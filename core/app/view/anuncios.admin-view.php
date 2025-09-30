<?php
// Panel de administración de anuncios
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

$anuncios = AnunciosData::getAll();
var_dump($anuncios);
?>
<section class="content-header">
    <h1>Anuncios <small>Administración</small></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="index.php?view=anuncios.crear" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</a>
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-download"></i> Exportar <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?view=anuncios.estadisticas&formato=excel"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                        <li><a href="index.php?view=anuncios.estadisticas&formato=pdf"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                        <li><a href="index.php?view=anuncios.graficos"><i class="fa fa-bar-chart"></i> Gráficos</a></li>
                        <li><a href="index.php?view=anuncios.mapa"><i class="fa fa-map"></i> Mapa</a></li>
                    </ul>
                </div>
                <span class="label label-info" id="totalReacciones" style="margin-left: 10px;">Total reacciones: <span id="totalCount">0</span></span>
            </div>
        </div>
        <div class="box-body">
            <!-- Filtros por emoji -->
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm active" data-filter="all">
                            <input type="radio" name="emojiFilter" value="all" checked> Todos
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="👍">
                            <input type="radio" name="emojiFilter" value="👍"> 👍
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="❤️">
                            <input type="radio" name="emojiFilter" value="❤️"> ❤️
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="😂">
                            <input type="radio" name="emojiFilter" value="😂"> 😂
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="😢">
                            <input type="radio" name="emojiFilter" value="😢"> 😢
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="😮">
                            <input type="radio" name="emojiFilter" value="😮"> 😮
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="👏">
                            <input type="radio" name="emojiFilter" value="👏"> 👏
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="🔥">
                            <input type="radio" name="emojiFilter" value="🔥"> 🔥
                        </label>
                        <label class="btn btn-default btn-sm" data-filter="🎉">
                            <input type="radio" name="emojiFilter" value="🎉"> 🎉
                        </label>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="tblAnuncios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Imagen</th>
                            <th>Reacciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($anuncios as $a): ?>
                        <tr>
                            <td><?php echo $a->id; ?></td>
                            <td><?php echo htmlspecialchars($a->title); ?></td>
                            <td><?php echo htmlspecialchars($a->type); ?></td>
                            <td><?php echo $a->date; ?></td>
                            <td><?php if($a->image) echo '<img src="storage/anuncios/'.htmlspecialchars($a->image).'" style="height:40px">'; ?></td> <?php 
                            $counts = ReaccionesData::getCountsByAnuncio($a->id); $totalReac = 0; 
                            var_dump($counts);
                            foreach($counts as $ct){ $totalReac += intval($ct); } ?>
                            <td data-order="<?php echo $totalReac; ?>" data-reactions='<?php echo json_encode($counts); ?>'>
                                <?php 
                                    if(!empty($counts)){
                                        $order = ["👍","❤️","😂","😢","😮","👏","🔥","🎉"]; 
                                        $printed = 0;
                                        foreach($order as $em){ if(isset($counts[$em])){ echo '<span style="margin-right:6px">'.$em.' <b>'.intval($counts[$em]).'</b></span>'; $printed++; } }
                                        foreach($counts as $em=>$ct){ if(!in_array($em,$order)){ echo '<span style="margin-right:6px">'.htmlspecialchars($em).' <b>'.intval($ct).'</b></span>'; $printed++; } }
                                        if($printed===0){ echo '<span class="text-muted">—</span>'; }
                                        echo '<span class="hidden"> Total: '.$totalReac.'</span>';
                                    } else { echo '<span class="text-muted">—</span>'; }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-warning btn-edit" data-id="<?php echo $a->id; ?>" data-title="<?php echo htmlspecialchars($a->title); ?>" data-cuerpo="<?php echo htmlspecialchars($a->body); ?>" data-tipo="<?php echo htmlspecialchars($a->type); ?>"><i class="fa fa-pen"></i></button>
                                <a class="btn btn-xs btn-danger" href="index.php?view=anuncios.eliminar&id=<?php echo $a->id; ?>" onclick="return confirm('¿Eliminar anuncio?');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo -->
    <div class="modal fade" id="modalNuevo">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="index.php?view=anuncios.crear" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo Anuncio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control">
                                <option value="noticia">Noticia</option>
                                <option value="servicio">Servicio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="cuerpo" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Imagen (opcional)</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="index.php?view=anuncios.editar" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Anuncio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="titulo" id="editTitulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" id="editTipo" class="form-control">
                                <option value="noticia">Noticia</option>
                                <option value="servicio">Servicio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="cuerpo" id="editCuerpo" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Imagen (opcional, deja vacío para no cambiar)</label>
                            <input type="file" name="imagen" accept="image/*" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        var table;
        if($.fn.DataTable){
            table = $('#tblAnuncios').DataTable({
                order: [[5, 'desc']],
                pageLength: 10,
                responsive: true,
                language: {
                    url: 'plugins/datatables/i18n/Spanish.json'
                }
            });
            
            // Calcular total de reacciones
            var totalReacciones = 0;
            $('#tblAnuncios tbody tr').each(function(){
                var reactions = $(this).find('td[data-reactions]').data('reactions');
                if(reactions){
                    Object.values(reactions).forEach(function(count){
                        totalReacciones += parseInt(count) || 0;
                    });
                }
            });
            $('#totalCount').text(totalReacciones);
            
            // Filtros por emoji
            $('input[name="emojiFilter"]').on('change', function(){
                var filter = $(this).val();
                if(filter === 'all'){
                    table.search('').draw();
                } else {
                    // Filtrar por emoji específico
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex){
                        var reactions = JSON.parse($('#tblAnuncios tbody tr:eq(' + dataIndex + ') td[data-reactions]').attr('data-reactions') || '{}');
                        return reactions[filter] && parseInt(reactions[filter]) > 0;
                    });
                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                }
            });
        }
    });
    $('.btn-edit').on('click', function(){
        $('#editId').val($(this).data('id'));
        $('#editTitulo').val($(this).data('titulo'));
        $('#editCuerpo').val($(this).data('cuerpo'));
        $('#editTipo').val($(this).data('tipo'));
        $('#modalEditar').modal('show');
    });
</script>


