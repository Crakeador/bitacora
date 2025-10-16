<?php
require_once 'flight/Flight.php';

Flight::set('flight.log_errors', true);
// Registra la clase con parametros de constructor
Flight::register('db', PDO::class, ['mysql:host=localhost;dbname=bitacora', 'root', 'MyNewPass']);

Flight::route('/', function($route){
    // Array of HTTP methods matched against
    $route->methods;

    // Array of named parameters
    $route->params;

    // Matching regular expression
    $route->regex;

    // Contains the contents of any '*' used in the URL pattern
    $route->splat;
}, true);

// Endpoint para subir una foto  
Flight::route('POST /uploadRegistro', function () {  
    // Verifica si el archivo ha sido enviado  
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {  
        $file = $_FILES['photo'];  
        $filename = basename($file['name']); // uniqid() . '-' . Nombre único para el archivo  
        $targetPath = '../sidai/storage/ingreso/'.$filename;  

        // Mueve el archivo a la carpeta de uploads  
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {  
            Flight::json(['message' => 'Archivo subido exitosamente.', 'file' => $filename]);  
        } else {  
            Flight::json(['message' => 'Error al mover el archivo.'], 500);  
        }  
    } else {  
        Flight::json(['message' => 'No se ha subido ningún archivo o hay un error.'], 400);  
    }  
});


// Endpoint para subir una foto  
Flight::route('POST /uploadNovedad', function () {  
    // Verifica si el archivo ha sido enviado  
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {  
        $file = $_FILES['photo'];  
        $filename = basename($file['name']); // uniqid() . '-' . Nombre único para el archivo  
        $targetPath = '../sidai/storage/novedad/'.$filename;  

        // Mueve el archivo a la carpeta de uploads  
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {  
            Flight::json(['message' => 'Archivo subido exitosamente.', 'file' => $filename]);  
        } else {  
            Flight::json(['message' => 'Error al mover el archivo.'], 500);  
        }  
    } else {  
        Flight::json(['message' => 'No se ha subido ningún archivo o hay un error.'], 400);  
    }  
});  

Flight::route('/saludo', function () {
    $array = [
        "texto" => "Saludos desde CIPOL...!!!",
        "status" => "success"
    ];
    
    Flight::json($array);
});

Flight::route('GET /guardia/@cedula/@password', function ($cedula, $password) {
    $db = Flight::db();
    
    if(strlen($cedula)==13){
        $stmt = $db->prepare('SELECT * FROM client WHERE ruc = "'.$cedula.'" AND telefono1 = "'.$password.'" AND is_active = 1');
        $stmt->execute();
        
        if($stmt->rowCount() == 0){
            $array = [
                "data" => [
                    "total_row" => $stmt->rowCount(),
                    "mensaje" => 'Este usuario no tiene pribilegios',
                ],
                "status" => "error"
            ];
            
            Flight::json($array); 
        }else{
            $data = $stmt->fetchAll();
                    
            $array = [];
            foreach($data as $row){
                $array[] = [
                    "idpersona" => $row['idclient'],
                    "idpuesto" => $row['idclient'],
                    "puesto" => utf8_encode($row['nombre']),
                    "residencial" => $row['residencial'],
                    "nombre" => utf8_encode($row['contacto']),
                    "idcargo" => 32,
                    "cargo" => utf8_encode($row['cargo']),
                    "activo" => $row['is_active'],
                ];
            }
        
            Flight::json($array); 
        }
    }else{
        $stmt = $db->prepare('SELECT A.id, B.idservicio, C.descripcion, C.residencial, A.name, A.cargo, D.description, A.is_active FROM person A, personpuestos B, puestos C, cargo D WHERE B.idperson = A.id AND C.id = B.idservicio AND D.id = A.cargo AND A.idcard = "'.$cedula.'"');
        $stmt->execute();
        
        if($stmt->rowCount() == 0){
            $stmt = $db->prepare('SELECT B.nombre AS clientes, A.* FROM residente A, client B WHERE B.idclient = A.idclient AND A.cedula = "'.$cedula.'" AND A.is_active=1');
            $stmt->execute();
    
            if($stmt->rowCount() == 0){
                $array = [
                    "data" => [
                        "total_row" => $stmt->rowCount(),
                        "mensaje" => 'Este usuario no tiene pribilegios',
                    ],
                    "status" => "error"
                ];
                
                Flight::json($array); 
            }else{ 
                $data = $stmt->fetchAll();
                    
                $array = [];
                foreach($data as $row){
                    $array[] = [
                        "idpersona" => $row['id'],
                        "idpuesto" => $row['idpuesto'],
                        "puesto" => utf8_encode($row['clientes']),
                        "residencial" => 0,
                        "nombre" => utf8_encode($row['nombre']),
                        "idcargo" => 15,
                        "cargo" => 'RESIDENTE',
                        "manzana" => $row['manzana'],
                        "villa" => $row['villa'],
                        "activo" => $row['is_active'],
                    ];
                }
            
                Flight::json($array); 
            }
        }else{
            $data = $stmt->fetchAll();
            
            if($data[0][5] == '5' OR $data[0][5] == '7' OR $data[0][5] == '23'){
                $array = [];
                foreach($data as $row){
                    $array[] = [
                        "idpersona" => $row['id'],
                        "idpuesto" => $row['idservicio'],
                        "puesto" => utf8_encode($row['descripcion']),
                        "residencial" => $row['residencial'],
                        "nombre" => utf8_encode($row['name']),
                        "idcargo" => $row['cargo'],
                        "cargo" => $row['description'],
                        "activo" => $row['is_active'],
                    ];
                } 
                
                Flight::json($array); 
            }else{
                $array = [
                    "data" => [
                        "total_row" => $stmt->rowCount(),
                        "mensaje" => 'Este usuario no tiene pribilegios',
                    ],
                    "status" => "error"
                ];
                
                Flight::json($array); 
            }
        } 
    }
});

