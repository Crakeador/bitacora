<?php 
/*
* Modulo de registro de los horarios del sistema
* Modificado: 25/07/2024
*/
Core::aviso();
$ini="2020-01-01"; $fin=date("Y-m-d");
$mes = date("m"); 
$ano = $_SESSION["ano"]; 

if(isset($_GET['id']) && $_GET['id'] != '0'){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	$lugar=$_SESSION['id'];
}

$tabla = PuestoData::getByIdHorario($lugar, 3, 1, $ini, $fin); // Verificacion de los guardias por puesto

//var_dump($tabla);
if(count($tabla) > 0){
	// Crea tabla de agentes activos
	foreach($tabla as $tables) {
		$horas=HorarioData::getByTurnos($tables['servicio'], $tables['id'], $mes, $ano, 2);
		
		$fecha = $_SESSION['ano']."-".date("m")."-01";
		$dias = date('t', strtotime($fecha));
		
		if(count($horas) == 0){		
			for ($i = 1; $i <= $dias; $i++) {
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
if(isset($_GET['final']) && $_GET['final'] != '0'){
	Core::redir('finalizar');
}else{
	Core::redir('despliegue');
}
