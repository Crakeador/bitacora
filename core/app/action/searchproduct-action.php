<?php 
/*
* Modulo de Operaciones para el registro del horaio de los agentes en puestos activos
* Modificado: 10/10/2023
*/
ini_set('max_input_vars', 5000);

//var_dump($_POST);
if(count($_POST)>0){
	echo '<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
	      <script type="text/javascript">
			swal("Excelente", "Se actualizaron los registros", "success");
		  </script>';
	foreach($_POST as $nombre_campo => $valor){
		if(strlen($valor)>6){
			$valor = explode("-", $valor);
			
			if($valor[0] == 0) {
				$user = new HorarioData();
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia  = str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$user->mes  = str_pad($valor[4], 2, "0", STR_PAD_LEFT);
				$user->ano  = $valor[5];
				$user->turno= $valor[6];
				$user->tipo = 2;
				$user->add();
			}else{
				$user = new HorarioData();
				$user->id = $valor[0];
				$user->idservicio = $valor[1];
				$user->idagente = $valor[2];
				$user->dia  = str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$user->mes  = str_pad($valor[4], 2, "0", STR_PAD_LEFT);
				$user->ano  = $valor[5];
				$user->turno= $valor[6];
				$user->tipo = 2;
				$user->update();
			}
			if($valor[6]==10){				
				$final = new PersonData();	
				$fecha = $valor[5].'-'.str_pad($valor[4], 2, "0", STR_PAD_LEFT).'-'.str_pad($valor[3], 2, "0", STR_PAD_LEFT);
				$final->update_final($valor[0], $fecha);
				
				$desvincula = new PuestoData();	
				$desvincula->id = $valor[2];
				$desvincula->desvincular();
			}
		}
	}
}
if(isset($_GET["product"]) && $_GET["product"]!=""):?>
<?php
$products = ProductData::getLike($_GET["product"]);
if(count($products)>0){
	?>
<h3>Resultados de la Busqueda</h3>
<table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Unidad</th>
		<th>Precio unitario</th>
		<th>En inventario</th>
		<th>Cantidad</th>
	</thead>
	<?php
$products_in_cero=0;
	 foreach($products as $product):
$q= OperationData::getQYesF($product->id);
	?>
	<?php 
	if($q>0):?>
		
	<tr class="<?php if($q<=$product->inventary_min){ echo "danger"; }?>">
		<td style="width:80px;"><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $product->unit; ?></td>
		<td><b>$<?php echo $product->price_out; ?></b></td>
		<td>
			<?php echo $q; ?>
		</td>
		<td style="width:250px;"><form method="post" action="index.php?view=addtocart">
		<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">

<div class="input-group">
		<input type="" class="form-control" required name="q" placeholder="Cantidad ...">
      <span class="input-group-btn">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Agregar</button>
      </span>
    </div>


		</form></td>
	</tr>
	
<?php else:$products_in_cero++;
?>
<?php  endif; ?>
	<?php endforeach;?>
</table>
<?php if($products_in_cero>0){ echo "<p class='alert alert-warning'>Se omitieron <b>$products_in_cero productos</b> que no tienen existencias en el inventario. <a href='index.php?module=inventary'>Ir al Inventario</a></p>"; }?>

	<?php
}else{
	echo "<br><p class='alert alert-danger'>No se encontro el producto</p>";
}
?>
<hr><br>
<?php else:
?>
<?php endif; ?>