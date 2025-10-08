<?php
// Modelo de la tabla de departamentos
class DepartamentoData {
	public static $tablename = "departamento";

	public function __construct(){
		$this->name = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, name, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->description\", $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$this->id";
		Executor::doit($sql);
	}

	public function recuperar(){
		$sql = "update ".self::$tablename." set is_active = 1 where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\", update_at=\"$this->created_at\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DepartamentoData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);
		return Model::many($query[0],new DepartamentoData());
	}
	
	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DepartamentoData());
	}
}