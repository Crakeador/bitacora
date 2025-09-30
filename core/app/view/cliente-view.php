<?php
// Pantalla de ingreso de los clientes

if(isset($_GET["id"])){
    $mensaje = "modificar un cliente en el sistema";
    $enlaces = "Modificar";
    $client = ClientData::getById($_GET["id"]);
    $client_id = $_GET["id"];
}else{
    $mensaje = "crear un nuevo cliente en el sistema";
    $enlaces = "Crear"; $error = "";

 	// Ingreso de clientes
	if(count($_POST)>0){
  		$fechafac = date("Y-m-d", strtotime($_POST["fechafac"]));
  		$fechaini = date("Y-m-d", strtotime($_POST["fechaini"]));
  		$fechafin = date("Y-m-d", strtotime($_POST["fechafin"]));
		
		if(isset($_POST["is_active"])) $activo=1; else $activo=0;
		if(isset($_POST["etapas"])) $etapas=1; else $etapas=0;
		if(isset($_POST["hadicional"])) $hadicional=1; else $hadicional=0;
		if(isset($_POST["hnocturna"])) $hnocturna=1; else $hnocturna=0;


			$var = str_replace('_', '', $_POST["monto"]);
			$var = str_replace('.', '', $var);
			$var = str_replace(',', '.', $var);

        echo 'Monto: '.$_POST["monto"].' Variable: '.$var;
		if($_POST["client_id"] == 0){
			if(is_object(ClientData::getByRuc($_POST["ruc"]))){
			  $error = 'El RUC ya exite...!!!';
			}
		}

		if($error == ""){
		    $user = new ClientData();
			$user->idcompany = $_SESSION['id_company'];
			$user->tipo_empresa = $_POST["tipo_empresa"];
			$user->ruc = $_POST["ruc"];
			$user->nombre = strtoupper($_POST["nombre"]);
			$user->contacto = strtoupper($_POST["contacto"]);
			$user->cargo = strtoupper($_POST["cargo"]);
			$user->factura = strtoupper($_POST["factura"]);
			$user->email = $_POST["email"];
			$user->telefono1 = $_POST["telefono1"];
			$user->telefonofac1 = $_POST["telefonofac1"];
			$user->telefono2 = $_POST["telefono2"];
			$user->telefonofac2 = $_POST["telefonofac2"];
			$user->fechafac = $fechafac;
			$user->fechaini = $fechaini;
			$user->fechafin = $fechafin;

			$user->ini_fac = $_POST["ini_fac"];
			$user->fin_fac = $_POST["fin_fac"];
			  
			$user->direccion = $_POST["direccion"];
			$user->observacion = $_POST["observacion"];
			$user->monto = $_POST["monto"];
			$user->etapas = $etapas;
			$user->hadicional = $hadicional;
			$user->hnocturna = $hnocturna;
			$user->is_active = $activo;

			if($_POST["client_id"] == 0){
				$user->add();
			}else{
				$user->id = $_POST["client_id"];
				$user->update();
			}
			Core::redir("clientes");
        }else{
			Core::alert("Error...!!!!", $error, "error");
        }

        $client_id = $_POST["client_id"];

        $client = (object) [
            "tipo_empresa" => $_POST["tipo_empresa"],
            "ruc" => $_POST["ruc"],
            "nombre" => $_POST["nombre"],
            "contacto" => $_POST["contacto"],
            "cargo" => $_POST["cargo"],
            "email" => $_POST["email"],
            "telefono1" => $_POST["telefono1"],
            "telefono2" => $_POST["telefono2"],
            "factura" => $_POST["factura"],
            "telefonofac1" => $_POST["telefonofac1"],
            "telefonofac2" => $_POST["telefonofac2"],
            "fechafac" => $fechafac,
            "fechaini" => $fechaini,
            "fechafin" => $fechafin,
            "ini_fac" => $_POST["ini_fac"],
            "fin_fac" => $_POST["fin_fac"],
            "direccion" => $_POST["direccion"],
            "observacion" => $_POST["observacion"],
            "etapas" => $etapas,
            "hadicional" => $hadicional,
            "hnocturna" => $hnocturna,
            "is_active" => $activo
        ];
	}else{
        $client_id = 0;

        $client = (object) [
            "tipo_empresa" => "Privado",
            "ruc" => "",
            "nombre" => "",
            "contacto" => "",
            "cargo" => "",
            "email" => "",
            "telefono1" => "",
            "telefono2" => "",
            "factura" => "",
            "telefonofac1" => "",
            "telefonofac2" => "",
            "fechafac" => date("Y-m-d"),
            "fechaini" => date("Y-m-d"),
            "fechafin" => date("Y-m-d"),
            "ini_fac" => 0,
            "fin_fac" => 0,
            "direccion" => "",
            "observacion" => "",
            "monto" => 0,
            "etapas" => "0",
            "hadicional" => "0",
            "hnocturna" => "0",
            "is_active" => "1"
        ];
    }
}

