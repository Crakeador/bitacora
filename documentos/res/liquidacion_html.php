<?php
session_start();
include("../../core/controller/Database.php");
$base = new Database();
$con = $base->connect();

$meses = array("", "ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$num = (int) $_SESSION['mes'];
$_SESSION['pagado']=$meses[$num];

$ano = $_SESSION['ano'];
$mes = str_pad($_SESSION['mes'], 2, "0", STR_PAD_LEFT);
$tipo = $_SESSION['tipo'];

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
$final=$ano."-".$mes."-".$total;

$ini="01-".$mes."-".$ano;
$fin=$total."-".$mes."-".$ano;

$sql = "SELECT E.idpuesto, F.name AS liquidacion, D.description AS cargo, C.idcard, C.name, C.startwork, C.endwork, E.sueldo, B.descripcion, A.* 
          FROM horario A, puestos B, person C, cargo D, persond E, operation_type F
         WHERE A.idagente = ".$_GET["id"]." AND A.turno = 10 AND C.id = A.idagente AND A.idservicio = B.id AND C.cargo = D.id AND E.idperson = A.idagente AND E.idpuesto = A.idservicio AND E.estado = 'L'
		   AND E.tipo_despido = F.id";

$users = $con->query($sql);

if (is_countable($users) && count($users)==0){
	echo "<script>alert('No hay datos para este personal...!!!')</script>";
	echo "<script>window.close();</script>";
	exit;
}else{
	$userid = null; $a = 0;
	while($r = $users->fetch_array()){
		$firstDate = $r['startwork'];
		$secondDate = $r['endwork'];

		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$cadena = $years." años,  ".$months." meses y ".$days." dias";
		echo '<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">';			
			echo '<table cellspacing="0" style="width: 100%; border: solid 2px black; text-align: center; font-size: 10pt; padding: 0.3em;">';
				echo '<tr>';
				  echo '<td style="width: 25%;">';
					  echo '<img src="../../assets/images/'.$_SESSION['logo-recibo'].'" alt="Logo empresarial" width="60%" height="40%">';
				  echo '</td>';
				  echo '<td style="text-align:center; alignment-baseline:middle; border:#000; border-color:#000">';
					  echo '<h2>'.$_SESSION['se_imprime'].'</h2>';
				   echo '</td>';
				echo '</tr>';
			echo '</table>';
			echo '<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">';
				echo '<tr>';
					echo '<td colspan="10" style="background-color:#000000;color:#ffffff;font-size:18px;font-weight:bold;text-align:center;vertical-align:top"><strong>LIQUIDACION DE HABERES</strong></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Proyecto</th>';
					echo '<th colspan="6" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['descripcion'].'</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Tiempo</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$cadena.'</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">C&eacute;dula</th>';
					echo '<th colspan="2" style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Apellidos y Nombres</th>';
					echo '<th colspan="2" style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Motivo de la salida</th>';
					echo '<th colspan="2" style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Cargo</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Sueldo</th>';
					echo '<th width="100" style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Desde</th>';
					echo '<th width="100" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Hasta</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['idcard'].'</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['name'].'</small></th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['liquidacion'].'</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['cargo'].'</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['sueldo'].'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['startwork'].'</small></th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['endwork'].'</small></th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">DIAS</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">PERIODO</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">SUELDO</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">HORAS EXTRAS</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>SUELDO + HORAS EXTRAS</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>FONDO DE RESERVA</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>DECIMO TERCERO</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>DECIMO CUARTO</small></th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;"><small>OBSERVACION</small></th>';
				echo '</tr>';					
				$sql = "SELECT B.estado, A.* FROM nomina A, control B WHERE A.person=".$_GET["id"]." AND A.rubro=1 AND A.client=B.idclient AND A.mes=B.mes AND A.ano=B.ano ORDER BY ano, mes";
				
				$products = $con->query($sql);
				$idpuesto = $r['idpuesto'];
				foreach($products as $tables) {
					$nochem = 0; $diassm = 0; $totalm = 0;
					$totals = 0; $diasla = 0; $nochel = 0; $faltas = 0;	$libres = 0; $noched = 0; $diassd = 0; $libret = 0; $cadena="";

					$sql = "select * from horario where idagente=".$_GET["id"]." and idservicio=".$idpuesto." and CAST(mes AS UNSIGNED)=".$tables["mes"]." and CAST(ano AS UNSIGNED)=".$tables["ano"]." and tipo=2"; 
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
					//$startwork = str_pad($tables->dia, 2, "0", STR_PAD_LEFT).'-'.str_pad($tables->mes, 2, "0", STR_PAD_LEFT).'-'.$tables->ano;						
					echo '<tr>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$totals.'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$meses[$tables["mes"]].'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$tables["monto"].'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.(($tables["monto"]/360)*30).'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$tables["estado"].'</th>';
					echo '</tr>';
				}						
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';	
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';	
				echo '<tr>';
					echo '<th colspan="10" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">VACACIONES</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">DESDE</th>';						
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">HASTA</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">DIAS</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">GANADO</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">MONTO</th>';					
				echo '</tr>';			
				
				$sql = "SELECT A.startwork, A.endwork, A.tipo_contrato, A.sueldo FROM persond A WHERE A.idperson = ".$_GET["id"]." AND A.estado LIKE 'V'";
				$rubro = $con->query($sql);

				$vacacion=0; 
				while($m = $rubro->fetch_array()){						
					echo '<tr>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['startwork'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['endwork'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['dias'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($m['sueldo'], 2, ',', '.').'</th>';
						echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format(($m['sueldo']/24), 2, ',', '.').'</th>';	
					echo '</tr>';
					$vacacion=$vacacion+($m['sueldo']/24);
				}					
				echo '<tr>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';	
				echo '</tr>';					
				echo '<tr>';
					echo '<th colspan="8" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL VACACIONES</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($vacacion, 2, ',', '.').'</th>';
				echo '</tr>';					
				
				echo '<tr>';
					echo '<th colspan="10" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">INGRESOS</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">PERIODO</th>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">DESCRIPCION</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">MONTO</th>';					
				echo '</tr>';	
				
				$sql = "SELECT A.startwork, A.endwork, A.tipo_contrato, A.sueldo FROM persond A WHERE A.idperson = ".$_GET["id"]." AND A.estado LIKE 'I'";
				$rubro = $con->query($sql);

				$ingreso=0; 
				while($m = $rubro->fetch_array()){						
					echo '<tr>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['startwork'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['endwork'].'</th>';
						echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['tipo_contrato'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($m['sueldo'], 2, ',', '.').'</th>';	
					echo '</tr>';
					$ingreso=$ingreso+$m['sueldo'];
				}					
				echo '<tr>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';	
				echo '</tr>';					
				echo '<tr>';
					echo '<th colspan="8" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL DE INGRESOS</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($ingreso, 2, ',', '.').'</th>';
				echo '</tr>';					
				echo '<tr>';
					echo '<th colspan="10" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">EGRESOS</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">PERIODO</th>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">DESCRIPCION</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">MONTO</th>';					
				echo '</tr>';					
				
				$sql = "SELECT A.startwork, A.endwork, A.tipo_contrato, A.sueldo FROM persond A WHERE A.idperson = ".$_GET["id"]." AND A.estado LIKE 'E'";
				$rubro = $con->query($sql);

				$egreso=0;
				while($m = $rubro->fetch_array()){						
					echo '<tr>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['startwork'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['endwork'].'</th>';
						echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$m['tipo_contrato'].'</th>';
						echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($m['sueldo'], 2, ',', '.').'</th>';	
					echo '</tr>';
					$egreso=$egreso+$m['sueldo'];
				}					
				echo '<tr>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="4" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';	
				echo '</tr>';					
				echo '<tr>';
					echo '<th colspan="8" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL DE EGRESOS</th>';
					echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format($egreso, 2, ',', '.').'</th>';
				echo '</tr>';
				
				$numero = $ingreso-$egreso;
				$entero = floor($numero);
				$decimales = $numero-$entero;

				if(strval($decimales) == 0.99)
					$valor = round($numero);
				else
					$valor = $numero;

				echo '<tr>';
					echo '<th colspan="8" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">VALOR A PAGAR</th>';
					echo '<th colspan="2" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.number_format((($vacacion+$ingreso)-$egreso), 2, ',', '.').'</th>';
				echo '</tr>';					
				
				$sql = "SELECT A.observacion, A.depart FROM descuento A WHERE A.idperson = ".$_GET["id"];
				$observa = $con->query($sql);
				
				if ($stmt = $con->prepare($sql)) {
					$stmt->execute();
					$stmt->store_result();
					
					if($stmt->num_rows == 0){							
						echo '<tr>';
							echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">LOGISTICA&nbsp;&nbsp;&nbsp;</th>';
							echo '<th colspan="8" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '</tr>';
						echo '<tr>';
							echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">OPERACIONES&nbsp;&nbsp;&nbsp;</th>';
							echo '<th colspan="8" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '</tr>';
					}else{
						$cadena1 = ''; $cadena2 = ''; $uno = 0; $dos = 0;
						while($m = $observa->fetch_array()){		
							if($m['depart'] == '3'){
								$cadena1 = 'LOGISTICA&nbsp;&nbsp;&nbsp;';
								$cadena2 = $m['observacion'];
								$uno++;									
							}
							if($m['depart'] == '7'){
								$cadena1 = 'OPERACIONES&nbsp;&nbsp;&nbsp;';
								$cadena2 = $m['observacion'];
								$dos++;
							}
							echo '<tr>';
								echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">'.$cadena1.'</th>';
								echo '<th colspan="8" style="border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$cadena2.'</th>';
							echo '</tr>';
						}
						if($uno == 0){								
							echo '<tr>';
								echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">LOGISTICA&nbsp;&nbsp;&nbsp;</th>';
								echo '<th colspan="8" style="border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
							echo '</tr>';
						}
						if($dos == 0){								
							echo '<tr>';
								echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">OPERACIONES&nbsp;&nbsp;&nbsp;</th>';
								echo '<th colspan="8" style="border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
							echo '</tr>';
						}
					}
				}else{
					printf("Error en la base de datos: %d.\n", $stmt->num_rows);
				}
				echo '<tr>';
					echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">CONTABILIDAD&nbsp;&nbsp;&nbsp;</th>';
					echo '<th colspan="8" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">T.T.H.H.&nbsp;&nbsp;&nbsp;</th>';
					echo '<th colspan="8" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th height="40" colspan="2" style="text-align:right; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">OTROS&nbsp;&nbsp;&nbsp;</th>';
					echo '<th colspan="8" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th height="100" valign="top" colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">ELABORADO POR: </th>';
					echo '<th valign="top" colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">REVISADO POR:</th>';
					echo '<th valign="top" colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">REVISADO POR:</th>';
					echo '<th valign="top" colspan="2" style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">REVISADO POR:</th>';
					echo '<th valign="top" colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">APROBADO POR:</th>';
				echo '</tr>';
			echo '</table>';
		 echo '</page>';
	}
}

?>
