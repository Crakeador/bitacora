<?php
//Novedades de Bitacora
date_default_timezone_set('America/Guayaquil');
/*
if($_SESSION['dispositivo'] == 1){ 
	$usuario = $_GET['usuario'];
	$puesto = $_GET['puesto'];
	$ingreso = $_GET['ingreso'];
	$turno = $_GET['turno'];
	
	Core::redir('fotos&usuario='.$usuario.'&puesto='.$puesto.'&ingreso='.$ingreso.'&turno='.$turno);
} */
$_SESSION['actividad']=1;

$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); 
$errores = ''; $observacion = ''; $estilo = ''; $validador = 99;
$today = getdate(); $hora=$today["hours"];

if(isset($_GET["fase"])){
    $user = new ResidenteData();
	$user->id = $_GET["id"];
	$user->idclient = $_SESSION["id_client"];
	$user->tipo = $_GET["fase"];
	$user->fecha = date("Y-m-d H:i:s");

	$user->horario($_GET["fase"]);
	$user->historial();
	
}

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
        $_SESSION['ingreso']=3;
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
        $_SESSION['ingreso']=3;
    }
}else{
    //echo("Buenas Noches ");
}

if(isset($_GET["usuario"])){
    $_SESSION["usuario"]=$_GET["usuario"];
    $_SESSION["puesto"]=$_GET["puesto"];
    $_SESSION["ingreso"]=$_GET["ingreso"];
}

if(!isset($_SESSION["puesto"])){
	echo '<script>
			if(localStorage.getItem("usuario") != null){
				var usuario = localStorage.getItem("usuario");
				var puesto = localStorage.getItem("puesto");
				var ingreso = localStorage.getItem("ingreso");
				var turno = localStorage.getItem("'.$_SESSION["turno"].'");
					
				window.location="index.php?view=registro&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
			}else{
				window.location="index.php?view=asignar";
			}
		</script>';
}

if(isset($_POST['id_person'])){
    $user = new VisitantesData();
	
    $user->idpuesto = (int) $_SESSION["puesto"];
    $user->idperson = (int) $_POST["id_person"];
    $user->nombre = $_POST["nombre"];
    $user->cedula = $_POST["cedula"];
    $user->placa = $_POST["placa"];
    $user->fecha = $_POST["fecha"];
    $user->tipo = $_POST["tipo"];
    $user->observacion = $_POST["observacion"];
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

    if($_POST["nombre"]==""){
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
    }

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

//var_dump($_SESSION);
?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
	<div class="container">
		<!-- Registro de Bitacora -->
		<div class="box box-info">
			<!-- panel heading/header -->
			<div class="box-header with-border">
				<h3 class="box-title"><i class="mr5"></i>Ingreso de novedades <?php echo $texto; ?> </h3>
			</div>
			<!-- panel body with collapse capable -->
			<div class="box-body">					
				<!-- tabs -->
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_generales" data-toggle="tab" aria-expanded="false"><b>Visitas</b></a>
					</li>
					<li>
						<a href="#tab_residentes" data-toggle="tab" aria-expanded="false"><b>Personal</b></a>
					</li>
				</ul>
				<div class="panel-body">				
					<!-- tabs content -->
					<div class="tab-content panel">
						<div class="tab-pane active" id="tab_generales">
							<div class="row">
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="registro" name="registro" action="registro" role="form">
    								<div class="col-md-7">
    									<input type="hidden" id="id_person"   name="id_person"   value="<?php echo $_SESSION['user_id']; ?>">
    									<input type="hidden" id="timestamp"   name="timestamp"   value="">
    									<input type="hidden" id="latitude"    name="latitude"    value="">
    									<input type="hidden" id="longitude"   name="longitude"   value="">
    									<input type="hidden" id="rangoerror"  name="rangoerror"  value="">
    									<input type="hidden" id="sentido"     name="sentido"     value="">
    									<input type="hidden" id="velocidad"   name="velocidad"   value="">
    									<input type="hidden" id="mensaje"     name="mensaje"     value="">                            
    									<div class="" id="fisicos">
                    						<div class="form-group">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
                                            </div>
                    						<div class="form-group">
    											<div class="col-sm-6">
    												<span class="text-danger">Que tipo de visita es?</span>
    												<div class="radiobutton">
    													<input type="radio" id="tipo1" name="tipo" value="1" checked> Tramite &nbsp;&nbsp;
    													<input type="radio" id="tipo2" name="tipo" value="2"> Visita  &nbsp;&nbsp;
    													<input type="radio" id="tipo3" name="tipo" value="3"> Patio &nbsp;&nbsp;
    													<input type="radio" id="tipo4" name="tipo" value="4"> Otros
    												</div>
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="nombre" class="col-sm-4 control-label">Nombre:</label>
    											<div class="col-sm-8">
    											    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $cargos->nombre; ?>">
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="cedula" class="col-sm-4 control-label">Cedula:</label>
    											<div class="col-sm-8">
    											    <input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $cargos->cedula; ?>">
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="cedula" class="col-sm-4 control-label">Placa:</label>
    											<div class="col-sm-8">
    												<input type="text" id="placa" name="placa" class="form-control" value="<?php echo $cargos->placa; ?>">
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="fechas" class="col-sm-4 control-label">Fecha:</label>
    											<div class="col-md-8 col-sm-8">
    												<div class="input-group date form_datetime col-md-10 col-sm-10">
    													<input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
    													<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    													<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
    												</div>
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
                                </form>
							</div>
						</div>						
						<div class="tab-pane" id="tab_residentes">
							    <div class="row">
    								<div class="form-group">
							            <div id="content"></div>
			                        </div>
    								<div class="form-group">
    									<label for="actual" class="col-sm-4 control-label">Cedula:</label>
    									<div class="col-sm-12">
    									    <input type="text" id="actual" name="actual" class="form-control" value="<?php echo $cargos->cedula; ?>">
    									</div>
    								</div>
    						        <div class="form-group">
    									<div class="col-sm-12">
    									    <a href="#" id="buscar" class="btn btn-danger btn-sm button"><i class="fa fa-search"></i>&nbsp; Buscar</a>
                                        </div>
                                    </div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
<script>
    $(document).ready(function() {    
        $('#buscar').on('click', function(){
			$cedula  = $('#actual').val();	

            if($cedula == '')
                $('#content').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Error...!!!</h4><p>El numero de cedula no puede ser dejado en blanco...!!!</p></div>');
            else
                $('#content').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor estamos calculando...!!!</div>');
        
            $.ajax({
                type: "GET",
                url: "ajax/buscar.php?cedula="+$cedula,
                success: function(data) {
					valor = JSON.parse(data);
					
                    if (valor.iEstado === "ok") {
            			var nombre = valor.aaData[0][1],
            			    cedula = valor.aaData[0][0];
            			
                        $('#content').fadeIn(1000).html('<div class="callout callout-success"><h4>Error...!</h4><p>Bienvenido '+nombre+' la cedula '+cedula+' es correcta...!!!</p></div>'); 
                        sweetAlert('Excelente', 'Bienevenido ' + nombre + '...!!!', 'success');
            		}else{
                        $('#content').fadeIn(1000).html('<div class="callout callout-danger"><h4>Error...!</h4><p>Se produjo un error grave consultando la cedula de identidad, debe de ser verificada la identidad con el administrador.</p></div>'); 
            		    sweetAlert('Error', 'No esta registrada esta cedula', 'error');
            		}
                }
            });
            return false;
        });
    });
</script>