?>
<section class="content-header">
	<h1>
		Clientes
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./clientes"><i class="fa fa-database"></i> Clientes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="container-fluid">
		<div class="alert alert-danger" style="<?php if(isset($_GET["error"]) == 1) echo ''; else echo 'display:none;'; ?>">
		  <strong>hoops!</strong> Hay un problema con sus datos.<br><br>
		  <ul>
			<li> Ya hay una empresa registrada con este RUC, verifique para continuar.</li>
		  </ul>
		</div>
		<div class="row">
			<input type="hidden" id="ndetalles" value="2">
			<!-- Dialogo para seleccionar una cuenta -->
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
				<!-- START panel -->
				<form class="form-horizontal" method="post" id="addtask" action="index.php?view=cliente" role="form">
					<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
        						<label for="ruc" class="col-lg-2 control-label"><span class="text-danger">*</span> RUC:</label>
        						<div class="col-md-2">
        							<input type="text" class="form-control" id="ruc" name="ruc" minlength="13" maxlength="13" data-inputmask='"mask": "9999999999999"' data-mask placeholder="1234567890123" value="<?php echo $client->ruc; ?>" pattern="[0-9]{13}" title="Solo números, debe ser un RUC de empresa minimo 13" required autofocus>
        						</div>
                                <div class="col-md-2 col-sm-4">
                                    <span class="text-danger">La empresa es:</span>
                                    <div class="radiobutton">
                                        <input type="radio" id="tipo_empresa" name="tipo_empresa" value="Publico" <?php if($client->tipo_empresa == "Publico") echo 'checked="checked"'; ?>> P&uacute;blica &nbsp;&nbsp;
                                        <input type="radio" id="tipo_empresa" name="tipo_empresa" value="Privado" <?php if($client->tipo_empresa == "Privado") echo 'checked="checked"'; ?>> Privada
                                    </div>
                                </div>                                				
        						<label for="monto" class="col-md-2 col-sm-2 control-label">Monto del contrato:</label>
        						<div class="col-md-4 col-sm-4">
                                    <div class="input-group date form_date col-md-4 col-sm-6">
        								<input style="text-align:right" type="text" class="form-control" id="monto" name="monto" value="<?php echo $client->monto; ?>" required="required" minlength="10" data-inputmask='"mask": "#####0.00"' data-mask placeholder="#####0.00" title="Debe de ser mayor a cero">
                                    </div>
        						</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-4 col-sm-4">
									<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->nombre; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required>
								</div>								
								<label class="col-md-2 col-sm-2 control-label">Fecha de Facturaci&oacute;n:</label>
								<div class="col-md-4 col-sm-4">
                                    <div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
										<input type="date" class="form-control" id="fechafac" name="fechafac" value="<?php echo $client->fechafac; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
										<span class="validity"></span>
                                    </div>
								</div>
							</div>
							<div class="form-group">
								<label for="contacto" class="col-md-2 col-sm-2 control-label">Contacto:</label>
								<div class="col-md-4 col-sm-4">
									<input class="text-field form-control input-sm" id="contacto" maxlength="50" name="contacto" type="text" placeholder="Nombres y Apellidos del contacto" value="<?php echo $client->contacto; ?>" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 50" required>
								</div>
								<label class="col-md-2 col-sm-2 control-label">Persona a Facturar:</label>
							    <div class="col-md-4 col-sm-4">
								  	<input class="text-field form-control input-sm" id="factura" maxlength="40" name="factura" type="text" placeholder="Nombres y Apellidos de la persona a facturar" value="<?php echo $client->factura; ?>">
							  	</div>
							</div>
							<div class="form-group">
								<label for="telefono1" class="col-md-2 col-sm-2 control-label">Tel&eacute;fono:</label>
								<div class="col-md-2 col-sm-4">
									<input type="text" class="form-control" id="telefono1" name="telefono1" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono1; ?>">
								</div>
								<label class="col-md-4 col-sm-2 control-label">Tel&eacute;fono:</label>
								<div class="col-md-2 col-sm-4">
									<input type="text" class="form-control" id="telefonofac1" name="telefonofac1" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefonofac1; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="telefono2" class="col-md-2 col-sm-2 control-label">Tel&eacute;fono:</label>
								<div class="col-md-2 col-sm-4">
									<input type="text" class="form-control" id="telefono2" name="telefono2" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono2; ?>">
								</div>
								<label class="col-md-4 col-sm-2 control-label">Tel&eacute;fono:</label>
								<div class="col-md-2 col-sm-4">
									<input type="text" class="form-control" id="telefonofac2" name="telefonofac2" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefonofac2; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="cargo" class="col-md-2 col-sm-2 control-label">Cargo:</label>
								<div class="col-md-4 col-sm-4">
									<input class="text-field form-control input-sm" id="cargo" maxlength="50" name="cargo" type="text" placeholder="Gerente General" value="<?php echo $client->cargo; ?>">
								</div>
								<label for="email" class="col-md-2 col-sm-2 control-label">Correo Electronico:</label>
							    <div class="col-md-4 col-sm-4">
								  	<input class="text-field form-control input-sm" id="email" minlength="5" maxlength="50" name="email" type="email" placeholder="Correo de la persona a facturar" value="<?php echo $client->email; ?>">
							  	</div>
							</div>
							<div class="form-group">
								<label for="fechaini" class="col-md-2 col-sm-2 control-label">Fecha de activaci&oacute;n:</label>
								<div class="col-md-4 col-sm-4">
                                    <div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
										<input type="date" class="form-control" id="fechaini" name="fechaini" value="<?php echo $client->fechaini; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
                                    </div>
								</div>
								<label for="ini_fac" class="col-md-2 col-sm-2 control-label">Inicio de nomina:</label>
								<div class="col-md-4 col-sm-4">
                                    <div class="input-group col-md-2 col-sm-6">
										<input type="number" class="form-control" id="ini_fac" name="ini_fac" maxlength="2" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $client->ini_fac; ?>">
										<span class="validity"></span>
                                    </div>									
								</div>
							</div>							
							<div class="form-group">
								<label for="fechafin" class="col-md-2 col-sm-2 control-label">Fecha para desactivar:</label>
								<div class="col-md-4 col-sm-4">
                                    <div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
										<input type="date" class="form-control" id="fechafin" name="fechafin" value="<?php echo $client->fechafin; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
                                    </div>
								</div>
								<label for="fin_fac" class="col-md-2 col-sm-2 control-label">Fin de la nomina:</label>
								<div class="col-md-4 col-sm-4">
                                    <div class="input-group col-md-2 col-sm-6">
										<input type="number" class="form-control" id="fin_fac" name="fin_fac" maxlength="2" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $client->fin_fac; ?>">
										<span class="validity"></span>
                                    </div>									
								</div>
							</div>
							<div class="form-group">
								<label for="direccion" class="col-md-2 col-sm-3 control-label">Direcci&oacute;n del cliente:</label>
								<div class="col-md-4">
									<textarea class="form-control input-sm" cols="50%" id="direccion" name="direccion" rows="3"><?php echo $client->direccion; ?></textarea>
								</div>
								<label for="observacion" class="col-md-2 col-sm-2 control-label">Observaciones:</label>
								<div class="col-md-4">
									<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="3"><?php echo $client->observacion; ?></textarea>
								</div>
							</div>							
            				<input id="is_active" name="is_active" type="checkbox" <?php if($client->is_active == 1) echo "checked"; ?>>
            				<label for="is_active">&nbsp;Empresa activa </label>&nbsp;&nbsp;			
            				<input id="etapas" name="etapas" type="checkbox" <?php if($client->etapas == 1) echo "checked"; ?>>
            				<label for="etapas">&nbsp;Empresa con Etapas </label>&nbsp;&nbsp;			
            				<input id="hadicional" name="hadicional" type="checkbox" <?php if($client->hadicional == 1) echo "checked"; ?>>
            				<label for="hadicional">&nbsp;Horas suplementarias </label>&nbsp;&nbsp;			
            				<input id="hnocturna" name="hnocturna" type="checkbox" <?php if($client->hnocturna == 1) echo "checked"; ?>>
            				<label for="hnocturna">&nbsp;Horas nocturnas </label>
                            <!-- Listado de contratos -->
                            </br></br>
                            <button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Agregar/Modificar
                            </button></br></br>
                            <div id="contratos" class="tab-pane active">
                      			<div class="panel panel-default">
                      			    <div class="panel-heading">
                      			        <h3 class="panel-title">Historial de contratos</h3>
                      			    </div>
                      			    <div class="table-responsive panel-collapse pull out">            
                  					    <table id="tusuarios" class="table table-hover table-bordered table-striped" style="background-color:white;">            
                      						<thead>            
                      							<tr>            
                      								<th width="70px;"></th>            
                      								<th><b>Autorización</b></th>            
                      								<th><b>Tipo Comp.</b></th>            
                      								<th><b>Sec. Inicio</b></th>            
                      								<th><b>Sec. Fin</b></th>            
                      								<th><b>Fecha Inicio</b></th>            
                      								<th><b>Fecha Fin</b></th>            
                      							</tr>            
                      						</thead>            
                      						<tbody>            
                  								<tr>            
                  										<td>            
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/138738/"><i class="glyphicon glyphicon-eye-open"></i></a>
    
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120892512')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/138738/"><i class="glyphicon glyphicon-pencil"></i></a>
    
                  										</td>
    
                  										<td>1120892512</td>
    
                  										<td>Retención</td>
    
                  										<td>351</td>
    
                  										<td>450</td>
    
                  										<td>12/06/2017</td>
    
                  										<td>12/06/2018</td>
    
                  								</tr>            
                  								<tr>
    
                  										<td>
    
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137529/"><i class="glyphicon glyphicon-eye-open"></i></a>
    
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120677683')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137529/"><i class="glyphicon glyphicon-pencil"></i></a>
    
                  										</td>
    
                  										<td>1120677683</td>
    
                  										<td>Retención</td>
    
                  										<td>000000301</td>
    
                  										<td>000000351</td>
    
                  										<td>04/05/2017</td>
    
                  										<td>04/05/2018</td>
    
                  								</tr>            
                  								<tr>
    
                  										<td>
    
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137731/"><i class="glyphicon glyphicon-eye-open"></i></a>
    
                  											<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, '1120677683')" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137731/"><i class="glyphicon glyphicon-pencil"></i></a>
    
                  										</td>
    
                  										<td>1120677683</td>
    
                  										<td>Venta</td>
    
                  										<td>201</td>
    
                  										<td>300</td>
    
                  										<td>04/05/2017</td>
    
                  										<td>04/05/2018</td>
    
                  								</tr>            
                      						</tbody>            
                      					  </table>            
                      			    </div>
                      			</div>
                      		</div> 
                      		<!-- Fin de Listado -->
            				<!-- pop up fechas Ingreso y Salida del empleado -->
            				<div id="dlg_fechas_empresa" class="modal fade">
            					  <div class="modal-dialog">            
            						  <div class="modal-content">            
            							  <div class="panel-default">            
            								  <!-- panel heading/header -->            
            								  <div class="panel-heading panel-heading-contifico">            
            									  <h3 class="panel-title">Fechas de Ingreso y Salida Empresa</h3>            
            										  <div class="panel-toolbar text-right">            
            										  <!-- option -->            
            										  <div class="option">            
            											  <button type="button" class="close" data-dismiss="modal">×</button>            
            										  </div>            
            										  <!--/ option -->            
            									  </div>            
            								  </div>            
            								  <!--/ panel heading/header -->            
            								  <!-- panel body -->            
            								  <div class="panel-body">            
            									  <div id="msj_error_fechas_empresa" class="alert alert-danger hide">            
            										  <p> La Fecha de Entrada no puede ser mayor a la fecha de Salida.</p>            
            									  </div>            
            									  <table id="table_detalle_entradasalida_empresa" class="table table-bordered table-hover table-striped table-condensed">            
            										  <thead>            
            											  <tr>            
            												  <th class="text-center"></th>            
            												  <th class="text-center">Entrada</th>            
            												  <th class="text-center">Salida</th>            
            												  <th colspan="2" class="text-center col-md-2">Acta de Finiquito</th>            
            												  <th class="text-center">Liquidación</th>
            
            											  </tr>
            
            										  </thead>
            
            										  <tbody id="tdetalle_entradasalida_empresa">
            
            											  <tr>
            
            												  <td style="width:2%">
            
            													  <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" rel="tooltip" href="javascript:;" onclick="fechas_entrada_salida_empresa.eliminarDetalle(this); return false;" class="btn btn-danger btn-xs"><i class="fa fa-users text-aqua"></i></a>
            
            												  </td>
            
            												  <td class="id_entradasalida_empresa" style="display: none;"></td>
            
            												  <td style="width:10%">
            
            													  <input id="id_entradasalidaempresa_1-id" name="entradasalidaempresa_1-id" type="hidden" value="84864">
            
            													  <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaempresa_1-fecha_entrada" name="entradasalidaempresa_1-fecha_entrada" type="text" value="01/01/2017">
            
            												  </td>
            
            												  <td style="width:10%">
            
            													  <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaempresa_1-fecha_salida" name="entradasalidaempresa_1-fecha_salida" type="text">
            
            													  <input id="id_entradasalidaempresa_1-tipo" maxlength="2" name="entradasalidaempresa_1-tipo" type="hidden" value="E">
            
            												  </td>
            
            												  <td style="width:20%; border-right:solid 1px #F5F5F5;">
            
            													  <div class="fileinput-new input-group" data-provides="fileinput">
            
            														  <div class="form-control input-sm" data-trigger="fileinput">
            
            															  <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename ancho_input_file" style="width"></span>
            
            														  </div>
            
            														  <span class="input-group-addon btn btn-default btn-file input-sm">
            
            														  <span class="glyphicon glyphicon-open"> </span>
            
            															  <input class="filestyle form-control input-sm" id="id_entradasalidaempresa_1-archivo_acta_finiquito" name="entradasalidaempresa_1-archivo_acta_finiquito" type="file">
            
            														  </span>
            
            														  <a href="https://presentacion.contifico.com/sistema/persona/1760171/#" class="input-group-addon btn btn-default fileinput-exists" style="color:black !important" data-dismiss="fileinput">
            
            															  <span class="glyphicon glyphicon-trash"> </span>
            
            														  </a>
            
            													  </div>
            
            												  </td>
            
            												  <td style="width:2%; border-left:solid 1px #F5F5F5;">
            
            												  </td>
            
            												  <td class="text-center" style="width:5%">
            
            													Pendiente
            
            												  </td>
            
            											  </tr>
            
            										  </tbody>
            
            										  <tfoot>
            
            											  <tr>
            
            												  <td colspan="6">
            
            													  <button id="agregar_fechas_empresa" class="btn btn-primary btn-sm">
            
            													  <span class="ico-plus-circle2"></span>
            
            													  Agregar Fecha
            
            													  </button>
            
            												  </td>
            
            											  </tr>
            
            										  </tfoot>
            
            									  </table>
            
            								  </div>
            
            								  <!--/ panel body -->
            
            							  </div>
            
            							  <div class="modal-footer">
            
            								  <button type="button" class="btn btn-success">
            
            									  <span class="glyphicon glyphicon-ok"> </span> Aceptar
            
            								  </button>
            
            							  </div>
            
            						  </div><!-- /.modal-content -->
            
            					  </div><!-- /.modal-dialog -->
        				    </div>
        				    <!--/ END modal -->
						</div>
					</div>
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button></br>
				</form>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-red',
	    radioClass: 'iradio_flat-red'
	  });
	});
</script>

