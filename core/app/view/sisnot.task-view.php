<?php 

$companys = CompanyData::getById($_SESSION["id_company"]); 
$users = UserData::getAll();

//var_dump($_SESSION);

if(count($_POST)>0){	
	if($_POST["prioridad"]==0)
	    $cadena = 'Baja';
	else
    	if($_POST["prioridad"]==1)
    	    $cadena = 'Media';
    	else
    	    $cadena = 'Alta';
	
	$nombre = UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname;
    $email = UserData::getById($_POST["persona"])->email;

	$user = new TimelineData();
	$user->idcompany = $_POST["company"];
	$user->idperson = $_POST["persona"];
	$user->prioridad = $_POST["prioridad"];
	$user->quien_asigna = $nombre;
	$user->status = 1;
	$user->title = $_POST["descripcion"];
	$user->date_event = $_POST["fecha"];
	$user->add_task();

	$hoy = date("Y-m-d H:i:s");

	// Varios destinatarios
	$para  = $email; // atención a la coma
	$título = 'Solicitud de actividades asignada por: '.$nombre;

	// mensaje
	$mensaje = '
	<html>
	<head>
	<title>Tiene Una actividad Pendiente</title>
	</head>
	<body>
		<h1>Tiene Una actividad Pendiente asignada el: '.$hoy.'</h1>
		<p>Esta actividad tienen una prioridad: '.$cadena.'<p>
	    <p>La fecha maxima de Ejecuci&oacute;n es: '.$_POST["fecha"].'</p>
	    <p>'.$_POST["descripcion"].'</p>
	</body>
	</html>';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: Gilbert Lerma <glerma@security.ec>' . "\r\n";
	$cabeceras .= 'From: Recordatorio <info@security.ec>' . "\r\n";

	// Enviarlo
	$bool = mail($para, $título, $mensaje, $cabeceras);
	
	//var_dump($bool);
	//print "<script>window.location='index.php?view=home&correo=".$bool."';</script>";
	Core::redir('home');
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tareas
		<small>asignaci&oacute;n de tareas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-database"></i> Tareas </a></li>
		<li class="active"> Asignaci&oacute;n</li>
	</ol>
</section>
</br>
<section id="main" role="main">
    <div class="container-fluid">
		<!-- Dialogo para seleccionar una cuenta -->
		<p class="alert alert-info">
			<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
			- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</p>
		<!-- ui-dialog -->
		<div id="dialog" title="Error en ingreso">
			<p>Debe completar los campos obligatorios para poder hacer el ingreso de los datos olicitados en el sistema.</p>
		</div>
		<!-- START panel -->
		<form class="form-horizontal" method="post" id="addtask" action="index.php?view=sisnot.task" role="form">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Asignaci&oacute;n de tareas</h3>
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
						<label class="col-md-2 control-label">Empresa:</label>
						<div class="col-md-4">
							<select id="id_company" name="company" class="form-control">
								<?php
									foreach($companys as $company):?>
										<option value="<?php echo $company->id; ?>"><?php echo $company->name; //utf8_encode() ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label"><span class="text-danger">*</span> Fecha Maxima:</label>
						<div class="col-md-4">
							<div class="input-group date form_date col-md-8" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input" data-link-format="yyyy-mm-dd">
								<input class="form-control" size="16" type="text" id="id_fecha" name="fecha" value="" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"> Responsable:</label>
						<div class="col-md-4">
							<select class="select-input form-control" id="id_persona" name="persona" required>
								<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($users as $user):?>
										<option value="<?php echo $user->id; ?>"><?php echo $user->name.' '.$user->lastname; // utf8_encode()?></option>
									<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"> Prioridad:</label>
						<div class="col-md-4">
							<select class="select-input form-control" id="id_prioridad" name="prioridad">
								<option value="0" selected="selected"> Baja </option>
								<option value="1"> Media </option>
								<option value="2"> Alta </option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-4 control-label"><span class="text-danger">*</span> Descripci&oacute;n de la solicitud:</label>
						<div class="col-md-4">
							<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-5">
							<label class="control-label">&nbsp;</label>
							<input id="id_active" name="active" type="checkbox" checked>
							<label for="id_gasto_no_deducible">&nbsp;&nbsp;Pendiente </label>
						</div>
					</div>
				</div>
			</div>
			<button type="submit" id="signin-button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Agregar Tarea</button>
		</form>
		</br>
	</div>
	<!--/ END To Top Scroller -->
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Asignacion de las tareas";
</script>
<script>
    $(document).ready(function(){    
        $('input').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });
        
        $("#dialog").dialog({
    		autoOpen: false,
    		modal: true,
    		width: 400,
    		buttons: [{
    			text: "Ok",
    			click: function() {
    				$(this).dialog("close");
    			}
    		}]
    	});
    
    	$('#signin-button').on('click', function (event) {
    		var descripcion = $('#id_descripcion')[0].value;
    		var responsable = $('#id_persona')[0].value;
    		var fecha = $('#id_fecha')[0].value;
    
    		if (!descripcion || !responsable || !fecha) {
    			event.preventDefault();
    			$("#dialog").dialog("open");
    		}
    		return;
    	});
    
    	$('.datepicker').datepicker({		
    		locale: 'es',
            daysOfWeekDisabled: [0, 6],
            format: 'DD/MM/YYYY',
            useCurrent:true
    	});
    });
</script>
