<?php
  $hoy = date("d-m-Y");
  $fecha = date("Y-m-d");
?>
<style>
  .vista-principal { display: flex; gap: 20px; }  
  .pregunta { background: #fff; padding: auto; padding-right: 30px; box-shadow: 0 0 5px #ccc; }
  .panel { background: #fff; padding: 10px; box-shadow: 0 0 5px #ccc; }
  video { border: 1px solid #333; }
  textarea { width: 100%; margin-top: 10px; }
</style>
<div class="row mb-3"> 
  <div class="col-md-8 themed-grid-col"> 
    <div class="pb-3">
      <div class="panel" id="camara0">
        <div class="vista-principal">  
          <video id="videoDocumento" style="border: 1px solid #333; width: 640px; height: 480px;" autoplay></video>
          <canvas id="canvasDocumento" style="display:none;"></canvas>
        </div>
      </div>
    </div> 
    <div class="row text-center"> 
      <div class="col-md-4 themed-grid-col">
        <div class="panel" id="camara1">
          <video id="video1" style="border: 1px solid #333; width: 320px; height: 240px;" autoplay></video>
          <canvas id="canvas1" style="display:none;"></canvas>
        </div>
      </div> 
      <div class="col-md-4 themed-grid-col">
        <div class="panel" id="camara2">
          <video id="video2" style="border: 1px solid #333; width: 320px; height: 240px;" autoplay></video>
          <canvas id="canvas2" style="display:none;"></canvas>
        </div>
      </div> 
      <div class="col-md-4 themed-grid-col">
        <div class="panel" id="camara3">
          <video id="video3" style="border: 1px solid #333; width: 320px; height: 240px;" autoplay></video>
          <canvas id="canvas3" style="display:none;"></canvas>
        </div>
      </div> 
    </div> 
  </div> 
  <div class="col-md-4 pregunta">
    <div class="form-group">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked>
        <label class="form-check-label" for="inlineRadio1">Entrada</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
        <label class="form-check-label" for="inlineRadio2">Salida</label>
      </div>
    </div>    
    <div class="form-group">
      <div class="input-group date form_datetime col-md-12 col-sm-12">
        <input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="placa">Placa de Vehiculo</label>
      <input type="text" class="form-control" id="placa" name="placa" placeholder="HPH-0022">
    </div>
    <div class="form-group">
      <label for="cedula">Cedula o RUC</label>
      <input type="text" class="form-control" id="cedula" name="cedula" placeholder="99999999999">
    </div>
    <div class="form-group">
      <label for="nombres">Nombres Completos</label>
      <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Juan Perez">
    </div>
    <div class="form-group">
      <label for="residente">Residente/Familia</label>
      <input type="text" class="form-control" id="residente" name="residente" placeholder="Familia Zalazar">
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="manzana">Manzana</label>
        <input type="text" class="form-control" id="manzana" name="manzana" placeholder="MZ-001">
      </div>
      <div class="form-group col-md-4">
        <label for="villa">Villa</label>
        <input type="text" class="form-control" id="villa" name="villa" placeholder="2544">
      </div>      
      <div class="form-group col-md-4">
        <label for="telefono">Teléfono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="0999999999">
      </div>
    </div>
    <textarea id="observacion" name="observacion" placeholder="Observación general" rows="3"></textarea>
    <button onclick="capturarTodo()">Capturar y Guardar</button>
    </br></br>
    <!-- Botones de reproducción -->    
    <div class="btn-group">
      <button class="btn btn-primary" onclick="playAudio('assets/media/saludo.mp3')">
        <i class="fa fa-play"></i> Saludo
      </button>
      <button class="btn btn-warning" onclick="playAudio('assets/media/cedula.mp3')">
        <i class="fa fa-play"></i> Cedula
      </button>
      <button class="btn btn-info" onclick="playAudio('assets/media/casco.mp3')">
        <i class="fa fa-play"></i> Casco
      </button>
      <button class="btn btn-primary" onclick="playAudio('assets/media/indique.mp3')">
        <i class="fa fa-play"></i> Indique
      </button>
      <button class="btn btn-success" onclick="playAudio('assets/media/avance.mp3')">
        <i class="fa fa-play"></i> Avance
      </button>
      <button class="btn btn-danger" onclick="stopAudio()">
        <i class="fa fa-stop"></i> Detener
      </button>
    </div>    
    </br></br>
    <!-- Reproductor de audio oculto -->
    <audio id="audioPlayer" controls style="display:none;"></audio>
    </br></br></br></br></br>
  </div> 
</div>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.5/dist/tesseract.min.js"></script>
<script type='text/javascript'>
  function playAudio(file) {
    const player = document.getElementById('audioPlayer');
    player.src = file;
    player.style.display = 'block';
    player.play();
  }

  function stopAudio() {
    const player = document.getElementById('audioPlayer');
    player.pause();
    player.currentTime = 0;
  }

  function aplicarFiltros(canvas) {
    const ctx = canvas.getContext('2d');
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;

    // Escala de grises
    for (let i = 0; i < data.length; i += 4) {
      const r = data[i], g = data[i + 1], b = data[i + 2];
      const gris = 0.3 * r + 0.59 * g + 0.11 * b;
      data[i] = data[i + 1] = data[i + 2] = gris;
    }

    // Contraste
    const factor = 1.2;
    for (let i = 0; i < data.length; i += 4) {
      data[i] = truncar((data[i] - 128) * factor + 128);
      data[i + 1] = truncar((data[i + 1] - 128) * factor + 128);
      data[i + 2] = truncar((data[i + 2] - 128) * factor + 128);
    }

    ctx.putImageData(imageData, 0, 0);
  }

  function truncar(valor) {
    return Math.min(255, Math.max(0, valor));
  }

  function capturarTodo() {
    const imagenes = [];
    const tipos = ['rostro', 'vehículo', 'documento'];

    for (let i = 1; i <= 3; i++) {
      const video = document.getElementById('video' + i);
      const canvas = document.getElementById('canvas' + i);
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      const imagen = canvas.toDataURL('image/jpeg');
      imagenes.push({ imagen, tipo: tipos[i - 1] });
    }
    
    const placa = document.getElementById('placa').value;
    const cedula = document.getElementById('cedula').value;
    const nombres = document.getElementById('nombres').value;
    const residente = document.getElementById('residente').value;
    const manzana = document.getElementById('manzana').value;
    const villa = document.getElementById('villa').value;
    const telefono = document.getElementById('telefono').value;
    const observacion = document.getElementById('observacion').value;

    // OCR sobre imagen del documento (canvas3)
    const canvasDoc = document.getElementById('canvas3');
    aplicarFiltros(canvasDoc);
    const imagenFiltrada = canvasDoc.toDataURL('image/jpeg');

    Tesseract.recognize(imagenFiltrada, 'spa')
      .then(result => {
        const textoExtraido = result.data.text;
        alert("Texto OCR: " + textoExtraido);

        // Enviar todo al backend
        fetch('ajax/subir_multiple.php', {
          method: 'POST',
          body: JSON.stringify({
            imagenes, placa, cedula, nombres, residente,
            manzana, villa, telefono,
            observacion,
            texto_documento: textoExtraido
          }),
          headers: { 'Content-Type': 'application/json' }
        })
        .then(res => res.text())
        .then(msg => alert(msg)); 
      })
      .catch(err => {
        console.error("Error OCR:", err);
        alert("Error al procesar OCR");
      });
  }
</script>
<script>  
  $(document).ready(function(event) {
    let streamDocumento;
    let stream1, stream2, stream3;

    function iniciarCamaraDocumento(deviceId) {
      navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } } })
        .then(stream => {
          streamDocumento = stream;
          document.getElementById('videoDocumento').srcObject = stream;
        });
    }

    // Cámara 1
    function iniciarCamara1(deviceId) {
      navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } } })
        .then(stream => {
          stream1 = stream;
          document.getElementById('video1').srcObject = stream;
        });
    }

    function capturarCamara1() {
      const canvas = document.getElementById('canvas1');
      const ctx = canvas.getContext('2d');
      ctx.drawImage(document.getElementById('video1'), 0, 0, canvas.width, canvas.height);
      const imagen = canvas.toDataURL('image/jpeg');
      const descripcion = document.getElementById('descripcion1').value;

      fetch('subir.php', {
        method: 'POST',
        body: JSON.stringify({ imagen, descripcion, camara: 1 }),
        headers: { 'Content-Type': 'application/json' }
      }).then(res => res.text()).then(msg => alert(msg));
    }

    // Cámara 2
    function iniciarCamara2(deviceId) {
      navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } } })
        .then(stream => {
          stream2 = stream;
          document.getElementById('video2').srcObject = stream;
        });
    }

    function capturarCamara2() {
      const canvas = document.getElementById('canvas2');
      const ctx = canvas.getContext('2d');
      ctx.drawImage(document.getElementById('video2'), 0, 0, canvas.width, canvas.height);
      const imagen = canvas.toDataURL('image/jpeg');
      const descripcion = document.getElementById('descripcion2').value;

      fetch('subir.php', {
        method: 'POST',
        body: JSON.stringify({ imagen, descripcion, camara: 2 }),
        headers: { 'Content-Type': 'application/json' }
      }).then(res => res.text()).then(msg => alert(msg));
    }

    // Cámara 3
    function iniciarCamara3(deviceId) {
      navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } } })
        .then(stream => {
          stream3 = stream;
          document.getElementById('video3').srcObject = stream;
        });
    }

    function capturarCamara3() {
      const canvas = document.getElementById('canvas3');
      const ctx = canvas.getContext('2d');
      ctx.drawImage(document.getElementById('video3'), 0, 0, canvas.width, canvas.height);
      const imagen = canvas.toDataURL('image/jpeg');
      const descripcion = document.getElementById('descripcion3').value;

      fetch('subir.php', {
        method: 'POST',
        body: JSON.stringify({ imagen, descripcion, camara: 3 }),
        headers: { 'Content-Type': 'application/json' }
      }).then(res => res.text()).then(msg => alert(msg));
    }

    // Enumerar y asignar cámaras
    navigator.mediaDevices.enumerateDevices().then(devices => {
      const camaras = devices.filter(d => d.kind === 'videoinput');
      if (camaras.length >= 3) {
        iniciarCamaraDocumento(camaras[3] ? camaras[3].deviceId : camaras[2].deviceId);
        iniciarCamara1(camaras[0].deviceId);
        iniciarCamara2(camaras[1].deviceId);
        iniciarCamara3(camaras[2].deviceId);

        const imagenes = [];
        const tipos = ['rostro', 'vehículo', 'documento'];

        for (let i = 1; i <= 3; i++) {
          const video = document.getElementById('video' + i);
          const canvas = document.getElementById('canvas' + i);
          const ctx = canvas.getContext('2d');
          ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
          const imagen = canvas.toDataURL('image/jpeg');
          imagenes.push({ imagen, tipo: tipos[i - 1] });
        }

        const observacion = document.getElementById('observacion').value;

        // OCR sobre imagen del documento
        Tesseract.recognize(imagenes[2].imagen, 'spa').then(result => {
          const textoExtraido = result.data.text;
          alert("Texto extraído del documento: " + textoExtraido);
        });
      } else {
        alert("No se detectaron tres cámaras disponibles.");
      }
    });

    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
	});
</script>
