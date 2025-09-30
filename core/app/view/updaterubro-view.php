<?php
if(count($_POST)>0){
	$operation = NominaData::getByIdCambio($_POST["operation_id"]);

	$operation->monto = $_POST["monto"];
	$operation->id = $_POST["operation_id"];
	$operation->updateById($_POST["operation_id"], $_POST["monto"]);
	$_SESSION["update"] = 1;
	print "<script>window.location='?view=rrhnom.detalle&id=".$_POST["person_id"]."';</script>"; 
}
