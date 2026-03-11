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

$mensaje = "crear un salvo conducto";
$enlaces = "Crear";

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
			$user->date_event = $_POST["ini_fec"];
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
			$user->date_event = $_POST["ini_fec"];
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
		"fecha" => $_POST["ini_fec"],
		"is_active" => "1"
	];
}else{
	if(!isset($_SESSION["idtarea"]) || $_SESSION["idtarea"] <= 0) $_SESSION["idtarea"] = 0;

	$tarea = (object) [
		"idperson" => 0,
		"asunto" => "",
		"descripcion" => "",
		"prioridad" => 0,
		"fecha" => "",
		"is_active" => "1"
	];
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tareas Nro. <?php echo $_SESSION["idtarea"]; ?>
		<small>asignaci&oacute;n de tareas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php if($_SESSION["is_admin"] == 1) echo 'tareas'; else echo 'home'; ?>"><?php if($_SESSION["is_admin"] == 1) echo '<i class="fa fa-database"></i> Tareas'; else echo '<i class="fa fa-dashboard"></i> Inicio'; ?> </a></li>
		<li class="active"> Asignaci&oacute;n</li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<form class="form-horizontal" method="post" id="addconducta" name="addconducta" action="<?php echo $_SESSION["url"]; ?>conductar" role="form">
		<input type="hidden" id="tarea_id" name="tarea_id" value="<?php echo $_SESSION["idtarea"]; ?>">
		<div class="callout callout-danger" style="margin-bottom: 0!important;">
			<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
			<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
			Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</div></br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del cliente</h3>
			</div>
			<div class="panel-body">
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
					<label for="asunto" class="col-md-2 col-sm-2 control-label">Prioridad:</label>
					<div class="col-md-4 col-sm-4">
						<select class="select-input form-control" id="id_prioridad" name="prioridad">
							<option value="0" <?php if($tarea->prioridad == 0) echo 'selected="selected"'; ?>> Baja </option>
							<option value="1" <?php if($tarea->prioridad == 1) echo 'selected="selected"'; ?>> Media </option>
							<option value="2" <?php if($tarea->prioridad == 2) echo 'selected="selected"'; ?>> Alta </option>
						</select>
					</div>
					<label for="ini_fec" class="col-md-2 col-sm-2 control-label">Fecha Maxima:</label>
					<div class="col-md-4 col-sm-4">
						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $tarea->fecha; ?>" required title="Debe de ser una fecha válida">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="asunto" class="col-sm-2 control-label"><span class="text-danger">*</span> Asunto:</label>
					<div class="col-sm-4">
						<input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" value="<?php echo $tarea->asunto; ?>" placeholder="Asunto de la Tarea" required>
					</div>
				</div>
				<div class="form-group">
				<label for="id_descripcion" class="col-sm-2 col-sm-4 control-label"><span class="text-danger">*</span> Descripción:</label>
				<div class="col-md-4">
					<textarea class="form-control input-sm" id="id_descripcion" name="descripcion" rows="4" required placeholder="Ingrese la descripción de la tarea"><?php echo $tarea->descripcion; ?></textarea>
					</div>
				</div>
				</br></br>
				<div class="panel panel-default" <?php if(isset($_SESSION["idtarea"]) && $_SESSION["idtarea"] > 0) echo ''; else echo 'style="display:none;"'; ?>>
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_personal" data-toggle="tab" aria-expanded="false">
								<b>Personal</b>
							</a>
						</li>
					</ul>
					<div class="panel-body">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane active" id="tab_personal">
								<button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
									Agregar/Modificar
								</button>									
								</br></br>
								<!-- pop up fechas Ingreso y Salida del empleado -->
								<div id="dlg_fechas_empresa" class="modal fade" tabindex="-1" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
												<h4 class="modal-title">Descripción de la Tarea</h4>
											</div>
											<div class="modal-body">
												<div class="form-group">
													<label for="rubro"><span class="text-danger">*</span> Descripción:</label>
													<textarea class="form-control" id="rubro" name="rubro" rows="4" required placeholder="Ingrese la descripción de la tarea"></textarea>
												</div>										
												<div class="form-group">
													<label for="fechaTarea"><span class="text-danger">*</span> Fecha:</label>
													<input type="date" class="form-control" id="fechaTarea" name="fechaTarea" required title="Debe de ser una fecha válida">
												</div>
											</div>
											<div class="modal-footer">
												<button id="agregar_fechas_empresa" type="button" class="btn btn-success">
													<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
												</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">
													<span class="glyphicon glyphicon-remove"> </span> Cancelar
												</button>
												<div id="finiquito"></div>
											</div>
										</div> <!-- /.modal-content -->
									</div> <!-- /.modal-dialog -->
								</div> <!--/ END modal -->	
								<div class="row">						
									<div class="col-md-12">
										<!--- Datos de Liquidacion --->
										<table id="viewBitacora" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="width: 12%"><div align="center">NRO.</div></th>
													<th style="width: 20%"><div align="center">CARGO</div></th>
													<th><div align="center">APELLIDOS Y NOMBRE</div></th>
													<th style="width: 20%"><div align="center">CEDULA</div></th>
													<th style="width: 20%"><div align="center">TELEFONO</div></th>
												</tr>
											</thead>
											<tbody>
												<?php
												if($_SESSION["idtarea"] == NULL){
													//No hay Acciones
												}else{
													$users = TimelineData::getDetalle($_SESSION["idtarea"]);		
													$resultado = count($users); 
													
													$i=1;
													if($resultado > 0){
														foreach($users as $tables) {
																echo '<tr>';
																	echo '<td><div align="center">'.$i.'&nbsp;&nbsp;<a href="index.php?view=conductar&borrar='.$tables->id.'&id='.$_SESSION['idtarea'].'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div></td>';
																echo '<td>'.$tables->description.'</td>';
																echo '<td>'.$tables->name.'</td>';
																echo '<td><div align="center">'.$tables->idcard.'</div></td>';
																echo '<td><div align="center">'.$tables->phone.'</div></td>';
															echo '</tr>';																
															$i++;
														}
													}
												} ?>
											</tbody>
										</table>								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</form>
</section>
<script>
    // Verificar que el elemento existe antes de usarlo
    var element = document.getElementById("sidai");
    if(element) {
        element.classList.add("sidebar-collapse");
    }
    document.title = "Near Solution | Registro de las tareas";

	// Inicializar datepicker si existen elementos con esa clase
	if($('.datepicker').length > 0) {
		$('.datepicker').datepicker({		
			locale: 'es',
	        daysOfWeekDisabled: [0, 6],
	        format: 'DD/MM/YYYY',
	        useCurrent:true
		});
	}
	
    // Usar delegación de eventos - más robusto
    $(document).on('click', '#agregar_fechas_empresa', function(e){
        e.preventDefault();
        console.log('✓ Botón guardar clickeado');
        
        // Obtener valores de la modal
        var tareas = $('#tarea_id').val();
        var rubro = $('#rubro').val().trim();
        var fechaTarea = $('#fechaTarea').val().trim();
        
        console.log('📋 Datos:', {tareas, rubro, fechaTarea});
        
        // Validar que los campos estén llenos
        if(tareas == '' || rubro == '' || fechaTarea == ''){
            console.warn('⚠️ Campos vacíos');
            sweetAlert('Errores pendientes...!!!', 'Debe llenar todos los campos para continuar', 'error');
            return false;
        }
        
        // Enviar datos por POST
        $.ajax({
            type: "POST",
                url: "/bitacora/ajax/guardarSubtarea.php",
            data: {
                tareas: tareas,
                rubro: rubro,
                fechaTarea: fechaTarea
            },
            dataType: 'json',
            success: function(response) {
                console.log('✅ Respuesta exitosa:', response);
                if(response.success){
                    sweetAlert('Éxito', 'Subtarea grabada correctamente', 'success');
                    // Limpiar campos de la modal
                    $('#rubro').val('');
                    $('#fechaTarea').val('');
                    // Cerrar modal
                    $('#dlg_fechas_empresa').modal('hide');
                    // Esperar a que se cierre la modal antes de recargar
                    setTimeout(function(){
                        window.location = "index.php?view=conductar&id=" + tareas;
                    }, 500);
                } else {
                    console.error('❌ Error del servidor:', response.error);
                    sweetAlert('Error', response.error || 'No se pudo grabar la subtarea', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Error AJAX:', {status, error, xhr});
                console.error('Respuesta:', xhr.responseText);
                sweetAlert('Error', 'Error de conexión: ' + status, 'error');
            }
        });
    });
</script>