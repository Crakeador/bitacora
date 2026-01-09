<?php

class ContactoData {
    public static $tablename = "contacto";

    public function __construct(){
        $this->id = null;
        $this->idpuesto = null;
        $this->idperson = null;
        $this->nombre = null;
        $this->cedula = null;
        $this->placa = null;
        $this->created_at = null;
    }
    
    public function add(){
        $idpuesto = intval($this->idpuesto);
        $idperson = intval($this->idperson);
        $nombre = $this->escape($this->nombre);
        $cedula = $this->escape($this->cedula);
        $placa = $this->escape($this->placa);
        
        $sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, nombre, cedula, placa) VALUES ($idpuesto, $idperson, \"$nombre\", \"$cedula\", \"$placa\")";
        Executor::doit($sql);
    }

    public static function getAll($idpuesto){
        $sql = "SELECT * FROM ".self::$tablename." WHERE idpuesto=".intval($idpuesto)." ORDER BY placa DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ContactoData());
    }

    public static function getLike($person){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=".intval($person);
        $query = Executor::doit($sql);
        return Model::one($query[0], new ContactoData());
    }

    private function escape($str){
        $con = Database::getCon();
        return $con->real_escape_string($str);
    }
}
