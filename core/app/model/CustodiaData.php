<?php
// Clase de la Tabla de Control de Custodias
class CustodiaData {
	public static $tablename = "custodia";

	public function __construct(){
		$this->id = "";
		$this->is_active = "1";
		$this->created_at = "NOW()";
	}

	public function add(){		
		$sql = "insert into ".self::$tablename." (vehiculo, fecha, nombre, cedula, kilometraje, is_active, usuario_log, created_at) ";
		$sql .= "value (\"$this->vehiculo\", \"$this->fecha\", \"$this->nombre\", \"$this->cedula\", \"$this->kilometraje\", \"$this->is_active\", \"".$_SESSION['user_name']."\", $this->created_at)";
		Executor::doit($sql);
	}

	public function addFoto(){		
		$sql = "insert into custodiaf (idcustodia, entrada, numero, foto, is_active, usuario_log, created_at) ";
		$sql .= "value (\"$this->idcustodia\", \"$this->entrada\", \"$this->numero\", \"$this->foto\", 1, \"".$_SESSION['user_name']."\", $this->created_at)";
		echo $sql;
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

	public function recuperar(){
		$sql = "update ".self::$tablename." set is_active = 1 where id=$this->id";

		Executor::doit($sql);
	}


	public function control(){
		$sql = "update ".self::$tablename." set estado=$this->estado where id=$this->id";

		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set vehiculo=\"$this->vehiculo\", kilometraje=\"$this->kilometraje\", fecha=\"$this->fecha\", nombre=\"$this->nombre\", cedula=\"$this->cedula\",
		            municion=\"$this->municion\", llantas=\"$this->llantas\", ollantas=\"$this->ollantas\", rayones=\"$this->rayones\", orayones=\"$this->orayones\", 
		            espejos=\"$this->espejos\", oespejos=\"$this->oespejos\", puertas1=\"$this->puertas1\", opuertas1=\"$this->opuertas1\", capo=\"$this->capo\", ocapo=\"$this->ocapo\", 
		            balde=\"$this->balde\", obalde=\"$this->obalde\", guias1=\"$this->guias1\", oguias1=\"$this->oguias1\", guias2=\"$this->guias2\", oguias2=\"$this->oguias2\", 
		            luces=\"$this->luces\", oluces=\"$this->oluces\", motor=\"$this->motor\", anomalia=\"$this->anomalia\", asientos=\"$this->asientos\", oasientos=\"$this->oasientos\", 
		            panel=\"$this->panel\", opanel=\"$this->opanel\", cinturon=\"$this->cinturon\", ocinturon=\"$this->ocinturon\", forros=\"$this->forros\", oforros=\"$this->oforros\", 
		            elevadores=\"$this->elevadores\", oelevadores=\"$this->oelevadores\", aire=\"$this->aire\", oaire=\"$this->oaire\", parabrisa=\"$this->parabrisa\", oparabrisa=\"$this->oparabrisa\", 
		            emergencia=\"$this->emergencia\", oemergencia=\"$this->oemergencia\", extintor=\"$this->extintor\", oextintor=\"$this->oextintor\", techo=\"$this->techo\", otecho=\"$this->otecho\", 
		            puertas2=\"$this->puertas2\", opuertas2=\"$this->opuertas2\", enciende=\"$this->enciende\", oenciende=\"$this->oenciende\", aceite=\"$this->aceite\", oaceite=\"$this->oaceite\", 
		            hidraulico=\"$this->hidraulico\", ohidraulico=\"$this->ohidraulico\", freno=\"$this->freno\", ofreno=\"$this->ofreno\", refrigerante=\"$this->refrigerante\", 
		            orefrigerante=\"$this->orefrigerante\", is_active=\"$this->is_active\", usuario_log=\"".$_SESSION['user_name']."\" WHERE id=$this->id"; 
    
		Executor::doit($sql);
	}

	public function update2(){
		$sql = "update ".self::$tablename." set observacion=\"$this->observacion\", kilometraje2=\"$this->kilometraje2\", fecha2=\"$this->fecha2\", municion2=\"$this->municion2\", 
		            llantas2=\"$this->llantas2\", ollantas2=\"$this->ollantas2\", rayones2=\"$this->rayones2\", orayones2=\"$this->orayones2\", espejos2=\"$this->espejos2\", 
		            oespejos2=\"$this->oespejos2\", puertas12=\"$this->puertas12\", opuertas12=\"$this->opuertas12\", capo2=\"$this->capo2\", ocapo2=\"$this->ocapo2\", 
		            balde2=\"$this->balde2\", obalde2=\"$this->obalde2\", guias12=\"$this->guias12\", oguias12=\"$this->oguias12\", guias22=\"$this->guias22\", oguias22=\"$this->oguias22\", 
		            luces2=\"$this->luces2\", oluces2=\"$this->oluces2\", motor2=\"$this->motor2\", anomalia2=\"$this->anomalia2\", asientos2=\"$this->asientos2\", oasientos2=\"$this->oasientos2\", 
		            panel2=\"$this->panel2\", opanel2=\"$this->opanel2\", cinturon2=\"$this->cinturon2\", ocinturon2=\"$this->ocinturon2\", forros2=\"$this->forros2\", oforros2=\"$this->oforros2\", 
		            elevadores2=\"$this->elevadores2\", oelevadores2=\"$this->oelevadores2\", aire2=\"$this->aire2\", oaire2=\"$this->oaire2\", parabrisa2=\"$this->parabrisa2\", oparabrisa2=\"$this->oparabrisa2\", 
		            emergencia2=\"$this->emergencia2\", oemergencia2=\"$this->oemergencia2\", extintor2=\"$this->extintor2\", oextintor2=\"$this->oextintor2\", techo2=\"$this->techo2\", otecho2=\"$this->otecho2\", 
		            puertas22=\"$this->puertas22\", opuertas22=\"$this->opuertas22\", enciende2=\"$this->enciende2\", oenciende2=\"$this->oenciende2\", aceite2=\"$this->aceite2\", oaceite2=\"$this->oaceite2\", 
		            hidraulico2=\"$this->hidraulico2\", ohidraulico2=\"$this->ohidraulico2\", freno2=\"$this->freno2\", ofreno2=\"$this->ofreno2\", refrigerante2=\"$this->refrigerante2\", 
		            orefrigerante2=\"$this->orefrigerante2\", status=\"Recibido\", usuario_log=\"".$_SESSION['user_name']."\" WHERE id=$this->id"; 
        echo $sql;
		Executor::doit($sql);
	}
	
	public static function getDatos($id){
		$sql = "SELECT A.* FROM salidas A WHERE A.idcotizacion = $id AND A.tipo = 3 AND A.is_active = 1"; 
		$query = Executor::doit($sql); //echo $sql;
		return Model::many($query[0],new CustodiaData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=\"$id\"";

		$query = Executor::doit($sql);
		return Model::one($query[0],new CustodiaData());
	}

	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m like '%$n%'";
		$query = Executor::doit($sql);

		return Model::one($query[0],new CustodiaData());
	}

	public static function getCodigo(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." ORDER BY id DESC LIMIT 1"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new CotizacionData());
	}

	public static function getCentrol($id){ 
		$sql = "SELECT B.nombre, A.* FROM ".self::$tablename." A, client B WHERE A.idclient = B.idclient AND A.idclient = $id";
	    $query = Executor::doit($sql);

	    return Model::many($query[0],new CustodiaData());
    }

	public static function getAll($status){
		$sql = 'SELECT A.*, B.serial, C.name, C.unit FROM custodia A, operation B, product C WHERE B.id = A.vehiculo AND C.id = B.product_id AND status = "'.$status.'"';
		$query = Executor::doit($sql);
		
		return Model::many($query[0],new CustodiaData());
	}
}

