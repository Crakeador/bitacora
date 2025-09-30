<?php
// Control de Nomina

if(isset($_POST['description'])){	
	$control = new OperationTypeData();	
	$control->name = $_POST['description'];
	$control->addObserva(27, 'Cotizaciones');	
	
	Core::redir('cotizar&id='.$_POST['cotizacion_id']);
}

?>
<section class="content-header">
	<h1>
		Observaciones
		<small>ingreso de observaciones nuevas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=cotizar&id=<?php echo $_GET['id']; ?>"><i class="fa fa-database"></i> Asignacion </a></li>
		<li class="active">Cotizacion Nr. <?php echo $_GET['id']; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="row">
		<div class="col-md-12">
			<h1>Ingreso una observaci&oacute;n</h1>
			<br>
			<form class="form-horizontal" method="post" id="addcategory" action="index.php?view=newobserva" role="form">				
				<input type="hidden" id="cotizacion_id" name="cotizacion_id" value="<?php echo $_GET['id']; ?>">
				<div class="form-group">
					<div class="col-md-6">
						<input type="text" name="description" required class="form-control" id="description" placeholder="Nombre">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-primary">Agregar Observaci&oacute;n</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script>    
	var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de Observaciones";  
</script>
