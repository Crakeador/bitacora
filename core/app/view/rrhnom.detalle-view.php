<?php
if(isset($_GET["id"])){
	$_SESSION["update"] = 0;
	$ano=$_SESSION['ano'];
	$mes=$_SESSION['mes'];
	$fecha=$ano."-".$mes."-01";
	$total=date("t", strtotime($fecha));
	$final=$ano."-".$mes."-".$total;
	$_SESSION["rubro"] = $_GET["id"];

	$users = NominaData::getById($ano, $mes, $_GET["id"], $_SESSION["cliente"]);
	$ingreso = 0;
	$egresos = 0;

	$resultado = count($users);
	if($resultado > 0){
		foreach($users as $tables) {
			if($tables->tipo_cuenta == 'I'){
				$ingreso = $ingreso + $tables->monto;
			}else{
				$egresos = $egresos + $tables->monto;
			}
			   
			$id = $tables->id;
			$idcard = $tables->idcard;
			$nombre = $tables->name;
			$cargo = $tables->description;
			$inicio = $tables->startwork;
		}
	}

	$numero = $ingreso-$egresos;
	$entero = floor($numero);
	$decimales = $numero-$entero;

	if(strval($decimales) == 0.99)
		$valor = round($numero);
	else
		$valor = $numero;

		echo '<section class="content-header">';
			echo '<h1>';
				echo $idcard.'-'.$nombre;
				echo '<small>Periodo: '.$fecha.' al '.$final.'</small>';
			echo '</h1>';
			echo '<ol class="breadcrumb">';
				echo '<li><a href="./?view=rrhnom.lista"><i class="fa fa-book"></i> Talento Humano </a></li>';
				echo '<li class="active"> Registro de prenomina </li>';
			echo '</ol>';
		echo '</section>';
		echo '<div class="col-md-12">';
			echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarRecibo('.$_GET["id"].');"><i class="fa  fa-print"></i> Generar Recibos</button>';
		echo '</div>';
		echo '</br>';
	echo '<div id="parte1" class="row">';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Ingresos</h2>';
					echo '<h1>'.$ingreso.'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<br>';
		echo '</div>';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Egresos</h2>';
					echo '<h1>'.$egresos.'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<div class="clearfix"></div>';
			echo '<br>';
		echo '</div>';
		echo '<div class="col-md-4">';
			echo '<div class="jumbotron">';
				echo '<center>';
					echo '<h2>Total</h2>';
					echo '<h1>'.number_format($valor, 2, ',', '.').'</h1>';
				echo '</center>';
			echo '</div>';
			echo '<div class="clearfix"></div>';
			echo '<br>';
		echo '</div>';
			echo '<table class="table table-bordered table-hover">';
				echo '<thead>';
					echo '<th><div align="center">Cuenta</div></th>';
					echo '<th>Descripci&oacute;n del Rubro</th>';
					echo '<th>Ingreso</th>';
					echo '<th>Egreso</th>';
					echo '<th></th>';
				echo '</thead>';
				foreach($users as $operation){
					echo '<tr>';
						if($operation->tipo_cuenta == 'I'){
							$ingreso = $ingreso + $operation->monto;
							echo '<td><div align="center">'.$operation->tipo_cuenta.'</div></td>';
							echo '<td>'.$operation->descripcion.' '.$operation->formula.'</td>';
							echo '<td><div align="right">'.number_format($operation->monto, 2, ',', '.').'</div</td>';
							echo '<td></td>';
						}else{
							$egresos = $egresos + $operation->monto;
							echo '<td><div align="center">'.$operation->tipo_cuenta.'</div></td>';
							echo '<td>'.$operation->descripcion.'</td>';
							echo '<td></td>';
							echo '<td><div align="right">'.number_format($operation->monto, 2, ',', '.').'</div></td>';
						}

						echo '<td style="width:80px;">';
							echo '<a href="?view=editrubro&id='.$operation->id.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';
							echo '<a href="#" id="oper-'.$operation->id.'" class="btn tip btn-xs btn-danger" title="Eliminar registro"><i class="glyphicon glyphicon-trash"></i></a>';
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
	echo '<script type="text/javascript" src="js/VentanaCentrada.js"></script>';
	echo '<script type="text/javascript">';
        echo 'function btn_EnviarRecibo(id) {';
            echo 'VentanaCentrada("documentos/res/recibo_html.php?id="+id, "Recibos de Pago", "", "1024", "768", "true");';
        echo '}';
    echo '</script>';
}else{
	echo '</br>';
	echo '<div class="content">';
		echo '<img src=\'assets/images/nube.png\' alt="Este es el ejemplo de un texto alternativo" style="max-width:100%;width:auto;height:auto;"></br><h1>No hay ningun dato que mostrar aun...!!!</h1></br><a href=\'./index.php?view=home\'>Volver al inicio</a>';
	echo '</div><!-- /.content-wrapper -->';
}
