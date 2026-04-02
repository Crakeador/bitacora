<?php
//Vista del Panel de control
$ano=date("Y"); $mes=date("m"); 
$_SESSION["error"]=0; $_SESSION['ganada']=0; $_SESSION['perdida']=0; $_SESSION['ventas']=0;

$users = TimelineData::getTipe(2);
foreach($users as $tables) {	
	$fecha = explode(" ",$tables->date_event);
	$tables->date_event = $fecha[0];

	$ini = explode(" ", $tables->date_event);
	$fin = date("Y-m-d");
	
	$fecha1 = new DateTime($ini[0]);
	$fecha2 = new DateTime($fin);
	
	$intervalo = $fecha1->diff($fecha2);
	$dias = $intervalo->format('%R%a');
	
	if($dias > 0) $vencida = TimelineData::changeStatus($tables->id, 4);
} 

if($_SESSION['idrol']=='1' || $_SESSION['idrol']=='2'){
	//No hay datos
	$total1 = TimelineData::getByTotal(4); 
	$total2 = TimelineData::getByTotal(3); 
	$total3 = TimelineData::getByTotal(2); 
	$total4 = TimelineData::getByTotal(1);

	$_SESSION['vencida'] = $total1->total;	
	$_SESSION['terminada'] = $total2->total;
	$_SESSION['encurso'] = $total3->total;
	$_SESSION['activa'] = $total4->total;
}else{
	if($_SESSION['idrol']=='3' || $_SESSION['depart']=='4'){
		$events = TimelineData::getTime($_SESSION['user_id'], $ano); // Listado de agentes comerciales
		$totalLlam = ComercialData::getTotal('Llamada');
		$totalMail = ComercialData::getTotal('Mailing');
		$totalVisi = ComercialData::getTotal('Visita');
		$totalGana = ComercialData::getTotal('Ganada');
		$totalPerd = ComercialData::getTotal('Perdida'); 
	} else{
		print "<script>window.location='./vistas';</script>";
	}
}

if($_SESSION["ingreso"] == 3)
    if($_SESSION['dispositivo'] == 1)
		print "<script>window.location='./videoip';</script>";
    else
		print "<script>window.location='./novedad';</script>";

if (isset($_COOKIE['usuario'])) {
    $usuario = $_COOKIE['usuario'];
    echo '<script>alert("Bienvenido, $usuario");</script>';
} else {
    //echo '<script>alert("No se encontró la cookie \'usuario\'");</script>';
}

if($_SESSION['idrol'] ==  4){
    if($_SESSION['dispositivo'] == 1){
        //En la PC
    }else{
        Core::redir('visito');
    }
}

if($_SESSION['idrol'] ==  6){
    if($_SESSION['dispositivo'] == 1){
        //En la PC
    }else{
        Core::redir('supervisar');
    }
}

