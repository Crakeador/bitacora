<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Oficinas
		<small>lista de las oficinas de la empresa</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<div class="col-md-12">
	<div class="text-left">
		<a href="index.php?view=catofi.oficina" class="btn btn-success btn-sm">
			<i class="fa fa-plus"></i> Ingresar una oficina
		</a>
	</div>
</div>
</br></br>
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
									<th>Lugar</th>
									<th>Codigo</th>
									<th width="14%">Ciudad</th>
									<th><div align="center">Horario</div></th>
									<th><div align="center">Estado</div></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$puestos = PuestoData::getAll(1);
								// Crea tabla de las oficinas
								foreach($puestos as $sell) {
									if($sell->is_active == 1){ $activo = '<i class="fa fa-check"></i>'; }else{ $activo = '<i class="fa fa-times"></i>'; }

									echo '<tr>';
										echo '<td>';
											echo '<a class="text-primary" href="?view=catofi.oficina&id='.$sell->id.'">'.$sell->descripcion.'</a>';
										echo '</td>';
										echo '<td><b>'.$sell->codigo.'</b></td>';
										echo '<td>'.$sell->lugar.'</td>';
										echo '<td>'.$sell->horas.' '.$sell->horario.'</td>';
										echo '<td><div align="center">'.$activo.'&nbsp;&nbsp;';
											if($sell->sucursal == 1) echo '<small class="label label-success"> PRINCIPAL </small>'; else echo '<small class="label label-danger"> SUCURSAL</small>';
											echo '&nbsp;&nbsp;<a href="index.php?view=resumenpuesto&id='.$sell->id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></div>';
										echo '</td>';
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
					</div> <!-- /.box-body -->
				</div> <!-- /.box -->
			</div> <!-- /.col -->
		</div> <!-- /.row -->
	</section>	<!-- /.content -->
</form>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-red',
	    radioClass: 'iradio_flat-red'
	  });
	});
</script>
