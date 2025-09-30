<?php
// Lista de la Nomina 
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

$cotizacion = $_GET['cotizacion'];
$rubro = $_GET['rubro'];
$monto = $_GET['monto'];
$cantidad = $_GET['cantidad'];

$sql = "INSERT INTO cotizaciond(idcotizacion, descripcion, monto, cantidad, usuario_log, ip) VALUES ($cotizacion, '$rubro', $monto, $cantidad, '".$_SESSION['user_name']."', '".$_SESSION['ip']."')"; 
$result = $con->query($sql);

if($result){
	// echo "<script>sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');</script>";
}else{
	echo "<script>sweetAlert('Falla la actualizacion...!!!', 'No hay ningun contrato activo actualmente', 'error');</script>";
}
