<?php
//Ingreso de Guardias en la Bitacora Electronica
if(!isset($_SESSION['ingreso'])) Core::redir('home');

$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $_SESSION['guardar'] = 0; $observacion = ''; $estilo = ''; $mensaje = '';

$ini = new DateTime(date("Y-m-d")." 07:00:00");
$fin = new DateTime(date("Y-m-d")." 17:00:00");

if(isset($_POST['id_person'])){	
    $user = new BitacoraData();
    $user->idpuesto = (int) $_POST["id_localidad"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_POST["turno"];
    $user->proceso = (($_SESSION['ingreso'] == 0) ? 1: 3);
    $user->observacion = $_POST["observacion"];	
    $user->foto1 = $_POST["foto"];
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

	$observacion = $_POST["observacion"];
    if(!isset($_POST["turno"])){
        $errores = 'debe de seleccionar el turno';
    }else{
        if($_POST["observacion"]==""){
            $errores = 'debe de ingresar una observacion del puesto';
        }else{
            if($_POST["foto"]==""){
                $errores = 'debe de tomarse una foto para verificar su identidad';
            }else{
				if($_POST["verifica"]==0) $prod = $user->addIMG();

				if(isset($_POST["short"])){
					$_SESSION["consigna"]=$_POST["consigna"];

					$config = new ConfigurationData();
					$config->id = 9;
					$config->val = $_POST["consigna"];

					$prod = $config->update();
				}

				$_SESSION['turno'] = $_POST["turno"];
				$_SESSION['puesto'] = (int) $_POST["id_localidad"];
				
				if($_SESSION['ingreso']==0){
					$_SESSION['ingreso']=1;
					// Fotos
					echo '<script>
						localStorage.setItem("usuario", "'.$_POST["id_person"].'");
						localStorage.setItem("puesto", "'.$_POST["id_localidad"].'");
						localStorage.setItem("ingreso", "'.$_SESSION['ingreso'].'");
						localStorage.setItem("turno", "'.$_POST["turno"].'");

						
					 </script>';
				}else{
					$_SESSION['ingreso']=2; //window.location = "index.php?view=novedad";  

					echo '<script>
						localStorage.removeItem("usuario");
						localStorage.clear();
						
						window.location = "index.php?view=logout";
					</script>';
				}
            }
        }
    }

    if($errores == ''){
      // Sin errores
    }else{
      Core::alert("Corrija...!!!!", $errores, "error");
    }
}

$today = getdate(); $hora=$today["hours"];

if ($hora<6) {
    //echo(" Hoy has madrugado mucho... ");
}elseif($hora<16){
    if($_SESSION['ingreso']==0){
        $total = $hora - 7;
		$_SESSION['turno'] = 1;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos días, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}elseif($hora<=18){
    if($_SESSION['ingreso']==0){
        $total = $hora - 17;
		$_SESSION['turno'] = 2;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos tardes, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}else{
    //echo("Buenas Noches ");
}

// Listado de los puesto de servicio de los guardias
$puestos = UnionData::getByIdLugares($_SESSION['user_id']);

?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
  <div class="container-fluid">
	<div class="callout callout-danger" <?php echo $estilo; ?>>
		<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
		<?php echo $mensaje; ?>
		<span class="text-danger">*</span><?php echo $_SESSION['consigna']; ?>
	</div>
	</br>
	<!-- Registro de Bitacora -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- panel heading/header -->
				<div class="panel-heading">
					<h3 class="panel-title"><i class="mr5"></i><?php echo (($_SESSION['ingreso'] == 0) ? "Ingreso al puesto de trabajo": "Salida al puesto de trabajo"); ?></h3>
				</div>
				<!--/ panel heading/header -->
				<!-- panel body with collapse capable -->
				<div class="panel-collapse pull out">
					<div class="panel-body">						
						<div class="col-md-6">
						    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="ingreso" name="ingreso" action="index.php?view=ingreso" role="form">
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
									<label for="id_localidad" class="col-sm-4 control-label"><span class="text-danger">*</span> Puesto:</label>
									<div class="col-md-8 col-sm-8">
										<?php
											echo '<select id="id_localidad" name="id_localidad" class="form-control">';
											foreach($puestos as $tables) {
												echo '<option value="'.$tables->idservicio.'">'.$tables->descripcion.'</option>';
											}
											echo '</select>';
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="fechas" class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
									<div class="col-md-8 col-sm-8">
										<div class="input-group date form_datetime col-md-9 col-sm-9">
											<input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
											<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-6">
										<span class="text-danger">Que turno esta cubriendo?</span>
										<div class="radiobutton">
											<input type="radio" id="turno1" name="turno" value="1" <?php if($_SESSION['turno']==1) echo "checked"; ?>> Diurno &nbsp;&nbsp;
											<input type="radio" id="turno2" name="turno" value="2" <?php if($_SESSION['turno']==2) echo "checked"; ?>> Nocturno
										</div>
									</div>
									<div class="col-xs-6">
										<span class="text-danger">Pasar la siguiente consigna:</span>
										<input type="checkbox" name="short">
									</div>
								</div>
								<div class="form-group">
									<label for="consigna" class="col-md-4 col-sm-4 control-label">Consigna:</label>
									<div class="col-sm-8">
										<textarea class="form-control" size="10" type="text" id="consigna" name="consigna" placeholder="Indique su consigna" cols="40" rows="2"><?php echo $_SESSION['consigna']; ?></textarea>

									</div>
								</div>
								</br>
								<div class="form-group">
									<label for="observacion" class="col-sm-4 control-label"> Describa lo que esta reportando:</label>
									<div class="col-sm-8">
										<textarea class="form-control" id="observacion" name="observacion" placeholder="Se recivio el puesto sin ninguna novedad" cols="40" rows="5"><?php echo $observacion; ?></textarea>
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
								<button id="boton">Tomar foto</button>
								<p id="estado"></p>
							</div>
							<br>
							<video muted="muted" id="video"></video>
							<canvas id="canvas" style="display: none;"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
</section>
<script>
    document.title = "Near Solucions | Ingreso del Personal en PC";

    if(localStorage.getItem("usuario") != null){
        var usuario = localStorage.getItem("usuario");
        var puesto = localStorage.getItem("puesto");
        var ingreso = localStorage.getItem("ingreso");
        var turno = localStorage.getItem("turno");
        var verifica = document.getElementById("verifica");

        verifica.value = 1;
        //window.location="index.php?view=novedad&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
    }else{
        alert("No hay ningun turno abierto...!!!");
    }
</script>
<script>
    $(document).ready(function(event) {
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
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

					//Escuchar el click del botón para tomar la foto
					//Escuchar el click del botón para tomar la foto
					$boton.addEventListener("click", function() {						
						//Pausar reproducción
						$video.pause();

						//Obtener contexto del canvas y dibujar sobre él
						let contexto = $canvas.getContext("2d");
						$canvas.width = $video.videoWidth;
						$canvas.height = $video.videoHeight;
						contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

						let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
						$estado.innerHTML = "Enviando foto. Por favor, espera...";
						fetch("storage/fotos/guardar_foto.php", {
								method: "POST",
								body: encodeURIComponent(foto),
								headers: {
									"Content-type": "application/x-www-form-urlencoded",
								}
							})
							.then(resultado => {
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