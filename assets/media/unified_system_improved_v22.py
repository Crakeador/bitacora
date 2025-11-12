#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Sistema Unificado - Fiscalía & Placas (Versión Servidor Mejorada)
Backend con interfaz web moderna para consultas de cédulas y placas vehiculares
Compatible con TRASSIR y sistemas LPR
"""

from __future__ import annotations
import os, re, json, time, socket, threading
from datetime import datetime, timedelta
from pathlib import Path
from typing import Dict, Any, Optional, Tuple, List

from fastapi import FastAPI, Request, Form, HTTPException, File, UploadFile
from fastapi.responses import JSONResponse, HTMLResponse, RedirectResponse, StreamingResponse
from starlette.middleware.sessions import SessionMiddleware
from fastapi.staticfiles import StaticFiles
from jinja2 import Environment, DictLoader, select_autoescape
import uvicorn
import logging

from zoneinfo import ZoneInfo

# Configurar logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Zona horaria local (por defecto America/Guayaquil)
APP_TZ = os.environ.get("APP_TZ", "America/Guayaquil")
LOCAL_TZ = ZoneInfo(APP_TZ)

# ==========================
# Configuración básica
# ==========================
BASE_DIR = Path(__file__).parent
DATA_DIR = BASE_DIR / "data"
RESULTS_DIR = DATA_DIR / "results"
STATIC_DIR = BASE_DIR / "static"
DATA_DIR.mkdir(parents=True, exist_ok=True)
RESULTS_DIR.mkdir(parents=True, exist_ok=True)
STATIC_DIR.mkdir(parents=True, exist_ok=True)

HISTORY_PATH = DATA_DIR / "history.jsonl"
CONFIG_PATH = DATA_DIR / "config.json"
CACHE_PATH = DATA_DIR / "query_cache.json"

HOST = "0.0.0.0"
PORT = int(os.environ.get("PORT", 8000))
SECRET_KEY = os.environ.get("SECRET_KEY", "cambiar-en-produccion-unified-system")

ROOT_PASSWORD = "Canela2018-"
ADMIN_PASSWORD_KEY = "admin_password"

# URLs (para Selenium)
URL_CEDULA = "https://www.gestiondefiscalias.gob.ec/siaf/comunes/noticiasdelito/info_mod.php"
URL_PLACA = "https://servicios.epmtsd.gob.ec/vehiculo_seguro/"

# ==========================
# Utilidades
# ==========================
def now_iso():
    return datetime.now(LOCAL_TZ).strftime("%Y-%m-%d %H:%M:%S")

def has_internet(timeout: float = 2.0) -> bool:
    try:
        socket.create_connection(("1.1.1.1", 53), timeout=timeout).close()
        return True
    except Exception:
        return False

def save_result_file(rec_id: str, query: str, texto: str, tipo: str) -> str:
    ts_tag = datetime.now().strftime("%Y%m%d-%H%M%S")
    safe_query = re.sub(r'[^0-9A-Za-z_-]+', '_', query or "NA")
    fname = f"{rec_id}_{tipo}_{safe_query}_{ts_tag}.txt"
    path = RESULTS_DIR / fname
    try:
        path.write_text(texto if texto else "", encoding="utf-8")
    except Exception as e:
        logger.warning(f"No se pudo escribir archivo: {e}")
    return str(path)

# ==========================
# Configuración
# ==========================
class ConfigManager:
    def __init__(self, path: Path):
        self.path = path
        self.data: Dict[str, Any] = {
            "SERVERS": {},
            "USERS": {},
            "SETTINGS": {"no_requery_days": 30, "max_history": 10000, "lpr_whitelist": False}
        }
        self._load()

    def _load(self):
        if self.path.exists():
            try:
                self.data = json.loads(self.path.read_text(encoding="utf-8"))
            except Exception:
                pass

    def save(self):
        self.path.write_text(json.dumps(self.data, ensure_ascii=False, indent=2), encoding="utf-8")

    def get_admin_password(self) -> Optional[str]:
        return self.data.get(ADMIN_PASSWORD_KEY)

    def set_admin_password(self, new_pass: str):
        self.data[ADMIN_PASSWORD_KEY] = new_pass
        self.save()

    def users(self) -> Dict[str, Any]:
        return self.data.setdefault("USERS", {})

    def servers(self) -> Dict[str, Any]:
        return self.data.setdefault("SERVERS", {})

    def allowed_servers_for(self, username: str, role: str) -> List[str]:
        if role == "root":
            return sorted(list(self.servers().keys()))
        if not username:
            return []
        info = self.users().get(username, {})
        if username == "admin":
            info = self.users().get("admin", info)
        return info.get("allowed_servers", [])

    def set_user(self, username: str, info: Dict[str, Any]):
        self.users()[username] = info
        self.save()

    def del_user(self, username: str) -> bool:
        if username in ("root", "admin"):
            return False
        self.users().pop(username, None)
        self.save()
        return True

CONFIG = ConfigManager(CONFIG_PATH)

def purge_admin_user():
    """Elimina el usuario 'admin' y su password del sistema en el arranque."""
    try:
        changed = False
        if 'admin' in CONFIG.users():
            CONFIG.del_user('admin')
            changed = True
        if CONFIG.data.get('admin_password') is not None:
            CONFIG.data.pop('admin_password', None)
            changed = True
        if changed:
            CONFIG.save()
    except Exception as e:
        logger.warning(f'No se pudo purgar admin: {e}')

purge_admin_user()

# ==========================
# En memoria de 30 días
# ==========================
class QueryCache:
    def __init__(self, path: Path):
        self.path = path
        self.data: Dict[str, str] = {}
        self._load()

    def _load(self):
        if self.path.exists():
            try:
                self.data = json.loads(self.path.read_text(encoding="utf-8"))
            except Exception:
                self.data = {}

    def _save(self):
        try:
            self.path.write_text(json.dumps(self.data, ensure_ascii=False, indent=2), encoding="utf-8")
        except Exception:
            pass

    def key(self, server_id: str, tipo: str, identificador: str) -> str:
        return f"{server_id}:{tipo}:{identificador}"

    def should_query(self, server_id: str, tipo: str, identificador: str, days: int = 30) -> Tuple[bool, Optional[str]]:
        k = self.key(server_id, tipo, identificador)
        last = self.data.get(k)
        if not last:
            return True, None
        try:
            last_dt = datetime.fromisoformat(last)
            if datetime.now(LOCAL_TZ).replace(tzinfo=None) - last_dt >= timedelta(days=days):
                return True, None
            return False, last
        except Exception:
            return True, None

    def mark(self, server_id: str, tipo: str, identificador: str):
        self.data[self.key(server_id, tipo, identificador)] = datetime.now(LOCAL_TZ).isoformat()
        self._save()

CACHE = QueryCache(CACHE_PATH)

# ==========================
# Historial
# ==========================
class DataStore:
    def __init__(self, history_path: Path):
        self.history_path = history_path
        self.history: List[Dict[str, Any]] = []
        self._autoinc = 1
        self._load()

    def _load(self):
        if self.history_path.exists():
            for line in self.history_path.read_text(encoding="utf-8").splitlines():
                line = line.strip()
                if not line:
                    continue
                try:
                    rec = json.loads(line)
                except Exception:
                    continue
                self.history.append(rec)
                try:
                    self._autoinc = max(self._autoinc, int(rec.get("id", 0)) + 1)
                except Exception:
                    pass

    def _append(self, rec: Dict[str, Any]):
        self.history.append(rec)
        max_hist = CONFIG.data.get("SETTINGS", {}).get("max_history", 10000)
        if len(self.history) > max_hist:
            self.history = self.history[-max_hist:]
        with self.history_path.open("a", encoding="utf-8") as f:
            f.write(json.dumps(rec, ensure_ascii=False) + "\n")

    def add_record(self, *, server_id: str, user: str, tipo: str, identificador: str,
                   estado: str, sospechoso: bool, detalle: str, origen: str):
        rid = f"{self._autoinc:06d}"
        self._autoinc += 1
        file_path = save_result_file(rid, identificador, detalle, tipo)
        rec = {
            "id": rid,
            "ts": now_iso(),
            "server_id": server_id,
            "user": user,
            "tipo": tipo,
            "query": identificador,
            "estado": estado,
            "sospechoso": sospechoso,
            "resultado": detalle,
            "origen": origen,
            "file_path": file_path
        }
        self._append(rec)
        return rec

    def list_for_user(self, username: str, role: str, allowed_servers: List[str]) -> List[Dict[str, Any]]:
        if role == "root":
            return list(self.history)
        if role in ("admin", "user"):
            allowed = set(allowed_servers)
            return [r for r in self.history if r.get("server_id") in allowed]
        return []

    def get_stats(self, allowed_servers: List[str] = None) -> Dict[str, Any]:
        filtered = self.history if allowed_servers is None else [r for r in self.history if r.get("server_id") in set(allowed_servers)]
        total = len(filtered)
        sospechosos = sum(1 for r in filtered if r.get("sospechoso"))
        today = datetime.now(LOCAL_TZ).date().isoformat()
        hoy = sum(1 for r in filtered if r.get("ts", "").startswith(today))
        return {"total": total, "sospechosos": sospechosos, "hoy": hoy}

DATA = DataStore(HISTORY_PATH)

# ==========================
# Selenium (opcional)
# ==========================
try:
    from selenium import webdriver
    from selenium.webdriver.chrome.options import Options as ChromeOptions
    from selenium.webdriver.chrome.service import Service as ChromeService
    from selenium.webdriver.edge.options import Options as EdgeOptions
    from selenium.webdriver.edge.service import Service as EdgeService
    from selenium.webdriver.common.by import By
    from selenium.webdriver.common.keys import Keys
    from selenium.common.exceptions import TimeoutException
    from bs4 import BeautifulSoup
    HAS_SELENIUM = True
except ImportError:
    HAS_SELENIUM = False
    logger.warning("Selenium no disponible - usando fallbacks heurísticos")

DRIVER_DIR = BASE_DIR / "drivers"
CHROMEDRIVER_PATH = DRIVER_DIR / "chromedriver.exe"
EDGEDRIVER_PATH = DRIVER_DIR / "msedgedriver.exe"
BROWSER_PREFERENCE = "auto"

def _chrome_options():
    o = ChromeOptions()
    o.add_argument("--headless=new")
    o.add_argument("--no-sandbox")
    o.add_argument("--disable-dev-shm-usage")
    o.add_argument("--disable-gpu")
    o.add_argument("--window-size=1920,1080")
    o.add_argument("--user-agent=Mozilla/5.0")
    return o

def _edge_options():
    o = EdgeOptions()
    o.add_argument("--headless=new")
    o.add_argument("--no-sandbox")
    o.add_argument("--disable-dev-shm-usage")
    o.add_argument("--disable-gpu")
    o.add_argument("--window-size=1920,1080")
    o.add_argument("--user-agent=Mozilla/5.0")
    return o

def get_webdriver(prefer="auto"):
    if not HAS_SELENIUM:
        raise RuntimeError("Selenium no está disponible")
    errors = []
    order = ["chrome_sm", "edge_sm", "chrome_local", "edge_local"] if prefer == "auto" else [f"{prefer}_sm", f"{prefer}_local"]
    for mode in order:
        try:
            if mode == "chrome_sm":
                return webdriver.Chrome(options=_chrome_options()), "chrome"
            if mode == "edge_sm":
                return webdriver.Edge(options=_edge_options()), "edge"
            if mode == "chrome_local" and CHROMEDRIVER_PATH.exists():
                return webdriver.Chrome(service=ChromeService(str(CHROMEDRIVER_PATH)), options=_chrome_options()), "chrome"
            if mode == "edge_local" and EDGEDRIVER_PATH.exists():
                return webdriver.Edge(service=EdgeService(str(EDGEDRIVER_PATH)), options=_edge_options()), "edge"
        except Exception as e:
            errors.append(f"{mode}: {e}")
    raise RuntimeError(f"No se pudo iniciar navegador. Errores: {'; '.join(errors)}")

# ==========================
# Consultas reales (simplificadas)
# ==========================
def consultar_cedula(cedula: str) -> Tuple[str, bool]:
    """
    Devuelve (texto, es_sospechoso: bool) usando scraping real en Fiscalía.
    - Construye la URL con el parámetro businfo para consulta directa.
    - Parsea cada "NOTICIA DEL DELITO" y su tabla de sujetos.
    - Marca sospechoso SOLO si la cédula consultada aparece con estado "Sospechoso"
      (o variantes) en la tabla de sujetos.
    - Si no hay coincidencias reales -> "SIN NOVEDADES".
    Mantiene la firma y el formato del texto para no romper la interfaz.
    """
    import time, re, unicodedata
    from bs4 import BeautifulSoup

    def _norm(s: str) -> str:
        s = s or ""
        s = unicodedata.normalize("NFKD", s)
        s = s.encode("ASCII", "ignore").decode("ASCII")
        return s.strip()

    if not has_internet():
        return "ERROR: No hay conexión a Internet. No es posible consultar la página de Fiscalía.", False

    try:
        driver, used = get_webdriver(BROWSER_PREFERENCE)
    except Exception as e:
        return f"ERROR al iniciar el navegador/driver: {e}", False

    try:
        driver.set_page_load_timeout(30)
        valor = (cedula or "").strip()
        if not (valor.isdigit() and len(valor) == 10):
            return f"CÉDULA {cedula}\nFormato inválido (deben ser 10 dígitos).", False

        longitud = len(valor)
        businfo = f'a:1:{{i:0;s:{longitud}:"{valor}";}}'
        url = f"{URL_CEDULA}?businfo={businfo}"
        driver.get(url)
        time.sleep(6)

        soup = BeautifulSoup(driver.page_source, "html.parser")
        texto = soup.get_text(separator="\n", strip=True).upper()

        if any(x in texto for x in [
            "NO EXISTEN COINCIDENCIAS",
            "NO EXISTEN REGISTROS",
            "NO SE ENCONTRARON RESULTADOS",
            "SIN RESULTADOS"
        ]):
            return f"CÉDULA {cedula}\nSIN NOVEDADES", False

        def extraer_detalle(tabla):
            detalle = {"caso": "", "lugar": "", "fecha": "", "delito": ""}
            th = tabla.find("th")
            if th:
                m = re.search(r'NOTICIA\s+DEL\s+DELITO\s+Nro\.\s*(\S+)', th.get_text(), flags=re.I)
                if m:
                    detalle["caso"] = m.group(1).strip()
            lugar_td = tabla.find(lambda t: t.name == "td" and t.get_text(strip=True).upper() == "LUGAR")
            if lugar_td:
                sg = lugar_td.find_next_sibling("td")
                if sg: detalle["lugar"] = _norm(sg.get_text())
            fecha_td = tabla.find(lambda t: t.name == "td" and t.get_text(strip=True).upper() == "FECHA")
            if fecha_td:
                sg = fecha_td.find_next_sibling("td")
                if sg: detalle["fecha"] = _norm(sg.get_text())
            delito_td = tabla.find(lambda t: t.name == "td" and t.get_text(strip=True).upper().startswith("DELITO"))
            if delito_td:
                sg = delito_td.find_next_sibling("td")
                if sg: detalle["delito"] = _norm(sg.get_text())
            return detalle

        resultados, es_sospechoso = [], False
        nombre_global = ""
        for th in soup.find_all("th"):
            if "NOTICIA DEL DELITO" in (th.get_text(strip=True) or ""):
                tabla_caso = th.find_parent("table")
                if not tabla_caso:
                    continue
                detalle = extraer_detalle(tabla_caso)

                tabla_sujetos = tabla_caso.find_next_sibling("table")
                estado_encontrado = ""
                nombres_encontrado = ""
                if tabla_sujetos and "SUJETOS" in tabla_sujetos.get_text().upper():
                    filas = tabla_sujetos.find_all("tr")[2:]
                    for fr in filas:
                        cols = [c.get_text(strip=True) for c in fr.find_all("td")]
                        if len(cols) >= 3:
                            ced_en_tabla = _norm(cols[0]).replace(" ", "")
                            estado = _norm(cols[2])
                            nombre_raw = cols[1] if len(cols) > 1 else ""
                            if ced_en_tabla == valor:
                                estado_encontrado = estado
                                nombres_encontrado = nombre_raw
                                if "SOSPECHOSO" in estado.upper():
                                    es_sospechoso = True
                                if not nombre_global:
                                    nombre_global = nombre_raw
                                break

                if estado_encontrado:
                    detalle["estado"] = estado_encontrado
                    if nombres_encontrado:
                        detalle["nombres"] = nombres_encontrado
                    resultados.append(detalle)

        if not resultados:
            return f"CÉDULA {cedula}\nSIN NOVEDADES", False

        lineas = [f"CÉDULA {cedula} (navegador: {used})"]
        if nombre_global:
            lineas.append(f"NOMBRE: {nombre_global}")
        for det in resultados:
            nombres_det = det.get('nombres','')
            lineas.append(
                f"CASO {det.get('caso','')}: DELITO {det.get('delito','')}; FECHA: {det.get('fecha','')}; "
                f"LUGAR: {det.get('lugar','')}; ESTADO: {det.get('estado','SIN DATO')}" + (f"; NOMBRE: {nombres_det}" if nombres_det else "")
            )
        return "\n".join(lineas), es_sospechoso

    except TimeoutException:
        return "ERROR: La página de Fiscalía tardó demasiado en responder.", False
    except Exception as ex:
        return f"ERROR en la consulta: {str(ex)}", False
    finally:
        try:
            driver.quit()
        except Exception:
            pass
def consultar_placa(placa: str) -> Tuple[str, bool]:
    """
    Consulta placa en el portal oficial y arma un texto detallado.
    Corrige la detección de "robado" para que SOLO sea True cuando el campo
    correspondiente indique explícitamente SI (o equivalente), evitando
    falsos positivos por la mera presencia de la palabra "ROBADO" en la página.
    """
    import unicodedata
    from bs4 import BeautifulSoup
    from selenium.webdriver.common.by import By
    from selenium.webdriver.common.keys import Keys
    import re as _re

    def _norm(s: str) -> str:
        s = s or ""
        s = unicodedata.normalize('NFKD', s)
        s = s.encode('ASCII', 'ignore').decode('ASCII')
        return s.upper().strip()

    YES_TOKENS = {"SI", "SÍ", "TRUE", "1", "ROBADO", "REPORTADO"}
    NO_TOKENS  = {"NO", "FALSE", "0", "NO ROBADO", "NO REPORTADO", "NINGUNO",
                  "SIN REPORTE", "NO REGISTRA", "NO REGISTRA DENUNCIA"}

    if not has_internet():
        return "ERROR: Sin conexión a Internet", False
    if not HAS_SELENIUM:
        return "ERROR: Selenium no disponible para consultas web", False
    try:
        driver, used = get_webdriver(BROWSER_PREFERENCE)
    except Exception as e:
        return f"ERROR al iniciar navegador: {e}", False
    try:
        placa = (placa or "").strip().upper()
        driver.set_page_load_timeout(30)
        driver.get(URL_PLACA)
        time.sleep(5)

        # Localiza campo de placa
        input_placa = None
        for locator in [(By.NAME, "placa_vehiculo"), (By.ID, "placa_vehiculo")]:
            try:
                input_placa = driver.find_element(*locator)
                if input_placa:
                    break
            except Exception:
                pass
        if input_placa is None:
            return f"ERROR: No se halló campo de placa en {URL_PLACA}", False

        input_placa.clear()
        input_placa.send_keys(placa)
        input_placa.send_keys(Keys.RETURN)
        time.sleep(5)

        html = driver.page_source
        soup = BeautifulSoup(html, "html.parser")
        texto_completo = _norm(soup.get_text())

        # No registrada
        if ("PLACA NO REGISTRADA" in texto_completo) or ("NO REGISTRADA EN LA AGENCIA" in texto_completo)            or ("NO SE ENCONTRO" in texto_completo) or ("SIN RESULTADOS" in texto_completo):
            return f"PLACA {placa}\nNO REGISTRADA EN EL SISTEMA (ANT)", False

        modelo = anio = color = None
        robado = None  # None = indeterminado

        # Parseo principal por tarjetas <div class="card"><h5>Etiqueta</h5><p>Valor</p></div>
        tarjetas = soup.find_all("div", class_="card")
        for tarjeta in tarjetas:
            titulo_tag = tarjeta.find("h5")
            valor_tag = tarjeta.find("p")
            if not titulo_tag or not valor_tag:
                continue
            titulo = _norm(titulo_tag.get_text(strip=True))
            valor  = _norm(valor_tag.get_text(strip=True))

            if (("REPORTADO" in titulo and "ROBAD" in titulo) or ("ROBO" in titulo) or ("ROBADO" in titulo)):
                if any(tok == valor or tok in valor for tok in YES_TOKENS):
                    robado = True
                elif any(tok == valor or tok in valor for tok in NO_TOKENS):
                    robado = False
            elif "MODELO" in titulo:
                modelo = valor_tag.get_text(strip=True)
            elif ("AÑO" in titulo) or ("ANIO" in titulo):
                anio = valor_tag.get_text(strip=True)
            elif "COLOR" in titulo:
                color = valor_tag.get_text(strip=True)

        # Fallback: intenta extraer "REPORTADO ROBADO: <valor>" del texto plano
        if robado is None:
            m = _re.search(r"REPORTADO\s+ROBAD[OA]\s*[:\-]?\s*([A-Z\s]+)", texto_completo)
            if m:
                v = m.group(1).strip()
                if any(tok == v or tok in v for tok in YES_TOKENS):
                    robado = True
                elif any(tok == v or tok in v for tok in NO_TOKENS):
                    robado = False

        # Si no pudimos determinar, por defecto consideramos NO robado (para evitar falsos positivos)
        if robado is None:
            robado = False

        lineas = [f"PLACA {placa} (navegador: {used})", f"ESTADO: {'ROBADO' if robado else 'NO ROBADO'}"]
        if any([modelo, anio, color]):
            lineas.append(f"MODELO: {modelo or '-'}")
            lineas.append(f"AÑO: {anio or '-'}")
            lineas.append(f"COLOR: {color or '-'}")

        return "\n".join(lineas), bool(robado)

    except Exception as ex:
        return f"ERROR en consulta de placa {placa}: {str(ex)}", False
    finally:
        try:
            driver.quit()
        except Exception:
            pass

def process_cedula_async(server_id: str, cedula: str, user: str, origen: str = "Automático"):
    days = int(CONFIG.data.get("SETTINGS", {}).get("no_requery_days", 30))
    ok, last = CACHE.should_query(server_id, "CEDULA", cedula, days)
    if not ok:
        detalle = f"CÉDULA {cedula}\nConsulta omitida por memoria (< {days} días)\nÚltima: {last}"
        DATA.add_record(server_id=server_id, user=user, tipo="CEDULA", identificador=cedula,
                        estado="En memoria", sospechoso=False, detalle=detalle, origen=origen)
        return
    detalle, sospe = consultar_cedula(cedula)
    estado = "Sospechoso" if sospe else "Limpio"
    DATA.add_record(server_id=server_id, user=user, tipo="CEDULA", identificador=cedula,
                    estado=estado, sospechoso=sospe, detalle=detalle, origen=origen)
    CACHE.mark(server_id, "CEDULA", cedula)

def process_placa_async(server_id: str, placa: str, user: str, origen: str = "Automático"):
    days = int(CONFIG.data.get("SETTINGS", {}).get("no_requery_days", 30))
    ok, last = CACHE.should_query(server_id, "PLACA", placa, days)
    if not ok:
        detalle = f"PLACA {placa}\nConsulta omitida por memoria (< {days} días)\nÚltima: {last}"
        DATA.add_record(server_id=server_id, user=user, tipo="PLACA", identificador=placa,
                        estado="En memoria", sospechoso=False, detalle=detalle, origen=origen)
        return
    detalle, robado = consultar_placa(placa)
    estado = "Robado" if robado else "No Robado"
    DATA.add_record(server_id=server_id, user=user, tipo="PLACA", identificador=placa,
                    estado=estado, sospechoso=robado, detalle=detalle, origen=origen)
    CACHE.mark(server_id, "PLACA", placa)

# ==========================
# Autenticación
# ==========================
def get_user_role(username: Optional[str]) -> str:
    if username == "root":
        return "root"
    if username == "admin":
        return "admin"
    if not username:
        return "user"
    info = CONFIG.users().get(username) or {}
    return info.get("role", "user")

def validate_login(username: str, password: str) -> bool:
    if username == "root":
        return password == ROOT_PASSWORD
    if username == "admin":
        return False  # usuario 'admin' eliminado
    info = CONFIG.users().get(username)
    return bool(info and info.get("password") == password)

def identify_server(request: Request, payload: Optional[Dict[str, Any]] = None) -> str:
    servers = CONFIG.servers()
    all_headers = dict(request.headers)  # Loguear todos los headers para debug
    logger.info(f"Procesando autenticación. IP: {request.client.host}. Headers: {all_headers}. Payload={payload}")

    # Verificar servidor en payload usando data.server.name o store
    if payload:
        sid = (payload.get("data", {}).get("server", {}).get("name") or payload.get("store") or "").strip()
        if sid:
            logger.debug(f"Verificando server_id/name/store: {sid}")
            info = servers.get(sid)
            if info:
                logger.info(f"Autenticación exitosa para server_id: {sid} vía payload")
                return sid
            logger.error(f"Server ID/Name/Store {sid} no encontrado en configuración")
            raise HTTPException(401, f"Servidor no registrado: {sid}")

    logger.error("Faltan credenciales válidas en payload (name no encontrado)")
    raise HTTPException(401, "Faltan credenciales de servidor o son inválidas. Verifica logs para detalles.")

def get_server_from_payload_permissive(payload: Dict[str, Any]) -> str:
    """
    Obtiene el identificador del servidor desde el JSON de TRASSIR/LPR sin exigir auth.
    Usa data["server"]["name"] si existe; si no, intenta variantes comunes.
    Si SETTINGS.lpr_whitelist es True y hay servidores configurados, sólo acepta
    nombres/IDs que estén en la configuración. Si está desactivada, acepta cualquiera.
    """
    servers = CONFIG.servers()
    settings = CONFIG.data.get("SETTINGS", {})
    whitelist = bool(settings.get("lpr_whitelist", False))

    server_name = (
        (payload.get("data") or {}).get("server", {}).get("name") or
        payload.get("serverName") or
        payload.get("server") or
        payload.get("store") or
        ""
    )
    server_name = (server_name or "").strip()
    if not server_name:
        server_name = "unknown"

    if not whitelist or not servers:
        return server_name

    if server_name in servers:
        return server_name
    for sid, info in servers.items():
        if (info.get("name") or "").strip() == server_name:
            return sid

    raise HTTPException(401, f"Servidor no permitido por whitelist: {server_name}")

# ==========================
# FastAPI
# ==========================
app = FastAPI(title="Sistema Unificado - Fiscalía & Placas", version="2.0")
app.mount("/media", StaticFiles(directory="/opt/unified", html=False), name="media")
app.add_middleware(SessionMiddleware, secret_key=SECRET_KEY, session_cookie="unified_session")

# ==========================
# Templates
# ==========================
TEMPLATES = {
    "base.html": """<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ title or 'Panel' }} - Sistema Unificado</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
