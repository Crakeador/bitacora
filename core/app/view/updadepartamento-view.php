<?php

if(count($_POST)>0){
	$user = DepartamentoData::getById($_POST["user_id"]);
	$user->description = strtoupper($_POST["description"]);
	$user->update();
	print "<script>window.location='index.php?view=departamento';</script>";
}
