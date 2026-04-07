<?php
// Retorna subtareas (timelined) para una tarea dada, solo JSON
header('Content-Type: application/json; charset=utf-8');
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();
$response = ['success'=>false,'data'=>[],'error'=>''];

if($_SERVER['REQUEST_METHOD']!="POST"){
    $response['error']='Método no permitido';
    echo json_encode($response);
    exit;
}

if(!isset($_POST['id'])){
    $response['error']='Falta id';
    echo json_encode($response);
    exit;
}

$id = intval($_POST['id']);
if($id<=0){
    $response['error']='Id inválido';
    echo json_encode($response);
    exit;
}

$sql = "SELECT * FROM timelined WHERE idtimeline = $id";
error_log("DEBUG getSubtasks.php - SQL: " . $sql); // Log para debugging
$sub = $con->query($sql);

if ($sub) {
    if ($sub->num_rows > 0) {
        $response['success'] = true;
        // Limpiar el array de datos antes de llenarlo, como has solicitado.
        $response['data'] = [];
        while ($s = $sub->fetch_object()) {
            $response['data'][] = [
                'name' => $s->descripcion,
                'date' => $s->fecha,
                'status' => $s->status
            ];
        }
    } else {
        // No hay subtareas, lo cual no es un error, pero el cliente espera success: false
        $response['success'] = false;
        $response['error'] = "Error en la consulta SQL: " . $con->error . " SQL: ". $sql;
        error_log("ERROR getSubtasks.php: " . $response['error'] . " | SQL: " . $sql);
    }
}else{
    $response['error'] = "Error en la consulta SQL: " . $con->error;
    error_log("ERROR getSubtasks.php: " . $response['error'] . " | SQL: " . $sql);
}
echo json_encode($response);
exit;