<?php 
// Visor de Imagenes para la Bitacora
date_default_timezone_set('America/Guayaquil');

if(isset($_GET['id'])){
    $autoriza = $_GET['id']; 
	$vistas = 0;/*
    $datos = VisitasData::getById($_GET['id']); 
    $vistas = $datos->vistas + 1; */
    
	$datos = AutorizanData::getById($_GET['id']); 
	if($datos->idbitacora == ""){
        $nombre_fichero1 = 'storage/persons/american.png';
		$nombre_fichero2 = 'storage/persons/american.png';
		$nombre_fichero3 = 'storage/persons/american.png';
    }else{
		$fotos = FotosData::getById($datos->idbitacora); 

		foreach($fotos as $tables) {
			if($tables->tipo == "documento"){
				if (file_exists("storage/visitas/".$tables->nombre_archivo)) {
					$nombre_fichero1 = "storage/visitas/".$tables->nombre_archivo;
				}else{
					$nombre_fichero1 = 'storage/persons/american.png';
				}
			}
			if($tables->tipo == "rostro"){
				if (file_exists("storage/visitas/".$tables->nombre_archivo)) {
					$nombre_fichero2 = "storage/visitas/".$tables->nombre_archivo;
				}else{
					$nombre_fichero2 = 'storage/persons/american.png';
				}
			}
			if($tables->tipo == "vehículo"){
				if (file_exists("storage/visitas/".$tables->nombre_archivo)) {
					$nombre_fichero3 = "storage/visitas/".$tables->nombre_archivo;
				}else{
					$nombre_fichero3 = 'storage/persons/american.png';
				}
			}

		}
	}
    /*$sumas = BitacoraData::updateVista($_GET['id'], $vistas);
    
	$user = new BitacoraData();
	$user->idbitacora =  $_GET['id'];
	$user->tipo = 'Bitacora';
	$user->fecha = date("Y-m-d H:i:s"); 
	
	$sumas = $user->addVista(); */
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
										  <img value="1" class="img-thumbnail" src="'.$nombre_fichero1.'" alt="Imagen 1" draggable="false">
										</li>
									</ul>
								</div>';
            			?>
					</div>
        			<div class="col-md-7 col-sm-6 col-xs-12">
        				<h1 class="text-muted text-uppercase"><?php echo $datos->cedula.'-'.$datos->nombre; ?></h1>
        				<p><?php echo $datos->observacion; ?></p>	
						<p>
							<small>
								<span class="glyphicon glyphicon-Home text-success"></span>&nbsp;
								<span class="text-success">Manzana <?php echo $datos->manzana; ?> - Villa <?php echo $datos->villa; ?></span>
							</small>
						</p>
        				<div class="form-group row">
        					<h4 class="col-md-12 col-sm-0 col-xs-0">
        						<hr>
        						<span class="label label-default" style="font-weight:100">
        							<i class="fa fa-clock" style="margin-right:5px"></i> Reportado el: <?php echo $datos->fecha; ?>  |
        							<i class="fa fa-eye" style="margin:0px 5px"></i> Visto por <span class="vistas" tipo="0"><?php echo $vistas; ?></span> personas  
        						</span>
        					</h4>
        				</div>
        				<?php /*
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
                    		}  */
                    	?>
        		    </div>
        		</div>
            </div>
        </div>
    </div>
</section>
<!--/ END To Top Scroller --> 
<script>
    document.title = "Near Solution | Verificacion de la Bitacora";
    
    // Can also be used with $(document).ready()
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide"
      });
    });
</script>