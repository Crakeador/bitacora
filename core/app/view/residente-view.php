<?php
// Pantalla de ingreso de los clientes
$cliente = ClientData::getAll(0);

if(isset($_GET["id"])){
    $mensaje = "modificar un residente en el sistema";
    $enlaces = "Modificar";
    $client = ResidenteData::getById($_GET["id"]);
	
    $client_id = $_GET["id"];
}else{
    $mensaje = "crear un nuevo residente en el sistema";
    $enlaces = "Crear"; $error = "";

 	// Ingreso de clientes
	if(count($_POST)>0){
		if(isset($_POST["active"])) $activo=1; else $activo=0;

		if($_POST["client_id"] == 0){
			if(is_object(ResidenteData::getByCedula($_POST["cedula"]))){
			  $error = 'El CEDULA ya exite...!!!';
			}
		}

		if($error == ""){
		    $user = new ResidenteData();
			$user->idclient = $_SESSION["id_client"]; // $_POST['idclient'];
			$user->tipo = $_POST["tipo"];
			$user->cedula = $_POST["cedula"];
			$user->nombre = strtoupper($_POST["nombre"]);
			$user->email = $_POST["email"];
			$user->telefono1 = $_POST["telefono1"];
			$user->telefono2 = $_POST["telefono2"];
			$user->manzana = $_POST["manzana"];
			$user->villa = $_POST["villa"];
			$user->fecha = $_POST["fechafac"];
			$user->observacion = $_POST["observacion"];
			$user->is_active = $activo;

			if($_POST["client_id"] == 0){
				$user->add();
			}else{
			  	$user->id = $_POST["client_id"];
			  	$user->update();
			}
			Core::redir('residentes');
        }else{
			Core::alert("Error...!!!!", $error, "error");
        }

        $client_id = $_POST["client_id"];

        $client = (object) [
            "tipo" => $_POST["tipo"],
            "cedula" => $_POST["cedula"],
            "nombre" => $_POST["nombre"],
            "manzana" => $_POST["manzana"],
            "villa" => $_POST["villa"],
            "email" => $_POST["email"],
            "telefono1" => $_POST["telefono1"],
            "telefono2" => $_POST["telefono2"],
            "fecha" => $_POST["fechafac"],
            "observacion" => $_POST["observacion"],
            "is_active" => $activo
        ];
	}else{
        $client_id = 0;

        $client = (object) [
            "tipo" => "Residente",
            "cedula" => "",
            "nombre" => "",
            "manzana" => "",
            "villa" => "",
            "email" => "",
            "telefono1" => "",
            "telefono2" => "",
            "fecha" => date("Y-m-d"),
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
		<li><a href="./index.php?view=catres.lista"><i class="fa fa-database"></i> Residentes </a></li>
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
			<form class="form-horizontal" method="post" id="addtask" action="index.php?view=catres.residents" role="form">
				<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
					</div>
					<div class="panel-body" style="padding: 1.5rem !important;">					
						<div class="form-group" style="display: none">
							<label for="idclient" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Cliente:</label>
							<div class="col-md-3 col-sm-4">
								<select class="select-input form-control input-sm" id="idclient" name="idclient">
									<option value="0" selected="selected"> Selecione... </option> <?php // $client->idclient
									foreach($cliente as $clients):
										if ($clients->idclient == $_SESSION["id_client"]) $valor = " selected"; else $valor = ""; ?>	
										<option value="<?php echo $clients->idclient; ?>"<?php echo $valor; ?>><?php echo $clients->nombre;?></option> <?php 
									endforeach;	?>
								</select>
							</div>
							<span class="text-danger">* Este campo es obligatorio</span>
						</div>
						<div class="form-group">
							<label for="inputEmpresa" class="col-lg-2 control-label"><span class="text-danger">*</span> C.C.</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="cedula" name="cedula" data-inputmask='"mask": "999999999-9"' data-mask placeholder="999999999-9" placeholder="123456789-0" value="<?php echo $client->cedula; ?>" title="Solo números, debe ser una cedula valida" required>
							</div>
							<div class="col-md-2 col-sm-4">
								<span class="text-danger">Que persona es:</span>
								<div class="radiobutton">
									<input type="radio" id="tipo" name="tipo" value="1" checked="checked"> Residente &nbsp;&nbsp;
									<input type="radio" id="tipo" name="tipo" value="2"> Inquilino 
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nombre:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Nombres Completos" value="<?php echo $client->nombre; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required>
							</div>								
							<label class="col-md-2 col-sm-2 control-label">Fecha de Facturaci&oacute;n:</label>
							<div class="col-md-4 col-sm-8">
								<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
									<input type="date" class="form-control" id="fechafac" name="fechafac" value="<?php echo $client->fecha; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
								</div>
							</div>
						</div>
						<div class="form-group">						
							<label class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="telefono1" name="telefono1" data-inputmask='"mask": "99-99999999"' data-mask placeholder="99-99999999" value="<?php echo $client->telefono1; ?>">
							</div>
							<label class="col-md-4 col-sm-4 control-label"> Tel&eacute;fono convencial:</label>
							<div class="col-md-2 col-sm-4">
								<input type="text" class="form-control" id="telefono2" name="telefono2" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $client->telefono2; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-sm-2 control-label">Manzana:</label>
							<div class="col-sm-1">
								<input class="text-field form-control input-sm" id="manzana" maxlength="3" name="manzana" type="text" data-inputmask='"mask": "999"' data-mask placeholder="999" placeholder="Numero de la manzana" value="<?php echo $client->manzana; ?>">
							</div>
							<label class="col-md-5 col-sm-4 control-label">Villa:</label>
							<div class="col-md-1 col-sm-4">
								<input class="text-field form-control input-sm" id="villa" maxlength="3" name="villa" type="text" data-inputmask='"mask": "999"' data-mask placeholder="999" placeholder="Numero de la villa" value="<?php echo $client->villa; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-sm-2 control-label">Correo Electronico:</label>
							<div class="col-md-4 col-sm-4">
								<input class="text-field form-control input-sm" id="email" minlength="5" maxlength="50" name="email" type="email" placeholder="Correo de la persona a facturar" value="<?php echo $client->email; ?>">
							</div>
							<label class="col-md-2 col-sm-2 control-label">Observaciones:</label>
							<div class="col-md-4">
								<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="3"><?php echo $client->observacion; ?></textarea>
							</div>
						</div>
						<input type="checkbox" id="id_active" name="active" class="js-switch" <?php if($client->is_active == 1) echo "checked"; ?> />&nbsp;&nbsp;
						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Residente activo </label>
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
	
	document.title = "Near Solutions | Entrega de dotacion";
</script>

