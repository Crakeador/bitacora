<?php
class ListaData {
	public static $tablename = "localidad";

	public function __construct(){
		$this->id = 0;
		$this->nombre = "";
		$this->q = 0;
		$this->serial = "";
		$this->idcard = "";
		$this->name = "";
		$this->codigo = "";
		$this->price_out = "";
		$this->categoria = "";
	}

	public static function getPuesto($id){
		$sql = "SELECT D.id, E.name nombre, D.q, D.serial, D.created_at, B.idcard, B.name, E.id codigo, E.price_out, F.name categoria, C.id venta, F.id idcategory FROM personpuestos A, person B, sell C, operation D, product E, category F WHERE A.idservicio = $id and A.idperson = B.id and B.id = C.person_id and C.id = D.sell_id and D.product_id = E.id AND E.category_id = F.id"; 
		//echo $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ListaData());
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
		return Model::many($query[0],new CargoData());
	}
}
