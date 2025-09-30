<?php
// Panel de administración de anuncios y gestión de reacciones
$anuncios = AnunciosData::getAll();
// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Mostrar la lista de anuncios
        break;
    case 'POST': 
        // Crear nuevo anuncio 
        $anuncio = new AnunciosData();   

        $anuncio->titulo = $_POST["titulo"];
        $anuncio->tipo = $_POST["tipo"];
		$anuncio->cuerpo = $_POST["cuerpo"];

        if($_FILES["imagen"]["name"]==""){
            $anuncio->imagen = "";
        }else{
            $image = new Upload($_FILES["imagen"]);

            if($image->uploaded){
                $image->Process("storage/anuncios/");

                if($image->processed){
                    $anuncio->imagen = $image->file_dst_name;
                }
            }
        }

        if(isset($_POST["id"]) && $_POST["id"]!=""){
            //Actualizar anuncio
            $anuncio->id = $_POST["id"];
            $anuncio->update();
        } else {
            //Nuevo anuncio
            $anuncio->add();
        }
		Core::redir("anuncios");
        break;
    default:
        // Manejar otros métodos HTTP si es necesario
    break;
}
?>
<section class="content-header">
    <h1>
        Anuncios 
        <small>Administración</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-book"></i> Panel de Control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="box">
        <div class="box-header with-border">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> Nuevo</button>
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
                            <td><?php if($a->imagen) echo '<img src="storage/anuncios/'.htmlspecialchars($a->imagen).'" style="height:40px">'; ?></td> <?php 
                            $counts = ReaccionesData::getCountsByAnuncio($a->id); $totalReac = 0; 
                            
                            foreach($counts as $ct){ $totalReac += intval($ct); } ?>
                            <td data-order="<?php echo $totalReac; ?>" data-reactions='<?php echo json_encode($counts); ?>'>
                                <div align="center"> <?php 
                                    if(!empty($counts)){
                                        $order = ["👍","❤️","😂","😢","😮","👏","🔥","🎉"]; 
                                        $printed = 0;
                                        foreach($order as $em){ 
                                            if(isset($counts[$em])){ 
                                                echo '<span style="margin-right:6px">'.$em.' <b>'.intval($counts[$em]).'</b></span>'; $printed++; 
                                            } 
                                        }
                                        foreach($counts as $em=>$ct){ if(!in_array($em,$order)){ 
                                            echo '<span style="margin-right:6px">'.htmlspecialchars($em).' <b>'.intval($ct).'</b></span>'; $printed++; } 
                                        }

                                        if($printed===0){ 
                                            echo '<span class="text-muted"><b>0</b></span>'; 
                                        }
                                        echo '<span class="hidden"> Total: '.$totalReac.'</span>';
                                    } else { 
                                        echo '<span class="text-muted"><b>0</b></span>'; 
                                    } ?>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-warning btn-edit" data-id="<?php echo $a->id; ?>" data-title="<?php echo htmlspecialchars($a->title); ?>" data-body="<?php echo htmlspecialchars($a->body); ?>" data-type="<?php echo htmlspecialchars($a->type); ?>"><i class="fa fa-pen"></i></button>
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
                <form method="post" action="./anuncios" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo Anuncio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" name="tipo" class="form-control">
                                <option value="noticias">Noticia</option>
                                <option value="servicios">Servicio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cuerpo">Contenido</label>
                            <textarea id="cuerpo" name="cuerpo" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen (opcional)</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control">
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
                <form method="post" action="./anuncios" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Anuncio</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="noticias">Noticia</option>
                                <option value="servicios">Servicio</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cuerpo">Contenido</label>
                            <textarea name="cuerpo" id="cuerpo" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen (opcional, deja vacío para no cambiar)</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control">
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
        $('#editTitulo').val($(this).data('title'));
        $('#editCuerpo').val($(this).data('body'));
        $('#editTipo').val($(this).data('type'));
        $('#modalEditar').modal('show');
    });
</script>


