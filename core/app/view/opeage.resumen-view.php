<?php
$ano=date("Y");

if(!isset($_SESSION['id']))	$_SESSION['id']=1;
if(!isset($_SESSION['mes'])) $_SESSION['mes']=date("m");

if(isset($_GET['id'])){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	$lugar=$_SESSION['id'];
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

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));

$lugar=$_SESSION['id'];

?>
<div class="row">
	<section class="content-header">
		<h1>
			Operaciones
			<small>registro de la asistencia de los agentes Activos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-book"></i> Operaciones </a></li>
			<li class="active"> Asistencia </li>
		</ol>
	</section>
	<form class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" role="form"> 
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body mailbox-messages">
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_length" id="example_length">
								<label>Ver el reporte de asistencia de:&nbsp;
									<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='?view=opeage.resumen&mes='+value;">
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
									Total de dias del periodo: <?php echo $total; ?>
								</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div id="example_filter" class="dataTables_filter">
								Oficina:&nbsp;&nbsp;
								<label>
									<?php
										$local = PuestoData::getByLocalidad();

										echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'?view=opeage.resumen&id=\'+value;">';
										foreach($local as $tables) {
											if($tables['codigo'] == $lugar) $valor = 'selected'; else $valor = '';
											echo '<option value= "'.$tables['codigo'].'" '.$valor.'>'.$tables['descripcion'].'</option>';
										}
										echo '</select>';
									?>
								</label>&nbsp;
							</div>
						</div>
					</div>
					<table id="cabecera" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th style="width:18%"><div align="center">Agentes</div></th>
								<th style="width:7%"><div align="center">Dias Laborados</div></th>
								<th style="width:7%"><div align="center">Noches Laboradas</div></th>
								<th style="width:7%"><div align="center">Nro. Faltas</div></th>
								<th style="width:7%"><div align="center">Dias</br> Libres</div></th>
								<th style="width:7%"><div align="center">Total de Dias</div></th>
								<th style="width:7%"><div align="center">Libres Trabajados</div></th>
								<th style="width:7%"><div align="center">Turnos dobles</div></th>
								<th style="width:7%"><div align="center">Total</br> doble</div></th>
								<th style="width:7%"><div align="center">Dias con Moto</div></th>
								<th style="width:7%"><div align="center">Noche con Moto</div></th>
								<th style="width:7%"><div align="center">Total</br> Moto</div></th>
								<th><div align="center">Fin del Contrato</div></th>
								<th><div align="center"></div></th>
							</tr>
						</thead>
					</table>
					<div style="height: 510px; width: 100%; overflow-x: auto;" id="example_length">
						<table id="horario" class="table table-bordered table-hover">
							<tbody>
								<?php
									$users = PuestoData::getByIdHorario($lugar, 3, 1);

									// Crea tabla de Ventas
									foreach($users as $tables) {
										echo '<tr>';
											echo '<td style="width:17%">';
												echo '<small>';
													echo utf8_encode($tables['nombre']);
													echo '</br>'.$tables['descripcion'].'</br>'.$tables['cargo'];
												echo '</small>';
											echo '</td>';
											$nochem = 0;
											$diassm = 0;
											$totalm = 0;

											$totals = 0;
											$diasla = 0;
											$nochel = 0;
											$faltas = 0;
											$libres = 0;
											$noched = 0;
											$diassd = 0;
											$libret = 0;
											$renuncio = ''; $observacion = '';
											$valor=HorarioData::getByIdHorario($tables['servicio'], $tables['id'], $mes, $ano, 2);
											$resultado = count($valor);

											for ($i = 1; $i <= $total; $i++) {
													if($resultado > 0) {
														if($valor[$i-1]['turno']==1) {//dia
															$diasla++;
														}else{
															if($valor[$i-1]['turno']==2) {// noche
																$nochel++;
															}else{
																if($valor[$i-1]['turno']==3) {// libres
																	$libres++;
																}else{
																if($valor[$i-1]['turno']==4) {// faltas
																	$faltas++;
																}else{
																	if($valor[$i-1]['turno']==5) {// libre trabajado
																		$libret++;
																	}else{
																		if($valor[$i-1]['turno']==6) {// turno doble noche
																			$noched++; $diasla++;
																		}else{
																			if($valor[$i-1]['turno']==7) {// turno doble dia
																				$diassd++; $nochel++;
																			}else{
																				if($valor[$i-1]['turno']==8) {// turno doble dia
																					$diassm++;
																				}else{
																					if($valor[$i-1]['turno']==9) {// turno dia moto
																						$nochem++;
																					}else{
																						if($valor[$i-1]['turno']==10) {// turno doble dia
																							$renuncio = $ano.'-'.str_pad($mes, 2, "0", STR_PAD_LEFT).'-'.str_pad($i, 2, "0", STR_PAD_LEFT);
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}

												$totals = $diasla+$nochel+$libres;
												$totala = $libret+($noched+$diassd);
												$totalm = $diassm+$nochem;
											}
											echo '<td style="width:7%"><div align="center">'.$diasla.'</div></td>';
											echo '<td style="width:7%"><div align="center">'.$nochel.'</div></td>';
											echo '<td style="width:7%"><div align="center">'.$faltas.'</div></td>';
											echo '<td style="width:7%"><div align="center">'.$libres.'</div></td>';
											echo '<td style="width:7%"><div align="center"><span class="text-danger">'.$totals.'</span></div></td>';
											echo '<td style="width:7%"><div align="center">'.$libret.'</div></td>';
											echo '<td style="width:7%"><div align="center">'.($noched+$diassd).'</div></td>';
											echo '<td style="width:7%"><div align="center"><span class="text-danger">'.$totala.'</span></div></td>';
											echo '<td style="width:7%"><div align="center">'.$diassm.'</div></td>';
											echo '<td style="width:7%"><div align="center">'.$nochem.'</div></td>';
											echo '<td style="width:7%"><div align="center"><span class="text-danger">'.$totalm.'</span></div></td>';
											echo '<td><div align="center">'.$renuncio.'</div></td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
