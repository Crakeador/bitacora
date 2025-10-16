<?php
// Clases utilizadas en la tabla de puestos
class PuestoData {
	public static $tablename = "puestos";

	public function __construct(){
		$this->id = 0;
		$this->grupo = 0;
		$this->idcompany = 0;
		$this->idclient = 0;
		$this->tipo = 0;		
		$this->sucursal = 0;
		$this->residencial = 0;
		$this->codigo = "";
		$this->tipo = 0;
		$this->descripcion = "";
		$this->activado = "";
		$this->idlugar = 0;
		$this->horas = 0;
		$this->horario = "";
		$this->lunes = 0;
		$this->martes = 0;
		$this->miercoles = 0;
		$this->jueves = 0;
		$this->viernes = 0;
		$this->sabado = 0;
		$this->domingo = 0;
		$this->feriado = 0;
		$this->observacion = 0;
		$this->principal = 0;
		$this->is_active = 0;
		$this->created_at = "NOW()";
	}

	public function getPerson(){ return PersonData::getById($this->person_id);}
	public function getUser(){ return UserData::getById($this->user_id);}

	public function add(){
		$sql = "insert into ".self::$tablename." (grupo, idcompany, idclient, tipo, codigo, residencial, descripcion, activado, idlugar, horas, horario, lunes, martes, miercoles, jueves, viernes, sabado, domingo, feriado, observacion, principal, is_active, usuario_log, created_at) ";
		$sql .= "value ($this->grupo, ".$_SESSION['id_company'].", $this->idclient, $this->tipo, \"$this->codigo\", $this->residencial, \"$this->descripcion\", \"$this->activado\", $this->idlugar, $this->horas, \"$this->horario\", $this->lunes, $this->martes, $this->miercoles, $this->jueves, $this->viernes, $this->sabado, $this->domingo, $this->feriado,\"".$this->observacion."\", $this->principal, $this->is_active, \"".$_SESSION['user_name']."\", $this->created_at)";
        
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "UPDATE ".self::$tablename." SET idclient='".$this->idclient."', codigo ='".$this->codigo."', residencial ='".$this->residencial."', descripcion ='".$this->descripcion."', activado ='".$this->activado."', idlugar ='".$this->idlugar."', horas ='".$this->horas."', horario ='".$this->horario."', observacion ='".$this->observacion."',";
		$sql .= "lunes ='".$this->lunes."', martes ='".$this->martes."', miercoles ='".$this->miercoles."', jueves ='".$this->jueves."', viernes ='".$this->viernes."', sabado ='".$this->sabado."', domingo ='".$this->domingo."', feriado ='".$this->feriado."', principal ='".$this->principal."', is_active ='".$this->is_active."', usuario_log ='".$_SESSION['user_name']."' WHERE id=$this->id"; 
		Executor::doit($sql);
	}

	public function serial(){
		$sql = "UPDATE operation SET serial='".$this->serial."', estado ='".$this->estado."' WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function desvincular(){
		$sql = "UPDATE personpuestos SET is_active=0, usuario_log ='".$_SESSION['user_name']."', ip ='".$_SESSION['ip']."' WHERE idperson=$this->id";
		Executor::doit($sql);
	}
	
