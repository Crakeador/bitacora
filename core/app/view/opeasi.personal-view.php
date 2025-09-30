<?php
// Pantallas de ingreso los efectivos 
$puestos = PuestoData::getAll(2);
$persons = PersonData::getAllTipo(3, 1);

$hoy = date("Y-m-d H:i:s"); $error = ""; $lugar_id = 0; $servicio = 0;

$mensaje = "Asignar a un agente a un puesto";
$enlaces = "Crear";
if(count($_POST)>0){ 
   if(isset($_POST["active"])) $activo=1; else $activo=0;

   if($_POST["idservicio"] == "0"){
        $error .= "Debe seleccionar un puesto, corriga...!!!\n";
   }

   if($_POST["idperson"] == "0"){
        $error .= "Debe seleccionar un agente, corriga...!!!";
   }

   if($error == ""){
        $lugar = new UnionData();

		$lugar->id = $_POST["servicio"]; 
		$lugar->idservicio = $_POST["idservicio"];
        $lugar->idperson = $_POST["idperson"];
        $lugar->is_active = $activo;

		if($_POST["servicio"] == 0){
			$valor = $lugar->add();
		}else{
			$valor = $lugar->update();
		}
		
		Core::redir('opeasi.lista');
    }else{
        Core::alert("Error...!!!!", $error, "error");
    }

    $lugar = (object) [
        "idservicio" => $_POST["idservicio"],
        "idperson" => $_POST["idperson"],
        "is_active" => $activo
    ];
}else{
	if(isset($_GET["id"])){
		$lugar = UnionData::getById($_GET["id"]);
		$servicio = $_GET["id"];
	}else{
		$servicio = 0;
		$lugar = (object) [
			"idservicio" => "",
			"idperson" => "",
			"is_active" => "1"
		];
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Asignaci&oacute;n
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=opeasi.lista"><i class="fa fa-database"></i> Asignacion </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="row">
		<div class="container-fluid">
			<!-- Dialogo para seleccionar una cuenta -->
			<p class="alert alert-info">
				<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
				- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
			</p>
			<!-- START panel -->
			<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=opeasi.personal" role="form">
		        <input type="hidden" id="servicio" name="servicio" value="<?php echo $servicio; ?>">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Asignaci&oacute;n de un efectivo</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Puesto: </label>
							<div class="col-md-8 col-sm-8">
							    <?php
						            echo '<select id="idservicio" name="idservicio" class="form-control">';
						            echo '<option value="0"> -- SELECCIONE -- </option>';
					                foreach($puestos as $tables) {
										if($tables->id == $lugar->idservicio) $valor = 'selected'; else $valor = '';
										echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
									}
									echo '</select>';
		                        ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Agente:</label>
							<div class="col-md-8 col-sm-8">
							    <?php
			                        echo '<select id="idperson" name="idperson" class="form-control select2">';
					                    echo '<option value="0"> -- SELECCIONE -- </option>';
					                    foreach($persons as $tables) {
					                        if($tables->id == $lugar->idperson) $valor = 'selected'; else $valor = '';
					                        echo '<option value="'.$tables->id.'" '.$valor.'>'.utf8_encode($tables->name).'</option>';
					                    }
					                    echo '</select>';
		                        ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-5">
								<input id="active" name="active" type="checkbox" class="activo" <?php if($lugar->is_active == 1) echo "checked"; ?>>
								<label for="active">&nbsp;&nbsp;Activo </label>
							</div>
						</div>
					</div>
				</div>
		      	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
			</form>
		</div>
	</div>
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Asignacion de los guardias";
</script>
<script>
  $(document).ready(function(){    
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  });
</script>
