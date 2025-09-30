<?php

class TimelineData {
	public static $tablename = "timeline";

	public function __construct(){
		$this->id = "";
		$this->idcompany = "";
		$this->idperson = "";
		$this->idejecuta = "";
		$this->quien_asigna = "";
		$this->prioridad = "";
		$this->status = 0;
		$this->type = "";
		$this->title = "";
		$this->body = "";
		$this->date_event = "";
		$this->date_pass = "";
		$this->porentaje = "";
		$this->update_at = "NOW()";
		$this->created_at = "NOW()";
	}

	public function add_task(){
		$sql = "insert into timeline (idcompany, idperson, quien_asigna, prioridad, status, asunto, title, type, date_event, date_pass, porcentaje, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->idperson\", \"$this->quien_asigna\", \"$this->prioridad\", 1, \"$this->asunto\", \"$this->title\", \"$this->type\", \"$this->date_event\", \"$this->date_pass\", \"$this->porcentaje\", $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update($id){
		$sql = "UPDATE ".self::$tablename." SET body=\"$this->body\", date_pass=NOW(), idejecuta=\"$this->idejecuta\", status=$this->status, update_at=$this->update_at WHERE id=$id";
        echo $sql;
		Executor::doit($sql);
	}
	
	public static function updateVista($id, $vista){
		$sql = "UPDATE ".self::$tablename." SET vistas = $vista WHERE id=$id";
		Executor::doit($sql);
	}
	
	public static function updateValor($id, $vista){
		$sql = "UPDATE ".self::$tablename." SET date_autoriza = NOW(), status = 3, vistas = '".$vista."' WHERE id=".$id;
		Executor::doit($sql);
	}
	
	public static function updatePerimso($id, $status, $body){
		$sql = "UPDATE ".self::$tablename." SET prioridad = $status, status = $status, body = '".$body."' WHERE id=".$id;
		Executor::doit($sql);
	}

	public static function getAllByUserId($user_id, $mes, $ano, $tipo){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idperson=$user_id AND MONTH(date_event)='$mes' AND YEAR(date_event)='$ano' AND status=$tipo order by created_at desc"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new TimelineData());
	}
	
	public static function getEstados($id, $status){	    
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." AND type=$id AND status=$status"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new TimelineData());
	}

	public static function getStatus($id, $status){
	    if($status == 0) $cadena = ''; else $cadena = ' AND status='.$status;
	    
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." AND idperson=$id".$cadena;
		$query = Executor::doit($sql);

		return Model::many($query[0],new TimelineData());
	}

	public static function getTipe($id){	    
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." AND type=$id order by date_event DESC"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new TimelineData());
	}
	
	public static function getPermiso(){
		$sql = "select B.description, A.* from timeline A, operation_type B WHERE B.id = A.porcentaje AND A.idcompany = ".$_SESSION['id_company']." AND A.type=$id order by date_event DESC"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new TimelineData());
	}
	
	public static function getTime($id, $ano){	    
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." AND idperson=$id AND YEAR(date_event)='$ano' order by date_event DESC"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new TimelineData());
	}
		
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id"; 
		$query = Executor::doit($sql);

		return Model::one($query[0], new TimelineData());
	}

	public static function getAll($i){
	    if($i == 0) 
	        $cadena = '';
	    else
	        $cadena = 'LIMIT '.$i;
	    
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." order by date_event Desc ".$cadena;
		$query = Executor::doit($sql);
        
		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TimelineData();

			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcompany = $r['idcompany'];
			$array[$cnt]->idperson = $r['idperson'];
			$array[$cnt]->status = $r['status'];
			$array[$cnt]->quien_asigna = $r['quien_asigna'];
			$array[$cnt]->type = $r['type'];
			$array[$cnt]->title = $r['title'];
			$array[$cnt]->body = $r['body'];
			$array[$cnt]->date_event = $r['date_event'];
			$array[$cnt]->date_pass = $r['date_pass'];
			$array[$cnt]->prioridad = $r['prioridad'];
			$array[$cnt]->update_at = $r['update_at'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->porcentaje = $r['porcentaje'];
			$array[$cnt]->proroga = $r['proroga'];
			$array[$cnt]->vistas = $r['vistas'];

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

