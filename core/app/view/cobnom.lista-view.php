<?php
// Lista de Control de Nomina
$client = ClientData::getTotal(); 

if(isset($_GET['client'])){	
	$_SESSION['client'] = $_GET['client'];
	$cliente = $_SESSION['client'];
}else{
	if(isset($_SESSION['client'])){
		$cliente = $_SESSION['client'];
	}else{
		$cliente = 0;
	}
}

if(isset($_GET['id'])){	
	$control = new ControlData();	
	$control->id = $_GET['id'];
	$control->estado = $_GET['estado'];
	$valor = $control->control();
}

?>
<!-- Generacion de las nominas en el sistema -->
<section class="content-header">
    <h1>
        Control de Nomina
        <small>nominas elaboradas por el sistema</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-book"></i> Panel de control </a></li>
		<li class="active"> Auditoria </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section>
<form id="frmC" name="frmC" class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" role="form">
	<div class="col-xs-12" style="padding: 1.5rem !important;">
		<div class="box">
			<div class="box-header with-border">
				<label> Cliente: </label>
				<select class="select-input form-control input-sm" id="idclient" name="idclient" onchange="javascript:location.href='index.php?view=cobnom.lista&client='+value;">
					<option value="0" selected="selected"> Selecione... </option>
					<?php
						foreach($client as $clients): ?>
							<option value="<?php echo $clients->idclient; ?>" <?php if($clients->idclient == $cliente) echo 'selected="selected"'; ?>><?php echo utf8_encode($clients->nombre);?></option>
						<?php endforeach;	
					?>
				</select>	
			</div>
			<div class="box-body mailbox-messages">
				<div> 
					<table id="viewnomina" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 10%"><div align="center">Generada</div></th>
								<th style="width: 10%"><div align="center">Tipo</div></th>
								<th style="width: 7%"><div align="center">Mes</div></th>
								<th style="width: 7%"><div align="center">Año</div></th>
								<th><div align="center">Clientes</div></th>
								<th style="width: 16%"><div align="center">Estado</div></th>
								<th style="width: 12%"><div align="center">Modificado el</div></th>
							</tr>
						</thead>
						<tbody> 
							<?php
								if($cliente == 0)							
									$users = ControlData::getAll();	
								else
									$users = ControlData::getCentrol($cliente);				

								$resultado = count($users);
								$j=1; $subtotal=0;

								if($resultado > 0){
									foreach($users as $tables) {
										if($tables->tipo == 0) 
											$tipo = 'Mensual';
										else 
											if($tables->tipo == 1)
												$tipo = '1era. Quicena';
											else 
												$tipo = '2da. Quincena';
											
										echo '<tr>';
											echo '<td><div align="center">'.$tables->created_at.'</div></td>';
											echo '<td><div align="center">'.$tipo.'</div></td>';
											echo '<td><div align="center">'.$tables->mes.'</div></td>';
											echo '<td><div align="center">'.$tables->ano.'</div></td>';
											echo '<td><small>'.$tables->nombre.'</br>Generado por: '.$tables->usuario_log.'</small></td>';											
											echo '<td><small>';
												echo '<a href="index.php?view=cobnom.detalle&id='.$tables->idclient.'&mes='.$tables->mes.'&ano='.$tables->ano.'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>';
												if ($tables->estado == "Generada"){
													echo '<button type="button" class="btn btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', 2);"><i class="fa fa-sign-out"></i></button>';
												}else{
													if ($tables->estado == "Firmada")
														echo '<button type="button" class="btn btn-warning btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', 3);"><i class="fa fa-sign-out"></i></button>';
													else
														if ($tables->estado == "Modificada")
															echo '<button type="button" class="btn btn-info btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', 3);"><i class="fa fa-sign-out"></i></button>';
														else
															echo '<button type="button" class="btn btn-success btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', 1);"><i class="fa fa-sign-out"></i></button>';
												}
											    echo '&nbsp;&nbsp;'.$tables->estado;
											echo '</small></td>'; 
											echo '<td><div align="center">'.$tables->update_at.'</div></td>';
										echo '</tr>';
									}
								}
							?>
						</tbody>
					</table> 
				</div>
			</div>
		</div>
	</div>
</form>
<!-- Page specific script -->
<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Control de Nominas"
	
	function btn_EnviarOnClick($id, $is_active) {
		 var valor = <?php echo $_SESSION['is_admin']; ?>;

		 if(valor == "0"){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
		 	if($is_active == "1"){
		 	     swal("Pagado", "La nomina esta pagada", "error");
			}else {
				swal({
				   title: "Esta usted seguro?",
				   text: "Se va actualizar el registro de la nomina seleccionada...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, cambiar...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				},
				function(isConfirm){
				   if (isConfirm) {					   
						window.location.href = "./index.php?view=cobnom.lista&id="+$id+"&estado="+$is_active;
						swal({
							  title: "Registro actualizado...!",
							  text: "Se actualizo el registro seleccionado.",
							  timer: 6000,

							  showConfirmButton: false
							});
				   } else {
				 	    swal("Cancelado", "Se cancelo la actualizacion del registro", "error");
				   }
				});
			}
		 }

	} //--
</script>
