<?php
//Novedades de Bitacora
date_default_timezone_set('America/Guayaquil');

$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $observacion = ''; $estilo = ''; 

if(isset($_GET["usuario"])){
    $_SESSION["usuario"]=$_GET["usuario"];
    $_SESSION["puesto"]=$_GET["puesto"];
    $_SESSION["ingreso"]=$_GET["ingreso"];
    $_SESSION["turno"]=$_GET["turno"];
}

if(!isset($_SESSION["puesto"])){
    print "<script>window.location='index.php?view=asignar';</script>";
}

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
    $user->idpuesto = $_POST["puesto"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_SESSION['turno'];
    $user->proceso = 2;
    $user->tipo = $_POST["tipo"];
    $user->manzana = $_POST["manzana"];
    $user->villa = $_POST["villa"];
    $user->observacion = $_POST["observacion"];
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

    if($_POST["observacion"]==""){
        $errores = 'debe de ingresar una observacion del puesto';
    }else{
        if($_POST["foto1"]==""){
            $errores = 'debe de tomarse una foto para verificar la novedad';
        }else{
			$user->foto1 = $_POST["foto1"];
			$user->foto2 = $_POST["foto2"];
			$user->foto3 = $_POST["foto3"];
			$user->foto4 = $_POST["foto4"];
			$user->foto5 = $_POST["foto5"];
			$user->foto6 = $_POST["foto6"];

            $prod = $user->add();

            $guardar = 1;
        }
    }

    if($errores == ''){
        // Core::alert("Exito...!!!!", "Se guardo su registro", "error", "novedad&guardar=1");
    }else{
        $Observacion = $_POST["observacion"];
        Core::alert("Corrija...!!!!", $errores, "error");
    }
}

if($_SESSION["residencial"]==0)
    $estilo='style="display: none;"';
else
    $estilo="";

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
					<h3 class="panel-title"><i class="mr5"></i>Ingreso de novedades </h3>
				</div>
				<!--/ panel heading/header -->
				<!-- panel body with collapse capable -->
				<div class="panel-collapse pull out">
					<div class="panel-body">
						<div class="col-md-6">
							<form class="form-horizontal" method="post" enctype="multipart/form-data" id="fotos" name="fotos" action="index.php?view=fotos" role="form">
								<input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['user_id']; ?>">
								<input type="hidden" id="guardar"    name="guardar"    value="<?php echo $_GET['guardar']; ?>">
								<input type="hidden" id="puesto"     name="puesto"     value="">
								<input type="hidden" id="timestamp"  name="timestamp"  value="">
								<input type="hidden" id="latitude"   name="latitude"   value="">
								<input type="hidden" id="longitude"  name="longitude"  value="">
								<input type="hidden" id="rangoerror" name="rangoerror" value="">
								<input type="hidden" id="sentido"    name="sentido"    value="">
								<input type="hidden" id="velocidad"  name="velocidad"  value="">
								<input type="hidden" id="mensaje"    name="mensaje"    value="">
								<input type="hidden" id="foto1"      name="foto1"      value="">
								<input type="hidden" id="foto2"      name="foto2"      value="">
								<input type="hidden" id="foto3"      name="foto3"      value="">
								<input type="hidden" id="foto4"      name="foto4"      value="">
								<input type="hidden" id="foto5"      name="foto5"      value="">
								<input type="hidden" id="foto6"      name="foto6"      value="">
								<input type="hidden" id="cuenta"     name="cuenta"     value="1">
                                <div class="form-group">
								
                                    <label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
									<div class="col-md-6 col-sm-6">
    					                <div class="input-group date form_datetime col-md-9 col-sm-6">
    						                <input class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
    						                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
    										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    										<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
    								    </div>
    								</div>
                                            <input type="checkbox" id="puerta" name="puerta" value="2"> Salida &nbsp;&nbsp;
                                            
								</div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <span class="text-danger">Que tipo de visita es?</span>
                                        <div class="radiobutton">
                                            <input type="radio" id="tipo1" name="tipo" value="1" checked> Vista &nbsp;&nbsp;
                                            <input type="radio" id="tipo2" name="tipo" value="2"> Taxi  &nbsp;&nbsp;
                                            <input type="radio" id="tipo3" name="tipo" value="3"> Entrega &nbsp;&nbsp;
                                            <input type="radio" id="tipo4" name="tipo" value="4"> Otros
                                        </div>
                                    </div>
                                </div>
								<div class="form-group" <?php echo $estilo; ?>>
                                    <div class="col-xs-6">
                                        <label class="control-label"><span class="text-danger">*</span> Mz:</label>
                                        <input type="text" name="manzana" class="form-control" placeholder="1224">
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="control-label"><span class="text-danger">*</span> Villa:</label>
                                        <input type="text" name="villa" class="form-control" placeholder="41">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"> Describa lo que esta reportando:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Visita autorizada por el propietario" cols="40" rows="5"><?php echo $observacion; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"> Ingrese las fotos:</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="foto01" id="foto01" class="SubirFoto" style="width:300px"/></br></br>
                                        <input type="text" name="foto02" id="foto02" class="SubirFoto" style="width:300px"/></br></br>
                                        <input type="text" name="foto03" id="foto03" class="SubirFoto" style="width:300px"/></br></br>
                                        <input type="text" name="foto04" id="foto04" class="SubirFoto" style="width:300px"/></br></br>
                                        <input type="text" name="foto05" id="foto05" class="SubirFoto" style="width:300px"/></br></br>
                                        <input type="text" name="foto06" id="foto06" class="SubirFoto" style="width:300px"/></br></br>
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
    document.title = "Near Solucions | Registro de la Bitacora en PC";
