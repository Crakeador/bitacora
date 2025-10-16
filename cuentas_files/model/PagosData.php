<?php
// Clase de la tabla pagos
class PagosData {
	public static $tablename = "pagos";

	public function __construct(){
		$this->id = "";
		$this->idperson = "";
		$this->mes = "";
		$this->ano = "";
		$this->tipo = "";
		$this->monto = 0;
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idperson, dia, mes, ano, tipo, monto, created_at) ";
		$sql .= "value ($this->idperson, \"01\", \"$this->mes\", \"$this->ano\", \"$this->tipo\", $this->monto, $this->created_at)";
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
		$sql = "UPDATE ".self::$tablename." SET is_active=$this->is_active WHERE idperson=$this->idperson AND mes=$this->mes AND ano=$this->ano"; 
		Executor::doit($sql);
	}

	public static function getById($id, $mes, $ano){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idperson=$id AND mes='$mes' AND ano='$ano' AND is_active=1"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new PagosData());
	}

	public static function getLike($id, $mes, $ano){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idperson=$id AND mes='$mes' AND ano='$ano'"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new PagosData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new LugarData());
	}
}
