<?php
// Clases de la tabla Bitacora
date_default_timezone_set('America/Guayaquil');

class BitacoraData {
	public static $tablename = "bitacora";

	public function __construct(){
		$this->id = 0;
		$this->idpuesto = 0;
		$this->idperson = 0;
		$this->idresidente = 0;
		$this->idautoriza = 0;
		$this->fecha = "";
		$this->turno = "";
		$this->proceso = "";
		$this->tipo = "";
		$this->manzana = "";
		$this->villa = "";
		$this->observacion = "";
		$this->accion = "";
		$this->observaciono = "";
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
    
	public function addIMG(){
		$sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, fecha, turno, punto, proceso, observacion, accion, foto1, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idpuesto, $this->idperson, \"$this->fecha\", \"$this->turno\", \"$this->punto\", \"$this->proceso\", \"$this->observacion\", \"$this->accion\", \"$this->foto1\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")";
		Executor::doit($sql);
	}
	
	public function add(){
		$sql = "INSERT INTO ".self::$tablename." (idpuesto, idperson, idresidente, fecha, punto, proceso, tipo, manzana, villa, observacion, accion, observaciono, foto1, foto2, foto3, foto4, foto5, foto6, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) ";
		$sql .= "value ($this->idpuesto, $this->idperson, $this->idresidente, \"$this->fecha\", \"$this->punto\", \"$this->proceso\", \"$this->tipo\", \"$this->manzana\", \"$this->villa\", \"$this->observacion\", \"$this->accion\", \"$this->observaciono\", \"$this->foto1\", \"$this->foto2\", \"$this->foto3\", \"$this->foto4\", \"$this->foto5\", \"$this->foto6\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")";
        $res = Executor::doit($sql);
		return $res;
	}
	
	public function addReport(){
		$sql = "INSERT INTO reportes (idclient, idperson, fecha, proceso, tipo, manzana, villa, observacion, accion, observaciono, foto1, foto2, foto3, foto4, foto5, foto6, timestamp, latitude, longitude, rangoerror, sentido, velocidad, mensaje, is_active, usuario_log, ip) 
                   		value ($this->idclient, $this->idperson, \"$this->fecha\", \"$this->proceso\", \"$this->tipo\", \"$this->manzana\", \"$this->villa\", \"$this->observacion\", \"$this->accion\", \"$this->observaciono\", \"$this->foto1\", \"$this->foto2\", \"$this->foto3\", \"$this->foto4\", \"$this->foto5\", \"$this->foto6\", \"$this->timestamp\", \"$this->latitude\", \"$this->longitude\", \"$this->rangoerror\", \"$this->sentido\", \"$this->velocidad\", \"$this->mensaje\", $this->is_active, \"$this->usuario_log\", \"$this->ip\")"; 
		
		return Executor::doit($sql);
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
	
	public static function getRonda($cadena){
		$sql = "SELECT B.name, B.phone1, B.phone2, B.phone3, C.descripcion, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.proceso IN (6) ".$cadena; //." GROUP BY date(A.fecha), grupo"; , count(A.punto) AS todos
		$query = Executor::doit($sql); 
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getCustodia($cadena){
		$sql = "SELECT D.contacto, B.name, B.phone1, B.phone2, B.phone3, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C, servicio D
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.proceso LIKE ('Custodia') AND A.idresidente = D.id ".$cadena;
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getAll($cadena){
		$sql = "SELECT B.name, B.phone1, B.phone2, B.phone3, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.proceso IN (1, 2, 3, 5, 7, 8) ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
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
        
	public static function getByConsola($id, $grupo, $fecha){ 
	    $sql = "SELECT ";
	}
	
	public static function getByRondas($id){ 
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.idpuesto = $id AND date(A.fecha) = date('".$fecha."')";  //ORDER BY A.punto
		         // AND A.grupo = $grupo
		$sql = "SELECT A.* FROM rondas A WHERE A.id = $id";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new BitacoraData());
	}
	
	public static function getByClient($id, $cadena){
		$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND C.idclient = $id AND A.proceso IN (1,2,3,5) ".$cadena; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new BitacoraData());
	}
	
	public static function getByTipo($id, $cadena, $tipo){
		$sql = "SELECT A.tipo as total FROM bitacora A, person B, puestos C 
		         WHERE A.idperson = B.id AND A.idpuesto = C.id AND C.idclient = $id AND A.proceso IN (2, 5) AND A.tipo LIKE '$tipo' ".$cadena;
		$query = Executor::doit($sql); 
		return Model::many($query[0],new BitacoraData());
	}
}
