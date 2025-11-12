<?php
$datos = json_decode(file_get_contents("php://input"), true);

$placa = $datos['placa'] ?? '';
$cedula = $datos['cedula'] ?? '';
$nombres = $datos['nombres'] ?? '';
$residente = $datos['residente'] ?? '';
$manzana = $datos['manzana'] ?? '';
$villa = $datos['villa'] ?? '';
$telefono = $datos['telefono'] ?? '';
$imagenes = $datos['imagenes'] ?? [];
$observacion = $datos['observacion'] ?? '';
$texto_documento = $datos['texto_documento'] ?? '';

$conn = new mysqli('localhost', 'root', 'MyNewPass', 'bitacora');
if ($conn->connect_error) {
    http_response_code(500);
    echo "Error de conexión";
    exit;
}

$stmt = $conn->prepare("INSERT INTO fotos (manzana, villa, nombre_archivo, descripcion, tipo_camara) VALUES (?, ?, ?, ?, ?)");
$desc = $observacion . ' | OCR: ' . $texto_documento;
$stmt->bind_param("sssss", $manzana, $villa, $nombre, $desc, $tipo);
$success = $stmt->execute();

if ($success) {
    $nuevo = $conn->insert_id;
}
foreach ($imagenes as $img) {
    $imagen = str_replace('data:image/jpeg;base64,', '', $img['imagen']);
    $imagen = str_replace(' ', '+', $imagen);
    $binario = base64_decode($imagen);

    $tipo = $img['tipo'] ?? 'desconocido';
    $nombre = $tipo . '_' . time() . '_' . rand(1000,9999) . '.jpg';
    $ruta = '/var/www/latin.near-solution.com/public_html/storage/fotos/' . $nombre;
    file_put_contents($ruta, $binario);

    $stmt = $conn->prepare("INSERT INTO fotos (idpadre, manzana, villa, nombre_archivo, descripcion, tipo_camara) VALUES (?, ?, ?, ?, ?)");
    $desc = $observacion . ' | OCR: ' . $texto_documento;
    $stmt->bind_param("sssss", $nuevo, $manzana, $villa, $nombre, $desc, $tipo);
    $stmt->execute();
}

echo "Captura y registro completados.";
