<?php
// Vista del Panel de control
if($_SESSION['depart'] == 7) $_SESSION['ventas']=1;
if($_SESSION['idrol']==7) print "<script>window.location='index.php?view=novedad';</script>";
if($_SESSION['idrol']==9) print "<script>window.location='index.php?view=autorizan';</script>";
if($_SESSION['idrol']==10) 
	if($_SESSION['depart'] == 3)	
		print "<script>window.location='index.php?view=opeasi.personal';</script>";
	else
		print "<script>window.location='index.php?view=rrging.persons';</script>";

if($_SESSION['idrol']==11) print "<script>window.location='index.php?view=aspirantes';</script>";
if(isset($_GET['error'])) Core::alert("Error...!!!!", "No tiene permisos suficientes para esta accion...!!!", "error");
if(isset($_GET['id'])) $_SESSION['id_company'] = $_GET['id'];

$_SESSION['ano'] = date("Y");
$ano=date("Y"); $mes=date("m");

$ini=$ano."-".$mes."-01";
$total=date("t", strtotime($ini));
$fin=$ano."-".$mes."-".$total;
$fechas = PersonData::getByDate($mes);
$empresas = ClientData::getAll(0, 1);

if($_SESSION['is_admin']=='1')
	$events = TimelineData::getAll(); // Listado de administradores
else
	$events = TimelineData::getById($_SESSION['user_id']);

//var_dump($_SESSION); ?>
<style>
    .mi-celda {
       background-color:  #777799 !important;
       font-weight: bold;
    }
</style>

