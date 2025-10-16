<?php
// Modelo de la tabla de categorias
class InformeData {
	public static $tablename = "informe";

	public function __construct(){
		$this->id = "";	
		$this->idinforme = "";
		$this->idoperation_type = "";
		$this->tipo_empresa = "";
		$this->contacto = "";
		$this->cargo = "";
		$this->asunto = "";
		$this->email = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->ini_fec = "";
		$this->status = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
	}

	public function addObserva(){
		$sql = "insert into observaciones (idcotizacion, idoperation_type, created_at) ";
		$sql .= "value ($this->idcotizacion, $this->idoperation_type, $this->created_at)"; 
		$array = Executor::doit($sql);		
		
		return $array;
	}
	
	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, status, usuario_log, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"Borrador\", \"".$_SESSION['user_name']."\", $this->created_at)"; 
		$array = Executor::doit($sql);		
		
		return $array;
	}
	
	public function del(){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		Executor::doit($sql);
	}
	
	public static function updateOficio($oficio, $id){
		$sql = "update ".self::$tablename." set oficio=\"$oficio\" where id=$id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set tipo_empresa=\"$this->tipo_empresa\", contacto=\"$this->contacto\",
							cargo=\"$this->cargo\", asunto=\"$this->asunto\", email=\"$this->email\", ini_fec=\"$this->ini_fec\",
							 telefono1=\"$this->telefono1\", telefono2=\"$this->telefono2\", usuario_log=\"".$_SESSION['user_name']."\"
				where id=$this->id"; 
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}

	public static function getTipo($tipo){
		$sql = "select * from ".self::$tablename." where tipo in ($tipo) idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoryData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}

		return $array;
	}

	public static function getCodigo(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." ORDER BY id DESC LIMIT 1"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getDetalle($id){
		$sql = "SELECT * FROM cotizaciond WHERE idcotizacion = $id";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getObserva($id){
		$sql = "SELECT B.name FROM observaciones A, operation_type B WHERE B.id = A.idoperation_type AND A.idcotizacion = $id";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new CotizacionData());
	}
	
	public static function getLike($q){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id like '%$q%'";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}
}

