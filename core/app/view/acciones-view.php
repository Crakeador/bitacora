<?php
//Modificar las acciones de las tareas asignadas a los comerciales
$companys = ComercialData::getPhone($_SESSION["user_id"], 1);

$hoy = date("Y-m-d H:i:s");
if(count($_POST)>0){
	$user = new TimelineData();
	$user->idperson = $_SESSION["user_id"];
	$user->quien_asigna = $_SESSION["usuario"];
	$user->asunto = "Modificacion por: ".$_SESSION["usuario"];
	$user->porcentaje = 10;
	$user->type = 3;
	$user->prioridad = $_POST["tipo"];
	$user->status = $_POST["id_active"];
	$user->idclient = $_POST["company_id"];
	$user->title = strtoupper($_POST["descripcion"]);
	$user->date_event = $_POST["fecha"];

	$user->add_acci();
	
	if($_POST["tipo"] == 1) $cadena = "Llamada"; elseif($_POST["tipo"] == 2) $cadena = "Mailing"; elseif($_POST["tipo"] == 3) $cadena = "Visita"; else $cadena = "Whatsapp";
	$comercial = new ComercialData();
	$comercial->id = $_POST["company_id"];
	$comercial->observacion = strtoupper($_POST["descripcion"]);
	$comercial->gestion = $cadena;

	$comercial->estado();
	
	$hoy = date("Y-m-d H:i:s");
	// Varios destinatarios
	$para  = $_SESSION["email"]; // atención a la coma
	$título = 'Solicitud de actividades asignada por: '.$_SESSION["usuario"];

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
	
	//Core::redir('tareas'); 
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Actividades realizadas
		<small>registro de actividades</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $_SESSION["url"]; ?>home"><i class="fa fa-dashboard"></i> Panel de Control </a></li>
		<li class="active"> Actividades </li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<div class="row">
			<!-- Dialogo para seleccionar una cuenta -->
			<div class="col-md-12">
				<!-- START panel -->
				<form class="form-horizontal" method="post" id="addtask" action="acciones" role="form">
    				<p class="alert alert-info">
    					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
    					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
    				</p>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Acctualizar Gestion</h3>
						</div>
						<div class="panel-body">
    			            <button type="submit" class="btn btn-success pull-right"><span class="fa fa-save"></span> Actualizar Gestion </button>
							<div class="form-group">
									<div class="col-md-6 col-sm-3">
										<span class="text-danger">&nbsp;</span>
									</div>
									<div class="col-sm-2">
										<span class="text-danger">&nbsp;</span>
									</div>
							</div>
							<div class="form-group">
								<label for="company_id" class="col-md-2 col-sm-3 control-label">Prospecto:</label>
								<div class="col-md-9 col-sm-4">
    								<select id="company_id" name="company_id" class="form-control">
    									<option value="0"> Selecione... </option>
    									<?php
    										foreach($companys as $company):?>
    											<option value="<?php echo $company->id; ?>"><?php echo utf8_encode($company->nombre);?></option>
    										<?php endforeach;
    									?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-3 control-label"> Fecha de accion:</label>
								<div class="col-md-9 col-sm-4">
									<div class="input-group date form_date col-md-3" data-provide="" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" name="fecha2" value="<?php echo $hoy; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n de la respuesta:</label>
								<div class="col-md-9 col-sm-4">
									<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4"></textarea>
								</div>
							</div>
        					<div class="form-group">
        						<label for="tipo" class="col-sm-2 control-label"> Accion:</label>
        						<div class="col-md-4">
        							<select class="select-input form-control" id="tipo" name="tipo">
        								<option value="1"> Llamada </option>
        								<option value="2"> Mailing </option>
        								<option value="3"> Visitas </option>
        							</select>
        						</div>
        					</div>
        					<div class="form-group">
        						<label for="id_active" class="col-sm-2 control-label"> Seguimiento:</label>
        						<div class="col-md-4">
        							<select class="select-input form-control" id="id_active" name="id_active">
        								<option value="1"> En curso </option>
        								<option value="2"> Seguimiento </option>
        								<option value="3"> En espera </option>
        								<option value="4"> Visitado </option>
        								<option value="5"> Enviar Cotizacion </option>
        								<option value="6"> Negociacion </option>
        								<option value="7"> En revision </option>
										<option value="8"> Ganada </option>
										<option value="9"> Perdida </option>
        							</select>
        						</div>
        					</div>							
        					<div class="form-group">
        						<label for="resultado" class="col-sm-2 control-label"> Resultado:</label>
        						<div class="col-md-4">
        							<select class="select-input form-control" id="resultado" name="resultado">
        								<option value="1"> Cotizaciones </option>
        								<option value="2"> Inspeccion </option>
        								<option value="3"> Visita Futura </option>
        							</select>
        						</div>
        					</div>
							<fieldset class="form-fieldset">
                                <legend>Generar alertas</legend>
								<div class="form-group">
									<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Fecha Maxima:</label>
									<div class="col-md-9 col-sm-4">
										<div class="input-group date form_date col-md-3" data-provide="" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" id="id_fecha" name="fecha" value="<?php echo $hoy; ?>">
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="accion" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Observacion:</label>
									<div class="col-md-9 col-sm-4">
										<textarea class="form-control input-sm" cols="50%" id="accion" name="accion" rows="4"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="id_active" class="col-sm-2 control-label"> Seguimiento:</label>
									<div class="col-md-4">
										<select class="select-input form-control" id="id_active" name="id_active">
											<option value="1"> En curso </option>
											<option value="2"> Segimiento </option>
											<option value="3"> En espera </option>
											<option value="4"> Visitado </option>
											<option value="5"> Enviar Cotizacion </option>
											<option value="6"> Pospuesto </option>
											<option value="7"> En revision </option>
											<option value="8"> Ganada </option>
											<option value="9"> Perdida </option>
										</select>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
    document.title = "Near Solution | Listado de Usuarios";
    
	$('.datepicker').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
</script>
