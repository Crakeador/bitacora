<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Catalogos
		<small>listado de los proveedores</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">	
		<div class="box-header with-border">
			<a href="index.php?view=newprovider" class="btn btn-success btn-sm">
				<span class="glyphicon glyphicon-plus"></span> Ingresar Proveedor
			</a>		
		</div>
		<div class="box-body">
			<table id="viewlista" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th><div align="center">Proveedores</div></th>
					<th><div align="center">R.U.C.</div></th>
					<th>Contacto</th>
					<th><div align="center">Telefono</div></th>
					<th><div align="center">Telefono</div></th>
					<th><div align="center">Correo</div></th>
					<th><div align="center">Direcci&oacute;n</div></th>
				</tr>
				</thead>
				<tbody>
					<?php					
						$users = ProviderData::getProviders();
						
						//Lista de los proveedores
						foreach($users as $tables) {
							if($tables->tipo == 1) $persona = 'Natural'; else if($tables->tipo == 2) $persona = 'Jur&iacute;dico'; else $persona = 'Sin RUC';
							echo '<tr>';
								echo '<td>';
									echo '<a class="text-primary" href="?view=editprovider&id='.$tables->id.'">'.$tables->nombre.'</a>';
									echo '<div class="mini-tabla">';
										echo '<small>';
											echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
											echo '<span class="text-success">&nbsp;Activo</span>&nbsp;·&nbsp;';
											echo '<span class="glyphicon glyphicon-user"></span> '.$persona.' &nbsp;·&nbsp; Proveedor';
										echo '</small>';
									echo '</div>';
								echo '</td>';
								echo '<td width="8%">'.$tables->ruc.'</td>';
								echo '<td>'.utf8_encode($tables->contacto).'</td>';
								echo '<td><div align="center">'.$tables->telefono1.'</div></td>';
								echo '<td><div align="center">'.$tables->telefono2.'</div></td>';
								echo '<td>'.$tables->email.'</td>';
								echo '<td>'.$tables->direccion.'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<!-- Page specific script -->
<script type='text/javascript'><!--
	function btn_EnviarOnClick($valor) {
		 var f = document.frmC;
		 var isadm = f.hid_frmIsAmd;
		 alert('aaaaa');
		 if(isadm == 1){
			 swal({
					title: 'Confirm',
					text: 'Are you sure to delete this message?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#987463',
					timer: 1500
			 });
		 }else{
			 sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "./?view=newprovider";
	} //
</script>
