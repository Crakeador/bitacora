<?php 
//Sistemas de clientes
if(!isset($_SESSION["user_id"])){  Core::redir("./");  }//si no hay sesion redirecciona al login

if(isset($_SESSION["idrol"]) && $_SESSION["idrol"] == 4){
	$totalLlam = ComercialData::getNull($_SESSION['user_id']);
	$totalLlam = ComercialData::getTotal('Llamada', $_SESSION['user_id']);
	$totalMail = ComercialData::getTotal('Mailing', $_SESSION['user_id']);
	$totalVisi = ComercialData::getTotal('Visita', $_SESSION['user_id']);
}else{
	$totalPros = ComercialData::getNull();
	$totalLlam = ComercialData::getTotal('Llamada');
	$totalMail = ComercialData::getTotal('Mailing');
	$totalVisi = ComercialData::getTotal('Visita');
}

if(isset($_GET['id'])){	
    $total = PuestoData::getByIdTodos($_GET['id'], 1);
	
	if(count($total) == 0){	
		$client = new ComercialData();	
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
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Listado </li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="venta">
				<span class="glyphicon glyphicon-plus"></span> Ingresar un cliente
			</a>
		</div>
		<!-- tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_prospecto" data-toggle="tab" aria-expanded="false"><b>Prospectos</b></a>
			</li>			
			<li>
				<a href="#tab_llamadas" data-toggle="tab" aria-expanded="false"><b>Llamadas</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="Agentes activos"><?php echo $totalLlam->total; ?></span></a>
			</li>
			<li>
				<a href="#tab_mailing" data-toggle="tab" aria-expanded="false"><b>Mailing</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="Agentes activos"><?php echo $totalMail->total; ?></span></a>
			</li>
			<li>
				<a href="#tab_visita" data-toggle="tab" aria-expanded="false"><b>Visitas</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="Agentes activos"><?php echo $totalVisi->total; ?></span></a>
			</li>
		</ul>
		<div class="box-body mailbox-messages">		
			<!-- tabs content -->
			<div class="tab-content panel">
              	<div class="tab-pane active" id="tab_prospecto">
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="10%">RUC</th>
								<th>Cliente</th>
								<th>Telefono</th>
								<th>Contacto</th>
								<th>E-Mail</th>
								<th>Observacion</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($_SESSION['idrol'] == 3){ // Si es administrador ve todos los clientes
									$client = ComercialData::getNulo();
								}else{
									$client = ComercialData::getNulo($_SESSION['user_id']);
								}

								// Crea tabla de Ventas
								foreach($client as $tables) {
									echo '<tr>';
										echo '<td>
												<div align="center">';									
													echo $tables->ruc.'</br>';
													echo '<a href="./informa/'.$tables->id.'" class="btn btn-xs btn-warning"><span data-toggle="tooltip" title="" data-original-title="Linea de informacion"><i class="fa fa-eye"></i></span></a>';
													echo '<a href="./venta/'.$tables->id.'" class="btn btn-xs btn-success"><span data-toggle="tooltip" title="" data-original-title="Detalles del cliente"><i class="fa fa-edit"></i></span></a>';
													echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
											echo '</div>
												</td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td><div align="center">'.$tables->telefono1.'</div></td>';
										echo '<td><b>'.$tables->contacto.'</b></td>';
										echo '<td>'.$tables->email.'</td>';
										echo '<td>'.$tables->observacion.'</br>Creado el: '.$tables->created_at.'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_llamadas">
					<table id="viewInac" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="10%">RUC</th>
								<th>Cliente</th>
								<th>Telefono</th>
								<th>Contacto</th>
								<th>E-Mail</th>
								<th>Observacion</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($_SESSION['idrol'] == 3){ // Si es administrador ve todos los clientes
									echo "Administrador";
									$client1 = ComercialData::getAll(1, "Llamada");
								}else{
									echo "Agente";
									$client1 = ComercialData::getLike("Llamada", $_SESSION['user_id']);
								}

								// Crea tabla de Ventas
								foreach($client1 as $tables) {
									echo '<tr>';
										echo '<td><div align="center">';									
											echo $tables->ruc.'</br>';
												echo '<a href="./informa/'.$tables->id.'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>';
												echo '<a href="./venta/'.$tables->id.'" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>';
												echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '</div></td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td><div align="center">'.$tables->telefono1.'</div></td>';
										echo '<td><b>'.$tables->contacto.'</b></td>';
										echo '<td>'.$tables->email.'</td>';
										echo '<td>'.$tables->observacion.'</br>Actualizado el: '.$tables->update_at.'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_mailing">
					<table id="viewdates" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="10%">RUC</th>
								<th>Cliente</th>
								<th>Telefono</th>
								<th>Contacto</th>
								<th>E-Mail</th>
								<th>Observacion</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($_SESSION['idrol'] == 3){ // Si es administrador ve todos los clientes
									$client2 = ComercialData::getAll(1, "Mailing");
								}else{
									$client2 = ComercialData::getLike("Mailing", $_SESSION['user_id']);
								}

								// Crea tabla de Ventas
								foreach($client2 as $tables) {
									echo '<tr>';
										echo '<td><div align="center">';									
											echo $tables->ruc.'</br>';
												echo '<a href="./informa/'.$tables->id.'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>';
												echo '<a href="./venta/'.$tables->id.'" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>';
												echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '</div></td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td><div align="center">'.$tables->telefono1.'</div></td>';
										echo '<td><b>'.$tables->contacto.'</b></td>';
										echo '<td>'.$tables->email.'</td>';
										echo '<td>'.$tables->observacion.'</br>Actualizado el: '.$tables->update_at.'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_visita">
					<table id="viewDotar" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="10%">RUC</th>
								<th>Cliente</th>
								<th>Telefono</th>
								<th>Contacto</th>
								<th>E-Mail</th>
								<th>Observacion</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($_SESSION['idrol'] == 3){ // Si es administrador ve todos los clientes
									$client3 = ComercialData::getAll(1, "Visita");
								}else{
									$client3 = ComercialData::getLike("Visita", $_SESSION['user_id']);
								}

								// Crea tabla de Ventas
								foreach($client3 as $tables) {
									echo '<tr>';
										echo '<td><div align="center">';									
											echo $tables->ruc.'</br>';
												echo '<a href="./informa/'.$tables->id.'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>';
												echo '<a href="./venta/'.$tables->id.'" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>';
												echo '<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '</div></td>';
										echo '<td>'.$tables->nombre.'</td>';
										echo '<td><div align="center">'.$tables->telefono1.'</div></td>';
										echo '<td><b>'.$tables->contacto.'</b></td>';
										echo '<td>'.$tables->email.'</td>';
										echo '<td>'.$tables->observacion.'</br>Actualizado el: '.$tables->update_at.'</td>';
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
    document.title = "Near Solution | Listado de los Clientes";

	function btn_EnviarOnClick($id, $is_active) {
		 var valor = <?php echo $_SESSION['idrol']; ?>;

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
						window.location.href = "./cliente/"+$id;
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
							window.location.href = "./cliente/"+$id;
				   } else {
				 	    swal("Cancelado", "Se cancelo la activicion del registro", "error");
				   }
				 });
			 }
		 }
	} //--
</script>