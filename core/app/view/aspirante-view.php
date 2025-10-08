<?php
//Ingreso de Guardias
$cargos = CargoData::getAll();
$puesto = PuestoData::getAll(2);
$bancos = BancoData::getAll();

$hoy = date("Y-m-d H:i:s");

if(isset($_GET['id'])){
    $mensaje = "modificar un usuario del sistema";
    $enlaces = "Modificar";
    $person = PersonData::getById($_GET['id']);

    if($person->firma == ""){
        $nombre_fichero1 = 'storage/persons/logo-Cipol-color.png';
    }else{
        $nombre_fichero1 = "storage/fotos/".$person->firma; $fotos1 = 1;
    } 
    if($person->cedula1 == ""){
        $nombre_fichero2 = 'storage/persons/logo-Cipol-color.png';
    }else{
        $nombre_fichero2 = "storage/fotos/".$person->cedula1; $fotos2 = 1;
    }    
    if($person->cedula2 == ""){
        $nombre_fichero3 = 'storage/persons/logo-Cipol-color.png';
    }else{    
        $nombre_fichero3 = "storage/fotos/".$person->cedula2; $fotos3 = 1;
    }    
    if($person->votacion == ""){
        $nombre_fichero4 = 'storage/persons/logo-Cipol-color.png';
    }else{    
        $nombre_fichero4 = "storage/fotos/".$person->votacion; $fotos4 = 1;
    }    
    if($person->vivienda == ""){
        $nombre_fichero5 = 'storage/persons/logo-Cipol-color.png';
    }else{
        $nombre_fichero5 = "storage/fotos/".$person->vivienda; $fotos5 = 1;
    }
    if($person->carnet == ""){
        $nombre_fichero6 = 'storage/persons/logo-Cipol-color.png';
    }else{
        $nombre_fichero6 = "storage/fotos/".$person->carnet; $fotos6 = 1;
    }         
    
    $id_person = $_GET['id'];
}else{
    $mensaje = "crear un nuevo usuario del sistema";
    $enlaces = "Crear";
    $id_person = 0;

    if(count($_POST)>0){
        $errores = "";

        if($_POST["id_person"] == 0){
            if(is_object(PersonData::getLike("idcard", $_POST["cedula"]))){
                $errores .= "- Cedula repetida";
            }
        }

        $acumular3 = 0; $acumular4 = 0;
        if(isset($_POST["acumular_decimo3"])) $acumular3 = 1; else $acumular3 = 0;		
        if(isset($_POST["acumular_decimo4"])) $acumular4 = 1; else $acumular4 = 0;

        $person = (object) [
           "idcard" => $_POST["cedula"],
           "image"=> (is_null($_POST["image"]) ? "store/persons/".$_POST["image"]: "assets/images/avatar/user00.png"), 
           "cargo" => 7,
           "startwork" => $_POST["startwork"],
           "endwork" => $_POST["endwork"],
           "name" => strtoupper($_POST["nombre_uno"]),
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
           "tipo_contrato" => $_POST["tipo_contrato"],
           "sueldo" => $_POST["sueldo"],
           "bachiller" => $_POST["bachiller"],
           "especializacion1" => $_POST["especializacion1"],
           "esc_tecnico" => $_POST["esc_tecnico"],
           "especializacion2" => $_POST["especializacion2"],
           "computadora" => $_POST["computadora"],
           "celulartactil" => $_POST["celulartactil"],
           "curso_realizado" => $_POST["curso_realizado"],
           "certificados" => $_POST["certificados"],
           "banco" => $_POST["banco"],
           "cuenta" => $_POST["cuenta"],
           "tipo" => $_POST["tipo"],
           "tipo_pago" => $_POST["tipo_pago"],
           "recibe" => $_POST["recibe"],
           "tipo_sangre" => $_POST["tipo_sangre"],
           "certificadosangre" => $_POST["certificadosangre"],
           "peso" => (int) $_POST["peso"],
           "altura" => (int) $_POST["altura"],
           "tallacamisa" => (int) $_POST["tallacamisa"],
           "tallapantalon" => (int) $_POST["tallapantalon"],
           "tallazapato" => (int) $_POST["tallazapato"],
           "se_ejercita" => (int) $_POST["se_ejercita"],
           "cuantos_dias" => (int) $_POST["cuantos_dias"],
           "especifique_ejercicio" => $_POST["especifique_ejercicio"],
           "embarazada" => $_POST["embarazada"],
           "lentes" => $_POST["lentes"],
           "sobrepeso" => $_POST["sobrepeso"],
           "presion_alta" => $_POST["presion_alta"],
           "diabetes" => $_POST["diabetes"],
           "rinones" => $_POST["rinones"],
           "colesterol" => $_POST["colesterol"],
           "higado" => $_POST["higado"],
           "alergico" => $_POST["alergico"],
           "especifique_alergico" => $_POST["especifique_alergico"],
           "medicamento" => $_POST["medicamento"],
           "especifique_medicamento" => $_POST["especifique_medicamento"],
           "cirugia" => $_POST["cirugia"],
           "especifique_cirugia" => $_POST["especifique_cirugia"],
           "protesis" => $_POST["protesis"],
           "especifique_protesis" => $_POST["especifique_protesis"],
           "discapacidad" => $_POST["discapacidad"],
           "tipo_discapacidad" => $_POST["tipo_discapacidad"],
           "conadis" => $_POST["conadis"],
           "porcentaje" => (int) $_POST["porcentaje"],
           "copia_conadis" => $_POST["copia_conadis"],
           "licencia" => $_POST["licencia"],
           "tipo_licencia" => $_POST["tipo_licencia"],
           "copia_licencia" => $_POST["copia_licencia"],
           "moto" => $_POST["moto"],
           "marca_moto" => $_POST["marca_moto"],
           "modelo_moto" => $_POST["modelo_moto"],
           "color_moto" => $_POST["color_moto"],
           "placa_moto" => $_POST["placa_moto"],
           "ano_moto" => $_POST["ano_moto"],
           "vehiculo" => $_POST["vehiculo"],
           "marca" => $_POST["marca"],
           "modelo" => $_POST["modelo"],
           "color" => $_POST["color"],
           "placa" => $_POST["placa"],
           "ano_vehiculo" => $_POST["ano_vehiculo"],
           "copia_vehiculo" => $_POST["copia_vehiculo"],           
           "inscrito_curso"=> $_POST["inscrito_curso"],
           "termino_curso"=> $_POST["termino_curso"],
           "tiene_carnet"=> $_POST["tiene_carnet"],
           "copia_ministerio"=> $_POST["copia_ministerio"],
           "tiene_afis"=> $_POST["tiene_afis"],
           "copia_afis"=> $_POST["copia_afis"],
           "premilitar"=> $_POST["premilitar"],
           "militar"=> $_POST["militar"],
           "carrera_militar"=> $_POST["carrera_militar"],
           "copia_militar"=> $_POST["copia_militar"],
           "uso_arma"=> $_POST["uso_arma"],
           "nombre_curso"=> $_POST["nombre_curso"],
           "copia_curso"=> $_POST["copia_curso"],
           "recibo" => 0,
           "completo" => 0,
           "decimo" => 0,
           "region" => 2,
           "extencion" => 0,
           "acumula3" => $acumular3,		   
           "acumula4" => $acumular4,
           "is_active" => $_POST["is_active"]
        ];

        if($errores == ''){
            $user = new PersonData();

            $user->company = $_SESSION['id_company'];
            $user->id = $_POST["id_person"];
            $user->idcard = $_POST["cedula"];
            $user->cargo = 7;
            $user->name = strtoupper($_POST["nombre_uno"]);
            $user->genero = $_POST["genero"];
            $user->hijos = $_POST["hijos"];
            $user->copiacedula = $_POST["copiacedula"];
            $user->fechanacimiento = $_POST["fechanacimiento"];
            $user->lugarnacimiento = strtoupper($_POST["lugarnacimiento"]);
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
            $user->tipo_sangre = $_POST["tipo_sangre"];
            $user->certificadosangre = $_POST["certificadosangre"];
            $user->peso = (int) $_POST["peso"];
            $user->altura = (int) $_POST["altura"];
            $user->tallacamisa = (int) $_POST["tallacamisa"];
            $user->tallapantalon = (int) $_POST["tallapantalon"];
            $user->tallazapato = (int) $_POST["tallazapato"];
            $user->se_ejercita = (int) $_POST["se_ejercita"];
            $user->cuantos_dias = (int) $_POST["cuantos_dias"];
            $user->especifique_ejercicio = $_POST["especifique_ejercicio"];
            $user->embarazada = $_POST["embarazada"];
            $user->lentes = $_POST["lentes"];
            $user->sobrepeso = $_POST["sobrepeso"];
            $user->presion_alta = $_POST["presion_alta"];
            $user->diabetes = $_POST["diabetes"];
            $user->rinones = $_POST["rinones"];
            $user->colesterol = $_POST["colesterol"];
            $user->higado = $_POST["higado"];
            $user->alergico = $_POST["alergico"];
            $user->especifique_alergico = $_POST["especifique_alergico"];
            $user->medicamento = $_POST["medicamento"];
            $user->especifique_medicamento = $_POST["especifique_medicamento"];
            $user->cirugia = $_POST["cirugia"];
            $user->especifique_cirugia = $_POST["especifique_cirugia"];
            $user->protesis = $_POST["protesis"];
            $user->especifique_protesis = $_POST["especifique_protesis"];
            $user->discapacidad = $_POST["discapacidad"];
            $user->tipo_discapacidad = $_POST["tipo_discapacidad"];
            $user->conadis = $_POST["conadis"];
            $user->porcentaje = (int) $_POST["porcentaje"];
            $user->copia_conadis = $_POST["copia_conadis"];
            $user->licencia = $_POST["licencia"];
            $user->tipo_licencia = $_POST["tipo_licencia"];
            $user->copia_licencia = $_POST["copia_licencia"];
            $user->moto = $_POST["moto"];
            $user->marca_moto = $_POST["marca_moto"];
            $user->modelo_moto = $_POST["modelo_moto"];
            $user->color_moto = $_POST["color_moto"];
            $user->placa_moto = $_POST["placa_moto"];
            $user->ano_moto = $_POST["ano_moto"];
            $user->vehiculo = $_POST["vehiculo"];
            $user->marca = $_POST["marca"];
            $user->modelo = $_POST["modelo"];
            $user->color = $_POST["color"];
            $user->placa = $_POST["placa"];
            $user->ano_vehiculo = $_POST["ano_vehiculo"];
            $user->copia_vehiculo = $_POST["copia_vehiculo"];
            $user->inscrito_curso = $_POST["inscrito_curso"];
            $user->copia_curso = $_POST["copia_curso"];
            $user->termino_curso = $_POST["termino_curso"];
            $user->tiene_carnet = $_POST["tiene_carnet"];
            $user->copia_ministerio = $_POST["copia_ministerio"];
            $user->tiene_afis = $_POST["tiene_afis"];
            $user->copia_afis = $_POST["copia_afis"];
            $user->premilitar = $_POST["premilitar"];
            $user->militar = $_POST["militar"];
            $user->carrera_militar = $_POST["carrera_militar"];
            $user->copia_militar = $_POST["copia_militar"];
            $user->uso_arma = $_POST["uso_arma"];
            $user->nombre_curso = $_POST["nombre_curso"];
            $user->recibo = 0;
            $user->completo = 0;            
            $user->decimo = 0; 
            $user->acumula3 = $acumular3; 
            $user->acumula4 = $acumular4; 
            $user->is_active = $_POST["is_active"];

            if($_POST["id_person"] == 0) { 
                if(isset($_FILES["image"])){
                    $image = new Upload($_FILES["image"]);

                    if($image->uploaded){
                        $image->Process("storage/persons/");

                        if($image->processed){        
                            $user->image = $image->file_dst_name;                    
                            $prod = $user->addIMG();
                        }
                    }
                }else{
                    $user->add();
                }
            }else{				
                if(isset($_FILES["image"]["name"])){
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
                    $prod = $user->updateAMD();
                }
            }

            Core::redir("rrging.lista");
        }else{
            Core::alert("Corrija...!!!!", $errores, "error");
        }
    }else{
        $id_person = 0;

        $person = (object) [
           "idcompany" => $_SESSION['id_company'],
           "idcard"=>"",
           "image"=>"assets/images/avatar/user00.png",
           "name"=>"",
           "cargo"=>7,
           "hijos"=>0,
           "tiene_carnet"=>"0",
           "tiene_afis"=>"0",
           "sueldo"=>0,
           "startwork"=>null,
           "endwork"=>null,
           "email"=>"",
           "copiacedula"=>"0",
           "genero"=>"1",
           "direccion"=>"",
           "lugarnacimiento"=>"",
           "fechanacimiento"=>null,
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
           "recibe"=>"0",
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
           "alergico"=>"0",
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
           "inscrito_curso"=>"0",
           "termino_curso"=>"0",
           "tiene_carnet"=>"0",
           "copia_ministerio"=>"0",
           "tiene_afis"=>"0",
           "copia_afis"=>"0",
           "premilitar"=>"0",
           "militar"=>"0",
           "carrera_militar"=>"0",
           "copia_militar"=>"0",
           "uso_arma"=>"0",
           "nombre_curso"=>null,
           "copia_curso"=>"0",
           "porcentaje"=>"0",
           "copia_conadis"=>"0",
           "region"=>"2",
           "decimo"=>3,
           "extencion"=>0,
           "acumula3"=>0,
           "acumula4"=>0,
           "acumular_decimos"=>"1",
           "acumular_cuartos"=>"1",
           "is_active"=>"1"
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
		<li><a href="./index.php?view=rrging.lista"><i class="fa fa-database"></i> Personal </a></li>
		<li class="active"> Operativo </li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
    <!-- Dialogo para seleccionar una cuenta -->
    <form class="form-horizontal" method="post" id="addagente" action="index.php?view=rrging.persons" role="form">
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
                    <a href="#tab_informacionfisica" data-toggle="tab" aria-expanded="false"><b>Ficha M&eacute;dica</b></a>
                </li>
                <li>
                    <a href="#tab_documentos" data-toggle="tab" aria-expanded="false"><b>Documentacion</b></a>
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
                                                        <img src="storage/persons/<?php echo $person->image;?>" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="cedula" name="cedula" maxlength="10" value="<?php echo $person->idcard; ?>" required title="Solo números. Tamaño obligatorio: 10"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Apellidos y Nombres:</label>
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo $person->name; ?>" placeholder="Nombres del personal" required title="Letras y números. Tamaño mínimo: 3. Tamaño máximo: 30"></div>
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
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Cargas personales:</label>
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
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="lugarnacimiento" maxlength="30" name="lugarnacimiento" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->lugarnacimiento; ?>" required title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
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
                                                    <div class="col-sm-6">
                                                        <span class="text-danger">Es un agente de seguridad?</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="kind" name="kind" value="1" <?php if($person->kind==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="kind" name="kind" value="0" <?php if($person->kind==0) echo 'checked'; ?>> No&nbsp;&nbsp;
                                                            <input type="radio" id="kind" name="kind" value="2" <?php if($person->kind==0) echo 'checked'; ?>> Eventual
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
                                                    <label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha Ingreso:</label>
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
													<div class="col-md-6 col-sm-6">
														<input class="form-control input-sm" id="sueldo" maxlength="40" name="sueldo" size="30" type="text" placeholder="Titulo de especializaci&oacute;n" value="<?php echo $person->sueldo; ?>">
													</div>
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
														<label for="id_acumular_fondosreserva"><input id="acumular_fondosreserva" name="acumular_fondosreserva" type="radio" value="1" <?php if($person->decimo==1) echo 'checked'; ?>> Pagar desde el Año </label>
														<label for="id_acumular_fondosreserva"><input id="acumular_fondosreserva" name="acumular_fondosreserva" type="radio" value="2" <?php if($person->decimo==2) echo 'checked'; ?>> Pagar desde el Ingreso </label>
														<label for="id_acumular_fondosreserva"><input id="acumular_fondosreserva" name="acumular_fondosreserva" type="radio" value="3" <?php if($person->decimo==3) echo 'checked'; ?>> Acumular</label>
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
                                                                foreach($bancos as $banco): ?>
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
                            </div> <!--/ Datos Bancarios -->
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_informacionfisica">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="panel panel-default">
                                    <!-- panel heading/header -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Datos Personales</h3>
                                    </div>
                                    <!--/ panel heading/header -->
                                    <!-- panel body with collapse capable -->
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
                                            <div class="" id="fisicos">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tipo de Sangre:</label>
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
                                                <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">Adjunto el certificado de Tipo de Sangre de la Cruz Roja</span>
                                                    <div class="radiobutton">
                                                        <input type="radio" id="certificadosangre" name="certificadosangre" value="1" <?php if($person->certificadosangre==1) echo 'checked'; ?>> Si
                                                        <input type="radio" id="certificadosangre" name="certificadosangre" value="0" <?php if($person->certificadosangre==0) echo 'checked'; ?>> No
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Peso en libras:</label>
                                                    <div class="col-sm-2"><input type="text" class="form-control" id="peso" name="peso" value="<?php echo $person->peso; ?>" title="Solo números. Tamaño obligatorio: 3"></div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Altura en centimetros:</label>

                                                    <div class="col-sm-2"><input type="text" class="form-control" id="altura" name="altura" data-inputmask='"mask": "999"' data-mask placeholder="999" value="<?php echo $person->altura; ?>" title="Solo números. Tamaño obligatorio: 3"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Talla de camisa:</label>

                                                    <div class="col-sm-2"><input type="text" class="form-control" id="tallacamisa" name="tallacamisa" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->tallacamisa; ?>" title="Solo números. Tamaño obligatorio: 2"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Talla de pantal&oacute;n:</label>

                                                    <div class="col-sm-2"><input type="text" class="form-control" id="tallapantalon" name="tallapantalon" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->tallapantalon; ?>" title="Solo números. Tamaño obligatorio: 2"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Talla de zapatos:</label>

                                                    <div class="col-sm-2">

                                                        <input type="text" class="form-control" id="tallazapato" name="tallazapato" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->tallazapato; ?>" title="Solo números. Tamaño obligatorio: 2">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Se ejercita regularmente?</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="se_ejercita" name="se_ejercita" value="1" <?php if($person->se_ejercita==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="se_ejercita" name="se_ejercita" value="0" <?php if($person->se_ejercita==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"> Cuantos dias se ejercita a la semana:</label>

                                                    <div class="col-sm-2">

                                                                <input type="text" class="form-control" id="cuantos_dias" name="cuantos_dias" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->cuantos_dias; ?>" title="Solo números">

                                                            </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"> Que tipo de ejercicio realiza:</label>

                                                    <div class="col-sm-8">

                                                        <textarea class="form-control" id="especifique_ejercicio" name="especifique_ejercicio" placeholder="Correr"><?php echo $person->especifique_ejercicio; ?></textarea>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Esta embarazada?</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="embarazada" name="embarazada" value="1" <?php if($person->embarazada==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="embarazada" name="embarazada" value="0" <?php if($person->embarazada==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Usa lentes:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="lentes" name="lentes" value="1" <?php if($person->lentes==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="lentes" name="lentes" value="0" <?php if($person->lentes==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene sobrepeso:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="sobrepeso" name="sobrepeso" value="1" <?php if($person->sobrepeso==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="sobrepeso" name="sobrepeso" value="0" <?php if($person->sobrepeso==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Sufre de presi&oacute;n alta:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="presion_alta" name="presion_alta" value="1" <?php if($person->presion_alta==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="presion_alta" name="presion_alta" value="0" <?php if($person->presion_alta==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene diabetes:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="diabetes" name="diabetes" value="1" <?php if($person->diabetes==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="diabetes" name="diabetes" value="0" <?php if($person->diabetes==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene problema en ri&ntilde;ones:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="rinones" name="rinones" value="1" <?php if($person->rinones==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="rinones" name="rinones" value="0" <?php if($person->rinones==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Colesterol/trigicelidos alto?</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="colesterol" name="colesterol" value="1" <?php if($person->colesterol==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="colesterol" name="colesterol" value="0" <?php if($person->colesterol==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Problemas de higado:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="higado" name="higado" value="1" <?php if($person->higado==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="higado" name="higado" value="0" <?php if($person->higado==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Es alergico alg&uacute;n alimento:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="alergico" name="alergico" value="1" <?php if($person->alergico==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="alergico" name="alergico" value="0" <?php if($person->alergico==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>

                                                    <div class="col-sm-10">

                                                        <input type="text" class="form-control" id="especifique_alergico" name="especifique_alergico" placeholder="Especifique a que alimento es alergico" value="<?php echo $person->especifique_alergico; ?>">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Alergico alg&uacute;n medicamento:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="medicamento" name="medicamento" value="1" <?php if($person->medicamento==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="medicamento" name="medicamento" value="0" <?php if($person->medicamento==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>

                                                    <div class="col-sm-10">

                                                        <input type="text" class="form-control" id="especifique_medicamento" name="especifique_medicamento" placeholder="Especifique a que medicamento es alergico" value="<?php echo $person->especifique_medicamento; ?>">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">A tenido cirugias?</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="cirugia" name="cirugia" value="1" <?php if($person->cirugia==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="cirugia" name="cirugia" value="0" <?php if($person->cirugia==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>

                                                    <div class="col-sm-10">

                                                        <input type="text" class="form-control" id="especifique_cirugia" name="especifique_cirugia" placeholder="Especifique que tipo de cirugia realizada" value="<?php echo $person->especifique_cirugia; ?>">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene pr&oacute;tesis:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="protesis" name="protesis" value="1" <?php if($person->protesis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="protesis" name="protesis" value="0" <?php if($person->protesis==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>

                                                    <div class="col-sm-10">

                                                        <input type="text" class="form-control" id="especifique_protesis" name="especifique_protesis" placeholder="Especifique que tipo de protesis posee" value="<?php echo $person->especifique_protesis; ?>">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene alguna discapacidad:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="discapacidad" name="discapacidad" value="1" <?php if($person->discapacidad==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="discapacidad" name="discapacidad" value="0" <?php if($person->discapacidad==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tipo de discapacidad:</label>

                                                    <div class="col-sm-3">

                                                        <select class="select-input form-control input-sm" id="tipo_discapacidad" name="tipo_discapacidad">

                                                        <option value="0" <?php if($person->tipo_discapacidad==0) echo 'selected="selected"'; ?>>Seleccione</option>

                                                        <option value="1" <?php if($person->tipo_discapacidad==1) echo 'selected="selected"'; ?>>Fisica</option>

                                                        <option value="2" <?php if($person->tipo_discapacidad==2) echo 'selected="selected"'; ?>>Intelectual</option>

                                                        <option value="3" <?php if($person->tipo_discapacidad==3) echo 'selected="selected"'; ?>>Auditiva</option>

                                                        <option value="4" <?php if($person->tipo_discapacidad==4) echo 'selected="selected"'; ?>>Visual</option>

                                                        <option value="5" <?php if($person->tipo_discapacidad==5) echo 'selected="selected"'; ?>>Psicosocial</option>

                                                        <option value="6" <?php if($person->tipo_discapacidad==6) echo 'selected="selected"'; ?>>Visual</option>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Tiene carnet discapacidad:</label>

                                                    <div class="col-md-5 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="conadis" name="conadis" value="1" <?php if($person->conadis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="conadis" name="conadis" value="0" <?php if($person->conadis==0) echo 'checked'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> % de discapacidad:</label>

                                                    <div class="col-sm-2">

                                                        <input type="text" class="form-control" id="porcentaje" name="porcentaje" data-inputmask='"mask": "999"' data-mask placeholder="999" value="<?php echo $person->porcentaje; ?>">

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-10">

                                                        <span class="text-danger">Adjunto copia de carnet de CONADIS</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_conadis" name="copia_conadis" value="1" <?php if($person->copia_conadis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_conadis" name="copia_conadis" value="2" <?php if($person->copia_conadis==2) echo 'checked'; ?>> No &nbsp;&nbsp;

                                                            <input type="radio" id="copia_conadis" name="copia_conadis" value="0" <?php if($person->copia_conadis==0) echo 'checked'; ?>> No Procede

                                                        </div>

                                                    </div>

                                                </div>

                                                </br>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- Informacion personal Operativo -->
                            <div class="col-md-5">
                                <div id="personalizados_proveedor">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="mr5"></i>Personal Operativo</h3>
                                        </div>
                                        <div class="panel-collapse pull out">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Se ha inscrito en el curso?</label>
                                                    <div class="col-md-4 col-sm-5">
                                                        <div class="radiobutton">
                                                            <input type="radio" id="inscrito_curso" name="inscrito_curso" value="1" <?php if($person->inscrito_curso==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="inscrito_curso" name="inscrito_curso" value="0" <?php if($person->inscrito_curso==0) echo 'checked="checked"'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Termino el curso?</label>
                                                    <div class="col-md-4 col-sm-5">
                                                        <div class="radiobutton">
                                                            <input type="radio" id="termino_curso" name="termino_curso" value="1" <?php if($person->termino_curso==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="termino_curso" name="termino_curso" value="0" <?php if($person->termino_curso==0) echo 'checked="checked"'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Tiene el carnet del curso?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="tiene_carnet" name="tiene_carnet" value="1" <?php if($person->tiene_carnet==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="tiene_carnet" name="tiene_carnet" value="0" <?php if($person->tiene_carnet==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-12">

                                                        <span class="text-danger">Adjunto la copia del carnet del Ministerio del Interior</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_ministerio" name="copia_ministerio" value="1" <?php if($person->copia_ministerio==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_ministerio" name="copia_ministerio" value="0" <?php if($person->copia_ministerio==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Tiene el certificado AFIS?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="tiene_afis" name="tiene_afis" value="1" <?php if($person->tiene_afis==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="tiene_afis" name="tiene_afis" value="0" <?php if($person->tiene_afis==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-12">

                                                        <span class="text-danger">Adjunto la copia del certificado del AFIS</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_afis" name="copia_afis" value="1" <?php if($person->copia_afis==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_afis" name="copia_afis" value="0" <?php if($person->copia_afis==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Realizo la premilitar?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="premilitar" name="premilitar" value="1" <?php if($person->premilitar==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="premilitar" name="premilitar" value="0" <?php if($person->premilitar==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Realizo el servicio militar?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="militar" name="militar" value="1" <?php if($person->militar==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="militar" name="militar" value="0" <?php if($person->militar==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Ha tenido carrera militar?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="carrera_militar" name="carrera_militar" value="1" <?php if($person->carrera_militar==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="carrera_militar" name="carrera_militar" value="0" <?php if($person->carrera_militar==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-12">

                                                        <span class="text-danger">Adjunto la copia del carnets (Servicio Militar, FFAA, Policia)</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_militar" name="copia_militar" value="1" <?php if($person->copia_militar==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_militar" name="copia_militar" value="0" <?php if($person->copia_militar==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Tiene cursos de uso de armas y/o defensa personal?</label>

                                                    <div class="col-md-4 col-sm-5">

                                                        <div class="radiobutton">

                                                            <input type="radio" id="uso_arma" name="uso_arma" value="1" <?php if($person->uso_arma==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="uso_arma" name="uso_arma" value="0" <?php if($person->uso_arma==0) echo 'checked="checked"'; ?>> No

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-6 control-label">Nombre del curso:</label>

                                                    <div class="col-sm-6"><input type="text" class="form-control input-sm" id="nombre_curso" name="nombre_curso" maxlength="40" placeholder="Diga el nombre del curso" value="<?php echo $person->nombre_curso; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-12">

                                                        <span class="text-danger">Adjunto certificados (cursos de defensa personal, etc)</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_curso" name="copia_curso" value="1" <?php if($person->copia_curso==1) echo 'checked="checked"'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_curso" name="copia_curso" value="0" <?php if($person->copia_curso==0) echo 'checked="checked"'; ?>> No

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
                            <div class="col-md-5">
                                <div id="referencias_vehiculos">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <h3 class="panel-title"><i class="mr5"></i>Referencias de Vehiculos</h3>

                                        </div>

                                        <div class="panel-collapse pull out">

                                            <div class="panel-body">

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Tiene licencia?</label>

                                                    <div class="col-sm-7">

                                                    <div class="radiobutton">

                                                        <input type="radio" id="licencia" name="licencia" value="1" <?php if($person->licencia==1) echo 'checked'; ?>> Si

                                                        <input type="radio" id="licencia" name="licencia" value="0" <?php if($person->licencia==0) echo 'checked'; ?>> No

                                                    </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Tipo de licencia:</label>

                                                    <div class="col-sm-6">

                                                        <select class="select-input form-control input-sm" id="tipo_licencia" name="tipo_licencia">

                                                        <option value= "0" <?php if($person->tipo_licencia== 0) echo 'selected="selected"'; ?>>Seleccione</option>

                                                        <option value= "1" <?php if($person->tipo_licencia== 1) echo 'selected="selected"'; ?>>A</option>

                                                        <option value= "2" <?php if($person->tipo_licencia== 2) echo 'selected="selected"'; ?>>B</option>

                                                        <option value= "3" <?php if($person->tipo_licencia== 3) echo 'selected="selected"'; ?>>F</option>

                                                        <option value= "4" <?php if($person->tipo_licencia== 4) echo 'selected="selected"'; ?>>A1</option>

                                                        <option value= "5" <?php if($person->tipo_licencia== 5) echo 'selected="selected"'; ?>>C</option>

                                                        <option value= "6" <?php if($person->tipo_licencia== 6) echo 'selected="selected"'; ?>>C1</option>

                                                        <option value= "7" <?php if($person->tipo_licencia== 7) echo 'selected="selected"'; ?>>D</option>

                                                        <option value= "8" <?php if($person->tipo_licencia== 8) echo 'selected="selected"'; ?>>D1</option>

                                                        <option value= "9" <?php if($person->tipo_licencia== 9) echo 'selected="selected"'; ?>>E</option>

                                                        <option value="10" <?php if($person->tipo_licencia==10) echo 'selected="selected"'; ?>>E1</option>

                                                        <option value="11" <?php if($person->tipo_licencia==11) echo 'selected="selected"'; ?>>G</option>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="col-sm-10">

                                                        <span class="text-danger">Adjunto copia de la licencia de conducir</span>

                                                        <div class="radiobutton">

                                                            <input type="radio" id="copia_licencia" name="copia_licencia" value="1" <?php if($person->licencia==1) echo 'checked'; ?>> Si &nbsp;&nbsp;

                                                            <input type="radio" id="copia_licencia" name="copia_licencia" value="2" <?php if($person->licencia==2) echo 'checked'; ?>> No &nbsp;&nbsp;

                                                            <input type="radio" id="copia_licencia" name="copia_licencia" value="0" <?php if($person->licencia==0) echo 'checked'; ?>> No Procede

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Tiene moto?</label>

                                                    <div class="col-sm-7">

                                                    <div class="radiobutton">

                                                        <input type="radio" id="moto" name="moto" value="1" <?php if($person->moto==1) echo 'checked'; ?>> Si

                                                        <input type="radio" id="moto" name="moto" value="0" <?php if($person->moto==0) echo 'checked'; ?>> No

                                                    </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Marca:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="marca_moto" name="marca_moto" maxlength="20" placeholder="Especifique la marca de la moto" value="<?php echo $person->marca_moto; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Modelo:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="modelo_moto" name="modelo_moto" maxlength="20" placeholder="Especifique el modelo de la moto" value="<?php echo $person->modelo_moto; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Color:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="color_moto" name="color_moto" maxlength="20" placeholder="Especifique el color de la moto" value="<?php echo $person->color_moto; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Placa:</label>

                                                    <div class="col-sm-4"><input type="text" class="form-control input-sm" id="placa_moto" name="placa_moto" maxlength="7" placeholder="Nro. de la placa" value="<?php echo $person->placa_moto; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">A&ntilde;o:</label>

                                                    <div class="col-sm-4"><input type="text" class="form-control input-sm" id="ano_moto" name="ano_moto" maxlength="4" placeholder="Nro. de la placa" value="<?php echo $person->ano_moto; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Tiene veh&iacute;culo?</label>

                                                    <div class="col-sm-7">

                                                    <div class="radiobutton">

                                                        <input type="radio" id="vehiculo" name="vehiculo" value="1" <?php if($person->vehiculo==1) echo 'checked'; ?>> Si

                                                        <input type="radio" id="vehiculo" name="vehiculo" value="0" <?php if($person->vehiculo==0) echo 'checked'; ?>> No

                                                    </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Marca:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="marca" name="marca" maxlength="20" placeholder="Especifique la marca del vehiculo" value="<?php echo $person->marca; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Modelo:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="modelo" name="modelo" maxlength="20" placeholder="Especifique el modelo del vehiculo" value="<?php echo $person->modelo; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Color:</label>

                                                    <div class="col-sm-7"><input type="text" class="form-control input-sm" id="color" name="color" maxlength="20" placeholder="Especifique el color del vehiculo" value="<?php echo $person->color; ?>"></div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-sm-5 control-label">Placa:</label>

                                                    <div class="col-sm-4"><input type="text" class="form-control input-sm" id="placa" name="placa" maxlength="8" placeholder="Nro. de la placa" value="<?php echo $person->placa; ?>"></div>

                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">A&ntilde;o:</label>
                                                    <div class="col-sm-4"><input type="text" class="form-control input-sm" id="ano_vehiculo" name="ano_vehiculo" maxlength="4" placeholder="Año del vehiculo" value="<?php echo $person->ano_vehiculo; ?>"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <span class="text-danger">Adjunto copia de la matr&iacute;cula de la moto y/o veh&iacute;culo</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="copia_vehiculo" name="copia_vehiculo" value="1" <?php if($person->copia_vehiculo==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="copia_vehiculo" name="copia_vehiculo" value="2" <?php if($person->copia_vehiculo==2) echo 'checked'; ?>> No &nbsp;&nbsp;
                                                            <input type="radio" id="copia_vehiculo" name="copia_vehiculo" value="0" <?php if($person->copia_vehiculo==0) echo 'checked'; ?>> No Procede
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
                    <div class="tab-pane" id="tab_documentos">                        
                		<div class="row">
                		    <div class="col-md-10">
                                <div class="col-sm-6">
                                    <img class="img-responsive" src="<?php echo $nombre_fichero1; ?>" alt="Photo">                                                                        
                                    <ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-warning margin-r-5"></i> Pedir</a></li>
                                        <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Aprobado</a></li>
                                    </ul>
                                </div>                                
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="<?php echo $nombre_fichero2; ?>" alt="Photo">
                                            <ul class="list-inline">
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-warning margin-r-5"></i> Pedir</a></li>
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Aprobado</a></li>
                                            </ul>
                                            <br>
                                            <img class="img-responsive" src="<?php echo $nombre_fichero3; ?>" alt="Photo">
                                            <ul class="list-inline">
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-warning margin-r-5"></i> Pedir</a></li>
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Aprobado</a></li>
                                            </ul>
                                        </div>                                
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="<?php echo $nombre_fichero4; ?>" alt="Photo">
                                            <ul class="list-inline">
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-warning margin-r-5"></i> Pedir</a></li>
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Aprobado</a></li>
                                            </ul>
                                            <br>
                                            <img class="img-responsive" src="<?php echo $nombre_fichero5; ?>" alt="Photo">
                                            <ul class="list-inline">
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-warning margin-r-5"></i> Pedir</a></li>
                                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Aprobado</a></li>
                                            </ul>
                                        </div>                                
                                    </div>                                
                                </div>
                            </div>
                		</div>
                    </div>
                </div>
                <!-- Boton Guardar -->
                <div class="form-group">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
	document.title = "Near Solution | Registro de los guardias";
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

