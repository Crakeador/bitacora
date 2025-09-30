<?php
//Control del Modelos de Residentes
class ResidenteData {
	public static $tablename = "residente";

	public function __construct(){
		$this->id = 0;
		$this->idclient = "";
		$this->tipo = "";
		$this->cedula = "";
		$this->nombre = "";
		$this->manzana = "";
		$this->villa = "";
		$this->email = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->fecha = "";
		$this->observacion = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idclient, tipo, cedula, nombre, manzana, villa, email, telefono1, telefono2, fecha, observacion, is_active, created_at) ";
		$sql .= "VALUES (\"$this->idclient\", \"$this->tipo\", \"$this->cedula\", \"$this->nombre\", \"$this->manzana\", \"$this->villa\", \"$this->email\", \"$this->telefono1\", \"$this->telefono2\", \"$this->fecha\", \"$this->observacion\", 1, $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$this->id"; 
		$valor = Executor::doit($sql);
		return $valor;
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET  tipo_empresa=\"$this->tipo_empresa\", nombre=\"$this->nombre\", contacto=\"$this->contacto\", cargo=\"$this->cargo\", email=\"$this->email\", telefono1=\"$this->telefono1\", telefono2=\"$this->telefono2\", factura=\"$this->factura\", telefonofac1=\"$this->telefonofac1\", telefonofac2=\"$this->telefonofac2\", fechafac=\"$this->fechafac\", fechaini=\"$this->fechaini\", fechafin=\"$this->fechafin\", ini_fac=\"$this->ini_fac\", fin_fac=\"$this->fin_fac\", direccion=\"$this->direccion\", observacion=\"$this->observacion\", is_active=\"$this->is_active\" WHERE idclient=$this->id";
		Executor::doit($sql);
	}

	public static function getByCedula($id){
		$sql = "select * from ".self::$tablename." where cedula=\"$id\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ResidenteData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idclient=$id";
		$query = Executor::doit($sql);
		
		return Model::one($query[0],new ResidenteData());
	}

	public static function getTotal(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE is_active = 1";
		$query = Executor::doit($sql);

		return Model::many($query[0],new ResidenteData());
	}

	public static function getAll($client, $activo = 1){
		if($client != null){
			$valor = "AND A.idclient = $client ";
		}else{
			$valor = "AND A.idclient != 0 ";
		}
		$sql = "SELECT B.nombre AS cliente, A.* FROM ".self::$tablename." A, client B WHERE A.idclient = B.idclient ".$valor." AND A.is_active = $activo"; 
		$query = Executor::doit($sql); 

		return Model::many($query[0],new ResidenteData());
	}

	public static function getLike($q){
		$sql = "select B.nombre AS residente, A.*, B.id AS idresidente from autorizacion A, residente B where A.idresidente = B.id AND A.clave like '%$q%'";
		$query = Executor::doit($sql); 

		return Model::one($query[0],new ResidenteData());
	}
}
