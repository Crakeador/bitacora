<?php
//Reportes de supervicion
//Modificado: 21/02/2024
date_default_timezone_set('America/Guayaquil');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $accion = ''; $telefono = ''; $Observacion = ''; $errores = '';

// Cargar clientes activos de la tabla comercial
require_once __DIR__ . '/../../../documentos/conexion.php';
$mysqli = getConn();
$clientes = array();
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
// Detectar PK de comercial (id o idclient)
$pkRes = $mysqli->query("SHOW COLUMNS FROM comercial LIKE 'id'");
$comercialPK = ($pkRes && $pkRes->num_rows > 0) ? 'id' : 'idclient';
if($pkRes){ $pkRes->close(); }
$sqlClientes = "SELECT `$comercialPK` as id, nombre, ruc FROM comercial WHERE is_active = 1" . ($userId ? " AND iduser = $userId" : "") . " ORDER BY nombre ASC";
if($resCli = $mysqli->query($sqlClientes)){
    while($row = $resCli->fetch_assoc()){
        $clientes[] = $row;
    }
    $resCli->close();
}

if($_SESSION['idrol']=='4') {
    //Personas Permitidos
}else{
    print "<script>window.location='index.php?view=home&error=10';</script>";
}

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
    $user->idpuesto = 174;
    $user->idperson = (int) $_SESSION['id_person'];
    $user->fecha = $_POST["fecha"];
    $user->turno = 1;
    $user->tipo = "Visita";
    $user->proceso = "Ventas";
    $user->nota = "Visita de clientes";
    $user->observacion = $_POST["cliente"].'. Telefono: '.$_POST["telefono"];
    $user->observaciono = $_POST["observacion"];
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
    
    $Observacion = $_POST["observacion"];
    $accion = $_POST["accion"];
    
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

            $prod = $user->add();            
            if($prod[0]){
                Core::alert("Exito...!!!!", "Se guardo su registro", "success", "home");
            }else{
                Core::alert("Corrija...!!!!", "Debe correguir estos errores: ".$errores, "error");
            } 
        }
    }

    if($errores == ''){
        //print "<script>window.location='index.php?view=home';</script>";
    }else{
        Core::alert("Corrija...!!!!", $errores, "error");
    }
}

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
        <form class="form-horizontal" method="post" enctype="multipart/form-data" id="parte" name="parte" action="visito" role="form">
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
                                        <label for="idfecha" class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
    									<div class="col-md-6 col-sm-6">
    										<div class="input-group date form_datetime col-md-9 col-sm-6">
    											<input id="idfecha" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
    											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
    											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    											<input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
    										</div>
    									</div>
    								</div>
                                    <div class="form-group">
                                        <label for="cliente" class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Clientes:</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control" id="cliente" name="cliente" required>
                                                <option value="">-- Seleccione un cliente --</option>
                                                <?php foreach($clientes as $cli): ?>
                                                    <?php 
                                                        $nom = htmlspecialchars($cli['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
                                                        $ruc = isset($cli['ruc']) ? htmlspecialchars($cli['ruc'], ENT_QUOTES, 'UTF-8') : '';
                                                    ?>
                                                    <option value="<?= $nom ?>"><?= $nom ?><?= $ruc ? ' (' . $ruc . ')' : '' ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                					<div class="form-group">
                                        <label for="telefono" class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Telefono:</label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="number" class="form-control" id="telefono" name="telefono" minlength="10" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $telefono; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion" class="col-sm-4 control-label"> Direcci&oacute;n:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Direccion del agente" cols="40" rows="5" required><?php echo $Observacion; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="accion" class="col-sm-4 control-label"> Observaciones:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="accion" name="accion" placeholder="Se llamo al supervisor" cols="40" rows="5"><?php echo $accion; ?></textarea>
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
    document.title = "Registro de la Bitacora";
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
  });
</script>
