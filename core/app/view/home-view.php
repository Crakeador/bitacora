<?php
//Vista del Panel de control
//Modificado el: 15/05/2025 - Boton de tareas

$cadena = '';
//if($_SESSION["ingreso"] == 0) print "<script>window.location='./logout.php';</script>";

if($_SESSION['idrol'] ==  4){
    if($_SERVER['dispositivo'] == 1){
        //En la PC
    }else{
        Core::redir('visito');
    }
}

if($_SESSION['idrol'] ==  6){
    if($_SERVER['dispositivo'] == 1){
        //En la PC
    }else{
        Core::redir('supervisar');
    }
}

if($_SESSION['idrol'] ==  7 || $_SESSION['idrol'] == 14){
    if($_SESSION['residencial'] == 0) 
        $cadena = 'registro';
    else
        $cadena = 'novedad';
    
	echo '<script>
				if(localStorage.getItem("usuario") != null){
					var usuario = localStorage.getItem("usuario");
					var puesto = localStorage.getItem("puesto");
					var ingreso = localStorage.getItem("ingreso");
					var turno = localStorage.getItem("turno");
					
					console.log(usuario + \' Puesto: \' + puesto + \' Ingreso: \' + ingreso + \' Turno: \' + turno);
					window.location="index.php?view='.$cadena.'&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso;
				}else{
					window.location="index.php?view=asignar";
				}
			</script>'; //+"&turno="+turno
    //Core::redir('novedad');
}

if($_SESSION['idrol'] ==  8) Core::redir('fechas');
if($_SESSION['idrol'] ==  9) Core::redir('autorizan');
if($_SESSION['idrol'] == 13) Core::redir('ruta');
if($_SESSION['idrol'] == 15) Core::redir('supervisar');

if($_SESSION['idrol'] == 10) 
	if($_SESSION['depart'] == 3)	
		print "<script>window.location='index.php?view=opeasi.personal';</script>";
	else
		print "<script>window.location='index.php?view=rrging.persons';</script>";

if($_SESSION['idrol'] ==11) {
	if($_SESSION['aspirante']>0) {
		print "<script>window.location='index.php?view=aspirantes&id=".$_SESSION['aspirante']."';</script>"; 
	}else{
		Core::redir('aspirantes');
	}
}
if($_SESSION["idrol"] == "12")
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

if($_SESSION['is_admin']=='1')
	$events = TimelineData::getAll(10); // Listado de administradores
else
	$events = TimelineData::getTime($_SESSION['user_id'], $ano); //getById

$fechaIni = new DateTime($_SESSION["cambio"]);
// Fecha de finalización (puede ser la fecha actual)
$fechaFin = new DateTime(date('Y-m-d'));
// Calcular la diferencia entre las fechas
$diferencia = $fechaIni->diff($fechaFin);

/* Acceder a los componentes de tiempo deseados
echo "Diferencia de días: " . $diferencia->days . " días<br>";
echo "Diferencia de meses: " . $diferencia->m . " meses<br>";
echo "Diferencia de años: " . $diferencia->y . " años<br>";
echo "Diferencia total en días: " . $diferencia->format('%R%a') . " días<br>"; */

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
			$rubro = NominaData::getAllMonto($ano, strval($mes)-1, 3);

			$ingreso=0; $egresos=0; $monto=0;
			foreach($rubro as $rubros) {
				if($rubros->tipo_cuenta == 'I'){
					$ingreso = $ingreso + $rubros->monto;
				}else{
					$egresos = $egresos + $rubros->monto;
				}
			}
			
			$monto = $ingreso-$egresos;
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-aqua">';
					echo '<div class="inner">';
						echo '<h3>'.count(ClientData::getAll(0, 1)).'</h3>';
						echo '<p>Total de Clientes</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="fa fa-shopping-cart"></i>';
					echo '</div>';
					echo '<a href="index.php?view=clientes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
						echo '<i class="fa fa-user-friends"></i>';
					echo '</div>';
					echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
				echo '</div>';
			echo '</div>';
			echo '<div class="col-lg-3 col-xs-6">';
				echo '<div class="small-box bg-red">';
				echo '<div class="inner">';
					echo '<h3> $ '.number_format($monto, 2, ',', '.').'</h3>';
					echo '<p>Total de Nomina</p>';
				echo '</div>';
				echo '<div class="icon">';
					echo '<i class="fa fa-dolly"></i>';
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
							echo '<i class="ion ion-bookmark"></i>';
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
							echo '<i class="fa fa-dolly"></i>';
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
									echo '<p>Total de Aspirantes</p>';
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
					case 4: // Area Comercial
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(ProductData::getAll()).'</h3>';
									echo '<p>Visitas realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="index.php?view=products" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
								echo '<a href="index.php?view=agentes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
								echo '<p>Total de Aspirantes</p>';
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
								echo '<i class="fa fa-dolly"></i>';
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
									echo '<i class="fa fa-dolly"></i>';
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
									echo '<i class="fa fa-user-friends"></i>';
								echo '</div>';
								echo '<a href="index.php?view=equipar" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
					    break;
					case 8: // Area Comercial
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

						if($_SERVER['dispositivo'] == 1) $cadena = " AND A.fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
						if($_SERVER['dispositivo'] == 2) $cadena = " AND A.fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
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
									echo '<p>Puestos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user-friends"></i>';
								echo '</div>';
								echo '<a href="index.php?view=puestos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">'; // Logistica
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(CategoryData::getAll()).'</h3>';
									echo '<p>Proveedores</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-dolly"></i>';
								echo '</div>';
								echo '<a href="proveedores" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
				}
			}
		}
	echo '</div>';

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
    if($_SESSION['idrol'] == '1299'){ ?>
        <div class="row">
            <section class="col-lg-7 connectedSortable ui-sortable">
                <div class="box box-success">
                    <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-comments-o"></i>
                    <h3 class="box-title">Chat</h3>
                    <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">
                        <div class="btn-group" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                        </div>
                    </div>
                    </div>
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 346px;">
                        <div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto; height: 346px;">
                        
                        <div class="item">
                        <img src="dist/img/user4-128x128.jpg" alt="user image" class="online">
                        <p class="message">
                        <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock"></i> 2:15</small>
                        Mike Doe
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                        </p>
                        <div class="attachment">
                        <h4>Attachments:</h4>
                        <p class="filename">
                        Theme-thumbnail-image.jpg
                        </p>
                        <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
                        </div>
                        </div>
                        
                        </div>
                        
                        
                        <div class="item">
                        <img src="dist/img/user3-128x128.jpg" alt="user image" class="offline">
                        <p class="message">
                        <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock"></i> 5:15</small>
                        Alexander Pierce
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                        </p>
                        </div>
                        
                        
                        <div class="item">
                        <img src="dist/img/user2-160x160.jpg" alt="user image" class="offline">
                        <p class="message">
                        <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock"></i> 5:30</small>
                        Susan Doe
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                        </p>
                        </div>
                        
                        </div>
                    <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 184.366px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                    
                    <div class="box-footer">
                    <div class="input-group">
                    <input class="form-control" placeholder="Type message...">
                    <div class="input-group-btn">
                    <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                        </div>
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

    if(!isset($_SESSION["client_id"])){
        $valor = count($events);
        
        if(count($events) > 0){
    		// Crea tabla de Tareas
            echo '<div class="row">';
                echo '<div class="col-md-12">';
                    echo '<ul class="timeline">';
                        $fecha = '';
                		foreach($events as $product) {
                        	if($product->prioridad == 0) $prioridad = 'green'; 
            				if($product->prioridad == 1) $prioridad = 'yellow'; 
            				if($product->prioridad == 2) $prioridad = 'red'; 
                			
                			$pos = strpos($product->idperson, ',');	
                			if ($pos === false) {
                				if($product->idperson > 0){
                					$nombre = UserData::getById($product->idperson)->name.' '.UserData::getById($product->idperson)->lastname;
                				}
                			}else{
                			    $array = explode (',', $product->idperson);
                			    
                                foreach ($array as $palabra) {
                                    $valor = (int) $palabra;
                                    if($valor > 0)
                                        $nombre = UserData::getById($palabra)->name.' '.UserData::getById($palabra)->lastname;
                                }
                			}
            				
            				if($product->date_event == $fecha){
            				    
            				}else{
            				    $fecha=$product->date_event;
                                echo '<li class="time-label">';
                                    echo '<span class="bg-red">';
                                        echo substr($product->date_event, 0, 10); //date_format(, 'Y-m-d');
                                    echo '</span>';
                                echo '</li>';    				    
            				}
            				
            				if($product->type == 'news') 
            				    $tipo = 'envelope';
            				elseif($product->type == 'image') 
            				    $tipo = 'eyedropper';
            				else
            				    $tipo = 'comments';
            				
            				if($product->type == 'image'){
                				if($product->prioridad == 0) $estilo = '<div class="text-yellow"><i class="fa fa-bell"></i> Su solicitud esta en espera de ser aprobada </div>';
    							if($product->prioridad == 1) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> Su solicitud fue rechazada </div>';
    							if($product->prioridad == 2) $estilo = '<div class="text-green"><i class="fa fa-bell"></i> Su solicitud fue aprobada </div>';
            				}else{
                				if($product->prioridad == 0) $estilo = '<div class="text-green"><i class="fa fa-bell"></i> Prioridad: Baja &#9733; </div>';
    							if($product->prioridad == 1) $estilo = '<div class="text-yellow"><i class="fa fa-bell"></i> Prioridad: Media &#9733; &#9733; &#9733; </div>';
    							if($product->prioridad == 2) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> Prioridad: Alta &#9733; &#9733; &#9733; &#9733; &#9733;</div>';
            				}
            				$descripcion = OperationTypeData::getLike('id', $product->porcentaje);
            				
                            echo '<li>';
                                echo '<i class="fa fa-'.$tipo.' bg-'.$prioridad.'"></i>';
                                echo '<div class="timeline-item">';
                                    if($product->type == 'image') {
                                        if($product->date_pass == '')
                                            echo '<span class="time"><i class="fa fa-clock"></i> Aprobado el: '.$product->update_at.'</span>';
                                        else
                                            echo '<span class="time"><i class="fa fa-clock"></i> Solicitado el: '.$product->created_at.'</span>';
                                    }else{
                                        if($product->date_pass == '')
                                            echo '<span class="time"><i class="fa fa-clock"></i> Finalizada el: '.$product->update_at.'</span>';
                                        else
                                            echo '<span class="time"><i class="fa fa-clock"></i> Asignada el: '.$product->created_at.'</span>';
                                    }
                                    
                                    if($product->type == 'image') $cadena = 'Solicitud Permiso de:'; else $cadena = 'Tarea asignada a:';
                                    echo '<h3 class="timeline-header">'.$cadena.' '.$nombre.'&nbsp;&nbsp;'; //<a href="#"></a>
                                    if($product->type == 'image') echo '<small>Solicitado a: '.$product->quien_asigna.'</small></h3>'; else echo '<small>Asignado por: '.$product->quien_asigna.'</small></h3>';
                                    echo '<div class="timeline-body">';
                                        if($product->type == 'image') echo 'Solitiud de permiso por: '.$descripcion->name.'</br>';
                                        echo $product->title.'</br>';
                                        if($product->type == 'image') {
                                            //Sin Acciones
                                        }else{
                                            if($product->proroga == 0)
                                                echo 'Esta tarea no tiene opcion a prorroga, fecha maxima de entrega: '.$product->date_event.'.</br>';
                                            else
                                                echo 'Esta tarea tiene opcion a prorroga, consulte con el administrador</br>';
                                            
                                            if($product->porcentaje == 0)
                                                echo '';
                                            else
                                                echo '<div class="form-group has-error">
                                                          <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Fecha Maxima de entrega: '.$product->date_event.'. El inclumplimiento de la fecha maxima, genera un '.$product->porcentaje.'% de descuento del salario basico. </label>
                                                      </div>'; 
                                        }
                                        echo $estilo.'</br>'; 
                                        if($product->vistas == 0)
                                            $info = 'No ha sido verificado por: '.$nombre.'</br>';
                                        else
                                            $info = 'Verificado '.$product->vistas.' veces</br>';
                                        
                                        if($product->body != ''){
                                            echo '<div class="direct-chat-msg">';
                                                echo '<div class="direct-chat-info clearfix">';
                                                    echo '<span class="direct-chat-name pull-left">'.$info.'</span>';
                                                    echo '<span class="direct-chat-timestamp pull-right"> <i class="fa fa-clock"></i> Reportada el: '.$product->created_at.'</span>';
                                                echo '</div>';
                                                echo '<img class="direct-chat-img" src="assets/images/avatar/user01.png" alt="message user image">';
                                                echo '<div class="direct-chat-text">';
                                                    echo $product->body;
                                                echo '</div>';
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                    if($product->body != '')
                                        $comentario = 'Modificar tarea';
                                    else
                                        $comentario = 'Finalizar tarea';
                                        
                                    echo '<div class="timeline-footer">';
                                        if($product->type == 'image')
                                            if($product->prioridad == 2)
                                                echo '<p>Ya fue procesada su solicitud</p>';
                                            else
                                                echo '<a class="btn btn-primary btn-xs" href="index.php?view=autoriza&id='.$product->id.'"><i class="fa fa-fa-thumbs-o-up"> </i> Autorizar Solicitud</a>&nbsp;&nbsp;';
                                        else
                                            echo '<a class="btn btn-primary btn-xs" href="index.php?view=ma.edittask&id='.$product->id.'"><i class="fa fa-fa-thumbs-o-up"> </i>'.$comentario.'</a>&nbsp;&nbsp;';
                                    echo '</div>';
                                echo '</div>';
                            echo '</li>';
                		}
                		echo '<li>';
                            echo '<i class="fa fa-clock bg-gray"></i>';
                        echo '</li>';
                	echo '</ul>';
                echo '</div>';
            echo '</div>';
        }
	}
echo '</section>';
?>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Panel de Control";
</script>