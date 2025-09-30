<?php
/*
* Modulo de Operaciones para el registro del horaio planificado de los agentes
* Modificado el: 21/11/2022
*/
ini_set('max_input_vars', 5000);

if($_SESSION["idrol"] == "6")
	$puestos = PuestoData::getAllLugar(2);
else
	$puestos = PuestoData::getAll(2);

if(!isset($_SESSION['id']))	$_SESSION['id']=1;
if(!isset($_SESSION['mes'])) $_SESSION['mes']=date("m");

if(count($_POST)>0){
	echo '<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
	      <script type="text/javascript">
			swal("Excelente", "Se actualizaron los registros", "success");
		  </script>';

	foreach($_POST as $nombre_campo => $valor){
		if(strlen($valor)>6){
			$valor = explode("-", $valor);
			if($valor[0] == 0) {
				$user = new HorarioData();
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia = $valor[3];
				$user->mes = $valor[4];
				$user->ano = $valor[5];
				$user->turno= $valor[6];
				$user->tipo = 1;
				$user->add();
			}else{
				$user = new HorarioData();
				$user->id = $valor[0];
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia = $valor[3];
				$user->mes = $valor[4];
				$user->ano = $valor[5];
				$user->turno = $valor[6];
				$user->tipo = 1;
				$user->update();
			}
		}
	}
}

if(isset($_GET['id'])){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	$lugar=0; // $_SESSION['id'];
}

if(isset($_GET['mes'])){
	if($_GET['mes'] < 10)
		$mes="0".$_GET['mes'];
	else
		$mes=$_GET['mes'];

	$_SESSION['mes']=$mes;
}else{
	$mes=$_SESSION['mes'];
}

