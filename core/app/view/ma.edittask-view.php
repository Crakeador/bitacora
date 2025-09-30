<?php
$companys = CompanyData::getAll();
$users = UserData::getAll();

$hoy = date("Y-m-d");
if(count($_POST)>0){
	$user = new TimelineData();
	$user->id = $_POST["id"];
	$user->idejecuta = $_POST["persona"];
	if(isset($_POST["active"]))
		$user->status = $_POST["active"];
	else
		$user->status = 1;

	$user->body = $_POST["descripcion"];
	$user->date_pass = $_POST["fecha"];
	$user->update($_POST["id"]);

	$hoy = date("Y-m-d H:i:s");
	// Varios destinatarios
	$para  = $_SESSION["email"]; // atención a la coma
	$título = 'Solicitud de actividades asignada por: '.$nombre;

	// mensaje
	$mensaje = '
	<html>
	<head>
	  <title>Tiene Una actividad Pendiente</title>
	</head>
	<body>
		<h1>Tiene Una actividad Pendiente asignada el: '.$hoy.'</h1>
	  <p>La fecha maxima de Ejecuci&oacute;n es: '.$_POST["fecha"].'</p>
	  <p>'.$_POST["descripcion"].'</p>
	</body>
	</html>';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: Jorge Fiallos <jfiallos@grupogps.com.ec>' . "\r\n";
	$cabeceras .= 'From: Recordatorio <info@grupogps.com.ec>' . "\r\n";

	// Enviarlo
	$bool = mail($para, $título, $mensaje, $cabeceras);
	
	print "<script>window.location='index.php?view=home';</script>";
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
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de Control </a></li>
		<li class="active"> Asignaciones </li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<div class="row">
			<!-- Dialogo para seleccionar una cuenta -->
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
				<!-- START panel -->
				<form class="form-horizontal" method="post" id="addtask" action="index.php?view=ma.edittask" role="form">
					<input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
								<h3 class="panel-title">Actualizar una tarea</h3>
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
								<label for="inputEmpresa" class="col-lg-2 control-label">Empresa:</label>
								<div class="col-md-4">
								<select name="company_id" class="form-control">
									<option value="0"> Selecione... </option>
									<?php
										foreach($companys as $company):?>
											<option value="<?php echo $company->id; ?>" <?php if($company->id == $datos->idcompany) echo 'selected="selected"'; ?>><?php echo utf8_encode($company->name);?></option>
										<?php endforeach;
									?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-3 control-label"> Fecha Maxima:</label>
								<div class="col-md-9 col-sm-4">
									<div class="input-group date form_date col-md-3" data-provide="" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" name="fecha2" value="<?php echo $datos->date_event; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Fecha Elaborada:</label>
								<div class="col-md-9 col-sm-4">
									<div class="input-group date form_date col-md-3" data-provide="" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" id="id_fecha" name="fecha" value="<?php echo $hoy; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 col-sm-3 control-label"> Ejecutor:</label>
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
								<label class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Descripci&oacute;n de la respuesta:</label>
								<div class="col-md-4">
									<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4"><?php echo $datos->body; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-5">
									<label class="col-sm-1 control-label">&nbsp;</label>
									<input id="id_active" name="active" value="2" type="checkbox">
									<label for="id_gasto_no_deducible">&nbsp;&nbsp;Ejecutado </label>
								</div>
							</div>
						</div>
					</div>
			  <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Actualizar Tarea </button>
				</form>
			</div>
		</div>
	</div>
	<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
	<!--/ END To Top Scroller -->
</section>
<script>
	$('.datepicker').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
</script>
