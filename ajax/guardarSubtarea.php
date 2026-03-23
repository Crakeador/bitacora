<?php
// Script para guardar subtareas (tareas conducta)
// Recibe datos por POST y graba en la tabla
header('Content-Type: application/json; charset=utf-8');
include("../core/controller/Database.php");
session_start();

$response = ['success' => false, 'error' => '', 'id' => 0];

// Validar que es POST
if($_SERVER['REQUEST_METHOD'] != "POST"){
    $response['error'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

// Validar parámetros requeridos
$required = ['tareas', 'rubro', 'fechaTarea'];
foreach($required as $param){
    if(!isset($_POST[$param]) || empty($_POST[$param])){
        $response['error'] = "Falta parámetro requerido: $param";
        echo json_encode($response);
        exit;
    }
}

// Sanitizar entrada
$tareas = intval($_POST['tareas']);
$rubro = htmlspecialchars($_POST['rubro']);
$fechaTarea = $_POST['fechaTarea'];
$userid = intval($_SESSION['user_id']);

// Validar fechaTarea sea válida
if(!strtotime($fechaTarea)){
    $response['error'] = 'Formato de fecha inválido';
    echo json_encode($response);
    exit;
}

// Conectar a la base de datos
$base = new Database();
$con = $base->connect();

// Preparar SQL para insertar en tabla de subtareas
// Ajusta los nombres de tabla y columnas según tu esquema
$sql = "INSERT INTO timelined 
        (idtimeline, descripcion, fecha, status, iduser) 
        VALUES 
        ($tareas, '$rubro', '$fechaTarea', 1, $userid)";

$response['error'] = "Error al grabar: " . $con->error . " | SQL: " . $sql;
if($con->query($sql) === TRUE){
    $response['success'] = true;
    $response['id'] = $con->insert_id;
    $response['aaaa'] = "Error al grabar: " . $con->error . " | SQL: " . $sql;
    $response['error'] = "Subtarea grabada exitosamente: ID=" . $response['id'];
} else {
    $response['error'] = "Error al grabar: " . $con->error . " | SQL: " . $sql;
    error_log("Error al grabar subtarea: " . $response['error']);
}

echo json_encode($response);
exit;