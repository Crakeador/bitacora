<?php
// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $mensaje = "crear una cotizaci&oacute;n";
		$enlaces = "Crear";
		
		$oficio = "";
		
		$client = (object) [
			"paquete" => 0,
			"nombre" => "",
			"idcarro" => 0,
			"municion" => 0,
			"telefono" => "",
			"fecha" => date("Y-m-d"),
			"is_active" => "1"
		];
			
    	if(isset($_GET['dato'])){ //Ingreso de datos
        	$user = new CotizacionData();
        	
        	$user->idcotizacion = $_GET["id"];
        	$user->dato = $_GET["dato"];
        	$user->tipo = $_GET["tipo"];
        	
        	$arma = $user->addDatos();
            $idruta = $_GET["id"];
            
        	$client = CustodiaData::getLike("id", $_GET["id"]);	
        }else{
            if(isset($_GET['id'])){
        		$client = CustodiaData::getLike("id", $_GET["id"]);	
        		$idruta = $_GET["id"];
        	}
        }
        
        break;
    case 'POST':
        $mensaje = "verificacion del vehiculo";
		$enlaces = "Crear";
		$user = new CustodiaData();
		
		$user->municion = $_POST["municion"];
		$user->vehiculo = $_POST["idcarro"];
		$user->nombre = strtoupper($_POST['nombre']);
		$user->cedula = $_POST["cedula"];
		$user->kilometraje = $_POST["telefono"];
		$user->fecha = $_POST["ini_fec"];
		
		//Revision Vehicular
        $user->id = $_POST["entrega_id"];
        $user->llantas = $_POST["llantas"];
        $user->ollantas = $_POST["ollantas"];
        $user->rayones = $_POST["rayones"];
        $user->orayones = $_POST["orayones"];
        $user->espejos = $_POST["espejos"];
        $user->oespejos = $_POST["oespejos"];
        $user->puertas1 = $_POST["puertas1"];
        $user->opuertas1 = $_POST["opuertas1"];
        $user->capo = $_POST["capo"];
        $user->ocapo = $_POST["ocapo"];
        $user->balde = $_POST["balde"];
        $user->obalde = $_POST["obalde"];
        $user->guias1 = $_POST["guias1"];
        $user->oguias1 = $_POST["oguias1"];
        $user->guias2 = $_POST["guias2"];
        $user->oguias2 = $_POST["oguias2"];
        $user->luces = $_POST["luces"];
        $user->oluces = $_POST["oluces"];
        $user->motor = $_POST["motor"];
        $user->anomalia = $_POST["anomalia"];
        $user->asientos = $_POST["asientos"];
        $user->oasientos = $_POST["oasientos"];
        $user->panel = $_POST["panel"];
        $user->opanel = $_POST["opanel"];
        $user->cinturon = $_POST["cinturon"];
        $user->ocinturon = $_POST["ocinturon"];
        $user->forros = $_POST["forros"];
        $user->oforros = $_POST["oforros"];
        $user->elevadores = $_POST["elevadores"];
        $user->oelevadores = $_POST["oelevadores"];
        $user->aire = $_POST["aire"];
        $user->oaire = $_POST["oaire"];
        $user->parabrisa = $_POST["parabrisa"];
        $user->oparabrisa = $_POST["oparabrisa"];
        $user->emergencia = $_POST["emergencia"];
        $user->oemergencia = $_POST["oemergencia"];
        $user->extintor = $_POST["extintor"];
        $user->oextintor = $_POST["oextintor"];
        $user->techo = $_POST["techo"];
        $user->otecho = $_POST["otecho"];
        $user->puertas2 = $_POST["puertas2"];
        $user->opuertas2 = $_POST["opuertas2"];
        $user->enciende = $_POST["enciende"];
        $user->oenciende = $_POST["oenciende"];
        $user->aceite = $_POST["aceite"];
        $user->oaceite = $_POST["oaceite"];
        $user->hidraulico = $_POST["hidraulico"];
        $user->ohidraulico = $_POST["ohidraulico"];
        $user->freno = $_POST["freno"];
        $user->ofreno = $_POST["ofreno"];
        $user->refrigerante = $_POST["refrigerante"];
        $user->orefrigerante = $_POST["orefrigerante"];
        
        if($_POST["entrega_id"] == 0){
		    $user->add();
		    
			$valor = $user->getCodigo();
			$_SESSION["entrega_id"] = $valor->id;
		}else{
		    $_SESSION["entrega_id"] = $_POST["entrega_id"];
		    $user->update();
		}
		
        $idruta = $_SESSION["entrega_id"];
		Core::redir("index.php?view=vehiculo&id=".$_SESSION["entrega_id"]);
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php if($idruta == "") echo 'Acta de Entrega'; else echo 'Hoja de Ruta Nro. '.$idruta; ?>
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo $_SESSION["url"]; ?>vehiculos"><i class="fa fa-database"></i> Vehiculos </a></li>
		<li class="active"> Entregas </li>
	</ol>
