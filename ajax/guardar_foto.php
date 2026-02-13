<?php
// Asegura permisos adecuados en el servidor para este directorio

$targetDir = __DIR__ . "/../storage/captura/"; // Ruta donde guardarás las fotos
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'No se pudo crear el directorio de destino']);
        exit;
    }
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Verificar si se recibe la foto por POST (Base64)
if (isset($_POST['foto'])) {
    $data = $_POST['foto'];
    
    // Procesar la cadena Base64 (quitar el encabezado "data:image/png;base64,")
    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
        $data = substr($data, strpos($data, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif
        
        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            echo json_encode(['success' => false, 'error' => 'Tipo de archivo no válido']);
            exit;
        }

        $data = base64_decode($data);

        if ($data === false) {
            echo json_encode(['success' => false, 'error' => 'Fallo al decodificar base64']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Formato de datos no válido']);
        exit;
    }

    // Generar nombre único y guardar
    $filename = 'captura_' . date('Ymd_His') . '_' . uniqid() . '.' . $type;
    $filepath = $targetDir . $filename;

    if (file_put_contents($filepath, $data)) {
        echo json_encode(['success' => true, 'filename' => $filename]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo escribir el archivo en el servidor']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se recibió la variable foto por POST']);
}
