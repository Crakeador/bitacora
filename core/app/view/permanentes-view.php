<?php

// Resumen de Asistencia de Activos
$client = UserData::getCampo("iddepartamento", 4);
$ano=date("Y"); $idcliente=0; $mes=0; $trimestre='';

if(!isset($_SESSION['cliente']))  $_SESSION['cliente']=1;
if(!isset($_SESSION['mes']))      $_SESSION['mes']=date("m");

if(isset($_GET['cliente'])){
	$cliente=$_GET['cliente'];
	$_SESSION['cliente']=$cliente;
}else{
	$cliente=$_SESSION['cliente'];
}

if(isset($_GET['mes'])){
	$mes=$_GET['mes'];
	$_SESSION['mes']=$mes;
}else{
	$mes=$_SESSION['mes'];
}

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));

$ini="2020-01-01"; $fin=$ano."-".str_pad($mes, 2, "0", STR_PAD_LEFT)."-30"; 

if(isset($_GET['trimestre'])){
	$trimestre = $_GET['trimestre'];
	$_SESSION['trimestre'] = $trimestre;
}else{
	if(isset($_SESSION['trimestre']))
		$trimestre = $_SESSION['trimestre'];
	else
		$trimestre = 'T1';

	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
	if($mes >= '01' && $mes <= '03') {
		$trimestre = 'T1';
	} elseif($mes >= '04' && $mes <= '06') {
		$trimestre = 'T2';
	} elseif($mes >= '07' && $mes <= '09') {
		$trimestre = 'T3';
	} else {
		$trimestre = 'T4';
	}
}

?>
<section class="content-header">
	<h1>
		comercial
		<small>resumen de las ventas anuales</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $_SESSION['url']; ?>home"><i class="fa fa-book"></i> Panel de Control </a></li>
		<li class="active"> Asistencia </li>
	</ol>
</section>
<!-- estilos personalizados para la tabla de asistencia -->
<style>
    /* Opcional: estilo básico para mejor legibilidad */
    .checkbox-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      max-width: 250px;
      font-family: Arial, sans-serif;
    }
    label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

	#viewBitacora {border-collapse: collapse; width:100%;}
	#viewBitacora th {background:#4a8bc2; color:#fff; text-align:center;}
	#viewBitacora td {background:#f9f9f9; text-align:center; vertical-align:middle;}
	#viewBitacora tr:nth-child(even) td {background:#ffffff;}
	/* mes columns with light pastels */
	#viewBitacora td:nth-child(3) {background:#fff9c4;}
	#viewBitacora td:nth-child(4) {background:#ffe0b2;}
	#viewBitacora td:nth-child(5) {background:#ffccbc;}
	#viewBitacora td:nth-child(6) {background:#dcedc8;}
	#viewBitacora td:nth-child(7) {background:#b2dfdb;}
	#viewBitacora td:nth-child(8) {background:#c5cae9;}
	#viewBitacora td:nth-child(9) {background:#d1c4e9;}
	#viewBitacora td:nth-child(10) {background:#f8bbd0;}
	#viewBitacora td:nth-child(11) {background:#e1bee7;}
	#viewBitacora td:nth-child(12) {background:#c5cae9;}
	#viewBitacora td:nth-child(13) {background:#bbdefb;}
	#viewBitacora td:nth-child(14) {background:#b3e5fc;}
	#viewBitacora td:nth-child(2) {background:#e1f5fe;} /* columna ventas anuales */
	#viewBitacora td:last-child {background:#ffecb3; font-weight:bold;} /* columna total */
