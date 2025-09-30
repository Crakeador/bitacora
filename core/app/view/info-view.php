<?php 
// Visor de Imagenes para la Bitacora
date_default_timezone_set('America/Guayaquil');

if(isset($_GET['id'])){
    $_SESSION['id_person'] = $_GET['id'];
    $id_person = $_GET['id'];
	if($_GET['ruta']==7) 
        $person = VisitasData::getById($_GET['id']); 
	else
        $person = BitacoraData::getById($_GET['id']); 
	
    $vistas = $person->vistas + 1;
    
	if($_GET['ruta']==4) 
		$cambio = 'index.php?view=fechas'; 
	elseif($_GET['ruta']==3) 
		$cambio = 'index.php?view=partes'; 
	elseif($_GET['ruta']==7)
	    $cambio = 'index.php?view=visitas'; 
	else
		$cambio = 'index.php?view=bitacora'; 
    
    if($_GET['ruta']==1) $ruta = 'novedad';
    if($_GET['ruta']==2) $ruta = 'ingreso';
    if($_GET['ruta']==4) $ruta = 'novedad';
    if($_GET['ruta']==3) $ruta = 'parte';
    if($_GET['ruta']==5) $ruta = 'supervicion';
    if($_GET['ruta']==6) $ruta = 'rondas';
    if($_GET['ruta']==7) $ruta = 'visitas';
    if($_GET['ruta']==8) $ruta = 'custodia';
    
	if($person->foto1 == ""){
        $nombre_fichero1 = 'storage/persons/american.png';
    }else{
		$nombre_fichero1 = "storage/".$ruta."/".$person->foto1;
    }
    if($person->foto2 == ""){
        $nombre_fichero2 = 'storage/persons/american.png';
    }else{
        $nombre_fichero2 = "storage/".$ruta."/".$person->foto2; $fotos2 = 1;
    }    
    if($person->foto3 == ""){
        $nombre_fichero3 = 'storage/persons/american.png';
    }else{    
        $nombre_fichero3 = "storage/".$ruta."/".$person->foto3; $fotos3 = 1;
    }    
    if($person->foto4 == ""){
        $nombre_fichero4 = 'storage/persons/american.png';
    }else{    
        $nombre_fichero4 = "storage/".$ruta."/".$person->foto4; $fotos4 = 1;
    }    
    if($person->foto5 == ""){
        $nombre_fichero5 = 'storage/persons/american.png';
    }else{
        $nombre_fichero5 = "storage/".$ruta."/".$person->foto5; $fotos5 = 1;
    }    
    if($person->foto6 == ""){
        $nombre_fichero6 = 'storage/persons/american.png';
    }else{
        $nombre_fichero6 = "storage/".$ruta."/".$person->foto6; $fotos6 = 1;
    }    
    $sumas = BitacoraData::updateVista($_GET['id'], $vistas);
    
	$user = new BitacoraData();
	$user->idbitacora =  $_GET['id'];
	$user->tipo = 'Bitacora';
	$user->fecha = date("Y-m-d H:i:s"); 
	
	$sumas = $user->addVista();
}else{
	// Mensaje de Error
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora
		<small>vista de las fotos de la bitacora</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php if($_SESSION['idrol'] == 8) echo 'fechas'; else if($_SESSION['idrol'] == 12) echo 'bitacora'; else echo $cambio; ?>"><i class="fa fa-database"></i> Bitacora </a></li>
		<li class="active"> Administrativo </li>
	</ol>
</section>
<section id="main" role="main">
    </br>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
        		<div class="row">
        			<div class="col-md-5 col-sm-6 col-xs-12 visorImg">
        			    <?php 
						  echo '<div class="flexslider">
								  <ul class="slides">
										<li class+ "flex-active-slide" style="width: 100px; float: left; display: block;">
										  <img value="2" class="img-thumbnail" src="'.$nombre_fichero2.'" alt="Imagen 2" draggable="false">
										</li>
										<li style="width: 100px; float: left; display: block;">
										  <img value="3" class="img-thumbnail" src="'.$nombre_fichero3.'" alt="Imagen 3" draggable="false">
										</li>
										<li style="width: 100px; float: left; display: block;">
										  <img value="4" class="img-thumbnail" src="'.$nombre_fichero4.'" alt="Imagen 4" draggable="false">
										</li>
										<li style="width: 100px; float: left; display: block;">
										  <img value="5" class="img-thumbnail" src="'.$nombre_fichero5.'" alt="Imagen 5" draggable="false">
										</li>
										<li style="width: 100px; float: left; display: block;">
										  <img value="6" class="img-thumbnail" src="'.$nombre_fichero6.'" alt="Imagen 6" draggable="false">
										</li>
										<li style="width: 100px; float: left; display: block;">
										  <img value="1" class="img-thumbnail" src="'.$nombre_fichero1.'" alt="Imagen 1" draggable="false">
										</li>
									</ul>
								</div>';
            			?>
					</div>
        			<div class="col-md-7 col-sm-6 col-xs-12">
        				<h1 class="text-muted text-uppercase"><?php echo $person->proceso; ?></h1>
        				<p><?php echo $person->observacion; ?></p>	
						<?php 
							if($person->manzana == ""){
								echo '';
								if($person->proceso == 'Supervision'){
    								echo '<p>
    										<small>
    											<span class="glyphicon glyphicon-Home text-success"></span>';
    											if($person->accion == ""){
    											    //Sin Novedad
    											}else{
    											    echo '<span class="text-success"><p>Acciones: '.$person->accion.'</p></span></br>';
    											}
    											    
    								        echo '<span class="text-success">Logistica: '.substr($person->observaciono,-60, -2).'.</span>
    								  	    </small>
    								      </p>';
								}
							}else{
								echo '<p>
										<small>
											<span class="glyphicon glyphicon-Home text-success"></span>&nbsp;
											<span class="text-success">Manzana '.$person->manzana.' - Villa '.$person->villa.'</span>
								 	    </small>
								      </p>';
							}
						?>
        				<div class="form-group row">
        					<h4 class="col-md-12 col-sm-0 col-xs-0">
        						<hr>
        						<span class="label label-default" style="font-weight:100">
        							<i class="fa fa-clock" style="margin-right:5px"></i> Reportado el: <?php echo $person->fecha; ?>  |
        							<i class="fa fa-eye" style="margin:0px 5px"></i> Visto por <span class="vistas" tipo="0"><?php echo $vistas; ?></span> personas  
        						</span>
        					</h4>
        				</div>
        				<?php
						    if($_SESSION['idrol'] == 8){
						        // No hay Acciones
						    }else{
                				$permiso = BitacoraData::getVistas($_GET['id']); 
                				
                				if($permiso){ ?>
                    				<table class="table table-hover">
                    					<thead>
                    			    	 <tr>
                    						<th align="center" valign="middle">Nombres y Apellidos</th>
                    						<th align="center" width="20%" valign="middle"><div align="center">Verificado</div></th>
                    						<th align="center"><div align="center">Autorizado</div></th>
                    					 </tr>
                    					</thead>
                    					<tbody><?php
                							// Crea tabla de Permisos autorizados
                							foreach($permiso as $tables) {
                								echo '<tr>';
                									echo '<td>'.$tables->usuario_log.'</td>';
                									echo '<td><div align="center">'.$tables->fecha.'</div></td>';
                									echo '<td align="center">'.$tables->ip.'</td>';
                								echo '</tr>';
                							} ?>
                    					</tbody>
                    				</table> <?php
                    			} 
                    		} 
                    	?>
        		    </div>
        		</div>
            </div>
        </div>
    </div>
</section>
<!--/ END To Top Scroller --> 
<script>
    document.title = "Near Solutions | Verificacion de la Bitacora";
    
    // Can also be used with $(document).ready()
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide"
      });
    });
</script>