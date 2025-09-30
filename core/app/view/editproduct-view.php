<?php
if(isset($_POST) && isset($_POST["id"])){
	$product = ProductData::getById($_POST["product_id"]);

	$product->barcode = $_POST["barcode"];
	$product->name = strtoupper($_POST["name"]);
	$product->price_in = $_POST["price_in"];
	$product->price_out = $_POST["price_out"];
	$product->unit = strtoupper($_POST["unit"]);
  	$product->description = strtoupper($_POST["description"]);
  	$product->presentation = strtoupper($_POST["presentation"]);
  	$product->inventary_min = $_POST["inventary_min"];

  	$category_id="NULL";
  	if($_POST["category_id"]!=""){ $category_id=$_POST["category_id"];}

  	$is_active=0;
  	if(isset($_POST["is_active"])){ $is_active=1;}

  	$product->is_active=$is_active;
  	$product->category_id=$category_id;

	$product->user_id = $_SESSION["user_id"];
	$product->update();

	if(isset($_FILES["image"])){
		$image = new Upload($_FILES["image"]);
		if($image->uploaded){
			$image->Process("storage/products/");
			if($image->processed){
				$product->image = $image->file_dst_name;
				$product->update_image();
			}
		}
	}

	setcookie("prdupd","true");
	Core::redir('productos');
}

if(isset($_GET["id"])){
	$product = ProductData::getById($_GET["id"]);
	$categories = CategoryData::getAll();

	if(!is_object($product)){ ?>
		<script type="text/javascript">
			$(document).ready(function(){		
				swal({
					title: "Editar Producto",
					text: 'No se puede editar el producto, no se encontro el mismo...!',
					showCancelButton: false,
					closeOnConfirm: false,
					animation: "slide-from-top"
				}, function(){
					document.location = "index.php?view=productos";
				});
			});
		</script><?php
	}else{ ?>
		<section class="content-header">
			<h1>		
				Productos
				<small>listado de los productos</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="index.php?view=productos"><i class="fa fa-dashboard"></i> Productos </a></li>
				<li class="active">Administrar productos</li>
			</ol>
		</section>
		<section class="content" style="padding: 1.5rem !important;">
			<div class="row">		
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="box box-primary">
						<div class="box-body box-profile">
							<div id="load_img">	<?php
								if($product->image!=""):?>
									<br>
									<img src="storage/products/<?php echo $product->image;?>" class="img-responsive" alt="Imagen de producto"> <?php
								else:	?>								
									<div class="form-group">
										<div class="panel">SUBIR IMAGEN</div>
										<input type="file" class="nuevaImagen" name="editarImagen">
										<p class="help-block">Peso máximo de la imagen 2MB</p>
										<img src="storage/products/default-50x50.gif" class="img-thumbnail previsualizar" width="350px">
										<input type="hidden" name="imagenActual" id="imagenActual">
									</div> <?php
								endif;	?>
							</div>
							<h3 class="profile-username text-center"><?php echo $product->name;?></h3>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box --> 
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					<form name="update_register" id="update_register" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">Detalles del producto</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="details">
									<div class="form-group ">
										<label for="barcode" class="col-sm-2 control-label">Código</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $product->barcode; ?>" placeholder="Codigo de barras del Producto">
										</div>		
										<label for="unit" class="col-sm-2 control-label">Modelo</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="unit" name="unit" value="<?php echo $product->unit; ?>" placeholder="Modelo del Producto">
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">Nombre</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="name" name="name" value="<?php echo $product->name;?>" required="">
										</div>
										<label for="presentation" class="col-sm-2 control-label">Marca</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="presentation" name="presentation" value="<?php echo $product->presentation; ?>" placeholder="Presentacion del Producto">
										</div>				
									</div>
									<div class="form-group">
										<label for="note" class="col-sm-2 control-label">Descripción</label>
										<div class="col-sm-10">
											<textarea name="description" class="form-control" id="description" placeholder="Descripcion del Producto"><?php echo $product->description;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="inventary_min" class="col-sm-2 control-label">Inventario Minimo</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="inventary_min" name="inventary_min" value="<?php echo $product->inventary_min; ?>" placeholder="Unidad minima del Producto" pattern="\d{1,4}" maxlength="4">
										</div>
										<label for="category_id" class="col-sm-2 control-label">Categoría</label>
										<div class="col-sm-4">
											<select class="form-control" name="category_id" id="category_id" required>
												<option value="">-- NINGUNA --</option>
												<?php foreach($categories as $category):?>
													<option value="<?php echo $category->id;?>" <?php if($product->category_id!=null&& $product->category_id==$category->id){ echo "selected";}?>><?php echo utf8_encode($category->name);?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="buying_price" class="col-sm-2 control-label">Costo</label>
										<div class="col-sm-4">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-usd"></i>
												</div>
												<input type="text" class="form-control" id="price_in" name="price_in" value="<?php echo $product->price_in; ?>" placeholder="Precio de entrada" pattern="\d+(\.\d{2})?"	 title="precio con 2 decimales" required>
											</div>
										</div>					
										<label for="profit" class="col-sm-2 control-label">Utilidad</label>
										<div class="col-sm-4">
											<div class="input-group">
												<div class="input-group-addon">
													<strong>%</strong>
												</div>
												<input type="text" class="form-control" id="profit" name="profit" value="20" required="" pattern="\d{1,4}" maxlength="4">
											</div>
										</div>				
									</div>                  
									<div class="form-group">
										<label for="selling_price" class="col-sm-2 control-label">Precio de venta</label>
										<div class="col-sm-4">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-usd"></i>
												</div>
												<input type="text" class="form-control" id="price_out" name="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio de venta" pattern="\d+(\.\d{2})?" title="precio con 2 decimales" required>
											</div>
										</div>
										<label for="status" class="col-sm-2 control-label">Estado</label>
										<div class="col-sm-4">
											<select class="form-control" name="status" id="status">
												<option value="1" selected="selected">Activo</option>
												<option value="0">Inactivo</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-6">
											<button type="submit" class="btn btn-primary actualizar_datos">Guardar datos</button>
										</div>
									</div>							
								</div><!-- /.tab-pane -->							
							</div><!-- /.tab-content -->
						</div><!-- /.nav-tabs-custom -->
					</form>
				</div><!-- /.col -->
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
				document.location = "index.php?view=productos";
			});
		});
    </script><?php
}
