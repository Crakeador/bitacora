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
			day: 'Dia'
		  },
		  dayClick:function(date,jsEvent,view){
			  $('#txtFecha').val(date.format());
			  $("#dlg_dias").modal();			  
		  },
		  //Random default events
		  events: 'https://latin.near-solution.com/ajax/eventos.php',
		  eventClick:function(calEvent,jsEvent,view){
			  $('#tituloEvento').html(calEvent.title);
			  //Mostrar la informacion del evento
			  $('#txtID').val(calEvent.id);
			  $('#txtDescripcion').val(calEvent.descripcion);
			  $('#txtTitulo').val(calEvent.title);
			  $('#txtColor').val(calEvent.color);
			  
			  FechaHora=calEvent.start._i.split(" ");			  
			  $('#txtFecha').val(FechaHora[0]);
			  $('#txtHora').val(FechaHora[1]);
			  
			  $("#dlg_dias").modal();
		  },
		  editable: true,
		  droppable: true, // this allows things to be dropped onto the calendar !!!
		  locale: 'es',
		  eventDrop:function(calEvent){
			  $('#tituloEvento').html(calEvent.title);
			  //Mostrar la informacion del evento
			  $('#txtID').val(calEvent.id);
			  $('#txtDescripcion').val(calEvent.descripcion);
			  $('#txtTitulo').val(calEvent.title);
			  $('#txtColor').val(calEvent.color);
			  
			  FechaHora=calEvent.start.format().split("T");			  
			  $('#txtFecha').val(FechaHora[0]);
			  $('#txtHora').val(FechaHora[1]);
			  
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
	  });
</script>
<!-- pop up fechas Ingreso y Salida del empleado -->
<div id="dlg_dias" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="box-header with-border">
				<h3 class="box-title">Valores a Cotizar</h3>
				<div class="box-tools pull-right">
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body" style="display: block;">		
				<div class="form-group">
					<label for="txtID" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> ID:</label>
					<div class="col-md-8 col-sm-2">
						<input type="text" class="form-control" id="txtID" name="txtID" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="txtFecha" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Fecha:</label>
					<div class="col-md-8 col-sm-2">
						<input type="date" class="form-control" id="txtFecha" name="txtFecha" value="">
					</div>
				</div>		
				<div class="form-group">
					<label for="txtHora" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Hora:</label>
					<div class="col-md-8 col-sm-2">
						<input type="time" class="form-control" id="txtHora" name="txtHora" value="">
					</div>
				</div>					
				<div class="form-group">
					<label for="txtTitulo" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Titulo:</label>
					<div class="col-md-8 col-sm-5">
						<input type="text" class="form-control" id="txtTitulo" name="txtTitulo" value="" placeholder="Titulo del evento">
					</div>
				</div>
				<div class="form-group">
					<label for="txtDescripcion" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
					<div class="col-md-8 col-sm-5">
						<textarea class="form-control" id="txtDescripcion" name="txtDescripcion" value="" placeholder="Descripcion del rubro"></textarea>
					</div>
				</div>		
				<div class="form-group">
					<label for="txtColor" class="col-md-4 col-sm-3 control-label"><span class="text-danger">*</span> Hora:</label>
					<div class="col-md-3 col-sm-2">
						<input type="color" class="form-control" id="txtColor" name="txtColor" value="">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="agregar_eventos" class="btn btn-success">
					<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
				</button>
				<button id="modificar_eventos" class="btn btn-success">
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
		var NuevoEvento = {
				id:$('#txtID').val(),
				title:$('#txtTitulo').val(),
				start:$('#txtFecha').val()+' '+$('#txtHora').val(),
				end:$('#txtFecha').val()+' '+$('#txtHora').val(),
				backgroundColor:$('#txtColor').val(),
				borderColor:$('#txtColor').val(),
				descripcion:$('#txtDescripcion').val()
			};
	}

	function EnviarInformacion(accion, objEvento, modal){
		var id = $('#txtID').val();
		var title = $('#txtTitulo').val();
		var start = $('#txtFecha').val()+' '+$('#txtHora').val();
		var end = $('#txtFecha').val()+' '+$('#txtHora').val();
		var color = $('#txtColor').val();
		var descripcion = $('#txtDescripcion').val();
		var dataString = 'title='+title+'&start='+start+'&end='+end+'&color='+color+'&descripcion='+descripcion;
				
		$.ajax({
			type:'POST',
			url:'index.php?action=calendar&accion'+accion,			
			datatype: 'json',
			data: dataString,
			success:function(msg){
				console.log(JSON.stringify(msg));
				if(msg){					
					$('#calendar').fullCalendar('refetchEvents');
					if(!modal){
						$('#dlg_dias').modal('toggle');	
					}
				}
			},
			error:function(){
				alert("Hay un error...!!!");
			}
		});
	}
</script>