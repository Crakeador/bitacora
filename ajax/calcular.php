<?php
// Lista de la Nomina 
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

// Proceso de Generacion de la nomina
$fecha = date("Y-m-d");
$persons = 0;

$ano   = $_GET['ano'];
$mes   = str_pad($_GET['mes'], 2, "0", STR_PAD_LEFT);
$dia   = $_SESSION['diai']; // date('d', strtotime($fecha));

$inicio = $ano.'-'.$mes.'-'.$dia;
$entras = $ano.'-'.$mes.'-'.date('t', strtotime($inicio));

$total = 30; $empleado = 0;
// Todos los Descuentos de los Empleados
$sql = "SELECT * FROM entrada WHERE is_active=1";
$h = $con->query($sql);

$sql = "SELECT D.idservicio, A.*, B.sueldo, B.acumula3, B.acumula4, B.decimo 
          FROM nomina A, person B, puestos C, personpuestos D 
		 WHERE B.id = A.person AND C.idclient = A.client AND D.idservicio = C.id AND A.company = ".$_SESSION['id_company']." AND 
		       A.client = ".$_SESSION['cliente']." AND mes = ".$_GET['mes']." AND ano = ".$_GET['ano'];
			   
$q = $con->query($sql);  

//Recalculo
while($c = $q->fetch_array(MYSQLI_ASSOC)){
	//Verifica los datos de la asistencia
	$monto_a = 0; $monto_b = 0;
	if($c['person'] != $empleado){
		$sql = "SELECT * FROM horario WHERE idservicio=".$c['idservicio']." AND idagente=".$c['person']." AND CAST(mes AS UNSIGNED)=$mes AND CAST(ano AS UNSIGNED)=$ano AND tipo=2 ORDER BY turno DESC";
		$valor = $con->query($sql);
		
		$idclient = $_SESSION['cliente'];
		if(empty($valor)) {
			$totals = $total;
			$faltas = 0;
		}else{
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
			while($v = $valor->fetch_array(MYSQLI_ASSOC)){
				if($v['turno']==1) {//dia
					$diasla++;
				}else{
					if($v['turno']==2) {// noche
						$nochel++;
					}else{
						if($v['turno']==3) {// libres
							$libres++;
						}else{
							if($v['turno']==4) {// faltas
								$faltas++;
							}else{
								if($v['turno']==5) {// libre trabajado
									$libret++;
								}else{
									if($v['turno']==6) {// turno doble noche
										$noched++; $diasla++;
									}else{
										if($v['turno']==7) {// turno doble dia
											$diassd++; $nochel++;
										}else{
											if($v['turno']==8) {// turno doble dia
												$diassm++;
											}else{
												if($v['turno']==9) {// turno dia moto
													$nochem++;
												}else{
													if($v['turno']==10) {// ultimo turno
														$diasla++;
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
		
				$totals = $diasla+$nochel+$libres+$libret;
				$totala = $noched+$diassd;
				$totalm = $diassm+$nochem;
			}
		}
		$empleado = $c['person'];
		
		// Todos los Rubros de la quincena AND B.tipo=".$a['id']." 
		$sql3 = "SELECT A.*, B.tipo FROM recibo A, adicional B WHERE A.iddescuento=B.id AND A.idperson=".$c['person']." AND MONTH(entregado)='$mes' AND YEAR(entregado)='$ano' ORDER BY B.tipo";
		$adicional = $con->query($sql3); 

		if(!empty($adicional)){
			while($dato = $adicional->fetch_array(MYSQLI_ASSOC)){
				$monto_b = $dato["tipo"];
				$monto_a = $dato["monto"];
				$persons = $dato["idperson"];
			}
		}
	}
	
	if($_GET['mes'] == '2')
		$totals = 30;
	else
		if($totals > 30) 
			$totals = 30;
	
	if($c['rubro'] == 1){ // Sueldo
		$diario = $c['sueldo']/30;
		$mensual = $diario*$totals;
		if($totals == 30){
			$valor = $c['sueldo'];				
			$formula = $valor;
		}else{
			$valor = $mensual;				
			$formula = '('.$c['sueldo'].'/30)*'.$totals;
		}

		$sueldo = $c['sueldo'];
		$base_4to = ($c['sueldo']/30)*$totals;
		
		$cadena = 'UPDATE nomina SET monto='.$valor.', formula="'.$formula.'", update_at=NOW(), usuario_log="'.$_SESSION['user_name'].'", ip="'.$_SESSION['ip'].'" WHERE id='.$c['id'];
		$registros = $con->query($cadena);
		if (!$registros){
			echo "Error Rubro 1: $cadena</br>";
		} 
	}
		
	if($c['rubro'] == 4){ // Fondos de Reserva
		if($c['decimo'] == 2){
			if($totals == 30){
				// Sin cambios
			}else {
				$base_3ero = $c['sueldo']/30;
			}

			// Formula: sueldo * 8.33%
			$valor = ($base_4to*8.33)/100;
			$formula = '('.$sueldo.'*8.33)/100';
		}else{				
			$valor = 0;
			$formula = '';
		}
		
		$cadena = 'UPDATE nomina SET monto='.$valor.', formula="'.$formula.'", update_at=NOW(), usuario_log="'.$_SESSION['user_name'].'", ip="'.$_SESSION['ip'].'" WHERE id='.$c['id'];

		$registros = $con->query($cadena);
		if (!$registros){
			echo "Error Rubro 4: $cadena</br>";
		} 
	}

	if($c['rubro'] == 5 && $c['acumula3'] == 0){ // Decimo 3ero.
		$valor = $base_4to/12;
		$formula = $base_4to.'/12';
		
		$cadena = 'UPDATE nomina SET monto='.$valor.', formula="'.$formula.'", update_at=NOW(), usuario_log="'.$_SESSION['user_name'].'", ip="'.$_SESSION['ip'].'" WHERE id='.$c['id'];

		$registros = $con->query($cadena);
		if (!$registros){
			echo "Error Rubro 5: $cadena</br>";
		} 
	}

	if($c['rubro'] == 6){ // Decimo 4to.
		if($c['acumula4'] == 0){
			if($c['rubro'] == $monto_b){
				$suma = $monto_a;
			}else{
				$suma = 0;
			}

			$valor = (450/360)*$totals; // $base_4to/12; +$suma ($c['sueldo'])
			$formula = '(450/360)*'.$totals; //.'+'.$suma. ('.$c['sueldo'].')
		}else{
			$valor = 0;
			$formula = '';				
		}
		
		$cadena = 'UPDATE nomina SET monto='.$valor.', formula="'.$formula.'", update_at=NOW(), usuario_log="'.$_SESSION['user_name'].'", ip="'.$_SESSION['ip'].'" WHERE id='.$c['id'];

		$registros = $con->query($cadena);
		if (!$registros){
			echo "Error Rubro 6: $cadena</br>";
		} 
	}
	
	
	if($c['rubro'] == 12){ // IESS
		$valor = ($c['sueldo']*9.5)/100;
		$formula = '('.$base_3ero.'*'.$valor.')/100';
	}
}

// Codigo para el ingreso de la auditoria
$sql = "UPDATE control SET observacion='Se recalculo la nomina por ".$_SESSION["user_name"]." desde la maquina ".$_SESSION["ip"]."', estado=6, update_at=NOW(), usuario_log='".$_SESSION["user_name"]."',ip='".$_SESSION["ip"]."' WHERE company=".$_SESSION['id_company']." AND idclient=".$_SESSION['cliente']." AND mes=$mes AND ano=$ano";

$registros = $con->query($sql);
if (!$registros){
	echo "Error en el Control: $sql</br>";
} 
