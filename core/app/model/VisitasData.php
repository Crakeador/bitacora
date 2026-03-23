<?php
// Clases de la tabla Bitacora
date_default_timezone_set('America/Guayaquil');

class VisitasData {
	public static $tablename = "visitas";

	public function __construct(){
		$this->id = 0;
		$this->idpuesto = 0;
		$this->idperson = 0;
		$this->familiar = "";
		$this->telefonof = "";
		$this->vecino = "";
		$this->telefonov = "";
		$this->observacion = "";
		$this->accion = "";
		$this->foto1 = "";
		$this->foto2 = "";
		$this->foto3 = "";
		$this->foto4 = "";
		$this->foto5 = "";
		$this->foto6 = "";
		$this->vistas = 0;
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
		$sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, fecha, familiar, telefonof, vecino, telefonov, observacion, accion, foto1, foto2, foto3, foto4, foto5, foto6, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idpuesto, $this->idperson, \"$this->fecha\", \"$this->familiar\", \"$this->telefonof\", \"$this->vecino\", \"$this->telefonov\", \"$this->observacion\", \"$this->accion\", \"$this->foto1\", \"$this->foto2\", \"$this->foto3\", \"$this->foto4\", \"$this->foto5\", \"$this->foto6\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")"; 
		$valor = Executor::doit($sql);
		return $valor;
	}

	public static function getVistas($id){
		$sql = "SELECT * FROM auditoria WHERE idbitacora=$id ORDER BY fecha DESC"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new VisitasData());
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

	public static function getByClients($id, $cadena){
		$sql = "SELECT B.nombre, C.descripcion, C.codigo, A.* FROM reportes A, residente B, puestos C 
		         WHERE A.idperson = B.id AND A.idclient = C.idclient AND A.idclient = $id AND A.proceso IN (1, 2, 3, 5) ".$cadena;
		$query = Executor::doit($sql); 
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getEtapa($cadena, $id){
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.idpuesto = $id AND A.proceso IN (1, 2, 3, 5) ".$cadena;
		$query = Executor::doit($sql); 
		return Model::many($query[0],new BitacoraData());
	}

	public static function getAll(){
		$sql = "SELECT B.name, B.phone1, B.phone2, B.phone3, C.descripcion, C.codigo, A.* FROM visitas A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new VisitasData());
	}
	
	public static function getParteCliente($id, $cadena = ''){
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		WHERE A.idperson = B.id AND A.idpuesto = C.id AND C.idclient = $id AND  A.proceso = 4 ".$cadena;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getParte($cadena = ''){
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.proceso = 4 ".$cadena;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getByRondas($id, $grupo, $fecha){ 
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.idpuesto = $id AND A.grupo = $grupo AND date(A.fecha) = date('".$fecha."') ORDER BY A.punto"; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new BitacoraData());
	}
}
