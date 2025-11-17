<?php
//Modelos de la tabla fotos
class FotosData {
	public static $tablename = "fotos";

	public function __construct(){
		$this->id = "";
		$this->idpadre= "";
		$this->nombre_archivo = "";
		$this->tipo = "";
		$this->fecha = "";		
	}

	static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idpadre = $id"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new FotosData());
	}

	static function getByTipo($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idpadre = $id AND tipo = 'documento'"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new FotosData());
	}
}
