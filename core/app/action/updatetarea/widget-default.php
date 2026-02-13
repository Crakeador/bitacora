<?php

if(isset($_POST["id"])){
	$tarea = TareaData::getById($_POST["id"]);
	$tarea->title = $_POST["title"];
	$tarea->description = $_POST["description"];
	$tarea->due_date = $_POST["due_date"];
	$tarea->update();
	Core::redir("./tareas");
}

?>