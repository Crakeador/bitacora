<?php

if(isset($_POST["title"])){
	$tarea = new TareaData();
	$tarea->title = $_POST["title"];
	$tarea->description = $_POST["description"];
	$tarea->due_date = $_POST["due_date"];
	$tarea->user_id = $_SESSION["user_id"];
	$tarea->add();
	Core::redir("./tareas");
}

?>