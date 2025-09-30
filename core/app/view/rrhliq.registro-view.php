<?php 
// Reacion de las liquidaciones
$persons = PersonData::getTodos(); 
$despidos = OperationTypeData::getByType('Liquidaciones');

$hoy = date("Y-m-d H:i:s");

if(isset($_GET['id'])){
	$mensaje = "modificar los datos adicionales de una liquidaci&oacute;n";
    $enlaces = "Modificar";

	$valores = PersonData::getByIdLiquidacion($_GET["id"]);		
	$txt_obs = $valores->observacion;
	$txt_des = $valores->tipo_despido;	
	
	if(!isset($valores->id)){	
		$valores = PersonData::getByIdDatos($_GET["id"]);	
		$idingreso = 0;		
	}else{		
		$idingreso = $valores->id;
		var_dump($datos);
	}
	$vacac = PersonData::getByIdVacacion($_GET["id"]);
	$observa = DescuentoData::getByPerson($_GET["id"]);
	$liquida = $_GET["id"];	$total = count($observa);
	$valor = HorarioData::getByTurno($_GET["id"], 10);
	$final = $valor->ano.'-'.str_pad($valor->mes, 2, "0", STR_PAD_LEFT).'-'.str_pad($valor->dia, 2, "0", STR_PAD_LEFT);

	if(!isset($vacac->id)){	
		$vacac = (object) [
           "id" => 0,
           "idperson" => 0,
           "money" => 0,
           "sueldo" => 0,
           "startwork" => $final,
           "endwork" => $final,		   
           "is_active" => 1
        ];
	}
	
	$id_person = $_GET["id"];
}else{
    $mensaje = "crear un nuevo usuario del sistema";
    $enlaces = "Crear";

    if(count($_POST)>0){
		var_dump($_POST);
        $errores = "";
		$id_person = $_POST["id_person"]; $final = $_POST["dtp_final"];
		
		$vacac = (object) [
           "id" => $_POST["id_vacaci"],
           "idperson" => $_POST["id_person"],
           "sueldo" => $_POST["money"],
           "startwork" => $_POST["dtp_start"],
           "endwork" => $_POST["dtp_stop"],		   
           "is_active" => 1
        ];
		
		$valores = (object) [
           "id" => $_POST["id_person"],
           "tipo_despido" => $_POST["id_despido"],
           "descripcion" => $_POST["puesto"],
           "sueldo" => (int) $_POST["valor"],
           "startwork" => $_POST["dtp_inicio"],
           "endwork" => $_POST["dtp_final"],	
           "observacion" => $_POST["observacion"],	   
           "is_active" => 1
        ];		
		
		$txt_obs = $valores->observacion;
		$txt_des = $valores->tipo_despido;	
		if($errores == ''){
            $user = new PersonData();
			
            $user->id = $_POST["id_vacaci"];
            $user->company = $_SESSION['id_company'];
            $user->idperson = $_POST["id_person"];
            $user->observacion = $_POST["observacion"];
            $user->startwork = $_POST["dtp_inicio"];
            $user->endwork = $_POST["dtp_final"];
            $user->sueldo = (int) $_POST["money"];
            $user->idcard = $_POST["cedula"];
				  
			if($_POST["idingreso"] == '0') {	
				$user->addFinal($_POST["id_person"], $_POST["id_despido"], 7, "Liquidacion ".$_POST["nombre"], 0, $_POST["money"], $_POST["dtp_inicio"], $_POST["dtp_final"], $_POST["observacion"]);
			}else{
                $user->update_vacacion();
			}
			
            $user->id = $_POST["id_vacaci"];
			if($_POST["id_vacaci"] == 0) { 				
                $user->addVac();				
			}else{				
                $user->update_vacacion();
			}
		}
    }else{
        $id_person = 0;
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Personal
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=rrhliq.lista"><i class="fa fa-database"></i> Personal </a></li>
		<li class="active"> Administrativo </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" id="addliquidacion" name="addliquidacion" action="index.php?view=rrhliq.registro" role="form">
	    <input type="hidden" id="idingreso" name="idingreso" value="<?php echo $idingreso; ?>">
        <input type="hidden" id="id_person" name="id_person" value="<?php echo $id_person; ?>">
		<input type="hidden" id="id_vacaci" name="id_vacaci" value="<?php echo $vacac->id; ?>">
        <div class="callout callout-danger" style="margin-bottom: 0!important;">
            <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
            <h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
            Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
        </div>
        </br>
        <div class="panel panel-default"> 
            <!-- tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_generales" data-toggle="tab" aria-expanded="false">
						<b>Datos Generales</b>
					</a>
                </li>
                <li>
                    <a href="#tab_contrato" data-toggle="tab" aria-expanded="false">
						<b>Contratos</b>
					</a>
                </li>
				<li>
                    <a href="#tab_liquida" data-toggle="tab" aria-expanded="false">
						<b>Ingresos & Egresos</b>
					</a>
                </li>
                <li>
                    <a href="#tab_observacion" data-toggle="tab" aria-expanded="false">
						<b>Observaciones</b>&nbsp;&nbsp;
						<?php if($total > 0)
								echo '<div class="box-tools pull-right">
										<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="'.$total.' observaciones">'.$total.'</span>
									  </div>';
						?>
					</a>
                </li>
            </ul>
            <div class="panel-body">
                <!-- tabs content -->
                <div class="tab-content panel">
                    <div class="tab-pane active" id="tab_generales">
                        <div class="row">
                            <!-- Datos del Usuario -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Informaci&oacute;n del Coolaborador</h3>
                                    </div>
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
                                            <div class="" id="datos">
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                    <span class="text-danger">DATOS BASICOS:</span>
                                                    </div>
                                                </div>												
												<!--- Datos de Liquidacion --->
												<div class="form-group">
													<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
													<div class="col-md-8 col-sm-5">
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
													<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Despido:</label>
													<div class="col-md-8 col-sm-5">
														<select class="select-input form-control input-sm" id="id_despido" name="id_despido">
															<option value="0" selected="selected"> Selecione... </option>
															<?php
																  foreach($despidos as $despido):
																	if($despido->id == $txt_des) $valor = 'selected'; else $valor = ''; ?>
																	<option value="<?php echo $despido->id; ?>" <?php echo $valor; ?>><?php echo $despido->name; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<label class="col-sm-2 control-label">&nbsp;</label>
													<div class="col-sm-5"></div>
												</div>
												<div class="form-group">
													<label class="col-md-3 col-sm-3 control-label"> Puesto de Trabajo: </label>
													<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo $valores->descripcion; ?>" placeholder="Puesto asignado al personal" readonly></div>
												</div>
												<div class="form-group">
													<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Ultimo Sueldo:</label>
													<div class="col-md-3 col-sm-2">
														<input type="text" class="form-control" id="money" name="money" value="<?php echo $valores->sueldo; ?>" data-mask placeholder="$ 9.999,99">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 col-sm-3 control-label"> Observaci&oacute;n:</label>
													<div class="col-md-8">
														<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="4"><?php echo $txt_obs; ?></textarea>
													</div>
												</div>							
												<div class="form-group">
													<label for="dtp_input1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Inicio de Contrato:</label>
													<div class="col-md-8 col-sm-6">
														<div class="input-group date form_date col-sm-6" data-date-format="yyyy-mm-dd">
															<input class="form-control" size="16" type="text" value="<?php echo $valores->startwork; ?>" readonly>
															<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
															<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
															<input type="hidden" id="dtp_inicio" name="dtp_inicio" value="<?php echo $valores->startwork; ?>">
														</div>
													</div>
												</div>	
												<div class="form-group">
													<label for="dtp_input2" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Termino de Contrato:</label>
													<div class="col-md-8 col-sm-6">
														<div class="input-group date form_date col-sm-6" data-date-format="yyyy-mm-dd">
															<input class="form-control" size="16" type="text" value="<?php echo $final; ?>" readonly>
															<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
															<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
															<input type="hidden" id="dtp_final" name="dtp_final" value="<?php echo $final; ?>">
														</div>
														<?php 
															$firstDate = $valores->startwork;
															$secondDate = $final;

															$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

															$years  = floor($dateDifference / (365 * 60 * 60 * 24));
															$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
															$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

															echo $years." años,  ".$months." meses y ".$days." dias";
														?>
													</div>												
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Vacaciones</h3>
                                    </div>
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
											<!--- Datos de las vacaciones --->
											<div class="form-group">
												<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Sueldos Ganados:</label>
												<div class="col-md-3 col-sm-2" align="right">
													<div align="right"><input type="text" class="form-control" id="valor" name="valor" value="<?php echo number_format($valores->sueldo,2, ",", "."); ?>" data-mask placeholder="$ 9.999,99"></div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Valor Asignado:</label>
												<div class="col-md-3 col-sm-2" align="right">
													<div align="right"><input type="text" class="form-control" id="money2" name="money2" value="<?php echo number_format($vacac->sueldo,2, ",", "."); ?>" data-mask placeholder="$ 9.999,99"></div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Inicio de vacaciones:</label>
												<div class="col-md-8 col-sm-6">
													<div class="input-group date form_date col-md-6" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_start" data-link-format="yyyy-mm-dd">
														<input class="form-control" size="16" type="text" id="dtp_start" name="dtp_start" value="<?php echo $vacac->startwork; ?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>											
											<div class="form-group">
												<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Termino de Vacaciones:</label>
												<div class="col-md-8 col-sm-6">
													<div class="input-group date form_date col-md-6" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_stop" data-link-format="yyyy-mm-dd">
														<input class="form-control" size="16" type="text" id="dtp_stop" name="dtp_stop" value="<?php echo $vacac->endwork; ?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													</div>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
                    </div>
					<div class="tab-pane" id="tab_contrato">
                        <div class="row">						
                            <!-- Informacion personal Operativo -->
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Datos de Ingresos</h3>
                                    </div>
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
											<!--- Datos de Liquidacion --->
											<table id="viewactivo" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th style="width: 10%"><div align="center">Dias</div></th>
														<th style="width: 12%"><div align="center">Periodo</div></th>
														<th style="width: 20%"><div align="center">Sueldo</div></th>
														<th style="width: 20%"><div align="center">Decimo 3ro.</div></th>
														<th style="width: 20%"><div align="center">Decimo 4to.</div></th>
														<th><div align="center">Estado</div></th>
													</tr>
												</thead>
												<tbody>
													<?php
														$products = NominaData::getByIdRubro($id_person, 1);
														
														foreach($products as $tables) {																
															$valor=count(HorarioData::getByIdHorario($tables->client, $tables->person, $tables->mes, $tables->ano, 2));
															//var_dump($tables);
															
															//$startwork = str_pad($tables->dia, 2, "0", STR_PAD_LEFT).'-'.str_pad($tables->mes, 2, "0", STR_PAD_LEFT).'-'.$tables->ano;
															echo '<tr>';
																echo '<td><div align="center">'.str_pad($valor, 2, "0", STR_PAD_LEFT).'</div></td>';
																echo '<td><div align="center">'.str_pad($tables->mes, 2, "0", STR_PAD_LEFT).'-'.$tables->ano.'</div></td>';
																echo '<td><div align="center">'.$tables->monto.'</div></td>';
																echo '<td><div align="center">'.($tables->monto/12).'</div></td>';
																echo '<td><div align="center">'.(($tables->monto/360)*30).'</div></td>';
																echo '<td>'.$tables->estado.'</td>';
															echo '</tr>';
														}														
														/* $resultado = count($products); 
														
														$j=1; $subtotal=0;
														if($resultado > 0){
															
														} */
													?>
												</tbody>
											</table> 
										</div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>            
                    <div class="tab-pane" id="tab_liquida">
                        <div class="row">						
							<div class="col-md-12">
                                <div class="box box-default box-solid"> <!-- collapsed-box -->
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Datos Laborales</h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
                                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                                    Agregar/Modificar
                                                </button>
                                            </div>											
                                        </br></br>
										<!-- Informacion personal Operativo -->
										<div class="col-md-6">
											<!--- Datos de Liquidacion --->
											<table id="viewactivo" class="table table-bordered table-hover">						
												<caption><div align="center">Resumen de Ingresos</div></caption>
												<thead>
													<tr>
														<th style="width: 20%"><div align="center">Dias</div></th>
														<th><div align="center">Periodo</div></th>
														<th style="width: 20%"><div align="center">Sueldo</div></th>
													</tr>
												</thead>
												<tbody>
													<?php
														$users = PersonData::getValores($id_person, 'I');		
														$resultado = count($users); 
														
														$subtotalI=0;
														if($resultado > 0){
															foreach($users as $tables) {																
																echo '<tr>';
																	echo '<td><div align="center">'.$tables->startwork.'</div></td>';
																	echo '<td>'.$tables->tipo_contrato .'</td>';
																	echo '<td><div align="right">'.number_format($tables->sueldo,2, ",", ".").'</div></td>';
																echo '</tr>';																
																$subtotalI=$subtotalI+$tables->sueldo;
															}
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="2">Total</td>
														<td headers="hours"><div align="right"><?php echo number_format($subtotalI,2, ",", "."); ?></div></td>
													</tr>
												</tfoot>
											</table> 
										</div>                            
										<!-- Informacion personal Operativo -->
										<div class="col-md-6">
											<!--- Datos de Liquidacion --->
											<table id="viewactivo" class="table table-bordered table-hover">												
												<caption><div align="center">Resumen de Egresos</div></caption>
												<thead>
													<tr>
														<th style="width: 20%"><div align="center">Dias</div></th>
														<th><div align="center">Periodo</div></th>
														<th style="width: 20%"><div align="center">Sueldo</div></th>
													</tr>
												</thead>
												<tbody>
													<?php
														$users = PersonData::getValores($id_person, 'E');		
														$resultado = count($users); 
														
														$subtotalE=0;
														if($resultado > 0){
															foreach($users as $tables) {																
																echo '<tr>';
																	echo '<td><div align="center">'.$tables->startwork.'</div></td>';
																	echo '<td>'.$tables->tipo_contrato .'</td>';
																	echo '<td><div align="right">'.number_format($tables->sueldo,2, ",", ".").'</div></td>';
																echo '</tr>';
																$subtotalE=$subtotalE+$tables->sueldo;
															}
														}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="2">Total</td>
														<td headers="hours"><div align="right"><?php echo number_format($subtotalE,2, ",", "."); ?></div></td>
													</tr>
												</tfoot>
											</table> 
										</div>
                                        </div>
                                    </div>
									<div class="box-footer">
									  <div class="pull-right">
										Total Liquido: <?php echo number_format(($subtotalI-$subtotalE),2, ",", "."); ?>
									  </div>
									</div>
                                    <!-- pop up fechas Ingreso y Salida del empleado -->
                                    <div id="dlg_fechas_empresa" class="modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Liquidaci&oacute;n del empleado</h3>
                                                        <div class="box-tools pull-right">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                        </div><!-- /.box-tools -->
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body" style="display: block;">
                                                        <div id="finiquito"></div>
                                                        <div class="form-group">
                                                            <label class="col-md-4 col-sm-5 control-label"><span class="text-danger">*</span> Tipo de Rubro:</label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <select class="select-input form-control input-sm" id="id_rubro" name="id_rubro">
                                                                    <option value="0" selected="selected"> Selecione... </option>                                                                    
                                                                    <option value="I"> Ingresos </option>																	
                                                                    <option value="E"> Egresos </option>
                                                                </select>
                                                            </div>
                                                        </div>														
														<div class="form-group">
															<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha de inicio:</label>
															<div class="col-md-8 col-sm-6">
																<div class="input-group date form_date col-md-8" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="inifecha" data-link-format="yyyy-mm-dd">
																	<input class="form-control" size="16" type="text" id="inifecha" name="inifecha" value="" readonly>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha de final:</label>
															<div class="col-md-8 col-sm-6">
																<div class="input-group date form_date col-md-8" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="finfecha" data-link-format="yyyy-mm-dd">
																	<input class="form-control" size="16" type="text" id="finfecha" name="finfecha" value="" readonly>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
																	<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
																</div>
															</div>
														</div>											
														<div class="form-group">
															<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
															<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="rubro" name="rubro" value="" placeholder="Descripcion del rubro"></div>
														</div>														
														<div class="form-group">
															<label class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Monto:</label>
															<div class="col-md-3 col-sm-2">
																<input type="text" class="form-control" id="montoIE" name="montoIE" value="" data-mask placeholder="$ 9.999,99">
															</div>
														</div>
                                                    </div>
                                                <div class="modal-footer">
                                                    <button id="agregar_fechas_empresa" class="btn btn-success">
                                                        <span class="glyphicon glyphicon-floppy-disk"></span> Grabar
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        <span class="glyphicon glyphicon-remove"> </span> Aceptar
                                                    </button>
                                                </div>
                                            </div> <!-- /.modal-content -->
                                        </div> <!-- /.modal-dialog -->
                                    </div> <!--/ END modal -->
                                </div>
                            </div>
                        </div>
                    </div>   
					<div class="tab-pane" id="tab_observacion">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="panel panel-default">
                                    <!-- panel heading/header -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Descuentos de los departamentos</h3>
                                    </div>
                                    <!--/ panel heading/header -->
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
                                            <div class="" id="fisicos">  
												<?php 
													if($total > 0){
														foreach($observa as $tables) {
															if($tables->depart == '7')
																echo '<div class="form-group">
																		<label class="col-sm-4 control-label"> Descuentos de Logistica:</label>
																		<div class="col-sm-8">
																			<textarea class="form-control" placeholder="Descuentos generados por el guardia" rows="4" cols="50">'.$tables->observacion.'</textarea>
																		</div>
																	  </div>';
															else															
																echo '<div class="form-group">
																		<label class="col-sm-4 control-label"> Descuentos de Operaciones:</label>
																		<div class="col-sm-8">
																			<textarea class="form-control" placeholder="Descuentos generados por el guardia" rows="4" cols="50">'.$tables->observacion.'</textarea>
																		</div>
																	  </div>';
														}
													}else{
														echo '<div class="callout callout-success">
																<h4>No hay observaciones!</h4>
																<p>No hay descuentos de parte de los departamentos involucrados para ser aplicados a esta liquidaci&oacute;n.</p>
															  </div>';
													}
												?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
                    </div>
                </div>
            </div>
	    </div>      
  	</form>
  </div>
</section>
<div class="text-right">
  <a href="#" id="js_up" class="ir-arriba" title="Volver arriba">
    <span class="fa-stack">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
    </span>
  </a>
</div>
<!--/ END To Top Scroller -->
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de Liquidacion";
	
	$('.datepicker').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //invocamos al objeto (window) y a su método (scroll), solo se ejecutara si el usuario hace scroll en la página
    $(window).scroll(function(){
      if($(this).scrollTop() > 300){ //condición a cumplirse cuando el usuario aya bajado 301px a más.
        $("#js_up").slideDown(300); //se muestra el botón en 300 mili segundos
      }else{ // si no
        $("#js_up").slideUp(300); //se oculta el botón en 300 mili segundos
      }
    });

    //creamos una función accediendo a la etiqueta i en su evento click
    $("#js_up i").on('click', function (e) {
      e.preventDefault(); //evita que se ejecute el tag ancla (<a href="#">valor</a>).
      $("body,html").animate({ // aplicamos la función animate a los tags body y html
        scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      },700); //el valor 700 indica que lo ara en 700 mili segundos
      return false; //rompe el bucle
    });
  });
</script>
<script type="text/javascript">
    $(function(){
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
            $person = $('#id_person').val();
            $despido = $('#id_rubro').val();
			$rubro = $('#rubro').val();			
			$monto = $('#montoIE').val();
			$inifecha = $('#inifecha').val();
			$finfecha = $('#finfecha').val();
			//alert('Despido: ' + $despido + 'Rubro: ' + $rubro + 'Monto: ' + $monto + 'Fecha: ' + $inifecha + 'Fehas: ' + $finfecha);
			if($despido == 0 || $rubro == '' || $monto == '' || $inifecha == '' || $finfecha == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				// Añadimos la imagen de carga en el contenedor 
				$('#finiquito').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor espere...!!!</div>');

				$.ajax({
					type: "POST",
					url: "ajax/contrato.php?despido="+$despido+"&rubro="+$rubro+"&monto="+$monto+"&inifecha="+$inifecha+"&finfecha="+$finfecha+"&person="+$person,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
						$('#finiquito').fadeIn(1000).html(data);
						window.location="index.php?view=rrhliq.registro&id="+$person;
					}
				});
			}

            return false;
        }) 
    });
</script>