<?php
//Listado de Usuarios
if(isset($_GET["id"])) $users = UserData::update_activo($_GET["id"]);
$users = UserData::getAll();

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Usuarios
		<small>listado de los usuario</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
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
						<a id="btn_guardar_persona" class="btn btn-success btn-sm" onclick="btn_NuevoOnClick();">
							<span class="glyphicon glyphicon-plus"></span> Ingresar usuario
						</a></br></br>
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Foto</th>
								<th><div align="center">Nombre</div></th>
								<th><div align="center">Rol de Usuario</div></th>
								<th width="8%"><div align="center">Departamento</div></th>
								<th width="8%"><div align="center">Usuario</div></th>
								<th width="8%"><div align="center">Rol</div></th>
							</tr>
							</thead>
							<tbody>
								<?php
									foreach($users as $tables) {
										echo '<tr>';
											echo '<td>';
												echo '<div align="center">';
												if($tables->image!="")
														echo '<img src="assets/images/avatar/'.$tables->image.'" style="width:64px;">';
													else
														echo '<img src="assets/images/usuario.jpg" style="width:64px;">';
												echo '</div>';
											echo '</td>';
											echo '<td>';
												echo '<a class="text-primary" href="usuario/'.$tables->id.'">'.utf8_encode($tables->name).' '.utf8_encode($tables->lastname).'</a>';												
												if($tables->is_admin){													
													echo '&nbsp;·&nbsp;<small>';
														echo  '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo  '<span class="text-success">Es administrador</span>'; 
													echo '</small>';
												}
												echo '<div class="mini-tabla">';
													echo '<small>';
														if($tables->is_active) echo '<small class="label label-success"><i class="fa fa-check"></i> ACTIVO</small>&nbsp;·&nbsp;'; else echo '<small class="label label-danger"><i class="fa fa-close"></i> INACTIVO</small>&nbsp;·&nbsp;';
														echo '<span class="glyphicon glyphicon-envelope"></span> '.$tables->email;
													echo '</small>';													
												echo '</div>';
											echo '</td>';
											echo '<td>';
												if($tables->idrol!=null){
													echo $tables->nombre;
													echo '</br><small>'.$tables->descripcion.'</small>';
												}else{
													echo "Sin rol"; 
												}
											echo '</td>';
											echo '<td>';
												if($tables->iddepartamento!=null){
													echo $tables->description;
												}else{
													echo "Sin Departamento"; 
												}
											echo '</td>';
											echo '<td>'.$tables->username.'</td>';
											echo '<td>											
													<div align="center">
														<button type="button" class="btn btn-app btn-danger" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i> Inactivar </a></button>
													</div>
												  </td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					</div>	<!-- /.box-body -->
				</div>	<!-- /.box -->
			</div>	<!-- /.col -->
		</div>	<!-- /.row -->
	</section>	<!-- /.content -->
</form>
<!-- Page specific script -->
<script type='text/javascript'>
    document.title = "Near Solucions | Listado de Usuarios";
	
	function btn_NuevoOnClick() {
		window.location.href = "./usuario";
	} //
	
	<!-- Funcion Inactivar
	function btn_EnviarOnClick(valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 if(idrol > 3){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
				 title: "¿Seguro que deseas continuar?",
				 text: "No podrás deshacer este paso...!!!",
				 type: "warning",
				 showCancelButton: true,
				 cancelButtonText: "No, cancelar...!",
				 confirmButtonColor: "#DD6B55",
				 confirmButtonText: "Si, continuar...!",
				 closeOnConfirm: false
			  }, function(isConfirm){
			  	 if (isConfirm) {
					 swal({
						title:"¡Bien Hecho!",
						text:"Se desactivo el usuario en el sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						function(){
							location.href="./usuarios/"+valor;
					});
				 }else{
					sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para activar agentes', 'error');
					swal({
						title:"¡Errrooooor!",
						text:"Se activo el agente del sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						function(){
							location.href="./usuarios/"+valor;
					});
				 }
			 });
		 }
	} //--
</script>

