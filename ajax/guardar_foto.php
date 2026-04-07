<?php
// Guardar foto subida desde trade-view.php e integrar con API de acceso

// === CONFIGURACIÓN DEL DISPOSITIVO ===
$DEVICE_IN = '192.168.30.172';
$DEVICE_OUT = '192.168.30.173';
$USER = 'admin';
$PASS = 'Latinameric@123';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$targetDir = __DIR__ . "/../storage/trade/"; // Ruta donde guardarás las fotos
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        echo json_encode(['success' => false, 'error' => 'No se pudo crear el directorio de destino']);
        exit;
    }
}

// Verificar si se recibe el archivo por FILES (desde FormData)
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmpPath = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    
    // Validar que sea una imagen
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $tmpPath);
    finfo_close($finfo);
    
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($mimeType, $allowedMimes)) {
        echo json_encode(['success' => false, 'error' => 'Tipo de archivo no válido: ' . $mimeType]);
        exit;
    }
    
    // Generar nombre único
    $ext = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg';
    $newFilename = 'foto_' . date('Ymd_His') . '_' . uniqid() . '.' . $ext;
    $newPath = $targetDir . $newFilename;
    
    // Mover archivo a destino
    if (move_uploaded_file($tmpPath, $newPath)) {
        // Datos adicionales del formulario
        $cedula = $_POST['cedula'] ?? '';
        $nombres = $_POST['nombres'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        
        $results = [];
        
        // Si tenemos datos completos, enviar al API
        if ($cedula && $nombres) {
            $usuarioId = $cedula; // Usar cédula como ID único
            $nombreCompleto = trim($apellidos . ' ' . $nombres);
            
            // Calcular tiempos con duración fija de 30 minutos
            $beginTime = date('Y-m-d\TH:i:s'); // Hora actual
            $endTime = date('Y-m-d\TH:i:s', strtotime("+30 minutes")); // beginTime + 30 minutos
            
            // Criar usuario en el dispositivo
            $crearResp = crearUsuario($DEVICE_IP, $USER, $PASS, $usuarioId, $nombreCompleto, $beginTime, $endTime);
            $results['usuario'] = $crearResp;
            
            // Enviar rostro
            $rostroResp = enviarRostro($DEVICE_IP, $USER, $PASS, $usuarioId, $newPath);
            $results['rostro'] = $rostroResp;
            
            // Determinar éxito del API
            $apiSuccess = (!empty($crearResp['success']) || !empty($crearResp['RequestID'])) &&
                         (!empty($rostroResp['success']) || !empty($rostroResp['RequestID']));
        } else {
            $apiSuccess = false;
        }
        
        // Log para depuración
        $logFile = __DIR__ . '/../logs/api_log.txt';
        if (!is_dir(dirname($logFile))) mkdir(dirname($logFile), 0777, true);
        
        $logData = date('Y-m-d H:i:s') . " - Cedula: $cedula\n";
        $logData .= "  Usuario Response Code: " . ($results['usuario']['httpCode'] ?? 'N/A') . "\n";
        $logData .= "  Usuario Response: " . json_encode($results['usuario']) . "\n";
        $logData .= "  Rostro Response Code: " . ($results['rostro']['httpCode'] ?? 'N/A') . "\n";
        $logData .= "  Rostro Response: " . json_encode($results['rostro']) . "\n";
        $logData .= "  Archivo guardado: $newPath (tamaño: " . filesize($newPath) . " bytes)\n";
        $logData .= "---\n";
        
        file_put_contents($logFile, $logData, FILE_APPEND);
        
        echo json_encode([
            'success' => true, 
            'filename' => $newFilename,
            'cedula' => $cedula,
            'nombres' => $nombres,
            'api_results' => $results,
            'api_success' => $apiSuccess,
            'message' => 'Foto guardada' . ($apiSuccess ? ' y sincronizada con dispositivo' : '')
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo guardar el archivo']);
    }
} else {
    $errorMsg = $_FILES['foto']['error'] ?? 'desconocido';
    echo json_encode(['success' => false, 'error' => 'No se recibió foto válida. Error: ' . $errorMsg]);
}

// === FUNCIONES DEL API ===

function crearUsuario($deviceIp, $user, $pass, $id, $nombre, $beginTime, $endTime) {
    $url = "http://$deviceIp/ISAPI/AccessControl/UserInfo/Record?format=json";
    
    $body = json_encode([
        'UserInfo' => [
            'employeeNo'   => $id,
            'name'         => $nombre,
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

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
        CURLOPT_USERPWD        => "$user:$pass",
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['success' => false, 'error' => $curlError, 'httpCode' => $httpCode];
    }
    
    // HTTP 400 con subStatusCode "employeeNoAlreadyExist" es aceptable
    if ($httpCode == 400 && strpos($response, 'employeeNoAlreadyExist') !== false) {
        return ['success' => true, 'httpCode' => $httpCode, 'note' => 'Usuario ya existe', 'response' => $response];
    }
    
    return ['success' => true, 'httpCode' => $httpCode, 'response' => $response];
}

function enviarRostro($deviceIp, $user, $pass, $id, $rutaFoto) {
    $url = "http://$deviceIp/ISAPI/Intelligent/FDLib/FDSetUp?format=json";

    if (!file_exists($rutaFoto)) {
        return ['success' => false, 'error' => 'Archivo de foto no encontrado: ' . $rutaFoto];
    }

    // Validar tamaño (máximo 200 KB según especificaciones)
    $fileSize = filesize($rutaFoto);
    if ($fileSize > 200000) {
        return ['success' => false, 'error' => 'Archivo demasiado grande: ' . $fileSize . ' bytes. Máximo: 200000 bytes'];
    }

    // Leer la imagen como datos binarios
    $imageData = file_get_contents($rutaFoto);
    $boundary = '----HikvisionBoundary' . bin2hex(random_bytes(8));

    // Construir el body multipart según el ejemplo
    $faceRecord = json_encode([
        'faceLibType' => 'blackFD',
        'FDID'        => '1',
        'FPID'        => $id,
    ]);

    $body  = "--{$boundary}\r\n";
    $body .= "Content-Disposition: form-data; name=\"FaceDataRecord\"\r\n";
    $body .= "Content-Type: application/json\r\n\r\n";
    $body .= $faceRecord . "\r\n";

    $body .= "--{$boundary}\r\n";
    $body .= "Content-Disposition: form-data; name=\"img\"; filename=\"face.jpg\"\r\n";
    $body .= "Content-Type: image/jpeg\r\n\r\n";
    $body .= $imageData . "\r\n";

    $body .= "--{$boundary}--\r\n";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_POSTFIELDS     => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
        CURLOPT_USERPWD        => "$user:$pass",
        CURLOPT_HTTPHEADER     => [
            "Content-Type: multipart/form-data; boundary={$boundary}",
            'Expect:'
        ],
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_VERBOSE        => true
    ]);

    // Capturar verbose output para depuración
    $verbose = fopen(__DIR__ . '/../logs/curl_verbose.log', 'a');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    fclose($verbose);

    if ($curlError) {
        return ['success' => false, 'error' => $curlError, 'httpCode' => $httpCode];
    }
    
    return ['success' => true, 'httpCode' => $httpCode, 'response' => $response];
}

function abrirPuerta($deviceIp, $user, $pass, $doorNo = 1) {
    $url = "http://$deviceIp/ISAPI/AccessControl/RemoteControl/door/$doorNo";

    $body = json_encode([
        'RemoteControlDoor' => ['cmd' => 'open']
    ]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_POSTFIELDS     => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
        CURLOPT_USERPWD        => "$user:$pass",
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}