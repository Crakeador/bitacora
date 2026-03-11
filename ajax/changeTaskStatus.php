<?php
// Manejador AJAX para cambio de estado de tareas - SIN layout
// Devuelve SOLO JSON, sin cargar el layout completo
header('Content-Type: application/json; charset=utf-8');
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();
$response = ['success' => false, 'error' => ''];

try {
    // Verificar que sea POST
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        $response['error'] = 'Método no permitido';
        echo json_encode($response);
        exit;
    }
    
    // Validar parámetros
    if(!isset($_POST['id']) || !isset($_POST['status'])){
        $response['error'] = 'Parámetros inválidos';
        echo json_encode($response);
        exit;
    }
    
    $id = intval($_POST['id']);
    $status = intval($_POST['status']);
    
    // Validar valores
    if($id <= 0 || $status <= 0){
        $response['error'] = 'ID o estado inválido';
        echo json_encode($response);
        exit;
    }
    
    // Actualizar estado
    $sql = "UPDATE timeline SET status=$status, update_at=NOW() WHERE id=$id";
    $registros = $con->query($sql);
    if (!$registros){
        $response['success'] = false;
        $response['error'] = $sql . " - " . $con->error;
    } else {
        $response['success'] = true;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
exit;