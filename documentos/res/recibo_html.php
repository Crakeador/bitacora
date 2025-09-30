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

$sql = "SELECT A.client, E.nombre AS cliente, A.person, C.id, B.tipo_cuenta, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto 
          FROM nomina A, rubro B, person C, cargo D, client E 
		 WHERE E.idclient = A.client AND A.mes = $mes AND A.ano = $ano AND A.rubro = B.id AND A.person = C.id AND C.cargo = D.id AND 
			   D.idtipo = $tipo AND A.person = ".$_GET["id"]." AND A.client = ".$_SESSION['cliente']."
	  GROUP by C.id"; 
$users = $con->query($sql);

if (is_countable($users) && count($users)==0){
	echo "<script>alert('No hay datos pera este personal...!!!')</script>";
	echo "<script>window.close();</script>";
	exit;
}else{
	$userid = null; $a = 0;
	while($r = $users->fetch_array()){
			$nochem = 0; $diassm = 0; $totalm = 0;
			$totals = 0; $diasla = 0; $nochel = 0; $faltas = 0;	$libres = 0; $noched = 0; $diassd = 0; $libret = 0; $cadena="";

			$sql = "select B.idclient, A.* from horario A, puestos B 
					 where A.idservicio = B.id AND B.idclient=".$r['client']." AND A.idagente=".$r['id']." and A.mes=$mes and A.ano=$ano and A.tipo=2";
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
			
			$porciones = explode("-", $r['startwork']);
		    echo '<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">';
				echo '<table cellspacing="0" style="width: 100%; border: solid 2px black; text-align: center; font-size: 10pt; padding: 0.3em;">';
					echo '<tr>';
					  echo '<td style="width: 25%;">';
					  	  echo '<img src="../../assets/images/'.$_SESSION['logo-recibo'].'" alt="Logo empresarial" width="80%" height="40%">';
					  echo '</td>';
					  echo '<td style="text-align:center; alignment-baseline:middle; border:#000; border-color:#000">';
						  echo '<h2>'.$_SESSION['se_imprime'].'</h2>';
					   echo '</td>';
					echo '</tr>';
				echo '</table>';
				echo '<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">';
					echo '<tr>';
						echo '<td colspan="6" style="background-color:#000000;color:#ffffff;font-size:18px;font-weight:bold;text-align:center;vertical-align:top"><strong>ROL DE PAGO '.$_SESSION['pagado'].' '.$ano.'</strong></td>';
					echo '</tr>';
					echo '<tr>';
						echo '<th colspan="2" style="background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Empresa: </br>'.$_SESSION['company'].'</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Proyecto</th>';
						echo '<th colspan="3" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['cliente'].'</th>';
					echo '</tr>';
					echo '<tr>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">C&eacute;dula</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Apellidos y Nombres</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">A&ntilde;o</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Cargo</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Desde</th>';
						echo '<th style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Hasta</th>';
					echo '</tr>';
					echo '<tr>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['idcard'].'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['name'].'</small></th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$ano.'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['description'].'</small></th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$ini.'</small></th>';
						echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$fin.'</small></th>';
					echo '</tr>';

					echo '<tr>';
						echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Dias trabajados: '.$totals.'</th>';
						echo '<th colspan="2" style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Faltas: '.$faltas.'</th>';
						echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">Atrasos: 0</th>';
						echo '<th colspan="2" style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Fecha de Ingreso: '.$porciones[2].'-'.$porciones[1].'-'.$porciones[0].'</th>';
					echo '</tr>';
					echo '<tr>';
						echo '<th colspan="2" style="border-left: solid 1px black; border-bottom: solid 1px black;"><strong>INGRESOS</strong></th>';
						//echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;"><strong>EGRESOS</strong></th>';
						echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '</tr>';

					$sql = "select B.impreso, A.rubro, A.monto, B.tipo_cuenta, B.descripcion 
					          from nomina A, rubro B 
							 where A.client = ".$r['client']." AND A.person = ".$r['person']." AND A.mes = $mes AND A.ano = $ano AND A.rubro = B.id 
						  ORDER BY B.impreso";
					$rubro = $con->query($sql);

					$i=0; $ingreso=0; $egreso=0;
					while($m = $rubro->fetch_array()){
						if($m['tipo_cuenta'] == 'I'){
							echo '<tr>';
							echo '<th style="border-left: solid 1px black;">'.$m['impreso'].'-'.$m['descripcion'].'</th>';
							echo '<th align="right">'.$m['monto'].'</th>';
							echo '<th>&nbsp;</th>';
							$i++; $ingreso=$ingreso+$m['monto'];
						}else{
							if($m['monto']==0){
								$monto=0; $cadena='';
								if($m['rubro'] == 7 || $m['rubro'] == 8 || $m['rubro'] == 18 || $m['rubro'] == 20){
									$sql = "SELECT A.cuota, B.cuota pago, B.monto, B.fecha, C.descripcion FROM recibo A, recibod B, descuento C WHERE A.id = B.idrecibo AND A.iddescuento = C.id AND A.idperson = ".$r['person']." AND C.tipo = ".$m['rubro']." AND MONTH(B.fecha) = $num AND YEAR(B.fecha) = $ano";
									$result = $con->query($sql);
									if ($result){
										while($c = $result->fetch_array()){
											if($m['rubro'] == 7)
												$cadena = $c['descripcion'].' '.'('.$c['pago'].'/'.$c['cuota'].')';
											else
												$cadena = '('.$c['pago'].'/'.$c['cuota'].')';
											$monto=$monto+$c['monto'];
										}
									}
								}
							}else{
								$cadena='';
								$monto=$m['monto'];
							}
							$egreso=$egreso+$monto;

							if($i > 7){
								echo '<tr>';
									echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
									echo '<th align="right">&nbsp;</th>';
									echo '<th>&nbsp;</th>';
									echo '<th style="border-left: solid 1px black;">'.$m['impreso'].'-'.$m['descripcion'].' '.$cadena.'</th>';
									echo '<th align="right">'.number_format($monto, 2, ',', '.').'</th>';
									echo '<th style="text-align:center; border-right: solid 1px black;">&nbsp;</th>';
								echo '</tr>';
							}else{
								if($m['rubro'] == 7)
									if($cadena == '')
										echo '<th style="border-left: solid 1px black;">'.$m['impreso'].'-'.$m['descripcion'].' '.$cadena.'</th>';
									else
										echo '<th style="border-left: solid 1px black;">'.$m['impreso'].'-'.$cadena.'</th>';
								else
									echo '<th style="border-left: solid 1px black;">'.$m['impreso'].'-'.$m['descripcion'].' '.$cadena.'</th>';
								echo '<th align="right">'.number_format($monto, 2, ',', '.').'</th>';
								echo '<th style="text-align:center; border-right: solid 1px black;">&nbsp;</th>';
								echo '</tr>';
								if($i == 7) $i++;
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
						echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
						echo '<th align="right">&nbsp;</th>';
						echo '<th>&nbsp;</th>';
						echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
						echo '<th align="right">&nbsp;</th>';
						echo '<th style="text-align:center; border-right: solid 1px black;">&nbsp;</th>';
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
						echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th align="right" style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th align="right" style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '</tr>';
					echo '<tr>';
						echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL INGRESOS:</th>';
						echo '<th align="right" style="border-bottom: solid 1px black;">$ '.$ingreso.'</th>';
						echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
						echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;">TOTAL EGRESOS:</th>';
						echo '<th align="right" style="border-bottom: solid 1px black;">$ '.$egreso.'</th>';
						echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
					echo '</tr>';
					echo '<tr>';
						echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
						echo '<th align="right">&nbsp;</th>';
						echo '<th>&nbsp;</th>';
						echo '<th style="border-left: solid 1px black;">&nbsp;</th>';
						echo '<th align="right">NETO A RECIBIR:</th>';
						echo '<th style="text-align:center; border-right: solid 1px black;">$ '.number_format($valor, 2, ',', '.').'</th>';
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
	}
}

?>
