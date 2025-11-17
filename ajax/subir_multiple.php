<?php
session_start();
$datos = json_decode(file_get_contents("php://input"), true);

$idpuesto = 8;
$idperson = $_SESSION['user_id'] ?? null;
$proceso = 'Observacion';
$tipo = 'Visita';
$idcodigo = $datos['idcodigo'] ?? '0';
$fecha = date("Y-m-d H:i:s");
$placa = $datos['placa'] ?? '';
$cedula = $datos['cedula'] ?? '';
$nombres = $datos['nombres'] ?? '';
$idresidente = $datos['idresidente'] ?? '';
$telefono = $datos['telefono'] ?? '';
$imagenes = $datos['imagenes'] ?? [];
$observacion = $datos['observacion'] ?? '';
$texto_documento = $datos['texto_documento'] ?? '';
$is_active = 1;
$usuario_log = $_SESSION['name'] ?? 'toten'; 
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

$conn = new mysqli('localhost', 'root', 'MyNewPass', 'bitacora');
if ($conn->connect_error) {
    http_response_code(500);
    echo "Error de conexión";
    exit;
}
//echo "Conexión exitosa. ";
$stmt = $conn->prepare("INSERT INTO bitacora (idpuesto, idperson, idresidente, fecha, proceso, tipo, observacion, is_active, usuario_log, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$desc = $observacion . ' | OCR: ' . $texto_documento;
$stmt->bind_param("ssssssssss", $idpuesto, $idperson, $idresidente, $fecha, $proceso, $tipo, $observacion, $is_active, $usuario_log, $ip);

$queryDebug = sprintf(
    "INSERT INTO bitacora (idpuesto, idperson, idresidente, fecha, proceso, tipo, observacion, is_active, usuario_log, ip) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
    $idpuesto, $idperson, $idresidente, $fecha, $proceso, $tipo, $desc, $is_active, $usuario_log, $ip
);
//echo "Query armado: " . $queryDebug;

$success = $stmt->execute();

if ($success) {
    $padre = $conn->insert_id;
    //echo "Registro principal insertado correctamente con ID: " . $padre;
    //echo "ID Codigo recibido: " . $idcodigo;

    if ($idcodigo != '0') {
        $stmt2 = $conn->prepare("UPDATE autorizacion SET is_active = 0, idbitacora = ?, entrada = ? WHERE id = ?");
        
        $queryDebug = sprintf(
            "UPDATE autorizacion SET is_active = 0, idbitacora = '%s', entrada = '%s' WHERE id = '%s'",
            $padre, $fecha, $idcodigo
        );
        //echo "Query armado: " . $queryDebug;

        $stmt2->bind_param("sss", $padre, $fecha, $idcodigo);
        $success2 = $stmt2->execute();
        if ($success2) {
            //echo "Código QR actualizado correctamente.";
        } else {
            http_response_code(500);
            echo "Error al actualizar el código QR: " . $stmt2->error;
            exit;
        }
    }
} else {
    http_response_code(500);
    echo "Error al insertar registro principal: " . $stmt->error;
    exit;
}

foreach ($imagenes as $img) {
    //echo "Procesando imagen: ".$img['tipo'].". ";
    $imagen = str_replace('data:image/jpeg;base64,', '', $img['imagen']);
    $imagen = str_replace(' ', '+', $imagen);
    $binario = base64_decode($imagen);

    $tipo = $img['tipo'] ?? 'desconocido';
    $nombre = $tipo . '_' . time() . '_' . rand(1000,9999) . '.jpg';
    $ruta = '/var/www/latin.near-solution.com/public_html/storage/visitas/' . $nombre;
    file_put_contents($ruta, $binario);

    $stmt = $conn->prepare("INSERT INTO fotos (idpadre, nombre_archivo, descripcion, tipo) VALUES (?, ?, ?, ?)");
    $desc = $observacion . ' | OCR: ' . $texto_documento;
    $stmt->bind_param("ssss", $padre, $nombre, $desc, $tipo);
    $success = $stmt->execute();
    
    if ($success) {
        //echo "Imagen $nombre insertada correctamente. ";
    } else {
        http_response_code(500);
        echo "Error al insertar imagen $nombre";
        exit;
    }
}

echo "Captura y registro completados.";
