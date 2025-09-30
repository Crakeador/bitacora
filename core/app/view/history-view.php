<?php
// Historial por puesto
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductId($product->id);
$dotacion = OperationData::getAllByProductNombre($product->id);

$itotal = OperationData::GetInputQYesF($product->id);
?>
<style type="text/css" media="print">
	@media print {
		#parte1 {display:none;}
		#parte2 {display:none;}
	}
</style>
<div class="row">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Inventario
			<small>productos asignados a los agentes</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php?view=inventary"><i class="fa fa-database"></i> Inventario </a></li>
			<li class="active"> Asignados </li>
		</ol>
	</section>
</hr>
	<div class="row">
		<div class="col-md-12"></div>
	</div>
	<!-- Main content -->
	<div class="col-md-12">
		<h1><?php echo $product->name; ?> <small>Historial</small></h1>
	</div>
</div>
<div id="parte1" class="row">
	<div class="col-md-4">
        <div class="jumbotron">
            <center>
                <h2>Entradas</h2>
                <h1><?php echo $itotal; ?></h1>
            </center>
        </div>
        <br>
    </div>
	<div class="col-md-4">
		<?php
            $total = OperationData::GetQYesF($product->id);
        ?>
        <div class="jumbotron">
            <center>
                <h2>Disponibles</h2>
                <h1><?php echo $total; ?></h1>
            </center>
        </div>
        <div class="clearfix"></div>
        <br>
    </div>
	<div class="col-md-4">
		<?php
            $ototal = -1*OperationData::GetOutputQYesF($product->id);
        ?>
        <div class="jumbotron">
            <center>
                <h2>Salidas</h2>
                <h1><?php echo $ototal; ?></h1>
            </center>
        </div>
        <div class="clearfix"></div>
        <br>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php if(count($operations)>0):?>
			<table class="table table-bordered table-hover">
			<thead>
			<th><div align="center">Cantidad</div></th>
			<th><div align="center">Serial</div></th>
			<th>Puesto</th>
			<th>C&eacute;dula</th>
			<th>Nombre</th>
			<th>Fecha</th>
			<th></th>
			</thead>
			<?php foreach($dotacion as $operation):?>
			<tr>
			<td><div align="center"><?php echo $operation->q; ?></div></td>
			<td><div align="center"><?php echo $operation->serial; ?></div></td>
			<td><?php echo $operation->descripcion; ?></td>
			<td><?php echo $operation->idcard; ?></td>
			<td><?php echo utf8_encode($operation->name); ?></td>
			<td><?php echo $operation->created_at; ?></td>
			<td style="width:80px;">
      	<div id="parte2">
            <a href="index.php?view=editinventario&id=<?php echo $operation->idsell; ?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
            <a href="#" id="oper-<?php echo $operation->idsell; ?>" class="btn tip btn-xs btn-danger" title="Eliminar registro"><i class="glyphicon glyphicon-trash"></i></a>
				</div>
			</td>
			<script>
				$("#oper-"+<?php echo $operation->idsell; ?>).click(function(){
					x = confirm("Estas seguro que quieres eliminar esto ??");
					if(x==true){
						window.location = "index.php?view=deleteoperation&ref=history&pid=<?php echo $operation->id;?>&opid=<?php echo $operation->idsell;?>";
					}
				});
			</script>
			</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
