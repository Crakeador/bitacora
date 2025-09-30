<?php
$usera = PersonData::getAllTipo(3, 1);
$users = PersonData::getAllTipo(3, 0);
$userb = PersonData::getAllTipo(4, 1);
//$userc = PersonData::getAllTipo(3, 1, 2);

$activo = count($usera);
$activa = count($users);
$active = count($userb);

if(isset($_GET['id'])){	
	$person = new PersonData();	
	$person->id = $_GET['id'];
	$person->del();
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>listado de los agentes activos</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active"><i class="fa fa-dashboard"></i> Panel de Control </li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box"> 
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=rrging.persons">
				<span class="glyphicon glyphicon-plus"></span> Ingresar agente
			</a>
		</div>
		<!-- tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Activos</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="Agentes activos"><?php echo $activo; ?></span></a>
			</li>
			<li>
				<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Inactivos</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="Agentes inactivos"><?php echo $activa; ?></span></a>
			</li>
			<li>
				<a href="#tab_aspirante" data-toggle="tab" aria-expanded="false"><b>Aspirantes</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="Aspirantes ingresados"><?php echo $active; ?></span></a>
			</li>
		</ul>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<!-- tabs content -->
				<div class="tab-content panel">
					<div class="tab-pane active" id="tab_activos"> 
						<div class="content_tabs">
							<table id="viewlista" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><div align="center">Fotos</div></th>
										<th><div align="center">C.C.</div></th>
										<th>Nombre Completos</th>
										<th><div align="center">Telefono</div></th>
										<th><div align="center">Direcci&oacute;n</div></th>
										<th width="10%"><div align="center">Acci&oacute;n</div></th>
									</tr>
								</thead>
								<tbody>
									<?php
										// Crea tabla de Activos
										foreach($usera as $tables) {
											echo '<tr>';
												if (is_null($tables->image)) {
													echo '<td width="8%"><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
												} else {
													echo '<td width="8%"><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
												}
												echo '<td width="8%"><div align="center">';
													echo $tables->idcard;
													echo '<a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_Contrato();">';
														echo '<span class="glyphicon glyphicon-print"></span> &nbsp;Contrato';
													echo '</a>';
												echo '</div></td>';
												echo '<td width="30%">';
													echo $tables->name.'</br>';
													echo '<small>';													
														echo '<span class="glyphicon glyphicon-home text-success"></span>&nbsp;';
														echo '<span class="text-success">';							
															echo $tables->startwork;
														echo '</span>';
													echo '</small>';
												echo '</td>';
												echo '<td width="8%"><div align="center">'.$tables->phone1.'</div></td>';
												echo '<td>'.$tables->direccion.'</td>';
												echo '<td>';
													echo '<div align="center">';
														echo '<button type="button" class="btn btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
														echo '<a href="index.php?view=rrging.persons&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
													echo '</div>';
												echo '</td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="tab_inactivos">
						<div class="content_tabs">
							<table id="viewInac" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><div align="center">Fotos</div></th>
										<th><div align="center">C.C.</div></th>
										<th>Nombre Completos</th>
										<th><div align="center">Telefono</div></th>
										<th><div align="center">Direcci&oacute;n</div></th>
										<th width="10%"><div align="center">Acci&oacute;n</div></th>
									</tr>
								</thead>
								<tbody>
									<?php
										// Crea tabla de Activos
										foreach($users as $tables) {
											echo '<tr>';
												if (is_null($tables->image)) {
													echo '<td width="8%"><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
												} else {
													echo '<td width="8%"><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
												}
												echo '<td width="8%"><div align="center">';
													echo $tables->idcard;
													echo '<a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_Contrato();">';
														echo '<span class="glyphicon glyphicon-print"></span> &nbsp;Contrato';
													echo '</a>';
												echo '</div></td>';
												echo '<td width="30%">';
													echo $tables->name.'</br>';
													echo '<small>';													
														echo '<span class="glyphicon glyphicon-home text-success"></span>&nbsp;';
														echo '<span class="text-success">';							
															echo $tables->startwork;
														echo '</span>';
													echo '</small>';
												echo '</td>';
												echo '<td width="8%"><div align="center">'.$tables->phone1.'</div></td>';
												echo '<td>'.$tables->direccion.'</td>';
												echo '<td>';
													echo '<div align="center">';
														echo '<button type="button" class="btn btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
														echo '<a href="index.php?view=rrging.persons&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
													echo '</div>';
												echo '</td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="tab_aspirante">
						<div class="content_tabs">
							<table id="viewactivo" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><div align="center">Fotos</div></th>
										<th><div align="center">C.C.</div></th>
										<th>Nombre Completos</th>
										<th><div align="center">Telefono</div></th>
										<th><div align="center">Direcci&oacute;n</div></th>
										<th width="10%"><div align="center">Acci&oacute;n</div></th>
									</tr>
								</thead>
								<tbody>
									<?php
										// Crea tabla de Activos
										foreach($userb as $tables) {
											echo '<tr>';
												if (is_null($tables->image)) {
													echo '<td width="8%"><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
												} else {
													echo '<td width="8%"><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
												}
												echo '<td width="8%"><div align="center">';
													echo $tables->idcard;
													echo '<a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_Contrato();">';
														echo '<span class="glyphicon glyphicon-print"></span> &nbsp;Contrato';
													echo '</a>';
												echo '</div></td>';
												echo '<td width="30%">';
													echo $tables->name.'</br>';
													echo '<small>';													
														echo '<span class="glyphicon glyphicon-home text-success"></span>&nbsp;';
														echo '<span class="text-success">';							
															echo $tables->startwork;
														echo '</span>';
													echo '</small>';
												echo '</td>';
												echo '<td width="8%"><div align="center">'.$tables->phone1.'</div></td>';
												echo '<td>'.$tables->direccion.'</td>';
												echo '<td>';
													echo '<div align="center">';
														echo '<button type="button" class="btn btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
														echo '<a href="index.php?view=rrging.persons&id='.$tables->id.'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
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
			</form>
		</div>	
	</div> 
</section> 
<!-- Page specific script -->
<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Listado de los agentes";
	
	function btn_EnviarOnClick($id, $is_active) {
		swal({
			title: "Esta usted seguro?",
			text: "Se va ha inactivar el agente de seguridad...!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Si, proceder...!",
			cancelButtonText: "No, cancelar...!",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm){
			if (isConfirm) {
					swal({
						title: "Registro desactivado...!",
						text: "Se desactivo el registro seleccionado.",
						timer: 6000,
						showConfirmButton: false
					});
					window.location.href = "./index.php?view=rrging.lista&id="+$id;
			} else {
				swal("Cancelado", "Se cancelo el borrado el registro", "error");
			}
		});
	} //--
</script>
