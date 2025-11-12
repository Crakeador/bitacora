<?php
// storage/fotos/guardar_foto.php
// Asegura permisos adecuados en el servidor para este directorio

$targetDir = __DIR__ . "/public_html/storage/trade/"; // Ruta donde guardarás las fotos
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

// Validar que exista el archivo
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No se recibio la foto']);
    exit;
}

// Validar tipo MIME permitido
$allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
$mime = mime_content_type($_FILES['foto']['tmp_name']);
if (!in_array($mime, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido']);
    exit;
}

// Generar nombre único
$ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
$ext = strtolower($ext ?: 'jpg');
$filename = uniqid('foto_', true) . "." . $ext;

// Mover archivo
$tmpPath = $_FILES['foto']['tmp_name'];
$destPath = rtrim($targetDir, '/') . '/' . $filename;

if (move_uploaded_file($tmpPath, $destPath)) {
    echo json_encode(['success' => true, 'filename' => $filename]);
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo mover el archivo']);
    exit;
}
