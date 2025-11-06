<?php
//Manejo de areas
$msg = 'Agregar areas';
$area = (object) [
					"id" => 0,
					"name" => ""
				];

// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
		if(isset($_GET['id']) && isset($_GET['tipo']) && $_GET['tipo']==2){
			// Manejar la edición de una area
			$area = AreasData::getById($_GET['id']);
			if($area){
				$msg = 'Modificar areas'; 
			}
		}
        // Mostrar la lista de anuncios
        break;
    case 'POST': 
		$user = new AreasData();
		$user->id = $_POST['areas-id'];
		$user->name = strtoupper($_POST["areas-name"]);
		$user->description = '';

		// Manejar la creación de una area
		if(isset($_POST['areas-id']) && $_POST['areas-id']>0){	
			$errors = $user->update();
			
			if(!empty($errors)){	
				$_SESSION['sweetalert_message'] = ['icon' => 'success', 'title' => '¡Éxito!', 'text' => 'Area modificada exitosamente.'];
			}else{
				$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Lo siento el registro falló.'];
			}
		}elseif(isset($_POST['add_cat'])){			
			$errors = $user->add();
			
			if(!empty($errors)){	
				$_SESSION['sweetalert_message'] = ['icon' => 'success', 'title' => '¡Éxito!', 'text' => 'Area agregada exitosamente.'];
			}else{
				$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Lo siento el registro falló.'];
			}
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
		Areas Comunes
		<small>lista de las areas registradas</small>
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
							<form class="form-horizontal" method="post" id="addtask" action="index.php?view=areas" role="form">
								<input type="hidden" name="areas-id" value="<?php echo $area->id; ?>">
								<input type='hidden' name="hid_frmIdrol" value='<?php echo $_SESSION['idrol']; ?>'/>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="areas-name" placeholder="Nombre del área" value="<?php echo $area->name; ?>" required>
									</div>
								</div>
								<button type="submit" name="add_cat" class="btn btn-primary"><?php echo $msg; ?></button>
							</form>
						</div>
					</div> <?php
					if (isset($_SESSION['sweetalert_message'])) {;
						echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js?v=1.0.1"></script>';
						$alert = $_SESSION['sweetalert_message'];
						echo "<script>
								document.addEventListener('DOMContentLoaded', function() {
								swal('".$alert['title']."', '".$alert['text']."', '".$alert['icon']."');
								});
							</script>";
						unset($_SESSION['sweetalert_message']); // Limpia la sesión después de usarla
					} ?>
				</div>
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>
							  <span class="glyphicon glyphicon-th"></span>
							  <span>Lista de las Areas</span>
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
								<tbody>	<?php
									$products = AreasData::getAll(); 
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
													echo '<a href="index.php?view=areas&id='.$product->id.'&tipo=2" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
												echo '</div>';
											echo '</td>';
										echo '</tr>';
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Page specific script -->
<script type='text/javascript'><!--
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
</script>