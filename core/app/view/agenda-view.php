<?php
require_once __DIR__ . '/../../../documentos/conexion.php';

$mysqli = getConn();

$msg = '';

function h($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

// Mapeo de estados de negociación con códigos numéricos
$ESTADOS_NEGOCIACION = array(
    1 => 'Contacto Inicial',
    2 => 'Reunión con el Dueño',
    3 => 'Visita en Sitio',
    4 => 'Aprobado por los Dueños',
    5 => 'Licitación Objetada',
    6 => 'En Revisión',
    7 => 'Completado'
);

$ESTADOS_COLORES = array(
    1 => '#FF6B6B',  // Rojo - Inicial Contacto
    2 => '#FFA500',  // Naranja - Reunión
    3 => '#FFD700',  // Amarillo - Visita
    4 => '#90EE90',  // Verde - Aprobado
    5 => '#FF1493',  // Rosa - Objetada
    6 => '#87CEEB',  // Azul - En Revisión
    7 => '#00CED1'   // Turquesa - Completado
);
 
// Manejo de acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'crear') {
        $idcomercial = intval($_POST['idcomercial'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $fecha = trim($_POST['fecha'] ?? '');
        $hora = trim($_POST['hora'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $persona_contacto = trim($_POST['persona_contacto'] ?? '');
        $lugar = trim($_POST['lugar'] ?? '');
        $estado = intval($_POST['estado'] ?? 1);
        $color = isset($ESTADOS_COLORES[$estado]) ? $ESTADOS_COLORES[$estado] : '#3c8dbc';
        $start = $fecha . ' ' . $hora;
        $end = $start;
        $user_id = isset($_SESSION['id_person']) ? intval($_SESSION['id_person']) : (isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null);

        $usuario_log = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'ADMIN';
        
        // Obtener IP real considerando proxies
        $ip_addr = 'LOCALHOST';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_addr = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip_addr = $_SERVER['REMOTE_ADDR'];
        }

        // Validar que se seleccionó un cliente
        if ($idcomercial <= 0) {
            $msg = 'error::Debe seleccionar un cliente para la actividad.';
        } else {
            // Escapar valores para SQL
            $idcomercial_esc = intval($idcomercial);
            $user_id_esc = intval($user_id);
            $title_esc = $mysqli->real_escape_string($title);
            $fecha_esc = $mysqli->real_escape_string($fecha);
            $hora_esc = $mysqli->real_escape_string($hora);
            $descripcion_esc = $mysqli->real_escape_string($descripcion);
            $persona_contacto_esc = $mysqli->real_escape_string($persona_contacto);
            $lugar_esc = $mysqli->real_escape_string($lugar);
            $color_esc = $mysqli->real_escape_string($color);
            $start_esc = $mysqli->real_escape_string($start);
            $end_esc = $mysqli->real_escape_string($end);
            $estado_esc = intval($estado);
            $usuario_log_esc = $mysqli->real_escape_string($usuario_log);
            $ip_addr_esc = $mysqli->real_escape_string($ip_addr);
            
            $sql = "INSERT INTO eventos (idcomercial, iduser, title, fecha, hora, descripcion, persona_contacto, lugar, color, start, end, estado, usuario_log, ip) 
                    VALUES ($idcomercial_esc, $user_id_esc, '$title_esc', '$fecha_esc', '$hora_esc', '$descripcion_esc', '$persona_contacto_esc', '$lugar_esc', '$color_esc', '$start_esc', '$end_esc', $estado_esc, '$usuario_log_esc', '$ip_addr_esc')";
            
            if ($mysqli->query($sql)) {
                $msg = 'success::Actividad registrada correctamente.';
            } else {
                $msg = 'error::Error al registrar: ' . h($mysqli->error);
                error_log("[EVENTOS ERROR] " . $mysqli->error);
            }
        }
    } elseif ($accion === 'eliminar') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
          $stmt = $mysqli->prepare('UPDATE eventos SET is_active = 0 WHERE id = ?');
          if ($stmt) { $stmt->bind_param('i', $id); $stmt->execute(); $stmt->close(); $msg = 'success::Actividad eliminada.'; }
        }
    }
}

// Filtros - Recalcular siempre según la vista actual
$vista = $_GET['vista'] ?? 'dia'; // dia|semana|mes|todo
$hoy = date('Y-m-d');

