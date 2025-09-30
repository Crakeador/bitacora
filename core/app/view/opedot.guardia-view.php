<?php
// Entrega de dotacion de Guardia 
if($_SESSION["is_admin"] == "1" && $_SESSION["depart"] == "3"){
	Core::redir('home&error=1');
}else{
  date_default_timezone_set('America/Guayaquil');
  $hoy = date("Y-m-d H:i:s"); $cliente_id = 0;
}
$products = ProductData::getAgente();
$clientes = ClientData::getAll(0);

if(isset($_GET["person"])){
  	$_SESSION["id_person"] = $_GET["person"];
}else{
  	if(!isset($_SESSION["id_person"])) $_SESSION["id_person"] = 0;
}

if(isset($_GET["id"])){
  	$puestos = PuestoData::getCliente($_GET["id"]);
	$id_cliente = $_GET["id"];
	$_SESSION["id_cliente"] = $id_cliente;
}else{
	if(!isset($_SESSION["id_cliente"])) $_SESSION["id_cliente"] = 0;
}

if(isset($_GET["puesto"])){
	$puestos = PuestoData::getCliente($_SESSION["id_cliente"]);
	$tipo = PuestoData::getByIdHorario($_GET["puesto"], 3, 1);
	$id_puesto = $_GET["puesto"]; 
	$_SESSION["id_puesto"] = $id_puesto;

	if(isset($tipo)){
		$rowCount = count($tipo); $var = ''; $valor = '';
		for ($i = 0; $i < $rowCount; $i++) {
			$var .= '<option value="'.$tipo[$i]["id"].'" '.$valor.'>'.utf8_encode($tipo[$i]["nombre"]).'</option>';
		}
	}
}else{
	if(!isset($_SESSION["id_puesto"])) $_SESSION["id_puesto"] = 0;	

	$puestos = PuestoData::getCliente($_SESSION["id_cliente"]);
	$tipo = PuestoData::getByIdHorario($_SESSION["id_puesto"], 3, 1);

	if(isset($tipo)){
		$rowCount = count($tipo); $var = ''; 
		for ($i = 0; $i < $rowCount; $i++) {
			if($tipo[$i]["id"] == $_SESSION["id_person"]) $valor = 'selected="selected"'; else $valor = '';
			$var .= '<option value="'.$tipo[$i]["id"].'" '.$valor.'>'.$tipo[$i]["nombre"].'</option>';
		}
	}
}

?>
<section class="content-header">
	<h1>
		Dotaci&oacute;n del agente
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Ingresar Compra</li>
	</ol>
</section>
<div class="box-header with-border">
	<div class="alert alert-danger" style="<?php if(isset($_SESSION["errors"])) echo ''; else echo 'display:none;'; ?>">
		<strong>Error...!!!</strong> Hay un problema con sus datos.<br><br>
		<ul>
			<li><?php if(isset($_SESSION["errors"])) echo $_SESSION["errors"][0]["message"] ?></li>
		</ul>
		<?php if(isset($_SESSION["errors"])) unset($_SESSION["errors"]); ?>
	</div>
