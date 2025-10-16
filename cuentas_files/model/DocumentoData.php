<?php
//Tipo de Documentos relativos a los guardias
class DocumentoData {
	public static $tablename = "tipo_documento";

	public static function ServicioData(){
		$this->name = "";
		$this->price_in = "";
		$this->price_out = "";
		$this->unit = "";
		$this->user_id = "";
		$this->presentation = "0";
		$this->created_at = "NOW()";
	}

	public function __construct(){		
		$this->id = "";
		$this->tipo_documen = "";
		$this->idperson = "";
		$this->responsable = "";		
		$this->fecha_doc = "";
		$this->observacion = "";
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public static function getCategory(){ return CategoryData::getById($this->category_id); }
	public static function getOperation(){ return OperationData::getByIdProduct($this->id); }
	public static function getTotal(){ return OperationData::getQYesF($this->id); }

	public static function add(){
		$sql = "insert into documento (company, tipo_documen, idperson, responsable, observacion, fecha_doc) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->tipo_documen\", \"$this->idperson\", \"".$_SESSION['user_name']."\", \"$this->observacion\", \"$this->fecha_doc\")"; 
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public static function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

    // partiendo de que ya tenemos creado un objecto ProductData previamente utilizamos el contexto
	public static function update(){
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

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new DocumentoData());
	}

	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where barcode like '%$p%' or name like '%$p%' or id like '%$p%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CuentasData());
	}

	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CuentasData());
	}

	public static function getAllByCategoryId($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new CuentasData());
	}
}

