<?php 
// Detallede las cotizaciones
$hoy = date("Y-m-d H:i:s");
$observacion = OperationTypeData::getAllType('Cotizaciones');

if(isset($_GET['observacion'])){
	$mensaje = "modificar los datos adicionales de una liquidaci&oacute;n";
	$enlaces = "Modificar";

	$user = new CotizacionData();
	
	$user->idcotizacion = $_GET["id"];
	$user->idoperation_type = $_GET["observacion"];
	$user->addObserva();
	
	$client = CotizacionData::getLike($_GET["id"]);	
	$idcotizacion = $_GET["id"];		
	$oficio = $client->oficio;
}else{
	if(isset($_GET['id'])){
		$mensaje = "modificar los datos adicionales de una cotizaci&oacute;n";
		$enlaces = "Modificar";

		$client = CotizacionData::getLike($_GET["id"]);	
		$idcotizacion = $_GET["id"];
		$oficio = $client->oficio;
	}else{
		$mensaje = "crear un nuevo usuario del sistema";
		$enlaces = "Crear";

		if(count($_POST)>0){
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
			if($_SESSION['cotizar']==0){
				$user = new CotizacionData();
				$user->add();
				
				$valor = $user->getCodigo();
				$idcotizacion=$valor->id;
				$oficio = 'C'.str_pad($valor->id, 3, "0", STR_PAD_LEFT).'-'.date("Y");
				$user->updateOficio($oficio, $valor->id);
				
				$client = (object) [
					"tipo_empresa" => "Privado",
					"asunto" => "",
					"contacto" => "",
					"cargo" => "",
					"email" => "",
					"telefono1" => "",
					"telefono2" => "",
					"ini_fec" => date("Y-m-d"),
					"is_active" => "1"
				];
			}else{
				$idcotizacion=$_SESSION['cotizar'];				
				$client = CotizacionData::getLike($idcotizacion);
				$oficio = $client->oficio;
			}
		}
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Cotizacion Nro. <?php echo $oficio; ?>
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./cotizacion"><i class="fa fa-database"></i> Cotizaciones </a></li>
		<li class="active"> Cotizar </li>
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
					<label for="asunto" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Asunto:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->asunto; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required>
					</div>
					<div class="col-md-6 col-sm-4">
						<span class="text-danger">La empresa es:</span>
						<div class="radiobutton">
							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="Publico" <?php if($client->tipo_empresa == "Publico") echo 'checked="checked"'; ?>> P&uacute;blica &nbsp;&nbsp;
							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="Privado" <?php if($client->tipo_empresa == "Privado") echo 'checked="checked"'; ?>> Privada
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
					<label for="telefono1" class="col-md-2 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="number" class="form-control" id="telefono1" name="telefono1" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono1; ?>">
					</div>
					<label for="telefono2" class="col-md-4 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="number" class="form-control" id="telefono2" name="telefono2" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono2; ?>">
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
								<b>Observaciones</b>
							</a>
						</li>
						<li>
							<a href="#tab_liquida" data-toggle="tab" aria-expanded="false">
								<b>Cotizacion</b>
							</a>
						</li>
					</ul>
					<div class="panel-body">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane active" id="tab_generales">
								<div class="row">
									<div class="col-md-12">	
										<a id="btn_guardar_observa" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick(<?php echo $idcotizacion; ?>);">
											<span class="glyphicon glyphicon-plus"></span>Ingresar nuevas observaciones
										</a>
									</div>
									</br></br>
									<div class="col-md-12">	
										<!-- Datos del Usuario -->							
										<div class="form-group">
											<label for="idobservacion" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Observaciones:</label>
											<div class="col-md-8 col-sm-6">
												<?php
													echo '<select id="idobservacion" name="idobservacion" class="form-control select2" onchange="javascript:location.href=\'index.php?view=cotizar&observacion=\'+value+\'&id=\'+'.$idcotizacion.'">';
														echo '<option value="0"> -- SELECCIONE -- </option>';
														foreach($observacion as $tables) {
															echo '<option value="'.$tables->id.'">'.$tables->name.'</option>';
														}
													echo '</select>';
												?>
											</div>
										</div>
									</div>
									<div class="col-md-12">	
										<table id="viewactivo" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th><div align="center">OBSERVACION</div></th>
												</tr>
											</thead>
											<tbody>
												<?php
													$users = CotizacionData::getObserva($idcotizacion);		
													$resultado = count($users); 
													
													if($resultado > 0){
														foreach($users as $tables) {
															echo '<tr>';
																echo '<td>'.$tables->name.'</td>';
															echo '</tr>';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_liquida">
								<div class="row">						
									<div class="col-md-12">
										<button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
											<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
											Agregar/Modificar
										</button>									
										</br></br>
										<!--- Datos de Liquidacion --->
										<table id="viewBitacora" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th><div align="center">DSECRIPCION</div></th>
													<th style="width: 20%"><div align="center">PUNTOS</div></th>
													<th style="width: 20%"><div align="center">VALOR</div></th>
													<th style="width: 20%"><div align="center">TOTAL</div></th>
												</tr>
											</thead>
											<tbody>
												<?php
													$users = CotizacionData::getDetalle($idcotizacion);		
													$resultado = count($users); 
													
													$subtotal=0; $total=0;
													if($resultado > 0){
														foreach($users as $tables) {	
															$total=($tables->cantidad*$tables->monto);
															echo '<tr>';
																echo '<td>'.$tables->descripcion.'</td>';
																echo '<td><div align="right">'.number_format($tables->cantidad,2, ",", ".").'</div></td>';
																echo '<td><div align="right">'.number_format($tables->monto,2, ",", ".").'</div></td>';
																echo '<td><div align="right">'.number_format($total,2, ",", ".").'</div></td>';
															echo '</tr>';																
															$subtotal=$subtotal+$total;
															$total=0;
														}
													}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3"><b>Total</b></td>
													<td headers="hours"><div align="right"><?php echo number_format($subtotal,2, ",", "."); ?></div></td>
												</tr>
											</tfoot>
										</table>							
										<!-- pop up fechas Ingreso y Salida del empleado -->
										<div id="dlg_fechas_empresa" class="modal">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="box-header with-border">
														<h3 class="box-title">Valores a Cotizar</h3>
														<div class="box-tools pull-right">
															<button type="button" class="close" data-dismiss="modal">×</button>
														</div><!-- /.box-tools -->
													</div><!-- /.box-header -->
													<div class="box-body" style="display: block;">
														<div id="finiquito"></div>									
														<div class="form-group">
															<label for="rubro" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
															<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="rubro" name="rubro" value="" placeholder="Descripcion del rubro"></div>
														</div>														
														<div class="form-group">
															<label for="cantidad" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cantidad:</label>
															<div class="col-md-3 col-sm-2">
																<input type="text" class="form-control" id="cantidad" name="cantidad" value="" data-mask placeholder="$ 9.999,99">
															</div>
														</div>
														<div class="form-group">
															<label for="monto" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Monto:</label>
															<div class="col-md-3 col-sm-2">
																<input type="text" class="form-control" id="monto" name="monto" value="" data-mask placeholder="$ 9.999,99">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button id="agregar_fechas_empresa12" class="btn btn-success">
															<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
														</button>
														<button type="button" class="btn btn-danger" data-dismiss="modal">
															<span class="glyphicon glyphicon-remove"> </span> Cancelar
														</button>
													</div>
												</div> <!-- /.modal-content -->
											</div> <!-- /.modal-dialog -->
										</div> <!--/ END modal -->		
										<!-- pop up fechas Ingreso y Salida del empleado -->
										<div id="dlg_cotiza_empresa" class="modal">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="box-header with-border">
														<h3 class="box-title">Valores a Cotizar</h3>
														<div class="box-tools pull-right">
															<button type="button" class="close" data-dismiss="modal">×</button>
														</div><!-- /.box-tools -->
													</div><!-- /.box-header -->
													<div class="box-body" style="display: block;">							
														<div class="form-group">
															<label for="rubro" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
															<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="rubro" name="rubro" value="" placeholder="Descripcion del rubro"></div>
														</div>														
														<div class="form-group">
															<label for="cantidad" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cantidad:</label>
															<div class="col-md-3 col-sm-2">
																<input type="text" class="form-control" id="cantidad" name="cantidad" value="" data-mask placeholder="$ 9.999,99">
															</div>
														</div>
														<div class="form-group">
															<label for="monto" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Monto:</label>
															<div class="col-md-3 col-sm-2">
																<input type="text" class="form-control" id="monto" name="monto" value="" data-mask placeholder="$ 9.999,99">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button id="agregar_fechas_empresa" class="btn btn-success">
															<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
														</button>
														<button type="button" class="btn btn-danger" data-dismiss="modal">
															<span class="glyphicon glyphicon-remove"> </span> Cancelar
														</button>
														<div id="finiquito"></div>
													</div>
												</div> <!-- /.modal-content -->
											</div> <!-- /.modal-dialog -->
										</div> <!--/ END modal -->									
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
<script type="text/javascript">
    $(function(){
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
            $cotizacion = $('#cotizacion_id').val();
			$rubro = $('#rubro').val();			
			$cantidad = $('#cantidad').val();
			$monto = $('#monto').val();
			//alert('Despido: ' + $despido + 'Rubro: ' + $rubro + 'Monto: ' + $monto + 'Fecha: ' + $inifecha + 'Fehas: ' + $finfecha);
			if($cotizacion == 0 || $rubro == '' || $monto == '' || $cantidad == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				// Añadimos la imagen de carga en el contenedor 
				$('#finiquito').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor espere...!!!</div>');

				$.ajax({
					type: "POST",
					url: "ajax/cotizacion.php?cotizacion="+$cotizacion+"&rubro="+$rubro+"&monto="+$monto+"&cantidad="+$cantidad,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
						$('#finiquito').fadeIn(1000).html(data);
						window.location="index.php?view=cotizar&id="+$cotizacion;
					}
				});
			}

            return false;
        }) 
    });
		
	function btn_NuevoOnClick($id) {
		window.location.href = "./index.php?view=newobserva&id="+$id;
	} //
</script>