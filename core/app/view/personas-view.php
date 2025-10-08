<?php
// Listado de los puesto de servicio de los guardias
$puestos = PuestoData::getAll(2); $lugar = '';

$activo = 0; $activa = 0; $users = array();
if(isset($_GET['status'])){
	$lugar = new UnionData();

	$lugar->id = $_GET['status']; 
	$lugar->is_active = 0;

	$valor = $lugar->del();
	$lugar=$_SESSION['id'];
}

if(isset($_GET['id'])){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
	
	if($lugar == 99){
		$users = PuestoData::getAsignar();
	}else{
		$users = PuestoData::getAllpuesto($lugar, 1);			
	}
	
	$userf = PuestoData::getAllpuesto($lugar, 0);
	$activo = count($users);
	$activa = count($userf);
}else{
	if(isset($_SESSION['id'])){
		//$lugar=$_SESSION['id'];
	}else{
		$lugar = '';
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Puestos
		<small>listado de los agentes asignados</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
  <div class="box box-primary">
    <div class="box-header">
		Oficina:&nbsp;&nbsp;
		<label>
			<?php
				echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?view=personas&id=\'+value;">';
				echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
				echo '<option value="99"> -- TODOS LOS AGENTES -- </option>';
				foreach($puestos as $tables) {
					if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
					echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
				}
				echo '</select>';
			?>
		</label>  
		<a href="persona" class="btn btn-success btn-sm">
			<i class="fa fa-plus"></i> Ingresar un efectivo
		</a>
	</div>
	<!-- tabs -->
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Activos</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="Agentes activos"><?php echo $activo; ?></span></a>
		</li>
		<li>
			<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Inactivos</b>&nbsp;&nbsp;<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="Agentes inactivos"><?php echo $activa; ?></span></a>
		</li>
	</ul>
	<div class="box-body">
	  <?php
		if($lugar==''){
		  $users = array();
		  echo '<p class="alert alert-success">';
			echo '<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>';
			echo '</br>- Debe de selecionar un nuevo opcion...!!!';
		  echo '</p>';
		}else{
		  if(count($users) == 0){
			echo '<p class="alert alert-danger">';
			  echo '<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>';
			  echo '</br>- No hay agentes asignados a este puesto de manera permanente...!!!';
			echo '</p>';
		  }else{
			echo '<div class="tab-content panel">';
				echo '<div class="tab-pane active" id="tab_activos">';
					echo '<div class="content_tabs">';
						echo '<table id="viewactivo" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="viewlista_info">';
						  echo '<thead>';
							echo '<tr>';                          
							  echo '<th width="20%"><div align="center">Puesto</div></th>';
							  echo '<th width="40%"><div align="center">Agente</div></th>';                            
							  echo '<th><div align="center">Direcci&oacute;n</div></th>';                         
							  echo '<th width="12%"><div align="center">Activado</div></th>';
							echo '</tr>';
						  echo '</thead>';
						  echo '<tbody>';
							for($i=0; $i < count($users); $i++){
							  if($users[$i]->is_active == 0){ 
								$cadena = '<span class="pull-right badge bg-red">Inactivo'; 
							  }else{ 
								$cadena = '<span class="pull-right badge bg-green">&nbsp;&nbsp;Activo&nbsp;&nbsp;'; 
							  }
							  echo '<tr>'; 
								if($users[$i]->descripcion == ''){
								  echo '<td>Sin asignar</td>';
								}else{                 
								  echo '<td>';
									echo $users[$i]->descripcion;
									echo '</br>';
									echo '<small>';
									  echo '<a href="index.php?view=persona&id='.$users[$i]->servicio.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
									  echo '<a href="index.php?view=personas&status='.$users[$i]->servicio.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>&nbsp;';
									  echo $users[$i]->lugar;
									echo '</small>';
								  echo '</td>';
								}
								echo '<td>';
								  echo $users[$i]->idcard.'-'.$users[$i]->name;
								  echo '</br>';
								  echo '<small>';
									if($users[$i]->demanda == 0){
									  echo '<span class="label label-success">&nbsp;&nbsp;&nbsp;&nbsp;Sin demanda&nbsp;&nbsp;&nbsp;&nbsp;</span>';
									}else{
									  echo '<span class="label label-danger">Esta demandado&nbsp;&nbsp;</span>';
									}
									echo '&nbsp;'.$users[$i]->fechanacimiento;
								  echo '</small>';
								echo '</td>';
								echo '<td>'.$users[$i]->direccion.'</br>'.$cadena.'</span></td>';
								echo '<td><div align="center">'.$users[$i]->created_at.'</div></td>';
							  echo '</tr>';
							}
						  echo '</tbody>';
						echo '</table>';					
					echo '</div>';
				echo '</div>';
				echo '<div class="tab-pane" id="tab_inactivos">';					
					echo '<div class="content_tabs">';	
						echo '<table id="viewactivo" class="table table-bordered table-hover dataTable no-footer dtr-inline" role="grid" aria-describedby="viewlista_info">';
						  echo '<thead>';
							echo '<tr>';                          
							  echo '<th width="20%"><div align="center">Puesto</div></th>';
							  echo '<th width="40%"><div align="center">Agente</div></th>';                            
							  echo '<th><div align="center">Direcci&oacute;n</div></th>';                         
							  echo '<th width="12%"><div align="center">Activado</div></th>';
							echo '</tr>';
						  echo '</thead>';
						  echo '<tbody>';
							for($i=0; $i < count($userf); $i++){
							  if($userf[$i]->is_active == 0){ 
								$cadena = '<span class="pull-right badge bg-red">Inactivo'; 
							  }else{ 
								$cadena = '<span class="pull-right badge bg-green">&nbsp;&nbsp;Activo&nbsp;&nbsp;'; 
							  }
							  echo '<tr>'; 
								if($userf[$i]->descripcion == ''){
								  echo '<td>Sin asignar</td>';
								}else{                 
								  echo '<td>';
									echo $userf[$i]->descripcion;
									echo '</br>';
									echo '<small>';
									  echo '<a href="index.php?view=persona&id='.$userf[$i]->servicio.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
									  echo '<a href="index.php?view=personas&status='.$userf[$i]->servicio.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>&nbsp;';
									  echo $userf[$i]->lugar;
									echo '</small>';
								  echo '</td>';
								}
								echo '<td>';
								  echo $userf[$i]->name.' '.$userf[$i]->name2.' '.$userf[$i]->lastname.' '.$userf[$i]->lastname2;
								  echo '</br>';
								  echo '<small>';
									if($userf[$i]->demanda == 0){
									  echo '<span class="label label-success">&nbsp;&nbsp;&nbsp;&nbsp;Sin demanda&nbsp;&nbsp;&nbsp;&nbsp;</span>';
									}else{
									  echo '<span class="label label-danger">Esta demandado&nbsp;&nbsp;</span>';
									}
									echo '&nbsp;'.$userf[$i]->cargo.'('.$userf[$i]->fechanacimiento.')';
								  echo '</small>';
								echo '</td>';
								echo '<td>'.$userf[$i]->direccion.'</br>'.$cadena.'</span></td>';
								echo '<td><div align="center">'.$userf[$i]->created_at.'</div></td>';
							  echo '</tr>';
							}
						  echo '</tbody>';
						echo '</table>';	
					echo '</div>';
				echo '</div>';
			echo '</div>';
		  }
		} ?>
	</div>
  </div>
</section>
<script>document.title = "Near Solutions | Agentes asignados"</script> 