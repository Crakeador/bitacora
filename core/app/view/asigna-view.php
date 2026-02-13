<div class="row">
	<div class="col-md-12">
		<h1>Tareas</h1>
		<p>Aqui puedes ver y administrar tus tareas.</p>
		<div class="btn-group">
			<a href="index.php?view=newtarea" class="btn btn-default"><i class='fa fa-th-list'></i> Nueva Tarea</a>
		</div>
		<br><br>
		<?php

		$user = UserData::getById($_SESSION["user_id"]);
		$tareas = TareaData::getAllByUserId($user->id);
		if(count($tareas)>0){
			?>
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Tareas</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered datatable table-hover">
						<thead>
							<th>Titulo</th>
							<th>Descripcion</th>
							<th>Fecha de entrega</th>
							<th></th>
						</thead>
						<?php
						foreach($tareas as $tarea){
							?>
							<tr>
								<td><?php echo $tarea->title; ?></td>
								<td><?php echo $tarea->description; ?></td>
								<td><?php echo $tarea->due_date; ?></td>
								<td style="width:130px;">
									<a href="index.php?view=edittarea&id=<?php echo $tarea->id;?>" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
									<a href="index.php?action=deltarea&id=<?php echo $tarea->id;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
			<?php
		}else{
			echo "<p class='alert alert-info'>No hay tareas</p>";
		}
		?>
	</div>
</div>
