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
		<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<h1><i class='glyphicon glyphicon-shopping-cart'></i> Reabastecimientos</h1>
				<div class="clearfix"></div> <?php
					$products = SellData::getRes();
					//var_dump($products);
					if(count($products)>0){	?>
						<br>
						<table class="table table-bordered table-hover	">
							<thead>
								<th></th>
								<th>Nombres</th>
								<th>Producto</th>
								<th>Fecha</th>
								<th></th>
							</thead>
							<?php foreach($products as $sell):?>
							<tr>
								<td style="width:30px;"><a href="index.php?view=onere&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>								
								<td> <?php
									$total=0;
									foreach($operations as $operation){
										$product  = $operation->getProduct();
										$total += $operation->q*$product->price_in;
									}
									echo $client->name."<br>";
									echo "<b>$ ".number_format($total)."</b>";	?>
								</td>
								<td> <?php
									$operations = OperationData::getAllProductsBySellId($sell->id);
									$client = $sell->getPerson();
									//var_dump($client);
									echo count($operations); ?>
								</td>
								<td><?php echo $sell->created_at; ?></td>
								<td style="width:30px;"><a href="index.php?view=delre&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php endforeach; ?>
						</table>
						<?php
					}else{	?>
						<div class="jumbotron">
							<h2>No hay datos</h2>
							<p>No se ha realizado ninguna operacion.</p>
						</div>	<?php
					} ?>
				</div>
			</div>
		</div>
	</div>	
</section>