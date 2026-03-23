<?php
class UserData {
	public static $tablename = "user";

	public function __construct(){
		$this->idcompany = 1;
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into user (idcompany, idrol, iddepartamento, name, lastname, username, email, image, is_admin, password, created_at) ";
		$sql .= "value (\"$this->idcompany\", \"$this->idrol\", \"$this->iddepartamento\", \"$this->name\", \"$this->lastname\", \"$this->username\", \"$this->email\", \"$this->image\", \"$this->is_admin\", \"$this->password\", $this->created_at)";
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
		$sql = "update ".self::$tablename." set name=\"$this->name\",email=\"$this->email\",username=\"$this->username\",lastname=\"$this->lastname\",idrol=\"$this->idrol\",iddepartamento=\"$this->iddepartamento\",image=\"$this->image\",is_active=\"$this->is_active\",is_admin=\"$this->is_admin\" where id=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function update_user($id){
		$sql = "UPDATE ".self::$tablename." SET ingresos=ingresos+1, ultima_session=NOW() WHERE id=$id"; 
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());

	}

	public static function getByMail($mail){
		$sql = "select * from ".self::$tablename." where email=\"$mail\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new UserData());

	}

	public static function getTipo($tipo){
		if($tipo == 0) $valor = "WHERE is_admin = 0"; else $valor = "";
		$sql = "select * from ".self::$tablename." ".$valor; 
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
	
	public static function getEstado($estado){
		$sql = "SELECT B.nombre, B.descripcion, C.name AS departamento, A.* FROM user A
             LEFT JOIN rol B ON A.idrol = B.id
             LEFT JOIN departamento C ON A.iddepartamento = C.id
                 WHERE A.idcompany = ".$_SESSION['id_company']." AND A.is_active = $estado
			  ORDER BY A.iddepartamento DESC";
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}
	
	public static function getAll(){
		$sql = "SELECT B.nombre, B.descripcion, C.name AS departamento, A.* FROM user A
             LEFT JOIN rol B ON A.idrol = B.id
             LEFT JOIN departamento C ON A.iddepartamento = C.id
                 WHERE A.idcompany = ".$_SESSION['id_company']; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}

	public static function getAllTipo(){
		$sql = "SELECT D.idcard, E.idtipo, D.idcargo, B.nombre, C.name AS departamento, A.* FROM user A, rol B, departamento C, person D, cargo E
                 WHERE A.idrol = B.id AND A.iddepartamento = C.id AND A.idperson = D.id AND E.id = D.idcargo AND A.idcompany = 1 AND
                 idtipo = 1
                 ORDER BY idcargo";
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);

		return Model::many($query[0],new UserData());
	}

	public static function getCampo($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m LIKE '%$n%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new UserData());
	}
}