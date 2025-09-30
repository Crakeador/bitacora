<?php
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

if(isset($_GET['id'])){
    AnunciosData::delById(intval($_GET['id']));
}
Core::redir('anuncios.admin');

