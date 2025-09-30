<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Inventario
		<small>lista de los articulos registrados</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-cubes"></i> Panel de Control </a></li>
		<li class="active">Inventario</li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<section class="content" style="padding: 1.5rem !important;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body mailbox-messages">
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th width="30%">Producto</th>
									<th width="8%">Disponible</th>
									<th>Descripci&oacute;n</th>
									<th>Activo</th>
									<th width="14%"></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$products = ProductData::getAll();
								// Crea tabla de Ventas
								foreach($products as $product) {
									$q=OperationData::getQYesF($product->id);
									echo '<tr>';
										echo '<td>'.$product->name.'</br>';
											echo '<small>';
												echo '<span class="text-success">'.$product->unit.'</span>';
											echo '</small>';
										echo '</td>';
										echo '<td><div align="center">'.number_format($q).'</div></td>';
										echo '<td>'.$product->description.'</td>';
										echo '<td>';
												echo '<small>';
													if($product->is_active == 1){
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Activo</span>';
													}else{
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Inactivo</span>';
													}
												echo '</small>';
										echo '</td>';
										echo '<td style="width:140px;"><div align="center">';
											echo '<a href="index.php?view=input&product_id='.$product->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-circle-arrow-up"></i> Alta</a>&nbsp;&nbsp;';
											echo '<a href="index.php?view=history&product_id='.$product->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-time"></i> Historial</a>';
										echo '</div></td>';
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</form>
<!-- Page specific script -->
<script type='text/javascript'><!--
	function btn_EnviarOnClick($valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 if(idrol > 3){
			 sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
					title: 'Confirm',
					text: 'Are you sure to delete this message?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#987463',
					timer: 1500
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "main.php?pages=1";
	} //
</script>
