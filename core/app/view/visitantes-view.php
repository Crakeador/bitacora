<?php
// Visualicacion de la Bitacora Electronica

date_default_timezone_set('America/Guayaquil');
$mes = date("m"); $ano=date("Y");
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND A.created_at BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND A.created_at BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

?>
<!-- Listado de los clientes -->
<section class="content-header">
	<h1>
		Novedades
		<small>lista de novedades</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active"><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
		    Registro de Visitantes
		</div>
		<div class="box-body">
			<table id="viewBitacora" class="table table-bordered table-hover">
				<thead>
				 <tr>
					<th width="8%" style='text-align=center'>Entrada</th>
					<th width="8%">C.C.</th>
					<th>Nombres y Apellidos</th>
					<th>Puesto/Agente</th>
					<th>Observacion</th>
					<th width="8%" style='text-align=center'>Entrada</th>
					<th width="8%" style='text-align=center'>Salida</th>
				 </tr>
				</thead>
				<tbody>
					<?php
						$client = VisitantesData::getByBusqueda($_SESSION["puesto"], $cadena);
						
						// Crea tabla de Ventas
						foreach($client as $tables) {
						    echo '<tr>';
								echo '<td><div align="center">'.$tables->created_at.'</div></td>';
								echo '<td>';
									echo '<div align="center">';
										echo $tables->cedula.'&nbsp;&nbsp;';
									echo '</div>';
								echo '</td>';
								echo '<td>';
								    echo '<i class="fa fa-user"></i>&nbsp;'.$tables->nombre.'<br>';
								    echo '<small>';
								        echo '<span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$tables->placa.'&nbsp;';
									echo '</small>';
								echo '</td>';
								echo '<td>'.$tables->descripcion.'<br><small>'.$tables->usuario_log.'<small></td>';
								echo '<td>'.$tables->observacion.'</td>';
								echo '<td><div align="center"><span class="label label-success">'.$tables->created_at.'</span></div></td>';
								if($tables->is_active == 2){
								    echo '<td><div align="center"><span class="label label-success">'.$tables->update_at.'</span></div></td>';	
								}else{
								    echo '<td><div align="center"><span class="label label-danger">&nbsp;&nbsp;&nbsp;Salida Pendiente&nbsp;&nbsp;&nbsp;</span></div></td>';	
								}
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<!-- Page specific script -->
<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	function btn_EnviarOnClick($id, $is_active) {
		 var valor = <?php echo $_SESSION['is_admin']; ?>;

		 if(valor == "0"){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			if($is_active == "1"){
				 swal({
				   title: "Esta usted seguro?",
				   text: "No se puede recuperar el archivo despues de borrado...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, borralo...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				 },
				 function(isConfirm){
				   if (isConfirm) {					   
						window.location.href = "index.php?view=catres.lista&id="+$id;
						swal({
							  title: "Registro borrado...!",
							  text: "Se elimino el registro seleccionado.",
							  timer: 6000,
							  showConfirmButton: false
							});
				   } else {
						swal("Cancelado", "Se cancelo el borrado el registro", "error");
				   }
				 });
			}else{
				 swal({
				   title: "Esta usted seguro?",
				   text: "Se puede recuperar el archivo despues de borrado...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, recuperalo...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				 },
				 function(isConfirm){
				   if (isConfirm) {
						 swal({
							  title: "Registro recuperado...!",
							  text: "Se recupero el registro seleccionado.",
							  timer: 6000,
							  showConfirmButton: false
							});
							window.location.href = "index.php?view=catres.lista&id="+$id;
				   } else {
						swal("Cancelado", "Se cancelo la activicion del registro", "error");
				   }
				 });
			}
		}
	} //--
</script>