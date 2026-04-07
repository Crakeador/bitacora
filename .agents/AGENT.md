# Sistema Near Solution — Bitácora Electrónica
**Proyecto PHP 7.4 + MySQL — Versión 1.0.0**

---

## 🎯 Propósito

Sistema web/móvil para gestionar Agentes de Seguridad, Usuarios Administrativos y Clientes en una única interfaz, con soporte para dispositivos móviles y web. Incluye:

- Autenticación basada en roles (Agente, Admin, Cliente).
- Gestión de departamentos y asignación de usuarios.
- Integración con APIs de dispositivos móviles (GPS, Cámara, Almacenamiento).
- Diseño responsivo compatible con móviles y escritorio.

---

## ⚙️ Stack Técnico

| Componente     | Versión/Tecnología                              |
|----------------|-------------------------------------------------|
| Backend        | PHP 7.4 (sin frameworks, MVC procedural propio) |
| Base de Datos  | MySQL 8.0 / MariaDB                             |
| Frontend       | AdminLTE 2.x, Bootstrap 3, jQuery              |
| APIs Móviles   | Geolocation API, MediaDevices API               |
| Servidor       | Apache 2.4 con mod_rewrite                      |
| Dependencias   | php-mysqli, php-json, php-c           |

> ⚠️ PHP 7.4 ya no recibe actualizaciones de seguridad. Para producción, actualizar a PHP 8.1+.

---

## �️ Estructura del Proyecto

```
/
├── index.php                        # Punto de entrada único
├── .htaccess                        # URLs amigables
├── core/
│   ├── autoload.php                 # Carga todas las clases del sistema
│   ├── controller/                  # Clases base del framework
│   │   ├── Database.php             # Conexión MySQLi (host, user, pass, db: bitacora)
│   │   ├── Executor.php             # Ejecuta todas las queries SQL
│   │   ├── Model.php                # Mapea resultados a objetos (one/many)
│   │   ├── View.php                 # Carga vistas desde core/app/view/
│   │   ├── Action.php               # Carga acciones desde core/app/action/
│   │   ├── Module.php               # Carga layouts
│   │   ├── Session.php              # Manejo de $_SESSION['user_id']
│   │   ├── Lb.php                   # Bootstrap del sistema
│   │   └── Core.php                 # Clase base con helpers globales
│   └── app/
│       ├── layouts/
│       │   └── layout.php           # Plantilla principal (menú, CSS, JS, sesión)
│       ├── model/                   # 53 clases *Data.php (una por tabla)
│       ├── view/                    # 200+ archivos *-view.php (HTML + PHP)
│       └── action/                  # 25+ archivos *-action.php (lógica de procesamiento)
├── ajax/                            # 22 endpoints AJAX (GET/POST → JSON/HTML)
├── api/                             # ST con micro-framework Flight
├── assets/                          # CSS, JS, imágenes, fuentes
└── plugins/                         # Bootstrap, DataTables, Select2, SweetAlert, etc.
```

---

## 🔀 Enrutamiento

```
index.php → core/autoload.php → Lb::start() → core/app/init.php
```

| URL                    | Archivo cargado                              |
|------------------------|----------------------------------------------|
| `?view=nombre`         | `core/app/view/nombre-view.php`              |
| `?action=nombre`       | `core/app/action/nombre-action.php`          |
| Sin parámetros         | `core/app/layouts/layout.php` (login/dashboard) |

---

## 🔐 Autenticación y Sesiones

Archivo: `core/app/action/processlogin-action.php`

Tres flujos de login según el input:
- **Admin/Usuario**: nombre de usuario + contraseña (`sha1(md5($pass))`)
- **Agente**: cédula de 10 dígitos
- **Cliente**: RUC de 13 dígitos + teléfono

Variables de sesión clave:

cias y comunicados internos con reacciones                |

---

## 🐞 Problemas Conocidos

- Android < 10: algunos dispositivos no soportan `MediaDevices.getUserMedia()`.
- Uso intensivo del GPS puede agotar la batería en móviles.
- Sin soporte offline: reportes no se envían si el servidor está caído.
ta fotos a reportes desde el dispositivo (MediaDevices API)         |
| Responsive Design     | Interfaz adaptable para móviles y web (AdminLTE + Bootstrap 3)           |
| Nómina                | Módulo de cálculo de nómina, descuentos y liquidaciones                  |
| Bitácora              | Registro de novedades con foto, GPS y timestamp                          |
| Asistencia            | Control de entrada/salida con geolocalización                            |
| Anuncios              | Sistema de noti| Descripción                                                              |
|-----------------------|--------------------------------------------------------------------------|
| Autenticación Única   | Login para todos los roles desde una misma interfaz                      |
| Gestión de Roles      | Permisos diferenciados por rol (Admin, Agente, Cliente, Residente)       |
| GPS en Tiempo Real    | Registra ubicación del agente al crear un reporte (Geolocation API)      |
| Cámara                | Adjun— esquema débil. Migrar a `password_hash()` / `password_verify()`.
- Credenciales de BD en texto plano en `Database.php` (`root` sin contraseña).
- La URL base está hardcodeada en sesión dentro de `layout.php`: `$_SESSION["url"]`.
- Siempre verificar `$_SESSION['idrol']` e `$_SESSION['is_admin']` en vistas/acciones nuevas para control de acceso.
- El sistema detecta dispositivo en `layout.php` via `HTTP_USER_AGENT` y setea `$_SESSION['dispositivo']`.