:root{--primary:#2563eb;--primary-dark:#1d4ed8;--secondary:#64748b;--success:#10b981;--warning:#f59e0b;--danger:#ef4444;--light:#f8fafc;--dark:#1e293b;--border:#e2e8f0}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',system-ui,-apple-system,sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;color:var(--dark)}
.navbar{background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);padding:1rem 0;position:sticky;top:0;z-index:1000}
.nav-container{max-width:1200px;margin:0 auto;padding:0 1rem;display:flex;align-items:center;justify-content:space-between}
.nav-brand{font-size:1.5rem;font-weight:bold;color:var(--primary);text-decoration:none}
.nav-links{display:flex;gap:2rem;align-items:center}
.nav-links a{color:var(--secondary);text-decoration:none;font-weight:500;transition:.3s}
.nav-links a:hover{color:var(--primary)}
.container{max-width:1200px;margin:2rem auto;padding:0 1rem}
.card{background:white;border-radius:12px;box-shadow:0 4px 6px -1px rgb(0 0 0 / .1);overflow:hidden;margin-bottom:2rem}
.card-header{padding:1.5rem;border-bottom:1px solid var(--border);background:var(--light)}
.card-title{font-size:1.25rem;font-weight:600;color:var(--dark);margin-bottom:.5rem}
.card-subtitle{color:var(--secondary);font-size:.9rem}
.card-body{padding:1.5rem}
.form-group{margin-bottom:1rem}
.form-label{display:block;margin-bottom:.5rem;font-weight:500;color:var(--dark)}
.form-control{width:100%;padding:.75rem;border:1px solid var(--border);border-radius:6px;font-size:1rem;transition:.3s}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgb(37 99 235 / .1)}
.btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;border:none;border-radius:6px;font-weight:500;text-decoration:none;cursor:pointer;transition:.3s}
.btn-primary{background:var(--primary);color:white}.btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px)}
.btn-secondary{background:var(--secondary);color:white}.btn-success{background:var(--success);color:white}
.btn-warning{background:var(--warning);color:white}.btn-danger{background:var(--danger);color:white}
.alert{padding:1rem;border-radius:6px;margin-bottom:1rem;border:1px solid transparent}
.alert-success{background:#f0fdf4;color:#166534;border-color:#bbf7d0}
.alert-danger{background:#fef2f2;color:#dc2626;border-color:#fecaca}
.table{width:100%;border-collapse:collapse;margin-top:1rem}
.table th,.table td{padding:.75rem;text-align:left;border-bottom:1px solid var(--border)}
.table th{background:var(--light);font-weight:600;color:var(--dark)}
.badge{display:inline-block;padding:.25rem .5rem;font-size:.75rem;font-weight:500;border-radius:9999px}
.badge-success{background:#dcfce7;color:#166534}
.badge-warning{background:#fef3c7;color:#92400e}
.badge-danger{background:#fee2e2;color:#dc2626}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem}
.stat-card{background:white;padding:1.5rem;border-radius:8px;box-shadow:0 2px 4px rgb(0 0 0 / .1);text-align:center}
.stat-number{font-size:2rem;font-weight:bold;color:var(--primary)}
.stat-label{color:var(--secondary);font-size:.9rem;margin-top:.5rem}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;z-index:9999}
.modal-content{background:white;padding:2rem;border-radius:12px;max-width:500px;width:90%;text-align:center;animation:pulse 1s infinite;cursor:pointer}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(239,68,68,.7)}70%{box-shadow:0 0 0 10px rgba(239,68,68,0)}100%{box-shadow:0 0 0 0 rgba(239,68,68,0)}}
.loading{display:inline-block;width:1rem;height:1rem;border:2px solid #f3f3f3;border-top:2px solid var(--primary);border-radius:50%;animation:spin 1s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
.d-flex{display:flex}.align-items-center{align-items:center}.justify-content-between{justify-content:space-between}.gap-3{gap:1rem}.mb-3{margin-bottom:1rem}.text-center{text-align:center}.text-muted{color:var(--secondary)}
@media (max-width:768px){.nav-container{flex-direction:column;gap:1rem}.nav-links{flex-wrap:wrap;justify-content:center}.container{padding:0 .5rem}.stats-grid{grid-template-columns:1fr}}
</style>
</head>
<body>
    {% if user %}
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="nav-brand"><i class="fas fa-shield-alt"></i> Sistema Unificado</a>
            <div class="nav-links">
                <a href="/"><i class="fas fa-home"></i> Inicio</a>
                <a href="/manual"><i class="fas fa-search"></i> Consulta Manual</a>
                <a href="/historial"><i class="fas fa-history"></i> Historial</a>
                <a href="/export"><i class="fas fa-download"></i> Exportar</a>
                {% if role in ['root','admin'] %}<a href="/admin/users"><i class="fas fa-users"></i> Usuarios</a>{% endif %}
                {% if role == 'root' %}<a href="/admin/servers"><i class="fas fa-server"></i> Servidores</a>{% endif %}
                <a href="/logout"><i class="fas fa-sign-out-alt"></i> Salir ({{ user }})</a>
            </div>
        </div>
    </nav>
    {% endif %}
    <div class="container">
        {% if flash %}
        <div class="alert alert-{{ 'success' if flash[0]=='ok' else 'danger' }}">
            <i class="fas fa-{{ 'check-circle' if flash[0]=='ok' else 'exclamation-triangle' }}"></i> {{ flash[1] }}
        </div>
        {% endif %}
        {% block content %}{% endblock %}
    </div>

    <audio id="audioAlarma" src="/media/alarma.mp3" preload="auto"></audio>
    <audio id="audioSiren" src="/media/siren.mp3" preload="auto"></audio>

    <!-- Modal de alerta global -->
<div id="alertModal" class="modal-overlay" onclick="closeAlert()">
  <div class="modal-content" onclick="event.stopPropagation(); closeAlert();">
    <h2 id="alertTitle" style="color:var(--danger);margin-bottom:1rem;"><i class="fas fa-exclamation-triangle"></i> ¡ALERTA!</h2>
    <p id="alertBody" style="margin-bottom:1.5rem;white-space:pre-wrap;text-align:left;"></p>
    <button class="btn btn-danger" onclick="closeAlert()"><i class="fas fa-times"></i> Cerrar</button>
  </div>
</div>

<script>
function getAudio(id){return document.getElementById(id);} 
function playFile(id){try{const a=getAudio(id);a.currentTime=0;a.play();}catch(e){}} 
function stopFile(id){try{const a=getAudio(id);a.pause();a.currentTime=0;}catch(e){}} 
function playRobado(){playFile('audioAlarma')} 
function playSospechoso(){playFile('audioSiren')} 
function showPopup(rec){
  try{
    const modal=document.getElementById('alertModal');
    const t=document.getElementById('alertTitle');
    const b=document.getElementById('alertBody');
    const tipo=(rec&&rec.tipo)||'ALERTA';
    const q=(rec&&rec.query)||rec.identificador||'';
    const est=(rec&&rec.estado)||'';
    const sus=!!(rec&&rec.sospechoso);
    t.innerHTML = (tipo==='PLACA'? '🚨 VEHÍCULO '+(sus?'ROBADO':'') : '⚠️ PERSONA '+(sus?'SOSPECHOSA':''));
    b.textContent = `${tipo}: ${q}\nEstado: ${est || (sus?'Crítico':'Limpio')}\nFecha/Hora: ${(rec&&rec.ts)||''}`;
    modal.style.display='flex';
    if(sus){ if(tipo==='PLACA'){ playRobado(); } else { playSospechoso(); } }
  }catch(e){}
}
function showAlert(){ showPopup({tipo:'PLACA', sospechoso:true, estado:'Robado'}); }
function closeAlert(){ 
  document.getElementById('alertModal').style.display='none'; 
  stopFile('audioAlarma'); 
  stopFile('audioSiren'); 
}
let __lastSeenId=null;
async function pollLast(){
  try{
    const r=await fetch('/api/last_record', {credentials:'same-origin'});
    if(!r.ok) return;
    const rec=await r.json();
    if(!rec || !rec.id) return;
    if(__lastSeenId===null){ __lastSeenId = rec.id; return; }
    if(rec.id !== __lastSeenId){
       __lastSeenId = rec.id;
       window.dispatchEvent(new CustomEvent('newRecord', {detail: rec}));
       if(rec.sospechoso){ showPopup(rec); }
    }
  }catch(e){}
}
document.addEventListener('DOMContentLoaded', ()=>{ pollLast(); setInterval(pollLast, 2000); });
</script>
</body></html>""",

    "login.html": """{% extends 'base.html' %}{% block content %}
<div style="max-width:400px;margin:4rem auto;">
  <div class="card">
    <div class="card-header text-center">
      <h1 class="card-title"><i class="fas fa-shield-alt" style="color:var(--primary);"></i> Sistema Unificado</h1>
      <p class="card-subtitle">Fiscalía & Placas Vehiculares</p>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="form-group"><label class="form-label"><i class="fas fa-user"></i> Usuario</label><input name="username" class="form-control" required value=""></div>
        <div class="form-group"><label class="form-label"><i class="fas fa-lock"></i> Contraseña</label><input type="password" name="password" class="form-control" required></div>
        <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
      </form>
      <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border);font-size:.8rem;color:var(--secondary);">
        <strong>Sistema de Consultas</strong><br>• Cédulas y Placas • Integración con TRASSIR/LPR • Alertas para casos críticos
      </div>
    </div>
  </div>
</div>{% endblock %}""",

    "home.html": """{% extends 'base.html' %}{% block content %}
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 style="margin:0;"><i class="fas fa-tachometer-alt"></i> Panel de Control</h1>
  <span class="badge badge-{{ 'danger' if role == 'root' else 'warning' if role == 'admin' else 'success' }}">{{ role.upper() }}</span>
</div>
<div class="stats-grid">
  <div class="stat-card"><div class="stat-number">{{ stats.total }}</div><div class="stat-label"><i class="fas fa-search"></i> Total Consultas</div></div>
  <div class="stat-card"><div class="stat-number" style="color:var(--danger);">{{ stats.sospechosos }}</div><div class="stat-label"><i class="fas fa-exclamation-triangle"></i> Sospechosos/Robados</div></div>
  <div class="stat-card"><div class="stat-number" style="color:var(--success);">{{ stats.hoy }}</div><div class="stat-label"><i class="fas fa-calendar-day"></i> Consultas Hoy</div></div>
  <div class="stat-card"><div class="stat-number" style="color:var(--warning);">{{ allowed|length }}</div><div class="stat-label"><i class="fas fa-server"></i> Servidores Permitidos</div></div>
</div>
<div class="card"><div class="card-header"><h2 class="card-title"><i class="fas fa-info-circle"></i> Estado del Sistema</h2></div>
<div class="card-body">
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem;">
    <div><h4><i class="fas fa-user-shield"></i> Información del Usuario</h4><p><strong>Usuario:</strong> {{ user }}</p><p><strong>Rol:</strong> {{ role }}</p><p><strong>Permisos:</strong> {% if role=='root' %}Acceso completo{% elif role=='admin' %}Gestión de usuarios y consultas{% else %}Consultas básicas{% endif %}</p></div>
    <div><h4><i class="fas fa-server"></i> Servidores Autorizados</h4>
      {% if allowed %}<ul style="margin:.5rem 0;">{% for s in allowed %}<li><strong>{{ s }}</strong></li>{% endfor %}</ul>{% else %}<p style="color:var(--warning);">No hay servidores asignados</p>{% endif %}
    </div>
  </div>
</div></div>
{% endblock %}""",

    "manual.html": """{% extends 'base.html' %}{% block content %}
<h1><i class="fas fa-search"></i> Consulta Manual</h1>
<div class="card"><div class="card-header"><h2 class="card-title">Nueva Consulta</h2><p class="card-subtitle">Cédulas y placas vehiculares</p></div>
<div class="card-body">
<form method="post" id="consultaForm">
  <div class="form-group">
    <label class="form-label">Tipo</label>
    <div class="d-flex gap-3">
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="tipo" value="CEDULA" checked onchange="cambiarTipo()"><i class="fas fa-id-card"></i> Cédula</label>
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="tipo" value="PLACA" onchange="cambiarTipo()"><i class="fas fa-car"></i> Placa</label>
    </div>
  </div>
  <div class="form-group">
    <label class="form-label" id="labelConsulta"><i class="fas fa-id-card"></i> Número de Cédula</label>
    <input name="query" id="inputConsulta" class="form-control" placeholder="Ingrese 10 dígitos" required>
  </div>
  {% if allowed|length > 1 %}
  <div class="form-group">
    <label class="form-label"><i class="fas fa-server"></i> Servidor</label>
    <select name="server_id" class="form-control">{% for srv in allowed %}<option value="{{ srv }}">{{ srv }}</option>{% endfor %}</select>
  </div>
  {% elif allowed|length == 1 %}<input type="hidden" name="server_id" value="{{ allowed[0] }}">{% endif %}
  <button type="submit" class="btn btn-primary" id="btnConsultar"><i class="fas fa-search"></i> Consultar</button>
  <button type="button" class="btn btn-secondary" onclick="limpiarForm()"><i class="fas fa-eraser"></i> Limpiar</button>
</form></div></div>
{% if resultado %}
<div class="card"><div class="card-header">
  <h2 class="card-title"><i class="fas fa-{{ 'exclamation-triangle' if sospechoso else 'check-circle' }}"></i> Resultado</h2>
  <span class="badge badge-{{ 'danger' if sospechoso else 'success' }}">{{ 'ROBADO' if tipo_consulta=='PLACA' and sospechoso else ('NO ROBADO' if tipo_consulta=='PLACA' else ('SOSPECHOSO' if sospechoso else 'SIN NOVEDADES')) }}</span>
</div>
<div class="card-body">
  <div style="background:var(--light);padding:1rem;border-radius:6px;font-family:monospace;white-space:pre-wrap;">{{ resultado }}</div>
  {% if sospechoso %}<script>showPopup({id:'manual',tipo:'{{ tipo_consulta }}',query:'{{ query_value|e }}',estado:'{{ 'Robado' if tipo_consulta=='PLACA' else 'Sospechoso' }}',sospechoso:true,ts: (()=> {const d=new Date(),p=n=>String(n).padStart(2,'0');return `${d.getFullYear()}-${p(d.getMonth()+1)}-${p(d.getDate())} ${p(d.getHours())}:${p(d.getMinutes())}:${p(d.getSeconds())}`;})() });</script>{% endif %}
</div></div>
{% endif %}
<script>
function cambiarTipo(){const tipo=document.querySelector('input[name="tipo"]:checked').value;const label=document.getElementById('labelConsulta');const input=document.getElementById('inputConsulta');if(tipo==='CEDULA'){label.innerHTML='<i class="fas fa-id-card"></i> Número de Cédula';input.placeholder='Ingrese 10 dígitos';input.pattern='[0-9]{10}'}else{label.innerHTML='<i class="fas fa-car"></i> Número de Placa';input.placeholder='Ej: ABC1234';input.pattern='[A-Z0-9]{6,8}'}input.value=''}
function limpiarForm(){document.getElementById('consultaForm').reset();document.querySelector('input[name="tipo"][value="CEDULA"]').checked=true;cambiarTipo()}
document.getElementById('consultaForm').addEventListener('submit',function(){const btn=document.getElementById('btnConsultar');btn.innerHTML='<span class="loading"></span> Consultando...';btn.disabled=true})
</script>
{% endblock %}""",

    "historial.html": """{% extends 'base.html' %}{% block content %}
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1><i class="fas fa-history"></i> Historial de Consultas</h1>
  <a href="/historial" class="btn btn-secondary"><i class="fas fa-sync"></i> Actualizar</a>
</div>

<div class="card mb-3"><div class="card-header"><h3 class="card-title mb-0"><i class="fas fa-filter"></i> Filtros</h3></div>
<div class="card-body">
<form method="get" class="d-flex gap-3" style="flex-wrap:wrap;align-items:end;">
  {% if allowed|length > 1 %}
  <div class="form-group mb-0"><label class="form-label">Servidor</label>
    <select name="server_id" class="form-control"><option value="">Todos</option>{% for srv in allowed %}<option value="{{ srv }}" {{ 'selected' if server_id == srv else '' }}>{{ srv }}</option>{% endfor %}</select>
  </div>{% endif %}
  <div class="form-group mb-0"><label class="form-label">Tipo</label>
    <select name="tipo" class="form-control"><option value="">Todos</option><option value="CEDULA" {{ 'selected' if tipo=='CEDULA' else '' }}>CÉDULA</option><option value="PLACA" {{ 'selected' if tipo=='PLACA' else '' }}>PLACA</option></select>
  </div>
  <div class="form-group mb-0"><label class="form-label">Estado</label>
    <select name="estado" class="form-control"><option value="">Todos</option><option value="sospechoso" {{ 'selected' if estado=='sospechoso' else '' }}>Solo Sospechosos/Robados</option><option value="limpio" {{ 'selected' if estado=='limpio' else '' }}>Solo Limpios</option></select>
  </div>
  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filtrar</button>
</form></div></div>

<div class="card"><div class="card-header"><h3 class="card-title mb-0">Registros ({{ rows|length }} resultados)</h3></div>
<div class="card-body" style="overflow-x:auto;">
<table class="table">
  <thead><tr>
    <th>Fecha/Hora</th>{% if allowed|length > 1 %}<th>Servidor</th>{% endif %}
    <th>Tipo</th><th>Consulta</th><th>Estado</th><th>Origen</th><th>Usuario</th><th>Acciones</th>
  </tr></thead>
  <tbody id="historyBody">
  {% for r in rows %}
    <tr>
      <td style="white-space:nowrap;">{{ r.ts }}</td>
      {% if allowed|length > 1 %}<td>{{ r.server_id }}</td>{% endif %}
      <td><i class="fas fa-{{ 'id-card' if r.tipo=='CEDULA' else 'car' }}"></i> {{ r.tipo }}</td>
      <td style="font-family:monospace;">{{ r.query }}</td>
      <td>
        {% if r.sospechoso %}
          {% if r.tipo == 'PLACA' %}<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> ROBADO</span>
          {% else %}<span class="badge badge-warning"><i class="fas fa-user-secret"></i> SOSPECHOSO</span>{% endif %}
        {% else %}<span class="badge badge-success"><i class="fas fa-check"></i> {{ r.estado }}</span>{% endif %}
      </td>
      <td>{{ r.origen }}</td>
      <td>{{ r.user }}</td>
      <td><button class="btn" style="padding:.25rem .5rem;font-size:.8rem;" onclick="verDetalle('{{ r.id }}', '{{ r.query }}', '{{ r.tipo }}', {{ r.sospechoso|lower }})"><i class="fas fa-eye"></i></button> <a class="btn" style="padding:.25rem .5rem;font-size:.8rem;" href="/export/record/{{ r.id }}" title="Exportar PDF"><i class="fas fa-file-pdf"></i></a></td>
    </tr>
  {% endfor %}
  {% if not rows %}<tr><td colspan="{{ 8 if allowed|length>1 else 7 }}" class="text-center text-muted"><i class="fas fa-inbox"></i> No hay registros</td></tr>{% endif %}
  </tbody>
</table>
</div></div>

<div id="detalleModal" class="modal-overlay">
  <div class="modal-content" style="max-width:700px;animation:none;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 id="detalleTitle" style="margin:0;">Detalle de Consulta</h3>
      <button class="btn" onclick="cerrarDetalle()" style="padding:.25rem .5rem;"><i class="fas fa-times"></i></button>
    </div>
    <div id="detalleContent" style="background:var(--light);padding:1rem;border-radius:6px;font-family:monospace;white-space:pre-wrap;max-height:400px;overflow-y:auto;"></div>
    <div class="d-flex gap-3" style="margin-top:1rem;justify-content:end;">
      <button class="btn btn-secondary" onclick="cerrarDetalle()"><i class="fas fa-times"></i> Cerrar</button>
    </div>
  </div>
</div>

<script>
async function verDetalle(id, query, tipo, sospechoso){
  try{
    const res = await fetch(`/api/record/${id}`, {credentials:'same-origin'});
    if(!res.ok) throw new Error('No se pudo obtener el detalle');
    const rec = await res.json();
    document.getElementById('detalleTitle').textContent = `Detalle de ${rec.tipo}: ${rec.query}`;
    document.getElementById('detalleContent').textContent = rec.resultado || '(sin detalle)';
    document.getElementById('detalleModal').style.display = 'flex';
    if(rec.sospechoso){ setTimeout(()=>showPopup(rec), 500); }
  }catch(e){
    document.getElementById('detalleTitle').textContent = `Detalle`;
    document.getElementById('detalleContent').textContent = 'Error cargando el detalle.';
    document.getElementById('detalleModal').style.display = 'flex';
  }
}
function cerrarDetalle(){ document.getElementById('detalleModal').style.display='none'; }
document.addEventListener('DOMContentLoaded', function(){
  const robadoBadges = document.querySelectorAll('.badge-danger');
  const sospeBadges = document.querySelectorAll('.badge-warning');
});

window.addEventListener('newRecord', (ev)=>{
  try{
    const rec = ev.detail;
    const filtroSrv = '{{ server_id or '' }}';
    const filtroTipo = '{{ tipo or '' }}';
    const filtroEstado = '{{ estado or '' }}';
    if(filtroSrv && rec.server_id !== filtroSrv) return;
    if(filtroTipo && rec.tipo !== filtroTipo) return;
    if(filtroEstado==='sospechoso' && !rec.sospechoso) return;
    if(filtroEstado==='limpio' && rec.sospechoso) return;
    const tbody=document.getElementById('historyBody'); if(!tbody) return;
    const allowedMultiple = {{ (allowed|length) if allowed is defined else 0 }};
    const colsSrv = allowedMultiple>1 ? `<td>${rec.server_id||''}</td>` : '';
    const badge = rec.sospechoso ? (rec.tipo==='PLACA' ? `<span class='badge badge-danger'><i class='fas fa-exclamation-triangle'></i> ROBADO</span>` : `<span class='badge badge-warning'><i class='fas fa-user-secret'></i> SOSPECHOSO</span>`) : `<span class='badge badge-success'><i class='fas fa-check'></i> ${rec.estado||''}</span>`;
    const row = document.createElement('tr');
    row.innerHTML = `<td style='white-space:nowrap;'>${rec.ts||''}</td>${colsSrv}<td><i class='fas fa-${rec.tipo==='CEDULA'?'id-card':'car'}'></i> ${rec.tipo}</td><td style='font-family:monospace;'>${rec.query||rec.identificador||''}</td><td>${badge}</td><td>${rec.origen||''}
</td><td>${rec.user||''}</td><td><button class='btn' style='padding:.25rem .5rem;font-size:.8rem;' onclick="verDetalle('${rec.id}','${rec.query||rec.identificador||''}','${rec.tipo}',${rec.sospechoso})"><i class='fas fa-eye'></i></button> <a class='btn' style='padding:.25rem .5rem;font-size:.8rem;' href='/export/record/${rec.id}' title='Exportar PDF'><i class='fas fa-file-pdf'></i></a></td>`;
    const first = tbody.querySelector('tr');
    if(first) tbody.insertBefore(row, first); else tbody.appendChild(row);
  }catch(e){}
});
</script>
{% endblock %}""",

    "export.html": """{% extends 'base.html' %}{% block content %}
<h1><i class="fas fa-download"></i> Exportar Datos</h1>
<div class="card"><div class="card-header"><h2 class="card-title">Configuración de exportación</h2><p class="card-subtitle">CSV, JSON, TXT o PDF</p></div>
<div class="card-body">
<form method="post">
  <div class="form-group"><label class="form-label">Alcance</label>
    <div style="display:flex;gap:1rem;flex-direction:column;">
      {% if role in ['root','admin'] %}<label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="scope" value="all"><i class="fas fa-globe"></i> Todo</label>{% endif %}
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="scope" value="mine" checked><i class="fas fa-user"></i> Mis consultas</label>
      {% if allowed|length > 1 %}<label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="scope" value="server"><i class="fas fa-server"></i> Por servidor</label>{% endif %}
    </div>
  </div>
  {% if allowed|length > 1 %}
  <div class="form-group" id="serverSelect" style="display:none;">
    <label class="form-label">Servidor</label><select name="server_id" class="form-select">{% for s in allowed %}<option value="{{ s }}">{{ s }}</option>{% endfor %}</select>
  </div>{% endif %}
  <div class="form-group"><label class="form-label">Formato</label>
    <div style="display:flex;gap:1rem;flex-direction:column;">
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="format" value="csv" checked><i class="fas fa-file-csv"></i> CSV</label>
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="format" value="json"><i class="fas fa-file-code"></i> JSON</label>
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="format" value="txt"><i class="fas fa-file-alt"></i> TXT (resumen)</label>
      <label style="display:flex;align-items:center;gap:.5rem;"><input type="radio" name="format" value="pdf"><i class="fas fa-file-pdf"></i> PDF</label>
    </div>
  </div>
  <div class="form-group"><label class="form-label">Filtros</label>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;">
      <div><label class="form-label" style="font-size:.9rem;">Tipo</label><select name="tipo" class="form-select"><option value="">Todos</option><option value="CEDULA">Solo Cédulas</option><option value="PLACA">Solo Placas</option></select></div>
      <div><label class="form-label" style="font-size:.9rem;">Estado</label><select name="estado_filter" class="form-select"><option value="">Todos</option><option value="sospechoso">Sospechosos/Robados</option><option value="limpio">Limpios</option></select></div>
      <div><label class="form-label" style="font-size:.9rem;">Días</label><select name="days" class="form-select"><option value="">Todos</option><option value="7">7 días</option><option value="30">30 días</option><option value="90">90 días</option></select></div>
    </div>
  </div>
  <div style="border-top:1px solid #e2e8f0;padding-top:1rem;margin-top:1rem;">
    <button type="submit" class="btn btn-success"><i class="fas fa-download"></i> Generar y Descargar</button>
  </div>
</form>
</div></div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  const scopeRadios=document.querySelectorAll('input[name="scope"]');const serverSelect=document.getElementById('serverSelect');
  if(serverSelect){scopeRadios.forEach(r=>{r.addEventListener('change',function(){serverSelect.style.display=(this.value==='server')?'block':'none'})})}
  document.querySelector('form').addEventListener('submit',function(e){const btn=this.querySelector('button[type=submit]');btn.innerHTML='<span class="loading"></span> Generando...';btn.disabled=true})
});
</script>
{% endblock %}""",

    "users.html": """{% extends 'base.html' %}{% block content %}
