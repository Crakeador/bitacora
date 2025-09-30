<?php
$msg = '';

if(isset($_POST['add_cat'])){	
	$user = new CategoryData();
	$user->name = strtoupper($_POST["categorie-name"]);
	$user->description = '';
	$errors = $user->add();
	
    if(!empty($errors)){	
		$msg = Core::display_msg("success", "Categoría agregada exitosamente.");
	}else{
		$msg = Core::display_msg("danger", "Lo siento, registro falló");
	}
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Catalogo
		<small>lista de las categorias registradas</small>
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
								<span>Agregar categoría</span>
							</strong>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" id="addtask" action="index.php?view=categorias" role="form">				
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="categorie-name" placeholder="Nombre de la categoría" required>
									</div>
								</div>
								<button type="submit" name="add_cat" class="btn btn-primary">Agregar categoría</button>
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
										<th>Categorias</th>
										<th><div align="center">Estados</div></th>
										<th><div align="center">Acciones</div></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$products = CategoryData::getAll();
										// Crea tabla de Ventas
										foreach($products as $product) {
											echo '<tr>';
												echo '<td width="30%">'.$product->name.'</td>';
												echo '<td width="6%">';
													echo '<small>';
														if($product->active == 1){
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
														echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$product->id.'\');"><i class="fa fa-trash"></i></button>';
														echo '<a href="index.php?view=editcategory&id='.$product->id.'" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
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
