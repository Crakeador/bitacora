<?php 
// Listado de los puesto de servicio de los guardias
$puestos = PuestoData::getAll(2); $lugar = '';

// Detallede las cotizaciones
$hoy = date("Y-m-d H:i:s");

if(isset($_GET['id'])){
	$mensaje = "modificar los datos adicionales de una cotizaci&oacute;n";
	$enlaces = "Modificar";

	$client = CotizacionData::getLike($_GET["id"]);	
	$idcotizacion = $_GET["id"];
	$oficio = $client->oficio;
}else{
	$mensaje = "crear un informe ";
	$enlaces = "Crear";

	if(count($_POST)>0){
		var_dump($_POST);
		$user = new CotizacionData();
		
		$user->id = (int) $_POST["cotizacion_id"];
		$user->asunto = strtoupper($_POST['asunto']);
		$user->tipo_empresa = $_POST["tipo_empresa"];
		$user->contacto = strtoupper($_POST["contacto"]);
		$user->ini_fec = $_POST["ini_fec"];
		$user->telefono1 = $_POST["telefono1"];
		$user->telefono2 = $_POST["telefono2"];
		$user->cargo = $_POST["cargo"];
		$user->email = $_POST["email"];
		
		$_SESSION['cotizar'] = $_POST["cotizacion_id"];
		$user->update();
		Core::redir("cotizar");
	}else{
		$client = (object) [
			"tipo_empresa" => "Privado",
			"asunto" => "",
			"contacto" => "",
			"cargo" => "",
			"email" => "",
			"ini_fec" => date("Y-m-d"),
			"tipo_novedad" => "1",
			"is_active" => "1"
		];
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Informe 
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=informes"><i class="fa fa-database"></i> Informes </a></li>
		<li class="active"> Inf
		orme </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" id="addcotizacion" name="addcotizacion" action="index.php?view=cotizar" role="form">	
		<input type="hidden" id="cotizacion_id" name="cotizacion_id" value="<?php echo $idcotizacion; ?>">
		<div class="callout callout-danger" style="margin-bottom: 0!important;">
			<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
			<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
			Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</div></br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="asunto" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Cliente:</label>
					<div class="col-md-6 col-sm-4">						
						<label>
							<?php
								echo '<select id="localidad_id" name="localidad_id" class="form-control">';
								echo '<option value="0"> -- SELECCIONE EL CLIENTE -- </option>';
								foreach($puestos as $tables) {
									if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
									echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
								}
								echo '</select>';
							?>
						</label>  
					</div>
					<div class="col-md-3 col-sm-4">
						<span class="text-danger">Reporto todas las novedades?</span>
						<div class="radiobutton">
							<input type="radio" id="tipo_novedad" name="tipo_novedad" value="1" <?php if($client->tipo_novedad == "1") echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;
							<input type="radio" id="tipo_novedad" name="tipo_novedad" value="0" <?php if($client->tipo_novedad == "0") echo 'checked="checked"'; ?>> No
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="asunto" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Asunto:</label>
					<div class="col-md-6 col-sm-4">
						<input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" placeholder="Gesti&oacute;n operativa activa de servicio" value="<?php echo $client->asunto; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required>
					</div>
					<div class="col-md-2 col-sm-4">
						<span class="text-danger">Tipo Documento:</span>
						<div class="radiobutton">
							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="Interno" <?php if($client->tipo_empresa == "Interno") echo 'checked="checked"'; ?>> Interno &nbsp;&nbsp;
							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="Externo" <?php if($client->tipo_empresa == "Externo") echo 'checked="checked"'; ?>> Externo
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="contacto" class="col-md-2 col-sm-2 control-label">Contacto:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="contacto" maxlength="50" name="contacto" type="text" placeholder="Nombres y Apellidos del contacto" value="<?php echo $client->contacto; ?>" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 50" required>
					</div>							
					<label for="ini_fec" class="col-md-2 col-sm-2 control-label">Fecha:</label>
					<div class="col-md-4 col-sm-4">
						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $client->ini_fec; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="cargo" class="col-md-2 col-sm-2 control-label">Cargo:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="cargo" maxlength="50" name="cargo" type="text" placeholder="Gerente General" value="<?php echo $client->cargo; ?>">
					</div>
					<label for="email" class="col-md-2 col-sm-2 control-label">Correo Electronico:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="email" minlength="5" maxlength="50" name="email" type="email" placeholder="Correo de la persona a contactar" value="<?php echo $client->email; ?>" autocomplete="email">
					</div>
				</div>
				</br></br>
				<div class="panel panel-default">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_generales" data-toggle="tab" aria-expanded="false">
								<b>Conclusiones</b>
							</a>
						</li>
						<li>
							<a href="#tab_recomienda" data-toggle="tab" aria-expanded="false">
								<b>Recomendaciones
								</b>
							</a>
						</li>
						<li>
							<a href="#tab_anexos" data-toggle="tab" aria-expanded="false">
								<b>Anexos</b>
							</a>
						</li>
					</ul>
					<div class="panel-body">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane active" id="tab_generales">
								<div class="col-md-10">	
									<div class="form-group">
										<label>Conclusiones</label>
										<textarea name="txt_conclusion" id="txt_conclusion" class="form-control" rows="6" placeholder="Describa las conclusiones reportadas en el informe..."></textarea>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_recomienda">
								<div class="col-md-10">	
									<div class="form-group">
										<label>Recomendaciones y Sugerencias</label>
										<textarea name="txt_recomienda" id="txt_recomienda" class="form-control" rows="6" placeholder="Describa las conclusiones reportadas en el informe..."></textarea>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_anexos">								
								<div class="col-md-10">	
									<div class="form-group">
										<label>Anexos de verificacion de Evento</label>
										<textarea name="txt_eventos" id="txt_eventos" class="form-control" rows="6" placeholder="Describa las conclusiones reportadas en el informe..."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>	
  	</form>
  </div>
</section>
<div class="text-right">
  <a href="#" id="js_up" class="ir-arriba" title="Volver arriba">
    <span class="fa-stack">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
    </span>
  </a>
</div>
<!--/ END To Top Scroller -->
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de las cotizaciones";
	
	$('.datepicker').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //invocamos al objeto (window) y a su método (scroll), solo se ejecutara si el usuario hace scroll en la página
    $(window).scroll(function(){
      if($(this).scrollTop() > 300){ //condición a cumplirse cuando el usuario aya bajado 301px a más.
        $("#js_up").slideDown(300); //se muestra el botón en 300 mili segundos
      }else{ // si no
        $("#js_up").slideUp(300); //se oculta el botón en 300 mili segundos
      }
    });

    //creamos una función accediendo a la etiqueta i en su evento click
    $("#js_up i").on('click', function (e) {
      e.preventDefault(); //evita que se ejecute el tag ancla (<a href="#">valor</a>).
      $("body,html").animate({ // aplicamos la función animate a los tags body y html
        scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      },700); //el valor 700 indica que lo ara en 700 mili segundos
      return false; //rompe el bucle
    });
  });
</script>