if(!isset($_SESSION['ano'])) {
	$ano=date("Y"); 
	$_SESSION['ano']=date("Y");	
}else{
	$ano=$_SESSION['ano'];
}
$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
?>
<section class="content-header">
	<h1>
		Operaciones
		<small>planificaci&oacute;n del horario de los agentes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<form class="form-horizontal" method="post" id="addPlanificado" enctype="multipart/form-data" role="form">
	<div class="col-xs-12" style="padding: 1.5rem !important;">
		<div class="box">
		<div class="box-header with-border">		
				<div class="col-md-4 col-sm-10">
					<div class="dataTables_length" id="example_length">
						<label>Ver el reporte de asistencia de:&nbsp;
							<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='index.php?view=planificado&mes='+value;">
								<option value= "1" <?php if($mes == '01') echo 'selected'; ?>>Enero</option>
								<option value= "2" <?php if($mes == '02') echo 'selected'; ?>>Febrero</option>
								<option value= "3" <?php if($mes == '03') echo 'selected'; ?>>Marzo</option>
								<option value= "4" <?php if($mes == '04') echo 'selected'; ?>>Abril</option>
								<option value= "5" <?php if($mes == '05') echo 'selected'; ?>>Mayo</option>
								<option value= "6" <?php if($mes == '06') echo 'selected'; ?>>Junio</option>
								<option value= "7" <?php if($mes == '07') echo 'selected'; ?>>Julio</option>
								<option value= "8" <?php if($mes == '08') echo 'selected'; ?>>Agosto</option>
								<option value= "9" <?php if($mes == '09') echo 'selected'; ?>>Septiembre</option>
								<option value="10" <?php if($mes == '10') echo 'selected'; ?>>Octubre</option>
								<option value="11" <?php if($mes == '11') echo 'selected'; ?>>Noviembre</option>
								<option value="12" <?php if($mes == '12') echo 'selected'; ?>>Diciembre</option>
							</select>
						</label>
					</div>
				</div>										
				<div class="col-md-7 col-sm-10">					
					<div id="example_filter">
						Oficina:&nbsp;&nbsp;
						<label>
							<?php
								echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?view=planificado&id=\'+value;">';
								echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
									foreach($puestos as $tables) {
										if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
										echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
									}
								echo '</select>';
							?>
						</label>&nbsp;&nbsp;
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
					</div>
				</div>
			</div>	
			<div class="box-body mailbox-messages">
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-dismissable alert-info">
							<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
							<p> - Todos los campos son requeridos para completar la programacion de los turnos de trabajo.</p>
							<p> - Los turnos se identifican con las siguientes letras:&nbsp;
								<span class="number"><span class="label label-success">D</span>&nbsp;Diurno</span>,&nbsp;
								<span class="number"><span class="label label-primary">N</span>&nbsp;Nocturno</span> y
								<span class="number"><span class="label label-warning">L</span>&nbsp;Libre</span>
							</p>
						</div>
					</div>
				</div>
				<div style="height: 410px; width: 100%; overflow-x: auto;" id="example_length">
					<?php 
                    $ini="2020-01-01"; $fin=$_SESSION['ano']."-".$_SESSION['mes']."-30";
					$users = PuestoData::getByIdHorario($lugar, 3, 1, $ini, $fin);

					if(count($users) > 0): ?>
						<table id="planificado" class="table table-bordered table-hover">
							<tbody>
								<?php
									// Crea tabla de Ventas
									foreach($users as $tables) {
										echo '<tr>';
											echo '<td>';
												echo '<small>';
													echo $tables['nombre'];
													echo '</br>'.$tables['descripcion'].'-'.$tables['cargo'];
													echo '</small></br>';
													$valor=HorarioData::getByIdHorario($tables['servicio'], $tables['id'], $mes, $ano, 1);
													$resultado = count($valor);
													$dias=$dia;
													echo '<table>';
														echo '<tr>';
															for ($i = 1; $i <= $total; $i++) {
																if($dias == 1)	echo '<td><div align="center"><small><span class="text-green">LUN</span></small></div></td>';
																if($dias == 2)	echo '<td><div align="center"><small><span class="text-green">MAR</span></small></div></td>';
																if($dias == 3)	echo '<td><div align="center"><small><span class="text-green">MIE</span></small></div></td>';
																if($dias == 4)	echo '<td><div align="center"><small><span class="text-green">JUE</span></small></div></td>';
																if($dias == 5)	echo '<td><div align="center"><small><span class="text-green">VIE</span></small></div></td>';
																if($dias == 6)	echo '<td><div align="center"><small><span class="text-red">SAB</span></small></div></td>';
																if($dias == 7)	echo '<td><div align="center"><small><span class="text-red">DOM</span></small></div></td>';
																if($dias == 7) $dias = 1; else $dias++;
															}
														echo '</tr>';
													echo '<tr>';
													$iddia=0;
													for ($i = 1; $i <= $total; $i++) {
														echo '<td>';
															if($resultado > 0) {
																echo '<input type="hidden" id="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" value="'.$valor[$i-1]['id'].'-'.$tables['servicio'].'-'.$tables['id'].'-'.$i.'-'.$mes.'-'.$ano.'-'.$valor[$i-1]['turno'].'">';

																$iddia=$valor[$i-1]['id'];
																if($valor[$i-1]['turno']==1)
																	$clase = 'btn-success';
																else
																	if($valor[$i-1]['turno']==2)
																		$clase = 'btn-primary';
																	else
																		if($valor[$i-1]['turno']==3)
																			$clase = 'btn-warning';
																		else
																			$clase = 'btn-default';
															} else {
																echo '<input type="hidden" id="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" value="'.$iddia.'-'.$tables['servicio'].'-'.$tables['id'].'-'.$i.'-'.$mes.'-'.$ano.'-0">';
																$clase = 'btn-default';
															}
															echo '<button type="button" id="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" class="btn '.$clase.'" onClick="btn_NuevoOnClick('.$iddia.', '.$i.', '.$mes.', '.$ano.','.$tables['id'].','.$tables['servicio'].',\'button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\',\'hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\');">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</button>';
														echo '</td>';
													}
													echo '</tr>';
												echo '</table>';
											echo '</td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					<?php else: ?>
							<div class="alert alert-dismissable alert-danger">
								<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
								<p> - A&uacute;n no se ha reclutado a ningun agente.</p>
							</div>
					<?php endif; ?>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</form>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solutions | Planificador de horarios de agentes activos";
 	
	function btn_NuevoOnClick(id, dia, mes, ano, agente, servicio, boton, hiden) {
		var oculto = document.getElementById(hiden);
		var elemento = document.getElementById(boton);
		
		if(dia < 10) dia = "0"+dia;		
		if(mes < 10) mes = '0'+mes;

		if (elemento.className == "btn btn-default") {
			elemento.value = "D";
			elemento.className = "btn btn-success";
			oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-1";
		}else{
			if (elemento.className == "btn btn-success") {
				elemento.value = "N";
				elemento.className = "btn btn-primary";
				oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-2";
			}else{
				if (elemento.className == "btn btn-primary") {
					elemento.value = "L";
					elemento.className = "btn btn-warning";
					oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-3";
				}else{
					if (elemento.className == "btn btn-warning") {
						elemento.className = "btn btn-default";
						oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-0";
					}
				}
			}
		}
	} //
</script>

