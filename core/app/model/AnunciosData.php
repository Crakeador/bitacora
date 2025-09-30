<?php
//Clase de la tabla anuncios
class AnunciosData {
    public static $tablename = "anuncios";
    
    public function __construct(){
        $this->id = null;
        $this->title = "";
        $this->body = "";
        $this->imagen = null;
        $this->type = "noticia";
        $this->autor_id = null;
        $this->fecha_creacion = null;
    }
    
    public function add(){
        $titulo = $this->escape($this->titulo);
        $cuerpo = $this->escape($this->cuerpo);
        $imagen = $this->imagen ? ('"'. $this->escape($this->imagen) .'"') : 'NULL';
        $tipo = $this->escape($this->tipo);
        $autor = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 'NULL';
        $sql = "INSERT INTO ".self::$tablename." (title, body, imagen, type, autor_id) VALUES (\"$titulo\",\"$cuerpo\",$imagen,\"$tipo\",$autor)"; 
        Executor::doit($sql);
    }

    public function update(){
        $titulo = $this->escape($this->titulo);
        $cuerpo = $this->escape($this->cuerpo);
        $tipo = $this->escape($this->tipo);
        $imagenSet = $this->imagen !== "" ? ", imagen=\"".$this->escape($this->imagen)."\"" : "";
        $sql = "UPDATE ".self::$tablename." SET title=\"$titulo\", body=\"$cuerpo\", type=\"$tipo\"$imagenSet WHERE id=".intval($this->id);
        Executor::doit($sql);
    }

    public static function delById($id){
        $sql = "DELETE FROM ".self::$tablename." WHERE id=".intval($id);
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM ".self::$tablename." WHERE id=".intval($id)." LIMIT 1";
        $query = Executor::doit($sql);
        return Model::one($query[0], new AnunciosData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM ".self::$tablename." ORDER BY date DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new AnunciosData());
    }

    private function escape($str){
        $con = Database::getCon();
        return $con->real_escape_string($str);
    }
}


