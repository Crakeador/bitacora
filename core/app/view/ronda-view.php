<?php
//Ingreso de Parte Informativo 
date_default_timezone_set('America/Guayaquil');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $Observacion = ''; $errores = '';

if(isset($_GET)){
    if(isset($_GET['puesto'])){
        $lugar = PuestoData::getById($_GET["id"]);
        $id = $_GET["id"];
        $_SESSION["puesto"] = $_GET["id"];

        $rondas = BitacoraData::getByRondas($_GET["puesto"]);

        $_SESSION['ronda'] = $_GET["puesto"];
    }else{
        Core::alert("Error...!!!!", "No se ha seleccionado un puesto de trabajo...!!!", "error");
        print "<script>window.location='home';</script>";
    }
}

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
    
    $user->idpuesto = $_SESSION["puesto"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_SESSION['turno'];
    $user->punto = $_POST["punto"];
    $user->proceso = "Rondas";
    $user->tipo = "Ronda";
    $user->observacion = $_POST["observacion"];
    $user->accion = $_POST["accion"];
    $user->timestamp = $_POST["timestamp"];
    $user->latitude = $_POST["latitude"];
    $user->longitude = $_POST["longitude"];
    $user->rangoerror = $_POST["rangoerror"];
    $user->sentido = $_POST["sentido"];
    $user->velocidad = $_POST["velocidad"];
    $user->mensaje = $_POST["mensaje"];
    $user->is_active = 1;
    $user->usuario_log = $_SESSION["name"]." ".$_SESSION["lastname"];
    $user->ip = $_SESSION["ip"];

    if($_POST["observacion"]==""){
        $errores = 'debe de ingresar una observacion del puesto';
    }else{
        if($_FILES["foto1"]["name"]==""){
            $errores = 'debe de tomarse una foto para verificar la novedad';
        }else{
            $image = new Upload($_FILES["foto1"]);

            if($image->uploaded){
                $image->Process("storage/rondas/");

                if($image->processed){
                    $user->foto1 = $image->file_dst_name;
                }
            }

            if($_FILES["foto2"]["name"]==""){
                $user->foto2 = "";
            }else{
                $image = new Upload($_FILES["foto2"]);
                if($image->uploaded){
                    $image->Process("storage/rondas/");

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
                    $image->Process("storage/rondas/");

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
                    $image->Process("storage/rondas/");

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
                    $image->Process("storage/rondas/");

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
                    $image->Process("storage/rondas/");

                    if($image->processed){
                        $user->foto6 = $image->file_dst_name;
                    }
                }
            }

            $prod = $user->add();
            if($prod){                
    	        $_SESSION['ronda'] = $_SESSION['ronda'] + 1;
    	        $_SESSION['next'] = $_SESSION['next'] + 1;
        	    print "<script>window.location='novedad';</script>";
            }else{
                Core::alert("Corrija...!!!!", "No se pudo ingresar el evento...!!!", "error");
            }
        }
    }

    if($errores == ''){
        print "<script>window.location='novedad';</script>";
    }else{
        $Observacion = $_POST["observacion"];
        $accion = $_POST["accion"];

        Core::alert("Corrija...!!!!", $errores, "error");
    }
}

?>
<!-- Reporte de Danos -->
<section class="content-header">
	<h1>
		Rondas
		<small>reporte de rondas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
    <div class="container-fluid">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" id="parte" name="parte" action="ronda" role="form">
            <input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['id_person']; ?>">            
            <input type="hidden" id="puesto"     name="puesto"     value="<?php echo $_GET["id"]; ?>">
            <input type="hidden" id="punto"      name="punto"      value="<?php echo $_GET["puesto"]; ?>">
            <input type="hidden" id="latitude"  name="latitude"  value="" size="10">
            <input type="hidden" id="longitude" name="longitude" value="" size="10">
            <input type="hidden" id="timestamp"  name="timestamp"  value="">
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
                            <h3 class="panel-title"><i class="mr5"></i>Ronda Planificada</h3>
                        </div>
                        <!--/ panel heading/header -->
                        <!-- panel body with collapse capable -->
                        <div class="panel-collapse pull out">
                            <div class="panel-body">
                                <div class="" id="ronda">
                    				<div class="form-group">
                    					<label for="descripcion" class="col-md-34 col-sm-4 control-label"> Nombre:</label>
                    					<div class="col-md-6 col-sm-4">
                    						<input class="text-field form-control input-sm" id="descripcion" name="descripcion" value="<?php echo $rondas->name; ?>" readonly="readonly">
                    					</div>
                    				</div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-sm-4 control-label"> Fecha:</label>
									    <div class="col-md-6 col-sm-6">
              					            <div class="input-group date form_datetime col-md-9 col-sm-6">
              						            <input class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
                						        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      							<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                      							<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                    						</div>
                    					</div>
                					</div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Describa lo que ve:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Visita de el punto de Ronda" cols="40" rows="5"><?php echo $Observacion; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Acciones Tomadas:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="accion" name="accion" placeholder="Se llamo al supervisor" cols="40" rows="5"><?php echo $accion; ?></textarea>
                                        </div>
                                    </div>
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
    document.title = "SIDAI | Registro de la Ronda";    
</script>
<script>
    $(document).ready(function() {
        // Your jQuery code here will execute once the DOM is ready
        sweetAlert('Excelente', 'Usted esta en <?php echo $rondas->codigo; ?>, de el puesto: <?php echo $lugar->codigo; ?>, registre lo que ve en el punto...!', 'success');
    });
</script>
