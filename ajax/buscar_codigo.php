<?php
/*
* Modulo de Operaciones para el registro del horaio de los agentes en puestos activos
* Creado: 01/12/2025
*/
session_start();
ini_set('max_input_vars', 5000);
header('Content-Type: application/json');

try {
    $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';

    // Depuración del código recibido
    error_log('Código recibido: ' . $codigo);

    if (empty($codigo)) {
        echo json_encode(['success' => false, 'message' => 'Código vacío']);
        exit;
    }

    // Buscar el código en la base de datos    
    $conn = new mysqli('localhost', 'root', 'MyNewPass', 'bitacora');
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]);
        exit;
    }

    // Usar prepared statement para evitar SQL injection
    $query = "SELECT * FROM autorizacion WHERE clave LIKE ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error en preparación: ' . $conn->error]);
        exit;
    }

    // Bind parameter
    $search_param = $codigo;
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
 
    $result = $stmt->get_result();
    $resultado = $result->fetch_object();

    // Depuración del resultado
    error_log('Resultado de búsqueda: ' . print_r($resultado, true));
    error_log('Tipo de resultado: ' . gettype($resultado));

    if ($resultado) {
        // Verificar que los campos existan
        $response = [
            'success' => true,
            'message' => 'Código encontrado',
            'nombre' => $resultado->nombre ?? '',
            'cedula' => $resultado->cedula ?? '',
            'tipo' => $resultado->tipo ?? '',
            'placa' => $resultado->placa ?? '',
            'observacion' => $resultado->observacion ?? '',
            'idresidente' => $resultado->idresidente ?? '',
            'debug' => [
                'resultado_type' => gettype($resultado),
                'resultado_keys' => array_keys((array)$resultado),
                'resultado_completo' => (array)$resultado
            ]
        ];
        
        error_log('Respuesta enviada: ' . json_encode($response));
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Código no encontrado', 'codigo_buscado' => $codigo]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    http_response_code(500);
    error_log('Excepción: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}