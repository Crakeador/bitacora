<?php
// Tablero de tareas tipo Kanban mostrando estados
// utiliza datos de TimelineData y AdminLTE 2.0

// Nota: El manejo AJAX de cambios de estado se realiza en /ajax/changeTaskStatus.php
// que devuelve SOLO JSON sin cargar el layout


// mapear estados de la tabla timeline a nombres legibles
$statuses = [
    1 => 'Pendiente',
    2 => 'Asignado',      // ajusta este texto si es necesario
    3 => 'En Curso',
    4 => 'Completadas'
];

// recolectar tareas por cada estado
$tasksByStatus = [];
foreach ($statuses as $code => $label) {
    $sql = "SELECT * FROM timeline WHERE idcompany=" . $_SESSION['id_company'] . " AND type=2 AND status=$code ORDER BY date_event DESC";
    $query = Executor::doit($sql);
    $tasksByStatus[$code] = Model::many($query[0], new TimelineData());
}
?>
<section class="content-header">
    <h1>
        Tablero de Tareas
        <small>organizadas por estado</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tablero</li>
    </ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <!-- subtasks modal -->
    <div class="modal fade" id="modalSubtasks" tabindex="-1" role="dialog" aria-labelledby="modalSubtasksLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#2196f3; color:#fff; border:none;">
            <button type="button" class="close" style="color:#fff; opacity:0.8;" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalSubtasksLabel"><i class="fa fa-tasks"></i> Subtareas</h4>
          </div>
          <div class="modal-body" style="max-height:500px; overflow-y:auto;">
            <table class="table table-hover table-striped" id="subtasksTable">
              <thead style="background-color:#f5f5f5;">
                <tr>
                  <th><i class="fa fa-cube"></i> Nombre</th>
                  <th><i class="fa fa-calendar"></i> Fecha</th>
                  <th><i class="fa fa-flag"></i> Estado</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <div id="emptySubtasks" class="alert alert-info text-center" style="display:none; margin:0;">
              <i class="fa fa-info-circle"></i> No hay subtareas para esta tarea
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- include toastr and jQuery UI assets if not already loaded -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <div class="row">
        <?php foreach ($statuses as $code => $label): ?>
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo $label; ?>
                            <span class="badge bg-blue"><?php echo count($tasksByStatus[$code]); ?></span>
                        </h3>
                    </div>
                    <div class="box-body kanban-column" id="col-<?php echo $code; ?>"> <?php
                        if (empty($tasksByStatus[$code])) {
                            echo '<p class="text-muted">No hay tareas</p>';
                        } else {
                            foreach ($tasksByStatus[$code] as $task) {
                                // obtener subtareas para este task
                                $subtasks = TimelineData::getDetalle($task->id);
                                $subtaskCount = is_array($subtasks) ? count($subtasks) : 0;
                                
                                echo '<div class="task-card" data-task-id="'.$task->id.'">';
                                
                                // botones en esquina superior
                                echo '<div style="float:right; display:flex; gap:6px; margin-bottom:8px;">';
                                
                                // botón de editar
                                echo '<a href="edittask/'.$task->id.'" class="btn btn-xs btn-primary" title="Editar tarea" style="padding:5px 10px; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">';
                                echo '<i class="fa fa-edit"></i> Editar';
                                echo '</a>';
                                
                                // botón de ojo para subtareas (siempre visible)
                                $eyeButtonClass = $subtaskCount > 0 ? 'btn-info' : 'btn-default';
                                $eyeButtonDisabled = $subtaskCount > 0 ? '' : 'disabled';
                                echo '<button type="button" class="view-subtasks btn btn-xs '.$eyeButtonClass.'" data-task-id="'.$task->id.'" title="Ver '.$subtaskCount.' subtarea(s)" style="padding:5px 10px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:4px;" '.$eyeButtonDisabled.'>';
                                echo '<i class="fa fa-eye"></i>';
                                echo '<span style="font-size:11px; font-weight:bold;">'.$subtaskCount.'</span>';
                                echo '</button>';
                                
                                echo '</div>';
                                
                                echo '<div style="clear:both;"></div>';
                                
                                echo '<strong>' . htmlspecialchars($task->title) . '</strong><br/>';
                                echo '<small>' . htmlspecialchars($task->body) . '</small><br/>';
                                echo '<small class="text-muted"><i class="fa fa-calendar"></i> ' . $task->date_event . '</small><br/>';
                                
                                // status selector - show selector only if role allowed
                                if($_SESSION['idrol'] <= 2){
                                    echo '<select class="status-selector" data-id="'.$task->id.'">';
                                    foreach($statuses as $sCode=>$sLabel){
                                        $sel = ($task->status==$sCode)?' selected':'';
                                        echo '<option value="'.$sCode.'"'.$sel.'>'.$sLabel.'</option>';
                                    }
                                    echo '</select>';
                                }
                                echo '</div>';
                            }
                        } ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
