<?php 
if(isset($_GET["id"])){
	$user = DepartamentoData::getById($_GET["id"]); 
}else{	
	Core::alert("Error...!!!!", "No selecciono ningun departamento", "error");	
	Core::redir('home&error=1');
}
?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Departamento</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updadepartamento" role="form">
		  <div class="form-group">
		    <label for="inputDepartamento" class="col-lg-2 control-label"><span class="text-danger">*</span> Departamento:</label>
		    <div class="col-md-6">
		      <input type="text" name="description" value="<?php echo $user->description; ?>" class="form-control" id="description" placeholder="Nombre">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		    	<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
		      <button type="submit" class="btn btn-primary">Actualizar Departamento</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
