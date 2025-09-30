<?php
// Visualicacion de la Bitacora Electronica
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

$users = BitacoraData::getEtapa($cadena, $_SESSION["puesto"]);
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
			<div id="myProgress">
				<div id="myBar"></div>
			</div>
			<div id="content">
				<span id="minuto"></span> minutos,  <span id="segundo"></span> segundos
			</div>
            <div class="box">
				<div class="box-header with-border"> 
						<button onclick="actualizar()">Actualizar</button>
				</div>
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<form id='frmC' name='frmC' method='post' action=''>
						<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
						<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
                        <table id="viewBitacora" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="8%"><div align="center">Ingreso</div></th>
                                    <th width="8%"><div align="center">Codigo</div></th>
                                    <th>Observaci&oacute;n</th>
                                    <th><div align="center">Reportado por</div></th>
                                    <th width="8%" align="center">Punto GPS</div></th>
                                    <th width="12%"><div align="center">Acci&oacute;n</div></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php
									// Crea tabla de Ventas
									foreach($users as $tables){
										$ruta = '';
										if($tables->proceso == "Observacion") $ruta = 1;
										if($tables->proceso == "Supervicion") $ruta = 5;
										if($tables->proceso == "Inreso" || $tables->proceso == "Salida") $ruta = 2;
										
										echo '<tr>';
											echo '<td><div align="center">'.$tables->fecha.'</div></td>';
											echo '<td>';											
												if($tables->manzana == ""){
													echo 'S/N';
												}else{
													echo '<small>';
														echo '<span class="text-success">Mz '.$tables->manzana.' V '.$tables->villa.'</span>';
													echo '</small>';
												}
											echo '</td>';
											echo '<td>';
												echo $tables->observacion;
											echo '</td>';
											echo '<td>';
												echo $tables->lastname.' '.$tables->name.'</br>';
												echo '<small>';
													if($tables->vistas == 0){
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Este evento no ha sido verificado</span>';
													}else{
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Este evento se a visto '.$tables->vistas.' veces</span>';
													}
												echo '</small>';
											echo '</td>';
											if($tables->mensaje == "")
												echo '<td><a class="text-primary" href="index.php?view=mapas&lat='.$tables->latitude.'&lot='.$tables->longitude.'">'.$tables->latitude.', '.$tables->longitude.'</a></div></td>';
											else
												echo '<td>'.$tables->mensaje.'</td>';
											echo '<td>';
												  echo '<div align="center">';
													echo '<a href="index.php?view=verificar&id='.$tables->id.'&ruta='.$ruta.'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
														  <button type="button" class="btn btn-success btn-sm" onClick="btn_Imprimir('.$tables->id.')"><i class="fa fa-print"></i></button>';
												  echo '</div>';
											echo '</td>';
										echo '</tr>';
									}
                                ?>
                            </tbody>
                        </table>
                    </form>
                
            </div>
        </div>
    </div>
</section>
<!-- Page specific script -->
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Bitacora Electronica";
		
	//Función para actualizar cada 5 segundos(5000 milisegundos)
	barras();
	
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
	
	//Función actualizar
	function barras(){
		const element = document.getElementById("myBar");   
		let width = 0;
		const id = setInterval(frame, 1000);
		  
		function frame() {		
			// Inserta los segundos almacenados en clock en el span con id segundo
			minutos = document.getElementById('minuto');		
			segundos = document.getElementById('segundo');			
			
			if (width == 100) {
				clearInterval(id);
				actualizar();
			} else {
				if(width == 0){
					minuto = 1; tiempo = 60;
				}
				if(tiempo == 0){
					minuto--; tiempo = 60;
				}
				width++; tiempo--;	
				element.style.width = width + '%'; 	
				
				minutos.innerHTML = minuto;
				segundos.innerHTML = tiempo;
			}
		}
	}
	
	function actualizar(){
		location.reload(true);
	}
</script>

