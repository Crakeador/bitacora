<?php
//Vista del perfil del cliente
if(count($_POST)>0){
  $cadena = '';
	$nombre = UserData::getById($_SESSION["user_id"])->name.' '.UserData::getById($_SESSION["user_id"])->lastname;
  if($_POST["seguimiento"] == 8) 
    $cadena = 'Ganada'; 
  else
    if($_POST["prioridad"] == 1) $cadena = 'Llamada'; elseif($_POST["prioridad"] == 2) $cadena = 'Mailing'; else $cadena = 'Visita';

  if($_POST["monto"] != '') $monto = $_POST["monto"]; else $monto = 0;
  
  if($_POST["producto"] == 1) $producto = "Seguridad Electronica"; 
  if($_POST["producto"] == 2) $producto = "Clearspeed"; 
  if($_POST["producto"] == 3) $producto = "Consultoria"; 
  if($_POST["producto"] == 4) $producto = "Armas"; 
  if($_POST["producto"] == 5) $producto = "Accesorios Tacticos"; 
  if($_POST["producto"] == 6) $producto = "MOC"; 
  if($_POST["producto"] == 7) $producto = "Escuela de Tiro";  
  if($_POST["producto"] == 8) $producto = "Seguridad Fisica"; 

	$user = new TimelineData();
	$user->idclient = $_GET["id"];
	$user->idperson = $_SESSION["user_id"];
	$user->quien_asigna = $nombre;
	$user->status = $_POST["producto"];
	$user->title = $_POST["descripcion"];
	$user->body = $_POST["mensaje"];
	$user->asunto = "";
	$user->monto = $monto;
	$user->prioridad = $_POST["prioridad"];
	$user->resultado = $_POST["resultado"];
  $user->seguimiento = $_POST["seguimiento"];
	$user->date_event = $_POST["fecha"];
	$user->date_pass = $_POST["alerta"];
  
	$user->add_info();
  $estado = new ComercialData();
  $estado->id = $_GET["id"];
  $estado->gestion = $cadena;
  $estado->monto = $monto;
  $estado->producto = $producto;
  $estado->observacion = $_POST["descripcion"];

  $estado->estado();
	//Core::redir("informa&id=".$_GET["id"]);
}
$empresa = ComercialData::getById($_GET["id"]);
$totalLlam = TimelineData::getByTipo($_GET["id"], 1);
$totalMail = TimelineData::getByTipo($_GET["id"], 2);
$totalVisi = TimelineData::getByTipo($_GET["id"], 3);

$ano=date("Y");
$events = TimelineData::getClient($_GET["id"], $ano);