</script>
<script>
  $(document).ready(function(){
    var guardar = document.getElementById("guardar");

    if(localStorage.getItem("usuario") != null){
        var valor = localStorage.getItem("puesto");
        var puesto = document.getElementById("puesto");

        puesto.value = valor;
        //window.location="index.php?view=novedad&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
    }else{
        alert("No hay ningun turno abierto...!!!");
    }
	
    if(guardar.value == 1){
        guardar.value = 0;
        swal("Excelente..!", "Se grabo con exito", "success");
    }

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
		  $foto01 = document.querySelector("#foto01"),
		  $foto02 = document.querySelector("#foto02"),
		  $foto03 = document.querySelector("#foto03"),
		  $foto04 = document.querySelector("#foto04"),
		  $foto05 = document.querySelector("#foto05"),
		  $foto06 = document.querySelector("#foto06"),
		  $foto1 = document.querySelector("#foto1"),
		  $foto2 = document.querySelector("#foto2"),
		  $foto3 = document.querySelector("#foto3"),
		  $foto4 = document.querySelector("#foto4"),
		  $foto5 = document.querySelector("#foto5"),
		  $foto6 = document.querySelector("#foto6"),
		  $cuenta = document.querySelector("#cuenta"),
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
					$boton.addEventListener("click", function() {
						// Añadimos la imagen de carga en el contenedor 
						$('#content').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor espere...!!!</div>');
						
						//Pausar reproducción
						$video.pause();

						//Obtener contexto del canvas y dibujar sobre él
						let contexto = $canvas.getContext("2d");
						$canvas.width = $video.videoWidth;
						$canvas.height = $video.videoHeight;
						contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

						let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
						$estado.innerHTML = "Enviando foto. Por favor, espera...";
						fetch("storage/novedad/guardar_foto.php", {
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
								console.log("La foto fue enviada correctamente");
								$estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./storage/novedad/${nombreDeLaFoto}'> aquí</a>`;
								if($cuenta.value == 1){ 
									$foto1.value = nombreDeLaFoto;
									$foto01.value = nombreDeLaFoto;
								}
								if($cuenta.value == 2){
									$foto2.value = nombreDeLaFoto;
									$foto02.value = nombreDeLaFoto;
								}
								if($cuenta.value == 3){
									$foto3.value = nombreDeLaFoto;
									$foto03.value = nombreDeLaFoto;
								}
								if($cuenta.value == 4){
									$foto4.value = nombreDeLaFoto;
									$foto04.value = nombreDeLaFoto;
								}
								if($cuenta.value == 5){
									$foto5.value = nombreDeLaFoto;
									$foto05.value = nombreDeLaFoto;
								}
								if($cuenta.value == 6){
									$foto6.value = nombreDeLaFoto;
									$foto06.value = nombreDeLaFoto;
								}
								$cuenta.value = parseInt($cuenta.value) + 1;
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