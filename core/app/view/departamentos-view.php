<?php
$msg = 'Agregar departamento'; $error = '';
$departa = (object) [
					"id" => 0,
					"name" => ""
				];

// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
		if(isset($_GET['id']) && isset($_GET['tipo']) && $_GET['tipo']==2){
			$departa = DepartamentoData::getById($_GET['id']);
			if($departa){
				$msg = 'Modificar categoría'; 
			}else{
				$error = Core::display_msg("danger", "No se encontro el departamento");
			}
		}
        break;
    case 'POST': 
		var_dump($_POST);
		/*
		if(isset($_POST['add_cat'])){	
			$depart = new DepartamentoData();
			$depart->description = strtoupper($_POST["description"]);
			$errors = $depart->add();
			
			if(!empty($errors)){	
				$msg = Core::display_msg("success", "Departamento agregada exitosamente.");
			}else{
				$msg = Core::display_msg("danger", "Lo siento, registro falló");
			} */

		if(count($_POST)>0){
			$user = DepartamentoData::getById($_POST["user_id"]);
			$user->name = strtoupper($_POST["description"]);
			$user->update();
			print "<script>window.location='index.php?view=departamento';</script>";
		}

        break;
	default:
		// Manejar otros métodos HTTP si es necesario
		break;
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
	<div class="row">
		<div class="col-md-12">		
			<div class="row">
				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
								<span class="glyphicon glyphicon-th"></span>
								<span><?php echo $msg; ?></span>
							</strong>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" id="addtask" action="departamentos" role="form">
								<input type="hidden" id="id" name="id" value="<?php echo $departa->id; ?>">
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Departamento" value="<?php echo $departa->name; ?>" required>
									</div>
								</div>
								<button type="submit" name="add_cat" class="btn btn-primary"><?php echo $msg; ?></button>
							</form>	<?php 
							if($error == "") { 
								//Sin Error 
							} else {
								echo '<br>'.$error; 
							} ?>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
							  <span class="glyphicon glyphicon-th"></span>
							  <span>Lista de departamentos</span>
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
										$products = DepartamentoData::getAll();
										// Crea tabla de Ventas
										foreach($products as $tables) {
											echo '<tr>';
												echo '<td width="30%">'.$tables->name.'</td>';
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
														echo '<a href="index.php?view=departamentos&id='.$tables->id.'&tipo=2" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
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
