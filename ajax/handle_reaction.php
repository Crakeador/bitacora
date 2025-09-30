<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__.'/../core/controller/Database.php';
require_once __DIR__.'/../core/controller/Executor.php';
require_once __DIR__.'/../core/controller/Model.php';
require_once __DIR__.'/../core/app/model/ReaccionData.php';

if(!isset($_SESSION['user_id'])){
  echo json_encode(["success"=>false, "error"=>"unauthorized"]);
  exit;
}

$announcementId = isset($_POST['announcement_id']) ? intval($_POST['announcement_id']) : 0;
$emoji = isset($_POST['emoji']) ? trim($_POST['emoji']) : '';

if($announcementId <= 0 || $emoji === ''){
  echo json_encode(["success"=>false, "error"=>"invalid_params"]);
  exit;
}

$r = new ReaccionData();
$r->anuncio_id = $announcementId;
$r->usuario_id = intval($_SESSION['user_id']);
$r->emogi = $emoji;
$r->addOrUpdate();

echo json_encode(["success"=>true]);

