<?php
// Visualicacion de la Bitacora Electronica

date_default_timezone_set('America/Guayaquil');
$mes = date("m"); $ano=date("Y");
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND A.created_at BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND A.created_at BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

$users = NovedadData::getAll($cadena);

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
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
                    <table id="viewBitacora" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="12%"><div align="center">Ingreso</div></th>
                                <th width="8%"><div align="center">Codigo</div></th>
                                <th width="8%"><div align="center">Turno</div></th>
                                <th>Observaci&oacute;n</th>
                                <th width="30%"><div align="center">Acci&oacute;n Tomada</div></th>
                                <th width="8%"><div align="center">Acci&oacute;n</div></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
								// Crea tabla de Ventas
								foreach($users as $tables){
									echo '<tr>';
										echo '<td><div align="center">'.$tables->created_at.'</div></td>';
										echo '<td>'.$tables->descripcion.'</td>';
										echo '<td>'.$tables->turno.'</td>';
										echo '<td>';
										    echo substr($tables->observacion, 0, 20).'<br>';
												if($tables->vistas == 0){
													echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
													echo '<span class="text-danger">Este evento no ha sido verificado</span>';
												}else{
													echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
													echo '<span class="text-success">Este evento se verifico '.$tables->vistas.' veces</span>';
												}
											echo '</small>';
										echo '</td>';
										echo '<td>';
											echo trim($tables->accion);
											if($tables->observaciono == ""){
												// Sin Observacion
											}else{
											    echo '. Logistica: '.substr($tables->observaciono, 0, -3).'.';
											}
										echo '</td>';
										echo '<td>';
											  echo '<div align="center">';
												echo '<button type="button" class="btn btn-success btn-sm'.$activo.'" id="imprimir" title="Imprimir" onClick="btn_Imprimir('.$tables->id.')"><i class="fa fa-print"></i></button>
													  <a href="index.php?view=info&id='.$tables->id.'&ruta='.$ruta.'" title="informa" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
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
    document.title = "SIDAI | Bitacora Electronica";
	
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

