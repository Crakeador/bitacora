<?php
// Pantallas de ingreso y modificacion de las localidades
$client = ClientData::getAll(0);
$lugars = LugarData::getAll();
$hoy = date("Y-m-d H:i:s"); $error = ""; $lugar_id = 0;

if(isset($_GET["id"])){
    $mensaje = "modificar un puesto en el sistema";
    $enlaces = "Modificar";
    $lugar = PuestoData::getById($_GET["id"]);
    $lugar_id = $_GET["id"];
}else{
    $mensaje = "crear una oficina en el sistema";
    $enlaces = "Crear";

    if(count($_POST)>0){
      $lugar_id = $_POST["lugar_id"];

      if(isset($_POST["active"])) $activo=1; else $activo=0;
      if(isset($_POST["principal"])) $principal=1; else $principal=0;
      if(isset($_POST["iCubre1"])) $lunes = 1; else $lunes = 0;
      if(isset($_POST["iCubre2"])) $martes = 1; else $martes = 0;
      if(isset($_POST["iCubre3"])) $miercoles = 1; else $miercoles = 0;
      if(isset($_POST["iCubre4"])) $jueves = 1; else $jueves = 0;
      if(isset($_POST["iCubre5"])) $viernes = 1; else $viernes = 0;
      if(isset($_POST["iCubre6"])) $sabado = 1; else $sabado = 0;
      if(isset($_POST["iCubre7"])) $domingo = 1; else $domingo = 0;
      if(isset($_POST["iCubre8"])) $feriado = 1; else $feriado = 0;

      $lugar = new PuestoData();

      $lugar->grupo = 1;
      $lugar->idclient = $_POST["idclient"];
      $lugar->tipo = 2;
      $lugar->descripcion = strtoupper($_POST["descripcion"]);
      $lugar->codigo = strtoupper($_POST["codigo"]);
      $lugar->residencial = $_POST["residencial"];
      $lugar->activado = $_POST["dtp_input"];
      $lugar->idlugar = $_POST["idlugar"];
      $lugar->horas = $_POST["horas"];
      $lugar->horario = $_POST["turno"];
      $lugar->lunes = $lunes;
      $lugar->martes = $martes;
      $lugar->miercoles = $miercoles;
      $lugar->jueves = $jueves;
      $lugar->viernes = $viernes;
      $lugar->sabado = $sabado;
      $lugar->domingo = $domingo;
      $lugar->feriado = $feriado;
      $lugar->observacion = $_POST["observacion"];
      $lugar->principal = $principal;
      $lugar->is_active = $activo;

      if($_POST["lugar_id"] == 0){
          $lugar->add();
      }else{
          $lugar->id = $_POST["lugar_id"];
          $lugar->update();
      }
	  
      //Core::redir('catpus.lista');
    }else{
      $lugar = (object) [
          "idclient" => 0,
          "tipo" => 2,
          "codigo" => "",
          "residencial" => 0,
          "descripcion" => "",
          "activado" => $hoy,
          "idlugar" => "",
          "horas" => "",
          "horario" => "",
          "lunes" => "",
          "martes" => "",
          "miercoles" => "",
          "jueves" => "",
          "viernes" => "",
          "sabado" => "",
          "domingo" => "",
          "feriado" => "",
          "observacion" => "",
          "principal" => "0",
          "is_active" => "1"
      ];
    }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Puestos
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=catpus.lista"><i class="fa fa-database"></i> Listado </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<div class="container-fluid">
		<div class="row">
			<!-- Dialogo para seleccionar una cuenta -->
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
				<form class="form-horizontal" method="post" id="addpuesto" action="index.php?view=catpus.puesto" role="form">
                    <input type="hidden" id="lugar_id" name="lugar_id" value="<?php echo $lugar_id; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Ficha de los datos del puesto</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="idclient" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Cliente:</label>
								<div class="col-md-3 col-sm-4">
									<select class="select-input form-control input-sm" id="idclient" name="idclient">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($client as $clients):?>
												<option value="<?php echo $clients->idclient; ?>" <?php if($clients->idclient == $lugar->idclient) echo 'selected="selected"'; ?>><?php echo $clients->nombre;?></option>
											<?php endforeach;	?>
									</select>
								</div>
								<span class="text-danger">* Este campo es obligatorio</span>
							</div>
							<div class="form-group">
								<label for="descripcion" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-6 col-sm-4">
									<input class="text-field form-control input-sm" id="descripcion" name="descripcion" value="<?php echo $lugar->descripcion; ?>" minlength="3" maxlength="50" style="text-transform: uppercase;" type="text" required autofocus>
								</div>
							</div>
                            <div class="form-group">
								<label for="codigo" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Codigo:</label>
								<div class="col-md-3 col-sm-4">
									<input class="text-field form-control input-sm" id="codigo" name="codigo" value="<?php echo $lugar->codigo; ?>" maxlength="20" style="text-transform: uppercase;" type="text">
								</div>								
                                <span class="text-danger">Este puesto es residencial?</span>
                                <div class="col-xs-6">
                                    <div class="radiobutton">
                                        <input type="radio" id="residencial1" name="residencial" value="0" <?php if($lugar->residencial == 0) echo "checked"; ?>> No &nbsp;&nbsp;
                                        <input type="radio" id="residencial2" name="residencial" value="1" <?php if($lugar->residencial == 1) echo "checked"; ?>> Si  
                                    </div>
                                </div>
							</div>
							<div class="form-group">
								<label for="idlugar" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Localidad:</label>
								<div class="col-md-3 col-sm-4">
									<select class="select-input form-control input-sm" id="idlugar" name="idlugar">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($lugars as $local):?>
												<option value="<?php echo $local->id; ?>" <?php if($local->id == $lugar->idlugar) echo "selected"; ?>><?php echo $local->descripcion;?></option>
											<?php endforeach;
										?>
									</select>
								</div>
							</div>
                            <div class="form-group">
								<label for="turno" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Turno:</label>
								<div class="col-md-2 col-sm-4">
									<select class="select-input form-control input-sm" id="turno" name="turno" required>
										<option value="" <?php if($lugar->horario == "") echo "selected"; ?>> -- SELECCIONE -- </option>
										<option value="DIURNO" <?php if($lugar->horario == "DIURNO") echo "selected"; ?>> Diurno </option>
										<option value="NOCTURNO" <?php if($lugar->horario == "NOCTURNO") echo "selected"; ?>> Nocturno </option>
										<option value="HORAS" <?php if($lugar->horario == "HORAS") echo "selected"; ?>> Horas </option>
										<option value="DIAS" <?php if($lugar->horario == "DIAS") echo "selected"; ?>> Dias </option>
										<option value="TEMPORAL" <?php if($lugar->horario == "TEMPORAL") echo "selected"; ?>> Temporal </option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="horas" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Tiempo:</label>
								<div class="col-md-2 col-sm-2">
									<input class="text-field form-control input-sm" name="horas" id="horas" type="number" min="1" max="24" step="1" pattern="\d+" value="<?php echo $lugar->horas; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="iCubre1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Dias de trabajo:</label>
								<div class="col-md-8 col-sm-6">
								    <label class="control-label">
								        <input type="checkbox" id="iCubre1" name="iCubre1" value="1" <?php if($lugar->lunes == 1) echo "checked"; ?>> Lunes
										<input type="checkbox" id="iCubre2" name="iCubre2" value="1" <?php if($lugar->martes == 1) echo "checked"; ?>> Martes
										<input type="checkbox" id="iCubre3" name="iCubre3" value="1" <?php if($lugar->miercoles == 1) echo "checked"; ?>> Miercoles
										<input type="checkbox" id="iCubre4" name="iCubre4" value="1" <?php if($lugar->jueves == 1) echo "checked"; ?>> Jueves
										<input type="checkbox" id="iCubre5" name="iCubre5" value="1" <?php if($lugar->viernes == 1) echo "checked"; ?>> Viernes
										<input type="checkbox" id="iCubre6" name="iCubre6" value="1" <?php if($lugar->sabado == 1) echo "checked"; ?>> Sabado
										<input type="checkbox" id="iCubre7" name="iCubre7" value="1" <?php if($lugar->domingo == 1) echo "checked"; ?>> Domingo
										<input type="checkbox" id="iCubre8" name="iCubre8" value="1" <?php if($lugar->feriado == 1) echo "checked"; ?>> Feriados
								    </label>
								</div>
							</div>
							<div class="form-group">
                	            <label for="fecha" class="col-md-3 control-label"><span class="text-danger">*</span> Fecha de la entrega:</label>
								<div class="col-sm-6">
									<div class="input-group date form_date col-md-8 col-sm-8" data-date-format="yyyy-mm-dd">
										<input id="fecha" class="form-control" size="16" type="text" value="<?php echo $lugar->activado; ?>" readonly autocomplete="off">
										<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										<input type="hidden" id="dtp_input" name="dtp_input" value="<?php echo $lugar->activado; ?>">
									</div>
								</div>
	        		        </div>
                            <div class="form-group">
                                <label for="observacion" class="col-md-3 col-sm-3 control-label">Observaciones:</label>
                                <div class="col-md-9 col-sm-4">
									<textarea class="form-control input-sm" cols="50%" id="observacion" name="observacion" rows="3" style="width: 358px; height: 88px;"><?php echo $lugar->observacion; ?></textarea>
								</div>
							</div>
							</br>
                            <div class="form-group">
							    <div class="col-sm-5">
									<input id="active" name="active" type="checkbox" class="activo" <?php if($lugar->is_active == 1) echo "checked"; ?>>
									<label for="active">&nbsp;&nbsp;Activo </label>&nbsp;&nbsp;&nbsp;
									<input id="principal" name="principal" type="checkbox" class="activo" <?php if($lugar->principal == 1) echo "checked"; ?>>
									<label for="principal">&nbsp;Principal </label>
								</div>
							</div>
						</div>
					</div>
		            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guadar </button>
				</form>
			</div>
		</div>
	</div>
	<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
</section>
</br>
<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_flat-red',
	    radioClass: 'iradio_flat-red'
	  });
	});
</script>
