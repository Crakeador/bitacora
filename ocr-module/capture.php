<?php

$config = require 'config.php';
$redis = new Redis();
$redis->connect($config['redis']['host'], $config['redis']['port']);

$cameraId = $_POST['camera_id'] ?? 1;
$rtsp = $config['camaras'][$cameraId];
$output = "/tmp/capture_cam{$cameraId}_" . time() . ".jpg";

$redis->lPush('ocr_queue', json_encode([
    'camera_id' => $cameraId,
    'rtsp' => $rtsp,
    'output' => $output
]));

echo "Captura encolada";
