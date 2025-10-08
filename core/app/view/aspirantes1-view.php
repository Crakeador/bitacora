<?php
// Ingreso de los aspirantes
if(isset($_GET['id'])){
    $mensaje = "modificar un aspirante del sistema";
    $enlaces = "Modificar";
    $person = PersonData::getById($_GET['id']);

    $id_person = $_GET['id'];
}else{
    if(count($_POST)>0){
        $errores = "";
        if($_POST["id_person"] == 0){
            if(is_object(PersonData::getLike("idcard", $_POST["cedula"]))){
                $errores .= "- Cedula repetida";
            }
        }          
        
        $embarazada = 0;
        if(isset($_POST["embarazada"])) $embarazada = 1; else $embarazada = 0;
        
        $var = str_replace('_', '', $_POST["money"]);
        $var = str_replace('.', '', $var);
        $var = str_replace(',', '.', $var);

        $person = (object) [
           "idcard" => $_POST["cedula"],
           "image"=>"assets/images/user0.png",
           "name" => strtoupper($_POST["nombres"]),
           "latitude" => $_POST["latitude"],
           "longitude" => $_POST["longitude"],
           "mensaje" => $_POST["mensaje"],
           "email" => $_POST["email"],
           "genero" => $_POST["genero"],
           "conyuge" => $_POST["conyuge"],
           "embarazada" => $embarazada,
           "hijos" => $_POST["hijos"],
           "copiacedula" => $_POST["copiacedula"],
           "fechanacimiento" => $_POST["fechanacimiento"],
           "lugarnacimiento" => $_POST["lugarnacimiento"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "reentrenamiento" => $_POST["reentrenamiento"],
           "demanda" => $_POST["demanda"],
           "monto" => $var,
           "phone1" => $_POST["telefono1"],
           "phone2" => $_POST["telefono2"],
           "phone3" => $_POST["telefono3"],
           "direccion" => $_POST["direccion"],
           "tipo_sangre" => $_POST["tipo_sangre"],
           "tipo_vivienda" => $_POST["tipo_vivienda"],
           "especifique" => $_POST["especifique"],
           "bachiller" => $_POST["bachiller"],
           "especializacion1" => $_POST["especializacion1"],
           "esc_tecnico" => $_POST["esc_tecnico"],
           "especializacion2" => $_POST["especializacion2"],
           "celulartactil" => $_POST["celulartactil"],
           "computadora" => $_POST["computadora"],
           "curso_realizado" => $_POST["curso_realizado"],
           "certificados" => $_POST["certificados"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "tiene_afis" => $_POST["tiene_afis"],
           "recibo" => 0,
           "completo" => 0,
           "is_active" => 1
        ];

        if($_POST["id_person"] == 0){
            if(isset($_FILES["foto"]) && $_FILES["foto"]["name"]=="") $errores .= "- No puede dejar la foto del aspirante en blanco\n";
            if(isset($_FILES["cedula1"]) && $_FILES["cedula1"]["name"]=="") $errores .= "- No puede dejar la cedula en blanco\n";
            if(isset($_FILES["cedula2"]) && $_FILES["cedula2"]["name"]=="") $errores .= "- No puede dejar la cedula en blanco\n";
            if(isset($_FILES["certificado"]) && $_FILES["certificado"]["name"]=="") $errores .= "- No puede dejar el certificado en blanco\n";
            if(isset($_FILES["vivienda"]) && $_FILES["vivienda"]["name"]=="") $errores .= "- No puede dejar la foto de la vivienda\n";
            if(isset($_FILES["carnet"]) && $_FILES["carnet"]["name"]=="") $errores .= "- No puede dejar la foto del carnet\n";
            if(isset($_FILES["firma"]) && $_FILES["firma"]["name"]=="") $errores .= "- No puede dejar la foto de la firma\n";
        }
        
        if($errores == ''){
            $user = new PersonData();

            $user->cargo = 11;
            $user->company = $_SESSION['id_company'];
            $user->id = $_POST["id_person"];
            $user->idcard = $_POST["cedula"];
            $user->email = $_POST["email"];
            $user->name = strtoupper($_POST["nombres"]);
            $user->mensaje = strtoupper($_POST["mensaje"]);
            $user->genero = $_POST["genero"];
            $user->conyuge = strtoupper($_POST["conyuge"]);
            $user->embarazada = $embarazada;
            $user->hijos = (int) $_POST["hijos"];
            $user->latitude = $_POST["latitude"];
            $user->longitude = $_POST["longitude"];
            $user->demanda = $_POST["demanda"];
            $user->monto = $_POST["money"];
            $user->copiacedula = $_POST["copiacedula"];
            $user->fechanacimiento = $_POST["fechanacimiento"];
            $user->lugarnacimiento = strtoupper($_POST["lugarnacimiento"]);
            $user->phone1 = $_POST["telefono1"];
            $user->phone2 = $_POST["telefono2"];
            $user->phone3 = $_POST["telefono3"];
            $user->direccion = $_POST["direccion"];
            $user->tipo_sangre = (int) $_POST["tipo_sangre"];
            $user->tipo_vivienda = $_POST["tipo_vivienda"];
            $user->especifique = $_POST["especifique"];
            $user->bachiller = $_POST["bachiller"];
            $user->especializacion1 = $_POST["especializacion1"];
            $user->esc_tecnico = $_POST["esc_tecnico"];
            $user->especializacion2 = $_POST["especializacion2"];
            $user->celulartactil = $_POST["celulartactil"];
            $user->computadora = $_POST["computadora"];
            $user->curso_realizado = $_POST["curso_realizado"];
            $user->certificados = $_POST["certificados"];
            $user->tiene_carnet = $_POST["tiene_carnet"];
            $user->reentrenamiento = $_POST["reentrenamiento"];
            $user->tiene_afis = $_POST["tiene_afis"];
            $user->recibo = 0;
            $user->completo = 0;
            $user->is_active = 1;

            if($_FILES["foto"]["name"]==""){
                $user->image = "";
            }else{
                $image = new Upload($_FILES["foto"]);

                if($image->uploaded){
                    $image->Process("storage/persons/");

                    if($image->processed){
                        $user->image = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["cedula1"]["name"]==""){
                $user->cedula1 = "";
            }else{
                $image = new Upload($_FILES["cedula1"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->cedula1 = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["cedula2"]["name"]==""){
                $user->cedula2 = "";
            }else{
                $image = new Upload($_FILES["cedula2"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->cedula2 = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["certificado"]["name"]==""){
                $user->votacion = "";
            }else{
                $image = new Upload($_FILES["certificado"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->votacion = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["vivienda"]["name"]==""){
                $user->vivienda = "";
            }else{
                $image = new Upload($_FILES["vivienda"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->vivienda = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["carnet"]["name"]==""){
                $user->carnet = "";
            }else{
                $image = new Upload($_FILES["carnet"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->carnet = $image->file_dst_name;
                    }
                }
            }
            
            if($_FILES["firma"]["name"]==""){
                $user->firma = "";
            }else{
                $image = new Upload($_FILES["firma"]);

                if($image->uploaded){
                    $image->Process("storage/fotos/");

                    if($image->processed){
                        $user->firma = $image->file_dst_name;
                    }
                }
            }

            if($_POST["id_person"] == 0) {
                $user->add_aspirante();
            }else{
                $user->upd_aspirante();
            }
            
        	// Varios destinatarios
        	$para = $_POST["email"]; // atención a la coma
        	$título = 'Registro de los datos del Aspirante '.$_POST["nombres"];
        
        	// mensaje
        	$mensaje = '<html>
                        	<head>
                        	    <title>Ingreso de solicitud de aspirante</title>
                        	</head>
                        	<body>
                        		<h1>Se ingreso un aspirante desde: '.$_POST["latitude"].', '.$_POST["longitude"].'</h1>
                        	    <p>La fecha maxima de Ejecuci&oacute;n es: '.date('Y-m-d').'</p>'.$_SESSION["email"].'
                        	    <p>'.$_POST["nombres"].'</p>
                        		<a class="text-primary" href="index.php?view=mapas&lat='.$_POST["latitude"].'&lot='.$_POST["longitude"].'>Mira aqui</a>
                        	</body>
                	    </html>';
        
        	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
        	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        	// Cabeceras adicionales
        	$cabeceras .= 'To: jorgefiallos@gmail.com, jorgefiallos@hotmail.com, programacion@security.ec, talentohumano@security.ec '."\r\n";
        	$cabeceras .= 'From: Recordatorio <info@security.ec>' . "\r\n";
        
        	// Enviarlo
        	$bool = mail($para, $título, $mensaje, $cabeceras);
        	
        	//print "<script>window.location='index.php?view=aspirantes&correo=".$bool."';</script>";
            //Core::redir('opeasp.lista');
        }else{
            Core::alert("Corrija...!!!!", $errores, "error");
        }
    }else{
        $mensaje = "crear un nuevo aspirante al sistema";
        $enlaces = "Crear";
        $id_person = 0;

        $id_person = 0;
        $person = (object) [
           "idcompany"=>$_SESSION['id_company'],
           "idcard"=>$_SESSION['id_card'],
           "image"=>"assets/images/user0.png",
           "cedula1"=>"",
           "cedula2"=>"",
           "votacion"=>"",
           "vivienda"=>"",
           "carnet"=>"",
           "name"=>"",
           "cargo"=>11,           
           "hijos"=>0,
           "demanda"=>"",
           "monto"=>NULL,
           "tiene_carnet"=>"0",
           "reentrenamiento"=>"",
           "tiene_afis"=>"0",
           "ubicacion"=>"",
           "email"=>"",
           "copiacedula"=>"0",
           "genero"=>"0",
           "direccion"=>"",
           "lugarnacimiento"=>"",
           "fechanacimiento"=>"",
           "tipo_vivienda"=>"2",
           "tipo_sangre"=>"0",
           "especifique"=>"","0",
           "planilla"=>"0",
           "contrato"=>"0",
           "croquis"=>"0",
           "phone1"=>"",
           "phone2"=>"",
           "phone3"=>"",
           "bachiller"=>"0",
           "especializacion1"=>"",
           "esc_tecnico"=>"0",
           "especializacion2"=>"",
           "computadora"=>"0",
           "celulartactil"=>"0",
           "curso_realizado"=>"",
           "certificados"=>"0",
           "firma"=>"0",
           "tipo_contrato"=>"",
           "computadora"=>"0",
           "is_active" => "1"
        ];
    }
}

//var_dump($_SESSION);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Aspirantes
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-database"></i> Aspirantes </li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
    <div class="row">
  	    <div class="container-fluid">
  			<!-- Dialogo para seleccionar una cuenta -->
  			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="aspirante" name="aspirante" action="index.php?view=aspirantes" role="form">
                <input type="hidden" id="verifica"   name="verifica"   value="0">
                <input type="hidden" id="timestamp"  name="timestamp"  value="">
                <input type="hidden" id="latitude"   name="latitude"   value="">
                <input type="hidden" id="longitude"  name="longitude"  value="">
                <input type="hidden" id="rangoerror" name="rangoerror" value="">
                <input type="hidden" id="sentido"    name="sentido"    value="">
                <input type="hidden" id="velocidad"  name="velocidad"  value="">
                <input type="hidden" id="mensaje"    name="mensaje"    value="">
   			    <input type="hidden" id="id_person" name="id_person" value="<?php echo $id_person; ?>">
   			    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Datos importantes...!</h4>
                    <ul>
                      <li>Debe de tomar toda las fotos de manera clara y legible</li>
                      <li>No puede portar lentes, ni gorra</li>
                      <li>Debe poner como fondo de las fotos un color blanco</li>
                    </ul>
                </div>
  				<div class="row">
  					<div class="col-md-7">
  						<div class="panel panel-default">
  							<div class="panel-heading">
  								<h3 class="panel-title"><i class="mr5"></i>Informaci&oacute;n del Coolaborador</h3>
  							</div>
  							<div class="panel-collapse pull out">
  								<div class="panel-body">
  									<div class="" id="datos">
  										<div class="form-group">
  											<div class="col-sm-10">
  												<span class="text-danger">DATOS BASICOS:</span>
  											</div>
  										</div>
  										<div class="form-group">
  											<label for="email" class="col-sm-4 control-label"><span class="text-danger">*</span> Correo electronico:</label>
  											<div class="col-sm-6"><input class="text-field form-control input-sm" id="email" name="email" type="email" value="<?php echo utf8_encode($person->email); ?>" minlength="3" maxlength="30" style="text-transform: lowercase;" placeholder="Correo personal" required></div>
  										</div>
                                        <div class="form-group" <?php if($person->image == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="foto" class="col-sm-4 control-label"> Foto del aspirante:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="foto" id="foto" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
                                        <div class="form-group" <?php if($person->firma == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <div class="col-sm-10">
                                                <div class="callout callout-info">
                                                    <h4>Firma del Aspirante...!</h4>
                                                    <p>- Debe realizar la firma en una hoja en blando y tome una foto, esto servirá para la validación de la informaci&oacute;n subida, asi como la elaboraci&oacute;n de los carnets.</p> 
                                                </div>
                                            </div>
                                            <label for="firma" class="col-sm-4 control-label"> Firma del aspirante:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="firma" id="firma" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
  										<div class="form-group">
  											<label for="cedula" class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
  											<div class="col-sm-3">
  											    <input class="form-control" id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" data-mask placeholder="9999999999" value="<?php echo $person->idcard; ?>" required pattern="^[0-9]{10}" title="Solo números. Tamaño obligatorio: 10">
  											</div>
  										</div>
  										<div class="form-group">
  											<label for="nombres" class="col-sm-4 control-label"><span class="text-danger">*</span> Nombres Completos:</label>
  											<div class="col-sm-6"><input class="text-field form-control input-sm" id="nombres" name="nombres" type="text" value="<?php echo utf8_encode($person->name); ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" placeholder="Primer nombre del personal" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ñ]{3,40}" title="Solo letras. Tamaño mínimo: 3. Tamaño máximo: 30" required></div>
  										</div>
                                        <div class="form-group">
                                            <label for="tipo_sangre" class="col-sm-4 control-label"><span class="text-danger">*</span> Tipo de Sangre:</label>
                                            <div class="col-sm-3">
                                                <select class="select-input form-control input-sm" id="tipo_sangre" name="tipo_sangre">
                                                <option value="0" <?php if($person->tipo_sangre==0) echo 'selected="selected"'; ?>>Seleccione</option>
                                                <option value="1" <?php if($person->tipo_sangre==1) echo 'selected="selected"'; ?>>A-</option>
                                                <option value="2" <?php if($person->tipo_sangre==2) echo 'selected="selected"'; ?>>A+</option>
                                                <option value="3" <?php if($person->tipo_sangre==3) echo 'selected="selected"'; ?>>AB-</option>
                                                <option value="4" <?php if($person->tipo_sangre==4) echo 'selected="selected"'; ?>>AB+</option>
                                                <option value="5" <?php if($person->tipo_sangre==5) echo 'selected="selected"'; ?>>B-</option>
                                                <option value="6" <?php if($person->tipo_sangre==6) echo 'selected="selected"'; ?>>B+</option>
                                                <option value="7" <?php if($person->tipo_sangre==7) echo 'selected="selected"'; ?>>O-</option>
                                                <option value="8" <?php if($person->tipo_sangre==8) echo 'selected="selected"'; ?>>O+</option>
                                                </select>
                                            </div>
                                        </div>
  										<div class="form-group">
  											<label for="genero" class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
  											<div class="col-sm-3">
  												<select class="select-input form-control input-sm" id="genero" name="genero">
  													<option value="0" <?php if($person->genero==0) echo 'selected="selected"'; ?>>Seleccione</option>
  													<option value="1" <?php if($person->genero==1) echo 'selected="selected"'; ?>>Masculino</option>
  													<option value="2" <?php if($person->genero==2) echo 'selected="selected"'; ?>>Femenino</option>
  												</select>
  											</div>
  										</div>
                                        <div class="form-group" id="masculino" style="display: none;">
                                            <label for="conyuge" class="col-sm-4 control-label"><span class="text-danger">*</span><span class="price-cash" > Nombre de la conyuge: </span></label>
  											<div class="col-sm-6">
                                                <input class="text-field form-control input-sm" type="text" name="conyuge" id="conyuge">&nbsp;&nbsp;<input type="checkbox" name="embarazada" value="1" id="embarazada"> Esta embarazada
                                            </div>
                                        </div>
  										<div class="form-group">
  											<label for="fechanacimiento" class="col-sm-4 control-label"><span class="text-danger">*</span> Fecha de nacimiento:</label>
  											<div class="col-sm-4"><input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo $person->fechanacimiento; ?>" required title="Debe de ser una fecha valida"></div>
  										</div>
                                        <div class="form-group" <?php if($person->cedula1 == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="cedula1" class="col-sm-4 control-label"> Foto de Cedula (Frente):</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="cedula1" id="cedula1" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
                                        <div class="form-group" <?php if($person->cedula2 == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="cedula2" class="col-sm-4 control-label"> Foto de Cedula (Posterior):</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="cedula2" id="cedula2" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
                                        <div class="form-group" <?php if($person->votacion == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="certificado" class="col-sm-4 control-label"> Certificado de votacion:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="certificado" id="certificado" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
  										<div class="form-group">
  											<label for="lugarnacimiento" class="col-sm-4 control-label"><span class="text-danger">*</span> Lugar de nacimiento:</label>
  											<div class="col-sm-6"><input class="text-field form-control input-sm" id="lugarnacimiento" maxlength="25" name="lugarnacimiento" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->lugarnacimiento; ?>" required style="text-transform: uppercase;" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
  										</div>
  										<div class="form-group">
  											<label for="telefono1" class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
  											<div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Debe de ser un numero valido...!!!"></div>
  										</div>
                                        <div class="form-group">
  											<label for="telefono2" class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono de Emergencia:</label>
  											<div class="col-sm-3"><input type="text" class="form-control" id="telefono2" name="telefono2" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone2; ?>" required minlength="9" pattern="[0-9]{9,10}" title="Debe de ser un numero valido...!!!"></div>
  										</div>
  										<div class="form-group">
  											<label for="telefono3" class="col-sm-4 control-label"> Tel&eacute;fono convencial:</label>
  											<div class="col-sm-3"><input type="text" class="form-control" id="telefono3" name="telefono3" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $person->phone3; ?>"></div>
  										</div>
  										</br>
  										<div class="form-group">
  											<div class="col-sm-8">
  												<span class="text-danger">DATOS DE LA VIVIENDA:</span>
  											</div>
  										</div>
  										<div class="form-group">
  											<label for="direccion" class="col-sm-4 control-label"><span class="text-danger">*</span> Direcci&oacute;n de domicilio:</label>
  											<div class="col-sm-8">
  												<textarea class="form-control" id="direccion" name="direccion" placeholder="Dirrecci&oacute;n de su vivienda actual" required><?php echo $person->direccion; ?></textarea>
  											</div>
  										</div>
                                        <div class="form-group" <?php if($person->vivienda == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="vivienda" class="col-sm-4 control-label"> Foto de la vivienda:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="vivienda" id="vivienda" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
  										<div class="form-group">
  											<div class="col-sm-offset-1 col-sm-2">
  												El tipo de vivienda es:
  												<div class="radiobutton">
  													<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="1" <?php if($person->tipo_vivienda==1) echo 'checked'; ?>> Propia &nbsp;&nbsp;
  													<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="2" <?php if($person->tipo_vivienda==2) echo 'checked'; ?>> Alquilada 
  													<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="3" <?php if($person->tipo_vivienda==3) echo 'checked'; ?>> Familiar &nbsp;&nbsp;
  													<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="4" <?php if($person->tipo_vivienda==4) echo 'checked'; ?>> Otro
  												</div>
  											</div>
  										</div>
  										<div class="form-group">
  											<label for="especifique" class="col-sm-2 control-label">Especifique:</label>
  											<div class="col-sm-10">
  												<input type="text" class="form-control" id="especifique" name="especifique" placeholder="Especifique que tipo de vivienda posee" value="<?php echo $person->especifique; ?>">
  											</div>
  										</div>
  									</div>
  								</div>
  							</div>
  						</div>
  					</div>
  					<!-- Informacion personal Operativo -->
  					<div class="col-md-5">
  						<div id="datos_laborales">
  							<div class="panel panel-default">
  								<div class="panel-heading">
  									<h3 class="panel-title"><i class="mr5"></i>Informacion Clasificada</h3>
  								</div>
  								<div class="panel-collapse pull out">
  									<div class="panel-body">
  										<div class="form-group">
  											<label for="tiene_carnet" class="col-sm-6 control-label">Tiene carnet Nivel I?</label>
  											<div class="col-md-4 col-sm-5">
  												<div class="radiobutton">
  													<input type="radio" id="tiene_carnet" name="tiene_carnet" value="1" <?php if($person->tiene_carnet==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  													<input type="radio" id="tiene_carnet" name="tiene_carnet" value="0" <?php if($person->tiene_carnet==0) echo 'checked'; ?>> No
  												</div>
  											</div>
  										</div>
                                        <div class="form-group" <?php if($person->carnet == NULL) echo ''; else echo 'style="display: none;"'; ?>>
                                            <label for="carnet" class="col-sm-4 control-label"> Foto del Carnet:</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="carnet" id="carnet" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                            </div>
                                        </div>
  										<div class="form-group">
  											<label for="reentrenamiento" class="col-sm-4 control-label"> Reentrenamientos:</label>
  											<div class="col-md-6 col-sm-6"><input type="text" class="form-control" id="reentrenamiento" name="reentrenamiento" placeholder="2002, 2011..." value="<?php echo $person->reentrenamiento; ?>"></div>
  										</div>
  										<div class="form-group">
  											<div class="col-sm-15">
  												<label class="col-sm-8 control-label">Tiene demanda de alimentos?</label>
  												<div class="col-md-4" <?php if($person->monto == 0) echo ''; else echo 'style="display: none;"'; ?>>
                                                    <div class="boton" id="alimentos">
                                                      Si tengo...!
                                                    </div>
  												</div>
  											</div>
  										</div>
  										<div class="form-group" id="alimentame" <?php if($person->monto == 0) echo 'style="display: none;"'; else echo ''; ?>>
  											<label for="money" class="col-sm-4 control-label"><span class="text-danger">*</span> Monto:</label>
  											<div class="col-md-6 col-sm-6">
  												<input type="text" class="form-control" id="money" name="money" data-mask placeholder="$ 9.999,99" value="<?php echo $person->monto; ?>">
  											</div>
  										</div>
  										<div class="form-group">
  											<div class="col-sm-15">
  												<label for="demanda" class="col-sm-8 control-label">Tiene hijos menores de 18 años?</label>
  												<div class="col-md-4" <?php if($person->hijos == 0) echo ''; else echo 'style="display: none;"'; ?>>
                                                    <div class="boton" id="tiene">
                                                      Si tengo...!
                                                    </div>
  												</div>
  											</div>
  										</div>
  										<div class="form-group" id="hijos" <?php if($person->hijos == 0) echo 'style="display: none;"'; else echo ''; ?>>
  											<label for="hijos" class="col-sm-4 control-label"><span class="text-danger">*</span> Nro. de hijos:</label>
  											<div class="col-sm-3"><input type="text" class="form-control" id="hijos" name="hijos" maxlength="2" data-mask placeholder="99" value="<?php echo $person->hijos; ?>" pattern="[0-9]{1,10}" title="Solo números"></div>
  										</div>
  									</div>
  								</div>
  							</div>
  						</div>
  					</div>
  					<div class="col-md-5">
  						<div id="personalizados_proveedor">
  							<div class="panel panel-default">
  								<div class="panel-heading">
  									<h3 class="panel-title"><i class="mr5"></i>Nivel de Educaci&oacute;n</h3>
  								</div>
  								<div class="panel-collapse pull out">
  									<div class="panel-body">
  										<div class="form-group">
  											<div class="col-sm-15">
  												<label for="bachiller" class="col-sm-8 control-label">Tiene titulo de bachiller?</label>
  												<div class="col-md-4">
  													<div class="radiobutton">
  														<input autocomplete="off" type="radio" id="bachiller" name="bachiller" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  														<input autocomplete="off" type="radio" id="bachiller" name="bachiller" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
  													</div>
  												</div>
  											</div>
  										</div>
  										<div class="form-group">
  											<div class="col-sm-15">
  												<label for="computadora" class="col-sm-8 control-label">Sabe utilizar la computadora?</label>
  												<div class="col-md-4">
  													<div class="radiobutton">
  														<input type="radio" id="computadora" name="computadora" value="1" <?php if($person->computadora==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  														<input type="radio" id="computadora" name="computadora" value="0" <?php if($person->computadora==0) echo 'checked'; ?>> No
  													</div>
  												</div>
  											</div>
  										</div>
  										<div class="form-group">
  											<div class="col-sm-15">
  												<label for="celulartactil" class="col-sm-8 control-label">Sabe utilizar celular tactil?</label>
  												<div class="col-md-4">
  													<div class="radiobutton">
  														<input type="radio" id="celulartactil" name="celulartactil" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  														<input type="radio" id="celulartactil" name="celulartactil" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
  													</div>
  												</div>
  											</div>
  										</div>
  										<div class="form-group">
  											<label for="curso_realizado" class="col-sm-4 control-label">Cursos realizados:</label>
  											<div class="col-sm-8">
  												<textarea class="form-control" id="curso_realizado" name="curso_realizado" placeholder="Especifique los cursos realizados"><?php echo $person->curso_realizado; ?></textarea>
  											</div>
  										</div>
  									</div>
  								</div>
  							 </div>
  						</div>
  					</div> <!--/ Nivel de educacion -->
  				</div>
  				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
  			</form>
  	    </div>
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
<script>
    document.title = "Near Solution | Ingreso de aspirante";

    $(document).ready(function(){
        $("input").iCheck({
            checkboxClass: "icheckbox_flat-blue",
            radioClass: "iradio_flat-blue"
        });
    
        $("#alimentos").on("click", function(evento) {
            console.log(evento, $("#alimentos").prop("change"));
            $("#alimentame").show();
        });
        
        $("#tiene").on("click", function(evento) {
            console.log(evento, $("#tiene").prop("change"));
            $("#hijos").show();
        });
        
        $('#genero').on('change', function() {
            if (this.value == '1'){
                $("#masculino").show();
                $(".price-cash").text('Nombre de la conyuge:');
            }else{
                if (this.value == '2'){
                $("#masculino").show();
                $(".price-cash").text('Nombre del esposo:');
                }else{
                    $("#masculino").hide();
                }
            }
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
