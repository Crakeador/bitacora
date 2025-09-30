<?php
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

if(count($_POST) > 0){
    $a = AnunciosData::getById(intval($_POST['id']));
    if($a){
        $a->titulo = $_POST['titulo'];
        $a->cuerpo = $_POST['cuerpo'];
        $a->tipo = $_POST['tipo'];
        if(isset($_FILES['imagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $name = date('Ymd_His')."_".preg_replace('/[^A-Za-z0-9._-]/','_', $_FILES['imagen']['name']);
            $dest = "storage/anuncios/".$name;
            if(!is_dir("storage/anuncios")){
                @mkdir("storage/anuncios", 0775, true);
            }
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $dest)){
                $a->imagen = $name;
            }
        }
        $a->update();
    }
}
Core::redir('anuncios.admin');

