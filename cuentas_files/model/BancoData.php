<?php
class BancoData {
	public static $tablename = "bancos";

	public function __construct(){
		$this->id = "";
		$this->desciption = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into departamento (idcompany, name, description, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->name\", \"$this->description\", $this->created_at)";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\", description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where iddepartamento=$id";
		$query = Executor::doit($sql);
		$found = null;
		
		$data = new CargoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['nombre'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getDepart(){
		$sql = "select * from departamento where idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new CargoData());
	}

	public static function getAllData(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CargoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['description'];
			$array[$cnt]->active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoryData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
}
?>
