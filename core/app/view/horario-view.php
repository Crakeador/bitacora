<?php
//Ingreso de Guardias de Seguridad
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; 

$ini = new DateTime(date("Y-m-d")." 07:00:00");
$fin = new DateTime(date("Y-m-d")." 17:00:00");

if(isset($_POST['id_person'])){
    $user = new AsistenciaData();
    $user->idcompany = (int) $_SESSION["id_company"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->status = $_POST["turno"];
    $user->timestamp = $_POST["fecha"];
    $user->latitude = $_POST["latitude"];
    $user->longitude = $_POST["longitude"];
    $user->rangoerror = $_POST["rangoerror"];
    $user->sentido = $_POST["sentido"];
    $user->velocidad = $_POST["velocidad"];
    $user->mensaje = $_POST["mensaje"];
    $user->is_active = 1;
    $user->usuario_log = substr($_SESSION["name"]." ".$_SESSION["lastname"], 0, 20);
    $user->ip = $_SESSION["ip"];

    if($_FILES["image"]["name"]==""){
        $errores = 'debe de tomarse una foto para verificar su identidad';
    }else{
        $image = new Upload($_FILES["image"]);
        if($image->uploaded){
            $image->Process("storage/horario/");
            
            if($image->processed){
                $user->foto = $image->file_dst_name;
                $prod = $user->add();                
                
                echo '<script>
                            localStorage.removeItem("usuario");
                            localStorage.clear();
                        
                            window.location = "logout";
                        </script>'; 
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
            $mensaje = "<span class=\"text-danger\">*</span>Buenos días, tiene un atrazo de: ".$total." horas</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}elseif($hora<=18){
    if($_SESSION['ingreso']==0){
        $total = $hora - 17;
		$_SESSION['turno'] = 2;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos tardes, tiene un atrazo de: ".$total." horas</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}else{
    //echo("Buenas Noches ");
}

?> 
<!-- Listado de los clientes -->
<section class="content-header">
	<h1>
		Resientes
		<small>lista de las autorizaciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
    <!-- Registro de Bitacora -->
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" id="bitacora" name="asignar" action="horario" role="form">
                <input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['user_id']; ?>">
                <input type="hidden" id="verifica"   name="verifica"   value="0">
                <input type="hidden" id="timestamp"  name="timestamp"  value="">
                <input type="hidden" id="latitude"   name="latitude"   value="">
                <input type="hidden" id="longitude"  name="longitude"  value="">
                <input type="hidden" id="rangoerror" name="rangoerror" value="">
                <input type="hidden" id="sentido"    name="sentido"    value="">
                <input type="hidden" id="velocidad"  name="velocidad"  value="">
                <input type="hidden" id="mensaje"    name="mensaje"    value="">
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
                                    <span class="text-danger">Esta reportando: </span>
                                    <div class="radiobutton">
                                        <input type="radio" id="turno1" name="turno" value="1" <?php if($_SESSION['turno'] == '1') echo "checked='checked'"; ?>> Entrada &nbsp;&nbsp;
                                        <input type="radio" id="turno2" name="turno" value="2" <?php if($_SESSION['turno'] == '2') echo "checked='checked'"; ?>> Salida
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-md-4 col-sm-4 control-label">Consigna:</label>
							    <div class="col-sm-8">
						            <textarea class="form-control" size="10" type="text" name="consigna" placeholder="Indique su consigna" cols="40" rows="2"><?php echo $_SESSION['consigna']; ?></textarea>
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
            </form>
        </div>
    </div>
</section>
<script>
    document.title = "Near Solucions | Ingreso del Personal";

    if(localStorage.getItem("usuario") != null && localStorage.getItem("puesto") != null{
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

    $(document).ready(function(){
        $("#bitacora").submit(function(){
            $(this).find("button[type='submit']").attr("disabled", true);
            $(this).find("button[type='submit']").html("<span class='glyphicon glyphicon-refresh'></span> Procesando el envio...");
        });
    });
</script>