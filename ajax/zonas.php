<?php
// Ingreso de los puntos de la runda 
include("../core/controller/Database.php");
session_start();

$base = new Database();
$con = $base->connect();

$puesto = $_GET['puesto'];
$name = $_GET['name'];
$codigo = $_GET['codigo'];

$sql = "INSERT INTO zonas (idpuesto, name, codigo, usuario_log, ip) VALUES 
                           ($puesto, '$name', '$codigo', '".$_SESSION['user_name']."', '".$_SESSION['ip']."')"; 

$result = $con->query($sql); 
