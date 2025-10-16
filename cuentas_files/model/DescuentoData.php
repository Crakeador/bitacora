<?php
//Modelos de la tabla descuento
class DescuentoData {
	public static $tablename = "descuento";

	public function __construct(){
		$this->idperson = "";
		$this->depart = "";
		$this->observacion = "";
		$this->usuario_log = "";		
		$this->is_active = "1";
		$this->created_at = "NOW()";
		$this->ip = "";		
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idperson, depart, observacion, created_at, usuario_log, ip) ";
		$sql .= "value (\"$this->idperson\", \"$this->depart\", \"$this->observacion\", $this->created_at, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")";
		
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
		$sql = "update ".self::$tablename." set observacion=\"$this->observacion\" WHERE id=$this->id"; 
		Executor::doit($sql);
	}

	static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE depart = ".$_SESSION['depart']." AND idperson = $id AND is_active = 1"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new DescuentoData());
	}

	public static function getByPerson($id){		
		$sql = "SELECT * FROM ".self::$tablename." WHERE idperson = $id AND is_active = 1"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new DescuentoData());
	}

}
