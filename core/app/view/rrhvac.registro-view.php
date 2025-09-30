<?php
$documen = DocumentoData::getAll();
$persons = PersonData::getAll();
$users = UserData::getAll();

$fecha = date("Y-m-d");

if(isset($_GET["id"])){
	$mensaje = "modificar los datos de las vacaciones";
    $enlaces = "Modificar";

	$valores = PersonData::getByCodigo($_GET["id"]);
	$vacacion = $_GET["id"];

	$registro = (object) $valores[0];
}else{
	$mensaje = "agregar un nuevo grupo adicional";
    $enlaces = "Agregar";
	
	if(count($_POST)>0){ 
		$registro = new PersonData();

		$registro->id = $_POST["idperson"];
		$registro->startwork = $_POST["dtp_input"];
		$registro->endwork = $_POST["dtp_output"];		
		$registro->dias = $_POST["dias"];
		$registro->observacion = strtoupper($_POST["observacion"]);
	
		if($_POST["vacacion"] == 0){
			$registro->addVac();
		}else{
			$registro->id = $_POST["vacacion"];
			$registro->update_vacacion();
		}
		Core::redir('rrhvac.lista');
	}else{
		$vacacion = 0; 
		$registro = (object) [
			"dias" => "",
			"startwork" => date("Y-m-d"),	
			"endwork" => date("Y-m-d"),			
			"observacion" => null
		];
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small><?php echo $mensaje; ?></small> 
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=rrhvac.lista"><i class="fa fa-calendar"></i> Lista de vacaciones </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="container-fluid">
		<div class="row">
			<input type="hidden" id="ndetalles" value="2">
			<!-- Dialogo para seleccionar una rubro -->
			<p class="alert alert-info">
				<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
				- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
			</p>
			<form class="form-horizontal" method="post" id="datos_vacaciones" action="index.php?view=rrhvac.registro" role="form">
				<input type="hidden" name="vacacion" id="vacacion" value="<?php echo $vacacion; ?>">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Registro de las vacaciones asignadas</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-3 control-label"><span class="text-danger">*</span>Nombre:</label>
							<div class="col-md-5 col-sm-5">
								<select class="select-input form-control input-sm select2" id="idperson" name="idperson">
									<option value="0" selected="selected"> Selecione... </option>
									<?php
										foreach($persons as $person):
										if($person->id == $registro->idperson) $valor = 'selected'; else $valor = ''; ?>
											<option value="<?php echo $person->id; ?>" <?php echo $valor; ?>><?php echo strtoupper($person->name); ?></option>
										<?php endforeach;
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="dtp_input1" class="col-md-3 control-label"><span class="text-danger">*</span> Inicio de Vacaciones:</label>
							<div class="col-md-4 col-sm-5">
								<div class="input-group date form_date col-sm-5" data-date-format="yyyy-mm-dd">
									<input id="dtp_input" name="dtp_input" class="form-control datepicker" size="10" type="text" value="<?php echo $registro->startwork; ?>">
									<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="dtp_input2" class="col-md-3 control-label"><span class="text-danger">*</span> Fin de Vacaciones:</label>
							<div class="col-md-4 col-sm-5">
								<div class="input-group date form_date col-sm-5" data-date-format="yyyy-mm-dd">
									<input id="dtp_output" name="dtp_output" class="form-control datepicker" size="10" type="text" value="<?php echo $registro->endwork; ?>">
									<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><span class="text-danger">*</span> Dias tomados:</label>
							<div class="col-md-1 col-sm-1"><input type="text" class="form-control" id="dias" name="dias" maxlength="2" data-mask placeholder="99" value="<?php echo $registro->dias; ?>"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label"> Observaci&oacute;n:</label>
							<div class="col-md-5">
								<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="4" required title="Debe indicar el motivo de la falta"><?php echo $registro->observacion; ?></textarea>
							</div>
						</div>
						</br>
					</div>
				</div>
			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar </button>
			</form>
		</div>
	</div>
	<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
</section>
