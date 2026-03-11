<?php
class RolesData {
	public static $tablename = "rol";

	public function __construct(){
		$this->nombre = "";
		$this->alias = "";
		$this->description = "";
		$this->activo = "1";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into departamento (idcompany, description, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->description\", $this->created_at)";
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
		$sql = "update ".self::$tablename." set description=\"$this->description\", update_at=\"$this->created_at\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new DepartamentoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->description = $r['description'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getRol(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active = 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new RolesData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new RolesData();
			$array[$cnt]->id = $r['idrol'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->alias = $r['alias'];
			$array[$cnt]->description = $r['descripcion'];
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
