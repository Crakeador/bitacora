<div class="row">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Contabilidad
			<small>mantenimiento de cuentas</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-book"></i> Contabilidad</a></li>
			<li class="active">Cuentas contables</li>
		</ol>
	</section>
	<!-- Main content -->
	<form id='frmC' name='frmC' method='post' action=''>
			<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
			<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body mailbox-messages">
								<table id="viewlista" class="table table-bordered table-hover">
									<thead>
									<tr>
										<th>Cuenta</th>
										<th>Descripci&oacute;n de la cuenta</th>
										<th>Balance</th>
										<th>Orden</th>
										<th>Saldo Inicial</th>
										<th>Imputable</th>
										<th>Acción</th>
									</tr>
									</thead>
									<tbody>
									<?php
										$cuentas = CuentasData::getAll();

										// Crea tabla de Ventas
										foreach($cuentas as $tables) {
											echo '<tr>';
												echo '<td>'.$tables->cuenta.'</td>';
												echo '<td width="40%">'.utf8_encode($tables->nombre).'</td>';
												echo '<td>'.$tables->balance.'</td>';
												echo '<td><div align="center">'.$tables->orden.'</div></td>';
												echo '<td>';
													echo '<div align="right">'.number_format($tables->saldoinicial, 2, ',', '.').'</div>';
												echo '</td>';
												echo '<td><div align="center">'.$tables->imputable.'</div></td>';
												echo '<td>';
													echo '<div align="center">';
														echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idcuenta.'\');"><i class="fa fa-trash"></i></button>';
														echo '<button type="button" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>';
														echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_NuevoOnClick();"><i class="fa fa-plus"></i></button>';
													echo '</div>';
												echo '</td>';
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
</div>
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
