<?php
//Novedades de Bitacora
date_default_timezone_set('America/Guayaquil');
$contactos = ContactoData::getAll($_SESSION["puesto"]);
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

if(isset($_GET["id"])) $users = VisitantesData::update($_GET["id"]);
if(isset($_GET["person"])) 
    $cargos = ContactoData::getLike($_GET["person"]);
else
    $cargos = (object) [
        "nombre" => "",
        "cedula" => "",
        "placa" => ""
    ];

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
        $user->foto1 = isset($_FILES["foto1"]) ? $_FILES["foto1"]["name"] : "";
        $user->foto2 = isset($_FILES["foto2"]) ? $_FILES["foto2"]["name"] : "";
        $user->foto3 = isset($_FILES["foto3"]) ? $_FILES["foto3"]["name"] : "";
        $user->foto4 = isset($_FILES["foto4"]) ? $_FILES["foto4"]["name"] : "";
        $user->foto5 = isset($_FILES["foto5"]) ? $_FILES["foto5"]["name"] : "";
        $user->foto6 = isset($_FILES["foto6"]) ? $_FILES["foto6"]["name"] : "";
        
        $prod = $user->add();
        
        if($_FILES["foto1"]["name"]==""){
            $user->foto1 = "";        
        }else{
            $image = new Upload($_FILES["foto1"]);
            if($image->uploaded){
                $image->Process("storage/visitantes/");
    
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
                $image->Process("storage/visitantes/");

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
                $image->Process("storage/visitantes/");

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
                $image->Process("storage/visitantes/");

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
                $image->Process("storage/visitantes/");

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
                $image->Process("storage/visitantes/");

                if($image->processed){
                    $user->foto6 = $image->file_dst_name;
                }
            }
        }
    }

    if($errores == ''){
        echo '<script type="text/javascript" src="plugins/sweetalert/sweetalert.min.js"></script>
            <script type="text/javascript">
                swal("Excelente", "Se actualizaron los registros", "success");
            </script>';
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
		<!-- Registro de Visitas -->
		<div class="box box-info">
			<!-- panel heading/header -->
			<div class="box-header with-border">
				<h3 class="box-title"><i class="mr5"></i>Ingreso de visitas</h3>
			</div>
			<!-- panel body with collapse capable -->
			<div class="box-body">					
				<!-- tabs -->
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_generales" data-toggle="tab" aria-expanded="false"><b>Entradas</b></a>
					</li>
					<li>
						<a href="#tab_residentes" data-toggle="tab" aria-expanded="false"><b>Salidas</b></a>
					</li>
				</ul>
				<div class="panel-body">				
					<!-- tabs content -->
					<div class="tab-content panel">
						<div class="tab-pane active" id="tab_generales">
							<div class="row">
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="registro" name="registro" action="index.php?view=registro" role="form">
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
                                                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modalAgregarPersona" title="Añadir nueva persona" style="margin-right: 10px;">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <button type="submit" class="btn btn-success btn-sm pull-right" title="Guardar registro">
                                                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar 
                                                </button>
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
    											<label for="select_persona" class="col-sm-4 control-label">Seleccionar Placa:</label>
    											<div class="col-sm-7">
    												<select id="select_persona" name="select_persona" class="form-control select2" onchange="javascript:location.href='index.php?view=registro&person='+value;">
    													<option value="">-- Seleccione una persona --</option>
                                                        <?php 
                                                            foreach($contactos as $contacto): ?>
                                                                <option value="<?php echo $contacto->id; ?>"><?php echo $contacto->placa; ?></option>
                                                        <?php endforeach; ?>
    												</select>
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="nombre" class="col-sm-4 control-label">Nombre:</label>
    											<div class="col-sm-8">
    											    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $cargos->nombre; ?>" required>
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="cedula" class="col-sm-4 control-label">Cédula:</label>
    											<div class="col-sm-8">
    											    <input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $cargos->cedula; ?>">
    											</div>
    										</div>
    										<div class="form-group">
    											<label for="placa" class="col-sm-4 control-label">Placa:</label>
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
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th>Nombre</th>
                                        <th width="8%">Placa</th>
                                        <th>Salir</th>
                                    </thead><?php
                                        $users = VisitantesData::getAll($_SESSION["puesto"]);

                                        // Crea tabla de personal administrativo
                                        foreach($users as $tables) {
                                            echo '<tr>';
                                                echo '<td>'.$tables->nombre.'<br><small>'.$tables->created_at.'</small></td>';
                                                echo '<td>'.$tables->placa.'</td>';
                                                echo '<td>';
                                                    echo '<div align="center">';
                                                        echo '<a href="index.php?view=registro&fase=2&id='.$tables->id.'" class="btn btn-danger btn-sm"><i class="fa fa-sign-out"></i> Salir</a>';
                                                    echo '</div>';
                                                echo '</td>';
                                            echo '</tr>';
                                        }  ?>
                                </table>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal para Añadir Persona -->
<div class="modal fade" id="modalAgregarPersona" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPersonaLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f4f4f4; border-bottom: 1px solid #ddd;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -5px;">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="modalAgregarPersonaLabel" style="font-weight: 600;">Añadir persona</h4>
			</div>
			<div class="modal-body" style="padding: 20px;">
				<form id="formAgregarPersona">
					<div class="form-group">
						<label for="modal_nombre" style="font-weight: 500;">Nombre <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="modal_nombre" name="modal_nombre" placeholder="Ingrese el nombre" required autofocus>
					</div>
					<div class="form-group">
						<label for="modal_cedula" style="font-weight: 500;">Cédula</label>
						<input type="text" class="form-control" id="modal_cedula" name="modal_cedula" placeholder="Ingrese la cédula">
					</div>
					<div class="form-group">
						<label for="modal_placa" style="font-weight: 500;">Placa</label>
						<input type="text" class="form-control" id="modal_placa" name="modal_placa" placeholder="Ingrese la placa">
					</div>
				</form>
			</div>
			<div class="modal-footer" style="border-top: 1px solid #ddd; padding: 15px 20px;">
				<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 10px;">Cancelar</button>
				<button type="button" class="btn btn-success" id="btnGuardarPersona">
					<i class="fa fa-save"></i> Guardar
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de visitas";

    if (typeof(Storage) !== "undefined") {
        console.log("LocalStorage disponible");
    	if(localStorage.getItem("usuario") != null){
    		var usuario = localStorage.getItem("usuario");
    		var puesto = localStorage.getItem("puesto");
    		var ingreso = localStorage.getItem("ingreso");
    		var turno = localStorage.getItem("turno");
    	}else{
    	    console.log('Local Store no definido');
    		window.location="aspirantes";
    	}
    }else{
        console.log("LocalStorage no soportado en este navegador");
    }
    
    // Guardar nueva persona desde el modal
    $('#btnGuardarPersona').on('click', function() {
        var nombre = $('#modal_nombre').val();
        var cedula = $('#modal_cedula').val();
        var placa = $('#modal_placa').val();
        
        if(!nombre || nombre.trim() == '') {
            alert('El nombre es obligatorio');
            $('#modal_nombre').focus();
            return;
        }
        
        // Deshabilitar botón mientras se procesa
        var btnGuardar = $('#btnGuardarPersona');
        var textoOriginal = btnGuardar.html();
        btnGuardar.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Guardando...');
        
        $.ajax({
            url: 'index.php?action=contacto&accion=agregar',
            type: 'POST',
            data: {
                nombre: nombre.trim(),
                cedula: cedula.trim(),
                placa: placa.trim()
            },
            dataType: 'json',
            success: function(response) {
                btnGuardar.prop('disabled', false).html(textoOriginal);
                
                if(response.success) {
                    // Limpiar formulario
                    $('#formAgregarPersona')[0].reset();
                    // Cerrar modal
                    $('#modalAgregarPersona').modal('hide');
                    // Seleccionar la persona recién agregada
                    setTimeout(function() {
                        $('#select_persona').val(response.id).trigger('change');
                    }, 500);
                    // Mostrar mensaje de éxito
                    if(typeof swal !== 'undefined') {
                        swal("Excelente", "Persona agregada correctamente", "success");
                    } else {
                        alert('Persona agregada correctamente');
                    }
                } else {
                    alert('Error: ' + (response.message || 'No se pudo guardar la persona'));
                }
            },
            error: function(xhr, status, error) {
                btnGuardar.prop('disabled', false).html(textoOriginal);
                console.error('Error:', error);
                alert('Error al guardar la persona. Por favor, intente nuevamente.');
            }
        });
    });
    
    // Limpiar formulario cuando se cierra el modal
    $('#modalAgregarPersona').on('hidden.bs.modal', function() {
        $('#formAgregarPersona')[0].reset();
    });
</script>