---

## 🚀 Características Clave

| Funcionalidad         y'];
        $query = Executor::doit($sql);
        return Model::many($query[0], new NuevaData());
    }
}
```

**Nuevo endpoint AJAX:**
```php
<?php
include("../core/controller/Database.php");
session_start();
$base = new Database();
$con = $base->connect();
// lógica aquí
echo json_encode($resultado);
```

---

## ⚠️ Puntos de Atención

- Las queries en archivos AJAX concatenan `$_GET`/`$_POST` directamente — riesgo de SQL injection. Usar siempre `$con->real_escape_string()`.
- Contraseñas con `sha1(md5())` → carga de archivos
- `ajax/handle_reaction.php` → reacciones en anuncios

---

## 🛠️ Cómo agregar funcionalidad nueva

**Nueva vista:**
```
Crear: core/app/view/nueva-view.php
Acceder: ?view=nueva
```

**Nueva acción (procesar formulario):**
```
Crear: core/app/action/nueva-action.php
Acceder: ?action=nueva
```

**Nuevo modelo:**
```php
class NuevaData {
    public static $tablename = "tabla";

    public static function getAll() {
        $sql = "SELECT * FROM tabla WHERE idcompany = ".$_SESSION['id_companphp` → listado de agentes
- `asistencia-view.php` → control de asistencia
- `layout.php` → plantilla base (AdminLTE)

---

## ⚡ AJAX (`/ajax/` — 22 archivos)

Cada archivo incluye su propia conexión a BD. Reciben parámetros por `$_GET` o `$_POST` y devuelven HTML o JSON. Se consumen con jQuery desde las vistas.

Archivos relevantes:
- `ajax/cliente.php` → operaciones sobre clientes
- `ajax/calcular.php` → cálculos de nómina
- `ajax/eventos.php` → eventos del calendario
- `ajax/subir.php` / `subir_multiple.php`  Convenciones de nombres:

| Prefijo   | Módulo                        |
|-----------|-------------------------------|
| `rrh`     | Recursos Humanos              |
| `ope`     | Operaciones                   |
| `cat`     | Catálogos/configuración       |
| `rep`     | Reportes                      |
| `rrp`     | Reportes de RRHH              |
| `anuncios`| Noticias y comunicados        |

Vistas clave:
- `home-view.php` → dashboard principal
- `bitacora-view.php` → registro de novedades
- `personas-view.por is_active
$obj->add()                  // INSERT
$obj->update()               // UPDATE
$obj->del()                  // DELETE
```

Modelos más usados:
- `UserData.php` → tabla `user`
- `PersonData.php` → tabla `person`
- `ClientData.php` → tabla `client`
- `BitacoraData.php` → tabla `bitacora`
- `AsistenciaData.php` → tabla `asistencia`
- `PuestoData.php` → tabla `puestos`
- `DepartamentoData.php` → tabla `departamento`

---

## 🖼️ Vistas (200+ archivos en `core/app/view/`)

HTML puro con PHP embebido.iones globales (consigna, emails)      | —                |
| `anuncios`     | Noticias y servicios publicados                  | —                |
| `asistencia`   | Asistencia con GPS (lat, lng, foto, timestamp)   | —                |

---

## 🧩 Modelos (53 clases en `core/app/model/`)

Convención: cada clase `*Data.php` mapea una tabla. Métodos estándar:

```php
NombreData::getAll()         // SELECT * con JOINs
NombreData::getById($id)     // SELECT por PK
NombreData::getEstado($est)  // SELECT filtrado fotos y GPS             | 9000+            |
| `asistencia`   | Control de asistencia con geolocalización        | 176+             |
| `autorizacion` | Autorizaciones de visitas                        | 23+              |
| `puestos`      | Puestos de seguridad asignados                   | —                |
| `departamento` | Departamentos organizacionales                   | —                |
| `rol`          | Roles del sistema                                | —                |
| `configuration`| Configuracía)*

Tablas principales:

| Tabla          | Descripción                                      | Registros aprox. |
|----------------|--------------------------------------------------|------------------|
| `user`         | Usuarios del sistema con roles                   | —                |
| `person`       | Agentes/personas de seguridad                    | —                |
| `client`       | Clientes/empresas contratantes                   | —                |
| `bitacora`     | Novedades y reportes con ]`      | IP detectada del cliente                 |
| `$_SESSION['dispositivo']` | 1 = desktop, 2 = móvil              |

Roles conocidos:

| idrol | Descripción      |
|-------|------------------|
| 1     | Administrador    |
| 7     | Agente           |
| 8     | Cliente          |
| 9     | Residente        |
| 11    | Aspirante        |
| 22    | Administrativo   |

---

## 🗄️ Base de Datos

Archivo de conexión: `core/controller/Database.php`
- Host: `localhost` | DB: `bitacora` | User: `root` | Pass: *(vac       |
|------------------------|------------------------------------------|
| `$_SESSION['user_id']` | ID del usuario autenticado               |
| `$_SESSION['idrol']`   | Rol numérico del usuario                 |
| `$_SESSION['is_admin']`| 1 = administrador, 0 = usuario normal    |
| `$_SESSION['depart']`  | ID del departamento asignado             |
| `$_SESSION['id_company']` | ID de la empresa/compañía             |
| `$_SESSION['usuario']` | Nombre de usuario para logs              |
| `$_SESSION['ip'| Variable               | Descripción                       