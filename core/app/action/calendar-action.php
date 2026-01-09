<?php
//==== GESTIÓN DE EVENTOS DEL CALENDARIO //
date_default_timezone_set('America/Guayaquil');
header('Content-Type: application/json');

$base = new Database();
$con = $base->connect();

// Detectar nombre real de la columna título para ambientes antiguos
function columnExists($con, $table, $column) {
	$res = $con->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
	$exists = $res && $res->num_rows > 0;
	if($res){ $res->close(); }
	return $exists;
}

$colTitle = columnExists($con, 'eventos', 'title') ? 'title' : (columnExists($con, 'eventos', 'titulo') ? 'titulo' : 'title');
$hasEstado = columnExists($con, 'eventos', 'estado');
$hasIdComercial = columnExists($con, 'eventos', 'idcomercial');
$comercialIdCol = columnExists($con, 'comercial', 'id') ? 'id' : (columnExists($con, 'comercial', 'idclient') ? 'idclient' : 'id');

// Obtener ID del usuario de la sesión (preferir id_person)
$user_id = 1;
if(isset($_SESSION['id_person'])) {
	$user_id = intval($_SESSION['id_person']);
} elseif(isset($_SESSION['user_id'])) {
	$user_id = intval($_SESSION['user_id']);
}
$usuario_log = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'ADMIN';

// Obtener IP real considerando proxies
$ip_addr = 'LOCALHOST';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip_addr = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip_addr = $_SERVER['REMOTE_ADDR'];
}

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'Leer';

