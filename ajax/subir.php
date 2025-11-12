<?php
$datos = json_decode(file_get_contents("php://input"), true);
$imagen = $datos['imagen'];
$descripcion = $datos['descripcion'];

if (!$imagen || !$descripcion) {
    http_response_code(400);
    echo "Datos incompletos: " . $descripcion;
    exit;
}

// Extraer base64
$imagen = str_replace('data:image/jpeg;base64,', '', $imagen);
$imagen = str_replace(' ', '+', $imagen);
$binario = base64_decode($imagen);

// Guardar archivo
$nombre = 'foto_' . time() . '.jpg';
$ruta = '/var/www/latin.near-solution.com/public_html/storage/fotos/' . $nombre;

echo "Ruta: " . $ruta."\n"; // Línea de depuración
file_put_contents($ruta, $binario);

// Guardar en MySQL
$conn = new mysqli('localhost', 'root', 'MyNewPass', 'bitacora');
if ($conn->connect_error) {
    http_response_code(500);
    echo "Error de conexión";
    exit;
}

$stmt = $conn->prepare("INSERT INTO fotos (nombre_archivo, descripcion) VALUES (?, ?)");
$stmt->bind_param("ss", $nombre, $descripcion);
$stmt->execute();

echo "Foto guardada correctamente";
?>
