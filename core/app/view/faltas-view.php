<?php
//Listado de las faltas de los guardias
/*
if($_SESSION["idrol"] == "12" || $_SESSION["idrol"] == "6")
    $cadena = "AND A.ano = '".date("Y")."' AND A.mes = '".date("m")."' AND A.dia = '".date("d")."'";
else */
    $cadena = "";
/*
if($_SESSION["idrol"] == "6")
	$users = PuestoData::getByLugar();
else */
	$users = PuestoData::getByFaltas($cadena);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Faltas
		<small>lista de las faltas reportadas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
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
					<div class="box-body mailbox-messages">
						<table id="viewBitacora" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><div align="center">Fecha</div></th>
									<th>Puesto de Servicio</th>
									<th>Agente Protector</th>
									<th><div align="center">Tipo de Falta</div></th>
									<th><div align="center">Reportado el</div></th>
								</tr>
							</thead>
							<tbody>
								<?php
									//Listado de Faltas
									foreach($users as $sell) {	
										$operations = FaltaData::getByIdFalta($sell["idhorario"]); 
										if (is_null($operations)){
											$operations = HorarioData::getById($sell["idhorario"]); $reportado = 0; 
											$valor = 'Falta no registrada';
										}else{
											$reportado = $operations->tipo_documen;
											$valor = $operations->tipo;
										}

										echo '<tr>';
											echo '<td><div align="center">'.$sell["fecha"].'</div></td>';
											echo '<td>'.$sell["descripcion"];
												echo '<div class="mini-tabla">';
													echo '<small>';
														echo '<span class="glyphicon glyphicon-briefcase"></span> '.$sell["codigo"].'- Reportado el: '.$sell["created_at"];
													echo '</small>';
												echo '</div>';
											echo '</td>';
											echo '<td>'.$sell["nombre"].'</br>Reportado por: '.$operations->usuario_log.'</td>'; // utf8_encode() '</br>'.$operations->tipo.
											echo '<td>'.$valor.'</td>';
											echo '<td style="width:180px;">';
												if($reportado == 0) // index.php?view=falta&id=
													echo '<div align="center"><a href="index.php?view=falta&id='.$sell["idhorario"].'" class="btn btn-app btn-warnig"><i class="glyphicon glyphicon-plus"></i>Ingresar</a></div>';
												else
													echo '<div align="center"><a href="index.php?view=falta&id='.$sell["idhorario"].'&falta='.$operations->id.'" class="btn btn-app btn-danger"><i class="glyphicon glyphicon-eye-open"></i>Verificar</a></div>';
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

