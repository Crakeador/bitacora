<?php
// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $mensaje = "entrega de vehiculo";
		$enlaces = "Modificar";
		
		$oficio = "";
		
		$client = (object) [
			"paquete" => 0,
			"nombre" => "",
			"idcarro" => 0,
			"usuario" => 0,
			"telefono" => "",
			"fecha" => date("Y-m-d"),
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
		
		$user->vehiculo = $_POST["idcarro"];
		$user->nombre = strtoupper($_POST['nombre']);
		$user->cedula = $_POST["cedula"];
		$user->kilometraje = $_POST["telefono"];
		$user->fecha = $_POST["ini_fec"];
		
		//Revision Vehicular
        $user->id = $_POST["entrega_id"];
        $user->llantas = $_POST["llantas"];
        $user->ollantas = $_POST["ollantas"];
        $user->rayones = $_POST["rayones"];
        $user->orayones = $_POST["orayones"];
        $user->espejos = $_POST["espejos"];
        $user->oespejos = $_POST["oespejos"];
        $user->puertas1 = $_POST["puertas1"];
        $user->opuertas1 = $_POST["opuertas1"];
        $user->capo = $_POST["capo"];
        $user->ocapo = $_POST["ocapo"];
        $user->balde = $_POST["balde"];
        $user->obalde = $_POST["obalde"];
        $user->guias1 = $_POST["guias1"];
        $user->oguias1 = $_POST["oguias1"];
        $user->guias2 = $_POST["guias2"];
        $user->oguias2 = $_POST["oguias2"];
        $user->luces = $_POST["luces"];
        $user->oluces = $_POST["oluces"];
        $user->motor = $_POST["motor"];
        $user->anomalia = $_POST["anomalia"];
        $user->asientos = $_POST["asientos"];
        $user->oasientos = $_POST["oasientos"];
        $user->panel = $_POST["panel"];
        $user->opanel = $_POST["opanel"];
        $user->cinturon = $_POST["cinturon"];
        $user->ocinturon = $_POST["ocinturon"];
        $user->forros = $_POST["forros"];
        $user->oforros = $_POST["oforros"];
        $user->elevadores = $_POST["elevadores"];
        $user->oelevadores = $_POST["oelevadores"];
        $user->aire = $_POST["aire"];
        $user->oaire = $_POST["oaire"];
        $user->parabrisa = $_POST["parabrisa"];
        $user->oparabrisa = $_POST["oparabrisa"];
        $user->limpia = $_POST["limpia"];
        $user->olimpia = $_POST["olimpia"];
        $user->emergencia = $_POST["emergencia"];
        $user->oemergencia = $_POST["oemergencia"];
        $user->extintor = $_POST["extintor"];
        $user->oextintor = $_POST["oextintor"];
        $user->techo = $_POST["techo"];
        $user->otecho = $_POST["otecho"];
        $user->puertas2 = $_POST["puertas2"];
        $user->opuertas2 = $_POST["opuertas2"];
        $user->enciende = $_POST["enciende"];
        $user->oenciende = $_POST["oenciende"];
        $user->aceite = $_POST["aceite"];
        $user->oaceite = $_POST["oaceite"];
        $user->hidraulico = $_POST["hidraulico"];
        $user->ohidraulico = $_POST["ohidraulico"];
        $user->freno = $_POST["freno"];
        $user->ofreno = $_POST["ofreno"];
        $user->refrigerante = $_POST["refrigerante"];
        $user->orefrigerante = $_POST["orefrigerante"];
        
        if($_POST["entrega_id"] == 0){
		    $user->add();
		    
			$valor = $user->getCodigo();
			$_SESSION["entrega_id"] = $valor->id;
		}else{
		    $_SESSION["entrega_id"] = $_POST["entrega_id"];
		    $user->update();
		}
		        
        if($_FILES["foto1"]["name"]==""){
            $errores = 'debe de tomarse una foto para verificar la novedad';
        }else{
            $image = new Upload($_FILES["foto1"]);

            if($image->uploaded){
                $image->Process("storage/novedad/");

                if($image->processed){    
                    $user->idcustodia = $_POST["entrega_id"];
                    $user->entrada = 1;
                    $user->numero = 1;
                    $user->foto = $image->file_dst_name; 

                    $user->addFoto();
                }
            }

            if($_FILES["foto2"]["name"]==""){
                $user->foto2 = "";
            }else{
                $image = new Upload($_FILES["foto2"]);

                if($image->uploaded){
                    $image->Process("storage/novedad/");

                    if($image->processed){    
                        $user->idcustodia = $_POST["entrega_id"];
                        $user->entrada = 1;
                        $user->numero = 2;
                        $user->foto = $image->file_dst_name; 
    
                        $user->addFoto();
                    }
                }
            }

            if($_FILES["foto3"]["name"]==""){
                $user->foto3 = "";
            }else{
                $image = new Upload($_FILES["foto3"]);

                if($image->uploaded){
                    $image->Process("storage/novedad/");

                    if($image->processed){    
                        $user->idcustodia = $_POST["entrega_id"];
                        $user->entrada = 1;
                        $user->numero = 3;
                        $user->foto = $image->file_dst_name; 
    
                        $user->addFoto();
                    }
                }
            }

            if($_FILES["foto4"]["name"]==""){
                $user->foto4 = "";
            }else{
                $image = new Upload($_FILES["foto4"]);

                if($image->uploaded){
                    $image->Process("storage/novedad/");

                    if($image->processed){    
                        $user->idcustodia = $_POST["entrega_id"];
                        $user->entrada = 1;
                        $user->numero = 4;
                        $user->foto = $image->file_dst_name; 
    
                        $user->addFoto();
                    }
                }
            }

            if($_FILES["foto5"]["name"]==""){
                $user->foto5 = "";
            }else{
                $image = new Upload($_FILES["foto5"]);

                if($image->uploaded){
                    $image->Process("storage/novedad/");

                    if($image->processed){    
                        $user->idcustodia = $_POST["entrega_id"];
                        $user->entrada = 1;
                        $user->numero = 5;
                        $user->foto = $image->file_dst_name; 
    
                        $user->addFoto();
                    }
                }
            }

            if($_FILES["foto6"]["name"]==""){
                $user->foto6 = "";
            }else{
                $image = new Upload($_FILES["foto6"]);

                if($image->uploaded){
                    $image->Process("storage/novedad/");

                    if($image->processed){    
                        $user->idcustodia = $_POST["entrega_id"];
                        $user->entrada = 1;
                        $user->numero = 6;
                        $user->foto = $image->file_dst_name; 
    
                        $user->addFoto();
                    }
                }
            }
        }

        $idruta = $_SESSION["entrega_id"];
		//Core::redir("recibo&id=".$_SESSION["entrega_id"]);
        //break;
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
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="vehiculo" name="vehiculo" action="recibo" role="form">
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
				    <label for="municion" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Entrega:</label>
					<div class="col-md-4 col-sm-4">
						<input type="text" class="form-control" id="entrega" name="entrega" value="<?php echo $_SESSION['usuario']; ?>" pattern="[0-9]{13}" title="Solo números, debe ser el numero la orden" readonly>
					</div>
					<label for="telefono" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Kilometraje:</label>
					<div class="col-md-2 col-sm-2">
						<input type="number" class="form-control" id="telefono" name="telefono" minlength="5" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $client->kilometraje; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Recibe:</label>
					<div class="col-md-4 col-sm-4">
						<input class="text-field form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Joe Doe" value="<?php echo $client->nombre; ?>" minlength="5" maxlength="100" required title="Tamaño mínimo: 5. Tamaño máximo: 100" required autofocus>
					</div>
					<label for="cedula" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Cedula:</label>
					<div class="col-md-2 col-sm-2">
						<input class="form-control" id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" data-mask placeholder="9999999999" value="<?php echo $client->cedula; ?>" required pattern="^[0-9]{10}" title="Solo números. Tamaño obligatorio: 10">
					</div>
				</div>
				<div class="form-group">
					<label for="idcarro" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Vehiculos:</label>
					<div class="col-md-4 col-sm-4">
					    <?php
	                        echo '<select id="idcarro" name="idcarro" class="form-control select2" style="width: 100%;">';
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
							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $client->fecha; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
						</div>
					</div>
				</div>
				<br>
				<div class="panel panel-default" <?php if($idruta == "") echo 'style="display: none"'; ?>>
					<ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_entregas" data-toggle="tab" aria-expanded="false">
                                <b>Chequeo</b>
                            </a>
                        </li>
						<li>
							<a href="#tab_personal" data-toggle="tab" aria-expanded="false">
								<b>Imagenes</b>
							</a>
						</li>
					</ul>
					<div class="panel-body">
						<!-- tabs content -->
						<div class="tab-content panel">
							<div class="tab-pane" id="tab_personal">
							    <button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
									Agregar/Modificar
								</button>									
								</br></br>
								<div class="row">
									<div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"> Ingrese las fotos:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="foto1" id="foto1" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                                <input type="file" name="foto2" id="foto2" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                                <input type="file" name="foto3" id="foto3" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                                <input type="file" name="foto4" id="foto4" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                                <input type="file" name="foto5" id="foto5" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                                <input type="file" name="foto6" id="foto6" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>					
									</div>
								</div> <?php
                                if($person->image == NULL) {
                                    $nombre_fichero1 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero1 = "http://localhost/bitacora/storage/persons/".$person->image;

                                    if (file_exists("storage/persons/".$person->image)) {
                                        $tamano1 = filesize("storage/persons/".$person->image);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }
                                if($person->cedula1 == NULL) {
                                    $nombre_fichero2 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero2 = "http://localhost/bitacora/storage/documento/".$person->cedula1;

                                    if (file_exists("storage/documento/".$person->cedula1)) {
                                        $tamano2 = filesize("storage/documento/".$person->cedula1);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }
                                if($person->cedula2 == NULL) {
                                    $nombre_fichero3 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero3 = "http://localhost/bitacora/storage/documento/".$person->cedula2;

                                    if (file_exists("storage/documento/".$person->cedula2)) {
                                        $tamano3 = filesize("storage/documento/".$person->cedula2);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }
                                if($person->votacion == NULL) {
                                    $nombre_fichero4 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero4 = "http://localhost/bitacora/storage/documento/".$person->votacion;

                                    if (file_exists("storage/documento/".$person->votacion)) {
                                        $tamano4 = filesize("storage/documento/".$person->votacion);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }
                                if($person->firma == NULL) {
                                    $nombre_fichero5 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero5 = "http://localhost/bitacora/storage/documento/".$person->firma;

                                    if (file_exists("storage/documento/".$person->firma)) {
                                        $tamano5 = filesize("storage/documento/".$person->firma);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }
                                if($person->archivo == NULL) {
                                    $nombre_fichero6 = "http://localhost/bitacora/storage/persons/logo-Cipol-color.png"; 
                                }else {
                                    $nombre_fichero6 = "http://localhost/bitacora/storage/documento/".$person->archivo;

                                    if (file_exists("storage/documento/".$person->archivo)) {
                                        $tamano6 = filesize("storage/documento/".$person->archivo);
                                    } else {
                                        echo "El archivo no existe.";
                                    }
                                }  ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-ban"></i> Datos importantes...! </h4>
                                            <ul>
                                            <li>Debe de tomar toda las fotos de manera clara y legible</li>
                                            <li>No puede portar lentes, ni gorra</li>
                                            <li>Debe poner como fondo de las fotos un color blanco</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box box-primary">
                                            <div class="box-body box-profile">
                                                <div align="center">
                                                    <img class="profile-user-img img-responsive img-circle" style="width:80%; height:60%;" src="<?php echo $nombre_fichero1; ?>" alt="User profile picture">
                                                    <h3 class="profile-username text-center"><?php echo $_SESSION['name']; ?></h3>
                                                    <p class="text-muted text-center">Software Engineer</p>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Archivos ingresados</h3>
                                            </div>
                                            <div class="box-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Nombre del Archivo</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td> <?php 
                                                            if($person->image == NULL) { ?>
                                                                <label for="foto" class="col-sm-4 control-label"> Foto del aspirante:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="foto" id="foto" class="SubirFoto" accept="image/jpeg" capture="camera" /></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->image;
                                                            }  ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php 
                                                            if($person->cedula1 == NULL) { ?>
                                                                <label for="cedula1" class="col-sm-4 control-label"> Foto de Cedula (Frente):</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="cedula1" id="cedula1" class="SubirFoto" accept="image/jpeg" capture="camera" /></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->cedula1; 
                                                            } ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php 
                                                            if($person->cedula2 == NULL) { ?>
                                                                <label for="cedula2" class="col-sm-4 control-label"> Foto de Cedula (Reverso):</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="cedula2" id="cedula2" class="SubirFoto" accept="image/jpeg" capture="camera" /></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->cedula2; 
                                                            } ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php 
                                                            if($person->votacion == NULL) { ?>
                                                                <label for="votacion" class="col-sm-4 control-label"> Certificado de votaci&oacute;n:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="votacion" id="votacion" class="SubirFoto" accept="image/jpeg" capture="camera" /></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->votacion; 
                                                            } ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php 
                                                            if($person->firma == NULL) { ?>
                                                                <label for="firma" class="col-sm-4 control-label"> Firma personal:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="firma" id="firma" class="SubirFoto" accept="image/jpeg" capture="camera" /></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->firma; 
                                                            } ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php 
                                                            if($person->archivo == NULL) { ?>
                                                                <label for="foto" class="col-sm-4 control-label"> Historial Laboral (IESS):</label>
                                                                <div class="col-sm-6">
                                                                    <input type="file" name="archivo" id="archivo" class="SubirFoto" accept=".pdf"/></br>
                                                                </div> <?php
                                                            }else{ 
                                                                echo $person->archivo; 
                                                            } ?>
                                                        </td>
                                                        <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                            <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="miAlbum" style="display: block;">
                                            <h1>Documentos</h1>
                                            <div class="imagenes">
                                                <div class="imagen" onmouseover="mostrar(this)" onmouseout="ocultar(this)" onclick="ampliar('<?php echo $nombre_fichero1; ?>')">
                                                    <img src="<?php echo $nombre_fichero1; ?>" alt="Imagen Muestra">
                                                </div>
                                                <div class="imagen" onmouseover="mostrar(this)" onmouseout="ocultar(this)" onclick="ampliar('<?php echo $nombre_fichero2; ?>')">
                                                    <img src="<?php echo $nombre_fichero2; ?>" alt="Imagen Muestra">
                                                </div>
                                                <div class="imagen" onmouseover="mostrar(this)" onmouseout="ocultar(this)" onclick="ampliar('<?php echo $nombre_fichero3; ?>')">
                                                    <img src="<?php echo $nombre_fichero3; ?>" alt="Imagen Muestra">
                                                </div>
                                                <div class="imagen" onmouseover="mostrar(this)" onmouseout="ocultar(this)" onclick="ampliar('<?php echo $nombre_fichero4; ?>')">
                                                    <img src="<?php echo $nombre_fichero4; ?>" alt="Imagen Muestra">
                                                </div>
                                                <div class="imagen" onmouseover="mostrar(this)" onmouseout="ocultar(this)" onclick="ampliar('<?php echo $nombre_fichero5; ?>')">
                                                    <img src="<?php echo $nombre_fichero5; ?>" alt="Imagen Muestra">
                                                </div>
                                            </div>
                                        </div>
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
                                                            <div class="col-sm-6">
                                                                <label for="llantas" class="col-sm-4 control-label">Llantas Buenas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="llantas" name="llantas" value="1" <?php if($client->llantas==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="llantas" name="llantas" value="0" <?php if($client->llantas==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ollantas" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ollantas" name="ollantas" value="<?php echo $client->ollantas; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="rayones" class="col-sm-4 control-label">Tiene Rayones</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="rayones" name="rayones" value="1" <?php if($client->rayones==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="rayones" name="rayones" value="0" <?php if($client->rayones==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="orayones" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="orayones" name="orayones" value="<?php echo $client->orayones; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="espejos" class="col-sm-4 control-label">Espejos buenos</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="espejos" name="espejos" value="1" <?php if($client->espejos==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="espejos" name="espejos" value="0" <?php if($client->espejos==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oespejos" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oespejos" name="oespejos" value="<?php echo $client->oespejos; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="puertas1" class="col-sm-4 control-label">Puertas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="puertas1" name="puertas1" value="1" <?php if($client->puertas1==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="puertas1" name="puertas1" value="0" <?php if($client->puertas1==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="opuertas1" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opuertas1" name="opuertas1" value="<?php echo $client->opuertas1; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label">Capo hundido</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="capo" name="capo" value="1" <?php if($client->capo==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="capo" name="capo" value="0" <?php if($client->capo==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ocapo" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ocapo" name="ocapo" value="<?php echo $client->ocapo; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="balde" class="col-sm-4 control-label">Balde bueno</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="balde" name="balde" value="1" <?php if($client->balde==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="balde" name="balde" value="0" <?php if($client->balde==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="obalde" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="obalde" name="obalde" value="<?php echo $client->obalde; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="guias1" class="col-sm-4 control-label">Guias Golpedas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="guias1" name="guias1" value="1" <?php if($client->guias1==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="guias1" name="guias1" value="0" <?php if($client->guias1==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oguias1" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oguias1" name="oguias1" value="<?php echo $client->oguias1; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="guias2" class="col-sm-4 control-label">Guias Rotas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="guias2" name="guias2" value="1" <?php if($client->guias2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="guias2" name="guias2" value="0" <?php if($client->guias2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oguias2" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oguias2" name="oguias2" value="<?php echo $client->oguias2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="luces" class="col-sm-4 control-label">Luces</label>
                                                                <div class="col-md-8 col-sm-6">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="luces" name="luces" value="1" <?php if($client->luces==1) echo 'checked'; ?>> Buenas &nbsp;&nbsp;
                                                                        <input type="radio" id="luces" name="luces" value="0" <?php if($client->luces==0) echo 'checked'; ?>> Malas
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oluces" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oluces" name="oluces" value="<?php echo $client->oluces; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="parabrisa" class="col-sm-4 control-label">Parabrisas</label>
                                                                <div class="col-md-8 col-sm-6">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="parabrisa" name="parabrisa" value="1" <?php if($client->parabrisa==1) echo 'checked'; ?>> Bueno &nbsp;&nbsp;
                                                                        <input type="radio" id="parabrisa" name="parabrisa" value="0" <?php if($client->parabrisa==0) echo 'checked'; ?>> Malo
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oparabrisa" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oparabrisa" name="oparabrisa" value="<?php echo $client->oparabrisa; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <span class="text-danger">Tiene sonidos raros el motor?</span>
                                                                <div class="radiobutton">
                                                                    <input type="radio" id="motor" name="motor" value="1" <?php if($client->motor==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                    <input type="radio" id="motor" name="motor" value="0" <?php if($client->motor==0) echo 'checked'; ?>> No
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <span class="text-danger">Tiene alguna anomalia interna?</span>
                                                                <div class="radiobutton">
                                                                    <input type="radio" id="anomalia" name="anomalia" value="1" <?php if($client->anomalia==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                    <input type="radio" id="anomalia" name="anomalia" value="0" <?php if($client->anomalia==0) echo 'checked'; ?>> No
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
                                                                <label for="asientos" class="col-sm-4 control-label">Asientos</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="asientos" name="asientos" value="1" <?php if($client->asientos==1) echo 'checked'; ?>> Buenos &nbsp;&nbsp;
                                                                        <input type="radio" id="asientos" name="asientos" value="0" <?php if($client->asientos==0) echo 'checked'; ?>> Rotos
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oasientos" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oasientos" name="oasientos" value="<?php echo $client->oasientos; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="panel" class="col-sm-4 control-label">Esta bueno el Panel</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="panel" name="panel" value="1" <?php if($client->panel==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="panel" name="panel" value="0" <?php if($client->panel==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="opanel" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opanel" name="opanel" value="<?php echo $client->opanel; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="cinturon" class="col-sm-4 control-label">Cinturones buenos</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="cinturon" name="cinturon" value="1" <?php if($client->cinturon==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="cinturon" name="cinturon" value="0" <?php if($client->cinturon==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ocinturon" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ocinturon" name="ocinturon" value="<?php echo $client->ocinturon; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="forros" class="col-sm-4 control-label">Forros buenos</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="forros" name="forros" value="1" <?php if($client->forros==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="forros" name="forros" value="0" <?php if($client->forros==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oforros" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oforros" name="oforros" value="<?php echo $client->oforros; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="elevadores" class="col-sm-4 control-label">Elevadores buenos</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="elevadores" name="elevadores" value="1" <?php if($client->elevadores==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="elevadores" name="elevadores" value="0" <?php if($client->elevadores==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oelevadores" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oelevadores" name="oelevadores" value="<?php echo $client->oelevadores; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="aire" class="col-sm-4 control-label">A/C funciona</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="aire" name="aire" value="1" <?php if($client->aire==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="aire" name="aire" value="0" <?php if($client->aire==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oaire" name="oaire" value="<?php echo $client->oaire; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="limpia" class="col-sm-4 control-label">Limpia Parabrisas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="limpia" name="limpia" value="1" <?php if($client->limpia==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="limpia" name="limpia" value="0" <?php if($client->limpia==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="olimpia" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="olimpia" name="olimpia" value="<?php echo $client->olimpia; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="emergencia" class="col-sm-4 control-label">Kit de Emergencia completo</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="emergencia" name="emergencia" value="1" <?php if($client->emergencia==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="emergencia" name="emergencia" value="0" <?php if($client->emergencia==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oemergencia" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oemergencia" name="oemergencia" value="<?php echo $client->oemergencia; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="extintor" class="col-sm-4 control-label">Extintor</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="extintor" name="extintor" value="1" <?php if($client->extintor==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="extintor" name="extintor" value="0" <?php if($client->extintor==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oextintor" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oextintor" name="oextintor" value="<?php echo $client->oextintor; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="techo" class="col-sm-4 control-label">Techo roto</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="techo" name="techo" value="1" <?php if($client->techo==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="techo" name="techo" value="0" <?php if($client->techo==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="otecho" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="otecho" name="otecho" value="<?php echo $client->otecho; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="puertas2" class="col-sm-4 control-label">Puertas buenas</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="puertas2" name="puertas2" value="1" <?php if($client->puertas2==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="puertas2" name="puertas2" value="0" <?php if($client->puertas2==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="opuertas2" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="opuertas2" name="opuertas2" value="<?php echo $client->opuertas2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="enciende" class="col-sm-4 control-label">Enciende bien</label>
                                                                <div class="col-md-8 col-sm-6">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="enciende" name="enciende" value="1" <?php if($client->enciende==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                        <input type="radio" id="enciende" name="enciende" value="0" <?php if($client->enciende==0) echo 'checked'; ?>> No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oenciende" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oenciende" name="oenciende" value="<?php echo $client->oenciende; ?>">
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
                                                                <label for="aceite" class="col-sm-4 control-label">Aceite Motor</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="aceite" name="aceite" value="1" <?php if($client->aceite==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="aceite" name="aceite" value="0" <?php if($client->aceite==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="oaceite" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="oaceite" name="oaceite" value="<?php echo $client->oaceite; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="hidraulico" class="col-sm-4 control-label">Aceite Hidraulico</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="hidraulico" name="hidraulico" value="1" <?php if($client->hidraulico==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="hidraulico" name="hidraulico" value="0" <?php if($client->hidraulico==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ohidraulico" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ohidraulico" name="ohidraulico" value="<?php echo $client->ohidraulico; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="freno" class="col-sm-4 control-label">Liquido Freno</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="freno" name="freno" value="1" <?php if($client->freno==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="freno" name="freno" value="0" <?php if($client->freno==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="ofreno" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="ofreno" name="ofreno" value="<?php echo $client->ofreno; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="refrigerante" class="col-sm-4 control-label">Refrigerante</label>
                                                                <div class="col-md-8 col-sm-4">
                                                                    <div class="radiobutton">
                                                                        <input type="radio" id="refrigerante" name="refrigerante" value="1" <?php if($client->refrigerante==1) echo 'checked'; ?>> Completo &nbsp;&nbsp;
                                                                        <input type="radio" id="refrigerante" name="refrigerante" value="0" <?php if($client->refrigerante==0) echo 'checked'; ?>> Falta
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="orefrigerante" class="col-sm-4 control-label"> Observacion:</label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control" id="orefrigerante" name="orefrigerante" value="<?php echo $client->orefrigerante; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  <!--/ Referencias de Vehiculos -->
                                </div>
                            </div>
						</div>
					</div>
				</div>			
			</div>
		</div>
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
							<label for="cargo" class="col-md-4 col-sm-3 control-label"> Cargo:</label>
							<div class="col-md-8 col-sm-5">
							    <input type="text" class="form-control" id="cargo" name="cargo" value="CUSTODIA" placeholder="Descripcion del cargo">
							</div>
						</div>
						<div class="form-group">
							<label for="cedulaA" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cedula:</label>
							<div class="col-md-3 col-sm-2">
							    <input type="number" class="form-control" id="cedulaA" name="cedulaA" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" maxlength="10" value="" placeholder="0989564512">
							</div>
						</div>
						<div class="form-group">
							<label for="celularA" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Celular:</label>
							<div class="col-md-3 col-sm-2">
							    <input type="number" class="form-control" id="celularA" name="celularA" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" maxlength="10" value="" placeholder="0945781245">
							</div>
						</div>
						<div class="form-group">
							<label for="nombreA" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Nombre Completos:</label>
							<div class="col-md-8 col-sm-5"><input type="text" class="form-control" id="nombreA" name="nombreA" value="" placeholder="Nombre del agente"></div>
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
    document.title = "Near Solutions | Registro de entregas";
	
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
			$cargo = $('#cargo').val();
			$cedula = $('#cedulaA').val();
			$celular = $('#celularA').val();
			$nombre = $('#nombreA').val();
			
			if($cotizacion == 0 || $cedula == '' || $nombre == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
				$.ajax({
					type: "POST",
					url: "ajax/custodia.php?cotizacion="+$cotizacion+"&cargo="+$cargo+"&cedula="+$cedula+"&celular="+$celular+"&nombre="+$nombre,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
						window.location="index.php?view=recibo&id="+$cotizacion;
					}
				});
			} 

            return false;
        }) 
    });
</script>
