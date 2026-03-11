<?php
// Modelo de la tabla de categorias
class CotizacionData {
	public static $tablename = "cotizacion";

	public function __construct(){
		$this->id = "";	
		$this->idcotizacion = "";
		$this->idoperation_type = "";
		$this->tipo_empresa = "";
		$this->contacto = "";
		$this->cargo = "";
		$this->pago = "";
		$this->detalle = "";
		$this->asunto = "";
		$this->email = "";
		$this->telefono = "";
		$this->ruc = "";
		$this->ini_fec = "";
		$this->status = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function addDatos(){
		$sql = "insert into salidas (idcotizacion, dato, tipo, usuario_log) value ($this->idcotizacion, $this->dato, $this->tipo, \"".$_SESSION['user_name']."\")"; 
		$array = Executor::doit($sql);		
		
		return $array;
	}

	public function addObserva(){
		$sql = "insert into observaciones (idcotizacion, idoperation_type, created_at) ";
		$sql .= "value ($this->idcotizacion, $this->idoperation_type, $this->created_at)"; 
		$array = Executor::doit($sql);		
		
		return $array;
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, tipo, status, ruc, paquete, asunto, contacto, ini_fec, telefono, detalle, pago, usuario_log, created_at, ip) 
		              value (".$_SESSION['id_company'].", 1, \"Borrador\", \"$this->ruc\", \"$this->paquete\", \"$this->asunto\", \"$this->contacto\", \"$this->ini_fec\", 
		                     \"$this->telefono\", \"$this->detalle\", \"$this->pago\", \"".$_SESSION['user_name']."\", $this->created_at, \"".$_SESSION['ip']."\")"; 
		$array = Executor::doit($sql);	
		
		return $array;
	}
	
	public function addConducta(){
		$sql = "insert into ".self::$tablename." (idcompany, tipo, status, usuario_log, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", 2, \"Borrador\", \"".$_SESSION['user_name']."\", $this->created_at)"; 
		$array = Executor::doit($sql);		
		
		return $array;
	}
	
	public function delSalida(){
		$sql = "update salidas set is_active = 0 where id=$this->id"; 
		Executor::doit($sql);
	}
	
	public function delDetalle(){
		$sql = "update cotizaciond set is_active = 0 where id=$this->id"; 
		Executor::doit($sql);
	}
	
	public function del(){
		$sql = "update observaciones set is_active = 0 where id=$this->id"; 
		Executor::doit($sql);
	}
	
	public static function updateOficio($oficio, $id){
		$sql = "update ".self::$tablename." set oficio=\"$oficio\" where id=$id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set paquete=\"$this->paquete\", tipo_empresa=\"$this->tipo_empresa\", contacto=\"$this->contacto\", email=\"$this->email\", 
						cargo=\"$this->cargo\", asunto=\"$this->asunto\", ini_fec=\"$this->ini_fec\", fin_fec=\"$this->fin_fec\", pago=\"$this->pago\", detalle=\"$this->detalle\", 
						telefono=\"$this->telefono\", ruc=\"$this->ruc\", municion=\"$this->municion\", observacion=\"$this->observacion\", 
						usuario_log=\"".$_SESSION['user_name']."\"
				where id=$this->id"; echo $sql;
		Executor::doit($sql);
	}
	
	public static function getPerson($id){
		$sql = "SELECT C.*, B.* FROM salidas A, person B, cargo C WHERE B.id = A.dato AND C.id = B.cargo AND A.idcotizacion = $id AND A.tipo = 2 AND A.is_active = 1"; 
		
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getDatos($id){
		$sql = "SELECT A.* FROM salidas A WHERE A.idcotizacion = $id AND A.tipo = 2 AND A.is_active = 1"; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getArmas($id, $tipo = 1){
		$sql = "SELECT A.id AS valor, B.serial, B.*, C.* FROM salidas A, operation B, product C WHERE B.id = A.dato AND C.id = B.product_id AND A.idcotizacion = $id AND A.tipo = $tipo AND A.is_active = 1"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}

	public static function getCodigo(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." ORDER BY id DESC LIMIT 1"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}

	public static function getAll($tipo, $user=NULL){
	    if($user == 1)
	        $cadena = "AND usuario_log='".$_SESSION["user_name"]."'";
	    else
	        $cadena = "";
	    
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." AND tipo=$tipo ".$cadena; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getDetalle($id){
		$sql = "SELECT A.*, B.descripcion AS lugar FROM cotizaciond A, localidad B WHERE A.idlugar = B.id AND A.idcotizacion = $id AND A.is_active = 1";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getObserva($id){
		$sql = "SELECT A.id, B.name FROM observaciones A, operation_type B WHERE B.id = A.idoperation_type AND A.idcotizacion = $id AND A.is_active = 1";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id like '%$q%'";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}
}

