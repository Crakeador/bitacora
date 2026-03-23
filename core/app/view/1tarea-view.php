<?php 
//Asignacion de Tarea
$grupos = GruposData::getAll(); 
$users = UserData::getAll();
$error = 0;

// manejo modal nuevo grupo
if(isset($_POST['guardar_grupo']) && !empty($_POST['grupo_nombre'])){
    $g = new GruposData();
    $g->name = $_POST['grupo_nombre'];
    $g->idcompany = $_SESSION['id_company'];
    $g->is_active = 1;
    $g->add();
    // refrescar lista de grupos para edición actual
    $grupos = GruposData::getAll();
}

// manejo modal asignar miembro a grupo
if(isset($_POST['guardar_miembro']) && isset($_POST['miembro_persona']) && $_POST['miembro_persona']>0 && isset($_POST['miembro_grupo']) && $_POST['miembro_grupo']>0){
    $g = new GruposData();
    $g->idgrupo = $_POST['miembro_grupo'];
    $g->idperson = $_POST['miembro_persona'];
    $g->is_active = 1;
    $g->addGrupo();
    // opcional: mensaje de confirmación simple
    echo "<script>toastr.success('Miembro agregado al grupo');</script>";
}

if(count($_POST)>0){
	if(isset($_POST["grupo"]) && $_POST["grupo"] > 0){	
		$grupo = new GruposData();
		$todos = $grupo->getAllGrupo($_POST["grupo"]);

		foreach($todos as $tarea){
			$user = new TimelineData();
			$user->idcompany = $_SESSION["id_company"];
			$user->idperson = $tarea->idperson;
			$user->prioridad = $_POST["prioridad"];
			$user->quien_asigna = UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname;
			$user->status = 1;
			$user->type = 2;
			$user->asunto = $_POST["asunto"];
			$user->title = $_POST["descripcion"];
			$user->date_event = $_POST["fecha"];
			$user->add_task();
		}
	}else{
		if(isset($_POST["persona"]) && $_POST["persona"] > 0){
			$nombre = UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname;
			$email = UserData::getById($_POST["persona"])->email;

			$user = new TimelineData();
			$user->idcompany = $_SESSION["id_company"];
			$user->idperson = $_POST["persona"];
			$user->prioridad = $_POST["prioridad"];
			$user->quien_asigna = $nombre;
			$user->status = 1;
			$user->type = 2;
			$user->asunto = $_POST["asunto"];
			$user->title = $_POST["descripcion"];
			$user->date_event = $_POST["fecha"];
			$user->add_task();

			$total = TimelineData::getByTotal();
			$_SESSION["idtarea"] = $total->total;
			$hoy = date("Y-m-d H:i:s");
		}
	}
	
	$tarea = (object) [
		"idgrupo" => $_POST["grupo"],
		"idperson" => $_POST["persona"],
		"asunto" => $_POST["asunto"],
		"descripcion" => $_POST["descripcion"],
		"prioridad" => $_POST["prioridad"],
		"date_event" => $_POST["fecha"],
		"is_active" => "1"
	];
}else{
	if(!isset($_GET["id"]) || $_GET["id"] <= 0){
		$_SESSION["idtarea"] = 0;

		$tarea = (object) [
			"idperson" => 0,
			"asunto" => "",
			"title" => "",
			"prioridad" => 0,
			"date_event" => "",
			"is_active" => "1"
		];
	}else{
		$tarea = TimelineData::getById($_GET["id"]);
		$_SESSION["idtarea"] = $_GET["id"];
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tareas
		<small>asignaci&oacute;n de tareas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php if($_SESSION["is_admin"] == 1) echo 'tareas'; else echo 'home'; ?>"><?php if($_SESSION["is_admin"] == 1) echo '<i class="fa fa-database"></i> Tareas'; else echo '<i class="fa fa-dashboard"></i> Inicio'; ?> </a></li>
		<li class="active"> Asignaci&oacute;n</li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
    <div class="container-fluid">
		<!-- Dialogo para seleccionar una cuenta -->
		<p class="alert alert-info">
			<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
			- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</p>
		<!-- START panel -->
		<form class="form-horizontal" method="post" id="addtask" action="tarea" role="form">
			<input type="hidden" id="tarea_id" name="tarea_id" value="<?php echo $_SESSION["idtarea"]; ?>">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Asignaci&oacute;n de tareas <?php echo $_SESSION["idtarea"]; ?></h3>
				</div>
				<div class="panel-body">
					<?php if(isset($_SESSION["idtarea"]) && $_SESSION["idtarea"] > 0): ?>
						<a href="tareas" class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span> Regresar</a>
					<?php else: ?>
						<button type="submit" id="signin-button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Agregar Tarea</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalNuevoGrupo">
							<i class="fa fa-plus"></i> Grupos
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAsignarMiembro">
							<i class="fa fa-plus"></i> Miembros
						</button>
					<?php endif; ?>
					<div class="form-group">
						<div class="col-md-6 col-sm-3">
							<span class="text-danger">&nbsp;</span>
						</div>
						<div class="col-sm-2">
							<span class="text-danger">&nbsp;</span>
						</div>
					</div>
					<div class="form-group" <?php if($_SESSION["idrol"] < 3) echo ''; else echo 'style="display:none;"'; ?>>
						<label for="id_grupo" class="col-md-2 control-label">Grupo:</label>
						<div class="col-md-4">
							<select id="id_grupo" name="grupo" class="form-control">
								<option value="0">--- SELECCIONE UN GRUPO ---</option><?php							
								foreach($grupos as $grupo):?>
									<option value="<?php echo $grupo->id; ?>"><?php echo $grupo->name; //utf8_encode() ?></option> <?php 
								endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="id_persona" class="col-sm-2 control-label"> Responsable:</label>
						<div class="col-md-4">
							<select class="select-input form-control" id="id_persona" name="persona">
								<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($users as $user): 
										if($user->id == $tarea->idperson) $cadena = 'selected="selected"'; else $cadena = '';?>
										<option value="<?php echo $user->id; ?>" <?php echo $cadena; ?>><?php echo $user->name.' '.$user->lastname; //utf8_encode() ?></option>
									<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="id_prioridad" class="col-sm-2 control-label"> Prioridad:</label>
						<div class="col-md-4">
							<select class="select-input form-control" id="id_prioridad" name="prioridad">
								<option value="0" <?php if($tarea->prioridad == 0) echo 'selected="selected"'; ?>> Baja </option>
								<option value="1" <?php if($tarea->prioridad == 1) echo 'selected="selected"'; ?>> Media </option>
								<option value="2" <?php if($tarea->prioridad == 2) echo 'selected="selected"'; ?>> Alta </option>
							</select>
						</div>
					</div>			
    				<div class="form-group">
    					<label for="asunto" class="col-sm-2 control-label"><span class="text-danger">*</span> Asunto:</label>
    					<div class="col-sm-4">
    					    <input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" value="<?php echo $tarea->asunto; ?>" placeholder="Asunto de la Tarea" required>
    					</div>
    				</div>
					<div class="form-group">
						<label for="id_descripcion" class="col-sm-2 col-sm-4 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
						<div class="col-md-4">
							<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4" required><?php echo $tarea->title; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="fecha" class="col-sm-2 control-label"><span class="text-danger">*</span> Fecha:</label>
						<div class="col-md-4">
							<input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo ($tarea->date_event && $tarea->date_event != '0000-00-00 00:00:00') ? date('Y-m-d', strtotime($tarea->date_event)) : date('Y-m-d'); ?>" required>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!-- modal nuevo grupo -->
		<div class="modal fade" id="modalNuevoGrupo" tabindex="-1" role="dialog" aria-labelledby="modalNuevoGrupoLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalNuevoGrupoLabel">Nuevo Grupo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="post" action="">
					<div class="modal-body">
					<div class="form-group">
						<label for="grupo_nombre">Nombre del grupo</label>
						<input type="text" class="form-control" id="grupo_nombre" name="grupo_nombre" required>
					</div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" name="guardar_grupo">Guardar</button>
					</div>
				</form>
				</div>
			</div>
		</div>

		<!-- modal asignar miembro -->
		<div class="modal fade" id="modalAsignarMiembro" tabindex="-1" role="dialog" aria-labelledby="modalAsignarMiembroLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalAsignarMiembroLabel">Asignar miembro al grupo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form method="post" action="">
					<div class="modal-body">
					<div class="form-group">
						<label for="miembro_grupo">Grupo</label>
						<select id="miembro_grupo" name="miembro_grupo" class="form-control" required>
							<option value="0">--Seleccione--</option>
							<?php foreach($grupos as $grupo): ?>
								<option value="<?php echo $grupo->id; ?>"><?php echo $grupo->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="miembro_persona">Persona</label>
						<select id="miembro_persona" name="miembro_persona" class="form-control" required>
							<option value="0">--Seleccione--</option>
							<?php foreach($users as $user): ?>
								<option value="<?php echo $user->id; ?>"><?php echo $user->name.' '.$user->lastname; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary" name="guardar_miembro">Guardar</button>
					</div>
				</form>
				</div>
			</div>
		</div>
		<div class="panel panel-default" <?php if(isset($_SESSION["idtarea"]) && $_SESSION["idtarea"] > 0) echo ''; else echo 'style="display:none;"'; ?>>
			<div class="panel-heading">
				<h3 class="panel-title">Asignaci&oacute;n de tareas</h3>
			</div>
			<div class="panel-body">
				<div class="row">						
					<div class="col-md-12">
						<button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
							Agregar/Modificar
						</button>									
						</br></br>
						<!--- Datos de Liquidacion --->
						<table id="viewBitacora" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><div align="center">DSECRIPCION</div></th>
									<th style="width: 20%"><div align="center">fecha</div></th>
									<th style="width: 20%"><div align="center">creada</div></th>
								</tr>
							</thead>
							<tbody>	<?php 								
								if($_SESSION["idtarea"] == NULL){
									//No hay Acciones
								}else{
									$users = TimelineData::getDetalle($_SESSION["idtarea"]);		
									$resultado = count($users); 

									if($resultado > 0){
										foreach($users as $tables) {
											echo '<tr>';
												echo '<td>'.$tables->descripcion.'</td>';
												echo '<td><div align="center">'.$tables->fecha.'</div></td>';
												echo '<td><div align="center">'.$tables->created_at.'</div></td>';
											echo '</tr>';
										}
									}
								} ?>
							</tbody>
						</table>
						<!-- pop up fechas Ingreso y Salida del empleado -->
						<div id="dlg_fechas_empresa" class="modal">
							<div class="modal-dialog">
								<div class="modal-content">	
									<form class="form-horizontal" method="post" id="addtareas" action="tarea" role="form">
										<div class="box-header with-border">
											<h3 class="box-title">Asignar Tareas</h3>
											<div class="box-tools pull-right">
												<button type="button" class="close" data-dismiss="modal">×</button>
											</div><!-- /.box-tools -->
										</div><!-- /.box-header -->
										<div class="box-body" style="display: block;">
											<div class="form-group">
												<label for="id_persona" class="col-md-4 col-sm-3 control-label"> Responsable:</label>
												<div class="col-md-6 col-sm-5">
													<select class="select-input form-control" id="id_persona" name="persona">
														<option value="0" selected="selected"> Selecione... </option>
														<?php
															foreach($users as $user): 
																if($user->id == $tarea->idperson) $cadena = 'selected="selected"'; else $cadena = '';?>
																<option value="<?php echo $user->id; ?>" <?php echo $cadena; ?>><?php echo $user->name.' '.$user->lastname; //utf8_encode() ?></option>
															<?php endforeach; ?>
													</select>
												</div>
											</div></br>	
											<div class="form-group">
												<label for="rubro" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
												<div class="col-md-8 col-sm-5">
													<input type="text" class="form-control" id="rubro" name="rubro" value="" placeholder="Descripcion de la tarea">
												</div>
											</div></br>
											<div class="form-group">
												<label for="fechaTarea" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha Maxima:</label>
												<div class="col-md-6">
													<div class="input-group date" id="datetimepicker1">
													<input type="text" class="form-control" id="fechaTarea" name="fechaTarea" value="<?php echo $tarea->fecha; ?>" required/>
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-remove"></span>
													</span>
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button id="agregar_fechas_empresa" class="btn btn-success">
												<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
											</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">
												<span class="glyphicon glyphicon-remove"> </span> Cancelar
											</button>
										</div>
									</form>
								</div> <!-- /.modal-content -->
							</div> <!-- /.modal-dialog -->
						</div> <!--/ END modal -->					
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ END To Top Scroller -->
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Asignacion de las tareas";
	
	$(document).ready(function(){
    	$('input').iCheck({
    	    checkboxClass: 'icheckbox_flat-red',
    	    radioClass: 'iradio_flat-red'
    	});
	
    	$(function () {
            $('#datetimepicker1').datetimepicker();
        });

        // validar que se seleccione grupo o persona antes de enviar
        $('#addtask').on('submit', function(e){
            var grupo = parseInt($('#id_grupo').val()) || 0;
            var persona = parseInt($('#id_persona').val()) || 0;
            if(grupo <= 0 && persona <= 0){
                e.preventDefault();
                sweetAlert('Error...','Debe seleccionar un grupo o una persona antes de continuar','error');
            }
        });
	});
	
    $(function(){
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
			// Obtener valores de la modal
			var tareas = $('#tarea_id').val();
			var rubro = $('#rubro').val().trim();
			var fechaTarea = $('#fechaTarea').val().trim();
			
			console.log('📋 Datos:', {tareas, rubro, fechaTarea});
			
			// Validar que los campos estén llenos
			if(tareas == 0 || rubro == '' || fechaTarea == ''){
				console.warn('⚠️ Campos vacíos');
				sweetAlert('Errores pendientes...!!!', 'Debe llenar todos los campos para continuar', 'error');
				return false;
			}else{
				// Añadimos la imagen de carga en el contenedor 
				$('#finiquito').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor espere...!!!</div>');

				$.ajax({
					type: "POST",
					url: "/bitacora/ajax/guardarSubtarea.php",
					dataType: "json",
					data: {
						tareas: tareas,
						rubro: rubro,
						fechaTarea: fechaTarea
					},
					success: function(response) {
						if(response.success){
							sweetAlert('Éxito', 'Subtarea guardada correctamente', 'success');
							setTimeout(function(){
								window.location="<?php echo $_SESSION["url"]; ?>tarea/"+tareas;
							}, 1500);
						} else {
							$('#finiquito').html('');
							sweetAlert('Error', response.error || 'Error al guardar la subtarea', 'error');
							console.error('Error:', response.error);
						}
					},
					error: function(xhr, status, error) {
						$('#finiquito').html('');
						sweetAlert('Error', 'Error en la solicitud: ' + error, 'error');
						console.error('AJAX Error:', error);
					}
				});
			}

			return false;
		}) 
	});
</script>