<?php

// Pantallas de ingreso y modificacion de las localidades

$hoy = date("Y-m-d H:i:s"); $error = ""; $person_id = 0;



if(isset($_GET["id"])){

    $mensaje = "modificar un agente del sistema";

    $enlaces = "Modificar";

    $person = LugarData::getById($_GET["id"]);

    $person_id = $_GET["id"];

}else{

    $mensaje = "crear un agente en el sistema";

    $enlaces = "Crear";

    if(count($_POST)>0){

       	if(isset($_POST["active"])) $activo=1; else $activo=0; // var_dump($_POST); echo '</br>';

        if($_POST["person_id"] == 0){
            if(empty(PersonData::getLike("idcard", $_POST["idcard"]))){
                // Sin comentario
            }else{
                $error .= "- Cedula repetida";
            }
        }

        if($error == ""){
			$user = new PersonData();

			$user->company = $_SESSION['id_company'];
			$user->id = $_POST["person_id"];
			$user->idlocalidad = $_POST["genero"];
			$user->idcard = $_POST["idcard"];
			$user->cargo = 7;
			$user->name = strtoupper($_POST["nombre_uno"]);
			$user->genero = $_POST["genero"];
            $user->tipo_sangre = $_POST["tipo_sangre"];
            $user->phone1 = $_POST["telefono1"];
			$user->is_active = $activo;

			if($_POST["person_id"] == 0){
				if(isset($_FILES["image"])){
					$image = new Upload($_FILES["image"]);	
					if($image->uploaded){
						$image->Process("storage/persons/");

						if($image->processed){
							echo 'Cuatro...!!!</br>';
							$user->image = $image->file_dst_name;
                            $prod = $user->add_IMGAge();
						}
					}else{
						$user->add_agente();
					}
				}
			}

          	Core::redir('rrsing.lista');
        }else{
          	Core::alert("Error...!!!!", $error, "error");
        }

        $person = (object) [
			"idcard"=>$_POST["idcard"],
			"image"=>"assets/images/avatar/user00.png",
			"name"=>strtoupper($_POST["nombre_uno"]),
			"phone1"=>$_POST["telefono1"],
			"genero"=>$_POST["genero"],
			"tipo_sangre"=>$_POST["tipo_sangre"],
            "is_active" => $activo
        ];
	}else{
        $person = (object) [
			"idcompany" => $_SESSION['id_company'],
			"idcard"=>"",
			"image"=>"assets/images/avatar/user00.png",
			"name"=>"",
			"phone1"=>"",
			"genero"=>1,
			"tipo_sangre"=>0,
            "is_active" => "1"
        ];
    }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Operaciones
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=rrsing.lista"><i class="fa fa-database"></i> Agentes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">

		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>

		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>

	</p>

	<!-- START panel -->

	<form class="form-horizontal" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=rrsing.persons" role="form">
		<input type="hidden" id="person_id" name="person_id" value="<?php echo $person_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del agente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-4 control-label"><span class="text-danger">*</span> Imagen:</label>
					<div class="col-sm-2">
						<input type="file" name="image" id="image" placeholder="">Grupo Near Solucions
						<br>
						<img src="<?php echo $person->image;?>" class="img-responsive">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
					<div class="col-sm-3"><input type="text" class="form-control" id="idcard" name="idcard" maxlength="10" value="<?php echo $person->idcard; ?>" required title="Solo números. Tamaño obligatorio: 10"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label"><span class="text-danger">*</span> Apellidos Nombres:</label>
					<div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo utf8_encode($person->name); ?>" placeholder="Primer nombre del personal" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,40}" title="Letras y números. Tamaño mínimo: 3. Tamaño máximo: 30"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
					<div class="col-sm-3">
						<select class="select-input form-control input-sm" id="genero" name="genero">
							<option value="1" <?php if($person->genero==1) echo 'selected="selected"'; ?>>Masculino</option>
							<option value="2" <?php if($person->genero==2) echo 'selected="selected"'; ?>>Femenino</option>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-4 control-label"><span class="text-danger">*</span> Tipo de Sangre:</label>
					<div class="col-sm-3">
						<select class="select-input form-control input-sm" id="tipo_sangre" name="tipo_sangre">
							<option value="0" <?php if($person->tipo_sangre==0) echo 'selected="selected"'; ?>>Seleccione</option>
							<option value="1" <?php if($person->tipo_sangre==1) echo 'selected="selected"'; ?>>A-</option>
							<option value="2" <?php if($person->tipo_sangre==2) echo 'selected="selected"'; ?>>A+</option>
							<option value="3" <?php if($person->tipo_sangre==3) echo 'selected="selected"'; ?>>AB-</option>
							<option value="4" <?php if($person->tipo_sangre==4) echo 'selected="selected"'; ?>>AB+</option>
							<option value="5" <?php if($person->tipo_sangre==5) echo 'selected="selected"'; ?>>B-</option>

							<option value="6" <?php if($person->tipo_sangre==6) echo 'selected="selected"'; ?>>B+</option>

							<option value="7" <?php if($person->tipo_sangre==7) echo 'selected="selected"'; ?>>O-</option>

							<option value="8" <?php if($person->tipo_sangre==8) echo 'selected="selected"'; ?>>O+</option>

						</select>

					</div>

				</div>				

				<div class="form-group">

					<label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>

					<div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>

				</div>

				<div class="form-group">

					<div class="col-md-2 col-sm-2">

						<label class="col-sm-1 control-label">&nbsp;</label>

						<input id="active" name="active" type="checkbox" class="activo" <?php if($person->is_active == 1) echo "checked"; ?>>

						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Activo </label>

					</div>

				</div>

			</div>

		</div>
		<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
	</form>
</section>
<!-- Page specific script -->
<script type='text/javascript'>
  var elem = document.querySelector('.activo'); // referred checkbox class is here
  var init = new Switchery(elem, { size: 'small' }); // put option after elem attribute    
  
  document.title = "Near Solucions | Ingreso de Personal";
</script>

