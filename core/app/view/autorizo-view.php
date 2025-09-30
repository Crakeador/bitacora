<?php 
if(isset($_GET['id'])){	
	echo '<script src="plugins/sweetalert/sweetalert.min.js"></script>
		  <script type="text/javascript">
			swal({
				title: "Nuevo registro",
				text: "Se genero la clave de acceso: '.$_GET['id'].', comparta esta clave con su visita...!!!",
				icon: "success",
				buttons: true,
				dangerMode: true
			});	
		  </script>';
}

?>
<!-- Listado de los clientes -->
<section class="content-header">
	<h1>
		Resientes
		<small>lista de las autorizaciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
			    	 <tr>
    					<th align="center" valign="middle" width="10%">C.C.</th>
						<th align="center" valign="middle">Nombres y Apellidos</th>
						<th align="center" valign="middle" width="8%">Clave</th>
						<th align="center" width="12%">Autorizado</th>
						<th align="center" valign="middle">Observaci&oacute;n</th>
					 </tr>
					</thead>
					<tbody>
						<?php
							$permiso = AutorizanData::getAll(0);

							// Crea tabla de Permisos autorizados
							foreach($permiso as $tables) {
								echo '<tr>';
									echo '<td><div align="center">'.$tables->cedula.'</br></div></td>';
									echo '<td>'.$tables->nombre.'</br>Mz. '.$tables->manzana.', Villa '.$tables->villa.'</br>'.$tables->tipo.'</td>';
									echo '<td><div align="center">'.$tables->clave.'</div></td>';
									echo '<td align="center">'.$tables->ini_fec.'</td>';
									echo '<td>'.$tables->observacion.'</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</form>
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
						window.location.href = "index.php?view=autorizo&id="+$id;
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
							window.location.href = "index.php?view=repdepartamento&id="+$id;
				   } else {
				 	    swal("Cancelado", "Se cancelo la activicion del registro", "error");
				   }
				 });
			 }
		 }
	} //--
</script>