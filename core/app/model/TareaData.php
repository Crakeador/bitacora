<?php
// Clases de Tarea 

class TareaData {
	public static $tablename = "tarea";

	public function __construct(){
		$this->title = "";
		$this->description = "";
		$this->due_date = "";
		$this->user_id = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (title, description, due_date, user_id, created_at) ";
		$sql .= "value \"$this->title\", \"$this->description\", \"$this->due_date\", \"$this->user_id\", $this->created_at)";
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

	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",description=\"$this->description\",due_date=\"$this->due_date\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new TareaData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new TareaData());
	}

	public static function getAllByUserId($id){
		$sql = "select * from ".self::$tablename." where user_id=$id";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TareaData());
	}

}