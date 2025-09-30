<?php
//Falta de los guardias
class FaltaData {
	public static $tablename = "falta";

	public function __construct(){
		$this->id = "";
		$this->company = "";
		$this->tipo_documen = "";
		$this->idperson = "";
		$this->idhorario = "";
		$this->fecha_doc = "";
		$this->tipo = "";
		$this->turno = "";
		$this->numero = "";
		$this->motivo = "";
		$this->observacion = "";
		$this->comunico = "";
		$this->fecha = "";
		$this->idpersona = "";
		$this->respaldo = "";
		$this->documento = "";
		$this->cubierto_por = "";
		$this->costo = "";
		$this->quien = "";
		$this->pago = "";
		$this->firmo = "";
		$this->is_active = "";
		$this->created_at = "NOW()";
		$this->ip = "";
	}

	public function ingresa(){
		$sql = "insert into documento (company, idperson, fecha_doc, tipo_documen, numero, motivo, firmo, usuario_log, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", $this->idperson, \"$this->fecha_doc\", $this->tipo_documen, \"$this->numero\", \"$this->motivo\", $this->firmo, \"".$_SESSION['user_name']."\", NOW())";
		Executor::doit($sql);
	}

	public function add(){
		$sql = "insert into documento (idperson, idhorario, fecha_doc, tipo_documen, numero, tipo, turno, motivo, comunico, fecha, idpersona, respaldo, documento, cubierto_por, costo, quien, pago, firmo, created_at) ";
		$sql .= "value ($this->idperson, $this->idhorario, \"$this->fecha_doc\", $this->tipo_documen, \"$this->numero\", \"$this->tipo\", \"$this->turno\", \"$this->motivo\", $this->comunico, \"$this->fecha\", $this->idpersona, $this->respaldo, \"$this->documento\", $this->cubierto_por, $this->costo, $this->quien, $this->pago, $this->firmo, NOW())";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set is_active = 0 where id=$this->id";
		Executor::doit($sql);
	}

	public function guardar(){
		$sql = "UPDATE documento SET usuario_log=\"".$_SESSION['user_name']."\", firmo=\"$this->firmo\", tipo_documen=\"$this->tipo_documen\", ";
		$sql .= "motivo=\"$this->motivo\", numero=\"$this->numero\", fecha_doc=\"$this->fecha_doc\", idperson=$this->idperson, update_at=NOW() WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update documento set firmo=\"$this->firmo\", tipo=\"$this->tipo\", turno=\"$this->turno\", motivo=\"$this->motivo\", ";
		$sql .= "comunico=$this->comunico, fecha=\"$this->fecha\", idpersona=$this->idpersona, respaldo=$this->respaldo, ";
		$sql .= "documento=\"$this->documento\", cubierto_por=$this->cubierto_por, costo=$this->costo, quien=$this->quien, ";
		$sql .= "pago=$this->pago, update_at=NOW() WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function getByIdFalta($id){
		$sql = "SELECT A.id, A.tipo, B.name, C.description, A.fecha_doc, A.created_at, A.idperson, A.firmo, A.motivo, A.tipo_documen FROM documento A, person B, tipo_documento C WHERE A.idperson = B.id AND A.tipo_documen = C.id AND A.idhorario=$id"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new FaltaData());
	}

	public static function getById($id){
		$sql = "SELECT A.id, A.tipo, B.name, C.description, A.numero, A.fecha_doc, A.created_at, A.idperson, A.firmo, A.motivo, A.tipo_documen FROM documento A, person B, tipo_documento C WHERE A.idperson = B.id AND A.tipo_documen = C.id AND A.id=$id";
		$query = Executor::doit($sql); 
		return Model::one($query[0],new FaltaData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." order by status, date_event DESC";
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){

			$array[$cnt] = new TimelineData();

			$array[$cnt]->id = $r['id'];

			$array[$cnt]->idcompany = $r['idcompany'];

			$array[$cnt]->idperson = $r['idperson'];

			$array[$cnt]->status = $r['status'];

			$array[$cnt]->quien_asigna = $r['quien_asigna'];

			$array[$cnt]->type = $r['type'];

			$array[$cnt]->title = $r['title'];

			$array[$cnt]->body = $r['body'];

			$array[$cnt]->date_event = $r['date_event'];

			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;

		}

		return $array;

	}



	public static function getLike($q){

		$sql = "select * from ".self::$tablename." where name like '%$q%'";

		$query = Executor::doit($sql);

		$array = array();

		$cnt = 0;

		while($r = $query[0]->fetch_array()){

			$array[$cnt] = new CategoryData();

			$array[$cnt]->id = $r['id'];

			$array[$cnt]->name = $r['name'];

			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;

		}

		return $array;

	}

}

