<?php
// Control de Nomina
if(isset($_GET['id'])){	
	$control = new InformeData();	
	$control->id = $_GET['id'];
	$control->estado = $_GET['estado'];
	$valor = $control->control();
}

$_SESSION['cotizar'] = 0;
?>
<!-- Listado de las informes generadas -->
<section class="content-header">
    <h1>
        Informes
        <small>reporte de los puestos</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Informes </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section><!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=informar">
				<span class="glyphicon glyphicon-plus"></span> Nuevo informe
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<div> 
				<table id="viewBitacora" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="width: 10%"><div align="center">Generada</div></th>
							<th><div align="center">Cliente</div></th>
							<th style="width: 16%"><div align="center">Eventos</div></th>
							<th style="width: 16%"><div align="center">Estado</div></th>
							<th style="width: 12%"><div align="center">Modificado el</div></th>
						</tr>
					</thead>
					<tbody> 
						<?php
							$users = InformeData::getAll();				

							$resultado = count($users);
							$j=1; $subtotal=0;

							if($resultado > 0){
								foreach($users as $tables) {
									echo '<tr>';
										echo '<td><div align="center">'.$tables->oficio.'</div></td>';
										echo '<td><small>'.$tables->contacto.'</br>'.$tables->lugar.'</br>Generado por: '.$tables->usuario_log.'</small></td>';
										echo '<td><div align="center">2</div></td>';										
										echo '<td><small>';
											if ($tables->status == "Borrador") echo '<a href="index.php?view=informar&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>';										
											echo '<button type="button" class="btn btn-info btn-sm" onClick="btn_Imprimir('.$tables->id.')"><i class="fa fa-print"></i></button>';
											echo '</br>&nbsp;&nbsp;'.$tables->status;
										echo '</small></td>'; 
										echo '<td><div align="center">'.$tables->update_at.'</div></td>';
									echo '</tr>';
									
									$subtotal=0;
								}
							}
						?>
					</tbody>
				</table> 
			</div>
		</div>
	</div>
</section>
<!-- Page specific script --><!-- Page specific script -->
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de cotizaciones";
	
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/cotizacion_pdf.php?id='+$id,'Reporte de Bitacora','','1024','768','true');
	}
	
	function btn_EnviarOnClick($id, $is_active) {
		 var valor = <?php echo $_SESSION['is_admin']; ?>;

		 if(valor == "0"){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
		 	if($is_active == "1"){
		 	     swal("Pagado", "La nomina esta pagada", "error");
			}else {
				swal({
				   title: "Esta usted seguro?",
				   text: "Se va actualizar el registro de la nomina seleccionada...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, cambiar...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				},
				function(isConfirm){
				   if (isConfirm) {					   
						window.location.href = "./index.php?view=cotizar&id="+$id;
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
			}
		 }

	} //--
</script>