switch($accion){
	case 'agregar':
		// Escapar datos para prevenir SQL injection
		$idcomercial = $hasIdComercial ? intval($_POST['idcomercial'] ?? 0) : null;
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
		$color = mysqli_real_escape_string($con, $_POST['color']);
		$start = mysqli_real_escape_string($con, $_POST['start']);
		$end = mysqli_real_escape_string($con, $_POST['end']);
		$fecha = mysqli_real_escape_string($con, explode(' ', $start)[0] ?? '');
		$hora = mysqli_real_escape_string($con, explode(' ', $start)[1] ?? '');
		$persona_contacto = mysqli_real_escape_string($con, $_POST['persona_contacto']);
		$lugar = mysqli_real_escape_string($con, $_POST['lugar']);
		$estado = isset($_POST['estado']) ? intval($_POST['estado']) : null;
		
		$estadoVal = ($estado !== null ? $estado : 'NULL');

		// Construcción dinámica de columnas para soportar idcomercial/estado opcionales
		$colsParts = array();
		$valsParts = array();

		if($hasIdComercial){
			$colsParts[] = 'idcomercial';
			$valsParts[] = ($idcomercial > 0) ? $idcomercial : 'NULL';
		}
		$colsParts[] = 'iduser';
		$valsParts[] = $user_id;
		$colsParts[] = "`$colTitle`";
		$valsParts[] = "'$title'";
		$colsParts[] = 'fecha';
		$valsParts[] = "'$fecha'";
		$colsParts[] = 'hora';
		$valsParts[] = "'$hora'";
		$colsParts[] = 'descripcion';
		$valsParts[] = "'$descripcion'";
		$colsParts[] = 'persona_contacto';
		$valsParts[] = "'$persona_contacto'";
		$colsParts[] = 'lugar';
		$valsParts[] = "'$lugar'";
		$colsParts[] = 'color';
		$valsParts[] = "'$color'";
		$colsParts[] = 'start';
		$valsParts[] = "'$start'";
		$colsParts[] = 'end';
		$valsParts[] = "'$end'";
		if($hasEstado){
			$colsParts[] = 'estado';
			$valsParts[] = $estadoVal;
		}
		$colsParts[] = 'usuario_log';
		$valsParts[] = "'$usuario_log'";
		$colsParts[] = 'ip';
		$valsParts[] = "'$ip_addr'";
		$colsParts[] = 'created_at';
		$valsParts[] = 'NOW()';

		$sql = "INSERT INTO eventos(" . implode(', ', $colsParts) . ") VALUES (" . implode(', ', $valsParts) . ")";
		
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
		$idcomercial = $hasIdComercial ? intval($_POST['idcomercial'] ?? 0) : null;
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
		$color = mysqli_real_escape_string($con, $_POST['color']);
		$start = mysqli_real_escape_string($con, $_POST['start']);
		$end = mysqli_real_escape_string($con, $_POST['end']);
		$fecha = mysqli_real_escape_string($con, explode(' ', $start)[0] ?? '');
		$hora = mysqli_real_escape_string($con, explode(' ', $start)[1] ?? '');
		$persona_contacto = mysqli_real_escape_string($con, $_POST['persona_contacto']);
		$lugar = mysqli_real_escape_string($con, $_POST['lugar']);
		$estado = isset($_POST['estado']) ? intval($_POST['estado']) : null;
		
		$sql = "UPDATE eventos SET 
				iduser=$user_id,
				`$colTitle`='$title', 
				fecha='$fecha',
				hora='$hora',
				descripcion='$descripcion', 
				color='$color',
				start='$start', 
				end='$end',
				persona_contacto='$persona_contacto',
				lugar='$lugar',
				usuario_log='$usuario_log',
				ip='$ip_addr'";
		if($hasIdComercial){
			$sql .= ", idcomercial=" . ($idcomercial > 0 ? $idcomercial : 'NULL');
		}
		if($hasEstado){
			$sql .= ", estado=" . ($estado !== null ? $estado : 'NULL');
		}
		$sql .= " WHERE id = $id";
		
		// DEBUG: Log del SQL
		error_log("[EVENTOS MODIFICAR DEBUG] SQL: " . $sql);
		
		if($query = $con->query($sql)){
			$response = array('success' => true, 'message' => 'Evento modificado correctamente');
		}else{
			$response = array('success' => false, 'message' => 'Error al modificar evento: '.mysqli_error($con), 'sql' => $sql);
			error_log("[EVENTOS MODIFICAR ERROR] " . mysqli_error($con));
		}
		
		echo json_encode($response);
		break;
		
	default:
			$startParam = isset($_GET['start']) ? mysqli_real_escape_string($con, $_GET['start']) : null;
			$endParam = isset($_GET['end']) ? mysqli_real_escape_string($con, $_GET['end']) : null;
			$searchParam = isset($_GET['search']) ? trim($_GET['search']) : '';
			$colorParam = isset($_GET['color']) ? trim($_GET['color']) : '';

			$where = array();
			$where[] = "(e.is_active = 1 OR e.is_active IS NULL)";
			if($startParam && $endParam){
				$where[] = "(e.start BETWEEN '$startParam' AND '$endParam')";
			}
			if($searchParam !== ''){
				$searchEsc = mysqli_real_escape_string($con, "%$searchParam%");
				$searchParts = array("e.`$colTitle` LIKE '$searchEsc'", "e.descripcion LIKE '$searchEsc'", "e.persona_contacto LIKE '$searchEsc'", "e.lugar LIKE '$searchEsc'");
				if($hasIdComercial){
					$searchParts[] = "c.nombre LIKE '$searchEsc'";
				}
				$where[] = '(' . implode(' OR ', $searchParts) . ')';
			}
			if($colorParam !== ''){
				$colorEsc = mysqli_real_escape_string($con, $colorParam);
				$where[] = "(e.color = '$colorEsc')";
			}

			$whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';
			$estadoSelect = $hasEstado ? ", e.estado" : "";
			$idComercialSelect = $hasIdComercial ? ", e.idcomercial, c.nombre as cliente_nombre, c.`$comercialIdCol` as cliente_id" : "";
			$joinComercial = $hasIdComercial ? " LEFT JOIN comercial c ON e.idcomercial = c.`$comercialIdCol`" : "";
			$sql = "SELECT e.id, e.`$colTitle` as title, e.descripcion, e.color, e.start, e.end, 
					e.persona_contacto, e.lugar, e.iduser$estadoSelect$idComercialSelect 
					FROM eventos e
					$joinComercial
					$whereSql
					ORDER BY e.start ASC";
		
			$events = array();
			if($query = $con->query($sql)){
				while($row = $query->fetch_assoc()){
					$event = array(
						'id' => $row['id'],
						'title' => $row['title'],
						'descripcion' => $row['descripcion'],
						'color' => $row['color'],
						'backgroundColor' => $row['color'],
						'borderColor' => $row['color'],
						'start' => $row['start'],
						'end' => $row['end'],
						'persona_contacto' => $row['persona_contacto'],
						'lugar' => $row['lugar'],
						'user_id' => $row['iduser']
					);
					if($hasEstado){
						$event['estado'] = $row['estado'];
					}
					if($hasIdComercial){
						$event['idcomercial'] = $row['idcomercial'];
						$event['cliente_nombre'] = $row['cliente_nombre'];
						$event['cliente_id'] = isset($row['cliente_id']) ? $row['cliente_id'] : null;
					}
					$events[] = $event;
				}
			}
		
			echo json_encode($events);
			break;
}

