<?php
// ver_variables.php

// Inicia la sesión (si no está ya iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Opcional: establecer algunos valores de ejemplo en las superglobales para pruebas
// _GET, _POST, _SESSION (descomenta solo para pruebas en tu entorno)
// $_GET['usuario'] = 'ana';
// $_POST['contrasena'] = '1234';
// $_SESSION['rol'] = 'admin';

function safe_print_r($data) {
    // Devuelve una representación segura para imprimir
    if (is_array($data) || is_object($data)) {
        return '<pre>' . htmlspecialchars(print_r($data, true)) . '</pre>';
    }
    return '<code>' . htmlspecialchars((string)$data) . '</code>';
}

// Función para imprimir una de las superglobales en una tabla
function imprimir_tabla($titulo, $array) {
    $html = '';
    $html .= '<h5 class="mt-4">' . htmlspecialchars($titulo) . '</h5>';
    if (empty($array) || !is_array($array)) {
        $html .= '<div class="alert alert-info" role="alert">No hay datos.</div>';
        return $html;
    }

    $html .= '<table class="table table-striped table-bordered table-sm">';
    $html .= '<thead class="table-dark"><tr><th>Clave</th><th>Valor</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($array as $clave => $valor) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars((string)$clave) . '</td>';
        if (is_array($valor) || is_object($valor)) {
            $html .= '<td>' . safe_print_r($valor) . '</td>';
        } else {
            $html .= '<td>' . htmlspecialchars((string)$valor) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    return $html;
}

// Preparar contenidos a imprimir
$contenido = '';

$contenido .= imprimir_tabla('$_GET', $_GET);
$contenido .= imprimir_tabla('$_POST', $_POST);
$contenido .= imprimir_tabla('$_SESSION', $_SESSION);

?>
<main class="container">
    <h1 class="mb-4">Imprimir variables de sesión, GET y POST</h1>

    <div class="mb-3">
        <div class="alert alert-warning" role="alert">
        Este script muestra las variables de las super globales en tablas. Asegúrate de no exponer datos sensibles en un entorno de producción.
        </div>
    </div>
    <?php echo $contenido; ?>
</main>
<footer class="text-center py-4 mt-4">
    <small class="text-muted">         </small>
</footer>
