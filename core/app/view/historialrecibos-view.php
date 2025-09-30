<?php
if(isset($_GET["id"])){
	$_SESSION["update"] = 0;
	$_SESSION["recibo"] = $_GET["id"];
	
	$recibo = DetalleData::getById($_GET["id"]);
	$total = 0;
	
	$resultado = count($recibo);
	if($resultado > 0){
		foreach($recibo as $tables) {
			$total = $total + $tables->monto;
			$idcard = $tables->idcard;
			$nombre = $tables->name;
			$cuotas = $tables->totales;
		}
	}

	echo '<div class="row">';
		echo '<section class="content-header">';
			echo '<h1>';
				echo $idcard.'-'.utf8_encode($nombre);
			echo '</h1>';
			echo '<ol class="breadcrumb">';
				echo '<li><i class="fa fa-book"></i> Talento Humano </li>';
				echo '<li><a href="./?view=listaprestamo"> Lista de prestamos </a></li>';
				echo '<li class="active"> Registro de prenomina </li>';
			echo '</ol>';
		echo '</section>';
		echo '<div class="col-md-12">';
			echo '<button type="button" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick('.$_GET["id"].');"><i class="fa fa-plus"></i> &nbsp;Nuevo Descuento</button>&nbsp;&nbsp;';
			echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick();"><i class="fa fa-print"></i> &nbsp;Imprimir Descuento</button>';
		echo '</div>';
		echo '</br>';
	echo '</div>';
	echo '<div id="parte1" class="row">';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Cuotas</h2>';
					echo '<h1>'.$cuotas.'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<br>';
		echo '</div>';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Pagados</h2>';
					echo '<h1>'.$resultado.'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<div class="clearfix"></div>';
			echo '<br>';
		echo '</div>';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Total</h2>';
					echo '<h1>'.number_format($total, 2, ',', '.').'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<div class="clearfix"></div>';
			echo '<br>';
		echo '</div>';
	echo '</div>';
	echo '<div class="row">';
		echo '<div class="col-md-12">';
			echo '<table class="table table-bordered table-hover">';
				echo '<thead>';
					echo '<th><div align="center">Cuota</div></th>';
					echo '<th><div align="center">Fecha</div></th>';
					echo '<th><div align="center">Monto</div></th>';
					echo '<th></th>';
				echo '</thead>';
				foreach($recibo as $operation){
                    echo '<tr>';
						echo '<td><div align="center">'.$operation->cuota.'</div></td>';
						echo '<td><div align="center">'.$operation->fecha.'</div></td>';
						echo '<td><div align="right">'.$operation->monto.'</div></td>';
                        echo '<td style="width:80px;">';
                            echo '<a href="?view=editdescuento&id='.$operation->id.'" class="btn btn-xs btn-warning" title="Modificar una cuota"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';
                            echo '<a href="?view=editdescuento&id='.$operation->id.'" class="btn btn-xs btn-danger" title="Eliminar registro"><i class="glyphicon glyphicon-trash"></i></a>';
                        echo '</td>';
                        echo '<script>
								$("#oper-"+'.$operation->id.').click(function(){
									x = confirm("Estas seguro que quieres eliminar esto...?");
									if(x==true){
										window.location = "index.php?view=deleteoperation&ref=historial&id='.$operation->id.'";
									}
								});
							  </script>';
                    echo '</tr>';
				}
			echo '</table>';
		echo '</div>';
	echo '</div>';
	echo '<script type="text/javascript">';
		echo 'function btn_NuevoOnClick(valor) {';
			echo 'window.location.href = "./?view=adddescuento&id="+valor;';
		echo '}';
	echo '</script>';
}else{
	echo '</br>';
	echo '<div class="content">';
		echo '<img src=\'images/404.png\'></br><h1>La p&aacute;gina que intentas solicitar no esta en el servidor</h1></br><a href=\'./index.php?view=home\'>Volver al inicio</a>';
	echo '</div><!-- /.content-wrapper -->';
} 
