---
name: hikvision-face-recognition
description: Documenta los terminales de reconocimiento facial DS-K1T344EBWX-E1 y DS-K1T341CMFW de Hikvision para desarrolladores que necesitan integrar control de acceso facial en aplicaciones web, incluyendo especificaciones técnicas, API HTTP, SDK y ejemplos de integración con PHP y JavaScript.
---

# Hikvision Face Recognition Terminals

## Introducción

Los terminales de reconocimiento facial de la serie Value de Hikvision están diseñados para control de acceso seguro. Este skill cubre los modelos DS-K1T344EBWX-E1 y DS-K1T341CMFW, proporcionando documentación técnica y guías de integración para desarrolladores que desean conectar estos dispositivos con aplicaciones web.

## Modelos Soportados

### DS-K1T344EBWX-E1

Compatible con pantalla táctil LCD de 4.5 pulgadas, lente gran angular de 2 megapíxeles y módulo de lectura de tarjeta EM incorporado.

**Especificaciones Técnicas:**

- **Pantalla**: LCD táctil de 4.5 pulgadas
- **Cámara**: Lente gran angular de 2 megapíxeles
- **Capacidad**:
  - Máximo 3000 caras
  - Máximo 3000 tarjetas
- **Distancia de Reconocimiento**: 0.3 m a 1.5 m
- **Velocidad**: < 0.2 segundos por usuario
- **Exactitud**: ≥ 99%
- **Autenticación**: Rostro, tarjeta EM, PIN
- **Audio**: Bidireccional (compatible con software cliente, estación interior y principal)
- **Interfaz**: Botón físico y táctil
- **Configuración**: Web móvil y PC
- **Alimentación**: PoE estándar + 12VCC/1A para bloqueo de puerta

### DS-K1T341CMFW

Terminal con algoritmo de deep learning, pantalla táctil capacitiva de 4.3 pulgadas y lente dual gran angular de 2 MP.

**Especificaciones Técnicas:**

- **Pantalla**: Capacitiva táctil de 4.3 pulgadas
- **Cámara**: Dual-lens gran angular de 2 MP
- **Capacidad**:
  - Máximo 3000 caras
  - Máximo 3000 tarjetas
  - Máximo 3000 huellas dactilares
  - Máximo 150,000 eventos
- **Velocidad**: < 0.2 segundos por usuario
- **Autenticación**: Rostro, huella dactilar, tarjeta, etc.
- **Características Adicionales**: Detección de uso de máscara
- **Conexiones**: Wiegand protocol, RS-485
- **Audio**: Bidireccional (compatible con software cliente, estación interior y principal)

## API y Integración

Hikvision proporciona APIs HTTP para interactuar con sus dispositivos de control de acceso. La autenticación típica utiliza DIGEST authentication. Las operaciones comunes incluyen:

- Crear usuario
- Subir datos faciales
- Abrir puerta
- Verificar estado

### Endpoints Comunes

- **Crear Usuario**: `POST /ISAPI/AccessControl/UserInfo/Record`
- **Subir Rostro**: `PUT /ISAPI/Intelligent/FDLib/FDSetUp`
- **Abrir Puerta**: `PUT /ISAPI/AccessControl/RemoteControl/door`

### Autenticación

Usa autenticación DIGEST con usuario y contraseña configurados en el dispositivo.

### Configuración de Tiempos de Acceso

Los usuarios tienen tiempos de acceso limitados configurados mediante los campos `beginTime` y `endTime` en el objeto `Valid`. Los tiempos están en formato ISO 8601 (YYYY-MM-DDTHH:MM:SS).

**Campos importantes:**
- `beginTime`: Fecha y hora de inicio de validez del usuario (hora actual del ingreso)
- `endTime`: Fecha y hora de fin de validez del usuario (30 minutos después del inicio)
- `timeType`: Tipo de tiempo ('local' para zona horaria del dispositivo)

**Configuración actual:**
- Duración fija: **30 minutos** para todos los ingresos
- `beginTime`: Hora actual del registro
- `endTime`: Hora actual + 30 minutos

**Ejemplo de cálculo:**
```php
$beginTime = date('Y-m-d\TH:i:s'); // 2026-04-07T19:31:09
$endTime = date('Y-m-d\TH:i:s', strtotime("+30 minutes")); // 2026-04-07T20:01:09
```

## SDK de Hikvision

Hikvision proporciona SDKs para integración avanzada con sus dispositivos. Estos SDKs ofrecen mayor control y funcionalidades que las APIs HTTP básicas.

### Device Network SDK

El Device Network SDK (HCNetSDK) permite el desarrollo de aplicaciones cliente-servidor para interactuar con dispositivos Hikvision. Soporta plataformas Windows y Linux (32 y 64 bits).

**Características:**
- Control completo de dispositivos
- Streaming de video y audio
- Gestión de usuarios y permisos
- Configuración de parámetros
- Eventos en tiempo real

