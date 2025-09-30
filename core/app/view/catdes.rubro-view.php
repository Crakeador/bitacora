<?php
// Pantallas de ingreso y modificacion de las localidades
$hoy = date("Y-m-d H:i:s"); $error = ""; $lugar_id = 0;
$rubros = RubroData::getAll();

if(isset($_GET["id"])){
    $mensaje = "modificar un rubro del calculo de nomina";
    $enlaces = "Modificar";
    $rubro = DescuentoData::getById($_GET["id"]);
	$id_rubro = $_GET["id"];
}else{
	$mensaje = "crear un descuento en la nomina";
	$enlaces = "Crear";

	if(count($_POST)>0){
        if(isset($_POST["active"])) $activo=1; else $activo=0;

		$rubro = new DescuentoData();

		$rubro->tipo        = strtoupper($_POST["tipo"]);
		$rubro->descripcion = strtoupper($_POST["descripcion"]);
		$rubro->monto = $_POST["monto"];
		$rubro->is_active = $activo;

		if($_POST["id_rubro"] == 0){
			$rubro->add();
		}else{
			$rubro->id = $_POST["id_rubro"];
			$rubro->update();
		}

		Core::redir('catdes.lista');
	}else{
		$id_rubro = 0;
        $rubro = (object) [
            "tipo" => "",
            "descripcion" => null,
            "monto" => null,
            "is_active" => "1"
        ];
    }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Adicionales
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=catdes.lista"><i class="fa fa-database"></i> Listado </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" id="rubros" action="index.php?view=catdes.rubro" role="form">
		<input type="hidden" id="id_rubro" name="id_rubro" value="<?php echo $id_rubro; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del adicional</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Rubro:</label>
					<div class="col-md-3 col-sm-4">
						<select class="select-input form-control input-sm" id="tipo" name="tipo">
							<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($rubros as $tables) {
										if($tables->id == $rubro->tipo) $valor = 'selected'; else $valor = '';
										echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
									}
								?>
						</select>
					</div>
					<label class="col-sm-3 control-label"><span class="text-danger">* Este campo es obligatorio</span></label>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
					<div class="col-md-5 col-sm-4">
						<input class="text-field form-control input-sm" id="descripcion" name="descripcion" value="<?php echo $rubro->descripcion; ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" pattern="[A-Za-z ]{3, 30}" title="El nombre debe de tener minimo 3 caracteres" type="text" required autofocus>
					</div>
					<label class="col-sm-3 col-sm-3 control-label"><span class="text-danger">*</span> Monto:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="text-field form-control input-sm" id="monto" name="monto" value="<?php echo $rubro->monto; ?>" title="Monto del rubro que desea" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-5">
						<label class="col-sm-1 control-label">&nbsp;</label>
						<input id="active" name="active" type="checkbox" class="activo" <?php if($rubro->is_active == 1) echo "checked"; ?>>
						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Activo </label>
					</div>
				</div>
			</div>
		</div>
	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
	</form>
</section>
<script>
  var elem2 = document.querySelector('.activo'); // referred checkbox class is here
  
  var init = new Switchery(elem2, { size: 'small' }); // put option after elem attribute
</script>
