<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Localidades
		<small>listado de las diferentes lugares</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<div class="col-md-12">
		<div class="text-left">
			<a href="index.php?view=catloc.lugar" id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick();">
					<i class="glyphicon glyphicon-plus"></i> Ingresar un lugar
			</a>
		</div>
</div>
</br></br>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
		<input type='hidden' name='hid_frmAdmin' id='hid_frmAdmin' value='<?php echo $_SESSION['is_admin']; ?>'/>
		<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body mailbox-messages">
							<table id="viewlista" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>Descripci&oacute;n</th>
									<th>Siglas</th>
									<th>Estado</th>
									<th width="14%"></th>
								</tr>
								</thead>
								<tbody>
								<?php
									$lugares = LugarData::getAll();

									// Crea tabla de Ventas
									foreach($lugares as $tables) {
										echo '<tr>';
											echo '<td>'.$tables->descripcion.'</td>';
											echo '<td>'.$tables->nombre.'</td>';
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
													echo '<button type="button" class="btn btn-success btn-sm" onClick="btn_UpdateOnClick(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
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
<!-- Page specific script -->
<script type='text/javascript'><!--
	function btn_UpdateOnClick($id) {
		window.location.href = "./index.php?view=catloc.lugar&id="+$id;
	} //
</script>
