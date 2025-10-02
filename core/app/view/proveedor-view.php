<?php 
//Pantalla de Manejo de proveedores
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Mostrar la lista de anuncios
		if($_GET["id"] === 0)
			$users = (object) [
				"id" => 0,
				"ruc" => "",
				"nombre" => "",
				"tipo" => "",
				"telefonofac1" => "",
				"telefonofac2" => "",
				"direccion" => "",
				"descripcion" => "",
				"observacion" => "",
				"contacto" => "",
				"cargo" => "",
				"email" => "",
				"telefono1" => "",
				"telefono2" => ""
			];
		else
			$user = ProviderData::getById($_GET["id"]); 

        break;
    case 'POST': 
		// Manejar la creación de un nuevo anuncio	
		$user = new ProviderData();

		$user->ruc = $_POST["ruc"];
		$user->tipo = $_POST["tipo"];
		$user->nombre = $_POST["nombre"];
		$user->descripcion = $_POST["descripcion"];
		$user->contacto = $_POST["contacto"];
		$user->cargo = $_POST["cargo"];
		$user->email = $_POST["email"];
		$user->telefono1 = $_POST["telefono1"];
		$user->telefono2 = $_POST["telefono2"];
		$user->telefonofac1 = $_POST["telefonofac1"];
		$user->telefonofac2 = $_POST["telefonofac2"];
		$user->direccion = $_POST["direccion"];
		$user->observacion = $_POST["observacion"];

		if($_POST["user_id"] === 0){
			$user->add_provider();
		}else{
			$user->update_provider();
		} 

		print "<script>window.location='proveedores';</script>";
		break;
	default:
		// Manejar otros métodos HTTP si es necesario
		$users = (object) [
            "id" => 0,
            "ruc" => "",
            "nombre" => "",
            "tipo" => "",
            "telefonofac1" => "",
            "telefonofac2" => "",
            "direccion" => "",
			"descripcion" => "",
			"observacion" => "",
			"contacto" => "",
			"cargo" => "",
			"email" => "",
			"telefono1" => "",
			"telefono2" => ""
        ];
		break;
}	
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Proveedores
		<small>listado de los provedores</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="proveedores"><i class="fa fa-database"></i> Catalogos </a></li>
		<li class="active"> Modificar </li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<!-- Dialogo para seleccionar una cuenta -->
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" id="addproduct" action="proveedor" role="form">
		<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
		<div class="panel panel-default">
			<div class="panel-heading">
					<h3 class="panel-title">Información del Asiento</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
						<div class="col-md-6 col-sm-3">
							<span class="text-danger">DATOS BASICOS:</span>
						</div>
						<div class="col-sm-2">
							<span class="text-danger">DATOS DE FACTURACION:</span>
						</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> R.U.C.:</label>
					<div class="col-md-3 col-sm-4">
						<input class="text-field form-control input-sm" id="id_ruc" maxlength="13" name="ruc" type="text" value="<?php echo $user->ruc; ?>">
					</div>
					<label class="col-sm-3 control-label"> Tel&eacute;fono convencial:</label>
					<div class="col-sm-2"><input type="text" class="form-control" id="telefono1" name="telefonofac1" value="<?php echo $user->telefonofac1; ?>" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Tipo Persona:</label>
					<div class="col-md-3 col-sm-4">
						<select class="select-input form-control input-sm" id="id_tipo" name="tipo">
							<option value="1" <?php if($user->tipo==1) echo 'selected="selected"'; ?>> Natural </option>
							<option value="2" <?php if($user->tipo==2) echo 'selected="selected"'; ?>> Jur&iacute;dico </option>
							<option value="3" <?php if($user->tipo==3) echo 'selected="selected"'; ?>> Sin RUC </option>
						</select>
					</div>
					<label class="col-sm-3 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
					<div class="col-sm-2"><input type="text" class="form-control" id="telefono2" name="telefonofac2" value="<?php echo $user->telefonofac2; ?>" data-inputmask='"mask": "99-99999999"' data-mask placeholder="99-99999999"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-3 control-label"><span class="text-danger">*</span> Nombre Comercial:</label>
					<div class="col-md-3 col-sm-4">
						<input class="text-field form-control input-sm" id="id_nombre" name="nombre" value="<?php echo $user->nombre; ?>" type="text">
					</div>
					<label class="col-sm-3 control-label"><span class="text-danger">*</span> Direcci&oacute;n:</label>
					<div class="col-sm-4">
						<input class="text-field form-control input-sm" id="id_direccion" name="direccion" value="<?php echo $user->direccion; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-sm-2 control-label"><span class="text-danger">*</span> Descripci&oacute;n de los producto:</label>
					<div class="col-md-3">
						<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="3"><?php echo $user->descripcion; ?></textarea>
					</div>
					<label class="col-sm-3 control-label"> Observaci&oacute;n:</label>
					<div class="col-md-3">
						<textarea class="form-control input-sm" cols="50%" id="id_observacion" name="observacion" rows="3"><?php echo $user->observacion; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><span class="text-danger">*</span> Contacto:</label>
					<div class="col-sm-4">
						<input class="text-field form-control input-sm" id="id_contacto" name="contacto" value="<?php echo $user->contacto; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><span class="text-danger">*</span> Cargo:</label>
					<div class="col-sm-4">
						<input class="text-field form-control input-sm" id="id_cargo" name="cargo" value="<?php echo $user->cargo; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"> E-mail:</label>
					<div class="col-sm-4">
						<input class="text-field form-control input-sm" id="id_email" name="email" value="<?php echo $user->email; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
						<label class="col-sm-2 control-label"> Tel&eacute;fono convencial:</label>
						<div class="col-sm-2"><input type="text" class="form-control" id="telefono1" name="telefono1" value="<?php echo $user->telefono1; ?>" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999"></div>
				</div>
				<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
						<div class="col-sm-2"><input type="text" class="form-control" id="telefono2" name="telefono2" value="<?php echo $user->telefono2; ?>" data-inputmask='"mask": "99-99999999"' data-mask placeholder="99-99999999"></div>
				</div></br>
				<div class="form-group">
					<div class="col-sm-5">
						<label class="col-sm-1 control-label">&nbsp;</label>
						<input id="id_active" name="active" type="checkbox" checked>
						<label for="id_gasto_no_deducible">&nbsp;&nbsp;Activo </label>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Agregar Proveedor</button>
	</form>
	<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
	<!--/ END To Top Scroller -->
</section>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-red',
	    radioClass: 'iradio_flat-red'
	  });
	});
</script>
