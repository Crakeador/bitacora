<?php
//Actualizacion de tareas
$users = UserData::getAll();

$hoy = date("Y-m-d H:i:s");
if(count($_POST)>0){
	$user = new TimelineData();
	$user->idtimeline = $_POST["id"];
	$user->iduser = $_SESSION["user_id"];
	$user->idperson = $_POST["persona"];
	if(isset($_POST["active"]))
		$user->status = $_POST["active"];
	else
		$user->status = 1;

	$user->idejecuta = $_POST["persona"];
	$user->body = $_POST["descripcion"];
	$user->descripcion = $_POST["descripcion"];
	$user->fecha= $_POST["fecha"];

	// agregar respuesta y obtener el id generado
	list($queryResult, $insertId) = $user->add_resp();
	$indice = $insertId; // ID de la fila insertada en tabla 'respuesta'
	// determinar si hubo error en la inserción
	$error = $queryResult ? 0 : 1;
	if($error == 0){
		$cambio = $user->update($_POST["id"]);

		// manejar archivos subidos (opcional) usando $indice si se desea
		if(isset($_FILES['tarea_files'])){
			$uploadDir = 'uploads/tareas/';
			if(!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
			foreach($_FILES['tarea_files']['tmp_name'] as $idx => $tmp){
				if(is_uploaded_file($tmp)){
					// datos de cada archivo
					$nombreOriginal = $_FILES['tarea_files']['name'][$idx];
					$tipoArchivo = $_FILES['tarea_files']['type'][$idx];
					$tamano = $_FILES['tarea_files']['size'][$idx];
					// nombre que vamos a guardar en servidor
					$nombreSubido = $_POST["id"] . '_' . $nombreOriginal;
					$dest = $uploadDir . $nombreSubido;
					// mover fichero
					move_uploaded_file($tmp, $dest);
					// registro de archivo como respuesta adicional
					$user->iduser = $_SESSION["user_id"];
					$user->idrespuesta = $indice; // asociar archivo a la respuesta creada
					$user->descripcion = $nombreSubido;
					$user->tipo = $tipoArchivo;
					$user->add_acci();
				}
			}			
			echo "<script>window.location='".$_SESSION['url']."home';</script>";
		}
	}else{
		echo "<script>alert('Ocurrio un error al actualizar la tarea');window.location='".$_SESSION['url']."home';</script>";
	}	
}else{
	$datos = TimelineData::getById($_GET["id"]);
}
 
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Asignaciones
		<small>asignacion de tareas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de Control </a></li>
		<li class="active"> Asignaciones </li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
			</div>			
			<form class="form-horizontal" method="post" id="addtask" action="<?php echo $_SESSION['url']; ?>edittask" role="form" enctype="multipart/form-data">
				<!-- Dialogo para seleccionar una cuenta -->
				<div class="col-md-6">
					<!-- START panel -->
					<input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-legal"></i>&nbsp;&nbsp;Actualizar una tarea</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="col-md-6 col-sm-3">
									<span class="text-danger">&nbsp;</span>
								</div>
								<div class="col-sm-2">
									<span class="text-danger">&nbsp;</span>
								</div>
							</div>
							<div class="form-group">
								<span class="col-md-2 col-sm-3 control-label"> Fecha Elaborada:</span>
								<div class="col-md-10 col-sm-4">
									<div class="input-group date form_date col-md-6 col-sm-4" data-provide="" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" id="id_fecha" name="fecha" value="<?php echo $hoy; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="persona_id" class="col-sm-2 col-sm-3 control-label"> Ejecutor:</label>
								<div class="col-md-3 col-sm-4">
									<select class="select-input form-control input-sm" id="persona_id" name="persona">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($users as $user):?>
												<option value="<?php echo $user->id; ?>" <?php if($user->id == $datos->idperson) echo 'selected="selected"'; ?>><?php echo utf8_encode($user->name).' '.utf8_encode($user->lastname);?></option>
											<?php endforeach;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="asunto" class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Tarea Asignada:</label>
								<div class="col-md-10 col-sm-10">
									<input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" value="<?php echo $datos->asunto; ?>" placeholder="Asunto de la Tarea" disabled>
								</div>
							</div>
							<div class="form-group">
								<label for="id_descripcion" class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Descripci&oacute;n de la respuesta:</label>
								<div class="col-md-10 col-sm-10">
									<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-5">
									<span class="col-sm-1 control-label">&nbsp;</span>
									<input id="id_active" name="active" value="2" type="checkbox">
									<label for="id_active" class="control-label">&nbsp;&nbsp;Ejecutado </label>
								</div>
							</div>
						</div>			
						<div class="panel-footer">
							<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Actualizar Tarea </button>
							<a href="<?php echo $_SESSION['url']; ?>home" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Cancelar </a>
						</div>
					</div>		
				</div>			
				<div class="col-md-6">
					<div class="panel panel-default">	
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-server"></i>&nbsp;&nbsp;Subir archivos</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<p class="alert alert-info">
										<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
										- Solo se permiten archivos con formato PDF, Word, Excel, Imagenes (JPG, PNG) y archivos comprimidos (ZIP).
									</p>									
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label for="tarea_files" class="control-label">Seleccionar archivos</label>
											<input type="file" id="tarea_files" name="tarea_files[]" multiple class="form-control">
											<p class="help-block">Puede seleccionar varios archivos a la vez.</p>
											<ul id="selected_files" class="list-group" style="margin-top:5px;"></ul>
										</div><?php
										// mostrar archivos ya subidos para esta tarea
										if(isset($_GET['id'])){
											$existingDir = 'uploads/tareas/';
											$taskId = intval($_GET['id']);
											if(is_dir($existingDir)){
												$files = glob($existingDir . $taskId . '_*');
												if($files){
													echo '<h5>Archivos adjuntos</h5><ul class="list-unstyled">';
													foreach($files as $f){
														$fname = basename($f);
														echo '<li class="list-group-item"><a href="'.$f.'" target="_blank">'.htmlspecialchars($fname).'</a></li>';
													}
													echo '</ul>';
												}
											}
										} ?>
									</div>
								</div>
							</div>						
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
	<!--/ END To Top Scroller -->
</section>
<script>
	$(document).ready(function(){
		var element = document.getElementById("sidai");

		element.classList.add("sidebar-collapse");
		document.title = "Near Solution | Asignacion de los guardias";

		$('input').iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-red'
		});

		// mostrar lista de archivos elegidos antes de enviar
		document.getElementById('tarea_files').addEventListener('change', function(e){
			var list = document.getElementById('selected_files');

			list.innerHTML = '';
			Array.from(this.files).forEach(function(f){
				var li = document.createElement('li');
				li.className = 'list-group-item';
				li.textContent = f.name + ' (' + Math.round(f.size/1024) + ' KB)';
				list.appendChild(li);
					// variables para debugging
					var nombreOriginal = f.name;              // nombre de archivo en el cliente
					var tipoArchivo = f.type;                 // MIME type
					var nombreSubido = f.name;                // en este momento coincide con el original
					console.log('seleccionado ->', nombreOriginal, tipoArchivo);			});
		});
	});
</script>