<h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>

<div class="card mb-3"><div class="card-header"><h3 class="card-title"><i class="fas fa-user-plus"></i> Crear Usuario</h3></div>
<div class="card-body">
<form method="post" action="/admin/users/create">
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1rem;">
    <div class="form-group mb-0"><label class="form-label">Usuario</label><input name="username" class="form-control" required></div>
    <div class="form-group mb-0"><label class="form-label">Nombre completo</label><input name="name" class="form-control" required></div>
    <div class="form-group mb-0"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required></div>
    <div class="form-group mb-0"><label class="form-label">Rol</label><select name="role" class="form-control" required><option value="user">Usuario</option><option value="admin">Administrador</option></select></div>
  </div>
  <div class="form-group"><label class="form-label">Servidores permitidos (coma)</label><input name="servers" class="form-control" placeholder="servidor1,servidor2"></div>
  <button type="submit" class="btn btn-success"><i class="fas fa-user-plus"></i> Crear Usuario</button>
</form>
</div></div>

<div class="card mb-3"><div class="card-header"><h3 class="card-title"><i class="fas fa-key"></i> Gestión de Contraseñas y Roles</h3></div>
<div class="card-body">
<form method="post" action="/admin/users/update" style="margin-bottom:2rem;">
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1rem;">
    <div class="form-group mb-0"><label class="form-label">Usuario</label>
      <select name="username" class="form-control" required><option value="">Seleccionar...</option>
      {% for u,info in config.users().items() %}<option value="{{ u }}">{{ u }} ({{ info.get('name','') }})</option>{% endfor %}</select>
    </div>
    <div class="form-group mb-0"><label class="form-label">Nueva contraseña (opcional)</label><input type="password" name="password" class="form-control"></div>
    <div class="form-group mb-0"><label class="form-label">Rol</label><select name="new_role" class="form-control" required><option value="user">Usuario</option><option value="admin">Administrador</option></select></div>
  </div>
  <div class="form-group"><label class="form-label">Servidores permitidos (coma)</label><input name="servers" class="form-control" placeholder="servidor1,servidor2"></div>
  <div class="d-flex gap-3"><button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Actualizar Usuario</button></div>