// Si hay desde/hasta en GET, usarlos; sino, calcular según vista
if (isset($_GET['desde']) && isset($_GET['hasta'])) {
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
} else {
    // Calcular automáticamente según vista
    if ($vista === 'mes') {
        $desde = date('Y-m-01');
        $hasta = date('Y-m-t');
    } elseif ($vista === 'semana') {
        $desde = date('Y-m-d', strtotime('monday this week'));
        $hasta = date('Y-m-d', strtotime('sunday this week'));
    } elseif ($vista === 'todo') {
        $desde = '2000-01-01';
        $hasta = '2099-12-31';
    } else { // dia
        $desde = $hoy;
        $hasta = $hoy;
    }
}
$buscar = trim($_GET['q'] ?? '');

$where = 'WHERE 1=1';
if ($desde) { $where .= " AND DATE(start) >= '".$mysqli->real_escape_string($desde)."'"; }
if ($hasta) { $where .= " AND DATE(start) <= '".$mysqli->real_escape_string($hasta)."'"; }
if ($buscar !== '') {
    $q = '%'.$mysqli->real_escape_string($buscar).'%';
    $where .= " AND (title LIKE '$q' OR descripcion LIKE '$q' OR persona_contacto LIKE '$q' OR lugar LIKE '$q' OR usuario_nombre LIKE '$q' OR cliente_nombre LIKE '$q')";
}

// Detectar PK de comercial (id o idclient)
$testPK = $mysqli->query("SHOW COLUMNS FROM comercial LIKE 'id'")->num_rows > 0 ? 'id' : 'idclient';

// Obtener lista de clientes para el SELECT
$sqlClientes = "SELECT `$testPK` as id, nombre, ruc FROM comercial WHERE iduser = ".$_SESSION['user_id']." AND is_active = 1 ORDER BY nombre ASC";
$clientes = [];
if ($resClientes = $mysqli->query($sqlClientes)) {
    while ($rowCliente = $resClientes->fetch_assoc()) { 
        $clientes[] = $rowCliente; 
    }
    $resClientes->close();
}

$sqlEventos = "SELECT e.id, e.title, e.descripcion, e.color, e.start, e.persona_contacto, e.lugar, e.iduser, e.idcomercial, e.estado,
                CONCAT(u.name, ' ', u.lastname) as usuario_nombre,
                c.nombre as cliente_nombre
                FROM eventos e
                INNER JOIN user u ON e.iduser = u.id
                LEFT JOIN comercial c ON e.idcomercial = c.id
                $where AND (e.is_active = 1 OR e.is_active IS NULL) 
                ORDER BY e.start DESC";
$eventos = [];
if ($res = $mysqli->query($sqlEventos)) {
    while ($row = $res->fetch_assoc()) { $eventos[] = $row; }
    $res->close();
}
?>
<section class="content-header">
  <h1>Actividades
    <small>Registro y consulta</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="./index.php?view=calendar"><i class="fa fa-calendar"></i> Calendario</a></li>
    <li class="active">Actividades</li>
  </ol>
