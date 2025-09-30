<?php
//Clases de la tabla reacciones
class ReaccionesData {
    public static $tablename = "reacciones";

    public function __construct(){
        $this->id = null;
        $this->anuncio_id = null;
        $this->usuario_id = null;
        $this->emogi = "";
        $this->creado_en = null;
    }

    public function addOrUpdate(){
        $anuncioId = intval($this->anuncio_id);
        $usuarioId = intval($this->usuario_id);
        $emoji = $this->escape($this->emoji);
        // Upsert simple: si existe, actualiza; si no, inserta
        $sql = "INSERT INTO ".self::$tablename." (announcement_id, user_id, emoji) VALUES ($anuncioId, $usuarioId, \"$emoji\")\n  ON DUPLICATE KEY UPDATE emogi=VALUES(emogi), creado_en=CURRENT_TIMESTAMP";
        Executor::doit($sql);
    }

    public static function getByUser($anuncioId, $usuarioId){
        $sql = "SELECT * FROM ".self::$tablename." WHERE announcement_id=".intval($anuncioId)." AND user_id=".intval($usuarioId)." LIMIT 1";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ReaccionesData());
    }

    public static function getCountsByAnuncio($anuncioId){
        $sql = "SELECT emoji, COUNT(*) as total FROM ".self::$tablename." WHERE announcement_id=".intval($anuncioId)." GROUP BY emoji"; 
        $query = Executor::doit($sql);
        $rows = [];
        while($r = $query[0]->fetch_assoc()){
            $rows[$r['emoji']] = intval($r['total']);
        }
        return $rows;
    }

    private function escape($str){
        $con = Database::getCon();
        return $con->real_escape_string($str);
    }
}


