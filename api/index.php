<?php
require_once 'flight/Flight.php';
// Agrega esto al inicio de tu código PHP en el servidor
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Manejo de la petición OPTIONS (Pre-flight) que hacen los navegadores
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
// Habilita el registro de errores
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

// Endpoint: POST /api/hombre_vivo
Flight::route('POST /alertas', function() {
    $db = Flight::db(); // Asumiendo que ya tienes configurada la conexión PDO en Flight
    $request = Flight::request();
    $data = $request->data; // Obtener los datos del cuerpo JSON
    // 1. Extraer variables básicas
    $idpersona = $data->idpersona;
    $idpuesto = $data->idpuesto ?? null;
    $fecha = $data->timestamp ?? date('Y-m-d H:i:s');
    $atraso = $data->atraso_ingreso ?? 0;
    
    // 2. Determinar el estado segun el payload de la APK
    // Mapeamos: incidente (true) -> 1, respuesta_positiva -> 2, sin_responder -> 3
    $estado = 3; // Por defecto "Sin Responder"
    if (isset($data->incidente) && $data->incidente === true) {
        $estado = 1; // Alerta generada
    } elseif (isset($data->respuesta_positiva) && $data->respuesta_positiva === true) {
        $estado = 2; // El guardia presionó el botón
    }
    try {
        // 3. Insertar en la tabla alertas_hombre_vivo
        $sql = "INSERT INTO alertas (idpersona, idpuesto, fecha, estado, atraso_ingreso) 
                VALUES (:idp, :idpu, :fec, :est, :atr)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':idp' => $idpersona,
            ':idpu' => $idpuesto,
            ':fec' => $fecha,
            ':est' => $estado,
            ':atr' => $atraso
        ]);
        Flight::json([
            "status" => "success",
            "message" => "Evento registrado correctamente",
            "id" => $db->lastInsertId()
        ], 201);
    } catch (PDOException $e) {
        Flight::json([
            "status" => "error",
            "message" => "Error en la base de datos: " . $e->getMessage()
        ], 500);
    }
});

// Endpoint para subir una foto
Flight::route('POST /uploadRegistro', function () {
    // Verifica si el archivo ha sido enviado
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        $filename = basename($file['name']); // uniqid() . '-' . Nombre único para el archivo
        $targetPath = '/var/www/latin.grupolatinamerica.com/public_html/storage/ingreso/'.$filename;

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
        $targetPath = '/var/www/latin.grupolatinamerica.com/public_html/storage/novedad/'.$filename;

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
        "texto" => "Saludos desde Latin America...!!!",
        "status" => "success"
    ];

    Flight::json($array);
});

