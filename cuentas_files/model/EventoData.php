<?php
class EventoData {
	public static $tablename = "evenement";

	public function __construct(){
		$this->title = "";
		$this->start = "NOW()";
		$this->end = "NOW()";
		$this->url = "";
		$this->allday = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, title, start, end, url, allday, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->tile\", \"$this->start\", \"$this->end\", \"$this->url\", \"$this->allday\", $this->created_at)";
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

// partiendo de que ya tenemos creado un objecto CategoryData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\", description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new CategoryData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->name = $r['name'];
			$data->description = $r['description'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EventoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->start = $r['start'];
			$array[$cnt]->end = $r['end'];
			$array[$cnt]->allday = $r['allday'];
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
