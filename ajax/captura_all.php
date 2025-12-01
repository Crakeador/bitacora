<?php
session_start();
header('Content-Type: application/json');

//Ingreso de las visitas y captura de imágenes desde cámaras IP
$idpuesto = 8;
$idperson = $_SESSION['user_id'] ?? null;
$proceso = 'Observacion';
$tipo = 'Visita';
$idcodigo = $_POST['idcodigo'] ?? '0';
$fecha = date("Y-m-d H:i:s");
$placa = $_POST['placa'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$nombres = $_POST['nombres'] ?? '';
$idresidente = $_POST['idresidente'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$imagenes = $_POST['imagenes'] ?? [];
$observacion = $_POST['observacion'] ?? '';
$puerta = 1; // Entrada
$texto_documento = $_POST['texto_documento'] ?? '';
$usuario_log = $_SESSION['name'] ?? 'Toten'; 
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$is_active = 1;

if (trim($cedula) === '' || trim($nombres) === '' || trim($observacion) === '') {
  echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
  exit;
}

$streams = [
  'cam1' => ['url' => 'http://192.168.0.10:8888/cam1/index.m3u8', 'ubicacion' => 'Entrada'],
  'cam2' => ['url' => 'http://192.168.0.10:8888/cam2/index.m3u8', 'ubicacion' => 'Patio'],
  'cam3' => ['url' => 'http://192.168.0.10:8888/cam3/index.m3u8', 'ubicacion' => 'Garaje']
];

$pdo = new PDO("mysql:host=localhost;dbname=seguridad", "usuario", "clave");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo "Conexión exitosa. ";
$stmt = $pdo->prepare("INSERT INTO visitas (idpuesto, idperson, idresidente, fecha, proceso, tipo, observacion, puerta, is_active, usuario_log, ip) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$desc = $observacion . ' | OCR: ' . $texto_documento;
$stmt->bind_param("sssssssssss", $idpuesto, $idperson, $idresidente, $fecha, $proceso, $tipo, $observacion, $puerta, $is_active, $usuario_log, $ip);
$queryDebug = sprintf(
    "INSERT INTO visitas (idpuesto, idperson, idresidente, fecha, proceso, tipo, observacion, puerta, is_active, usuario_log, ip) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
    $idpuesto, $idperson, $idresidente, $fecha, $proceso, $tipo, $desc, $puerta, $is_active, $usuario_log, $ip
);
echo json_encode(["success" => true, "message" => $queryDebug]);
$success = $stmt->execute();

if ($success) {
  $padre = $pdo->lastInsertId();
  echo json_encode(["success" => true, "message" => "Registro principal insertado correctamente con ID: " . $padre. " ID Codigo recibido: " . $idcodigo]);

  if ($idcodigo != '0') {
      $stmt2 = $pdo->prepare("UPDATE autorizacion SET is_active = 0, idbitacora = ?, entrada = ? WHERE id = ?");
      
      $queryDebug = sprintf(
          "UPDATE autorizacion SET is_active = 0, idbitacora = '%s', entrada = '%s' WHERE id = '%s'",
          $padre, $fecha, $idcodigo
      );
      echo json_encode(["success" => true, "message" => $queryDebug]);

      $stmt2->bind_param("sss", $padre, $fecha, $idcodigo);
      $success2 = $stmt2->execute();
      if ($success2) {
          echo json_encode(["success" => true, "message" => "Código QR actualizado correctamente."]);
      } else {
          echo json_encode(["success" => false, "message" => "Error al actualizar el código QR: " . $stmt2->error]);
      }
  }
} else {
    echo json_encode(["error" => false, "message" => "Error al insertar registro principal: " . $stmt->error]);
}

$errores = [];
foreach ($streams as $cam => $info) {
  $filename = "uploads/{$cam}_" . time() . ".jpg";
  exec("ffmpeg -y -i {$info['url']} -frames:v 1 -q:v 2 $filename 2>&1", $output, $status);

  if ($status === 0 && file_exists($filename)) {
    $ocr = ($cam === 'cam1') ? shell_exec("tesseract $filename stdout -l spa") : null;
    $valido = ($cam === 'cam1') ? (
      strpos($ocr, $cedula) !== false && stripos($ocr, $nombres) !== false
    ) : null;

    $stmt = $pdo->prepare("INSERT INTO capturas (imagen, ubicacion, observacion, cedula, nombres, ocr, valido) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$filename, $info['ubicacion'], $observacion, $cedula, $nombres, $ocr, $valido]);
  } else {
    $errores[] = $info['ubicacion'];
  }
}

if (empty($errores)) {
  echo json_encode(["success" => true, "message" => "Capturas realizadas y validadas correctamente."]);
} else {
  echo json_encode([
    "success" => false,
    "message" => "Error al capturar: " . implode(', ', $errores)
  ]);
}
?>
