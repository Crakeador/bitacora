<?php
// Pantallas de ingreso los efectivos 
$persons = PersonData::getAllTipo(3, 1);

$hoy = date("Y-m-d H:i:s"); $error = ""; $lugar_id = 0;
$fecha=date("Y-m-d");

$mensaje = "Asignar a un agente a un puesto";
$enlaces = "Crear";
if(count($_POST)>0){ 
   if($_POST["idperson"] == "0"){
        $error .= "Debe seleccionar un agente, corriga...!!!";
   }

   if($error == ""){
        $lugar = new UnionData();

        $lugar->idservicio = $_POST["idservicio"];
        $lugar->idperson = $_POST["idperson"];
        $lugar->fecha = $_POST["fecha"];
        
        $result = $lugar->finTurno();
		if($result){
            $result = $lugar->finFecha();
			if($result){
				Core::redir('finalizar');
			}else{
				echo "<script>sweetAlert('Falla la actualizacion...!!!', 'No se puede actualizar la fecha de salida...!!!', 'error');</script>";
			}
		}else{
		    Core::alert("Error...!!!!", "No se actualizo el fin de turno...!!!", "error");
		}
    }else{
        Core::alert("Error...!!!!", $error, "error");
    }

    $lugar = (object) [
        "idservicio" => $_POST["idservicio"],
        "idperson" => $_POST["idperson"],
        "fecha" => $_POST["fecha"]
    ];
}else{
	if(isset($_GET["id"])){
		$lugar = UnionData::getById($_GET["id"]);
		$servicio = $_GET["id"];
	}else{
		$servicio = 0;
		$lugar = (object) [
			"idservicio" => "",
			"idperson" => "",
			"is_active" => "1"
		];
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Asignaci&oacute;n
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./personas"><i class="fa fa-database"></i> Asignacion </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>
						<span class="glyphicon glyphicon-th"></span>
						<span>Lista de categorías</span>
					</strong>
				</div>
				<div class="panel-body">
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><div align="center">Agente</div></th>
								<th><div align="center">Finalizo</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$products = PersonData::getAllLiquida(3, 0);
								// Crea tabla de Ventas
								foreach($products as $product) {
									echo '<tr>';
										echo '<td width="30%">'.$product->name.'</td>';
										echo '<td width="6%"><div align="center">'.$product->endwork.'</div></td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<form class="form-horizontal" method="post" id="finturno" action="finalizar" role="form">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="glyphicon glyphicon-th"></span>
						<span>Asignaci&oacute;n de un efectivo</span>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha de salida: </label>
							<div class="col-md-8">
								<div class="input-group date form_date col-md-8" data-provide="datepicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input" data-link-format="yyyy-mm-dd">
									<input class="form-control" size="16" type="text" id="id_fecha" name="fecha" value="<?php echo $fecha; ?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Agente: </label>
							<div class="col-md-8 col-sm-8">
								<?php
									echo '<select id="idperson" name="idperson" class="form-control select2">';
										echo '<option value="0"> -- SELECCIONE -- </option>';
										foreach($persons as $tables) {
											if($tables->id == $lugar->idperson) $valor = 'selected'; else $valor = '';
											echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->name.'</option>'; //utf8_encode()
										}
								echo '</select>';
								?>
							</div>
						</div>
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Ultimo turno de los agentes";
</script>
