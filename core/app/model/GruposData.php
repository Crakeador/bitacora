<?php
// Clases utilizadas en la tabla de grupos
class GruposData {
	public static $tablename = "grupo";

	public function __construct(){
		$this->id = 0;
		$this->idcompany = 0;
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name, idcompany, is_active, usuario_log, created_at) ";
		$sql .= "value (\"$this->name\", ".$_SESSION['id_company'].", $this->is_active, \"".$_SESSION['user_name']."\", $this->created_at)";
		return Executor::doit($sql);
	}

	public function addGrupo(){
		$sql = "INSERT INTO grupoperson (idgrupo, idperson, is_active) ";
		$sql .= "value (\"$this->idgrupo\", \"$this->idperson\", $this->is_active)"; 
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET idclient='".$this->idclient."', codigo ='".$this->codigo."', residencial ='".$this->residencial."', descripcion ='".$this->descripcion."', activado ='".$this->activado."', idlugar ='".$this->idlugar."', horas ='".$this->horas."', horario ='".$this->horario."', observacion ='".$this->observacion."',";
		$sql .= "lunes ='".$this->lunes."', martes ='".$this->martes."', miercoles ='".$this->miercoles."', jueves ='".$this->jueves."', viernes ='".$this->viernes."', sabado ='".$this->sabado."', domingo ='".$this->domingo."', feriado ='".$this->feriado."', principal ='".$this->principal."', is_active ='".$this->is_active."', usuario_log ='".$_SESSION['user_name']."' WHERE id=$this->id"; 
		Executor::doit($sql);
	}

	public function serial(){
		$sql = "UPDATE operation SET serial='".$this->serial."', estado ='".$this->estado."' WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function tarea($valor, $clave){
		$sql = "UPDATE consecutivo SET consecutivo ='".$clave."' WHERE tabla='".$valor."'";
		Executor::doit($sql);
	}

	public function desvincular(){
		$sql = "UPDATE grupoperson SET is_active=0, usuario_log ='".$_SESSION['user_name']."', ip ='".$_SESSION['ip']."' WHERE idperson=$this->id";
		Executor::doit($sql);
	}
	
	public static function getByIdOperation($id){
		$sql = "select * from operation where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new GruposData());
	}

	public static function getValores($tabla){
		$sql = "SELECT * FROM consecutivo WHERE tabla = '$tabla' AND is_active = 1"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new GruposData());
	}

	public static function getAll($activo = 1){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=$activo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new GruposData());
	}

	public static function getAllGrupo($grupo = 0, $activo = 1){
		$sql = "SELECT E.nombre, D.name AS departamento, B.name AS grupo, C.* FROM grupoperson A, grupo B, user C, departamento D, rol E WHERE A.idgrupo = B.id AND A.idperson = C.id AND C.iddepartamento = D.id AND C.idrol = E.id AND A.idgrupo=$grupo AND A.is_active=$activo"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new GruposData());
	}
}