</style>
<form class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" role="form">
	<div class="col-xs-12" style="padding: 1.5rem !important;">
		<div class="box">
			<div class="box-header with-border">
				<label> Vendedores: </label>
				<select class="select-input form-control input-sm" id="idclient" name="idclient" onchange="javascript:location.href='index.php?view=rrphor.activos&cliente='+value;">
					<option value="0" selected="selected"> Selecione... </option>
					<?php foreach($client as $clients): ?>
							<option value="<?php echo $clients->id; ?>" <?php if($clients->id == $cliente) echo 'selected="selected"'; ?>><?php echo $clients->name.' '.$clients->lastname; //utf8_encode() ?></option> 
					<?php endforeach; ?>
				</select>				
				<form action="#" method="get" id="trimestralesForm">
					<fieldset>
					<legend>Selecciona los trimestres del año</legend>
					<div class="checkbox-group">
						<label>
						<input type="checkbox" name="trimestre" value="T1" id="t1" />
						Trimestre 1 (ene – mar)
						</label>

						<label>
						<input type="checkbox" name="trimestre" value="T3" id="t3" />
						Trimestre 3 (jul – sep)
						</label>
					</div>

					<button type="submit" style="margin-top: 8px;">Enviar</button>
					</fieldset>
				</form>
			</div>
			<div class="box-body mailbox-messages">
				<div class="row">
					<div class="col-sm-6">
						<div class="dataTables_length" id="example_length">
							<label>Ver el reporte de asistencia de:&nbsp;
								<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='?view=rrphor.activos&mes='+value;">
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
								&nbsp;&nbsp;Total de dias del periodo: <?php echo $total; ?>
							</label>
						</div>
					</div>
				</div>
				</br>
				<table id="viewBitacora" class="table table-bordered table-hover table-striped table-condensed">
					<thead>
						<tr>
							<th rowspan="2" style="width: 8%; text-align: center; vertical-align: middle;"><div align="center">Linea de Productos</div></th>
							<th rowspan="2" style="width: 7%; text-align: center; vertical-align: middle;"><div align="center">Venta </br>Anuales</div></th><?php
							if($trimestre == 'T1' || $trimestre == 'T2' || $trimestre == 'T3' || $trimestre == 'T4') {
								if($trimestre == 'T1') { ?>
									<th colspan="2"><div align="center">Enero</div></th>
									<th colspan="2"><div align="center">Febrero</div></th>
									<th colspan="2"><div align="center">Marzo</div></th>
									<th colspan="2"><div align="center">Abril</div></th>
									<th colspan="2"><div align="center">Mayo</div></th>
									<th colspan="2"><div align="center">Junio</div></th><?php
								}
								if($trimestre == 'T2') { ?>
									<th colspan="2"><div align="center">Enero</div></th>
									<th colspan="2"><div align="center">Febrero</div></th>
									<th colspan="2"><div align="center">Marzo</div></th>
									<th colspan="2"><div align="center">Abril</div></th>
									<th colspan="2"><div align="center">Mayo</div></th>
									<th colspan="2"><div align="center">Junio</div></th><?php
								}
								if($trimestre == 'T3') { ?>
									<th colspan="2"><div align="center">Julio</div></th>
									<th colspan="2"><div align="center">Agosto</div></th>
									<th colspan="2"><div align="center">Septiembre</div></th>
									<th colspan="2"><div align="center">Octubre</div></th>
									<th colspan="2"><div align="center">Noviembre</div></th>
									<th colspan="2"><div align="center">Diciembre</div></th><?php
								}
								if($trimestre == 'T4') { ?>
									<th colspan="2"><div align="center">Julio</div></th>
									<th colspan="2"><div align="center">Agosto</div></th>
									<th colspan="2"><div align="center">Septiembre</div></th>
									<th colspan="2"><div align="center">Octubre</div></th>
									<th colspan="2"><div align="center">Noviembre</div></th>
									<th colspan="2"><div align="center">Diciembre</div></th><?php
								}
							} ?>
							<th colspan="2" style="width: 12%"><div align="center">Semestral</div></th>
						</tr>						
						<tr>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
							<td>Programado</td>
							<td>Ejecutado</td>
						</tr>
					</thead>
					<tbody>
						<?php
							// Consulta de las Nominas
							$users = ComercialData::getByVentas();
							$anuales = 0; $anual = 0; $semestre = 0; $global = 0;
							
							// Crea tabla de los horarios
							foreach($users as $tables) {								
								echo '<tr>';
									echo '<td>';
										echo '<small>';
											echo $tables->producto; 
											echo '</br>('.$tables->margen.' al '.$tables->total.')'; 
										echo '</small>';
									echo '</td>';
									echo '<td><div align="center">'.number_format($tables->monto, 2, ',', '.').'</div></td>';									
										$total01 = 0; $total02 = 0; $total03 = 0; $total04 = 0; $total05 = 0; $total06 = 0;	$total07 = 0; $total08 = 0; $total09 = 0; $total10 = 0; $total11 = 0; $total12 = 0;
										$mensual = $tables->monto/12; $mes = 1; $anuales += $tables->monto;
										if($trimestre == 'T1' || $trimestre == 'T2') {								
											if($mes == 1){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 1);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 1);

												foreach($totales as $item) {
													$total += intval($item->monto);
												}

												if($mensual > $total) {
													$valor = $mensual - $total;
												} else {
													$valor = 0;
												}
												
												$total01 += $mensual;
												$total02 += $total;
												$anual += $mensual;
												$semestre += $total02;
												echo '<script>console.log("Valor 1: " + '.$valor.' + " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total01.');</script>';
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											} 
											if($mes == 2){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 2);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 2);

												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $item) {
														$total += intval($item->monto);
													}
												}
												if($valor > 0) 
													$saldo = $valor / 11; // Ajusta el valor para que no sea negativo
												else
													$saldo = 0;
																								
												if($mensual > $total) 
													$valor = $mensual - $total;
												else 
													$valor = $mensual;

												$valor = $valor + $saldo; // Ajusta el valor con el saldo acumulado
												$total03 += $mensual;
												$total04 += $total;
												$anual += $mensual;
												$semestre += $total04;
												echo '<script>console.log("Valor 2: " + '.$valor.' + " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total03.');</script>';
												echo '<td><div align="center">'.number_format(($mensual + $saldo), 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 3){
												$mes += 1;
												if($idcliente == 0)
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 3);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 3);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $item) {
														$total += intval($item->monto);
													}
												}
												$total05 += $mensual;
												$total06 += $total;
												$anual += $mensual;
												$semestre += $total06;
												echo '<script>console.log("Valor 3: " + '.$valor.'+ " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total05.');</script>';
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 4){
												$mes += 1;
												if($idcliente == 0)
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 4);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 4);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $item) {
														$total += intval($item->monto);
													}
												}												
												$total07 += $mensual;
												$total08 += $total;									
												$anual += $mensual;
												$semestre += $total08;
												echo '<script>console.log("Valor 4: " + '.$valor.' + " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total07.');</script>';
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 5){
												$mes += 1;
												if($idcliente == 0)
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 5);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 5);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $item) {
														$total += intval($item->monto);
													}
												}
												$total09 += $mensual;
												$total10 += $total;												
												$anual += $mensual;
												$semestre += $total10;
												echo '<script>console.log("Valor 5: " + '.$valor.'+ " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total09.');</script>';
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 6){
												$mes += 1;
												if($idcliente == 0)
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 6);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 6);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $item) {
														$total += intval($item->monto);
													}
												}
												$total11 += $mensual;
												$total12 += $total;												
												$anual += $mensual;
												$semestre += $total12;
												echo '<script>console.log("Valor 6: " + '.$valor.'+ " Anual: " + '.$anual.' + " Total: " + '.$semestre.' + " Mensual: " + '.$total11.');</script>';
												echo '<td><div align="center">'.number_format($anual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}
										}
										if($trimestre == 'T3' || $trimestre == 'T4') {											
											if($mes == 7){
												$mes += 1; 
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 7);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 7);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}												
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 8){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 8);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 8);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}
												$total03 += $mensual;
												$total04 += $total;				
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}
											if($mes == 9){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 9);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 9);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}
												$total05 += $mensual;
												$total06 += $total;								
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 10){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 10);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 10);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}
												$total07 += $mensual;
												$total08 += $total;										
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}							
											if($mes == 11){
												$mes += 1; 
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 11);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 11);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}
												$total09 += $mensual;
												$total10 += $total;									
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}
											if($mes == 12){
												$mes += 1;
												if($idcliente == 0)									
													$totales = ComercialData::getSuma($tables->producto, 0, 2026, 12);
												else
													$totales = ComercialData::getSuma($tables->producto, $tables->iduser, 2026, 12);
												
												if(!is_array($totales) || count($totales) === 0) {
													$total = 0;
												} else {
													foreach($totales as $total) {
														$total += intval($total->monto);
													}
												}
												$total11 += $mensual;
												$total12 += $total;
												echo '<td><div align="center">'.number_format($mensual, 2, ',', '.').'</div></td>';
												echo '<td><div align="center">'.number_format($total, 2, ',', '.').'</div></td>';
											}
										}
										$global += (3*$semestre);
										echo '<td><div align="center">'.number_format((3*$semestre), 2, ',', '.').'</div></td>';
										echo '<td><div align="center">'.number_format(($semestre), 2, ',', '.').'</div></td>';
									echo '</tr>';
							} 
							echo '<tr>';
								echo '<td>';
									echo '<small>Totales</br>Anual</small>';
								echo '</td>';
								echo '<td><div align="center">'.number_format($anual, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total01, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total02, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total03, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total04, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total05, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total06, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total07, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total08, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total09, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total10, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total11, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format($total12, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format(($total01+$total03+$total05+$total07+$total09+$total11)*3, 2, ',', '.').'</div></td>';
								echo '<td><div align="center">'.number_format((3*$semestre), 2, ',', '.').'</div></td>';
							echo '</tr>';
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Resumen de asistencia activos";
</script>