<?php
// Pantallas de ingreso los efectivos
$persons = ResidenteData::getCliente(6, 1); //$_SESSION["id_client"], 1);

$cargos = (object) [    
	"tipo"=>0,
	"ini_fec"=>null,
	"fin_fec"=>null,
	"manzana"=>null,
	"villa"=>null
];

$hoy = date("d-m-Y H:i:s");
$fecha = date("Y-m-d H:i:s");
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
                                <div class="col-md-12">
                                    <audio id="alerta" src="assets/media/alarma.mp3" preload="auto"></audio>
                                    <audio id="ok" src="assets/media/siren.mp3" preload="auto"></audio>
                                    <div class="col-md-8 themed-grid-col">
                                        <div class="pb-3">
                                            <div class="panel" id="videoPrincipal">                  
                                                <!-- <video id="video" controls autoplay width="100%"></video> -->                                                 
                                                <div class="col-md-12">				
                                                    <div>
                                                        <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                                                        <button id="boton">Tomar foto</button>
                                                        <p id="estado"></p>
                                                    </div>
                                                    <br>
                                                    <video muted="muted" id="video"></video>
                                                    <canvas id="canvas" style="display: none;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara1">
                                                    <video id="video3" controls autoplay width="100%"></video>
                                                </div>
                                            </div>
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara2">
                                                    <video id="video2" controls autoplay width="100%"></video>
                                                </div>
                                            </div>
                                            <div class="col-md-4 themed-grid-col">
                                                <div class="panel" id="camara3">
                                                    <video id="video1" controls autoplay width="100%"></video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <form id="captureForm">
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
                                                <label for="codigo">Codigo QR</label>
                                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="458988" style="text-transform: uppercase;" >
                                            </div>
                                            <div class="form-group">
                                                <label for="placa">Fecha:</label>
                                                <div class="input-group date form_datetime col-md-12 col-sm-12">
                                                    <input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                                                </div>
                                            </div><?php 
                                            if($_SESSION['residencial'] > 0) { ?>
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
                                            </div><?php } ?>
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
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-camera"></i> Capturar y Guardar
                                                </button>
                                                <button class="btn btn-warning" onclick="btn_camara()">Verificar QR</button>
                                            </div>                                    
                                            <div class="col-md-12 btn-group">
                                                <!-- Reproductor de audio oculto none -->
                                                <audio id="audioPlayer" controls style="display:block;"></audio>
                                            </div>
                                        </form>
                                        <div id="alertBox" class="mt-3"></div>
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
                                    <br>
                                    <audio id="alertSound" src="assets/media/alarma.mp3" preload="auto"></audio>
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
</script>
<script>
    // Auto-focus en el campo de código QR
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('codigo').focus();
    });

    document.getElementById('captureForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new URLSearchParams(new FormData(this));

        const alertBox = document.getElementById('alertBox');
        const alertSound = document.getElementById('alertSound');
        alertBox.innerHTML = `<div class="alert alert-success">✅ Enviando foto. Por favor, espera...</div>`;
        fetch('ajax/captura_all.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alertBox.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;
            } else {
                alertBox.innerHTML = `<div class="alert alert-danger">❌ ${data.message}</div>`;
                alertSound.play();
            }
        });
    });

    // Auto-búsqueda al cambiar el campo de código QR
    document.getElementById('codigo').addEventListener('change', function() {
        const codigo = this.value.trim();
        
        if (codigo.length === 0) {
            return;
        }

        const alertBox = document.getElementById('alertBox');
        alertBox.innerHTML = `<div class="alert alert-info">🔍 Buscando código QR...</div>`;

        const formData = new URLSearchParams();
        formData.append('codigo', codigo);

        fetch('ajax/buscar_codigo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(res => {
            console.log('Status:', res.status);
            return res.text(); // Primero obtener como texto
        })
        .then(text => {
            console.log('Respuesta cruda:', text);
            try {
                const data = JSON.parse(text);
                console.log('Datos parseados:', data);

                if (data.success) {
                    alertBox.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;
                    
                    // Llenar campos si el servidor retorna datos
                    console.log('Llenando campos...');
                    console.log('nombres:', data.nombre);
                    console.log('cedula:', data.cedula);
                    console.log('placa:', data.placa);
                    console.log('observacion:', data.observacion);
                    
                    if (data.nombre) {
                        document.getElementById('nombres').value = data.nombre;
                        console.log('nombre llenado:', document.getElementById('nombres').value);
                    }
                    if (data.cedula) {
                        document.getElementById('cedula').value = data.cedula;
                    }
                    if (data.placa) {
                        document.getElementById('placa').value = data.placa;
                    }
                    if (data.observacion) {
                        document.getElementById('observacion').value = data.observacion;
                    }
                    
                    if (document.getElementById('ok')) {
                        document.getElementById('ok').play();
                    }
                } else {
                    alertBox.innerHTML = `<div class="alert alert-warning">⚠️ ${data.message}</div>`;
                    if (document.getElementById('alerta')) {
                        document.getElementById('alerta').play();
                    }
                }
            } catch (e) {
                console.error('Error al parsear JSON:', e);
                alertBox.innerHTML = `<div class="alert alert-danger">❌ Error en respuesta: ${text}</div>`;
            }
        })
        .catch(error => {
            console.error('Error en fetch:', error);
            alertBox.innerHTML = `<div class="alert alert-danger">❌ Error: ${error.message}</div>`;
        });
    });
</script>

