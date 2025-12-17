<?php

date_default_timezone_set('America/Guayaquil');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Calendario
		<small>planificaci&oacute;n de las acciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=cotizacion"><i class="fa fa-database"></i> Cotizaciones </a></li>
		<li class="active"> Cotizar </li>
	</ol>
</section>
</br>
<section id="main" role="main">
	<!-- /.col -->
	<div class="col-md-3">
	  <div class="box box-solid">
		<div class="box-header with-border">
		  <h4 class="box-title">Draggable Events</h4>
		</div>
		<div class="box-body">
		  <!-- the events -->
		  <div id="external-events">
			<div class="external-event bg-green">Lunch</div>
			<div class="external-event bg-yellow">Go home</div>
			<div class="external-event bg-aqua">Do homework</div>
			<div class="external-event bg-light-blue">Work on UI design</div>
			<div class="external-event bg-red">Sleep tight</div>
			<div class="checkbox">
			  <label for="drop-remove">
				<input type="checkbox" id="drop-remove">
				remove after drop
			  </label>
			</div>
		  </div>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->
	  <div class="box box-solid">
		<div class="box-header with-border">
		  <h3 class="box-title">Create Event</h3>
		</div>
		<div class="box-body">
		  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
			<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
			<ul class="fc-color-picker" id="color-chooser">
			  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
			  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
			</ul>
		  </div><!-- /btn-group -->
		  <div class="input-group">
			<input id="new-event" type="text" class="form-control" placeholder="Event Title">
			<div class="input-group-btn">
			  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
			</div><!-- /btn-group -->
		  </div><!-- /input-group -->
		</div>
	  </div>
	</div><!-- /.col -->
	<div class="col-md-9">
	  <div class="box box-primary">
		<div class="box-body no-padding">
		  <!-- THE CALENDAR -->
		  <div id="calendar"></div>
		</div><!-- /.box-body -->
	  </div><!-- /. box -->
	</div><!-- /.col -->
