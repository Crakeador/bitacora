<?php
session_start();
$datos = json_decode(file_get_contents("php://input"), true);
 
if(isset($_POST['imagen_base64'])){
    $imgData = $_POST['imagen_base64'];
    $imgData = str_replace('data:image/jpeg;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    $data = base64_decode($imgData);

    
    echo json_encode(['success' => false, 'error' => 'Archivo recibido. Tamaño: ' . strlen($data) . ' bytes.']);
    // Guardar imagen en servidor
    // Ruta destino en ajax/captura
    $fecha = date("Ymd_His");
    $file = __DIR__ . "/store/captura/captura_$fecha.jpg";

    file_put_contents($file, $data);

    // Ejecutar OCR con Tesseract
    $cmd = "tesseract $file stdout -l eng+spa";
    $texto = shell_exec($cmd);

    echo json_encode(['success' => false, 'error' => $texto]);
    // Regex para placas
    $patron = '/[A-Z]{3}[- ]?[0-9]{3,4}/';
    preg_match($patron, strtoupper($texto), $matches);
    $placa = $matches[0] ?? "No detectada";

    // Guardar en MySQL
    $db_host = "localhost";
    $db_user = "usuario_mysql";
    $db_pass = "clave_mysql";
    $db_name = "visitasdb";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if(!$conn->connect_error){
        $fechaSQL = date("Y-m-d H:i:s");
        $cedula = "OCR";
        $nombre = "OCR";
        $obs    = "Detectada por OCR";

        $stmt = $conn->prepare("INSERT INTO visitas (fecha, placa, cedula, nombre, observacion) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fechaSQL, $placa, $cedula, $nombre, $obs);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode([
        "ocr_texto"=>$texto,
        "placa"=>$placa,
        "archivo"=>basename($file)
    ]);
    exit;
}
?>
