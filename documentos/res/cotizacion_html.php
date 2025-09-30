<?php
//Impresion de los recibos globales de las nominas
session_start();

include("../../core/controller/Database.php");

$base = new Database();
$con = $base->connect();

$meses = array("", "ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$mes = (int) $_SESSION['mes'];

$_SESSION['pagado']=$meses[$mes];

$ano = $_SESSION['ano']; 
$mes = str_pad($_SESSION['mes'], 2, "0", STR_PAD_LEFT);

$tipo = $_SESSION['tipo'];

$sql = "select * from company where id = ".$_SESSION['id_company'];
$query = $con->query($sql);

while($r = $query->fetch_array()){
	$name = $r['name'];
	break;
}

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
$final=$ano."-".$mes."-".$total;

$ini=$_SESSION['inicia']; // "01-".$mes."-".$ano;
$fin=$_SESSION['finala']; // $total."-".$mes."-".$ano;

$sql = "select G.nombre, A.person, C.id, B.tipo_cuenta, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto, F.descripcion ";
$sql .=  "from nomina A, rubro B, person C, cargo D, personpuestos E, puestos F, client G ";
$sql .= "where A.mes = $mes and A.ano = $ano and A.rubro = B.id and A.person = C.id and C.cargo = D.id AND A.person = E.idperson AND E.idservicio = F.id AND G.idclient = F.idclient AND ";
$sql .=       "D.idtipo = $tipo and C.idcompany = ".$_SESSION['id_company']." AND F.idclient = ".$_SESSION['cliente']." AND E.is_active = 1";
$sql .= " GROUP by C.name"; 

$users = $con->query($sql); 

if (empty($users)){
	echo "<script>alert('No hay registros procesados en la nomina...!!!')</script>";
	echo "<script>window.close();</script>";
}else{
	$userid = null; $a = 0;

	while($r = $users->fetch_array()){
		echo '<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">';
			$nochem = 0; $diassm = 0; $totalm = 0; $totals = 0; $diasla = 0; $nochel = 0; $faltas = 0; $libres = 0; $noched = 0; $diassd = 0; $libret = 0;
			$sql = "SELECT * FROM horario A, puestos B
		         WHERE B.id = A.idservicio AND B.idclient=".$_SESSION['cliente']." AND A.idagente=".$r['id']." AND CAST(A.mes AS UNSIGNED)=$mes AND CAST(A.ano AS UNSIGNED)=$ano AND A.tipo=2";

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
			if($totals == 28 && $mes == 2) $totals = 30; // CALCULO DE LOS DIAS DE FEBRERO
			if($totals > 30) $totals = 30; // CALCULO DE LOS DIAS DE FEBRERO
	
			if($_SESSION['tipo']==1) $mensaje = 'Personal Administrativo'; else $mensaje = 'Personal Operativo';

			echo '<table cellspacing="0" style="width: 100%; text-align: center; font-size: 10pt;">';
				echo '<tr>';
					echo '<td style="width: 25%;">';
						echo '<img src="../../assets/images/'.$_SESSION['logo-recibo'].'" alt="logo" width="50%" height="60"><br>'; 
					echo '</td>';
					echo '<td style="width: 75%;text-align:center; alignment-baseline:middle; border:#000; border-color:#000">';
						echo '<h2>'.$_SESSION['se_imprime'].'</h2>'; 
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			echo '<table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">';
				echo '<tr>';
					echo '<td colspan="4" align="center" bgcolor="#CCCCCC" style="width:80%; "><strong>ROL DE PAGO '.$_SESSION['pagado'].' '.$ano.'</strong></td>';
				echo '</tr>';
			echo '</table>';
			echo '<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">';
				echo '<tr>';
					echo '<td width="22%" style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black;"><strong>Empresa: <span style="color: #ed1b24">'.$name.'</span></strong></td>';
					echo '<td colspan="5"  style="border-right: solid 1px black;">';
						echo '&nbsp;&nbsp;<strong>Proyecto: </strong>'.$r['nombre'];
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="6" style="text-align: center; font-size: 11pt; border-right: solid 1px black; border-left: solid 1px black; border-top: solid 1px black; border-bottom: solid 1px black;"><strong>'.$mensaje.'</strong></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">C&eacute;dula</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Apellidos</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Nombres</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Cargo</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Desde</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">Hasta</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['idcard'].'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;"><small>'.$r['name'].'</small></th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$r['description'].'</th>'; 
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$ini.'</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">'.$fin.'</th>';
				echo '</tr>';
				$porciones = explode("-", $r['startwork']);

				echo '<tr>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Dias trabajados:</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">'.$totals.'</th>';
					echo '<th style="text-align:center; background: #E7E7E7; border-left: solid 1px black; border-bottom: solid 1px black;">Faltas: '.$faltas.'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">Fecha de Ingreso: '.$porciones[2].'-'.$porciones[1].'-'.$porciones[0].'</th>';
					echo '<th style="text-align:center; border-left: solid 1px black; border-bottom: solid 1px black;">Atrasos:</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-left: solid 1px black; border-bottom: solid 1px black;">0</th>';
				echo '</tr>';
				echo '<tr>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;"><strong>INGRESOS</strong></th>';
					echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="border-left: solid 1px black; border-bottom: solid 1px black;"><strong>EGRESOS</strong></th>';
					echo '<th style="border-bottom: solid 1px black;">&nbsp;</th>';
					echo '<th style="text-align:center; border-right: solid 1px black; border-bottom: solid 1px black;">&nbsp;</th>';
				echo '</tr>';
		
				$sql = "select A.rubro, A.monto, B.tipo_cuenta, B.descripcion from nomina A, rubro B where A.person = ".$r['person']." AND A.client = ".$_SESSION['cliente']." and A.mes = $mes and A.ano = $ano and A.rubro = B.id ORDER BY B.impreso";
				$rubro = $con->query($sql);

				$i=0; $ingreso=0; $egreso=0;
				while($m = $rubro->fetch_array()){
					if($m['tipo_cuenta'] == 'I'){
						echo '<tr>';
						echo '<th style="border-left: solid 1px black;">'.$m['descripcion'].'</th>';
						echo '<th align="right">'.$m['monto'].'</th>';
						echo '<th>&nbsp;</th>';
						$i++; $ingreso=$ingreso+$m['monto'];
					}else{
						if($m['monto']==0){
							$monto=0; $cadena='';

							if($m['rubro'] == 7 || $m['rubro'] == 8 || $m['rubro'] == 18 || $m['rubro'] == 20){
								$sql = "SELECT A.cuota, B.cuota pago, B.monto, B.fecha, C.descripcion FROM recibo A, recibod B, adicional C WHERE A.id = B.idrecibo AND A.iddescuento = C.id AND A.idperson = ".$r['person']." AND C.tipo = ".$m['rubro']." AND MONTH(B.fecha) = $mes AND YEAR(B.fecha) = $ano"; 
								$result = $con->query($sql); 

								if ($result->num_rows > 0){

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
								echo '<th style="border-left: solid 1px black;">'.$m['descripcion'].' '.$cadena.'</th>';
								echo '<th align="right">'.number_format($monto, 2, ',', '.').'</th>';
								echo '<th style="text-align:center; border-right: solid 1px black;">&nbsp;</th>';
							echo '</tr>';
						}else{
							if($m['rubro'] == 7)
								if($cadena == '')
									echo '<th style="border-left: solid 1px black;">'.$m['descripcion'].' '.$cadena.'</th>';
								else
									echo '<th style="border-left: solid 1px black;">'.$cadena.'</th>';
							else
								echo '<th style="border-left: solid 1px black;">'.$m['descripcion'].' '.$cadena.'</th>';
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
		echo '</br>';
	}

}



?>



