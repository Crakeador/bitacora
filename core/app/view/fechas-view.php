<?php
// Reporte de Bitacora de los propietarios 
date_default_timezone_set('America/Guayaquil');
$mes = date("m"); $ano=date("Y");

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
// Visualicacion de la Bitacora Electronica
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

// Listado de las observaciones
$users = BitacoraData::getByClient($_SESSION['id_client'], $cadena);
$puestos = PuestoData::getByIdTodos($_SESSION['id_client']);

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
<section class="content-header">
	<h1>
		Bitacora
		<small>novedades del mes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-book"></i> Panel de Control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<input type='hidden' name='hid_cliente' id='hid_cliente' value='<?php echo $_SESSION['id_client']; ?>'/>
					<table id="viewBitacora" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><div align="center">Ingreso</div></th>
								<th width="8%"><div align="center">Codigo</div></th>
								<th width="8%"><div align="center">Turno</div></th>
								<th>Nombre del Guardia</th>
								<th width="30%"><div align="center">Observaci&oacute;n</div></th>
								<th width="8%"><div align="center">Acci&oacute;n</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								// Crea tabla de Ventas
								foreach($users as $tables) {
									echo '<tr>';
										echo '<td><div align="center">'.$tables->fecha.'</div></td>';
										echo '<td>'.$tables->codigo.'</td>';
										echo '<td>'.$tables->turno.'</td>';
										echo '<td>';
											echo utf8_encode($tables->lastname).' '.utf8_encode($tables->name).'</br>';
										echo '</td>';
										echo '<td>'.$tables->observacion.'</td>';
										echo '<td>';
											  echo '<div align="center">';
														echo '<a href="index.php?view=info&id='.$tables->id.'&ruta=4" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
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
    document.title = "Near Solution | Reporte de Novedades";
	
	function btn_Imprimir(cliente) {
		var valor1 = document.getElementById('localidad');
		var valor2 = document.getElementById('turno');
		var valor3 = document.getElementById('sd');
		var valor4 = document.getElementById('sm');	  

		puesto = valor1.value;
		turno = valor2.value;
		sd = valor3.value;
		sm = valor4.value;		
	  
		VentanaCentrada('documentos/fechas_pdf.php?cliente='+cliente+'&id='+puesto+'&turno='+turno+'&ini='+sd+'&fin='+sm,'Reporte de Bitacora','','1024','768','true');
	}
</script>