**Versiones Disponibles:**
- Windows 64-bit: V6.1.9.4_build20220412 [Descargar (404 MB)](https://www.hikvision.com/content/dam/hikvision/en/support/download/sdk/device-network-sdk/EN-HCNetSDKV6.1.9.4_build20220412_win64.zip)
- Windows 32-bit: V6.1.9.4_build20220412 [Descargar (195 MB)](https://www.hikvision.com/content/dam/hikvision/en/support/download/sdk/device-network-sdk/EN-HCNetSDKV6.1.9.4_build20220412_win32.zip)
- Linux 64-bit: V6.1.9.4_build20220412 [Descargar (180 MB)](https://www.hikvision.com/content/dam/hikvision/en/support/download/sdk/device-network-sdk/EN-HCNetSDKV6.1.9.4_build20220412_linux64.zip)
- Linux 32-bit: V6.1.9.4_build20220412 [Descargar (179 MB)](https://www.hikvision.com/content/dam/hikvision/en/support/download/sdk/device-network-sdk/EN-HCNetSDKV6.1.9.4_build20220412_linux32.zip)

### Web Development Kit

Kit de desarrollo web basado en ActiveX y NPAPI, con interfaces encapsuladas en JavaScript para integración en aplicaciones web (Browser/Server).

**Características:**
- Vista previa de video
- Reproducción
- Control PTZ
- Otras funciones de control

**Descarga:** [Web SDK 3.2 (32 MB)](https://www.hikvision.com/content/dam/hikvision/en/support/download/sdk/web-development-kit/websdk3.2.rar)

**Nota:** Este SDK es para desarrollo web, pero puede complementarse con las APIs HTTP para funcionalidades específicas de control de acceso.

## Ejemplos de Integración

### PHP - Crear Usuario con Tiempo de Acceso Limitado

```php
function crearUsuario($ip, $usuario, $password, $cedula, $nombres, $apellidos) {
    $url = "http://$ip/ISAPI/AccessControl/UserInfo/Record?format=json";
    
    // Calcular tiempos de acceso con duración fija de 30 minutos
    $beginTime = date('Y-m-d\TH:i:s'); // Hora actual
    $endTime = date('Y-m-d\TH:i:s', strtotime("+30 minutes")); // 30 minutos después
    
    $json = json_encode([
        'UserInfo' => [
            'employeeNo'   => $cedula,
            'name'         => $nombres . ' ' . $apellidos,
            'userType'     => 'visitor',
            'doorRight'    => '1',
            'RightPlan'    => [['doorNo' => 1, 'planTemplateNo' => '1']],
            'localUIRight' => false,
            'Valid'        => [
                'enable'    => true,
                'beginTime' => $beginTime,
                'endTime'   => $endTime,
                'timeType'  => 'local'
            ]
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
```

### PHP - Subir Datos Faciales

```php
function enviarRostro($ip, $usuario, $password, $cedula, $imagenBase64) {
    $url = "http://$ip/ISAPI/Intelligent/FDLib/FDSetUp?format=jpg";
    $xml = "<?xml version='1.0' encoding='UTF-8'?>
    <FDLib>
        <FD>
            <employeeNo>$cedula</employeeNo>
            <faceData>$imagenBase64</faceData>
        </FD>
    </FDLib>";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/xml']);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
```

### PHP - Abrir Puerta

```php
function abrirPuerta($ip, $usuario, $password, $puerta = 1) {
    $url = "http://$ip/ISAPI/AccessControl/RemoteControl/door/$puerta";
    $xml = "<?xml version='1.0' encoding='UTF-8'?>
    <RemoteControlDoor>
        <cmd>open</cmd>
    </RemoteControlDoor>";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/xml']);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
```

### JavaScript - Captura y Envío de Foto

```javascript
async function tomarFoto() {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    const video = document.createElement('video');
    video.srcObject = stream;
    await video.play();

    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    const imagenBase64 = canvas.toDataURL('image/jpeg').split(',')[1];

    // Enviar a servidor
    const formData = new FormData();
    formData.append('foto', imagenBase64);
    formData.append('cedula', document.getElementById('cedula').value);
    formData.append('nombres', document.getElementById('nombres').value);
    formData.append('apellidos', document.getElementById('apellidos').value);

    const response = await fetch('ajax/guardar_foto.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    console.log(result);
}
```

## Configuración del Dispositivo

1. Conecta el dispositivo a la red.
2. Accede a la interfaz web usando la IP del dispositivo.
3. Configura usuario y contraseña para API.
4. Habilita los servicios HTTP necesarios.

## Recursos Adicionales

### DS-K1T344EBWX-E1
- [Data Sheet](https://assets.hikvision.com/prd/normal/all/doc/m000126767/DS-K1T344EBWX-E1_Datasheet_20250725.pdf)
- [Manual de Usuario](https://www.hikvision.com/es-la/products/Access-Control-Products/Face-Recognition-Terminals/Value-Series/ds-k1t344ebwx-e1/)

### DS-K1T341CMFW
- [Data Sheet](https://assets.hikvision.com/prd/public/all/doc/m000059643/DS-K1T341CMFW_Datasheet_20240808.pdf)
- [Manual de Usuario](https://www.hikvision.com/en/products/Access-Control-Products/Face-Recognition-Terminals/Value-Series/ds-k1t341cmfw/)

- Documentación API de Hikvision (consulta el manual del dispositivo)
- [SDK Downloads](https://www.hikvision.com/us-en/support/download/sdk/)

## Notas de Implementación

- Asegúrate de que el dispositivo esté en la misma red que el servidor web.
- Usa HTTPS en producción para seguridad.
- Maneja errores de API apropiadamente (códigos de estado HTTP).
- La imagen facial debe estar en formato JPG y codificada en base64 para la API.