	public static function getDetalle($id){
		$sql = "SELECT * FROM rondas WHERE idpuesto = $id AND is_active = 1"; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new PuestoData());
	}

	public static function getByPuestos($id){
		$sql = "select * from ".self::$tablename." where idclient=$id and principal = 0"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getByIdTodos($id, $activo=1){
		$sql = "select * from ".self::$tablename." where idclient=$id AND is_active = $activo"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getByCompany($id){
		$sql = "select * from ".self::$tablename." where idcompany=$id"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}
	
	public static function getByIdOperation($id){
		$sql = "select * from operation where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PuestoData());
	}

	public static function getByIdPerson($id){
		$sql = "select * from ".self::$tablename." where person_id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PuestoData());
	}

	public static function getByLocalidad(){
		$con = Database::getCon();
		$sql = "SELECT * FROM localidad WHERE is_active = 1";
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$x++;
		}
		return $array;
	}

	public static function getByIdCliente($client, $tipo, $estado, $ini, $fin){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, C.id, A.idservicio ";
		$sql .=  "FROM personpuestos A, puestos B, person C, cargo D ";
		$sql .= "WHERE A.idservicio = B.id AND A.idperson = C.id AND C.cargo = D.id AND B.tipo = 2 AND B.idclient = $client AND D.idtipo = $tipo AND A.is_active = $estado ";
		$sql .= "AND date(C.startwork) >= \"".$ini."\" AND date(C.startwork) <= \"".$fin."\" ";
		$sql .= "GROUP BY A.idperson ";
		$sql .= "ORDER BY C.name"; 
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["id"] = $r[4];
			$array[$x]["servicio"] = $r[5];
			$x++;
		}
		return $array;
	}

	public static function getByIdHorario($id, $tipo, $estado, $ini=null, $fin=null){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, C.id, A.idservicio, C.startwork, C.phone1, C.phone2 ";
		$sql .=  "FROM personpuestos A, puestos B, person C, cargo D ";
		$sql .= "WHERE A.idservicio = B.id AND A.idperson = C.id AND C.idcargo = D.id AND A.idservicio = $id AND D.idtipo IN ($tipo) AND A.is_active = $estado ";
		if($ini == NULL)
			$sql .= "";
		else
			$sql .= "AND date(C.startwork) >= \"".$ini."\" AND date(C.startwork) <= \"".$fin."\" ";
		$sql .= "ORDER BY C.name"; // B.grupo, A.idservicio, 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["id"] = $r[4];
			$array[$x]["servicio"] = $r[5];
			$array[$x]["startwork"] = $r[6];
			$array[$x]["phone1"] = $r[7];
			$array[$x]["phone2"] = $r[8];
			$x++;
		}
		return $array;
	}
	
	public static function getByIdDesvinculado($id, $tipo, $estado){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, C.id, A.idservicio, C.startwork ";
		$sql .=  "FROM personpuestos A, puestos B, person C, cargo D ";
		$sql .= "WHERE A.idservicio = B.id AND A.idperson = C.id AND C.idcargo = D.id AND A.idservicio = $id AND D.idtipo = $tipo AND A.is_active = $estado "; 
		$sql .= "ORDER BY B.grupo, A.idservicio, C.name"; 
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["id"] = $r[4];
			$array[$x]["servicio"] = $r[5];
			$array[$x]["startwork"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getBySancion(){
		$con = Database::getCon();
		$sql = "SELECT B.name, C.description, A.fecha_doc, A.created_at, A.idperson, A.firmo ";
		$sql .=  "FROM documento A, person B, tipo_documento C ";
		$sql .= "WHERE A.idperson = B.id AND A.tipo_documen = C.id AND A.responsable = '".$_SESSION['user_name']."'";
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["nombre"] = $r[0];
			$array[$x]["documen"] = $r[1];
			$array[$x]["fecha"] = $r[2];
			$array[$x]["created_at"] = $r[3];
			$array[$x]["idperson"] = $r[4];
			$array[$x]["firmo"] = $r[5];
			$x++;
		}
		return $array;
	}

	public static function getByDocumentos(){
		$con = Database::getCon();
		$sql = "SELECT B.name, C.description, A.fecha_doc, A.created_at, A.idperson, A.firmo, A.id ";
		$sql .= "FROM documento A, person B, tipo_documento C WHERE A.idperson = B.id AND A.tipo_documen = C.id";
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["nombre"] = $r[0];
			$array[$x]["documen"] = $r[1];
			$array[$x]["fecha"] = $r[2];
			$array[$x]["created_at"] = $r[3];
			$array[$x]["idperson"] = $r[4];
			$array[$x]["firmo"] = $r[5];
			$array[$x]["id"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getByFaltas(){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, A.* 
		          FROM horario A, puestos B, person C, cargo D 
		        WHERE A.turno=4 AND A.tipo = 2 AND A.idservicio = B.id AND A.idagente = C.id AND C.idcargo = D.id AND 
				      A.is_active = 1 AND C.idcargo IN (7,8) ORDER BY B.grupo, A.idservicio, C.idcargo"; 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["idhorario"] = $r[4];
			if(strlen($r[9]) == 1)
				$dia = '0'.$r[9];
			else
				$dia = $r[9];

			if(strlen($r[10]) == 1)
				$mes = '0'.$r[10];
			else
				$mes = $r[10];

			$array[$x]["fecha"] = $dia.'-'.$mes.'-'.$r[11];

			$array[$x]["created_at"] = $r[16];
			$x++;
		}
		return $array;
	}

	public static function getByLugar(){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, A.* ";
		$sql .= "FROM horario A, puestos B, person C, cargo D ";
		$sql .= "WHERE A.turno=4 AND A.tipo = 2 AND A.idservicio = B.id AND A.idagente = C.id AND C.idcargo = D.id AND A.is_active = 1 ";
		$sql .= "AND C.idcargo IN (7,8) AND B.idlugar = ".$_SESSION['id_localidad']." ORDER BY B.grupo, A.idservicio, C.idcargo";
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["idhorario"] = $r[4];
			if(strlen($r[9]) == 1)
				$dia = '0'.$r[9];
			else
				$dia = $r[9];

			if(strlen($r[10]) == 1)
				$mes = '0'.$r[10];
			else
				$mes = $r[10];

			$array[$x]["fecha"] = $dia.'-'.$mes.'-'.$r[11];

			$array[$x]["created_at"] = $r[16];
			$x++;
		}
		return $array;
	}

	public static function getByAdministrador($id){ 
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, C.id, A.idservicio, C.startwork 
		          FROM personpuestos A, puestos B, person C, cargo D 
				 WHERE A.idservicio = B.id AND A.idperson = C.id AND C.idcargo = D.id AND A.is_active = 1 AND B.id = 1 AND D.idtipo in (1, 2) AND B.idlugar = $id AND 
				       C.idcompany = ".$_SESSION['id_company']." ORDER BY B.grupo, A.idservicio, C.cargo"; 
		$query = $con->query($sql); 

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1];
			$array[$x]["nombre"] = $r[2];
			$array[$x]["cargo"] = $r[3];
			$array[$x]["id"] = $r[4];
			$array[$x]["servicio"] = $r[5];	
			$array[$x]["startwork"] = $r[6];
			$x++;
		}
		return $array;
	}

	public static function getByIdDias($id){
		$con = Database::getCon();
		$sql = "SELECT D.id, E.name, D.q, D.serial, D.created_at, B.idcard, B.name, E.id, E.image, E.price_out 
		          FROM personpuestos A, person B, sell C, operation D, product E 
				 WHERE A.idservicio = $id and A.idperson = B.id and B.id = C.person_id and C.id = D.sell_id and D.product_id = E.id and E.category_id = 4";
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["id"] = $r[0];
			$array[$x]["producto"] = $r[1];
			$array[$x]["cantidad"] = $r[2];
			$array[$x]["serial"] = $r[3];
			$array[$x]["entregado"] = $r[4];
			$array[$x]["idcard"] = $r[5];
			$array[$x]["name"] = $r[6];
			$array[$x]["idproducto"] = $r[7];
			$array[$x]["image"] = $r[8];
			$array[$x]["total"] = $r[9];
			$x++;
		}
		return $array;
	}

	public static function getByIdPuestos($id){
		$con = Database::getCon();
		$sql = "SELECT A.id, B.name, A.q, A.serial, A.created_at, B.id, B.image, B.price_out FROM operation A, product B WHERE A.idpuesto = $id AND A.product_id = B.id AND B.category_id = 4";
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["id"] = $r[0];
			$array[$x]["producto"] = $r[1];
			$array[$x]["cantidad"] = $r[2];
			$array[$x]["serial"] = $r[3];
			$array[$x]["entregado"] = $r[4];
			$array[$x]["idcard"] = 0;
			$array[$x]["name"] = "";
			$array[$x]["idproducto"] = $r[5];
			$array[$x]["image"] = $r[6];
			$array[$x]["total"] = $r[7];
			$x++;
		}
		return $array;
	}

	public static function getByIdPersonas($id){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, A.dia, A.mes, A.ano, E.*
  				  FROM horario A, puestos B, person C, cargo D, documento E
 				 WHERE A.idservicio = B.id AND A.idagente = C.id AND C.cargo = D.id AND A.id = $id AND A.is_active = 1 AND A.id = E.idhorario"; 
		$query = $con->query($sql);

		$found = null;
		$data = new HorarioData();
		while($r = $query->fetch_array()){
			$data->codigo = $r[0];
			$data->descripcion = $r[1];
			$data->agente = $r[2];
			$data->cargo = $r[4];
			$data->falta = $r[4].'/'.$r[5].'/'.$r[6];
			$data->id = $r[7];
			$data->idperson = $r[8];
			$data->idhorario = $r[9];
			$data->fecha_doc = $r[10];
			$data->tipo = $r[15];
			$data->turno = $r[16];
			$data->motivo = $r[20];
			$data->observacion = $r[14];
			$data->comunico = $r[21];
			$data->fecha = $r[20];
			$data->idpersona = $r[23];
			$data->respaldo = $r[24];
			$data->documento = $r[25];
			$data->cubierto_por = $r[26];
			$data->costo = $r[27];
			$data->quien = $r[28];
			$data->pago = $r[29];
			$data->firmo = $r[30];
			$data->is_active = $r[31];
			$data->created_at = $r[33];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByIdFaltaNew($id){
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion, C.name, D.description, A.dia, A.mes, A.ano, C.id
  				    FROM horario A, puestos B, person C, cargo D
 				     WHERE A.idservicio = B.id AND A.idagente = C.id AND C.idcargo = D.id AND A.id = $id AND A.is_active = 1";
		$query = $con->query($sql);

		$found = null;
		$data = new HorarioData();
		while($r = $query->fetch_array()){
			$data->codigo = $r[0];
			$data->descripcion = $r[1];
			$data->agente = $r[2];
			$data->cargo = $r[3];
			$data->id = 0;
			$data->idhorario = 0;
			$data->tipo = 1;
			$data->turno = 1;
			$data->motivo = "";
			$data->observacion = "";
			$data->comunico = 1;
			$data->fecha = "0000-00-00 00:00:00";
			$data->idpersona = 0;
			$data->respaldo = 1;
			$data->documento = "";
			$data->cubierto_por = 0;
			$data->costo = "";
			$data->quien = 1;
			$data->pago = 1;
			$data->is_active = 1;
			$data->created_at = "0000-00-00 00:00:00";
			$data->falta = $r[4].'/'.$r[5].'/'.$r[6];
			$data->idperson = $r[7];
			$data->firmo = 2;
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByIdProduct($id){
		$con = Database::getCon();
		$sql = "SELECT D.id, E.name, D.q, D.serial, D.created_at, B.idcard, B.name, E.id, E.image, D.estado 
		          FROM personpuestos A, person B, sell C, operation D, product E 
				 WHERE A.idperson = B.id and B.id = C.person_id and C.id = D.sell_id and D.product_id = E.id and D.id = $id";
		$query = $con->query($sql);

		$found = null;
		$data = new BoxData();
		while($r = $query->fetch_array()){
			$data->id = $r[0];
			$data->producto = $r[1];
			$data->q = $r[2];
			$data->serial = $r[3];
			$data->created_at = $r[4];
			$data->idcard = $r[5];
			$data->name = $r[6];
			$data->idproducto = $r[7];
			$data->image = $r[8];
			$data->estado = $r[9];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getSellsUnBoxed(){
		$sql = "SELECT * FROM ".self::$tablename." where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getByBoxId($id){
		$sql = "SELECT * FROM ".self::$tablename." where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getRes(){
		$sql = "SELECT * FROM ".self::$tablename." where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getById($id){
		$sql = "SELECT B.descripcion lugar, A.* FROM puestos A, localidad B WHERE A.idlugar = B.id AND A.id = $id"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new PuestoData());
	}

	public static function getPuesto($tipo){
		$sql = "SELECT A.* FROM puestos A WHERE A.tipo = $tipo ORDER by idclient, codigo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getCliente($idclient){
		$sql = "SELECT A.* FROM puestos A WHERE A.idclient = $idclient ORDER by idclient, codigo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getByLibre($id){
		$sql = "select * from personpuestos A WHERE A.idperson = $id AND A.is_active = 1";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new PuestoData());
	}

	public static function getByAgente($id){
		$sql = "select B.idcard, B.name, B.fechanacimiento, B.startwork, B.direccion from personpuestos A, person B WHERE A.idperson = B.id AND A.idservicio = $id AND A.is_active = 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getAll($tipo, $activo=1){
		$sql = "SELECT C.nombre cliente, B.descripcion lugar, A.* FROM puestos A, localidad B, client C 
		         WHERE A.idclient = C.id AND A.idlugar = B.id AND A.tipo = $tipo AND A.is_active = $activo 
		      ORDER by idclient, codigo"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}
 
	public static function getAllLugar($tipo){
		$sql = "SELECT C.nombre cliente, B.descripcion lugar, A.* FROM puestos A, localidad B, client C ";
		$sql .= "WHERE A.idclient = C.id AND A.idlugar = B.id AND A.tipo = $tipo AND A.idlugar = ".$_SESSION['id_localidad']." AND A.is_active = 1 ";
		$sql .= "ORDER by idclient, codigo";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getAllpuesto($id, $estado){
		$sql = "SELECT A.id servicio, A.created_at, B.codigo, B.descripcion, E.descripcion lugar, C.idcard, C.direccion, C.name, C.fechanacimiento, C.demanda, D.description cargo, C.id, A.idservicio, A.is_active ";
		$sql .=  "FROM personpuestos A, puestos B, person C, cargo D, localidad E ";
		$sql .= "WHERE A.idservicio = B.id AND A.idperson = C.id AND C.idcargo = D.id AND B.idlugar = E.id AND A.idservicio = $id AND A.is_active = $estado ";
		$sql .= "ORDER BY B.grupo, A.idservicio, C.idcargo"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new PuestoData());
	}

	public static function getAsignar(){
		$sql = "SELECT B.id servicio, B.idservicio, B.created_at, C.descripcion, E.descripcion lugar, D.description cargo, A.name, A.direccion, A.demanda, A.fechanacimiento 
		          FROM person A ";
		$sql .= "LEFT JOIN personpuestos B ON B.idperson = A.id ";
		$sql .= "LEFT JOIN puestos C ON C.id = B.idservicio ";
		$sql .= "LEFT JOIN cargo D ON D.id = A.idcargo ";
		$sql .= "LEFT JOIN localidad E ON E.id = C.idlugar"; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new PuestoData());
	}

	public static function getByIdPuesto($id){ // Revisar
		$con = Database::getCon();
		$sql = "SELECT B.codigo, B.descripcion FROM personpuestos A, puestos B WHERE A.idservicio = B.id and A.idperson = $id and A.is_active = 1"; 
		$query = $con->query($sql);

		$x = 0; $array = array();
		while($r = $query->fetch_array()){
			$array[$x]["codigo"] = $r[0];
			$array[$x]["descripcion"] = $r[1]; 
			$x++;
		}
		return $array;
	}

	public static function getAllByDateOp($start,$end,$op){
  		$sql = "SELECT * FROM ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}

	public static function getAllByDateBCOp($clientid,$start,$end,$op){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and client_id=$clientid  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new SellData());
	}
}