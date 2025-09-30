<?php
// Actualizacion de los seriales del equipo
if(count($_POST)>0){
	$operation = PuestoData::getByIdOperation($_POST["product_id"]);
	$operation->serial = strtoupper($_POST["serial"]);
	$operation->estado = strtoupper($_POST["estado"]);
	$operation->serial();
	$_SESSION["update"] = 1;
	
	print "<script>window.location='index.php?view=editserial&id=".$_POST["product_id"]."';</script>"; 
}