?>
<section class="content-header">
  <h1>
    Datos de la Empresa
    <small>Perfil</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="home"><i class="fa fa-dashboard"></i> Inicio </a></li>
    <li><a href="<?php echo $_SESSION['url']; ?>ventas">Clientes</a></li>
    <li class="active">Informacion</li>
  </ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <h3 class="profile-username text-center"><?php echo $empresa->nombre; ?></h3>
          <p class="text-muted text-center"><?php echo $empresa->contacto; ?></p>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Llamadas</b> <a class="pull-right"><?php echo $totalLlam->total; ?></a>
            </li>
            <li class="list-group-item">
              <b>Mailing</b> <a class="pull-right"><?php echo $totalMail->total; ?></a>
            </li>
            <li class="list-group-item">
              <b>Visitas</b> <a class="pull-right"><?php echo $totalVisi->total; ?></a>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Acerca de</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong><i class="fa fa-book margin-r-5"></i> Creado el</strong>
          <p class="text-muted">
            <?php echo $empresa->created_at; ?>
          </p>
          <hr>
          <strong><i class="fa fa-book margin-r-5"></i> Modificado el</strong>
          <p class="text-muted">
            <?php echo $empresa->update_at; ?>
          </p>
          <hr>
          <strong><i class="fa fa-file-text-o margin-r-5"></i> Observacion</strong>
          <p><?php echo $empresa->observacion; ?></p>
          <hr>
          <strong><i class="fa fa-book margin-r-5"></i> Telefonos</strong>
          <p class="text-muted">
            <?php echo $empresa->telefono1; if($empresa->telefono2 != '') echo ' / '.$empresa->telefono2; ?>
          </p>
          <hr>
          <strong><i class="fa fa-map-marker margin-r-5"></i> Ubicacion</strong>
          <p class="text-muted"><?php echo $empresa->direccion; ?></p>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="true">Timeline</a></li>
          <li class="pull-right"><a href="#" class="text-muted" data-toggle="modal" data-target="#modalActividad"><span data-toggle="tooltip" title="" data-original-title="Ingresar las acciones">AGREGAR ACCIONES <i class="fa fa-gear"></i></span></a></li>
        </ul>
        <div class="tab-content">
          <!-- /.tab-pane -->
          <div class="tab-pane active" id="timeline"><?php
              // The timeline 
              $valor = count($events);

              if(count($events) > 0){                
                  echo '<ul class="timeline timeline-inverse">';
                  $fecha = '';
                  foreach($events as $product) {
                    if($product->prioridad == 1) $prioridad = 'purple'; 
            				if($product->prioridad == 2) $prioridad = 'yellow'; 
            				if($product->prioridad == 3) $prioridad = 'red';  
            				if($product->prioridad == 4) $prioridad = 'green';  
                			
                    $pos = strpos($product->idperson, ',');	
                    if ($pos === false) {
                      if($product->idperson > 0){
                        $nombre = UserData::getById($product->idperson)->name.' '.UserData::getById($product->idperson)->lastname;
                      }
                    }else{
                      $array = explode (',', $product->idperson);                        
                      foreach ($array as $palabra) {
                        $valor = (int) $palabra;
                        if($valor > 0) $nombre = UserData::getById($palabra)->name.' '.UserData::getById($palabra)->lastname;
                      }
                    }
            				
            				if($product->date_event == $fecha){
      								//Error
            				}else{
            				  $fecha=$product->date_event;
                      echo '<li class="time-label">';
                          echo '<span class="bg-red">';
                              echo substr($product->date_event, 0, 10); //date_format(, 'Y-m-d');
                          echo '</span>';
                      echo '</li>';    				    
            				}
            				
            				if($product->prioridad == 1) $tipo = 'phone';
            				if($product->prioridad == 2) $tipo = 'eyedropper';
            				if($product->prioridad == 3) $tipo = 'comments';

                    if($product->status == 1) $estilo = '<div class="text-green"><i class="fa fa-bell"></i> Negociacion en curso &#9733; </div>';
                    if($product->status == 2) $estilo = '<div class="text-yellow"><i class="fa fa-bell"></i> Negociacion en Seguimiento &#9733; &#9733; &#9733; </div>';
                    if($product->status == 3) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> En espera &#9733; &#9733; &#9733; &#9733; &#9733;</div>';
                    if($product->status == 4) $estilo = '<div class="text-blue"><i class="fa fa-bell"></i> Se realizo una visita &#9733; &#9733; &#9733; &#9733; &#9733;</div>';
                    if($product->status == 5) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> Enviar cotizacion &#9733; </div>';
                    if($product->status == 6) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> Negociacon pospuesta &#9733; &#9733; </div>';
                    if($product->status == 7) $estilo = '<div class="text-yellow"><i class="fa fa-bell"></i> En revision &#9733; &#9733; &#9733; </div>';
                    if($product->status == 8) $estilo = '<div class="text-green"><i class="fa fa-bell"></i> Negociacion Ganada &#9733; </div>';
                    if($product->status == 9) $estilo = '<div class="text-red"><i class="fa fa-bell"></i> Negociacion Perdida &#9733; </div>';

                    echo '<li>';
                        echo '<i class="fa fa-'.$tipo.' bg-'.$prioridad.'"></i>';
                        echo '<div class="timeline-item">';
                            if($product->type == 'image') {
                                if($product->date_pass == '')
                                    echo '<span class="time"><i class="fa fa-clock"></i> Aprobado el: '.$product->update_at.'</span>';
                                else
                                    echo '<span class="time"><i class="fa fa-clock"></i> Solicitado el: '.$product->created_at.'</span>';
                            }else{
                                if($product->date_pass == '')
                                    echo '<span class="time"><i class="fa fa-clock"></i> Reportado el: '.$product->update_at.'</span>';
                                else
                                    echo '<span class="time"><i class="fa fa-clock"></i> Asignada el: '.$product->created_at.'</span>';
                            }
                            
                            if($product->resultado == 1) $resultado = '<span>Cotizacion por un monto de: '.$product->monto.'$</span>'; elseif($product->resultado == 2) $resultado = 'Inspeccion'; else $resultado = 'Visita Futura';

                            if($product->prioridad == 1) $cadena = 'Llamada realizada por:'; elseif($product->prioridad == 2) $cadena = 'Mailing realizado por:'; else $cadena = 'Visita realizada por:';
                            echo '<h3 class="timeline-header">'.$cadena.' '.$nombre.'&nbsp;&nbsp;</h3>'; 
                            echo '<div class="timeline-body">';
                                echo '</br>';
                                echo '<p>'.$product->title.'</p></br>';
                                echo '</br>';
                                echo '<p>'.$product->body.'</p></br>';
                                
                                echo '<h3 class="text-primary"><i class="fa fa-info-circle"></i> Acci&oacute;n resultante: '.$resultado.'</h3>';
                            echo '</div>';
                            echo '<div class="timeline-footer">';
                                    echo $estilo;
                            echo '</div>';
                        echo '</div>';
                    echo '</li>';
                  } 
                  echo '<li>
                          <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                      </ul>';
                }else{
                    echo '<div class="callout callout-info">';
                        echo '<h4><i class="fa fa-info"></i> No hay acciones asignadas...!</h4>';
                        echo '<p>Aun no se han asignado acciones a este cliente, por favor espere o consulte con el administrador.</p>';
                    echo '</div>';
                }?>           
          </div>
          <!-- /.tab-pane --> 
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <!-- Modal -->
  <div class="modal fade" id="modalActividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Seguimiento Diario</h4>
        </div>
        <form class="form-horizontal" method="post" action="<?php echo $_SESSION['url']; ?>informa/<?php echo $_GET["id"]; ?>">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <legend>Acciones tomadas</legend>
                <div class="form-group">
                  <label for="fecha" class="col-sm-3 control-label text-right">Fecha:</label>
                  <div class="col-sm-7">
                    <div class="input-group date" id="datetimepicker1">
                        <input type="text" class="form-control" id="fecha" name="fecha" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-remove"></span>
                        </span>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="prioridad" class="col-sm-3 control-label text-right">Acci&oacute;n:</label>
                  <div class="col-sm-6">
                    <select class="form-control" id="prioridad" name="prioridad">
                      <option value="1">Llamada</option>
                      <option value="2">Mailing</option>
                      <option value="3">Visita</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="seguimiento" class="col-sm-3 control-label text-right"> Estado:</label>
                  <div class="col-md-6 col-sm-9">
                    <select class="select-input form-control" id="seguimiento" name="seguimiento">
                      <option value="2"> Seguimiento </option>
                      <option value="5"> Enviar Cotizacion </option>
                      <option value="6"> Negociacion </option>
                      <option value="8"> Ganada </option>
                      <option value="9"> Perdida </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="descripcion" class="col-sm-3 control-label text-right">Descripci&oacute;n:</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="resultado" class="col-sm-3 control-label text-right"> Resultado:</label>
                  <div class="col-md-6">
                    <select class="select-input form-control" id="resultado" name="resultado">
                      <option value="0"> NO APLICA </option>
                      <option value="1"> Cotizaciones </option>
                      <option value="2"> Inspeccion </option>
                      <option value="3"> Visita Futura </option>
                      <option value="4"> Seguimiento Futura </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="producto" class="col-sm-3 control-label text-right"> Producto:</label>
                  <div class="col-md-6">
                    <select class="select-input form-control" id="producto" name="producto">
                      <option value="0"> NO APLICA </option>
                      <option value="1"> Seguridad Electronica </option>
                      <option value="2"> Clearspeed </option>
                      <option value="3"> Consultoria </option>
                      <option value="4"> Armas </option>
                      <option value="5"> Accesorios Tacticos </option>
                      <option value="6"> MOC</option>
                      <option value="7"> Escuela de Tiro</option>
                      <option value="8"> Seguridad Fisica </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="monto" class="col-md-3 col-sm-2 control-label"> Monto:</label>
                  <div class="col-md-6">
                    <input type="number" class="form-control" id="monto" name="monto" placeholder="Monto de la venta...">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <fieldset class="form-fieldset">
                  <legend>Generar alertas</legend>
                  <div class="form-group">
                    <label for="alerta" class="col-md-3 col-sm-3 control-label"> Fecha:</label>
                    <div class="col-md-7 col-sm-4">
                      <div class="input-group date" id="datetimepicker2">
                        <input type="text" class="form-control" id="alerta" name="alerta" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-remove"></span>
                        </span>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mensaje" class="col-md-3 col-sm-3 control-label"> Observacion:</label>
                    <div class="col-md-9 col-sm-4">
                      <textarea class="form-control input-sm" cols="50%" id="mensaje" name="mensaje" rows="4"></textarea>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Asignacion de las tareas";
	
	$(document).ready(function(){
        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
        $(function () {
            $('#datetimepicker2').datetimepicker();
        });
	});
</script>