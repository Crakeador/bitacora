<?php
// Clases de la tabla Bitacora
date_default_timezone_set('America/Guayaquil');

class TradeData {
	public static $tablename = "trade";

	public function __construct(){
		$this->id = 0;
		$this->idpuesto = 0;
		$this->idperson = 0;
		$this->fecha = "";
		$this->nacionalidad = 0;
		$this->cedula = "";
		$this->apellidos = "";
		$this->nombres = "";
		$this->empresa = 0;
		$this->oficina = "";
		$this->acompanante1 = "";
		$this->acompanante2 = "";
		$this->acompanante3 = "";
		$this->acompanante4 = "";
		$this->foto = "";
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
		$sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, fecha, nacionalidad, cedula, apellidos, nombres, empresa, oficina, acompanante1, acompanante2, acompanante3, acompanante4, foto, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) 
		            value ($this->idpuesto, $this->idperson, \"$this->fecha\", \"$this->nacionalidad\", \"$this->cedula\", \"$this->apellidos\", \"$this->nombres\", \"$this->empresa\", \"$this->oficina\", \"$this->acompanante1\", \"$this->acompanante2\", \"$this->acompanante3\", \"$this->acompanante4\", \"$this->foto\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")"; echo $sql;
        $res = Executor::doit($sql);
		return $res;
	}
	
	public static function update($id, $vista){
		$sql = "UPDATE ".self::$tablename." SET vistas = $vista WHERE id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "UPDATE ".self::$tablename." SET is_active = 0 WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BitacoraData());
	}
	
	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0],new BitacoraData());
	}
	
	public static function getAll($cadena){
		$sql = "SELECT * FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.proceso IN (1, 2, 3, 5, 7, 8) ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
}
