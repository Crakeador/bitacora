<!-- Content Header (Page header) --> 
<section class="content-header">
	<h1>
		Coordinaciones
		<small>lista de las coordinaciones reportadas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<form id='frmC' name='frmC' method='post' action=''>
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol'  id='hid_frmIdrol'  value='<?php echo $_SESSION['idrol']; ?>'/>
	<section class="content" style="padding: 1.5rem !important;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=opecor.new">
							<span class="glyphicon glyphicon-plus"></span> Nuevo registro
						</a>
					</div>
					<div class="box-body mailbox-messages">
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Puesto de Servicio</th>
									<th>Agente Protector</th>
									<th><div align="center">Fecha</div></th>
									<th><div align="center">Tipo de Falta</div></th>
									<th><div align="center">Reportado el</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
									if($_SESSION["idrol"] == "6")
										$users = PuestoData::getByLugar();
									else
										$users = PuestoData::getByFaltas();

									foreach($users as $sell) {
										echo '<tr>';
											echo '<td>'.$sell["descripcion"];
												echo '<div class="mini-tabla">';
													echo '<small>';
														echo '<span class="glyphicon glyphicon-briefcase"></span> '.$sell["codigo"];
													echo '</small>';
												echo '</div>';
											echo '</td>';
											echo '<td>'.utf8_encode($sell["nombre"]).'</td>';
											echo '<td><div align="center">'.$sell["fecha"].'</div></td>';
											$thearray = HorarioData::getByIdFalta($sell["idhorario"]);
											if(count($thearray) > 0) {
												$operations = get_object_vars($thearray);
												if($operations["tipo"] == 1)
													$valor = 'Falta programada';
												else
													if($operations["tipo"] == 2)
														$valor = 'Falta justificada y avisada';
													else
														if($operations["tipo"] == 3)
															$valor = 'Falta injustificada';
														else
															if($operations["tipo"] == 4)
																$valor = 'Falta en feriado o fiesta';
															else
																$valor = 'Sin definir';
											}else{
												$operations = 0;
											}

											echo $operations == 0 ? '<td>No registrado</td>' : '<td>'.$valor.'</td>';
											echo '<td style="width:180px;">';
												if($operations == 0)
													echo '<div align="center">'.$sell["created_at"].'&nbsp;&nbsp;<a href="index.php?view=opefal.edit&id='.$sell["idhorario"].'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-plus"></i></a></div>';
												else
													echo '<div align="center">'.$sell["created_at"].'&nbsp;&nbsp;<a href="index.php?view=opefal.edit&id='.$sell["idhorario"].'&falta='.$operations["tipo"].'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></div>';
											echo '</td>';
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