Flight::route('POST /connection-events', function () {
    try {
        $body = Flight::request()->data->getData();

        if (empty($body)) {
            $raw = Flight::request()->getBody();
            $body = json_decode($raw, true);
        }

        if (!is_array($body)) {
            Flight::json([
                'status' => 'error',
                'message' => 'Payload invalido'
            ], 400);
            return;
        }

        $required = ['timestamp', 'event_type', 'connection'];
        foreach ($required as $field) {
            if (!isset($body[$field]) || $body[$field] === '') {
                Flight::json([
                    'status' => 'error',
                    'message' => "Campo requerido: {$field}"
                ], 400);
                return;
            }
        }

        $details = isset($body['details']) ? json_encode($body['details'], JSON_UNESCAPED_UNICODE) : null;

        $db = Flight::db(); // Debe devolver tu instancia PDO

        $sql = "
            INSERT INTO connection_events (
                timestamp,
                event_type,
                connection,
                device_id,
                usuario,
                idpersona,
                agente,
                idpuesto,
                puesto,
                turno,
                pending_observations,
                pending_incidents,
                synced,
                sync_attempts,
                last_sync_attempt,
                sync_error,
                details,
                created_at
            ) VALUES (
                :timestamp,
                :event_type,
                :connection,
                :device_id,
                :usuario,
                :idpersona,
                :agente,
                :idpuesto,
                :puesto,
                :turno,
                :pending_observations,
                :pending_incidents,
                :synced,
                :sync_attempts,
                :last_sync_attempt,
                :sync_error,
                :details,
                NOW()
            )
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':timestamp' => $body['timestamp'],
            ':event_type' => $body['event_type'],
            ':connection' => $body['connection'],
            ':device_id' => $body['device_id'] ?? null,
            ':usuario' => $body['usuario'] ?? null,
            ':idpersona' => $body['idpersona'] ?? null,
            ':agente' => $body['agente'] ?? null,
            ':idpuesto' => $body['idpuesto'] ?? null,
            ':puesto' => $body['puesto'] ?? null,
            ':turno' => $body['turno'] ?? null,
            ':pending_observations' => (int)($body['pending_observations'] ?? 0),
            ':pending_incidents' => (int)($body['pending_incidents'] ?? 0),
            ':synced' => (int)($body['synced'] ?? 0),
            ':sync_attempts' => (int)($body['sync_attempts'] ?? 0),
            ':last_sync_attempt' => $body['last_sync_attempt'] ?? null,
            ':sync_error' => $body['sync_error'] ?? null,
            ':details' => $details,
        ]);

        Flight::json([
            'status' => 'success',
            'data' => [
                'id' => $db->lastInsertId(),
                'message' => 'Evento de conexion registrado'
            ]
        ]);
    } catch (Throwable $e) {
        Flight::json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

Flight::route('POST /connection_events/bulk', function() {
    $db = Flight::db(); // Asumiendo que Flight::db() retorna la instancia PDO
    $request = Flight::request();
    $data = json_decode($request->getBody(), true);
    if (empty($data) || !is_array($data)) {
        Flight::json(['status' => 'error', 'message' => 'Invalid data format, expected JSON array'], 400);
        return;
    }
    $db->beginTransaction();
    try {
        $stmt = $db->prepare("
            INSERT INTO connection_events (
                event_type, connection, device_id, usuario, idpersona, 
                agente, idpuesto, puesto, turno, pending_observations, 
                pending_incidents, details, timestamp
            ) VALUES (
                :event_type, :connection, :device_id, :usuario, :idpersona, 
                :agente, :idpuesto, :puesto, :turno, :pending_observations, 
                :pending_incidents, :details, :timestamp
            )
        ");
        $insertedCount = 0;
        foreach ($data as $event) {
            $stmt->execute([
                ':event_type' => $event['event_type'] ?? null,
                ':connection' => $event['connection'] ?? null,
                ':device_id'  => $event['device_id'] ?? null,
                ':usuario'    => $event['usuario'] ?? null,
                ':idpersona'  => $event['idpersona'] ?? null,
                ':agente'     => $event['agente'] ?? null,
                ':idpuesto'   => $event['idpuesto'] ?? null,
                ':puesto'     => $event['puesto'] ?? null,
                ':turno'      => $event['turno'] ?? null,
                ':pending_observations' => $event['pending_observations'] ?? 0,
                ':pending_incidents'    => $event['pending_incidents'] ?? 0,
                ':details'    => isset($event['details']) ? json_encode($event['details']) : null,
                ':timestamp'  => $event['timestamp'] ?? date('Y-m-d H:i:s')
            ]);
            $insertedCount++;
        }
        $db->commit();
        Flight::json(['status' => 'success', 'message' => "$insertedCount events synced successfully"]);
    } catch (Exception $e) {
        $db->rollBack();
        Flight::json(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()], 500);
    }
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
                    "idpersona" => $row['id'],
                    "idpuesto" => $row['id'],
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
        $stmt = $db->prepare('SELECT A.id, B.idservicio, C.descripcion, C.residencial, A.idcard, A.name, A.idcargo, D.description, C.inicio, C.final, A.is_active FROM person A, personpuestos B, puestos C, cargo D WHERE B.idperson = A.id AND C.id = B.idservicio AND D.id = A.idcargo AND A.idcard = "'.$cedula.'"');
        $stmt->execute();

        if($stmt->rowCount() == 0){
            $stmt = $db->prepare('SELECT B.nombre AS clientes, A.* FROM residente A, client B WHERE B.id = A.idclient AND A.cedula = "'.$cedula.'" AND A.is_active=1');
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
                        "idpuesto" => $row['idclient'],
                        "puesto" => utf8_encode($row['clientes']),
                        "residencial" => 0,
                        "cedula" => $row['cedula'],
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

            if($data[0][6] == '5' OR $data[0][6] == '7' OR $data[0][6] == '23'){
                $array = [];
                foreach($data as $row){
                    $array[] = [
                        "idpersona" => $row['id'],
                        "idpuesto" => $row['idservicio'],
                        "puesto" => utf8_encode($row['descripcion']),
                        "residencial" => $row['residencial'],
                        "nombre" => utf8_encode($row['name']),
                        "cedula" => $row['idcard'],
                        "idcargo" => $row['idcargo'],
                        "cargo" => $row['description'],
                        "inicio" => $row['inicio'],
                        "fin" => $row['final'],
                        "activo" => $row['is_active'],
                    ];
                }

                Flight::json($array);
            }else{
                $array = [
                    "data" => [
                        "total_row" => $stmt->rowCount(),
                        "mensaje" => 'Este usuario no tiene pribilegios',
                        "data" => $data
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
        $array = [
            "data" => [
                "sql" => $sql,
                "error" => "Se grabaron los registros",
            ],
            "status" => "error"
        ];
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

Flight::route('POST /salidas', function () {
    $db = Flight::db();
    $id = Flight::request()->data->id;
    $latitud = Flight::request()->data->latitud;
    $longitud = Flight::request()->data->longitud;
    $rangoerror = Flight::request()->data->rangoerror;
    $mensaje = Flight::request()->data->mensaje;
    $ip = Flight::request()->data->ip;

    $sql = 'UPDATE visitantes SET is_active=2, observacion="Salida por la aplicacion Movil", latitude="'.$latitud.'", longitude="'.$longitud.'", rangoerror="'.$rangoerror.'", mensaje="'.$mensaje.'",ip="'.$ip.'" WHERE id='.$id;
    $stmt = $db->prepare($sql);

    $array = [
        "data" => [
            "id" => $id,
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
                "error" => "Se actualizaron los registros",
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

Flight::route('POST /puntos', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
    $punto = Flight::request()->data->punto;
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
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, punto, turno, fecha, proceso, tipo, nota, observacion, foto1, foto2, foto3, foto4, foto5, foto6, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :punto, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :foto1, :foto2, :foto3, :foto4, :foto5, :foto6, :latitude, :longitude, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");

    $array = [
        "data" => [
            "idpuesto" => $idpuesto,
            "idpersona" => $idpersona,
            "punto" => $punto,
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

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":punto" => $punto, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":foto1" => $foto1, ":foto2" => $foto2, ":foto3" => $foto3, ":foto4" => $foto4, ":foto5" => $foto5, ":foto6" => $foto6, ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "Hubo un error al ingresar los registros"
            ],
            "status" => "error"
        ];
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

Flight::route('POST /inicio', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
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
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :latitude, :longitude, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");

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
            "latitude" => $latitud,
            "longitude" => $longitud,
            "rangoerror" => $rangoerror,
            "mensaje" => $mensaje,
            "ip" => $ip,
            "salida" => "Hubo un error al ingresar los registros",
        ],
        "status" => "error"
    ];

    if(!$stmt->execute([":idpuesto" => $idpuesto, ":idpersona" => $idpersona, ":turno" => $turno, ":fecha" => $fecha, ":proceso" => $proceso, ":tipo" => $tipo, ":nota" => $nota, 
                        ":observacion" => $observacion, ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
        $array = [
            "data" => [
                "id" => $db->lastInsertId(),
                "error" => "No se ingreso el registro",
            ],
            "status" => "error"
        ];
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

Flight::route('POST /panico', function () {
    $idpuesto = Flight::request()->data->idpuesto;
    $idpersona = Flight::request()->data->idpersona;
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
    $stmt = $db->prepare("INSERT INTO bitacora(idpuesto, idperson, turno, fecha, proceso, tipo, nota, observacion, latitude, longitude, rangoerror, mensaje, is_active, created_at, usuario_log, ip) VALUES
            (:idpuesto, :idpersona, :turno, :fecha, :proceso, :tipo, :nota, :observacion, :latitude, :longitude, :rangoerror, :mensaje, 1, NOW(), 'APLICACION MOVIL', :ip)");

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
                        ":observacion" => $observacion, ":latitude" => $latitud, ":longitude" => $longitud, ":rangoerror" => $rangoerror, ":mensaje" => $mensaje, ":ip" => $ip])){
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

Flight::route('GET /rondas/@puesto', function ($puesto) {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM rondas WHERE idpuesto = '.$puesto.' AND is_active = 1');
    $stmt->execute();

    if($stmt->rowCount() == 0){
        $array = [
            "data" => [
                "total_row" => $stmt->rowCount(),
                "mensaje" => 'No hay datos para mostrar',
            ],
            "status" => "error"
        ];

        Flight::json($array);
    }else{
        $data = $stmt->fetchAll();

        $array = [];
        foreach($data as $row){
            $array[] = [
                "id" => $row['id'],
                "orden" => $row['orden'],
                "name" => $row['name'],
                "latitude" => $row['latitude'],
                "longitude" => $row['longitude'],
                "activo" => $row['is_active'],
            ];
        }

        Flight::json($array);
    }
});

Flight::route('GET /contactos/@puesto', function ($puesto) {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM contacto WHERE idpuesto='.$puesto.' ORDER BY placa DESC');
    $stmt->execute();

    if($stmt->rowCount() == 0){
        $array = [
            "data" => [
                "total_row" => $stmt->rowCount(),
                "mensaje" => 'No hay datos para mostrar',
            ],
            "status" => "error"
        ];

        Flight::json($array);
    }else{
        $data = $stmt->fetchAll();

        $array = [];
        foreach($data as $row){
            $array[] = [
                "id" => $row['id'],
                "placa" => utf8_encode($row['placa']),
                "activo" => $row['is_active'],
            ];
        }

        Flight::json($array);
    }
});
   
Flight::route('GET /placas/@id', function ($id) {
    $cadena = 'SELECT * FROM contacto WHERE id='.$id;
    $db = Flight::db();
    $sql = $db->prepare($cadena);
    $sql->execute();

    $data = $sql->fetchAll();

    $array = [];
    foreach($data as $row){
        $array[] = [
            "id" => $row['id'],
            "idpersona" => $row['idperson'],
            "cedula" => $row['cedula'],
            "placa" => $row['placa'],
            "nombre" => $row['nombre'],
            "fecha" => $row['created_at'],
            "activo" => $row['is_active'],
        ];
    }

    Flight::json([
        "total_row" => $sql->rowCount(),
        "rows" => $array
    ]);
});

Flight::route('GET /visitas/@puesto', function ($puesto) {
    $cadena = 'SELECT A.* FROM visitantes A WHERE A.is_active = 1 AND A.idpuesto = '.$puesto.' ORDER BY A.nombre ASC';
    $db = Flight::db();
    $sql = $db->prepare($cadena);
    $sql->execute();

    $data = $sql->fetchAll();

    $array = [];
    foreach($data as $row){
        $array[] = [
            "id" => $row['id'],
            "idpersona" => $row['idperson'],
            "placa" => utf8_encode($row['placa']),
            "nombre" => utf8_encode($row['nombre']),
            "fecha" => $row['created_at'],
            "activo" => $row['is_active'],
        ];
    }

    Flight::json([
        "total_row" => $sql->rowCount(),
        "rows" => $array
    ]);
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

Flight::route('GET /ronda_valor/@id', function ($id) {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM consecutivo WHERE tabla = "Rondas" AND idpuesto = :id');
    $stmt->execute([":id" => $id]);

    $row = $stmt->fetch();

    if($stmt->rowCount() == 0){
        $array = [
            "data" => [
                "total_row" => $stmt->rowCount(),
                "mensaje" => 'No hay datos para mostrar',
            ],
            "status" => "error"
        ];

        Flight::json($array);
    }else{
        $array = [
                "idpuesto" => $row['idpuesto'],
                "consecutivo" => $row['consecutivo'],
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

Flight::route('GET /puestos', function () {
    $cadena = 'SELECT * FROM puestos WHERE is_active = 1';
    $db = Flight::db();
    $sql = $db->prepare($cadena);
    $sql->execute();

    $data = $sql->fetchAll();

    $array = [];
    foreach($data as $row){
        $array[] = [
            "id" => $row['id'],
            "title" => $row['codigo'],
            "description" => $row['descripcion'],
            "inicio" => $row['inicio'],
            "final" => $row['final'],
            "activo" => $row['is_active'],
        ];
    }
    Flight::json($array);
});

Flight::route('GET /tareas', function () {
    include "../core/app/model/TareaData.php";
    session_start();
    $tareas = TareaData::getAllByUserId($_SESSION["user_id"]);
    $array = [];
    foreach($tareas as $tarea){
        $array[] = [
            "id" => $tarea->id,
            "title" => $tarea->title,
            "description" => $tarea->description,
            "due_date" => $tarea->due_date,
        ];
    }
    Flight::json($array);
});

Flight::route('GET /tareas/@id', function ($id) {
    include "../core/app/model/TareaData.php";
    $tarea = TareaData::getById($id);
    $array = [
        "id" => $tarea->id,
        "title" => $tarea->title,
        "description" => $tarea->description,
        "due_date" => $tarea->due_date,
    ];
    Flight::json($array);
});

Flight::route('POST /tareas', function () {
    include "../core/app/model/TareaData.php";
    session_start();
    $tarea = new TareaData();
    $tarea->title = Flight::request()->data->title;
    $tarea->description = Flight::request()->data->description;
    $tarea->due_date = Flight::request()->data->due_date;
    $tarea->user_id = $_SESSION["user_id"];
    $tarea->add();
    $array = [
        "message" => "Tarea creada con exito",
        "status" => "success"
    ];
    Flight::json($array);
});

Flight::route('PUT /tareas/@id', function ($id) {
    include "../core/app/model/TareaData.php";
    $tarea = TareaData::getById($id);
    $tarea->title = Flight::request()->data->title;
    $tarea->description = Flight::request()->data->description;
    $tarea->due_date = Flight::request()->data->due_date;
    $tarea->update();
    $array = [
        "message" => "Tarea actualizada con exito",
        "status" => "success"
    ];
    Flight::json($array);
});

Flight::route('DELETE /tareas/@id', function ($id) {
    include "../core/app/model/TareaData.php";
    $tarea = TareaData::getById($id);
    $tarea->del();
    $array = [
        "message" => "Tarea eliminada con exito",
        "status" => "success"
    ];
    Flight::json($array);
});

Flight::start();