<?php
// Pantallas de ingreso y modificacion de las localidades
$hoy = date("Y-m-d H:i:s"); 
$mensaje = "ingresar un nuevo agente al sistema";
$enlaces = "Nuevo";

if(isset($_GET["id"])){
    $mensaje = "modificar un agente del sistema";
    $enlaces = "Modificar";
    $person = PersonData::getById($_GET["id"]);
    $person_id = $_GET["id"];

	//var_dump($person);
}else{
    if(isset($_POST)){
        $user = new PersonData();
        $user->id = $_POST["person_id"];
        $user->tipo_sangre = $_POST["tipo_sangre"];
        $user->phone1 = $_POST["telefono1"];
        $user->phone2 = $_POST["telefono2"];
        $user->phone3 = $_POST["telefono3"];
        $user->image = "user15.png";

        $user->update_telefono();
        Core::alert("Exito...!!!!", "Se ha actualizado el telefono", "success"); 
        Core::redir('telefonos');
    }else{
        $person = (object) [
			'idcard' => '',
			'name' => '',
			'genero' => 1,
			'tipo_sangre' => 0,
			'phone1' => '',
			'phone2' => '',
			'phone3' => '',
			'image' => ''
		];
		$person_id = 0;
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
		<li><a href="./telefonos"><i class="fa fa-database"></i> Agentes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" enctype="multipart/form-data" id="telefono" action="telefono" role="form">
		<input type="hidden" id="person_id" name="person_id" value="<?php echo $person_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del agente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="image" class="col-sm-4 control-label"><span class="text-danger">*</span> Imagen:</label>
					<div class="col-sm-2">
						<input type="file" name="image" id="image" placeholder="">
						<br>
						<?php
						if(strlen($person->image) == 0)
						    echo '<img src="./assets/images/avatar/user00.png" class="img-responsive">';
						else
						    echo '<img src="storage/persons/'.$person->image.'" class="img-responsive">';
					    ?>
					</div>
				</div>
				<div class="form-group">
					<label for="idcard" class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
					<div class="col-sm-3"><input type="text" class="form-control" id="idcard" name="idcard" maxlength="10" value="<?php echo $person->idcard; ?>" required title="Solo números. Tamaño obligatorio: 10"></div>
				</div>
				<div class="form-group">
					<label for="id_primer_nombre" class="col-sm-4 control-label"><span class="text-danger">*</span> Nombre Completos:</label>
					<div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo utf8_encode($person->name); ?>" placeholder="Primer nombre del personal" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,40}" title="Letras y números. Tamaño mínimo: 3. Tamaño máximo: 30"></div>
				</div>
				<div class="form-group">
					<label for="genero" class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
					<div class="col-sm-3">
						<select class="select-input form-control input-sm" id="genero" name="genero">
							<option value="1" <?php if($person->genero==1) echo 'selected="selected"'; ?>>Masculino</option>
							<option value="2" <?php if($person->genero==2) echo 'selected="selected"'; ?>>Femenino</option>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<label for="tipo_sangre" class="col-sm-4 control-label"><span class="text-danger">*</span> Tipo de Sangre:</label>
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
					<label for="telefono1" class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
					<div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
				</div>
				<div class="form-group">
					<label for="telefono2" class="col-sm-4 control-label"> Tel&eacute;fono celular:</label>
					<div class="col-sm-3"><input type="text" class="form-control" id="telefono2" name="telefono2" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone2; ?>" minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
				</div>
				<div class="form-group">
					<label for="telefono3" class="col-sm-4 control-label"> Tel&eacute;fono celular:</label>
					<div class="col-sm-3"><input type="text" class="form-control" id="telefono3" name="telefono3" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone3; ?>" minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
				</div>
				<div class="form-group">
					<div class="col-md-2 col-sm-2">
						<input id="active" name="active" type="checkbox" class="activo" <?php if($person->is_active == 1) echo "checked"; ?>>
						<label for="active">&nbsp;&nbsp;Activo </label>
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
  
  document.title = "Near Solutions | Modificacion de los Telefonos";
</script>

