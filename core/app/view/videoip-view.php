<?php
// Pantallas de ingreso los efectivos
$persons = ResidenteData::getCliente(6, 1); //$_SESSION["id_client"], 1);

$cargos = (object) [
	"ini_fec"=>null,
	"fin_fec"=>null,
	"manzana"=>null,
	"villa"=>null
];

$hoy = date("d-m-Y H:i:s");
$fecha = date("Y-m-d");
?>
<!-- Content Header (Page header) -->
 <style>
    .vista-principal { display: flex; gap: 20px; text-align: center; justify-content: center; }
    .pregunta { background: #fff; padding: auto; padding-right: 30px; box-shadow: 0 0 5px #ccc; }
    .panel { background: #fff; padding: 10px; box-shadow: 0 0 5px #ccc; }
    video { border: 1px solid #333; } 
    textarea { width: 100%; margin-top: 10px; }
</style>
<section class="content-header">
	<h1>
		Puestos
		<small>listado de los agentes asignados</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Camaras</a></li>
                    <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Visitas</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="activity">
                        <!-- Post -->
                        <div class="row">
                            <div class="post">
                                <div class="col-md-12>
                                    <audio id="alerta" src="assets/media/alarma.mp3" preload="auto"></audio>
                                    <audio id="ok" src="assets/media/siren.mp3" preload="auto"></audio>
                                    <div class="col-md-8 themed-grid-col">
                                        <div class="pb-3">
                                            <div class="panel" id="videoPrincipal">                  
                                                <video id="video" controls autoplay></video>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara1">
                                                    <video id="video" controls autoplay width="100%"></video>
                                                    <p class="text-center">Entrada principal</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara2">
                                                    <video id="video2" controls autoplay width="100%"></video>
                                                    <p class="text-center">Patio trasero</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara3">
                                                    <video id="video3" controls autoplay width="100%"></video>
                                                    <p class="text-center">Camara Nro. 1</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                        <div class="form-group">
                                            <label for="placa">Fecha:</label>
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
                                        <div class="form-group">
                                            <button class="btn btn-info" onclick="capturarTodo()">Capturar y Guardar</button>
                                            <button class="btn btn-success" onclick="btn_camara()">Verificar QR</button>
                                        </div>                                    
                                        <div class="col-md-12 btn-group">
                                            <!-- Reproductor de audio oculto none -->
                                            <audio id="audioPlayer" controls style="display:block;"></audio>
                                        </div>
                                        <p id="estado"></p>
                                    </div>
                                </div>
                                <div class="col-md-12 btn-group video-group" role="group" aria-label="Reproductor de audio">
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
                            </div>
                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <h13 class="timeline-header"><a href="#">Jonathan Burke Jr.</a> Changed His Name</h3>
                        <p class="timeline-header">3 Jan. 2014</p>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>document.title = "Near Solution | Agentes asignados"</script> 
<script>
  if (Hls.isSupported()) {
    var video1 = document.getElementById('video3');
    var video = document.getElementById('video');

    var hls = new Hls();
    var hls1 = new Hls();
    hls.loadSource('http://192.168.0.10:8888/cam1/index.m3u8');    
    hls1.loadSource('http://192.168.0.10:8888/cam1/index.m3u8');
    hls.attachMedia(video);
    hls1.attachMedia(video1);
  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
    video.src = 'http://192.168.0.10:8888/cam1/index.m3u8';
  }
  
  function playAudio(file) {
    const player = document.getElementById('audioPlayer');
    player.src = file;
    //player.style.display = 'block';
    player.play();
  }
  
  function btn_camara() {
	window.location.href = "verifica";
  } //

  function capturar() {
    fetch('capture.php', { method: 'POST' })
       .then(res => res.json())
       .then(data => {
          document.getElementById('imagenCamara').src = 'snapshot.php?' + new Date().getTime();
          document.getElementById('cedula').value = data.cedula || '';
          document.getElementById('nombre').value = data.nombre || '';
          document.getElementById('apellido').value = data.apellido || '';
          if (!data.valido) {
              document.getElementById('alerta').play();
              alert("⚠️ Error: Cédula inválida o campos incompletos");
          } else {
              document.getElementById('ok').play();
          }
    });
  }
</script>
