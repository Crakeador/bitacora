<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>liquidaciones del Personal</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box box-primary">
		<div class="box-body mailbox-messages">
			<table id="viewBitacora" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th><div align="center">Fotos</div></th>
					<th width="40%">Nombre Completos</th>
					<th width="8%"><div align="center">Telefono</div></th>
					<th><div align="center">Cargo</div></th>
					<th width="10%"><div align="center">Ingreso</div></th>
					<th width="10%"><div align="center">Salida</div></th>
					<th><div align="center">Estado</div></th>
				</tr>
				</thead>
				<tbody>
					<?php
						$users = PersonData::getAllLiquida(3, 0);

						// Crea tabla de Ventas
						foreach($users as $tables) {					
							echo '<tr>';											
								$nombre_fichero = "storage/persons/1234567890.jpg";
								$motivo = PersonData::getMotivo($tables->id, 'L');
								
								if($motivo == NULL) $texto = 'No hay liquidacion'; else $texto = $motivo->motivo;
								if (file_exists($nombre_fichero)) {
									echo '<td width="8%"><div align="center"><img src="'.$nombre_fichero.'" style="width:64px;"></div></td>';
								} else {
									echo '<td width="8%"><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
								}

								echo '<td>';
									echo 'C.C. '.$tables->idcard.'</br>'.utf8_encode($tables->name).'</br>'.$texto;
								echo '</td>';
								echo '<td><div align="center">'.$tables->phone1.'</div></td>';
								echo '<td>'.$tables->description.'</td>';
								echo '<td><div align="center">'.$tables->startwork.'</div></td>';
								echo '<td><div align="center">'.$tables->endwork.'</div></td>';
								echo '<td>
										<div align="center">
											<a href="index.php?view=observacion&id='.$tables->id.'"><img src="assets/images/icon/consul.png" alt="Edicion" title="Modificar una liquidaci&oacute;n" width="25"></a>
											<a href="index.php?view=mostrarl&id='.$tables->id.'"><img src="assets/images/icon/liquidacion.png" alt="Edicion" title=" Ver La Liquidacion" width="25"></a>
											<a href="index.php?view=prestacion&id='.$tables->id.'"><img src="assets/images/icon/editar.png" alt="Edicion" title="Ver prestaciones del agente" width="25"></a>
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
<!-- Page specific script -->
<?php 

if(isset($_SESSION['eliminado'])){

	if($_SESSION['eliminado'] == 1){

		$_SESSION['eliminado']=0;

		echo "<script>swal(\"¡El Número de Identificación ya se encuentra registrado en la Asignatura...!\", \"Por favor rectificar los datos ingresados.\", \"error\");</script>";

	}

}

?>

<script>document.title = "Listado de liquidaciones"</script>

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

</script>