Flight::route('POST /registros', function () {
    $db = Flight::db();
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto = Flight::request()->data->foto;
    $turno = Flight::request()->data->turno;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $sql = 'INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, observacion, foto1, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            ('.$idpuesto.', '.$idpersona.', '.$turno.', "'.$fecha.'", "'.$proceso.'", "'.$observacion.'", "'.$foto.'", "'.$latitud.'", "'.$longitud.'", "'.$rangoerror.'", "'.$mensaje.'", 1, NOW(), "APLICACION MOVIL", "'.$ip.'")';
    $stmt = $db->prepare($sql);
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "observacion" => $observacion, 
            "foto" => $foto, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "error" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute()){
        var_dump($stmt);
        echo "Fallo la ejecucion: (".$stmt->errno.")".$stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});


Flight::route('POST /residente', function () {
    $db = Flight::db();
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto1 = Flight::request()->data->foto1;
    $foto2 = Flight::request()->data->foto2;
    $foto3 = Flight::request()->data->foto3;
    $foto4 = Flight::request()->data->foto4;
    $foto5 = Flight::request()->data->foto5;
    $foto6 = Flight::request()->data->foto6;
    $turno = Flight::request()->data->turno;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $tipo = Flight::request()->data->tipo;
    $manzana = Flight::request()->data->manzana;
    $villa = Flight::request()->data->villa;
    $puerta = Flight::request()->data->puerta;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $sql = 'INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, manzana, villa, puerta, observacion, foto1, foto2, foto3, foto4, foto5, foto6, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            ('.$idpuesto.', '.$idpersona.', '.$turno.', "'.$fecha.'", "'.$proceso.'", "'.$tipo.'", "'.$manzana.'", "'.$villa.'", "'.$puerta.'", "'.$observacion.'", "'.$foto1.'", "'.$foto2.'", "'.$foto3.'", "'.$foto4.'", "'.$foto5.'", "'.$foto6.'", "'.$latitud.'", "'.$longitud.'", "'.$rangoerror.'", "'.$mensaje.'", 1, NOW(), "APLICACION MOVIL", "'.$ip.'")';
    $stmt = $db->prepare($sql);
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "tipo" => $tipo, 
            "manzana" => $manzana, 
            "villa" => $villa, 
            "puerta" => $puerta, 
            "observacion" => $observacion, 
            "foto1" => $foto1, 
            "foto2" => $foto2, 
            "foto3" => $foto3, 
            "foto4" => $foto4, 
            "foto5" => $foto5, 
            "foto6" => $foto6, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "error" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute()){
        var_dump($stmt);
        echo "Fallo la ejecucion: (".$stmt->errno.")".$stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});

Flight::route('POST /novedades', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto1 = Flight::request()->data->foto1;
    $foto2 = Flight::request()->data->foto2;
    $foto3 = Flight::request()->data->foto3;
    $foto4 = Flight::request()->data->foto4;
    $foto5 = Flight::request()->data->foto5;
    $foto6 = Flight::request()->data->foto6;
    $turno = Flight::request()->data->turno;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $tipo = Flight::request()->data->tipo;
    $nota = Flight::request()->data->nota;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, foto1, foto2, foto3, foto4, foto5, foto6, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :foto1, :foto2, :foto3, :foto4, :foto5, :foto6, :latitud, :longitud, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "tipo" => $tipo, 
            "nota" => $nota, 
            "observacion" => $observacion, 
            "foto1" => $foto1, 
            "foto2" => $foto2, 
            "foto3" => $foto3, 
            "foto4" => $foto4, 
            "foto5" => $foto5, 
            "foto6" => $foto6, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "error" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":foto1" => $foto1, ":foto2" => $foto2, ":foto3" => $foto3, ":foto4" => $foto4, ":foto5" => $foto5, ":foto6" => $foto6, 
                        ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        var_dump($stmt);
        echo "Fallo la ejecucion: (" . $stmt->errno . ") " . $stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});

