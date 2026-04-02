
<?php
// Listado de los memos
if(isset($_SESSION["idrol"]) && $_SESSION["idrol"] <= 2){
	$users = TimelineData::getTipe(2);
}else{
	$users = TimelineData::getTime($_SESSION["user_id"], $_SESSION["ano"]);
}
$_SESSION["idtarea"] = 0;

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Gestion Administrativa
		<small>listado de las tareas asignadas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <!-- include toastr and jQuery UI assets if not already loaded -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?php echo $_SESSION["url"]; ?>plugins/jQueryUI/jquery-ui.min.js"></script>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
	    		<div class="box-header with-border">
    				<a id="btn_productos" class="btn btn-success btn-sm" href="tarea">
    					<span class="glyphicon glyphicon-floppy-disk"></span> Crear Tareas
    				</a>
	    		</div>
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<form id='frmC' name='frmC' method='post' action=''>
					    <input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
					    <input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
                        <table id="viewBitacora" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><div align="center">Asignado el</div></th>
                                    <th><div align="center">Entregar el</div></th>
                                    <th width="12%><div align="center">Asignado por</div></th>
                                    <th><div align="center">Asignado a</div></th>
                                    <th width="16%">Asunto</th>
                                    <th width="25%">Descripci&oacute;n</th>
                                    <th width="25%">Avances</th>
                                    <th width="10%"><div align="center">Acci&oacute;n</div></th>
                                </tr>
                            </thead>
                            <tbody>	<?php
								// Crea tabla de memos
								foreach($users as $tables) {
									$nombre = UserData::getById($tables->idperson)->name.' '.UserData::getById($tables->idperson)->lastname;
									$email = UserData::getById($tables->idperson)->email; $dias = 0; $boton = '';
									
									$fecha = explode(" ",$tables->date_event);
									$tables->date_event = $fecha[0];
									//var_dump($tables);
									echo '<tr>';
										echo '<td><div align="center">'.$tables->created_at.'</div></td>';
										echo '<td><div align="center">'.$tables->date_event.'</div></td>';
										echo '<td>'.$tables->quien_asigna.'<br>';
										if($tables->status == 3){
											//$boton = ' disabled';
											echo '<span class="label label-success">EJECUTADA</span><br>';
											echo ' El: '.$tables->date_pass;
										}else{
											$boton = '';
											
											$ini = explode(" ", $tables->date_event);
											$fin = date("Y-m-d");
											
											$fecha1 = new DateTime($ini[0]);
											$fecha2 = new DateTime($fin);
											
											$intervalo = $fecha1->diff($fecha2);
											$dias = $intervalo->format('%R%a');
											
											if($dias > 0){												
												if($tables->status == 5){
													echo " Se vencio hace: ".abs($intervalo->format('%R%a'))." días</br>";
													echo '<span class="label label-purple"> DESTIEMPO </span>';
												}else{
													echo " Se vencio hace: ".abs($intervalo->format('%R%a'))." días</br>";
													echo '<span class="label label-danger">&nbsp;&nbsp; VENCIDA &nbsp;&nbsp;</span>';
												}
												$boton = ' disabled';
											}else{
												echo " Se vence en: ".abs($intervalo->format('%R%a'))." días</br>";
												
												if($tables->status == 2)
													echo '<span class="label label-warning">&nbsp;&nbsp;EN CURSO&nbsp;&nbsp;</span>';
												else
													echo '<span class="label label-info">&nbsp;&nbsp;ASIGNADA&nbsp;&nbsp;</span>';
											}
										}
										echo '</td>';
										echo '<td>'.$nombre.'</td>';
										echo '<td>'.$tables->asunto.'</br>';
										echo '<small>';
											if($tables->status == 4 || $tables->status == 5){
												if($tables->date_pass == '0000-00-00 00:00:00'){
													//Sin fecha de entrega
												}else{
													echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;&nbsp;<span class="label label-success">TERMINADA</span>';
												}
											}else{
												if($tables->prioridad == 0){
													echo '<span class="glyphicon glyphicon-remove-sign text-danger"></span>&nbsp;&nbsp;<span>PRIORIDAD BAJA</span>';
												}else{
													if($tables->prioridad == 1){
														echo '<span class="glyphicon glyphicon-minus-sign text-warning"></span>&nbsp;&nbsp;<span>PRIORIDAD MEDIA</span>';
													}else{
														echo '<span class="glyphicon glyphicon-remove-sign text-danger"></span>&nbsp;&nbsp;<span>PRIORIDAD ALTA</span>';
													}
												}
											}
										echo '</small></td>';
										echo '<td>'.$tables->title.'</td>';
										if($tables->body != ""){
											echo '<td>'.$tables->body.'</td>';
										}else{
											echo '<td>No hay avances registrados en la tarea&nbsp;</td>';
										}
										echo '<td>';
											echo '<div align="center">';
												if($_SESSION["usuario"] == $tables->quien_asigna || $_SESSION["idrol"] == 2 || $_SESSION["idrol"] == 1){
													if($dias > 0)
														echo '<a class="btn btn-success btn-sm'.$boton.'" href="labor/'.$tables->id.'"><i class="fa fa-edit"></i></a>';
													else
														echo '<a class="btn btn-success btn-sm'.$boton.'" href="edittask/'.$tables->id.'"><i class="fa fa-edit"></i></a>';
												}else{
													echo '<a class="btn btn-success btn-sm'.$boton.'" href="edittask/'.$tables->id.'"><i class="fa fa-edit"></i></a>';
												}
												// Botón para ver subtareas (modal)
												echo '<button type="button" class="btn btn-info btn-sm'.$boton.'" onClick="openSubtasksModal(\''.$tables->id.'\');"><i class="fa fa-eye"></i></button>';
												echo '<button type="button" class="btn btn-warning btn-sm'.$boton.'" onClick="openRespuestaModal(\''.$tables->id.'\');"><i class="fa fa-key"></i></button>';
											echo '</div>';
										echo '</td>';
									echo '</tr>';
								} ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- subtasks modal -->
