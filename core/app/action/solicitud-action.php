<?php
// Mostrar errores para depuración (quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '/var/www/latin.near-solution.com/public_html/plugins/PHPMailer/src/PHPMailer.php';
require_once '/var/www/latin.near-solution.com/public_html/plugins/PHPMailer/src/SMTP.php';
require_once '/var/www/latin.near-solution.com/public_html/plugins/PHPMailer/src/Exception.php';

//Inicializamos variable para el mensaje de error
$error_message = "";

//Verificacion de los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_GET['ticket_codigo'])) {
    // Validar que todos los campos requeridos estén presentes
    $campos_requeridos = ['contacto', 'celular', 'email', 'servicio', 'ciudad', 'asunto'];
    $campos_faltantes = [];
    
    foreach ($campos_requeridos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === "") {
            $campos_faltantes[] = $campo;
        }
    }
    
    // Validación especial para el celular
    if (isset($_POST["celular"]) && $_POST["celular"] != "") {
        if (!preg_match('/^[0-9]{10}$/', $_POST["celular"])) {
            $error_message = "El celular debe contener exactamente 10 dígitos numéricos.";
        }
    } else {
        $error_message = "El campo CELULAR es obligatorio. Por favor, proporcione su número de celular para poder contactarle.";
    }
    
    // Si hay errores, mostrar mensaje
    if (empty($error_message) && empty($campos_faltantes)) {
        $base = new Database();
        $con = $base->connect();

        // Sanitizar datos antes de insertar
        $contacto = htmlspecialchars($_POST["contacto"]);
        $email = htmlspecialchars($_POST["email"]);
        $celular = htmlspecialchars($_POST["celular"]);
        $prioridad = htmlspecialchars($_POST["prioridad"]);
        $asunto = htmlspecialchars($_POST["asunto"]);
        $title = htmlspecialchars($_POST["title"]);

        $sql = "INSERT INTO timeline (idcompany, idperson, quien_asigna, email, celular, prioridad, status, asunto, title, type, date_event, created_at) ";
        $sql.= "VALUES (1, 1, '".$contacto."', '".$email."', '".$celular."', '".$prioridad."', 1, '".$asunto."', '".$title."', 2, NOW(), NOW())"; 

        $registros = $con->query($sql);
        if (!$registros){
            $error_message = "Error en el registro: $sql";
        } else {
            // Obtener el ID del último registro insertado
            $ticket_id = $con->insert_id;
            // Envío de correo con PHPMailer usando SMTP de Gmail
            /* ...código de PHPMailer aquí... */
            $error_message = "<div class='success-message'>¡Solicitud enviada exitosamente!<br>Su número de ticket es: <strong>".$ticket_id."</strong><br>Nos pondremos en contacto con usted en breve.</div>";
        }
    } elseif (!empty($campos_faltantes) && empty($error_message)) {
        $error_message = "Los siguientes campos son obligatorios: " . implode(", ", $campos_faltantes);
    }
}

