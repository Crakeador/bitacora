<?php
// Ingreso de las observaciones de Logistica
$persons = PersonData::getTodos(); 

if(isset($_GET["id"])){
	$mensaje = "modificar los datos adicionales de una liquidaci&oacute;n";
    $enlaces = "Modificar";

	$valores = PersonData::getByIdDatos($_GET["id"]);	
	$valor = DescuentoData::getById($_GET["id"]);
	
	$person = $_GET["id"];
	$liquida = $valor->id;
}else{
	if(isset($_POST["idperson"])){ 
		$user = new DescuentoData();
		$user->id = $_POST["liquida"];
		$user->idperson = $_POST["id_person"];
		$user->depart = $_SESSION["depart"];
		$user->observacion = $_POST["observacion"];
		$user->user_name = $_SESSION["user_name"];
		
		if($_POST["liquida"] == '')
			$user->add();
		else
			$user->update();
	}

	Core::redir('descuento'); 
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=descuento"><i class="fa fa-book"></i> Lista de liquidaci&oacute;n </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
				<form class="form-horizontal" id="datos_prestamo" role="form" action="index.php?view=observacion" method="post">
					<input type="hidden" name="hijos" id="hijos" value="<?php echo $valores->hijos; ?>">
					<input type="hidden" name="tipo_contrato" id="tipo_contrato" value="<?php echo $valores->tipo_contrato; ?>">
					<input type="hidden" name="cargo" id="cargo" value="<?php echo $valores->cargo; ?>">					
					<input type="hidden" name="idperson" id="idperson" value="<?php echo $person; ?>">
					<input type="hidden" name="liquida" id="liquida" value="<?php echo $liquida; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Detalle del la liquidaci&oacute;n</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-5 col-sm-5">
									<?php 
										if($liquida == 0){
											echo '<select class="select-input form-control input-sm select2" id="id_person" name="id_person" onchange="javascript:location.href=\'index.php?view=rrhliq.registro&person=\'+value;">
												    <option value="0" selected="selected"> Selecione... </option>';												
													foreach($persons as $person){
														if($person->id == $valores->id) $valor = 'selected'; else $valor = ''; 
														echo '<option value="'.$person->id.'" '.$valor.'>'.$person->name.'</option>';
													}
											echo '</select>';
										}else{
											echo '<input type="text" class="form-control" id="nombre" name="nombre" value="'.$valores->name.'">';
										}
									?>
				                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Puesto de Trabajo:</label>
								<div class="col-md-5 col-sm-5"><input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo $valores->descripcion; ?>" placeholder="Puesto asignado al personal"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Ultimo Sueldo:</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="money" name="money" value="<?php echo $valores->sueldo; ?>" data-mask placeholder="$ 9.999,99">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"> Observaci&oacute;n:</label>
								<div class="col-md-6">
									<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="4"><?php if(isset($valores->observacion)) echo $valores->observacion; else echo $valor->observacion; ?></textarea>
								</div>
							</div>							
							<div class="form-group">
								<label for="dtp_input1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Inicio de Contrato:</label>
								<div class="col-md-6 col-sm-6">
									<div class="input-group date form_date col-sm-6" data-date-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $valores->startwork; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										<input type="hidden" id="dtp_start" name="dtp_start" value="<?php echo $valores->startwork; ?>">
									</div>
								</div>
							</div>	
							<div class="form-group">
								<label for="dtp_input1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Termino de Contrato:</label>
								<div class="col-md-6 col-sm-6">
									<div class="input-group date form_date col-sm-6" data-date-format="yyyy-mm-dd">
										<input class="form-control" size="16" type="text" value="<?php echo $valores->endwork; ?>" readonly>
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										<input type="hidden" id="dtp_input" name="dtp_input" value="">
									</div>
								</div>
							</div>							
							<button type="submit" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Guadar 
							</button>
							</br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script>document.title = "Registro de descuentos"</script>
<script type='text/javascript'>
	$("#datos_prestamo").submit(function(){
		var nombre = $("#id_person").val();
		var descuento = $("#id_despido").val();
		var valor = $("#sueldo").val();
		var id_motivo = $("#id_motivo").val();
		var dtp_input = $("#dtp_input").val();
		var sueldo = parseInt(valor);

		if(id_person == null || id_person == 0) {
			sweetAlert('Error...!!!', 'Usted debe de seleccionar el personal del formulario.', 'error');
			return false;
		}else{
			if(sueldo == null || sueldo.length == 0) {
				sweetAlert('Error...!!!', 'Usted debe de complerar el numero de las cuotas.', 'error');
				return false;
			}
		}
	});
</script>
