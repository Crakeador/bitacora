<?php
// Modelo de la tabla de areas comunes
class AreasData {
	public static $tablename = "areas";

	public function __construct(){
		$this->name = "";
		$this->tipo = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, name, created_at) 
		              value (".$_SESSION['id_company'].", \"$this->name\", $this->created_at)"; 
		$array = Executor::doit($sql);				
		return $array;
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id"; 
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AreasData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);
		return Model::many($query[0],new AreasData());
	}

	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new AreasData());
	}
}

