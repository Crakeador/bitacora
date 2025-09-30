<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>listado de las vacaciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"><i class="fa fa-book"></i> Vacaciones </li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<div class="col-md-12">
		<div class="text-left">
			<a id="btn_guardar_persona" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick();">
				<span class="glyphicon glyphicon-plus"></span> Registro de vacaciones
			</a>
		</div>
	</div>
	</br>
	</br>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body mailbox-messages">
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Agente Protector</th>
									<th><div align="center">Fecha Inicio</div></th>
									<th><div align="center">Fecha Fin</div></th>
									<th><div align="center">Total de dias</div></th>
									<th><div align="center">Reportado el</div></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$users = PersonData::getVacaciones();
								
								foreach($users as $sell) {
									echo '<tr>';
										echo '<td>'.strtoupper($sell->name).'</td>';
										echo '<td><div align="center">'.$sell->startwork.'</div></td>';
										echo '<td><div align="center">'.$sell->endwork.'</div></td>';
										echo '<td><div align="center">'.$sell->dias.'</div></td>';
										echo '<td style="width:180px;">';
											echo '<div align="center">'.$sell->created_at.'&nbsp;&nbsp;<a href="index.php?view=rrhvac.registro&id='.$sell->id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></div>';
										echo '</td>';
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</form>
<script>document.title = "Listado de Vacaciones"</script>
<script type='text/javascript'><!--
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
				 confirmButtonText: "Si, Eliminar...!", 
				 closeOnConfirm: false 
			  }, function(isConfirm){ 	
			  	 if (isConfirm) { 			 
					 swal({
						title:"¡Bien Hecho!",
						text:"Se desincorporo el agente del sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						
						function(){
							location.href="./?view=delpersonal&id="+valor;
					}); 
				 }else{
					sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
					swal({
						title:"¡Bien Hecho!",
						text:"Se desincorporo el agente del sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						
						function(){
							location.href="./?view=delpersonal&id="+valor;
					}); 					
				 } 
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "index.php?view=rrhvac.registro";
	} //--
</script>
