<?php
// Manejo de la Nomina 
class NominaData {
	public static $tablename = "nomina";

	public function __construct(){
		$this->id = "";
		$this->person = "";
		$this->mes = "";
		$this->ano = "";
		$this->rubro = "";
		$this->monto = "";
		$this->tipo = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (person, mes, ano, rubro, monto, created_at) ";
		$sql .= "VALUE ($this->person, $this->mes, $this->ano, $this->rubro, $this->monto, $this->created_at)";
		return Executor::doit($sql);
	}

	public function addPago($idperson, $mes, $ano, $idgasto, $tipo, $monto){
		$sql = "INSERT INTO pagos(idperson, dia, mes, ano, idgasto, tipo, monto, created_at) ";
		$sql .= "VALUE (".$idperson.", 30, ".$mes.", ".$ano.", ".$idgasto.", '".$tipo."', ".$monto.", NOW())";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		return Executor::doit($sql);
	}

	public function updateById(){
		$sql = "update ".self::$tablename." set monto=$this->monto where id=$this->id";
		return Executor::doit($sql);
	}

	public static function getAll($client, $id, $ano, $mes){
		$sql = "SELECT C.id, B.tipo_cuenta, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto 
		          from nomina A, rubro B, person C, cargo D 
				 WHERE A.person = $id and A.mes = $mes and A.ano = $ano and A.rubro = B.id and A.person = C.id and C.cargo = D.id AND A.client = $client";
		$query = Executor::doit($sql); 
		
		return Model::many($query[0],new NominaData());
	}
	
	public static function getAllMonto($ano, $mes, $tipo){
		$sql = "SELECT A.*, B.tipo_cuenta from nomina A, rubro B, person C, cargo D WHERE A.mes = $mes and A.ano = $ano and A.rubro = B.id and A.person = C.id and C.cargo = D.id and D.idtipo = $tipo and A.company = ".$_SESSION['id_company'];  
		$query = Executor::doit($sql);

		return Model::many($query[0],new NominaData());
	}

	public static function getAllGuardias($ano, $mes, $tipo, $client){
		$sql = "SELECT A.mes, A.ano, F.idclient, F.descripcion puesto, E.idservicio, C.id, C.idcard, C.name, C.startwork, D.description, A.monto, C.tipo, C.cuenta
				  FROM nomina A, person C, cargo D, personpuestos E, puestos F
				 WHERE A.person = C.id AND C.id = E.idperson AND C.cargo = D.id AND E.idservicio = F.id AND E.is_active = 1 AND
					  A.mes = $mes and A.ano = $ano and D.idtipo = $tipo and C.idcompany = ".$_SESSION['id_company']." AND A.client = $client
			  GROUP BY C.id 
			  ORDER BY C.name";
		$query = Executor::doit($sql); 
		
		return Model::many($query[0],new NominaData());
	}
		
	public static function getHistorico($ano, $mes, $client){
		$sql = "SELECT A.mes, A.ano, F.idclient, F.idclient idservicio, F.descripcion puesto, A.client, C.id, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto 
				  FROM nomina A, person C, cargo D, puestos F 
				 WHERE A.person = C.id AND C.cargo = D.id AND A.client = F.id AND 
					   A.mes = '$mes' AND A.ano = '$ano' AND C.idcompany = ".$_SESSION['id_company']." AND A.client = $client
			  GROUP BY C.id 
			  ORDER BY C.name"; 
		$query = Executor::doit($sql); 
		
		return Model::many($query[0],new NominaData());
	}
	
	public static function getAllTotal($ano, $mes, $tipo, $client){
		$sql = "SELECT A.mes, A.ano, F.idclient, F.idclient idservicio, F.descripcion puesto, A.client, C.id, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto 
				  FROM nomina A, person C, cargo D, puestos F 
				 WHERE A.person = C.id AND C.cargo = D.id AND A.client = F.id AND C.is_active = 1 AND
					  A.mes = '$mes' and A.ano = '$ano' and D.idtipo IN (1, 2) and C.idcompany = ".$_SESSION['id_company']." AND A.client = $client
			  GROUP BY C.id 
			  ORDER BY C.name"; //echo $sql;
		$query = Executor::doit($sql); 
		
		return Model::many($query[0],new NominaData());
	}

	public static function getById($ano, $mes, $id, $cliente){
		$sql = "select A.id, C.id person, B.tipo_cuenta, B.descripcion, C.idcard, C.name, C.fechanacimiento, C.startwork, D.description, A.monto, A.formula ";
		$sql .=  "from nomina A, rubro B, person C, cargo D ";
		$sql .= "where A.client = $cliente AND A.person = $id and A.mes = $mes and A.ano = $ano and A.rubro = B.id and A.person = C.id and C.cargo = D.id ";
		$sql .= "ORDER BY orden_rubro";
		$query = Executor::doit($sql);
		return Model::many($query[0],new NominaData());
	}

	public static function getByIdRubro($id, $rubro){ // Busqueda de todos los rubros de un guardia
		$sql = "SELECT B.estado, A.* FROM nomina A, control B WHERE A.person=$id AND A.rubro=$rubro AND A.client=B.idclient AND A.mes=B.mes AND A.ano=B.ano ORDER BY ano, mes";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new NominaData());
	}

	public static function getByIdCambio($id){ // Busqueda de un rubro en especifico
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new NominaData());
	}
	
	public static function getAllByDateOfficial($start,$end){ 
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" order by created_at desc";

		if($start == $end){
			$sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}

		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByDateOfficialBP($product, $start,$end){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and product_id=$product order by created_at desc";

		if($start == $end){
			$sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}

		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}
}