</section>
<script>
	$(document).ready(function () {		
        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));
		
		/* initialize the calendar
		 -----------------------------------------------------------------*/
		//Date for the calendar events (dummy data)
		var date = new Date();
		var d = date.getDate(),
				m = date.getMonth(),
				y = date.getFullYear();
				
		$('#calendar').fullCalendar({
		  header: {
			left: 'prev, next, today',
			center: 'title',
			right: 'month, basicWeek,basicDay, agendaWeek,agendaDay'
		  },
		  buttonText: {
			today: 'Hoy',
			month: 'Mes',
			week: 'Semana',
			day: 'Día'
		  },
		  eventRender: function(event, element) {
			  // Agregar tooltip con información completa del evento
			  var tooltipContent = '<strong>' + event.title + '</strong><br/>';
			  if(event.persona_contacto){
				  tooltipContent += '<strong>Contacto:</strong> ' + event.persona_contacto + '<br/>';
			  }
			  if(event.lugar){
				  tooltipContent += '<strong>Lugar:</strong> ' + event.lugar + '<br/>';
			  }
			  if(event.descripcion){
				  tooltipContent += '<strong>Descripción:</strong> ' + event.descripcion + '<br/>';
			  }
			  if(event.start){
				  var fechaHora = '';
				  if(event.start.format){
					  fechaHora = event.start.format('DD/MM/YYYY HH:mm');
				  } else if(event.start._i){
					  fechaHora = event.start._i;
				  } else {
					  fechaHora = event.start;
				  }
				  tooltipContent += '<strong>Fecha:</strong> ' + fechaHora;
			  }
			  element.attr('title', tooltipContent);
			  element.attr('data-toggle', 'tooltip');
			  element.attr('data-html', 'true');
			  
			  // Agregar información adicional al título si hay lugar o contacto
			  if(event.lugar || event.persona_contacto){
				  var titleExtra = '';
				  if(event.persona_contacto){
					  titleExtra += ' 👤 ' + event.persona_contacto;
				  }
				  if(event.lugar){
					  titleExtra += ' 📍 ' + event.lugar;
				  }
				  element.find('.fc-title').append('<br/><small style="font-size:0.85em;">' + titleExtra + '</small>');
			  }
		  },
		  dayClick:function(date,jsEvent,view){
			  // Limpiar formulario para nuevo evento
			  $('#txtID').val('');
			  $('#txtTitulo').val('');
			  $('#txtPersonaContacto').val('');
			  $('#txtLugar').val('');
			  $('#txtDescripcion').val('');
			  $('#txtColor').val('#3c8dbc');
			  $('#txtFecha').val(date.format('YYYY-MM-DD'));
			  $('#txtHora').val('');
			  $('#modificar_eventos').hide();
			  $('#agregar_eventos').show();
			  $("#dlg_dias").modal();			  
		  },
		  //Cargar eventos desde el servidor
		  events: 'index.php?action=calendar&accion=Leer',
		  eventClick:function(calEvent,jsEvent,view){
			  $('#tituloEvento').html(calEvent.title);
			  //Mostrar la informacion del evento
			  $('#txtID').val(calEvent.id);
			  $('#txtDescripcion').val(calEvent.descripcion || '');
			  $('#txtTitulo').val(calEvent.title);
			  $('#txtPersonaContacto').val(calEvent.persona_contacto || '');
			  $('#txtLugar').val(calEvent.lugar || '');
			  $('#txtColor').val(calEvent.color || calEvent.backgroundColor || '#3c8dbc');
			  
			  // Manejar diferentes formatos de fecha
			  var fechaHora;
			  if(calEvent.start._i){
				  fechaHora = calEvent.start._i.split(" ");
			  } else if(calEvent.start.format){
				  fechaHora = calEvent.start.format().split("T");
				  fechaHora[1] = fechaHora[1] ? fechaHora[1].substring(0,5) : '';
			  } else {
				  fechaHora = [moment(calEvent.start).format('YYYY-MM-DD'), moment(calEvent.start).format('HH:mm')];
			  }
			  
			  $('#txtFecha').val(fechaHora[0]);
			  $('#txtHora').val(fechaHora[1] || '');
			  
			  $('#agregar_eventos').hide();
			  $('#modificar_eventos').show();
			  $("#dlg_dias").modal();
		  },
		  editable: true,
		  droppable: true, // this allows things to be dropped onto the calendar !!!
		  locale: 'es',
		  eventDrop:function(calEvent){
			  // Actualizar fecha cuando se arrastra el evento
			  var fechaHora = calEvent.start.format().split("T");
			  $('#txtID').val(calEvent.id);
			  $('#txtFecha').val(fechaHora[0]);
			  $('#txtHora').val(fechaHora[1] ? fechaHora[1].substring(0,5) : '');
			  $('#txtTitulo').val(calEvent.title);
			  $('#txtPersonaContacto').val(calEvent.persona_contacto || '');
			  $('#txtLugar').val(calEvent.lugar || '');
			  $('#txtDescripcion').val(calEvent.descripcion || '');
			  $('#txtColor').val(calEvent.color || calEvent.backgroundColor || '#3c8dbc');
			  
			  RecolectarDatos();
			  EnviarInformacion('modificar', NuevoEvento, true);
		  },
		  drop: function (date, allDay) { 
			// this function is called when something is dropped
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');

			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			copiedEventObject.backgroundColor = $(this).css("background-color");
			copiedEventObject.borderColor = $(this).css("border-color");

			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
			  // if so, remove the element from the "Draggable Events" list
			  $(this).remove();
			}
		  }
		});
		
		// Inicializar tooltips de Bootstrap
		$('[data-toggle="tooltip"]').tooltip();
		
		// Reinicializar tooltips después de cargar eventos
		$('#calendar').on('eventAfterRender', function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	  });
