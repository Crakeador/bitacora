<?php
//Modelo de los clientes en el sistema comercial
class ComercialData {
	public static $tablename = "comercial";

	public function __construct(){
		$this->id = "";
		$this->tipo = "";
		$this->ruc = "";
		$this->empresa = "";
		$this->nombre = "";
		$this->contacto = "";
		$this->cargo = "";
		$this->email = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->telefonofac1 = "";
		$this->telefonofac2 = "";
		$this->fechafac = "";
		$this->fechaini = "";
		$this->fechafin = "";
		$this->ini_fac = "";
		$this->fin_fac = "";
		$this->direccion = "";
		$this->observacion = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idcompany, iduser, tipo, ruc, empresa, nombre, contacto, email, telefono1, telefono2, telefonofac1, telefonofac2, observacion, is_active, created_at) 
		             VALUES (".$_SESSION['id_company'].", ".$_SESSION['user_id'].",	 \"$this->tipo\", \"$this->ruc\", \"$this->empresa\", \"$this->nombre\", \"$this->contacto\", \"$this->email\", \"$this->telefono1\", \"$this->telefono2\", \"$this->telefonofac1\", \"$this->telefonofac2\", \"$this->observacion\", 1, $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		$valor = Executor::doit($sql);
		return $valor;
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		$valor = Executor::doit($sql);
		return $valor;
	}

	public function estado(){
		$sql = "UPDATE ".self::$tablename." SET observacion=\"$this->observacion\", gestion=\"$this->gestion\", monto=$this->monto, producto=\"$this->producto\", is_active=\"$this->is_active\" WHERE id=$this->id"; 
		$valor = Executor::doit($sql); 
		return $valor;
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET iduser=".$_SESSION['user_id'].", tipo=\"$this->tipo\", nombre=\"$this->nombre\", contacto=\"$this->contacto\", cargo=\"$this->cargo\", email=\"$this->email\", telefono1=\"$this->telefono1\", telefono2=\"$this->telefono2\", telefonofac1=\"$this->telefonofac1\", telefonofac2=\"$this->telefonofac2\", direccion=\"$this->direccion\", observacion=\"$this->observacion\", is_active=\"$this->is_active\" WHERE id=$this->id";
		$valor = Executor::doit($sql); 
		return $valor;
	}

	public static function getByName($name){
		$sql = "SELECT * FROM ".self::$tablename." WHERE nombre LIKE '%$name%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}

	public static function getByVentas(){
		$sql = "SELECT * FROM ventas";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}

	public static function getTodos($iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'WHERE iduser = '.$iduser;
		$sql = "SELECT * FROM ".self::$tablename." ".$cadena;
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}
		
	public static function getPhone($iduser, $activo = 1){
		$sql = "SELECT * FROM ".self::$tablename." WHERE iduser = $iduser AND is_active = $activo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getAll($activo=1, $q = ""){
		$sql = "SELECT * FROM ".self::$tablename." WHERE gestion LIKE '%$q%' AND is_active = $activo"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getLike($q, $iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';

		$sql = "SELECT * FROM ".self::$tablename." WHERE ".$cadena." gestion LIKE '%$q%'"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getTotal($q, $iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';

		$sql = "SELECT count(*) total FROM ".self::$tablename." WHERE ".$cadena." gestion LIKE '%$q%'"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}

	public static function getValores($q, $iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';
		$sql = "SELECT sum(monto) total FROM ".self::$tablename." WHERE ".$cadena." producto LIKE '%$q%'"; 	
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}

	public static function getSuma($q, $iduser=NULL, $anio=2026, $mes=0){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';
		$sql = "SELECT
					YEAR(update_at) AS anio,
					MONTH(update_at) AS mes,
					DATE_FORMAT(update_at, '%M') AS nombre_mes,
					monto
				FROM ".self::$tablename."
				WHERE ".$cadena." producto LIKE '%$q%'
  					AND YEAR(update_at) = $anio
  					AND MONTH(update_at) = $mes"; 	
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getNulo($iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';

		$sql = "SELECT * FROM ".self::$tablename." WHERE ".$cadena." gestion IS NULL || gestion = ''"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getNull($iduser=NULL){
		if($iduser == NULL) $cadena = ''; else $cadena = 'iduser = '.$iduser.' AND ';

		$sql = "SELECT count(*) total FROM ".self::$tablename." WHERE ".$cadena." gestion IS NULL"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}
		
	public static function getDetalle($id){
		$sql = "SELECT * FROM clientd WHERE id = $id AND is_active = 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}
	
	public static function getCotizacion($id=0){
		if($id == 0) $cadena = ''; else $cadena = 'iduser = '.$id.' AND ';
		$sql = "SELECT * FROM comercial WHERE ".$cadena." monto > 0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ComercialData());
	}

	public static function getTotalCotizacion($id=0){
		if($id == 0) $cadena = ''; else $cadena = 'iduser = '.$id.' AND ';
		$sql = "SELECT SUM(monto) as total FROM comercial WHERE ".$cadena." monto > 0"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new ComercialData());
	}
}