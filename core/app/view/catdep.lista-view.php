<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Departamentos
		<small>listado de los departamentos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<input type='hidden' name='hid_frmAdmin' id='hid_frmAdmin' value='<?php echo $_SESSION['is_admin']; ?>'/>
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<div class="col-md-12">
		<div class="text-left">
		<a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick();">
			<span class="glyphicon glyphicon-plus"></span>
			Ingresar Departamento
		</a>
		</div>
	</div>
	</br></br>
	<section class="content">
		<div class="box">
			<div class="box-body mailbox-messages">
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Departamento</th>
						<th>Estado</th>
						<th width="14%"></th>
					</tr>
					</thead>
					<tbody>
					<?php
						$products = DepartamentoData::getDepart();

						// Crea tabla de Ventas
						foreach($products as $tables) {
							echo '<tr>';
								echo '<td>'.$tables->description.'</td>';
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
			<!-- /.box-body -->
		</div>
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
		window.location.href = "./index.php?view=editdepartamento&id="+$id;
	} //

	function btn_NuevoOnClick() {
		window.location.href = "./index.php?view=newdepartamento";
	} //
</script>
