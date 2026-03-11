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

if (!$sub){
    $response['success'] = false;
    $response['error'] = "Error en consulta SQL: " . $con->error . " | SQL: " . $sql;
    error_log("ERROR getSubtasks.php: " . $response['error']);
} else {
    $response['success'] = true;
}

if($sub && $sub->num_rows > 0){
    while($s = $sub->fetch_object()){
        $response['data'][] = [
            'name'=>$s->descripcion,
            'date'=>$s->fecha,
            'status'=>$s->status
        ];
    }
}
echo json_encode($response);
exit;