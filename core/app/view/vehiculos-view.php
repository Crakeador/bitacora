<?php
$users = OperationData::getVehiculos();
$resultado = count($users);

?>
<!-- Listado de las custodias -->
<section class="content-header">
    <h1>
        Vehiculos de la Empresa
        <small>listado de las vehiculos de la empresa</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Vehiculos </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section>
<!-- Main content -->
<section class="content container-fluid" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-body mailbox-messages">
			<table id="viewBitacora" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><div align="center">Tipo</div></th>
						<th><div align="center">Marca</div></th>
						<th><div align="center">Placa</div></th>
						<th style="width:  8%"><div align="center">Kilometraje</div></th>
						<th style="width: 10%"><div align="center">Comprado el</div></th>
						<th style="width: 10%"><div align="center">Estado</div></th>
					</tr>
				</thead>
				<tbody> 
					<?php
						if($resultado > 0){
							foreach($users as $tables) {
								echo '<tr>';
									echo '<td>'.$tables->name.'</td>';
									echo '<td><div align="center">'.$tables->unit.'</div></td>';
									echo '<td><div align="center">'.$tables->serial.'</div></td>';
									echo '<td><div align="center">'.number_format($tables->kilometraje, 0, ',', '.').'</div></td>';
									echo '<td><div align="center">'.$tables->created_at.'</div></td>';
									echo '<td><div align="center"><small>';
										echo '<a href="index.php?view=vehiculo&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>'; 
										echo '<a href="index.php?view=odometro&id='.$tables->id.'" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-log-in"></i></a>'; 
										echo '<button type="button" class="btn btn-info btn-sm" onClick="btn_Entrega('.$tables->id.')"><i class="fa fa-print"></i></button>';
										echo '</small></div>';
									echo '</td>'; 
								echo '</tr>';
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
    document.title = "SIDAI | Listado de Vehiculos";

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
