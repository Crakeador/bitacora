<?php
//Novedades de Bitacora
$_SESSION['actividad']=1;
$bitacora = OperationTypeData::getAllType('Bitacora', 88);

$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $observacion = ''; $estilo = ''; $validador = 99;
$today = getdate(); $hora=$today["hours"];

if($hora<16){
	$_SESSION['turno'] = 1;
    if($_SESSION['ingreso']==0){
        $total = $hora - 7;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos días, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}elseif($hora<=18){
	$_SESSION['turno'] = 2;
    if($_SESSION['ingreso']==0){
        $total = $hora - 17;
        if($total > 0){
            $estilo = 'style="margin-bottom: 0!important;"';
            $mensaje = "<span class=\"text-danger\">*</span>Buenos tardes, tiene un atrazo de: ".$total." hora</br>";
        }else{
            $estilo = 'style="display: none;"';
        }
    }else{
        $_SESSION['ingreso']=3;
    }
}

if(isset($_GET["usuario"])){
    $_SESSION["usuario"]=$_GET["usuario"];
    $_SESSION["puesto"] =$_GET["puesto"];
    $_SESSION["ingreso"]=$_GET["ingreso"];
}

if(!isset($_SESSION["puesto"])){
    if($_SESSION["residencial"] == 0) $cadena='evento'; else $cadena='novedad';
	echo '<script>
			if(localStorage.getItem("usuario") != null){
				var usuario = localStorage.getItem("usuario");
				var puesto = localStorage.getItem("puesto");
				var ingreso = localStorage.getItem("ingreso");
				var turno = localStorage.getItem("'.$_SESSION["turno"].'");
					
				window.location="index.php?view='.$cadena.'&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
			}else{
				window.location="index.php?view=asignar";
			}
		</script>';
}

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
	if($_SESSION['etapas'] == 1)
		$user->idpuesto = $_POST["id_localidad"];
	else
		$user->idpuesto = $_SESSION["puesto"];
	
	$cadena = '';
	if(isset($_POST["reporte"]) && $_POST["reporte"]>0){	    
        $valor = OperationTypeData::getById($_POST["reporte"]);
        $cadena = $valor->name.'. ';
	}
	
	$reporte = $cadena.$_POST["observacion"];	

    $user->idpuesto = (int) $_SESSION["puesto"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_SESSION['turno'];
    $user->proceso = 2;
    $user->tipo = $_POST["tipo"];
    $user->manzana = $_POST["manzana"];
    $user->villa = $_POST["villa"];
    $user->observacion = $reporte;
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
	
	if($user->idpuesto == ''){
		print "<script>window.location='index.php?view=asignar';</script>";
	}

    if($reporte==""){
        $errores = 'debe de ingresar una observacion del puesto';
    }else{
        $user->foto1 = $_FILES["foto1"]["name"];            
        $user->foto2 = $_FILES["foto2"]["name"];            
        $user->foto3 = $_FILES["foto3"]["name"];            
        $user->foto4 = $_FILES["foto4"]["name"];            
        $user->foto5 = $_FILES["foto5"]["name"];            
        $user->foto6 = $_FILES["foto6"]["name"];
        
        $prod = $user->add();
        
        if($_FILES["foto1"]["name"]==""){
            $user->foto1 = "";        
        }else{
            $image = new Upload($_FILES["foto1"]);
            if($image->uploaded){
                $image->Process("storage/novedad/");
    
                if($image->processed){
                    $user->foto1 = $image->file_dst_name;
                }
            }
        }
        if($_FILES["foto2"]["name"]==""){
            $user->foto2 = "";
        }else{
            $image = new Upload($_FILES["foto2"]);

            if($image->uploaded){
                $image->Process("storage/novedad/");

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
                $image->Process("storage/novedad/");

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
                $image->Process("storage/novedad/");

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
                $image->Process("storage/novedad/");

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
                $image->Process("storage/novedad/");

                if($image->processed){
                    $user->foto6 = $image->file_dst_name;
                }
            }
        }
        $guardar = 1;
    }
    
    Core::redir('index.php?view=evento');
    if($errores == ''){
        Core::alert("Exito...!!!!", "Se guardo su registro", "sucess");
    }else{
        $Observacion = $_POST["observacion"];
        Core::alert("Corrija...!!!!", $errores, "error");
    } 
}

if($_SESSION["residencial"]==0)
    $estilo='style="display: none;"';
else
    $estilo="";

if(isset($_SESSION["asigna"]) || $_SESSION["asigna"] == NULL) $total = 1; else $total = count($_SESSION["asigna"]);
if($total > 1){
    $texto = 'Saca Franco';
}else{
    $idclint = $_SESSION["asigna"][0];
}

//var_dump($_SESSION);
?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
	<form class="form-horizontal" method="post" enctype="multipart/form-data" id="evento" name="evento" action="evento" role="form">
	<div class="container">
		<!-- Registro de Bitacora -->
		<div class="box box-alert">
			<!-- panel heading/header -->
			<div class="box-header with-border">
				<h3 class="box-title"><i class="mr5"></i>NOVEDADES </h3>
                <a href="evento" class="btn btn-warning pull-right"><i class="fa fa-sync"></i></a>
                <button type="submit" class="btn btn-success pull-right" style="font-size: 14px; font-weight: bold;"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>&nbsp;&nbsp;
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-7">
						<input type="hidden" id="id_person"   name="id_person"   value="<?php echo $_SESSION['user_id']; ?>">
						<input type="hidden" id="idresidente" name="idresidente" value="<?php echo $_POST['idresidente']; ?>">
						<input type="hidden" id="idautoriza"  name="idautoriza"  value="<?php echo $_POST['id']; ?>">
						<input type="hidden" id="guardar"     name="guardar"     value="<?php echo $_GET['guardar']; ?>">
						<input type="hidden" id="timestamp"   name="timestamp"   value="">
						<input type="hidden" id="latitude"    name="latitude"    value="">
						<input type="hidden" id="longitude"   name="longitude"   value="">
						<input type="hidden" id="rangoerror"  name="rangoerror"  value="">
						<input type="hidden" id="sentido"     name="sentido"     value="">
						<input type="hidden" id="velocidad"   name="velocidad"   value="">
						<input type="hidden" id="mensaje"     name="mensaje"     value="">                            
						<div class="form-group">
							<label for="fechas" class="col-sm-4 control-label">Fecha:</label>
							<div class="col-sm-8">
								<div class="input-group date form_datetime col-md-10 col-sm-10">
									<input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
								</div>
							</div>
						</div> 
						<div class="form-group">
							<div class="col-sm-6">
								<span class="text-danger">Que tipo de evento reporta?</span>
								<div class="radiobutton">
									<input type="radio" id="tipo1" name="tipo" value="1" checked> Evento &nbsp;&nbsp;
									<input type="radio" id="tipo2" name="tipo" value="2"> Reporte  &nbsp;&nbsp;
									<input type="radio" id="tipo3" name="tipo" value="3"> Entrega &nbsp;&nbsp;
									<input type="radio" id="tipo4" name="tipo" value="4"> Otros
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="reporte" class="col-sm-4 control-label"><span class="text-danger">*</span> Reporte:</label>
							<div class="col-md-8 col-sm-8">
							    <?php
			                        echo '<select id="reporte" name="reporte" class="form-control select2">';
					                    echo '<option value="0"> -- SELECCIONE -- </option>';
					                    foreach($bitacora as $tables) {
											echo '<option value="'.$tables->id.'">'.$tables->name.'</option>';
					                    }
					               echo '</select>';
		                        ?>
							</div>
						</div>
						<div class="form-group">
							<label for="observacion" class="col-sm-4 control-label"> Describa lo que esta reportando:</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="observacion" name="observacion" placeholder="Visita autorizada por el propietario" cols="40" rows="5"><?php echo $observacion; ?></textarea>
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
				</div>
			</div>
			<div class="box-footer">
			    <h4>Verificar cualquie novedad...!!!</h4>
			</div>
		</div>
	</div>
	</form>
</section>
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "SIDAI | Registro de Novedades";

    if (typeof(Storage) !== "undefined") {
        console.log("LocalStorage disponible");
    	if(localStorage.getItem("usuario") != null){
    		var usuario = localStorage.getItem("usuario");
    		var puesto = localStorage.getItem("puesto");
    		var ingreso = localStorage.getItem("ingreso");
    		var turno = localStorage.getItem("turno");
    		
    		console.log('Usuario: ' + usuario + ' Puesto: ' + puesto + ' Ingreso: ' + ingreso + ' Turno: ' + turno);
    		//window.location="index.php?view=aspirantes&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
    	}else{
    	    console.log('Local Store no definido');
    		window.location="aspirantes";
    	}
    }else{
        console.log("LocalStorage no soportado en este navegador");
    }
</script>