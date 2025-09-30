<?php
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

if(count($_POST) > 0){
    $a = new AnunciosData();
    $a->titulo = $_POST['titulo'];
    $a->cuerpo = $_POST['cuerpo'];
    $a->tipo = $_POST['tipo'];
    
    // Manejo de múltiples imágenes
    $imagenes = [];
    if(isset($_FILES['fotos']) && is_array($_FILES['fotos']['name'])){
        if(!is_dir("storage/anuncios")){
            @mkdir("storage/anuncios", 0775, true);
        }
        
        for($i = 0; $i < count($_FILES['fotos']['name']); $i++){
            if(is_uploaded_file($_FILES['fotos']['tmp_name'][$i])){
                $ext = pathinfo($_FILES['fotos']['name'][$i], PATHINFO_EXTENSION);
                $name = date('Ymd_His')."_".$i."_".uniqid().".".$ext;
                $dest = "storage/anuncios/".$name;
                
                if(move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $dest)){
                    $imagenes[] = $name;
                }
            }
        }
    }
    
    // Guardar como JSON si hay múltiples imágenes, o string simple si es una
    if(count($imagenes) > 0){
        $a->imagen = count($imagenes) == 1 ? $imagenes[0] : json_encode($imagenes);
    }
    $a->add();
    
    // Obtener el ID del anuncio recién creado
    $anuncioId = Database::getCon()->insert_id;
    
    // Guardar geolocalización de las fotos
    for($i = 0; $i < count($imagenes); $i++){
        if(isset($_POST["location_$i"])){
            $locationData = json_decode($_POST["location_$i"], true);
            if($locationData && isset($locationData['lat']) && isset($locationData['lng'])){
                $location = new AnuncioLocationData();
                $location->anuncio_id = $anuncioId;
                $location->foto_index = $i;
                $location->latitude = $locationData['lat'];
                $location->longitude = $locationData['lng'];
                $location->accuracy = isset($locationData['accuracy']) ? $locationData['accuracy'] : null;
                $location->address = isset($locationData['address']) ? $locationData['address'] : null;
                $location->add();
            }
        }
    }
}
Core::redir('anuncios.admin');

