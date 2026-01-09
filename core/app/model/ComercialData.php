<?php
//Modelo de los clientes en el sistema comercial
class ComercialData {
	public static $tablename = "comercial";

	public function __construct(){
		$this->id = "";
		$this->tipo_empresa = "";
		$this->ruc = "";
		$this->nombre = "";
		$this->contacto = "";
		$this->cargo = "";
		$this->email = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->factura = "";
		$this->telefonofac1 = "";
		$this->telefonofac2 = "";
		$this->fechafac = "";
		$this->fechaini = "";
		$this->fechafin = "";
		$this->ini_fac = "";
		$this->fin_fac = "";
		$this->direccion = "";
		$this->observacion = "";
		$this->monto = 0;
		$this->etapas = "";
		$this->hadicional = "";
		$this->hnocturna = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO client (idcompany, tipo_empresa, ruc, nombre, contacto, cargo, email, telefono1, telefono2, factura, telefonofac1, telefonofac2, fechafac, fechaini, fechafin, ini_fac, fin_fac, direccion, observacion, monto, etapas, hadicional, hnocturna, is_active, created_at) ";
		$sql .= "VALUES (".$_SESSION['id_company'].", \"$this->tipo_empresa\", \"$this->ruc\", \"$this->nombre\", \"$this->contacto\", \"$this->cargo\", \"$this->email\", \"$this->telefono1\", \"$this->telefono2\", \"$this->factura\", \"$this->telefonofac1\", \"$this->telefonofac2\", \"$this->fechafac\", \"$this->fechaini\", \"$this->fechafin\", \"$this->ini_fac\", \"$this->fin_fac\", \"$this->direccion\", \"$this->observacion\", $this->monto, \"$this->etapas\", \"$this->hadicional\", \"$this->hnocturna\", 1, $this->created_at)";

		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		$valor = Executor::doit($sql);
		return $valor;
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->idclient";
		$valor = Executor::doit($sql);
		return $valor;
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET  tipo_empresa=\"$this->tipo_empresa\", nombre=\"$this->nombre\", contacto=\"$this->contacto\", cargo=\"$this->cargo\", email=\"$this->email\", telefono1=\"$this->telefono1\", telefono2=\"$this->telefono2\", factura=\"$this->factura\", telefonofac1=\"$this->telefonofac1\", telefonofac2=\"$this->telefonofac2\", fechafac=\"$this->fechafac\", fechaini=\"$this->fechaini\", fechafin=\"$this->fechafin\", ini_fac=\"$this->ini_fac\", fin_fac=\"$this->fin_fac\", direccion=\"$this->direccion\", observacion=\"$this->observacion\", monto=\"$this->monto\", etapas=\"$this->etapas\", hadicional=\"$this->hadicional\", hnocturna=\"$this->hnocturna\", is_active=\"$this->is_active\" WHERE id=$this->id";
		$valor = Executor::doit($sql); 
		return $valor;
	}

	public static function getByRuc($id){
		$sql = "select * from ".self::$tablename." where ruc=\"$id\"";
		$query = Executor::doit($sql);

		return Model::one($query[0],new ComercialData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idclient=$id";
		$query = Executor::doit($sql);

		return Model::one($query[0],new ComercialData());
	}

	public static function getTodos(){
		$sql = "SELECT * FROM ".self::$tablename;
		$query = Executor::doit($sql);

		return Model::many($query[0],new ComercialData());
	}
		
	public static function getPhone($iduser, $activo = 1){
		$sql = "SELECT * FROM ".self::$tablename." WHERE iduser = $iduser AND is_active = $activo"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new ComercialData());
	}

	public static function getAll($iduser, $activo = 1, $q = ""){
		$sql = "SELECT * FROM ".self::$tablename." WHERE gestion LIKE '%$q%' AND iduser = $iduser AND is_active = $activo";
		$query = Executor::doit($sql);

		return Model::many($query[0],new ComercialData());
	}

	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE gestion LIKE '%$q%'";
		$query = Executor::doit($sql);

		return Model::many($query[0],new ComercialData());
	}	

	public static function getTotal($q){
		$sql = "SELECT count(*) total FROM ".self::$tablename." WHERE gestion LIKE '%$q%'";
		$query = Executor::doit($sql);

		return Model::one($query[0],new ComercialData());
	}	

	public static function getNulo(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE gestion IS NULL";
		$query = Executor::doit($sql);

		return Model::one($query[0],new ComercialData());
	}

	public static function getNull(){
		$sql = "SELECT count(*) total FROM ".self::$tablename." WHERE gestion IS NULL";
		$query = Executor::doit($sql);

		return Model::one($query[0],new ComercialData());
	}
}


