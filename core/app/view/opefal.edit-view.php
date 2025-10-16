<?php

$persons = PersonData::getAllTipo(3, 1); 
$users = UserData::getAll();

if(isset($_GET["falta"])){
	$user = PuestoData::getByIdPersonas($_GET["id"]);
	$vacio = false;
}else{
	if(isset($_GET["id"])){
		$user = PuestoData::getByIdFaltaNew($_GET["id"]);
		$vacio = true;		
	}else{
		if($_POST['falta_id'] == 0){
			$fecha = explode("/", $_POST["fecha_doc"]);

			$var = str_replace('_', '', $_POST["money"]);
			$var = str_replace('.', '', $var);
			$var = str_replace(',', '.', $var);

			$user = new FaltaData();
			$user->id = $_POST["falta_id"];
			$user->company = $_SESSION["id_company"];	
			$user->idperson = $_POST["person_id"];			
			$user->responsable = $_POST["person_id"];
			$user->idhorario = $_POST["horario_id"]; 
			$user->fecha_doc = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
			$user->tipo_documen = 3;
			$user->numero = "";
			$user->tipo = $_POST["tipo"];
			$user->turno = $_POST["turno"];
			$user->motivo = $_POST["motivo"];
			$user->comunico = $_POST["iComunico"];
			$user->fecha = $_POST["dtp_input"];
			$user->idpersona = $_POST["persona"];
			$user->respaldo = $_POST["iRespaldo"];
			$user->documento = $_POST["documento"];
			$user->cubierto_por = $_POST["cubierta"];
			$user->costo = $var;
			$user->quien = $_POST["iCubre"];
			$user->pago = $_POST["iCosto"];
			$user->firmo = $_POST["iFirmo"];
			$user->id = $_SESSION["ip"];

			$user->add();
			print "<script>window.location='index.php?view=opefal.lista';</script>"; 
		}
	}
}
$hoy = date("Y-m-d H:i:s");

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Operaciones
		<small>reporte de faltas de los agentes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=opefal.lista"><i class="fa fa-database"></i> Operaciones </a></li>
		<li class="active"> Faltas </li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<input type="hidden" id="ndetalles" value="2">
	<!-- Dialogo para seleccionar una cuenta -->
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=opefal.edit" role="form">
			<input type="hidden" name="horario_id" value="<?php echo $_GET["id"]; ?>">
			<input type="hidden" name="person_id" value="<?php if($vacio) echo $user->idperson; else echo 0; ?>">
			<input type="hidden" name="falta_id" value="<?php if($vacio) echo $user->id; else echo 0; ?>">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Reporte de Faltas de Dobladas</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-md-6 col-sm-3">
							<span class="text-danger">REPORTE DE FALTAS:</span>
						</div>
						<div class="col-sm-4">
							<span class="text-danger">REPORTE DE DOBLADAS:</span>
						</div>
					</div>
					<div class="form-group">
						<label for="agente" class="col-md-2 col-sm-3 control-label">Nombre:</label>
						<div class="col-md-3 col-sm-4">
							<input class="text-field form-control input-sm" id="agente" name="agente" type="text" value="<?php echo $user->agente; ?>" readonly>
						</div>
						<label for="cubierta" class="col-sm-3 control-label"><span class="text-danger">*</span> Falta cubierta por:</label>
						<div class="col-sm-3">
							<select class="select-input form-control input-sm" id="cubierta" name="cubierta">
								<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($persons as $person):?>
										<option value="<?php echo $person->id; ?>" <?php if($person->id==$user->cubierto_por) echo 'selected="selected"'; ?>><?php echo utf8_encode($person->lastname).' '.utf8_encode($person->lastname2).utf8_encode($person->name).' '.utf8_encode($person->name2);?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="tipo" class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Falta:</label>
						<div class="col-md-3 col-sm-4">
							<select class="select-input form-control input-sm" id="tipo" name="tipo">
								<option value="1" <?php if($user->tipo==1) echo 'selected="selected"'; ?>> Falta programada </option>
								<option value="2" <?php if($user->tipo==2) echo 'selected="selected"'; ?>> Falta justificada y avisada </option>
								<option value="3" <?php if($user->tipo==3) echo 'selected="selected"'; ?>> Falta injustificada </option>
								<option value="4" <?php if($user->tipo==4) echo 'selected="selected"'; ?>> Falta en feriado o fiesta </option>
							</select>
						</div>
						<label for="iCubre" class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-5">
							<span class="text-danger">Indique el cargo de quien cubre:</span>
							<div class="radiobutton">
								<input type="radio" name="iCubre" value="1" <?php if($user->quien==1) echo 'checked'; ?>> Agente Fijo
								<input type="radio" name="iCubre" value="2" <?php if($user->quien==2) echo 'checked'; ?>> Saca Franco
								<input type="radio" name="iCubre" value="3" <?php if($user->quien==3) echo 'checked'; ?>> Supervisor
								<input type="radio" name="iCubre" value="4" <?php if($user->quien==4) echo 'checked'; ?>> Al llamado
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="fecha_doc" class="col-md-2 col-sm-3 control-label">Fecha de la Falta:</label>
						<div class="col-md-2 col-sm-3">
							<input class="text-field form-control input-sm" name="fecha_doc" id="fecha_doc" type="text" value="<?php echo $user->falta; ?>" readonly>
						</div>
						<label for="iCosto" class="col-sm-3 control-label">&nbsp;</label>
						<div class="col-sm-5">
							<span class="text-danger">Gener&oacute; alg&uacute;n costo...?</span>
							<div class="radiobutton">
								<input type="radio" name="iCosto" value="1" <?php if($user->pago==1) echo 'checked'; ?>> Si
								<input type="radio" name="iCosto" value="2" <?php if($user->pago==2) echo 'checked'; ?>> No
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="descripcion" class="col-sm-2 col-sm-3 control-label">Puesto de servicio:</label>
						<div class="col-md-4 col-sm-4">
							<input class="text-field form-control input-sm" id="descripcion" name="descripcion" value="<?php echo $user->descripcion; ?>" type="text" readonly>
						</div>
						<label for="money" class="col-sm-2 control-label"><span class="text-danger">*</span> Pago recibido:</label>
						<div class="col-sm-2"><input type="text" class="form-control" id="money" name="money" value="<?php echo $user->costo; ?>" data-mask placeholder="$ 9.999,99" required></div>
					</div>
					<div class="form-group">
						<label for="turno" class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Turno:</label>
						<div class="col-md-2 col-sm-4">
							<select class="select-input form-control input-sm" id="turno" name="turno">
								<option value="1" <?php if($user->turno==1) echo 'selected="selected"'; ?>> Diurno </option>
								<option value="2" <?php if($user->turno==2) echo 'selected="selected"'; ?>> Nocturno </option>
							</select>
						</div>
						<label for="iFirmo" class="col-sm-3 control-label">&nbsp;</label>
						<div class="col-sm-5">
							<span class="text-danger">Firmo el documento...?</span>
							<div class="radiobutton">
								<input type="radio" name="iFirmo" value="1" <?php if($user->firmo==1) echo 'checked'; ?>> Si
								<input type="radio" name="iFirmo" value="2" <?php if($user->firmo==2) echo 'checked'; ?>> No
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="motivo" class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Motivo de la falta:</label>
						<div class="col-md-4">
							<textarea class="form-control input-sm" cols="50%" id="motivo" name="motivo" rows="4" required><?php echo $user->motivo; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<span class="text-danger">Comunic&oacute; con antelaci&oacute;n la falta...?</span>
							<div class="radiobutton">
								<input type="radio" name="iComunico" value="1" <?php if($user->comunico==1) echo 'checked'; ?>> Si
								<input type="radio" name="iComunico" value="2" <?php if($user->comunico==2) echo 'checked'; ?>> No
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="fecha_dtp" class="col-md-2 control-label"><span class="text-danger">*</span> Indique fecha y hora de la comunicaci&oacute;n:</label>
						<div class="col-sm-10">
							<div class="input-group date form_datetime col-sm-3" data-date-format="yyyy-mm-dd HH:ii:ss">
								<input id="fecha_dtp" name="fecha_dtp" class="form-control" size="16" type="text" value="<?php echo $hoy; ?>" readonly>
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
								<input type="hidden" name="dtp_input" value="<?php echo $hoy; ?>">
							</div>
						</div>
						<input type="hidden" id="dtp_input1" value="" /><br/>
					</div>
					<div class="form-group">
						<label for="persona" class="col-sm-2 col-sm-3 control-label"> Indique a qui&eacute;n comunic&oacute;:</label>
						<div class="col-md-3 col-sm-4">
							<select class="select-input form-control input-sm" id="persona" name="persona">
								<option value="0" selected="selected"> No aplica </option>
								<?php
									foreach($users as $person):?>
										<option value="<?php echo $person->id; ?>" <?php if($person->id==$user->idpersona) echo 'selected="selected"'; ?>><?php echo utf8_encode($person->name).' '.utf8_encode($person->lastname);?></option>
									<?php endforeach;
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<span class="text-danger">Present&oacute; documento de respaldo VALIDO para justificar su falta...?</span>
							<div class="radiobutton">
								<input type="radio" name="iRespaldo" value="1" <?php if($user->respaldo==1) echo 'checked'; ?>> Si
								<input type="radio" name="iRespaldo" value="2" <?php if($user->respaldo==2) echo 'checked'; ?>> No
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="documento" class="col-sm-3 control-label"><span class="text-danger">*</span> Indique que documento VALIDO present&oacute; (entregar copia a Talento Humano):</label>
						</br>
						<div class="col-sm-4">
							<input class="text-field form-control input-sm" id="documento" name="documento" value="<?php echo $user->documento; ?>" type="text">
						</div>
					</div>
					</br>
				</div>
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar Falta</button>
			</div>
		</form>
</section>

