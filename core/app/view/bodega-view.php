<?php
// Historial de articulos defectuosos
$operations = OperationData::getAllByProductStados(4);
?>
<style type="text/css" media="print">
	@media print {
		#parte1 {display:none;}
		#parte2 {display:none;}
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
		    <li><a href="report/history-word.php?id=<?php echo $product->id;?>">Word 2007 (.docx)</a></li>
		  </ul>
		</div>
		<h1>Productos defectuosos <small>Historial</small></h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php if(count($operations)>0):?>
			<table class="table table-bordered table-hover">
			<thead>
				<th><div align="center">Serial</div></th>
				<th>Puesto</th>
				<th>C&eacute;dula</th>
				<th>Nombre</th>
				<th>Fecha</th>
				<th></th>
			</thead>
			<?php foreach($operations as $operation):?>
			<tr>
			<td><div align="center"><?php echo $operation->serial; ?></div></td>
			<td><?php echo $operation->descripcion; ?></td>
			<td><?php echo $operation->idcard; ?></td>
			<td><?php echo utf8_encode($operation->name); ?></td>
			<td><?php echo $operation->created_at; ?></td>
			<td style="width:80px;">
      	<div id="parte2">
            <a href="index.php?view=editinventario&id=<?php echo $operation->idsell; ?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pen"></i></a>
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
