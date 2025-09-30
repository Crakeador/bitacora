<?php
// Clases de las Operaciones

class OperationData {
	public static $tablename = "operation";

	public function __construct(){
		$this->idcard = "";
		$this->idpuesto = "";
		$this->name = "";
		$this->product_id = "";
		$this->q = "";
		$this->estado = "";
		$this->serial = "";
		$this->fecha = "";
		$this->cut_id = "";
		$this->operation_type_id = "";
		$this->ip = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (product_id, q, serial, estado, fecha, idpuesto, operation_type_id, sell_id, ip, usuario_log, created_at) ";
		$sql .= "value (\"$this->product_id\", \"$this->q\", \"$this->serial\", \"$this->estado\", \"$this->fecha\", ".$_SESSION['id_puesto'].", $this->operation_type_id, $this->sell_id, \"".$_SESSION['ip']."\", \"".$_SESSION['user_name']."\", $this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public static function updateById($id, $monto){
		$sql = "update nomina set monto=$monto where id=$id";
		Executor::doit($sql);
	}

	public function updateTipo(){
		$sql = "update ".self::$tablename." set tipo='1' where id=$this->id"; 
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set product_id=\"$this->product_id\",q=\"$this->q\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		
		return Model::one($query[0],new OperationData());
	}

	public static function getByIdProduct($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE product_id=$id and operation_type_id = 1"; 
		$query = Executor::doit($sql);
		return Model::one($query[0],new OperationData());
	}

	public static function getByAllTipo($tipo){
		$sql = "SELECT A.* FROM operation A, product B WHERE B.id = A.product_id and B.category_id = $tipo AND A.serial!='' AND A.operation_type_id = 1"; echo $sql;
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getVehiculos(){
		$sql = "SELECT B.name, B.unit, A.* FROM operation A, product B WHERE B.id = A.product_id and B.category_id = 8 AND A.serial!='' AND A.operation_type_id = 1"; 
		$query = Executor::doit($sql); 
		return Model::many($query[0],new OperationData());
	}
	
	public static function getByAllSerial($id){
		$sql = "SELECT B.category_id, A.* FROM operation A, product B WHERE B.id=A.product_id AND A.product_id=$id AND A.serial!='' AND A.operation_type_id = 1";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}	
	
	public static function getByAllProduct($id){
		$sql = "select * from ".self::$tablename." where product_id=$id and operation_type_id = 1"; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}
	
	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByDateOfficial($start,$end){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" order by created_at desc";
		if($start == $end){
		    $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}

		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByDateOfficialBP($product, $start,$end){
 		$sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and product_id=$product order by created_at desc";
		if($start == $end){
		    $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}

		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public function getProduct(){ return ProductData::getById($this->product_id); }
	public function getOperationtype(){ return OperationTypeData::getById($this->operation_type_id);}

	public static function getQYesF($product_id){
		$q=0;
		$operations = self::getAllByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;

		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; 
			    
			}else if($operation->operation_type_id==$output_id)
			    { $q+=(-$operation->q); }
		}

		return $q;
	}

	public static function getAllByProductIdCutId($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";
		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());
	}

	public static function getAllByProductNombre($product_id){
		$sql = "SELECT A.id, A.serial, A.estado, A.product_id, A.sell_id, A.q, C.idcard, C.name, A.created_at, D.descripcion
				  FROM operation A
			INNER JOIN sell B ON A.sell_id = B.id
			INNER JOIN person C ON B.person_id = C.id
			 LEFT JOIN puestos D ON A.idpuesto = D.id
				 WHERE A.product_id = $product_id
 			  ORDER BY A.serial"; 

		$query = Executor::doit($sql);

		$array = array(); $cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new OperationData();
			$array[$cnt]->idsell = $r['id'];
			$array[$cnt]->serial = $r['serial'];
			$array[$cnt]->estado = $r['estado'];
			$array[$cnt]->id = $r['product_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->descripcion = $r['descripcion'];

			$cnt++;
		}

		return $array;
	}

	public static function getAllByProductStados($product_id){

		$sql = "SELECT A.id, A.serial, A.estado, A.product_id, A.sell_id, A.q, C.idcard, C.name, A.created_at, D.descripcion
			      FROM operation A
			INNER JOIN sell B ON A.sell_id = B.id
		    INNER JOIN person C ON B.person_id = C.id
			 LEFT JOIN puestos D ON A.idpuesto = D.id
			INNER JOIN estados E ON A.estado = E.id
			     WHERE A.estado = $product_id
 			     ORDER BY A.serial";

		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new OperationData();
			$array[$cnt]->idsell = $r['id'];
			$array[$cnt]->serial = $r['serial'];
			$array[$cnt]->estado = $r['estado'];
			$array[$cnt]->id = $r['product_id'];
			$array[$cnt]->q = $r['q'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$cnt++;
		}

		return $array;
	}

	public static function getAllByProductId($product_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id order by created_at desc";
		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());
	}

	public static function getAllByProductIdCutIdOficial($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";

		return Model::many($query[0],new OperationData());
	}

	public static function getAllProductsBySellId($sell_id){
		$sql = "select * from ".self::$tablename." where sell_id=$sell_id order by created_at desc";
		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}

	public static function getAllByProductIdCutIdYesF($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";
		return Model::many($query[0],new OperationData());

		return $array;
	}

	public static function getOutputQ($product_id,$cut_id){
		$q=0;
		$operations = self::getOutputByProductIdCutId($product_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;

		foreach($operations as $operation){

			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }

			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }

		}

		// print_r($data);

		return $q;

	}



	public static function getOutputQYesF($product_id){

		$q=0;

		$operations = self::getOutputByProductId($product_id);

		$input_id = OperationTypeData::getByName("entrada")->id;

		$output_id = OperationTypeData::getByName("salida")->id;

		foreach($operations as $operation){

			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }

			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }

		}

		// print_r($data);

		return $q;

	}



	public static function getInputQYesF($product_id){

		$q=0;

		$operations = self::getInputByProductId($product_id);

		$input_id = OperationTypeData::getByName("entrada")->id;

		foreach($operations as $operation){

			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }

		}

		// print_r($data);

		return $q;

	}



	public static function getOutputByProductIdCutId($product_id,$cut_id){

		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=2 order by created_at desc";

		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}



	public static function getOutputByProductId($product_id){

		$sql = "select * from ".self::$tablename." where product_id=$product_id and operation_type_id=2 order by created_at desc";

		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}



  ////////////////////////////////////////////////////////////////////

	public static function getInputQ($product_id,$cut_id){

		$q=0;

		return Model::many($query[0],new OperationData());

		$operations = self::getInputByProductId($product_id);

		$input_id = OperationTypeData::getByName("entrada")->id;

		$output_id = OperationTypeData::getByName("salida")->id;

		foreach($operations as $operation){

			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }

			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }

		}

		// print_r($data);

		return $q;

	}



	public static function getInputByProductIdCutId($product_id,$cut_id){

		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=1 order by created_at desc";

		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}



	public static function getInputByProductId($product_id){

		$sql = "select * from ".self::$tablename." where product_id=$product_id and operation_type_id=1 order by created_at desc";

		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}



	public static function getInputByProductIdCutIdYesF($product_id,$cut_id){

		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=1 order by created_at desc";

		$query = Executor::doit($sql);

		return Model::many($query[0],new OperationData());

	}

  ////////////////////////////////////////////////////////////////////////////

}

