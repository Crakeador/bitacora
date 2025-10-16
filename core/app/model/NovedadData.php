<?php
// Clases de la tabla Bitacora
date_default_timezone_set('America/Guayaquil');

class NovedadData {
	public static $tablename = "novedades";

	public function __construct(){
		$this->id = 0;
		$this->idpuesto = 0;
		$this->idperson = 0;
		$this->turno = 1;
		$this->observacion = "";
		$this->accion = "";
		$this->foto1 = "";
		$this->foto2 = "";
		$this->foto3 = "";
		$this->foto4 = "";
		$this->foto5 = "";
		$this->foto6 = "";
		$this->vistas = 0;
		$this->is_active = "";
		$this->created_at = "NOW()";
		$this->usuario_log = "";
		$this->ip = "";
	}
	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, observacion, accion, foto1, foto2, foto3, foto4, foto5, foto6, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idpuesto, $this->idperson, \"$this->observacion\", \"$this->accion\", \"$this->foto1\", \"$this->foto2\", \"$this->foto3\", \"$this->foto4\", \"$this->foto5\", \"$this->foto6\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")"; 
        
        $res = Executor::doit($sql);
		return $res;
	}

	public function addVista(){
		$sql = "INSERT INTO auditoria (idbitacora, tipo, fecha, usuario_log, created_at, ip) 
		                        value ($this->idbitacora, \"$this->tipo\", \"$this->fecha\", \"".$_SESSION['usuario']."\", $this->created_at, \"".$_SESSION['ip']."\")"; 
		return Executor::doit($sql);
	}

	public static function updateVista($id, $vista){
		$sql = "UPDATE ".self::$tablename." SET vistas = $vista WHERE id=$id";
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
	
	public function update(){
		$sql = "UPDATE ".self::$tablename." SET estado=\"1\", observaciono=\"$this->observaciono\", observacion=\"$this->observacion\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getVistas($id){
		$sql = "SELECT * FROM auditoria WHERE idbitacora=$id ORDER BY fecha DESC"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BitacoraData());
	}
	
	public static function getByBusqueda($id, $cadena){
		$sql = "SELECT B.name, C.descripcion, C.codigo, C.idclient, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.idpuesto = $id ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BitacoraData());
	}

	public static function getAll($cadena){
		$sql = "SELECT C.descripcion, C.codigo, A.* FROM ".self::$tablename." A, puestos C 
		         WHERE A.idpuesto = C.id ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new NovedadData());
	}
}
