<?php
// Clase de Horarios 
class HorarioData {
	public static $tablename = "consola"; 

	public function __construct(){
		$this->idservicio = "";
		$this->idagente = "";
		$this->dia = "";
		$this->mes = "";
		$this->ano = "";
		$this->turno= "0";
		$this->tipo = "";
		$this->update_at = "NOW()";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idservicio, idagente, dia, mes, ano, turno, tipo, created_at) value ($this->idservicio, $this->idagente, \"$this->dia\", \"$this->mes\", \"$this->ano\", $this->turno, $this->tipo, NOW())"; 
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set turno=$this->turno, update_at=NOW() where id=$this->id"; // idagente=$this->idagente, dia=\"$this->dia\", mes=\"$this->mes\", ano=\"$this->ano\", tipo=$this->tipo, 
		return Executor::doit($sql);
	}

	public static function getByTurnos($servicio, $id, $mes, $ano, $tipo){
		$sql = "select * from ".self::$tablename." where idservicio=$servicio and idagente=$id and CAST(mes AS UNSIGNED)=$mes and CAST(ano AS UNSIGNED)=$ano and tipo=$tipo";
		$query = Executor::doit($sql); 

		return Model::many($query[0],new HorarioData());
	}

	public static function getByIdHorarioA($servicio, $id, $mes, $ano, $tipo){
		$con = Database::getCon();
		$sql = "select * from ".self::$tablename." where idservicio=$servicio and idagente=$id and CAST(mes AS UNSIGNED)=$mes and CAST(ano AS UNSIGNED)=$ano and tipo=$tipo"; 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["id"] = $r[0];
			$array[$x]["idservicio"] = $r[1];
			$array[$x]["idagente"] = $r[2];
			$array[$x]["dia"] = $r[3];
			$array[$x]["mes"] = $r[4];
			$array[$x]["ano"] = $r[5];
			$array[$x]["turno"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getByIdHorario($servicio, $id, $mes, $ano, $tipo){
		$con = Database::getCon();
		$sql = "select * from ".self::$tablename." where idservicio=$servicio and idagente=$id and CAST(mes AS UNSIGNED)=$mes and CAST(ano AS UNSIGNED)=$ano and tipo=$tipo"; 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["id"] = $r[0];
			$array[$x]["idservicio"] = $r[1];
			$array[$x]["idagente"] = $r[2];
			$array[$x]["dia"] = $r[3];
			$array[$x]["mes"] = $r[4];
			$array[$x]["ano"] = $r[5];
			$array[$x]["turno"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getByIdHorarioAll($id, $mes, $ano, $tipo){
		$con = Database::getCon();
		$sql = "select * from ".self::$tablename." where idagente=$id and CAST(mes AS UNSIGNED)=$mes and CAST(ano AS UNSIGNED)=$ano and tipo=$tipo "; 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["id"] = $r[0];
			$array[$x]["idservicio"] = $r[1];
			$array[$x]["idagente"] = $r[2];
			$array[$x]["dia"] = $r[3];
			$array[$x]["mes"] = $r[4];
			$array[$x]["ano"] = $r[5];
			$array[$x]["turno"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getByIdFalta($id){
		$con = Database::getCon();
		$sql = "SELECT * FROM documento WHERE idhorario = $id";

		$query = $con->query($sql);

		$found = null;
		$data = new HorarioData();

		while($r = $query->fetch_array()){
			$data->id = $r[0];
			$data->idperson = $r[1];
			$data->idhorario = $r[2];
			$data->tipo = $r[6];
			$data->turno = $r[7];
			$data->motivo = $r[8];
			$data->observacion = $r[9];
			$data->comunico = $r[10];
			$data->fecha = $r[11];
			$data->idpersona = $r[12];
			$data->respaldo = $r[13];
			$data->documento = $r[14];
			$data->cubierto_por = $r[15];
			$data->costo = $r[16];
			$data->quien = $r[17];
			$data->pago = $r[18];
			$data->firmo = $r[19];
			$data->is_active = $r[20];
			$data->created_at = $r[22];
			$found = $data;

			break;
		}

		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);

		return Model::many($query[0],new HorarioData());
	}

	public static function getAllByTurno(){
		$sql = " SELECT C.descripcion, B.name, A.* 
				   FROM horario A, person B, puestos C 
				  WHERE A.idagente = B.id AND A.idservicio = C.id AND A.turno = 10 
			   ORDER BY A.update_at DESC LIMIT 15";

		$query = Executor::doit($sql);
		return Model::many($query[0],new HorarioData());
	}

	public static function getLike($servicio, $mes, $ano){
		$sql = "select * from ".self::$tablename." where mes like '%$mes%' AND ano like '%$ano%' AND idservicio = $servicio";
		$query = Executor::doit($sql); 

		return Model::many($query[0],new HorarioData());
	}

	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);

		return Model::many($query[0],new CuentasData());
	}

	public static function getByTurno($id, $turno){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idagente=$id AND turno=$turno ";
		$query = Executor::doit($sql);

		return Model::one($query[0],new HorarioData());
	}	
	
	public static function getTurnoTotal($cliente, $id, $mes, $ano, $tipo, $turno){
		$sql = "SELECT * FROM horario A, puestos B
		         WHERE B.id = A.idservicio AND B.idclient=$cliente AND A.idagente=$id AND CAST(A.mes AS UNSIGNED)=$mes AND CAST(A.ano AS UNSIGNED)=$ano AND A.tipo=$tipo AND A.turno=$turno";
		$query = Executor::doit($sql);

		return Model::many($query[0],new HorarioData());
	}
}

