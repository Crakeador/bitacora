<div class="row">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Reportes
			<small>lista de dotaci&oacute;n por puestos</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="./index.php?view=home"><i class="fa fa-book"></i> Reportes </a></li>
			<li class="active">Dotaci&oacute;n por Puestos</li>
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
										<th>Ciudad</th>
										<th>Lugar</th>
										<th>Codigo</th>
										<th><div align="center">Horario</div></th>
										<th><div align="center">Activo</div></th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									<?php
										$puestos = PuestoData::getAll(1);

										// Crea tabla de Ventas
										foreach($puestos as $sell) {
											if($sell->is_active == 1){ $activo = '<i class="fa fa-check"></i>'; }else{ $activo = '<i class="fa fa-times"></i>'; }

											echo '<tr>';
												echo '<td width="10%">'.$sell->lugar.'</td>';
												echo '<td>'.$sell->descripcion.'</td>';
												echo '<td><b>'.$sell->codigo.'</b></td>';
												echo '<td>'.$sell->horas.' '.$sell->horario.'</td>';
												echo '<td><div align="center">'.$activo.'</div></td>';
												echo '<td style="width:30px;"><a href="index.php?view=resumenpuesto&id='.$sell->id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
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