<script>
	/*
		Tomar una fotografía y guardarla en un archivo v3
		@date 2018-10-22
		@author parzibyte
		@web parzibyte.me/blog
	*/
	const tieneSoporteUserMedia = () =>
		!!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
	const _getUserMedia = (...arguments) =>
		(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

	// Declaramos elementos del DOM
	const $video = document.querySelector("#video"),
		$canvas = document.querySelector("#canvas"),
		$estado = document.querySelector("#estado"),		
		$foto = document.querySelector("#foto"),
		$boton = document.querySelector("#boton"),
		$listaDeDispositivos = document.querySelector("#listaDeDispositivos");

	const limpiarSelect = () => {
		for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
			$listaDeDispositivos.remove(x);
	};
	const obtenerDispositivos = () => navigator
		.mediaDevices
		.enumerateDevices();

	// La función que es llamada después de que ya se dieron los permisos
	// Lo que hace es llenar el select con los dispositivos obtenidos
	const llenarSelectConDispositivosDisponibles = () => {
		limpiarSelect();
		obtenerDispositivos()
			.then(dispositivos => {
				const dispositivosDeVideo = [];
				dispositivos.forEach(dispositivo => {
					const tipo = dispositivo.kind;
					if (tipo === "videoinput") {
						dispositivosDeVideo.push(dispositivo);
					}
				});
 
				// Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
				if (dispositivosDeVideo.length > 0) {
					// Llenar el select
					dispositivosDeVideo.forEach(dispositivo => {
						const option = document.createElement('option');
						option.value = dispositivo.deviceId;
						option.text = dispositivo.label;
						$listaDeDispositivos.appendChild(option);
					});
				}
			});
	}

	(function() {
		// Comenzamos viendo si tiene soporte, si no, nos detenemos
		if (!tieneSoporteUserMedia()) {
			alert("Lo siento. Tu navegador no soporta esta característica");
			$estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
			return;
		}
		//Aquí guardaremos el stream globalmente
		let stream;


		// Comenzamos pidiendo los dispositivos
		obtenerDispositivos()
			.then(dispositivos => {
				// Vamos a filtrarlos y guardar aquí los de vídeo
				const dispositivosDeVideo = [];

				// Recorrer y filtrar
				dispositivos.forEach(function(dispositivo) {
					const tipo = dispositivo.kind;
					if (tipo === "videoinput") {
						dispositivosDeVideo.push(dispositivo);
					}
				});

				// Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
				// y le pasamos el id de dispositivo
				if (dispositivosDeVideo.length > 0) {
					// Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
					mostrarStream(dispositivosDeVideo[0].deviceId);
				}
			});

		const mostrarStream = idDeDispositivo => {
			_getUserMedia({
					video: {
						// Justo aquí indicamos cuál dispositivo usar
						deviceId: idDeDispositivo,
					}
				},
				(streamObtenido) => {
					// Aquí ya tenemos permisos, ahora sí llenamos el select,
					// pues si no, no nos daría el nombre de los dispositivos
					llenarSelectConDispositivosDisponibles();

					// Escuchar cuando seleccionen otra opción y entonces llamar a esta función
					$listaDeDispositivos.onchange = () => {
						// Detener el stream
						if (stream) {
							stream.getTracks().forEach(function(track) {
								track.stop();
							});
						}
						// Mostrar el nuevo stream con el dispositivo seleccionado
						mostrarStream($listaDeDispositivos.value);
					}

					// Simple asignación
					stream = streamObtenido;

					// Mandamos el stream de la cámara al elemento de vídeo
					$video.srcObject = stream;
					$video.play();

					/*Escuchar el click del botón para tomar la foto
					$boton.addEventListener("click", function() {	
						context.drawImage(video, 0, 0, canvas.width, canvas.height);
						const imagen = canvas.toDataURL('image/jpeg');
						const descripcion = document.getElementById('descripcion').value;

						fetch('./ajax/subir.php', {
							method: 'POST',
							body: JSON.stringify({ imagen, descripcion }),
							headers: { 'Content-Type': 'application/json' }
						})
						.then(res => res.text())
						.then(msg => alert(msg));
					}); */
					//Escuchar el click del botón para tomar la foto
					$boton.addEventListener("click", function() {				
						//Pausar reproducción
						$video.pause();

						//Obtener contexto del canvas y dibujar sobre él
						let contexto = $canvas.getContext("2d");
						$canvas.width = $video.videoWidth;
						$canvas.height = $video.videoHeight;
						contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);
						
						const foto = canvas.toDataURL('image/jpeg');
						const descripcion = document.getElementById('observacion').value;
						console.log(descripcion);
						//let foto = $canvas.toDataURL(); //Esta es la foto, en base 64 guardar_foto.php
						$estado.innerHTML = "Enviando foto. Por favor, espera...";
						fetch("ajax/subir.php", {
								method: "POST",
								body: JSON.stringify({ foto, descripcion}),
								headers: { 'Content-Type': 'application/json' } /*
								body: encodeURIComponent(foto),
								headers: {
									"Content-type": "application/x-www-form-urlencoded",
								} */
							})
							.then(resultado => {
								res => res.text()
								msg => alert(msg)
								// A los datos los decodificamos como texto plano
								return resultado.text()
							})
							.then(nombreDeLaFoto => {
								// nombreDeLaFoto trae el nombre de la imagen que le dio PHP
								console.log(nombreDeLaFoto);
								$estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./storage/ingreso/${nombreDeLaFoto}'> aquí</a>`;
								$foto.value = nombreDeLaFoto;
							})

						//Reanudar reproducción
						$video.play();
					}); 
				}, (error) => {
					console.log("Permiso denegado o error: ", error);
					$estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
				});
		}
	})();
</script>