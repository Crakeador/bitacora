<?php 
//Registro de Alertas
Core::cargando();

$hora_actual = strtotime(date('H:i')); // Convierte la hora a marca de tiempo Unix
$hora_objetivo = strtotime('19:00'); // También puedes establecer una hora objetivo

if ($hora_actual === $hora_objetivo) {
    echo '¡Es la hora exacta!';
} elseif ($hora_actual < $hora_objetivo) {
    $turno = 'Diurno';
} else {
    $turno = 'Nocturno';
}

$user = new BitacoraData();
if(isset($_SESSION["puesto"]))
	$user->idpuesto = (int) $_SESSION["puesto"];
else
	$user->idpuesto = 1;

if($_SESSION["id_person"] == 0)
	$idperson = 1;
else
	$idperson = $_SESSION["id_person"];

if(!isset($_SESSION["user_name"])) $_SESSION["user_name"] = 'Usuario Desconocido';

$user->idperson = (int) $idperson;
$user->fecha = date("Y-m-d H:i:s");
$user->turno = $turno;
$user->proceso = "Alerta";
$user->nota = "Boton de Panico";
$user->tipo = 5;
$user->observacion = "Se reporto una Alerta de Emergencia";
$user->puerta = "Entrada";
$user->latitude = $_GET["lat"];
$user->longitude = $_GET["lot"];
$user->is_active = 1;
$user->usuario_log = $_SESSION["user_name"];
$user->ip = $_SESSION["ip"];

$prod = $user->add(); 

if($prod[0]){
	print "<script>window.location='index.php?view=home&guardar=1';</script>";
}else{
	print "<script>window.location='index.php?view=home&error=1';</script>";
}
