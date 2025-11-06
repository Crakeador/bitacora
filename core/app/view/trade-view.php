<?php
//Ingreso del personal de la Recepcion

$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $_SESSION['guardar'] = 0; $observacion = ''; $estilo = ''; $mensaje = '';

$ini = new DateTime(date("Y-m-d")." 07:00:00");
$fin = new DateTime(date("Y-m-d")." 17:00:00");

if(isset($_POST['id_person'])){	
    $user = new TradeData();
    $user->idpuesto = 1;
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->nacionalidad = $_POST["nacionalidad"];
    $user->cedula = $_POST["cedula"];
	$user->apellidos = $_POST["apellidos"];
	$user->nombres = $_POST["nombres"];
	$user->empresa = $_POST["empresa"];
	$user->oficina = $_POST["oficina"];
	$user->acompanante1 = $_POST["acompanante1"];
	$user->acompanante2 = $_POST["acompanante2"];
	$user->acompanante3 = $_POST["acompanante3"];
	$user->acompanante4 = $_POST["acompanante4"];
    $user->timestamp = $_POST["timestamp"];
    $user->latitude = $_POST["latitude"];
    $user->longitude = $_POST["longitude"];
    $user->rangoerror = $_POST["rangoerror"];
    $user->sentido = $_POST["sentido"];
    $user->velocidad = $_POST["velocidad"];
    $user->mensaje = $_POST["mensaje"];
    $user->is_active = 1;
    $user->usuario_log = $_SESSION["name"]." ".$_SESSION["lastname"];
    $user->ip = $_SESSION["ip"];

    if(!isset($_POST["cedula"])){
        $_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Lo siento el registro falló.'];
    }else{
		if($_FILES["foto"]["name"]==""){
			$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Debe de tomarse una foto para verificar su identidad'];
		}else{			
            if($_FILES["foto"]["name"]==""){
                $user->foto = "";
            }else{
                $image = new Upload($_FILES["foto"]);

                if($image->uploaded){
                    $image->Process("storage/trade/");

                    if($image->processed){
                        $user->foto = $image->file_dst_name;
                    }
                }
            }
			$prod = $user->add();
			if($prod[0] > 0){
				$_SESSION['sweetalert_message'] = ['icon' => 'success', 'title' => '¡Éxito!', 'text' => 'El registro se ha completado satisfactoriamente.'];	
			}else{
				$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Lo siento el registro falló.'];
			}	
		}
    }

    if($errores == ''){
      // Sin errores
    }else{
      Core::alert("Corrija...!!!!", $errores, "error");
    } /* */
}

