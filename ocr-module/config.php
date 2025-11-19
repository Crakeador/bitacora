<?php
return [
    'aws' => [
        'key' => 'TU_ACCESS_KEY',
        'secret' => 'TU_SECRET_KEY',
        'region' => 'us-east-1'
    ],
    'mysql' => [
        'dsn' => 'mysql:host=localhost;dbname=seguridad',
        'user' => 'usuario',
        'pass' => 'clave'
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379
    ],
    'camaras' => [
        1 => 'rtsp://admin:admin@192.168.0.188:554/live/main'
    ]
];
