<?php
// Lista de la Nomina 
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

// Proceso de Generacion de la nomina
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");

$despido = $_GET['despido'];
$rubro = $_GET['rubro'];
$monto = $_GET['monto'];
$inifecha = $_GET['inifecha'];
$finfecha = $_GET['finfecha'];
$fecha = $_GET['fecha'];
$fecha = $_GET['fecha'];
$idperson = $_GET['person']; //$_SESSION['id_person'];

$sql = "INSERT INTO persond(idperson, tipo_contrato, sueldo, startwork, endwork, estado, observacion, usuario_log, ip) VALUES 
						   ($idperson, '$rubro', $monto, '$inifecha', '$finfecha', '$despido', 'Rubro agregado manualmente', '".$_SESSION['user_name']."', '".$_SESSION['ip']."')";
$result = $con->query($sql);

if($result)
	echo "<script>sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');</script>";
else
	echo "<script>sweetAlert('Falla la actualizacion...!!!', 'No hay ningun contrato activo actualmente', 'error');</script>";

?>