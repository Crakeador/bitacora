<?php
// Pantallas de ingreso y modificacion de las localidades
$hoy = date("Y-m-d H:i:s"); $error = ""; $lugar_id = 0;

if(isset($_GET["id"])){
    $mensaje = "modificar una ubicaci&oacute;n en el sistema";
    $enlaces = "Modificar";
    $lugar = LugarData::getById($_GET["id"]);
    $lugar_id = $_GET["id"];
}else{
    $mensaje = "crear una ubicaci&oacute;n en el sistema";
    $enlaces = "Crear";
    if(count($_POST)>0){
       if(isset($_POST["active"])) $activo=1; else $activo=0;

       if($_POST["lugar_id"] == 0){
          if(count(LugarData::getLike("descripcion", $_POST["descripcion"])) > 0)
            $error = "Ya hay un lugar con ese nombre, corriga...!!!";
       }

       if($error == ""){
          $lugar = new LugarData();

          $lugar->descripcion = strtoupper($_POST["descripcion"]);
          $lugar->nombre = strtoupper($_POST["nombre"]);
          $lugar->is_active = $activo;

          if($_POST["lugar_id"] == 0){
              $lugar->add();
          }else{
              $lugar->id = $_POST["lugar_id"];
              $lugar->update();
          }

          Core::redir('catloc.lista');
        }else{
          Core::alert("Error...!!!!", $error, "error");
        }

        $lugar = (object) [
            "descripcion" => $_POST["descripcion"],
            "nombre" => $_POST["nombre"],
            "is_active" => $activo
        ];
	}else{
        $lugar = (object) [
            "descripcion" => "",
            "nombre" => "",
            "is_active" => "1"
        ];
    }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Localidades
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=catloc.lista"><i class="fa fa-database"></i> Localidades </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=catloc.lugar" role="form">
		<input type="hidden" id="lugar_id" name="lugar_id" value="<?php echo $lugar_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la localidad</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
					<div class="col-md-5 col-sm-4">
						<input class="text-field form-control input-sm" id="descripcion" name="descripcion" value="<?php echo $lugar->descripcion; ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" pattern="[A-Z ]{3, 30}" title="El nombre debe de tener minimo 3 caracteres" type="text" required autofocus>
					</div>
					<label class="col-sm-3 col-sm-3 control-label"><span class="text-danger">*</span> Abreviatura:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="text-field form-control input-sm" id="nombre" name="nombre" value="<?php echo $lugar->nombre; ?>" minlength="3" maxlength="3" style="text-transform: uppercase;" pattern="[A-Z]{3}" title="La abreviatura solo son 3 letras" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-5">
						<label class="col-sm-1 control-label">&nbsp;</label>
						<input id="active" name="active" type="checkbox" class="activo" <?php if($lugar->is_active == 1) echo "checked"; ?>>
						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Activo </label>
					</div>
				</div>
			</div>
		</div>
	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
	</form>
</section>
<script>
  var elem = document.querySelector('.activo'); // referred checkbox class is here
  var init = new Switchery(elem, { size: 'small' }); // put option after elem attribute
</script>
