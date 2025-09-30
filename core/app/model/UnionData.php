<?php
// Clases de la tabla de Person x Puesto

class UnionData {
	public static $tablename = "personpuestos";

	public function __construct(){
		$this->id = 0;
		$this->idservicio = "";
		$this->idperson = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idservicio, idperson, is_active) ";
		$sql .= "value (\"$this->idservicio\", \"$this->idperson\", $this->is_active)"; 
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$id";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$this->id";
		return Executor::doit($sql);
	}

	public function finTurno(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE idservicio=$this->idservicio AND idperson=$this->idperson";
		return Executor::doit($sql);
	}
	
	public function update(){
		$sql = "UPDATE ".self::$tablename." SET is_active=$this->is_active, idservicio=\"$this->idservicio\", ";
		$sql .= "idperson=\"$this->idperson\", usuario_log=\"".$_SESSION['user_name']."\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LugarData());
	}

	public static function getByIdLugares($id){
		$sql = "select A.*, B.descripcion, B.codigo from ".self::$tablename." A, puestos B where A.idservicio=B.id and idperson=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getAll(){
		$sql = "SELECT A.*, B.descripcion, B.codigo FROM ".self::$tablename." A, puestos B where A.idservicio=B.id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LugarData());
	}

	public static function getTipo(){
		$sql = "SELECT * FROM tipo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UnionData());
	}
}