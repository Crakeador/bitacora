<?php 
// Visor de Imagenes para la Bitacora
if(isset($_GET['id'])){
    $person = BitacoraData::getById($_GET['id']); 

    $vistas = $person->vistas + 1;
    $_SESSION['id_person'] = $_GET['id'];
    $id_person = $_GET['id'];
    
    if($_GET['ruta']==4) 
		$cambio = 'index.php?view=fechas'; 
	else 
		if($_GET['ruta']==3) 
			$cambio = 'index.php?view=parte'; 
		else 
			$cambio = 'index.php?view=verificados'; 
    
    if($_GET['ruta']==1) $ruta = 'novedad'; 
    if($_GET['ruta']==2) $ruta = 'fotos';
    if($_GET['ruta']==3) $ruta = 'parte';	
    if($_GET['ruta']==4) $ruta = 'novedad'; 
    if($_GET['ruta']==5) $ruta = 'supervicion';
    
	if($person->foto2 == ""){
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
		<li><a href="<?php echo $cambio; ?>"><i class="fa fa-database"></i> Bitacora </a></li>
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
        				<h3class="text-muted text-uppercase"><?php echo $person->proceso; ?></h3>
        				<p><?php echo $person->observacion; ?></p>	
						<?php 
							if($person->manzana == "")
								echo '';
							else
								echo '<p>
										<small>
											<span class="glyphicon glyphicon-Home text-success"></span>&nbsp;
											<span class="text-success">Manzana '.$person->manzana.' - Villa '.$person->villa.'</span>
										</small>
									  </p>';
						?>
        				<div class="form-group row">
        					<h4 class="col-md-12 col-sm-0 col-xs-0">
        						<hr>
        						<span class="label label-default" style="font-weight:100">
        							<i class="fa fa-clock" style="margin-right:5px"></i> Reportado el: <?php echo $person->fecha; ?>  </br>
        							<i class="fa fa-eye" style="margin:0px 5px"></i> Visto por <span class="vistas" tipo="0"><?php echo $vistas; ?></span> personas  
        						</span>
        					</h4>
        				</div>						
						<form class="form-horizontal" method="post" id="addtask" action="index.php?view=categorias" role="form">				
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" class="form-control" name="categorie-name" placeholder="Nombre de la categoría" required>
								</div>
							</div>
							<button type="submit" name="add_cat" class="btn btn-danger">Verificar</button>
						</form>
        		    </div>
        		</div>
            </div>
        </div>
    </div>
</section>
<!--/ END To Top Scroller -->
<script>
    document.title = "Near Solution | Verificacion de Foto";
    
    // Can also be used with $(document).ready()
    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide"
      });
    });
</script>