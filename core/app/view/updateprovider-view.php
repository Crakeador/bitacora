<?php

if(count($_POST)>0){
	$user = ProviderData::getById($_POST["user_id"]);
	$user->ruc = $_POST["ruc"];
	$user->tipo = $_POST["tipo"];
	$user->nombre = $_POST["nombre"];
	$user->descripcion = $_POST["descripcion"];
	$user->contacto = $_POST["contacto"];
	$user->cargo = $_POST["cargo"];
	$user->email = $_POST["email"];
	$user->telefono1 = $_POST["telefono1"];
	$user->telefono2 = $_POST["telefono2"];
	$user->telefonofac1 = $_POST["telefonofac1"];
	$user->telefonofac2 = $_POST["telefonofac2"];
	$user->direccion = $_POST["direccion"];
	$user->observacion = $_POST["observacion"];
	$user->update_provider();

	print "<script>window.location='?view=providers';</script>";
}
