<?php
// Proceso de Recalculo de la nomina
Core::cargando();

$base = new Database();
$con = $base->connect();

$total=0; $falta=0; $totals = 30;
$sql = "SELECT A.* FROM horario A, puestos B WHERE B.id = A.idservicio AND B.idclient=".$_SESSION['cliente']." AND A.idagente=".$_GET['id']." AND CAST(A.mes AS UNSIGNED)=".$_GET['mes']." AND CAST(A.ano AS UNSIGNED)=".$_GET['ano']." AND A.tipo=2 ORDER BY turno DESC";

if($horario = $con->query($sql)){			
	while($v = $horario->fetch_array()){
		if($v['turno'] > 0) {//dias trabajados
			if($v['turno'] == 4)
				$falta++;
			else
				$total++;
		}
	}
}

$sql = "SELECT A.*, B.sueldo, B.acumula3, B.acumula4, B.decimo FROM nomina A, person B
		 WHERE B.id = A.person AND A.company = ".$_SESSION['id_company']." AND A.client = ".$_SESSION['cliente']." AND person = ".$_GET['id']." AND mes = ".$_GET['mes']." AND ano = ".$_GET['ano'];

if($query = $con->query($sql)){	
	while($c = $query->fetch_array()){
		if($c['rubro'] == 1){ // Sueldo
			$diario = $c['sueldo']/$totals;
			$mensual = $diario*$total;
			if($total == 30){
				$valor = $c['sueldo'];				
				$formula = $valor;
			}else{
				$valor = $mensual;				
				$formula = '('.$c['sueldo'].'/30)*'.$total;
			}

			$sueldo = $c['sueldo'];
			$base_4to = ($c['sueldo']/$totals)*$total;
			
			$cadena = 'UPDATE nomina SET monto='.$valor.', formula="'.$formula.'", update_at=NOW(), usuario_log="'.$_SESSION['user_name'].'", ip="'.$_SESSION['ip'].'" WHERE id='.$c['id'];
			$registros = $con->query($cadena);
			if (!$registros){
				echo "Error Rubro 1: $cadena</br>";
			} 
		}
			
		if($c['rubro'] == 4){ // Fondos de Reserva
			if($c['decimo'] == 2){
				$base_3ero = $c['sueldo']/30;

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
	}
}else{
	echo "Error, al ejecutar una consulta";
}

Core::redir('rrhnom.lista');
