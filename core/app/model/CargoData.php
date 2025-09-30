<?php
// Clase de la Tabla de Cargos
class CargoData {
	public static $tablename = "cargo";

	public function __construct(){
		$this->id = "";
		$this->iddepartamento = "";
		$this->description = "";
		$this->idtipo = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (iddepartamento, description, idtipo, is_active, usuario_log, created_at) ";
		$sql .= "value (\"$this->iddepartamento\", \"$this->description\", \"$this->idtipo\", \"$this->is_active\", \"".$_SESSION['user_name']."\", $this->created_at)";
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
		$sql = "update ".self::$tablename." set iddepartamento=\"$this->iddepartamento\", description=\"$this->description\", ";
		$sql .= "idtipo=\"$this->idtipo\", is_active=\"$this->is_active\", usuario_log=\"".$_SESSION['user_name']."\" WHERE id=$this->id"; 
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=\"$id\""; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new CargoData());
	}

	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LugarData());
	}

	public static function getAll(){
		$sql = "SELECT B.description departamento, C.description tipo, A.* ";
		$sql .=  "FROM cargo A, departamento B, tipo C ";
		$sql .= "WHERE A.iddepartamento = B.id AND A.idtipo = C.id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CargoData());
	}
}
?>
