<?php

if(count($_POST)>0){
	$operation = PuestoData::getByIdOperation($_POST["operation_id"]);
	$operation->serial = strtoupper($_POST["serial"]);
	$operation->estado = strtoupper($_POST["estado"]);
	$operation->update();
	$_SESSION["update"] = 1;
	print "<script>window.location='?view=history&product_id=".$_POST["product_id"]."';</script>";
}
