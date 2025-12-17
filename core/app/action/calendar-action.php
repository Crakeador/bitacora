<?php
//==== GESTIÓN DE EVENTOS DEL CALENDARIO //
date_default_timezone_set('America/Guayaquil');
header('Content-Type: application/json');

$base = new Database();
$con = $base->connect();

// Obtener ID del usuario de la sesión
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'Leer';

switch($accion){
	case 'agregar':
		// Escapar datos para prevenir SQL injection
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
		$color = mysqli_real_escape_string($con, $_POST['color']);
		$start = mysqli_real_escape_string($con, $_POST['start']);
		$end = mysqli_real_escape_string($con, $_POST['end']);
		$persona_contacto = mysqli_real_escape_string($con, $_POST['persona_contacto']);
		$lugar = mysqli_real_escape_string($con, $_POST['lugar']);
		
		$sql = "INSERT INTO eventos(title, descripcion, backgroundColor, borderColor, start, end, user_id, persona_contacto, lugar, created_at) 
				VALUES ('$title', '$descripcion', '$color', '$color', '$start', '$end', $user_id, '$persona_contacto', '$lugar', NOW())";
		
		if($query = $con->query($sql)){
			$response = array('success' => true, 'message' => 'Evento agregado correctamente', 'id' => mysqli_insert_id($con));
		}else{
			$response = array('success' => false, 'message' => 'Error al agregar evento: '.mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	case 'eliminar':
		$id = intval($_POST['id']);
		$sql = "UPDATE eventos SET is_active = 0 WHERE id = $id";
		
		if($query = $con->query($sql)){
			$response = array('success' => true, 'message' => 'Evento eliminado correctamente');
		}else{
			$response = array('success' => false, 'message' => 'Error al eliminar evento: '.mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	case 'modificar':
		$id = intval($_POST['id']);
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
		$color = mysqli_real_escape_string($con, $_POST['color']);
		$start = mysqli_real_escape_string($con, $_POST['start']);
		$end = mysqli_real_escape_string($con, $_POST['end']);
		$persona_contacto = mysqli_real_escape_string($con, $_POST['persona_contacto']);
		$lugar = mysqli_real_escape_string($con, $_POST['lugar']);
		
		$sql = "UPDATE eventos SET 
				title='$title', 
				descripcion='$descripcion', 
				backgroundColor='$color', 
				borderColor='$color', 
				start='$start', 
				end='$end',
				persona_contacto='$persona_contacto',
				lugar='$lugar',
				updated_at=NOW()
				WHERE id = $id";
		
		if($query = $con->query($sql)){
			$response = array('success' => true, 'message' => 'Evento modificado correctamente');
		}else{
			$response = array('success' => false, 'message' => 'Error al modificar evento: '.mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	default:
		// Seleccionar los eventos del calendario activos
		$sql = "SELECT id, title, descripcion, backgroundColor as color, borderColor, start, end, 
				persona_contacto, lugar, user_id 
				FROM eventos 
				WHERE is_active = 1 OR is_active IS NULL
				ORDER BY start ASC";
		
		$events = array();
		if($query = $con->query($sql)){
			while($row = $query->fetch_assoc()){
				$events[] = array(
					'id' => $row['id'],
					'title' => $row['title'],
					'descripcion' => $row['descripcion'],
					'color' => $row['color'],
					'backgroundColor' => $row['color'],
					'borderColor' => $row['borderColor'],
					'start' => $row['start'],
					'end' => $row['end'],
					'persona_contacto' => $row['persona_contacto'],
					'lugar' => $row['lugar'],
					'user_id' => $row['user_id']
				);
			}
		}
		
		echo json_encode($events);
		break;
}

