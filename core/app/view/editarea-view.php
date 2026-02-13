<?php
$tarea = TareaData::getById($_GET["id"]);
?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Tarea</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=updatetarea" role="form">


  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Titulo*</label>
    <div class="col-md-6">
      <input type="text" name="title" value="<?php echo $tarea->title; ?>" class="form-control" id="title" placeholder="Titulo">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Descripcion*</label>
    <div class="col-md-6">
      <textarea name="description" class="form-control" id="description" placeholder="Descripcion"><?php echo $tarea->description; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Fecha de entrega*</label>
    <div class="col-md-6">
      <input type="date" name="due_date" value="<?php echo $tarea->due_date; ?>" class="form-control" id="due_date" placeholder="Fecha de entrega">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="id" value="<?php echo $tarea->id; ?>">
      <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
    </div>
  </div>
</form>
	</div>
</div>