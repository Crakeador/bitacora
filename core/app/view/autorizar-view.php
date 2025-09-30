<?php
// Pantalla de ingreso de los clientes
if(isset($_GET["id"])){
    $mensaje = "modificar un residente en el sistema";
    $enlaces = "Modificar";
    $client = AutorizanData::getById($_GET["id"]);
    $client_id = $_GET["id"];
}else{
    $mensaje = "autorizar la visita de un residente";
    $enlaces = "Crear"; $error = "";

 	// Ingreso de clientes
	if(count($_POST)>0){
		if(isset($_POST["active"])) $activo=1; else $activo=0;

		if($error == ""){
			$clave = rand(111111, 999999);
		    $user = new AutorizanData();
			$user->idcompany = $_SESSION['id_company'];
			$user->idclient = $_SESSION['id_client'];
			$user->tipo = $_POST["tipo"];
			$user->cedula = $_POST["cedula"];
			$user->nombre = strtoupper($_POST["nombre"]);
			$user->email = $_POST["email"];
			$user->telefono1 = $_POST["telefono1"];
			$user->telefono2 = $_POST["telefono2"];
			$user->villa = $_POST["villa"];
			$user->manzana = $_POST["manzana"];
			$user->clave = $clave;
			$user->ini_fec = $_POST["fecha"];
			$user->observacion = $_POST["observacion"];
			$user->is_active = $activo;

			if($_POST["client_id"] == 0){
			  $user->add();
			}else{
			  $user->id = $_POST["client_id"];
			  $user->update();
			}
			Core::redir('autorizan&clave='.$clave);
        }else{
			Core::alert("Error...!!!!", $error, "error");
        }

        $client_id = $_POST["client_id"];

        $client = (object) [
            "tipo" => $_POST["tipo"],
            "cedula" => $_POST["cedula"],
            "nombre" => $_POST["nombre"],
            "villa" => $_POST["villa"],
            "manzana" => $_POST["manzana"],
            "email" => $_POST["email"],
            "telefono1" => $_POST["telefono1"],
            "telefono2" => $_POST["telefono2"],
            "fecha" => $_POST["fecha"],
            "observacion" => $_POST["observacion"],
            "is_active" => $activo
        ];
	}else{
        $client_id = 0;

        $client = (object) [
            "tipo" => "Visita",
            "cedula" => "",
            "nombre" => "",
            "contacto" => "",
            "manzana" => $_SESSION['manzana'],
            "villa" => $_SESSION['villa'],
            "email" => "",
            "telefono1" => "",
            "telefono2" => "",
            "fecha" => date("Y-m-d h:m"),
            "observacion" => "",
            "is_active" => "1"
        ];
    }
}
?>
<section class="content-header">
	<h1>
		Residentes
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=autorizan"><i class="fa fa-database"></i> Residentes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="alert alert-danger" style="<?php if(isset($_GET["error"]) == 1) echo ''; else echo 'display:none;'; ?>">
	  <strong>hoops!</strong> Hay un problema con sus datos.<br><br>
	  <ul>
		<li> Ya hay una empresa registrada con este RUC, verifique para continuar.</li>
	  </ul>
	</div>
	<div class="row">
		<input type="hidden" id="ndetalles" value="2">
		<!-- Dialogo para seleccionar una cuenta -->
		<div class="col-md-12">
			<p class="alert alert-info">
				<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
				- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
			</p>
			<!-- START panel -->
			<form class="form-horizontal" method="post" id="addtask" action="index.php?view=autorizar" role="form">
				<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
					</div>
					<div class="panel-body" style="padding: 1.5rem !important;">
						<div class="form-group">
							<label for="cedula" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> C.C.</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="cedula" name="cedula" autocomplete="off" minlength="10" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="1234567890" value="<?php echo $client->cedula; ?>" pattern="[0-9]{10}" title="Solo números, debe ser una cedula valida" required autofocus>
							</div>
							<div class="col-md-6 col-sm-4">
								<span class="text-danger">Tipo de visitante:</span>
								<div class="radiobutton">
									<input type="radio" id="tipo1" name="tipo" value="1" <?php if($client->tipo == "Visita") echo 'checked="checked"'; ?>> Visita&nbsp;&nbsp;
									<input type="radio" id="tipo2" name="tipo" value="2" <?php if($client->tipo == "Taxi") echo 'checked="checked"'; ?>> Taxi&nbsp;&nbsp;
									<input type="radio" id="tipo3" name="tipo" value="3" <?php if($client->tipo == "Entrega") echo 'checked="checked"'; ?>> Entrega&nbsp;&nbsp;
									<input type="radio" id="tipo4" name="tipo" value="4" <?php if($client->tipo == "Otros") echo 'checked="checked"'; ?>> Otros
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="nombre" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nombre:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Jhon Doe" value="<?php echo $client->nombre; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required>
							</div>								
							<label for="fecha" class="col-md-2 col-sm-2 control-label">Fecha de Ingreso:</label>
							<div class="col-md-4 col-sm-8">
								<div class="input-group date form_date col-md-8 col-sm-8" data-date-format="yyyy-mm-dd hh:ii">
									<input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo $client->fecha; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
								</div>
							</div>
						</div>
						<div class="form-group">						
							<label for="id_telefono1" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
							<div class="col-md-4 col-sm-4">
								<input type="text" class="form-control" id="id_telefono1" name="telefono1" data-inputmask='"mask": "99-99999999"' data-mask placeholder="99-99999999" value="<?php echo $client->telefono1; ?>" required>
							</div>
							<label for="id_telefono2" class="col-md-2 col-sm-2 control-label"> Tel&eacute;fono convencial:</label>
							<div class="col-md-4 col-sm-4">
								<input type="text" class="form-control" id="id_telefono2" name="telefono2" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $client->telefono2; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="manzana" class="col-md-2 col-sm-2 control-label">Manzana:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="manzana" name="manzana" maxlength="10" type="number" placeholder="Numero de la manzana" value="<?php echo $client->manzana; ?>">
							</div>
							<label for="email" class="col-md-2 col-sm-2 control-label">Correo Electronico:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="email" name="email" minlength="5" maxlength="50" type="mail" placeholder="Correo de la persona que visita" value="<?php echo $client->email; ?>" autocomplete="email">
							</div>
						</div>
						<div class="form-group">
							<label for="villa" class="col-md-2 col-sm-3 control-label">Villa:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="villa" name="villa" maxlength="10" type="text" placeholder="Numero de la villa" value="<?php echo $client->villa; ?>">
							</div>
							<label for="observacion" class="col-md-2 col-sm-2 control-label">Observaciones:</label>
							<div class="col-md-4">
								<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="3"><?php echo $client->observacion; ?></textarea>
							</div>
						</div>
						<input type="checkbox" id="active" name="active" class="js-switch" <?php if($client->is_active == 1) echo "checked"; ?> />&nbsp;&nbsp;
						<label for="active">&nbsp;&nbsp;Residente activo </label>
					</div>
				</div>
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
			</form>
		</div>
	</div>	
</section>
<link type="text/css" rel="stylesheet" href="plugins/switchery/switchery.min.css"/>
<script type="text/javascript" src="plugins/switchery/switchery.min.js"></script>
<script type='text/javascript'><!--
	var elem = document.querySelector('.js-switch');
	var init = new Switchery(elem, {
		color: 'green',
		secondaryColor: 'red',
		size: 'small'
	});	
</script>

