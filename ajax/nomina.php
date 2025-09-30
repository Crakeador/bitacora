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

$total = 30;
// Todos los Descuentos de los Empleados
$sql = "SELECT * FROM entrada WHERE is_active=1";
$h = $con->query($sql);

//Lista de Empleados (4 Bari 135) 2 35 
$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, C.id, A.idservicio 
          FROM personpuestos A, puestos B, person C, cargo D 
		 WHERE A.idservicio = B.id AND A.idperson = C.id AND C.cargo = D.id AND B.tipo = 2 AND B.idclient = $client AND D.idtipo = $tipo AND A.is_active = $estado 
		   AND date(C.startwork) >= \"".$ini."\" AND date(C.startwork) <= \"".$fin."\" 
	  GROUP BY A.idperson 
	  ORDER BY C.name"; 

if($_SESSION['tipo'] == 3)
	$sql = "SELECT C.id, B.codigo, B.descripcion, C.name, D.description, A.idservicio, C.sueldo, C.acumula3, C.acumula4, C.decimo
			  FROM personpuestos A, puestos B, person C, cargo D 
			 WHERE A.idservicio = B.id AND A.idperson = C.id AND C.cargo = D.id AND B.tipo = 2 AND B.idclient = ".$_SESSION['cliente']." AND D.idtipo = 3 AND A.is_active = 1
			 GROUP BY A.idperson 
			 ORDER BY C.name"; 
else
	$sql = "SELECT C.id, C.name, D.description, C.sueldo, C.acumula3, C.acumula4, C.decimo 
              FROM person C, cargo D WHERE C.cargo = D.id AND D.idtipo IN (1, 2) AND C.is_active = 1 
	      ORDER BY C.name"; 
		  
$q = $con->query($sql); 

