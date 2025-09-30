<?php//$users = PuestoData::getByDocumentos();	?><!-- Content Header (Page header) --><section class="content-header">	<h1>		Talento Humano		<small>listado de los documentos</small>	</h1>	<ol class="breadcrumb">		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>	</ol></section><!-- Main content --><section class="content" style="padding: 1.5rem !important;">	<div class="box">		<div class="box-header with-border">			<a id="btn_documentos" class="btn btn-success btn-sm" href="index.php?view=rrhdoc.document">				<span class="glyphicon glyphicon-plus"></span> Ingresar sanci&oacute;n			</a>
		</div>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>				<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>				<table id="viewlista" class="table table-bordered table-hover">					<thead>						<tr>							<th>Agente Protector</th>							<th>Tipo de Documento</th>							<th><div align="center">Fecha</div></th>							<th><div align="center">Firmo</div></th>							<th><div align="center">Reportado el</div></th>						</tr>					</thead>					<tbody>					<?php
						foreach($users as $sell) {
							echo '<tr>';
								echo '<td>'.utf8_encode($sell["nombre"]).'</td>';
								echo '<td>'.$sell["documen"].'</td>';
								echo '<td><div align="center">'.$sell["fecha"].'</div></td>';
								echo '<td width="8%">';									echo '<small>';									if($sell["firmo"] == 1){										echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';										echo '<span class="text-success">Firmo</span>';									}else{										echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
										echo '<span class="text-danger">No firmo</span>';
									}
									echo '</small>';
								echo '</td>';
								echo '<td style="width:180px;">';
									echo '<div align="center">'.$sell["created_at"].'&nbsp;&nbsp;<a href="index.php?view=rrhdoc.document&id='.$sell["id"].'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></div>';								echo '</td>';							echo '</tr>';						}					?>					</tbody>				</table>			</form>		</div>	</div></section><script type='text/javascript'><!--	function btn_EnviarOnClick(valor) {		 var f = document.frmC;		 var idrol = f.hid_frmIdrol;
		 if(idrol > 3){			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');		 }else{			 swal({ 				 title: "¿Seguro que deseas continuar?", 
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
</script>
