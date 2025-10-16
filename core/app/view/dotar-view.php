<?php
// Asignacion de Puesto
if($_SESSION["is_admin"] == "1" && $_SESSION["depart"] == "3"){
	Core::redir('home&error=1');
}else{
    $hoy = date("Y-m-d H:i:s"); $cliente_id = 0;
}

$products = ProductData::getPuesto();
$clientes = ClientData::getAll(0);

// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

if(!isset($_SESSION["id_cliente"])) {
    $_SESSION["id_cliente"] = 0;
}else{
    $puestos = PuestoData::getCliente($_SESSION["id_cliente"]);
}
        

switch ($method) {
    case 'GET':
        if(isset($_GET["id"])){
        	$puestos = PuestoData::getCliente($_GET["id"]);
        
        	$id_cliente = $_GET["id"];
        	$_SESSION["id_cliente"] = $id_cliente;
        }
        
        if(isset($_GET["puesto"])){
        	$puestos = PuestoData::getCliente($_SESSION["id_cliente"]);
        	
        	$id_puesto = $_GET["puesto"]; 
        	$_SESSION["id_puesto"] = $id_puesto;
        }
        
        break;
    case 'POST':
        if(isset($_SESSION["cart"])){
        	$cart = $_SESSION["cart"];
        	//var_dump($cart); echo '</br>';
        	if(count($cart)>0){
        		// antes de proceder con lo que sigue vamos a verificar que:
        		// haya existencia de productos
        		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
        		$num_succ = 0;
        		$process=false;
        		$errors = array();
        		foreach($cart as $c){
        			$q = OperationData::getQYesF($c["product_id"]);
        			if($c["q"]<=$q){
        				if(isset($_POST["is_oficial"])){
            				$qyf=OperationData::getQYesF($c["product_id"]); /// son los productos que puedo facturar
            				if($c["q"]<=$qyf){
            					$num_succ++;
            				}else{
                				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto para facturar en inventario.");					
                				$errors[count($errors)] = $error;
            				}
        				}else{
        					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
        					$num_succ++;
        				}
        			}else{
        				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
        				$errors[count($errors)] = $error;
        			}
        		}
        
        		if($num_succ==count($cart)){
        			$process = true;
        		}
        
        		if($process==false){     			
        		    Core::alert("Error...!!!!", $errors, "error");
        		}
        
        		//////////////////////////////////
        		if($process==true){
        			$sell = new SellData();
        			$sell->user_id = $_SESSION["user_id"];
                    $sell->puesto_id = $_SESSION["id_puesto"];
                    
        			$sell->total = $_POST["total"];
        			$sell->discount = $_POST["discount"];
        
    			 	$sell->person_id=$_POST["client_id"];
     				$s = $sell->add_with_puesto();
                    
        			foreach($cart as $c){
        				$op = new OperationData();
        				$op->product_id = $c["product_id"] ;
        				$op->operation_type_id=OperationTypeData::getByName("salida")->id;
        				$op->sell_id = $s[1];
        				$op->q = $c["q"];
        
        				if(isset($_POST["is_oficial"])){
        					$op->is_oficial = 1;
        				}
        
        				$add = $op->add();			 		
        
        				unset($_SESSION["cart"]);
        				setcookie("selled","selled");
        			}
        			
        			if(isset($_GET["valor"])){
        				$puesto = PuestoData::getById($_SESSION["id_puesto"]);
        				$_SESSION["puesto"] = $puesto->descripcion;
        				$_SESSION["valor"] = 1;
        			}else{
        				// Sin comentario
        			}
        			
        			unset($_SESSION["id_cliente"]);
        			unset($_SESSION["id_puesto"]);
        			print "<script>window.location='index.php?view=resumenpuesto&id=$s[1]';</script>"; 
        		}
        	}else{
        		Core::alert("Error...!!!!", "No hay productos agregados al carrito...!!!", "error");
        	}
        }else{
        	if($_POST["idcliente"] == "0"){
        		Core::alert("Error...!!!!", "No hay productos agregados al carrito...!!!", "error");
        	}else{
        		if(count($_POST["idarticulo"])>0){
        			echo 'Total de Ventas: '.count($_POST["idarticulo"]).'</br>';
        			
        			var_dump($_POST);		
        		}
        	}
        }
        break;
    default:
        if(isset($_SESSION["id_cliente"]) || $_SESSION["id_cliente"] > 0){    
            $puestos = PuestoData::getCliente($_SESSION["id_cliente"]);
        }
}