<div class="modal fade" id="modalSubtasks" tabindex="-1" role="dialog" aria-labelledby="modalSubtasksLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalSubtasksLabel">Subtareas</h4>
		</div>
		<div class="modal-body">
		<table class="table table-striped" id="subtasksTable">
			<thead><tr><th>Nombre</th><th width="18%">Fecha</th></tr></thead>
			<tbody></tbody>
		</table>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
	</div>
</div>
<!-- subtasks modal -->
<div class="modal fade" id="modalRespuesta" tabindex="-1" role="dialog" aria-labelledby="modalRespuestaLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalRespuestaLabel">Respuesta ingresadas</h4>
          </div>
          <div class="modal-body">
            <table class="table table-striped" id="RespuestaTable">
              <thead><tr><th>Descripcion</th><th>Fecha</th><th>Responsable</th></tr></thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
</div>
<!-- Page specific script -->
<script type='text/javascript'><!--
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Listado de las tareas";

	function openSubtasksModal(id) {
        var id = id;
		var resp = '';

		// Limpiar el contenido anterior del modal para evitar que se acumulen los datos
		$('#subtasksTable tbody').empty();

		$.post('<?php echo $_SESSION["url"]; ?>ajax/getSubtasks.php',{id:id},function(resp){
			if(resp.success){
				resp.data.forEach(function(r){
					$('#subtasksTable tbody').append('<tr><td>'+r.name+'</td><td>'+r.date+'</td></tr>');
				});
				$('#modalSubtasks').modal('show');
			} else {
				toastr.error('No se pudieron cargar subtareas');
			}
		},'json').fail(function(e){
			toastr.error('Error cargando subtareas');
			console.error(e);
		});
	}

	function openRespuestaModal(id) {
        var id = id;
		var resp = '';

		// Limpiar el contenido anterior del modal para evitar que se acumulen los datos
		$('#RespuestaTable tbody').empty();

		$.post('<?php echo $_SESSION["url"]; ?>ajax/getRespuesta.php',{id:id},function(resp){
			if(resp.success){
				resp.data.forEach(function(r){
					$('#modalRespuesta tbody').append('<tr><td>'+r.name+'</td><td>'+r.date+'</td><td>'+r.status+'</td></tr>');
				});
				$('#modalRespuesta').modal('show');
			} else {
				toastr.error('No se pudieron cargar las respuesta');
			}
		},'json').fail(function(e){
			toastr.error('Error cargando las respuestas');
			console.error(e);
		});
	}

	$(function(){
        // manejar clic en ojo para ver subtareas
        $(document).on('click', '.view-subtasks', function(e){
            e.stopPropagation();
            var card = $(this).closest('.task-card');
            var id = card.data('task-id');
            $('#subtasksTable tbody').empty();
            $.post('<?php echo $_SESSION["url"]; ?>ajax/getSubtasks.php',{id:id},function(resp){
                if(resp.success){
                    resp.data.forEach(function(r){
                        $('#subtasksTable tbody').append('<tr><td>'+r.name+'</td><td>'+r.date+'</td><td>'+r.status+'</td></tr>');
                    });
                    $('#modalSubtasks').modal('show');
                } else {
                    toastr.error('No se pudieron cargar subtareas');
                }
            },'json').fail(function(e){
                toastr.error('Error cargando subtareas');
                console.error(e);
            });
        });
	});

	function btn_EnviarPermiso(valor) {		
        var id = valor;

		$.post('<?php echo $_SESSION["url"]; ?>ajax/getSubtasks.php',{id:id},function(resp){
			if(resp.success){
				resp.data.forEach(function(r){
					$('#subtasksTable tbody').append('<tr><td>'+r.name+'</td><td>'+r.date+'</td><td>'+r.status+'</td></tr>');
				});
				$('#modalSubtasks').modal('show');
			} else {
				toastr.error('No se pudieron cargar subtareas');
			}
		},'json').fail(function(e){
			toastr.error('Error cargando subtareas');
			console.error(e);
		});
	}
	//--
</script>