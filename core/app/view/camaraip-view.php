<?php
// Pantallas de ingreso los efectivos
$persons = ResidenteData::getCliente(6, 1); //$_SESSION["id_client"], 1);

$cargos = (object) [
	"ini_fec"=>null,
	"fin_fec"=>null,
	"manzana"=>null,
	"villa"=>null
];

if(isset($_GET['codigo'])){
	if(strlen($_GET['codigo']) < 6 || strlen($_GET['codigo']) > 6){
		$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Este codigo no es valido, llamar al propietario.'];
	}else{
		$cargos = ResidenteData::getLike($_GET['codigo']);		

		if($cargos == NULL){
			Core::alert("Error...!!!!", "El codigo no exite", "error");
			$diff_in_days = -1;
			$cargos = (object) [
				"ini_fec"=>null,
				"fin_fec"=>null,
				"manzana"=>null,
				"villa"=>null
			];
			$validador = 0;
		}else{
      //var_dump($cargos);
      $fechaObjetivo = new DateTime($cargos->ini_fec);
      $fechaActual = new DateTime();

      //echo 'Diferencia en días: ' . $fechaActual->format('Y-m-d H:i:s') . ' días, ' . $fechaObjetivo->format('Y-m-d H:i:s') . ' horas';
      /*
      $diferencia = $fechaActual->diff($fechaObjetivo);
      if($diferencia->days == 0 && $diferencia->h <= 2){
        // Dentro del periodo de autorizacion
      }else{
        $_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Su periodo de autorizacion ha expirado, llamar al propietario.'];
        $validador = 0;
      } */
		}
	}
}
$hoy = date("d-m-Y H:i:s");
$fecha = date("Y-m-d");
?>
<style>
  .vista-principal { display: flex; gap: 20px; text-align: center; justify-content: center; }
  .pregunta { background: #fff; padding: auto; padding-right: 30px; box-shadow: 0 0 5px #ccc; }
  .panel { background: #fff; padding: 10px; box-shadow: 0 0 5px #ccc; }
  video { border: 1px solid #333; } 
  textarea { width: 100%; margin-top: 10px; }
</style>
<div class="panel-body">
  <div class="row"> 
    <div class="col-md-12">      
      <div class="panel panel-default">
        <!-- panel heading/header -->
        <div class="panel-heading">
          <h3 class="panel-title"><i class="mr5"></i>Ingreso de novedades </h3>
        </div>
        <!--/ panel heading/header -->
        <!-- panel body with collapse capable -->
        <div class="panel-collapse pull out">	
          <p>Por favor, complete la siguiente información y utilice las cámaras para capturar las imágenes necesarias.</p>
          <div class="row mb-3">
            <div class="col-md-8 themed-grid-col">
              <div class="pb-3">
                <div class="panel" id="camara0">
                  <div class="vista-principal">
                    <video id="video" controls autoplay width="100%"></video>
                    <canvas id="canvasDocumento" style="display:none;"></canvas>
                  </div>
                </div>
              </div>
              <div class="row text-center">
                <div class="col-md-4 themed-grid-col">
                  <div class="panel" id="camara1">
                    <video id="video1" controls autoplay width="100%"></video>
                    <canvas id="canvas1" style="display:none;"></canvas>
                  </div>
                </div>
                <div class="col-md-4 themed-grid-col">
                  <div class="panel" id="camara2">
                    <video id="video2" controls autoplay width="100%"></video>
                    <canvas id="canvas2" style="display:none;"></canvas>
                  </div>
                </div>
                <div class="col-md-4 themed-grid-col">
                  <div class="panel" id="camara3">
                    <video id="video3" controls autoplay width="100%"></video>
                    <canvas id="canvas3" style="display:none;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 pregunta">
              <div class="form-group" style="display:none;">
                <input type="hidden" name="idcodigo" id="idcodigo" value="<?php if(isset($cargos->id)) echo $cargos->id; else echo '0'; ?>">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked>
                  <label class="form-check-label" for="inlineRadio1">Entrada</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                  <label class="form-check-label" for="inlineRadio2">Salida</label>
                </div>
              </div>
              <div class="form-group" style="padding: 1.5rem !important;">
                <div class="col-md-12 col-sm-12 text-right">
                  <span class="text-danger">Que tipo de visita es?</span>
                  <div class="radiobutton">
                    <input type="radio" id="tipo1" name="tipo" value="1" <?php if($cargos->tipo == 'Visita') echo "checked='checked'"; ?>> Visita &nbsp;&nbsp;
                    <input type="radio" id="tipo2" name="tipo" value="2" <?php if($cargos->tipo == 'Taxi') echo "checked='checked'"; ?>> Taxi  &nbsp;&nbsp;
                    <input type="radio" id="tipo3" name="tipo" value="3" <?php if($cargos->tipo == 'Entrega') echo "checked='checked'"; ?>> Entrega &nbsp;&nbsp;
                    <input type="radio" id="tipo4" name="tipo" value="4" <?php if($cargos->tipo == 'Otros') echo "checked='checked'"; ?> > Otros
                  </div>
                </div>
              </div>
              <br>  
              <div class="form-group">
                <div class="input-group date form_datetime col-md-12 col-sm-12">
                  <input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                  <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                </div>
              </div>        
              <div class="form-group">
                <label for="placa">Residente/Familia:</label>                 
                <div class="input-group col-md-12 col-sm-12"> <?php
                  echo '<select id="idresidente" name="idresidente" class="form-control select2">';
                    echo '<option value="0"> -- SELECCIONE -- </option>';
                    foreach($persons as $tables) {
                      if($tables->id == $cargos->idresidente) $valor = 'selected'; else $valor = '';
                      echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->nombre.'</option>'; //utf8_encode()
                    }
                  echo '</select>'; ?>
                </div>
              </div>
              <div class="form-group">
                <label for="placa">Placa de Vehiculo</label>
                <input type="text" class="form-control" id="placa" name="placa" placeholder="HPH-0022" style="text-transform: uppercase;" >
              </div>
              <div class="form-group">
                <label for="cedula">Cedula o RUC</label>
                <input type="number" class="form-control" id="cedula" name="cedula" placeholder="99999999999" value="<?php if(isset($cargos->cedula)) echo $cargos->cedula; ?>">
              </div>
              <div class="form-group">
                <label for="nombres">Nombres Completos</label>
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Juan Perez" value="<?php if(isset($cargos->nombre)) echo $cargos->nombre; ?>" style="text-transform: uppercase;" >
              </div>
              <div class="form-group">
                <label for="observacion"> Observaciones: </label>
                <textarea class="form-control" id="observacion" name="observacion" placeholder="Observación general" rows="3"><?php if(isset($cargos->observacion)) echo $cargos->observacion; ?></textarea>
              </div>
              <button class="btn btn-info" onclick="capturarTodo()">Capturar y Guardar</button>
              <button class="btn btn-success" onclick="btn_camara()">Verificar QR</button>
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
              </div>
              </br></br>
              <!-- Reproductor de audio oculto none -->
              <audio id="audioPlayer" controls style="display:block;"></audio>
              </br>
              <p id="estado"></p>
              </br></br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.5/dist/tesseract.min.js"></script><?php
if (isset($_SESSION['sweetalert_message'])) {;
	echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js?v=1.0.1"></script>';
        $alert = $_SESSION['sweetalert_message'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                  swal('".$alert['title']."', '".$alert['text']."', '".$alert['icon']."');
                });
              </script>";
        unset($_SESSION['sweetalert_message']); // Limpia la sesión después de usarla
} ?>
<script type='text/javascript'>
  if (Hls.isSupported()) {   
    var video1 = document.getElementById('video1');
    var video2 = document.getElementById('video2');
    var video3 = document.getElementById('video3');
    var video = document.getElementById('video');

    var hls = new Hls();
    var hls1 = new Hls();
    var hls2 = new Hls();
    var hls3 = new Hls();
    hls.loadSource('http://192.168.0.10:8888/cam1/index.m3u8');    
    hls1.loadSource('http://192.168.0.10:8888/cam1/index.m3u8');
    hls2.loadSource('http://192.168.0.10:8888/cam2/index.m3u8');
    hls3.loadSource('http://192.168.0.10:8888/cam3/index.m3u8');
    hls.attachMedia(video);
    hls1.attachMedia(video1);
    hls2.attachMedia(video2);
    hls3.attachMedia(video3);
  }

  function playAudio(file) {
    const player = document.getElementById('audioPlayer');
    player.src = file;
    //player.style.display = 'block';
    player.play();
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

  function capturarTodo() {
    const imagenes = [];
    const tipos = ['documento', 'vehículo', 'rostro'];

    for (let i = 1; i <= 3; i++) {
      const video = document.getElementById('video' + i);
      const canvas = document.getElementById('canvas' + i);
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      const imagen = canvas.toDataURL('image/jpeg');
      imagenes.push({ imagen, tipo: tipos[i - 1] });
    }

    const idcodigo = document.getElementById('idcodigo').value;
    const placa = document.getElementById('placa').value;
    const cedula = document.getElementById('cedula').value;
    const nombres = document.getElementById('nombres').value;
    const idresidente = document.getElementById("idresidente").value;
    const observacion = document.getElementById('observacion').value;
 
		const estado = document.querySelector("#estado");

    // OCR sobre imagen del documento (canvas3)
    const canvasDoc = document.getElementById('canvas3');
    aplicarFiltros(canvasDoc);
    const imagenFiltrada = canvasDoc.toDataURL('image/jpeg');

    console.log("Codigo: " + idcodigo);
    estado.innerHTML = "Enviando foto. Por favor, espera...";
    fetch('ajax/subir_multiple.php', {
      method: 'POST',
      body: JSON.stringify({imagenes, placa, cedula, nombres, idresidente, observacion, idcodigo}),
      headers: { 'Content-Type': 'application/json' }
    }).then(res => res.text()).then(msg => alert(msg));

    Tesseract.recognize(imagenFiltrada, 'spa')
      .then(result => {
        const textoExtraido = result.data.text;
        alert("Texto OCR: " + textoExtraido);

        /* Enviar todo al backend
        fetch('ajax/subir_multiple.php', {
          method: 'POST',
          body: JSON.stringify({imagenes, placa, cedula, nombres, idresidente, observacion, texto_documento: textoExtraido}),
          headers: { 'Content-Type': 'application/json' }
        })
        .then(res => res.text())
        .then(msg => alert(msg)); */
      })
      .catch(err => {
        console.error("Error OCR:", err);
        alert("Error al procesar OCR");
      });
  }

  function btn_camara() {
	  window.location.href = "verifica";
  } //
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

    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
	});
</script>
