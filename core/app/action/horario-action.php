<?php 
/*
* Modulo de registro de los horarios del sistema
* Creado: 03/10/2023
* Modificado: 03/10/2023
*/
// Core::aviso();
$ini="2020-01-01"; $fin=$_SESSION['ano']."-".$_SESSION['mes']."-30";
$ano = $_SESSION["ano"]; 

if(isset($_GET['mes'])){
	$mes = $_GET["mes"];
	$_SESSION["mes"] = $mes;
}else{
	$mes = $_SESSION["mes"];
}
if(isset($_GET['id']) && $_GET['id'] != '0'){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	$lugar=$_SESSION['id'];
}

if($_GET['tipo'] == 3){
	$cadena='opehor.activos';
	$tabla = PuestoData::getByIdHorario($lugar, 3, 1, $ini, $fin); // Verificacion de los guardias por puesto
}else{	
	$cadena='rrphor.registro';
	$tabla = PuestoData::getByAdministrador($lugar); // Personal administrativo 
}

if(count($tabla) > 0){	
	$total = count($tabla);
	echo $total.'</br>';
	// Crea tabla de agentes activos
	foreach($tabla as $tables) {			
		$horas=HorarioData::getByTurnos($tables['servicio'], $tables['id'], $mes, $ano, 2);
		
		$fecha = $_SESSION['ano']."-".$mes."-01";
		$dias = date('t', strtotime($fecha));
		
		if(count($horas) == 0){		
			for ($i = 1; $i <= $dias; $i++) {
				//echo $i.'</br>';
				$user = new HorarioData();
				$user->idservicio = $lugar;
				$user->idagente = $tables['id'];
				$user->dia  = str_pad($i, 2, "0", STR_PAD_LEFT);
				$user->mes  = str_pad($mes, 2, "0", STR_PAD_LEFT);
				$user->ano   = $_SESSION['ano'];
				$user->turno = 0;
				$user->tipo  = 2;
				$user->add(); 
			}
		}
	}
}

Core::redir($cadena);