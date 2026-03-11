<?php
date_default_timezone_set('America/Guayaquil');

if(session_status() === PHP_SESSION_NONE){
	session_start();
}
require_once __DIR__ . '/../../../documentos/conexion.php';
$mysqli = getConn();

// Cargar clientes activos para asociar a cada evento
$clientes = array();
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$sqlClientes = "SELECT id, idclient, nombre, ruc FROM comercial WHERE is_active = 1";
if($userId > 0){
	$sqlClientes .= " AND iduser = " . $userId;
}
$sqlClientes .= " ORDER BY nombre ASC";
if($resCli = $mysqli->query($sqlClientes)){
	while($rowCli = $resCli->fetch_assoc()){
		$clientes[] = $rowCli;
	}
	$resCli->close();
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Calendario
		<small>planificaci&oacute;n de las acciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Dashboard </a></li>
		<li class="active"> Cotizar </li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<!-- Panel lateral reducido a filtros -->
	<div class="col-md-3">
	  <!-- Filtros y resumen -->
	  <div class="box box-solid">
		<div class="box-header with-border">
		  <h4 class="box-title"><i class="fa fa-filter"></i> Filtros</h4>
		</div>
		<div class="box-body">
		  <div class="form-group">
			<label for="searchEvent">Buscar por título:</label>
			<input type="text" class="form-control" id="searchEvent" placeholder="Buscar por título...">
		  </div>
		  <div class="form-group">
			<label for="filterColor">Filtrar por color/estado:</label>
			<select class="form-control" id="filterColor">
			  <option value="">Todos</option>
			  <option value="#FF6B6B">Contacto Inicial</option>
			  <option value="#FFA500">Reunión con el Dueño</option>
			  <option value="#FFD700">Visita en Sitio</option>
			  <option value="#90EE90">Aprobado por los dueños</option>
			  <option value="#FF1493">Licitación Objetada</option>
			  <option value="#87CEEB">En Revisión</option>
			  <option value="#00CED1">Completado</option>
			</select>
		  </div>
		  <button id="btnHoy" class="btn btn-primary btn-block"><i class="fa fa-calendar-o"></i> Ir a Hoy</button>
		  <button id="btnLimpiarFiltros" class="btn btn-default btn-block"><i class="fa fa-refresh"></i> Limpiar Filtros</button>
		</div>
	  </div>
	</div><!-- /.col -->
	<div class="col-md-9">
	  <div class="box box-primary">
		<div class="box-body no-padding">
		  <!-- THE CALENDAR -->
		  <div id="calendar"></div>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->
	</div><!-- /.col -->
</section>
<!-- Lógica del calendario movida a assets/js/calendar-eventos.js -->
<!-- Content continues -->
<!-- pop up fechas Ingreso y Salida del empleado -->
<div id="dlg_dias" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="box-header with-border">
				<h3 class="box-title">Agenda de Reuniones</h3>
				<div class="box-tools pull-right">
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body" style="display: block;">		
				<!-- ID oculto, ya no se muestra -->
				<input type="hidden" id="txtID" name="txtID" value="">
				<div class="form-group">
					<label for="txtCliente" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cliente:</label>
					<div class="col-md-8 col-sm-5">
						<select class="form-control" id="txtCliente" name="txtCliente" required>
							<option value="">-- Seleccione un cliente --</option>
							<?php foreach($clientes as $cli): 
								$clienteId = isset($cli['idclient']) && $cli['idclient'] !== null ? $cli['idclient'] : $cli['id'];
								$clienteNombre = htmlspecialchars($cli['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
								$clienteRuc = isset($cli['ruc']) ? htmlspecialchars($cli['ruc'], ENT_QUOTES, 'UTF-8') : '';
							?>
							<option value="<?= intval($clienteId) ?>"><?= $clienteNombre ?><?= $clienteRuc ? ' (' . $clienteRuc . ')' : '' ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="txtFecha" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha:</label>
					<div class="col-md-8 col-sm-2">
						<input type="date" class="form-control" id="txtFecha" name="txtFecha" value="" required>
					</div>
				</div>		
				<div class="form-group">
					<label for="txtHora" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Hora:</label>
					<div class="col-md-8 col-sm-2">
						<input type="time" class="form-control" id="txtHora" name="txtHora" value="" required>
					</div>
				</div>					
				<div class="form-group">
					<label for="txtTitulo" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> T&iacute;tulo:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtTitulo" name="txtTitulo" value="" placeholder="Título de la reunión" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtPersonaContacto" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Persona de Contacto:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtPersonaContacto" name="txtPersonaContacto" value="" placeholder="Nombre de la persona de contacto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtLugar" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Lugar de Reuni&oacute;n:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtLugar" name="txtLugar" value="" placeholder="Dirección o lugar de la reunión" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtDescripcion" class="col-md-4 col-sm-3 control-label">Descripci&oacute;n:</label>
					<div class="col-md-8 col-sm-5">
						<textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3" placeholder="Descripción adicional de la reunión"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="txtEstado" class="col-md-4 col-sm-3 control-label">Estado:</label>
					<div class="col-md-8 col-sm-5">
						<select class="form-control" id="txtEstado" name="txtEstado">
							<option value="1" data-color="#FF6B6B">Contacto Inicial</option>
							<option value="2" data-color="#FFA500">Reunión con el Dueño</option>
							<option value="3" data-color="#FFD700">Visita en Sitio</option>
							<option value="4" data-color="#90EE90">Aprobado por los dueños</option>
							<option value="5" data-color="#FF1493">Licitación Objetada</option>
							<option value="6" data-color="#87CEEB">En Revisión</option>
							<option value="7" data-color="#00CED1">Completado</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="txtColor" class="col-md-4 col-sm-3 control-label">Color:</label>
					<div class="col-md-3 col-sm-2">
						<input type="color" class="form-control" id="txtColor" name="txtColor" value="#FF6B6B" disabled>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="agregar_eventos" class="btn btn-success" style="display:none;">
					<i class="fa fa-save"></i> Guardar Evento
				</button>
				<button id="modificar_eventos" class="btn btn-primary" style="display:none;">
					<i class="fa fa-edit"></i> Modificar Evento
				</button>
				<button id="eliminar_eventos" class="btn btn-danger" style="display:none;">
					<i class="fa fa-trash"></i> Eliminar Evento
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<i class="fa fa-times"></i> Cancelar
				</button>
				<div id="finiquito"></div>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!--/ END modal -->
<!-- Lógica de eventos movida a assets/js/calendar-eventos.js -->
<script src="assets/js/calendar-eventos.js?v=20260106"></script>

<!-- Manejo de accesibilidad para modal -->
<script>
$(document).ready(function() {
    var $modal = $('#dlg_dias');
    
    // Remover aria-hidden cuando el modal se abre
    $modal.on('show.bs.modal', function() {
        $(this).removeAttr('aria-hidden');
    });
    
    // Agregar aria-hidden cuando el modal se cierra
    $modal.on('hide.bs.modal', function() {
        $(this).attr('aria-hidden', 'true');
    });
    
    // Establecer aria-hidden inicial si el modal no está visible
    if (!$modal.hasClass('in') && $modal.css('display') === 'none') {
        $modal.attr('aria-hidden', 'true');
    }
});
</script>