</form>
</div></div>

<div class="card"><div class="card-header"><h3 class="card-title"><i class="fas fa-list"></i> Usuarios del Sistema</h3></div>
<div class="card-body" style="overflow-x:auto;">
<table class="table">
  <thead><tr><th>Usuario</th><th>Nombre</th><th>Rol</th><th>Servidores</th><th>Estado</th><th>Acciones</th></tr></thead>
  <tbody id="historyBody">
  {% for u,info in config.users().items() %}
    <tr>
      <td><strong>{{ u }}</strong></td>
      <td>{{ info.get('name','') }}</td>
      <td>{% if info.get('role')=='admin' %}<span class="badge badge-warning">ADMIN</span>{% else %}<span class="badge badge-success">USER</span>{% endif %}</td>
      <td>{{ info.get('allowed_servers',[]) | join(', ') or 'Ninguno' }}</td>
      <td><span class="badge badge-success">Activo</span></td>
      <td>
        <button class="btn btn-secondary" style="padding:.25rem .5rem;font-size:.8rem;" onclick="editarUsuario('{{ u }}','{{ info.get('name','') }}','{{ info.get('role','user') }}','{{ info.get('allowed_servers',[]) | join(',') }}')"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger" style="padding:.25rem .5rem;font-size:.8rem;" onclick="eliminarUsuario('{{ u }}')"><i class="fas fa-trash"></i></button>
      </td>
    </tr>
  {% endfor %}
  {% if config.users().items() | list | length == 0 %}<tr><td colspan="6" class="text-center text-muted"><i class="fas fa-users"></i> No hay usuarios aún</td></tr>{% endif %}
  </tbody>
