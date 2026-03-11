<?php
// Pantalla de ingreso de los clientes
$hoy = date("Y-m-d");

if(isset($_GET["id"])){
    $mensaje = "modificar un cliente en el sistema";
    $enlaces = "Modificar";
    $client = ComercialData::getById($_GET["id"]);

    $client_id = $_GET["id"];
}else{
    $mensaje = "crear un nuevo cliente en el sistema";
    $enlaces = "Crear"; $error = "";

 	// Ingreso de clientes
	if(count($_POST)>0){
		if($_POST["client_id"] == 0){
		  	$error = '';
			$user = ComercialData::getByName($_POST["nombre"]);
			if(is_object($user)){
				if(intval($user->iduser) > 0){
				  	$error = 'El nombre de la empresa ya exite, verifique para continuar...!!!';
				  	$client_id = 0;
				}else{
					$error = 'El nombre de la empresa ya exite, modifique los datos para continuar...!!!';
					$client_id = $user->id;

					$client = (object) [
						"tipo" => $user->tipo,
						"ruc" => $user->ruc,
						"residencial" => $user->residencial,
						"nombre" => $user->nombre,
						"contacto" => $user->contacto,
						"cargo" => $user->cargo,
						"email" => $user->email,
						"telefono1" => $user->telefono1,
						"telefono2" => $user->telefono2,
						"factura" => $user->factura,
						"telefonofac1" => $user->telefonofac1,
						"telefonofac2" => $user->telefonofac2,
						"direccion" => $user->direccion,
						"observacion" => $user->observacion,
						"is_active" => "1"
					];
				}
			}
		}

		if($error == ""){
		    $user = new ComercialData();
			$user->idcompany = $_SESSION['id_company'];
			$user->tipo = $_POST["tipo"];
			$user->residencial = 0;
			$user->ruc = $_POST["ruc"];
			$user->empresa = strtoupper($_POST["empresa"]);
			$user->nombre = strtoupper($_POST["nombre"]);
			$user->contacto = strtoupper($_POST["contacto"]);
			$user->email = $_POST["email"];
			$user->telefono1 = $_POST["telefono1"];
			$user->telefonofac1 = $_POST["telefonofac1"];
			$user->telefono2 = $_POST["telefono2"];
			$user->telefonofac2 = $_POST["telefonofac2"];
			$user->monto = 0;
			$user->is_active = 1;

			if($_POST["client_id"] == 0){
				$user->add();
			}else{
				$user->id = $_POST["client_id"];
				$user->update();
			}

			Core::redir("ventas");
        }else{
			Core::alert("Error...!!!!", $error, "error");

			if($client_id == 0){
				$client_id = $_POST["client_id"];

				$client = (object) [
					"tipo" => $_POST["tipo"],
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
					"direccion" => $_POST["direccion"],
					"observacion" => $_POST["observacion"],
					"is_active" => $activo
				];
			}
		}
	}else{
        $client_id = 0;

        $client = (object) [
            "tipo" => 0,
            "ruc" => "",
            "residencial" => "",
            "empresa" => "",
            "nombre" => "",
            "contacto" => "",
            "cargo" => "",
            "email" => "",
            "telefono1" => "",
            "telefono2" => "",
            "factura" => "",
            "telefonofac1" => "",
            "telefonofac2" => "",
            "direccion" => "",
            "observacion" => "",
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
		<li><a href="<?php echo $_SESSION['url']; ?>ventas"><i class="fa fa-database"></i> Clientes </a></li>
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
	<form class="form-horizontal" method="post" id="addCliente" action="<?php echo $_SESSION['url']; ?>venta" role="form">
		<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">		
		<input type="hidden" id="modifica" name="modifica" value="<?php echo $modifica; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del cliente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="ruc" class="col-md-2 control-label"> RUC:</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="ruc" name="ruc" minlength="13" maxlength="13" data-inputmask='"mask": "9999999999999"' data-mask placeholder="1234567890123" value="<?php echo $client->ruc; ?>" pattern="[0-9]{13}" title="Solo números, debe ser un RUC de empresa minimo 13" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-md-2 col-sm-2 control-label"> Nombre Comercial:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->nombre; ?>" minlength="3" maxlength="80" title="Tamaño mínimo: 3. Tamaño máximo: 80" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-md-2 col-sm-2 control-label"> Nombre Empresa:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="empresa" name="empresa" type="text" placeholder="Empresa XYZ s.a." value="<?php echo $client->empresa; ?>" minlength="5" maxlength="80" title="Tamaño mínimo: 5. Tamaño máximo: 80">
					</div>
					<label for="tipo" class="col-md-2 col-sm-2 control-label">Tipo de empresa:</label>
					<div class="col-md-4 col-sm-4">
						<select id="tipo" name="tipo" class="form-control" required>
                  			<option value="0" <?php echo $client->tipo == 0 ? "selected" : ""; ?>> -- SELECCIONE -- </option>
                      		<option value="1" <?php echo $client->tipo == 1 ? "selected" : ""; ?>>Urbanizacion</option>
                      		<option value="2" <?php echo $client->tipo == 2 ? "selected" : ""; ?>>Industria</option>
                      		<option value="3" <?php echo $client->tipo == 3 ? "selected" : ""; ?>>Centro Comercial</option>
                      		<option value="4" <?php echo $client->tipo == 4 ? "selected" : ""; ?>>Automotriz</option>
                      		<option value="5" <?php echo $client->tipo == 5 ? "selected" : ""; ?>>Bancaria</option>
                      		<option value="6" <?php echo $client->tipo == 6 ? "selected" : ""; ?>>Alimenticio</option>
                      		<option value="7" <?php echo $client->tipo == 7 ? "selected" : ""; ?>>Bananero</option>
                      		<option value="8" <?php echo $client->tipo == 8 ? "selected" : ""; ?>>Camaronero</option>
                      		<option value="9" <?php echo $client->tipo == 9 ? "selected" : ""; ?>>Hotelero</option>
                      		<option value="10" <?php echo $client->tipo == 10 ? "selected" : ""; ?>>Edificio</option>
                      		<option value="11" <?php echo $client->tipo == 11 ? "selected" : ""; ?>>Hospitalario</option>
                      		<option value="12" <?php echo $client->tipo == 12 ? "selected" : ""; ?>>Clinica</option>
                      		<option value="13" <?php echo $client->tipo == 13 ? "selected" : ""; ?>>Educacion</option>
                      		<option value="14" <?php echo $client->tipo == 14 ? "selected" : ""; ?>>Administradora</option>
                      		<option value="15" <?php echo $client->tipo == 15 ? "selected" : ""; ?>>Gastronomico</option>
                      		<option value="16" <?php echo $client->tipo == 16 ? "selected" : ""; ?>>Sector Publico</option>
                      		<option value="17" <?php echo $client->tipo == 17 ? "selected" : ""; ?>>Otros</option>
                  		</select>
					</div>
				</div>
				<div class="form-group">
					<label for="contacto" class="col-md-2 col-sm-2 control-label"> Contacto Operativo:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="contacto" maxlength="50" name="contacto" type="text" placeholder="Nombres y Apellidos del contacto" value="<?php echo $client->contacto; ?>" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 50">
					</div>
					<label for="email" class="col-md-2 col-sm-2 control-label">Correo Operativo:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="email" minlength="5" maxlength="50" name="email" type="email" placeholder="Correo de la persona a facturar" value="<?php echo $client->email; ?>" required>
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
			</div>
			<div class="panel-footer"><?php
				if($client_id > 0) { ?>
					<a href="<?php echo $_SESSION['url']; ?>ventas" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Regresar </a><?php
				}else{ ?>
				    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>  <?php 
				} ?>				
			</div>
		</div>
	</form>
</section>
<script type='text/javascript'><!--
    document.title = "Near Solution | Ingreso de Clientes";
    
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
					url: "ajax/comercial.php?cliente="+$cliente+"&rubro="+$rubro+"&monto="+$monto+"&cantidad="+$cantidad,
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
