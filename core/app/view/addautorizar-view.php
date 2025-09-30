<?php

if(count($_POST)>0){
	$user = new CategoryData();
	$user->name = strtoupper($_POST["name"]);
	$user->description = strtoupper($_POST["description"]);
	$user->add();
	print "<script>window.location='categorias';</script>";
}
