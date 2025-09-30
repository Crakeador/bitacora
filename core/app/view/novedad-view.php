<?php
//Novedades de Bitacora
/*
if($_SERVER['dispositivo'] == 1){ 
	$usuario = $_GET['usuario'];
	$puesto = $_GET['puesto'];
	$ingreso = $_GET['ingreso'];
	$turno = $_GET['turno'];
	
	Core::redir('fotos&usuario='.$usuario.'&puesto='.$puesto.'&ingreso='.$ingreso.'&turno='.$turno);
} */
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $observacion = ''; $estilo = ''; $validador = 99;

if(isset($_GET["usuario"])){
    $_SESSION["usuario"]=$_GET["usuario"];
    $_SESSION["puesto"]=$_GET["puesto"];
    $_SESSION["ingreso"]=$_GET["ingreso"];
    $_SESSION["turno"]=$_GET["turno"];
}

if(!isset($_SESSION["puesto"])){
    print "<script>window.location='index.php?view=asignar';</script>";
}

if(isset($_POST['codigo'])){
	if($_POST['codigo'] == ""){
		$diff_in_days = 99;
		
		$cargos = (object) [
			"tipo"=>1,
			"ini_fec"=>null,
			"fin_fec"=>null,
			"manzana"=>null,
			"villa"=>null
        ];
	}else{
		$cargos = ResidenteData::getLike($_POST['codigo']); 
		
		if($cargos == NULL){			
			Core::alert("Error...!!!!", "El codigo no exite", "error");
			$diff_in_days = -1;
			$cargos = (object) [
				"ini_fec"=>null,
				"fin_fec"=>null,
				"manzana"=>null,
				"villa"=>null
			];
			$validador = 0;
		}else{
			$now = time();
			$date = strtotime($cargos->ini_fec);
			 
			$diff_in_days = floor(($date - $now) / (60 * 60 * 24));
			$validador = 1;
		}
	}
}else{
	$diff_in_days = 99;
	$cargos = (object) [
		"cedula"=>'',
		"nombre"=>'',
		"residente"=>'',
		"tipo"=>1,
		"ini_fec"=>null,
		"fin_fec"=>null,
		"manzana"=>null,
		"villa"=>null
	];
}

