<?php 
if(isset($_GET['id'])){	
    $total = PuestoData::getByIdTodos($_GET['id'], 1);
	
	if(count($total) == 0){	
		$client = new ClientData();	
		$client->idclient = $_GET['id'];
		//$valor = $client->del();
	}else{
		echo "<script src=\"plugins/sweetalert/sweetalert.min.js\"></script>
		<script>sweetAlert('Falla la actualizacion...!!!', 'Hay puesto activos actualmente, comunicarse con operaciones', 'error');</script>";
	}
}
?>
<!-- Listado de los clientes -->
<section class="content-header">
	<h1>
		Clientes
		<small>lista de los clientes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Listado </li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="./cliente">
				<span class="glyphicon glyphicon-plus"></span> Ingresar un cliente
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
								<th width="10%">RUC</th>
								<th>Cliente</th>
								<th>Contacto</th>
								<th>Direcci&oacute;n</th>
							 </tr>
							</thead>
							<tbody>
								<?php
									$client = ClientData::getAll(0, 1);

									// Crea tabla de Ventas
									foreach($client as $tables) {
										echo '<tr>';
											echo '<td><div align="center">';									
												echo $tables->ruc.'</br>';
													echo '<a href="index.php?view=catcli.resumen&id='.$tables->idclient.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-eye-open"></i></a>';
													echo '<a href="index.php?view=cliente&id='.$tables->idclient.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>';
													echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idclient.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
											echo '</div></td>';
											echo '<td>'.$tables->nombre.'</td>';
											echo '<td><b>'.$tables->contacto.'</b></td>';
											echo '<td>'.$tables->direccion.'</td>';
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
							<th width="10%">RUC</th>
							<th>Cliente</th>
							<th>Contacto</th>
							<th>Direcci&oacute;n</th>
						 </tr>
						</thead>
						<tbody>
							<?php
								$client = ClientData::getAll(0, 0);

								// Crea tabla de Ventas
								foreach($client as $tables) {
									echo '<tr>';
										echo '<td><div align="center">';									
											echo $tables->ruc.'</br>';
												echo '<a href="index.php?view=catcli.resumen&id='.$tables->idclient.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-eye-open"></i></a>';
												echo '<a href="index.php?view=cliente&id='.$tables->idclient.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>';
												echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idclient.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '</div></td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td><b>'.$tables->contacto.'</b></td>';
										echo '<td>'.$tables->direccion.'</td>';
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
<script src="plugins/sweetalert/sweetalert.min.js"></script>
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
						window.location.href = "index.php?view=cliente&id="+$id;
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