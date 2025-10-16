<?php
// Clase de la tabla de Productos
class ProductData {
	public static $tablename = "product";

	public function __construct(){
        $this->barcode = "";
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "";
        $this->category_id = "";
		$this->inventary_min = "";
		$this->description = "";
		$this->is_active = "1";
		$this->created_at = "NOW()";
	}

	public function getCategory() { return CategoryData::getById($this->category_id); }
	public function getOperation(){ return OperationData::getByIdProduct($this->id); }
	public function getTotal()    { return OperationData::getQYesF($this->id); }

	public function seriales(){
		$sql = "insert into seriales (idproduct, description, fecha, estado, serial, numero, monto, usuario_log, created_at, ip) ";
		$sql .= "value (\"$this->idproduct\", \"$this->description\", \"$this->fecha\", \"$this->estado\", \"$this->serial\", \"$this->numero\", $this->monto, \"".$_SESSION['user_name']."\", $this->created_at, \"".$_SESSION['ip']."\")";
		return Executor::doit($sql);
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idcompany, barcode,name,description,price_in,price_out,user_id,presentation,unit,category_id,inventary_min,created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->barcode\",\"$this->name\",\"$this->description\",\"$this->price_in\",\"$this->price_out\",$this->user_id,\"$this->presentation\",\"$this->unit\",$this->category_id,$this->inventary_min,NOW())";
		return Executor::doit($sql);
	}

	public function add_with_image(){
		$sql = "insert into ".self::$tablename." (idcompany, barcode, image, name, description, price_in, price_out, user_id, presentation,unit,category_id,inventary_min) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->barcode\",\"$this->image\",\"$this->name\",\"$this->description\",\"$this->price_in\",\"$this->price_out\",$this->user_id,\"$this->presentation\",\"$this->unit\",$this->category_id,$this->inventary_min)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set is_active=0 where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set barcode=\"$this->barcode\",name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\",category_id=$this->category_id,inventary_min=\"$this->inventary_min\",description=\"$this->description\",is_active=\"$this->is_active\" where id=$this->id";
		Executor::doit($sql);
	}

	public function del_category(){
		$sql = "update ".self::$tablename." set category_id=NULL where id=$this->id";
		Executor::doit($sql);
	}

	public function update_image(){ 
		$sql = "update ".self::$tablename." set image=\"$this->image\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ProductData());
	}

	public static function getSerial($id){
		$sql = "select A.* from seriales A
				 where A.idproduct = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getCategoria($tipo){
		$sql = "SELECT A.* FROM product A, category B 
				 WHERE A.category_id = B.id AND B.id = $tipo AND A.idcompany = ".$_SESSION['id_company']." AND A.is_active = 1 ORDER BY barcode";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getProduct($tipo){
		$sql = "select A.* from product A, category B 
				 where A.category_id = B.id AND B.tipo = $tipo AND A.idcompany = ".$_SESSION['id_company']." order by barcode";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where idcompany = ".$_SESSION['id_company']." order by barcode";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}
			
	public static function getAgente(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE category_id = 2 AND idcompany = ".$_SESSION['id_company']." order by barcode";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->inventary_min = $r['inventary_min'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getPuesto(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE category_id IN (4, 6, 12) AND idcompany = ".$_SESSION['id_company']." order by barcode";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->inventary_min = $r['inventary_min'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getTodos(){
		$sql = "SELECT A.*, B.name AS categoria FROM product A, category B WHERE B.id = A.category_id AND A.idcompany = ".$_SESSION['id_company']." AND A.is_active = 1 ORDER BY barcode"; 
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->barcode = $r['barcode'];
			$array[$cnt]->image = $r['image'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->price_in = $r['price_in'];
			$array[$cnt]->price_out = $r['price_out'];
			$array[$cnt]->unit = $r['unit'];
			$array[$cnt]->presentation = $r['presentation'];
			$array[$cnt]->category_id = $r['category_id'];
			$array[$cnt]->inventary_min = $r['inventary_min'];
			$array[$cnt]->description = $r['description'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$array[$cnt]->categoria = $r['categoria'];
			$cnt++;
		}
		return $array;
	}

	public static function getByIdProduct($id){
		$con = Database::getCon();
		$sql = "SELECT * FROM operation A, product B WHERE A.id = $id and A.product_id = B.id";
		$query = $con->query($sql);

		$found = null;
		$data = new BoxData();
		while($r = $query->fetch_array()){
			$data->id = $r[0];
			$data->producto = $r['name'];
			$data->q = $r[2];
			$data->serial = $r['serial'];
			$data->idproducto = $r['product_id'];
			$data->image = $r['image'];
			$data->estado = $r['estado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where barcode like '%$p%' or name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}

	public static function getAllByCategoryId($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ProductData());
	}
		
	public static function getAllSerial($id){
		$sql = "select * from seriales where idproduct=$id";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new ProductData());
	}
}
