<?php 
//Lista de anuncios para residentes
$noticias = AnunciosData::getAll();

?>
<style>
    .box-footer {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        border-top: 1px solid #f4f4f4;
        padding: 10px;
        background-color: #fff;
    }
    .user-block .description {
        color: #999;
        font-size: 13px;
    }
    .user-block .username {
        font-size: 16px;
        font-weight: 600;
    }
    .user-block .username, .user-block .description, .user-block .comment {
        display: block;
        margin-left: 50px;
    }
    .user-block img {
        width: 40px;
        height: 40px;
        float: left;
    }
    user agent stylesheet
    div {
        display: block;
        unicode-bidi: isolate;
    }    
    img {
        overflow-clip-margin: content-box;
        overflow: clip;
    }
    .img-circle {
        border-radius: 50%;
    }
    img {
        vertical-align: middle;
    }
    img {
        border: 0;
    }
    .img-sm, .box-comments .box-comment img, .user-block.user-block-sm img {
        width: 30px !important;
        height: 30px !important;
    }
    .img-sm, .img-md, .img-lg, .box-comments .box-comment img, .user-block.user-block-sm img {
        float: left;
    }
    .box-comments .box-comment img {
        float: left;
    }
    .box-comments .comment-text {
        margin-left: 40px;
        color: #555;
    }
    .box-comments .username {
        color: #444;
        display: block;
        font-weight: 600;
    }
</style>
<section class="content-header">
    <div class="row"> <?php 
        foreach ($noticias as $ann):  ?>
            <div class="col-md-6">
                <!-- Box Comment -->
                <div class="box box-widget">
                    <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="../assets/images/user1-128x128.jpg" alt="User Image">
                        <span class="username"><a href="#"><?php echo htmlspecialchars($ann->title); ?> </a></span>
                        <span class="description"><small>(<?php echo ucfirst($ann->type); ?> - <?php echo $ann->date; ?>)</small></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                        <i class="fa fa-circle"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">                        
                        <?php if ($ann->imagen): ?>
                            <img class="img-responsive pad" src="../storage/anuncios/<?php echo $ann->imagen; ?>" class="img-responsive" style="width: 100%; height: auto;" alt="Photo">
                        <?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($ann->body)); ?></p>
                        <span class="pull-right text-muted">127 likes - 3 comments</span>
                    </div>                    
                    <div class="box-footer">
                        <button class="btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="👍">👍</button>
                        <button class="btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="❤️">❤️</button>
                        <button class="btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="😂">😂</button>
                        <button class="btn-reaction" data-id="<?php echo $ann->id; ?>" data-emoji="😢">😢</button>
                        <span id="reactions-<?php echo $ann->id; ?>"></span>
                    </div>
                </div>
            </div> <?php 
        endforeach; ?>
    </div> 
</section>
<script>
    // Reacciones AJAX
    $('.btn-reaction').click(function() {
        var annId = $(this).data('id');
        var emoji = $(this).data('emoji');
        var btn = $(this);

        $.post('ajax/handle_reaction.php', {announcement_id: annId, emoji: emoji}, function(data) {
            if (data.success) {
                // Actualiza UI (simple: muestra emoji del usuario)
                $('#reactions-' + annId).html('Tu reacción: ' + emoji);
                btn.prop('disabled', true);
            }
        }, 'json');
    });

    // Cargar reacciones iniciales (opcional, vía AJAX)
    $(function() {
        // Para cada anuncio, fetch reacciones si quieres counts
    });
</script>