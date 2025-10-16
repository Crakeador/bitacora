<?php
class RubroData {
	public static $tablename = "rubro";

	public function __construct(){
		$this->id = "";
		$this->company = "";
		$this->tipo_cuenta = "";
		$this->descripcion = "";
		$this->valor = "";
		$this->calcular = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (company, tipo_cuenta, descripcion, valor, calcular, is_active, usuario_log) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->tipo_cuenta\", \"$this->descripcion\", \"$this->valor\", \"$this->calcular\", 1, ".$_SESSION['user_name'].")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET company = ".$_SESSION['id_company'].", tipo_cuenta = '".$this->tipo_cuenta."', descripcion ='".$this->descripcion."', valor = ".$this->valor.", calcular = ".$this->calcular.", ";
		$sql .= "is_active ='".$this->is_active."', usuario_log ='".$_SESSION['user_name']."' WHERE id=$this->id";
		Executor::doit($sql);
	}
	
	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new RubroData());
	}

	public static function getByName($name){
		$sql = "SELECT * FROM ".self::$tablename." WHERE name=\"$name\"";
		$query = Executor::doit($sql);
		$found = null;
		$data = new OperationTypeData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getCombo(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE company = ".$_SESSION['id_company']." AND is_active=1 ORDER BY orden_rubro";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NominaData());
	}

	public static function getTipo($tipo){
		$sql = "SELECT * FROM ".self::$tablename." WHERE company = ".$_SESSION['id_company']." AND tipo_cuenta = '".$tipo."' ORDER BY orden_rubro";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NominaData());
	}

	public static function getRubro(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE company = ".$_SESSION['id_company']." ORDER BY orden_rubro";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NominaData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE company = ".$_SESSION['id_company']." AND is_active=1 ORDER BY orden_rubro";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new RubroData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo_cuenta = $r['tipo_cuenta'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->valor = $r['valor'];
			$array[$cnt]->calcular = $r['calcular'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllTotal(){
		$sql = "SELECT * FROM entrada WHERE is_active=1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new RubroData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->tipo_cuenta = $r['tipo'];
			$array[$cnt]->descripcion = $r['description'];
			$array[$cnt]->valor = $r['monto'];
			$cnt++;
		}
		return $array;
	}
}
