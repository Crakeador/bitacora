<?php
/* Control de Vehiculos
if(isset($_GET['id'])){	
	$control = new ControlData();	
	$control->id = $_GET['id'];
	$control->estado = $_GET['estado'];
	$valor = $control->control();
}

//$_SESSION['cotizar'] = 0; */
?>
<!-- Listado de las custodias -->
<section class="content-header">
    <h1>
        Listado de Vehiculos
        <small>listado de los vehiculos entregados</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Cotizaciones </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section>
<!-- Main content -->
<section class="content container-fluid" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border"><?php
    		if($_SESSION['idrol'] == 7) { ?>
    		    <a href="novedad" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-calendar"></i> Novedades </a>&nbsp;&nbsp; <?php
    		} ?>
		    <a id="btn_productos" class="btn btn-success btn-sm" href="recibo">
				<span class="glyphicon glyphicon-plus"></span> Nueva Entrega
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<table id="viewBitacora" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 6%"><div align="center">Nro.</div></th>
						<th><div align="center">Nombre del que Recibe</div></th>
						<th style="width: 10%"><div align="center">Fecha</div></th>
						<th style="width:  8%"><div align="center">Cedula</div></th>
						<th style="width:  8%"><div align="center">Kilometraje</div></th>
						<th style="width: 12%"><div align="center">Creada el</div></th>
						<th style="width: 10%"><div align="center">Estado</div></th>
					</tr>
				</thead>
				<tbody> 
					<?php
						$users = CustodiaData::getAll("Entregado");

						$resultado = count($users);
						$j=1; $subtotal=0;

						if($resultado > 0){
							foreach($users as $tables) {
								echo '<tr>';
									echo '<td><div align="center">'.$tables->id.'</div></td>';
									echo '<td><span class="badge bg-red">'.$tables->status.'</span>&nbsp;&nbsp;'.$tables->nombre.'&nbsp;&nbsp;(CHOFER)</br><small>Vehiculo: '.$tables->name.' ('.$tables->unit.') - Placa: '.$tables->serial.'</small></td>';
									echo '<td><div align="center">'.$tables->fecha.'</div></td>';
									echo '<td><div align="center">'.$tables->cedula.'</div></td>';
									echo '<td><div align="center">'.number_format($tables->kilometraje, 0, ',', '.').'</div></td>';
									echo '<td><div align="center">'.$tables->created_at.'</div></td>';
									echo '<td><div align="center"><small>';
										echo '<a href="index.php?view=recibo&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>'; 
										echo '<a href="index.php?view=entrega&id='.$tables->id.'" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-log-in"></i></a>'; 
										echo '<button type="button" class="btn btn-info btn-sm" onClick="btn_Entrega('.$tables->id.')"><i class="fa fa-print"></i></button>';
										echo '</small></div>';
									echo '</td>'; 
								echo '</tr>';
								
								$subtotal=0;
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<!-- Page specific script --><!-- Page specific script -->
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Registro de cotizaciones";

	function btn_Entrega($id) {
		VentanaCentrada('documentos/entregado_pdf.php?id='+$id,'Reporte de Entrega','','1024','768','true');
	}
	
	function btn_Recibe($id) {
		VentanaCentrada('documentos/recibido_pdf.php?id='+$id,'Reporte de Recepcion','','1024','768','true');
	}
	
	function btn_EnviarOnClick($id) {
		swal({
		   title: "Esta usted seguro?",
		   text: "Se va a entregar los equipos, entrego los permisos de las armas...?",
		   type: "warning",
		   showCancelButton: true,
		   confirmButtonColor: "#DD6B55",
		   confirmButtonText: "Si, entregue...!",
		   cancelButtonText: "No, llevan armas...!",
		   closeOnConfirm: false,
		   closeOnCancel: false
		},
		function(isConfirm){
		   if (isConfirm) {
				window.location.href = "conducta/"+$id;
				swal({
					  title: "Registro actualizado...!",
					  text: "Se actualizo el registro seleccionado.",
					  timer: 6000,

					  showConfirmButton: false
					});
		   } else {
		 	    swal("Cancelado", "Se cancelo la actualizacion del registro", "error");
		   }
		});
	} //--
</script>