// Mostrar datos del ticket si se consulta por GET
$cadena = "";
if (isset($_GET['ticket_codigo']) && is_numeric($_GET['ticket_codigo'])) {
    $ticket_id = intval($_GET['ticket_codigo']);
    $base = new Database();
    $con = $base->connect();
    $sql = "SELECT * FROM timeline WHERE id = $ticket_id LIMIT 1";
    $result = $con->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $cadena = '<div class="alert alert-info" style="margin: 15px; font-size: 14px; font-weight: bold;">';
        $cadena .= 'Ticket encontrado:<br>';
        $cadena .= 'N° Ticket: <strong>' . htmlspecialchars($row['id']) . '</strong><br>';
        $cadena .= 'Nombre: <strong>' . htmlspecialchars($row['quien_asigna']) . '</strong><br>';
        $cadena .= 'Celular: <strong>' . htmlspecialchars($row['celular']) . '</strong><br>';
        $cadena .= 'Correo: <strong>' . htmlspecialchars($row['email']) . '</strong><br>';
        $cadena .= 'Asunto: <strong>' . htmlspecialchars($row['asunto']) . '</strong><br>';
        $cadena .= 'Comentario: <strong>' . htmlspecialchars($row['title']) . '</strong><br>';        
        $cadena .= 'Solucion: <strong>' . htmlspecialchars($row['body']) . '</strong><br>';
        $cadena .= 'Fecha: <strong>' . htmlspecialchars($row['created_at']) . '</strong>';
        $cadena .= '</div>';
    } else {
        $cadena = '<div class="alert alert-danger" style="margin: 15px; font-size: 14px; font-weight: bold;">No se encontró ningún ticket con ese número.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  <!-- Cambiado por mi: <meta charset="utf-8"> -->
        <meta name="googlebot" content="impuestos, creacion de compania">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- Denine el ancho de la pantalla a ser utilizado -->
        <meta name="robots" content="contabilidad, impuestos, facturacion electronica">
        <meta name="author" content="Jorge Fiallos">
        <meta name="keywords" content="nearsolution, seguridad, facturacion electronica, contabilidad">
        <meta name="description" content="Puedes tener el control de tu negocio con nuestro módulos desarrollados en casos reales de los diferentes negocios en el Ecuador">
        <title>Near Solution | Dashboard</title>
        <meta property="og:url" content="https://near-solution.com/">
        <meta property="og:title" content="Near Soft ERP">
        <link rel="icon" type="image/jpg" href="assets/images/icon-service.png">
        <link type="text/css" rel="stylesheet" href="assets/css/dashforge.css">
        <link type="text/css" rel="stylesheet" href="assets/css/dashforge.auth.css">
        <style>
            p * {
              display: block;
            }

            input[type="email"] {
              -webkit-appearance: none;
              appearance: none;

              width: 100%;
              border: 1px solid #333;
              margin: 0;

              font-family: inherit;
              font-size: 90%;

              box-sizing: border-box;
            }

            /* Este es nuestro diseño para los campos no válidos */
            input:invalid {
              border-color: #900;
              background-color: #fdd;
            }

            input:focus:invalid {
              outline: none;
            }

            /* Este es nuestro diseño para los campos no válidos */
            select:invalid {
              border-color: #900;
              background-color: #fdd;
            }

            /* Este es nuestro diseño para los campos no válidos */
            textarea:invalid {
              border-color: #900;
              background-color: #fdd;
            }

            textarea:focus:invalid {
              outline: none;
            }

            /* Este es el diseño para nuestros mensajes de error */
            .error {
              width: 100%;
              padding: 0;

              font-size: 80%;
              color: white;
              background-color: #900;
              border-radius: 0 0 5px 5px;

              box-sizing: border-box;
            }

            .error.active {
              padding: 0.3em;
            }

            /* Estilos para campo celular prioritario */
            #celular {
              transition: all 0.3s ease;
              border: 2px solid #ff9800;
            }

            #celular:focus {
              border-color: #007bff;
              box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            /* Mensajes de éxito */
            .success-message {
              color: #155724;
              background-color: #d4edda;
              border: 1px solid #c3e6cb;
              border-radius: 0.25rem;
              padding: 0.75rem 1.25rem;
              margin-bottom: 1rem;
            }

            /* Mensaje de alerta para el celular */
            .celular-hint {
              display: block;
              color: #ff6b6b;
              font-weight: bold;
              margin-top: 5px;
              font-size: 12px;
            }
        </style>
    </head>
    <body id="sidai">
        <!-- Content Wrapper. Contains page content -->
        <!-- Pantalla de Logeo -->
        <header class="navbar navbar-header navbar-header-fixed">
            <div class="navbar-brand">
                <div class="df-logo">Solicitud&nbsp;&nbsp;<span>Eléctronica</span></div>
            </div><!-- navbar-brand -->
        </header><!-- navbar -->
        <div class="content content-fixed content-auth" style="background-image: url('assets/images/bg-close-scaled.webp'); background-repeat:no-repeat; background-size:cover; background-position:center center;">
            <div class="containerDg">
                <div class="row">
                    <div class="col-sm">
                        <div class="card">
                            <div class="form-group">
                                <img src="assets/images/american.png" class="img-fluid" alt="Latin American" height="60%" width="20%" align="right" style="margin-top: 10px; margin-right: 10px;">
                            </div>
                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="solicitudTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="solicitud-tab" data-bs-toggle="tab" data-bs-target="#solicitud" type="button" role="tab" aria-controls="solicitud" aria-selected="true">Solicitud</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="consulta-tab" data-bs-toggle="tab" data-bs-target="#consulta" type="button" role="tab" aria-controls="consulta" aria-selected="false">Consultar Ticket</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="solicitudTabsContent" style="padding: 20px;">
                                <div class="tab-pane fade show active" id="solicitud" role="tabpanel" aria-labelledby="solicitud-tab">
                                    <!-- Mostrar mensajes de error o éxito -->
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert <?php echo (strpos($error_message, 'éxito') !== false || strpos($error_message, 'exitosamente') !== false) ? 'alert-success' : 'alert-danger'; ?>" role="alert" style="margin: 15px; font-size: 14px; font-weight: bold;">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <form class="form-horizontal" method="post" id="cotizacion" action="index.php?action=solicitud" role="form">
                                            <fieldset class="form-fieldset">
                                                <legend>Informaci&oacute;n personal</legend>
                                                <div class="form-group">
                                                    <label for="celular" class="d-block"><strong style="color: red;">* </strong>Celular <small style="color: #666;">(10 dígitos)</small>:</label>
                                                    <input type="tel" id="celular" name="celular" class="form-control" placeholder="Ej: 0987654321" pattern="[0-9]{10}" value="" required title="El celular debe contener exactamente 10 dígitos numéricos">
                                                    <small style="color: #999; display: block; margin-top: 5px;">⚠️ Este campo es obligatorio para contactarle</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contacto" class="d-block">Apellidos y Nombres:</label>
                                                    <input type="text" id="contacto" name="contacto" class="form-control" placeholder="Ingrese sus apellidos y nombres" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="d-block">Correo:</label>
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Correo electronico para ser atendido" value="" required autocomplete="email">
                                                </div>
                                            </fieldset>
                                            </br>
                                            <fieldset class="form-fieldset">
                                                <legend>Requerimiento a Solicitar</legend>
                                                <p>
                                                    <fieldset>
                                                        <legend>¿Que tipo de servicio necesita?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required">*</abbr></legend>
                                                        <input type="radio" required name="servicio" id="r1" value="1">&nbsp;&nbsp;<label for="r1">Asesor&iacute;a-tecnolog&iacute;ca</label>&nbsp;&nbsp;
                                                        <input type="radio" required name="servicio" id="r2" value="2">&nbsp;&nbsp;<label for="r2">Seguridad y vigilancia</label>
                                                    </fieldset>
                                                </p>
                                                <div class="form-group">
                                                    <label for="ciudad" class="d-block">Ciudad para el servicio:</label>
                                                    <input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Nombre de la empresa" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="prioridad" class="d-block">Prioridad:</label>
                                                    <select class="select-input form-control" id="prioridad" name="prioridad" class="d-block" required>
                                                        <option value="0" selected="selected"> Baja </option>
                                                        <option value="1"> Media </option>
                                                        <option value="2"> Alta </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="asunto" class="d-block">Asunto:</label>
                                                    <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Asunto del servicio" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="title" class="d-block">Comentario:</label>
                                                    <textarea class="form-control" id="title" name="title" rows="4" placeholder="Especifique mas informaci&oacute;n sobre el soporte"></textarea>
                                                </div>
                                            </fieldset>
                                            </br>
                                            <button class="btn btn-primary" type="submit" id="submitBtn">Enviar</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="consulta" role="tabpanel" aria-labelledby="consulta-tab">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="get" id="consultaTicket" action="index.php?action=solicitud" role="form">
                                            <fieldset class="form-fieldset">
                                                <legend>Consultar Ticket</legend>
                                                <div class="form-group">
                                                    <label for="ticket_codigo" class="d-block">Número de Ticket:</label>
                                                    <input type="text" id="ticket_codigo" name="ticket_codigo" class="form-control" placeholder="Ingrese el número del ticket" required pattern="[0-9]+" inputmode="numeric" maxlength="15">
                                                </div>
                                            </fieldset>
                                            </br>
                                            <button class="btn btn-info" type="submit" id="buscarTicketBtn">Buscar Ticket</button>
                                        </form>
                                        <div id="resultadoConsulta" style="margin: 20px 0;">
                                            <?php if (!empty($cadena)) echo $cadena; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px;">Empresa de seguridad <a href="https://grupolatinamerica.com/">Latin America</a></div>
                        </div>
                    </div>
                </div>
            </div><!-- container -->
        </div><!-- content -->
        <footer class="footer">
            <div>
            <span>© 2025 Bitacora <span>Eléctronica</span> v3.0 </span>
            <span>Created by <a href="https://grupolatinamerica.com/">Grupo Latin America</a></span>
            </div>
            <div>
            <nav class="nav">
                <a href="https://near-solution.com/licenses/standard" class="nav-link">Licencia</a>
                <a href="https://near-solution.com/help" class="nav-link">Ayuda</a>
            </nav>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.title = "Near Solution | Solicitud de Cotizaci&oacute;n";
            // Validación y ayuda para el campo celular
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                const celularInput = document.getElementById('celular');
                const celularValue = celularInput.value.trim();
                if (!celularValue) {
                    e.preventDefault();
                    alert('⚠️ CAMPO OBLIGATORIO\n\nEl número de CELULAR es requerido para poder contactarle.\n\nPor favor, ingrese un número de celular válido (10 dígitos).');
                    celularInput.focus();
                    celularInput.style.borderColor = '#c00';
                    celularInput.style.backgroundColor = '#fdd';
                    return false;
                }
                if (!/^[0-9]{10}$/.test(celularValue)) {
                    e.preventDefault();
                    alert('❌ FORMATO INVÁLIDO\n\nEl número de celular debe contener EXACTAMENTE 10 dígitos numéricos.\n\nEjemplo: 0987654321');
                    celularInput.focus();
                    celularInput.style.borderColor = '#c00';
                    celularInput.style.backgroundColor = '#fdd';
                    return false;
                }
                celularInput.style.borderColor = '';
                celularInput.style.backgroundColor = '';
            });
            document.getElementById('celular').addEventListener('focus', function() {
                this.style.borderColor = '#007bff';
                this.style.boxShadow = '0 0 0 0.2rem rgba(0, 123, 255, 0.25)';
            });
            document.getElementById('celular').addEventListener('blur', function() {
                this.style.boxShadow = 'none';
            });
            document.getElementById('celular').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 10) {
                    this.style.borderColor = '#28a745';
                } else if (this.value.length > 0) {
                    this.style.borderColor = '#ffc107';
                }
            });
            // Mostrar resultado de consulta de ticket
            document.getElementById('consultaTicket').addEventListener('submit', function(e) {
                e.preventDefault();
                var ticket = document.getElementById('ticket_codigo').value.trim();
                var resultado = document.getElementById('resultadoConsulta');
                if (!ticket) {
                    resultado.innerHTML = '<div class="alert alert-danger">Ingrese el número de ticket.</div>';
                    return;
                }
                // Simulación de consulta (aquí deberías hacer AJAX al backend)
                // Por ahora solo muestra el número ingresado
                resultado.innerHTML = '<div class="alert alert-info">Buscando información para el ticket <strong>' + ticket + '</strong>...</div>';
                setTimeout(function() {
                    window.location.href = window.location.pathname + '?action=solicitud&ticket_codigo=' + encodeURIComponent(ticket);
                }, 1200);
                // Aquí puedes agregar una llamada AJAX para mostrar el resultado real
            });
            // Solo permitir números en el input de ticket
            document.getElementById('ticket_codigo').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            // Activar tab de consulta si hay resultado
            <?php if (!empty($cadena)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var consultaTab = document.getElementById('consulta-tab');
                if (consultaTab) {
                    var tab = new bootstrap.Tab(consultaTab);
                    tab.show();
                }
            });
            <?php endif; ?>
        </script>
    </body>
</html>
