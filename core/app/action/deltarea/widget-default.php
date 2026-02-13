<?php

if(isset($_GET["id"])){
	$tarea = TareaData::getById($_GET["id"]);
	$tarea->del();
	Core::redir("./tareas");
}

?>