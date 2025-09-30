<?php

if(count($_POST)>0){
	$user = new VacacionData();
	$user->idperson = $_POST["idperson"];
	$user->inicio = $_POST["dtp_inicio"];
	$user->fin = $_POST["dtp_input"];
	$user->dias = $_POST["cuota"];
	$user->observacion = $_POST["observacion"];

	$user->add();
	print "<script>window.location='?view=listavacacion';</script>";
}
