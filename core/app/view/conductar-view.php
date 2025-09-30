<?php 
//Detalle de las cotizaciones
//Modificado: 12/03/2024
$hoy = date("Y-m-d H:i:s");

if(isset($_GET['borrar'])){
	$mensaje = "modificar los datos adicionales de un salvo conducto";
	$enlaces = "Modificar";
	$user = new CotizacionData();
	
	$user->id = $_GET["borrar"];
	$user->delSalida();
}

if(isset($_GET['dato'])){ //Ingreso de datos
	$mensaje = "modificar los datos adicionales de un salvo conducto";
	$enlaces = "Modificar";

	$user = new CotizacionData();
	
	$user->idcotizacion = $_GET["id"];
	$user->dato = $_GET["dato"];
	$user->tipo = $_GET["tipo"];
	
	$arma = $user->addDatos();
	
	if($_GET["tipo"] == 1){
    	$user = new OperationData();
    	$user->id = $_GET["dato"];
    	
    	$arma = $user->updateTipo();
	}
}else{
	$mensaje = "crear un salvo conducto";
	$enlaces = "Crear";
	
	if(count($_POST)>0){
		$user = new CotizacionData();
		
		$user->id = (int) $_POST["cotizacion_id"];
		$user->asunto = strtoupper($_POST['asunto']);
		$user->tipo_empresa = $_POST["tipo_empresa"];
		$user->contacto = strtoupper($_POST["contacto"]);
		$user->ini_fec = $_POST["ini_fec"];
		$user->fin_fec = $_POST["fin_fec"];
		$user->telefono = $_POST["telefono"];
		$user->ruc = $_POST["ruc"];
		$user->observacion = $_POST["observacion"];
		$user->municion = $_POST["municion"];
		
		$user->update();
		Core::redir("conducta");
	}else{
		if($_GET["id"] == 0){
			$user = new CotizacionData();
			$user->addConducta();
			
			$valor = $user->getCodigo();
			$idcotizacion=$valor->id;
			$oficio = 'SC-'.date("Y").'-'.str_pad($valor->id, 3, "0", STR_PAD_LEFT);
			$user->updateOficio($oficio, $valor->id);
			
			$client = (object) [
				"tipo_empresa" => "Capital",
				"asunto" => "",
				"contacto" => "",
				"cargo" => "",
				"municion" => "", 
				"telefono" => "",
				"observacion" => "",
				"ruc" => "",
				"ini_fec" => date("Y-m-d"),
				"is_active" => "1"
			];
		}else{
			if(isset($_SESSION['cotizar']))
				$idcotizacion=$_SESSION['cotizar'];	
			else
				$idcotizacion=$_GET["id"];	

			$client = CotizacionData::getLike($idcotizacion);
			$oficio = $client->oficio;
		}
	}
}

