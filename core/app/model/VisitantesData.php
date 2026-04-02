<?php
// Clases de la tabla Visitantes
date_default_timezone_set('America/Guayaquil');

class VisitantesData
{
	public static $tablename = "visitantes";
 
	public $id;
	public $idpuesto;
	public $idperson;
	public $nombre;
	public $cedula;
	public $placa;
	public $observacion;
	public $accion;
	public $foto1;
	public $foto2;
	public $foto3;
	public $foto4;
	public $foto5;
	public $foto6;
	public $vistas;
	public $timestamp;
	public $latitude;
	public $longitude;
	public $rangoerror;
	public $sentido;
	public $velocidad;
	public $mensaje;
	public $is_active;
	public $created_at;
	public $usuario_log;
	public $ip;

	public function __construct()
	{
		$this->id = 0;
		$this->idpuesto = 0;
		$this->idperson = 0;
		$this->nombre = "";
		$this->cedula = "";
		$this->placa = "";
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
 
	public function add()
	{
		$sql = "INSERT INTO " . self::$tablename . " (idpuesto, idperson, nombre, cedula, placa, observacion, accion, foto1, foto2, foto3, foto4, foto5, foto6, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idpuesto, $this->idperson, \"$this->nombre\", \"$this->cedula\", \"$this->placa\", \"$this->observacion\", \"$this->accion\", \"$this->foto1\", \"$this->foto2\", \"$this->foto3\", \"$this->foto4\", \"$this->foto5\", \"$this->foto6\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")";

		$valor = Executor::doit($sql);
		return $valor;
	}

	public function update($id){
		$sql = "UPDATE ".self::$tablename." SET is_active=2 WHERE id=$id"; 
		Executor::doit($sql);
	}

	public static function getVistas($id){
		$sql = "SELECT * FROM auditoria WHERE idbitacora=$id ORDER BY fecha DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new VisitantesData());
	}

	public static function getById($id)	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VisitantesData());
	}

	public static function getByBusqueda($id, $cadena)	{
		$sql = "SELECT B.name, C.descripcion, C.codigo, C.idclient, A.* FROM visitantes A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id " . $cadena; //AND A.idpuesto = $id 
		$query = Executor::doit($sql);
		return Model::many($query[0], new VisitantesData());
	}

	public static function getLike($m, $n)	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE $m like '%$n%'";
		$query = Executor::doit($sql);
		return Model::one($query[0], new VisitantesData());
	}

	public static function getAll($cadena)	{
		$sql = "SELECT A.* FROM " . self::$tablename . " A WHERE A.is_active = 1 AND A.idpuesto = ".$cadena." ORDER BY A.nombre ASC"; 
		$query = Executor::doit($sql);
		return Model::many($query[0], new VisitantesData());
	}
}
