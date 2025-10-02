<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Puestos
		<small>lista de dotaci&oacute;n por puestos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active">Dotaci&oacute;n de Puestos</li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
	    		<div class="box-header with-border">
    				<a id="btn_productos" class="btn btn-success btn-sm" href="dotar">
    					<span class="glyphicon glyphicon-plus"></span> Asignar prendas
    				</a>
	    		</div>
				<div class="box-body mailbox-messages">
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Ciudad</th>
							<th>Lugar</th>
							<th>Codigo</th>
							<th><div align="center">Horario</div></th>
							<th><div align="center">Total Entregado</div></th>
							<th><div align="center">Activo</div></th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php
							$puestos = SellData::getPuestos();
                            
							// Crea tabla de Ventas
							foreach($puestos as $sell) {
								if($sell->is_active == 1){ $activo = '<i class="fa fa-check"></i>'; }else{ $activo = '<i class="fa fa-times"></i>'; }

								echo '<tr>';
									echo '<td width="10%">'.$sell->lugar.'</td>';
									echo '<td>'.$sell->descripcion.'</td>';
									echo '<td><b>'.$sell->codigo.'</b></td>';
									echo '<td>'.$sell->horas.' '.$sell->horario.'</td>';
									echo '<td><div align="center">'.$sell->total.'</div></td>';
									echo '<td><div align="center">'.$activo.'</div></td>';
									echo '<td style="width:30px;"><a href="index.php?view=resumenpuesto&id='.$sell->sell_id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
								echo '</tr>';
							}
						?>
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>
<!-- Page specific script -->
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "SIDAI | Puestos del Cliente";

	function btn_EnviarOnClick($valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 if(idrol > 3){
			 sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
					title: 'Confirm',
					text: 'Are you sure to delete this message?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#987463',
					timer: 1500
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "main.php?pages=1";
	} //
</script>
