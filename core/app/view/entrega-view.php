<?php 
// Detallede las cotizaciones
$lugars = LugarData::getAll();

// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        //echo '--------------- GET -------------------<br>';
        //var_dump($_GET);
        $mensaje = "crear una cotizaci&oacute;n";
		$enlaces = "Crear";
		
		$oficio = "";
		
		$client = (object) [
				"paquete" => 0,
				"nombre" => "",
				"idcarro" => 0,
				"municion" => 0,
				"telefono" => "",
				"ini_fec" => date("Y-m-d"),
				"is_active" => "1"
			];
			
    	if(isset($_GET['dato'])){ //Ingreso de datos
        	$user = new CotizacionData();
        	
        	$user->idcotizacion = $_GET["id"];
        	$user->dato = $_GET["dato"];
        	$user->tipo = $_GET["tipo"];
        	
        	$arma = $user->addDatos();
            $idruta = $_GET["id"];
            
        	$client = CustodiaData::getLike("id", $_GET["id"]);	
        }else{
            if(isset($_GET['id'])){
        		$client = CustodiaData::getLike("id", $_GET["id"]);	
        		$idruta = $_GET["id"];
        	}
        }
        break;
    case 'POST':
        $mensaje = "verificacion del vehiculo";
		$enlaces = "Crear";
		$user = new CustodiaData();
		
		//Revision Vehicular
        $user->id = $_POST["entrega_id"];
		$user->municion2 = $_POST["municion2"];
		$user->kilometraje2 = $_POST["kilometraje2"];
		$user->fecha2 = $_POST["fecha2"];
        $user->llantas2 = $_POST["llantas2"];
        $user->ollantas2 = $_POST["ollantas2"];
        $user->rayones2 = $_POST["rayones2"];
        $user->orayones2 = $_POST["orayones2"];
        $user->espejos2 = $_POST["espejos2"];
        $user->oespejos2 = $_POST["oespejos2"];
        $user->puertas12 = $_POST["puertas12"];
        $user->opuertas12 = $_POST["opuertas12"];
        $user->capo2 = $_POST["capo2"];
        $user->ocapo2 = $_POST["ocapo2"];
        $user->balde2 = $_POST["balde2"];
        $user->obalde2 = $_POST["obalde2"];
        $user->guias12 = $_POST["guias12"];
        $user->oguias12 = $_POST["oguias12"];
        $user->guias22 = $_POST["guias22"];
        $user->oguias22 = $_POST["oguias22"];
        $user->luces2 = $_POST["luces2"];
        $user->oluces2 = $_POST["oluces2"];
        $user->motor2 = $_POST["motor2"];
        $user->anomalia2 = $_POST["anomalia2"];
        $user->asientos2 = $_POST["asientos2"];
        $user->oasientos2 = $_POST["oasientos2"];
        $user->panel2 = $_POST["panel2"];
        $user->opanel2 = $_POST["opanel2"];
        $user->cinturon2 = $_POST["cinturon2"];
        $user->ocinturon2 = $_POST["ocinturon2"];
        $user->forros2 = $_POST["forros2"];
        $user->oforros2 = $_POST["oforros2"];
        $user->elevadores2 = $_POST["elevadores2"];
        $user->oelevadores2 = $_POST["oelevadores2"];
        $user->aire2 = $_POST["aire2"];
        $user->oaire2 = $_POST["oaire2"];
        $user->parabrisa2 = $_POST["parabrisa2"];
        $user->oparabrisa2 = $_POST["oparabrisa2"];
        $user->emergencia2 = $_POST["emergencia2"];
        $user->oemergencia2 = $_POST["oemergencia2"];
        $user->extintor2 = $_POST["extintor2"];
        $user->oextintor2 = $_POST["oextintor2"];
        $user->techo2 = $_POST["techo2"];
        $user->otecho2 = $_POST["otecho2"];
        $user->puertas22 = $_POST["puertas22"];
        $user->opuertas22 = $_POST["opuertas22"];
        $user->enciende2 = $_POST["enciende2"];
        $user->oenciende2 = $_POST["oenciende2"];
        $user->aceite2 = $_POST["aceite2"];
        $user->oaceite2 = $_POST["oaceite2"];
        $user->hidraulico2 = $_POST["hidraulico2"];
        $user->ohidraulico2 = $_POST["ohidraulico2"];
        $user->freno2 = $_POST["freno2"];
        $user->ofreno2 = $_POST["ofreno2"];
        $user->refrigerante2 = $_POST["refrigerante2"];
        $user->orefrigerante2 = $_POST["orefrigerante2"];

	    $_SESSION["entrega_id"] = $_POST["entrega_id"];
	    $user->update2();

		Core::redir("entregas");
    break;
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php if($idruta == "") echo 'Acta de Entrega'; else echo 'Hoja de Ruta Nro. '.$idruta; ?>
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $_SESSION["url"]; ?>vehiculos"><i class="fa fa-database"></i> Vehiculos </a></li>
		<li class="active"> Entregas </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" id="addentrega" name="addentrega" action="<?php echo $_SESSION["url"]; ?>entrega" role="form">	
		<input type="hidden" id="entrega_id" name="entrega_id" value="<?php echo $idruta; ?>">
		<input type="hidden" id="oficio" name="oficio" value="<?php echo $oficio; ?>">
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
					<label for="nombre" class="col-md-2 col-sm-2 control-label"> Recibe:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" value="<?php echo $client->nombre; ?>" disabled="disabled">
					</div>
					<label for="cedula" class="col-md-2 col-sm-2 control-label"> Cedula:</label>
					<div class="col-md-2 col-sm-2">
						<input class="form-control" id="cedula" name="cedula" type="text" value="<?php echo $client->cedula; ?>" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<label for="idcarro" class="col-md-2 col-sm-2 control-label"> Vehiculos:</label>
					<div class="col-md-4 col-sm-4">
					    <?php
	                        echo '<select id="idcarro" name="idcarro" class="form-control select2" style="width: 100%;" disabled="disabled">';
			                    echo '<option value="0"> -- SELECCIONE -- </option>';
			                    $armas = OperationData::getByAllTipo(8);

			                    foreach($armas as $tables) {
			                        if($client->vehiculo == $tables->id) $cadena = 'selected="selected"'; else $cadena = '';
			                        echo '<option value="'.$tables->id.'" '.$cadena.'>'.$tables->serial.'</option>'; 
			                    } 
			               echo '</select>';
                        ?>
					</div>					
					<label for="ini_fec" class="col-md-2 col-sm-2 control-label">Fecha:</label>
					<div class="col-md-4 col-sm-4">
						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $client->fecha; ?>" disabled="disabled">
						</div>
					</div>
				</div>
				<div class="form-group">
				    <label for="municion" class="col-md-2 col-sm-2 control-label"> Municiones:</label>
					<div class="col-md-4 col-sm-4">
						<input type="number" class="form-control" id="municion" name="municion" value="<?php echo $client->municion; ?>" disabled="disabled">
					</div>
					<label for="telefono" class="col-md-2 col-sm-2 control-label"> Kilometraje:</label>
					<div class="col-md-2 col-sm-2">
						<input type="number" class="form-control" id="kilometraje" name="kilometraje" value="<?php echo number_format($client->kilometraje, 0, '.', ''); ?>" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
				    <label for="municion" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Municiones:</label>
					<div class="col-md-4 col-sm-4">
						<input type="number" class="form-control" id="municion2" name="municion2" minlength="1" maxlength="2" data-inputmask='"mask": "99"' data-mask placeholder="12" value="<?php echo $client->municion2; ?>" pattern="[0-9]{13}" title="Solo números, debe ser el numero la orden" required>
					</div>			
					<label for="ini_fec" class="col-md-2 col-sm-2 control-label">Fecha:</label>
					<div class="col-md-4 col-sm-4">
						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
							<input type="date" class="form-control" id="fecha2" name="fecha2" value="<?php echo date("Y-m-d"); ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
						</div>
					</div>
				</div>
				<div class="form-group">
				    <label for="municion" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Observacion:</label>
					<div class="col-md-4 col-sm-4">
						<input type="text" class="form-control" id="observacion" name="observacion" maxlength="120" value="<?php echo $client->observacion; ?>" title="Solo números, debe ser el numero la orden" required>
					</div>
					<label for="telefono" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Kilometraje:</label>
					<div class="col-md-2 col-sm-2">
						<input type="number" class="form-control" id="kilometraje2" name="kilometraje2" minlength="5" maxlength="10" data-inputmask='"mask": "999999"' data-mask placeholder="999999" value="<?php echo $client->kilometraje2; ?>" required>
					</div>
				</div>
				<br>
				<div class="panel panel-default" <?php if($idruta == "") echo 'style="display: none"'; ?>>
					<ul class="nav nav-tabs">
						<li>
							<a href="#tab_armamento" data-toggle="tab" aria-expanded="false">
								<b>Armas</b>
							</a>
						</li>
						<li>
							<a href="#tab_personal" data-toggle="tab" aria-expanded="false">
								<b>Personal</b>
							</a>
						</li>
                        <li class="active">
                            <a href="#tab_entregas" data-toggle="tab" aria-expanded="false">
                                <b>Entrega</b>
                            </a>
                        </li>
					</ul>
					<div class="panel-body">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane" id="tab_armamento">
								<div class="row">						
									<div class="col-md-12">
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
													$users = CotizacionData::getArmas($idruta, 3);		
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
													$users = CustodiaData::getDatos($idruta);		
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
												?>
											</tbody>
										</table>								
									</div>
								</div>
							</div>
                            <div class="tab-pane active" id="tab_entregas">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <!-- panel heading/header -->
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-fw fa-car"></i>&nbsp;Revision de la Parte Externa</h3>
                                            </div>
                                            <!--/ panel heading/header -->
                                            <!-- panel body with collapse capable -->
                                            <div class="panel-collapse pull out">
                                                <div class="panel-body">
                                                    <div class="" id="fisicos">
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Llantas Buenas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="llantas2" name="llantas2" value="1" <?php if($client->llantas2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="llantas2" name="llantas2" value="0" <?php if($client->llantas2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ollantas2" name="ollantas2" value="<?php echo $client->ollantas2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Tiene Rayones?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="rayones2" name="rayones2" value="1" <?php if($client->rayones2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="rayones2" name="rayones2" value="0" <?php if($client->rayones2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="orayones2" name="orayones2" value="<?php echo $client->orayones2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Espejos?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="espejos" name="espejos2" value="1" <?php if($client->espejos2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="espejos" name="espejos2" value="0" <?php if($client->espejos2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oespejos2" name="oespejos2" value="<?php echo $client->oespejos2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Puertas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="puertas1" name="puertas12" value="1" <?php if($client->puertas12==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="puertas1" name="puertas12" value="0" <?php if($client->puertas12==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opuertas12" name="opuertas12" value="<?php echo $client->opuertas12; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Capo hundido?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="capo2" name="capo2" value="1" <?php if($client->capo2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="capo2" name="capo2" value="0" <?php if($client->capo2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ocapo2" name="ocapo2" value="<?php echo $client->ocapo2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Balde bueno?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="balde2" name="balde2" value="1" <?php if($client->balde2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="balde2" name="balde2" value="0" <?php if($client->balde2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="obalde2" name="obalde2" value="<?php echo $client->obalde2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Guias Golpedas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="guias12" name="guias12" value="1" <?php if($client->guias12==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="guias12" name="guias12" value="0" <?php if($client->guias12==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oguias12" name="oguias12" value="<?php echo $client->oguias12; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Guias Rotas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="guias22" name="guias22" value="1" <?php if($client->guias22==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="guias22" name="guias22" value="0" <?php if($client->guias22==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oguias22" name="oguias22" value="<?php echo $client->oguias22; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-4">
                                                                <label class="col-sm-4 control-label">Luces buenas?</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="luces2" name="luces2" value="1" <?php if($client->luces2==1) echo 'checked'; ?>> Buenas &nbsp;&nbsp;
                                                                        <input type="radio" id="luces2" name="luces2" value="0" <?php if($client->luces2==0) echo 'checked'; ?>> Malas
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oluces2" name="oluces2" value="<?php echo $client->oluces2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <span class="text-danger">Tiene sonidos raros el motor?</span>
                                                                <div class="radiobutton">
                                                                    <input type="radio" id="motor2" name="motor2" value="1" <?php if($client->motor2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                    <input type="radio" id="motor2" name="motor2" value="0" <?php if($client->motor2==0) echo 'checked'; ?>> No
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-danger">Tiene alguna anomalia interna?</span>
                                                                <div class="radiobutton">
                                                                    <input type="radio" id="anomalia2" name="anomalia2" value="1" <?php if($client->anomalia2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                    <input type="radio" id="anomalia2" name="anomalia2" value="0" <?php if($client->anomalia2==0) echo 'checked'; ?>> No
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Informacion personal Operativo -->
                                    <div class="col-md-12">
                                        <div id="personalizados_proveedor">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-fw fa-dashboard"></i>&nbsp;Revision de la Parte Interna</h3>
                                                </div>
                                                <div class="panel-collapse pull out">
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Asientos rotos?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="asientos2" name="asientos2" value="1" <?php if($client->asientos2==1) echo 'checked'; ?>> Buenos &nbsp;&nbsp;
                                                                        <input type="radio" id="asientos2" name="asientos2" value="0" <?php if($client->asientos2==0) echo 'checked'; ?>> Rotos
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oasientos2" name="oasientos2" value="<?php echo $client->oasientos2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Panel?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="panel2" name="panel2" value="1" <?php if($client->panel2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="panel2" name="panel2" value="0" <?php if($client->panel2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opanel2" name="opanel2" value="<?php echo $client->opanel2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Cinturones buenos?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="cinturon2" name="cinturon2" value="1" <?php if($client->cinturon2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="cinturon2" name="cinturon2" value="0" <?php if($client->cinturon2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ocinturon2" name="ocinturon2" value="<?php echo $client->ocinturon2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Forros buenos?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="forros2" name="forros2" value="1" <?php if($client->forros2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="forros2" name="forros2" value="0" <?php if($client->forros2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oforros2" name="oforros2" value="<?php echo $client->oforros2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Elevadores buenos?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="elevadores2" name="elevadores2" value="1" <?php if($client->elevadores2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="elevadores2" name="elevadores2" value="0" <?php if($client->elevadores2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oelevadores2" name="oelevadores2" value="<?php echo $client->oelevadores2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">A/C funciona?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="aire2" name="aire2" value="1" <?php if($client->aire2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="aire2" name="aire2" value="0" <?php if($client->aire2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oaire2" name="oaire2" value="<?php echo $client->oaire2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Limpia Parabrisas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="parabrisa2" name="parabrisa2" value="1" <?php if($client->parabrisa2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="parabrisa2" name="parabrisa2" value="0" <?php if($client->parabrisa2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oparabrisa2" name="oparabrisa2" value="<?php echo $client->oparabrisa2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Kit de Emergencia completo?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="emergencia2" name="emergencia2" value="1" <?php if($client->emergencia2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="emergencia2" name="emergencia2" value="0" <?php if($client->emergencia2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oemergencia2" name="oemergencia2" value="<?php echo $client->oemergencia2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Extintor?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="extintor2" name="extintor2" value="1" <?php if($client->extintor2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="extintor2" name="extintor2" value="0" <?php if($client->extintor2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oextintor2" name="oextintor2" value="<?php echo $client->oextintor2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Techo roto?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="techo2" name="techo2" value="1" <?php if($client->techo2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="techo2" name="techo2" value="0" <?php if($client->techo2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="otecho2" name="otecho2" value="<?php echo $client->otecho2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Puertas buenas?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="puertas22" name="puertas22" value="1" <?php if($client->puertas22==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="puertas22" name="puertas22" value="0" <?php if($client->puertas22==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opuertas22" name="opuertas22" value="<?php echo $client->opuertas22; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Enciende bien?</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="enciende2" name="enciende2" value="1" <?php if($client->enciende2==1) echo 'checked'; ?>> Normal &nbsp;&nbsp;
                                                                        <input type="radio" id="enciende2" name="enciende2" value="0" <?php if($client->enciende2==0) echo 'checked'; ?>> Problematico
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oenciende2" name="oenciende2" value="<?php echo $client->oenciende2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Form Referencias Personales -->
                                    <!-- Referencias de Vehiculos -->
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <!-- panel heading/header -->
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-fw fa-simplybuilt"></i>&nbsp;Revision del Motor</h3>
                                            </div>
                                            <!--/ panel heading/header -->
                                            <!-- panel body with collapse capable -->
                                            <div class="panel-collapse pull out">
                                                <div class="panel-body">
                                                    <div class="" id="fisicos">
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Aceite Motor?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="aceite2" name="aceite2" value="1" <?php if($client->aceite2==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="aceite2" name="aceite2" value="0" <?php if($client->aceite2==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oaceite2" name="oaceite2" value="<?php echo $client->oaceite2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Aceite Hidraulico?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="hidraulico2" name="hidraulico2" value="1" <?php if($client->hidraulico2==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="hidraulico2" name="hidraulico2" value="0" <?php if($client->hidraulico2==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ohidraulico2" name="ohidraulico2" value="<?php echo $client->ohidraulico2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Liquido Freno?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="freno2" name="freno2" value="1" <?php if($client->freno2==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="freno2" name="freno2" value="0" <?php if($client->freno2==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ofreno2" name="ofreno2" value="<?php echo $client->ofreno2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Refrigerante?</label>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="refrigerante2" name="refrigerante2" value="1" <?php if($client->refrigerante2==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="refrigerante2" name="refrigerante2" value="0" <?php if($client->refrigerante2==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="orefrigerante2" name="orefrigerante2" value="<?php echo $client->orefrigerante2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Referencias de Vehiculos -->
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
    document.title = "Near Solutions | Registro de las cotizaciones";
	
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
            $cotizacion = $('#entrega_id').val();
			$idlugar = $('#idlugar').val();
			$rubro = $('#rubro').val();
			$cantidad = $('#cantidad').val();
			$monto = $('#monto').val();
			
			if($cotizacion == 0 || $idlugar == '' || $rubro == '' || $monto == '' || $cantidad == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/cotizacion.php?cotizacion="+$cotizacion+"&rubro="+$rubro+"&monto="+$monto+"&cantidad="+$cantidad+"&idlugar="+$idlugar,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
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