Flight::route('POST /novedad', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto1 = Flight::request()->data->foto1;
    $foto2 = Flight::request()->data->foto2;
    $foto3 = Flight::request()->data->foto3;
    $foto4 = Flight::request()->data->foto4;
    $foto5 = Flight::request()->data->foto5;
    $foto6 = Flight::request()->data->foto6;
    $turno = 1;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $tipo = 4;
    $nota = 1;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, foto1, foto2, foto3, foto4, foto5, foto6, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :foto1, :foto2, :foto3, :foto4, :foto5, :foto6, :latitude, :longitude, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "tipo" => $tipo, 
            "nota" => $nota, 
            "observacion" => $observacion, 
            "foto1" => $foto1, 
            "foto2" => $foto2, 
            "foto3" => $foto3, 
            "foto4" => $foto4, 
            "foto5" => $foto5, 
            "foto6" => $foto6, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "salida" => "Hubo un error al ingresar los registros",
        ],
        "status" => "Pruebas"
    ];

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":foto1" => $foto1, ":foto2" => $foto2, ":foto3" => $foto3, ":foto4" => $foto4, ":foto5" => $foto5, ":foto6" => $foto6, ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        //var_dump($stmt);
        echo "Fallo la ejecucion: (" . $stmt->errno . ") " . $stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});

Flight::route('POST /ingreso', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto = Flight::request()->data->foto;
    $turno = 1;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $tipo = 4;
    $nota = 1;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, foto1, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :foto, :latitude, :longitude, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "tipo" => $tipo, 
            "nota" => $nota, 
            "observacion" => $observacion, 
            "foto" => $foto, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "error" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":foto" => $foto, ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        //var_dump($stmt);
        echo "Fallo la ejecucion: (" . $stmt->errno . ") " . $stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});

Flight::route('POST /botonpanico', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $foto1 = "";
    $foto2 = "";
    $foto3 = "";
    $foto4 = "";
    $foto5 = "";
    $foto6 = "";
    $turno = 1;
    $fecha = Flight::request()->data->fecha;
    $proceso = Flight::request()->data->proceso;
    $tipo = Flight::request()->data->tipo;
    $nota = Flight::request()->data->nota;
    $observacion = Flight::request()->data->observacion;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;
    
    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, foto1, foto2, foto3, foto4, foto5, foto6, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :foto1, :foto2, :foto3, :foto4, :foto5, :foto6, :latitude, :longitud, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");
    
    $array = [
        "data" => [
            "idpuesto" => $idpuesto, 
            "idpersona" => $idpersona, 
            "turno" => $turno, 
            "fecha" => $fecha, 
            "proceso" => $proceso, 
            "tipo" => $tipo, 
            "nota" => $nota, 
            "observacion" => $observacion, 
            "foto1" => $foto1, 
            "foto2" => $foto2, 
            "foto3" => $foto3, 
            "foto4" => $foto4, 
            "foto5" => $foto5, 
            "foto6" => $foto6, 
            "latitude" => $latitud, 
            "longitude" => $longitud, 
            "rangoerror" => $rangoerror, 
            "mensaje" => $mensaje, 
            "ip" => $ip,
            "error" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":foto1" => $foto1, ":foto2" => $foto2, ":foto3" => $foto3, ":foto4" => $foto4, ":foto5" => $foto5, ":foto6" => $foto6, 
                        ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        var_dump($stmt);
        echo "Fallo la ejecucion: (" . $stmt->errno . ") " . $stmt->error;
    }else{
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Se grabaron los registros",
            ],
            "status" => "success"
        ];
    }
    
    Flight::json($array);
});

Flight::route('GET /guardias', function () {
    $cadena = 'SELECT id, name, is_active FROM person';
    $db = Flight::db();
    $sql = $db->prepare($cadena);
    $sql->execute();
    
    $data = $sql->fetchAll();
    
    $array = [];
    foreach($data as $row){
        $array[] = [
            "idpersona" => $row['id'],
            "nombre" => utf8_encode($row['name']),
            "activo" => $row['is_active'],
        ];
    }
    
    Flight::json([
        "total_row" => $sql->rowCount(),
        "rows" => $array
    ]);
});

Flight::route('GET /ronda/@id', function ($id) {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT id, descripcion, is_active FROM puestos WHERE is_active = 1 AND id = :id');
    $stmt->execute([":id" => $id]);
    
    $row = $stmt->fetch();
    
    if($stmt->rowCount() == 0){
        $array = [
            "data" => [
                "total_row" => $stmt->rowCount(),
                "mensaje" => 'Este puesto no esta habilitado',
            ],
            "status" => "error"
        ];
        
        Flight::json($array); 
    }else{
        $array = [
            "idpersona" => $row['id'],
            "nombre" => utf8_encode($row['descripcion']),
            "activo" => $row['is_active'],
        ];

        Flight::json([
            "total_row" => $stmt->rowCount(),
            "rows" => $array
        ]);
    }
});

Flight::route('GET /person/@id', function ($id) {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT id, name, is_active FROM person WHERE id = :id');
    $stmt->execute([":id" => $id]);
    
    $row = $stmt->fetch();
    
    $array = [
            "idpersona" => $row['id'],
            "nombre" => utf8_encode($row['name']),
            "activo" => $row['is_active'],
        ];

    Flight::json([
        "total_row" => $stmt->rowCount(),
        "rows" => $array
    ]);
});

Flight::start();
