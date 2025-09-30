<!-- Reabastecimiento -->
<section class="content-header">
	<h1>
		Dotaci&oacute;n del puesto
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Ingresar Compra</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<h1>Reabastecer Inventario</h1>
			<p><b>Buscar producto por nombre o por codigo:</b></p>
			<form>
				<div class="row">
					<div class="col-md-6">
						<input type="hidden" name="view" value="re">
						<input type="text" name="product" class="form-control">
					</div>
					<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-12">
		<div id="show_search_results"></div>
	</div>
	<?php 
	if(isset($_GET["product"])):
		$products = ProductData::getLike($_GET["product"]); // Resultado de las busquedas
		if(count($products)>0){ ?>
			<h3>Resultados de la Busqueda </h3>
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width:200px;">Nombre</th>
					<th>Unidad</th>
					<th style="width:80px;">Precio </th>
					<th style="width:120px;">Estado</th>
					<th style="width:120px;">Serial</th>
					<th style="width:80px;">Fecha Vencido</th>
					<th>Cantidad</th>
					<th style="width:40px;"></th>
				</thead>
				<?php
				$products_in_cero=0;
				foreach($products as $product):
					$q = OperationData::getQYesF($product->id); ?>
					<form method="post" action="index.php?view=addtore">
						<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
							<td><?php echo $product->name; ?></td>
							<td><?php echo $product->unit; ?></td>
							<td><b>$<?php echo $product->price_in; ?></b></td>
							<td>
								<select name="estado" id="estado" class="form-control selectpicker" required>
								   <option value="Nuevo">Nuevo</option>
								   <option value="Usado" selected>Usado</option>
								   <option value="Dañado">Dañado</option>
								   <option value="Otro">Otro</option>
								</select>
							</td>
							<td><input type="text" class="form-control" id="serial" name="serial" value="" title="Serial del equipo"></td>
							<td><input type="date" class="form-control" id="fechafac" name="fechafac" value="<?php echo date(); ?>" title="Debe de ser una fecha valida"></td>
							<td>
								<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
								<input type="" class="form-control" required name="q" placeholder="Cantidad de producto ...">
							</td>
							<td style="width:100px;">
								<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Agregar</button>
							</td>
						</tr>
					</form>
				<?php endforeach;?>
			</table> <?php 
		} ?>
		<br>
		<hr>
		<hr>
		<br>
<?php else: ?>

<?php endif; 

 if(isset($_SESSION["errors"])): ?>
	<h2>Errores</h2>
	<p></p>
	<table class="table table-bordered table-hover">
	<tr class="danger">
		<th>Codigo</th>
		<th>Producto</th>
		<th>Mensaje</th>
	</tr>
	<?php foreach ($_SESSION["errors"]  as $error):
	$product = ProductData::getById($error["product_id"]);
	?>
	<tr class="danger">
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><b><?php echo $error["message"]; ?></b></td>
	</tr>

	<?php endforeach; ?>
	</table>
	<?php
	unset($_SESSION["errors"]);
endif; 

	// Carrito de compras 
	if(isset($_SESSION["reabastecer"])): 
		$total = 0; ?>
		<h2>Lista de Reabastecimiento</h2>
		<table class="table table-bordered table-hover">
			<thead>
				<th style="width:30px;">Codigo</th>
				<th style="width:30px;">Marca</th>
				<th>Producto</th>
				<th style="width:120px;">Estado</th>
				<th style="width:120px;">Serial</th>
				<th style="width:80px;">Fecha Vencido</th>
				<th style="width:30px;">Cantidad</th>
				<th style="width:80px;">Precio Unitario</th>
				<th style="width:80px;">Precio Total</th>
				<th ></th>
			</thead>
			<?php 
			foreach($_SESSION["reabastecer"] as $p):
				$product = ProductData::getById($p["product_id"]);	?>
				<tr >
					<td><?php echo $product->id; ?></td>
					<td><?php echo $product->unit; ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php echo $p["estado"]; ?></td>
					<td><?php echo $p["serial"]; ?></td>
					<td><?php echo $p["fechafac"]; ?></td>
					<td><?php echo $p["q"]; ?></td>
					<td><b>$ <?php echo number_format($product->price_in); ?></b></td>
					<td><b>$ <?php  $pt = $product->price_in*$p["q"]; $total +=$pt; echo number_format($pt); ?></b></td>
					<td style="width:30px;"><a href="index.php?view=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
				</tr> <?php 
			endforeach; ?>
		</table>
		<form method="post" class="form-horizontal" id="processsell" action="index.php?view=processre">
			<h2>Resumen</h2>
			<div class="form-group">
				<label for="inputProveedor" class="col-lg-2 control-label">Proveedor</label>
				<div class="col-lg-10">
					<?php
						$clients = ProviderData::getProviders(); 
					?>
					<select name="client_id" class="form-control">
						<option value="">-- NINGUNO --</option>
						<?php	
						foreach($clients as $client):  ?>
							<option value="<?php echo $client->id;?>"><?php echo $client->nombre;?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputMoney" class="col-lg-2 control-label">Efectivo</label>
				<div class="col-lg-10">
				  <input type="text" name="money" required class="form-control" id="money" placeholder="Efectivo">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-6">
					<table class="table table-bordered">
						<tr>
							<td><p>Subtotal</p></td>
							<td><p><b>$ <?php echo number_format($total*.84); ?></b></p></td>
						</tr>
						<tr>
							<td><p>IVA</p></td>
							<td><p><b>$ <?php echo number_format($total*.16); ?></b></p></td>
						</tr>
						<tr>
							<td><p>Total</p></td>
							<td><p><b>$ <?php echo number_format($total); ?></b></p></td>
						</tr>
					</table>
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
						  <div class="checkbox">
							<label>
							  <input name="is_oficial" type="hidden" value="1">
							</label>
						  </div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
						  <div class="checkbox">
							<label>
							<a href="index.php?view=clearre" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
							<button class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Procesar Reabastecimiento</button>
							</label>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script>
			$("#processsell").submit(function(e){
				money = $("#money").val();
				if(money<<?php echo $total;?>){
					alert("No se puede efectuar la operacion "+money+" - "+<?php echo $total;?>);
					e.preventDefault();
				}else{
					go = confirm("Cambio: $"+(money-<?php echo $total;?>));
					if(go){}
						else{e.preventDefault();}
				}
			});
		</script>
		<br><br><br><br><br> <?php 
	endif; ?>
</div>
</section>