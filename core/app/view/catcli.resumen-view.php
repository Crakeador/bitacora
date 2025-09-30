<section class="content-header">
	<h1>
		Catalogo
		<small>listado de los puestos de un cliente</small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-book"></i> Panel de control </li>
		<li><a href="index.php?view=catcli.lista"> Clientes </a></li>
		<li class="active"> Resumen </li>
	</ol>
</section>
<div class="col-md-12">
	<div class="text-left">
		<a href="?view=newpuesto" class="btn btn-success btn-sm"><i class="fa fa-truck"></i>&nbsp;Ingresar Puestos</a>
	</div>
</div>
</br></br>	
<div class="col-md-12">
	</br>
	<?php
	if(isset($_GET["id"]) && $_GET["id"]!="") {
		$_SESSION["cliente"] = $_GET["id"];
		$client = ClientData::getById($_GET["id"]);
		$puesto = ClientData::getByIdPuestos($_GET["id"]);
		
		echo '<table class="table table-bordered">';
			echo '<tr>';
			echo '<td style="width:150px;">Nombre del Cliente:</td>';
			echo '<td>'.utf8_encode($client->nombre).'</td>';
			echo '</tr>';
		echo '</table>';
		echo '</br>';
		echo '<table class="table table-bordered table-hover">';
			echo '<thead>';
				echo '<th>Codigo</th>';
				echo '<th>Puesto</th>';
				echo '<th><div align="center">Activado</div></th>';
				echo '<th>Localidad</th>';
				echo '<th>Turno</th>';
				echo '<th><div align="center">Creado el</div></th>';
				echo '<th>Acciones</th>';
			echo '</thead>';
			foreach($puesto as $base){	  	
				echo '<tr>';
				echo '<td>'.$base->codigo.'</td>';
				echo '<td>'.$base->descripcion.'</td>';
				echo '<td><div align="center">'.$base->activado.'</div></td>';
				echo '<td>'.$base->lugar.'</td>';
				echo '<td>'.$base->horario.'</td>';
				echo '<td><div align="center">'.$base->created_at.'</div></td>';
				echo '<td style="width:70px;"><div align="center">';
					echo '<a href="index.php?view=catpus.puesto&id='.$base->id.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;';
					echo '<a href="index.php?view=catcli.agente&id='.$base->id.'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>';
				echo '</div></td>';
				echo '</tr>';
			}
		echo '</table>';
	}else{
		echo '<div class="jumbotron">';
			echo '<h2>No hay productos</h2>';
			echo '<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>';
		echo '</div>';
	}
	?>
</div>
