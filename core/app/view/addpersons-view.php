<?php 
$despidos = OperationTypeData::getByType('Liquidaciones');

$bancos = BancoData::getAll();
$cargos = CargoData::getAll();
$puesto = PuestoData::getAll(1);
$hoy = date("Y-m-d H:i:s");

if(isset($_GET['id'])){
    $mensaje = "modificar un usuario del sistema";
    $enlaces = "Modificar";
    $person = PersonData::getById($_GET['id']);

    $_SESSION['id_person'] = $_GET['id'];
    $id_person = $_GET['id'];
    
    if(!empty($person->image))
        $nombre_fichero = "storage/persons/".$person->image;
    else
        $nombre_fichero = 'storage/persons/1234567890.jpg';

    if (file_exists($nombre_fichero)) {
        $foto = $nombre_fichero;
    } else {
        $foto = 'storage/persons/1234567890.jpg';
    }
    $_SESSION['foto'] = $foto;
}else{
    $mensaje = "crear un nuevo usuario del sistema";
    $enlaces = "Crear";
    $id_person = 0;

    if(count($_POST)>0){
        $errores = "";
        if(!isset($_POST["cmb_idcargo"]) || $_POST["cmb_idcargo"]==0){
            $errores .= "- Debe de seleccionar el cargo de la persona\n";
        }
        if($_POST["id_person"] == 0){
            if(count(PersonData::getLike("idcard", $_POST["cedula"])) == 0){
                // Sin comentario
            }else{
                $errores .= "- Cedula repetida\n";
            }
        } 
		
        $acumular3 = 0; $acumular4 = 0;
        if(isset($_POST["acumular_decimo3"])) $acumular3 = 1; else $acumular3 = 0;		
        if(isset($_POST["acumular_decimo4"])) $acumular4 = 1; else $acumular4 = 0;
		
        if(isset($_POST["acumular_decimos"])) $decimos = 1; else $decimos = 0;  
		$foto = (isset($_POST["image"]) ? "assets/persons/".$_POST["image"]: "assets/images/avatar/user00.png");

        $person = (object) [
           "idcard" => $_POST["cedula"],           
           "image"=> (isset($_POST["image"]) ? "assets/persons/".$_POST["image"]: "storage/persons/1234567890.jpg"),  
           "cargo" => (isset($_POST["cmb_idcargo"]) ? $_POST["cmb_idcargo"]: 0),
           "startwork" => (isset($_POST["startwork"]) ? $_POST["startwork"]: ""),
           "endwork" => (isset($_POST["endwork"]) ? $_POST["endwork"]: ""),
           "name" => $_POST["nombre_uno"],
           "genero" => $_POST["genero"],
           "hijos" => $_POST["hijos"],
           "copiacedula" => $_POST["copiacedula"],
           "fechanacimiento" => $_POST["fechanacimiento"],
           "lugarnacimiento" => $_POST["lugarnacimiento"],
           "phone1" => $_POST["telefono1"],
           "phone2" => $_POST["telefono2"],
           "direccion" => $_POST["direccion"],
           "tipo_vivienda" => $_POST["tipo_vivienda"],
           "especifique" => $_POST["especifique"],
           "croquis" => $_POST["croquis"],
           "planilla" => $_POST["planilla"],
           "contrato" => $_POST["contrato"],
           "tipo_contrato" => (isset($_POST["tipo_contrato"]) ? $_POST["tipo_contrato"]: 0),
           "sueldo" => (isset($_POST["sueldo"]) ? $_POST["sueldo"]: 0),
           "bachiller" => $_POST["bachiller"],
           "especializacion1" => $_POST["especializacion1"],
           "esc_tecnico" => $_POST["esc_tecnico"],
           "especializacion2" => $_POST["especializacion2"],
           "computadora" => $_POST["computadora"],
           "celulartactil" => $_POST["celulartactil"],
           "curso_realizado" => $_POST["curso_realizado"],
           "certificados" => $_POST["certificados"],
           "banco" => (isset($_POST["banco"]) ? $_POST["banco"]: 0),
           "cuenta" => (isset($_POST["cuenta"]) ? $_POST["cuenta"]: ""),
           "tipo" => (isset($_POST["tipo"]) ? : ""),
           "tipo_pago" => (isset($_POST["tipo_pago"]) ? $_POST["tipo"]: ""),
           "recibe" => (isset($_POST["recibe"]) ? $_POST["recibe"]: ""),
           "recibo" => 0,
           "completo" => 0,
           "decimo" => 0,
           "region" => 2,
           "extencion" => 0,
           "acumula3" => $acumular3,		   
           "acumula4" => $acumular4,
           "is_active" => 1
        ];
		//echo 'Errores: '.$errores;
        if($errores == ''){
            $user = new PersonData();
            $user->company = $_SESSION['id_company'];
            $user->id = $_POST["id_person"];
            $user->idcard = $_POST["cedula"];
            $user->cargo = $_POST["cmb_idcargo"];
            $user->name = $_POST["nombre_uno"];
            $user->genero = $_POST["genero"];
            $user->hijos = $_POST["hijos"];
            $user->copiacedula = $_POST["copiacedula"];
            $user->fechanacimiento = $_POST["fechanacimiento"];
            $user->lugarnacimiento = $_POST["lugarnacimiento"];
            $user->phone1 = $_POST["telefono1"];
            $user->phone2 = $_POST["telefono2"];
            $user->direccion = $_POST["direccion"];
            $user->tipo_vivienda = $_POST["tipo_vivienda"];
            $user->especifique = $_POST["especifique"];
            $user->direccion = $_POST["direccion"];
            $user->croquis = $_POST["croquis"];
            $user->planilla = $_POST["planilla"];
            $user->contrato = $_POST["contrato"];
            $user->startwork = $_POST["startwork"];
            $user->endwork = $_POST["endwork"];
            $user->cargo = $_POST["cmb_idcargo"];
            $user->tipo_contrato = $_POST["tipo_contrato"];
            $user->sueldo = $_POST["sueldo"];
            $user->bachiller = $_POST["bachiller"];
            $user->especializacion1 = $_POST["especializacion1"];
            $user->esc_tecnico = $_POST["esc_tecnico"];
            $user->especializacion2 = $_POST["especializacion2"];
            $user->computadora = $_POST["computadora"];
            $user->celulartactil = $_POST["celulartactil"];
            $user->curso_realizado = $_POST["curso_realizado"];
            $user->certificados = $_POST["certificados"];
            $user->banco = $_POST["banco"];
            $user->cuenta = $_POST["cuenta"];
            $user->tipo = $_POST["tipo"];
            $user->tipo_pago = $_POST["tipo_pago"];
            $user->recibe = $_POST["recibe"];
            $user->tipo_sangre = "";
            $user->certificadosangre = "";
            $user->peso = 0;
            $user->altura = 0;
            $user->tallacamisa = 0;
            $user->tallapantalon = 0;
            $user->tallazapato = 0;
            $user->se_ejercita = 0;
            $user->cuantos_dias = 0;
            $user->especifique_ejercicio = "";
            $user->embarazada = "";
            $user->lentes = "";
            $user->sobrepeso = "";
            $user->presion_alta = "";
            $user->diabetes = "";
            $user->rinones = "";
            $user->colesterol = "";
            $user->higado = "";
            $user->alergico = ""; 
            $user->especifique_alergico = "";
            $user->medicamento = "";
            $user->especifique_medicamento = "";
            $user->cirugia = "";
            $user->especifique_cirugia = "";
            $user->protesis = "";
            $user->especifique_protesis = "";
            $user->discapacidad = "";
            $user->tipo_discapacidad = "";
            $user->conadis = "";
            $user->porcentaje = 0;
            $user->copia_conadis = "";
            $user->licencia = "";
            $user->tipo_licencia = "";
            $user->copia_licencia = "";
            $user->moto = "";
            $user->marca_moto = "";
            $user->modelo_moto = "";
            $user->color_moto = "";
            $user->placa_moto = "";
            $user->ano_moto = "";
            $user->vehiculo = "";
            $user->marca = "";
            $user->modelo = "";
            $user->color = "";
            $user->placa = "";
            $user->ano_vehiculo = "";
            $user->copia_vehiculo = "";
            $user->recibo = 0;
            $user->completo = 0;            
            $user->decimo = ""; 
            $user->extension = ""; 
            $user->acumula3 = $acumular3; 
            $user->acumula4 = $acumular4; 
            $user->is_active = $_POST["is_active"];
			// var_dump($_POST);
            if($_POST["id_person"] == 0) {
                if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ""){
                    $image = new Upload($_FILES["image"]);
                    if($image->uploaded){
                        $image->Process("storage/persons/"); 
                        if($image->processed){                    
                            $user->image = $image->file_dst_name;                    
                            $prod = $user->addIMG();
                        }
                    }
                }else{
                    $regist = intval(PersonData::getTotal()->total);

                    $user->addId(1, ($regist+1));
                    $user->addAMD();
                }
            }else{
                if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ""){
                    $image = new Upload($_FILES["image"]);
                    if($image->uploaded){
                        $image->Process("storage/persons/"); 
                        if($image->processed){                    
                            $user->image = $image->file_dst_name;                    
                            $prod = $user->updateIMG();
                        }
                    }else{
                        $user->updateAMD(); 
                    }
                }else{
                    $user->updateAMD(); 
                }
            }
			Core::alert("Exito...!!!!", "Se guardo su registro", "error", "rrping.lista");
        }else{
            Core::alert("Corrija...!!!!", $errores, "error");
        }
    }else{
        $id_person = 0;
        $foto = 'assets/images/avatar/user00.png';

        $person = (object) [
           "idcompany" => $_SESSION['id_company'],
           "idcard"=>"", //$_SESSION['id_card']
           "image"=>"assets/images/avatar/user00.png",
           "name"=>"",
           "cargo"=>"",
           "hijos"=>"",
           "tiene_carnet"=>"0",
           "tiene_afis"=>"0",
           "sueldo"=>0,
           "startwork"=>"0000-00-00",
           "endwork"=>"0000-00-00",
           "email"=>"",
           "copiacedula"=>"0",
           "genero"=>"1",
           "direccion"=>"",
           "lugarnacimiento"=>"",
           "fechanacimiento"=>NULL,
           "tipo_vivienda"=>"2",
           "especifique"=>"","0",
           "planilla"=>"0",
           "contrato"=>"0",
           "croquis"=>"0",
           "phone1"=>"",
           "phone2"=>"",
           "bachiller"=>"0",
           "especializacion1"=>"",
           "esc_tecnico"=>"0",
           "especializacion2"=>"",
           "computadora"=>"0",
           "celulartactil"=>"0",
           "curso_realizado"=>"",
           "certificados"=>"0",
           "tipo_contrato"=>"",
           "banco"=>"0",
           "tipo"=>"0",
           "cuenta"=>"",
           "tipo_pago"=>"B",
           "recibe"=>"1",
           "inscrito_curso"=>"0",
           "termino_curso"=>"0",
           "copia_ministerio"=>"0",
           "copia_afis"=>"0",
           "premilitar"=>"0",
           "militar"=>"0",
           "carrera_militar"=>"0",
           "copia_militar"=>"0",
           "uso_arma"=>"0",
           "nombre_curso"=>"",
           "copia_curso"=>"0",
           "licencia"=>"0",
           "tipo_licencia"=>"0",
           "copia_licencia"=>"0",
           "moto"=>"0",
           "marca_moto"=>"",
           "modelo_moto"=>"",
           "color_moto"=>"",
           "placa_moto"=>"",
           "ano_moto"=>"0",
           "vehiculo"=>"0",
           "marca"=>"",
           "modelo"=>"",
           "color"=>"",
           "placa"=>"",
           "ano_vehiculo"=>"0",
           "copia_vehiculo"=>"0",
           "tipo_sangre"=>"0",
           "certificadosangre"=>"0",
           "se_ejercita"=>"0",
           "cuantos_dias"=>"0",
           "especifique_ejercicio"=>"",
           "peso"=>"0",
           "altura"=>"0",
           "tallacamisa"=>"0",
           "tallapantalon"=>"0",
           "tallazapato"=>"0",
           "embarazada"=>"0",
           "lentes"=>"0",
           "sobrepeso"=>"0",
           "presion_alta"=>"0",
           "diabetes"=>"0",
           "rinones"=>"0",
           "colesterol"=>"0",
           "higado"=>"0",
           "alergico"=>"0", // 3
           "especifique_alergico"=>"",
           "medicamento"=>"0",
           "especifique_medicamento"=>"",
           "cirugia"=>"0",
           "especifique_cirugia"=>"",
           "protesis"=>"0",
           "especifique_protesis"=>"",
           "discapacidad"=>"0",
           "tipo_discapacidad"=>"0",
           "conadis"=>"0",
           "porcentaje"=>"0",
           "copia_conadis"=>"0",
           "region"=>"2",
           "decimo"=>0,
           "extencion"=>0,
           "acumula3"=>0,
           "acumula4"=>0,
           "acumular_decimos"=>"1",
           "acumular_cuartos"=>"1",
           "is_empleado"=>"1",
           "is_active" => "1"
        ];
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Personal
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=rrping.lista"><i class="fa fa-database"></i> Personal </a></li>
		<li class="active"> Administrativo </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addpersons" name="addpersons" action="index.php?view=addpersons" role="form">
        <input type="hidden" id="id_person" name="id_person" value="<?php echo $id_person; ?>">
        <div class="callout callout-danger" style="margin-bottom: 0!important;">
            <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
            <h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
            Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
        </div>
        </br>
        <div class="panel panel-default"> 
            <!-- tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_generales" data-toggle="tab" aria-expanded="false"><b>Datos Generales</b></a>
                </li>
                <li>
                    <a href="#tab_fichamedica" data-toggle="tab" aria-expanded="false"><b>Liquidaci&oacute;n</b></a>
                </li>
            </ul>
            <div class="panel-body">
                <!-- tabs content -->
                <div class="tab-content panel">
                    <div class="tab-pane active" id="tab_generales">
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
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Imagen:</label>
                                                    <div class="col-sm-2">
                                                        <input type="file" name="image" id="image" placeholder="">
                                                        <br>
                                                        <img src="<?php echo $person->image;?>" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="cedula" name="cedula" maxlength="10" value="<?php echo $person->idcard; ?>" required title="Solo números. Tamaño obligatorio: 10"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Apellidos yNombre:</label>
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo $person->name; ?>" placeholder="Primer nombre del personal" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,40}" title="Letras y números. Tamaño mínimo: 3. Tamaño máximo: 30"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
                                                    <div class="col-sm-3">
														<select class="select-input form-control input-sm" id="genero" name="genero">
															<option value="1" <?php if($person->genero==1) echo 'selected="selected"'; ?>>Masculino</option>
															<option value="2" <?php if($person->genero==2) echo 'selected="selected"'; ?>>Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Fecha de nacimiento:</label>
                                                    <div class="col-sm-4"><input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo $person->fechanacimiento; ?>" required minlength="10" title="Debe de ser una fecha valida"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Nro. de hijos:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="hijos" name="hijos" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->hijos; ?>" required pattern="[0-9]{1}" title="Solo números"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                        <span class="text-danger">Adjunto la copia a color de c&eacute;dula y certificado de votaci&oacute;n actualizado</span>
                                                        <div class="radiobutton">
                                                        <input type="radio" id="copiacedula" name="copiacedula" value="1" <?php if($person->copiacedula==1) echo 'checked'; ?>> Si
                                                        <input type="radio" id="copiacedula" name="copiacedula" value="0" <?php if($person->copiacedula==0) echo 'checked'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Lugar de nacimiento:</label>
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="lugarnacimiento" maxlength="30" name="lugarnacimiento" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->lugarnacimiento; ?>" required pattern="[A-Za-z- ]{5,40}" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"> Tel&eacute;fono convencial:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono2" name="telefono2" maxlength="10" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $person->phone2; ?>"></div>
                                                </div>
                                                </br>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
														<span class="text-danger">DATOS DE LA VIVIENDA:</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Direcci&oacute;n de domicilio:</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n de su vivienda actual" required><?php echo $person->direccion; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    El tipo de vivienda es:
                                                    <div class="radiobutton">
                                                        <input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="1" <?php if($person->tipo_vivienda==1) echo 'checked'; ?>> Propia &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="2" <?php if($person->tipo_vivienda==2) echo 'checked'; ?>> Alquilada &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="3" <?php if($person->tipo_vivienda==3) echo 'checked'; ?>> De un familiar &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="4" <?php if($person->tipo_vivienda==4) echo 'checked'; ?>> Otro
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>
                                                    <div class="col-sm-10">
														<input type="text" class="form-control" id="especifique" name="especifique" placeholder="Especifique que tipo de vivienda posee" value="<?php echo $person->especifique; ?>">
                                                    </div>
                                                </div>
                                                </br>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
														<span class="text-danger">OBSERVACIONES:</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">Adjunto el croquis y foto de la vivienda</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="croquis" name="croquis" value="1" <?php if($person->croquis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="croquis" name="croquis" value="0" <?php if($person->croquis==0) echo 'checked'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">Adjunto la planilla de servicios b&aacute;sicos de la vivienda</span>
                                                    <div class="radiobutton">
                                                        <input type="radio" id="planilla" name="planilla" value="1" <?php if($person->planilla==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                        <input type="radio" id="planilla" name="planilla" value="0" <?php if($person->planilla==0) echo 'checked'; ?>> No
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
														<span class="text-danger">De ser una casa alquilada, adjunto el contrato de alquiler?</span>
														<div class="radiobutton">
															<input type="radio" id="contrato" name="contrato" value="1" <?php if($person->contrato==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
															<input type="radio" id="contrato" name="contrato" value="2" <?php if($person->contrato==2) echo 'checked'; ?>> No &nbsp;&nbsp;
															<input type="radio" id="contrato" name="contrato" value="0" <?php if($person->contrato==0) echo 'checked'; ?>> No Procede
														</div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-6">
                                                        <span class="text-danger">Esta activo el empleado?</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="is_active" name="is_active" value="1" <?php if($person->is_active==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="is_active" name="is_active" value="0" <?php if($person->is_active==0) echo 'checked'; ?>> No
                                                        </div>
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
                                            <h3 class="panel-title"><i class="mr5"></i>Datos Laborales</h3>
                                        </div>
                                        <div class="panel-collapse pull out">
                                            <div class="panel-body">
												<div class="form-group">
													<label class="col-md-4 col-sm-3 control-label">Oficina:</label>
													<div class="col-md-8 col-sm-4">
														<select class="select-input form-control input-sm" id="cmb_idpuesto" name="cmb_idpuesto">
														<option value="0"> -- Seleccionar -- </option>
														<?php
															foreach($puesto as $puestos):?>
															<option value="<?php echo $puestos->id; ?>" <?php if($puestos->id==1) echo 'selected="selected"'; ?>><?php echo utf8_encode($puestos->descripcion);?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>												
												<div class="form-group">
													<label class="col-md-4 col-sm-3 control-label">Cargo:</label>
													<div class="col-md-8 col-sm-4">
														<select class="select-input form-control input-sm" id="cmb_idcargo" name="cmb_idcargo" required>
														<option value=""> -- Seleccionar -- </option>
														<?php
															foreach($cargos as $cargo):?>
																<option value="<?php echo $cargo->id; ?>" <?php if($cargo->id==$person->cargo) echo 'selected="selected"'; ?>><?php echo strtoupper($cargo->description);?></option>
														<?php endforeach; ?>
														</select>
													</div>
												</div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-sm-4 control-label">Fecha Ingreso:</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="date" class="form-control" id="startwork" name="startwork" value="<?php echo $person->startwork; ?>" required minlength="10" title="Debe de ser una fecha valida">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="col-md-4 col-sm-4 control-label">Fechas Egreso:</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input type="date" class="form-control" id="endwork" name="endwork" value="<?php echo $person->endwork; ?>" minlength="10" title="Debe de ser una fecha valida">
                                                </div>
                                                </div>
                                                <div class="form-group">
													<label class="col-md-4 col-sm-4 control-label">Tipo Contrato:</label>
													<div class="col-md-6 col-sm-6">
														<select class="select-input form-control input-sm" id="tipo_contrato" name="tipo_contrato">
															<option value="" selected="selected">-- SELECCIONAR --</option>
															<option value="CA" <?php if($person->tipo_contrato=="CA") echo 'selected="selected"'; ?>>Indefinido</option>
															<option value="CT" <?php if($person->tipo_contrato=="CT") echo 'selected="selected"'; ?>>Temporal</option>
															<option value="SP" <?php if($person->tipo_contrato=="SP") echo 'selected="selected"'; ?>>Servicios Prestados</option>
															<option value="OC" <?php if($person->tipo_contrato=="OC") echo 'selected="selected"'; ?>>Obra Cierta</option>
															<option value="TP" <?php if($person->tipo_contrato=="TP") echo 'selected="selected"'; ?>>Tarea Período</option>
														</select>
													</div>
                                                </div>
                                                <div class="form-group">
													<label class="col-md-4 col-sm-4 control-label">Sueldo:</label>
													<div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="sueldo" maxlength="40" name="sueldo" size="30" type="text" placeholder="Titulo de especializaci&oacute;n" value="<?php echo $person->sueldo; ?>" required></div>
                                                </div>		
												<div class="form-group">
													<label class="col-md-6 col-sm-6 control-label">Acumular Décimo Tercera Remuneración: </label>
													<div class="col-md-1 col-sm-1">
														<label for="id_acumular_decimo3">
															<input id="id_acumular_decimo3" name="acumular_decimo3" type="checkbox" <?php if($person->acumula3 == 1) echo "checked"; else echo ""; ?>>
														</label>
													</div>                                            
												</div>
												<div class="form-group">
													<label class="col-md-6 col-sm-6 control-label">Acumular Décimo Cuarta Remuneración: </label>
													<div class="col-md-1 col-sm-1">
														<label for="id_acumular_decimo4">
															<input id="id_acumular_decimo4" name="acumular_decimo4" type="checkbox" <?php if($person->acumula4 == 1) echo "checked"; else echo ""; ?>>
														</label>
													</div>                                            
												</div>
												<div class="form-group">
													<label class="col-md-4 col-sm-4 control-label">Fondos de reserva:</label>
													<div class="col-md-6 col-sm-6">
														<label for="id_acumular_fondosreserva_0"><input id="id_acumular_fondosreserva_0" name="acumular_fondosreserva" type="radio" value="1" <?php if($person->decimo==1) echo 'checked'; ?>> Pagar desde el Año </label>
														<label for="id_acumular_fondosreserva_1"><input id="id_acumular_fondosreserva_1" name="acumular_fondosreserva" type="radio" value="2" <?php if($person->decimo==2) echo 'checked'; ?>> Pagar desde el Ingreso </label>
														<label for="id_acumular_fondosreserva_2"><input id="id_acumular_fondosreserva_2" name="acumular_fondosreserva" type="radio" value="3" <?php if($person->decimo==3) echo 'checked'; ?>> Acumular</label>
													</div>
												</div> 
                                                <div class="form-group">
													<div class="col-sm-10">
														<span class="text-danger">Recibe pago de la quincena</span>
														<div class="radiobutton">
															<input type="radio" id="recibe" name="recibe" value="1" <?php if($person->recibe==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
															<input type="radio" id="recibe" name="recibe" value="0" <?php if($person->recibe==0) echo 'checked'; ?>> No
														</div>
													</div>
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
                                                        <label class="col-sm-8 control-label">Tiene titulo de bachiller?</label>
                                                        <div class="col-md-4">
                                                            <div class="radiobutton">
                                                                <input type="radio" id="bachiller" name="bachiller" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                <input type="radio" id="bachiller" name="bachiller" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Especializaci&oacute;n:</label>
                                                    <div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="especializacion1" maxlength="40" name="especializacion1" size="30" type="text" placeholder="Titulo de especializaci&oacute;n" value="<?php echo $person->especializacion1; ?>"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-15">
                                                        <label class="col-sm-8 control-label">Tiene estudios t&eacute;cnicos y/o de 3er. Nivel?</label>
                                                        <div class="col-md-4">
                                                            <div class="radiobutton">
                                                                <input type="radio" id="esc_tecnico" name="esc_tecnico" value="1" <?php if($person->esc_tecnico==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                <input type="radio" id="esc_tecnico" name="esc_tecnico" value="0" <?php if($person->esc_tecnico==0) echo 'checked'; ?>> No
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Especializaci&oacute;n:</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input class="form-control input-sm" id="especializacion2" maxlength="40" name="especializacion2" size="30" type="text" placeholder="Titulo de especializaci&oacute;n" value="<?php echo $person->especializacion2; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-15">
                                                        <label class="col-sm-8 control-label">Sabe utilizar la computadora?</label>
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
                                                        <label class="col-sm-8 control-label">Sabe utilizar celular tactil?</label>
                                                        <div class="col-md-4">
                                                            <div class="radiobutton">
                                                                <input type="radio" id="celulartactil" name="celulartactil" value="1" <?php if($person->celulartactil==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                                <input type="radio" id="celulartactil" name="celulartactil" value="0" <?php if($person->celulartactil==0) echo 'checked'; ?>> No
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Cursos realizados:</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="curso_realizado" name="curso_realizado" placeholder="Especifique los cursos realizados"><?php echo $person->curso_realizado; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <span class="text-danger">Adjunto copia de certificados y capacitaciones</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="certificados" name="certificados" value="1" <?php if($person->certificados==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="certificados" name="certificados" value="2" <?php if($person->certificados==2) echo 'checked'; ?>> No &nbsp;&nbsp;
                                                            <input type="radio" id="certificados" name="certificados" value="0" <?php if($person->certificados==0) echo 'checked'; ?>> No procede
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--/ Nivel de educacion -->
                            <!-- Datos Bancarios -->
                            <div class="col-md-7 ajuste_div_datos_bancarios" style="display: none;"></div>
                            <div class="col-md-5">
                                <div id="datos_bancarios" class="" style="display: block;">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="mr5"></i>Datos Bancarios</h3>
                                        </div>
                                        <div class="panel-collapse pull out">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Banco:</label>
                                                    <div class="col-md-6 col-sm-6">
                                                    <select class="form-control input-sm" id="banco" name="banco" tabindex="-1" title="">
                                                        <option value="0"> -- Seleccionar -- </option>
                                                        <?php
                                                            foreach($bancos as $banco):?>
                                                                <option value="<?php echo $banco->id; ?>" <?php if($banco->id==$person->banco) echo 'selected="selected"'; ?>><?php echo $banco->description; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tipo Cuenta:</label>
                                                    <div class="col-md-6 col-sm-6">
														<select class="form-control input-sm" id="tipo" name="tipo">
															<option value="0" <?php if($person->tipo==0) echo 'selected="selected"'; ?>> -- Seleccionar -- </option>
															<option value="1" <?php if($person->tipo==1) echo 'selected="selected"'; ?>>Cuenta de Ahorros</option>
															<option value="2" <?php if($person->tipo==2) echo 'selected="selected"'; ?>>Cuenta Corriente</option>
														</select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">N° Cuenta:</label>
                                                    <div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="cuenta" maxlength="40" name="cuenta" size="30" type="text" placeholder="456456456" value="<?php echo $person->cuenta; ?>"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tipo de Pago:</label>
                                                    <div class="col-md-6 col-sm-6">
														<select class="select-input input-sm form-control" id="id_tipo_pago" maxlength="1" name="tipo_pago">
															<option value="D" <?php if($person->tipo_pago=="D") echo 'selected="selected"'; ?>>Deposito</option>
															<option value="B" <?php if($person->tipo_pago=="B") echo 'selected="selected"'; ?>>Cheque</option>
															<option value="T" <?php if($person->tipo_pago=="T") echo 'selected="selected"'; ?>>Transferencia</option>
														</select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Datos Bancarios -->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
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
    document.title = "Near Solution | Registro del Personal";
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
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