</div>
<section class="content">
	<div class="row">
		<!-- EL FORMULARIO -->
		<div class="col-lg-5">
			<div class="box box-success">
				<form role="form" method="post" class="form-horizontal" id="processsell" action="index.php?view=processsell&valor=2">
					<input type='hidden' name='discount' id='discount' value='0'/>
					<div class="box-body">
						<!--=====================================
						ENTRADA DEL VENDEDOR
						======================================-->
						<div class="col-md-12">
							<div class="form-group">
								<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-bank"></i></span>
									<select class="form-control" id="listaCliente" name="listaCliente" onchange="javascript:location.href='index.php?view=opedot.guardia&id='+value;" required>
										<option value="0" selected="selected"> Selecione el cliente </option>
										<?php
											foreach($clientes as $clients):?>
												<option value="<?php echo $clients->idclient; ?>" <?php if($clients->idclient == $_SESSION["id_cliente"]) echo 'selected="selected"'; ?>><?php echo $clients->nombre;?></option>
										<?php endforeach;	?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-newspaper-o"></i></span>
									<select class="form-control" id="listaPuesto" name="listaPuesto" onchange="javascript:location.href='index.php?view=opedot.guardia&puesto='+value;" required>
										<option value="0" selected="selected"> Selecione el puesto </option>
										<?php
											if(isset($puestos)){
												foreach($puestos as $puesto){
													if($puesto->id == $_SESSION["id_puesto"]) $valor = 'selected="selected"'; else $valor = '';
													echo '<option value="'.$puesto->id.'" '.$valor.'>'.utf8_encode($puesto->descripcion).'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users"></i></span>
									<select class="form-control" id="client_id" name="client_id" onchange="javascript:location.href='index.php?view=opedot.guardia&person='+value;" required>
										<option value="0" selected="selected"> Selecione el agente </option>
										<?php echo $var; ?>
									</select>
								</div>
							</div>
						</div>
						<!-- Productos Comprados -->
						<div class="form-group row nuevoProducto">
							<?php
								// Carrito de compras
								if(isset($_SESSION["cart"])):
									$total = 0; ?>
									<div class="col-md-12">
										<h3>Lista de articulos</h3>
										<table class="table table-bordered table-hover">
											<thead>
												<th>Cant</th>
												<th>Producto</th>
												<th>Precio</th>
												<th style="width: 20%">Total</th>
											</thead>
											<?php
												foreach($_SESSION["cart"] as $p):
													$product = ProductData::getById($p["product_id"]);
													$pt = $product->price_out*$p["q"]; $total += $pt;
													echo '<tr>';
														echo '<td>'.$p["q"].'</td>';
														echo '<td>'.$product->name.'</td>';
														echo '<td><div align="right">$ '.number_format($product->price_out).'</div></td>';
														echo '<td><div align="right"><b>$ '.number_format($pt).'</b>&nbsp;';
															echo '<a href="index.php?view=clearcart&valor=1&product_id='.$product->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
														echo '</div></td>';
													echo '</tr>';
												endforeach; ?>
												<tr>
													<td colspan="3">
														<b>Total</b>
													</td>
													<td><b>$ <?php echo $total; ?></b></td>
												</tr>
										</table>
										<input type='hidden' name='total' id='total' value='<?php echo $total; ?>'/>
									</div>
							<?php endif; ?>
						</div>
						<input type="hidden" id="listaProductos" name="listaProductos">
						<!--====================================
						BOTÓN PARA AGREGAR PRODUCTO
						======================================-->
						<button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
					</div>
					<div class="box-footer">
						<a href="index.php?view=clearcart&valor=1" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
						<button class="btn btn-primary"> Asignar Equipo </button>
					</div>
				</form>
			</div>
		</div>
		<!-- LA TABLA DE PRODUCTOS -->
		<div class="col-lg-7 hidden-md hidden-sm hidden-xs">
			<div class="box box-warning">
				<div class="box-body">
					<p><b>Buscar producto por nombre o por codigo:</b></p>
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th width="10%"><div align="center">Imagen</div></th>
							<th><div align="center">Nombre</div></th>
							<th width="8%"><div align="center">Stock</div></th>
							<th><div align="center">Entregados</div></th>
						</tr>
						</thead>
						<tbody>
							<?php
								foreach($products as $tables) {									
									$q=OperationData::getQYesF($tables->id);
									if($q>0){
										echo '<tr>';
											echo '<td>';
												echo '<div align="center">';
												if($tables->image!="")
														echo '<img src="storage/products/'.$tables->image.'" style="width:64px;">';
													else
														echo '<img src="storage/products/default-50x50.gif" style="width:64px;">';
												echo '</div>';
											echo '</td>';
											echo '<td>';
												echo '<a class="text-primary" href="index.php?view=editproduct&id='.$tables->id.'">'.$tables->name.'</a>';
												echo '<div class="mini-tabla">';
													echo '<small>';
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
														echo '<span class="text-success">&nbsp;Activo</span>&nbsp;·&nbsp;';
														echo '<span class="glyphicon glyphicon-barcode"></span> '.$tables->barcode;
													echo '</small>';
												echo '</div>';
											echo '</td>';
											$valor=$tables->getOperation()->q-$tables->getTotal();
											echo '<td><div align="right">'.$q.'</div></td>';
											echo '<td>';
												echo '<form method="post" action="index.php?view=addtocart&valor=1">';
													echo '<input type="hidden" name="product_id" value="'.$tables->id.'">';
													echo '<div class="input-group">';
														echo '<input type="" class="form-control" required name="q" placeholder="Cantidad ...">';
														echo '<span class="input-group-btn">';
																echo '<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>';
														echo '</span>';
													echo '</div>';
												echo '</form>';
											echo '</td>';
										echo '</tr>';
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		//recargarLista();
		$('#listaCliente').change(function(){
			$valor = $('#listaCliente').val();
			//alert($valor);
		});
	})
</script>
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"ajax/puestos.php",
			data:"idclient=" + $('#listaCliente').val(),
			success:function(r){
				$('#listaCliente').html(r);
			}
		});
	}
</script>
