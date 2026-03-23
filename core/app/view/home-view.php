<?php
//Vista del Panel de control
$ano=date("Y"); $mes=date("m"); 
$_SESSION["error"]=0; $_SESSION['ganada']=0; $_SESSION['perdida']=0; $_SESSION['ventas']=0;

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
						echo '<a href="index.php?view=opehor.activos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
								echo '<a href="index.php?view=opehor.activos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									$total1 = TimelineData::getByTotal(2);
									echo '<h3>'.(is_object($total1) && isset($total1->total) ? $total1->total : 0).'</h3>';
									echo '<p>Tareas en Curso </p>';
								echo '</div>'; 
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									$total1 = TimelineData::getByTotal(4);
									echo '<h3>'.(is_object($total1) && isset($total1->total) ? $total1->total : 0).'</h3>';
									echo '<p>Tareas Vencidas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									$total2 = TimelineData::getByTotal(3);
									echo '<h3>'.(is_object($total2) && isset($total2->total) ? $total2->total : 0).'</h3>';
									echo '<p>Tareas Ejecutadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user-friends"></i>';
								echo '</div>';
								echo '<a href="tareas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">'; 
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									$total2 = TimelineData::getByTotal(1);
									echo '<h3>'.(is_object($total2) && isset($total2->total) ? $total2->total : 0).'</h3>';
									echo '<p>Tareas Asignadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-dolly"></i>';
								echo '</div>';
								echo '<a href="calendario" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
			<div class="col-md-6">
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
									<li><i class="fa fa-circle-o text-yellow"></i> Tareas en Curso</li>
									<li><i class="fa fa-circle-o text-aqua"></i> Tareas Asignadas </li>
								</ul>
							</div>	<!-- /.col -->
						</div> 	<!-- /.row -->
					</div>	<!-- /.box-body -->
					<div class="box-footer no-padding">
						<ul class="nav nav-pills nav-stacked">
							<li>
								<a href="#">Perdidas 
									<span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> $ <?php echo $_SESSION['activas']; ?></span>
								</a>
							</li>
						</ul>
					</div>	<!-- /.footer -->
				</div>
			</div>
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
				label    : 'Tareas Pendientes'
			},
			{
				value    : <?php echo $_SESSION['encurso']; ?>,
				color    : '#f39c12',
				highlight: '#f39c12',
				label    : 'Tareas Asignadas'
			},
			{
				value    : <?php echo $_SESSION['activa']; ?>,
				color    : '#3c8dbc',
				highlight: '#3c8dbc',
				label    : 'Tareas Ejecutadas'
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