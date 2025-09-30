<?php 
if(isset($_POST) && isset($_POST["id"])){
	$user = CategoryData::getById($_POST["user_id"]);
	$user->name = strtoupper($_POST["name"]);
	$user->description = strtoupper($_POST["description"]);
	$user->update();

	//print "<script>window.location='categorias';</script>";
}

if(isset($_GET["id"])){
	$user = CategoryData::getById($_GET["id"]); 

	if(!is_object($user)){ ?>
		<script type="text/javascript">
			$(document).ready(function(){		
				swal({
					title: "Editar Producto",
					text: 'No se puede editar el producto, no se encontro el mismo...!',
					showCancelButton: false,
					closeOnConfirm: false,
					animation: "slide-from-top"
				}, function(){
					document.location = "categorias";
				});
			});
		</script><?php
	}else{ ?>
		<section class="content-header">
			<h1>
				Categorias
				<small>listado de las categorias</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="categorias"><i class="fa fa-dashboard"></i> Categorias </a></li>
				<li class="active">Editar Categorias</li>
			</ol>
		</section>
		<section class="content" style="padding: 1.5rem !important;">
			<div class="row">
				<div class="box box-primary">
					<div class="box-body box-profile">
					<h1>Editar Categoria</h1>
					<br>
					<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=editcategory" role="form">
						<div class="form-group">
							<label for="inputNombre" class="col-lg-2 control-label">* Nombre:</label>
							<div class="col-md-6">
							<input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre">
							</div>
						</div>
						<div class="form-group">
							<label for="inputDescripcion" class="col-lg-2 control-label">Descripcion:</label>
							<div class="col-md-6">
							<textarea name="description" class="form-control" id="description" placeholder="Descripcion del la categoria"><?php echo $user->description; ?></textarea>
						</div>
				</div>
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
						<button type="submit" class="btn btn-primary">Actualizar Categoria</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</section>
		<script>
			$(document).ready(function(){
				document.title = "Near Solutions | Listado de Productos"
			});
		</script> <?php	
	}
}else{ ?>
	<script type="text/javascript">
		$(document).ready(function(){		
			swal({
				title: "Editar Producto",
				text: 'No se puede editar el producto, no se encontro el mismo...!',
				showCancelButton: false,
				closeOnConfirm: false,
				animation: "slide-from-top"
			}, function(){
				document.location = "categorias";
			});
		});
    </script><?php
}