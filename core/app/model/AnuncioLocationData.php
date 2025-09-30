<?php

class AnuncioLocationData {
    public static $tablename = "anuncio_locations";

    public function __construct(){
        $this->id = null;
        $this->anuncio_id = null;
        $this->foto_index = null;
        $this->latitude = null;
        $this->longitude = null;
        $this->accuracy = null;
        $this->address = null;
        $this->created_at = null;
    }

    public function add(){
        $anuncioId = intval($this->anuncio_id);
        $fotoIndex = intval($this->foto_index);
        $lat = floatval($this->latitude);
        $lng = floatval($this->longitude);
        $accuracy = floatval($this->accuracy);
        $address = $this->escape($this->address);
        
        $sql = "INSERT INTO ".self::$tablename." (anuncio_id, foto_index, latitude, longitude, accuracy, address) VALUES ($anuncioId, $fotoIndex, $lat, $lng, $accuracy, \"$address\")";
        Executor::doit($sql);
    }

    public static function getByAnuncioId($anuncioId){
        $sql = "SELECT * FROM ".self::$tablename." WHERE anuncio_id=".intval($anuncioId)." ORDER BY foto_index";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AnuncioLocationData());
    }

    public static function getByAnuncioAndIndex($anuncioId, $fotoIndex){
        $sql = "SELECT * FROM ".self::$tablename." WHERE anuncio_id=".intval($anuncioId)." AND foto_index=".intval($fotoIndex)." LIMIT 1";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AnuncioLocationData());
    }

    private function escape($str){
        $con = Database::getCon();
        return $con->real_escape_string($str);
    }
}