<?php
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
						echo '<h3>'.count(ClientData::getTotal()).'</h3>';
						echo '<p>Total de Clientes</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="fa fa-shopping-cart"></i>';
					echo '</div>';
					echo '<a href="index.php?view=catcli.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
						echo '<i class="ion ion-bag"></i>';
					echo '</div>';
					echo '<a href="index.php?view=catpus.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-3 col-xs-6">';
					echo '<div class="small-box bg-red">';
					echo '<div class="inner">';
						echo '<h3> $ '.number_format($monto, 2, ',', '.').'</h3>';
						echo '<p>Total de Nomina</p>';
					echo '</div>';
					echo '<div class="icon">';
						echo '<i class="ion ion-pie-graph"></i>';
					echo '</div>';
					echo '<a href="index.php?view=caja" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
					echo '</div>';
				echo '</div>';
		}else{
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
						echo '<a href="./index.php?view=opehor.planificado" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
						echo '<a href="./index.php?view=opehor.activos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
							echo '<a href="./index.php?view=rrsing.persons" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
						echo '</div>';
					echo '</div>';
					echo '<div class="col-lg-3 col-xs-6">';
						echo '<div class="small-box bg-red">';
							echo '<div class="inner">';
								echo '<h3>'.count(PuestoData::getByFaltas()).'</h3>';
								echo '<p>Total de Faltas</p>';
							echo '</div>';
							echo '<div class="icon">';
								echo '<i class="ion ion-pie-graph"></i>';
							echo '</div>';
							echo '<a href="./index.php?view=opefal.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
						echo '</div>';
					echo '</div>';
			}else{	
				switch ($_SESSION['depart']) {
					case 3:
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getAllTipo(3, 1)).'</h3>'; 
									echo '<p>Agentes Activos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=opehor.activos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
								echo '<a href="./index.php?view=opeasp.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
									echo '<a href="./index.php?view=catpus.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-lg-3 col-xs-6">';
								echo '<div class="small-box bg-red">';
									echo '<div class="inner">';
										echo '<h3>'.count(PuestoData::getByFaltas()).'</h3>';
										echo '<p>Total de Faltas</p>';
									echo '</div>';
									echo '<div class="icon">';
										echo '<i class="ion ion-pie-graph"></i>';
									echo '</div>';
									echo '<a href="./index.php?view=opefal.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
								echo '</div>';
							echo '</div>';
						break;
					case 4: // Area Comercial
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(ProductData::getAll()).'</h3>';
									echo '<p>Nuevos pedidos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-shopping-cart"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=products" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getClients()).'</h3>';
									echo '<p>Registrar clientes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-person-add"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=agentes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>52%</h3>';
									echo '<p>Porcentaje de Ventas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-bag"></i>';
								echo '</div>';
									echo '<a href="./index.php?view=catpus.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
								echo '<div class="small-box bg-red">';
									echo '<div class="inner">';
										echo '<h3>'.count(DepartamentoData::getAll()).'</h3>';
										echo '<p>Departamentos</p>';
									echo '</div>';
									echo '<div class="icon">';
										echo '<i class="ion ion-pie-graph"></i>';
									echo '</div>';
									echo '<a href="./index.php?view=departamento" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
								echo '</div>';
							echo '</div>';
						break;
					case 6: // Inicio RRHH
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>Liquidaci&oacute;n</h3>';
									echo '<p>Planilla de Liquidaci&oacute;n</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-briefcase"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=rrhliq.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getClients()).'</h3>';
									echo '<p>Total de Agentes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=rrging.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
								echo '<h3>'.count(DepartamentoData::getAll()).'</h3>';
								echo '<p>Total de Departamentos</p>';
							echo '</div>';
							echo '<div class="icon">';
								echo '<i class="ion ion-bag"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=catdep.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
								echo '<h3>'.count(CargoData::getAll()).'</h3>';
								echo '<p>Total de Cargos</p>';
							echo '</div>';
							echo '<div class="icon">';
								echo '<i class="ion ion-pie-graph"></i>';
								echo '</div>';
								echo '<a href="./cargos" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						break;
					case 9: // Uso de las residencias
						$hoy = date("Y-m-d"); $cadena = "";

						if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
						if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

						// Listado de las bitacoras					
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByTipo($_SESSION['id_client'], $cadena, 'Taxi')).'</h3>'; 
									echo '<p>Total de Taxi</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-aqua">';
								echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByTipo($_SESSION['id_client'], $cadena, 'Visita')).'</h3>';
									echo '<p>Total de visitas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-fax"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
								echo '<div class="small-box bg-yellow">';
									echo '<div class="inner">';
									echo '<h3>'.count(BitacoraData::getByTipo($_SESSION['id_client'], $cadena, 'Entrega')).'</h3>';
									echo '<p>Total de entregas</p>';
									echo '</div>';
									echo '<div class="icon">';
										echo '<i class="ion ion-home"></i>';
									echo '</div>';
									echo '<a href="./index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-lg-3 col-xs-6">';
								echo '<div class="small-box bg-red">';
									echo '<div class="inner">';
										echo '<h3>'.count(BitacoraData::getByTipo($_SESSION['id_client'], $cadena, 'Otros')).'</h3>';
										echo '<p>Total de Otros</p>';
									echo '</div>';
									echo '<div class="icon">';
										echo '<i class="ion ion-pie-graph"></i>';
									echo '</div>';
									echo '<a href="./index.php?view=fechas" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
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
								echo '<a href="./index.php?view=catart.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-purple">';
								echo '<div class="inner">';
									echo '<h3>'.count(PersonData::getClients()).'</h3>';
									echo '<p>Compras Realizadas</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="fa fa-user"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=agentes" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-yellow">';
								echo '<div class="inner">';
									echo '<h3>'.count(PuestoData::getAll(2)).'</h3>';
									echo '<p>Puestos</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-bag"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=catpus.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-3 col-xs-6">';
							echo '<div class="small-box bg-red">';
								echo '<div class="inner">';
									echo '<h3>'.count(CategoryData::getAll()).'</h3>';
									echo '<p>Clientes</p>';
								echo '</div>';
								echo '<div class="icon">';
									echo '<i class="ion ion-pie-graph"></i>';
								echo '</div>';
								echo '<a href="./index.php?view=catcli.lista" class="small-box-footer">Ver mas <i class="fa fa-arrow-circle-right"></i></a>';
							echo '</div>';
						echo '</div>';
				}
			}
		}
	echo '</div>';

    if($_SESSION['depart'] == 4){ ?>
        <div id="contratos" class="tab-pane active">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Historial de contratos</h3>
				</div>
				<div class="table-responsive panel-collapse pull out">            
					<table id="tusuarios" class="table table-hover table-bordered table-striped" style="background-color:white;">            
						<thead>
							<tr class="mi-celda">
								<th><b>ASESOR</b></th>
								<th><b>CLIENTE</b></th>
								<th><b>CARGA</b></th>
								<th><b>SERVICIO</b></th>
								<th><b>LUGAR DE INICIO</b></th>
								<th><b>LUGAR DE DESTINO</b></th>
								<th><b>HORRA DE ARRANQUE</b></th>								
								<th><b>STATUS</b></th>
							</tr>            
						</thead>            
						<tbody>            
							<tr>            
								<td> 
									<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/138738/"><i class="glyphicon glyphicon-eye-open"></i></a>
									<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120892512')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/138738/"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
								<td>1120892512</td>
								<td>Retención</td>
								<td>351</td>
								<td>351</td>
								<td>1120892512</td>
								<td>Retención</td>
								<td>351</td>
							</tr>            
							<tr>
								<td>
									<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137529/"><i class="glyphicon glyphicon-eye-open"></i></a>
									<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120677683')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137529/"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
								<td>1120677683</td>
								<td>Retención</td>
								<td>000000301</td>
								<td>351</td>
								<td>1120892512</td>
								<td>Retención</td>
								<td>351</td>
							</tr>            
							<tr>
								<td>
									<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137731/"><i class="glyphicon glyphicon-eye-open"></i></a>
									<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120677683')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137731/"><i class="glyphicon glyphicon-pencil"></i></a>
								</td>
								<td>1120677683</td>
								<td>Venta</td>
								<td>201</td>
								<td>351</td>
								<td>1120892512</td>
								<td>Retención</td>
								<td>351</td>
							</tr>            
						</tbody>            
					</table>            
				</div>
			</div>
		</div> 
		<!-- Fin de Listado --><?php
    } 
	// RRHH - Adicionales solo para Recursos Humanos
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
												echo '<td><small>'.$tables->nombre.'</br><label><div class="text-red"><i class="fa fa-bell-o"></i> Estado: '.$tables->estado.' por '.$tables->usuario_log.'</div></label></td>'; //  <i class="fa fa-check"></i> Generado por: '.$tables->usuario_log.'
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
		</div><?php 
	} 
	
	// Listado de las empresas que se terminan
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
							// Crea tabla de Empresas
							foreach($empresas as $tables) {
								$now = time();
								$date = strtotime($tables->fechafin);
								 
								$diff_in_days = floor(($date - $now) / (60 * 60 * 24));
								
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
		</div>
	<?php } 
	
	// RRHH - Listado de Cumpleanos
	if($_SESSION['idrol'] == 6){ ?>
		<!-- Listado de Cumpleanos -->
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
							// Crea tabla de cumpleaños
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
									echo '<td>'.utf8_encode($tables->name).'</td>';
									echo '<td>'.$tables->email.'</td>';
									echo '<td>'.$tables->phone1.'</td>';
									echo '<td><div align="center">'.$startwork.'</div></td>';
									echo '<td><div align="center">'.$fechanacimiento.'</div></td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	<?php	// No hay acciones
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
			
			if(count($products)>0){?>
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

if(!isset($_SESSION["client_id"])): ?>
	<div class="box box-solid">
		<div class="box-header ui-sortable-handle bg-green-gradient">
			<i class="fa fa-th"></i>
			<h3 class="box-title">Listado de Tareas</h3>			
		</div>
		<div class="box-header with-border">
			<a href="index.php?view=sisnot.task" id="btn_productos" class="btn btn-success btn-sm">
				<span class="glyphicon glyphicon-plus"></span> Ingresar una Tarea
			</a>
		</div>
		<div class="box-body">
			<table id="viewlista" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="8%"><div align="center">Fecha Maxima</div></th>
						<th>Tareas</th>
						<th width="20%">Responsable</th>
						<th width="10%">Status</th>
						<th width="10%"><div align="center">Solicitado el</div></th>
						<th width="10%"><div align="center">Terminado el</div></th>
					</tr>
				</thead>
				<tbody>
					<?php
						// Crea tabla de Tareas
						foreach($events as $product) {
							$nombre = '';
							echo '<tr>';
								echo '<td>';
									echo '<div align="center"><a class="text-primary" href="index.php?view=ma.edittask&id='.$product->id.'">'.$product->date_event.'</a></div>';
								echo '</td>';
								if($product->prioridad == 0) $prioridad = '<div class="text-green"><i class="fa fa-bell-o"></i> Prioridad: Baja</div>';
								if($product->prioridad == 1) $prioridad = '<div class="text-yellow"><i class="fa fa-bell-o"></i> Prioridad: Media</div>';
								if($product->prioridad == 2) $prioridad = '<div class="text-red"><i class="fa fa-bell-o"></i> Prioridad: Alta</div>';
								
								echo '<td>'.$product->title.'</br>'.$prioridad.'</td>'; //&#9733; &#9733; &#9733; &#9733; &#9733;
								if($product->idperson > 0){
									$nombre = UserData::getById($product->idperson)->name.' '.UserData::getById($product->idperson)->lastname;
								}
								echo '<td>'.$nombre.'</td>';
								echo '<td>';
										echo '<small>';
											if($product->status == 1){
												echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
												echo '<span class="text-danger">Pendiente</span>';
											}else{
												echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
												echo '<span class="text-success">Ejecutado</span>';
											}
										echo '</small>';
								echo '</td>';
								echo '<td>';
									echo '<div align="center">'.$product->created_at.'</div>';
								echo '</td>';
								echo '<td>';
									echo '<div align="center">'.$product->date_pass.'</div>';
								echo '</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div> <?php
endif;
echo '</section>';
?>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Panel de Control";
</script>