<?php
// Ingreso de los NUEVOS aspirantes
$lugars = LugarData::getAll();
$cargos = CargoData::getAll();

$mensaje = "modificar un aspirante del sistema";
$enlaces = "Modificar";

if(isset($_GET['id'])){
    $person = PersonData::getById($_GET['id']);
    
    $falta = 0;
    if($person->image == ""){
        $nombre_fichero1 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{      
        $nombre_fichero1 = "https://cipol.ec/sidai/storage/persons/".$person->image; 
    } 
    if($person->cedula1 == ""){
        $nombre_fichero2 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{
        $nombre_fichero2 = "https://cipol.ec/sidai/storage/documento/".$person->cedula1;
    }    
    if($person->cedula2 == ""){
        $nombre_fichero3 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{    
        $nombre_fichero3 = "https://cipol.ec/sidai/storage/documento/".$person->cedula2; 
    }    
    if($person->votacion == ""){
        $nombre_fichero4 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{    
        $nombre_fichero4 = "https://cipol.ec/sidai/storage/documento/".$person->votacion; 
    }    
    if($person->firma == ""){
        $nombre_fichero5 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{
        $nombre_fichero5 = "https://cipol.ec/sidai/storage/documento/".$person->firma; 
    }
    if($person->carnet == ""){
        $nombre_fichero6 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; $falta++;
    }else{
        $nombre_fichero6 = "https://cipol.ec/sidai/storage/documento/".$person->carnet; 
    }
    
    $id_person = $_GET['id'];
    $_SESSION['person'] = $id_person;
}else{
    if(count($_POST)>0){
        ini_set("upload_max_filesize","600M");
        ini_set("max_execution_time","300");

        if($_POST["id_person"] == 0){
            if(is_object(PersonData::getLike("idcard", $_POST["cedula"]))){
                $errores8 = "- Cedula repetida \r\n";
            }
        }
        
        if($_POST["altura"]=="0") 
            $errores1 = "- No puede dejar altura del aspirante en blanco\r\n";
        else
            $cadena = "";
            
        if(isset($_FILES["image"]) && $_FILES["image"]["name"]=="") 
            $errores1 = "- No puede dejar la foto del aspirante en blanco\r\n";
        else
            $cadena = "";
        
        if(isset($_POST["embarazada"])) $embarazada = 1; else $embarazada = 0;
        $person = (object) [
           "idcard" => $_POST["cedula"],
           "image"=> $cadena,
           "name" => strtoupper($_POST["nombres"]),
           "latitude" => $_POST["latitude"],
           "longitude" => $_POST["longitude"],
           "mensaje" => $_POST["mensaje"],
           "idlugar" => $_POST["idlugar"],
           "email" => $_POST["email"],
           "genero" => $_POST["genero"],
           "estado_civil" => $_POST["estado_civil"],
           "conyuge" => $_POST["conyuge"],
           "cargo" => $_POST["cmb_idcargo"],
           "copiacedula" => $_POST["copiacedula"],
           "fechanacimiento" => $_POST["fechanacimiento"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "reentrenamiento" => $_POST["reentrenamiento"],
           "phone1" => $_POST["telefono1"],
           "phone2" => $_POST["telefono2"],
           "phone3" => $_POST["telefono3"],
           "sector" => $_POST["sector"],
           "direccion" => $_POST["direccion"],
           "referencia" => strtoupper($_POST["referencia"]),
           "tipo_sangre" => $_POST["tipo_sangre"],
           "bachiller" => $_POST["bachiller"],
           "altura" => $_POST["altura"],
           "celulartactil" => $_POST["celulartactil"],
           "computadora" => $_POST["computadora"],
           "curso_realizado" => $_POST["curso_realizado"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "tiene_afis" => $_POST["tiene_afis"],
           "referencia1" => $_POST["referencia1"],
           "referencia2" => $_POST["referencia2"],
           "referencia3" => $_POST["referencia3"],
           "recibo" => 0,
           "completo" => 0,
           "is_active" => 1
        ];

        if($errores1 != '' || $errores8 != ''){
            echo "<script type=\"text/javascript\">
                      swal({                
                      	 title: 'Corrija...!!!!',
                         text: '".$errores1."&nbsp;&nbsp;".$errores2."&nbsp;&nbsp;".$errores3."&nbsp;&nbsp;".$errores4."&nbsp;&nbsp;".$errores5."&nbsp;&nbsp;".$errores6."&nbsp;&nbsp;".$errores7."&nbsp;&nbsp;".$errores8."&nbsp;&nbsp;',
                         html: true,
                         type: 'error'
                      });
                  </script>"; 
        }else{
            $user = new PersonData();
    
            $user->cargo = 11;
            $user->company = $_SESSION['id_company'];
            $user->id = $_POST["id_person"];
            $user->idcard = $_POST["cedula"];
            $user->idlugar = $_POST["idlugar"];
            $user->estado_civil = $_POST["estado_civil"];
            $user->email = $_POST["email"];
            $user->name = strtoupper($_POST["nombres"]);
            $user->cargo = $_POST["cmb_idcargo"];
            $user->mensaje = strtoupper($_POST["mensaje"]);
            $user->genero = $_POST["genero"];
            $user->conyuge = strtoupper($_POST["conyuge"]);
            $user->embarazada = $embarazada;
            $user->latitude = $_POST["latitude"];
            $user->longitude = $_POST["longitude"];
            $user->copiacedula = $_POST["copiacedula"];
            $user->fechanacimiento = $_POST["fechanacimiento"];
            $user->phone1 = $_POST["telefono1"];
            $user->phone2 = $_POST["telefono2"];
            $user->phone3 = $_POST["telefono3"];
            $user->sector = strtoupper($_POST["sector"]);
            $user->direccion = strtoupper($_POST["direccion"]);
            $user->referencia = strtoupper($_POST["referencia"]);
            $user->tipo_sangre = (int) $_POST["tipo_sangre"];
            $user->bachiller = $_POST["bachiller"];
            $user->altura = $_POST["altura"];
            $user->celulartactil = $_POST["celulartactil"];
            $user->computadora = $_POST["computadora"];
            $user->curso_realizado = $_POST["curso_realizado"];
            $user->tiene_carnet = $_POST["tiene_carnet"];
            $user->reentrenamiento = $_POST["reentrenamiento"];
            $user->termino_curso = $_POST["termino_curso"];
            $user->referencia1 = $_POST["referencia1"];
            $user->referencia2 = $_POST["referencia2"];
            $user->referencia3 = $_POST["referencia3"];
            $user->recibo = 0;
            $user->completo = 0;
            $user->is_active = 1;
            $user->usuario_log = strtoupper($_POST["nombres"]);
    
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
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("image", $_FILES["foto"]["name"]);
            }
            
            if($_FILES["cedula1"]["name"]==""){
                $user->cedula1 = "";
            }else{
                $image = new Upload($_FILES["cedula1"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->cedula1 = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("cedula1", $_FILES["cedula1"]["name"]);
            }
    
            if($_FILES["cedula2"]["name"]==""){
                $user->cedula2 = "";
            }else{
                $image = new Upload($_FILES["cedula2"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->cedula2 = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("cedula2", $_FILES["cedula2"]["name"]);
            }
    
            if($_FILES["votacion"]["name"]==""){
                $user->votacion = "";
            }else{
                $image = new Upload($_FILES["votacion"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->votacion = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("votacion", $_FILES["votacion"]["name"]);
            }
    
            if($_FILES["vivienda"]["name"]==""){
                $user->vivienda = "";
            }else{
                $image = new Upload($_FILES["vivienda"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->vivienda = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("vivienda", $_FILES["vivienda"]["name"]);
            }
    
            if($_FILES["carnet"]["name"]==""){
                $user->carnet = "";
            }else{
                $image = new Upload($_FILES["carnet"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->carnet = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("carnet", $_FILES["carnet"]["name"]);
            }
            
            if($_FILES["archivo"]["name"]==""){
                $user->archivo = "";
            }else{
                $image = new Upload($_FILES["archivo"]);
    
                if($image->uploaded){
                    $image->Process("storage/documento/");
    
                    if($image->processed){
                        $user->archivo = $image->file_dst_name;
                    }
                }
                
                if($_POST["id_person"] == 0)
                    $error = '';
                else
                    $user->upd_campo("archivo", $_FILES["archivo"]["name"]);
            }
    
            if($_POST["id_person"] == 0) {
                $ingreso = $user->add_aspirante();
                
                if($ingreso[0]){
                    $total = $user->getTotal();
                    $valor = $total->total;
                }else{
                    $valor = 0;
                }
            }else{
                $valor = $_POST["id_person"];
                $user->upd_aspirante();
            }
            
            if(isset($_FILES["foto"]) && $_FILES["foto"]["name"]=="") $errores1 = "- No puede dejar la foto del aspirante en blanco\r\n";
            if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"]=="") $errores1 = "- No puede dejar el historial de laboral en blanco\r\n";
            if(isset($_FILES["cedula1"]) && $_FILES["cedula1"]["name"]=="") $errores2 = "- No puede dejar la cedula en blanco\r\n";
            if(isset($_FILES["cedula2"]) && $_FILES["cedula2"]["name"]=="") $errores3 = "- No puede dejar la cedula en blanco\r\n";
            if(isset($_FILES["votacion"]) && $_FILES["votacion"]["name"]=="") $errores4 = "- No puede dejar el certificado en blanco\r\n";
            if(isset($_FILES["vivienda"]) && $_FILES["vivienda"]["name"]=="") $errores5 = "- No puede dejar la foto de la vivienda\r\n";
            if(isset($_FILES["carnet"]) && $_FILES["carnet"]["name"]=="") $errores6 = "- No puede dejar la foto del carnet\r\n";
    
            if($errores1 == '' && $errores2 == '' && $errores3 == '' && $errores4 == '' && $errores5 == '' && $errores6 == ''){
                //
            }else{
                echo '<script type="text/javascript">
            			swal("Corrija...!!!!", "'.$errores1.'&nbsp;&nbsp;'.$errores2.'&nbsp;&nbsp;'.$errores3.'&nbsp;&nbsp;'.$errores4.'&nbsp;&nbsp;'.$errores5.'&nbsp;&nbsp;'.$errores6.'&nbsp;&nbsp;'.$errores7.'&nbsp;&nbsp;'.'", "error");
            		  </script>'; 
            }
            
            if($valor > 0){
            	// Varios destinatarios 
            	$para = $_POST["email"]; // atención a la coma <span style="border-radius:50px;background-color:#7d66a9;color:#ffffff;font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;display:inline-block;margin-top:5px;margin-right:5px">Oferta de servicio solicitada</span>
            	$título = 'Registro de los datos del Aspirante '.$_POST["nombres"];
            
            	// mensaje
            	$cuerpo = '<!DOCTYPE PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
                           <html xmlns="http://www.w3.org/1999/xhtml">
                              <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width,initial-scale=1.0">
                        	    <title>Ingreso de solicitud de aspirante</title>
                              </head>
                              <body>
                    	         <br><br>
                            	 <div style="font-family:Arial,sans-serif;font-size:15px;background-color:#ffffff;border-radius:10px;border:1px solid #e1e5ea">
                            	    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="80%" style="font-family:Arial,sans-serif;border-radius:10px">
                            	       <tbody>
                            	           <tr>
                            	               <td style="padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                                	               <table style="font-family:Arial,sans-serif" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                	                   <tbody>
                                	                       <tr>
                                	                         <td style="font-size:14px;padding-bottom:10px">
                                	                            <span style="border-radius:50px;background-color:#ec6984;color:#ffffff;font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;display:inline-block;margin-top:5px;margin-right:5px">Solicitud en tramite</span>
                                	                         </td>
                                	                       </tr>
                                	                       <tr>
                                	                         <td style="font-size:18px;padding-bottom:10px;line-height:24px">
                                	                            <strong>La Oferta de empleo es solicitada por: </strong> <p>'.$_POST["nombres"].'</p>
                                	                         </td>
                                	                       </tr>
                                	                       <tr>
                                	                         <td style="font-size:16px;padding-bottom:5px;line-height:24px">
                                	                            CIPOL
                                	                            <span style="padding-left:5px;display:inline-block"><img width="16" src="https://images.computrabajo.com/2021/10/06/etiqueta/verificada.png" alt="verificada" title="verificada" style="width:16px;vertical-align:bottom;padding-bottom:2px" class="CToWUd" data-bit="iit">
                                	                                <span style="color:#5e7d22;font-size:13px;padding-left:2px">Empresa 100% verificada</span>
                                	                            </span>
                                	                         </td>
                                	                       </tr>
                                	                       <tr>
                                	                         <td style="font-size:16px;padding-bottom:10px;line-height:24px">Guayaquil, Guayas</td>
                                	                       </tr>
                                	                       <tr>
                                	                         <td style="font-size:14px;color:#4b5968">Se ingreso una solicitud de empleo</td>
                                	                       </tr>
                                	                   </tbody>
                                	               </table>
                                	           </td>
                                	       </tr>
                                	   </tbody>
                                	</table>
                                 </div>
                              </body>
                    	    </html>';
            	
                // Set the headers
                $headers = [
                    "MIME-Version: 1.0",
                    "Content-type: text/html; charset=UTF-8",
                    'From: CIPOL Oficial <info@cipol.ec>',
                    'Cc: talentohumano@cipol.ec, asist.tthh@cipol.ec, ',
                ];
                
            	// Enviarlo
            	$bool = mail($para, $título, $cuerpo, implode("\r\n", $headers));
            	
            	if ($bool) {
                    //echo '<br>----------------------<br>Success...!' . PHP_EOL;
                } else {
                    echo 'Error.' . PHP_EOL;
                }
            }
            
            echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    	           <script>
        	            swal("Gracias...!", "Se ingresaron sus datos correctamente", "success");
                        setTimeout(function(){
        	                window.location="https://cipol.ec";
                        }, 3000);
        	       </script>';
            echo '<script>window.location="https://cipol.ec/sidai/aspirantes/'.$valor.'";</script>';
        }
    }else{
        $mensaje = "crear un nuevo aspirante al sistema";
        $enlaces = "Crear"; $falta = 6;
        
        $person = PersonData::getCedula($_SESSION["id_card"]);
        
        if (strlen($person->id) > 0) {
            //El usuario existe
        }else{
            $id_person = 0;
    
            $id_person = 0;
            $person = (object) [
               "idcompany"=>$_SESSION['id_company'],
               "idcard"=>$_SESSION['id_card'],
               "image"=>NULL,
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
               "sector"=>"",
               "direccion"=>"",
               "referencia"=>"",
               "fechanacimiento"=>"",
               "planilla"=>"0",
               "contrato"=>"0",
               "croquis"=>"0",
               "phone1"=>"",
               "phone2"=>"",
               "phone3"=>"",
               "bachiller"=>"0",
               "especializacion1"=>"",
               "estado_civil"=>"1",
               "esc_tecnico"=>"0",
               "especializacion2"=>"",
               "computadora"=>"0",
               "celulartactil"=>"0",
               "curso_realizado"=>"",
               "tipo_contrato"=>"",
               "computadora"=>"0",
               "referencia1"=>"",
               "referencia2"=>"",
               "referencia3"=>"",
               "is_active" => "1"
            ];
        }
    }
}

if($person->id)
    $users = PersonData::getTrabajos($person->id);
else
    $users = NULL;
    
?>
<style>
    /* Estilo para las previews */
    #preview-imgs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
    
    #preview-imgs img {
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    img{
        width:100%;
        vertical-align:top;
    }
    
    .caja{
        margin-top:22px;
        display:flex;
        align-items:center;
    }
    input{
        padding:4px 10px;
        outline:none;
        font-size:1.1em;
        border-radius:8px 0 0 8px;
        padding: 4px 15px 6px 15px;
        border:1px solid gray;
    }
    label{
        font-size:1em;
        margin-right:12px;
    }
    .superior{
        display:flex;
        align-items:center;
    }
    #album{
        font-size:1.2em;
        padding: 7px 14px 6px 14px;
    }
    button{
        border-radius:11px;
        background-color:forestgreen;
        color:white;
        padding:5px 13px;
        border:none;
        outline:none;
        border-radius:10px;
        cursor:pointer;
        margin-bottom:2px;
        font-size:1em;
        border:1px solid forestgreen;
    }
    button:hover{
        background-color:white;
        color:forestgreen; 
        border:1px solid forestgreen;
    }
    #enviar,.mas{
        margin-top:2px;
        padding:10px 25px 9px 14px;
        border-radius:0 12px 12px 0;
        border-left:none;
    }
    .albumes{
        margin-top:15px;
    }
    .cadaAlbum{
        display:flex;
        align-items:center;
        font-size:1.5em;
        padding-left:10px;
        cursor:pointer;
    }
    .cadaAlbum img{
        width:24px;
        margin-right:14px;
    }
    .miAlbum{
        border-radius:3px;
        border:1px dotted #0f0f0f;
        padding:7px 17px 14px;
        margin-top:12px;
        display:none;
    }
    h1{
        margin:0;   
    }
    .nombreAlbum{
        width:250px;
        outline:none;
        white-space: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .imagenes{
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        margin-top:12px;
    }
    .imagen{
        position:relative;
        margin:9px;
        padding:16px;
        border:6px dashed gainsboro;
        cursor:pointer;
    }
    .imagen:hover{
        border:6px dashed red;
    }
    .numeroImagenes{
        font-size:0.7em;
    }
    .imagenes img{
        width:150px;
    }
    .imagenes .papelera{
        width:24px;
        background-color:white;
        border:5px solid red;
        height:24px;
        position:absolute;
        right:-6px;
        top:-6px;
        cursor:pointer;
        display:none;
        padding:8px;
    }
    .ampliacion{
        position:fixed;
        width:100%;
        height:100vh;
        background-color:rgba(138, 43, 226,0.85);
        top: 0;
        left:0;
        display:none;
    }
    
    .imagenGrande img{
        position:absolute;
        height:90%;
        width:auto;
        margin:auto;
        left:0;
        right:0;
        top:0;
        bottom:0px;
        padding:13px;
        border-radius:5px;
        background-color:white;
        cursor: pointer;
    }
    
    .form-img {
      background: #ccc;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid black;
    }
    
    .form-img ol {
      padding-left: 0;
    }
    
    .form-img li,
    .div-img > p {
      background: #eee;
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      list-style-type: none;
      border: 1px solid black;
    }
    
    .form-img img {
      height: 64px;
      order: 1;
    }
    
    .form-img p {
      line-height: 32px;
      padding-left: 10px;
    }
    
    .form-img label,
    .form-img button {
      background-color: #7f9ccb;
      padding: 5px 10px;
      border-radius: 5px;
      border: 1px ridge black;
      font-size: 0.8rem;
      height: auto;
    }
    
    .form-img label:hover,
    .form-img button:hover {
      background-color: #2d5ba3;
      color: white;
    }
    
    .form-img label:active,
    .form-img button:active {
      background-color: #0d3f8f;
      color: white;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Aspirantes
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="aspirantes"><i class="fa fa-database"></i> Aspirantes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
    <div class="row">
		<div class="col-md-12">
            <div class="panel panel-default"> 
                <!-- tabs -->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_generales"  data-toggle="tab" aria-expanded="false"><b>Personales</b></a>
                    </li>
                    <li>
                        <a href="#tab_documentos" data-toggle="tab" aria-expanded="false"><b>Documentos</b><?php if($falta == 0) echo '&nbsp;&nbsp;<span class="badge bg-green">6</span>'; else echo '&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="Agentes activos">'.$falta.'</span>'; ?></a>
                    </li>
                    <li>
                        <a href="#tab_trabajos"   data-toggle="tab" aria-expanded="false"><b>Laborales</b><?php if(isset($users)) { if(count($users) > 0) echo '&nbsp;&nbsp;<span class="pull-right-container"><small class="label pull-right bg-green">Completo</small></span>'; else echo '&nbsp;&nbsp;<span class="pull-right-container"><small class="label pull-right bg-red">Faltan</small></span>'; }else{ echo '&nbsp;&nbsp;<span class="pull-right-container"><small class="label pull-right bg-red">Faltan</small></span>'; } ?></a>
                    </li>
                </ul>
                <div class="panel-body">
                    <!-- tabs content -->
                    <div class="tab-content panel">
                        <div class="tab-pane active" id="tab_generales">
                          	<!-- Dialogo para seleccionar una cuenta -->
                          	<form class="form-horizontal" method="POST" enctype="multipart/form-data" id="aspirante" name="aspirante" action="https://cipol.ec/sidai/aspirantes" role="form">
                                <input type="hidden" id="verifica"   name="verifica"   value="0">
                                <input type="hidden" id="timestamp"  name="timestamp"  value="">
                                <input type="hidden" id="latitude"   name="latitude"   value="">
                                <input type="hidden" id="longitude"  name="longitude"  value="">
                                <input type="hidden" id="rangoerror" name="rangoerror" value="">
                                <input type="hidden" id="sentido"    name="sentido"    value="">
                                <input type="hidden" id="velocidad"  name="velocidad"  value="">
                                <input type="hidden" id="mensaje"    name="mensaje"    value="">
                           	    <input type="hidden" id="id_person"  name="id_person"  value="<?php echo $person->id; ?>">
                           	    <input type="hidden" id="imgFoto"    name="imgFoto"    value="<?php echo $person->image; ?>">
                           	    <input type="hidden" id="imgCedula1" name="imgCedula1" value="<?php echo $person->cedula1; ?>">
                           	    <input type="hidden" id="imgCedula2" name="imgCedula2" value="<?php echo $person->cedula2; ?>">
                           	    <input type="hidden" id="imgCertifi" name="imgCertifi" value="<?php echo $person->votacion; ?>">
                           	    <input type="hidden" id="imgHistori" name="imgHistori" value="<?php echo $person->archivo; ?>">
                          		<div class="row">
                          		    <div class="col-md-12">
          		                        <button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
          		                    </div>
          		                    <br><br>
                          			<div class="col-md-7">
                          				<div class="panel panel-default">
                          					<div class="panel-heading">
                          						<h3 class="panel-title"><i class="fa fa-car"></i> Informaci&oacute;n del Coolaborador</h3>
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
                          									<label for="cedula" class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
                          									<div class="col-sm-3">
                          									    <input class="form-control" id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" data-mask placeholder="9999999999" value="<?php echo $person->idcard; ?>" required pattern="^[0-9]{10}" title="Solo números. Tamaño obligatorio: 10">
                          									</div>
                          								</div>
                          								<div class="form-group">
                          									<label for="nombres" class="col-sm-4 control-label"><span class="text-danger">*</span> Nombres Completos:</label>
                          									<div class="col-sm-6"><input class="text-field form-control input-sm" id="nombres" name="nombres" type="text" value="<?php echo $person->name; //utf8_encode() ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" placeholder="Nombres y apellidos del personal" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ñ]{3,40}" title="Solo letras. Tamaño mínimo: 3. Tamaño máximo: 30" required></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="email" class="col-sm-4 control-label"><span class="text-danger">*</span> Correo electronico:</label>
                          									<div class="col-sm-6"><input class="text-field form-control input-sm" id="email" name="email" type="email" value="<?php echo utf8_encode($person->email); ?>" minlength="3" maxlength="60" style="text-transform: lowercase;" placeholder="Correo personal" required></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="idlugar" class="col-sm-4 control-label"><span class="text-danger">*</span> Ciudad:</label>
                          									<div class="col-sm-3">
                          									    <select class="select-input form-control input-sm" id="idlugar" name="idlugar" required>
                            										<option value="0" selected="selected"> Selecione... </option>
                            										<?php
                            											foreach($lugars as $local):?>
                            												<option value="<?php echo $local->id; ?>" <?php if($local->id == $person->idlugar) echo "selected"; ?>><?php echo $local->descripcion;?></option>
                            										<?php endforeach; ?>
                            									</select>
                          									</div>
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
                          									<div class="col-sm-offset-1 col-sm-10">
                          										Estado Civil:
                          										<div class="radiobutton">
                          											<input type="radio" id="estado_civil" name="estado_civil" value="1" <?php if($person->estado_civil==1) echo 'checked'; ?>> Soltero &nbsp;&nbsp;
                          											<input type="radio" id="estado_civil" name="estado_civil" value="2" <?php if($person->estado_civil==2) echo 'checked'; ?>> Casado &nbsp;&nbsp;
                          											<input type="radio" id="estado_civil" name="estado_civil" value="3" <?php if($person->estado_civil==3) echo 'checked'; ?>> Union Libre &nbsp;&nbsp;
                          											<input type="radio" id="estado_civil" name="estado_civil" value="3" <?php if($person->estado_civil==4) echo 'checked'; ?>> Viudo
                          										</div>
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
                          								<div class="form-group">
                                                            <label class="col-sm-4 control-label"><span class="text-danger">*</span> Altura:</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="altura" name="altura" value="<?php echo $person->altura; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="masculino" style="display: none;">
                                                            <label for="conyuge" class="col-sm-4 control-label"> Nombre de la conyuge: </span></label>
                          									<div class="col-sm-6">
                                                                <input class="text-field form-control input-sm" type="text" name="conyuge" id="conyuge">&nbsp;&nbsp;<input type="checkbox" name="embarazada" value="1" id="embarazada"> Esta embarazada
                                                            </div>
                                                        </div>
                          								<div class="form-group">
                          									<label for="fechanacimiento" class="col-sm-4 control-label"><span class="text-danger">*</span> Fecha de nacimiento:</label>
                          									<div class="col-sm-4"><input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo $person->fechanacimiento; ?>" required title="Debe de ser una fecha valida"></div>
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
                          										<span class="text-danger">DATOS DE LA RESIDENCIA:</span>
                          									</div>
                          								</div>
                          								<div class="form-group">
                          									<label for="sector" class="col-sm-4 control-label"><span class="text-danger">*</span> Sector:</label>
                          									<div class="col-sm-6"><input class="text-field form-control input-sm" id="sector" maxlength="30" name="sector" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->sector; ?>" required style="text-transform: uppercase;" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="direccion" class="col-sm-4 control-label"><span class="text-danger">*</span> Direcci&oacute;n:</label>
                          									<div class="col-sm-6"><input class="text-field form-control input-sm" id="direccion" maxlength="80" name="direccion" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->direccion; ?>" required style="text-transform: uppercase;" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="referencia" class="col-sm-4 control-label"><span class="text-danger">*</span> Referencia:</label>
                          									<div class="col-sm-6">
                          										<textarea class="form-control" id="referencia" name="referencia" maxlength="120" placeholder="Al lado de la tienda de comestible"><?php echo $person->referencia; ?></textarea>
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
                          							<h3 class="panel-title"><i class="fa fa-briefcase"></i> Informacion Clasificada </h3>
                          						</div>
                          						<div class="panel-collapse pull out">
                          							<div class="panel-body">
                        								<div class="form-group">
                        									<label for="cmb_idcargo" class="col-md-4 col-sm-4 control-label">Cargo:</label>
                        									<div class="col-md-6 col-sm-4">
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
                          									<div class="col-sm-offset-1 col-sm-10">
                          										Curso de Guardia:
                          										<div class="radiobutton">
                          											<input type="radio" id="tiene_carnet" name="tiene_carnet" value="1" <?php if($person->tiene_carnet==1) echo 'checked'; ?>> Primer nivel  &nbsp;&nbsp;
                          											<input type="radio" id="tiene_carnet" name="tiene_carnet" value="2" <?php if($person->tiene_carnet==2) echo 'checked'; ?>> Segundo nivel &nbsp;&nbsp;
                          										</div>
                          									</div>
                          								</div>
                          								<div class="form-group">
                          									<label for="reentrenamiento" class="col-sm-4 control-label"> Reentrenamientos:</label>
                          									<div class="col-md-6 col-sm-6"><input type="text" class="form-control" id="reentrenamiento" name="reentrenamiento" placeholder="2002, 2011..." value="<?php echo $person->reentrenamiento; ?>"></div>
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
                          							<h3 class="panel-title"><i class="fa fa-book"></i> Nivel de Educaci&oacute;n </h3>
                          						</div>
                          						<div class="panel-collapse pull out">
                          							<div class="panel-body">
                          								<div class="form-group">
                          									<div class="col-sm-15">
                          										<label for="bachiller" class="col-sm-4 control-label">Tiene titulo de bachiller?</label>
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
                          										<label for="computadora" class="col-sm-4 control-label">Sabe utilizar la computadora?</label>
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
                          										<label for="celulartactil" class="col-sm-4 control-label">Sabe utilizar celular tactil?</label>
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
                          									<div class="col-sm-7">
                          										<textarea class="form-control" id="curso_realizado" name="curso_realizado" placeholder="Especifique los cursos realizados" rows="8" cols="50"><?php echo $person->curso_realizado; ?></textarea>
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
                          							<h3 class="panel-title"><i class="fa fa-users"></i> Referencias Personales </h3>
                          						</div>
                          						<div class="panel-collapse pull out">
                          							<div class="panel-body">
                          								<div class="form-group">
                          									<label for="referencia1" class="col-sm-3 control-label">Nombres y Telefono:</label>
                          									<div class="col-md-8 col-sm-8"><input type="text" class="form-control" id="referencia1" name="referencia1" placeholder="Referencia personal con nombre y telefono" value="<?php echo $person->referencia1; ?>"></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="referencia2" class="col-sm-3 control-label">Nombres y Telefono:</label>
                          									<div class="col-md-8 col-sm-8"><input type="text" class="form-control" id="referencia2" name="referencia2" placeholder="Referencia personal con nombre y telefono" value="<?php echo $person->referencia2; ?>"></div>
                          								</div>
                          								<div class="form-group">
                          									<label for="referencia3" class="col-sm-3 control-label">Nombres y Telefono:</label>
                          									<div class="col-md-8 col-sm-8"><input type="text" class="form-control" id="referencia3" name="referencia3" placeholder="Referencia personal con nombre y telefono" value="<?php echo $person->referencia2; ?>"></div>
                          								</div>
                          							</div>
                          						</div>
                          					 </div>
                          				</div>
                          			</div> 
                          			<!--/ Nivel de educacion -->
                          		</div>
              	            </form>
                      	</div>
                        <div class="tab-pane" id="tab_trabajos">
                            <div class="row">
								<div class="col-md-12"><?php
                                    if (isset($users)) { ?>
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
        												<th style="width: 10%"><div align="center">DESDE</div></th>
        												<th style="width: 10%"><div align="center">HASTA</div></th>
        												<th><div align="center">EMPRESA<?php echo $resultado; ?></div></th>
        												<th style="width: 20%"><div align="center">CARGO</div></th>
        											</tr>
        										</thead>
        										<tbody>	<?php
        											foreach($users as $tables) {
        												echo '<tr>';
        													echo '<td><div align="center">'.$tables->date_ini.'</div></td>';
        													echo '<td><div align="center">'.$tables->date_fin.'</div></td>';
        													echo '<td>'.$tables->empresa.'</td>';
        													echo '<td>'.$tables->cargo.'</td>';
        												echo '</tr>';
        											} ?>
        										</tbody>
        									</table>
        								</div><?php
                                    } else { 
                                        echo '<div class="callout callout-danger">
                                                <h4>Debe de llenar sus datos primero...!!!</h4>
                                                <p>Para poder ingresar sus datos laborales debe de ingresar primero sus datos principales.</p>
                                              </div>';
                                    } ?>
								</div>
							</div>
                        </div>
                        <div class="tab-pane" id="tab_documentos">  <?php
            			    if($person->image == NULL) {
            			        $nombre_fichero1 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
                			    $nombre_fichero1 = "https://cipol.ec/sidai/storage/persons/".$person->image;

                                if (file_exists("storage/persons/".$person->image)) {
                                    $tamano1 = filesize("storage/persons/".$person->image);
                                } else {
                                    echo "El archivo no existe.";
                                }
            			    }
            			    if($person->cedula1 == NULL) {
            			        $nombre_fichero2 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
            			        $nombre_fichero2 = "https://cipol.ec/sidai/storage/documento/".$person->cedula1;

                                if (file_exists("storage/documento/".$person->cedula1)) {
                                    $tamano2 = filesize("storage/documento/".$person->cedula1);
                                } else {
                                    echo "El archivo no existe.";
                                }
            			    }
            			    if($person->cedula2 == NULL) {
            			        $nombre_fichero3 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
            			        $nombre_fichero3 = "https://cipol.ec/sidai/storage/documento/".$person->cedula2;

                                if (file_exists("storage/documento/".$person->cedula2)) {
                                    $tamano3 = filesize("storage/documento/".$person->cedula2);
                                } else {
                                    echo "El archivo no existe.";
                                }
            			    }
            			    if($person->votacion == NULL) {
            			        $nombre_fichero4 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
            			        $nombre_fichero4 = "https://cipol.ec/sidai/storage/documento/".$person->votacion;

                                if (file_exists("storage/documento/".$person->votacion)) {
                                    $tamano4 = filesize("storage/documento/".$person->votacion);
                                } else {
                                    echo "El archivo no existe.";
                                }
            			    }
            			    if($person->firma == NULL) {
            			        $nombre_fichero5 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
            			        $nombre_fichero5 = "https://cipol.ec/sidai/storage/documento/".$person->firma;

                                if (file_exists("storage/documento/".$person->firma)) {
                                    $tamano5 = filesize("storage/documento/".$person->firma);
                                } else {
                                    echo "El archivo no existe.";
                                }
            			    }
            			    if($person->archivo == NULL) {
            			        $nombre_fichero6 = "https://cipol.ec/sidai/storage/persons/logo-Cipol-color.png"; 
            			    }else {
            			        $nombre_fichero6 = "https://cipol.ec/sidai/storage/documento/".$person->archivo;

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
                    </div>
                </div>
            </div>
    		<!-- pop up fechas Ingreso y Salida de los aspirantes -->
    		<div id="dlg_fechas_empresa" class="modal">
    			<div class="modal-dialog">
    				<div class="modal-content">
    					<div class="box-header with-border">
    						<h3 class="box-title">Experiencia Laboral</h3>
    						<div class="box-tools pull-right">
    							<button type="button" class="close" data-dismiss="modal">×</button>
    						</div><!-- /.box-tools -->
    					</div><!-- /.box-header -->
    					<div class="box-body" style="display: block;">
    						<div class="form-group">
    							<label for="empresa" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Empresa:</label>
    							<div class="col-md-12 col-sm-5">
    							    <input type="text" class="form-control" id="empresa" name="empresa" value="" placeholder="Nombre de la Empresa">
    							</div>
    						</div>
    						<div class="form-group">
    							<label for="cargo" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Cargo:</label>
    							<div class="col-md-12 col-sm-5">
    							    <input type="text" class="form-control" id="cargo" name="cargo" value="" placeholder="Descripcion del cargo">
    							</div>
    						</div>
    						<div class="form-group">
    							<label for="actividades" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Actividades:</label>
    							<div class="col-md-12 col-sm-5">
    							    <textarea id="actividades" name="actividades" style="width: 356px; height: 209px;" placeholder="Actividades realizadas" rows="10" cols="42"></textarea>
    							</div>
    						</div>
    						<div class="col-md-12 col-sm-12">
    						    <h4>Periodo Trabajado</h4>
    						</div>
    						<div class="form-group">
    							<label for="date_ini" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Desde:</label>
    							<div class="col-md-8 col-sm-5">
    							    <input type="date" id="date_ini" name="date_ini">
    							</div>
    						</div>
    						<div class="form-group">
    							<label for="date_fin" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Hasta:</label>
    							<div class="col-md-8 col-sm-5">
    							    <input type="date" id="date_fin" name="date_fin">
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
    					</div>
    				</div> <!-- /.modal-content -->
    			</div> <!-- /.modal-dialog -->
    		</div> <!--/ END modal -->
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
<div class="ampliacion">
	<div class="imagenGrande"></div>
</div>
<script type="text/javascript">
	let albunes=[];
	let desplegado;
	document.querySelector(".ampliacion").addEventListener("click", cerrar);
	
	ampliar = document.querySelector(".ampliacion");
	function teclado(e){
		(e.key==="Enter") && mas();
	}
	
	function activar(yo){
		yo.style.color="red";
	}

	function desactivar(yo){
		yo.style.color=null;
		const contenido=yo.innerHTML.trim();
		const indice=encontrar2(yo);			
		albunes[indice].album=contenido;
		insertar();
	}
	
	function detectarEnter(yo, e){	
		const tecla=e.key;
		if(tecla==="Enter"){
			desactivar(yo);
			e.preventDefault();
		}
	}
	
	function mostrar(yo){
		if(yo.querySelector(".papelera").style.display==="block")
			yo.querySelector(".papelera").style.display="none";
		else
			yo.querySelector(".papelera").style.display="block";
	}
	
	function ampliar(miImagen){	
		document.querySelector(".ampliacion").style.display="block";
		document.querySelector(".imagenGrande").innerHTML=`<img src="${miImagen}"/>`;
	}
	
	function cerrar(){	
		this.style.display="none";
		}
	
	function limpiar(){
		document.querySelector("#album").value="";
		document.querySelector("#album").focus();
	}
	
	function ocultar(){	
		
	}
	
	function encontrar2(yo){
		const hijos=yo.parentNode.parentNode.children;
		for(let k=0; k<hijos.length; k++){
			if(yo.parentNode === hijos[k]){
				return k;
			}
		}
	}
</script>
<script>
    const input = document.querySelector("input");
    const preview = document.querySelector(".preview");
    
    input.style.opacity = 0;
    
    input.addEventListener("change", updateImageDisplay);
    
    function updateImageDisplay() {
      while (preview.firstChild) {
        preview.removeChild(preview.firstChild);
      }
    
      const curFiles = input.files;
      if (curFiles.length === 0) {
        const para = document.createElement("p");
        para.textContent = "No hay archivos seleccionados actualmente para subir";
        preview.appendChild(para);
      } else {
        const list = document.createElement("ol");
        preview.appendChild(list);
    
        for (const file of curFiles) {
          const listItem = document.createElement("li");
          const para = document.createElement("p");
          if (validFileType(file)) {
            para.textContent = `Nombre del archivo ${file.name}, tamaño del archivo ${returnFileSize(
              file.size,
            )}.`;
            const image = document.createElement("img");
            image.src = URL.createObjectURL(file);
            image.alt = image.title = file.name;
    
            listItem.appendChild(image);
            listItem.appendChild(para);
          } else {
            para.textContent = `Nombre del archivo ${file.name}: Tipo de archivo no válido. Actualiza tu selección.`;
            listItem.appendChild(para);
          }
    
          list.appendChild(listItem);
        }
      }
    }
    
    // https://developer.mozilla.org/es/docs/Web/Media/Formats/Image_types
    const fileTypes = [
      "image/apng",
      "image/bmp",
      "image/gif",
      "image/jpeg",
      "image/pjpeg",
      "image/png",
      "image/svg+xml",
      "image/tiff",
      "image/webp",
      "image/x-icon",
    ];
    
    function validFileType(file) {
      return fileTypes.includes(file.type);
    }
    
    function returnFileSize(number) {
      if (number < 1e3) {
        return `${number} bytes`;
      } else if (number >= 1e3 && number < 1e6) {
        return `${(number / 1e3).toFixed(1)} KB`;
      } else {
        return `${(number / 1e6).toFixed(1)} MB`;
      }
    }
    
    const button = document.querySelector("form button");
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const para = document.createElement("p");
      para.append("Image uploaded!");
      preview.replaceChildren(para);
    });

    document.title = "CIPOL | Ingreso de aspirante";

    $(document).ready(function(){
        $("input").iCheck({
            checkboxClass: "icheckbox_flat-blue",
            radioClass: "iradio_flat-blue"
        });
        
        // Can also be used with $(document).ready()
        $(window).load(function() {
          $('.flexslider').flexslider({
            animation: "slide"
          });
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
        
        $("#agregar_fechas_empresa").click(function(e){
            e.preventDefault();
            $persona = $('#id_person').val();
			$empresa = $('#empresa').val();
			$cargo = $('#cargo').val();
			$actividades = $('#actividades').val();
			$date_ini = $('#date_ini').val();
			$date_fin = $('#date_fin').val();
			
			if($persona == 0 || $empresa == '' || $cargo == '' || $actividades == '' || $date_ini == '' || $date_fin == ''){
				sweetAlert('Errores pendientes...!!!', 'Debe seleccionar todos los campos para continuar', 'error');
			}else{
			    console.log("persona="+$persona+"&cargo="+$cargo+"&empresa="+$empresa+"&date_ini="+$date_ini+"&date_fin="+$date_fin+"&actividades="+$actividades);
				$.ajax({
					type: "POST",
					url: "ajax/trabajo.php?persona="+$persona+"&cargo="+$cargo+"&empresa="+$empresa+"&date_ini="+$date_ini+"&date_fin="+$date_fin+"&actividades="+$actividades,
					success: function(data) {
						/* Cargamos finalmente el contenido deseado */
						window.location="https://cipol.ec/sidai/aspirantes/"+$persona;
					}
				});
			} 

            return false;
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
