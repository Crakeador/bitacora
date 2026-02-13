<?php
// Assuming you have a layout file that includes the header, footer, and necessary CSS/JS.
// If not, you'll need to add the includes here.
?>

<link href='plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">


<div class="row">
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /. box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->


<!-- Modal para Agregar Evento -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form class="form-horizontal" method="POST" action="index.php?view=addreservation">
    
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
      </div>
      <div class="modal-body">
      
        <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Titulo</label>
        <div class="col-sm-10">
          <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
        </div>
        </div>
        <div class="form-group">
        <label for="color" class="col-sm-2 control-label">Color</label>
        <div class="col-sm-10">
            <div class="input-group my-colorpicker2">
                <input type="text" name="color" id="color" class="form-control" placeholder="#ff0000">
                <div class="input-group-addon">
                    <i></i>
                </div>
            </div>
        </div>
        </div>
        <div class="form-group">
        <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
        <div class="col-sm-10">
          <input type="text" name="start" class="form-control" id="start" readonly>
        </div>
        </div>
        <div class="form-group">
        <label for="end" class="col-sm-2 control-label">Fecha Final</label>
        <div class="col-sm-10">
          <input type="text" name="end" class="form-control" id="end" readonly>
        </div>
        </div>
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
    </div>
</div>

<!-- Modal Para Editar Evento -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form class="form-horizontal" method="POST">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
      </div>
      <div class="modal-body">
      
        <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Titulo</label>
        <div class="col-sm-10">
          <input type="text" name="title" class="form-control" id="edit-title" placeholder="Titulo">
        </div>
        </div>
        <div class="form-group">
        <label for="color" class="col-sm-2 control-label">Color</label>
        <div class="col-sm-10">
            <div class="input-group my-colorpicker2">
                <input type="text" name="color" id="edit-color" class="form-control" placeholder="#ff0000">
                <div class="input-group-addon">
                    <i></i>
                </div>
            </div>
        </div>
        </div>
          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label class="text-danger"><input type="checkbox" name="delete"> Eliminar Evento</label>
                </div>
              </div>
          </div>
        
        <input type="hidden" name="id" class="form-control" id="id">
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
    </div>
</div>

<script src='plugins/moment/moment.min.js'></script>
<script src='plugins/fullcalendar/fullcalendar.min.js'></script>
<script src='plugins/fullcalendar/lang/es.js'></script>
<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<script>
$(function () {
    //Colorpicker
    $(".my-colorpicker2").colorpicker();

    /* initialize the calendar
    -----------------------------------------------------------------*/
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'hoy',
            month: 'mes',
            week: 'semana',
            day: 'dia'
        },
        // Cargar eventos desde el backend
        events: 'ajax/eventos.php',
        editable: true,
        droppable: true,
        selectable: true,
		selectHelper: true,

        // Al seleccionar un rango de fechas
		select: function(start, end) {
			$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
			$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
			$('#ModalAdd').modal('show');
		},

        // Al hacer click en un evento
        eventClick: function(event) {
            var id = event.id;
            var title = event.title;
            var color = event.color;

            $('#ModalEdit #id').val(id);
            $('#ModalEdit #edit-title').val(title);
            $('#ModalEdit #edit-color').val(color);
            $('#ModalEdit').modal('show');
        },

        // Al mover un evento (drag and drop)
        eventDrop: function(event, delta, revertFunc) {
            var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
            var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
            var id = event.id;

            $.ajax({
                url: 'ajax/horario.php',
                type: 'POST',
                data: {
                    id: id,
                    start: start,
                    end: end
                },
                success: function(response){
                    if(response != "1"){
                        revertFunc(); // Revertir si la actualización falla
                        alert("No se pudo guardar el cambio.");
                    }
                }
            });
        },
        
        // Al redimensionar un evento
        eventResize: function(event, delta, revertFunc) {
            var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
            var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
            var id = event.id;

            $.ajax({
                url: 'ajax/horario.php',
                type: 'POST',
                data: {
                    id: id,
                    start: start,
                    end: end
                },
                success: function(response){
                     if(response != "1"){
                        revertFunc(); // Revertir si la redimensión falla
                        alert("No se pudo guardar el cambio.");
                    }
                }
            });
        }
    });

    // Manejar submit del modal de agregar
    $('#ModalAdd form').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: 'ajax/nuevos.php',
            type: 'POST',
            data: data,
            success: function(response){
                $('#ModalAdd').modal('hide');
                // Limpiar formulario
                 $('#ModalAdd form')[0].reset();
                // Recargar eventos del calendario
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    });

    // Manejar submit del modal de editar/eliminar
    $('#ModalEdit form').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).find('input[name="delete"]').is(':checked') ? 'ajax/DESVINCULAR.php' : 'ajax/horario.php';

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response){
                $('#ModalEdit').modal('hide');
                 // Limpiar formulario
                $('#ModalEdit form')[0].reset();
                // Recargar eventos del calendario
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    });
});
</script>