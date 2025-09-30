<?php
$product = ProductData::getByIdProduct($_GET["id"]);
$categories = EstadoData::getAll();

if($product!=null){
		echo '<div class="row">';
			echo '<div class="col-md-8">';
			echo '<h1>'.$product->producto.'&nbsp;&nbsp;<small>Editar Producto</small></h1>';
		  if(isset($_SESSION["update"]) && $_SESSION["update"] == 1){
		    	echo '<p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>';
		  		setcookie("prdupd","",time()-18600);
					$_SESSION["update"] = 0;
			}
			echo '<br>';
			echo '<form class="form-horizontal" method="post" id="updateserial" enctype="multipart/form-data" action="index.php?view=updateinventario" role="form">';
			  echo '<div class="form-group">';
			    echo '<label for="inputFoto" class="col-lg-3 control-label">Imagen:</label>';
			    echo '<div class="col-md-8">';
						if($product->image!=""){
		        		echo '<img src="storage/products/'.$product->image.'" class="img-responsive">';
							}else{
	              echo '<img src="storage/products/default-50x50.gif" style="width:64px;">';
	            }
		    	echo '</div>';
		  	echo '</div>';
		  	echo '<div class="form-group">';
		    	echo '<label for="inputDescripcion" class="col-lg-3 control-label">Descripci&oacute;n:</label>';
		    	echo '<div class="col-md-8">';
		      	echo '<input type="text" name="name" class="form-control" id="name" value="'.$product->producto.'" placeholder="Reponsable que recibe los equipos">';
		    	echo '</div>';
		  	echo '</div>';
				echo '<div class="form-group">';
		    	echo '<label for="inputSerial" class="col-lg-3 control-label">Serial:</label>';
		    	echo '<div class="col-md-8">';
		      	echo '<input type="text" name="serial" class="form-control" id="serial" value="'.$product->serial.'" placeholder="Serial del equipo entregado">';
		    	echo '</div>';
		  	echo '</div>';
		    echo '<div class="form-group">';
		    	echo '<label for="inputCategoria" class="col-lg-3 control-label">Categoria</label>';
		    	echo '<div class="col-md-8">';
			    	echo '<select name="estado" class="form-control">';
			    		echo '<option value="">-- NINGUNA --</option>';
			    		foreach($categories as $category){
							if($product->estado!=null && $product->estado==$category->id){ $valor = "selected"; } else { $valor = ""; }
							echo '<option value="'.$category->id.'" '.$valor.'>'.utf8_encode($category->description).'</option>';
			    		}
			      	echo '</select>';
					echo '</div>';
		  	echo '</div>';
			echo '<div class="form-group">';
			    echo '<div class="col-lg-offset-3 col-lg-8">';
						echo '<input type="hidden" name="product_id" value="'.$product->idproducto.'">';
			    	echo '<input type="hidden" name="operation_id" value="'.$product->id.'">';
			      echo '<button type="submit" class="btn btn-success">Actualizar Producto</button>';
			    echo '</div>';
			  echo '</div>';
			echo '</form>';
			echo '<br><br><br><br><br><br><br><br><br>';
			echo '</div>';
		echo '</div>';
}else{
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<h1><i class="fa fa-archive"></i> Actualizaci&oacute;n de los productos</h1>';
					echo '<div class="clearfix"></div>';
						echo '<h2>No hay articulos registrados</h2>';
						echo '<p>No se ha registrado ningun ingreso...!!!</p>';
					echo '<br><br><br><br><br><br><br><br><br><br>';
			echo '</div>';
		echo '</div>';
}
