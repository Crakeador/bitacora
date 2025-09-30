<?php 

if(isset($_GET["id"])){		
	$client = new ResidenteData();	
	$client->id = $_GET['id'];
	$valor = $client->del();
}

?>
<!-- Listado de los clientes -->
<section class="content-header">
	<h1>
		Resientes
		<small>lista de los residentes</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active"><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="residente">
				<span class="glyphicon glyphicon-plus"></span> Ingresar residente
			</a>
		</div>
		<!-- tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Activos</b></a>
			</li>
			<li>
				<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Inactivos</b></a>
			</li>
		</ul>
		<div class="box-body mailbox-messages">
			<!-- tabs content -->
			<div class="tab-content panel">
              	<div class="tab-pane active" id="tab_activos">
					<form id='frmC' name='frmC' method='post' action=''>
						<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
						<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
							 <tr>
								<th width="10%">C.C.</th>
								<th>Nombres y Apellidos</th>
								<th width="20%">Residente</th>
								<th>Direcci&oacute;n</th>
								<th>Clientes</th>
							 </tr>
							</thead>
							<tbody>
								<?php
									if($_SESSION['is_admin'] == "1"){
										$client = null;
									}else{
										$client = $_SESSION['id_client'];
									}
									$client = ResidenteData::getAll($client, 1);
									// Crea tabla de Ventas
									foreach($client as $tables) {
										if($tables->tipo == 1) $tipo = 'Residente'; else $tipo = 'Inquilino'; 						
										if($tables->is_active == 1) $activo = '<i class="fa fa-check"></i>'; else $activo = '<i class="fa fa-times"></i>'; 
										echo '<tr>';
											echo '<td>';
												echo '<div align="center">';
													echo $tables->cedula.'</br>';
													echo '<a href="index.php?view=catres.resumen&id='.$tables->idclient.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-eye-open"></i></a>';
													echo '<a href="index.php?view=catres.residents&id='.$tables->idclient.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>';
													echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idclient.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
												echo '</div>';
											echo '</td>';
											echo '<td>'.$tables->nombre.'</td>';
											echo '<td>'.$tipo.'</td>';
											echo '<td>Mz. '.$tables->manzana.', Villa '.$tables->villa.'</td>';									
											echo '<td>'.$tables->cliente.'</td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					</form>
				</div>
				<div class="tab-pane" id="tab_inactivos">
					<table id="viewInac" class="table table-bordered table-hover">
						<thead>
						 <tr>
							<th width="10%">C.C.</th>
							<th>Nombres y Apellidos</th>
							<th width="20%">Residente</th>
							<th>Direcci&oacute;n</th>
							<th>Acciones</th>
						 </tr>
						</thead>
						<tbody>
							<?php
								$client = ResidenteData::getAll(0);

								// Crea tabla de Ventas
								foreach($client as $tables) {
									if($tables->tipo == 1) $tipo = 'Residente'; else $tipo = 'Inquilino'; 						
									if($tables->is_active == 1) $activo = '<i class="fa fa-check"></i>'; else $activo = '<i class="fa fa-times"></i>'; 
									echo '<tr>';
										echo '<td><div align="center">'.$tables->cedula.'</br></div></td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td>'.$tipo.'</td>';
										echo '<td>Mz. '.$tables->manzana.', Villa '.$tables->villa.'</td>';									
										echo '<td><div align="center">';
												echo '<a href="index.php?view=catres.resumen&id='.$tables->idclient.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-eye-open"></i></a>';
												echo '<a href="index.php?view=catres.residents&id='.$tables->idclient.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>';
												echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idclient.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '</div></td>';
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