<?php
//Listado de seriales del Producto

$hoy = date("Y-m-d");
if(isset($_GET["id"])){
    $product = ProductData::getById($_GET["id"]);
    $product_id = $_GET["id"];
}else{	
	if(isset($_POST)){
		$product_id = $_POST["product_id"];
				
		if($product_id == 0){			
			Core::redir('productos');
		}else{
		    $product = new ProductData();
			$product->idproduct = $_POST["product_id"];
			$product->description = strtoupper($_POST["description"]);
			$product->fecha = $_POST["fecha"];
			$product->estado = $_POST["estado"];
			$product->serial = strtoupper($_POST["serie"]);
			$product->numero = (int) $_POST["numero"];
			$product->monto = $_POST["impuesto"];
			$product->is_active = 1;

			$error = $product->seriales();
			if($error[0] == 1)
				Core::redir('seriales&id='.$product_id);
			else
				Core::alert("Corrija...!!!!", "- Serial repetido...!!!", "error");
		}
	}else{
		Core::redir('productos');
	}
}

?>
<!-- Ingreso de los seriales de los productos -->
<section class="content-header">
	<h1>		
		Productos
		<small>listado de los productos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=productos"><i class="fa fa-glass"></i> Lista de productos </a></li>
		<li class="active">Seriales</li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="alert alert-danger" style="<?php if(isset($_GET["error"]) == 1) echo ''; else echo 'display:none;'; ?>">
		<strong>hoops!</strong> Hay un problema con sus datos.<br><br>
		<ul>
			<li> Ya hay un serial registrada con este RUC, verifique para continuar.</li>
		</ul>
	</div>
	<div class="row">
		<!-- Dialogo para seleccionar una cuenta -->
		<div class="col-md-12">
			<p class="alert alert-info">
				<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
				- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
			</p>
			<!-- START panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
				</div>
				<div class="panel-body">				
					<!-- box-header 			
					<form class="form-horizontal" method="post" id="addtask" action="index.php?view=seriales" role="form"> -->		
					<form action="index.php?view=seriales" name="formulario" id="formulario" method="POST">
						<div class="form-group col-lg-8 col-md-8 col-xs-12">
							<label for="">Descripci&oacute;n:</label>
							<input class="form-control" type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
							<input class="form-control" type="text" name="description" id="description" maxlength="7" placeholder="Serie">
						</div>
							<div class="form-group col-lg-4 col-md-4 col-xs-12">
							<label for="">Fecha de Vencimiento: </label>
							<input class="form-control" type="date" name="fecha" id="fecha">
						</div>
						<div class="form-group col-lg-6 col-md-6 col-xs-12">
							<label for="">Estados (*): </label>
							<select name="estado" id="estado" class="form-control selectpicker" required>
							   <option value="Nuevo">Nuevo</option>
							   <option value="Usado">Usado</option>
							   <option value="Dañado">Dañado</option>
							   <option value="Otro">Otro</option>
							</select>
						</div>
						 <div class="form-group col-lg-2 col-md-2 col-xs-6">
						  <label for="">Serie (*): </label>
						  <input class="form-control" type="text" name="serie" id="serie" maxlength="7" placeholder="Serie" required>
						</div>
						 <div class="form-group col-lg-2 col-md-2 col-xs-6">
						  <label for="">Número: </label>
						  <input class="form-control" type="text" name="numero" id="numero" maxlength="10" placeholder="Número">
						</div>
						<div class="form-group col-lg-2 col-md-2 col-xs-6">
						  <label for="">Monto: </label>
						  <input class="form-control" type="text" name="impuesto" id="impuesto" value="0">
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-xs-12">
							<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
								<thead style="background-color:#A9D0F5">
									<th>Opciones</th>
									<th>Serial</th>
									<th>Numero</th>
									<th>Descripci&oacute;n</th>
									<th>Comprado</th>
									<th>Monto</th>
								</thead>
								<tbody>
									<?php
										$products = ProductData::getAllSerial($product_id);

										//Lista de los productos
										foreach($products as $tables) {
											echo '<tr>';
												echo '<td>
														<div align="center">								
															<div class="btn-group">
																<button class="btn btn-primary btnImprirCodigoBarras" idproducto="'.$tables->id.'"><i class="fa fa-barcode"></i></button>
																<button class="btn btn-warning btnEditarProducto" idproducto="55" data-toggle="modal" data-target="#modalEditarProducto"><i class="fa fa-pencil"></i></button>
																<button class="btn btn-danger btnEliminarProducto" idproducto="'.$tables->id.'" codigo="NAVIDAD" imagen="vistas/img/productos/default/anonymous.png" codigodir="140877388"><i class="fa fa-times"></i></button>
															</div>
														</div>
													  </td>'; 
												echo '<td><div align="center">'.$tables->serial.'</div></td>';
												echo '<td><div align="center">'.$tables->numero.'</div></td>';
												echo '<td>'.$tables->description.'</td>';					
												echo '<td><div align="center">'.$tables->fecha.'</div></td>';		
												echo '<td><div align="right">'.number_format($tables->monto,2,'.',',').'</div></td>';	
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

