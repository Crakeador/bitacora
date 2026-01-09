<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Agenda de telef&oacute;nos		
		<small>listado de telefonos de clientes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
    <div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=rrsing.persons">
				<span class="glyphicon glyphicon-plus"></span> Ingresar agente
			</a>
		</div>
        <div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead> 
						<tr>
                            <th width="8%"><div align="center">Tel&eacute;fonos</div></th>
							<th width="40%">Clientes</th>
							<th><div align="center">Direcci&oacute;n</div></th>
							<th width="8%"><div align="center">Estado</div></th>
							<th width="10%"><div align="center">Acciones</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$users = ComercialData::getPhone($_SESSION['user_id']);

							// Crea tabla de Activos
							foreach($users as $tables) {
								echo '<tr>';
								    echo '<td>
									        <div align="center">';
									    echo '<a href="tel:'.$tables->telefono1.'">'.$tables->telefono1.'</a></br><a href="tel:'.$tables->telefono2.'">'.$tables->telefono2.'</a></br><a href="tel:'.$tables->telefonofac1.'">'.$tables->telefonofac1.'</a></br>';
								    echo '</div>
									      </td>';
									echo '<td><div align="left">';
										echo '<a class="text-primary" href="./index.php?view=telefono&id='.$tables->id.'">'.$tables->nombre.'</a></br>';
										echo $tables->contacto.'-'.$tables->email.'</br>';
										echo '<small>';
											echo '<span class="glyphicon glyphicon-paste text-success"></span>&nbsp;';
											echo $tables->created_at;
											echo '<span class="glyphicon glyphicon-copy text-success"></span>&nbsp;';
											echo $tables->producto.'&nbsp;';
											echo '</br>';
											echo '<span class="glyphicon glyphicon-envelope text-success"></span>&nbsp;';
											echo $tables->email;
										echo '</small>';
									echo '</div></td>';
									echo '<td><div align="left">'.$tables->direccion.'</div></td>';
									echo '<td width="6%">';
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
									echo '<td><div align="center">';
										echo '<button type="button" class="btn btn-primary btn-sm" onclick="logAndDial(\''.$tables->telefono1.'\', \''.$tables->nombre.'\')">Llamar</button>';
									echo '</div></td>';
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
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
	function logAndDial(numero, cliente){
		// Registra el evento y abre el dialer
		var now = new Date();
		var stamp = now.toISOString().slice(0,19).replace('T',' ');
		var fd = new FormData();
		fd.append('title', 'Llamada: '+cliente);
		fd.append('descripcion', 'Telefono: '+numero);
		fd.append('backgroundColor', '#00a65a');
		fd.append('borderColor', '#00a65a');
		fd.append('start', stamp);
		fd.append('end', stamp);
		fetch('ajax/eventos.php?accion=agregar', { method:'POST', body: fd })
			.catch(function(err){ console.error('No se pudo registrar la llamada', err); });
		window.location.href = 'tel:'+numero;
	}

	function btn_Contrato($id) {
		VentanaCentrada('js/documentos/res/contrato_html.php?id='+$id,'Recibos de Pago','','1024','768','true');
	}

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
							location.href="./index.php?view=delpersonal&id="+valor;
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
							location.href="./index.php?view=delpersonal&id="+valor;
					});
				 }
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "./index.php?view=rrging.persons";
	} //--
</script>
