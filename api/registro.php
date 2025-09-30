<?php
// api/registros.php
header('Content-Type: application/json');

// Soporta métodos simples: GET (listar o obtener uno), POST (crear o actualizar con _method),
// PUT para actualizacion (a través de _method=PUT en POST), DELETE mediante _method=DELETE.
// En este ejemplo, para simplificar, se usa un fallback: si $method == 'PUT' o 'DELETE', manejamos.
// Se puede adaptar a Apache/NGINX con rewrite para usar PATCH/DELETE reales.

$method = $_SERVER['REQUEST_METHOD'];
if (isset($_POST['_method'])) {
  $method = strtoupper($_POST['_method']);
}

// Funciones auxiliares
function responder($code, $data){
  http_response_code($code);
  echo json_encode($data);
  exit;
}

$pdo = getPdoConnection(); // Implementa en config.php y retorna PDO

if ($method === 'GET') {
  // Si ?id=, obtener uno; sino, listar todos
  if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM registros WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) responder(200, $row);
    responder(404, ['error' => 'Registro no encontrado']);
  } else {
    $stmt = $pdo->prepare('SELECT * FROM registros ORDER BY id DESC');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    responder(200, $rows);
  }
}

if ($method === 'POST') {
  // Crear
  if (isset($_POST['_method']) && strtoupper($_POST['_method']) === 'PUT') {
    // Actualizar
    if (!isset($_POST['id'])) responder(400, ['error' => 'ID requerido']);
    $id = $_POST['id'];
    $stmt = $pdo->prepare('UPDATE registros SET iddepartamento = ?, observacion = ?, monto = ?, fecha = ? WHERE id = ?');
    $success = $stmt->execute([
      $_POST['iddepartamento'], $_POST['observacion'], $_POST['monto'], $_POST['fecha'], $id
    ]);
    if ($success) responder(200, ['status' => 'actualizado']);
    responder(500, ['error' => 'Error al actualizar']);
  } elseif (isset($_POST['_method']) && strtoupper($_POST['_method']) === 'DELETE') {
    // Eliminar a través de POST con _method=DELETE
    if (!isset($_POST['id'])) responder(400, ['error' => 'ID requerido']);
    $stmt = $pdo->prepare('DELETE FROM registros WHERE id = ?');
    $stmt->execute([$_POST['id']]);
    responder(200, ['status' => 'eliminado']);
  } else {
    // Crear nuevo
    $stmt = $pdo->prepare('INSERT INTO registros (iddepartamento, observacion, monto, fecha) VALUES (?, ?, ?, ?)');
    $success = $stmt->execute([
      $_POST['iddepartamento'], $_POST['observacion'], $_POST['monto'], $_POST['fecha']
    ]);
    if ($success) {
      responder(201, ['id' => $pdo->lastInsertId()]);
    }
    responder(500, ['error' => 'Error al crear']);
  }
}

// Si llegaste aquí, no debería ocurrir
responder(400, ['error' => 'Solicitud inválida']);