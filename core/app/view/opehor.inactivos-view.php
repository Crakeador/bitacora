<?php
// Modulo de Operaciones para el registro del horaio de los agentes inactivos

if($_SESSION["idrol"] == "6")
	$puestos = PuestoData::getAllLugar(2);
else
	$puestos = PuestoData::getAll(2);
	
$ano=date("Y");

if(!isset($_SESSION['id']))	$_SESSION['id']=1;
if(!isset($_SESSION['mes'])) $_SESSION['mes']=date("m");

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

if(isset($_GET['ano'])){
	$ano=$_GET['ano'];
	$_SESSION['ano']=$ano;
}else{	
	if(!isset($_SESSION['ano']))
		$_SESSION['ano']=date("Y");
	
	$ano=$_SESSION['ano'];
}

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));

?>
<section class="content-header">
	<h1>
		Agentes Inactivos
		<small>registro de la asistencia de los agentes inactivos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
</br>
<form class="form-horizontal" method="post" id="addproduct" role="form">
	<div class="col-xs-12">
		<div class="box">		
			<div class="box-header with-border"> 
				<div class="col-md-6 col-sm-10">
					<div class="dataTables_length" id="example_length">
						<label>Ver el reporte de asistencia de:&nbsp;
							<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='index.php?view=opehor.inactivos&mes='+value;">
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
						</label>&nbsp;&nbsp;
						<label>Año:&nbsp;
							<select style="width: 120px; display: inline-block;" id="ano_id" name="ano_id" class="form-control" onchange="javascript:location.href='index.php?view=opehor.inactivos&ano='+value;">
								<option value="2022" <?php if($ano == '2022') echo 'selected'; ?>>2022</option>
								<option value="2023" <?php if($ano == '2023') echo 'selected'; ?>>2023</option>
								<option value="2024" <?php if($ano == '2024') echo 'selected'; ?>>2024</option>
								<option value="2025" <?php if($ano == '2025') echo 'selected'; ?>>2025</option>
								<option value="2026" <?php if($ano == '2026') echo 'selected'; ?>>2026</option>
								<option value="2027" <?php if($ano == '2027') echo 'selected'; ?>>2027</option>
								<option value="2028" <?php if($ano == '2028') echo 'selected'; ?>>2028</option>
								<option value="2029" <?php if($ano == '2029') echo 'selected'; ?>>2029</option>
								<option value="2030" <?php if($ano == '2030') echo 'selected'; ?>>2030</option>
								<option value="2031" <?php if($ano == '2031') echo 'selected'; ?>>2031</option>
								<option value="2032" <?php if($ano == '2032') echo 'selected'; ?>>2032</option>
								<option value="2032" <?php if($ano == '2033') echo 'selected'; ?>>2033</option>
								<option value="2032" <?php if($ano == '2034') echo 'selected'; ?>>2034</option>
								<option value="2032" <?php if($ano == '2035') echo 'selected'; ?>>2035</option>
							</select>
						</label>
					</div>
				</div>										
				<div class="col-md-6 col-sm-10">					
					<div id="example_filter">
						Oficina:&nbsp;&nbsp;
						<label>
							<?php
								echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?view=opehor.inactivos&id=\'+value;">';
								echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
								echo '<option value="99"> -- TODOS LOS PUESTO -- </option>';
								foreach($puestos as $tables) {
									if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
									echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
								}
								echo '</select>';
							?>
						</label>
					</div>
				</div>
			</div>	
			<div class="box-body mailbox-messages">
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-dismissable alert-info">
							<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
							<p> - Los turnos se identifican con los siguientes colores:&nbsp;</br>
								<span class="number"><span class="label label-success">D</span>&nbsp;Diurno</span>,&nbsp;
								<span class="number"><span class="label label-primary">N</span>&nbsp;Nocturno</span>,&nbsp;
								<span class="number"><span class="label label-warning">L</span>&nbsp;Libre</span>,&nbsp;
								<span class="number"><span class="label label-danger">F</span>&nbsp;Falta</span>,&nbsp;
								<span class="number"><span class="label label-purple">LT</span>&nbsp;Libre trabajado</span>,&nbsp;
								<span class="number"><span class="label label-navy">DN</span>&nbsp;<span class="label label-broum">ND</span>&nbsp;Dobladas</span> y
								<span class="number"><span class="label label-motod">DM</span>&nbsp;Diurno con Moto</span>,&nbsp;
								<span class="number"><span class="label label-moton">NM</span>&nbsp;Nocturno con Moto</span>,&nbsp;
								<span class="number"><span class="label label-renuncia">UT</span>&nbsp;Ultimo turno</span>
							</p>
						</div>
					</div>
				</div>
				<div style="height: 410px; width: 100%; overflow-x: auto;" id="example_length">
					<?php
						$users = PuestoData::getByIdDesvinculado($lugar, 3, 0);  
						
						if(count($users) > 0){
							echo '<table id="horario" class="table table-bordered table-hover">';
								echo '<tbody>';
								// Crea tabla de agentes activos
								foreach($users as $tables) {
									echo '<tr>';
										echo '<td>';
											echo '<small>';
												echo $tables['nombre']; // $lugar.' '.$tables['id'].' '.
												echo '</br>'.$tables['descripcion'].'-'.$tables['cargo'];
											echo '</small></br>';
											$valor=HorarioData::getByTurnos($tables['servicio'], $tables['id'], $mes, $ano, 2);
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
																	if($valor[$i-1]['turno']==4)
																		$clase = 'btn-danger';
																	else
																		if($valor[$i-1]['turno']==5)
																			$clase = 'bg-purple';
																		else
																			if($valor[$i-1]['turno']==6)
																				$clase = 'btn-bitbucket';
																			else
																				if($valor[$i-1]['turno']==7)
																					$clase = 'btn-github';
																				else
																					if($valor[$i-1]['turno']==8)
																						$clase = 'btn-dropbox';
																					else
																						if($valor[$i-1]['turno']==9)
																							$clase = 'btn-foursquare';
																						else
																							if($valor[$i-1]['turno']==10)
																								$clase = 'btn-flickr';
																							else
																								$clase = 'btn-default';
													} else {
														echo '<input type="hidden" id="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" value="'.$iddia.'-'.$tables['servicio'].'-'.$tables['id'].'-'.$i.'-'.$mes.'-'.$ano.'-0">';
														$clase = 'btn-default';
													}
													echo '<input type="button" id="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" class="btn '.$clase.'" value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'"/>';
													echo '</td>';
												}
												echo '</tr>';
											echo '</table>';
										echo '</td>';
									echo '</tr>';
								}
								echo '</tbody>';
							echo '</table>';
						}else{
							echo '<div class="alert alert-dismissable alert-danger">
									<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
									<p> - A&uacute;n no se ha reclutado a ningun agente.</p>
								  </div>';
						} 
					?>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Horario de Inactivos"
</script>
