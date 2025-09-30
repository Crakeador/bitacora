<?php
//Verificacion de los datos
if(isset($_POST["cedula"]) && $_POST["cedula"]!=""){
    $base = new Database();
    $con = $base->connect();

    // Codigo para el ingreso de la auditoria
    $sql = "INSERT INTO cotizacion (idcompany, tipo, cedula, contacto, cargo, celular, email, ruc, razon, telefono, correo, direccion, servicio, puntos, horas, modalidad, ciudad, fecha, observacion, status) ";
    $sql .= "value (1, 3, '".$_POST["cedula"]."', '".$_POST["contacto"]."', '".$_POST["cargo"]."', '".$_POST["celular"]."', '".$_POST["email"]."', '".$_POST["ruc"]."', '".$_POST["razon"]."', '".$_POST["telefono"]."', '".$_POST["correo"]."', '".$_POST["direccion"]."', '".$_POST["servicio"]."', '".$_POST["puntos"]."', '".$_POST["horas"]."', '".$_POST["modalidad"]."', '".$_POST["ciudad"]."', '".$_POST["fecha"]."', '".$_POST["observacion"]."', 4)";
    
    $registros = $con->query($sql);
    if (!$registros){
    	echo "Error en el Control: $sql</br>";
    } 
    
    // Varios destinatarios
	$para = 'admibrisana@gmail.com'; // atención a la coma
	$título = 'Solicitud de un registro nuevo';

	// mensaje
	$mensaje = '<html>
                	<head>
                	    <title>Se esta solicitando la autorizacion de un registro</title>
                	</head>
                	<body>
                		<h1>Se realizo una Nueva cotizacion de la empresa '.$_POST["razon"].'</h1>
                	    <p>La persona con la cedula: '.$_POST["cedula"].'. Solicita el servicio para el dia: '.$_POST["fecha"].', con el siguiente comentario:</p>
                	    <p>'.$_POST["observacion"].'</p>
                	</body>
            	</html>';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: glerma@cipol.ec, gerencia@cipol.ec, programacion@cipol.ec '."\r\n";
	$cabeceras .= 'From: CIPOL <info@cipol.ec>' . "\r\n";

	// Enviarlo
	$bool = mail($para, $título, $mensaje, $cabeceras);
}
?>
<html>
    <head>    
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  <!-- Cambiado por mi: <meta charset="utf-8"> -->
        <meta name="googlebot" content="impuestos, creacion de compania">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- Denine el ancho de la pantalla a ser utilizado -->
        <meta name="robots" content="contabilidad, impuestos, facturacion electronica">
        <meta name="author" content="Jorge Fiallos">
        <meta name="keywords" content="nearsolutions, seguridad, facturacion electronica, contabilidad">
        <meta name="description" content="Puedes tener el control de tu negocio con nuestro módulos desarrollados en casos reales de los diferentes negocios en el Ecuador">
        <title>Near Solutions | Dashboard</title>
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
        </style>
    </head>
    <body id="sidai">
      <!-- Content Wrapper. Contains page content -->
      <!-- Pantalla de Logeo -->
      <header class="navbar navbar-header navbar-header-fixed">
        <div class="navbar-brand">
          <div class="df-logo">Credencial&nbsp;&nbsp;<span>Eléctronica</span></div>
        </div><!-- navbar-brand -->
      </header><!-- navbar -->
      <div class="content content-fixed content-auth" style="background-image: url('assets/images/american.png'); background-repeat:no-repeat; background-size:cover; background-position:center center;">
        <div class="containerDg">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="form-group">
                            <img src="assets/images/american.png" class="img-fluid" alt="Latin American" height="60%" width="20%" align="right">
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="post" id="cotizacion" action="index.php?action=solicitud" role="form">
                                <fieldset class="form-fieldset">
                                    <legend>Informaci&oacute;n personal</legend>
                                    <div class="form-group">
                                        <label for="cedula" class="d-block">Cedula:</label>
                                        <input type="number" id="cedula" name="cedula" class="form-control" placeholder="Ingrese su cedula" value="" required minlength="10" maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label for="contacto" class="d-block">Apellidos y Nombres:</label>
                                        <input type="text" id="contacto" name="contacto" class="form-control" placeholder="Enter your firstname" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <legend>Requerimiento a Solicitar</legend>
                                        <p>
                                            <fieldset>
                                            <legend>¿Indique el tipo de residente?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required">*</abbr></legend>
                                            <input type="radio" required name="tipo" id="tipo" value="1">&nbsp;&nbsp;<label for="r1">Asesor&iacute;a-tecnolog&iacute;ca</label>
                                            <input type="radio" required name="tipo" id="tipo" value="2">&nbsp;&nbsp;<label for="r2">Seguridad y vigilancia</label>
                                            </fieldset>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="puntos" class="d-block">Cantidad de Puntos:</label>
                                        <input type="number" id="puntos" name="puntos" class="form-control" placeholder="1, 2 o 3" value="1" required minlength="1" maxlength="13" step="1" pattern="\d+">
                                    </div>
                                    <div class="form-group">
                                        <label for="cargo" class="d-block">Cargo:</label>
                                        <input type="text" id="cargo" name="cargo" class="form-control" placeholder="Enter your firstname" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="celular" class="d-block">Celular:</label>
                                        <input type="number" id="celular" name="celular" class="form-control" placeholder="Numero de celular" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="d-block">Correo:</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Correo electronico para ser atendido" value="" required>
                                    </div>
                                </fieldset>
                                </br>
                                <fieldset class="form-fieldset">
                                    <legend>Requerimiento a Solicitar</legend>
                                    <p>
                                        <fieldset>
                                          <legend>¿Que tipo de servicio necesita?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required">*</abbr></legend>
                                          <input type="radio" required name="servicio" id="r1" value="1">&nbsp;&nbsp;<label for="r1">Asesor&iacute;a-tecnolog&iacute;ca</label>
                                          <input type="radio" required name="servicio" id="r2" value="2">&nbsp;&nbsp;<label for="r2">Seguridad y vigilancia</label>
                                        </fieldset>
                                    </p>
                                    <div class="form-group">
                                        <label for="puntos" class="d-block">Cantidad de Puntos:</label>
                                        <input type="number" id="puntos" name="puntos" class="form-control" placeholder="1, 2 o 3" value="1" required minlength="1" maxlength="13" step="1" pattern="\d+">
                                    </div>
                                    <p>
                                        <fieldset>
                                          <legend>¿Cuantas horas necesita?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required">*</abbr></legend>
                                          <input type="radio" required name="horas" id="h1" value="1">&nbsp;&nbsp;<label for="h1">8</label>
                                          <input type="radio" required name="horas" id="h2" value="2">&nbsp;&nbsp;<label for="h2">9</label>
                                          <input type="radio" required name="horas" id="h3" value="3">&nbsp;&nbsp;<label for="h3">10</label>
                                          <input type="radio" required name="horas" id="h4" value="4">&nbsp;&nbsp;<label for="h4">12</label>
                                          <input type="radio" required name="horas" id="h5" value="5">&nbsp;&nbsp;<label for="h5">16</label>
                                          <input type="radio" required name="horas" id="h6" value="6">&nbsp;&nbsp;<label for="h6">24</label>
                                        </fieldset>
                                    </p>
                                    <p>
                                        <fieldset>
                                          <legend>¿Que tipo de modalidad?&nbsp;&nbsp;<abbr title="Este campo es obligatorio" aria-label="required">*</abbr></legend>
                                          <input type="radio" required name="modalidad" id="m1" value="1">&nbsp;&nbsp;<label for="m1">Fijo</label>
                                          <input type="radio" required name="modalidad" id="m2" value="2">&nbsp;&nbsp;<label for="m2">Movil</label>
                                        </fieldset>
                                    </p>
                                    <div class="form-group">
                                        <label for="ciudad" class="d-block">Ciudad para el servicio:</label>
                                        <input type="text" id="ciudad" name="ciudad" class="form-control" placeholder="Nombre de la empresa" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono" class="d-block">Telefono:</label>
                                        <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Numero de telefono" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha" class="d-block">Fecha de contrataci&oacute;n:</label>
                                        <input type="date" id="fecha" name="fecha" class="form-control" placeholder="Correo electronico para ser atendido" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion" class="d-block">Comentario:</label>
                                        <textarea class="form-control" id="observacion" name="observacion" rows="4" placeholder="Especifique mas informaci&oacute;n sobre el punto"></textarea>
                                    </div>
                                </fieldset>
                                </br>
                                <button class="btn btn-primary" type="submit">Enviar</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            Empresa de seguridad
                            <a href="https://grupolatinamerica.com/">Latin America</a>
                        </div>
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
            <a href="https://nearsolutions.com.ec/licenses/standard" class="nav-link">Licencia</a>
            <a href="https://nearsolutions.com.ec/help" class="nav-link">Ayuda</a>
          </nav>
        </div>
    </footer>
    <script>
        document.title = "Near Solutions | Solicitud de Cotizaci&oacute;n";
    </script>
</body>
</html>