<?php 
// Feed de anuncios para residentes
if(!isset($_SESSION['user_id'])){ Core::redir('./'); }

$anuncios = AnunciosData::getAll();
?>
<section class="content-header">
    <h1>Anuncios <small>Urbanización</small></h1>
</section>

<section class="content">
    <div class="row">
        <?php foreach($anuncios as $ann): ?>
        <div class="col-md-6">
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="assets/images/user1-128x128.jpg" alt="User Image">
                        <span class="username"><a href="#"><?php echo htmlspecialchars($ann->titulo); ?></a></span>
                        <span class="description"><small>(<?php echo htmlspecialchars($ann->tipo); ?> - <?php echo $ann->fecha_creacion; ?>)</small></span>
                    </div>
                </div>
                <div class="box-body">
                    <?php if ($ann->imagen): 
                        // Manejar múltiples imágenes
                        $imagenes = json_decode($ann->imagen, true);
                        if(is_array($imagenes)){
                            // Múltiples imágenes - mostrar galería
                            echo '<div class="row">';
                            foreach($imagenes as $index => $img){
                                echo '<div class="col-md-6 col-sm-12" style="margin-bottom: 10px; position: relative;">';
                                echo '<img class="img-responsive pad" src="storage/anuncios/'.htmlspecialchars($img).'" style="width:100%;height:200px;object-fit:cover;border-radius:8px;" alt="Imagen">';
                                
                                // Mostrar ubicación si existe
                                $location = AnuncioLocationData::getByAnuncioAndIndex($ann->id, $index);
                                if($location){
                                    echo '<div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px; border-radius: 4px; font-size: 12px;">';
                                    echo '<i class="fa fa-map-marker"></i> ';
                                    echo '<a href="https://www.google.com/maps?q='.$location->latitude.','.$location->longitude.'" target="_blank" style="color: white;">Ver ubicación</a>';
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            // Una sola imagen
                            echo '<div style="position: relative;">';
                            echo '<img class="img-responsive pad" src="storage/anuncios/'.htmlspecialchars($ann->imagen).'" style="width:100%;height:auto;" alt="Imagen">';
                            
                            // Mostrar ubicación si existe
                            $location = AnuncioLocationData::getByAnuncioAndIndex($ann->id, 0);
                            if($location){
                                echo '<div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px; border-radius: 4px; font-size: 12px;">';
                                echo '<i class="fa fa-map-marker"></i> ';
                                echo '<a href="https://www.google.com/maps?q='.$location->latitude.','.$location->longitude.'" target="_blank" style="color: white;">Ver ubicación</a>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    endif; ?>
                    <p><?php echo nl2br(htmlspecialchars($ann->cuerpo)); ?></p>
                </div>
                <div class="box-footer">
                    <button class="btn btn-default btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="👍">👍</button>
                    <button class="btn btn-default btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="❤️">❤️</button>
                    <button class="btn btn-default btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="😂">😂</button>
                    <button class="btn btn-default btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="😢">😢</button>
                    <span id="reactions-<?php echo $ann->id; ?>" class="pull-right"></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
$('.btn-reaction').click(function() {
    var annId = $(this).data('id');
    var emoji = $(this).data('emoji');
    var btn = $(this);
    $.post('ajax/handle_reaction.php', {announcement_id: annId, emoji: emoji}, function(data) {
        if (data.success) {
            $('#reactions-' + annId).html('Tu reacción: ' + emoji);
            $('.btn-reaction[data-id="'+annId+'"]').prop('disabled', false);
            btn.prop('disabled', true);
        }
    }, 'json');
});
</script>


