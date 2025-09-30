<?php
//==== REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN //
date_default_timezone_set('America/Guayaquil');

$base = new Database();
$con = $base->connect();

$accion = (isset($_GET['accion']))?$_GET['accion']:'Leer';

switch($accion){
	case 'agregar':		
			$sql = "INSERT INTO eventos(title, descripcion, backgroundColor, borderColor, start, end) VALUES ('".$_POST['title']."', '".$_POST['descripcion']."', '".$_POST['color']."', '".$_POST['color']."', '".$_POST['start']."', '".$_POST['end']."')";
						
			if($query = $con->query($sql)){
				echo 'Exito: '.$sql;
			}else{
				echo 'Error: '.$sql;
			}

			echo json_encode($query);
		break;
	case 'eliminar':
			$result=false;
			
			//Eliminar
		break;
	case 'modificar':
			$result=false;
			$sql = "UPDATE eventos SET title='".$_POST['title']."', 
										descripcion='".$_POST['title']."', 
										backgroundColor='".$_POST['title']."', 
										borderColor='".$_POST['title']."', 
										start='".$_POST['title']."', 
										end='".$_POST['title']."' 
								 WHERE id = ".$_POST['title'];
								 
			if($query = $con->query($sql)){
				echo 'Exito: '.$sql;
			}else{
				echo 'Error: '.$sql;
			}

			echo json_encode($query);
		break;
	default;	
			//Selecconar los eventos del calendario
			$sql = "SELECT * FROM eventos";
						
			if($query = $con->query($sql)){
				echo 'Exito: '.$sql;
			}else{
				echo 'Error: '.$sql;
			}

			echo json_encode($query);
		break;
}

