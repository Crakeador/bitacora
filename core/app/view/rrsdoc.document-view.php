<?php
$documen = DocumentoData::getAll();
$persons = PersonData::getAll();
$users = UserData::getAll();

$fecha = date("Y-m-d");

$rowCount = count($documen); $var = "";
for ($i = 0; $i < $rowCount; $i++) {
	$var .= '<option value="'.$documen[$i]->id.'">'.$documen[$i]->description.'</option>';
}

if(count($_POST)>0){
	$user = new DocumentoData();

	$user->idperson = $_POST["idperson"];
	$user->tipo_documen = $_POST["tipo"];
	$user->fecha_doc = $_POST["dtp_input"];
	$user->observacion = strtoupper($_POST["motivo"]);

	$user->add_doc();

	print "<script>window.location='index.php?view=rrsdoc.lista';</script>"; 
}else{	
	$documen = (object) [
		"descripcion" => "",
		"nombre" => "",
		"is_active" => "1"
	];
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>ingreso de los documentos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=rrsdoc.lista"><i class="fa fa-database"></i> Documentos </a></li>
		<li class="active"> Faltas </li>
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
				<form class="form-horizontal" method="post" id="documentos" action="index.php?view=rrsdoc.document" role="form">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Reporte de Faltas de Dobladas</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Documento:</label>
								<div class="col-md-4 col-sm-4">
									<select class="select-input form-control input-sm" id="tipo" name="tipo">
										<?php echo $var; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="idperson" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-4 col-sm-5">
									<select class="select-input form-control input-sm" id="idperson" name="idperson">
										<option value="0" selected="selected">-- SELECCIONAR --</option>
										<?php
											foreach($persons as $person):?>
												<option value="<?php echo $person->id; ?>"><?php echo utf8_encode($person->name); ?></option>
											<?php endforeach;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="id_motivo" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Motivo de la falta:</label>
								<div class="col-md-4 col-sm-5">
									<textarea class="form-control input-sm" cols="50%" id="id_motivo" name="motivo" rows="4"  required title="Debe indicar el motivo de la falta"></textarea>
								</div>
							</div>
							<div class="form-group">
				                <label for="fecha" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Fecha de la comunicaci&oacute;n:</label>
								<div class="col-sm-6">
					                <div class="input-group date form_datetime col-sm-6" data-date-format="yyyy-mm-dd">
						                <input id="fecha" class="form-control" size="10" type="text" value="<?php echo $fecha; ?>" readonly>
						                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										<input type="hidden" name="dtp_input" value="<?php echo $fecha; ?>">
								    </div>
								</div>
								<input type="hidden" id="dtp_input1" value="" /><br/>
							</div>
							</br>
						</div>
					</div>
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar Falta</button></br>
				</form>
			</div>
		</div>
	</div>
	</br></br>
</section>