if(isset($_GET['id']) && $_GET['id'] > 0){
	$mensaje = "modificar los datos adicionales de un salvo conducto";
	$enlaces = "Modificar";

	$client = CotizacionData::getLike($_GET["id"]);	
	$idcotizacion = $_GET["id"];
	$oficio = $client->oficio;
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Documento Nro. <?php echo $oficio; ?>
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="conducta"><i class="fa fa-database"></i> Salvo Conducto </a></li>
		<li class="active"> <?php echo $enlaces; ?> </li>
	</ol>
</section>
</br>
<section id="main" role="main">
    <div class="container-fluid">
        <form class="form-horizontal" method="post" id="addconducta" name="addconducta" action="index.php?view=conductar" role="form">	
    		<input type="hidden" id="cotizacion_id" name="cotizacion_id" value="<?php echo $idcotizacion; ?>">
    		<div class="callout callout-danger" style="margin-bottom: 0!important;">
    			<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
    			<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
    			Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
    		</div></br>
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title">Informaci&oacute;n del cliente</h3>
    			</div>
    			<div class="panel-body">
    				<div class="form-group">
    					<label for="contacto" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Cliente:</label>
    					<div class="col-md-4 col-sm-4">
    						<input class="text-field form-control input-sm" id="contacto" name="contacto" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->contacto; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required autofocus>
    					</div>
    					<div class="col-md-6 col-sm-4">
    						<span class="text-danger">Alcance del Salvo conducto:</span>
    						<div class="radiobutton">
    							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="3" <?php if($client->tipo_empresa == "Capital") echo 'checked="checked"'; ?>> Ciudad &nbsp;&nbsp;
    							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="4" <?php if($client->tipo_empresa == "Provincial") echo 'checked="checked"'; ?>> Provincia&nbsp;&nbsp;
    							<input type="radio" id="tipo_empresa" name="tipo_empresa" value="5" <?php if($client->tipo_empresa == "Nacional") echo 'checked="checked"'; ?>> Nacional
    						</div>
    					</div>
    				</div>
    				<div class="form-group">
    					<label for="asunto" class="col-md-2 col-sm-2 control-label">Destino:</label>
    					<div class="col-md-4 col-sm-4">
    						<input class="text-field form-control input-sm" id="asunto" maxlength="50" name="asunto" type="text" placeholder="Guayaquil-Guayas-Todo el territorio nacional" value="<?php echo $client->asunto; ?>" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 50" required>
    					</div>					
    					<label for="ini_fec" class="col-md-2 col-sm-2 control-label">Desde:</label>
    					<div class="col-md-4 col-sm-4">
    						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
    							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $client->ini_fec; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
    						</div>
    					</div>
    				</div>
    				<div class="form-group">
    				    <label for="inputEmpresa" class="col-lg-2 control-label"><span class="text-danger">*</span> RUC:</label>
    					<div class="col-md-4 col-sm-4">
    						<input type="number" class="form-control" id="ruc" name="ruc" minlength="13" maxlength="13" data-inputmask='"mask": "9999999999999"' data-mask placeholder="1234567890123" value="<?php echo $client->ruc; ?>" pattern="[0-9]{13}" title="Solo números, debe ser un RUC de empresa minimo 13" required>
    					</div>					
    					<label for="fin_fec" class="col-md-2 col-sm-2 control-label">Hasta:</label>
    					<div class="col-md-4 col-sm-4">
    						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
    							<input type="date" class="form-control" id="fin_fec" name="fin_fec" value="<?php echo $client->fin_fec; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
    						</div>
    					</div>
    				</div>
    				<div class="form-group">
    					<label for="observacion" class="col-md-2 col-sm-2 control-label">Valor a Proteger:</label>
    					<div class="col-md-4 col-sm-4">
    					    <textarea id="observacion" name="observacion" rows="4" cols="58"><?php echo $client->observacion; ?></textarea>
    					</div>
    					<label for="municion" class="col-md-2 col-sm-2 control-label">Municiones:</label>
    					<div class="col-md-4 col-sm-4">
    						<input class="text-field form-control input-sm" id="municion" name="municion" type="text" placeholder="Cantidad de municiones" value="<?php echo $client->municion; ?>">
    					</div>
    				</div>
    				</br></br>
    				<div class="panel panel-default">
    					<ul class="nav nav-tabs">
    						<li class="active">
    							<a href="#tab_armamento" data-toggle="tab" aria-expanded="false">
    								<b>Armamento</b>
    							</a>
    						</li>
    						<li>
    							<a href="#tab_personal" data-toggle="tab" aria-expanded="false">
    								<b>Personal</b>
    							</a>
    						</li>
    					</ul>
    					<div class="panel-body">
    						<!-- tabs content -->
    						<div class="tab-content panel">
    							<div class="tab-pane active" id="tab_armamento">
    								<div class="row">						
    									<div class="col-md-12">
    									    <div class="form-group">
    											<label for="idarmas" class="col-md-1 col-sm-3 control-label"><span class="text-danger">*</span> Armas:</label>
    											<div class="col-md-6 col-sm-5">
                    							    <?php
                    			                        echo '<select id="idarmas" name="idarmas" class="form-control select2" style="width: 100%;" onchange="javascript:location.href=\'index.php?view=conductar&tipo=1&dato=\'+value+\'&id=\'+'.$idcotizacion.'">';
                    					                    echo '<option value="0"> -- SELECCIONE -- </option>';
                    					                    $armas = OperationData::getByAllTipo(6);
    
                    					                    foreach($armas as $tables) {
                    					                        echo '<option value="'.$tables->id.'">'.$tables->serial.'</option>'; 
                    					                    } 
                    					               echo '</select>';
                    		                        ?>
    											</div>
    										</div>
    										<!--- Datos de las armas --->
    										<table id="viewBitacora" class="table table-bordered table-hover">
    											<thead>
    												<tr>
    													<th style="width: 12%"><div align="center">NRO.</div></th>
    													<th><div align="center">DESCRIPCION</div></th>
    													<th style="width: 20%"><div align="center">MARCA</div></th>
    													<th style="width: 20%"><div align="center">SERIAL</div></th>
    													<th style="width: 20%"><div align="center">COSTO</div></th>
    												</tr>
    											</thead>
    											<tbody>
    												<?php
        												if($idcotizacion == NULL){
        												    // Sin nada
        												}else{
        													$users = CotizacionData::getArmas($idcotizacion);		
        													$resultado = count($users); 
        													
        													$i=1; $total=0;
        													if($resultado > 0){
        														foreach($users as $tables) {
        														    $total=$total+$tables->price_out;
        															echo '<tr>';
        																echo '<td><div align="center">'.$i.'&nbsp;&nbsp;<a href="index.php?view=conductar&borrar='.$tables->valor.'&id='.$idcotizacion.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div></td>';
        																echo '<td>'.$tables->name.'</td>';
        																echo '<td>'.$tables->unit.'</td>';
        																echo '<td>'.$tables->serial.'</td>';
        																echo '<td><div align="right">'.number_format($tables->price_out,2, ",", ".").'</div></td>';
        															echo '</tr>';
        															$i++;
        														}
        													}
        												}
    												?>
    											</tbody>
    											<tfoot>
    												<tr>
    													<td colspan="4"><b>Total</b></td>
    													<td headers="hours"><div align="right"><?php echo number_format($total,2, ",", "."); ?></div></td>
    												</tr>
    											</tfoot>
    										</table>	
    									</div>
    								</div>
    							</div>
    							<div class="tab-pane" id="tab_personal">
    							    <button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
    									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
    									Agregar/Modificar
    								</button>									
    								</br></br>
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
    												<div class="form-group">
    													<label for="cantidad" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cedula:</label>
    													<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="cedula" name="cedula" value="" placeholder="Cedula"></div>
    												</div>						
    												<div class="form-group">
    													<label for="rubro" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Nombres y Apellidos:</label>
    													<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombres del protector"></div>
    												</div>										
    												<div class="form-group">
    													<label for="cantidad" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cargo:</label>
    													<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="cargo" name="cargo" value="" placeholder="Cargo"></div>
    												</div>
    												<div class="form-group">
    													<label for="monto" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Telefono:</label>
    													<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="telefono" name="telefono" value="" placeholder="0909090909"></div>
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
    								<div class="row">						
    									<div class="col-md-12">
    										<!--- Datos de Liquidacion --->
    										<table id="viewBitacora" class="table table-bordered table-hover">
    											<thead>
    												<tr>
    													<th style="width: 12%"><div align="center">NRO.</div></th>
    													<th style="width: 20%"><div align="center">CARGO</div></th>
    													<th><div align="center">APELLIDOS Y NOMBRE</div></th>
    													<th style="width: 20%"><div align="center">CEDULA</div></th>
    													<th style="width: 20%"><div align="center">TELEFONO</div></th>
    												</tr>
    											</thead>
    											<tbody>
    												<?php
    												if($idcotizacion == NULL){
    												    //No hay Acciones
    												}else{
    													$users = CotizacionData::getDatos($idcotizacion);		
    													$resultado = count($users); 
    													
    													$i=1;
    													if($resultado > 0){
    														foreach($users as $tables) {
    															echo '<tr>';
    																echo '<td><div align="center">'.$i.'&nbsp;&nbsp;<a href="index.php?view=conductar&borrar='.$tables->id.'&id='.$idcotizacion.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div></td>';
    																echo '<td>'.$tables->description.'</td>';
    																echo '<td>'.$tables->name.'</td>';
    																echo '<td><div align="center">'.$tables->idcard.'</div></td>';
    																echo '<td><div align="center">'.$tables->phone.'</div></td>';
    															echo '</tr>';																
    															$i++;
    														}
    													}
    												} ?>
    											</tbody>
    										</table>								
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
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de los Salvoconductos";
	
	$('.datepicker').datepicker({		
		locale: 'es',
        daysOfWeekDisabled: [0, 6],
        format: 'DD/MM/YYYY',
        useCurrent:true
	});
	
    $(function(){
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
            $cotizacion = $('#cotizacion_id').val();
			$cedula = $('#cedula').val();			
			$nombre = $('#nombre').val();
			$cargo = $('#cargo').val();
			$telefono = $('#telefono').val();
			
			if($nombre == '' || $cedula == '' || $cargo == '' || $telefono == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/salvar.php?cotizacion="+$cotizacion+"&cedula="+$cedula+"&nombre="+$nombre+"&cargo="+$cargo+"&telefono="+$telefono,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
						window.location="index.php?view=conductar&id="+$cotizacion;
					}
				});
			} 

            return false;
        }) 
    });
</script>