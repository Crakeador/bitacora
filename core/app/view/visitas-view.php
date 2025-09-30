<?php 
//var_dump($_SESSION);
$validos = AutorizanData::getClient(1);

// Crea tabla de Permisos autorizados
foreach($validos as $tables){
	$date1 = new DateTime($tables->ini_fec);
	$date2 = new DateTime("now");
	$diff = $date1->diff($date2);
	
	if(strval($diff->days) > 0){
		$client = new AutorizanData();	
		$client->id = $tables->id;
		$valor = $client->anular();
	}
}

if(isset($_GET['clave'])){	
	echo '<script src="plugins/sweetalert/sweetalert.min.js"></script>
		  <script type="text/javascript">
			swal({
				title: "Nuevo registro",
				text: "Se genero la clave de acceso: '.$_GET['clave'].', comparta esta clave con su visita...!!!",
				icon: "success",
				buttons: true,
				dangerMode: true
			});	
		  </script>';
}

if(isset($_GET['id'])){	
	$client = new AutorizanData();	
	$client->id = $_GET['id'];
	$valor = $client->del();
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
		<div class="box-header with-border">
			<div class="callout callout-danger" style="margin-bottom: 0!important;">
				<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
				<span class="text-danger">*</span>Despues de las 22:00 horas se debe de llamar a cualquier visita autorizada por los residentes<br>		
				<span class="text-danger">*</span>No dar ningun evento como efectivo, sin ser verificado	
			</div>
		</div>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
			    	 <tr>
						<th width="12%">Autorizado el</th>
						<th width="12%">Caduca en</th>
    					<th width="10%">C.C.</th>
						<th>Nombres y Apellidos</th>
						<th width="8%">Clave</th>
						<th>Observaci&oacute;n</th>
    					<th width="8%">Acciones</th>
					 </tr>
					</thead>
					<tbody>
						<?php
							$permiso = AutorizanData::getPuesto(1);

							// Crea tabla de Permisos autorizados
							foreach($permiso as $tables) {
								$anadir_minutos = 240;

								$now = new DateTime($tables->ini_fec);
								$now->add(new DateInterval('PT' . $anadir_minutos . 'M'));

								$expDate = $now->format('Y-m-d H:i').':00';
								
								echo '<tr>';
									echo '<td align="center">'.$tables->ini_fec.'</td>';
									echo '<td align="center">'.$expDate.'</td>';
									echo '<td><div align="center">'.$tables->cedula.'</div></td>';
									echo '<td>'.$tables->nombre.'</br>Mz. '.$tables->manzana.', Villa '.$tables->villa.'</br>'.$tables->tipo.'</td>';
									echo '<td><div align="center">'.$tables->clave.'</div></td>';
									echo '<td>'.$tables->observacion.'</td>';									
									echo '<td><div align="center">';
											echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
									echo '</div></td>';									
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
					window.location.href = "index.php?view=autorizan&id="+$id;
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
						window.location.href = "index.php?view=autorizan&id="+$id;
			   } else {
					swal("Cancelado", "Se cancelo la activicion del registro", "error");
			   }
			 });
		}
	} //--
</script>