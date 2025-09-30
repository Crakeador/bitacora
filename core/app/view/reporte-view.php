<?php
//Ingreso de Guardias
date_default_timezone_set('America/Guayaquil');
$hoy = date("d-m-Y H:i:s"); $fecha = date("Y-m-d H:i:s"); $errores = ''; $_SESSION['guardar'] = 0; $observacion = ''; $estilo = ''; $mensaje = '';

if(isset($_POST['id_person'])){	
    $user = new BitacoraData();
    $user->idpuesto = (int) $_POST["id_localidad"];
    $user->idperson = (int) $_POST["id_person"];
    $user->fecha = $_POST["fecha"];
    $user->turno = $_POST["turno"];
    $user->proceso = 4;
    $user->observacion = $_POST["observacion"];	
    $user->foto1 = $_POST["foto"];
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

	$observacion = $_POST["observacion"];
    if(!isset($_POST["turno"])){
        $errores = 'debe de seleccionar el turno';
    }else{
        if($_POST["observacion"]==""){
            $errores = 'debe de ingresar una observacion del puesto';
		}else{
			$_SESSION['turno'] = $_POST["turno"];
			$_SESSION['puesto'] = (int) $_POST["id_localidad"];
			
			$_SESSION['ingreso']=2;
			$prod = $user->addIMG();	

            Core::redir("parte");			
        }
    }

    if($errores == ''){
      // Sin errores
    }else{
      Core::alert("Corrija...!!!!", $errores, "error");
    }
}

// Listado de los puesto de servicio de los guardias
$puestos = PuestoData::getAll(2);

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Parte
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php&view=home><i class="fa fa-database"></i> Personal </a></li>
		<li class="active"> Administrativo </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
	<!-- Registro de Bitacora -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!-- panel heading/header -->
				<div class="panel-heading">
					<h3 class="panel-title"><i class="mr5"></i>Parte Informativo</h3>
				</div>
				<!--/ panel heading/header -->
				<!-- panel body with collapse capable -->
				<div class="panel-collapse pull out">
					<div class="panel-body">						
						<div class="col-md-6">
						    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="reporte" name="reporte" action="index.php?view=reporte" role="form">
								<input type="hidden" id="id_person"  name="id_person"  value="<?php echo $_SESSION['id_person']; ?>">
								<input type="hidden" id="verifica"   name="verifica"   value="0">
								<input type="hidden" id="timestamp"  name="timestamp"  value="">
								<input type="hidden" id="latitude"   name="latitude"   value="">
								<input type="hidden" id="longitude"  name="longitude"  value="">
								<input type="hidden" id="rangoerror" name="rangoerror" value="">
								<input type="hidden" id="sentido"    name="sentido"    value="">
								<input type="hidden" id="velocidad"  name="velocidad"  value="">
								<input type="hidden" id="mensaje"    name="mensaje"    value="">
								<input type="hidden" id="foto"       name="foto"       value="">
								<div class="form-group">
									<label class="col-sm-4 control-label"><span class="text-danger">*</span> Puesto:</label>
									<div class="col-md-8 col-sm-6">
										<?php
											echo '<select id="id_localidad" name="id_localidad" class="form-control">';
											foreach($puestos as $tables) {
												echo '<option value="'.$tables->id.'">'.$tables->descripcion.'</option>';
											}
											echo '</select>';
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 col-sm-4 control-label"><span class="text-danger">*</span> Fecha:</label>
									<div class="col-md-8 col-sm-6">
										<div class="input-group date form_datetime col-md-9 col-sm-6">
											<input class="form-control" size="10" type="text" value="<?php echo $hoy; ?>" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
											<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-8">
										<span class="text-danger">Que turno esta cubriendo?</span>
										<div class="radiobutton">
											<input type="radio" id="turno1" name="turno" value="1" <?php if($_SESSION['turno']==1) echo "checked"; ?>> Diurno &nbsp;&nbsp;
											<input type="radio" id="turno2" name="turno" value="2" <?php if($_SESSION['turno']==2) echo "checked"; ?>> Nocturno
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 col-sm-4 control-label">Observaci&oacute;n:</label>
									<div class="col-sm-8">
										<textarea class="form-control" id="observacion" name="observacion" placeholder="Se recivio el puesto sin ninguna novedad" cols="40" rows="5"><?php echo $observacion; ?></textarea>
									</div>
								</div>
								</br>
								<div class="form-group">
									<label class="col-md-4 col-sm-4 control-label"> Acciones Tomadas:</label>
									<div class="col-sm-8">
										<textarea class="form-control" id="accion" name="accion" placeholder="Se recivio el puesto sin ninguna novedad" cols="40" rows="5"><?php echo $observacion; ?></textarea>
									</div>
								</div>								
                                <div class="form-group">
                                    <label class="col-md-4 col-sm-4 control-label"> Ingrese las fotos:</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="foto1" id="foto1" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                        <input type="file" name="foto2" id="foto2" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                        <input type="file" name="foto3" id="foto3" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                        <input type="file" name="foto4" id="foto4" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                        <input type="file" name="foto5" id="foto5" class="SubirFoto" accept="image/*" capture="camera" /></br>
                                        <input type="file" name="foto6" id="foto6" class="SubirFoto" accept="image/*" capture="camera" /></br>
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
			</div>
		</div>
	</div>
  </div>
</section>
<script>
    document.title = "Near Solucions | Registro del Parte";
</script>
<script>
    $(document).ready(function(event) {
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
	});
</script>