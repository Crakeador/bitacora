<?php
// Clase de la Tabla de Departamentos
$local = DepartamentoData::getDepart();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Caja Chica
		<small>lista de las cajas registradas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
 <section class="content container-fluid" style="padding: 1.5rem !important;">	
    <div class="container-fluid container-main">
        <!-- Botón Nuevo -->
        <div class="row mb-3">
            <div class="col">
                <button id="btnNew" class="btn btn-primary">
                <span class="me-1">Nuevo registro</span>
                </button>
            </div>
        </div>
        <!-- Tabla (DataTables) -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Registros</h3>
            </div>
            <div class="card-body">
                <table id="tablaRegistros" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Departamento</th>
                        <th>Observación</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Modal de creación/edición -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formRegistro">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="registro_id" name="id" value="">
                <div class="mb-3">
                    <label for="id_localidad">Departamento</label>
                    <select class="select-input form-control input-sm" id="id_localidad" name="id_localidad" required>
                        <option value="0" selected="selected"> Selecione... </option>
                        <?php
                            foreach($local as $locals):?>
                                <option value="<?php echo $locals->id; ?>"><?php echo utf8_encode($locals->description);?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="registro_observacion" class="form-label">Observación</label>
                    <textarea class="form-control" id="registro_observacion" name="observacion" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="registro_monto" class="form-label">Monto</label>
                    <input type="number" step="0.01" class="form-control" id="registro_monto" name="monto" required>
                </div>
                <div class="mb-3">
                    <label for="registro_fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="registro_fecha" name="fecha" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnSave">Guardar</button>
            </div>
        </form>
      </div>
    </div>
</div>
<script>
    $(document).ready(function() {
      // Inicializa DataTables
      const table = $('#tablaRegistros').DataTable({
        ajax: {
          url: 'api/registros.php',
          dataSrc: ''
        },
        columns: [
          { data: 'id' },
          { data: 'iddepartamento' },
          { data: 'observacion' },
          { data: 'monto',
            render: function(data){ return parseFloat(data).toFixed(2); }
          },
          { data: 'fecha',
            render: function(data){ 
              const d = new Date(data);
              if (isNaN(d)) return data;
              return d.toLocaleDateString('es-ES');
            }
          },
          {
            data: null,
            orderable: false,
            render: function (row) {
              return `
                <button class="btn btn-sm btn-info btn-edit" data-id="${row.id}">Editar</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Eliminar</button>
              `;
            }
          }
        ]
      });

      // Abrir modal para nuevo
      $('#btnNew').on('click', function() {
        $('#formRegistro')[0].reset();
        $('#registro_id').val('');
        $('#modalRegistroLabel').text('Nuevo registro');
        $('#modalRegistro').modal('show');
      });

      // Editar
      $('#tablaRegistros').on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.ajax({
          url: 'api/registros.php',
          method: 'GET',
          data: { id: id },
          dataType: 'json',
          success: function(data){
            $('#registro_id').val(data.id);
            $('#registro_iddepartamento').val(data.iddepartamento);
            $('#registro_observacion').val(data.observacion);
            $('#registro_monto').val(data.monto);
            // Asegurar formato yyyy-mm-dd
            $('#registro_fecha').val(data.fecha ? data.fecha.substring(0,10) : '');
            $('#modalRegistroLabel').text('Editar registro');
            $('#modalRegistro').modal('show');
          },
          error: function(){
            alert('Error obteniendo el registro');
          }
        });
      });

      // Eliminar
      $('#tablaRegistros').on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('¿Seguro que desea eliminar este registro?')) {
          $.ajax({
            url: 'api/registros.php',
            method: 'POST',
            data: { _method: 'DELETE', id: id },
            success: function(){
              table.ajax.reload();
            },
            error: function(){
              alert('Error al eliminar');
            }
          });
        }
      });

      // Guardar (crear/actualizar)
      $('#formRegistro').on('submit', function(e){
        e.preventDefault();
        const id = $('#registro_id').val();
        const payload = {
          iddepartamento: $('#registro_iddepartamento').val(),
          observacion: $('#registro_observacion').val(),
          monto: $('#registro_monto').val(),
          fecha: $('#registro_fecha').val()
        };

        if (id) {
            // Actualizar
            $.ajax({
                url: 'api/registros.php',
                method: 'POST',
                data: Object.assign({ _method: 'PUT', id: id }, payload),
                success: function(){
                $('#modalRegistro').modal('hide');
                table.ajax.reload();
                },
                error: function(){
                alert('Error al actualizar');
                }
            });
        }else{
            // Crear
            $.ajax({
                url: 'api/registros.php',
                method: 'POST',
                data: payload,
                success: function(){
                $('#modalRegistro').modal('hide');
                table.ajax.reload();
                },
                error: function(){
                alert('Error al crear');
                }
            });
        }
      });
    });
</script>