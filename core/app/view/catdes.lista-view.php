<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Adicionales
		<small>listado de los calculos adicionales</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<section class="content" style="padding: 1.5rem !important;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=catdes.rubro">
							<span class="glyphicon glyphicon-plus"></span> Ingresar adicional
						</a>
					</div>
					<!-- tabs -->
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_entrada" data-toggle="tab" aria-expanded="false"><b>Entradas</b></a>
						</li>
						<li>
							<a href="#tab_salidas" data-toggle="tab" aria-expanded="false"><b>Salidas</b></a>
						</li>
					</ul>		
					<div class="box-body mailbox-messages">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane active" id="tab_entrada"> 
								<div class="content_tabs">
									<table id="viewlista" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Rubro</th>
												<th>Descuento</th>
												<th>Monto</th>
												<th>Estado</th>
												<th width="14%"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$articulos = DescuentoData::getTipo('I');

												// Crea tabla de Ventas
												foreach($articulos as $tables) {
													echo '<tr>';										
														echo '<td>'.$tables->rubro.'</td>';
														echo '<td>'.$tables->descripcion.'</td>';
														echo '<td>'.$tables->monto.'</td>';
														echo '<td>';
																echo '<small>';
																	if($tables->is_active == 1){
																		echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
																		echo '<span class="text-success">Activo</span>';
																	}else{
																		echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
																		echo '<span class="text-danger">Inactivo</span>';
																	}
																echo '</small>';
														echo '</td>';
														echo '<td width="10%">';
															echo '<div align="center">';
																echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
																echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_UpdateOnClick(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
															echo '</div>';
														echo '</td>';
													echo '</tr>';
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane" id="tab_salidas"> 
								<div class="content_tabs">
									<table id="viewInac" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Rubro</th>
												<th>Descuento</th>
												<th>Monto</th>
												<th>Estado</th>
												<th width="14%"></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$discounts = DescuentoData::getTipo('E');

												// Crea tabla de Ventas
												foreach($discounts as $tables) {
													echo '<tr>';										
														echo '<td>'.$tables->rubro.'</td>';
														echo '<td>'.$tables->descripcion.'</td>';
														echo '<td>'.$tables->monto.'</td>';
														echo '<td>';
																echo '<small>';
																	if($tables->is_active == 1){
																		echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
																		echo '<span class="text-success">Activo</span>';
																	}else{
																		echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
																		echo '<span class="text-danger">Inactivo</span>';
																	}
																echo '</small>';
														echo '</td>';
														echo '<td width="10%">';
															echo '<div align="center">';
																echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
																echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_UpdateOnClick(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
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
					</div>	<!-- /.box-body -->
				</div>	<!-- /.box -->
			</div>	<!-- /.col -->
		</div>	<!-- /.row -->
	</section>	<!-- /.content -->
</form>
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
						 swal({
							  title: "Registro borrado...!",
							  text: "Se elimino el registro seleccionado.",
							  timer: 6000,
							  showConfirmButton: false
							});
							window.location.href = "./?view=deldepartamento&id="+$id;
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
							window.location.href = "./?view=repdepartamento&id="+$id;
				   } else {
				 	    swal("Cancelado", "Se cancelo la activicion del registro", "error");
				   }
				 });
			 }
		 }
	} //--

	function btn_UpdateOnClick($id) {
		window.location.href = "./index.php?view=catdes.rubro&id="+$id;
	} //
</script>
