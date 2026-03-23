# Glosario de bitácora electrónica

## Objetivo

Usa este glosario para mantener vocabulario estable dentro del proyecto de guardias, especialmente en pantallas, payloads, textos UX y reportes.

## Términos base

### Bitácora electrónica

Registro digital de la operación del puesto. Agrupa ingresos, salidas, novedades, rondas, evidencias, tiempos y eventos relevantes del turno.

### Puesto

Lugar físico o servicio asignado al agente de seguridad. Suele estar identificado por `idpuesto`.

### Agente

Guardia o vigilante que opera la app y registra actividades del puesto.

### Turno

Ventana operativa asignada al agente durante la sesión.

- Turno diurno: `1`, de `07:00` a `17:00`
- Turno nocturno: `2`, de `17:00` a `07:00`

En este proyecto el turno queda fijo al iniciar sesión y se mantiene hasta el cierre de sesión.

### Ingreso al puesto

Registro inicial del agente entrante. Debe dejar trazabilidad del comienzo de operación en el puesto, normalmente con observación, ubicación, fecha, turno y evidencia fotográfica.

### Salida del sistema

Registro de cierre o entrega de turno. En el proyecto representa el momento en que termina la operación del agente actual y se libera el login para un nuevo relevo.

### Relevo

Transición entre agente saliente y agente entrante. Puede requerir dos fotos y observación de entrega/recepción.

### Novedad

Incidencia, observación o comentario operativo reportado desde el campo. Puede incluir texto, fotos, audio y tipificación.

### Pánico

Evento crítico y urgente generado por el agente con prioridad alta, normalmente acompañado de ubicación y hora exacta.

### Hombre Vivo

Mecanismo de validación periódica de presencia. El sistema solicita confirmación al agente para demostrar que sigue activo en el puesto.

### Hombre Caído

Alerta derivada de no responder a `Hombre Vivo` dentro del tiempo de gracia.

### Ronda

Recorrido operativo del agente por puntos o sectores definidos. Puede validarse por GPS, QR, NFC o Bluetooth según el sistema.

### Lance

Unidad operativa dentro de una ronda o bitácora. En la UI de rondas puede representarse como un evento en progreso con hora de inicio, tiempo transcurrido y evidencia asociada.

### Captura

Evidencia generada durante una ronda o lance, normalmente foto, audio o algún registro de validación.

### Bitácora abierta

Estado operativo en el que todavía se pueden agregar lances, capturas o novedades.

### Cierre de bitácora

Acción que finaliza la sesión operativa de rondas o del registro diario del puesto.

### Presencia validada

Confirmación de que el agente correcto está activo y cumpliendo en el puesto. Puede apoyarse en GPS, foto, reconocimiento facial o interacción explícita.

### Cola offline

Pendientes guardados localmente cuando no hay conectividad. Deben sincronizarse después sin perder turno, fecha, ubicación ni evidencia.

## Reglas de lenguaje recomendadas

- Usar `Ingreso al Puesto` para la acción inicial del relevo.
- Usar `Salir del Sistema` para el cierre definitivo de sesión.
- Usar `Novedades` para reportes operativos desde campo.
- Usar `Rondas` y `Lances` cuando se trate de recorridos o bitácora en progreso.
- Evitar mezclar `salida del puesto`, `logout`, `cerrar sesión` y `salir del sistema` si la acción funcional es la misma.

## Traducción sugerida a UX

- `Ingreso al Puesto`: comienzo de turno del agente actual.
- `Novedades`: operación continua mientras el agente sigue activo.
- `Rondas`: ejecución de recorridos y lances.
- `Salir del Sistema`: entrega del puesto y liberación del login.
