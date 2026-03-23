# SoftGuard y VigiControl

## Fuentes base

- Módulos SoftGuard: https://softguard.com/modulos/
- VigiControl: https://softguard.com/vigicontrol/

## Qué aporta SoftGuard a nivel plataforma

La página de módulos presenta SoftGuard como una plataforma PSIM+ que concentra distintas tecnologías de seguridad física en una sola solución. Para esta skill, los módulos más útiles para inferir producto son:

- Monitoreo Web: gestión de eventos, tareas pendientes, llamadas automáticas e instrucciones para operador.
- Monitoreo de eventos: recepción de eventos desde múltiples medios y protocolos.
- MapGuard: visualización de cuentas, vehículos, vigilantes, cámaras y asignación de unidad cercana.
- Reporte de Notificaciones: resumen de mensajes, alertas y comunicaciones entre actores operativos.
- Verificación de Video: validación de eventos con video para reducir falsas alarmas.
- Servicio Técnico: gestión de solicitudes, mantenimientos y seguimiento de estado.
- TrackGuard: rastreo GPS, posiciones históricas, geocercas y gestión de flotas.
- Control de Acceso y Gestión de Visitas: administración de invitados, entregas, servicios y accesos.
- Web Manager: auditoría, estadísticas y mejora operativa.
- Reporte a Autoridades: reenvío controlado de eventos a terceros o autoridades.

## Qué aporta VigiControl para la app del guardia

La documentación pública de VigiControl describe una operación móvil centrada en el vigilante y su supervisión:

- Supervisión de guardias y rondas desde una sola plataforma.
- Validación de presencia con GPS.
- Alertas críticas desde campo.
- Reportes e imágenes en tiempo real.
- Botón de pánico con ubicación y evidencia.
- Rondas y recorridos con tecnologías combinables:
  - GPS
  - QR
  - NFC
  - Bluetooth
- Hombre Vivo / Hombre Caído:
  - confirmación periódica
  - validación por PIN o patrón
  - alerta inmediata si no responde
- Check-in con biometría:
  - captura de foto o reconocimiento facial al iniciar sesión
- Novedades desde campo:
  - incidencias, comentarios y novedades
  - soporte para texto, imágenes o audio
  - botones generales o específicos
- Asignaciones en tiempo real por push.
- Control de visitas y accesos con registro en el momento.

## Traducción a capacidades de producto

### Operación del guardia

- Ingreso al puesto
- Salida del puesto o del sistema
- Validación de identidad del agente
- Toma de evidencia fotográfica
- Persistencia del turno activo

### Seguridad crítica

- Pánico
- Hombre Vivo
- Hombre Caído
- Alertas por atraso o ausencia

### Bitácora electrónica

- Inicio de ronda o lance
- Registro de capturas/evidencias
- Tiempo en progreso
- Historial de rondas completadas
- Cierre de bitácora

### Novedades y campo

- Texto descriptivo
- Fotos o audio
- Clasificación por tipo
- Registro online/offline

### Supervisión y trazabilidad

- Ubicación en mapa
- Histórico de eventos
- Estados y sincronización
- Indicadores de operación

## Cómo usar este contexto en desarrollo

Cuando un usuario pida una nueva pantalla o flujo, intenta mapearlo a uno de estos grupos:

1. `Ronda / bitácora`
2. `Presencia / validación`
3. `Emergencia`
4. `Novedad`
5. `Acceso / visita`
6. `Supervisión`

Después propone:

- el estado mínimo que debe guardar la app
- los eventos que debería emitir
- los datos obligatorios del payload
- la UI más cercana al patrón operativo de vigilancia

## Advertencias

- La documentación pública describe capacidades, no contratos API.
- Puede haber diferencias entre marketing, despliegues concretos y backend real del cliente.
- Si existe backend ya implementado, ese backend manda sobre cualquier inferencia de esta referencia.
