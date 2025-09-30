<?php
// Clases de Usuario 

class UserData {
	public static $tablename = "user";

	public function __construct(){
		$this->idcompany = "";
		$this->idlocalidad = "";
		$this->iddepartamento = "";
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->idrol = "";
		$this->created_at = "NOW()";
	}
	 
	public function add(){
		$sql = "insert into user (idcompany, idlocalidad, name, lastname, username, email, idrol, iddepartamento, is_admin, password, image, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", \"$this->idlocalidad\", \"$this->name\", \"$this->lastname\", \"$this->username\", \"$this->email\", \"$this->idrol\", \"$this->iddepartamento\", \"$this->is_admin\", \"$this->password\", \"$this->image\", $this->created_at)";
		Executor::doit($sql);
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
		$sql = "UPDATE ".self::$tablename." SET idlocalidad=\"$this->idlocalidad\", name=\"$this->name\", lastname=\"$this->lastname\", idrol=\"$this->idrol\", iddepartamento=\"$this->iddepartamento\", email=\"$this->email\", username=\"$this->username\", is_active=\"$this->is_active\", is_admin=\"$this->is_admin\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public static function update_user($fecha){
		$sql = "UPDATE ".self::$tablename." SET ultima_session=\"$fecha\" WHERE id=".$_SESSION["user_id"];
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "UPDATE ".self::$tablename." SET password=\"$this->password\" WHERE id=$this->id";
		Executor::doit($sql);
	}

	public function update_activo($id){
		$sql = "UPDATE ".self::$tablename." SET is_active=0 WHERE id=$id";
		Executor::doit($sql);
	}
	
	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());
	}

	public static function getByMail($mail){
		$sql = "SELECT * FROM ".self::$tablename." WHERE email=\"$mail\"";
		$query = Executor::doit($sql);

		return Model::one($query[0],new UserData());
	}
	
	public static function getEstado($estado){
		$sql = "SELECT B.nombre, B.descripcion, C.description, A.* FROM user A
             LEFT JOIN rol B ON A.idrol = B.id
             LEFT JOIN departamento C ON A.iddepartamento = C.id
                 WHERE A.idcompany = ".$_SESSION['id_company']." AND A.is_active = $estado";
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}

	public static function getAll(){
		$sql = "SELECT B.nombre, B.descripcion, C.description, A.* FROM user A
             LEFT JOIN rol B ON A.idrol = B.id
             LEFT JOIN departamento C ON A.iddepartamento = C.id
                 WHERE A.idcompany = ".$_SESSION['id_company'];
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}

	public static function getCampo($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m LIKE '%$n%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
}

