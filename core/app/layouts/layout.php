<?php
// Menu principal del sistema
// Modificado el: 16/01/2024
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Guayaquil');

if(!isset($_SESSION['depart'])) unset($_SESSION['user_id']);

$notificacion = 0;
$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox','qwap',
    'sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-',
    'siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh',
    'tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr',
    'webc','winw','winw','xda ','xda-');

if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;

    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}

if ($tablet_browser > 0) {
  $_SERVER['dispositivo']=3;
}
else if ($mobile_browser > 0) {
  $_SERVER['dispositivo']=2;
}
else{
  $_SERVER['dispositivo']=1;
}

if(isset($_SESSION['depart'])) $departamento = DepartamentoData::getById($_SESSION['depart']);

$ano=date("Y"); $mes=date("m"); $_SESSION["error"]=0;
//if(isset($_SESSION['depart'])) $departamento = DepartamentoData::getById("codigo", $_SESSION['depart']);

?>
<!DOCTYPE html>
<html lang="es-EC">
<head>
	  <meta charset="UTF-8">
    <meta name="googlebot" content="impuestos, creacion de compania">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Denine el ancho de la pantalla a ser utilizado -->
    <meta name="robots" content="seguridad, inteligencia artificial, camaras de seguridad, drones, control de acceso">
	  <link rel="alternate" href="https://near-solution.com" hreflang="es" />
    <link rel="manifest" href="/manifest.json">
	  <link rel="canonical" href="https://near-solution.com" />
	  <meta property="og:locale" content="es_ES" />
	  <meta property="og:locale:alternate" content="en_US" />
	  <meta property="og:type" content="article" />
	  <meta property="og:title" content="Near Solution" />
	  <meta property="og:description" content="Grupo Near Solucions es tu socio de confianza en seguridad integral somos una entidad única en el pais, comprometida con la entrega de soluciones de seguridad avanzadas, innovadoras y personalizadas, diseñadas para enfrentar los desafios mas exigentes en un entorno en constante evolución. Representamos marcas internacionales en Ecuador, ofreciendo suministros tacticos ... Leer más" />
	  <meta property="og:url" content="https://near-solution.com" />
	  <meta property="og:site_name" content="Grupo Latin America" />
	  <meta property="og:image:width" content="2560" />
	  <meta property="og:image:height" content="1422" />
	  <meta property="og:image:type" content="image/webp" />
    <meta name="author" content="Jorge Fiallos">
    <meta name="keywords" content="nearsolutions, seguridad, facturacion electronica, contabilidad">
    <meta name="description" content="Puedes tener el control de tu negocio con nuestro módulos desarrollados en casos reales de los diferentes negocios en el Ecuador" />
    <title>Near Solutions | Dashboard</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php // Seleccion de los temas del Sistema
        if(!isset($_SESSION["user_id"])){
            // DashForge CSS
            echo '<link type="text/css" rel="stylesheet" href="assets/css/dashforge.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="assets/css/dashforge.auth.css?v=1.0.1"/>';
        }else{
            // Theme style
            echo '<link type="text/css" rel="stylesheet" href="assets/css/AdminLTE.min.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="assets/css/skins/skin-yellow.min.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="assets/css/flexslider.css?v=1.0.1"/>';
            // BootsTrap
            echo '<link type="text/css" rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="plugins/datepicker/datepicker3.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="plugins/datetimepicker/css/bootstrap-datetimepicker.css?v=1.0.1"/>';
            // Data Tables
            echo '<link type="text/css" rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css?v=1.0.1"/>';
            // Font Awesome Icons
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
            // Theme style
            echo '<link type="text/css" rel="stylesheet" href="plugins/icheck/all.css?v=1.0.1">';
            // Alertas del Sistema
            echo '<link type="text/css" rel="stylesheet" href="plugins/sweetalert/sweetalert.css?v=1.0.1"/>';
            // Select2
            echo '<link type="text/css" rel="stylesheet" href="plugins/select2/css/select2.min.css?v=1.0.1"/>';
            echo '<link type="text/css" rel="stylesheet" href="plugins/jQueryUI/jquery-ui.min.css?v=1.0.1"/>';
            // Switchery
            echo '<link type="text/css" rel="stylesheet" href="plugins/switchery/switchery.min.css?v=1.0.1"/>';
        }
    ?>
    <style>
      /*Flecha para hacer la pagina hacia arriba*/
      .ir-arriba{
        display:none;
        background-repeat:no-repeat;
        font-size:20px;
        color:blue;
        cursor:pointer;
        position:fixed;
        bottom:10px;
        right:10px;
        z-index:2;
      }
      
      .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        right: 0px;
        bottom: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        
        background: gray;
        color: white;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        background: url('assets/images/cargando.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
      }
      
      .loader--show {
        display: flex;
      }	

      .circu{
        padding: 25px;
        background: #ccc;
        border-radius: 30px;
      }

      #grupoRadio label:hover{
        cursor: pointer;
      }

      #grupoRadio input[type="radio"]:checked + label {
        border: 3px solid #ccc !important;  
      } 

      .activado input[type=radio]:checked + label {
        border: 3px solid #555 !important;  
      }
      
      /* Emcabezado de la pagina */		
      #project-context,
      .project-context {
        display: inline-block;
        padding: 7px 13px 0;
        position: relative
      }

      #project-context>span,
      .project-context>span {
        display: block
      }

      .btn-header.pull-right {
        margin-left: 6px
      }

      .btn-header a>span {
        font-size: 13px;
        font-weight: 400;
        line-height: 30px;
        height: 30px;
        display: inline-block
      }

      .btn-header>:first-child>a {
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        cursor: default!important;
        display: inline-block;
        font-weight: 700;
        height: 30px;
        line-height: 24px;
        min-width: 30px;
        padding: 2px;
        text-align: center;
        text-decoration: none!important;
        -moz-user-select: none;
        -webkit-user-select: none;
        background-color: #f8f8f8;
        background-image: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f1f1f1));
        background-image: -webkit-linear-gradient(top, #f8f8f8, #f1f1f1);
        background-image: -moz-linear-gradient(top, #f8f8f8, #f1f1f1);
        background-image: -ms-linear-gradient(top, #f8f8f8, #f1f1f1);
        background-image: -o-linear-gradient(top, #f8f8f8, #f1f1f1);
        background-image: linear-gradient(top, #f8f8f8, #f1f1f1);
        border: 1px solid #bfbfbf;
        color: #6D6A69;
        font-size: 17px;
        margin: 10px 0 0
      }

      .btn-header>:first-child>a:hover {
        border: 1px solid #bfbfbf;
        color: #222;
        transition: all 0s;
        cursor: pointer;
        -webkit-box-shadow: inset 0 0 4px 1px rgba(0, 0, 0, .08);
        box-shadow: inset 0 0 4px 1px rgba(0, 0, 0, .08)
      }

      .btn-header>:first-child>a:active {
        background-color: #e8e8e8;
        background-image: -moz-linear-gradient(top, #e8e8e8 0, #ededed 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e8e8e8), color-stop(100%, #ededed));
        background-image: -webkit-linear-gradient(top, #e8e8e8 0, #ededed 100%);
        background-image: -o-linear-gradient(top, #e8e8e8 0, #ededed 100%);
        background-image: -ms-linear-gradient(top, #e8e8e8 0, #ededed 100%);
        background-image: linear-gradient(to bottom, #e8e8e8 0, #ededed 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e8e8e8', endColorstr='#ededed', GradientType=0);
        -webkit-box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, .15);
        box-shadow: inset 0 0 3px 1px rgba(0, 0, 0, .15)
      }
      
      .boton {
        border: 1px solid #2e518b; /*anchura, estilo y color borde*/
        padding: 10px; /*espacio alrededor texto*/
        background-color: #2e518b; /*color botón*/
        color: #ffffff; /*color texto*/
        text-decoration: none; /*decoración texto*/
        text-transform: uppercase; /*capitalización texto*/
        font-family: 'Helvetica', sans-serif; /*tipografía texto*/
        border-radius: 10px; /*bordes redondos*/
      }
      
      .boton:hover {
        background-color: #e8e8e8;
        border: 1px solid #bfbfbf;
        color: #222;
        transition: all 0s;
        cursor: pointer;
      }
    
      /* Temporizador de cuenta regresiva */	
      #countdown {
        display: flex;
        justify-content: center;
        font-family: Arial, sans-serif;
        font-size: 8px;
        padding: 0px;
      }
      #countdown div {
          text-align: center;
          margin: 0 5px;
      }
      
      #countdown span {
          font-size: 16px;
          font-weight: bold;
          color: #fff;
      }
      
      .smalltext {
          font-size: 9px;
          color: #fff;
      }
        
      .recortada {
          object-fit: cover; /* O 'contain', 'fill', etc. */
          object-position: 50% 50%; /* Posición (opcional) */
      }
    </style>
    <!-- jQuery jquery-2.2.4 -->
    <script type="text/javascript" src="plugins/jQuery/jquery.min.js?v=1.0.1"></script>     
    <script type="text/javascript" src="plugins/jQueryUI/jquery-ui.js?v=1.0.1"></script>
	  <script type="text/javascript" src="assets/js/jquery.flexslider.js?v=1.0.1"></script>	
    <!-- Switchery -->
    <script type="module" src="plugins/switchery/switchery.min.js?v=1.0.1"></script>
	  <script type="text/javascript"> <?php 
    if($_SESSION['idrol'] == 12){ ?>
        function esAntesDeLas17Horas() {
            const ahora = new Date();
            return ahora.getHours() < 19;
        }
    
        function countdown() {
            if (esAntesDeLas17Horas()) {
              var hora = 17;
            } else {
              var hora = 6;
            }	
    
            const targetTime = new Date();
            targetTime.setHours(hora, 30, 0); 
    
            const now = new Date().getTime();
            const timeLeft = targetTime - now;
    
            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
    
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;
        }
    
        setInterval(countdown, 1000); <?php 
    } ?>
		function cerrar() {		
			// Protección para evitar cierres accidentales de la ventana
			var allowExit = false;
			function beforeUnloadHandler(e){
				if(!allowExit){
					e.preventDefault();
					e.returnValue = '';
					return '';
				}
			}
			window.addEventListener('beforeunload', beforeUnloadHandler);

			// Si el usuario hace clic en un enlace o envía un formulario, permitimos la navegación
			document.addEventListener('click', function(e){
				var a = e.target && e.target.closest ? e.target.closest('a') : null;
				if(!a) return;
				var href = (a.getAttribute('href') || '').toLowerCase();
				if(href.startsWith('#') || href.startsWith('javascript:')) return;
				// Permitir salida para navegaciones iniciadas por clic
				allowExit = true;
				// Si es un enlace de logout/salir, removemos el handler para no mostrar aviso
				if(href.indexOf('logout') !== -1 || href.indexOf('salir') !== -1){
					window.removeEventListener('beforeunload', beforeUnloadHandler);
				}
			}, true);

			document.addEventListener('submit', function(e){
				// Permitir salida para envíos de formularios
				allowExit = true;
			}, true);
		}
		/*
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		}); */
	</script>
  </head>
  <body id="sidai" class="<?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])){ echo "sidebar-mini skin-yellow sidebar-collapse fixed"; } else { echo ""; } ?>" onload="cerrar();">
    <!-- div class="loader" style="display: flex; width: 100%; height: 100%; justify-content: center; align-items: center;"></div --> 
    <?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])):
              $notificcion = TimelineData::getAllByUserId($_SESSION["user_id"], $mes, $ano, 1);
              $notificacion = count($notificcion);
        ?>
        <!-- Main Header -->
        <div class="wrapper">
          <header class="main-header">			  
            <!-- Logo -->
            <span class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>GYE</b></span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg">LATIN GROUP</span>
            </span>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <span href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
              </span>
              <div class="project-context hidden-xs hidden-sm"><?php
                if($_SESSION['idrol'] == 12){ ?>
                  <div id="countdown">
                      <div>
                        <img src="assets/images/desp.gif" class="user-image" alt="User Image">
                      </div>
                      <div>
                          <span id="hours"></span>
                          <div class="smalltext">Horas</div>
                      </div>
                      <div>
                          <span id="minutes"></span>
                          <div class="smalltext">Minutos</div>
                      </div>
                      <div>
                          <span id="seconds"></span>
                          <div class="smalltext">Segundos</div>
                      </div>
                  </div> <?php
                }else{ ?>
                    <span style="color: white;"><b><em>Bitacora El&eacute;ctonica</em></b></span>
                    <span class="logo-lg" style="color: white;"> <?php if($_SESSION["idrol"] == 9) echo '<b>Cliente:</b> '.$_SESSION["clientes"]; else if($_SESSION['idrol'] == 8){ if($_SESSION["id_client"] == '27' || $_SESSION["id_client"] == '31') echo 'Custodias'; else echo '<b>Cliente:</b> '.$_SESSION["name"]; }else{ echo '<b>Empresa:</b> '.$_SESSION["company"].' | <b>Departamento:</b> '.$departamento->description; } ?> </span> <?php
                } ?>
              </div>
              <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">                  
                  <?php if(isset($_SESSION['rol']) && intval($_SESSION['rol'])===9){ ?>
                  <li>
                    <a href="./anuncios" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Administrar Anuncios">
                      <i class="fa fa-bullhorn"></i>
                    </a>
                  </li>
                  <?php } elseif(isset($_SESSION['depart']) && intval($_SESSION['depart'])===9) { ?>
                  <li>
                    <a href="./noticias" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Anuncios de la Urbanización">
                      <i class="fa fa-bullhorn"></i>
                    </a>
                  </li>
                  <?php } ?>
                  <li>
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 6%;">
                      <button id="alertButton" class="btn btn-block btn-danger" style="font-size: 14px; font-weight: bold;"><i class="fa fa-heartbeat"></i>&nbsp;&nbsp;Boton S.O.S.</button>
                    </div>
                  </li><?php
                  if(isset($_SESSION["idrol"]) && ($_SESSION["idrol"]=='8' || $_SESSION["idrol"]=='11')){
                      //echo '';
                  }else{ 
                      if(isset($_GET["view"]) && $_GET["view"] == "oficio"){
                        // No hay Valores
                      }elseif(isset($_SESSION["depart"]) && $_SESSION["depart"]=='1') { ?>
                          <!-- Notifications: style can be found in dropdown.less -->
                          <li class="dropdown notifications-menu">
                              <a href="#" class="dropdown-notificacion" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Notificaciones actualizadas">
                                  <i class="fa fa-bell"></i>
                                  <?php if($notificacion > 0) echo '<span class="label label-warning">'.$notificacion.'</span>'; ?>
                              </a>
                              <ul class="dropdown-menu" role="menu">
                                <li class="header">Tu tienes <?php if($notificacion > 1) echo $notificacion.' notificaciones'; else echo $notificacion.' notificacion'; ?></li>
                                <?php
                                  if($notificacion > 0){
                                    echo '<li>
                                            <!-- inner menu: contains the actual data -->
                                            <ul class="menu">';
                                              if(isset($_SESSION["idrol"]) && $_SESSION["idrol"]=='12')
                                                  echo '';
                                              else
                                                  echo '<li>
                                                    <a href="#">
                                                      <i class="fa fa-cloud text-aqua"></i> 5 nuevos archivos
                                                    </a>
                                                  </li>';
                                              echo '<li>
                                                <a href="#">
                                                  <i class="fa fa-warning text-yellow"></i> '.$notificacion.' eventos no se han verificado
                                                </a>
                                              </li>';
                                              if(isset($_SESSION["idrol"]) && $_SESSION["idrol"]=='12')
                                                  echo '';
                                              else
                                                  echo '<li>
                                                        <a href="#">
                                                          <i class="fa fa-users text-red"></i> 5 nuevos aspirantes
                                                        </a>
                                                      </li>';
                                              if(isset($_SESSION["depart"]) && $_SESSION["depart"]=='4')
                                                  echo '<li>
                                                        <a href="#">
                                                          <i class="fa fa-shopping-cart text-green"></i> Ventas listas 25 
                                                        </a>
                                                      </li>';
                                              if($diferencia->days > 230)
                                                  echo '<li>
                                                        <a href="password">
                                                          <i class="fa fa-user text-red"></i>'.$diferencia->days.' dias sin cambiar tu clave
                                                        </a>
                                                      </li>';
                                            echo '</ul>
                                        </li>';
                                    } ?>
                                  <li class="footer"><a href="notificacion">Ver todas</a></li>
                              </ul>
                          </li> <?php
                      }
                  } ?>
                  <?php // Administrador
                    if($_SESSION["rol"] == 99): ?>
                      <li>
                          <a href="./index.php?view=siscof.lista" rel="tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Compañía">
                            <span class="meta">
                                <span class="icon"><i class="fa fa-briefcase"></i></span>
                            </span>
                          </a>
                      </li>
                  <?php endif; ?>
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle2" data-toggle="dropdown">
                          <img src="assets/<?php if($_SESSION["idrol"] == 7) echo "images/avatar/user13.png"; else if(isset($_SESSION["user_id"])) if(UserData::getById($_SESSION["user_id"])->image == "") echo "images/usuario.jpg"; else echo "images/avatar/".UserData::getById($_SESSION["user_id"])->image; ?>" class="user-image" alt="User Image">
                          <span class="">
                              <?php
                                if(isset($_SESSION["id_card"])){
                            echo trim(substr(ucwords(strtolower($_SESSION["name"])), 0, 15));
                                }else{
                                    echo UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname; // htmlentities(
                                }?>
                            <b class="caret"></b>
                          </span> 
                      </a>
                      <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                          <img src="assets/<?php if($_SESSION["idrol"] == 7) echo "images/avatar/user13.png"; else if(isset($_SESSION["user_id"])) if(UserData::getById($_SESSION["user_id"])->image == "") echo "images/usuario.jpg"; else echo "images/avatar/".UserData::getById($_SESSION["user_id"])->image; ?>" class="img-circle" alt="User Image">
                          <p>
                            <?php
                                if(isset($_SESSION["id_card"])){
                                    echo substr($_SESSION["name"].' '.$_SESSION["lastname"], 0, 22);
                                }else{
                                    echo UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname; // utf8_decode(
                                }
                            ?>
                            <small>Usted tiene el ROL: <?php echo $_SESSION["desrol"]; ?></small>
                            <small>Ultimo ingreso el: <?php echo $_SESSION["ultima_sesion"]; ?></small>
                          </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                          <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Perfil</a>
                          </div>
                          <div class="pull-right">
                            <a href="./index.php?view=logout" class="btn btn-default btn-flat">Salir del Sistema</a>
                          </div>
                        </li>
                      </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;">
              <section class="sidebar" style="height: 300px; overflow: hidden; width: auto;">
                <ul class="sidebar-menu">
                  <li><a href="<?php if($_SESSION["idrol"] == 7) echo "./asignar"; elseif($_SESSION["idrol"] == 9) echo "./noticias"; else echo "./home"; ?>"><i class="fa fa-home"></i> <span>Panel de Control</span></a></li>
                  <?php
                    if(isset($_SESSION["user_id"])): ?>
                        <?php // 2 Administracion
                          if($_SESSION['depart'] == 2): ?>
                            <?php if($_SESSION['idrol'] == 3): ?>
                              <li><a href="./apertura"><i class='fa fa-cube'></i> <span>Caja Chica</span></a></li>                            
                              <li><a href="./caja"><i class='fa fa-cube'></i> <span>Resumen</span></a></li>
                            <?php endif; ?>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-print'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./reports"><i class="fa fa-circle"></i>Inventario</a></li>
                                <li><a href="./sellreports"><i class="fa fa-circle"></i>Entregas</a></li>
                              </ul>
                            </li>
                        <?php endif; ?>
                        <?php 
                          // 3 Operaciones
                          if($_SESSION['depart'] == 3){
                            if($_SESSION['idrol'] == 3 || $_SESSION['idrol'] == 5){                               
                              echo '<li class="treeview">
                                      <a href="#"><i class="fa fa-random"></i> <span>Vehiculos</span> <i class="fa fa-angle-left pull-right"></i></a>
                                      <ul class="treeview-menu">
                                        <li><a href="recibos"><i class="fa fa-circle"></i>Entregas</a></li>
                                        <li><a href="entregas"><i class="fa fa-circle"></i>Recepcion</a></li>
                                      </ul>
                                    </li>';
                              echo '<li><a href="./puestos"><i class="fa fa-hotel"></i><span> Puestos </span></a></li>';
                              echo '<li><a href="./index.php?view=opeasi.lista"><i class="fa fa-handshake"></i><span> Asignar Efectivo</span></a></li>';
                              echo '<li><a href="./descuento"><i class="fa fa-credit-card"></i><span>Liquidaci&oacute;n</span></a></li>';
                              echo '<li><a href="./agentes"><i class="fa fa-building"></i> <span>Agentes Dotados</span></a></li>'; 
                              echo '<li><a href="./bitacora"><i class="fa fa-book"></i> <span>Bitacora</span></a></li>'; 
                              echo '<li><a href="./rondas"><i class="fa fa-bicycle"></i> <span>Rondas</span></a></li>'; 
                              echo '<li><a href="./partes"><i class="fa fa-binoculars"></i> <span>Parte</span></a></li>'; 
                              echo '<li class="treeview">'; 
                                      echo '<a href="#"><i class="fa fa-calendar"></i> <span>Horario</span><i class="fa fa-angle-left pull-right"></i></a>'; 
                                      echo '<ul class="treeview-menu">'; 
                                        echo '<li><a href="./planificado"><i class="fa fa-circle"></i> Planificado </a> </li>'; 
                                        echo '<li>'; 
                                          echo '<a href="#"><i class="fa fa-circle"></i> Asistencia <i class="fa fa-angle-left pull-right"></i></a>'; 
                                          echo '<ul class="treeview-menu">'; 
                                            echo '<li><a href="./index.php?view=opehor.activos"><i class="fa fa-bullseye"></i><span> Activos </span></a></li>'; 
                                            echo '<li><a href="./index.php?view=opehor.eventual"><i class="fa fa-bullseye"></i><span> Eventuales </span></a></li>'; 
                                            echo '<li><a href="./index.php?view=opehor.inactivos"><i class="fa fa-bullseye"></i><span> Inactivos </span></a></li>'; 
                                            echo '<li><a href="./index.php?view=opehor.clientes"><i class="fa fa-bullseye"></i><span> Clientes </span></a></li>'; 
                                          echo '</ul>'; 
                                        echo '</li>'; 
                                        echo '<li><a href="./faltas"><i class="fa fa-circle"></i><span> Faltas </span></a></li>'; 
                                      echo '</ul>'; 
                              echo '</li>'; 
                              echo '<li class="treeview">'; 
                                      echo '<a href="#"><i class="fa fa-print"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>'; 
                                      echo '<ul class="treeview-menu">'; 
                                            echo '<li><a href="./index.php?view=repent.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Agentes </span></a></li>'; 
                                            echo '<li><a href="./index.php?view=reppus.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Puestos </span></a></li>'; 
                                      echo '</ul>'; 
                              echo '</li> '; 
                              echo '<li><a href="./novedades"><i class="fa fa-book-open"></i> <span> Novedades </span></a></li>';
                              echo '<li><a href="./vehiculos"><i class="fa fa-car"></i> <span> Veniculos </span></a></li>';
                            }else{
                              if($_SESSION['idrol'] == 6){ // Opcion del Supervisor ?>
                                <li class="treeview">
                                  <a href="#"><i class="fa fa-calendar"></i> <span>Horario</span><i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                  <li><a href="./planificado"><i class="fa fa-circle"></i> Planificado </a></li>
                                  <li><a href="./index.php?view=opecor.lista"><i class="fa fa-circle"></i><span> Coordinaci&oacute;n </span></a></li>
                                  <li><a href="./faltas"><i class="fa fa-circle"></i><span> Faltas </span></a></li>
                                  </ul>
                                </li>
                                <li><a href="./camara"><i class="fa fa-camera"></i><span> Camara </span></a></li>
                                <li><a href="./index.php?view=rrsdoc.lista"><i class="fa fa-barcode"></i><span> Sanciones </span></a></li>
                                <li><a href="./telefonos"><i class="fa fa-users"></i><span> Telefonos </span></a></li>
                                <li><a href="./reporte"><i class="fa fa-fax"></i> <span>Parte</span></a></li>	
                                <li><a href="./supervisar"><i class='fa fa-taxi'></i> <span>Supervici&oacute;n</span></a></li><?php
                              }else{
                                if($_SESSION['idrol'] == 7){ // Opcion del Guardia 
                                  if($_SERVER['dispositivo'] == 1){ // fotos - Modulo de ingreso de fotos USB 
                                    echo '<li><a href="./novedad"><i class="fa fa-book"></i> <span>Bitacora</span></a></li>'; 
                                  }else{
                                    echo '<li><a href="./novedad"><i class="fa fa-book"></i> <span>Bitacora</span></a></li>'; 
                                    echo '<li><a href="./camara"><i class="fa fa-recycle"></i> <span>Rondas</span></a></li>'; 
                                    echo '<li><a href="./informe"><i class="fa fa-fax"></i> <span>Parte</span></a></li>	'; 
                                    echo '<li><a href="./visitas"><i class="fa fa-suitcase"></i> <span>Visitas</span></a></li>'; 
                                    if($_SESSION['etapas'] == 1){ // Opcion para las Etapas 
                                      echo '<li><a href="./verificados"><i class="fa fa-binoculars"></i> <span>Verificados</span></a></li>';
                                    }
                                  } 
                                }else{
                                  if($_SESSION['idrol'] == 12){
                                    echo '<li><a href="./despliegue"><i class="fa fa-child"></i> <span>Despliegue</span></a></li>';
                                    echo '<li><a href="./finalizar"><i class="fa fa-power-off"></i> <span>Ultimo Turno</span></a></li>';
                                    echo '<li><a href="./faltas"><i class="fa fa-suitcase"></i><span> Faltas </span></a></li>';
                                    echo '<li><a href="./bitacora"><i class="fa fa-book"></i> <span>Bitacora</span></a></li>';
                                    echo '<li><a href="./central"><i class="fa fa-clipboard"></i> <span>Novedades</span></a></li>';
                                    echo '<li><a href="./rondas"><i class="fa fa-street-view"></i><span> Rondas </span></a></li>';
                                    echo '<li><a href="./partes"><i class="fa fa-binoculars"></i> <span>Parte</span></a></li>';
                                  }else{
                                    if($_SESSION['idrol'] == 13){
                                        echo '<li><a href="custodia"><i class="fa fa-car"></i> <span>Custodia </span></a></li>';
                                    }else{
                                        if($_SESSION['idrol'] == 11){
                                            //echo '<li><a href="preguntas"><i class="fa fa-calendar"></i> <span>Test Psicotecnico</span></a></li>';
                                        }else{
                                          if($_SESSION['idrol'] == 15){
                                            // Supervisor Interno
                                            echo '<li><a href="./supervisar"><i class="fa fa-motorcycle"></i> <span> Supervisi&oacute;n </span></a></li>';
                                          }else{
                                            echo '<li><a href="./novedad"><i class="fa fa-book-open"></i> <span> Novedades </span></a></li>';
                                            echo '<li><a href="./vehiculos"><i class="fa fa-car"></i> <span> Veniculos </span></a></li>';
                                            echo '<li><a href="./camara"><i class="fa fa-camera"></i><span> Ronda </span></a></li>';                                          
                                          } 
                                        }
                                    }
                                  }
                                } 
                              }
                            }
                          } ?>
                        <?php // 4 Comercial
                          if($_SESSION['depart'] == 4): ?>
                            <li><a href="./index.php?view=correo"><i class="fa fa-envelope"></i> <span>E-Mail</span></a></li>
                            <li><a href="./index.php?view=calendar"><i class="fa fa-calendar"></i> <span>Calendario</span></a></li>                          
                            <li><a href="./index.php?view=ventas"><i class="fa fa-database"></i> <span>Clientes</span></a></li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-print"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./index.php?view=reports"><i class="fa fa-circle"></i>Inventario</a></li>
                                <li><a href="./index.php?view=sellreports"><i class="fa fa-circle"></i>Entregas</a></li>
                              </ul>
                            </li>
                        <?php endif; ?>
                        <?php // 5 Contabilidad
                          if($_SESSION['depart'] == 5): ?>
                            <li><a href="./index.php?view=catlim.lista"><i class='fa fa-sitemap'></i> <span>Productos</span></a></li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-book"></i> <span> Contabilidad</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Asientos <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle"></i> Registrar </a></li>
                                    <li><a href="#"><i class="fa fa-circle"></i> Libro diario </a></li>
                                  </ul>
                                </li>
                                <li><a href="./index.php?view=ejercicio"><i class="fa fa-circle"></i> Ejercicio Contable </a></li>
                                <li><a href="./index.php?view=cuentas"><i class="fa fa-circle"></i> Plan de Cuentas </a></li>
                                <li><a href="./index.php?view=cuentas"><i class="fa fa-circle"></i> Centros de Costo </a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-archive"></i> <span>Financiero</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./factura"><i class="fa fa-circle"></i> Facturaci&oacute;n</a></li>
                                <li><a href="./caja"><i class="fa fa-circle"></i> Administrar caja </a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-database'></i> <span>Catalogos</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./clientes"><i class="fa fa-circle"></i> Clientes </a></li>
                                <li><a href="./puestos"><i class="fa fa-circle"></i> Servicios </a></li>
                              </ul>
                            </li>
                        <?php endif; ?>
                        <?php // 6 RRHH
                          if($_SESSION['depart'] == 6 && $_SESSION['idrol'] < 10): ?>
                              <li><a href="./index.php?view=rrping.lista"><i class='fa fa-fax'></i> <span> Personal Oficina </span></a></li>
                              <li><a href="./index.php?view=rrging.lista"><i class='fa fa-bullhorn'></i> <span> Personal Operativo </span></a></li>							
                              <li><a href="./index.php?view=opeasp.lista"><i class='fa fa-fax'></i> <span>Aspirantes</span></a></li>
                              <?php if($_SESSION['idrol'] == 3): ?>
                                  <li><a href="./index.php?view=caja"><i class='fa fa-cube'></i> <span>Caja Chica</span></a></li>
                              <?php endif; ?>
                              <li class="treeview">
                                <a href="#"><i class="fa fa-archive"></i> <span>Nomina</span><i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                  <li><a href="./index.php?view=rrhnom.lista"><i class="fa fa-circle"></i> Roles </a></li>
                                  <li><a href="./index.php?view=rrhpre.lista"><i class="fa fa-circle"></i> Descuentos </a></li>
                                  <li><a href="./index.php?view=rrhliq.lista"><i class="fa fa-circle"></i> Liquidaci&oacute;n </a></li>
                                  <li><a href="./index.php?view=rrhmac.lista"><i class="fa fa-circle"></i> Asignaci&oacute;n </a></li>
                                </ul>
                              </li>
                              <li><a href="./index.php?view=rrhvac.lista"><i class="fa fa-calendar"></i><span> Vacaciones </span></a></li>
                              <li><a href="./index.php?view=rrhdoc.lista"><i class="fa fa-barcode"></i><span> Sanciones </span></a></li>
                              <li class="treeview">
                                <a href="#"><i class="fa fa-table"></i> <span>Asistencia</span><i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                  <li>
                                    <a href="#"><i class="fa fa-folder-open-o"></i> Agentes <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                      <li><a href="./index.php?view=rrphor.activos"><i class="fa fa-bullseye"></i> Activos </a></li>
                                      <li><a href="./index.php?view=rrphor.inactivos"><i class="fa fa-bullseye"></i> Inactivos </a></li>
                                    </ul>
                                  </li>
                                  <li>
                                    <a href="#"><i class="fa fa-folder-open-o"></i> Administrativo <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                      <li><a href="./index.php?view=rrphor.registro"><i class="fa fa-circle"></i> Asistencias </a></li>
                                      <li><a href="./index.php?view=rrphor.resumen"><i class="fa fa-circle"></i> Resumen  </a></li>
                                    </ul>
                                  </li>
                                </ul>
                              </li>
                              <li class="treeview">
                                <a href="#"><i class='fa fa-database'></i> <span>Catalogos</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                  <li><a href="departamento"><i class="fa fa-circle"></i><span> Departamentos </span></a></li>
                                  <li><a href="./index.php?view=catcar.lista"><i class="fa fa-circle"></i><span> Cargos </span></a></li>
                                  <li><a href="./index.php?view=catrub.lista"><i class="fa fa-circle"></i><span> Rubros </span></a></li>
                                </ul>
                              </li>
                        <?php endif; ?>
                        <?php // 7 Logistica
                          if($_SESSION['depart'] == 7): ?>
                            <li><a href="carnets"><i class="fa fa-image"></i> <span>Carnets</span></a></li>
                            <li><a href="conducta"><i class="fa fa-key"></i> <span>Salvo Conducto</span></a></li>
                            <li><a href="productos"><i class="fa fa-sitemap"></i> <span>Productos</span></a></li>
                            <li><a href="prendas"><i class="fa fa-clipboard"></i> <span>Entregar dotaci&oacute;n</span></a></li>
                            <li><a href="dotar"><i class="fa fa-briefcase"></i><span>Dotar Puesto</span></a></li>
                            <li><a href="descuento"><i class="fa fa-credit-card"></i><span>Liquidaci&oacute;n</span></a></li>
                            <?php if($_SESSION['idrol'] == 3): ?>
                                <li><a href="./index.php?view=caja"><i class="fa fa-cube"></i> <span>Caja Chica</span></a></li>
                            <?php endif; ?>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-area-chart'></i> <span>Inventario</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./inventary"><i class="fa fa-circle"></i>Inventario</a></li>
                                <li><a href="./index.php?view=re"><i class="fa fa-circle"></i>Abastecer</a></li>
                                <li><a href="./index.php?view=res"><i class="fa fa-circle"></i>Abastecimientos</a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-random'></i> <span>Custodia</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="<?php echo $url; ?>recibos"><i class="fa fa-circle"></i>Entregas</a></li>
                                <li><a href="<?php echo $url; ?>entregas"><i class="fa fa-circle"></i>Recepcion</a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-print'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <?php
                                  if($_SESSION["actividad"] == 1){
                                    echo '<li><a href="./index.php?view=repent.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Agentes</span></a></li>';
                                    echo '<li><a href="./index.php?view=reppus.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Puestos</span></a></li>';
                                  }
                                ?>
                                <li><a href="./index.php?view=reports"><i class="fa fa-circle"></i>Inventario</a></li>
                                <li><a href="./index.php?view=sellreports"><i class="fa fa-circle"></i>Entregas</a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-database'></i> <span>Catalogos</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./categorias"><i class="fa fa-circle"></i>Categorias</a></li>
                                <li><a href="./proveedores"><i class="fa fa-circle"></i>Proveedores</a></li>
                              </ul>
                            </li>
                        <?php endif; ?>
                        <?php 
                          // 8 Financiero
                          if($_SESSION['depart'] == 8){
                            print "<li><a href=\"./bodega\"><i class='fa fa-home'></i> <span>Bodegas</span></a></li>
                                <li><a href=\"./index.php?view=repent.lista\"><i class='fa fa-edit'></i> <span>Entrega de dotaci&oacute;n</span></a></li>
                                <li><a href=\"./productos\"><i class='fa fa-book'></i> <span>Listado de Productos</span></a></li>
                                <li class='treeview'>
                                <a href=\"#\"><i class='fa fa-area-chart'></i> <span>Catalogos</span> <i class='fa fa-angle-left pull-right'></i></a>
                                <ul class='treeview-menu'>
                                  <li><a href=\"./clientes\"><i class='fa fa-circle'></i> Clientes </a></li>
                                  <li><a href=\"./puestos\"><i class='fa fa-circle'></i> Puestos </a></li>
                                  <li><a href=\"./index.php?view=res\"><i class='fa fa-circle'></i> Abastecimientos</a></li>
                                </ul>
                                </li>
                                <li class='treeview'>
                                <a href=\"#\"><i class='fa fa-print'></i> <span>Reportes</span> <i class='fa fa-angle-left pull-right'></i></a>
                                <ul class='treeview-menu'>
                                  <li><a href=\"./index.php?view=repent.lista\"><i class=\"fa fa-circle\"></i><span>Dotaci&oacute;n de Agentes</span></a></li>
                                  <li><a href=\"./index-php?view=reppus.lista\"><i class=\"fa fa-circle\"></i><span>Dotaci&oacute;n de Puestos</span></a></li>
                                  <li><a href=\"./index.php?view=reports\"><i class='fa fa-circle'></i>Inventario</a></li>
                                  <li><a href=\"./index.php?view=sellreports\"><i class='fa fa-circle'></i>Entregas</a></li>
                                </ul>
                                </li>";
                          } 
                          // 9 Residenciales
                          if($_SESSION['depart'] == 9){
                            if($_SESSION['idrol'] == 8){				
                              echo "<li><a href=\"./fechas\"><i class='fa fa-book'></i> <span>Bitacora</span></a></li>";
                              echo "<li><a href=\"./residentes\"><i class='fa fa-building'></i> <span>Residentes</span></a></li>";
                              echo "<li><a href=\"./novedades\"><i class='fa fa-binoculars'></i> <span>Novedades</span></a></li>";
                              echo "<li><a href=\"./anuncios\"><i class='fa fa-bullhorn'></i> <span>Anuncios</span></a></li>";
                            }							
                            if($_SESSION['idrol'] == 9){							
                              echo "<li><a href=\"./autorizan\"><i class='fa fa-book'></i> <span>Autorizar</span></a></li>";
                              echo "<li><a href=\"./autorizo\"><i class='fa fa-binoculars'></i> <span>Historial</span></a></li>";
                              echo "<li><a href=\"./informo\"><i class='fa fa-university'></i> <span>Novedades</span></a></li>";
                            }
                          }						
                          // Pasantes
                          if($_SESSION['idrol'] == 10){								
                            if($_SESSION['depart'] == 3){								
                              echo "<li><a href=\"./index.php?view=opeasi.personal\"><i class='fa fa-handshake'></i><span> Asignar Efectivo</span></a></li>";
                            }else{
                              echo "<li><a href=\"./index.php?view=rrging.persons\"><i class='fa fa-bullhorn'></i> <span> Personal Operativo </span></a></li>";
                            }
                          }
                        ?>
                        <?php // Administrador
                          if($_SESSION["is_admin"] == 1): ?>
                            <li class="header">Comercial</li>
                            <li><a href="./anuncios"><i class='fa fa-bullhorn'></i><span> Anuncios </span></a></li>
                            <li><a href="./informes"><i class='fa fa-envelope'></i><span> Informes </span></a></li>
                            <li><a href="./cotizacion"><i class='fa fa-diamond'></i><span> Cotizaciones </span></a></li>
                            <li><a href="./estadistica"><i class='fa fa-line-chart'></i><span> Estadisticas </span></a></li>
                            <!-- li class="header">Contabilidad</li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-tasks"></i> <span> Registro</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Asientos <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle"></i> Registrar </a></li>
                                    <li><a href="#"><i class="fa fa-circle"></i> Libro diario </a></li>
                                  </ul>
                                </li>
                                <li><a href="./index.php?view=ejercicio"><i class="fa fa-circle"></i> Ejercicio Contable </a></li>
                                <li><a href="./index.php?view=cuentas"><i class="fa fa-circle"></i> Plan de Cuentas </a></li>
                                <li><a href="./index.php?view=cuentas"><i class="fa fa-circle"></i> Centros de Costo </a></li>
                              </ul>
                            </li -->
                            <li><a href="./index.php?view=cobnom.lista"><i class='fa fa-hotel'></i><span> Control de Nomina </span></a></li>
                            <li class="header">Financiero</li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-archive"></i> <span>Financiero</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./clientes"><i class="fa fa-circle"></i> Clientes </a></li>
                                <li><a href="./factura"><i class="fa fa-circle"></i> Facturaci&oacute;n</a></li>
                                <li><a href="./caja"><i class="fa fa-circle"></i> Administrar caja </a></li>
                              </ul>
                            </li>
                            <li class="header">Talento Humano</li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-table"></i> <span>Talento Humano</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./index.php?view=rrging.lista"><i class="fa fa-circle"></i> Registro de guardias </a></li>
                                <li><a href="./index.php?view=rrping.lista"><i class="fa fa-circle"></i> Registro de personal </a></li>
                                <li><a href="./index.php?view=rrhliq.lista"><i class="fa fa-circle"></i> Liquidaci&oacute;n </a></li>
                                <li><a href="./index.php?view=rrhvac.lista"><i class="fa fa-circle"></i> Vacaciones </a></li>
                                <li><a href="./index.php?view=rrhdoc.lista"><i class="fa fa-circle"></i> Sansiones </a></li>
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Nomina <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="./index.php?view=rrhnom.lista"><i class="fa fa-circle"></i> Roles </a></li>
                                    <li><a href="./index.php?view=rrhpre.lista"><i class="fa fa-circle"></i> Adicionales </a></li>
                                    <li><a href="./index.php?view=rrhliq.lista"><i class="fa fa-circle"></i> Liquidaci&oacute;n </a></li>
                                    <li><a href="./index.php?view=rrhmac.lista"><i class="fa fa-circle"></i> Asignaci&oacute;n </a></li>
                                  </ul>
                                </li>
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Operaciones <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="./index.php?view=opeasp.lista"><i class='fa fa-circle'></i> Aspirantes </a></li>
                                    <li><a href="./index.php?view=opegur.lista"><i class='fa fa-circle'></i> Guardias </a></li>
                                    <li><a href="./index.php?view=rrphor.activos"><i class="fa fa-circle"></i> Resumen Activo</a></li>
                                    <li><a href="./index.php?view=rrphor.inactivos"><i class="fa fa-circle"></i> Resumen Inactivo</a></li>
                                  </ul>
                                </li>
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Asistencia <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="./index.php?view=opehor.activos"><i class="fa fa-circle"></i><span> Activos </span></a></li>
                                    <li><a href="./index.php?view=opehor.eventual"><i class="fa fa-circle"></i><span> Eventuales </span></a></li>
                                    <li><a href="./index.php?view=opehor.inactivos"><i class="fa fa-circle"></i><span> Inactivos </span></a></li>
                                  </ul>
                                </li>
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Administrativo <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="./index.php?view=rrphor.registro"><i class="fa fa-bullseye"></i><span> Asistencias </span></a></li>
                                    <li><a href="./index.php?view=rrphor.resumen"><i class="fa fa-bullseye"></i><span> Resumen </span></a></li>
                                  </ul>
                                </li>
                              </ul>
                            </li>
                            <li class="header">Operaciones</li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-calendar"></i> <span>Operaciones</span><i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./index.php?view=opeasp.lista"><i class='fa fa-circle'></i> <span>Aspirantes</span></a></li>
                                <li><a href="./index.php?view=planificado"><i class="fa fa-circle"></i> Planificado </a></li>
                                <li>
                                  <a href="#"><i class="fa fa-circle"></i> Asistencia <i class="fa fa-angle-left pull-right"></i></a>
                                  <ul class="treeview-menu">
                                    <li><a href="./index.php?view=opehor.activos"><i class="fa fa-bullseye"></i><span> Activos </span></a></li>
                                    <li><a href="./index.php?view=opehor.eventual"><i class="fa fa-bullseye"></i><span> Eventuales </span></a></li>
                                    <li><a href="./index.php?view=opehor.inactivos"><i class="fa fa-bullseye"></i><span> Inactivos </span></a></li>
                                  </ul>
                                </li>
                                <li><a href="./index.php?view=faltas"><i class="fa fa-circle"></i><span> Faltas </span></a></li>
                                <li><a href="./index.php?view=puestos"><i class="fa fa-circle"></i><span> Servicios </span></a></li>
                              </ul>
                            </li>
                            <li><a href="./bitacora"><i class='fa fa-book'></i> <span>Bitacora</span></a></li>
                            <li><a href="./partes"><i class='fa fa-binoculars'></i> <span>Parte</span></a></li>
                            <li><a href="./index.php?view=opeasi.lista"><i class='fa fa-sign-in'></i><span> Asignar Efectivo</span></a></li>
                            <li><a href="./prendas"><i class='fa fa-clipboard'></i><span> Entregar dotaci&oacute;n </span></a></li>
                            <li><a href="./dotar "><i class='fa fa-briefcase'></i><span> Dotar Puesto </span></a></li>
                            <li><a href="./residentes"><i class='fa fa-building'></i> <span>Residentes</span></a></li>
                            <li class="header">Logistica</li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-area-chart'></i> <span>Inventario</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./inventary"><i class="fa fa-circle"></i><span> Resumen </span></a></li>
                                <li><a href="./dotacion"><i class="fa fa-circle"></i><span> Asignados </span></a></li>
                                <li><a href="./index.php?view=re"><i class="fa fa-circle"></i><span> Abastecer </span></a></li>
                                <li><a href="./index.php?view=res"><i class="fa fa-circle"></i><span> Abastecimientos </span></a></li>
                              </ul>
                            </li>
                            <!--- Administracion del Sistema --->
                            <li class="header">Administraci&oacute;n</li>
                            <li><a href="./index.php?view=siscof.lista"><i class='fa fa-spinner'></i><span>Configuraci&oacute;n</span></a></li>
                            <li class="header">Sistemas</li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-database'></i> <span>Catalogos</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./index.php?view=catloc.lista"><i class="fa fa-circle"></i><span> Localidades </span></a></li>
                                <li><a href="./index.php?view=catofi.lista"><i class="fa fa-circle"></i><span> Oficinas </span></a></li>
                                <li><a href="./departamento"><i class="fa fa-circle"></i><span> Departamentos </span></a></li>
                                <li><a href="./index.php?view=catcar.lista"><i class="fa fa-circle"></i><span> Cargos </span></a></li>
                                <li><a href="./index.php?view=catrub.lista"><i class="fa fa-circle"></i><span> Rubros </span></a></li>
                                <li><a href="./index.php?view=catdes.lista"><i class="fa fa-circle"></i><span> Descuentos </span></a></li>
                                <li><a href="./categorias"><i class="fa fa-circle"></i><span> Categorias </span></a></li>
                                <li><a href="./productos"><i class="fa fa-circle"></i><span> Productos </span></a></li>
                                <li><a href="./proveedores"><i class="fa fa-circle"></i><span> Proveedores </span></a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class='fa fa-print'></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <?php
                                  if($_SESSION["actividad"] == 1){
                                    echo '<li><a href="./index.php?view=repent.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Agentes</span></a></li>';
                                    echo '<li><a href="./index.php?view=reppus.lista"><i class="fa fa-circle"></i><span>Dotaci&oacute;n de Puestos</span></a></li>';
                                  }
                                ?>
                                <li><a href="reports"><i class="fa fa-circle"></i><span> Inventario </span></a></li>
                                <li><a href="sellreports"><i class="fa fa-circle"></i><span> Entregas </span></a></li>
                              </ul>
                            </li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-cog"></i> <span>Administraci&oacute;n</span> <i class="fa fa-angle-left pull-right"></i></a>
                              <ul class="treeview-menu">
                                <li><a href="./usuarios"><i class="fa fa-circle"></i><span> Usuarios </span></a></li>
                                <li><a href="./settings"><i class="fa fa-circle"></i><span> Configuracion </span></a></li>
                                <li><a href="./index.php?view=sisaud.lista"><i class="fa fa-circle"></i> Auditoria </a></li>
                              </ul>
                            </li>  <?php 
                        endif; 
                        if($_SESSION['idrol'] == 7 || $_SESSION['idrol'] == 8 || $_SESSION['idrol'] == 11){
                            // Vigilante Residencial
                        }elseif($_SESSION['idrol'] == 9){
                          echo '<li><a href="./residentpass"><i class="fa fa-cube"></i> <span>Cambio de clave</span></a></li>';
                        }else{
                          echo '<li><a href="./password"><i class="fa fa-cube"></i> <span>Cambio de clave</span></a></li>';
                        } ?>                        
                        <li><a href="./ayudas"><i class='fa fa-info-circle'></i> <span>Acerca de </span></a></li>
                  <?php endif; ?>
                </ul><!-- /.sidebar-menu -->
              </section>
              <!-- /.sidebar -->
            </div>
          </aside>
          <?php endif;?>
          <!-- Content Wrapper. Contains page content -->
          <?php if(isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])):?>
            <div class="content-wrapper" style="min-height: 704px;">
				<div class="row">
					<div class="col-md-12">
					  <?php View::load("home"); ?>
					</div> <!-- /.col -->
                </div> <!-- /.col -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
              <div class="pull-right hidden-xs">
                <b>Versi&oacute;n</b> 3.0
              </div>
              <strong>Copyright &copy; 2016-2025 <a href="https://near-solution.com/" target="_blank">Near Solution</a></strong>
            </footer>
        </div><!-- ./wrapper -->
    <?php else: ?>
      <!-- Pantalla de Logeo -->
      <header class="navbar navbar-header navbar-header-fixed">
        <div class="navbar-brand">
          <div class="df-logo">Bitacora&nbsp;&nbsp;<span>El&eacute;ctronico</span></div>
        </div><!-- navbar-brand -->        
        <div class="navbar-right" style="display: none">
          <button id="alertButton" class="btn btn-block btn-danger" style="font-size: 14px; font-weight: bold;"><i class="fa fa-heartbeat"></i>&nbsp;&nbsp;Boton S.O.S.</button>
        </div>
      </header><!-- navbar -->
      <div class="content content-fixed content-auth" style="background-image: url('assets/images/bg-close-scaled.webp'); background-repeat:no-repeat; background-size:cover; background-position:center center;">
        <div class="containerDg">
          <div class="media align-items-stretch justify-content-center ht-100p pos-relative" style="color=white;">
            <div class="media-body align-items-center d-none d-lg-flex">
              <div class="mx-wd-600">
                <img src="" class="img-fluid" alt="">
              </div>
            </div><!-- media-body -->
            <div class="card">
                <div class="card-body">
                    <div class="wd-600p">
                        <div align="center" style="text-align: center;">
                            <img src="assets/images/logo-ameri.png" class="img-fluid" alt="AMERICAN" height="380px" width="260%">
                        </div>
                        <form id="frm" name="frm" action="./index.php?action=processlogin" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input type="text" name="username" id="username" tabindex=1 maxlength="20" class="form-control" placeholder="Ingrese el nombre de usuario" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mg-b-5">
                                  <label for="password" class="mg-b-0-f">Password</label>
                                </div>
                                <input type="password" name="password" id="password" tabindex=2 maxlength="20" class="form-control" placeholder="Ingrese su contraseña" >
                              </div>
                              <input class="btn btn-brand-02 btn-block" name="btn_enviar" type="submit" id="btn_enviar" value="Iniciar sesi&oacute;n"/>
                              </br>
                              <div class="alert alert-danger" style="<?php if(isset($_SESSION["error"]) && $_SESSION["error"] > 0) echo ''; else echo 'display:none;'; ?>">
                                <strong>hoops!</strong> Hay un problema con sus datos.<br><br>
                                <ul>
                                  <?php
                                    if($_SESSION["error"] == 1) echo '<li> El usuario no existe</li><li> Su clave esta errada</li>';
                                    if($_SESSION["error"] == 2) echo '<li> El guardia no tiene puesto asignado</li>';							
                                    if($_SESSION["error"] == 3) echo '<li> El usuario no existe</li><li> Su clave esta errada</li>';
                                  ?>
                                </ul>
                            </div>
                        </form>
                      </div>  
                    </div>
                </div>
            </div><!-- media -->
        </div><!-- container -->
      </div><!-- content -->
      <footer class="footer">
        <div>
          <span>&copy; 2025 Bitacora <span>El&eacute;ctronica</span> v3.0 </span>
          <span>Created by <a href="https://grupolatinamerica.com/">Grupo Latin America</a></span>
        </div>
        <div>
          <nav class="nav">
            <a href="https://nearsolutions.com.ec/licenses/standard" class="nav-link">Licencia</a>
            <a href="https://nearsolutions.com.ec/help" class="nav-link">Ayuda</a>
          </nav>
        </div>
      </footer>
      <script type="text/javascript">
        document.frm.username.focus();
      </script> <?php 
    endif;  ?>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="./assets/js/app.min.js?v=1.0.1"></script>
    <script type="text/javascript" src="./assets/js/bootstrap-select.min.js?v=1.0.1"></script>
    <!-- JS PDF -->
    <script type="text/javascript" src="./plugins/jspdf/jspdf.min.js?v=1.0.1"></script>
    <script type="text/javascript" src="./plugins/jspdf/jspdf.plugin.autotable.js?v=1.0.1"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script type="text/javascript" src="./plugins/bootstrap/js/bootstrap.min.js?v=1.0.1"></script>    
    <!-- SlimScroll -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js?v=1.0.1"></script>
    <!-- bootstrap datepicker -->
    <script type="text/javascript" src="./plugins/datetimepicker/js/bootstrap-datetimepicker.js?v=1.0.1" charset="UTF-8"></script>
    <script type="text/javascript" src="./plugins/datetimepicker/js/locales/bootstrap-datetimepicker.es.js?v=1.0.1" charset="UTF-8"></script>
    <script type="text/javascript" src="./plugins/datepicker/bootstrap-datepicker.js?v=1.0.1" charset="UTF-8"></script>
    <script type="text/javascript" src="./plugins/datepicker/locales/bootstrap-datepicker.es.js?v=1.0.1" charset="UTF-8"></script>
    <script type="text/javascript" src="./plugins/icheck/icheck.js?v=1.0.1"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="./plugins/select2/js/select2.full.min.js?v=1.0.1"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="./plugins/sweetalert/sweetalert.min.js?v=1.0.1"></script>	<?php 
    // Seleccion de los temas del Sistema
		if(isset($_GET["view"]) && $_GET["view"] == "calendar"){
			// Full Calendar
			echo '<script type="text/javascript" src="./plugins/fullcalendar/moment.min.js?v=1.0.1"></script>';
			echo '<link type="text/css" rel="stylesheet" href="./plugins/fullcalendar/fullcalendar.min.css?v=1.0.1">';
    	echo '<link type="text/css" rel="stylesheet" href="./plugins/fullcalendar/fullcalendar.print.css?v=1.0.1" media="print">';
			echo '<script type="text/javascript" src="./plugins/fullcalendar/fullcalendar.min.js?v=1.0.1"></script>';
			echo '<script type="text/javascript" src="./plugins/fullcalendar/locale-all.js?v=1.0.1"></script>';
    }
    
    if(isset($_GET["view"])){
			if($_GET["view"] == "calendar"){
				// Full Calendar
				echo '<script type="text/javascript" src="plugins/fullcalendar/moment.min.js?v=1.0.1"></script>';
				echo '<link type="text/css" rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css?v=1.0.1">';
				echo '<link type="text/css" rel="stylesheet" href="plugins/fullcalendar/fullcalendar.print.css?v=1.0.1" media="print">';
				echo '<script type="text/javascript" src="plugins/fullcalendar/fullcalendar.min.js?v=1.0.1"></script>';
				echo '<script type="text/javascript" src="plugins/fullcalendar/locale-all.js?v=1.0.1"></script>';
			}
			if($_GET["view"]=="newprovider" || $_GET["view"]=="editprovider" || $_GET["view"]=="residente" || $_GET["view"]=="autorizar" || $_GET["view"]=="novedad" || 
			   $_GET["view"]=="cliente" || $_GET["view"]=="corizar" || $_GET["view"]=="recibo" || $_GET["view"]=="venta"){
				echo '<script type="text/javascript" src="plugins/input-mask/jquery.inputmask.js?v=1.0.1"></script>';
				echo '<script type="text/javascript" src="plugins/input-mask/jquery.inputmask.date.extensions.js?v=1.0.1"></script>';
				echo '<script type="text/javascript" src="plugins/input-mask/jquery.inputmask.extensions.js?v=1.0.1"></script>';
			}
			if($_GET["view"]=="sell"){
				echo '<script type="text/javascript" src="plugins/jsqrcode/llqrcode.js?v=1.0.1"></script>';
				echo '<script type="text/javascript" src="plugins/jsqrcode/webqr.js?v=1.0.1"></script>';
			}
			if($_GET["view"]=="asignar" || $_GET["view"]=="novedad" || $_GET["view"]=="informe" || $_GET["view"]=="supervisar" || $_GET["view"]=="aspirantes" || 
         $_GET["view"]=="reporte"){
          echo '<script type="text/javascript">
                  initiate_geolocation();

                  var watchId;
                  // Controlamos los tiempos de espera mínimo y máximo de nuestra geolocalización respecto a la petición anterior
                  var PositionOptions = {
                      enableHighAccurace: true, // busca el mejor dispositivo de geolocalización (GPS, tiangulación, ...)
                      timeout: 5000,
                      maximumAge: 60000
                  };
                  // initiate_geolocation() utiliza la geolocalalización solamente cuando se solicita.
                  // Con PositionOptions aseguramos que la posición no corresponde a caché
                  function initiate_geolocation() {
                    if (navigator.geolocation) {
                      var watchId = navigator.geolocation.getCurrentPosition(successCallback, errorCallback, PositionOptions);
                    } else {
                      document.getElementById("mensaje").innerHTML = "Lo sentimos pero el API de Geolocalización de HTM5 no está disponible para su navegador";
                    }
                  }

                  // watch_geolocation() reitera la geolocalización hasta que la detenemos con clear_watch_geolocation()
                  function watch_geolocation() {
                    if (navigator.geolocation) {
                      var watchId = navigator.geolocation.watchPosition(successCallback, errorCallback, PositionOptions);
                    } else {
                      document.getElementById("mensaje").innerHTML = "Lo sentimos pero el API de Geolocalización de HTM5 no está disponible para su navegador";
                    }
                  }

                  // clear_watch_geolocation() dettiene la geolocalización reiterada
                  function clear_watch_geolocation() {
                    if (navigator.geolocation) {
                      navigator.geolocation.clearWatch(watchId);
                    } else {
                      document.getElementById("mensaje").innerHTML = "Lo sentimos pero el API de Geolocalización de HTM5 no está disponible para su navegador";
                    }
                  }

                  function successCallback(pos) {
                    var timestamp = document.getElementById(\'timestamp\');
                    var date = new Date(pos.timestamp);
                    // Hacemos legible la fecha a nuestro léxico ya que timestamp nos daría una lectura como ésta: Nov 18 2015 19:56:11 GMT+0100
                    var mes = date.getMonth() + 1;
                    if (mes < 10) {
                      mes = "0" + mes
                    }

                    var dia = date.getDate();
                    if (dia < 10) {
                      dia = "0" + dia
                    }
                    var anyo = date.getFullYear();
                    var hora = date.getHours();

                    if (hora < 10) {
                      hora = "0" + hora
                    }

                    var minuto = date.getMinutes();
                    if (minuto < 10) {
                      minuto = "0" + minuto
                    }

                    var segundo = date.getSeconds();
                    if (segundo < 10) {
                      segundo = "0" + segundo
                    }

                    var timestamp = document.getElementById(\'timestamp\');
                    timestamp.value = dia + "/" + mes + "/" + anyo + ", " + hora + ":" + minuto + ":" + segundo;

                    var latitude = document.getElementById(\'latitude\');
                    // con toFixed(6) limito decimales a 6
                    latitude.value = pos.coords.latitude.toFixed(6);

                    var longitude = document.getElementById(\'longitude\');
                    longitude.value = pos.coords.longitude.toFixed(6);

                    // accuracy considera el diámetro máximo de error. Muchos lo dividen por 2 ya que sería el radio máximo de error.
                    var accuracy = document.getElementById(\'rangoerror\');
                    rangoerror.value = pos.coords.accuracy;

                    // Sentido y velocidad si la medición se hace desde un dispositivo en movimiento
                    // 0 => Norte en sentido agujas del reloj hasta 360º
                    var heading = document.getElementById(\'sentido\');
                    sentido.value = pos.coords.heading;

                    // metros/segundo si se detecta movimiento
                    var speed = document.getElementById(\'velocidad\');
                    velocidad.value = pos.coords.speed;
                  };

                  /* Posibles errores que se pueden producir en la geolocalización */
                  function errorCallback(error) {
                    var appErrMessage = null;

                    if (error.core == error.PERMISSION_DENIED) {
                      appErrMessage = "El usuario no ha concedido los privilegios de geolocalización"
                    } else if (error.core == error.POSITION_UNAVAILABLE) {
                      appErrMessage = "Posición no disponible"
                    } else if (error.core == error.TIMEOUT) {
                      appErrMessage = "Demasiado tiempo intentando obtener la localización del usuario."
                    } else if (error.core == error.UNKNOWN) {
                      appErrMessage = "Error desconocido"
                    } else {
                      appErrMessage = "Error insesperado"
                    }

                    document.getElementById("mensaje").value = appErrMessage
                  };
              </script>';
            }
        }
    
    if (isset($_SESSION['sweetalert_message'])) {;
        echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js?v=1.0.1"></script>';
        $alert = $_SESSION['sweetalert_message'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                  swal('".$alert['title']."', '".$alert['text']."', '".$alert['icon']."');
                });
              </script>";
        unset($_SESSION['sweetalert_message']); // Limpia la sesión después de usarla
    } ?>
    <script type="text/javascript">      
        document.getElementById('alertButton').addEventListener('click', async () => {
          try {
              const location = await getCurrentLocation();
              const formattedLocation = `${location.coords.latitude}, ${location.coords.longitude}`;

              // Aquí puedes enviar las coordenadas al servidor PHP para su procesamiento.                
				      window.location.href = "index.php?view=alertas&lat="+location.coords.latitude+"&lot="+location.coords.longitude;
              console.error(`Emergencia: Coordenadas GPS ${formattedLocation}`);
          } catch (error) {
              console.error('Error al obtener la ubicación:', error.message);
          }
        });
        
        async function getCurrentLocation() {
            return new Promise((resolve, reject) => {
                if ('geolocation' in navigator) {
                    navigator.geolocation.getCurrentPosition(resolve, reject);
                }else {
                    reject(new Error('Geolocalización no está disponible en este navegador.'));
                 }
            });
        } 

        $(function () {
          <?php
          if(isset($_GET["view"])){
            if($_GET["view"]=="newprovider" || $_GET["view"]=="editprovider" || $_GET["view"]=="residente" || $_GET["view"]=="autorizar" || $_GET["view"]=="novedad" || 
               $_GET["view"]=="cliente"){
              echo "$(':input').inputmask();";
              //echo "$(money).inputmask('9.999,99', { numericInput: true, reverse: true, radixPoint: "," });";
              //echo "$(cuota).inputmask('99', { numericInput: true, reverse: true, radixPoint: "," });";
            }
          } ?>

          //Initialize Select2 Elements
          $(".select2").select2();

   		    var today = new Date();
          var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          var time = today.getHours() + ":" + today.getMinutes();
          var dateTime = date+' '+time;
          $("#fecha").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true,
            startDate: dateTime
          });

          //Date picker
          $('#date_salida').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "es",
            daysOfWeekDisabled: "0,6",
            calendarWeeks: true,
            autoclose: true
          });

          //Date picker
          $('#date_entrada').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "es",
            daysOfWeekDisabled: "0,6",
            calendarWeeks: true,
            autoclose: true
          });

          //Date picker
          $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            language: "es",
            calendarWeeks: true,
            autoclose: true
          });

          $(document).ready(function() {
              var toggled = false;

              $('.dropdown-toggle').on('click', function() {
                  if (toggled === false) {
                      $('.nav .open ul').hide();
                      $('.nav .dropdown ul').show();
                      toggled = true;
                  } else {
                      $('.nav .dropdown ul').hide();
                      $('.nav .open ul').show();
                      toggled = false;
                  }
              });
          });
      });
    </script>
    <?php
      if(isset($_GET["view"]) && ($_GET["view"]=="home" || $_GET["view"]=="inventary" || $_GET["view"]=="cuentas" || $_GET["view"]=="bitacora" || 
	        $_GET["view"]=="autorizan" || $_GET["view"]=="autorizo" || $_GET["view"]=="verificados" || $_GET["view"]=="cotizacion" || $_GET["view"]=="cotizar" ||
          $_GET["view"]=="fechas" || $_GET["view"]=="partes" || $_GET["view"]=="prendas" || $_GET["view"]=="descuento" || $_GET["view"]=="visitas" || 
		      $_GET["view"]=="departamento" || $_GET["view"]=="categorias" || $_GET["view"]=="productos" || $_GET["view"]=="informes" || $_GET["view"]=="anuncios" ||
		      $_GET["view"]=="agentes" || $_GET["view"]=="conducta" || $_GET["view"]=="catdes.lista" || $_GET["view"]=="rrphor.activos" || $_GET["view"]=="puestos" || 
          $_GET["view"]=="faltas" || $_GET["view"]=="rondas" || $_GET["view"]=="vehiculos" || $_GET["view"]=="novedades" || $_GET["view"]=="clientes" ||
          $_GET["view"]=="telefonos" || $_GET["view"]=="apertura" || $_GET["view"]=="recibos" || $_GET["view"]=="entregas" || $_GET["view"]=="conducta" ||
		      $_GET["view"]=="residentes" || $_GET["view"]=="proveedores" || $_GET["view"]=="rrhpre.lista" || $_GET["view"]=="opecor.lista" ||
          $_GET["view"]=="catrol.lista" || $_GET["view"]=="cobnom.lista" || $_GET["view"]=="sisnot.lista" || $_GET["view"]=="carnets" || 
          $_GET["view"]=="rrhpre.lista" || $_GET["view"]=="rrhliq.lista" || $_GET["view"]=="rrhmac.lista" || $_GET["view"]=="usuarios" || 
          $_GET["view"]=="rrsdoc.lista" || $_GET["view"]=="opeasp.lista" || $_GET["view"]=="opeasi.lista" || $_GET["view"]=="rrhdoc.lista" ||
          $_GET["view"]=="sisaud.lista" || $_GET["view"]=="rrging.lista" || $_GET["view"]=="rrping.lista" || $_GET["view"]=="rrhvac.lista" ||
          $_GET["view"]=="catdes.lista" || $_GET["view"]=="catlim.lista" || $_GET["view"]=="repent.lista" || $_GET["view"]=="catrub.lista" ||            
          $_GET["view"]=="catloc.lista" || $_GET["view"]=="catcar.lista" || $_GET["view"]=="reppus.lista" || $_GET["view"]=="catofi.lista")): ?>
          <!-- DataTables $_GET["view"]=="rrsing.lista" || -->
          <script src="plugins/datatables/jquery.dataTables.min.js?v=1.0.1"></script>
          <script src="plugins/datatables/dataTables.bootstrap.min.js?v=1.0.1"></script>
          <script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js?v=1.0.1"></script>
          <!-- Productos
          <script src="plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
          <script type="text/javascript" src="js/productos.js"></script> -->
          <script type="text/javascript">
            $(document).ready(function(){
              $('#viewactivo').DataTable({ // Elementos activos
                "order": [[0, 'desc']],
                "iDisplayLength":10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Actualmente no hay ningun registro asignado en esta consulta",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
				              "searchPlaceholder": "Dato para buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  }
              });

              $('#viewEliminado').DataTable({
                "iDisplayLength":10,
                "lengthMenu": [[10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Actualmente no hay ningun registro asignado en esta consulta",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
				              "searchPlaceholder": "Dato para buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  }
              });

              $('#viewBitacora').DataTable({
                "order": [[0, 'desc']],
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "stateSave": true,
                "autoWidth": false,
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Lo sentimos, no hay ninguna coincidencia...!!!",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  },
                  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                  "aria": {
                      "SortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "SortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "pagingType": "full_numbers"
              });

              $('#viewnomina').DataTable({
                "order": [[0, 'desc']],
                "iDisplayLength":10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Actualmente no hay ningun registro asignado en esta consulta",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
				              "searchPlaceholder": "Dato para buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  }
              });

              $('#viewdates').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "stateSave": true,
                "autoWidth": false,
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Actualmente no hay ningun registro asignado en esta consulta",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
				              "searchPlaceholder": "Dato para buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  },
                  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                  "aria": {
                      "SortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "SortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "pagingType": "full_numbers"
              });

              $('#viewlista').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "stateSave": true,
                "autoWidth": false,
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Lo sentimos, no hay ninguna coincidencia...!!!",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  },
                  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                  "aria": {
                      "SortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "SortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "pagingType": "full_numbers"
              });

              $('#viewInac').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "stateSave": true,
                "autoWidth": false,
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Lo sentimos, no hay ninguna coincidencia...!!!",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  },
                  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                  "aria": {
                      "SortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "SortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "pagingType": "full_numbers"
              });

              $('#viewDotar').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "stateSave": true,
                "autoWidth": false,
                "language": {
                      "lengthMenu": "Ver _MENU_ registros",
                      "zeroRecords": "Lo sentimos, no hay ninguna coincidencia...!!!",
                      "info": "_PAGE_ de _PAGES_",
                      "infoEmpty": "No hay ningun registro disponible...!!!",
                      "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                      "search": "Buscar",
                      "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Ultimo"
                      }
                  },
                  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                  "aria": {
                      "SortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "SortDescending": ": Activar para ordenar la columna de manera descendente"
                  },
                  "pagingType": "full_numbers"
              });
            });
          </script> <?php 
      endif;?>
  </body>
</html>

