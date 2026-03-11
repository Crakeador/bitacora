<?php

// Resumen de Asistencia de Activos
$client = UserData::getCampo("iddepartamento", 4);
$ano=date("Y");

if(!isset($_SESSION['cliente'])) $_SESSION['cliente']=0;
if(!isset($_SESSION['mes']))     $_SESSION['mes']=date("m");

if(isset($_GET['id'])){
	$cliente=$_GET['id'];
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

$ini="2020-01-01"; $fin=$ano."-".str_pad($mes, 2, "0", STR_PAD_LEFT)."-30"; $lugar=$_SESSION['id'];
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
#viewBitacora {border-collapse: collapse; width:100%;}
#viewBitacora th {background:#4a8bc2; color:#fff;}
#viewBitacora td {background:#f9f9f9; text-align:right; vertical-align:middle;}
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
				<select class="select-input form-control input-sm" id="idclient" name="idclient" onchange="javascript:location.href='<?php echo $_SESSION['url']; ?>cotizaciones/'+value;">
					<option value="0" selected="selected"> Selecione... </option>
					<?php foreach($client as $clients): ?>
							<option value="<?php echo $clients->id; ?>" <?php if($clients->id == $cliente) echo 'selected="selected"'; ?>><?php echo $clients->name.' '.$clients->lastname; //utf8_encode() ?></option> 
					<?php endforeach; ?>
				</select>	
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
							<th style="width: 8%"><div align="center">Clientes</div></th>
							<th style="width: 7%"><div align="center">Fecha</div></th>
							<th style="width: 7%"><div align="center">Seguridad Fisica</div></th>
							<th style="width: 7%"><div align="center">Seguridad Electronica</div></th>
							<th style="width: 7%"><div align="center">Clearspeed</div></th>
							<th style="width: 7%"><div align="center">Tecnologia</div></th>
							<th style="width: 7%"><div align="center">Equipos de Protecci&oacute;n</div></th>
							<th style="width: 7%"><div align="center">Capacitaci&oacute;n</div></th>
							<th style="width: 7%"><div align="center">Poligono</div></th>
							<th style="width: 7%"><div align="center">Valor Total</div></th>
							<th style="width: 7%"><div align="center">Estatus</div></th>
							<th style="width: 7%"><div align="center">Total</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
							// Consulta de las Nominas							
							$users = ComercialData::getCotizacion($cliente);
							
							// Crea tabla de los horarios
							foreach($users as $tables) {
								echo '<tr>';
									echo '<td>'.$tables->nombre.'</td>';									
									echo '<td style="width:7%"><div align="center">'.$tables->update_at.'</div></td>';

									if($tables->producto == "Seguridad Fisica"){
										$total01 += $tables->monto;
										echo '<td style="width:7%, text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7% text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7% text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Seguridad Electronica"){
										$total02 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Clearspeed"){
										$total03 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7% text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7% text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Tecnologia"){
										$total04 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Equipos de proteccion"){
										$total05 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Capacitacion"){
										$total06 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
									if($tables->producto == "Poligono"){
										$total07 += $tables->monto;
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										echo '<td style="width:7%">'.$tables->gestion.'</td>';
										if($tables->gestion == "Ganada")
											echo '<td style="width:7%; text-align: right;">'.number_format($tables->monto, 2, ',', '.').'</td>';
										else
											echo '<td style="width:7%; text-align: right;">'.number_format(0, 2, ',', '.').'</td>';
									}
								echo '</tr>';
								$anual += $tables->monto;
							} 
							echo '<tr>';
								echo '<td>';
									echo '<small>Totales Anual</small>';
								echo '</td>';
								echo '<td style="width:7%"></td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total01, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total02, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total03, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total04, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total05, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total06, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format($total07, 2, ',', '.').'</td>';
								echo '<td style="width:7%; text-align: right;">'.number_format(($tables->monto*$tables->total/100), 2, ',', '.').'</td>';
								echo '<td style="width:7%"></td>';
								echo '<td style="width:7%; text-align: right;">'.number_format(($tables->monto*$tables->total/100), 2, ',', '.').'</td>';
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
    document.title = "Near Solution | Resumen de presupuestos";
</script>