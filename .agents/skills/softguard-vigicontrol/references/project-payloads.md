# Payloads de referencia del proyecto

## Objetivo

Usa estos ejemplos para mantener consistencia entre el frontend Flutter y el backend actual del proyecto. Son payloads de trabajo del proyecto, no APIs oficiales de SoftGuard.

## Reglas transversales

- `turno` debe usar el valor fijado en sesión.
- `idpuesto` e `idpersona` deben salir de la sesión o del puesto seleccionado.
- `fecha` debe ir en formato `YYYY-MM-DD HH:mm:ss`.
- `latitude` / `longitude` o `latitud` / `longitud` deben respetar el nombre exacto que espere el endpoint actual.
- `ip` debe enviarse si está disponible; si no, usar el valor de respaldo definido por la app.
- Cuando haya offline, guardar suficiente información para reconstruir el payload completo al sincronizar.

## 1. Ingreso al puesto

Endpoint actual del proyecto:

- `POST /api/registros`

Payload de referencia:

```json
{
  "idpuesto": 18,
  "idpersona": 5,
  "foto1": "agente-saliente.jpg",
  "foto2": "agente-entrante.jpg",
  "turno": 1,
  "fecha": "2026-03-16 10:12:12",
  "proceso": 1,
  "observacion": "Se ingresa al puesto sin ninguna novedad",
  "latitude": "-2.788888",
  "longitude": "-79.89999",
  "rangoerror": 100,
  "mensaje": "",
  "ip": "120.45.8.99"
}
```

Notas:

- `foto1` y `foto2` salen de dos subidas previas al endpoint de upload.
- `proceso = 1` identifica ingreso.
- Se usa para el relevo inicial del agente.

## 2. Salida del sistema

Endpoint actual del proyecto:

- `POST /api/registros`

Payload de referencia:

```json
{
  "idpuesto": 18,
  "idpersona": 5,
  "foto1": "agente-saliente.jpg",
  "foto2": "agente-entrante.jpg",
  "turno": 1,
  "fecha": "2026-03-16 17:02:12",
  "proceso": 3,
  "observacion": "Se entrega el turno sin ninguna novedad",
  "latitude": "-2.788888",
  "longitude": "-79.89999",
  "rangoerror": 100,
  "mensaje": "",
  "ip": "120.45.8.99"
}
```

Notas:

- `proceso = 3` identifica salida.
- Después de un envío exitoso, la sesión debe limpiarse y el login debe quedar libre para un nuevo agente.

## 3. Novedad

Endpoint actual del proyecto:

- `POST /api/novedades`

Payload de referencia:

```json
{
  "idpuesto": 18,
  "idpersona": 5,
  "foto1": "novedad-1.jpg",
  "foto2": "novedad-2.jpg",
  "foto3": "",
  "foto4": "",
  "foto5": "",
  "foto6": "",
  "turno": 1,
  "fecha": "2026-03-16 11:32:45",
  "proceso": 1,
  "tipo": 4,
  "nota": 1,
  "observacion": "Visita autorizada por el propietario",
  "latitude": "-2.788888",
  "longitude": "-79.89999",
  "rangoerror": 0,
  "mensaje": "",
  "ip": "120.45.8.99"
}
```

Notas:

- El proyecto actual soporta hasta 6 fotos para novedades.
- `tipo` clasifica la novedad o visita.
- Tras registrar una novedad, el agente debe permanecer operando dentro de la app.

## 4. Pánico

Endpoint actual del proyecto:

- `POST /api/panico`

Payload de referencia:

```json
{
  "idpuesto": 18,
  "idpersona": 5,
  "turno": 1,
  "fecha": "2026-03-16 12:03:01",
  "proceso": 1,
  "tipo": 4,
  "nota": 1,
  "observacion": "ALERTA DE PANICO - Nombre del agente",
  "latitude": "-2.788888",
  "longitude": "-79.89999",
  "rangoerror": 0,
  "mensaje": "",
  "ip": "120.45.8.99"
}
```

Notas:

- Debe dispararse como evento crítico.
- La ubicación es obligatoria siempre que el dispositivo la tenga disponible.

## 5. Ronda o lance

Payload conceptual de referencia para cuando el proyecto conecte rondas con backend:

```json
{
  "idpuesto": 18,
  "idpersona": 5,
  "turno": 1,
  "fecha_inicio": "2026-03-16 14:00:00",
  "fecha_fin": "2026-03-16 14:22:00",
  "estado": "cerrado",
  "metodo_validacion": "gps",
  "observacion": "Lance completado sin novedades",
  "capturas": 0,
  "latitude": "-2.788888",
  "longitude": "-79.89999",
  "ip": "120.45.8.99"
}
```

Notas:

- En la UI actual, `Rondas` todavía puede estar desacoplado del backend.
- Este ejemplo sirve para pensar estado, tiempos, evidencia y cierre de bitácora.

## Recomendación de implementación

Cuando el usuario pida una nueva función:

1. Confirmar cuál endpoint real existe hoy.
2. Confirmar los nombres exactos de campos (`latitude` vs `latitud`, etc.).
3. Mantener alineado el payload online con el objeto offline.
4. Registrar consumo de datos y logs para depuración.
