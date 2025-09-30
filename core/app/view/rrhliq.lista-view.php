<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>liquidaciones del Personal</small>
	</h1>Dashboard
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box box-primary">
		<div class="box-body mailbox-messages">
			<table id="viewInac" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th><div align="center">Fotos</div></th>
					<th width="40%">Nombre Completos</th>
					<th><div align="center">Cargo</div></th>
					<th width="10%"><div align="center">Ingreso</div></th>
					<th width="10%"><div align="center">Egreso</div></th>
					<th width="10%"><div align="center">Reportado</div></th>
					<th width="10%"><div align="center">Estado</div></th>
				</tr>
				</thead>
				<tbody>
					<?php
						$users = PersonData::getAllLiquida(3, 0);

						// Crea tabla de Ventas
						foreach($users as $tables) {								
							$valor = HorarioData::getByTurno($tables->id, 10);
							echo '<tr>';											
								$nombre_fichero = "storage/persons/1234567890.jpg";
								
								$firstDate = $tables->startwork;
								$secondDate = $tables->endwork;

								$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

								$years  = floor($dateDifference / (365 * 60 * 60 * 24));
								$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
								$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

								if (file_exists($nombre_fichero)) {
									echo '<td width="8%"><div align="center"><img src="'.$nombre_fichero.'" style="width:64px;"></div></td>';
								} else {
									echo '<td width="8%"><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
								}
								$motivo = PersonData::getMotivo($tables->id, 'L');
								
								if($motivo == NULL) $texto = 'No hay liquidacion'; else $texto = $motivo->motivo;
								echo '<td>';
									echo 'C.C. '.$tables->idcard.' ('.$texto.')</br>'.$tables->lastname.' '.$tables->name.'</br>';
									if(isset($valor->idservicio)){
										$cadena='href="index.php?view=rrhliq.registro&id='.$tables->id.'"';
										echo '<div class="form-group has-success">
												<label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Ultimo Turno: '.str_pad($valor->dia, 2, "0", STR_PAD_LEFT).'-'.str_pad($valor->mes, 2, "0", STR_PAD_LEFT).'-'.$valor->ano.'</label> ('
												.$years.' años,  '.$months.' meses y '.$days.' dias)
											  </div>';
									}else{
										$cadena='onClick="btn_EnviarOnClick('.$tables->id.')';
										echo '<div class="form-group has-error">
												<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> No tiene fecha de UT</label>
											  </div>';
									}
								echo '</td>';
								echo '<td>'.$tables->description.'</td>';
								echo '<td><div align="center">'.$tables->startwork.'</div></td>';
								echo '<td><div align="center">'.$tables->endwork.'</div></td>';
								echo '<td><div align="center">'.$tables->update_at.'</div></td>';
								echo '<td>
										<div align="center">
											<a '.$cadena.'><img src="assets/images/icon/consul.png" alt="Edicion" title="Modificar una liquidaci&oacute;n" width="25"></a>
											<a href="index.php?view=mostrarl&id='.$tables->id.'"><img src="assets/images/icon/liquidacion.png" alt="Edicion" title=" Ver La Liquidacion" width="25"></a>
											<a name="imprimir" id="imprimir" onClick="btn_Imprimir('.$tables->id.')"><img src="assets/images/icon/impresora.png" alt="Edicion" title="Imprimir Liquidacion de agente" width="25"></a>
										</div> 
									</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
	document.title = "Near Solucions | Listado de liquidaciones";
	
	function btn_Imprimir(id) {
		VentanaCentrada('documentos/res/liquidacion_html.php?id='+id,'Liquidacion Personal','','1024','768','true');
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
							location.href="./index.php?view=delpersonal&id="+valor;
					}); 					
				 } 
			 });
		 }
	} //--
</script>

