<?php
// Cambio de horario
include("../core/controller/Database.php");
$base = new Database();
$con = $base->connect();

if($_GET['id'] == 0){
	echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
}else{
	$sql = "UPDATE horario SET turno=".$_GET['valor']." WHERE id=".$_GET['id'];
	$result = $con->query($sql);
}

if($result){
	// Actualizacion Completa
}else{
	echo "<script>sweetAlert('Falla la actualizacion...!!!', '".$sql."', 'error');</script>";
}
