<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Cargos 
		<small>listado de los cargos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box"> 
		<div class="box-header with-border">
			<a id="btn_cargos" class="btn btn-success btn-sm" href="cargo">
				<span class="glyphicon glyphicon-plus"></span> Ingresar Cargos
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Departamento</th>
						<th>Descripci&oacute;n</th>
						<th>Tipo</th>
						<th>Estado</th>
						<th width="14%"></th>
					</tr>
					</thead>
					<tbody>
					<?php
						$cargos = CargoData::getAll();
						// Crea tabla de Cargos
						foreach($cargos as $tables) {
							echo '<tr>';
								echo '<td>'.$tables->departamento.'</td>';
								echo '<td>'.$tables->description.'</td>';
								echo '<td>'.$tables->tipo.'</td>';
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
										echo '<a href="index.php?view=cargo&id='.$tables->id.'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>';
									echo '</div>';
								echo '</td>';
							echo '</tr>';
						}
					?>
					</tbody>
				</table>
			</form>
		</div>	
	</div> 
</section> 
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
</script>
 