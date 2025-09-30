<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Reportes
		<small>lista de dotaci&oacute;n entregada</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-book"></i> Reportes </a></li>
		<li class="active">Dotaci&oacute;n de Agentes</li>
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
								<th>Entregado a</th>
								<th>Puesto</th>
								<th>Codigo</th>
								<th>Total</th>
								<th>Entregado el</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<?php
								$products = SellData::getSells();

								// Crea tabla de Ventas
								foreach($products as $sell) {
									echo '<tr>';
										echo '<td width="30%">'.utf8_encode($sell->name).'</td>';
										$operations = PuestoData::getByIdPuesto($sell->id);
										echo count($operations) > 0 ? '<td>'.$operations[0]["descripcion"].'</td>' : '<td>Sin Asignar</td>';
										echo count($operations) > 0 ? '<td>'.$operations[0]["codigo"].'</td>' : '<td></td>';
										echo '<td><b>$ '.number_format($sell->total).'</b></td>';
										echo '<td><div align="center">'.$sell->created_at.'</div></td>';
										echo '<td style="width:30px;"><a href="index.php?view=resumen&id='.$sell->person_id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
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
