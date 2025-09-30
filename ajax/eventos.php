<?php
header('Content-Type: application/json');
$pdo=new PDO("mysql:dbname=cipol;hoslt=127.0.0.0","root","");

$accion = (isset($_GET['accion']))?$_GET['accion']:'Leer';

switch($accion){
	case 'agregar':			
			$result=false;
			$sql = $pdo->prepare("INSERT INTO eventos(title, descripcion, backgroundColor, borderColor, start, end) 
			                           VALUES (:title, :descripcion, :backgroundColor, :borderColor, :start, :end)");
			$result=$sql->execute(array(
				"title"=>$_POST['title'], 
				"descripcion"=>$_POST['descripcion'], 
				"backgroundColor"=>$_POST['backgroundColor'], 
				"borderColor"=>$_POST['borderColor'], 
				"start"=>$_POST['start'], 
				"end"=>$_POST['end']
			));
			
			echo json_encode($result);
		break;
	case 'eliminar':
			$result=false;
			
			if(isset($_POST['id'])){
				$sql = $pdo->prepare("DELETE FROM eventos WHERE id=:ID)");
				$result=$sql->execute(array("ID"=>$_POST['id']));
			}
			
			echo json_encode($result);
		break;
	case 'modificar':
			$result=false;
			$sql = $pdo->prepare("INSERT INTO eventos(title, descripcion, backgroundColor, borderColor, start, end) 
			                           VALUES (:title, :descripcion, :backgroundColor, :borderColor, :start, :end)");
			$result=$sql->execute(array(
				"title"=>$_POST['title'], 
				"descripcion"=>$_POST['descripcion'], 
				"backgroundColor"=>$_POST['backgroundColor'], 
				"borderColor"=>$_POST['borderColor'], 
				"start"=>$_POST['start'], 
				"end"=>$_POST['end']
			));
			
			echo json_encode($result);
		break;
	default;	
			//Selecconar los eventos del calendario
			$sql=$pdo->prepare("SELECT * FROM eventos");
			$sql->execute();

			$result=$sql->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($result);
		break;
}