</table>
</div></div>

<script>
function editarUsuario(username,name,role,servers){document.querySelector('select[name="username"]').value=username;document.querySelector('select[name="new_role"]').value=role;document.querySelector('input[name="servers"]').value=servers;document.querySelector('form[action="/admin/users/update"]').scrollIntoView()}
function eliminarUsuario(username){if(confirm(`¿Eliminar "${username}"?`)){const f=document.createElement('form');f.method='post';f.action='/admin/users/delete';const i=document.createElement('input');i.type='hidden';i.name='username';i.value=username;f.appendChild(i);document.body.appendChild(f);f.submit()}}
</script>
{% endblock %}""",

    "servers.html": """{% extends 'base.html' %}{% block content %}
<h1><i class="fas fa-server"></i> Gestión de Servidores</h1>
<p style="color:var(--secondary);margin-bottom:2rem;">Solo <strong>root</strong> puede gestionar los servidores.</p>
<div class="card mb-3"><div class="card-header"><h3 class="card-title"><i class="fas fa-plus"></i> Agregar/Actualizar Servidor</h3></div>
<div class="card-body">
<form method="post" action="/admin/servers/save">
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1rem;margin-bottom:1rem;">
    <div class="form-group mb-0"><label class="form-label">ID del Servidor</label><input name="server_id" class="form-control" required placeholder="francia, china"></div>
    <div class="form-group mb-0"><label class="form-label">Nombre</label><input name="name" class="form-control" required placeholder="Oficina Francia"></div>
  </div>
  <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
