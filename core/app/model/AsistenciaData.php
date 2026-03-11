<?php
// Clases de la tabla Bitacora
date_default_timezone_set('America/Guayaquil');

class AsistenciaData {
	public static $tablename = "asistencia";

	public function __construct(){
		$this->id = 0;
		$this->idcompany = 0;
		$this->idperson = 0;
		$this->observacion = "";
		$this->foto = "";
		$this->fecha = "";
		$this->status = "";
		$this->timestamp = "";
		$this->latitude = "";
		$this->longitude = "";
		$this->rangoerror = "";
		$this->sentido = "";
		$this->velocidad = "";
		$this->mensaje = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
		$this->usuario_log = "";
		$this->ip = "";
	}
	
	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idcompany, idperson, foto, fecha, status, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idcompany, $this->idperson, \"$this->foto\", \"$this->fecha\", \"$this->status\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")";
		
        $res = Executor::doit($sql);
		return $res;
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

	public function updInf($id, $is_active, $informe) {
		$sql = "UPDATE ".self::$tablename." SET contol=\"".$is_active."\", informe=\"".$informe."\" WHERE id=$id"; 
		Executor::doit($sql);
	}
	
	public function update(){
		$sql = "UPDATE ".self::$tablename." SET estado=\"1\", observaciono=\"$this->observaciono\", observacion=\"$this->observacion\" WHERE id=$this->id";
		Executor::doit($sql);
	}
	
	public function updateCustodia($id, $estado, $dato){
		$sql = "UPDATE servicio SET datos='".$dato."', status=$estado WHERE id=$id";
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
		$sql = "SELECT B.name, C.name AS persona, A.* FROM asistencia A, company B, person C 
		         WHERE A.idcompany = B.id AND A.idperson = C.id ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new AsistenciaData());
	}
}