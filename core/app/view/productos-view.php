<?php
//Listado de los productos del inventario
$categories = CategoryData::getAll();
/*
var_dump($_GET);
echo '<br>-----------------------------------------------------<br>';
var_dump($_POST); */

$products = ProductData::getTodos();

if(isset($_GET)){
    if(isset($_GET['id']) && $_GET['id'] > 0){ 
        $products = ProductData::delById($_GET['id']);
        
        Core::redir('productos');
    }
    
    if(isset($_GET['category']) && $_GET['category'] > 0) $products = ProductData::getCategoria($_GET['category']);
}

if(count($_POST)>0){
    $product = new ProductData();
    $product->barcode = $_POST["barcode"];
    $product->name = $_POST["name"];
    $product->price_in = $_POST["price_in"];
    $product->price_out = $_POST["price_out"];
    $product->unit = $_POST["unit"];
    $product->presentation = $_POST["presentation"];
    $product->description = ""; //$_POST["description"];

    $category_id="NULL";

    if($_POST["category_id"]!=""){ $category_id=$_POST["category_id"];}

    $inventary_min="\"\"";

    if($_POST["inventary_min"]!=""){ $inventary_min=$_POST["inventary_min"];}

    $product->category_id=$category_id;
    $product->inventary_min=$inventary_min;
    $product->user_id = $_SESSION["user_id"];
    
    if(isset($_FILES["image"]) &&  $_FILES["image"]["name"] != ''){
        $image = new Upload($_FILES["image"]);
        
        if($image->uploaded){		
        $image->Process("storage/products/");

        if($image->processed){
            $product->image = $image->file_dst_name;
            $prod = $product->add_with_image();
        }
        }else{
            $prod=$product->add();
        }
    }else{
        $prod=$product->add();
    }

    if($_POST["q"]!="" || $_POST["q"]!="0"){
        if(!isset($_SESSION['id_puesto'])) $_SESSION['id_puesto'] = 0;
        $op = new OperationData();
        $op->product_id = $prod[1] ;
        $op->operation_type_id = OperationTypeData::getByName("entrada")->id;
        $op->q = $_POST["q"];	
        $op->idpuesto="NULL";
        $op->sell_id="NULL";
        $op->is_oficial=1;
        
        $op->add();
    }
    Core::redir('productos');
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>		
		Productos
		<small>listado de los productos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active">Administrar productos</li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
        	<div class="row">
                <div class="col-md-3 col-xs-12">
        			<input type="text" class="form-control" placeholder="Buscar por código" id="product_code" onkeyup="load(1);">
        		</div>
        		<div class="col-md-3 col-xs-12">
        			<input type="text" class="form-control" placeholder="Buscar por nombre" id="q" onkeyup="load(1);">
        		</div>
        		<div class="col-md-3 col-xs-12">
        			<div class="input-group">
    					<select name="category_id" class="form-control" onchange="javascript:location.href='index.php?view=productos&category='+value;">
							<option value="">-- NINGUNA --</option>
							<?php foreach($categories as $category):?>
							  <option value="<?php echo $category->id;?>"><?php echo utf8_encode($category->name);?></option>
							<?php endforeach;?>
                        </select>
        				<span class="input-group-btn">
        				<button class="btn btn-default" type="button" onclick="load(1);"><i class="fa fa-search"></i></button>
        			  </span>
        			</div><!-- /input-group -->
        		</div>
        		<div class="col-xs-1">
        			<div id="loader" class="text-center"></div>
        		</div>
        		<div class="col-xs-2 ">
        			<div class="btn-group pull-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarProducto">
            			    <span class="glyphicon glyphicon-plus"></span> Nuevo
            			</button>
        			</div>
                </div>
        		<input type="hidden" id="per_page" value="15">
            </div>
		</div>
		<div class="box-body">			
			<table id="viewlista" class="table table-bordered table-hover">
				<thead>
				<tr>
					<!-- th><div align="center" width="6%">Imagen</div></th -->
					<th><div align="center" width="50%">Nombre</div></th>
					<th><div align="center">Categoria</div></th>
					<th width="8%"><div align="center">Precio Entrada</div></th>
					<th width="8%"><div align="center">Precio Salida</div></th>
					<th width="8%"><div align="center">Stock</br>Actual</div></th>
					<th width="8%"><div align="center">Acciones</div></th>
				</tr>
				</thead>
				<tbody>
					<?php
						//Lista de los productos
						foreach($products as $tables) {
							echo '<tr>'; /*
								echo '<td>';
									echo '<div align="center">';
										if($tables->image!="")
											echo '<img src="storage/products/'.$tables->image.'" style="width:64px;">';
										else
											echo '<img src="storage/products/default-50x50.gif" style="width:64px;">';
									echo '</div>';
								echo '</td>'; */
								echo '<td>';
									echo '<a class="text-primary" href="index.php?view=editproduct&id='.$tables->id.'">'.$tables->name.'</a>';
									echo '<div class="mini-tabla">';
									echo '<small>Marca: '.$tables->unit.'</small></br>';
										echo '<small>';
											echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>';
											echo '<span class="text-success">&nbsp;Activo</span>&nbsp;·&nbsp;';
											if($tables->barcode != '') echo '<span class="glyphicon glyphicon-barcode"></span> '.$tables->barcode;
										echo '</small>';
									echo '</div>';
								echo '</td>';
								echo '<td>';
									if($tables->category_id!=null){
										echo utf8_encode($tables->getCategory()->name);
									}else{
										echo "Sin Categoria"; }
								echo '</td>';
								echo '<td><div align="right">'.number_format($tables->price_in,2,'.',',').'</div></td>';
								echo '<td><div align="right">'.number_format($tables->price_out,2,'.',',').'</div></td>';								
								echo '<td><div align="right">'.$tables->getTotal().'</div></td>';
								$valor=$tables->getOperation()->q+$tables->getTotal();
								echo '<td>
										<div align="center">								
											<div class="btn-group">											
												<a href="index.php?view=seriales&id='.$tables->id.'" class="btn btn-xs btn-warning"><i class="fa fa-barcode"></i></a>
												<a href="index.php?view=editproduct&id='.$tables->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>
												<button type="button" class="btn btn-xs btn-danger btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', \''.$tables->is_active.'\');"><i class="fa fa-trash"></i></button>
											</div>
										</div>
									  </td>'; // .$tables->getOperation()->q			
							echo '</tr>';
						}
					?>
				</tbody>
			</table>		
		</div>			
	</div>
</section>
<!--=====================================
Modal de Ventas
======================================-->
<div id="modalVentasEstilo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            CABEZA DEL MODAL
            ======================================-->
            <div class="modal-header" style="background:#3c8dbc; color:white">

                <button type="button" class="close" data-dismiss="modal">×</button>

                <h4 class="modal-title">Selecione Mes para realizar el reporte</h4>

            </div>
            <form method="POST" action="http://posinventario.tresniveles.com/extensiones/tcpdf/pdf/VentasPorEstilo.php" target="_blank">  
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="col-lg-6">
                        <select name="mes" class="form-control" required="required">
                            <option value="">Elija Mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="year" required="">
                            <option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>                        </select>
                        <hr>     
                    </div>
                </div>

                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-success pull-right">Enviar</button>
                </div>    
            </form>
        </div>
    </div>
</div>
<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->
<div id="modalAgregarProducto" class="modal fade" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=productos" role="form">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Agregar producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <!-- ENTRADA PARA SUBIR FOTO -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="nuevaImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="storage/products/producto-default.jpg" class="img-thumbnail previsualizar" width="200%">
                            </div>
                        </div>
                        <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
									<select name="category_id" class="form-control">
										<option value="">-- NINGUNA --</option>
										<?php foreach($categories as $category):?>
										  <option value="<?php echo $category->id;?>"><?php echo utf8_encode($category->name);?></option>
										<?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA CODIGO DE BARRA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 
                                    <input type="text" class="form-control input-lg" id="barcode" name="barcode" min="0" placeholder="Ingrese el codigo">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL NOMBRE -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-suitcase"></i></span> 
                                    <input type="text" class="form-control input-lg" name="name" id="name" placeholder="Ingrese nombre del producto" required="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL CÓDIGO -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                                    <input type="text" class="form-control input-lg" id="unit" name="unit" placeholder="Ingresar marca" required="" autofocus="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA STOCK -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span> 
                                    <input type="text" class="form-control input-lg" id="presentation" name="presentation" placeholder="Ingresar modelo">
                                </div>
                                <br>
                            </div>
                        </div>
                        <!-- ENTRADA PARA STOCK -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                    <input type="number" class="form-control input-lg" id="q" name="q" min="0" placeholder="Stock" maxlength="50" required="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" id="price_in" name="price_in" step="any" min="1" placeholder="Precio de compra" required="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" id="price_out" name="price_out" step="any" min="1" placeholder="Precio de salida" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                PIE DEL MODAL
                ======================================-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->
<div id="modalEditarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Editar producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SUBIR FOTO -->
                            <div class="form-group">
                                <div class="panel">SUBIR IMAGEN</div>
                                <input type="file" class="nuevaImagen" name="editarImagen">
                                <p class="help-block">Peso máximo de la imagen 2MB</p>
                                <img src="storage/products/default-50x50.gif" class="img-thumbnail previsualizar" width="350px">
                                <input type="hidden" name="imagenActual" id="imagenActual">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <select class="form-control input-lg" name="editarCategoria" required="">
                                        <option id="editarCategoria"></option>
                                        <option value="">Selecionar categoría</option>
                                        <option value="37">Regalos</option><option value="36">Regalos</option><option value="35">Panetones</option><option value="34">Utiles escolares</option><option value="33">hola</option><option value="32">Mouse</option><option value="31">FRIOS</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <input type="text" class="form-control input-lg" name="descripcion_edit" id="descripcion_edit" placeholder="Ingrese nombre" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">
                            <font color="red"><h5 style="font-weight: bold;">Seleccione Clave de producto SAT:</h5></font>
                            <div class="form-group">
                                <input type="text" name="buscadorsat3" id="buscadorsat3" onkeyup="busquedaclavessatproductosedicion()" placeholder="Ingrese nombre o clave del sat..." class="form-control input-lg">
                                <div id="displaybusquedasatproduc2" class="row" style="padding:5px 15px; z-index:100000000; position: absolute; background-color: #fff; width: 100%"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6" style="display: none;">
                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                                    <input type="text" step="any" class="form-control input-lg" id="editCategoriaSat" name="editCategoriaSat" placeholder="Esperando clave de producto del sat..." onkeypress="return false;">
                                    <input type="hidden" id="sat_Unidad_edita" name="sat_Unidad_edita">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA EL CÓDIGO -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                                    <input type="hidden" class="form-control input-lg" id="idEditarPro" name="idEditarPro" readonly="" required="">
                                    <input type="hidden" class="form-control input-lg" id="codigoDir" name="codigoDir" required="">
                                    <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" onchange="valiCodEdita();" required="" placeholder="Código del producto">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA STOCK -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                    <input type="number" class="form-control input-lg" id="traerStock" name="traerStock" placeholder="Stock del producto" min="0" readonly="readonly">
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA STOCK -->
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" placeholder="Agregar stock al producto" min="0" value="0" required="required">
                                    <input type="hidden" class="form-control input-lg" id="editarStock_gnrl" name="editarStock_gnrl" placeholder="Agregar stock al producto" min="0" value="0" required="required">
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editMaximo" name="editMaximo" min="0" placeholder="Ingrese máximo">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editMinimo" name="editMinimo" min="0" placeholder="Ingrese minimo">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO COMPRA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" placeholder="Precio de compra" step="any" min="0" required="">
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO VENTA -->
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Precio 1<i class="fa fa-usd"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Precio 2<i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta2" name="editarPrecioVenta2" step="any" min="0" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Precio 3<i class="fa fa-arrow-down"></i></span> 
                                    <input type="number" class="form-control input-lg" id="editarPrecioVenta3" name="editarPrecioVenta3" step="any" min="0" required="">
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				<!--=====================================
				PIE DEL MODAL
				======================================-->
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
				</div>
			</form>    
		</div>
	</div>
</div>
<script type='text/javascript'><!--
	document.title = "Near Solutions | Listado de Productos"
	
	function btn_EnviarOnClick($id, $is_active) {
		var valor = <?php echo $_SESSION['is_admin']; ?>;

		if(valor == "0"){
			sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		}else{
		 	if($is_active == "1"){
				swal({
				   title: "Esta usted seguro?",
				   text: "No se puede recuperar el archivo despues de borrado...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, borralo...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				},
				function(isConfirm){
				   if (isConfirm) {					   
						window.location.href = "index.php?view=productos&id="+$id;
						swal({
							  title: "Registro borrado...!",
							  text: "Se elimino el registro seleccionado.",
							  timer: 6000,
							  showConfirmButton: false
							});
				    } else {
				 	    swal("Cancelado", "Se cancelo el borrado el registro", "error");
				    }
				});
			}else{
				swal({
				   title: "Esta usted seguro?",
				   text: "Se puede recuperar el archivo despues de borrado...!",
				   type: "warning",
				   showCancelButton: true,
				   confirmButtonColor: "#DD6B55",
				   confirmButtonText: "Si, recuperalo...!",
				   cancelButtonText: "No, cancelar...!",
				   closeOnConfirm: false,
				   closeOnCancel: false
				},
				function(isConfirm){
				    if (isConfirm) {
						 swal({
							  title: "Registro recuperado...!",
							  text: "Se recupero el registro seleccionado.",
							  timer: 6000,
							  showConfirmButton: false
							});
							window.location.href = "index.php?view=productos&id="+$id;
				    } else {
				 	    swal("Cancelado", "Se cancelo la activicion del registro", "error");
				    }
				});
			}
		}
	} //--
</script>