</section>
<section class="content">
  <?php if($msg): 
    $msg_parts = explode('::', $msg, 2);
    $msg_type = (count($msg_parts) > 1) ? $msg_parts[0] : 'info';
    $msg_text = (count($msg_parts) > 1) ? $msg_parts[1] : $msg;
    $alert_class = ($msg_type === 'error') ? 'alert-danger' : (($msg_type === 'success') ? 'alert-success' : 'alert-info');
  ?>
    <div class="alert <?= $alert_class ?> alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?= $msg_text ?>
    </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-plus"></i> Nueva actividad</h3>
        </div>
        <form method="post" class="box-body">
          <input type="hidden" name="accion" value="crear" />
          <div class="form-group">
            <label><span class="text-danger">*</span> Cliente</label>
            <select name="idcomercial" class="form-control" required>
              <option value="">-- Seleccione un cliente --</option>
              <?php foreach($clientes as $cli): ?>
                <option value="<?= intval($cli['id']) ?>">
                  <?= h($cli['nombre']) ?> <?= $cli['ruc'] ? '(' . h($cli['ruc']) . ')' : '' ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Título</label>
            <input type="text" name="title" class="form-control" required maxlength="100" />
          </div>
          <div class="form-group">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?= h($hoy) ?>" required />
          </div>
          <div class="form-group">
            <label>Hora</label>
            <input type="time" name="hora" class="form-control" value="<?= h(date('H:i')) ?>" required />
          </div>
          <div class="form-group">
            <label>Persona de contacto</label>
            <input type="text" name="persona_contacto" class="form-control" maxlength="100" />
          </div>
          <div class="form-group">
            <label>Lugar</label>
            <input type="text" name="lugar" class="form-control" maxlength="150" />
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>Estado de la Negociación</label>
            <select name="estado" class="form-control" required>
              <?php foreach($ESTADOS_NEGOCIACION as $cod => $desc): ?>
                <option value="<?= $cod ?>"><?= h($desc) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar</button>
        </form>
      </div>
    </div>

    <div class="col-md-9">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-search"></i> Filtros</h3>
        </div>
        <div class="box-body">
          <form method="get" class="form-inline">
            <input type="hidden" name="view" value="calendar-table" />
            <div class="form-group">
              <label>Vista:&nbsp;</label>
              <select name="vista" class="form-control" onchange="this.form.submit();">
                <option value="dia" <?= $vista==='dia'?'selected':'' ?>>Día</option>
                <option value="semana" <?= $vista==='semana'?'selected':'' ?>>Semana</option>
                <option value="mes" <?= $vista==='mes'?'selected':'' ?>>Mes</option>
                <option value="todo" <?= $vista==='todo'?'selected':'' ?>>Todo</option>
              </select>
            </div>
            &nbsp;
            <div class="form-group">
              <label>Desde:&nbsp;</label>
              <input type="date" name="desde" value="<?= h($desde) ?>" class="form-control" />
            </div>
            &nbsp;
            <div class="form-group">
              <label>Hasta:&nbsp;</label>
              <input type="date" name="hasta" value="<?= h($hasta) ?>" class="form-control" />
            </div>
            &nbsp;
            <div class="form-group">
              <label>Buscar:&nbsp;</label>
              <input type="text" name="q" value="<?= h($buscar) ?>" class="form-control" placeholder="Título, lugar, contacto" />
            </div>
            &nbsp;
            <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Aplicar</button>
          </form>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-list"></i> Actividades registradas</h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Título</th>
                <th>Contacto</th>
                <th>Lugar</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php if(empty($eventos)): ?>
              <tr><td colspan="9" class="text-center text-muted">Sin actividades para el filtro seleccionado.</td></tr>
            <?php else: foreach($eventos as $ev): ?>
              <?php 
                $dt = new DateTime($ev['start']); 
                $estado_cod = intval($ev['estado'] ?? 1);
                $estado_desc = $ESTADOS_NEGOCIACION[$estado_cod] ?? 'Desconocido';
                $estado_color = $ESTADOS_COLORES[$estado_cod] ?? '#3c8dbc';
              ?>
              <tr>
                <td><?= h($dt->format('Y-m-d')) ?></td>
                <td><?= h($dt->format('H:i')) ?></td>
                <td><strong><?= h($ev['cliente_nombre'] ?? 'Sin cliente') ?></strong></td>
                <td><?= h($ev['title']) ?></td>
                <td><?= h($ev['persona_contacto']) ?></td>
                <td><?= h($ev['lugar']) ?></td>
                <td><?= h($ev['usuario_nombre'] ?? 'Desconocido') ?></td>
                <td>
                  <span style="display:inline-block;width:14px;height:14px;border-radius:3px;background:<?= h($estado_color) ?>;vertical-align:middle;margin-right:5px;" title="<?= h($estado_desc) ?>"></span>
                  <small><?= h($estado_desc) ?></small>
                </td>
                <td>
                  <form method="post" style="display:inline-block;" onsubmit="return confirm('¿Eliminar actividad #<?= intval($ev['id']) ?>?');">
                    <input type="hidden" name="accion" value="eliminar" />
                    <input type="hidden" name="id" value="<?= intval($ev['id']) ?>" />
                    <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                  </form>
                  <a class="btn btn-xs btn-default" href="./index.php?view=calendar&focus=<?= h($ev['start']) ?>" title="Ver en calendario"><i class="fa fa-calendar"></i></a>
                </td>
              </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>