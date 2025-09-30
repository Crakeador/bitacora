<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Rubros
		<small>listado de los rubros de la nomina</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=catrub.rubro">
				<span class="glyphicon glyphicon-plus"></span> Ingresar un cliente
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<input type='hidden' name='hid_frmAdmin' id='hid_frmAdmin' value='<?php echo $_SESSION['is_admin']; ?>'/>
				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Cuenta</th>
						<th>Descripci&oacute;n</th>
						<th>Monto</th>
						<th>Calcular</th>
						<th>Orden</th>
						<th>Imp</th>
						<th>Estado</th>
						<th width="14%"></th>
					</tr>
					</thead>
					<tbody>
					<?php
						$rubros = RubroData::getRubro();

						// Crea tabla de Ventas
						foreach($rubros as $tables) {
							echo '<tr>';
								echo '<td><div align="center">'.$tables->tipo_cuenta.'</div></td>';
								echo '<td>'.$tables->descripcion.'</td>';
								echo '<td><div align="right">'.$tables->valor.'</div></td>';
								echo '<td>';
									if($tables->calcular == 1) echo '<small class="label label-success"> Se calcula&nbsp; </small>'; else echo '<small class="label label-danger"> No calcular </small>';
								echo '</td>';
								echo '<td>'.$tables->orden_rubro.'</td>';
								echo '<td>'.$tables->impreso.'</td>';
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
										echo '<button type="button" class="btn btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>';
										echo '<button type="button" class="btn btn-success btn-sm" onClick="btn_UpdateOnClick(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
									echo '</div>';
								echo '</td>';
							echo '</tr>';
						}
					?>
					</tbody>
				</table>
            </form>
		</div>	<!-- /.box-body -->
	</div>	<!-- /.box -->
</section> <!-- /.content -->
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
		window.location.href = "./?view=catrub.rubro&id="+$id;
	} //
</script>
