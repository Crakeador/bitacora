<?php
session_start();
include("../../core/controller/Database.php");
$base = new Database();
$con = $base->connect();

$ano = $_SESSION['ano']; 
$mes = str_pad($_SESSION['mes'], 2, "0", STR_PAD_LEFT);
$tipo = $_SESSION['tipo'];

$sql = "select * from company where idcompany=".$_SESSION['id_company'];
$query = $con->query($sql);

while($r = $query->fetch_array()){
	$name = $r['nombre'];
	break;
}

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
$final=$ano."-".$mes."-".$total;

$sql = "SELECT * FROM person WHERE recibo > 0";
$users = $con->query($sql);

if (empty($users)){
	echo "<script>alert('No hay ningun recibo generado')</script>";
	echo "<script>window.close();</script>";
}else{
	$userid = null; $a = 0;
	while($r = $users->fetch_array()){
		echo '<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">';
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
			$sql = "select * from horario where idagente=".$r['id']." and mes=$mes and ano=$ano and tipo=2";
			$query = $con->query($sql);
			
			while($h = $query->fetch_array()){
				if($h['turno']==1) {//dia
					$diasla++;
				}else{
					if($h['turno']==2) {// noche
						$nochel++;
					}else{
						if($h['turno']==3) {// libres
							$libres++;
						}else{
							if($h['turno']==4) {// faltas
								$faltas++;
							}else{
								if($h['turno']==5) {// libre trabajado
									$libret++;
								}else{
									if($h['turno']==6) {// turno doble noche
										$noched++; $diasla++;
									}else{
										if($h['turno']==7) {// turno doble dia
											$diassd++; $nochel++;
										}else{
											if($h['turno']==8) {// turno doble dia
												$diassm++;
											}else{
												if($h['turno']==9) {// turno dia moto
													$nochem++;
												}else{
													if($h['turno']==10) {// turno doble dia
														$renuncio = $ano.'-'.$mes.'-'.$i;
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
			
			if($totals > 30) $totals = 30;
			if($_SESSION['tipo']==1) $mensaje = 'Personal Administrativo'; else $mensaje = 'Personal Operativo';
			echo '<table cellspacing="0" style="width: 100%; border: solid 2px black; text-align: center; font-size: 10pt;">';
				echo '<tr>';
				  echo '<td style="width: 25%;">';
					  if($_SESSION['id_company'] == 1) echo '<img src="../../../images/gps.jpg" alt="Logo" width="140%" height="46" style="width: 100%;"><br>'; else echo '&nbsp;';
				  echo '</td>';
				  echo '<td style="width: 75%;text-align:center; alignment-baseline:middle; border:#000; border-color:#000">';
					  if($_SESSION['id_company'] == 1) echo '<h2><span style="color: #ed1b24">GPS</span> - Global Protection Security Cia. Ltda.</h2>'; else echo '&nbsp;';
				   echo '</td>';
				echo '</tr>';
				echo '<tr>';
				   echo '<td colspan="2" align="center" bgcolor="#CCCCCC"><strong>RECIBO DE PAGO: COMBUSTIBLE Y MANTENIMIENTO</strong></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td style="text-align:center; background: #E7E7E7; border-right: solid 1px black;"><strong>Empresa: <span style="color: #ed1b24">'.$name.'</span></strong></td>';
					echo '<td>';
						if($_SESSION['id_company'] == 1) echo '&nbsp;&nbsp;<strong>Mision: </strong> Agentes protectores, clientes y directivos <strong><span style="color: #ed1b24">GPS</span></strong> felices.'; else echo '&nbsp;';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			echo '<table cellspacing="0" style="width: 100%; border: solid 1px black; font-size: 10pt;">';
				echo '<tr>';
					echo '<td colspan="6" style="text-align: center; font-size: 11pt; border-left: solid 1px black; border-right: solid 1px black; border-top: solid 1px black; border-bottom: solid 1px black;"><strong>'.$mensaje.'</strong></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">C&eacute;dula</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Apellidos</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Nombres</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">A&ntilde;o</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Desde</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Hasta</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['idcard'].'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['name'].'</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$ano.'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$fecha.'</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$final.'</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Descripci&oacute;n</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Veh&iacute;culo</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Placa</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Modelo</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;"># Matricula</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;"># Seguro</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Descripci&oacute;n</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">D&iacute;as</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Quincena</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Valor Unitario</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Total Mensual</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Observaciones</th>';
				echo '</tr>';
				
				$sql = "SELECT A.idgasto, A.tipo, B.description, A.monto, A.dia FROM pagos A, entrada B WHERE A.idperson = ".$r['id']." and A.mes = $mes and A.ano = $ano AND A.idgasto = B.id";
				$rubro = $con->query($sql);

				$i=1; $ingreso=0; $egreso=0;
				while($m = $rubro->fetch_array()){
					if($r['id']==3) $totalm = 30;
					if($r['id']==6) $totalm = 22;

					if($totalm > 15) $quincena = 2; else $quincena = 1; 
					if($totalm < 7) $quincena = 0.5;

					if($m['idgasto'] == 1){
						echo '<tr>';
							echo '<td style="text-align: left; border-left: solid 1px black;">'.$m['description'].'</td>';
							echo '<td style="border-left: solid 1px black;" align="center">'.$totalm.'</td>'; // $m['dia']
							echo '<td style="border-left: solid 1px black;" align="center">'.$quincena.'</td>';
							echo '<td style="border-left: solid 1px black;" align="right">'.$m['monto'].'</td>';
							echo '<td style="border-left: solid 1px black;" align="right">$ '.number_format(($totalm*$m['monto']), 2, ',', '.').'</td>';
							echo '<td style="text-align:center; border-right: solid 1px black;">&nbsp;</td>';
						echo '</tr>';
						$i++; $ingreso=$ingreso+($totalm*$m['monto']);	// $m['dia']			
					}else{
						if($m['idgasto'] == 2){
							echo '<tr>';
								echo '<td style="text-align: left; border-left: solid 1px black;">'.$m['description'].'</td>';
								echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
								echo '<td style="border-left: solid 1px black;" align="center">'.$quincena.'</td>';
								echo '<td style="border-left: solid 1px black;" align="right">'.$m['monto'].'</td>';
								echo '<td style="border-left: solid 1px black;" align="right">$ '.number_format(($m['monto']*$quincena), 2, ',', '.').'</td>';
								echo '<td style="text-align:center; border-right: solid 1px black;">&nbsp;</td>';
							echo '</tr>';
							$i++; $ingreso=$ingreso+($m['monto']*$quincena);		
						}else{
							if($i == 6){
								echo '<tr>';
									echo '<td style="text-align: left; border-left: solid 1px black;"><strong>Total Mensual</strong></td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">$ '.number_format($ingreso, 2, ',', '.').'</td>';
									echo '<td style="text-align:center; border-right: solid 1px black;">&nbsp;</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td style="text-align: left; border-left: solid 1px black;">'.$m['description'].' '.$valor.'</td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">$ '.$m['monto'].'</td>';
									echo '<td style="text-align:center; border-right: solid 1px black;">&nbsp;</td>';
								echo '</tr>';
								$i++; $egreso=$egreso+$m['monto'];		
							}else{
								if($m['tipo'] == 'A') $valor = '(ANUAL)'; else $valor = '';
								echo '<tr>';
									echo '<td style="text-align: left; border-left: solid 1px black;">'.$m['description'].' '.$valor.'</td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="center">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">&nbsp;</td>';
									echo '<td style="border-left: solid 1px black;" align="right">$ '.$m['monto'].'</td>';
									echo '<td style="text-align:center; border-right: solid 1px black;">&nbsp;</td>';
								echo '</tr>';
								$i++; $ingreso=$ingreso+$m['monto'];		
							}
						}
					}
				}
				
				$numero = $ingreso-$egreso;
				$entero = floor($numero); 
				$decimales = $numero-$entero;
			
				if(strval($decimales) == 0.99)
					$valor = round($numero);
				else
					$valor = $numero;

				echo '<tr>';
					echo '<td style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
					echo '<td style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
					echo '<td style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
					echo '<td style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
					echo '<td style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
					echo '<td style="border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL A RECIBIR:</th>';
					echo '<th align="right" style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th align="right" style="border-bottom: solid 1px black;">$ '.number_format($valor, 2, ',', '.').'</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
					echo '<th align="right">&nbsp;</th>';
					echo '<th>&nbsp;</th>';
					echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
					echo '<th align="right">&nbsp;</th>';
					echo '<th style="text-align:center; border-right: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">Aprobado por:</th>';
					echo '<th align="right" style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">Recibe conforme</th>';
					echo '<th align="right" style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
			echo '</table>';
		echo '</page>';
		echo '</br></br>';
	}
}

?>