?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<!-- Registro de Bitacora -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<!-- panel heading/header -->
					<div class="panel-heading">
						<h3 class="panel-title"><i class="mr5"></i>Ingreso de los visitantes </h3>
					</div><?php
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
					<!--/ panel heading/header -->
					<!-- panel body with collapse capable -->
					<div class="panel-collapse pull out">
						<div class="panel-body">						
							<div class="col-md-6">
								<form class="form-horizontal" method="post" enctype="multipart/form-data" id="trade" name="trade" action="trade" role="form">
									<input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['user_id']; ?>">
									<input type="hidden" id="verifica"   name="verifica"   value="0">
									<input type="hidden" id="timestamp"  name="timestamp"  value="">
									<input type="hidden" id="latitude"   name="latitude"   value="">
									<input type="hidden" id="longitude"  name="longitude"  value="">
									<input type="hidden" id="rangoerror" name="rangoerror" value="">
									<input type="hidden" id="sentido"    name="sentido"    value="">
									<input type="hidden" id="velocidad"  name="velocidad"  value="">
									<input type="hidden" id="mensaje"    name="mensaje"    value="">
									<input type="hidden" id="foto"       name="foto"       value="">
									<div class="form-group">
										<div class="col-xs-6">
											<label for="cedula" class="control-label">Fecha:</label>
											<div class="input-group date form_datetime col-md-9 col-sm-9">
												<input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
												<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
												<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
												<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
											</div>
										</div>
										<div class="col-xs-6">
											<label for="nombre" class="control-label">Puesto:</label></br>
											<label class="control-label">EDIFICIO TRADE BUILDING</label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-6">
											<label for="nacionalidad" class="control-label">Nacionalidad:</label>
											<select id="nacionalidad" name="nacionalidad" class="form-control">
												<option value="0">Ecuatoriana</option>
												<option value="1">Extranjera</option>
											</select>
										</div>
										<div class="col-xs-6">
											<label for="nombre" class="control-label">Cedula:</label>
											<input type="text" id="cedula" name="cedula" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-6">
											<label for="apellidos" class="control-label">Apellidos:</label>
											<input type="text" id="apellidos" name="apellidos" class="form-control" value="">
										</div>
										<div class="col-xs-6">
											<label for="nombres" class="control-label">Nombres:</label>
											<input type="text" id="nombres" name="nombres" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-6">
											<label for="empresa" class="control-label">Empresa:</label>
											<select id="empresa" name="empresa" class="form-control">
												<option value="1">LATIN AMERICA</option>
												<option value="2">PRIMESHOP</option>
												<option value="3">SALICA DEL ECUADOR S.A.</option>
											</select>
										</div>
										<div class="col-xs-6">
											<label for="oficina" class="control-label">Nro. Oficina:</label>
											<input type="text" id="oficina" name="oficina" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-6">
											<label for="acompanante1" class="control-label">Acompañante 1:</label>
											<input type="text" id="acompanante1" name="acompanante1" class="form-control" value="">
										</div>
										<div class="col-xs-6">
											<label for="acompanante2" class="control-label">Acompañante 2:</label>
											<input type="text" id="acompanante2" name="acompanante2" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-6">
											<label for="acompanante3" class="control-label">Acompañante 3:</label>
											<input type="text" id="acompanante3" name="acompanante3" class="form-control" value="">
										</div>
										<div class="col-xs-6">
											<label for="acompanante4" class="control-label">Acompañante 4:</label>
											<input type="text" id="acompanante4" name="acompanante4" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-10">
											<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
										</div>
									</div>
								</form>
							</div>
							<div class="col-md-6">							
								<div>
									<select name="listaDeDispositivos" id="listaDeDispositivos"></select>
									<input type="hidden" id="fotoNombre" name="foto" value="">
									<button id="btnTomarFoto" type="button">Tomar foto</button>
									<p id="estadoFoto"></p>
								</div>
								<br>
								<video id="video" autoplay playsinline></video>
								<canvas id="canvas" style="display:none;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
    $(document).ready(function(event) {
	    document.title = "Near Solucion | Ingreso de Visitantes";

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

		(function(){
			const video = document.getElementById('video');
			const canvas = document.getElementById('canvas');
			const btnTomarFoto = document.getElementById('btnTomarFoto');
			const estadoFoto = document.getElementById('estadoFoto');
			const fotosEndpoint = '/ajax/guardar_foto.php'; // ajusta si es necesario
			const fotoNombreInput = document.getElementById('fotoNombre');

			// Iniciar cámara
			async function iniciarCamara() {
				try {
				const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
				video.srcObject = stream;
				await video.play();
				} catch (err) {
				estadoFoto.textContent = 'No se pudo acceder a la cámara: ' + err.message;
				}
			}

			// Tomar foto y subir
			btnTomarFoto.addEventListener('click', async function() {
				if (video.videoWidth === 0 || video.videoHeight === 0) {
				estadoFoto.textContent = 'La cámara no está lista.';
				return;
				}

				// Dibujar en canvas con tamaño real
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				const ctx = canvas.getContext('2d');
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

				// Convertir a Blob (jpeg)
				const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.92));
				const formData = new FormData();
				formData.append('foto', blob, 'foto.jpg');

				estadoFoto.textContent = 'Enviando foto...';

				try {
				const res = await fetch(fotosEndpoint, {
					method: 'POST',
					body: formData
				});
				const json = await res.json();
				if (json && json.success && json.filename) {
					const filename = json.filename;
					fotoNombreInput.value = filename; // Usado al guardar el registro
					estadoFoto.innerHTML = 'Foto guardada con éxito. Nombre: ' + filename;
					// Opcional: mostrar enlace
					// const enlace = document.createElement('a');
					// enlace.href = '/storage/trade/' + filename;
					// enlace.target = '_blank';
					// enlace.textContent = 'Ver foto';
					// estadoFoto.appendChild(document.createElement('br'));
					// estadoFoto.appendChild(enlace);
				} else {
					estadoFoto.textContent = 'Error al guardar la foto: ' + (json?.error ?? 'desconocido');
				}
				} catch (e) {
				console.error(e);
				estadoFoto.textContent = 'Error al enviar la foto.';
				}
			});

			// Inicia la cámara al cargar la página
			iniciarCamara();
		})();
	});
</script>