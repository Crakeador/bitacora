<?php 

if(isset($_GET['id'])){
    $mensaje = "modificar un usuario del sistema";
    $enlaces = "Modificar";
    $person = BitacoraData::getById($_GET['id']);

//var_dump($person);
    $_SESSION['id_person'] = $_GET['id'];
    $id_person = $_GET['id'];
    
    $nombre_fichero = "storage/fotos/".$person->foto1;

    if (file_exists($nombre_fichero)) {
        $foto = $nombre_fichero;
    } else {
        $foto = 'storage/persons/1234567890.jpg';
    }
    $_SESSION['foto'] = $foto;
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Personal
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=rrping.lista"><i class="fa fa-database"></i> Personal </a></li>
		<li class="active"> Administrativo </li>
	</ol>
</section>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=rrping.persons" role="form">
        </br>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="tab-pane" id="tab_generales">
                        <div class="row">
                            <!-- Datos del Usuario -->
                            <div class="col-md-7">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="mr5"></i>Informaci&oacute;n del Coolaborador</h3>
                                    </div>
                                    <div class="panel-collapse pull out">
                                        <div class="panel-body">
                                            <div class="" id="datos">
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                    <span class="text-danger">DATOS BASICOS:</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="cedula" name="cedula" maxlength="10" value="<?php echo $person->idcard; ?>" required title="Solo números. Tamaño obligatorio: 10"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Apellidos Nombres:</label>
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo utf8_encode($person->name); ?>" placeholder="Primer nombre del personal" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,40}" title="Letras y números. Tamaño mínimo: 3. Tamaño máximo: 30"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
                                                    <div class="col-sm-3">
                                                        <select class="select-input form-control input-sm" id="genero" name="genero">
                                                        <option value="1" <?php if($person->genero==1) echo 'selected="selected"'; ?>>Masculino</option>
                                                        <option value="2" <?php if($person->genero==2) echo 'selected="selected"'; ?>>Femenino</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Fecha de nacimiento:</label>
                                                    <div class="col-sm-4"><input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo $person->fechanacimiento; ?>" required minlength="10" title="Debe de ser una fecha valida"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Nro. de hijos:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="hijos" name="hijos" data-inputmask='"mask": "99"' data-mask placeholder="99" value="<?php echo $person->hijos; ?>" required pattern="[0-9]{1}" title="Solo números"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                        <span class="text-danger">Adjunto la copia a color de c&eacute;dula y certificado de votaci&oacute;n actualizado</span>
                                                        <div class="radiobutton">
                                                        <input type="radio" id="copiacedula1" name="copiacedula" value="1" <?php if($person->copiacedula==1) echo 'checked'; ?>> Si
                                                        <input type="radio" id="copiacedula0" name="copiacedula" value="0" <?php if($person->copiacedula==0) echo 'checked'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Lugar de nacimiento:</label>
                                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="lugarnacimiento" maxlength="25" name="lugarnacimiento" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo strtoupper($person->lugarnacimiento); ?>" required pattern="[A-Za-z- ]{5,40}" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="10" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"> Tel&eacute;fono convencial:</label>
                                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono2" name="telefono2" maxlength="10" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $person->phone2; ?>"></div>
                                                </div>
                                                </br>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                    <span class="text-danger">DATOS DE LA VIVIENDA:</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Direcci&oacute;n de domicilio:</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="direccion" name="direccion" placeholder="Direcci&oacute;n de su vivienda actual" required><?php echo $person->direccion; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    El tipo de vivienda es:
                                                    <div class="radiobutton">
                                                        <input type="radio" id="tipo_vivienda1" name="tipo_vivienda" value="1" <?php if($person->tipo_vivienda==1) echo 'checked'; ?>> Propia &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda2" name="tipo_vivienda" value="2" <?php if($person->tipo_vivienda==2) echo 'checked'; ?>> Alquilada &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda3" name="tipo_vivienda" value="3" <?php if($person->tipo_vivienda==3) echo 'checked'; ?>> De un familiar &nbsp;&nbsp;
                                                        <input type="radio" id="tipo_vivienda4" name="tipo_vivienda" value="4" <?php if($person->tipo_vivienda==4) echo 'checked'; ?>> Otro
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputName" class="col-sm-2 control-label">Especifique:</label>
                                                    <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="especifique" name="especifique" placeholder="Especifique que tipo de vivienda posee" value="<?php echo $person->especifique; ?>">
                                                    </div>
                                                </div>
                                                </br>
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                    <span class="text-danger">OBSERVACIONES:</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">Adjunto el croquis y foto de la vivienda</span>
                                                        <div class="radiobutton">
                                                            <input type="radio" id="croquis1" name="croquis" value="1" <?php if($person->croquis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                            <input type="radio" id="croquis0" name="croquis" value="0" <?php if($person->croquis==0) echo 'checked'; ?>> No
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">Adjunto la planilla de servicios b&aacute;sicos de la vivienda</span>
                                                    <div class="radiobutton">
                                                        <input type="radio" id="planilla1" name="planilla" value="1" <?php if($person->planilla==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                        <input type="radio" id="planilla0" name="planilla" value="0" <?php if($person->planilla==0) echo 'checked'; ?>> No
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-1 col-sm-10">
                                                    <span class="text-danger">De ser una casa alquilada, adjunto el contrato de alquiler?</span>
                                                    <div class="radiobutton">
                                                        <input type="radio" id="contrato1" name="contrato" value="1" <?php if($person->contrato==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
                                                        <input type="radio" id="contrato2" name="contrato" value="2" <?php if($person->contrato==2) echo 'checked'; ?>> No &nbsp;&nbsp;
                                                        <input type="radio" id="contrato0" name="contrato" value="0" <?php if($person->contrato==0) echo 'checked'; ?>> No Procede
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Foto del Usuario -->
                            <div class="col-md-5">
                                <!-- Widget: user widget style 1 -->
                                <div class="box box-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header" style="background: url('assets/images/backgrounds/boxed_bg.png') center center;">
                                        <div class="widget-user-image" style="padding: 1rem !important;">
                                            <div align="center">
                                                <img class="img-circle" src="<?php echo $foto;?>" alt="User Avatar" class="image respossive" width="448" height="448"> <!--  style="max-width:100%;width:auto;height:auto;"> --> 
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="box-footer" style="padding: 1.5rem !important;">
                                        <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="image" id="image" placeholder="">
                                            <div class="btn-group pull-right" style="padding-top: 2rem !important;">
                                                <button type="submit" name="submit" class="btn btn-warning">Cambiar</button>
                                            </div>      
                                        </form>
                                    </div>
                                </div><!-- /.widget-user -->
                            </div>
                            <!--/ fin de la foto -->
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
                    </div>
                </div>
            </div>
	    </div>      
  	</form>
  </div>
</section>
<!--/ END To Top Scroller -->
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Verificacion de Puesto";

    $(document).ready(function(){
        $('input').iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_flat-red'
    });
</script>