<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Reportes
		<small>lista de dotaci&oacute;n entregada</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-book"></i> Reportes </a></li>
		<li class="active">Dotaci&oacute;n</li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<section class="content" style="padding: 1.5rem !important;>
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body mailbox-messages">
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th></th>
								<th>Entregado a</th>
								<th>Entregas</th>
								<th>Total</th>
								<th>Entregado el</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$products = SellData::getSells();

								// Crea tabla de Ventas
								foreach($products as $sell) {
									echo '<tr>';
										echo '<td style="width:30px;"><a href="index.php?view=resumen&id='.$sell->person_id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
										echo '<td width="40%">'.utf8_encode($sell->name)." ".utf8_encode($sell->lastname).'</td>';
										$operations = OperationData::getAllProductsBySellId($sell->id);
										echo '<td>'.count($operations).'</td>';
										$total= $sell->total-$sell->discount;
										echo '<td><b>$ '.number_format($total).'</b></td>';
										echo '<td><div align="center">'.$sell->created_at.'</div></td>';
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