if(isset($_POST['id_person'])){
    $user = new BitacoraData();
	if($_SESSION['etapas'] == 1)
		$user->idpuesto = $_POST["id_localidad"];
	else
		$user->idpuesto = $_SESSION["puesto"];
	
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_SESSION['turno'];
    $user->proceso = 2;
    $user->tipo = $_POST["tipo"];
    $user->manzana = $_POST["manzana"];
    $user->villa = $_POST["villa"];
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

    if($_POST["observacion"]==""){
        $errores = 'debe de ingresar una observacion del puesto';
    }else{
        if($_FILES["foto1"]["name"]==""){
            $errores = 'debe de tomarse una foto para verificar la novedad';
        }else{
            $image = new Upload($_FILES["foto1"]);

            if($image->uploaded){
                $image->Process("storage/novedad/");

                if($image->processed){
                    $user->foto1 = $image->file_dst_name;
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

            $prod = $user->add();
            $guardar = 1;
        }
    }

    if($errores == ''){
        Core::alert("Exito...!!!!", "Se guardo su registro", "error", "novedad&guardar=1");
    }else{
        $Observacion = $_POST["observacion"];
        Core::alert("Corrija...!!!!", $errores, "error");
    }
}

if($_SESSION["residencial"]==0)
    $estilo='style="display: none;"';
else
    $estilo="";

?>
<!-- Content Header (Page header) -->
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<!-- Registro de Bitacora -->
		<div class="panel panel-default">
			<!-- panel heading/header -->
			<div class="panel-heading">
				<h3 class="panel-title"><i class="mr5"></i>Ingreso de novedades </h3>
			</div>
			<!--/ panel heading/header -->
			<!-- panel body with collapse capable -->
			<div class="panel-collapse pull out">					
				<!-- tabs -->
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_generales" data-toggle="tab" aria-expanded="false"><b>Ingreso Normal</b></a>
					</li>
					<li>
						<a href="#tab_residentes" data-toggle="tab" aria-expanded="false"><b>Visita autorizada</b></a>
					</li>
				</ul>
				<div class="panel-body">				
					<!-- tabs content -->
					<div class="tab-content panel">
						<div class="tab-pane active" id="tab_generales">
							<div class="row">
								<div class="col-md-7">
									<form class="form-horizontal" method="post" enctype="multipart/form-data" id="novedad" name="novedad" action="index.php?view=novedad" role="form">
										<input type="hidden" id="id_person"   name="id_person"   value="<?php echo $_SESSION['user_id']; ?>">
										<!-- input type="hidden" id="idresidente" name="idresidente" value="<?php echo $_POST['idresidente']; ?>" -->
										<!-- input type="hidden" id="idautoriza"  name="idautoriza"  value="<?php echo $_POST['id']; ?>" -->
										<input type="hidden" id="timestamp"   name="timestamp"   value="">
										<input type="hidden" id="latitude"    name="latitude"    value="">
										<input type="hidden" id="longitude"   name="longitude"   value="">
										<input type="hidden" id="rangoerror"  name="rangoerror"  value="">
										<input type="hidden" id="sentido"     name="sentido"     value="">
										<input type="hidden" id="velocidad"   name="velocidad"   value="">
										<input type="hidden" id="mensaje"     name="mensaje"     value="">                            
										<div class="" id="fisicos">
											<div class="" id="autorizar" style="<?php if($validador == 1) echo ''; else echo 'display:none;'; ?>">											
												<div class="form-group">
													<div class="col-xs-6">
														<label for="cedula" class="control-label">Cedula:</label>
														<input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $cargos->cedula; ?>">
													</div>
													<div class="col-xs-6">
														<label for="nombre" class="control-label">Nombre:</label>
														<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $cargos->nombre; ?>">
													</div>
												</div>
												<div class="form-group">
													<div class="col-xs-6">
														<label for="cedula" class="control-label">Residente:</label>
														<input type="text" id="residente" name="residente" class="form-control" value="<?php echo $cargos->residente; ?>">
													</div>
													<div class="col-xs-6">
														<label for="nombre" class="control-label">Fecha:</label>
														<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $cargos->ini_fec; ?>">
													</div>
												</div>
											</div>
											<?php if($_SESSION['etapas'] == 1):
													if($_SESSION['principal'] == 1): 											
														$puestos = PuestoData::getByPuestos($_SESSION['id_client']); ?>										
														<div class="form-group">
															<label for="id_localidad" class="col-sm-4 control-label"><span class="text-danger">*</span> Puesto:</label>
															<div class="col-md-8 col-sm-8">
																<?php
																	echo '<select id="id_localidad" name="id_localidad" class="form-control">';
																	foreach($puestos as $tables) {
																		echo '<option value="'.$tables->id.'">'.$tables->descripcion.'</option>';
																	}
																	echo '</select>';
																?>
															</div>
														</div>
											<?php   endif; 										
												  endif; ?>
											<div class="form-group">
												<div class="col-xs-6">
													<label for="final" class="control-label">Verificaci&oacute;n:</label>
													<?php if($diff_in_days < 0) echo '<span class="btn btn-block btn-danger btn-flat">LLAMAR AL RESIDENTE '.$diff_in_days.'</span>'; else if($diff_in_days == 99) echo '<span class="btn btn-block btn-warning btn-flat">VERIFICAR INGRESO</span>'; else echo '<span class="btn btn-block btn-success btn-flat">AUTORIZADO</span>'; ?>
												</div>
												<div class="col-md-6 col-sm-6">
													<label for="fechas" class="control-label">Fecha:</label>
													<div class="input-group date form_datetime col-md-9 col-sm-8">
														<input id="fechas" class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
														<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
														<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
														<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<span class="text-danger">Que tipo de visita es?</span>
													<div class="radiobutton">
														<input type="radio" id="tipo1" name="tipo" value="1" <?php if($cargos->tipo == 'Visita') echo "checked'checked'"; ?>> Visita &nbsp;&nbsp;
														<input type="radio" id="tipo2" name="tipo" value="2" <?php if($cargos->tipo == 'Taxi') echo "checked'checked'"; ?>> Taxi  &nbsp;&nbsp;
														<input type="radio" id="tipo3" name="tipo" value="3" <?php if($cargos->tipo == 'Entrega') echo "checked'checked'"; ?>> Entrega &nbsp;&nbsp;
														<input type="radio" id="tipo4" name="tipo" value="4" <?php if($cargos->tipo == 'Otros') echo "checked'checked'"; ?>> Otros
													</div>
												</div>
											</div>
											<div class="form-group" <?php echo $estilo; ?>>
												<div class="col-xs-6">
													<label for="manzana" class="control-label"><span class="text-danger">*</span> Mz:</label>
													<input type="text" id="manzana" name="manzana" class="form-control" placeholder="1224" value="<?php if(isset($_POST["codigo"])) echo $cargos->manzana; else echo ''; ?>">
												</div>
												<div class="col-xs-6">
													<label for="villa" class="control-label"><span class="text-danger">*</span> Villa:</label>
													<input type="text" id="villa" name="villa" class="form-control" placeholder="41" value="<?php if(isset($_POST["codigo"])) echo $cargos->villa; else echo ''; ?>">
												</div>
											</div>
											<div class="form-group">
												<label for="observacion" class="col-sm-4 control-label"> Describa lo que esta reportando:</label>
												<div class="col-sm-8">
													<textarea class="form-control" id="observacion" name="observacion" placeholder="Visita autorizada por el propietario" cols="40" rows="5"><?php echo $observacion; ?></textarea>
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
									</form>
								</div>
							</div>
						</div>						
						<div class="tab-pane" id="tab_residentes">
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
													<div class="row">													
														<div class="col-md-12">
															<div class="callout callout-danger" style="margin-bottom: 0!important;">
																<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
																No se debe de permitir el ingreso de codigos despues de las 10 de la noche <span class="text-danger">*</span>
															</div>
														</div>
													</div>
													<form class="form-horizontal" method="post" id="residente" name="residente" action="index.php?view=novedad" role="form">
														<div class="form-group" style="padding: 1.5rem !important;">
															<label class="col-sm-4 control-label"><span class="text-danger">*</span> Codigo de ingreso:</label>
															<div class="input-group margin">
																<input type="text" class="form-control" id="codigo" name="codigo" autocomplete="off" minlength="6" maxlength="6" data-inputmask='"mask": "999999"' data-mask placeholder="123456" value="" pattern="[0-9]{6}" title="Solo números, debe ser una cable valida" autofocus>
																<span class="input-group-btn">
																  <button class="btn btn-success btn-flat" type="submit"><span class="glyphicon glyphicon-search"></span> Buscar</button>
																</span>
															</div>
														</div>													
													</form>
												</div>
											</div>
										</div>
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
    document.title = "Near Solution | Registro de la Bitacora";
</script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
  });
</script>
