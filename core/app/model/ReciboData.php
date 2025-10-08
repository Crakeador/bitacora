<?php
class ReciboData {
	public static $tablename = "recibo";

	public function __construct(){
		$this->id = "";
		$this->idperson = "";
		$this->iddescuento = "";
		$this->cuota = 0;
		$this->monto = 0;
		$this->entregado = "";
		$this->observacion = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO recibo (idperson, iddescuento, cuota, monto, entregado, observacion, is_active, usuario_log, created_at) "; 
		$sql .= "VALUES (\"$this->idperson\", \"$this->iddescuento\", \"$this->cuota\", \"$this->monto\", \"$this->entregado\", \"$this->observacion\", 1, \"".$_SESSION['user_name']."\", $this->created_at)"; 
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
		$sql = "update ".self::$tablename." set idperson=\"$this->idperson\", iddescuento=\"$this->iddescuento\", cuota=\"$this->cuota\", 
		monto=\"$this->monto\", entregado=\"$this->entregado\", usuario_log=\"".$_SESSION['user_name']."\" WHERE id=$this->id"; 
		Executor::doit($sql);
	}

	public static function getAllPago($id){
		$sql = "SELECT COUNT(*) pagos FROM recibod WHERE idrecibo = $id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new DetalleData());
	}

	public static function getByPersona($id, $tipo, $mes, $ano){
		$sql = "SELECT A.cuota, B.cuota pago, B.fecha
				  FROM recibo A, recibod B, descuento C
				 WHERE A.id = B.idrecibo
				   AND A.iddescuento = C.id
				   AND A.idperson = $id
				   AND C.tipo = $tipo
				   AND MONTH(B.fecha) = $mes
				   AND YEAR(B.fecha) = $ano";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}

	public static function getById($id){
		$sql = "SELECT B.idcard, B.name, C.descripcion, A.* 
				  FROM recibo A, person B, adicional C
 				 WHERE A.idperson = B.id AND A.iddescuento = C.id AND A.id = $id AND A.is_active = 1";		
		$query = Executor::doit($sql);
		return Model::many($query[0],new ReciboData());
	}

	public static function getAll($mes, $ano){
		if($mes == '00'){
			$cadena = "";
		}else{
			$cadena = "AND A.entregado BETWEEN '".$ano."-".$mes."-01' AND '".$ano."-".$mes."-31'";
		}

		$sql = "SELECT B.idcard, B.name, C.descripcion, A.* 
				  FROM recibo A, person B, adicional C
 				 WHERE A.idperson = B.id AND A.iddescuento = C.id AND A.is_active = 1 ".$cadena;
		
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ReciboData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->nombre = $r['name'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->idperson = $r['idperson'];
			$array[$cnt]->cuota = $r['cuota'];
			$array[$cnt]->monto = $r['monto'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getNomina(){
		$sql = "SELECT * FROM person WHERE company = ".$_SESSION['id_company']." AND is_active = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->idcargo = $r['cargo'];
			$array[$cnt]->sueldo = $r['sueldo'];
			$array[$cnt]->vehiculo = $r['vehiculo'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->endwork = $r['endwork'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}	

	public static function getClients(){
		$sql = "select A.*, B.* from person A, cargo B where A.company = ".$_SESSION['id_company']." and A.cargo = B.id order by name";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->idcargo = $r['cargo'];
			$array[$cnt]->cargo = $r['nombre'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['address'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->endwork = $r['endwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getSupervisor(){
		$sql = "select * from person A, cargo B where A.cargo in(4, 5) and A.is_active=1 and A.cargo = B.idcargo";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->cargo = $r['nombre'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['address'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getAgentes(){
		$sql = "select * from person A, cargo B where A.cargo in(7) and A.is_active=1 and A.cargo = B.idcargo";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->cargo = $r['nombre'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['address'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
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
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->mail = $r['mail'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
}