</section>
</br>
<section id="main" role="main">
  <div class="container-fluid">
    <form class="form-horizontal" method="post" id="addcotizacion" name="addcotizacion" action="<?php echo $_SESSION["url"]; ?>vehiculo" role="form">	
		<input type="hidden" id="entrega_id" name="entrega_id" value="<?php echo $idruta; ?>">
		<input type="hidden" id="oficio" name="oficio" value="<?php echo $oficio; ?>">
		<div class="callout callout-danger" style="margin-bottom: 0!important;">
			<button type="submit" class="btn btn-success pull-right"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar </button>
			<h4><strong><i class="fa fa-bullhorn"></i> Importante...!</strong></h4>
			Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</div></br>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informaci&oacute;n del del cliente</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="chasis" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Nro. Chasis:</label>
					<div class="col-md-4 col-sm-4">
						<input class="form-control" id="chasis" name="chasis" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" data-mask placeholder="9999999999" value="<?php echo $client->cedula; ?>" required pattern="^[0-9]{10}" title="Solo números. Tamaño obligatorio: 10">
					</div>
					<label for="cedula" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Año:</label>
					<div class="col-md-2 col-sm-2">
						<input class="text-field form-control input-sm" id="ano" name="ano" type="text" placeholder="2005" value="<?php echo $client->ano; ?>" minlength="4" maxlength="4" title="Tamaño mínimo: 4" required autofocus>
					</div>
				</div>
				<div class="form-group">
					<label for="combustible" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Combustible:</label>
					<div class="col-md-4 col-sm-4">
					    <select id="combustible" name="combustible" class="form-control select2" style="width: 100%;">
					        <option value="0"> -- SELECCIONE -- </option>
					        <option value="ECO">ECO</option>
					        <option value="SUPER">SUPER</option>
					        <option value="GAS NATURAL">GAS NATURAL</option>
					        <option value="ELECTRICO">ELECTRICO</option>
					        <option value="DISEL">DISEL</option>
					    </select>
					</div>					
					<label for="tanque" class="col-md-2 col-sm-2 control-label">Capacidad Max:</label>
					<div class="col-md-4 col-sm-4">
						<input type="number" class="form-control" id="tanque" name="tanque" minlength="1" maxlength="3" data-inputmask='"mask": "999"' data-mask placeholder="12" value="<?php echo $client->tanque; ?>" pattern="[0-9]{13}" title="Solo números, debe ser el tamaño del tanque" required>
					</div>
				</div>
				<div class="form-group">
				    <label for="municion" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Observaciones:</label>
					<div class="col-md-4 col-sm-4">
						<input type="text" class="form-control" id="municion" name="municion" minlength="1" maxlength="2" data-inputmask='"mask": "99"' data-mask placeholder="12" value="<?php echo $client->municion; ?>" pattern="[0-9]{13}" title="Solo números, debe ser el numero la orden" required>
					</div>
					<label for="telefono" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Matriculaci&oacute;n:</label>
					<div class="col-md-2 col-sm-2">
						<div class="input-group date form_date col-md-2 col-sm-6" data-date-format="yyyy-mm-dd">
							<input type="date" class="form-control" id="ini_fec" name="ini_fec" value="<?php echo $client->fecha; ?>" required="required" minlength="10" title="Debe de ser una fecha valida">
						</div>
					</div>
				</div>
				<br>	
			</div>
		</div>
  	</form>
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
<!--/ END To Top Scroller -->
<script>
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Registro de Vehiculos";
</script>
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