if($_SESSION['idrol'] ==  7 || $_SESSION['idrol'] == 14){	
    if($_SESSION['dispositivo'] == 1){
        $cadena = 'videoip'; 
    }else{
		$cadena = 'novedad'; 
	}/*
    if($_SESSION['residencial'] == 0) 
        $cadena = 'registro';
    else
        $cadena = 'novedad';
    */
	echo '<script>
				if(localStorage.getItem("usuario") != null){
					var usuario = localStorage.getItem("usuario");
					var puesto = localStorage.getItem("puesto");
					var ingreso = localStorage.getItem("ingreso");
					var turno = localStorage.getItem("turno");
					
					console.log(usuario + \' Puesto: \' + puesto + \' Ingreso: \' + ingreso + \' Turno: \' + turno);
					window.location="index.php?view='.$cadena.'&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso;
				}else{
					window.location="index.php?view='.$cadena.'";
				}
			</script>'; //+"&turno="+turno
    //Core::redir('novedad');
}

if($_SESSION['idrol'] ==  8) Core::redir('fechas');
if($_SESSION['idrol'] ==  9) Core::redir('autorizan');
if($_SESSION['idrol'] == 13) Core::redir('ruta');
if($_SESSION['idrol'] == 15) Core::redir('supervisar');
if($_SESSION['idrol'] == 18) Core::redir('trade');
if($_SESSION['idrol'] == 22) Core::redir('horario');


if($_SESSION['idrol'] == 10) 
	if($_SESSION['depart'] == 3)	
		print "<script>window.location='./personas';</script>";
	else
		print "<script>window.location='index.php?view=rrging.persons';</script>";
 
if($_SESSION['idrol'] == 11) {
	if($_SESSION['aspirante']>0) {
		print "<script>window.location='index.php?view=aspirante&id=".$_SESSION['aspirante']."';</script>"; 
	}else{
		Core::redir('aspirante');
	}
}
if($_SESSION["idrol"] == 12)
    $filtro = "AND A.ano = '".date("Y")."' AND A.mes = '".date("m")."' AND A.dia = '".date("d")."'";
else
    $filtro = "";

if($_SESSION['depart'] == 7) $_SESSION['ventas']=1;

if(isset($_GET['error'])){
    if($_GET['error'] ==  1) Core::alert("Error...!!!!", "No se pudo generar correctamente su alerta...!!!", "error");
    if($_GET['error'] == 10) Core::alert("Error...!!!!", "No tiene permisos suficientes para esta accion...!!!", "error");
    if($_GET['error'] == 11) Core::alert("Error...!!!!", "No esta asignado un personal a este perfil. Debe de correguir este error primero...!!!", "error");
} 

if(isset($_GET['guardar'])){
	Core::alert("Exito...!!!!", "Se guardo su registro", "success"); 
}

if(isset($_GET['id'])) $_SESSION['id_company'] = $_GET['id'];

$_SESSION['ano'] = date("Y");
$ano=date("Y"); $mes=date("m");

$ini=$ano."-".$mes."-01";
$total=date("t", strtotime($ini));
$fin=$ano."-".$mes."-".$total;
$fechas = PersonData::getByDate($mes);

$fechaIni = new DateTime($_SESSION["cambio"]);
// Fecha de finalización (puede ser la fecha actual)
$fechaFin = new DateTime(date('Y-m-d'));
// Calcular la diferencia entre las fechas
$diferencia = $fechaIni->diff($fechaFin);

/* Acceder a los componentes de tiempo deseados 
echo "Diferencia de días: " . $diferencia->days . " días<br>";
echo "Diferencia de meses: " . $diferencia->m . " meses<br>";
echo "Diferencia de años: " . $diferencia->y . " años<br>";
echo "Diferencia total en días: " . $diferencia->format('%R%a') . " días<br>";
echo '</br>Rol:'.$_SESSION["idrol"]; */
echo '<section class="content-header">';
	echo '<h1>';
		echo 'Panel de Control';
		echo '<small>Estadisticas Diarias</small>';
	echo '</h1>';
	echo '<ol class="breadcrumb">';
		echo '<li class="active"><i class="fa fa-dashboard"></i> Panel de Control </li>';
	echo '</ol>';
echo '</section>';
echo '<section class="content" style="padding: 1.5rem !important;">';
	echo '<div class="row">';
		if($_SESSION["idrol"] == "1"){
		    //Administradores			
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-aqua">';
					echo '<div class="inner">';
						echo '<h3>'.count(ClientData::getAll(0, 1)).'</h3>';
						echo '<p>Total de Clientes</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="fa fa-shopping-cart"></i>';
					echo '</div>';
					echo '<a href="clientes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
				echo '</div>';
			echo '</div>';
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-purple">';
					echo '<div class="inner">';
						echo '<h3>'.count(PersonData::getAllTipo(3, 1)).'</h3>';
						echo '<p>Total de agentes</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="fa fa-user"></i>';
					echo '</div>';
					echo '<a href="index.php?view=rrging.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
				echo '</div>';
			echo '</div>';
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-yellow">';
    				echo '<div class="inner">';
    						echo '<h3>'.count(PuestoData::getAll(2)).'</h3>';
    						echo '<p>Puestos</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="fa fa-bank"></i>';
					echo '</div>';
					echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
				echo '</div>';
			echo '</div>';
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-red">';
				echo '<div class="inner">';
					echo '<h3> $ '.number_format(12000, 2, ',', '.').'</h3>';
					echo '<p>Total de Nomina</p>';
				echo '</div>';
				echo '<div class="icon">';
					echo '<i class="fa fa-book"></i>';
				echo '</div>';
				echo '<a href="index.php?view=caja" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
				echo '</div>';
			echo '</div>';
		}else{
		    // Supervisor de Operaciones
			if($_SESSION["idrol"] == "6"){
				echo '<div class="col-lg-3 col-xs-6">';
					echo '<div class="small-box bg-purple">';
						echo '<div class="inner">';
							echo '<h3>Planifica</h3>';
							echo '<p>Planificar los Horarios</p>';
						echo '</div>';
						echo '<div class="icon">';
							echo '<i class="fa fa-car"></i>';
						echo '</div>';
						echo '<a href="index.php?view=opehor.planificado" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3 col-xs-6">';
					echo '<div class="small-box bg-aqua">';
						echo '<div class="inner">';
							echo '<h3>Activos</h3>';
							echo '<p>Horario de asistencia</p>';
						echo '</div>';
						echo '<div class="icon">';
							echo '<i class="fa fa-user"></i>';
						echo '</div>';
						echo '<a href="asistencia" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3 col-xs-6">';
					echo '<div class="small-box bg-yellow">';
						echo '<div class="inner">';
							echo '<h3>Ingresos</h3>';
							echo '<p>Ingreso de los agentes</p>';
						echo '</div>';
						echo '<div class="icon">';
							echo '<i class="fa fa-users"></i>';
						echo '</div>';
						echo '<a href="index.php?view=rrsing.persons" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3 col-xs-6">';
					echo '<div class="small-box bg-red">';
						echo '<div class="inner">';
							echo '<h3>'.count(PuestoData::getByFaltas($filtro)).'</h3>';
							echo '<p>Total de Faltas</p>';
						echo '</div>';
						echo '<div class="icon">';
							echo '<i class="fa fa-user-md"></i>';
						echo '</div>';
						echo '<a href="index.php?view=faltas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
			}else{
				switch ($_SESSION['depart']) {
					case 3: // Operaciones
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getAllTipo(3, 1)).'</h3>'; 
									echo '<p>Agentes Activos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="asistencia" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getAllTipo(4, 1)).'</h3>';
									echo '<p>Total de aaa Aspirantes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-fax"></i>';
								echo '</div>';
								echo '<a href="aspirantes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>'; 
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(PuestoData::getByFaltas($filtro)).'</h3>';
									echo '<p>Total de Faltas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-dolly"></i>';
								echo '</div>';
								echo '<a href="index.php?view=faltas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>'.count(PuestoData::getAll(2)).'</h3>';
									echo '<p>Puestos Activos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-home"></i>';
								echo '</div>';
								echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					case 4: // Area 
						$total = ComercialData::getTotalCotizacion();
						$totol = ComercialData::getValores('Ganada');
						$totel = ComercialData::getValores('Perdida');
						$valor = (float) $total->total;

						$_SESSION['ventas'] = $valor;
						$_SESSION['ganada'] = (float) $totol->total;
						$_SESSION['perdida'] = (float) $totel->total;
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(ComercialData::getCotizacion()).'</h3>';
									echo '<p>Cotizaciones realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-print"></i>';
								echo '</div>';
								echo '<a href="ventas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>$ '.number_format($valor, 2, ',', '.').'</h3>';
									echo '<p>Presupuesto Cotizado</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-money"></i>';
								echo '</div>';
								echo '<a href="ventas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.$totalVisi->total.'</h3>';
									echo '<p>Visitas realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="ventas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>52%</h3>';
									echo '<p>Porcentaje de Ventas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user-friends"></i>';
								echo '</div>';
									echo '<a href="ventas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					case 6: // Inicio RRHH
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getAllTipo(3, 0)).'</h3>';
									echo '<p>Agentes Inactivos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-briefcase"></i>';
								echo '</div>';
								echo '<a href="index.php?view=rrhliq.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getAllTipo(3, 1)).'</h3>';
									echo '<p>Total de Agentes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="index.php?view=rrging.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
								echo '<h3>'.count(PersonData::getAllTipo(4, 1)).'</h3>';
								echo '<p>Total de bbb Aspirantes</p>';
							echo '</div>';
							echo '<div class="icon">';
								echo '<i class="fa fa-user-plus"></i>';
							echo '</div>';
								echo '<a href="aspirantes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
								echo '<h3>'.count(CargoData::getAll()).'</h3>';
								echo '<p>Total de Cargos</p>';
							echo '</div>';
							echo '<div class="icon">';
								echo '<i class="fa fa-address-card"></i>';
								echo '</div>';
								echo '<a href="cargos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					case 7: // Logistica
						echo '<div class="col-lg-3 col-xs-6">'; 
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(CategoryData::getAll()).'</h3>';
									echo '<p>Proveedores</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-book"></i>';
								echo '</div>';
								echo '<a href="proveedores" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(ProductData::getAll()).'</h3>';
									echo '<p>Productos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="index.php?view=productos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getClients()).'</h3>';
									echo '<p>Agentes dotados</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="index.php?view=agentes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>'.count(PuestoData::getAll(2)).'</h3>';
									echo '<p>Dotacion $</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-calendar"></i>';
								echo '</div>';
								echo '<a href="index.php?view=equipar" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
					    break;
					case 8: // Financiero
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(ProductData::getAll()).'</h3>';
									echo '<p>Visitas realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getClients()).'</h3>';
									echo '<p>Clientes registrados</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-person-add"></i>';
								echo '</div>';
								echo '<a href="index.php?view=clientes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>52%</h3>';
									echo '<p>Porcentaje de Ventas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user-friends"></i>';
								echo '</div>';
									echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(DepartamentoData::getAll()).'</h3>';
									echo '<p>Cotizaciones realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-dolly"></i>';
								echo '</div>';
								echo '<a href="index.php?view=departamento" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					case 9: // Uso de las residencias
						$hoy = date("Y-m-d"); $cadena = "";

						if($_SESSION['dispositivo'] == 1) $cadena = " AND A.fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
						if($_SESSION['dispositivo'] == 2) $cadena = " AND A.fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
                        if(isset($_SESSION['id_client'])) $cliente = $_SESSION['id_client']; else $cliente = 1;
						// Listado de las bitacoras
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PuestoData::getMiPuesto($cliente, 1)).'</h3>'; 
									echo '<p>Agentes Activos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="index.php?view=puesto" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByTipo($cliente, $cadena, 'Visita')).'</h3>';
									echo '<p>Ingresos Diarios</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-fax"></i>';
								echo '</div>';
								echo '<a href="index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByTipo($cliente, $cadena, 'Otros')).'</h3>';
									echo '<p>Autorizaciones pendientes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-dolly"></i>';
								echo '</div>';
								echo '<a href="index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
								echo '<div class="small-box bg-yellow">';
									echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByClients($cliente, $cadena)).'</h3>';
									echo '<p>Reporte de Daños</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-home"></i>';
								echo '</div>';
								echo '<a href="index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					default:
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									if($_SESSION['idrol'] == 2)
										$_SESSION['activa'] = count(TimelineData::getTipe(2));
									else
										$_SESSION['activa'] = count(TimelineData::getTipeUser($_SESSION['user_id'], 2026));

									echo '<h3>'.($_SESSION['activa'] > 0 ? $_SESSION['activa'] : 0).'</h3>';
									echo '<p>Tareas Asignadas</p>';
								echo '</div>'; 
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-green">';
								echo '<div class="inner">';
									$total2 = TimelineData::getByTotal(3);
									echo '<h3>'.(is_object($total2) && isset($total2->total) ? $total2->total : 0).'</h3>';
									echo '<p>Tareas Ejecutadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-users"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">'; 
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									$total2 = TimelineData::getByTotal(4);
									echo '<h3>'.(is_object($total2) && isset($total2->total) ? $total2->total : 0).'</h3>';
									echo '<p>Tareas Vencidas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-calendar"></i>';
								echo '</div>';
								echo '<a href="calendario" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									$total1 = TimelineData::getByTotal(2);
									echo '<h3>'.($total2*100)/$_SESSION['activa'].' %</h3>';
									echo '<p>Porcenjate de Cumplimieto </p>';
								echo '</div>'; 
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>'; 
						echo '</div>';
				}
			}
		}
	echo '</div>';
    /* Verificar al ingresar el venciniento de la clave y no dejar que avance hasta que la cambie
    if($diferencia->format('%R%a') > 0){
            if($diferencia->days > 250)
                echo '<div class="callout callout-danger">
                            <h4><i class="icon fa fa-ban"></i> Alerta. Su clave tiene <b>'.$diferencia->days.'</b> dias sin cambiar</h4>
                            <p>
                                es su responsabilidad la seguridad electronica de los procesos realizados en el sistema...!!! 
                                <a class="btn btn-success btn-app pull-right" href="password" style="text-decoration: none;"><i class="fa fa-edit"></i>Cambiar PassWord</a>
                            </p>
                            <br>
                       </div>'; // style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);" btn btn-info pull-right
            else
                if($diferencia->days > 120)
                    echo '<div class="callout callout-warning">
                                <h4>Su clave tiene <b>'.$diferencia->days.'</b> dias sin cambiar</h4>
                                <p>
                                    es su responsabilidad la seguridad electronica de los procesos realizados en el sistema...!!! 
                                    <a class="btn btn-success btn-app pull-right" href="password" style="text-decoration: none;"><i class="fa fa-edit"></i>Cambiar PassWord</a>
                                </p>
                                <br>
                           </div>';
    }
     */
	if($_SESSION["depart"] == 4) { ?>
		<div class="row">
			<div class="col-md-8">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Grafico de Ventas</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8"><?php
								if($_SESSION['ventas'] > 0) { ?>
									<div class="card-body" id="donutContainer">
										<canvas id="pieChart" height="285" width="305" style="width: 244px; height: 228px;"></canvas>
									</div><?php 
								}else{ ?>
									<div class="chart-responsive">
										<img src="assets/images/no-data.jpg" class="img-responsive" style="width:60%;height:200px;margin: auto;" alt="No hay datos para mostrar">
										<h3> No hay datos que mostrar</h3>
									</div><?php 
								} ?>
							</div>	<!-- /.col -->
							<div class="col-md-4">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o text-red"></i> Presupuesto Cotizado </li>
									<li><i class="fa fa-circle-o text-green"></i> Monto Ganado </li>
									<li><i class="fa fa-circle-o text-yellow"></i> Monto Perdido </li>
									<li><i class="fa fa-circle-o text-aqua"></i> En Negociacion </li>
								</ul>
							</div>	<!-- /.col -->
						</div> 	<!-- /.row -->
					</div>	<!-- /.box-body -->
					<div class="box-footer no-padding">
						<ul class="nav nav-pills nav-stacked">
							<li>
								<a href="#">Perdidas 
									<span class="pull-right text-red"><i class="fa fa-angle-down"></i> $ <?php echo $_SESSION['perdida']; ?></span>
								</a>
							</li>
							<li>
								<a href="#">Ganadas
									<span class="pull-right text-green"><i class="fa fa-angle-up"></i> $ <?php echo $_SESSION['ganada']; ?></span>
								</a>
							</li>
							<li>
								<a href="#">Cotizadas
									<span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> $ <?php echo $_SESSION['ventas']; ?></span>
								</a>
							</li>
						</ul>
					</div>	<!-- /.footer -->
				</div>
			</div> 
			<div class="col-md-4">
				<!-- Info Boxes Style 2 -->
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="fa fa-fax"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Llamadas Realizadas</span>
						<span class="info-box-number"><?php echo $totalLlam->total; ?></span>

						<div class="progress">
							<div class="progress-bar" style="width: 50%"></div>
						</div>
						<span class="progress-description">
							50% Increase in 30 Days
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="fa fa-envelope"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Contactos por correo</span>
						<span class="info-box-number"><?php echo $totalMail->total; ?></span>

						<div class="progress">
							<div class="progress-bar" style="width: 20%"></div>
						</div>
						<span class="progress-description">
							20% Increase in 30 Days
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
				<div class="info-box bg-red">
					<span class="info-box-icon"><i class="fa fa-beer"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total de Visitas</span>
						<span class="info-box-number"><?php echo $totalVisi->total; ?></span>

						<div class="progress">
							<div class="progress-bar" style="width: 70%"></div>
						</div>
						<span class="progress-description">
							70% Increase in 30 Days
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
				<div class="info-box bg-aqua">
					<span class="info-box-icon"><i class="fa fa-send"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">Total de Ganadas</span>
						<span class="info-box-number"><?php echo $totalGana->total; ?></span>

						<div class="progress">
							<div class="progress-bar" style="width: 40%"></div>
						</div>
						<span class="progress-description">
							40% Increase in 30 Days
						</span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</div>
		</div> <?php
	}

	if($_SESSION["depart"] == 2 && $_SESSION["idrol"] == 2) { ?>
		<div class="row">
			<section class="col-lg-7 connectedSortable ui-sortable">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Grafico de Tareas</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-8"><?php
								if($_SESSION['activa'] > 0) { ?>
									<div class="card-body" id="donutContainer">
										<canvas id="pieChart" height="285" width="305" style="width: 244px; height: 228px;"></canvas>
									</div><?php 
								}else{ ?>
									<div class="chart-responsive">
										<img src="assets/images/no-data.jpg" class="img-responsive" style="width:60%;height:200px;margin: auto;" alt="No hay datos para mostrar">
										<h3> No hay datos que mostrar</h3>
									</div><?php 
								} ?>
							</div>	<!-- /.col -->
							<div class="col-md-4">
								<ul class="chart-legend clearfix">
									<li><i class="fa fa-circle-o text-red"></i> Tareas Vencidas </li>
									<li><i class="fa fa-circle-o text-green"></i> Tareas Ejecutadas </li>
									<li><i class="fa fa-circle-o text-yellow"></i> Tareas Asignadas </li>
									<li><i class="fa fa-circle-o text-aqua"></i> Tareas en Curso </li>
								</ul>
							</div>	<!-- /.col -->
						</div> 	<!-- /.row -->
					</div>	<!-- /.box-body -->
					<div class="box-footer no-padding">
						&nbsp;&nbsp;<h4>Graficos actualizados</h4>
					</div>	<!-- /.footer -->
				</div>
			</section>
			<section class="col-lg-5 connectedSortable ui-sortable">				
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Visitors Report</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">						
						<div class="row">
							<div class="col-md-9 col-sm-8">
								<div class="pad">
									<!-- Map will be created here -->
									<div id="map" style="height: 325px;">
										<div class="jvectormap-container" style="width: 100%; height: 100%; position: relative; overflow: hidden; background-color: transparent;">
											<svg width="679.875" height="325"><g transform="scale(5.899620533252399) translate(-316.3536924865014, -154.94120682918154)">
											<path d="M652.71,228.85l-0.04,1.38l-0.46,-0.21l-0.42,0.3l0.05,0.65l-0.17,-1.37l-0.48,-1.26l-1.08,-1.6l-0.23,-0.13l-2.31,-0.11l-0.31,0.36l0.21,0.98l-0.6,1.11l-0.8,-0.4l-0.37,0.09l-0.23,0.3l-0.54,-0.21l-0.78,-0.19l-0.38,-2.04l-0.83,-1.89l0.4,-1.5l-0.16,-0.35l-1.24,-0.57l0.36,-0.62l1.5,-0.95l0.02,-0.49l-1.62,-1.26l0.64,-1.31l1.7,1.0l0.12,0.04l0.96,0.11l0.19,1.62l0.25,0.26l2.38,0.37l2.32,-0.04l1.06,0.33l-0.92,1.79l-0.97,0.13l-0.23,0.16l-0.77,1.51l0.05,0.35l1.37,1.37l0.5,-0.14l0.35,-1.46l0.24,-0.0l1.24,3.92Z" data-code="BD" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M429.28,143.95l1.76,0.25l0.13,-0.01l2.16,-0.64l1.46,1.34l1.26,0.71l-0.23,1.8l-0.44,0.08l-0.24,0.25l-0.2,1.36l-1.8,-1.22l-0.23,-0.05l-1.14,0.23l-1.62,-1.43l-1.15,-1.31l-0.21,-0.1l-0.95,-0.04l-0.21,-0.68l1.66,-0.54Z" data-code="BE" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M413.48,260.21l-1.22,-0.46l-0.13,-0.02l-1.17,0.1l-0.15,0.06l-0.73,0.53l-0.87,-0.41l-0.39,-0.75l-0.13,-0.13l-0.98,-0.48l-0.14,-1.2l0.63,-0.99l0.05,-0.18l-0.05,-0.73l1.9,-2.01l0.08,-0.14l0.35,-1.65l0.49,-0.44l1.05,0.3l0.21,-0.02l1.05,-0.52l0.13,-0.13l0.3,-0.58l1.87,-1.1l0.11,-0.1l0.43,-0.72l2.23,-1.01l1.21,-0.32l0.51,0.4l0.19,0.06l1.25,-0.01l-0.14,0.89l0.01,0.13l0.34,1.16l0.06,0.11l1.35,1.59l0.07,1.13l0.24,0.28l2.64,0.53l-0.05,1.39l-0.42,0.59l-1.11,0.21l-0.22,0.17l-0.46,0.99l-0.69,0.23l-2.12,-0.05l-1.14,-0.2l-0.19,0.03l-0.72,0.36l-1.07,-0.17l-4.35,0.12l-0.29,0.29l-0.06,1.44l0.25,1.45Z" data-code="BF" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M477.63,166.84l0.51,0.9l0.33,0.14l0.9,-0.21l1.91,0.47l3.68,0.16l0.17,-0.05l1.2,-0.75l2.78,-0.67l1.72,1.05l1.02,0.24l-0.97,0.97l-0.91,2.17l0.0,0.24l0.56,1.19l-1.58,-0.3l-0.16,0.01l-2.55,0.95l-0.2,0.28l-0.02,1.23l-1.92,0.24l-1.68,-0.99l-0.27,-0.02l-1.94,0.8l-1.52,-0.07l-0.15,-1.72l-0.12,-0.21l-0.99,-0.76l0.18,-0.18l0.02,-0.39l-0.17,-0.22l0.33,-0.75l0.91,-0.91l0.01,-0.42l-1.16,-1.25l-0.18,-0.89l0.24,-0.27Z" data-code="BG" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M468.39,164.66l0.16,0.04l0.43,-0.0l-0.43,0.93l0.06,0.34l1.08,1.06l-0.28,1.09l-0.5,0.13l-0.47,0.28l-0.86,0.74l-0.1,0.16l-0.28,1.29l-1.81,-0.94l-0.9,-1.22l-1.0,-0.73l-1.1,-1.1l-0.55,-0.96l-1.11,-1.3l0.3,-0.75l0.59,0.46l0.42,-0.04l0.46,-0.54l1.0,-0.06l2.11,0.5l1.72,-0.03l1.06,0.64Z" data-code="BA" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M707.34,273.57l0.76,-0.72l1.59,-1.03l-0.18,1.93l-0.9,-0.06l-0.28,0.14l-0.31,0.51l-0.68,-0.78Z" data-code="BN" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M263.83,340.79l-0.23,-0.12l-2.86,-0.11l-0.28,0.17l-0.77,1.67l-1.17,-1.51l-0.18,-0.11l-3.28,-0.64l-0.28,0.1l-2.02,2.3l-1.43,0.29l-0.91,-3.35l-1.31,-2.88l0.75,-2.41l-0.09,-0.32l-1.23,-1.03l-0.31,-1.76l-0.05,-0.12l-1.12,-1.6l1.49,-2.62l0.01,-0.28l-1.0,-2.0l0.48,-0.72l0.02,-0.29l-0.37,-0.78l0.87,-1.13l0.06,-0.18l0.05,-2.17l0.12,-1.71l0.5,-0.8l0.01,-0.3l-1.9,-3.58l1.3,0.15l1.34,-0.05l0.23,-0.12l0.51,-0.7l2.12,-0.99l1.31,-0.93l2.81,-0.37l-0.21,1.51l0.01,0.13l0.29,0.91l-0.19,1.64l0.11,0.27l2.72,2.27l0.15,0.07l2.71,0.41l0.92,0.88l0.12,0.07l1.64,0.49l1.0,0.71l0.18,0.06l1.5,-0.02l1.24,0.64l0.1,1.31l0.05,0.14l0.44,0.68l0.02,0.73l-0.44,0.03l-0.27,0.39l0.96,2.99l0.28,0.21l4.43,0.1l-0.28,1.12l0.0,0.15l0.27,1.02l0.15,0.19l1.27,0.67l0.52,1.42l-0.42,1.91l-0.66,1.1l-0.04,0.2l0.21,1.3l-0.19,0.13l-0.01,-0.27l-0.15,-0.24l-2.33,-1.33l-0.14,-0.04l-2.38,-0.03l-4.36,0.76l-0.21,0.16l-1.2,2.29l-0.03,0.13l-0.06,1.37l-0.79,2.53l-0.05,-0.08Z" data-code="BO" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											
											<path d="M494.7,295.83l-0.14,-2.71l-0.04,-0.13l-0.34,-0.62l0.93,0.12l0.3,-0.16l0.67,-1.25l0.9,0.11l0.11,0.76l0.08,0.16l0.46,0.48l0.02,0.56l-0.55,0.48l-0.96,1.29l-0.82,0.82l-0.61,0.07Z" data-code="BI" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M427.4,268.94l-1.58,0.22l-0.52,-1.45l0.11,-5.73l-0.08,-0.21l-0.43,-0.44l-0.09,-1.13l-0.09,-0.19l-1.52,-1.52l0.24,-1.01l0.7,-0.23l0.18,-0.16l0.45,-0.97l1.07,-0.21l0.19,-0.12l0.53,-0.73l0.73,-0.65l0.68,-0.0l1.69,1.3l-0.08,0.67l0.02,0.14l0.52,1.38l-0.44,0.9l-0.01,0.24l0.2,0.52l-1.1,1.42l-0.76,0.76l-0.08,0.13l-0.47,1.59l0.05,1.69l-0.13,3.79Z" data-code="BJ" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M650.38,213.78l0.88,0.75l-0.13,1.24l-1.77,0.07l-2.1,-0.18l-1.57,0.4l-2.02,-0.91l-0.02,-0.24l1.54,-1.87l1.18,-0.6l1.67,0.59l1.32,0.08l1.01,0.67Z" data-code="BT" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M226.67,238.37l1.64,0.23l1.2,0.56l0.11,0.19l-1.25,0.03l-0.14,0.04l-0.65,0.37l-1.24,-0.37l-1.17,-0.77l0.11,-0.22l0.86,-0.15l0.52,0.08Z" data-code="JM" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M484.91,331.96l0.53,0.52l0.82,1.53l2.83,2.86l0.14,0.08l0.85,0.22l0.03,0.81l0.74,1.66l0.21,0.17l1.87,0.39l1.17,0.87l-3.13,1.71l-2.3,2.01l-0.07,0.1l-0.82,1.74l-0.66,0.88l-1.24,0.19l-0.24,0.2l-0.65,1.98l-1.4,0.55l-1.9,-0.12l-1.2,-0.74l-1.06,-0.32l-0.22,0.02l-1.22,0.62l-0.14,0.14l-0.58,1.21l-1.16,0.79l-1.18,1.13l-1.5,0.23l-0.4,-0.68l0.22,-1.53l-0.04,-0.19l-1.48,-2.54l-0.11,-0.11l-0.53,-0.31l-0.0,-7.25l2.18,-0.08l0.29,-0.3l0.07,-9.0l1.63,-0.08l3.69,-0.86l0.84,0.93l0.38,0.05l1.53,-0.97l0.79,-0.03l1.3,-0.53l0.23,0.1l0.92,1.96Z" data-code="BW" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M259.49,274.87l1.42,0.25l1.97,0.62l0.28,-0.05l0.67,-0.55l1.76,-0.38l2.8,-0.94l0.12,-0.08l0.92,-0.96l0.05,-0.33l-0.15,-0.32l0.73,-0.06l0.36,0.35l-0.27,0.93l0.17,0.36l0.76,0.34l0.44,0.9l-0.58,0.73l-0.06,0.13l-0.4,2.13l0.03,0.19l0.62,1.22l0.17,1.11l0.11,0.19l1.54,1.18l0.15,0.06l1.23,0.12l0.29,-0.15l0.2,-0.36l0.71,-0.11l1.13,-0.44l0.79,-0.63l1.25,0.19l0.65,-0.08l1.32,0.2l0.32,-0.18l0.23,-0.51l-0.05,-0.31l-0.31,-0.37l0.11,-0.31l0.75,0.17l0.13,0.0l1.1,-0.24l1.34,0.5l1.08,0.51l0.33,-0.05l0.67,-0.58l0.27,0.05l0.28,0.57l0.31,0.17l1.2,-0.18l0.17,-0.08l1.03,-1.05l0.76,-1.82l1.39,-2.16l0.49,-0.07l0.52,1.17l1.4,4.37l0.2,0.2l1.14,0.35l0.05,1.39l-1.8,1.97l0.01,0.42l0.78,0.75l0.18,0.08l4.16,0.37l0.08,2.25l0.5,0.22l1.78,-1.54l2.98,0.85l4.07,1.5l1.07,1.28l-0.37,1.23l0.36,0.38l2.83,-0.75l4.8,1.3l3.75,-0.09l3.6,2.02l3.27,2.84l1.93,0.72l2.13,0.11l0.76,0.66l1.22,4.56l-0.96,4.03l-1.22,1.58l-3.52,3.51l-1.63,2.91l-1.75,2.09l-0.5,0.04l-0.26,0.19l-0.72,1.99l0.18,4.76l-0.95,5.56l-0.74,0.96l-0.06,0.15l-0.43,3.39l-2.49,3.34l-0.06,0.13l-0.4,2.56l-1.9,1.07l-0.13,0.16l-0.51,1.38l-2.59,0.0l-3.94,1.01l-1.82,1.19l-2.85,0.81l-3.01,2.17l-2.12,2.65l-0.06,0.13l-0.36,2.0l0.01,0.13l0.4,1.42l-0.45,2.63l-0.53,1.23l-1.76,1.53l-2.76,4.79l-2.16,2.15l-1.69,1.29l-0.09,0.12l-1.12,2.6l-1.3,1.26l-0.45,-1.02l0.99,-1.18l0.01,-0.37l-1.5,-1.95l-1.98,-1.54l-2.58,-1.77l-0.2,-0.05l-0.81,0.07l-2.42,-2.05l-0.25,-0.07l-0.77,0.14l2.75,-3.07l2.8,-2.61l1.67,-1.09l2.11,-1.49l0.13,-0.24l0.05,-2.15l-0.07,-0.2l-1.26,-1.54l-0.35,-0.09l-0.64,0.27l0.3,-0.95l0.34,-1.57l0.01,-1.52l-0.16,-0.26l-0.9,-0.48l-0.27,-0.01l-0.86,0.39l-0.65,-0.08l-0.23,-0.8l-0.23,-2.39l-0.04,-0.12l-0.47,-0.79l-0.14,-0.12l-1.69,-0.71l-0.25,0.01l-0.93,0.47l-2.29,-0.44l0.15,-3.3l-0.03,-0.15l-0.62,-1.22l0.57,-0.39l0.13,-0.3l-0.22,-1.37l0.67,-1.13l0.44,-2.04l-0.01,-0.17l-0.59,-1.61l-0.14,-0.16l-1.25,-0.66l-0.22,-0.82l0.35,-1.41l-0.28,-0.37l-4.59,-0.1l-0.78,-2.41l0.34,-0.02l0.28,-0.31l-0.03,-1.1l-0.05,-0.16l-0.45,-0.68l-0.1,-1.4l-0.16,-0.24l-1.45,-0.76l-0.14,-0.03l-1.48,0.02l-1.04,-0.73l-1.62,-0.48l-0.93,-0.9l-0.16,-0.08l-2.72,-0.41l-2.53,-2.12l0.18,-1.54l-0.01,-0.13l-0.29,-0.91l0.26,-1.83l-0.34,-0.34l-3.28,0.43l-0.14,0.05l-1.3,0.93l-2.16,1.01l-0.12,0.09l-0.47,0.65l-1.12,0.05l-1.84,-0.21l-0.12,0.01l-1.33,0.41l-0.82,-0.21l0.16,-3.6l-0.48,-0.26l-1.97,1.43l-1.96,-0.06l-0.86,-1.23l-0.22,-0.13l-1.23,-0.11l0.34,-0.69l-0.05,-0.33l-1.36,-1.5l-0.92,-2.0l0.45,-0.32l0.13,-0.25l-0.0,-0.87l1.34,-0.64l0.17,-0.32l-0.23,-1.23l0.56,-0.77l0.05,-0.13l0.16,-1.03l2.7,-1.61l2.01,-0.47l0.16,-0.09l0.24,-0.27l2.11,0.11l0.31,-0.25l1.13,-6.87l0.06,-1.12l-0.4,-1.53l-0.1,-0.15l-1.0,-0.82l0.01,-1.45l1.08,-0.32l0.39,0.2l0.44,-0.24l0.08,-0.96l-0.25,-0.32l-1.22,-0.22l-0.02,-1.01l4.57,0.05l0.22,-0.09l0.6,-0.63l0.44,0.5l0.47,1.42l0.45,0.16l0.27,-0.18l1.21,1.16l0.23,0.08l1.95,-0.16l0.23,-0.14l0.43,-0.67l1.76,-0.55l1.05,-0.42l0.18,-0.2l0.25,-0.92l1.65,-0.66l0.18,-0.35l-0.14,-0.53l-0.26,-0.22l-1.91,-0.19l-0.29,-1.33l0.1,-1.64l-0.15,-0.28l-0.44,-0.25Z" data-code="BR" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M227.51,216.69l0.3,0.18l-0.24,1.07l0.03,-1.04l-0.09,-0.21ZM226.5,224.03l-0.13,0.03l-0.54,-1.3l-0.09,-0.12l-0.78,-0.64l0.4,-1.26l0.33,0.05l0.79,2.0l0.01,1.24ZM225.76,216.5l-2.16,0.34l-0.07,-0.41l0.85,-0.16l1.36,0.07l0.02,0.16Z" data-code="BS" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M480.08,135.28l2.09,0.02l0.13,-0.03l2.72,-1.3l0.16,-0.19l0.55,-1.83l1.94,-1.06l0.15,-0.31l-0.2,-1.33l1.33,-0.52l2.58,-1.3l2.39,0.8l0.3,0.75l0.37,0.17l1.22,-0.39l2.18,0.75l0.2,1.36l-0.48,0.85l0.01,0.32l1.57,2.26l0.92,0.6l-0.1,0.41l0.19,0.35l1.61,0.57l0.48,0.6l-0.64,0.49l-1.91,-0.11l-0.18,0.05l-0.48,0.32l-0.1,0.39l0.57,1.1l0.51,1.78l-1.79,0.17l-0.18,0.08l-0.77,0.73l-0.09,0.19l-0.13,1.31l-0.75,-0.22l-2.11,0.15l-0.56,-0.66l-0.39,-0.06l-0.8,0.49l-0.79,-0.4l-0.13,-0.03l-1.94,-0.07l-2.76,-0.79l-2.58,-0.27l-1.98,0.07l-0.15,0.05l-1.31,0.86l-0.8,0.09l-0.04,-1.16l-0.03,-0.12l-0.63,-1.28l1.22,-0.56l0.17,-0.27l0.01,-1.35l-0.04,-0.15l-0.66,-1.24l-0.08,-1.12Z" data-code="BY" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M198.03,239.7l0.28,0.19l0.43,-0.1l0.82,-1.42l0.0,0.07l0.29,0.29l0.16,0.0l-0.02,0.35l-0.39,1.08l0.02,0.25l0.16,0.29l-0.23,0.8l0.04,0.24l0.09,0.14l-0.25,1.12l-0.38,0.53l-0.33,0.06l-0.21,0.15l-0.41,0.74l-0.25,0.0l0.17,-2.58l0.01,-2.2Z" data-code="BZ" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path>
											<path d="M507.71,314.14l1.65,-0.18l2.96,0.7l0.2,-0.02l0.6,-0.29l1.68,-0.06l0.18,-0.07l0.8,-0.69l1.5,0.02l2.74,-0.98l1.74,-1.27l0.25,0.7l-0.1,2.47l0.31,2.27l0.1,3.97l0.42,1.24l-0.7,1.71l-0.94,1.73l-1.52,1.52l-5.06,2.21l-2.88,2.8l-1.01,0.51l-1.72,1.81l-0.99,0.58l-0.15,0.23l-0.21,1.86l0.04,0.19l1.17,1.95l0.47,1.47l0.03,0.74l0.39,0.28l0.05,-0.01l-0.06,2.13l-0.39,1.19l0.1,0.33l0.42,0.32l-0.28,0.83l-0.95,0.86l-2.03,0.88l-3.08,1.49l-1.1,0.99l-0.09,0.28l0.21,1.13l0.21,0.23l0.38,0.11l-0.14,0.89l-1.39,-0.02l-0.17,-0.94l-0.38,-1.23l-0.2,-0.89l0.44,-2.91l-0.01,-0.14l-0.65,-1.88l-1.15,-3.55l2.52,-2.85l0.68,-1.89l0.29,-0.18l0.14,-0.2l0.28,-1.53l-0.03,-0.19l-0.36,-0.7l0.1,-1.83l0.49,-1.84l-0.01,-3.26l-0.14,-0.25l-1.3,-0.83l-0.11,-0.04l-1.08,-0.17l-0.47,-0.55l-0.1,-0.08l-1.16,-0.54l-0.13,-0.03l-1.83,0.04l-0.32,-2.25l7.19,-1.99l1.32,1.12l0.29,0.06l0.55,-0.19l0.75,0.49l0.11,0.81l-0.49,1.11l-0.02,0.15l0.19,1.81l0.09,0.18l1.63,1.59l0.48,-0.1l0.72,-1.68l0.99,-0.49l0.17,-0.29l-0.21,-3.29l-0.04,-0.13l-1.11,-1.92l-0.9,-0.82l-0.21,-0.08l-0.62,0.03l-0.63,-2.98l0.61,-1.67Z" data-code="MZ" fill="rgba(210, 214, 222, 1)" fill-opacity="1" stroke="none" stroke-width="0" stroke-opacity="1" fill-rule="evenodd" class="jvectormap-region jvectormap-element"></path></g><g><circle data-index="0" cx="801.0193815826044" cy="109.01664739712453" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="1" cx="726.5644394418839" cy="76.30840838675294" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="2" cx="3083.122449419605" cy="774.3466454906164" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="3"	cx="3264.5325068577094" cy="892.6781714227358" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="4" cx="801.1671096424072" cy="72.69872730615873" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="5" cx="757.7350600603197" cy="13.75169190094266" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="6" cx="3144.134138118251" cy="661.457115789418" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="7" cx="-309.60017201647474" cy="508.5729617934941" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="8" cx="1698.7628010055362" cy="719.3760030668881" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="9" cx="831.3036338422223" cy="212.94313654446717" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="10" cx="-295.1228221557792" cy="587.8065524711964" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="11" cx="-287.44096304602226" cy="571.1512744827156" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="12" cx="-262.6226489991154" cy="571.1512744827156" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="13" cx="-296.6001027538093" cy="511.4627799769286" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="14" cx="1436.2500387355756" cy="834.8144304376964" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="15" cx="2603.449439239209" cy="657.8934978914796" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="16" cx="639.4048841581036" cy="98.35508324975171" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="17" cx="-283.74776155094673" cy="558.3649774240959" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="18" cx="2953.8603970919658" cy="664.4258872012321" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="19" cx="2150.5152078831607" cy="747.459016453391" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="20" cx="3173.236565899445" cy="745.0949281576433" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="21" cx="3347.112492287595" cy="1083.4436142613813" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="22" cx="-289.65688394306744" cy="538.9017314149454" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="23" cx="1466.5342909951944" cy="1069.1123504979191" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle>
											<circle data-index="24" cx="1363.863289432097" cy="373.5300435421856" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle><circle data-index="25" cx="716.5189313752783" cy="761.7896756637616" fill="#00a65a" stroke="#111" fill-opacity="1" stroke-width="1" stroke-opacity="1" r="5" class="jvectormap-marker jvectormap-element"></circle></g>
										</svg>
										<div class="jvectormap-zoomin">+</div>
										<div class="jvectormap-zoomout">−</div>
									</div>
								</div>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-3 col-sm-4">
								<div class="pad box-pane-right bg-green" style="min-height: 280px">
									<div class="description-block margin-bottom">
										<div class="sparkbar pad" data-color="#fff"><canvas width="34" height="30" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
											<h5 class="description-header">8390</h5>
											<span class="description-text">Visits</span>
										</div>
										<!-- /.description-block -->
										<div class="description-block margin-bottom">
											<div class="sparkbar pad" data-color="#fff"><canvas width="34" height="30" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
												<h5 class="description-header">30%</h5>
												<span class="description-text">Referrals</span>
											</div>
										<!-- /.description-block -->
										<div class="description-block">
										<div class="sparkbar pad" data-color="#fff"><canvas width="34" height="30" style="display: inline-block; width: 34px; height: 30px; vertical-align: top;"></canvas></div>
											<h5 class="description-header">70%</h5>
											<span class="description-text">Organic</span>
										</div>
									<!-- /.description-block -->
								</div>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.box-body -->
				</div>
            </section>
		</div> <?php
	}
	/* RRHH - Adicionales solo para Recursos Humanos
	if($_SESSION['depart'] == 6){ ?>
		<!-- Listado de Nominas -->
		<div class="row">
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Agentes retirados recientemente</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<table id="viewactivo" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 20%"><div align="center">Reportado el</div></th>
									<th><div align="center">Apellidos y Nombres</div></th>
									<th style="width: 20%"><div align="center">Renuncia</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$products = HorarioData::getAllByTurno();			
									$resultado = count($products);

									$j=1; $subtotal=0;
									if($resultado > 0){
										foreach($products as $tables){
											$startwork = str_pad($tables->dia, 2, "0", STR_PAD_LEFT).'-'.str_pad($tables->mes, 2, "0", STR_PAD_LEFT).'-'.$tables->ano;
											echo '<tr>';
												echo '<td><div align="center">'.$tables->update_at.'</div></td>';
												echo '<td><small>'.$tables->name.'</br><label><div class="text-red"><i class="fa fa-tasks"></i> Servicio: '.$tables->descripcion.'</div></label></td>';
												echo '<td><div align="center">'.$startwork.'</div></td>';
											echo '</tr>';
										}
									}
								?>
							</tbody>
						</table> 
					</div><!-- /.col -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Ultimas Nominas Registradas</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<table id="viewnomina" class="table table-bordered table-hover">
							<thead>
								<tr>								
									<th style="width: 20%"><div align="center">Generado el</div></th>
									<th><div align="center">Observaci&oacute;n</div></th>
									<th style="width: 10%"><div align="center">Mes</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$users = ControlData::getAll();				

									$resultado = count($users);
									$j=1; $subtotal=0;

									if($resultado > 0){
										foreach($users as $tables) {
											echo '<tr>';
												echo '<td><div align="center">'.$tables->created_at.'</div></td>';
												echo '<td><small>'.$tables->nombre.'</br><label><div class="text-red"><i class="fa fa-bell"></i> Estado: '.$tables->estado.' por '.$tables->usuario_log.'</div></label></td>'; //  <i class="fa fa-check"></i> Generado por: '.$tables->usuario_log.'
												echo '<td><div align="center"><small>'.str_pad($tables->mes, 2, "0", STR_PAD_LEFT).'-'.$tables->ano.'</small></div></td>';
											echo '</tr>';
										}
									}
								?>
							</tbody>
						</table> 
					</div><!-- /.col -->
				</div>
			</div>
		</div>
	<?php } */
	
	// Centralistas
    if($_SESSION['idrol'] == '1'){ ?>
        <div class="row">
            <section class="col-lg-7 connectedSortable ui-sortable">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Mapa de Visitas</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body" style="padding:0;">
					<!-- Contenedor del mapa -->
					<div id="map_visitas" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
            </section>
            <section class="col-lg-5 connectedSortable ui-sortable">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                        <i class="fa fa-calendar"></i>
                        <h3 class="box-title">Calendar</h3>                    
                        <div class="pull-right box-tools">                    
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i></button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Add new event</a></li>
                                <li><a href="#">Clear events</a></li>
                                <li class="divider"></li>
                                <li><a href="#">View calendar</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>                    
                    </div>                    
                    <div class="box-body no-padding">                    
                        <div id="calendar" style="width: 100%">
                            <div class="datepicker datepicker-inline">
                                <div class="datepicker-days" style="">
                                    <table class="table-condensed">
                                        <thead>
                                            <tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr>
                                            <tr>
                                                <th class="prev">«</th><th colspan="5" class="datepicker-switch">July 2024</th><th class="next">»</th>
                                            </tr>
                                            <tr>
                                                <th class="dow">Su</th>
                                                <th class="dow">Mo</th>
                                                <th class="dow">Tu</th>
                                                <th class="dow">We</th>
                                                <th class="dow">Th</th>
                                                <th class="dow">Fr</th>
                                                <th class="dow">Sa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="old day" data-date="1719705600000">30</td>
                                                <td class="day" data-date="1719792000000">1</td>
                                                <td class="day" data-date="1719878400000">2</td>
                                                <td class="day" data-date="1719964800000">3</td>
                                                <td class="day" data-date="1720051200000">4</td>
                                                <td class="day" data-date="1720137600000">5</td><td class="day" data-date="1720224000000">6</td></tr><tr><td class="day" data-date="1720310400000">7</td><td class="day" data-date="1720396800000">8</td><td class="day" data-date="1720483200000">9</td><td class="day" data-date="1720569600000">10</td><td class="day" data-date="1720656000000">11</td><td class="day" data-date="1720742400000">12</td><td class="day" data-date="1720828800000">13</td></tr><tr><td class="day" data-date="1720915200000">14</td><td class="day" data-date="1721001600000">15</td><td class="day" data-date="1721088000000">16</td><td class="day" data-date="1721174400000">17</td><td class="day" data-date="1721260800000">18</td><td class="day" data-date="1721347200000">19</td><td class="day" data-date="1721433600000">20</td></tr><tr><td class="day" data-date="1721520000000">21</td><td class="day" data-date="1721606400000">22</td><td class="day" data-date="1721692800000">23</td><td class="day" data-date="1721779200000">24</td><td class="day" data-date="1721865600000">25</td><td class="day" data-date="1721952000000">26</td><td class="day" data-date="1722038400000">27</td></tr><tr><td class="day" data-date="1722124800000">28</td><td class="day" data-date="1722211200000">29</td><td class="day" data-date="1722297600000">30</td><td class="day" data-date="1722384000000">31</td><td class="new day" data-date="1722470400000">1</td><td class="new day" data-date="1722556800000">2</td><td class="new day" data-date="1722643200000">3</td></tr><tr><td class="new day" data-date="1722729600000">4</td><td class="new day" data-date="1722816000000">5</td><td class="new day" data-date="1722902400000">6</td><td class="new day" data-date="1722988800000">7</td><td class="new day" data-date="1723075200000">8</td><td class="new day" data-date="1723161600000">9</td><td class="new day" data-date="1723248000000">10</td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot>
                                    </table>
                                </div>
                                <div class="datepicker-months" style="display: none;">
                                    <table class="table-condensed">
                                        <thead>
                                            <tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2024</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month focused">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span>
                                        </td></tr>
                                        </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2020-2029</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="year old">2019</span><span class="year">2020</span><span class="year">2021</span><span class="year">2022</span><span class="year">2023</span><span class="year focused">2024</span><span class="year">2025</span><span class="year">2026</span><span class="year">2027</span><span class="year">2028</span><span class="year">2029</span><span class="year new">2030</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-decades" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2090</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade">2010</span><span class="decade focused">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-centuries" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2900</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="century old">1900</span><span class="century focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr><th colspan="7" class="today" style="display: none;">Today</th></tr>
                                            <tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                
                    <div class="box-footer text-black">
                        <div class="row">
                            <div class="col-sm-6">                
                                <div class="clearfix">
                                    <span class="pull-left">Task #1</span>
                                    <small class="pull-right">90%</small>
                                </div>
                                <div class="progress xs">
                                    <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                                </div>
                                <div class="clearfix">
                                    <span class="pull-left">Task #2</span>
                                    <small class="pull-right">70%</small>
                                </div>
                                <div class="progress xs">
                                    <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                                </div>
                            </div>                
                            <div class="col-sm-6">
                                <div class="clearfix">
                                    <span class="pull-left">Task #3</span>
                                    <small class="pull-right">60%</small>
                                </div>
                                <div class="progress xs">
                                    <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                                </div>
                                <div class="clearfix">
                                    <span class="pull-left">Task #4</span>
                                    <small class="pull-right">40%</small>
                                </div>
                                <div class="progress xs">
                                    <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                                </div>
                            </div>                
                        </div>                
                    </div>
                </div>
            </section>
        </div>  <?php
    }
    
	// Listado de los contratos que se terminan
	if($_SESSION["idrol"] == "1"){ ?>
		<!-- Listado de Empresas -->
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Contratos por finalizar</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table id="viewdates" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th width="8%"><div align="center">Termina</div></th>
						<th width="30%">Empresa</th>
						<th>Correo</th>
						<th width="8%">Telefono</th>
						<th width="10%"><div align="center">Fecha de Inicio</div></th>
						<th width="10%"><div align="center">Fecha de Final</div></th>
					</tr>
					</thead>
					<tbody>
						<?php						    
                            $empresas = ClientData::getAll(0, 1);

							// Crea tabla de Empresas
							foreach($empresas as $tables) {
								$now = time();
								$date = strtotime($tables->fechafin);
								 
								$diff_in_days = floor(($date - $now) / (60 * 60 * 24));
								if($diff_in_days < 0) $diff_in_days = 0;
								echo '<tr>';
									echo '<td><div align="center">'.$diff_in_days.'</div></td>';
									echo '<td>'.$tables->nombre.'</td>';
									echo '<td>'.$tables->email.'</td>';
									echo '<td>'.$tables->telefono1.'</td>';
									echo '<td><div align="center">'.$tables->fechaini.'</div></td>';
									echo '<td><div align="center">'.$tables->fechafin.'</div></td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>	<?php 
	} 
	    	
	// RRHH - Listado de Cumpleanos/Permisos
	if($_SESSION['depart'] == 6){ 
	    // Listado de los memos
        $users = TimelineData::getEstados(1, 3); 
		
        if (empty($users)) {
            //No hay registros
        } else { ?>
    	    <!-- Listado de Permisos -->
    		<div class="box">
    			<div class="box-body mailbox-messages">
    				<table id="viewBitacora" class="table table-bordered table-hover">
    					<thead>
    					<tr>
    						<th width="8%"><div align="center">SOLICITADO</div></th>
    						<th width="10%"><div align="center">SOLICITANTE</div></th>
    						<th>MOTIVO</th>
    						<th width="30%">JUSTIFICACION</th>
    						<th width="10%">SUPERVISOR</th>
    						<th width="10%"><div align="center">DESDE</div></th>
    						<th width="10%"><div align="center">HASTA</div></th>
                            <th width="8%"><div align="center">Acci&oacute;n</div></th>
    					</tr>
    					</thead>
    					<tbody>
    						<?php
    							// Crea tabla de permisos
    							foreach($users as $tables) {
                                    $permiso = OperationTypeData::getLike('id', $tables->porcentaje)->name;
                                	$nombre = UserData::getById($tables->idperson)->name.' '.UserData::getById($tables->idperson)->lastname;            
                                    $email = UserData::getById($tables->idperson)->email;
    								echo '<tr>';
    									echo '<td><div align="center">'.$tables->created_at.'</div></td>';
    									echo '<td><div align="center">'.$nombre.'</div></td>';
    									echo '<td>'.$permiso.'<br>'.$email.'</td>';
    									echo '<td>'.$tables->title.'</td>'; //utf8_encode()
    									echo '<td>'.$tables->quien_asigna.'</td>';
    									echo '<td><div align="center">'.$tables->date_event.'</div></td>';
    									echo '<td><div align="center">'.$tables->date_pass.'</div></td>';
    									echo '<td>';
    							 			  echo '<div align="center">';
    							 			      echo '<a class="btn btn-app btn-danger" href="index.php?view=archivo/'.$tables->id.'"><i class="fa fa-edit"></i> Registro </a>';
    										  echo '</div>';
    									echo '</td>';
    								echo '</tr>';
    							}
    						?>
    					</tbody>
    				</table>
    			</div>
    		</div><?php 
    	} ?>
		<!-- Listado de Cumpleanos 
		if($_SESSION['idrol'] == 6 || $_SESSION['idrol'] == 3){ 
		<div class="box">
			<div class="box-body mailbox-messages">
				<table id="viewdates" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th width="8%"><div align="center">Cedula</div></th>
						<th width="30%">Cumplea&ntilde;eros del Mes</th>
						<th>Correo</th>
						<th width="8%">Telefono</th>
						<th width="10%"><div align="center">Fecha de Ingreso</div></th>
						<th width="10%"><div align="center">Fecha de Nacimiento</div></th>
					</tr>
					</thead>
					<tbody>
						<?php
							/* Crea tabla de cumpleaños
							foreach($fechas as $tables) {
								$fechas = explode("-", $tables->startwork);
								if($tables->startwork == '')
									$startwork = '';
								else
									$startwork = $fechas[2].'-'.$fechas[1].'-'.$fechas[0];

								$fechas = explode("-", $tables->fechanacimiento);
								if($tables->fechanacimiento == '')
									$fechanacimiento = '';
								else
									$fechanacimiento = $fechas[2].'-'.$fechas[1].'-'.$fechas[0];

								echo '<tr>';
									echo '<td><div align="center">'.$tables->idcard.'</div></td>';
									echo '<td>'.$tables->name.'</td>'; //utf8_encode()
									echo '<td>'.$tables->email.'</td>';
									echo '<td>'.$tables->phone1.'</td>';
									echo '<td><div align="center">'.$startwork.'</div></td>';
									echo '<td><div align="center">'.$fechanacimiento.'</div></td>';
								echo '</tr>';
							} */
						?>
					</tbody>
				</table>
			</div>
		</div> --><?php
	}else{ 
		// Logistica - Listado de productos
		if($_SESSION['depart'] == 12){ ?>	
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							 <strong>
							   <span class="glyphicon glyphicon-th"></span>
							   <span>Productos más vendidos</span>
							 </strong>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered table-condensed">
							  <thead>
							   <tr>
								 <th>Título</th>
								 <th>Total vendido</th>
								 <th>Cantidad total</th>
							   <tr>
							  </thead>
							  <tbody>
								<?php foreach ($products_sold as  $product_sold): ?>
								  <tr>
									<td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
									<td><?php echo (int)$product_sold['totalSold']; ?></td>
									<td><?php echo (int)$product_sold['totalQty']; ?></td>
								  </tr>
								<?php endforeach; ?>
							  </tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
						  <strong>
							<span class="glyphicon glyphicon-th"></span>
							<span>ÚLTIMAS VENTAS</span>
						  </strong>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered table-condensed">
								<thead>
									<tr>
									   <th class="text-center" style="width: 50px;">#</th>
									   <th>Producto</th>
									   <th>Fecha</th>
									   <th>Venta total</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($recent_sales as  $recent_sale): ?>
									<tr>
									   <td class="text-center"><?php echo count_id();?></td>
									   <td>
										<a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
										 <?php echo remove_junk(first_character($recent_sale['name'])); ?>
									   </a>
									   </td>
									   <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
									   <td>$<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
							  <span class="glyphicon glyphicon-th"></span>
							  <span>Productos recientemente añadidos</span>
							</strong>
						</div>
						<div class="panel-body">
							<div class="list-group">
								<?php foreach ($recent_products as  $recent_product): ?>
									<a class="list-group-item clearfix" href="edit_product.php?id=<?php echo  (int)$recent_product['id'];?>">
										<h4 class="list-group-item-heading">
										 <?php if($recent_product['media_id'] === '0'): ?>
											<img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
										  <?php else: ?>
										  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />
										<?php endif;?>
										<?php echo remove_junk(first_character($recent_product['name']));?>
										  <span class="label label-warning pull-right">
										 $<?php echo (int)$recent_product['sale_price']; ?>
										  </span>
										</h4>
										<span class="list-group-item-text pull-right">
											<?php echo remove_junk(first_character($recent_product['categorie'])); ?>
										</span>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php	
			//Panel de fallas	
			$products = ProductData::getAll();
			foreach($products as $product){
				$q=OperationData::getQYesF($product->id);	
				if($q<=$product->inventary_min){
					$found=true;
					break;
				}
			}
			
			if(count($products)>0){ ?>
				<div class="box box-solid">
					<div class="box-header ui-sortable-handle bg-green-gradient">
						<i class="fa fa-th"></i>
						<h3 class="box-title">Listado de productos por terminar</h3>
					</div>
					<div class="box-body">
						<div class="clearfix"></div>
						<div class="col-md-12">
							<br>
							<table class="table table-bordered table-hover">
								<thead>
									<th >Codigo</th>
									<th>Nombre del producto</th>
									<th>En Stock</th>
									<th></th>
								</thead>
							<?php
							foreach($products as $product):
								$q=OperationData::getQYesF($product->id); ?>
								<?php if($q<=$product->inventary_min): ?>
								<tr class="<?php if($q==0){ echo "danger"; }else if($q<=$product->inventary_min/2){ echo "danger"; } else if($q<=$product->inventary_min){ echo "warning"; } ?>">
									<td><?php echo $product->id; ?></td>
									<td><?php echo $product->name; ?></td>
									<td><?php echo $q; ?></td>
									<td>
									<?php if($q==0){ echo "<span class='label label-danger'>No hay existencias.</span>";}else if($q<=$product->inventary_min/2){ echo "<span class='label label-danger'>Quedan muy pocas existencias.</span>";} else if($q<=$product->inventary_min){ echo "<span class='label label-warning'>Quedan pocas existencias.</span>";} ?>
									</td>
								</tr>
							<?php endif;?>
							<?php
							endforeach;
							?>
							</table>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			<?php
			}else{ ?>
				<div class="jumbotron">
					<h2>No hay alertas</h2>
					<p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel minimo.</p>
				</div>
				<?php
			} 
		}
	}	
echo '</section>';
if($_SESSION['idrol'] == 2) { ?>
<!-- Chart.js (incluido si AdminLTE ya trae una versión; si no, usa este CDN) -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/chart.js/Chart.js"></script>
<!-- Script principal (todo en este archivo) -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// -------------
		// - PIE CHART -
		// -------------
		// Get context with jQuery - using jQuery's .get() method.
		var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
		var pieCharts       = new Chart(pieChartCanvas);
		var PieData = [
			{
				value    : <?php echo $_SESSION['vencida']; ?>,
				color    : '#f56954',
				highlight: '#f56954',
				label    : 'Tareas Vencidas'
			},
			{
				value    : <?php echo $_SESSION['terminada']; ?>,
				color    : '#00a65a',
				highlight: '#00a65a',
				label    : 'Tareas Ejecutadas'
			},
			{
				value    : <?php echo $_SESSION['encurso']; ?>,
				color    : '#3c8dbc',
				highlight: '#3c8dbc',
				label    : 'Tareas en Curso'
			},
			{
				value    : <?php echo $_SESSION['activa']; ?>,
				color    : '#f39c12',
				highlight: '#f39c12',
				label    : 'Tareas Asignadas'
			}
		]; 
		var pieOptions     = {
			// Boolean - Whether we should show a stroke on each segment
			segmentShowStroke    : true,
			// String - The colour of each segment stroke
			segmentStrokeColor   : '#fff',
			// Number - The width of each segment stroke
			segmentStrokeWidth   : 1,
			// Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 50, // This is 0 for Pie charts
			// Number - Amount of animation steps
			animationSteps       : 100,
			// String - Animation easing effect
			animationEasing      : 'easeOutBounce',
			// Boolean - Whether we animate the rotation of the Doughnut
			animateRotate        : true,
			// Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale         : false,
			// Boolean - whether to make the chart responsive to window resizing
			responsive           : true,
			// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio  : false,
			// String - A legend template
			legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
			// String - A tooltip template
			tooltipTemplate      : '<%=value %> <%=label%> '
		};
		// Create pie or douhnut chart
		// You can switch between pie and douhnut using the method below.
		pieCharts.Doughnut(PieData, pieOptions);
		// -----------------
		// - END PIE CHART -
		// -----------------
	});
</script><?php
}
if($_SESSION['idrol'] == 3) { ?>
<!-- Chart.js (incluido si AdminLTE ya trae una versión; si no, usa este CDN) -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/chart.js/Chart.js"></script>
<!-- Script principal (todo en este archivo) -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// -------------
		// - PIE CHART -
		// -------------
		// Get context with jQuery - using jQuery's .get() method.
		var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
		var pieCharts       = new Chart(pieChartCanvas);
			var PieData        = [
				{
					value    : <?php echo $_SESSION['ventas']; ?>,
					color    : '#f56954',
					highlight: '#f56954',
					label    : 'Cotizado'
				},
				{
					value    : <?php echo $_SESSION['ganada']; ?>,
					color    : '#00a65a',
					highlight: '#00a65a',
					label    : 'Ganadas'
				},
				{
					value    : <?php echo $_SESSION['perdida']; ?>,
					color    : '#f39c12',
					highlight: '#f39c12',
					label    : 'Perdidas'
				},
				{
					value    : <?php echo $_SESSION['ventas'] - ($_SESSION['ganada'] + $_SESSION['perdida']); ?>,
					color    : '#3c8dbc',
					highlight: '#3c8dbc',
					label    : 'En Negociacion'
				}
			]; 
			var pieOptions     = {
				// Boolean - Whether we should show a stroke on each segment
				segmentShowStroke    : true,
				// String - The colour of each segment stroke
				segmentStrokeColor   : '#fff',
				// Number - The width of each segment stroke
				segmentStrokeWidth   : 1,
				// Number - The percentage of the chart that we cut out of the middle
				percentageInnerCutout: 50, // This is 0 for Pie charts
				// Number - Amount of animation steps
				animationSteps       : 100,
				// String - Animation easing effect
				animationEasing      : 'easeOutBounce',
				// Boolean - Whether we animate the rotation of the Doughnut
				animateRotate        : true,
				// Boolean - Whether we animate scaling the Doughnut from the centre
				animateScale         : false,
				// Boolean - whether to make the chart responsive to window resizing
				responsive           : true,
				// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
				maintainAspectRatio  : false,
				// String - A legend template
				legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
				// String - A tooltip template
				tooltipTemplate      : '<%=value %> <%=label%> '
			};
			// Create pie or douhnut chart
			// You can switch between pie and douhnut using the method below.
			pieCharts.Doughnut(PieData, pieOptions);
			// -----------------
			// - END PIE CHART -
			// ----------------- 
	});
</script><?php
}
?>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Panel de Control";
</script>