?>
<section class="content-header">
	<h1>
		Dotaci&oacute;n del puesto
	</h1>
	<ol class="breadcrumb">
		<li><a href="puestos"><i class="fa fa-dashboard"></i> Inicio</a></li>
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
		<div class="col-sm-5">
			<div class="box box-success">
				<form role="form" method="post" class="form-horizontal" id="processsell" action="<?php echo $_SESSION['url']; ?>dotar">
					<input type='hidden' name='discount' id='discount' value='0'/>
					<div class="box-body">
						<!--=====================================
						ENTRADA DEL VENDEDOR
						======================================-->
						<div class="col-md-12">
							<div class="form-group">
								<div class="input-group">
								    <span class="input-group-addon"><i class="fa fa-cubes"></i></span>
									<select class="form-control" id="listaCliente" name="listaCliente" onchange="javascript:location.href='index.php?view=dotar&id='+value;" <?php if(isset($_SESSION["id_puesto"]) && $_SESSION["id_puesto"] > 0) echo 'disabled="disabled"'; else echo 'required'; ?>>
										<option value="0" selected="selected"> Selecione el cliente </option>
										<?php
											foreach($clientes as $clients):?>
												<option value="<?php echo $clients->id; ?>" <?php if($clients->id == $_SESSION["id_cliente"]) echo 'selected="selected"'; ?>><?php echo $clients->nombre;?></option>
										<?php endforeach;	?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-university"></i></span>
									<select class="form-control" id="listaPuesto" name="listaPuesto" onchange="javascript:location.href='index.php?view=dotar&puesto='+value;" <?php /* if(isset($_SESSION["id_puesto"]) || $_SESSION["id_puesto"] > 0) echo 'disabled="disabled"'; else echo 'required'; */ ?> <?php if($_SESSION["id_cliente"] == 0) echo 'disabled="disabled"'; else echo 'required'; ?>>
										<option value="0" selected="selected"> Selecione el puesto </option><?php
											foreach($puestos as $puesto){
												if($puesto->id == $_SESSION["id_puesto"]) $valor = 'selected="selected"'; else $valor = '';
												echo '<option value="'.$puesto->id.'" '.$valor.'>'.utf8_encode($puesto->descripcion).'</option>'; // '.$_SESSION["id_puesto"].'
											} ?>
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
												<th style="width: 30%">Total</th>
											</thead>
											<?php
												foreach($_SESSION["cart"] as $p):
													$product = ProductData::getById($p["product_id"]);

													$pt = $product->price_out*$p["q"]; $total += $pt;
													echo '<tr>';
														echo '<td><div align="right">'.$p["q"].'</div></td>';
														echo '<td>'.$product->name.'</td>';
														echo '<td><div align="right">$ '.number_format($product->price_out).'</div></td>';
														echo '<td><div align="right"><b>$ '.number_format($pt).'</b>&nbsp;';
															echo '<a href="'.$_SESSION['url'].'index.php?view=clearcart&valor=2&product_id='.$product->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
														echo '</div></td>';
													echo '</tr>';
												endforeach; ?>
											<tr>
												<td colspan="3">
													<b>Total</b>
												</td>
												<td><div align="right"><b>$ <?php echo $total; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
											</tr>
										</table>
										<input type='hidden' name='total' id='total' value='<?php echo $total; ?>'/>
									</div>
							<?php endif; ?>
						</div>
						<input type="hidden" id="listaProductos" name="listaProductos">
						<!--====================================
						BOTON PARA AGREGAR PRODUCTO
						======================================-->
						<button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
					</div>
					<div class="box-footer">
						<a href="index.php?view=clearcart&valor=2" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
						<button class="btn btn-primary <?php if(isset($_SESSION["id_puesto"]) || $_SESSION["id_puesto"] > 0) echo ''; else echo 'disabled'; ?>"> Asignar Equipo </button>
					</div>
				</form>
			</div>
		</div>
		<!-- LA TABLA DE PRODUCTOS -->
		<div class="col-sm-7 hidden-md hidden-sm hidden-xs">
			<div class="box box-warning">
				<div class="box-body">
					<p><b>Buscar producto por nombre o por codigo:</b></p>
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th><div align="center">Nombre</div></th>
							<th width="8%"><div align="center">Stock</div></th>
							<th width="40%"><div align="center">Entregados</div></th>
						</tr>
						</thead>
						<tbody>
							<?php
								foreach($products as $tables) {
									$q=OperationData::getQYesF($tables->id);
									if($q>0){
										echo '<tr>';
											echo '<td>';
												echo '<a class="text-primary" href="index.php?view=editproduct&id='.$tables->id.'">'.$tables->name.' '.$tables->unit.'</a>';
												echo '<div class="mini-tabla">';
													echo '<small>';
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
														echo '<span class="text-success">&nbsp;Activo</span>&nbsp;&nbsp;';
														echo '<span class="glyphicon glyphicon-barcode"></span> '.$tables->barcode;
													echo '</small>';
												echo '</div>';
											echo '</td>';
											$valor=$tables->getOperation()->q-$tables->getTotal();
											echo '<td><div align="right">'.$q.'</div></td>';
											echo '<td>';
												echo '<form method="post" action="'.$_SESSION['url'].'index.php?view=addtocart&valor=2">';
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
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Dotacion de puesto";

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