while($c = $q->fetch_array(MYSQLI_ASSOC)){
    $sql = "SELECT * FROM horario WHERE idservicio=".$c['idservicio']." AND idagente=".$c['id']." AND CAST(mes AS UNSIGNED)=$mes AND CAST(ano AS UNSIGNED)=$ano AND tipo=2 ORDER BY turno DESC";
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
												if($v['turno']==10) {// turno doble dia
													$renuncio = $ano.'-'.$mes.'-'.$v['dia'];
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

	// Todos los Rubros de la quincena
	$sql2 = "SELECT * FROM rubro WHERE is_active=1 ORDER BY orden_rubro";
	$r = $con->query($sql2);

	while($a = $r->fetch_array(MYSQLI_ASSOC)){
		$valor = $a['valor']; $formula = ''; $monto_b = 0; $monto_a = 0;

		// Todos los Rubros de la quincena
		$sql3 = "SELECT A.*, B.tipo FROM recibo A, adicional B WHERE A.iddescuento=B.id AND A.idperson=".$c['id']." AND B.tipo=".$a['id']." AND MONTH(entregado)='$mes' AND YEAR(entregado)='$ano' ORDER BY B.tipo";
		$adicional = $con->query($sql3); 

		if(!empty($adicional)){
			while($dato = $adicional->fetch_array(MYSQLI_ASSOC)){
				$monto_b = $dato["tipo"];
				$monto_a = $dato["monto"];
				$persons = $dato["idperson"];
			}
		}

		if($_GET['mes'] == '2')
			$totals = 30;
		else
			if($totals > 30) 
				$totals = 30;
		
		if($a['id'] == 1){ // Sueldo
			$diario = $c['sueldo']/30;
			$mensual = $diario*$totals;
			if($totals == 30){
				$valor = $c['sueldo'];				
				$formula = $valor;
			}else{
				$valor = $mensual;				
				$formula = $diario.'*'.$totals;
			}

			$sueldo = $c['sueldo'];
			$base_4to = ($c['sueldo']/30)*$totals;
		}

		if($a['id'] == 2){ // Bonos
			if($a['id'] == $monto_b){
				$suma = $monto_a;
			}

			$valor = $a['valor']+$monto_a;
			$formula = '('.$a['valor'].'+'.$monto_a.')';
		}

		if($a['id'] == 3){ // Horas Extras
			if($c['cargo'] == 7){
				$valor = $valor;
			}else{
				$valor = 0;
			}

			if($totals == 30){
				// Sin cambios
			}else {
				$sueldo = $mensual;
			}
			$formula = $valor;
			$base_3ero = $sueldo+$valor;
		}

		if($a['id'] == 4){ // Fondos de Reserva
			if($c['decimo'] == 2){
				if($totals == 30){
					// Sin cambios
				}else {
					$base_3ero = $mensual;
				}

				// Formula: sueldo * 8.33%
				$valor = ($base_3ero*8.33)/100;
				$formula = '('.$base_3ero.'*8.33)/100';
			}else{				
				$valor = 0;
				$formula = '';
			}
		}

		if($a['id'] == 5 && $c['acumula3'] == 0){ // Decimo 3ero.
			$valor = $base_3ero/12;
			$formula = $base_3ero.'/12';
		}

		if($a['id'] == 6){ // Decimo 4to.
			if($c['acumula4'] == 0){
				if($a['id'] == $monto_b){
					$suma = $monto_a;
				}else{
					$suma = 0;
				}

				$valor = (($a['valor']+$suma)/360)*$totals; // $base_4to/12;
				$formula = '(('.$a['valor'].'+'.$suma.')/360)*'.$totals;
			}else{
				$valor = 0;
				$formula = '';				
			}
		}
		
		if($a['id'] == 8){ // Prestamos personales
			if($a['id'] == $monto_b){
				$suma = $monto_a;
			}

			$valor = $a['valor']+$monto_a;
			$formula = '('.$a['valor'].'+'.$monto_a.')';
		}

		if($a['id'] == 10){ // Prestamos Quirografarios
			if($a['id'] == $monto_b){
				$valor = $monto_a;
				$formula = $monto_a;
			}
		}
		
		if($a['id'] == 11){ // Anticipo de Quincena
			if($a['id'] == $monto_b){
				$valor = $monto_a;
				$formula = $monto_a;
			}
		}
		
		if($a['id'] == 12){ // IESS
			$valor = ($base_3ero*$valor)/100;
			$formula = '('.$base_3ero.'*'.$valor.')/100';
		}

		if($a['id'] == 15){ // Faltas
			$valor = $faltas*$valor;
			$formula = $faltas.'*'.$valor;
		}

		if($a['id'] == 20){ // Dotacion Extra
			if($a['id'] == $monto_b){
				$valor = $monto_a;
				$formula = $monto_a;
			}
		}
		
		$sql4 = "INSERT INTO nomina (company, client, person, mes, ano, rubro, monto, formula, created_at, usuario_log, ip) ";
		$sql4 .= "value (".$_SESSION['id_company'].", ".$_SESSION['cliente'].", ".$c['id'].", $mes, $ano, ".$a['id'].", $valor, '".$formula."', NOW(), '".$_SESSION["user_name"]."', '".$_SESSION["ip"]."')";

		//if($c['id']==$persons) echo $sql3.'</br>'.$sql4; // Ingreso de rubros adicionales

		$registros = $con->query($sql4);
		if (!$registros){
			echo "Error: $sql4</br>";
		} 
	}

	if($c['vehiculo'] == 1){
		while($a = $h->fetch_array(MYSQLI_ASSOC)){
			$sql = "INSERT INTO pagos(idperson, dia, mes, ano, idgasto, tipo, monto, created_at, usuario_log, ip) ";
			$sql .= "VALUE (".$c['id'].", 30, ".$mes.", ".$ano.", ".$a['id'].", '".$a['tipo']."', ".$a['valor'].", NOW(), '".$_SESSION["user_name"]."', '".$_SESSION["ip"]."')";
	
			$registros = $con->query($sql);
			if (!$registros){
				echo "Se detectaron errores $con->affected_rows registros.</br>";
			}
		}
	} 
} 

// Codigo para el ingreso de la auditoria
$sql = "INSERT INTO control (company, idclient, tipo, mes, ano, observacion, created_at, usuario_log, ip) ";
$sql .= "value (".$_SESSION['id_company'].", ".$_SESSION['cliente'].", '0', $mes, $ano, 'Se genero la nomina mensual del mes de $mes del $ano', NOW(), '".$_SESSION["user_name"]."', '".$_SESSION["ip"]."')";

$registros = $con->query($sql);
if (!$registros){
	echo "Error en el Control: $sql</br>";
} 
