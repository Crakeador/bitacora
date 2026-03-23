---
name: softguard-vigicontrol
description: Analiza, diseña y aterriza funcionalidades relacionadas con SoftGuard y VigiControl para apps de guardias, bitácoras electrónicas, rondas, hombre vivo, pánico, novedades, check-in con foto, control de accesos y supervisión operativa. Úsalo cuando el usuario pida mapear requerimientos del negocio o de la app a módulos SoftGuard, flujos VigiControl, pantallas operativas de vigilantes o conceptos de monitoreo y vigilancia en campo.
---

# SoftGuard VigiControl

Usa esta skill para trabajar sobre flujos de vigilancia y operación en campo inspirados en SoftGuard y VigiControl.

## Enfoque

Prioriza aterrizar requerimientos del usuario en términos funcionales y operativos:

- Identificar si el caso pertenece a guardias en puesto, rondas, incidencias, pánico, accesos o supervisión.
- Separar lo que es flujo móvil del guardia versus lo que es módulo de backoffice o monitoreo central.
- Mantener consistencia terminológica entre `ingreso`, `salida`, `novedad`, `ronda`, `hombre vivo`, `hombre caído`, `pánico`, `bitácora` y `asignaciones`.

## Flujo recomendado

1. Leer [references/softguard-overview.md](references/softguard-overview.md) cuando necesites contexto de módulos o capacidades.
2. Leer [references/bitacora-glossary.md](references/bitacora-glossary.md) cuando necesites lenguaje operativo consistente para guardias, rondas, lances y bitácora electrónica.
3. Leer [references/project-payloads.md](references/project-payloads.md) cuando necesites modelar payloads del proyecto para ingreso, salida, novedad, pánico o ronda.
4. Clasificar el requerimiento del usuario en una o más categorías:
   - operación del guardia
   - rondas / lances / bitácora
   - seguridad crítica
   - accesos y visitas
   - monitoreo y supervisión
5. Proponer una traducción a producto:
   - pantalla o experiencia móvil
   - evento o payload
   - validación operativa
   - módulo SoftGuard/VigiControl relacionado
6. Si el usuario pide desarrollo, implementar respetando el lenguaje operativo ya usado en la app.

## Heurísticas útiles

- Para `Hombre Vivo`, pensar en presencia validada, temporizador, gracia, confirmación y alerta derivada.
- Para `ingreso` y `salida`, pensar en trazabilidad del relevo: identidad, fotos, turno, fecha, puesto, ubicación e IP.
- Para `rondas`, pensar en inicio de lance, punto de control, tiempo transcurrido, evidencia y cierre de bitácora.
- Para `novedades`, pensar en texto, multimedia, tipificación y envío desde campo.
- Para `pánico`, pensar en evento urgente con ubicación y evidencia opcional.
- Para `accesos`, pensar en visitas peatonales/vehiculares, autorizaciones y registro en tiempo real.

## Qué reutilizar de esta skill

- Mapa conceptual de módulos SoftGuard.
- Capacidades operativas de VigiControl para guardias.
- Terminología consistente para bitácoras electrónicas y rondas.
- Ideas de payloads y pantallas alineadas con vigilancia en campo.

## Límites

- No asumir APIs oficiales de SoftGuard si el usuario no las proporcionó.
- Tratar la documentación pública como referencia funcional y comercial, no como contrato técnico.
- Si el usuario necesita integración exacta, pedir o revisar endpoints reales del sistema que esté implementando.
