<?php
// Ingreso de los aspirantes
if(isset($_GET['id'])){
    $mensaje = "modificar un aspirante del sistema";
    $enlaces = "Modificar";
    $person = PersonData::getById($_GET['id']);

    $id_person = $_GET['id'];
}else{
    $mensaje = "crear un nuevo aspirante al sistema";
    $enlaces = "Crear";
    $id_person = 0;

    if(count($_POST)>0){
        $errores = "";
        if($_POST["id_person"] == 0){
            if(is_object(PersonData::getLike("idcard", $_POST["cedula"]))){
                $errores .= "- Cedula repetida";
            }
        }          

        $var = str_replace('_', '', $_POST["money"]);
        $var = str_replace('.', '', $var);
        $var = str_replace(',', '.', $var);

        $person = (object) [
           "idcard" => $_POST["cedula"],
           "image"=>"assets/images/user0.png",
           "name" => strtoupper($_POST["nombre_uno"]),
           "genero" => $_POST["genero"],
           "hijos" => $_POST["hijos"],
           "copiacedula" => $_POST["copiacedula"],
           "fechanacimiento" => $_POST["fechanacimiento"],
           "lugarnacimiento" => $_POST["lugarnacimiento"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "tiene_afis" => $_POST["tiene_afis"],
           "demanda" => $_POST["demanda"],
           "monto" => $var,
           "phone1" => $_POST["telefono1"],
           "phone2" => $_POST["telefono2"],
           "phone3" => $_POST["telefono3"],
           "direccion" => $_POST["direccion"],
           "tipo_vivienda" => $_POST["tipo_vivienda"],
           "especifique" => $_POST["especifique"],
           "bachiller" => $_POST["bachiller"],
           "especializacion1" => $_POST["especializacion1"],
           "esc_tecnico" => $_POST["esc_tecnico"],
           "especializacion2" => $_POST["especializacion2"],
           "celulartactil" => $_POST["celulartactil"],
           "computadora" => $_POST["computadora"],
           "curso_realizado" => $_POST["curso_realizado"],
           "certificados" => $_POST["certificados"],
           "tiene_carnet" => $_POST["tiene_carnet"],
           "tiene_afis" => $_POST["tiene_afis"],
           "recibo" => 0,
           "completo" => 0,
           "is_active" => 1
        ];

        if($errores == ''){
            $user = new PersonData();

            $user->cargo = 11;
            $user->company = $_SESSION['id_company'];
            $user->id = $_POST["id_person"];
            $user->idcard = $_POST["cedula"];
            $user->name = strtoupper($_POST["nombre_uno"]);
            $user->genero = $_POST["genero"];
            $user->hijos = $_POST["hijos"];
            $user->demanda = $_POST["demanda"];
            $user->monto = $_POST["money"];
            $user->copiacedula = $_POST["copiacedula"];
            $user->fechanacimiento = $_POST["fechanacimiento"];
            $user->lugarnacimiento = $_POST["lugarnacimiento"];
            $user->phone1 = $_POST["telefono1"];
            $user->phone2 = $_POST["telefono2"];
            $user->phone3 = $_POST["telefono3"];
            $user->direccion = $_POST["direccion"];
            $user->tipo_vivienda = $_POST["tipo_vivienda"];
            $user->especifique = $_POST["especifique"];
            $user->direccion = $_POST["direccion"];
            $user->bachiller = $_POST["bachiller"];
            $user->especializacion1 = $_POST["especializacion1"];
            $user->esc_tecnico = $_POST["esc_tecnico"];
            $user->especializacion2 = $_POST["especializacion2"];
            $user->celulartactil = $_POST["celulartactil"];
            $user->computadora = $_POST["computadora"];
            $user->curso_realizado = $_POST["curso_realizado"];
            $user->certificados = $_POST["certificados"];
            $user->tiene_carnet = $_POST["tiene_carnet"];
            $user->tiene_afis = $_POST["tiene_afis"];
            $user->recibo = 0;
            $user->completo = 0;
            $user->is_active = 1;

            if($_POST["id_person"] == 0) {
                $user->add_backup();
            }else{
                $user->upd_backup();
            }
            Core::redir('opeasp.lista');
        }else{
            Core::alert("Corrija...!!!!", $errores, "error");
        }
    }else{
        $id_person = 0;
        $person = (object) [
           "idcompany" => $_SESSION['id_company'],
           "idcard"=>NULL,
           "image"=>"assets/images/user0.png",
           "name"=>"",
           "cargo"=>11,           
           "hijos"=>"",
           "demanda"=>"",           
           "monto"=>NULL,
           "tiene_carnet"=>"0",
           "tiene_afis"=>"0",
           "sueldo"=>0,
           "startwork"=>"0000-00-00",
           "endwork"=>"0000-00-00",
           "email"=>"",
           "copiacedula"=>"0",
           "genero"=>"1",
           "direccion"=>"",
           "lugarnacimiento"=>"",
           "fechanacimiento"=>"0000-00-00",
           "tipo_vivienda"=>"2",
           "especifique"=>"","0",
           "planilla"=>"0",
           "contrato"=>"0",
           "croquis"=>"0",
           "phone1"=>"",
           "phone2"=>"",
           "phone3"=>"",
           "bachiller"=>"0",
           "especializacion1"=>"",
           "esc_tecnico"=>"0",
           "especializacion2"=>"",
           "computadora"=>"0",
           "celulartactil"=>"0",
           "curso_realizado"=>"",
           "certificados"=>"0",
           "tipo_contrato"=>"",
           "computadora"=>"0",
           "is_active" => "1"
        ];
    }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Aspirantes
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=opeasp.lista"><i class="fa fa-database"></i> Aspirantes </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
  <div class="row">
  	<div class="container-fluid">
  			<!-- Dialogo para seleccionar una cuenta -->
  			<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=opeasp.persons" role="form">
   			  <input type="hidden" id="id_person" name="id_person" value="<?php echo $id_person; ?>">
  				<p class="alert alert-info">
  					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
  					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
  				</p>
  				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
  			  </br></br>
  				<div class="row">
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
  																		<div class="col-sm-3"><input class="form-control" id="cedula" name="cedula" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" data-mask placeholder="9999999999" value="<?php echo $person->idcard; ?>" required pattern="^[0-9]{10}" title="Solo números. Tamaño obligatorio: 10"></div>
  																</div>
  																<div class="form-group">
  																		<label class="col-sm-4 control-label"><span class="text-danger">*</span> Apellidos Nombres:</label>
  																		<div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" name="nombre_uno" type="text" value="<?php echo utf8_encode($person->name); ?>" minlength="3" maxlength="30" style="text-transform: uppercase;" placeholder="Primer nombre del personal" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ñ]{3,40}" title="Solo letras. Tamaño mínimo: 3. Tamaño máximo: 30" required></div>
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
  																		<div class="col-sm-4"><input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?php echo $person->fechanacimiento; ?>" required minlength="10" pattern="^[0-3]{1}[0-9]{1}[-/.][0-1]{1}[1-9]{1}[-/.][1-2]{1}[0-9]{1}[0-9]{1}[0-9]{1}$" title="Debe de ser una fecha valida"></div>
  																</div>
  																<div class="form-group">
  																		<div class="col-sm-offset-1 col-sm-10">
  																				<span class="text-danger">Adjunto la copia a color de c&eacute;dula y certificado de votaci&oacute;n actualizado</span>
  																				<div class="radiobutton">
  																					 <input type="radio" id="copiacedula" name="copiacedula" value="1" <?php if($person->copiacedula==1) echo 'checked'; ?>> Si
  																					 <input type="radio" id="copiacedula" name="copiacedula" value="0" <?php if($person->copiacedula==0) echo 'checked'; ?>> No
  																				</div>
  																		</div>
  																</div>
  																<div class="form-group">
  																		<label class="col-sm-4 control-label"><span class="text-danger">*</span> Lugar de nacimiento:</label>
  																		<div class="col-sm-6"><input class="text-field form-control input-sm" id="lugarnacimiento" maxlength="25" name="lugarnacimiento" type="text" placeholder="Guayaquil - Ecuador" value="<?php echo $person->lugarnacimiento; ?>" required pattern="[A-Za-z -]{5,40}" title="Solo Letras. Tamaño mínimo: 5. Tamaño máximo: 30"></div>
  																</div>
  																<div class="form-group">
  																		<label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
  																		<div class="col-sm-3"><input type="text" class="form-control" id="telefono1" name="telefono1" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone1; ?>" required minlength="10" pattern="[0-9]{10}" title="Solo números, debe ser un telefono local"></div>
  																</div>
                                                                <div class="form-group">
  																		<label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
  																		<div class="col-sm-3"><input type="text" class="form-control" id="telefono2" name="telefono2" data-inputmask='"mask": "9999999999"' data-mask placeholder="9999999999" value="<?php echo $person->phone2; ?>" minlength="9" pattern="[0-9]{9,10}" title="Solo números, debe ser un telefono local"></div>
  																</div>
  																<div class="form-group">
  																		<label class="col-sm-4 control-label"> Tel&eacute;fono convencial:</label>
  																		<div class="col-sm-3"><input type="text" class="form-control" id="telefono3" name="telefono3" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999" value="<?php echo $person->phone3; ?>"></div>
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
  																					<textarea class="form-control" id="direccion" name="direccion" placeholder="Dirrecci&oacute;n de su vivienda actual" required><?php echo $person->direccion; ?></textarea>
  																		</div>
  																</div>
  																<div class="form-group">
  																		<div class="col-sm-offset-1 col-sm-10">
  																			El tipo de vivienda es:
  																			<div class="radiobutton">
  																					<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="1" <?php if($person->tipo_vivienda==1) echo 'checked'; ?>> Propia &nbsp;&nbsp;
  																					<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="2" <?php if($person->tipo_vivienda==2) echo 'checked'; ?>> Alquilada &nbsp;&nbsp;
  																					<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="3" <?php if($person->tipo_vivienda==3) echo 'checked'; ?>> De un familiar &nbsp;&nbsp;
  																					<input type="radio" id="tipo_vivienda" name="tipo_vivienda" value="4" <?php if($person->tipo_vivienda==4) echo 'checked'; ?>> Otro
  																			</div>
  																		</div>
  																	</div>
  																<div class="form-group">
  																		<label for="inputName" class="col-sm-2 control-label">Especifique:</label>
  																		<div class="col-sm-10">
  																			 <input type="text" class="form-control" id="especifique" name="especifique" placeholder="Especifique que tipo de vivienda posee" value="<?php echo $person->especifique; ?>">
  																		</div>
  																</div>
  														</div>
  												</div>
  										</div>
  								</div>
  						</div>
  						<!-- Informacion personal Operativo -->
  						<div class="col-md-5">
  								<div id="datos_laborales">
  										<div class="panel panel-default">
  												<div class="panel-heading">
  														<h3 class="panel-title"><i class="mr5"></i>Informacion Clasificada</h3>
  												</div>
  												<div class="panel-collapse pull out">
  														<div class="panel-body">
  															<div class="form-group">
  																	<label class="col-sm-6 control-label">Tiene el carnet del curso?</label>
  																	<div class="col-md-4 col-sm-5">
  																			<div class="radiobutton">
  																					<input type="radio" id="tiene_carnet" name="tiene_carnet" value="1" <?php if($person->tiene_carnet==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																					<input type="radio" id="tiene_carnet" name="tiene_carnet" value="0" <?php if($person->tiene_carnet==0) echo 'checked'; ?>> No
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<label class="col-sm-6 control-label">Tiene el certificado AFIS?</label>
  																	<div class="col-md-4 col-sm-5">
  																			<div class="radiobutton">
  																					<input type="radio" id="tiene_afis" name="tiene_afis" value="1" <?php if($person->tiene_afis==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																					<input type="radio" id="tiene_afis" name="tiene_afis" value="0" <?php if($person->tiene_afis==0) echo 'checked'; ?>> No
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<div class="col-sm-15">
  																			<label class="col-sm-8 control-label">Tiene demanda de alimentos?</label>
  																			<div class="col-md-4">
  																					<div class="radiobutton">
  																							<input type="radio" id="demanda" name="demanda" value="1" <?php if($person->demanda==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																							<input type="radio" id="demanda" name="demanda" value="0" <?php if($person->demanda==0) echo 'checked'; ?>> No
  																					</div>
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																<label class="col-sm-4 control-label"><span class="text-danger">*</span> Monto:</label>
  																<div class="col-md-6 col-sm-6">
  																	<input type="text" class="form-control" id="money" name="money" data-mask placeholder="$ 9.999,99" value="<?php echo $person->monto; ?>">
  																</div>
  															</div>
  															<div class="form-group">
  																	<label class="col-sm-4 control-label"><span class="text-danger">*</span> Nro. de hijos:</label>
  																	<div class="col-sm-3"><input type="text" class="form-control" id="hijos" name="hijos" maxlength="2" data-mask placeholder="99" value="<?php echo $person->hijos; ?>" pattern="[0-9]{1,10}" title="Solo números"></div>
  															</div>
  														</div>
  												</div>
  										</div>
  								</div>
  						</div>
  						<div class="col-md-5">
  								<div id="personalizados_proveedor">
  									<div class="panel panel-default">
  											<div class="panel-heading">
  													<h3 class="panel-title"><i class="mr5"></i>Nivel de Educaci&oacute;n</h3>
  											</div>
  											<div class="panel-collapse pull out">
  													<div class="panel-body">
  															<div class="form-group">
  																	<div class="col-sm-15">
  																			<label class="col-sm-8 control-label">Tiene titulo de bachiller?</label>
  																			<div class="col-md-4">
  																					<div class="radiobutton">
  																							<input type="radio" id="bachiller" name="bachiller" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																							<input type="radio" id="bachiller" name="bachiller" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
  																					</div>
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<label class="col-sm-4 control-label">Especializaci&oacute;n:</label>
  																	<div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="especializacion1" value="<?php echo $person->especializacion1; ?>" maxlength="40" name="especializacion1" size="30" type="text" placeholder="Titulo de especializaci&oacute;n"></div>
  															</div>
  															<div class="form-group">
  																	<div class="col-sm-15">
  																			<label class="col-sm-8 control-label">Tiene estudios t&eacute;cnicos y/o de 3er. Nivel?</label>
  																			<div class="col-md-4">
  																					<div class="radiobutton">
  																							<input type="radio" id="esc_tecnico" name="esc_tecnico" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																							<input type="radio" id="esc_tecnico" name="esc_tecnico" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
  																					</div>
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<label class="col-sm-4 control-label">Especializaci&oacute;n:</label>
  																	<div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="especializacion2" value="<?php echo $person->especializacion2; ?>" maxlength="40" name="especializacion2" size="30" type="text" placeholder="Titulo de especializaci&oacute;n"></div>
  															</div>
  															<div class="form-group">
  																	<div class="col-sm-15">
  																			<label class="col-sm-8 control-label">Sabe utilizar la computadora?</label>
  																			<div class="col-md-4">
  																					<div class="radiobutton">
  																							<input type="radio" id="computadora" name="computadora" value="1" <?php if($person->computadora==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																							<input type="radio" id="computadora" name="computadora" value="0" <?php if($person->computadora==0) echo 'checked'; ?>> No
  																					</div>
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<div class="col-sm-15">
  																			<label class="col-sm-8 control-label">Sabe utilizar celular tactil?</label>
  																			<div class="col-md-4">
  																					<div class="radiobutton">
  																							<input type="radio" id="celulartactil" name="celulartactil" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																							<input type="radio" id="celulartactil" name="celulartactil" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No
  																					</div>
  																			</div>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<label class="col-sm-4 control-label">Cursos realizados:</label>
  																	<div class="col-sm-8">
  																			<textarea class="form-control" id="curso_realizado" name="curso_realizado" placeholder="Especifique los cursos realizados"><?php echo $person->curso_realizado; ?></textarea>
  																	</div>
  															</div>
  															<div class="form-group">
  																	<div class="col-sm-10">
  																		 <span class="text-danger">Adjunto copia de certificados y capacitaciones</span>
  																		 <div class="radiobutton">
  																				 <input type="radio" id="certificados" name="certificados" value="1" <?php if($person->bachiller==1) echo 'checked'; ?>> Si &nbsp;&nbsp;
  																				 <input type="radio" id="certificados" name="certificados" value="2" <?php if($person->bachiller==2) echo 'checked'; ?>> No &nbsp;&nbsp;
  																				 <input type="radio" id="certificados" name="certificados" value="0" <?php if($person->bachiller==0) echo 'checked'; ?>> No procede
  																		 </div>
  																	</div>
  															</div>
  													</div>
  											</div>
  									 </div>
  								</div>
  						</div> <!--/ Nivel de educacion -->
  				</div>
  			</form>
  	</div>
  </div>
</section>
<div class="text-right">
  <a href="#" id="js_up" class="ir-arriba" title="Volver arriba">
    <span class="fa-stack">
      <i class="fa fa-circle fa-stack-2x"></i>
      <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
    </span>
  </a>
</div>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //invocamos al objeto (window) y a su método (scroll), solo se ejecutara si el usuario hace scroll en la página
    $(window).scroll(function(){
      if($(this).scrollTop() > 300){ //condición a cumplirse cuando el usuario aya bajado 301px a más.
        $("#js_up").slideDown(300); //se muestra el botón en 300 mili segundos
      }else{ // si no
        $("#js_up").slideUp(300); //se oculta el botón en 300 mili segundos
      }
    });

    //creamos una función accediendo a la etiqueta i en su evento click
    $("#js_up i").on('click', function (e) {
      e.preventDefault(); //evita que se ejecute el tag ancla (<a href="#">valor</a>).
      $("body,html").animate({ // aplicamos la función animate a los tags body y html
        scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
      },700); //el valor 700 indica que lo ara en 700 mili segundos
      return false; //rompe el bucle
    });
  });
</script>
