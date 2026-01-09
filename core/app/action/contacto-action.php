<?php
//==== GESTIÓN DE PERSONAS DE CONTACTO //
date_default_timezone_set('America/Guayaquil');
header('Content-Type: application/json'); 

$base = new Database();
$con = $base->connect();

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'listar';

switch($accion){
	case 'agregar':
		// Escapar datos para prevenir SQL injection
		$nombre = mysqli_real_escape_string($con, $_POST['nombre']);
		$cedula = mysqli_real_escape_string($con, $_POST['cedula']);
		$placa = mysqli_real_escape_string($con, $_POST['placa']);
		$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
		$puesto = isset($_SESSION['puesto']) ? intval($_SESSION['puesto']) : 0;

		$sql = "INSERT INTO contacto (idpuesto, idperson, nombre, cedula, placa, created_at) 
				VALUES ($puesto, $user_id, '$nombre', '$cedula', '$placa', NOW())";
		
		// Log para debugging
		error_log("SQL EJECUTADO: " . $sql);
		
		if($query = $con->query($sql)){
			$lastId = mysqli_insert_id($con);
			error_log("Registro insertado con ID: " . $lastId);
			$response = array('success' => true, 'message' => 'Persona agregada correctamente', 'id' => $lastId);
		}else{
			error_log("ERROR SQL: " . mysqli_error($con));
			$response = array('success' => false, 'message' => 'Error al agregar persona: '.mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	case 'listar':
		// Verificar si la tabla existe
		$sql_check = "SHOW TABLES LIKE 'personas_contacto'";
		$table_exists = $con->query($sql_check);
		
		if($table_exists && $table_exists->num_rows > 0){
			$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
			$sql = "SELECT id, nombre, cedula, placa, etiquetas 
					FROM personas_contacto 
					WHERE is_active = 1 
					ORDER BY nombre ASC";
			
			$personas = array();
			if($query = $con->query($sql)){
				while($row = $query->fetch_assoc()){
					$personas[] = array(
						'id' => $row['id'],
						'nombre' => $row['nombre'],
						'cedula' => $row['cedula'],
						'placa' => $row['placa'],
						'etiquetas' => $row['etiquetas']
					);
				}
			}
			echo json_encode($personas);
		}else{
			echo json_encode(array());
		}
		break;
		
	case 'eliminar':
		$id = intval($_POST['id']);
		$sql = "UPDATE personas_contacto SET is_active = 0 WHERE id = $id";
		
		if($query = $con->query($sql)){
			$response = array('success' => true, 'message' => 'Persona eliminada correctamente');
		}else{
			$response = array('success' => false, 'message' => 'Error al eliminar persona: '.mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	default:
		echo json_encode(array('error' => 'Acción no válida'));
		break;
}

