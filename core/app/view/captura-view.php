<?php
// Lógica de Backend (PHP) para guardar la imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Directorio de destino
    $baseDir = __DIR__;
    $folder = '/storage/captura/';
    $targetDir = $baseDir . $folder;

    // Crear el directorio si no existe
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            echo json_encode(['success' => false, 'error' => 'No se pudo crear el directorio de destino']);
            exit;
        }
    }

    // Obtener los datos JSON enviados por JS
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['imagen'])) {
        $data = $input['imagen'];

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
            // Retornar la URL relativa para visualizar
            $url = '.' . $folder . $filename;
            echo json_encode(['success' => true, 'url' => $url, 'filename' => $filename]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo escribir el archivo en el servidor']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No se recibieron datos de imagen']);
    }
    exit; // Terminar ejecución PHP aquí para no mostrar el HTML
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Cámara USB</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 20px auto; text-align: center; background-color: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        select, button { padding: 10px; margin: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        #video-container { position: relative; margin: 20px auto; width: 100%; max-width: 640px; background: #000; border-radius: 4px; overflow: hidden; }
        video { width: 100%; display: block; }
        #resultado { margin-top: 20px; padding: 15px; border-radius: 5px; display: none; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        img.preview { max-width: 100%; height: auto; margin-top: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📸 Captura y Guardado de Foto</h2>
        
        <div>
            <label for="listaDeDispositivos">Cámara:</label>
            <select id="listaDeDispositivos"></select>
        </div>

        <div id="video-container">
            <video id="video" autoplay playsinline></video>
        </div>
        
        <button id="boton">Tomar Foto y Guardar</button>
        
        <!-- Canvas oculto para procesar la imagen -->
        <canvas id="canvas" style="display: none;"></canvas>

        <div id="resultado"></div>
    </div>

    <script>
        const $video = document.querySelector("#video");
        const $canvas = document.querySelector("#canvas");
        const $boton = document.querySelector("#boton");
        const $listaDeDispositivos = document.querySelector("#listaDeDispositivos");
        const $resultado = document.querySelector("#resultado");
        let streamActual = null;

        // Función para iniciar la cámara seleccionada
        const mostrarStream = (deviceId) => {
            if (streamActual) {
                streamActual.getTracks().forEach(track => track.stop());
            }
            const constraints = {
                video: { deviceId: deviceId ? { exact: deviceId } : undefined, width: 1280, height: 720 }
            };
            navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    streamActual = stream;
                    $video.srcObject = stream;
                })
                .catch(err => alert("Error al acceder a la cámara: " + err.message));
        };

        // Obtener cámaras y llenar el select
        navigator.mediaDevices.getUserMedia({ video: true }) // Pedir permiso primero
            .then(stream => {
                stream.getTracks().forEach(track => track.stop()); // Detener stream de prueba
                return navigator.mediaDevices.enumerateDevices();
            })
            .then(dispositivos => {
                const videos = dispositivos.filter(d => d.kind === "videoinput");
                $listaDeDispositivos.innerHTML = "";
                videos.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.deviceId;
                    option.text = d.label || `Cámara ${$listaDeDispositivos.length + 1}`;
                    $listaDeDispositivos.appendChild(option);
                });
                if (videos.length > 0) mostrarStream(videos[0].deviceId);
            })
            .catch(err => console.error("Error permisos:", err));

        // Cambiar cámara al seleccionar otra
        $listaDeDispositivos.onchange = () => mostrarStream($listaDeDispositivos.value);

        // Capturar y enviar
        $boton.onclick = () => {
            $canvas.width = $video.videoWidth;
            $canvas.height = $video.videoHeight;
            $canvas.getContext("2d").drawImage($video, 0, 0);
            
            const fotoBase64 = $canvas.toDataURL("image/png");
            $resultado.style.display = 'block';
            $resultado.className = '';
            $resultado.innerHTML = "Enviando...";

            fetch(window.location.href, {
                method: "POST",
                body: JSON.stringify({ imagen: fotoBase64 }),
                headers: { "Content-Type": "application/json" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    $resultado.className = 'success';
                    $resultado.innerHTML = `<strong>¡Foto guardada!</strong><br>Ver en: <a href="${data.url}" target="_blank">${data.filename}</a><br><img src="${data.url}" class="preview">`;
                } else {
                    $resultado.className = 'error';
                    $resultado.innerHTML = "Error: " + data.error;
                }
            })
            .catch(err => {
                $resultado.className = 'error';
                $resultado.innerHTML = "Error de red: " + err.message;
            });
        };
    </script>
</body>
</html>