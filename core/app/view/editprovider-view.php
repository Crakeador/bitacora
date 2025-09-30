<?php $user = ProviderData::getById($_GET["id"]); ?>
<div class="row">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Proveedores
			<small>listado de los provedores</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php?view=catpro.lista"><i class="fa fa-database"></i> Catalogos </a></li>
			<li class="active"> Modificar </li>
		</ol>
	</section>
	</br>
	<section id="main" role="main">
		<div class="container-fluid">
			<div class="row">
				<input type="hidden" id="ndetalles" value="2">
				<!-- Dialogo para seleccionar una cuenta -->
				<div class="col-md-12">
					<p class="alert alert-info">
						<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
						- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
					</p>
					<!-- START panel -->
					<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateprovider" role="form">
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
									<label class="col-sm-2 control-label"> Observaci&oacute;n:</label>
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
				</div>
			</div>
		</div>
		<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
		<!--/ END To Top Scroller -->
	</section>
</div>
</br>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-red',
	    radioClass: 'iradio_flat-red'
	  });
	});
</script>
