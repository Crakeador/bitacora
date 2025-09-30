<?php
// Clase de la Tabla de Departamentos
$msg = '';
$local = DepartamentoData::getDepart();

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
		Caja Chica
		<small>lista de las cajas registradas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content container-fluid" style="padding: 1.5rem !important;">	
	<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
	<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>
						<span class="glyphicon glyphicon-th"></span>
						<span>Lista de cajas</span>
					</strong>
				</div>
				<div class="panel-body">
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Departamento</th>
								<th>Monto</th>
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
										echo '<td width="30%">'.$product->name.'</td>';										
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
		<div class="col-md-4">
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
								<label for="nombre">Departamento</label>
								<select class="select-input form-control input-sm" id="id_localidad" name="id_localidad">
									<option value="0" selected="selected"> Selecione... </option>
									<?php
										foreach($local as $locals):?>
											<option value="<?php echo $locals->id; ?>"><?php echo utf8_encode($locals->description);?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="observaciones">Observaciones</label>
								<textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label>Préstamos</label>
								<input type="number" class="form-control" id="prestamos" name="prestamos">
							</div>
							<div class="form-group">
								<label>Sacamos</label>
								<input type="number" class="form-control" id="sacamos" name="sacamos">
							</div>
							<div class="form-group">
								<label>Vasos dañados con licor</label>
								<input type="number" class="form-control" id="vasos_con_licor" name="vasos_con_licor">
							</div>
							<div class="form-group">
								<label>Vasos dañados sin licor</label>
								<input type="number" class="form-control" id="vasos_sin_licor" name="vasos_sin_licor">
							</div>
							<div class="form-group">
								<label>Cuadro Caja?</label>
								<div>
									<button type="button" class="btn btn-success" id="btn-si-cuadro">SI CUADRO CAJA</button>
									<button type="button" class="btn btn-danger" id="btn-no-cuadro">NO CUADRO CAJA</button>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Guardar</button>
							<button type="submit" name="add_cat" class="btn btn-primary">Agregar categoría</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
