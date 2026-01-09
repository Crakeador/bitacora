<?php
// Inicia la sesión (si no está ya iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
<style>
.storage-value{ max-width: 450px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.nav-tabs { margin-bottom: 20px; }
.section-card { margin-bottom: 30px; }
</style>

<section class="content-header">
	<h1>
		<i class="fa fa-database"></i> Depuración de Variables
		<small>Sesión, GET, POST y Almacenamiento del Navegador</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Variables de Sistema</li>
	</ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i> <strong>Advertencia:</strong> Este panel muestra datos sensibles. No expongas esta página en producción.
            </div>
        </div>
    </div>

    <!-- Panel unificado con pestañas -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-database"></i> Variables del Sistema</h3>
                    <div class="box-tools pull-right">
                        <button type="button" id="refreshStorageBtn" class="btn btn-sm btn-default">
                            <i class="fa fa-refresh"></i> Actualizar
                        </button>
                        <button type="button" id="copyAllDataBtn" class="btn btn-sm btn-info">
                            <i class="fa fa-copy"></i> Copiar JSON
                        </button>
                        <button type="button" id="clearAllBtn" class="btn btn-sm btn-warning">
                            <i class="fa fa-trash"></i> Limpiar Navegador
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tabSession" aria-controls="tabSession" role="tab" data-toggle="tab">
                                <i class="fa fa-user-circle"></i> $_SESSION <span id="sessionPhpCount" class="badge"><?php echo count($_SESSION); ?></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tabGet" aria-controls="tabGet" role="tab" data-toggle="tab">
                                <i class="fa fa-link"></i> $_GET <span class="badge"><?php echo count($_GET); ?></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tabPost" aria-controls="tabPost" role="tab" data-toggle="tab">
                                <i class="fa fa-upload"></i> $_POST <span class="badge"><?php echo count($_POST); ?></span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tabCookies" aria-controls="tabCookies" role="tab" data-toggle="tab">
                                <i class="fa fa-circle"></i> Cookies <span id="cookieCount" class="badge">0</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tabLocal" aria-controls="tabLocal" role="tab" data-toggle="tab">
                                <i class="fa fa-hdd-o"></i> LocalStorage <span id="localCount" class="badge">0</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#tabSessionStorage" aria-controls="tabSessionStorage" role="tab" data-toggle="tab">
                                <i class="fa fa-clock-o"></i> SessionStorage <span id="sessionCount" class="badge">0</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style="margin-top: 20px;">
                        <!-- $_SESSION -->
                        <div role="tabpanel" class="tab-pane active" id="tabSession">
                            <?php if(empty($_SESSION)): ?>
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> $_SESSION está vacía.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead class="bg-primary">
                                            <tr><th style="width: 220px;">Clave</th><th>Valor</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($_SESSION as $key => $val): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($key); ?></td>
                                                    <td><?php echo safe_print_r($val); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- $_GET -->
                        <div role="tabpanel" class="tab-pane" id="tabGet">
                            <?php if(empty($_GET)): ?>
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> $_GET está vacía.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead class="bg-primary">
                                            <tr><th style="width: 220px;">Clave</th><th>Valor</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($_GET as $key => $val): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($key); ?></td>
                                                    <td><?php echo safe_print_r($val); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- $_POST -->
                        <div role="tabpanel" class="tab-pane" id="tabPost">
                            <?php if(empty($_POST)): ?>
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> $_POST está vacía.</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed">
                                        <thead class="bg-primary">
                                            <tr><th style="width: 220px;">Clave</th><th>Valor</th></tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($_POST as $key => $val): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($key); ?></td>
                                                    <td><?php echo safe_print_r($val); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Cookies -->
                        <div role="tabpanel" class="tab-pane" id="tabCookies">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="width: 220px;">Nombre</th>
                                            <th>Valor</th>
                                            <th style="width: 100px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cookieTableBody">
                                        <tr><td colspan="3" class="text-muted text-center">Cargando...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- LocalStorage -->
                        <div role="tabpanel" class="tab-pane" id="tabLocal">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="width: 220px;">Clave</th>
                                            <th>Valor</th>
                                            <th style="width: 100px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="localTableBody">
                                        <tr><td colspan="3" class="text-muted text-center">Cargando...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- SessionStorage -->
                        <div role="tabpanel" class="tab-pane" id="tabSessionStorage">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th style="width: 220px;">Clave</th>
                                            <th>Valor</th>
                                            <th style="width: 100px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sessionTableBody">
                                        <tr><td colspan="3" class="text-muted text-center">Cargando...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <small class="text-muted">
                        <i class="fa fa-info-circle"></i> <strong>Nota:</strong> Las cookies con flag HttpOnly no son accesibles por JavaScript. El botón "Limpiar Navegador" solo elimina cookies, localStorage y sessionStorage del navegador (no afecta variables PHP del servidor).
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// ===== UTILIDADES DE ALMACENAMIENTO DEL NAVEGADOR =====

// --- Cookies ---
function parseCookies(){
	var list = [];
	var raw = document.cookie || '';
	if(!raw){ return list; }
	raw.split(';').forEach(function(pair){
		var p = pair.split('=');
		var name = decodeURIComponent((p.shift()||'').trim());
		var value = decodeURIComponent((p.join('=')||'').trim());
		if(name){ list.push({ name: name, value: value }); }
	});
	return list;
}

function deleteCookie(name){
	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
	renderCookieTable();
}

function renderCookieTable(){
	var tbody = document.getElementById('cookieTableBody');
	var cookies = parseCookies();
	if(!tbody){ return; }
	tbody.innerHTML = '';
	document.getElementById('cookieCount').textContent = cookies.length;
	
	if(!cookies.length){
		var tr = document.createElement('tr');
		var td = document.createElement('td'); td.colSpan = 3; td.className='text-muted text-center'; td.textContent='No hay cookies disponibles.';
		tr.appendChild(td); tbody.appendChild(tr); return;
	}
	
	cookies.forEach(function(c){
		var tr = document.createElement('tr');
		var tdName = document.createElement('td'); tdName.textContent = c.name;
		var tdVal = document.createElement('td'); tdVal.className='storage-value'; tdVal.title = c.value; tdVal.textContent = c.value;
		var tdAct = document.createElement('td');
		var btnDel = document.createElement('button'); btnDel.className='btn btn-xs btn-danger'; btnDel.innerHTML='<i class="fa fa-trash"></i> Eliminar';
		btnDel.title = 'Eliminar cookie'; 
		btnDel.onclick = (function(n){ return function(){ if(confirm('¿Eliminar cookie "'+n+'"?')){ deleteCookie(n); } }; })(c.name);
		tdAct.appendChild(btnDel);
		tr.appendChild(tdName); tr.appendChild(tdVal); tr.appendChild(tdAct); 
		tbody.appendChild(tr);
	});
}

// --- LocalStorage ---
function getLocalStorageData(){
	var data = [];
	try{
		for(var i=0; i<localStorage.length; i++){
			var key = localStorage.key(i);
			data.push({ key: key, value: localStorage.getItem(key) });
		}
	}catch(e){}
	return data;
}

function deleteLocalStorageItem(key){
	try{ localStorage.removeItem(key); }catch(e){}
	renderLocalStorageTable();
}

function renderLocalStorageTable(){
	var tbody = document.getElementById('localTableBody');
	var data = getLocalStorageData();
	if(!tbody){ return; }
	tbody.innerHTML = '';
	document.getElementById('localCount').textContent = data.length;
	
	if(!data.length){
		var tr = document.createElement('tr');
		var td = document.createElement('td'); td.colSpan = 3; td.className='text-muted text-center'; td.textContent='LocalStorage vacío.';
		tr.appendChild(td); tbody.appendChild(tr); return;
	}
	
	data.forEach(function(item){
		var tr = document.createElement('tr');
		var tdKey = document.createElement('td'); tdKey.textContent = item.key;
		var tdVal = document.createElement('td'); tdVal.className='storage-value'; tdVal.title = item.value; tdVal.textContent = item.value;
		var tdAct = document.createElement('td');
		var btnDel = document.createElement('button'); btnDel.className='btn btn-xs btn-danger'; btnDel.innerHTML='<i class="fa fa-trash"></i> Eliminar';
		btnDel.title = 'Eliminar clave';
		btnDel.onclick = (function(k){ return function(){ if(confirm('¿Eliminar "'+k+'" de LocalStorage?')){ deleteLocalStorageItem(k); } }; })(item.key);
		tdAct.appendChild(btnDel);
		tr.appendChild(tdKey); tr.appendChild(tdVal); tr.appendChild(tdAct);
		tbody.appendChild(tr);
	});
}

// --- SessionStorage ---
function getSessionStorageData(){
	var data = [];
	try{
		for(var i=0; i<sessionStorage.length; i++){
			var key = sessionStorage.key(i);
			data.push({ key: key, value: sessionStorage.getItem(key) });
		}
	}catch(e){}
	return data;
}

function deleteSessionStorageItem(key){
	try{ sessionStorage.removeItem(key); }catch(e){}
	renderSessionStorageTable();
}

function renderSessionStorageTable(){
	var tbody = document.getElementById('sessionTableBody');
	var data = getSessionStorageData();
	if(!tbody){ return; }
	tbody.innerHTML = '';
	document.getElementById('sessionCount').textContent = data.length;
	
	if(!data.length){
		var tr = document.createElement('tr');
		var td = document.createElement('td'); td.colSpan = 3; td.className='text-muted text-center'; td.textContent='SessionStorage vacío.';
		tr.appendChild(td); tbody.appendChild(tr); return;
	}
	
	data.forEach(function(item){
		var tr = document.createElement('tr');
		var tdKey = document.createElement('td'); tdKey.textContent = item.key;
		var tdVal = document.createElement('td'); tdVal.className='storage-value'; tdVal.title = item.value; tdVal.textContent = item.value;
		var tdAct = document.createElement('td');
		var btnDel = document.createElement('button'); btnDel.className='btn btn-xs btn-danger'; btnDel.innerHTML='<i class="fa fa-trash"></i> Eliminar';
		btnDel.title = 'Eliminar clave';
		btnDel.onclick = (function(k){ return function(){ if(confirm('¿Eliminar "'+k+'" de SessionStorage?')){ deleteSessionStorageItem(k); } }; })(item.key);
		tdAct.appendChild(btnDel);
		tr.appendChild(tdKey); tr.appendChild(tdVal); tr.appendChild(tdAct);
		tbody.appendChild(tr);
	});
}

// --- Copiar todo como JSON ---
function copyAllDataJSON(){
	var allData = {
		cookies: parseCookies(),
		localStorage: getLocalStorageData(),
		sessionStorage: getSessionStorageData(),
		phpSession: <?php echo json_encode($_SESSION); ?>,
		phpGet: <?php echo json_encode($_GET); ?>,
		phpPost: <?php echo json_encode($_POST); ?>
	};
	var json = JSON.stringify(allData, null, 2);
	var ta = document.createElement('textarea'); ta.value = json; document.body.appendChild(ta); ta.select();
	try{ document.execCommand('copy'); alert('✓ Todos los datos copiados al portapapeles'); }catch(e){ alert('Error al copiar'); }
	document.body.removeChild(ta);
}

// --- Limpiar todo ---
function clearAllStorage(){
	if(!confirm('¿BORRAR TODAS las cookies, localStorage y sessionStorage?\n\nEsto cerrará tu sesión y eliminará todos los datos locales.')){
		return;
	}
	// Cookies
	parseCookies().forEach(function(c){ deleteCookie(c.name); });
	// LocalStorage
	try{ localStorage.clear(); }catch(e){}
	// SessionStorage
	try{ sessionStorage.clear(); }catch(e){}
	
	renderCookieTable();
	renderLocalStorageTable();
	renderSessionStorageTable();
	alert('✓ Todos los datos han sido eliminados.\n\nLa página se recargará.');
	setTimeout(function(){ location.reload(); }, 800);
}

// --- Actualizar tablas ---
function refreshAllTables(){
	renderCookieTable();
	renderLocalStorageTable();
	renderSessionStorageTable();
}

// Eventos
document.getElementById('refreshStorageBtn').addEventListener('click', refreshAllTables);
document.getElementById('copyAllDataBtn').addEventListener('click', copyAllDataJSON);
document.getElementById('clearAllBtn').addEventListener('click', clearAllStorage);

// Cargar automáticamente al inicio
$(document).ready(function(){
	refreshAllTables();
});
</script>
