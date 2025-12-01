<?php
// --- Configuración de la cámara central ---
$ip   = "192.168.0.189";
$port = "81";
$user = "admin";
$pass = "Latinamerica135";

// --- Funciones PHP para acciones ISAPI ---
function enviarPeticion($url,$xml,$user,$pass){
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_USERPWD => "$user:$pass",
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_HTTPHEADER => ["Content-Type: application/xml"],
        CURLOPT_POSTFIELDS => $xml,
        CURLOPT_RETURNTRANSFER => true
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp;
}
function activarAudio($ip,$port,$user,$pass){
    $url = "http://$ip:$port/ISAPI/System/TwoWayAudio/channels/1/open";
    $xml = '<TwoWayAudioChannel><enabled>true</enabled></TwoWayAudioChannel>';
    return enviarPeticion($url,$xml,$user,$pass);
}
function desactivarAudio($ip,$port,$user,$pass){
    $url = "http://$ip:$port/ISAPI/System/TwoWayAudio/channels/1/open";
    $xml = '<TwoWayAudioChannel><enabled>false</enabled></TwoWayAudioChannel>';
    return enviarPeticion($url,$xml,$user,$pass);
}
function abrirBarrera($ip,$port,$user,$pass){
    $url = "http://$ip:$port/ISAPI/IO/outputs/1/trigger";
    $xml = '<IOPortData><outputState>high</outputState></IOPortData>';
    return enviarPeticion($url,$xml,$user,$pass);
}
function cerrarBarrera($ip,$port,$user,$pass){
    $url = "http://$ip:$port/ISAPI/IO/outputs/1/trigger";
    $xml = '<IOPortData><outputState>low</outputState></IOPortData>';
    return enviarPeticion($url,$xml,$user,$pass);
}

// --- Procesar acciones desde botones ---
if(isset($_GET['accion'])){
    switch($_GET['accion']){
        case 'audio_on':  activarAudio($ip,$port,$user,$pass); break;
        case 'audio_off': desactivarAudio($ip,$port,$user,$pass); break;
        case 'relay_on':  abrirBarrera($ip,$port,$user,$pass); break;
        case 'relay_off': cerrarBarrera($ip,$port,$user,$pass); break;
    }
}

// --- Procesar registro manual ---
if(isset($_POST['placa'])){
    $placa = $_POST['placa'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $obs    = $_POST['observacion'];
    $fecha  = date("Y-m-d H:i:s");

    // Guardar en CSV (puedes cambiar a MySQL)
    $linea = "$fecha,$placa,$cedula,$nombre,$obs\n";
    file_put_contents("visitas.csv",$linea,FILE_APPEND);
    echo "<p style='color:green'>Visita registrada correctamente</p>";
}

// --- OCR con Tesseract y extracción de placa ---
if(isset($_POST['imagen_base64'])){
    $imgData = $_POST['imagen_base64'];
    $imgData = str_replace('data:image/jpeg;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    $data = base64_decode($imgData);

    $file = "captura_ocr.jpg";
    file_put_contents($file, $data);

    // Ejecutar Tesseract (idioma inglés+español)
    $cmd = "tesseract $file stdout -l eng+spa";
    $texto = shell_exec($cmd);

    // Regex para placas (ejemplo: ABC-1234, ABC1234, ABC 1234)
    $patron = '/[A-Z]{3}[- ]?[0-9]{3,4}/';
    preg_match($patron, strtoupper($texto), $matches);
    $placa = $matches[0] ?? "No detectada";

    // Guardar automáticamente en CSV
    $fecha = date("Y-m-d H:i:s");
    $linea = "$fecha,$placa,OCR,OCR,Detectada por OCR\n";
    file_put_contents("visitas.csv",$linea,FILE_APPEND);

    echo json_encode([
        "ocr_texto"=>$texto,
        "placa"=>$placa
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Visitas</title>
  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <style>
    video { width: 320px; height: 180px; margin:5px; border:1px solid #ccc; }
    canvas { border:1px solid #333; margin-top:10px; }
  </style>
</head>
<body>
  <h2>Visualización Cámaras</h2>
  <div>
    <video id="cam1" controls autoplay></video>
    <video id="cam2" controls autoplay></video>
    <video id="cam3" controls autoplay></video>
    <video id="camCentral" controls autoplay></video>
  </div>

  <script>
    function cargarCam(id,url){
      if(Hls.isSupported()){
        var video = document.getElementById(id);
        var hls = new Hls();
        hls.loadSource(url);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED,function(){ video.play(); });
      }
    }
    cargarCam("cam1","http://192.168.0.10:8888/cam1/index.m3u8");
    cargarCam("cam2","http://192.168.0.10:8888/cam2/index.m3u8");
    cargarCam("cam3","http://192.168.0.10:8888/cam3/index.m3u8");
    cargarCam("camCentral","http://192.168.0.10:8888/cam1/index.m3u8");
  </script>

  <h2>Controles</h2>
  <button onclick="location.href='?accion=audio_on'">Activar Audio</button>
  <button onclick="location.href='?accion=audio_off'">Desactivar Audio</button>
  <button onclick="location.href='?accion=relay_on'">Abrir Barrera</button>
  <button onclick="location.href='?accion=relay_off'">Cerrar Barrera</button>

  <h2>Registro Manual de Visitas</h2>
  <form method="post">
    <label>Placa:</label><input type="text" name="placa" required><br>
    <label>Cédula:</label><input type="text" name="cedula" required><br>
    <label>Nombre:</label><input type="text" name="nombre" required><br>
    <label>Observación:</label><textarea name="observacion"></textarea><br>
    <button type="submit">Registrar</button>
  </form>

  <h2>OCR desde Cámara Central</h2>
  <button onclick="capturar()">Capturar Imagen y OCR</button>
  <canvas id="canvas" width="640" height="360"></canvas>
  <div id="ocrResultado"></div>

  <script>    
    function capturar(){
      var video = document.getElementById('camCentral');
      var canvas = document.getElementById('canvas');
      var ctx = canvas.getContext('2d');
      ctx.drawImage(video,0,0,canvas.width,canvas.height);
      var dataURL = canvas.toDataURL('image/jpeg');

      let formData = new FormData();
      formData.append("imagen_base64", dataURL);

      fetch("ajax/nuevos.php", {
        method: "POST",
        body: formData
      })
      .then(resp => resp.json())
      .then(data => {
        document.getElementById("ocrResultado").innerHTML =
          "<b>Texto OCR:</b> " + data.ocr_texto + "<br>" +
          "<b>Placa detectada:</b> " + data.placa + "<br>" +
          "<b>Archivo guardado:</b> ajax/captura/" + data.archivo;
      });
    }
  </script>
</body>
</html>