<?php
//Modelo de Pantallas

class OperationTypeData {
	public static $tablename = "operation_type";

	public function __construct(){
		$this->name = "";
		$this->description = "";
		$this->codigo = "";
		$this->created_at = "NOW()";
	}

	public function addObserva($padre, $modulo){
		$sql = "INSERT INTO operation_type (idactividad, padre, name, modulo, created_at) ";
		$sql .= "VALUES (".$_SESSION['actividad'].", $padre, \"$this->name\", \"$modulo\", $this->created_at)"; 
		Executor::doit($sql);
	}
	
	public function add(){
		$sql = "insert into ".self::$tablename." (name) value (\"$this->name\")";
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

	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m LIKE '%$n%'";
		$query = Executor::doit($sql);

		return Model::one($query[0],new OperationTypeData());
	}
	
	public static function getByType($type){
		$sql = "SELECT * FROM ".self::$tablename." where modulo like '$type'";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new OperationTypeData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new OperationTypeData());
	}

	public static function getByName($name){
		$sql = "SELECT * FROM ".self::$tablename." where name=\"$name\"";
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

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new OperationTypeData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$cnt++;
		}
		return $array;
	}
	
	public static function getAllType($modulo, $id=999){
	    if($id == 999)
	        $padre = " AND padre > 0";
	    else
	        $padre = " AND padre = ".$id;
	    
		$sql = "SELECT * FROM ".self::$tablename." WHERE idactividad = ".$_SESSION['actividad'].$padre." AND modulo = '$modulo'"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationTypeData());
	}
}
