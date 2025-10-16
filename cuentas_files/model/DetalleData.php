<?php
class DetalleData {
	public static $tablename = "recibod";

	public function __construct(){
		$this->id = "";
		$this->idrecibo = "";
		$this->cuota = 0;
		$this->monto = 0;
		$this->fecha = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name) ";
		$sql .= "value (\"$this->name\")";
		Executor::doit($sql);
	}

	public function addRecibo(){
		$sql = "INSERT INTO recibod (idrecibo, cuota, monto, fecha, created_at) ";
		$sql .= "VALUES (\"$this->id\", \"$this->cuota\", \"$this->monto\", \"$this->fecha\", $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set monto=\"$this->monto\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getByIdDescuento($id){
		$sql = "SELECT * FROM recibod WHERE id = $id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DetalleData());
	}

	public static function getById($id){
		$sql = "SELECT A.*, B.cuota totales, B.idperson, C.idcard, C.name FROM ".self::$tablename." A, recibo B, person C WHERE A.idrecibo = B.id AND B.idperson = C.id AND A.idrecibo=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NominaData());
	}

	public static function getByName($name){
		$sql = "select * from ".self::$tablename." where name=\"$name\"";
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

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active=1 ORDER BY orden_rubro";
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
