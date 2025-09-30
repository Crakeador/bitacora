<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Operaciones
		<small>listado de los documentos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=rrsdoc.document">
				<span class="glyphicon glyphicon-plus"></span> Ingresar un cliente
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<form id='frmC' name='frmC' method='post' action=''>
				<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
				<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
				<table id="viewlista" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Agente Protector</th>
							<th>Tipo de Documento</th>
							<th><div align="center">Fecha</div></th>
							<th><div align="center">Firmo</div></th>
							<th><div align="center">Reportado el</div></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$users = PuestoData::getBySancion();

						foreach($users as $sell) {
							echo '<tr>';
								echo '<td>'.utf8_encode($sell["nombre"]).'</td>';
								echo '<td>'.$sell["documen"].'</td>';
								echo '<td><div align="center">'.$sell["fecha"].'</div></td>';
								echo '<td width="8%">';
									echo '<small>';
									if($sell["firmo"] == 1){
										echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
										echo '<span class="text-success">Firmo</span>';
									}else{
										echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
										echo '<span class="text-danger">No firmo</span>';
									}
									echo '</small>';
								echo '</td>';
								echo '<td style="width:180px;">';
									echo '<div align="center">'.$sell["created_at"].'</div>';
								echo '</td>';
							echo '</tr>';
						}
					?>
					</tbody>
				</table>
				</form>
		</div>
	</div>
</section>
