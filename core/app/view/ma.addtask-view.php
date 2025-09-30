<?php

if(count($_POST)>0){
	$nombre = UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname;
	$user = new TimelineData();
	$user->idcompany = $_POST["company"];
	$user->idperson = $_POST["persona"];
	$user->quien_asigna = $nombre;
	$user->status = 1;
	$user->title = $_POST["descripcion"];
	$user->date_event = $_POST["fecha"];
	$user->add_task();

	$hoy = date("Y-m-d H:i:s");
	// Varios destinatarios
	$para  = $_SESSION["email"]; // atención a la coma
	$título = 'Solicitud de actividades asignada por: '.$nombre;

	// mensaje
	$mensaje = '
	<html>
	<head>
	<title>Tiene Una actividad Pendiente</title>
	</head>
	<body>
		<h1>Tiene Una actividad Pendiente asignada el: '.$hoy.'</h1>
	<p>La fecha maxima de Ejecuci&oacute;n es: '.$_POST["fecha"].'</p>
	<p>'.$_POST["descripcion"].'</p>
	</body>
	</html>';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: Jorge Fiallos <jfiallos@gmail.com>' . "\r\n";
	$cabeceras .= 'From: Recordatorio <info@codemaker.ec>' . "\r\n";

	// Enviarlo
	$bool = mail($para, $título, $mensaje, $cabeceras);

	print "<script>window.location='index.php?view=home&correo=".$bool."';</script>";
}
