<?php
$msg = '';

if(isset($_POST['add_cat'])){	
	$depart = new DepartamentoData();
	$depart->description = strtoupper($_POST["description"]);
	$errors = $depart->add();
	
    if(!empty($errors)){	
		$msg = Core::display_msg("success", "Departamento agregada exitosamente.");
	}else{
		$msg = Core::display_msg("danger", "Lo siento, registro falló");
	}
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Departamentos
		<small>listado de los departamentos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content container-fluid" style="padding: 1.5rem !important;">	
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<div class="row">
		<div class="col-md-12">		
			<div class="row">
				<div class="col-md-5">
					<div class="row">
						<div class="col-md-12">
						   <?php echo $msg; ?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
								<span class="glyphicon glyphicon-th"></span>
								<span>Ingresar Departamento</span>
							</strong>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" id="addtask" action="index.php?view=categorias" role="form">				
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="categorie-name" placeholder="Nombre del Departamento" required>
									</div>
								</div>
								<button type="submit" name="add_cat" class="btn btn-primary">Agregar Departamento</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
							  <span class="glyphicon glyphicon-th"></span>
							  <span>Lista de categorías</span>
							</strong>
						</div>
						<div class="panel-body">
							<table id="viewlista" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Departamento</th>
										<th><div align="center">Estados</div></th>
										<th><div align="center">Acciones</div></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$products = DepartamentoData::getDepart();
										// Crea tabla de Ventas
										foreach($products as $tables) {
											echo '<tr>';
												echo '<td width="30%">'.$tables->description.'</td>';
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
												echo '<td width="8%">';
													echo '<div align="center">';
														echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
														echo '<a href="?view=editdepartamento&id='.$tables->id.'" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
													echo '</div>';
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
		</div>
	</div>
</section>
