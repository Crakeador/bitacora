<?php 
ini_set('max_input_vars', 5000);
if($_SESSION["idrol"] == "6")
	$puestos = PuestoData::getAllLugar(2);
else
	$puestos = PuestoData::getAll(2);
	
$persons = PersonData::getAllTipo(3, 1);
$users = UserData::getAll();

/*
if(isset($_GET["falta"])){
	$user = PuestoData::getByIdPersonas($_GET["id"]);
	$vacio = false;
}else{
	$user = PuestoData::getByIdFaltaNew($_GET["id"]);
	$vacio = true;
} */

$hoy = date("Y-m-d H:i:s");
$user = (object) [
	"tipo" => "1",
	"quien" => "1",
	"pago" => "2",
	"firmo" => "0",
	"comunico" => "0",
	"falta" => $hoy,
	"turno" => "1",
	"costo" => null,
	"motivo" => "",
	"idpersona" => "0",
	"is_active" => "1"
];
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Operaciones
		<small>reporte de faltas de los agentes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=opecor.lista"><i class="fa fa-database"></i> Operaciones </a></li>
		<li class="active"> Faltas </li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<form class="form-horizontal" method="post" id="addproduct" action="<?php echo "index.php?view=opecor.new"; ?>" role="form">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Reporte de coordinaciones en Dobladas</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label">Nombre:</label>
					<div class="col-md-3 col-sm-4">
						<select class="select-input form-control input-sm" id="id_coordina" name="id_coordina">
							<option value="0" selected="selected"> Selecione... </option>
							<?php
								foreach($persons as $person):?>
									<option value="<?php echo $person->id; ?>"><?php echo utf8_encode($person->name);?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<label class="col-sm-3 control-label"><span class="text-danger">*</span> Falta cubierta por:</label>
					<div class="col-sm-3">
						<select class="select-input form-control input-sm" id="id_cubierta" name="cubierta">
							<option value="0" selected="selected"> Selecione... </option>
							<?php
								foreach($persons as $person):?>
									<option value="<?php echo $person->id; ?>"><?php echo utf8_encode($person->name); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Falta:</label>
					<div class="col-md-3 col-sm-4">
						<select class="select-input form-control input-sm" id="id_tipo" name="tipo">
							<option value="1" <?php if($user->tipo==1) echo 'selected="selected"'; ?>> Falta programada </option>
							<option value="2" <?php if($user->tipo==2) echo 'selected="selected"'; ?>> Falta justificada y avisada </option>
							<option value="3" <?php if($user->tipo==3) echo 'selected="selected"'; ?>> Falta injustificada </option>
							<option value="4" <?php if($user->tipo==4) echo 'selected="selected"'; ?>> Falta en feriado o fiesta </option>
						</select>
					</div>
					<label class="col-sm-2 control-label">&nbsp;</label>
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
					<label class="col-md-2 col-sm-3 control-label">Fecha de la Falta:</label>
					<div class="col-md-2 col-sm-3">
						<input class="text-field form-control input-sm" name="fecha_doc" id="fecha_doc" type="text" value="<?php echo $user->falta; ?>" readonly>
					</div>
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-5">
						<span class="text-danger">Gener&oacute; alg&uacute;n costo...?</span>
						<div class="radiobutton">
							<input type="radio" name="iCosto" value="1" <?php if($user->pago==1) echo 'checked'; ?>> Si
							<input type="radio" name="iCosto" value="2" <?php if($user->pago==2) echo 'checked'; ?>> No
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-3 control-label">Puesto de servicio:</label>
					<div class="col-md-4 col-sm-4">
						<label>
							<?php
								echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?view=opehor.activos&id=\'+value;">';
								echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
								foreach($puestos as $tables) {
									if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
									echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
								}
								echo '</select>';
							?>
						</label>
					</div>
					<label class="col-sm-2 control-label"><span class="text-danger">*</span> Pago recibido:</label>
					<div class="col-sm-2"><input type="text" class="form-control" id="money" name="money" value="<?php echo $user->costo; ?>" data-mask placeholder="$ 9.999,99" required></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Turno:</label>
					<div class="col-md-2 col-sm-4">
						<select class="select-input form-control input-sm" id="id_turno" name="turno">
							<option value="1" <?php if($user->turno==1) echo 'selected="selected"'; ?>> Diurno </option>
							<option value="2" <?php if($user->turno==2) echo 'selected="selected"'; ?>> Nocturno </option>
						</select>
					</div>
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-5">
						<span class="text-danger">Comunic&oacute; con antelaci&oacute;n la falta...?</span>
						<div class="radiobutton">
							<input type="radio" name="iComunico" value="1" <?php if($user->comunico==1) echo 'checked'; ?>> Si
							<input type="radio" name="iComunico" value="2" <?php if($user->comunico==2) echo 'checked'; ?>> No
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Motivo de la falta:</label>
					<div class="col-md-4">
						<textarea class="form-control input-sm" cols="50%" id="id_motivo" name="motivo" rows="4" required><?php echo $user->motivo; ?></textarea>
					</div>
					<label class="col-sm-2 col-sm-3 control-label"> Indique a qui&eacute;n comunic&oacute;:</label>
					<div class="col-md-4 col-sm-4">
						<select class="select-input form-control input-sm" id="persona_id" name="persona">
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
					<label for="dtp_input1" class="col-md-2 control-label"><span class="text-danger">*</span> Indique fecha y hora de la comunicaci&oacute;n:</label>
					<div class="col-sm-10">
						<div class="input-group date form_datetime col-sm-4" data-date-format="yyyy-mm-dd HH:ii:ss">
							<input class="form-control" size="16" type="text" value="<?php echo $hoy; ?>" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
							<input type="hidden" name="dtp_input" value="<?php echo $hoy; ?>">
						</div>
					</div>
					<input type="hidden" id="dtp_input1" value="" /><br/>
				</div>
				</br>
			</div>
		</div>
	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar Falta</button>
	</form>
</section>
