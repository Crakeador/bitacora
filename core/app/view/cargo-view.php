<?php
// Pantallas de ingreso y modificacion de los cargos
$depar = DepartamentoData::getAll();
$tipos = UnionData::getTipo();

$hoy = date("Y-m-d H:i:s"); $error = ""; $cargo_id = 0;

if(isset($_GET["id"])){
    $mensaje = "modificar un cargo del sistema";
    $enlaces = "Modificar";

    $cargo = CargoData::getById($_GET["id"]);
	$cargo_id = $_GET["id"];
}else{
    $mensaje = "crear un cargo en el sistema";
    $enlaces = "Crear";

    if(count($_POST)>0){
       if(isset($_POST["active"])) $activo=1; else $activo=0;

       if($_POST["cargo_id"] == 0){
          if(count(CargoData::getLike("description", $_POST["description"])) > 0)
            $error = "Ya hay un CARGO con ese nombre, corriga...!!!";
       }

       if($error == ""){
          $cargo = new CargoData();

          $cargo->iddepartamento = $_POST["iddepartamento"];
          $cargo->description = strtoupper($_POST["description"]);
          $cargo->idtipo = $_POST["idtipo"];
          $cargo->is_active = $activo;

          if($_POST["cargo_id"] == 0){

              $cargo->add();

          }else{
              $cargo->id = $_POST["cargo_id"];

              $cargo->update();

          }

          Core::redir('cargos');
        }else{
          Core::alert("Error...!!!!", $error, "error");
        }

        $cargo = (object) [
            "iddepartamento" => $_POST["iddepartamento"],
            "description" => $_POST["description"],
            "idtipo" => $_POST["idtipo"],
            "is_active" => $activo
        ];
	}else{
		$cargo = (object) [
			"iddepartamento" => "",
			"description" => "",
			"idtipo" => "",
			"is_active" => "1"
		];
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Cargos
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./cargos"><i class="fa fa-database"></i> Cargos </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" id="addproduct" action="cargo" role="form">
		<input type="hidden" id="cargo_id" name="cargo_id" value="<?php echo $cargo_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la localidad</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Departamento: </label>
					<div class="col-md-5 col-sm-4">
						<?php
							echo '<select id="iddepartamento" name="iddepartamento" class="form-control">';
								echo '<option value="0"> -- SELECCIONE -- </option>';
								foreach($depar as $tables) {
									if($tables->id == $cargo->iddepartamento) $valor = 'selected'; else $valor = '';
									echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->name.'</option>';
								}
							echo '</select>';
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Cargo:</label>
					<div class="col-md-5 col-sm-4">
						<input class="text-field form-control input-sm" id="description" name="description" value="<?php echo $cargo->description; ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" pattern="[A-Z ]{3, 30}" title="El nombre debe de tener minimo 3 caracteres" type="text" required autofocus>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo:</label>
					<div class="col-md-5 col-sm-4">
						<?php
							echo '<select id="idtipo" name="idtipo" class="form-control">';
								echo '<option value="0"> -- SELECCIONE -- </option>';
								foreach($tipos as $tables) {
									if($tables->id == $cargo->idtipo) $valor = 'selected'; else $valor = '';
									echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->description.'</option>';
								}
								echo '</select>';
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-5">
						<label class="col-sm-1 control-label">&nbsp;</label>
						<input id="active" name="active" type="checkbox" class="activo" <?php if($cargo->is_active == 1) echo "checked"; ?>>
						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Activo </label>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
	</form>
</section>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de los Cargos";
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
  });
</script>

