<?php
//Ingreso de Guardias
if($_SERVER['dispositivo'] == 1) Core::redir('ingreso');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $_SESSION['guardar'] = 0; $observacion = ''; $estilo = ''; $mensaje = '';

$ini = new DateTime(date("Y-m-d")." 07:00:00");
$fin = new DateTime(date("Y-m-d")." 17:00:00");

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
    $user->idpuesto = (int) $_POST["id_localidad"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_POST["turno"];
    $user->proceso = (($_SESSION['ingreso'] == 0) ? 1: 3);
    $user->observacion = $_POST["observacion"];
    $user->timestamp = $_POST["timestamp"];
    $user->latitude = $_POST["latitude"];
    $user->longitude = $_POST["longitude"];
    $user->rangoerror = $_POST["rangoerror"];
    $user->sentido = $_POST["sentido"];
    $user->velocidad = $_POST["velocidad"];
    $user->mensaje = $_POST["mensaje"];
    $user->is_active = 1;
    $user->usuario_log = substr($_SESSION["name"]." ".$_SESSION["lastname"], 0, 20);
    $user->ip = $_SESSION["ip"];

    if(!isset($_POST["turno"])){
        $errores = 'debe de seleccionar el turno';
    }else{
        if($_POST["observacion"]==""){
            $errores = 'debe de ingresar una observacion del puesto';
        }else{
            if($_FILES["image"]["name"]==""){
                $errores = 'debe de tomarse una foto para verificar su identidad';
            }else{
                $image = new Upload($_FILES["image"]);

                if($image->uploaded){
                    $image->Process("storage/ingreso/");
                    if($image->processed){
                        $user->foto1 = $image->file_dst_name;
                        if($_POST["verifica"]==0) $prod = $user->addIMG();

                        if(isset($_POST["short"])){
                            $_SESSION["consigna"]=$_POST["consigna"];

                            $config = new ConfigurationData();
                            $config->id = 9;
                            $config->val = $_POST["consigna"];

                            $prod = $config->update();
                        }

                        $_SESSION['turno'] = $_POST["turno"];
                        $_SESSION['puesto'] = (int) $_POST["id_localidad"];
						
                        if($_SESSION['ingreso']==0){
                            $_SESSION['ingreso']=1;
														
							if($_SERVER['dispositivo'] == 1)
								$valor = 'fotos';
							else
								$valor = 'novedad';
							
                            echo '<script>
									 localStorage.setItem("usuario", "'.$_POST["id_person"].'");
								 	 localStorage.setItem("puesto", "'.$_POST["id_localidad"].'");
									 localStorage.setItem("ingreso", "'.$_SESSION['ingreso'].'");
									 localStorage.setItem("turno", "'.$_POST["turno"].'");

									 window.location = "index.php?view='.$valor.'";
								  </script>';
                        }else{ 
                            $_SESSION['ingreso']=2;

                            echo '<script>
									 localStorage.removeItem("usuario");
									 localStorage.clear();
									
									 window.location = "index.php?view=logout";
								 </script>';
                        }
                    }
                }
            }
        }
    }

    if($errores == ''){
      // Sin errores
    }else{
      Core::alert("Corrija...!!!!", $errores, "error");
    }
}

$today = getdate(); $hora=$today["hours"];

if ($hora<6) {
    //echo(" Hoy has madrugado mucho... ");
}elseif($hora<16){
    if($_SESSION['ingreso']==0){
        $total = $hora - 7;
		$_SESSION['turno'] = 1;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos días, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=2;
    }
}elseif($hora<=18){
    if($_SESSION['ingreso']==0){
        $total = $hora - 17;
		$_SESSION['turno'] = 2;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos tardes, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=2;
    }
}else{
    //echo("Buenas Noches ");
}

// Listado de los puesto de servicio de los guardias 
$puestos = UnionData::getByIdLugares($_SESSION['user_id']);

?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="bitacora" name="asignar" action="index.php?view=asignar" role="form">
        <input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" id="verifica"   name="verifica"   value="0">
        <input type="hidden" id="timestamp"  name="timestamp"  value="">
        <input type="hidden" id="latitude"   name="latitude"   value="">
        <input type="hidden" id="longitude"  name="longitude"  value="">
        <input type="hidden" id="rangoerror" name="rangoerror" value="">
        <input type="hidden" id="sentido"    name="sentido"    value="">
        <input type="hidden" id="velocidad"  name="velocidad"  value="">
        <input type="hidden" id="mensaje"    name="mensaje"    value="">
        <div class="callout callout-danger" <?php echo $estilo; ?>>
            <h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
            <?php echo $mensaje; ?>
            <span class="text-danger">*</span><?php echo $_SESSION['consigna']; ?>
        </div>
        </br>
        <!-- Registro de Bitacora -->
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <!-- panel heading/header -->
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="mr5"></i><?php echo (($_SESSION['ingreso'] == 0) ? "Ingreso al puesto de trabajo": "Salida al puesto de trabajo"); ?></h3>
                    </div>
                    <!--/ panel heading/header -->
                    <!-- panel body with collapse capable -->
                    <div class="panel-collapse pull out">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><span class="text-danger">*</span> Puesto:</label>
                                <div class="col-sm-6">
                                    <?php
                                        echo '<select id="id_localidad" name="id_localidad" class="form-control">';
                                        foreach($puestos as $tables) {
                                            echo '<option value="'.$tables->idservicio.'">'.$tables->codigo.'</option>';
                                        }
                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
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
                                <div class="col-xs-6">
                                    <span class="text-danger">Que turno esta cubriendo?</span>
                                    <div class="radiobutton">
                                        <input type="radio" id="turno1" name="turno" value="1" <?php if($_SESSION['turno']==1) echo "checked"; ?>> Diurno &nbsp;&nbsp;
                                        <input type="radio" id="turno2" name="turno" value="2" <?php if($_SESSION['turno']==2) echo "checked"; ?>> Nocturno
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <span class="text-danger">Pasar la siguiente consigna:</span>
                                    <input type="checkbox" name="short">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-md-4 col-sm-4 control-label">Consigna:</label>
							    <div class="col-sm-8">
						            <textarea class="form-control" size="10" type="text" name="consigna" placeholder="Indique su consigna" cols="40" rows="2"><?php echo $_SESSION['consigna']; ?></textarea>
						        </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Describa lo que esta reportando:</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="observacion" name="observacion" placeholder="Se recivio el puesto sin ninguna novedad" cols="40" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"> Verifique su identidad:</label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="image" class="SubirFoto" accept="image/*" capture="camera" /></br>
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
    document.title = "Near Solucions | Ingreso del Personal";

    if(localStorage.getItem("usuario") != null){
        var usuario = localStorage.getItem("usuario");
        var puesto = localStorage.getItem("puesto");
        var ingreso = localStorage.getItem("ingreso");
        var turno = localStorage.getItem("turno");
        var verifica = document.getElementById("verifica");

        verifica.value = 1;
        //window.location="index.php?view=novedad&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
    }else{
        alert("No hay ningun turno abierto...!!!");
    }
</script>
<script>
    $(document).ready(function(event) {
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
	});
</script>
