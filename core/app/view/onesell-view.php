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
	<div align="row">
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-success btn-sm" onClick="btn_Imprimir(<?php echo $_GET["id"]; ?>)"><i class="fa fa-tasks"></i> Imprimir </button>
		</div>
		<h1>Resumen de Asignaci&oacute;n</h1>
		<?php 
			if(isset($_GET["id"]) && $_GET["id"]!=""): 
				$sell = SellData::getById($_GET["id"]);
				$operations = OperationData::getAllProductsBySellId($_GET["id"]);
				$total = 0;

				if(isset($_COOKIE["selled"])){
					foreach ($operations as $operation) {
						// print_r($operation);
						$qx = OperationData::getQYesF($operation->product_id);
						// print "qx=$qx";
						$p = $operation->getProduct();
						if($qx==0){
							echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> no tiene existencias en inventario.</p>";
						}else if($qx<=$p->inventary_min/2){
							echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene muy pocas existencias en inventario.</p>";
						}else if($qx<=$p->inventary_min){
							echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'> $p->name</b> tiene pocas existencias en inventario.</p>";
						}
					}
					setcookie("selled","",time()-18600);
				}	
			?>
			<table class="table table-bordered">
				<?php if(!empty($sell->person_id)):
					$client = $sell->getPerson(); ?>
					<tr>
						<td style="width:150px;">Cliente</td>
						<td><?php if($_SESSION["valor"] == 1) echo $_SESSION["puesto"]; else echo $client->name." ".$client->lastname; ?></td>
					</tr>		
				<?php endif; ?>
				<?php if(!empty($sell->user_id)):
					$user = $sell->getUser(); ?>
					<tr>
						<td>Atendido por</td>
						<td><?php echo $user->name." ".$user->lastname;?></td>
					</tr>
				<?php endif; ?>
			</table>
			<br>
			<table class="table table-bordered table-hover">
				<thead>
					<th>Codigo</th>
					<th>Cantidad</th>
					<th>Nombre del Producto</th>
					<th>Precio Unitario</th>
					<th>Total</th>			
				</thead>
				<?php
					foreach($operations as $operation){
						$product  = $operation->getProduct(); ?>
						<tr>
							<td><?php echo $product->id ;?></td>
							<td><?php echo $operation->q ;?></td>
							<td><?php echo $product->name ;?></td>
							<td>$ <?php echo number_format($product->price_out,2,".",",") ;?></td>
							<td><b>$ <?php echo number_format($operation->q*$product->price_out,2,".",",");$total+=$operation->q*$product->price_out;?></b></td>
						</tr>
				<?php } 
				if(empty($sell->discount)) $descuento=0; else $descuento=$sell->discount;?>
			</table>
			<br><br>
			<div class="row">
				<div class="col-md-4">
					<table class="table table-bordered">
						<tr>
							<td><h4>Descuento:</h4></td>
							<td><h4>$ <?php echo number_format($descuento,2,'.',','); ?></h4></td>
						</tr>
						<tr>
							<td><h4>Subtotal:</h4></td>
							<td><h4>$ <?php echo number_format($total,2,'.',','); ?></h4></td>
						</tr>
						<tr>
							<td><h4>Total:</h4></td>
							<td><h4>$ <?php echo number_format($total-$descuento,2,'.',','); ?></h4></td>
						</tr>
					</table>
				</div>
			</div>
		<?php else:?>
			<div class="alert alert-danger">
				<strong>Error...!!!</strong> Hay un problema con sus datos.<br><br>
				<ul>
					<li>No hay ningun dato que mostrar...!!!</li>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</section>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/resumen_pdf.php?id='+$id,'Entrega de Dotacion','','1024','768','true');
	}
</script>