</script>
<!-- pop up fechas Ingreso y Salida del empleado -->
<div id="dlg_dias" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="box-header with-border">
				<h3 class="box-title">Agenda de Reuniones</h3>
				<div class="box-tools pull-right">
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body" style="display: block;">		
				<div class="form-group">
					<label for="txtID" class="col-md-4 col-sm-3 control-label">ID:</label>
					<div class="col-md-8 col-sm-2">
						<input type="text" class="form-control" id="txtID" name="txtID" value="" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="txtFecha" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha:</label>
					<div class="col-md-8 col-sm-2">
						<input type="date" class="form-control" id="txtFecha" name="txtFecha" value="" required>
					</div>
				</div>		
				<div class="form-group">
					<label for="txtHora" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Hora:</label>
					<div class="col-md-8 col-sm-2">
						<input type="time" class="form-control" id="txtHora" name="txtHora" value="" required>
					</div>
				</div>					
				<div class="form-group">
					<label for="txtTitulo" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> T&iacute;tulo:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtTitulo" name="txtTitulo" value="" placeholder="Título de la reunión" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtPersonaContacto" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Persona de Contacto:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtPersonaContacto" name="txtPersonaContacto" value="" placeholder="Nombre de la persona de contacto" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtLugar" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Lugar de Reuni&oacute;n:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtLugar" name="txtLugar" value="" placeholder="Dirección o lugar de la reunión" required>
					</div>
				</div>
				<div class="form-group">
					<label for="txtDescripcion" class="col-md-4 col-sm-3 control-label">Descripci&oacute;n:</label>
					<div class="col-md-8 col-sm-5">
						<textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="3" placeholder="Descripción adicional de la reunión"></textarea>
					</div>
				</div>		
				<div class="form-group">
					<label for="txtColor" class="col-md-4 col-sm-3 control-label">Color:</label>
					<div class="col-md-3 col-sm-2">
						<input type="color" class="form-control" id="txtColor" name="txtColor" value="#3c8dbc">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="agregar_eventos" class="btn btn-success" style="display:none;">
					<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
				</button>
				<button id="modificar_eventos" class="btn btn-success" style="display:none;">
					<span class="glyphicon glyphicon-floppy-disk"></span> Modificar
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"> </span> Cancelar
				</button>
				<div id="finiquito"></div>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!--/ END modal -->
<script type="text/javascript">
    var element = document.getElementById("sidai");
	var NuevoEvento;
	
    element.classList.add("sidebar-collapse");
    document.title = "Near Solution | Registro de las cotizaciones";
	
    $(function(){
        $("#agregar_eventos").click(function(e){
			RecolectarDatos();
			EnviarInformacion('agregar', NuevoEvento);
        });
		
		
        $("#modificar_eventos").click(function(e){
			RecolectarDatos();
			EnviarInformacion('modificar', NuevoEvento, false);
        });		
    });
	
	function RecolectarDatos(){
		NuevoEvento = {
				id:$('#txtID').val(),
				title:$('#txtTitulo').val(),
				start:$('#txtFecha').val()+' '+$('#txtHora').val(),
				end:$('#txtFecha').val()+' '+$('#txtHora').val(),
				backgroundColor:$('#txtColor').val(),
				borderColor:$('#txtColor').val(),
				descripcion:$('#txtDescripcion').val(),
				persona_contacto:$('#txtPersonaContacto').val(),
				lugar:$('#txtLugar').val()
			};
	}

	function EnviarInformacion(accion, objEvento, modal){
		var id = $('#txtID').val();
		var title = encodeURIComponent($('#txtTitulo').val());
		var start = encodeURIComponent($('#txtFecha').val()+' '+$('#txtHora').val());
		var end = encodeURIComponent($('#txtFecha').val()+' '+$('#txtHora').val());
		var color = encodeURIComponent($('#txtColor').val());
		var descripcion = encodeURIComponent($('#txtDescripcion').val());
		var persona_contacto = encodeURIComponent($('#txtPersonaContacto').val());
		var lugar = encodeURIComponent($('#txtLugar').val());
		
		var dataString = 'title='+title+'&start='+start+'&end='+end+'&color='+color+'&descripcion='+descripcion+'&persona_contacto='+persona_contacto+'&lugar='+lugar;
		
		if(id && accion == 'modificar'){
			dataString += '&id='+id;
		}
				
		$.ajax({
			type:'POST',
			url:'index.php?action=calendar&accion='+accion,			
			dataType: 'json',
			data: dataString,
			success:function(response){
				console.log('Respuesta:', response);
				if(response && response.success !== false){					
					$('#calendar').fullCalendar('refetchEvents');
					if(!modal){
						$('#dlg_dias').modal('hide');
						// Limpiar formulario
						$('#txtID').val('');
						$('#txtTitulo').val('');
						$('#txtPersonaContacto').val('');
						$('#txtLugar').val('');
						$('#txtDescripcion').val('');
						$('#txtColor').val('#3c8dbc');
						$('#txtFecha').val('');
						$('#txtHora').val('');
					}
					alert('Evento guardado correctamente');
				} else {
					alert('Error al guardar el evento');
				}
			},
			error:function(xhr, status, error){
				console.error('Error:', error);
				alert("Error al procesar la solicitud. Por favor, intente nuevamente.");
			}
		});
	}
</script>