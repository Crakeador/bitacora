/**
 * Módulo de gestión de eventos del calendario
 * Sistema de bitácora - Eventos diarios
 * 
 * Funcionalidades:
 * - Crear, editar y eliminar eventos
 * - Arrastrar y soltar eventos
 * - Filtros y búsqueda
 * - Validación de formularios
 * - Notificaciones visuales
 */

var CalendarioEventos = (function() {
    'use strict';
    
    var allEvents = [];
    var filters = {
        search: '',
        color: ''
    };
    var ESTADO_COLORES = {
        '1': '#FF6B6B',
        '2': '#FFA500',
        '3': '#FFD700',
        '4': '#90EE90',
        '5': '#FF1493',
        '6': '#87CEEB',
        '7': '#00CED1'
    };
    var NuevoEvento;
    var currColor = ESTADO_COLORES['1'];
    
    /**
     * Inicializar el calendario y eventos
     */
    function init() {
        initExternalEvents();
        initCalendar();
        initEventHandlers();
        initFilters();
    }
    
    /**
     * Inicializar eventos arrastrables externos
     */
    function initExternalEvents() {
        function ini_events(ele) {
            ele.each(function () {
                var eventObject = {
                    title: $.trim($(this).text())
                };
                $(this).data('eventObject', eventObject);
                
                $(this).draggable({
                    zIndex: 1070,
                    revert: true,
                    revertDuration: 0
                });
            });
        }
        
        ini_events($('#external-events div.external-event'));
        
        // Color chooser button
        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault();
            currColor = $(this).data('color');
            $('#add-new-event').css({
                "background-color": currColor,
                "border-color": currColor
            });
        });
        
        // Agregar nuevo evento externo
        $('#add-new-event').click(function (e) {
            e.preventDefault();
            var val = $('#new-event').val();
            if (val.length == 0) {
                mostrarNotificacion('Por favor ingrese un título para el evento', 'warning');
                return;
            }

            var event = $('<div />');
            event.css({
                "background-color": currColor,
                "border-color": currColor,
                "color": "#fff"
            }).addClass("external-event");
            event.html(val);
            $('#external-events').prepend(event);
            
            ini_events(event);
            $('#new-event').val('');
            
            mostrarNotificacion('Evento creado. Arrástrelo al calendario', 'success');
        });
    }
    
    /**
     * Inicializar el calendario FullCalendar
     */
    function initCalendar() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay, agendaWeek, agendaDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            locale: 'es',
            editable: true,
            droppable: true,
            eventRender: function(event, element) {
                renderEventTooltip(event, element);
                addDeleteButton(event, element);
            },
            dayClick: function(date, jsEvent, view) {
                openEventModal('create', date);
            },
            events: function(start, end, timezone, callback) {
                loadEvents(start, end, callback);
            },
            eventClick: function(calEvent, jsEvent, view) {
                openEventModal('edit', null, calEvent);
            },
            eventDrop: function(calEvent) {
                updateEventDates(calEvent);
            },
            eventResize: function(calEvent) {
                updateEventDates(calEvent);
            },
            drop: function (date, allDay) {
                handleExternalEventDrop(this, date, allDay);
            },
            eventAfterAllRender: function() {
                // Destruir tooltips viejos y crear nuevos con colocación dinámica
                $('[data-toggle="tooltip"]').tooltip('destroy');
                $('[data-toggle="tooltip"]').tooltip({
                    trigger: 'hover',
                    html: true,
                    container: 'body',
                    placement: function(tip, element) {
                        var $el = $(element);
                        var top = $el.offset().top - $(window).scrollTop();
                        // Si está cerca de la parte superior, mostrar abajo
                        return top < 120 ? 'bottom' : 'top';
                    },
                    delay: { show: 150, hide: 50 }
                });
                // Limpiar tooltips flotantes huérfanos
                $('.tooltip').remove();
            }
        });
    }
    
    /**
     * Renderizar tooltip del evento
     */
    function renderEventTooltip(event, element) {
        var tooltipContent = '<strong>' + event.title + '</strong><br/>';
        
        if(event.cliente_nombre) {
            tooltipContent += '<strong>Cliente:</strong> ' + event.cliente_nombre + '<br/>';
        }
        if(event.persona_contacto) {
            tooltipContent += '<strong>Contacto:</strong> ' + event.persona_contacto + '<br/>';
        }
        if(event.lugar) {
            tooltipContent += '<strong>Lugar:</strong> ' + event.lugar + '<br/>';
        }
        if(event.descripcion) {
            tooltipContent += '<strong>Descripción:</strong> ' + event.descripcion + '<br/>';
        }
        if(event.start) {
            var fechaHora = event.start.format ? event.start.format('DD/MM/YYYY HH:mm') : event.start;
            tooltipContent += '<strong>Fecha:</strong> ' + fechaHora;
        }
        
        element.attr({
            'title': tooltipContent,
            'data-toggle': 'tooltip',
            'data-html': 'true'
        });
        
        // Agregar información adicional al título
        if(event.lugar || event.persona_contacto) {
            var titleExtra = '';
            if(event.persona_contacto) {
                titleExtra += ' 👤 ' + event.persona_contacto;
            }
            if(event.lugar) {
                titleExtra += ' 📍 ' + event.lugar;
            }
            element.find('.fc-title').append('<br/><small style="font-size:0.85em;">' + titleExtra + '</small>');
        }
    }
    
    /**
     * Agregar botón de eliminar al evento
     */
    function addDeleteButton(event, element) {
        element.find('.fc-content').prepend(
            '<span class="fc-delete-btn" title="Eliminar evento" style="position:absolute; right:2px; top:2px; cursor:pointer; display:none; z-index:999;">' +
            '<i class="fa fa-times-circle text-white"></i></span>'
        );
        
        element.hover(
            function() { $(this).find('.fc-delete-btn').show(); },
            function() { $(this).find('.fc-delete-btn').hide(); }
        );
        
        element.find('.fc-delete-btn').on('click', function(e) {
            e.stopPropagation();
            if(confirm('¿Está seguro que desea eliminar este evento: "' + event.title + '"?')) {
                eliminarEvento(event.id);
            }
        });
    }
    
    /**
     * Cargar eventos desde el servidor
     */
    function loadEvents(start, end, callback) {
        // Destruir tooltips existentes antes de cargar nuevos eventos
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('.tooltip').remove();
        
        $.ajax({
            url: 'index.php?action=calendar&accion=Leer',
            dataType: 'json',
            data: {
                start: start ? start.format('YYYY-MM-DD') : null,
                end: end ? end.format('YYYY-MM-DD') : null,
                search: filters.search || null,
                color: filters.color || null
            },
            success: function(data) {
                allEvents = data;
                callback(data);
                setTimeout(function() {
                    // Reinicializar tooltips con nueva instancia
                    $('[data-toggle="tooltip"]').tooltip('destroy');
                    $('[data-toggle="tooltip"]').tooltip({
                        trigger: 'hover',
                        html: true,
                        placement: 'top'
                    });
                }, 100);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar eventos:', error);
                mostrarNotificacion('Error al cargar los eventos del calendario', 'error');
                callback([]);
            }
        });
    }
    
    /**
     * Abrir modal de evento
     */
    function openEventModal(mode, date, calEvent) {
        if(mode === 'create') {
            $('#txtID').val('');
            $('#txtTitulo').val('');
            $('#txtPersonaContacto').val('');
            $('#txtLugar').val('');
            $('#txtDescripcion').val('');
            $('#txtEstado').val('1');
            $('#txtCliente').val('');
            $('#txtColor').val(ESTADO_COLORES['1']);
            $('#txtFecha').val(date.format('YYYY-MM-DD'));
            $('#txtHora').val(moment().format('HH:mm'));
            
            $('#modificar_eventos').hide();
            $('#eliminar_eventos').hide();
            $('#agregar_eventos').show();
        } else {
            $('#txtID').val(calEvent.id);
            $('#txtTitulo').val(calEvent.title);
            $('#txtPersonaContacto').val(calEvent.persona_contacto || '');
            $('#txtLugar').val(calEvent.lugar || '');
            $('#txtDescripcion').val(calEvent.descripcion || '');
            $('#txtEstado').val(calEvent.estado || '1');
            $('#txtCliente').val(calEvent.idcomercial || calEvent.cliente_id || '');
            var color = calEvent.color || calEvent.backgroundColor || ESTADO_COLORES[$('#txtEstado').val()] || '#3c8dbc';
            $('#txtColor').val(color);
            
            var fechaHora = parseFechaHora(calEvent.start);
            $('#txtFecha').val(fechaHora[0]);
            $('#txtHora').val(fechaHora[1] || '');
            
            $('#agregar_eventos').hide();
            $('#modificar_eventos').show();
            $('#eliminar_eventos').show();
        }
        
        $('.form-group').removeClass('has-error');
        $("#dlg_dias").modal();
    }
    
    /**
     * Parsear fecha y hora del evento
     */
    function parseFechaHora(start) {
        var fechaHora;
        if(start._i) {
            fechaHora = start._i.split(" ");
        } else if(start.format) {
            fechaHora = start.format().split("T");
            fechaHora[1] = fechaHora[1] ? fechaHora[1].substring(0,5) : '';
        } else {
            fechaHora = [moment(start).format('YYYY-MM-DD'), moment(start).format('HH:mm')];
        }
        return fechaHora;
    }
    
    /**
     * Actualizar fechas del evento cuando se arrastra
     */
    function updateEventDates(calEvent) {
        var fechaHora = calEvent.start.format().split("T");
        $('#txtID').val(calEvent.id);
        $('#txtFecha').val(fechaHora[0]);
        $('#txtHora').val(fechaHora[1] ? fechaHora[1].substring(0,5) : '');
        $('#txtTitulo').val(calEvent.title);
        $('#txtPersonaContacto').val(calEvent.persona_contacto || '');
        $('#txtLugar').val(calEvent.lugar || '');
        $('#txtDescripcion').val(calEvent.descripcion || '');
        $('#txtEstado').val(calEvent.estado || '1');
        $('#txtCliente').val(calEvent.idcomercial || calEvent.cliente_id || '');
        var color = calEvent.color || calEvent.backgroundColor || ESTADO_COLORES[$('#txtEstado').val()] || '#3c8dbc';
        $('#txtColor').val(color);
        
        recolectarDatos();
        enviarInformacion('modificar', NuevoEvento, true);
    }
    
    /**
     * Manejar drop de evento externo
     */
    function handleExternalEventDrop(element, date, allDay) {
        var originalEventObject = $(element).data('eventObject');
        var copiedEventObject = $.extend({}, originalEventObject);
        
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(element).css("background-color");
        copiedEventObject.borderColor = $(element).css("border-color");
        
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
        
        if ($('#drop-remove').is(':checked')) {
            $(element).remove();
        }
    }
    
    /**
     * Inicializar manejadores de eventos
     */
    function initEventHandlers() {
        $("#agregar_eventos").click(function(e) {
            e.preventDefault();
            if(validarFormulario()) {
                recolectarDatos();
                enviarInformacion('agregar', NuevoEvento, false);
            }
        });
        
        $("#modificar_eventos").click(function(e) {
            e.preventDefault();
            if(validarFormulario()) {
                recolectarDatos();
                enviarInformacion('modificar', NuevoEvento, false);
            }
        });
        
        $("#eliminar_eventos").click(function(e) {
            e.preventDefault();
            var titulo = $('#txtTitulo').val();
            if(confirm('¿Está seguro que desea eliminar el evento "' + titulo + '"?\n\nEsta acción no se puede deshacer.')) {
                var id = $('#txtID').val();
                if(id) {
                    eliminarEvento(id);
                }
            }
        });

        // Ajustar color según estado seleccionado
        $('#txtEstado').on('change', function() {
            var nuevoColor = ESTADO_COLORES[$(this).val()] || '#3c8dbc';
            $('#txtColor').val(nuevoColor);
        });
        
        // Limpiar errores al escribir
        $('#txtCliente, #txtTitulo, #txtFecha, #txtHora, #txtPersonaContacto, #txtLugar').on('input change', function() {
            $(this).closest('.form-group').removeClass('has-error');
        });
    }
    
    /**
     * Inicializar filtros
     */
    function initFilters() {
        // Botón "Ir a Hoy"
        $('#btnHoy').click(function() {
            $('#calendar').fullCalendar('today');
        });
        
        // Búsqueda de eventos
        var searchTimeout;
        $('#searchEvent').on('keyup', function() {
            clearTimeout(searchTimeout);
            var searchTerm = $(this).val().toLowerCase();
            searchTimeout = setTimeout(function() {
                filters.search = searchTerm;
                $('#calendar').fullCalendar('refetchEvents');
            }, 300);
        });
        
        // Filtro por color
        $('#filterColor').on('change', function() {
            var selectedColor = $(this).val();
            filters.color = selectedColor;
            $('#calendar').fullCalendar('refetchEvents');
        });
        
        // Limpiar filtros
        $('#btnLimpiarFiltros').click(function() {
            $('#searchEvent').val('');
            $('#filterColor').val('');
            filters.search = '';
            filters.color = '';
            $('#calendar').fullCalendar('refetchEvents');
        });
        
        $('#searchEvent').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
            }
        });
    }
    
    /**
     * Validar formulario
     */
    function validarFormulario() {
        var errores = [];
        
        if(!$('#txtCliente').val()) {
            errores.push('Debe seleccionar un cliente');
            $('#txtCliente').closest('.form-group').addClass('has-error');
        } else {
            $('#txtCliente').closest('.form-group').removeClass('has-error');
        }

        if(!$('#txtTitulo').val().trim()) {
            errores.push('El título del evento es obligatorio');
            $('#txtTitulo').closest('.form-group').addClass('has-error');
        } else {
            $('#txtTitulo').closest('.form-group').removeClass('has-error');
        }
        
        if(!$('#txtFecha').val()) {
            errores.push('La fecha del evento es obligatoria');
            $('#txtFecha').closest('.form-group').addClass('has-error');
        } else {
            $('#txtFecha').closest('.form-group').removeClass('has-error');
        }
        
        if(!$('#txtHora').val()) {
            errores.push('La hora del evento es obligatoria');
            $('#txtHora').closest('.form-group').addClass('has-error');
        } else {
            $('#txtHora').closest('.form-group').removeClass('has-error');
        }
        
        if(!$('#txtPersonaContacto').val().trim()) {
            errores.push('La persona de contacto es obligatoria');
            $('#txtPersonaContacto').closest('.form-group').addClass('has-error');
        } else {
            $('#txtPersonaContacto').closest('.form-group').removeClass('has-error');
        }
        
        if(!$('#txtLugar').val().trim()) {
            errores.push('El lugar de la reunión es obligatorio');
            $('#txtLugar').closest('.form-group').addClass('has-error');
        } else {
            $('#txtLugar').closest('.form-group').removeClass('has-error');
        }
        
        if(errores.length > 0) {
            mostrarNotificacion('Por favor complete los campos obligatorios:\n' + errores.join('\n'), 'error');
            return false;
        }
        
        return true;
    }
    
    /**
     * Recolectar datos del formulario
     */
    function recolectarDatos() {
        NuevoEvento = {
            id: $('#txtID').val(),
            title: $('#txtTitulo').val(),
            start: $('#txtFecha').val() + ' ' + $('#txtHora').val(),
            end: $('#txtFecha').val() + ' ' + $('#txtHora').val(),
            idcomercial: $('#txtCliente').val(),
            backgroundColor: $('#txtColor').val(),
            borderColor: $('#txtColor').val(),
            descripcion: $('#txtDescripcion').val(),
            persona_contacto: $('#txtPersonaContacto').val(),
            lugar: $('#txtLugar').val(),
            estado: $('#txtEstado').val()
        };
    }
    
    /**
     * Enviar información al servidor
     */
    function enviarInformacion(accion, objEvento, modal) {
        var id = $('#txtID').val();
        var title = encodeURIComponent($('#txtTitulo').val());
        var start = encodeURIComponent($('#txtFecha').val() + ' ' + $('#txtHora').val());
        var end = encodeURIComponent($('#txtFecha').val() + ' ' + $('#txtHora').val());
        var idcomercial = encodeURIComponent($('#txtCliente').val());
        var color = encodeURIComponent($('#txtColor').val());
        var descripcion = encodeURIComponent($('#txtDescripcion').val());
        var persona_contacto = encodeURIComponent($('#txtPersonaContacto').val());
        var lugar = encodeURIComponent($('#txtLugar').val());
        var estado = encodeURIComponent($('#txtEstado').val());
        
        var dataString = 'title=' + title + '&start=' + start + '&end=' + end + '&color=' + color + 
                '&descripcion=' + descripcion + '&persona_contacto=' + persona_contacto + '&lugar=' + lugar + 
                '&estado=' + estado + '&idcomercial=' + idcomercial;
        
        if(id && accion == 'modificar') {
            dataString += '&id=' + id;
        }
        
        // Mostrar indicador de carga
        var btnTexto = accion === 'agregar' ? 'Guardando...' : 'Modificando...';
        if(accion === 'agregar') {
            $('#agregar_eventos').html('<i class="fa fa-spinner fa-spin"></i> ' + btnTexto).prop('disabled', true);
        } else {
            $('#modificar_eventos').html('<i class="fa fa-spinner fa-spin"></i> ' + btnTexto).prop('disabled', true);
        }
        
        $.ajax({
            type: 'POST',
            url: 'index.php?action=calendar&accion=' + accion,
            dataType: 'json',
            data: dataString,
            success: function(response) {
                console.log('Respuesta:', response);
                if(response && response.success !== false) {
                    $('#calendar').fullCalendar('refetchEvents');
                    if(!modal) {
                        $('#dlg_dias').modal('hide');
                        limpiarFormulario();
                    }
                    var mensaje = accion === 'agregar' ? 'Evento guardado correctamente' : 'Evento modificado correctamente';
                    mostrarNotificacion(mensaje, 'success');
                } else {
                    mostrarNotificacion('Error al guardar el evento. Por favor, intente nuevamente.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                mostrarNotificacion("Error al procesar la solicitud. Por favor, intente nuevamente.", 'error');
            },
            complete: function() {
                $('#agregar_eventos').html('<i class="fa fa-save"></i> Guardar Evento').prop('disabled', false);
                $('#modificar_eventos').html('<i class="fa fa-edit"></i> Modificar Evento').prop('disabled', false);
            }
        });
    }
    
    /**
     * Eliminar evento
     */
    function eliminarEvento(id) {
        $('#eliminar_eventos').html('<i class="fa fa-spinner fa-spin"></i> Eliminando...').prop('disabled', true);
        
        $.ajax({
            type: 'POST',
            url: 'index.php?action=calendar&accion=eliminar',
            dataType: 'json',
            data: { id: id },
            success: function(response) {
                console.log('Respuesta eliminar:', response);
                if(response && response.success !== false) {
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#dlg_dias').modal('hide');
                    limpiarFormulario();
                    mostrarNotificacion('Evento eliminado correctamente', 'success');
                } else {
                    mostrarNotificacion('Error al eliminar el evento. Por favor, intente nuevamente.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar:', error);
                mostrarNotificacion('Error al eliminar el evento. Por favor, intente nuevamente.', 'error');
            },
            complete: function() {
                $('#eliminar_eventos').html('<i class="fa fa-trash"></i> Eliminar Evento').prop('disabled', false);
            }
        });
    }
    
    /**
     * Limpiar formulario
     */
    function limpiarFormulario() {
        $('#txtID').val('');
        $('#txtCliente').val('');
        $('#txtTitulo').val('');
        $('#txtPersonaContacto').val('');
        $('#txtLugar').val('');
        $('#txtDescripcion').val('');
		$('#txtEstado').val('1');
		$('#txtColor').val(ESTADO_COLORES['1']);
        $('#txtFecha').val('');
        $('#txtHora').val('');
        $('.form-group').removeClass('has-error');
    }
    
    /**
     * Mostrar notificación
     */
    function mostrarNotificacion(mensaje, tipo) {
        var icono = 'fa-info-circle';
        var titulo = 'Información';
        var clase = 'info';
        
        switch(tipo) {
            case 'success':
                icono = 'fa-check-circle';
                titulo = 'Éxito';
                clase = 'success';
                break;
            case 'error':
                icono = 'fa-times-circle';
                titulo = 'Error';
                clase = 'danger';
                break;
            case 'warning':
                icono = 'fa-exclamation-triangle';
                titulo = 'Advertencia';
                clase = 'warning';
                break;
        }
        
        var notificacion = $('<div class="alert alert-' + clase + ' alert-dismissible" role="alert" style="position:fixed; top:70px; right:20px; z-index:9999; min-width:300px; max-width:500px; box-shadow:0 2px 10px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease;">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<h4><i class="icon fa ' + icono + '"></i> ' + titulo + '</h4>' +
            mensaje.replace(/\n/g, '<br/>') +
            '</div>');
        
        $('body').append(notificacion);
        
        setTimeout(function() {
            notificacion.fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // API pública
    return {
        init: init,
        mostrarNotificacion: mostrarNotificacion
    };
    
})();

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    CalendarioEventos.init();
    $('[data-toggle="tooltip"]').tooltip();
});
