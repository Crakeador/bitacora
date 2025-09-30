<?php
// Pantalla de ingreso de los clientes
$hoy = date("Y-m-d");

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
		if($_POST["client_id"] == 0){
			if(is_object(ClientData::getByRuc($_POST["ruc"]))){
			  $error = 'El RUC ya exite...!!!';
			}
		}

		if($error == ""){
		    $user = new ClientData();
			$user->idcompany = $_SESSION['id_company'];
			$user->tipo_empresa = 2;
			$user->residencial = 0;
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

			$user->ini_fac = $hoy;
			$user->fin_fac = $hoy;
			  
			$user->direccion = $_POST["direccion"];
			$user->observacion = $_POST["observacion"];
			$user->monto = 0;
			$user->etapas = 0;
			$user->hadicional = 0;
			$user->hnocturna = 0;
			$user->is_active = 1;

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
            "residencial" => $_POST["residencial"],
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
            "residencial" => "",
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
		<li><a href="<?php echo $_SESSION['url']; ?>clientes"><i class="fa fa-database"></i> Clientes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
	<div class="alert alert-danger" style="<?php if(isset($_GET["error"]) == 1) echo ''; else echo 'display:none;'; ?>">
	  <strong>hoops!</strong> Hay un problema con sus datos.<br><br>
	  <ul>
		<li> Ya hay una empresa registrada con este RUC, verifique para continuar.</li>
	  </ul>
	</div>
	<input type="hidden" id="ndetalles" value="2">
	<!-- Dialogo para seleccionar una cuenta -->
	<p class="alert alert-info">
		<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
		- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
	</p>
	<!-- START panel -->
	<form class="form-horizontal" method="post" id="addCliente" action="<?php echo $_SESSION['url']; ?>cliente" role="form">
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del cliente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="ruc" class="col-md-2 control-label"><span class="text-danger">*</span> RUC:</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="ruc" name="ruc" minlength="13" maxlength="13" data-inputmask='"mask": "9999999999999"' data-mask placeholder="1234567890123" value="<?php echo $client->ruc; ?>" pattern="[0-9]{13}" title="Solo números, debe ser un RUC de empresa minimo 13" required autofocus>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nombre Comercial:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->nombre; ?>" minlength="5" maxlength="80" required title="Tamaño mínimo: 5. Tamaño máximo: 80" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nombre Empresa:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="empresa" name="empresa" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->empresa; ?>" minlength="5" maxlength="80" required title="Tamaño mínimo: 5. Tamaño máximo: 80" required>
					</div>
				</div>
				<div class="form-group">
					<label for="contacto" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Contacto Jefe Operativo:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="contacto" maxlength="50" name="contacto" type="text" placeholder="Nombres y Apellidos del contacto" value="<?php echo $client->contacto; ?>" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 50" required>
					</div>
					<label for="email" class="col-md-2 col-sm-2 control-label">Correo del Jefe:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="email" minlength="5" maxlength="50" name="email" type="email" placeholder="Correo de la persona a facturar" value="<?php echo $client->email; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="telefono1" class="col-md-2 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="form-control" id="telefono1" name="telefono1" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono1; ?>">
					</div>
					<label for="telefonofac1" class="col-md-4 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="form-control" id="telefonofac1" name="telefonofac1" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefonofac1; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="telefono2" class="col-md-2 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="form-control" id="telefono2" name="telefono2" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefono2; ?>">
					</div>
					<label for="telefonofac2" class="col-md-4 col-sm-2 control-label">Tel&eacute;fono:</label>
					<div class="col-md-2 col-sm-4">
						<input type="text" class="form-control" id="telefonofac2" name="telefonofac2" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->telefonofac2; ?>">
					</div>
				</div>
				<?php
				// Listado de contratos
				if($client_id > 0) { ?>
    				</br>
    				<button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
    					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Agregar
    				</button></br></br>	<?php
				}
				$users = ClientData::getDetalle($client_id);		
				$resultado = count($users); 
				
				if($resultado > 0){ ?>
    				<div id="contratos" class="tab-pane active">
    					<div class="panel panel-default">
    						<div class="panel-heading">
    							<h3 class="panel-title">Historial de Contactos</h3>
    						</div>
    						<div class="table-responsive panel-collapse pull out">     
    							<!--- Datos de Liquidacion --->
    							<table id="viewBitacora" class="table table-bordered table-hover">
    								<thead>
    									<tr>
    										<!-- th width="70px;"></th --> 
    										<th><b>Contacto Operativo</b></th>            
    										<th><b>Telefono Operativo</b></th>            
    										<th><b>Correo Operativo</b></th>   
    									</tr>
    								</thead>
    								<tbody>
    									<?php
											foreach($users as $tables) {
												echo '<tr>';
													/* echo '<td> 
                											<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="#"><i class="glyphicon glyphicon-eye-open"></i></a>
                											<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" href="#"><i class="glyphicon glyphicon-pencil"></i></a>
                										  </td>'; */
													echo '<td>'.$tables->nombre.'</td>';
													echo '<td>'.$tables->telefono.'</td>';
													echo '<td>'.$tables->correo.'</td>';
												echo '</tr>';
											}
    									?>
    								</tbody>
    							</table>
    						</div>
    					</div>
    				</div><?php
    			} ?>
	            <!-- pop up de los contactos de las ventas -->
        		<div id="dlg_fechas_empresa" class="modal">
        			<div class="modal-dialog">
        				<div class="modal-content">
        					<div class="box-header with-border">
        						<h3 class="box-title">Datos del Contacto Operativo</h3>
        						<div class="box-tools pull-right">
        							<button type="button" class="close" data-dismiss="modal">×</button>
        						</div><!-- /.box-tools -->
        					</div><!-- /.box-header -->
        					<div class="box-body" style="display: block;">
        						<div class="form-group">
        							<label for="rubro" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
        							<div class="col-md-8 col-sm-5">
        							    <input type="text" class="form-control" id="rubro" name="rubro" value="" placeholder="Descripcion Operativo">
        							</div>
        						</div>														
        						<div class="form-group">
        							<label for="cantidad" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Telefono:</label>
        							<div class="col-md-4 col-sm-2">
        							    <input type="number" class="form-control" id="cantidad" name="cantidad" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="">
        							</div>
        						</div>
        						<div class="form-group">
        							<label for="monto" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Correo:</label>
        							<div class="col-md-8 col-sm-5">
        							    <input class="text-field form-control input-sm" id="monto" minlength="5" maxlength="50" name="monto" type="email" placeholder="Correo de la persona a facturar" value="">
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
			<div class="panel-footer">
			    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>  
			</div>
		</div>
	</form>
</section>
<script type='text/javascript'><!--
    document.title = "Near Solutions | Ingreso de Clientes";
    
    $(function(){
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
            $cliente = $('#client_id').val();
			$rubro = $('#rubro').val();
			$cantidad = $('#cantidad').val();
			$monto = $('#monto').val();
			
			console.log("cliente="+$cliente+"&rubro="+$rubro+"&monto="+$monto+"&cantidad="+$cantidad);
			if($cliente == 0 || $cantidad == '' || $rubro == '' || $monto == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/cliente.php?cliente="+$cliente+"&rubro="+$rubro+"&monto="+$monto+"&cantidad="+$cantidad,
					success: function(data) {
					    sweetAlert('aaaaa', data, 'error');
						/* Cargamos finalmente el contenido deseado */
						/* window.location="venta/"+$cliente; */
					}
				});
			} 

            return false;
        }) 
    });
</script>
