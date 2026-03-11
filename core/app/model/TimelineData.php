<?php
//Modelo de las tareas asignadas a los comerciales
class TimelineData {
	public static $tablename = "timeline";

	public function __construct(){
		$this->id = "";
		$this->idcompany = "";
		$this->idclient = 0;
		$this->idperson = "";
		$this->idejecuta = "";
		$this->quien_asigna = "";
		$this->prioridad = 0;
		$this->resultado = 0;
		$this->seguimiento = 0;
		$this->status = 0;
		$this->type = "";
		$this->title = "";
		$this->body = "";
		$this->date_event = "";
		$this->date_pass = "";
		$this->porentaje = "";
		$this->monto = 0;
		$this->update_at = "NOW()";
		$this->created_at = "NOW()";
	}

	public function add_task(){
		$sql = "insert into timeline (idcompany, idperson, quien_asigna, prioridad, status, asunto, title, type, date_event, date_pass, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->idperson\", \"$this->quien_asigna\", \"$this->prioridad\", 1, \"$this->asunto\", \"$this->title\", \"$this->type\", \"$this->date_event\", \"$this->date_pass\", $this->created_at)"; 
		Executor::doit($sql);
	}
	
	public function add_info(){
		$sql = "insert into timeline (idcompany, idclient, idperson, quien_asigna, prioridad, resultado, seguimiento, status, asunto, title, body, date_event, date_pass, monto, type, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->idclient\", \"$this->idperson\", \"$this->quien_asigna\", \"$this->prioridad\", \"$this->resultado\", \"$this->seguimiento\", \"$this->status\", \"$this->asunto\", \"$this->title\", \"$this->body\", \"$this->date_event\", \"$this->date_pass\", $this->monto, 3, $this->created_at)"; 
		Executor::doit($sql);
	}

	public function add_acci(){
		$sql = "insert into archivo (idrespuesta, iduser, descripcion, tipo, created_at) ";
		$sql .= "value ($this->idrespuesta, \"$this->iduser\", \"$this->descripcion\", \"$this->tipo\", $this->created_at)"; 
		return Executor::doit($sql);
	}

	public function add_resp(){
		$sql = "insert into respuesta (idtimeline, iduser, descripcion, created_at) ";
		$sql .= "value ($this->idtimeline, \"$this->iduser\", \"$this->descripcion\", $this->created_at)"; echo $sql;
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$id";
		Executor::doit($sql);
	}

	public static function del(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update($id){
		$sql = "UPDATE ".self::$tablename." 
		         SET body=\"$this->body\", 
				     idejecuta=\"$this->idejecuta\", 
		             date_pass=NOW(), 
					 status=$this->status, 
		             update_at=NOW() 
		         WHERE id=$id"; echo $sql;
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

	public static function changeStatus($id, $status){
		$sql = "UPDATE ".self::$tablename." SET status=$status, update_at=NOW() WHERE id=$id";
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
	
	public static function getClient($id, $ano){
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." AND type=3 AND idclient=$id AND YEAR(date_event)='$ano' order by date_event DESC"; 
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

	public static function getAll($i = 0, $tipo = 'news'){
	    if($i == 0) 
	        $cadena = '';
	    else
	        $cadena = 'LIMIT '.$i;
	    
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." AND type = '$tipo' ORDER BY date_event DESC ".$cadena;
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
			$array[$cnt]->vistas = $r['vistas'];

			$cnt++;
		}

		return $array;
	}

	public static function getByTotalID($id=1, $status=1){
		$sql = "SELECT count(*) as total FROM ".self::$tablename." where type LIKE 'news' AND idperson = $id AND status=$status AND idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);

		return Model::one($query[0], new TimelineData());
	}

	public static function getByTotal($status=1){
		if($_SESSION['idrol'] == 1 || $_SESSION['idrol'] == 2)
			$sql = "SELECT count(*) as total FROM ".self::$tablename." where type LIKE 'news' AND status=$status AND idcompany = ".$_SESSION['id_company'];
		else
			$sql = "SELECT count(*) as total FROM ".self::$tablename." where type LIKE 'news' AND idperson = ".$_SESSION['user_id']." AND status=$status AND idcompany = ".$_SESSION['id_company'];

		$query = Executor::doit($sql);

		return Model::one($query[0], new TimelineData());
	}

	public static function getDetalle($id){
		$sql = "SELECT * FROM timelined WHERE idtimeline = $id";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new TimelineData());
	}

	public static function getByTipo($id, $tipo){
		$sql = "select count(*) as total from ".self::$tablename." where idclient=$id AND prioridad=$tipo";
		$query = Executor::doit($sql);

		return Model::one($query[0], new TimelineData());
	}

	public static function countNewsByFutureDate(){
		$sql = "SELECT COUNT(*) as total FROM ".self::$tablename." WHERE type='news' AND DATEDIFF(date_event, created_at) > 0";
		$query = Executor::doit($sql);
		$result = $query[0]->fetch_assoc();
		return $result['total'];
	}

	public static function getNewsByFutureDate(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE type='news' AND DATEDIFF(date_event, created_at) > 0 ORDER BY date_event DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new TimelineData());
	}

	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE name like '%$q%'";
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