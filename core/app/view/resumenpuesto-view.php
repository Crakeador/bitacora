<?php $_SESSION["valor"] = 1; ?>
<section class="content-header">
	<h1>
		Reportes
		<small>lista de dotaci&oacute;n entregada</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=entregas"><i class="fa fa-book"></i> Talento Humano </a></li>
		<li class="active">resumen de Asignaci&oacute;n</li>
	</ol>
  <div class="btn-group pull-right">
    <button type="button" class="btn btn-success" onClick="btn_Imprimir()"><i class="fa fa-tasks"></i> Imprimir </button>
    <button type="button" class="btn btn-default" data-toggle="dropdown">
      <i class="fa fa-download"></i> Descargar <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      <li><a href="report/onesell-word.php?id=<?php echo $_GET["id"]; ?>">Word 2007 (.docx)</a></li>
    </ul>
  </div>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<h1>Resumen de Asignaci&oacute;n por puestos</h1>
	<?php
	if(isset($_GET["id"]) && $_GET["id"]!="") {
		$puesto = PuestoData::getById($_GET["id"]);
		$productos = ListaData::getPuesto($_GET["id"]); 
		
		$ciclo = count($productos);
		echo '<table class="table table-bordered">';
			echo '<tr>';
				echo '<td style="width:150px;">Puesto</td>';
				echo '<td>'.utf8_encode($puesto->descripcion).'</td>';
			echo '</tr>';
		echo '</table>';
		echo '<br>';
	
		echo '<table class="table table-bordered table-hover">';
			echo '<thead>';
				echo '<th style="width:22%;">Articulo</th>';
				echo '<th><div align="center">Cantidad</div></th>';
				echo '<th><div align="center">Serial</div></th>';
				echo '<th style="width:12%;">Costo</th>';
				echo '<th><div align="center">Responsable</div></th>';
				echo '<th style="width:70px;">Acciones</th>';
			echo '</thead>';
			$total=0;
			for($i=0; $i<$ciclo; $i++){
				$total += ($productos[$i]->q * $productos[$i]->price_out); 
				if($productos[$i]->idcategory == 4) $_SESSION['id_venta'] = $productos[$i]->venta;
				echo '<tr>';
					echo '<td>'.$productos[$i]->nombre.'</td>';
					echo '<td><div align="center">'.$productos[$i]->q.'</div></td>';
					echo '<td><div align="center">'.$productos[$i]->serial.'</div></td>';
					echo '<td><div align="right">'.number_format(($productos[$i]->q * $productos[$i]->price_out),2,'.',',').' $</div></td>';
					echo '<td>'.$productos[$i]->name.'</td>';
					echo '<td><div align="center">';
						echo '<a href="index.php?view=editserial&id='.$productos[$i]->id.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>';
						echo '<a href="index.php?view=delserial&id='.$productos[$i]->id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
					echo '</div></td>';
				echo '</tr>';
			}
		echo '</table>';
		echo '<div class="row">';
			echo '<div class="col-md-4">';
			echo '<table class="table">';
				echo '<tr>';
					echo '<td><h4>Total del Puesto:</h4></td>';
					echo '<td><h4>$ '.number_format($total,2,'.',',').'</h4></td>';
				echo '</tr>';
			echo '</table>';
			echo '</div>';
		echo '</div>';
	}else{
		echo '<div class="jumbotron">';
			echo '<h2>No hay productos</h2>';
			echo '<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>';
		echo '</div>';
	} ?>
</section>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
	function btn_Imprimir() {
		VentanaCentrada('documentos/resumen_pdf.php?id='+<?php echo $_GET['id']; ?>,'Entrega de Dotacion','','1024','768','true');
	}
</script>