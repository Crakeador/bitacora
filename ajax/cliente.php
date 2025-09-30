<?php
// Ingreso de Contacto
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

$cliente = $_GET['cliente'];
$nombre = $_GET['rubro'];
$telefono = $_GET['cantidad'];
$correo = $_GET['monto'];

$sql = "INSERT INTO clientd (idclient, nombre, telefono, correo, usuario_log, ip) VALUES 
                            ($cliente, '$nombre', '$telefono', '$correo', '".$_SESSION['user_name']."', '".$_SESSION['ip']."')"; 
$result = $con->query($sql); 

if($result){
	//echo "<script>sweetAlert('Excelente', '".$sql."', 'success');</script>";
}else{
	echo "<script>sweetAlert('Falla la actualizacion...!!!', 'No hay ningun contrato activo actualmente', 'error');</script>";
}
