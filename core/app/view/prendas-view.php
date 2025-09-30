<?php
//Activamos almacenamiento en el buffer
$persons = PersonData::getAllTipo(3, 1);
$products = ProductData::getTodos();

//Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        var_dump($_POST);
    	if($_POST["idagente"] == 0){
    	    Core::alert("Error...!!!!", "No se ha seleccionado ningun agente de seguridad...!!!", "error");
    	}else{
            echo '<br>-----------------------------------------------------------------<br>';
            $i = 0; $error = ''; $process==false;
        	$cart = $_POST["idarticulo"];
        	if(count($cart)>0){/*
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
    			} */
        	    foreach($cart as $c){
        	        echo '<br>Articulos: '.$_POST["idarticulo"][$i].'- '.$_POST["cantidad"][$i].'- '.$_POST["precio_venta"][$i].'- '.$_POST["descuento"][$i].'<br>';
        	        
        			$q = OperationData::getQYesF($_POST["idarticulo"][$i]);
        			
                    echo '<br>---- OperationData::getQYesF ---------------------------------------<br>';
                	echo '<br>Cantidad: '.$q.' - '.$_POST["cantidad"][$i];
        			if($_POST["cantidad"][$i]<=$q){
        			    $process=true;
        			}else{
        			    $process=false;
        				$error .= array("product_id"=>$_POST["idarticulo"][$i],"message"=>"No hay suficiente cantidad de producto en inventario.");
        				$errors[count($errors)] = $error;
        			}
        			
        	        $i++;
        	    }
        	    
        	    if($process){     			
        		    Core::alert("Error...!!!!", $errors, "error");
        		}else{
        		    
        		}
        	}else{
            	Core::alert("Error...!!!!", "No hay productos agregados al carrito...!!!", "error");
        	}
    	}
    break;
}

/*
array(7) {
  ["idagente"]=>
  string(3) "310"
  ["fecha_hora"]=>
  string(10) "2024-11-05"
  ["total_venta"]=>
  string(4) "1220"
  ["idarticulo"]=>
  array(3) {
    [0]=>
    string(2) "22"
    [1]=>
    string(2) "30"
    [2]=>
    string(2) "21"
  }
  ["cantidad"]=>
  array(3) {
    [0]=>
    string(1) "1"
    [1]=>
    string(1) "2"
    [2]=>
    string(1) "3"
  }
  ["precio_venta"]=>
  array(3) {
    [0]=>
    string(3) "140"
    [1]=>
    string(3) "240"
    [2]=>
    string(3) "200"
  }
  ["descuento"]=>
  array(3) {
    [0]=>
    string(10) "0568512245"
    [1]=>
    string(9) "012355455"
    [2]=>
    string(9) "096654455"
  }
}
*/

//var_dump($_SESSION);

?>
<section class="content-header">
	<h1>		
		Agentes
		<small>entrega de dotaci&oacute;n</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active"><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li><a href="agentes"> Prendas </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <form class="form-horizontal" method="post" id="addconducta" name="addprendas" action="prendas" role="form">
		<div class="callout callout-danger" style="margin-bottom: 0!important;">
			<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
			Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</div></br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del cliente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
					<div class="col-md-5 col-sm-5">
    					<select name="idagente" id="idagente" class="form-control select2" required>						
    						<?php
    							echo '<option value="0"> -- SELECCIONE -- </option>';
    							foreach($persons as $tables) {
    								if($tables->id == $lugar->idperson) $valor = 'selected'; else $valor = '';
    								echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->name.'</option>';
    							}
    						?>
    					</select>
    				</div>
				</div>
				<div class="form-group">
					<label for="dtp_input1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Fecha de la entrega:</label>
					<div class="col-md-2 col-sm-2">
    					<input class="form-control" type="date" name="fecha_hora" id="fecha_hora" value="<?php echo date("Y-m-d"); ?>">
    				</div>
    			</div>
				<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<a data-toggle="modal" href="#myModal">
					   <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
					</a>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-xs-12">
					 <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
					   <thead style="background-color:#A9D0F5">
						<th width="8%">Opciones</th>
						<th>Articulo</th>
						<th width="8%">Cantidad</th>
						<th width="8%">Precio Venta</th>
						<th width="8%">Serial</th>
						<th width="8%">Subtotal</th>
					   </thead>
					   <tfoot>
						 <th width="8%"></th>
						 <th></th>
						 <th width="8%"></th>
						 <th width="8%"></th>
						 <th width="8%">TOTAL</th>
						 <th width="8%"><h4 id="total">0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
					   </tfoot>
					   <tbody>
						 
					   </tbody>
					 </table>
				</div>
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
				    <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
				</div>
			</div>
		</div>
  	</form>
</section>
<!--Modal-->
<div class="modal fade" tabindex="-1" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content modal-lg modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title">Seleccione un Articulo</h4>
		</div>
		<div class="modal-body">
			<table id="viewDotar" class="table table-bordered table-hover">
				<thead>
    				<tr>
    					<th width="30%"><div align="center" width="50%">Nombre</div></th>
    					<th width="20%"><div align="center">Categoria</div></th>
    					<th width="8%"><div align="center">Precio Salida</div></th>
    					<th width="8%"><div align="center">Stock</br>Actual</div></th>
    					<th width="8%"><div align="center">Acciones</div></th>
    				</tr>
				</thead>
				<tbody>
					<?php
						//Lista de los productos
						foreach($products as $tables) {
							var_dump($tables);
							$serial = ProductData::getSerial($tables->id);										
							$resultado = count($serial); $cadena = '';
							
							if($resultado > 0){										
								$cadena .= '<select name="seriales" id="seriales" class="form-control" data-live-search="true" onchange="buscarDetalle('.$tables->id.', \''.$tables->name.'\', '.number_format($tables->price_out,2,'.',',').')">';
									$cadena .= '<option value="0">Cual...!</option>';
									foreach($serial as $valores) {
										$cadena .= '<option value="'.$valores->id.'">'.$valores->serial.'</option>';
									}
								$cadena .= '</select>';
							}else{
								$cadena = '';
							}
							echo '<tr>'; 
								echo '<td>';
									echo '<a class="text-primary" href="index.php?view=editproduct&id='.$tables->id.'">'.$tables->name.'</a>';
									echo '<div class="mini-tabla">';
									echo '<small>Marca: '.$tables->unit.'</small></br>';
										echo '<small>';
											echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
											echo '<span class="text-success">&nbsp;Activo</span>&nbsp;&nbsp;';
											if($tables->barcode != '') echo '<span class="glyphicon glyphicon-barcode"></span> '.$tables->barcode;
										echo '</small>';
									echo '</div>';
								echo '</td>';
								echo '<td>'.$tables->categoria.'</td>'; //echo $cadena; 
								echo '<td><div align="right">'.number_format($tables->price_out,2,'.',',').'</div></td>';								
								echo '<td><div align="right">'.$tables->getTotal().'</div></td>';
								$valor=$tables->getOperation()->q+$tables->getTotal();
								echo '<td>
										<div align="center">								
											<div class="btn-group">	
												<button class="btn btn-warning" onclick="agregarDetalle('.$tables->id.', \''.$tables->name.'\', '.number_format($tables->price_out,2,'.',',').')"><span class="fa fa-plus"></span></button>
											</div>
										</div>
									  </td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
		    <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>
<!-- fin Modal-->
<script src="scripts/venta.js"></script>
<script>
    var element = document.getElementById("sidai");
 
    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Registro de los Salvoconductos";
	
	$('.fecha_hora').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
</script>