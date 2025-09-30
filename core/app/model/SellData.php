<?php
// Clases de la tabla de Ventas
class SellData {
	public static $tablename = "sell";

	public function __construct(){
		$this->id = 0;
		$this->name = "";
		$this->q = 0;
		$this->categorys = "";
		$this->discount = 0;
		$this->productos = 0;
		$this->created_at = "NOW()";
	}

	public function getPerson(){ return PersonData::getById($this->person_id);}
	public function getUser(){ return UserData::getById($this->user_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (total, discount, user_id, usuario_log, ip, created_at) ";
		$sql .= "value ($this->total, $this->discount, $this->user_id, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; //echo 'Ingreso: '.$sql;
		return Executor::doit($sql);
	}

	public function add_re(){
		$sql = "insert into ".self::$tablename." (user_id,operation_type_id,created_at) ";
		$sql .= "value ($this->user_id,1,$this->created_at)";
		return Executor::doit($sql);
	}

	public function add_with_client(){
		$sql = "insert into ".self::$tablename." (total, discount, person_id, user_id, usuario_log, ip, created_at) ";
		$sql .= "value ($this->total, $this->discount, $this->person_id, $this->user_id, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; //echo 'Cliente: '.$sql;
		return Executor::doit($sql);
	}

	public function add_re_with_client(){
		$sql = "insert into ".self::$tablename." (person_id,operation_type_id,user_id,created_at) ";
		$sql .= "value ($this->person_id,1,$this->user_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update_box(){
		$sql = "update ".self::$tablename." set box_id=$this->box_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}

	public static function getByIdPerson($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE person_id=$id AND operation_type_id = 2";
		$query = Executor::doit($sql);
		return Model::one($query[0],new SellData());
	}

	public static function getByIdProduct($id){
		$con = Database::getCon();
		$sql = "SELECT C.name, B.q, D.name, A.discount, A.created_at, A.id FROM sell A, operation B, product C, category D 
		         WHERE A.id = B.sell_id AND B.product_id = C.id AND C.category_id = D.id AND B.sell_id = $id 	
	          ORDER BY A.created_at"; 
		
		$query = $con->query($sql);
    
		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["producto"] = $r[0];
			$array[$x]["cantidad"] = $r[1];
			$array[$x]["categoria"] = $r[2];
			$array[$x]["descuento"] = $r[3];
			$array[$x]["entregado"] = $r[4];
			$array[$x]["venta"] = $r[5];
			$x++;
		}
		return $array;
	}

	public static function getSells(){ 
		$sql = "select B.name, A.* from sell A, person B 
		         where A.person_id = B.id and A.operation_type_id=2 GROUP by A.person_id order by created_at desc"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAgentes(){
		$sql = "select B.name, A.* from sell A, person B where A.person_id = B.id and A.operation_type_id=2 and B.cargo in (7,8) GROUP by A.person_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getSellsUnBoxed(){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getByBoxId($id){
		$sql = "select * from ".self::$tablename." where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getRes(){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateOp($start,$end,$op){
  	$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}
	public static function getAllByDateBCOp($clientid,$start,$end,$op){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and client_id=$clientid  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}
}