</form></div></div>
<div class="card"><div class="card-header"><h3 class="card-title"><i class="fas fa-list"></i> Servidores Registrados</h3></div>
<div class="card-body" style="overflow-x:auto;">
<table class="table"><thead><tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Acciones</th></tr></thead>
<tbody id="historyBody">
{% for sid,info in config.servers().items() %}
<tr>
  <td><strong>{{ sid }}</strong></td>
  <td>{{ info.get('name','') }}</td>
  <td><span class="badge badge-success">Activo</span></td>
  <td>
    <button class="btn btn-danger" style="padding:.25rem .5rem;font-size:.8rem;" onclick="eliminarServidor('{{ sid }}')"><i class="fas fa-trash"></i></button>
  </td>
</tr>
{% endfor %}
{% if config.servers().items() | list | length == 0 %}<tr><td colspan="4" class="text-center text-muted"><i class="fas fa-server"></i> No hay servidores</td></tr>{% endif %}
</tbody></table>
</div></div>
<script>
function eliminarServidor(serverId){if(confirm(`¿Eliminar servidor "${serverId}"?`)){const f=document.createElement('form');f.method='post';f.action='/admin/servers/delete';const i=document.createElement('input');i.type='hidden';i.name='server_id';i.value=serverId;f.appendChild(i);document.body.appendChild(f);f.submit()}}
</script>
{% endblock %}""",
}

env = Environment(loader=DictLoader(TEMPLATES), autoescape=select_autoescape(["html"]))
def render(name: str, **ctx) -> HTMLResponse:
    tpl = env.get_template(name)
    return HTMLResponse(tpl.render(**ctx))

# ==========================
# Dependencias de sesión
# ==========================
def current_user(request: Request) -> Tuple[Optional[str], str, List[str]]:
    username = request.session.get("u")
    role = get_user_role(username) if username else ""
    allowed = CONFIG.allowed_servers_for(username, role) if username else []
    return username, role, allowed

def require_login(request: Request) -> Tuple[str, str, List[str]]:
    u, r, a = current_user(request)
    if not u:
        raise HTTPException(401, "Debes iniciar sesión")
    return u, r, a

# ==========================
# Rutas públicas
# ==========================
@app.get("/health")
def health():
    return {"status": "ok", "time_local": datetime.now(LOCAL_TZ).isoformat(sep=" ", timespec="seconds"), "time_utc": datetime.utcnow().isoformat(sep=" ", timespec="seconds")}

@app.get("/login")
def login_get(request: Request):
    u, r, a = current_user(request)
    if u:
        return RedirectResponse("/", 302)
    return render("login.html", title="Iniciar Sesión", user=None, role=None, flash=None)

@app.post("/login")
def login_post(request: Request, username: str = Form(...), password: str = Form(...)):
    if validate_login(username, password):
        request.session["u"] = username
        return RedirectResponse(url="/", status_code=302)
    return render("login.html", title="Iniciar Sesión", user=None, role=None, flash=("err", "Usuario o contraseña incorrectos"))

@app.get("/logout")
def logout(request: Request):
    request.session.clear()
    return RedirectResponse("/login", 302)

@app.get("/")
def home(request: Request):
    u, r, allowed = require_login(request)
    stats = DATA.get_stats(allowed if r != "root" else None)
    return render("home.html", title="Panel de Control", user=u, role=r, allowed=allowed, stats=stats, flash=None)

# ==========================
# Consulta manual
# ==========================
@app.get("/manual")
def manual_get(request: Request):
    u, r, allowed = require_login(request)
    if not allowed:
        return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=("err", "No tienes servidores asignados"))
    return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=None)

@app.post("/manual")
def manual_post(request: Request, tipo: str = Form(...), query: str = Form(...), server_id: str = Form("")):
    u, r, allowed = require_login(request)
    query = query.strip().upper() if tipo == "PLACA" else query.strip()
    if not query:
        return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=("err", "Ingrese el dato a consultar"))
    if tipo == "CEDULA" and (not query.isdigit() or len(query) != 10):
        return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=("err", "La cédula debe tener 10 dígitos"))
    if tipo == "PLACA" and len(query) < 6:
        return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=("err", "La placa debe tener al menos 6 caracteres"))
    if not server_id and allowed:
        server_id = allowed[0]
    if server_id not in allowed:
        return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=("err", "Servidor no autorizado"))

    if tipo == "CEDULA":
        resultado, sospechoso = consultar_cedula(query)
        estado = "Sospechoso" if sospechoso else "Limpio"
    else:
        resultado, sospechoso = consultar_placa(query)
        estado = "Robado" if sospechoso else "No Robado"

    DATA.add_record(server_id=server_id, user=u, tipo=tipo, identificador=query, estado=estado, sospechoso=sospechoso, detalle=resultado, origen="Manual")
    return render("manual.html", title="Consulta Manual", user=u, role=r, allowed=allowed, flash=None, resultado=resultado, sospechoso=sospechoso, tipo_consulta=tipo, query_value=query)

# ==========================
# Historial
# ==========================
@app.get("/historial")
def historial(request: Request, server_id: str = "", tipo: str = "", estado: str = ""):
    u, r, allowed = require_login(request)
    rows = DATA.list_for_user(u, r, allowed)
    if server_id:
        rows = [x for x in rows if x.get("server_id") == server_id]
    if tipo:
        rows = [x for x in rows if x.get("tipo") == tipo]
    if estado == "sospechoso":
        rows = [x for x in rows if x.get("sospechoso")]
    elif estado == "limpio":
        rows = [x for x in rows if not x.get("sospechoso")]
    rows = sorted(rows, key=lambda x: x.get("ts", ""), reverse=True)[:500]
    return render("historial.html", title="Historial", user=u, role=r, allowed=allowed, rows=rows, server_id=server_id, tipo=tipo, estado=estado, flash=None)

# ==========================
# Exportación
# ==========================
@app.get("/export")
def export_get(request: Request):
    u, r, allowed = require_login(request)
    return render("export.html", title="Exportar Datos", user=u, role=r, allowed=allowed, flash=None)


@app.post("/export")
def export_post(request: Request, scope: str = Form(...), format: str = Form(...), server_id: str = Form(""),
                tipo: str = Form(""), estado_filter: str = Form(""), days: str = Form("")):
    u, r, allowed = require_login(request)
    # Selección de filas
    if scope == "all" and r in ["root", "admin"]:
        rows = DATA.history
    elif scope == "server" and server_id in allowed:
        rows = [x for x in DATA.history if x.get("server_id") == server_id]
    else:
        rows = DATA.list_for_user(u, r, allowed)

    # Filtros
    if tipo:
        rows = [x for x in rows if x.get("tipo") == tipo]
    if estado_filter == "sospechoso":
        rows = [x for x in rows if x.get("sospechoso")]
    elif estado_filter == "limpio":
        rows = [x for x in rows if not x.get("sospechoso")]
    if days:
        cutoff = (datetime.now(LOCAL_TZ).replace(tzinfo=None) - timedelta(days=int(days)))
        rows = [x for x in rows if datetime.fromisoformat(x.get("ts", "1900-01-01 00:00:00")) >= cutoff]

    if not rows:
        return render("export.html", title="Exportar Datos", user=u, role=r, allowed=allowed, flash=("err", "No hay datos para exportar"))

    timestamp = datetime.now(LOCAL_TZ).strftime("%Y%m%d_%H%M%S")
    filename = f"consultas_{timestamp}"

    if format == "csv":
        def generate():
            yield "ID,Fecha/Hora,Servidor,Tipo,Consulta,Estado,Sospechoso,Origen,Usuario,Resultado\n"
            for rec in rows:
                resultado_clean = (rec.get("resultado","").replace('"','""').replace('\n',' | '))
                line = (
                    f"{rec.get('id','')},"
                    f"{rec.get('ts','')},"
                    f"{rec.get('server_id','')},"
                    f"{rec.get('tipo','')},"
                    f"{rec.get('identificador','')},"
                    f"{rec.get('estado','')},"
                    f"{'SI' if rec.get('sospechoso') else 'NO'},"
                    f"{rec.get('origen','')},"
                    f"{rec.get('user','')},"
                    f"\"{resultado_clean}\""
                    "\n"
                )
                yield line
        headers = {
            "Content-Disposition": f'attachment; filename="{filename}.csv"'
        }
        return StreamingResponse(generate(), media_type="text/csv", headers=headers)

    if format == "json":
        return JSONResponse(rows, media_type="application/json")

    if format == "txt":
        def generate():
            for rec in rows:
                yield (
                    f"ID: {rec.get('id','')}\n"
                    f"Fecha/Hora: {rec.get('ts','')}\n"
                    f"Servidor: {rec.get('server_id','')}\n"
                    f"Tipo: {rec.get('tipo','')} | Consulta: {rec.get('identificador','')}\n"
                    f"Estado: {rec.get('estado','')} | Sospechoso: {'SI' if rec.get('sospechoso') else 'NO'}\n"
                    f"Origen: {rec.get('origen','')} | Usuario: {rec.get('user','')}\n"
                    f"Resultado:\n{rec.get('resultado','')}\n"
                    f"{'-'*60}\n"
                )
        headers = { "Content-Disposition": f'attachment; filename="{filename}.txt"' }
        return StreamingResponse(generate(), media_type="text/plain", headers=headers)

    if format == "pdf":
        # Generación de PDF con reportlab
        try:
            from reportlab.pdfgen import canvas
            from reportlab.lib.pagesizes import A4
            from reportlab.lib.units import cm
        except Exception:
            return render("export.html", title="Exportar Datos", user=u, role=r, allowed=allowed,
                          flash=("err", "Falta instalar reportlab: pip install reportlab"))

        import io, textwrap as _tw
        buf = io.BytesIO()
        c = canvas.Canvas(buf, pagesize=A4)
        W, H = A4
        left, top = 2*cm, H - 2*cm
        line_h = 14

        def draw_wrapped(text, x, y, max_chars=95):
            y0 = y
            for line in _tw.wrap(text or "", max_chars):
                c.drawString(x, y0, line)
                y0 -= line_h
            return y0

        # Título
        c.setFont("Helvetica-Bold", 16)
        c.drawString(left, top, "Reporte de Consultas")
        c.setFont("Helvetica", 10)
        c.drawRightString(W-2*cm, top, datetime.now(LOCAL_TZ).strftime("%Y-%m-%d %H:%M:%S %Z"))
        y = top - 2*line_h

        for idx, rec in enumerate(rows, start=1):
            if y < 4*cm:  # nueva página
                c.showPage()
                c.setFont("Helvetica-Bold", 16)
                c.drawString(left, H-2*cm, "Reporte de Consultas (cont.)")
                c.setFont("Helvetica", 10)
                y = H - 3*cm

            c.setFont("Helvetica-Bold", 11)
            c.drawString(left, y, f"#{idx}  ID: {rec.get('id','')}  |  {rec.get('ts','')}")
            y -= line_h
            c.setFont("Helvetica", 10)
            y = draw_wrapped(f"Servidor: {rec.get('server_id','')}  |  Tipo: {rec.get('tipo','')}  |  Consulta: {rec.get('identificador','')}", left, y)
            y = draw_wrapped(f"Estado: {rec.get('estado','')}  |  Sospechoso: {'SI' if rec.get('sospechoso') else 'NO'}", left, y)
            y = draw_wrapped(f"Origen: {rec.get('origen','')}  |  Usuario: {rec.get('user','')}", left, y)
            y = draw_wrapped(f"Resultado: {rec.get('resultado','')}", left, y)
            y -= line_h // 2
            # Separador
            c.line(left, y, W-2*cm, y)
            y -= line_h

        c.save()
        buf.seek(0)
        headers = { "Content-Disposition": f'attachment; filename="{filename}.pdf"' }
        return StreamingResponse(buf, media_type="application/pdf", headers=headers)

    # Formato desconocido
    return render("export.html", title="Exportar Datos", user=u, role=r, allowed=allowed, flash=("err", f"Formato no soportado: {format}"))

@app.get("/export/record/{record_id}")
def export_single_record(record_id: str, request: Request):
    # Exporta en PDF una sola consulta por ID (desde el Historial -> Acciones)
    u, r, allowed = require_login(request)
    # Buscar el registro
    target = None
    for rec in DATA.history:
        if rec.get("id") == record_id:
            target = rec
            break
    if not target:
        raise HTTPException(404, "Registro no encontrado")
    # Verificar permisos
    if r != "root" and target.get("server_id") not in allowed:
        raise HTTPException(403, "Sin permisos")
    # Generar PDF con reportlab
    try:
        from reportlab.pdfgen import canvas
        from reportlab.lib.pagesizes import A4
        from reportlab.lib.units import cm
    except Exception:
        return render("export.html", title="Exportar Datos", user=u, role=r, allowed=allowed,
                      flash=("err", "Falta instalar reportlab: pip install reportlab"))
    import io, textwrap as _tw
    buf = io.BytesIO()
    c = canvas.Canvas(buf, pagesize=A4)
    W, H = A4
    left, top = 2*cm, H - 2*cm
    line_h = 14
    def draw_wrapped(text, x, y, max_chars=95):
        y0 = y
        for line in _tw.wrap(text or "", max_chars):
            c.drawString(x, y0, line)
            y0 -= line_h
        return y0
    # Encabezado
    c.setFont("Helvetica-Bold", 16)
    c.drawString(left, top, "Detalle de Consulta")
    c.setFont("Helvetica", 10)
    c.drawRightString(W-2*cm, top, datetime.now(LOCAL_TZ).strftime("%Y-%m-%d %H:%M:%S %Z"))
    y = top - 2*line_h
    # Cuerpo
    c.setFont("Helvetica-Bold", 11)
    c.drawString(left, y, f"ID: {target.get('id','')}  |  {target.get('ts','')}")
    y -= line_h
    c.setFont("Helvetica", 10)
    y = draw_wrapped(f"Servidor: {target.get('server_id','')}  |  Tipo: {target.get('tipo','')}  |  Consulta: {target.get('identificador','')}", left, y)
    y = draw_wrapped(f"Estado: {target.get('estado','')}  |  Sospechoso: {'SI' if target.get('sospechoso') else 'NO'}", left, y)
    y = draw_wrapped(f"Origen: {target.get('origen','')}  |  Usuario: {target.get('user','')}", left, y)
    y = draw_wrapped(f"Resultado: {target.get('resultado','')}", left, y)
    c.save()
    buf.seek(0)
    filename = f"consulta_{target.get('id','')}.pdf"
    headers = { "Content-Disposition": f'attachment; filename="{filename}"' }
    return StreamingResponse(buf, media_type="application/pdf", headers=headers)

@app.get("/admin/users")
def admin_users(request: Request):
    u, r, allowed = require_login(request)
    if r not in ("root", "admin"):
        raise HTTPException(403, "Sin permisos")
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=None, allowed=allowed)

@app.post("/admin/users/create")
def admin_users_create(request: Request, username: str = Form(...), name: str = Form("Usuario"),
                       password: str = Form(...), servers: str = Form(""), role: str = Form("user")):
    u, r, allowed = require_login(request)
    if r not in ("root", "admin"):
        raise HTTPException(403, "Sin permisos")
    if username in CONFIG.users() or username in ("root", "admin"):
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Usuario ya existe o es reservado"), allowed=allowed)
    if role not in ("user", "admin"):
        role = "user"
    sv = [s.strip() for s in servers.split(",") if s.strip()]
    if r == "admin":
        sv = [s for s in sv if s in allowed]
    CONFIG.set_user(username, {"password": password, "role": role, "name": name, "allowed_servers": sv, "created_by": u, "created_at": now_iso()})
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", f"Usuario {username} creado como {role}"), allowed=allowed)

@app.post("/admin/users/update")
def admin_users_update(request: Request, username: str = Form(...), password: str = Form(""),
                       new_role: str = Form("user"), servers: str = Form("")):
    u, r, allowed = require_login(request)
    if r not in ("root", "admin"):
        raise HTTPException(403, "Sin permisos")
    if username in ("root", "admin") or username not in CONFIG.users():
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Usuario no modificable"), allowed=allowed)
    info = CONFIG.users()[username]
    if r == "admin":
        user_servers = set(info.get("allowed_servers", []))
        if not user_servers.issubset(set(allowed)):
            return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Fuera de tus servidores"), allowed=allowed)
    if password.strip():
        info["password"] = password
    if new_role in ("user", "admin"):
        info["role"] = new_role
    sv = [s.strip() for s in servers.split(",") if s.strip()]
    if r == "admin":
        sv = [s for s in sv if s in allowed]
    info["allowed_servers"] = sv
    info["modified_by"] = u
    info["modified_at"] = now_iso()
    CONFIG.set_user(username, info)
    msg = f"Usuario {username} actualizado"
    if password.strip(): msg += " (contraseña cambiada)"
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", msg), allowed=allowed)

@app.post("/admin/users/reset")
def admin_users_reset(request: Request, username: str = Form(...), password: str = Form(...)):
    u, r, allowed = require_login(request)
    if r not in ("root", "admin"):
        raise HTTPException(403, "Sin permisos")
    if username == "root":
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "No se puede cambiar la contraseña de root"), allowed=allowed)
    if username == "admin":
        if r != "root":
            return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Solo root puede cambiar la contraseña de admin"), allowed=allowed)
        CONFIG.set_admin_password(password)
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", "Contraseña de admin actualizada"), allowed=allowed)
    info = CONFIG.users().get(username)
    if not info:
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Usuario no encontrado"), allowed=allowed)
    if r == "admin":
        user_servers = set(info.get("allowed_servers", []))
        if not user_servers.issubset(set(allowed)):
            return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Fuera de tus servidores"), allowed=allowed)
    info["password"] = password
    CONFIG.set_user(username, info)
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", f"Contraseña de {username} actualizada"), allowed=allowed)

@app.post("/admin/users/set_admin")
def admin_set_admin_password(request: Request, password: str = Form(...)):
    u, r, allowed = require_login(request)
    if r != "root":
        raise HTTPException(403, "Solo root puede establecer contraseña de admin")
    CONFIG.set_admin_password(password)
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", "Contraseña de admin establecida"), allowed=allowed)

@app.post("/admin/users/delete")
def admin_users_delete(request: Request, username: str = Form(...)):
    u, r, allowed = require_login(request)
    if r not in ("root", "admin"):
        raise HTTPException(403, "Sin permisos")
    if username in ("root", "admin"):
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "No se puede eliminar este usuario"), allowed=allowed)
    info = CONFIG.users().get(username)
    if not info:
        return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Usuario no encontrado"), allowed=allowed)
    if r == "admin":
        user_servers = set(info.get("allowed_servers", []))
        if not user_servers.issubset(set(allowed)):
            return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("err", "Fuera de tus servidores"), allowed=allowed)
    CONFIG.del_user(username)
    return render("users.html", title="Gestión de Usuarios", user=u, role=r, config=CONFIG, flash=("ok", f"Usuario {username} eliminado"), allowed=allowed)

# ==========================
# Administración de servidores
# ==========================
@app.get("/admin/servers")
def admin_servers(request: Request):
    u, r, _ = require_login(request)
    if r != "root":
        raise HTTPException(403, "Solo root puede gestionar servidores")
    return render("servers.html", title="Gestión de Servidores", user=u, role=r, config=CONFIG, flash=None, allowed=[])

@app.post("/admin/servers/save")
def admin_servers_save(request: Request, server_id: str = Form(...), name: str = Form("")):
    u, r, _ = require_login(request)
    if r != "root":
        raise HTTPException(403, "Solo root puede gestionar servidores")
    if not server_id.strip():
        return render("servers.html", title="Gestión de Servidores", user=u, role=r, config=CONFIG, flash=("err", "Server ID es obligatorio"), allowed=[])
    servers = CONFIG.servers()
    servers[server_id] = {"name": name or server_id, "created_at": now_iso(), "created_by": u}
    CONFIG.save()
    return render("servers.html", title="Gestión de Servidores", user=u, role=r, config=CONFIG, flash=("ok", f"Servidor {server_id} guardado"), allowed=[])

@app.post("/admin/servers/delete")
def admin_servers_delete(request: Request, server_id: str = Form(...)):
    u, r, _ = require_login(request)
    if r != "root":
        raise HTTPException(403, "Solo root puede gestionar servidores")
    servers = CONFIG.servers()
    if server_id not in servers:
        return render("servers.html", title="Gestión de Servidores", user=u, role=r, config=CONFIG, flash=("err", "Servidor no encontrado"), allowed=[])
    del servers[server_id]
    CONFIG.save()
    # quitar de usuarios
    for username, info in list(CONFIG.users().items()):
        sv = info.get("allowed_servers", [])
        if server_id in sv:
            sv.remove(server_id)
            info["allowed_servers"] = sv
            CONFIG.set_user(username, info)
    return render("servers.html", title="Gestión de Servidores", user=u, role=r, config=CONFIG, flash=("ok", f"Servidor {server_id} eliminado"), allowed=[])

# ==========================
# Ingesta de eventos (API)
# ==========================
async def get_payload(request: Request, file: Optional[UploadFile] = File(None)) -> Dict[str, Any]:
    if file:
        content = await file.read()
        try:
            return json.loads(content.decode("utf-8"))
        except json.JSONDecodeError as e:
            raise HTTPException(400, f"JSON inválido en el archivo: {str(e)}")
    else:
        try:
            return await request.json()
        except json.JSONDecodeError as e:
            raise HTTPException(400, f"JSON inválido en el cuerpo: {str(e)}")

@app.post("/face_events")
async def face_events(request: Request, file: Optional[UploadFile] = File(None)):
    payload = await get_payload(request, file)
    server_id = identify_server(request, payload)
    faceinfo = payload.get("faceinfo") or {}
    cedula = (faceinfo.get("remark") or faceinfo.get("cedula") or "").strip()
    if not cedula or not cedula.isdigit() or len(cedula) != 10:
        return JSONResponse({"status": "invalid_cedula", "message": "Cédula inválida o faltante"}, 400)
    threading.Thread(target=process_cedula_async, args=(server_id, cedula, "trassir", "Reconocimiento Facial"), daemon=True).start()
    return JSONResponse({"status": "ok", "server_id": server_id, "queued": {"tipo": "CEDULA", "cedula": cedula}, "timestamp": now_iso()}, 200)


@app.post("/lpr_events")
async def lpr_events(request: Request, file: Optional[UploadFile] = File(None)):
    """
    Endpoint LPR sin autenticación por API key.
    Valida únicamente por data["server"]["name"] (u otras variantes) y,
    si SETTINGS.lpr_whitelist=False (por defecto), acepta cualquier servidor (modo permisivo).
    """
    payload = await get_payload(request, file)
    try:
        server_id = get_server_from_payload_permissive(payload)
    except HTTPException as e:
        raise e
    placa = (payload.get("plate") or payload.get("placa") or "").strip().upper()
    if not placa or len(placa) < 6:
        return JSONResponse({"status": "invalid_plate", "message": "Placa inválida o faltante"}, 400)
    threading.Thread(target=process_placa_async, args=(server_id, placa, "lpr", "Reconocimiento LPR"), daemon=True).start()
    return JSONResponse({"status": "ok", "server_id": server_id, "queued": {"tipo": "PLACA", "placa": placa}, "timestamp": now_iso()}, 200)

# ==========================
# API de detalle
# ==========================
@app.get("/api/record/{record_id}")
def get_record_detail(record_id: str, request: Request):
    u, r, allowed = require_login(request)
    for rec in DATA.history:
        if rec.get("id") == record_id:
            if r != "root" and rec.get("server_id") not in allowed:
                raise HTTPException(403, "Sin permisos")
            return JSONResponse(rec)
    raise HTTPException(404, "Registro no encontrado")


@app.get("/api/last_record")
def api_last_record(request: Request):
    u, r, allowed = require_login(request)
    rows = DATA.list_for_user(u, r, allowed)
    if not rows:
        return JSONResponse({"id": None})
    last = sorted(rows, key=lambda x: x.get('ts', ''), reverse=True)[0]
    return JSONResponse(last)

# ==========================
# Función auxiliar para extraer servidor del payload
# ==========================
def get_server_from_payload_permissive(payload: Dict[str, Any]) -> str:
    """
    Extrae el nombre/ID de servidor del JSON LPR sin exigir autenticación.
    Acepta data["server"]["name"] o variantes. Si el valor es un dict, intenta tomar 'name'/'id'/'title'.
    Con SETTINGS.lpr_whitelist=False (default), acepta cualquiera (modo permisivo).
    """
    servers = CONFIG.servers()
    settings = CONFIG.data.get("SETTINGS", {})
    whitelist = bool(settings.get("lpr_whitelist", False))

    def pick_server_name(*candidates) -> str:
        for v in candidates:
            if not v:
                continue
            # Si llega un dict, intenta campos comunes
            if isinstance(v, dict):
                for k in ("name", "server_name", "title", "id"):
                    vv = v.get(k)
                    if isinstance(vv, str) and vv.strip():
                        return vv.strip()
                    if isinstance(vv, (int, float)):
                        return str(vv)
                # Si no hubo campos, repr corto
                return str(v)
            # Si es lista, toma el primero útil
            if isinstance(v, (list, tuple)) and v:
                vv = v[0]
                if isinstance(vv, str) and vv.strip():
                    return vv.strip()
                if isinstance(vv, (int, float)):
                    return str(vv)
                if isinstance(vv, dict):
                    for k in ("name", "server_name", "title", "id"):
                        if k in vv and isinstance(vv[k], str) and vv[k].strip():
                            return vv[k].strip()
            # Si es escalar
            if isinstance(v, str) and v.strip():
                return v.strip()
            if isinstance(v, (int, float)):
                return str(v)
        return ""

    data = payload.get("data") or {}
    server_name = pick_server_name(
        data.get("server"),                 # dict o str
        payload.get("serverName"),
        payload.get("server"),
        payload.get("store"),
        data.get("server_name"),
        data.get("store"),
    )
    if not server_name:
        server_name = "unknown"

    # Modo permisivo por defecto
    if not whitelist or not servers:
        return server_name

    # Whitelist habilitada: validar contra lista
    if server_name in servers:
        return server_name
    for sid, info in servers.items():
        if (info.get("name") or "").strip() == server_name:
            return sid

    raise HTTPException(401, f"Servidor no permitido por whitelist: {server_name}")

# ==========================
# Main
# ==========================
if __name__ == "__main__":
    print(f"🚀 Sistema Unificado - Fiscalía & Placas v2.0")
    print(f"🌐 http://{HOST}:{PORT}")
    print(f"📁 Datos: {DATA_DIR} | Historial: {len(DATA.history)} | Servidores: {len(CONFIG.servers())} | Usuarios: {len(CONFIG.users())}")
    if has_internet(): print("✅ Conexión a Internet OK")
    else: print("⚠️  Sin Internet - solo demo/heurístico")
    try:
        uvicorn.run("__main__:app", host=HOST, port=PORT, reload=False, log_level="info")
    except KeyboardInterrupt:
        print("\n👋 Sistema detenido")