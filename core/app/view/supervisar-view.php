<?php
//Reportes de supervicion
//Modificado: 21/02/2024
date_default_timezone_set('America/Guayaquil');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $accion = ''; $Observacion = ''; $errores = '';

if($_SESSION['idrol']!='6') print "<script>window.location='index.php?view=home&error=10';</script>";
//var_dump($_SESSION);
if(isset($_GET['puesto'])){
    $puesto = $_GET['puesto'];
}else{
    $puesto = 0;
}

if(isset($_POST['id_person'])){    
    $selectedValues = $_POST['logistica']; $logistica = '';    
    
    foreach ($selectedValues as $selectedValue) {
        if($selectedValue ==  "1") $logistica = $logistica.'Chaleco, ';
        if($selectedValue ==  "2") $logistica = $logistica.'Cinto, ';
        if($selectedValue ==  "3") $logistica = $logistica.'Placa fontal, ';
        if($selectedValue ==  "4") $logistica = $logistica.'Placa posterior, ';
        if($selectedValue ==  "5") $logistica = $logistica.'Porta tolete, ';
        if($selectedValue ==  "6") $logistica = $logistica.'Tolete, ';
        if($selectedValue ==  "7") $logistica = $logistica.'Posta Gas, ';
        if($selectedValue ==  "8") $logistica = $logistica.'Gas, ';
        if($selectedValue ==  "9") $logistica = $logistica.'Poncho de Agua, ';
        if($selectedValue == "10") $logistica = $logistica.'Linterna, ';
        if($selectedValue == "11") $logistica = $logistica.'Cargador, ';
        if($selectedValue == "12") $logistica = $logistica.'Detector de metales, ';
        if($selectedValue == "13") $logistica = $logistica.'Radio, ';
        if($selectedValue == "14") $logistica = $logistica.'Cargador de Radio, ';
        if($selectedValue == "15") $logistica = $logistica.'Bitacora, ';
        if($selectedValue == "16") $logistica = $logistica.'Estuche, ';
        if($selectedValue == "17") $logistica = $logistica.'Porta Arma, ';
        if($selectedValue == "18") $logistica = $logistica.'Arma, ';
        if($selectedValue == "19") $logistica = $logistica.'Bicicleta, ';
        if($selectedValue == "20") $logistica = $logistica.'Telefono';
    }

    $user = new BitacoraData();
    $user->idpuesto = (int) $_POST["id_localidad"];
    $user->idperson = (int) $_SESSION['id_person'];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_SESSION["turno"];
    $user->tipo = $_POST["tipo"];
    $user->proceso = 5;
    $user->nota = $_POST["nota"];
    $user->novedad = $_POST["novedad"];
    $user->superior = $_POST["superior"];
    $user->observacion = $_POST["observacion"];
    $user->observaciono = $logistica;
    $user->accion = $_POST["accion"];
    $user->timestamp = $_POST["timestamp"];
    $user->latitude = $_POST["latitude"];
    $user->longitude = $_POST["longitude"];
    $user->rangoerror = $_POST["rangoerror"];
    $user->sentido = $_POST["sentido"];
    $user->velocidad = $_POST["velocidad"];
    $user->mensaje = $_POST["mensaje"];
    $user->is_active = 1;
    $user->usuario_log = $_SESSION["user_name"];
    $user->ip = $_SESSION["ip"];

    if($_POST["observacion"]==""){
        $errores = 'debe de ingresar una observacion del puesto';
    }else{
        if($_FILES["foto1"]["name"]==""){
            $errores = 'debe de tomarse una foto para verificar la novedad';
        }else{
            $image = new Upload($_FILES["foto1"]);

            if($image->uploaded){
                $image->Process("storage/supervicion/");

                if($image->processed){
                    $user->foto1 = $image->file_dst_name;
                }
            }

            if($_FILES["foto2"]["name"]==""){
                $user->foto2 = "";
            }else{
                $image = new Upload($_FILES["foto2"]);

                if($image->uploaded){
                    $image->Process("storage/supervicion/");

                    if($image->processed){
                        $user->foto2 = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["foto3"]["name"]==""){
                $user->foto3 = "";
            }else{
                $image = new Upload($_FILES["foto3"]);

                if($image->uploaded){
                    $image->Process("storage/supervicion/");

                    if($image->processed){
                        $user->foto3 = $image->file_dst_name;
                    }

                }

            }

            if($_FILES["foto4"]["name"]==""){
                $user->foto4 = "";
            }else{
                $image = new Upload($_FILES["foto4"]);

                if($image->uploaded){
                    $image->Process("storage/supervicion/");
                    if($image->processed){
                        $user->foto4 = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["foto5"]["name"]==""){
                $user->foto5 = "";
            }else{
                $image = new Upload($_FILES["foto5"]);

                if($image->uploaded){
                    $image->Process("storage/supervicion/");

                    if($image->processed){
                        $user->foto5 = $image->file_dst_name;
                    }
                }
            }

            if($_FILES["foto6"]["name"]==""){
                $user->foto6 = "";
            }else{
                $image = new Upload($_FILES["foto6"]);

                if($image->uploaded){
                    $image->Process("storage/supervicion/");
                    if($image->processed){
                        $user->foto6 = $image->file_dst_name;
                    }
                }
            }

            $prod = $user->addSup();
            Core::redir('home');
        }
    }

    if($errores == ''){
        //print "<script>window.location='index.php?view=home';</script>";
    }else{
        $Observacion = $_POST["observacion"];
        $accion = $_POST["accion"];
        Core::alert("Corrija...!!!!", $errores, "error");
    }
}

// Listado de los puesto de servicio de los guardias
$puestos = PuestoData::getAll(2);

$today = getdate(); $hora=$today["hours"];

if($hora<16){
	$total = $hora - 7;
	$_SESSION['turno'] = 1;
}else{
	$total = $hora - 17;
	$_SESSION['turno'] = 2;
}
?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="parte" name="parte" action="index.php?view=supervisar" role="form">
        <input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" id="timestamp"  name="timestamp"  value="">
        <input type="hidden" id="latitude"   name="latitude"   value="">
        <input type="hidden" id="longitude"  name="longitude"  value="">
        <input type="hidden" id="rangoerror" name="rangoerror" value="">
        <input type="hidden" id="sentido"    name="sentido"    value="">
        <input type="hidden" id="velocidad"  name="velocidad"  value="">
        <input type="hidden" id="mensaje"    name="mensaje"    value="">
        <!-- Registro de Bitacora -->
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <!-- panel heading/header -->
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="mr5"></i>Supervicion de puesto</h3>
                    </div>
                    <!--/ panel heading/header -->
                    <!-- panel body with collapse capable -->
                    <div class="panel-collapse pull out">
                        <div class="panel-body">
                            <div class="" id="fisicos">                                       
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div style="text-align: right;" >
                                            <span class="text-danger">Que tipo de visita es?</span>
                                            <div class="radiobutton">
                                                <input type="radio" id="tipo1" name="tipo" value="9" <?php if($cargos->tipo == 1) echo "checked='checked'"; ?>> Entrada &nbsp;&nbsp;
                                                <input type="radio" id="tipo2" name="tipo" value="10" <?php if($cargos->tipo == 2) echo "checked='checked'"; ?>> Salida &nbsp;&nbsp;
                                                <input type="radio" id="tipo4" name="tipo" value="13" <?php if($cargos->tipo == 3) echo "checked='checked'"; ?> checked='checked'> Reporte
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group">
									<label for="nota" class="col-sm-4 control-label"><span class="text-danger">*</span> Reporte de:</label>
									<div class="col-sm-8">
										<select id="nota" name="nota" class="form-control">
        									<option value="3">Supervision de puesto</option>
                                            <option value="4">Visitas a clientes</option>
                                            <option value="5">Movimiento Operativo</option>
                                            <option value="6">Reporte de Incidencias</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="id_localidad" class="col-sm-4 control-label"><span class="text-danger">*</span> Puesto:</label>
									<div class="col-sm-8">
                                        <select id="id_localidad" name="id_localidad" class="form-control">
                                            <option value="20">TANGO 2 (EDIFICIO TRADE BUILDING)</option>
                                            <option value="19">TANGO 3 (EDIFICIO TRADE BUILDING)</option>
                                            <option value="3">ECO BRAVO (EDIFICIO ELITE BUILDING)</option>
                                            <option value="4">QUIL 1 (EDIFICIO QUO)</option>
                                            <option value="5">QUIL 2 (EDIFICIO QUO)</option>
                                            <option value="6">ALFA 1 (AKROS)</option>
                                            <option value="7">MURALLA (MEMORY)</option>
                                            <option value="8">CHARLY BRAVO (PROYECTO BRISANA)</option>
                                            <option value="9">ECO CHARLY 1 (EXECUTIVE CENTER)</option>
                                            <option value="10">ECO CHARLY 2 (EXECUTIVE CENTER)</option>
                                            <option value="13">INDIA 1 (IDEAL ALAMBREC)</option>
                                            <option value="18">CHARLY PAPA (PRIMAX CENTRO)</option>
                                            <option value="29">BUNKER (MONITOREO OMARSA)</option>
                                            <option value="21">DELTA 2 (CENTRO DE CAPACITACION)</option>
                                            <option value="22">OSCAR PAPA (PRIMAX OFICINA)</option>
                                            <option value="17">POSEIDON (PRIMAX GUAYAQUIL)</option>
                                            <option value="24">SIERRA (PRIMAX GUAYAQUIL)</option>
                                            <option value="25">SIERRA (PRIMAX DOMINGO COMIN)</option>
                                            <option value="26">SIERRA (PRIMAX PLAZA DAÑIN)</option>
                                            <option value="27">SIERRA (PRIMAX 25 DE JULIO )</option>
                                            <option value="31">FINCA (ESCUELA DE TIRO)</option>
                                            <option value="23">PAPA MIKE (PRIMAX MACHALA)</option>
                                            <option value="28">PAPA QUIL (PRIMAX QUITO)</option>
                                        </select>
									</div>
								</div>
                                <div class="form-group">
                                    <label for="idfecha" class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
									<div class="col-md-8 col-sm-8">
										<div class="input-group date form_datetime col-md-9 col-sm-8">
											<input id="idfecha" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
											<input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
										</div>
									</div>
								</div>
                                <div class="form-group">
                                    <label for="novedad" class="col-sm-4 control-label"> Tipo de Novedad:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="novedad" name="novedad" placeholder="Compra de Linterna" value="<?php echo $novedad; ?>">
                                    </div>
                                </div>            
                                <div class="form-group">
                                    <label for="superior" class="col-sm-4 control-label"> Ordenado por:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="superior" name="superior" placeholder="Jefe de Operaciones" value="<?php echo $superior; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="observacion" class="col-sm-4 control-label"> Descripcion de novedad:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Visita autorizada por el propietario" cols="40" rows="5"><?php echo $Observacion; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="accion" class="col-sm-4 control-label"> Acciones Tomadas:</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="accion" name="accion" placeholder="Se llamo al supervisor" cols="40" rows="5"><?php echo $accion; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="informa" class="col-sm-4 control-label"><span class="text-danger">*</span> Logistica:</label>
                                    <div class="col-md-8">
                                        <select id="informa" name="logistica[]" class="form-control select2 select2-hidden-accessible" multiple="" style="width: 100%;" data-placeholder="Seleccione la logistica" tabindex="-1" aria-hidden="true">
                                            <option value="1"> Chaleco </option>
                                            <option value="2"> Cinto </option>
                                            <option value="3"> Placa fontal </option>
                                            <option value="4"> Placa posterior </option>
                                            <option value="5"> Porta tolete </option>
                                            <option value="6"> Tolete </option>
                                            <option value="7"> Posta Gas </option>
                                            <option value="8"> Gas </option>
                                            <option value="9"> Poncho de Agua </option>
                                            <option value="10"> Linterna </option>
                                            <option value="11"> Cargador </option>
                                            <option value="12"> Detector de metales </option>
                                            <option value="13"> Radio </option>
                                            <option value="14"> Cargador de Radio </option>
                                            <option value="15"> Bitacora </option>
                                            <option value="16"> Estuche </option>
                                            <option value="17"> Porta Arma </option>
                                            <option value="18"> Arma </option>
                                            <option value="19"> Bicicleta </option>
                                            <option value="20"> Telefono </option>
                                        </select>                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="foto1" class="col-sm-4 control-label"> Ingrese las fotos:</label>
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
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
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
  $(document).ready(function(){
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de la Bitacora";

    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
  });
</script>
