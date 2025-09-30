<?php
// Visualicacion de la Bitacora Electronica

date_default_timezone_set('America/Guayaquil');
$mes = date("m"); $ano=date("Y");
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

$users = BitacoraData::getAll($cadena);

if(isset($_GET['mes'])){
	$mes=$_GET['mes'];
	$_SESSION['mes']=$mes;
}else{
	if(isset($_SESSION['mes']) && $_SESSION['mes'] > 1){
		$mes=$_SESSION['mes'];
	}else{
		$_SESSION['mes']=$mes;
	}
}

$puestos = PuestoData::getAll(2); $lugar = '';

If(isset($_POST["sd"])){
    $_SECCION["LOC"]=$_POST["id_localidad"];
    $_SECCION["INI"]=$_POST["sd"];
    $_SECCION["FIN"]=$_POST["ed"];
}else{
    $_SECCION["LOC"]=0;
    $_SECCION["INI"]="";
    $_SECCION["FIN"]="";
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora Electronica
		<small>listado de las observaciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
        		<div class="box-header with-border">
        		    <div class="row">
                		<div class="col-xs-3">
                			<div class="input-group">
                			<div class="input-group-addon">
                				<i class="fa fa-calendar"></i>
                			 </div>
                			  <input type="text" class="form-control pull-right" value="01/04/2025 - 03/04/2025" id="range" readonly="">
                			  
                			</div><!-- /input-group -->
                		</div>
                		<div class="col-xs-2">
                			<select id="status" class="form-control" onchange="load(1);">
                				<option value="">Estado </option>
                				<option value="0">Pendiente </option>
                				<option value="1">Aceptada </option>
                				<option value="2">Rechazada </option>
                			</select>
                		</div>
                    </div>
        		</div>
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
                    <table id="viewBitacora" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><div align="center">Ingreso</div></th>
                                <th width="8%"><div align="center">Codigo</div></th>
                                <th>Nombre Completos</th>
                                <th width="8%"><div align="center">Punto GPS</div></th>
                                <th width="8%"><div align="center">Turno</div></th>
                                <th width="8%"><div align="center">Proceso</div></th>
                                <th width="30%"><div align="center">Observaci&oacute;n</div></th>
                                <th width="8%"><div align="center">Acci&oacute;n</div></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
								// Crea tabla de Ventas
								foreach($users as $tables){
									$ruta = '';
									if($tables->proceso == "Observacion") $ruta = 1;
									if($tables->proceso == "Ingreso" || $tables->proceso == "Salida") $ruta = 2;
									if($tables->proceso == "Alerta") $ruta = 3;
									if($tables->proceso == "Supervicion") $ruta = 5;
									if($tables->proceso == "Rondas") $ruta = 6;
									if($tables->proceso == "Visitas") $ruta = 7;
									if($tables->proceso == "Custodia") $ruta = 8;
									
									echo '<tr>';
										echo '<td><div align="center">'.$tables->fecha.'</div></td>';
										echo '<td>'.$tables->descripcion.'</td>';
										echo '<td>';
											if($tables->usuario_log == "Residente"){
												$residente = ResidenteData::getById($tables->idperson);
												echo substr($residente->nombre, 0, 20).'<br>';
												echo '<small>';
													if($residente->telefono1 != '') echo '<span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$residente->telefono1.'&nbsp;';
													if($residente->telefono2 != '') echo '- <span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$residente->telefono2;
												echo '<small><br>';
											}else{
										    	echo substr($tables->name, 0, 20).'<br>';												
												echo '<small>';
													if($tables->phone1 != '') echo '<span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$tables->phone1.'&nbsp;';
													if($tables->phone2 != '') echo '- <span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$tables->phone2;
												echo '<small><br>';
											}
												if($tables->vistas == 0){
													echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
													echo '<span class="text-danger">Este evento no ha sido verificado</span>';
												}else{
													echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
													echo '<span class="text-success">Este evento se verifico '.$tables->vistas.' veces</span>';
												}
											echo '</small>';
										echo '</td>';
										if($tables->latitude == "")
											if(strlen($tables->mensaje) == 0)
												echo '<td>'.$tables->mensaje.'</td>';
											else
												echo '<td>GPS Desconectado</td>';
										else											
											echo '<td><div align="center"><a class="text-primary" href="index.php?view=mapas&lat='.$tables->latitude.'&lot='.$tables->longitude.'">'.$tables->latitude.', '.$tables->longitude.'</a></div></td>';

										echo '<td>'.$tables->turno.'</td>';
										if($tables->proceso == 'Alerta' || $tables->proceso == 'Salida' || $tables->proceso == 'Ingreso'){
											$activo = ' disabled';
											if($tables->proceso == 'Alerta')
										        echo '<td><span class="text-danger">'.$tables->proceso.' S.O.S.</span></td>';
										    else
										        echo '<td>'.$tables->proceso.'</td>';
										}else{
											$activo = '';
										    echo '<td>'.$tables->proceso.'</td>';
										}
										echo '<td>';
											echo trim($tables->observacion);
											if($tables->observaciono == ""){
												// Sin Observacion
											}else{
											    echo '. Logistica: '.substr($tables->observaciono,-60, -2).'.';
											}
											if($tables->manzana == ""){
												// Sin Observacion
											}else{
												echo '<br><small>';
													echo '<span class="glyphicon glyphicon-Home text-success"></span>&nbsp;';
													echo '<span class="text-success">Manzana '.$tables->manzana.' - Villa '.$tables->villa.'</span>';
												echo '</small>';
											}
										echo '</td>';
										echo '<td>';
											  echo '<div align="center">';
												echo '<button type="button" class="btn btn-success btn-sm'.$activo.'" onClick="btn_Imprimir('.$tables->id.')"><i class="fa fa-print"></i></button>
													  <a href="index.php?view=info&id='.$tables->id.'&ruta='.$ruta.'" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
											  echo '</div>';
										echo '</td>';
									echo '</tr>';
								}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page specific script -->
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Bitacora Electronica";
    setInterval("location.reload()", 30000);
	
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/novedad_pdf.php?id='+$id,'Reporte de Bitacora','','1024','768','true');
	}
	
	function btn_Lista() {
		var valor1 = document.getElementById('localidad');
		var valor2 = document.getElementById('turno');
		var valor3 = document.getElementById('sd');
		var valor4 = document.getElementById('sm');

		puesto = valor1.value;
		turno = valor2.value;
		sd = valor3.value;
		sm = valor4.value;

		VentanaCentrada('documentos/bitacora_pdf.php?id='+puesto+'&turno='+turno+'&ini='+sd+'&fin='+sm,'Reporte de Bitacora','','1024','768','true');
	}
</script>

