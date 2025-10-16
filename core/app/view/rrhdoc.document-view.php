<?php
// Registro de Sansiones de los Agentes
$persons = PersonData::getAll();
$users = UserData::getAll();

$fecha = date("Y-m-d");

if(isset($_GET['id'])){
    $mensaje = "modificar la sancion de un usuario";
    $enlaces = "Modificar";
    $documen = FaltaData::getById($_GET['id']);
	$documen_id = $_GET['id'];
}else{
    $mensaje = "crear una sancion de un usuario";
    $enlaces = "Crear";

	if(count($_POST)>0){
		$user = new FaltaData();
		$user->id = $_POST["documen_id"];
		$user->idperson = $_POST["idperson"];
		$user->tipo_documen = $_POST["tipo"];
		$user->fecha_doc = $_POST["dtp_input"];
		$user->numero = $_POST["nro_documento"];
		$user->tipo = 0;
		$user->turno = 0;
		$user->motivo = $_POST["motivo"];
		$user->documento = "";
		$user->observacion = "";
		$user->firmo = $_POST["iCosto"];

		if($_POST["documen_id"] == 0)
			$user->ingresa();
		else
			$user->guardar();

		Core::redir('rrhdoc.lista');
	}else{		
		$documen = (object) [
			"tipo_documen" => "",
			"motivo" => "",
			"numero" => "",
			"fecha" => $fecha,
			"firmo" => "2"
		];
		$documen_id = 0;
	}
}

$var = '<option value="0" selected="selected"> Selecione... </option>'; $valor = '';
if($documen->tipo_documen == 1) {
	$valor1 = 'selected="selected"'; $valor2 = ''; $valor3 = '';
}elseif($documen->tipo_documen == 2) {
	$valor1 = ''; $valor2 = 'selected="selected"'; $valor3 = '';
}elseif($documen->tipo_documen == 3) {
	$valor1 = ''; $valor2 = ''; $valor3 = 'selected="selected"'; 
}
$var .= '<option value="1" '.$valor1.'>Memorandum</option>';
$var .= '<option value="2" '.$valor2.'>Llamado de atencion</option>';
$var .= '<option value="3" '.$valor3.'>Faltas</option>';

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=rrhdoc.lista"><i class="fa fa-barcode"></i> Sanciones </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
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
				<form class="form-horizontal" method="post" id="documentos" action="index.php?view=rrhdoc.document" role="form">
					<input type="hidden" id="documen_id" name="documen_id" value="<?php echo $documen_id; ?>">	
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Reporte de sanciones de los agentes</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Documento:</label>
								<div class="col-md-4 col-sm-4">
									<select class="select-input form-control input-sm" id="tipo" name="tipo">
										<?php echo $var; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-5 col-sm-5">
									<select class="select-input form-control input-sm" id="idperson" name="idperson">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($persons as $person):
												if($documen_id == 0){
													// Sin accion
												}else{											
													if($person->id == $documen->idperson) $valor = 'selected="selected"'; else $valor = ''; 
												} ?>
												<option value="<?php echo $person->id; ?>" <?php echo $valor; ?>><?php echo utf8_encode($person->name); ?></option>
											<?php endforeach;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Motivo de la falta:</label>
								<div class="col-md-6">
									<textarea class="form-control input-sm" cols="50%" id="id_motivo" name="motivo" rows="4" required title="Debe indicar el motivo de la falta"><?php echo $documen->motivo; ?></textarea>
								</div>
							</div>
							<div class="form-group">
				                <label for="dtp_input1" class="col-md-3 control-label"><span class="text-danger">*</span> Fecha de la comunicaci&oacute;n:</label>
								<div class="col-sm-6">
					                <div class="input-group date form_datetime col-sm-6" data-date-format="yyyy-mm-dd">
						                <input class="form-control" size="10" type="text" value="<?php echo $documen->fecha_doc; ?>" readonly>
						                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										<input type="hidden" name="dtp_input" value="<?php echo $fecha; ?>">
								    </div>
								</div>
								<input type="hidden" id="dtp_input1" value="" /><br/>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><span class="text-danger">*</span> Nro. Documento:</label>
								<div class="col-md-2 col-sm-3">
									<input class="text-field form-control input-sm" id="nro_documento" name="nro_documento" type="text" value="<?php echo $documen->numero; ?>" required minlength="9" pattern="^[0-9]{1}[0-9]{1}[0-9]{1}[0-9]{1}[-][1-2]{1}[0-9]{1}[0-9]{1}[0-9]{1}$" title="Debe de utilizar el formato 0001-2017">
								</div>
								<label class="col-sm-3 control-label">&nbsp;</label>
								<div class="col-sm-6">
									<span class="text-danger">Se firmo el documento...?</span>
									<div class="radiobutton">
										<input type="radio" name="iCosto" value="1" <?php if($documen->firmo == 1) echo 'checked'; ?>> Si
										<input type="radio" name="iCosto" value="2" <?php if($documen->firmo == 2) echo 'checked'; ?>> No
									</div>
								</div>
							</div>
							</br>
						</div>
					</div>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar Falta</button>
				</form>
			</div>
		</div>
	</div>
	</br>
</section>
<!--/ END To Top Scroller -->
<script>
	$(document).ready(function(){
		$('input').iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-red'
		});
	});
</script>