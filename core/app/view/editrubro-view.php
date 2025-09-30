<?php
$rubro = NominaData::getByIdCambio($_GET["id"]);
$categories = RubroData::getCombo();

if($rubro!=null){
	echo '<div class="row">';
		echo '<section class="content-header">';
			echo '<h1>&nbsp;</h1>';
			echo '<ol class="breadcrumb">';
				echo '<li><i class="fa fa-book"></i> Talento Humano </li>';
				echo '<li><a href="./?view=historial&id='.$_SESSION["rubro"].'"> Historial </a></li>';
				echo '<li class="active"> Modificar rubro </li>';
			echo '</ol>';
		echo '</section>';
		echo '</br>';
		echo '<div class="col-md-8">';
			echo '<h1>&nbsp;&nbsp;<small>Editar Rubro</small></h1>';
			if(isset($_SESSION["update"]) && $_SESSION["update"] == 1){
				echo '<p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>';
				setcookie("prdupd","",time()-18600);
				$_SESSION["update"] = 0;
			}
			echo '<br>';
			echo '<form class="form-horizontal" method="post" id="updaterubro" enctype="multipart/form-data" action="?view=updaterubro" role="form">';
				echo '<div class="form-group">';
					echo '<label for="inputDescripcion" class="col-lg-3 control-label">Descripci&oacute;n:</label>';
					echo '<div class="col-md-8">';
						echo '<select name="estado" class="form-control">';
							echo '<option value="">-- NINGUNA --</option>';
							foreach($categories as $category){
								if($category->id==$rubro->rubro){ $valor = "selected"; } else { $valor = ""; }
								echo '<option value="'.$category->id.'" '.$valor.'>'.utf8_encode($category->descripcion).'</option>';
							}
						echo '</select>';
					echo '</div>';
				echo '</div>';
				echo '<div class="form-group">';
					echo '<label for="inputMonto" class="col-lg-3 control-label">Monto:</label>';
					echo '<div class="col-md-8">';
						echo '<input type="text" name="monto" class="form-control" id="monto" value="'.$rubro->monto.'" placeholder="Monto del rubro asignado">';
					echo '</div>';
				echo '</div>';
				  echo '<div class="form-group">';
					echo '<div class="col-lg-offset-3 col-lg-8">';
						echo '<input type="hidden" name="person_id" value="'.$rubro->person.'">';
						echo '<input type="hidden" name="operation_id" value="'.$_GET["id"].'">';
					  echo '<button type="submit" class="btn btn-success">Actualizar Rubro</button>';
					echo '</div>';
				  echo '</div>';
			echo '</form>';
			echo '<br><br><br><br><br><br><br><br><br>';
		echo '</div>';
	echo '</div>';
}else{
	echo '<div class="row">';
		echo '<div class="col-md-12">';
			echo '<h1><i class="fa fa-archive"></i> Actualizaci&oacute;n de los rubros</h1>';
				echo '<div class="clearfix"></div>';
					echo '<h2>No hay ningun rubro registrado para este usuario...!!!</h2>';
					echo '<p>No se ha registrado ningun ingreso...!!!</p>';
				echo '<br><br><br><br><br><br><br><br><br><br>';
		echo '</div>';
	echo '</div>';
}