.kanban-column {min-height: 400px; background: #f4f4f4; padding: 10px; border-radius: 4px; transition: all 0.3s ease;}
.kanban-column.drop-hover {background: #e3f2fd; border: 2px dashed #2196f3;}
.task-card {background: #fff; padding: 8px; margin-bottom: 8px; border-radius: 4px; box-shadow: 0 1px 1px rgba(0,0,0,.1); cursor: move; transition: all 0.2s ease;}
.task-card.dragging {opacity: 0.5; box-shadow: 0 5px 15px rgba(0,0,0,.3);}
.task-card:hover {box-shadow: 0 2px 8px rgba(0,0,0,.15);}
.status-selector {margin-top:5px; width:100%; padding: 5px; border-radius: 3px; border: 1px solid #ddd; font-size: 12px;}
.view-subtasks {transition: all 0.2s ease; font-size: 16px; color: #666;}
.view-subtasks:hover {color: #2196f3; transform: scale(1.2);}
</style>

<script>
$(function(){
    var allowed = <?php echo ($_SESSION['idrol']<=2?'true':'false'); ?>;
    var draggedCard = null;
    var originalColumn = null;
    
    // mapeo de estados para mostrar nombres legibles
    var statusNamesMap = {
        1: 'Pendiente',
        2: 'Asignado',
        3: 'En Curso',
        4: 'Completadas'
    };
    
    $('.status-selector').change(function(){
        var id = $(this).data('id');
        var status = $(this).val();
        console.log('Changing status for task', id, 'to', status);
        $.post('ajax/changeTaskStatus.php',{id:id,status:status},function(response){
            console.log('Dropdown response:', response);
            if(response && response.success){
                toastr.success('Estado actualizado a: ' + (statusNamesMap[status] || status));
            } else {
                toastr.error('Error: ' + (response.error || 'No actualizado'));
            }
        },'json').fail(function(e){
            console.error('Dropdown AJAX error:', e);
            toastr.error('Error al actualizar');
        });
    });

    // manejar clic en ojo para ver subtareas (disponible para todos)
    $(document).on('click', '.view-subtasks', function(e){
        e.stopPropagation();
        e.preventDefault();
        
        // si el botón está deshabilitado, no hacer nada
        if($(this).prop('disabled')){
            toastr.info('No hay subtareas para esta tarea');
            return;
        }
        
        var taskId = $(this).data('task-id');
        var card = $('[data-task-id="'+taskId+'"]');
        var taskTitle = card.find('strong').text();
        
        // actualizar título del modal
        $('#modalSubtasksLabel').text('Subtareas de: ' + taskTitle);
        $('#subtasksTable tbody').empty();
        
        $.ajax({
            url: 'ajax/getSubtasks.php',
            type: 'POST',
            data: {id: taskId},
            dataType: 'json',
            success: function(resp){
                if(resp.success && resp.data && resp.data.length > 0){
                    resp.data.forEach(function(r){
                        var statusLabel = statusNamesMap[r.status] || 'Desconocido';
                        var statusClass = 'label-default';
                        if(r.status == 1) statusClass = 'label-warning';
                        else if(r.status == 2) statusClass = 'label-info';
                        else if(r.status == 3) statusClass = 'label-primary';
                        else if(r.status == 4) statusClass = 'label-success';
                        
                        var row = '<tr>';
                        row += '<td><strong>'+r.name+'</strong></td>';
                        row += '<td>'+r.date+'</td>';
                        row += '<td><span class="label '+statusClass+'">'+statusLabel+'</span></td>';
                        row += '</tr>';
                        $('#subtasksTable tbody').append(row);
                    });
                    $('#modalSubtasks').modal('show');
                } else {
                    toastr.warning('No hay subtareas para esta tarea');
                }
            },
            error: function(e){
                toastr.error('Error cargando subtareas');
                console.error(e);
            }
        });
    });

    if(allowed){
        // inicializar draggable para todas las tarjetas
        initDraggable();

        // droppable areas
        $('.kanban-column').droppable({
            accept: '.task-card',
            hoverClass: 'drop-hover',
            tolerance: 'pointer',
            drop: function(event, ui){
                var $targetColumn = $(this);
                var columnId = $targetColumn.attr('id');
                var newStatus = columnId.replace('col-','');
                var $originalCard = ui.draggable;
                var taskId = $originalCard.data('task-id');
                
                if(!taskId){
                    toastr.error('Error: no se pudo obtener el ID de la tarea');
                    return false;
                }
                
                if($originalCard.parent().attr('id') === columnId){
                    // ya está en la misma columna
                    $originalCard.removeClass('dragging');
                    return true;
                }
                
                // ajax update
                $.ajax({
                    url: 'ajax/changeTaskStatus.php',
                    type: 'POST',
                    data: {
                        id: taskId,
                        status: newStatus
                    },
                    dataType: 'json',
                    success: function(response){
                        console.log('AJAX Response:', response);
                        if(response && response.success){
                            // mover la tarjeta al nuevo contenedor
                            $originalCard.removeClass('dragging').detach().appendTo($targetColumn);
                            // re-inicializar draggable
                            initDraggable();
                            // mostrar notificación
                            var statusLabel = statusNamesMap[newStatus] || newStatus;
                            toastr.success('Tarea movida a: ' + statusLabel);
                        } else {
                            toastr.error('Error: ' + (response.error || 'Estado no actualizado'));
                            console.error('Error response:', response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.error('AJAX Error Status:', textStatus);
                        console.error('AJAX Error Thrown:', errorThrown);
                        console.error('AJAX Response Text:', jqXHR.responseText);
                        toastr.error('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
                
                return true;
            }
        });
        
        function initDraggable(){
            $('.task-card').draggable({
                appendTo: 'body',
                helper: 'clone',
                revert: false,
                cursor: 'grab',
                distance: 5,
                start: function(event, ui){
                    $(this).addClass('dragging');
                    $(this).css('cursor','grabbing');
                    draggedCard = $(this);
                    originalColumn = $(this).parent();
                },
                stop: function(event, ui){
                    $(this).removeClass('dragging');
                    $(this).css('cursor','grab');
                }
            });
        }
    }
});
</script>