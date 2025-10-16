<?php
// Clase de los lugares  
class LugarData {
	public static $tablename = "localidad";

	public function __construct(){
		$this->id = "";
		$this->descripcion = "";
		$this->nombre = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (descripcion, nombre, created_at) ";
		$sql .= "value (\"$this->descripcion\", \"$this->nombre\", $this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET is_active=$this->is_active, nombre=\"$this->nombre\", descripcion=\"$this->descripcion\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LugarData());
	}

	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LugarData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new LugarData());
	}
}
