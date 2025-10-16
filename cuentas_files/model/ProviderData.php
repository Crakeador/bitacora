<?php
class ProviderData {
	public static $tablename = "proveedor";

	public function __construct(){
		$this->ruc = "";
		$this->tipo = "";
		$this->nombre = "";
		$this->descripcion = "";
		$this->contacto = "";
		$this->cargo = "";
		$this->email = "";
		$this->telefono1 = "";
		$this->telefono2 = "";
		$this->telefonofac1 = "";
		$this->telefonofac2 = "";
		$this->direccion = "";
		$this->observacion = "";
		$this->created_at = "NOW()";
	}

	public function add_provider(){
		$sql = "insert into ".self::$tablename." (ruc, tipo, nombre, descripcion, contacto, cargo, email, telefono1, telefono2, telefonofac1, telefonofac2, direccion, observacion, is_active, created_at) ";
		$sql .= "value (\"$this->ruc\", $this->tipo, \"$this->nombre\", \"$this->descripcion\", \"$this->contacto\", \"$this->cargo\", \"$this->email\", \"$this->telefono1\", \"$this->telefono2\", \"$this->telefonofac1\", \"$this->telefonofac2\", \"$this->direccion\", \"$this->observacion\", 1, $this->created_at)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function update_provider(){
		$sql = "update ".self::$tablename." set ruc=\"$this->ruc\", tipo=\"$this->tipo\", nombre=\"$this->nombre\", descripcion=\"$this->descripcion\", contacto=\"$this->contacto\", cargo=\"$this->cargo\", email=\"$this->email\", ";
		$sql .= "telefono1=\"$this->telefono1\", telefono2=\"$this->telefono2\", telefonofac1=\"$this->telefonofac1\", telefonofac1=\"$this->telefonofac1\", direccion=\"$this->direccion\", observacion=\"$this->observacion\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProviderData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->ruc = $r['ruc'];
			$data->nombre = $r['nombre'];
			$data->tipo = $r['tipo'];
			$data->contacto = $r['contacto'];
			$data->cargo = $r['cargo'];
			$data->email = $r['email'];
			$data->telefono1 = $r['telefono1'];
			$data->telefono2 = $r['telefono2'];
			$data->telefonofac1 = $r['telefonofac1'];
			$data->telefonofac2 = $r['telefonofac2'];
			$data->direccion = $r['direccion'];
			$data->descripcion = $r['descripcion'];
			$data->observacion = $r['observacion'];
			$data->is_active = $r['is_active'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->username = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->lastname = $r['lastname'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['address1'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

	public static function getProviders(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->ruc = $r['ruc'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->contacto = $r['contacto'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->telefono1 = $r['telefono1'];
			$array[$cnt]->telefono2 = $r['telefono2'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->is_active = $r['is_active'];
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
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->mail = $r['mail'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
}
?>
