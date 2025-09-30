<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Productos
		<small>listado de los productos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=newproduct">
				<span class="glyphicon glyphicon-plus"></span> Ingresar Productos
			</a>
		</div>
		<div class="box-body">
			<table id="viewlista" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th><div align="center" width="6%">Imagen</div></th>
					<th><div align="center" width="50%">Nombre</div></th>
					<th><div align="center" width="12%">Categoria</div></th>
					<th width="8%"><div align="center">Precio Entrada</div></th>
					<th width="8%"><div align="center">Precio Salida</div></th>
					<th width="8%"><div align="center">Inventario Inicial</div></th>
					<th width="8%"><div align="center">Stock</br>Actual</div></th>
				</tr>
				</thead>
				<tbody>
					<?php
						$products = ProductData::getTodos();

						//Lista de los productos
						foreach($products as $tables) {
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
									echo '</br><small>'.$tables->unit.'</small>';
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
								$valor=$tables->getOperation()->q+$tables->getTotal();
								echo '<td><div align="right">'.$tables->getOperation()->q.'</div></td>';
								echo '<td><div align="right">'.$tables->getTotal().'</div></td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>
