<?php
// Proceso de Recalculo de la nomina
Core::cargando();

$base = new Database();
$con = $base->connect();

// $_SESSION['tipo'] = 3; $_SESSION['id_company'] = 1; $_SESSION['cliente'] = 23; $_SESSION['diai'] = '01'; $_SESSION["user_name"] = 'ADMIN'; $_SESSION["ip"] = 'LOCALHOST';

// Proceso de Generacion de la nomina
$fecha = date("Y-m-d");
$persons = 0;

$ano   = $_GET['ano'];
$mes   = str_pad($_GET['mes'], 2, "0", STR_PAD_LEFT);
$dia   = $_SESSION['diai']; // date('d', strtotime($fecha));

$inicio = $ano.'-'.$mes.'-'.$dia;
$entras = $ano.'-'.$mes.'-'.date('t', strtotime($inicio));

//echo 'Inicio: '.$inicio.' Final: '.$entras.'</br>';
$total = 30;

if($_SESSION['tipo'] == 3)
	$sql = "SELECT B.idclient, E.hadicional, E.hnocturna, C.id, B.codigo, B.descripcion, C.name, C.cargo, D.description, A.idservicio, C.sueldo, C.acumula3, C.acumula4, C.decimo
	          FROM personpuestos A, puestos B, person C, cargo D, client E WHERE A.idservicio = B.id AND A.idperson = C.id AND C.cargo = D.id AND E.idclient = B.idclient AND 
	               B.tipo = 2 AND B.idclient = ".$_SESSION['cliente']." AND D.idtipo = 3 AND A.is_active = 1 
	      GROUP BY A.idperson ORDER BY C.id"; 
else
	$sql = "SELECT C.id, C.name, C.cargo, D.description, C.sueldo, C.acumula3, C.acumula4, C.decimo, C.hadicional, C.hnocturna
              FROM person C, cargo D WHERE C.cargo = D.id AND D.idtipo IN (1, 2) AND C.is_active = 1 
	      ORDER BY C.name"; 

//echo '</br>'.$sql;

//var_dump($_SESSION);
$q = $con->query($sql); 

//echo '</br>Total de Registro: '.$q->num_rows.'</br>';
while($c = $q->fetch_array(MYSQLI_ASSOC)){
    //echo '</br>Ubicacion: '.$c["descripcion"].' Agente: '.$c["name"];
    
    $sql = "SELECT * FROM horario WHERE idservicio=".$c['idservicio']." AND idagente=".$c['id']." AND CAST(mes AS UNSIGNED)='$mes' AND CAST(ano AS UNSIGNED)='$ano' AND tipo=2 ORDER BY turno DESC";
    $h = $con->query($sql); //echo $sql.'</br>';
	
	$idclient = $_SESSION['cliente'];
	if(empty($h)) {
		$totals = $total;
		$faltas = 0;
	}else{
		$totals = 0; $totalm = 0; $diassm = 0; $diasla = 0; $diassd = 0; $faltas = 0; $noched = 0; $nochel = 0; $nochem = 0; $libret = 0; $libres = 0; 
        $renuncio = ''; 
        
        while($v = $h->fetch_array(MYSQLI_ASSOC)){
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
												if($v['turno']==10) {// Fin de Turno
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
		
	    echo '</br>Total de dias: '.$diasla.' Total de noches: '.$nochel.' Total de dobladas: '.$totalm.'</br>';
	}

    if($_GET['mes'] == '2')
    	$totals = 30;
    else
    	if($totals > 30) 
    		$totals = 30;
    		
	// Todos los Rubros de la quincena
	$sql2 = "SELECT * FROM rubro WHERE is_active=1 ORDER BY orden_rubro";
	$r = $con->query($sql2);

	while($a = $r->fetch_array(MYSQLI_ASSOC)){
	    //var_dump($a);
	    
        if($a['id'] ==  1){ // Sueldo
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
		if($a['id'] ==  2){ // Bonos
			if($a['id'] == $monto_b){
				$suma = $monto_a;
			}

			$valor = $a['valor']+$monto_a;
			$formula = '('.$a['valor'].'+'.$monto_a.')';
		}
		if($a['id'] ==  3 && $c['hadicional'] == 1){ // Horas suplementarias
			if($c['cargo'] == 7){
                $valor=($a['valor']/30)*$totals;
		        $formula = '('.$a['valor'].'/30)*'.$totals;
			}else{
				$valor = 0;
				$formula = '';
			}

			if($totals == 30){
				// Sin cambios
			}else {
				$sueldo = $mensual;
			}
			$base_3ero = $sueldo+$valor;
		}
		if($a['id'] ==  4){ // Fondos de Reserva
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
		if($a['id'] ==  5 && $c['acumula3'] == 0){ // Decimo 3ero.
			$valor = $base_3ero/12;
			$formula = $base_3ero.'/12';
		}
		if($a['id'] ==  6){ // Decimo 4to.
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
		if($a['id'] ==  8){ // Prestamos personales
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
			$valor = ($base_3ero*$a['valor'])/100;
			$formula = '('.$base_3ero.'*'.$a['valor'].')/100';
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
        if($a['id'] == 24 && $c['hnocturna'] == 1){ // Horas Nocturnas
            if($c['cargo'] == 7){
                $valor=($a['valor']/10)*$nochel;
    	        $formula = '('.$a['valor'].'/10)*'.$nochel;
			}else{
				$valor = 0;
				$formula = '';
			}
		}
        if($a['id'] == 25){ // Dias adicionales
            // Ingreso de Adicionales
    		$sql3 = "SELECT A.*, B.tipo FROM recibo A, adicional B WHERE A.iddescuento=B.id AND A.idperson=".$c['id']." AND B.tipo=".$a['id']." AND MONTH(entregado)='$mes' AND YEAR(entregado)='$ano' ORDER BY B.tipo";
    		$adicional = $con->query($sql3); 
    
            $formula = ''; $monto_b = 0; $monto_a = 0; $persons = 0;
    		if(!empty($adicional)){
    			while($dato = $adicional->fetch_array(MYSQLI_ASSOC)){
    				$monto_b = $dato["tipo"];
    				$monto_a = $dato["monto"];
    				$persons = $dato["idperson"];
    			}
    			
    			$valor = $monto_a; $formula = '';
    		}else{
    		    $valor = 0; $formula = '';
    		}
		}
		
		$sql4 = "INSERT INTO nomina (company, client, person, mes, ano, rubro, monto, formula, created_at, usuario_log, ip) ";
		$sql4 .= "value (".$_SESSION['id_company'].", ".$_SESSION['cliente'].", ".$c['id'].", '$mes', '$ano', ".$a['id'].", $valor, '".$formula."', NOW(), '".$_SESSION["user_name"]."', '".$_SESSION["ip"]."')";
		
		$valor = 0; $formula = '';
        //echo "</br>1SQL: $sql4</br>"; 
        
        $registros = $con->query($sql4);
		if (!$registros){
		    echo "Error 2: $sql4</br>";
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

Core::redir('rrhnom.lista');
