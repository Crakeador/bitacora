<?php
// Clases utilizadas en la tabla de Personal 
class PersonData {
	public static $tablename = "person";

	public function __construct(){
		$this->id = "";
		$this->idlugar = "";
		$this->idperson = "";
		$this->idcard = "";
		$this->name = "";
		$this->latitude = "";
		$this->longitude = "";
		$this->mensaje = "";
		$this->conyuge = "";
		$this->embarazada = "";
		$this->cargo = 0;
		$this->sueldo = 0;	
		$this->dias = 0;		
		$this->hijos = "";
		$this->region = "2";
		$this->idcargo = "";
		$this->tipo_sangre = "";
		$this->tipo_contrato = "";
		$this->tiene_carnet = "";
		$this->reentrenamiento = "";
		$this->startwork = "";
		$this->endwork = "";
		$this->observacion = "";
		$this->email = "";
		$this->image = "";
		$this->votacion = "";
		$this->vivienda = "";
		$this->password = "";
		$this->firma = "";
		$this->total = "";
		$this->acumula3 = 0;	
		$this->acumula4 = 0;
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	// Funcion de asignacion atutomatica a la Oficina Principal 
	public function addId($id, $person){
		$sql = "INSERT INTO personpuestos (idservicio, idperson, is_active) ";
		$sql .= "value (\"$id\", \"$person\", 1)";
		return Executor::doit($sql);
	}

	public function addDatos($idperson, $despido, $cargo, $tipo_contrato, $hijos, $sueldo, $startwork, $endwork){
		$sql = "INSERT INTO persond(idperson, tipo_despido, cargo, tipo_contrato, hijos, sueldo, startwork, endwork, estado, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES ($idperson, $despido, \"$cargo\", \"$tipo_contrato\", $hijos, $sueldo, \"$startwork\", \"$endwork\", \"E\", 1, NOW(), \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")"; 
		Executor::doit($sql);
	}

	public function addFinal($idperson, $despido, $cargo, $tipo_contrato, $hijos, $sueldo, $startwork, $endwork, $observacion){
		$sql = "INSERT INTO persond(idperson, tipo_despido, cargo, tipo_contrato, hijos, sueldo, startwork, endwork, estado, observacion, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES ($idperson, $despido, \"$cargo\", \"$tipo_contrato\", $hijos, $sueldo, \"$startwork\", \"$endwork\", \"L\", \"$observacion\", 1, NOW(), \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")"; 
		Executor::doit($sql);
	}
	
	public function addPersonas(){
		$sql = "INSERT INTO persond(idperson, persona, ocupacion, tiempo_conocido, conocido, familia, relaciones, describa, empresa, laboral, cargo, 
		telefono, desde, hasta, desempeno, tiempo, jefe, relacion, motivo, penales, judicial, demanda, fiscalia, verificado, is_active, created_at, 
		usuario_log, ip)";
		$sql .= " VALUES ($idperson, \"$this->persona\", \"$this->ocupacion\", \"$this->tiempo_conocido\", \"$this->conocido\", \"$this->familia\", 
		\"$this->relaciones\", \"$this->describa\", \"$this->empresa\", \"$this->laboral\", \"$this->cargo\", 
		\"$this->telefono\", \"$this->desde\", \"$this->hasta\", \"$this->desempeno\", \"$this->tiempo\", 
		\"$this->jefe\", \"$this->relacion\", \"$this->motivo\", \"$this->penales\", \"$this->judicial\", 
		\"$this->demanda\", \"$this->fiscalia\", \"$this->verificado\", 1, NOW(), \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")"; 
		Executor::doit($sql);
	}
	
	public function addVac(){
		$sql = "INSERT INTO persond(idperson, region, cargo, tipo_contrato, hijos, sueldo, startwork, endwork, dias, observacion, tipo_pago, acumula, estado, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES ($this->idperson, 2, 7, \"Vacaciones del Guardia\", 0, $this->sueldo, \"$this->startwork\", \"$this->endwork\", $this->dias, \"$this->observacion\", \"0\", \"0\", \"V\", \"1\", NOW(), \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")"; 
		Executor::doit($sql);
	}

	public function addLiq($id){ 
		$sql = "INSERT INTO persond(idperson, region, cargo, tipo_contrato, hijos, sueldo, startwork, endwork, tipo_pago, acumula, estado, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES (".$id.", \"$this->region\", \"$this->cargo\", \"$this->tipo_contrato\", $this->hijos, $this->sueldo, \"$this->startwork\", \"$this->endwork\", \"$this->tipo_pago\", \"$this->acumula\", \"I\", \"$this->is_active\", $this->created_at, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")";
		Executor::doit($sql);
	}

	public function addAMD(){
		$sql = "INSERT INTO person(idcompany, idcard, name, cargo, startwork, endwork, licencia, tipo_licencia, copia_licencia, ";
		$sql .= "tiene_carnet, fechanacimiento, copiacedula, phone1, phone2, genero, sueldo, tipo_contrato, region, ";
		$sql .= "bachiller, especializacion1, esc_tecnico, especializacion2, computadora, celulartactil, curso_realizado, certificados, ";
		$sql .= "tipo_sangre, altura, certificadosangre, recibe, direccion, sector, referencia, croquis, planilla, contrato, banco, tipo, cuenta, tipo_pago, recibo, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->idcard\", \"$this->name\", \"$this->cargo\", \"$this->startwork\", \"$this->endwork\", ";
		$sql .= "\"$this->licencia\", \"$this->tipo_licencia\", \"$this->copia_licencia\", 1, \"$this->tiene_carnet\", \"$this->fechanacimiento\", \"$this->copiacedula\", \"$this->phone1\", ";
		$sql .= "\"$this->phone2\", \"$this->genero\", \"$this->sueldo\", \"$this->tipo_contrato\", \"$this->region\", \"$this->bachiller\", \"$this->especializacion1\", \"$this->esc_tecnico\", ";
		$sql .= "\"$this->especializacion2\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", ";
		$sql .= "\"$this->tipo_sangre\", \"$this->altura\", \"$this->certificadosangre\", \"$this->recibe\", \"$this->direccion\", ";
		$sql .= "\"$this->sector\", \"$this->referencia\", \"$this->croquis\", \"$this->planilla\", \"$this->contrato\", \"$this->banco\", \"$this->tipo\", \"$this->cuenta\", \"$this->tipo_pago\", \"$this->recibo\", ";
		$sql .= "\"$this->is_active\", $this->created_at, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")";
		Executor::doit($sql); 
	}

	public function addIMG(){
		$sql = "INSERT INTO person(idcompany, image, idcard, name, cargo, startwork, endwork, licencia, tipo_licencia, copia_licencia, ";
		$sql .= "tiene_carnet, fechanacimiento, copiacedula, phone1, phone2, genero, sueldo, tipo_contrato, ";
		$sql .= "bachiller, especializacion1, esc_tecnico, especializacion2, computadora, celulartactil, curso_realizado, certificados, ";
		$sql .= "tipo_sangre, altura, certificadosangre, recibe, direccion, sector, referencia, croquis, planilla, contrato, banco, tipo, cuenta, tipo_pago, recibo, is_active, created_at, usuario_log, ip)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->image\", \"$this->idcard\", \"$this->name\", \"$this->cargo\", \"$this->startwork\", \"$this->endwork\", ";
		$sql .= "\"$this->licencia\", \"$this->tipo_licencia\", \"$this->copia_licencia\", 1, \"$this->tiene_carnet\", \"$this->fechanacimiento\", \"$this->copiacedula\", \"$this->phone1\", ";
		$sql .= "\"$this->phone2\", \"$this->genero\", \"$this->sueldo\", \"$this->tipo_contrato\", \"$this->bachiller\", \"$this->especializacion1\", \"$this->esc_tecnico\", ";
		$sql .= "\"$this->especializacion2\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", ";
		$sql .= "\"$this->tipo_sangre\", \"$this->altura\", \"$this->certificadosangre\", \"$this->recibe\", \"$this->direccion\", ";
		$sql .= "\"$this->sector\", \"$this->referencia\", \"$this->croquis\", \"$this->planilla\", \"$this->contrato\", \"$this->banco\", \"$this->tipo\", \"$this->cuenta\", \"$this->tipo_pago\", \"$this->recibo\", ";
		$sql .= "\"$this->is_active\", $this->created_at, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")"; 
		Executor::doit($sql);
	}

	public function add(){
		$sql = "INSERT INTO person(idcompany, idcard, name, cargo, startwork, endwork, licencia, tipo_licencia, copia_licencia, ";
		$sql .= "inscrito_curso, tiene_carnet, copia_ministerio, premilitar, militar, carrera_militar, ";
		$sql .= "copia_militar, uso_arma, nombre_curso, copia_curso, fechanacimiento, copiacedula, phone1, phone2, genero, sueldo, tipo_contrato, ";
		$sql .= "bachiller, especializacion1, esc_tecnico, especializacion2, computadora, celulartactil, curso_realizado, certificados, ";
		$sql .= "tipo_sangre, altura, certificadosangre, recibe, direccion, decimo, acumula3, acumula4, sector, referencia, croquis, planilla, contrato, banco, tipo, cuenta, tipo_pago, recibo, is_active, usuario_log, ip, created_at)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->idcard\", \"$this->name\", \"$this->cargo\", \"$this->startwork\", \"$this->endwork\", ";
		$sql .= "\"$this->licencia\", \"$this->tipo_licencia\", \"$this->copia_licencia\", 1, \"$this->inscrito_curso\", \"$this->tiene_carnet\", \"$this->copia_ministerio\", ";
		$sql .= "\"$this->premilitar\", \"$this->militar\", \"$this->carrera_militar\", \"$this->copia_militar\", ";
		$sql .= "\"$this->uso_arma\", \"$this->nombre_curso\", \"$this->copia_curso\", \"$this->fechanacimiento\", \"$this->copiacedula\", \"$this->phone1\", ";
		$sql .= "\"$this->phone2\", \"$this->genero\", \"$this->sueldo\", \"$this->tipo_contrato\", \"$this->bachiller\", \"$this->especializacion1\", \"$this->esc_tecnico\", ";
		$sql .= "\"$this->especializacion2\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", ";
		$sql .= "\"$this->tipo_sangre\", \"$this->altura\", \"$this->certificadosangre\", \"$this->recibe\", \"$this->direccion\", \"$this->acumular_fondosreserva\", \"$this->acumula3\", \"$this->acumula4\", ";
		$sql .= "\"$this->sector\", \"$this->referencia\", \"$this->croquis\", \"$this->planilla\", \"$this->contrato\", \"$this->banco\", \"$this->tipo\", \"$this->cuenta\", \"$this->tipo_pago\", \"$this->recibo\", ";
		$sql .= "\"$this->is_active\", \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; 
		Executor::doit($sql);
	}

	public function addFisico(){
		$sql = "INSERT INTO person(idcompany, idcard, name, cargo, startwork, endwork, licencia, tipo_licencia, copia_licencia, ";
		$sql .= "inscrito_curso, tiene_carnet, copia_ministerio, premilitar, militar, carrera_militar, ";
		$sql .= "copia_militar, uso_arma, nombre_curso, copia_curso, fechanacimiento, copiacedula, phone1, phone2, genero, sueldo, tipo_contrato, ";
		$sql .= "bachiller, especializacion1, esc_tecnico, especializacion2, computadora, celulartactil, curso_realizado, certificados, ";
		$sql .= "tipo_sangre, altura, certificadosangre, recibe, direccion, decimo, acumula3, acumula4, sector, referencia, croquis, planilla, contrato, banco, tipo, cuenta, tipo_pago, recibo, is_active, usuario_log, ip, created_at)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->idcard\", \"$this->name\", \"$this->cargo\", \"$this->startwork\", \"$this->endwork\", ";
		$sql .= "\"$this->licencia\", \"$this->tipo_licencia\", \"$this->copia_licencia\", 1, \"$this->inscrito_curso\", \"$this->tiene_carnet\", \"$this->copia_ministerio\", ";
		$sql .= "\"$this->premilitar\", \"$this->militar\", \"$this->carrera_militar\", \"$this->copia_militar\", ";
		$sql .= "\"$this->uso_arma\", \"$this->nombre_curso\", \"$this->copia_curso\", \"$this->fechanacimiento\", \"$this->copiacedula\", \"$this->phone1\", ";
		$sql .= "\"$this->phone2\", \"$this->genero\", \"$this->sueldo\", \"$this->tipo_contrato\", \"$this->bachiller\", \"$this->especializacion1\", \"$this->esc_tecnico\", ";
		$sql .= "\"$this->especializacion2\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", ";
		$sql .= "\"$this->tipo_sangre\", \"$this->altura\", \"$this->certificadosangre\", \"$this->recibe\", \"$this->direccion\", \"$this->acumular_fondosreserva\", \"$this->acumula3\", \"$this->acumula4\", ";
		$sql .= "\"$this->sector\", \"$this->referencia\", \"$this->croquis\", \"$this->planilla\", \"$this->contrato\", \"$this->banco\", \"$this->tipo\", \"$this->cuenta\", \"$this->tipo_pago\", \"$this->recibo\", ";
		$sql .= "\"$this->is_active\", \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; 
		Executor::doit($sql);
	}
	
	public function add_aspirante(){
		$sql = "INSERT INTO person(idcompany, idcard, name, latitude, longitude, mensaje, cargo, email, carnet, conyuge, embarazada, estado_civil, ";
		$sql .= "fechanacimiento, phone1, phone2, phone3, genero, image, cedula1, cedula2, votacion, tipo_sangre, ";
		$sql .= "bachiller, computadora, celulartactil, curso_realizado, certificados, altura, ";
		$sql .= "idlugar, archivo, direccion, sector, referencia, tiene_carnet, reentrenamiento, vivienda, referencia1, referencia2, referencia3, is_active, usuario_log, ip, created_at)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->idcard\", \"$this->name\", \"$this->latitude\", \"$this->longitude\", \"$this->mensaje\", \"$this->cargo\", \"$this->email\", \"$this->carnet\", \"$this->conyuge\", $this->embarazada, $this->estado_civil, ";
		$sql .= "1, \"$this->fechanacimiento\", \"$this->phone1\", \"$this->phone2\", \"$this->phone3\", \"$this->genero\", \"$this->image\", \"$this->cedula1\", \"$this->cedula2\", \"$this->votacion\", $this->tipo_sangre, ";
		$sql .= "\"$this->bachiller\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", \"$this->altura\", ";
		$sql .= "$this->idlugar, \"$this->archivo\", \"$this->direccion\", \"$this->sector\", \"$this->referencia\", \"$this->tiene_carnet\", \"$this->reentrenamiento\", \"$this->vivienda\",  \"$this->referencia1\",  \"$this->referencia2\",  \"$this->referencia3\", \"$this->is_active\", \"$this->usuario_log\", \"".$_SESSION['ip']."\", $this->created_at)";
        $query = Executor::doit($sql); 
		return $query;
	}
	
	public function upd_aspirante(){
		$sql = "UPDATE person SET name=\"$this->name\", conyuge=\"$this->conyuge\", embarazada=\"$this->embarazada\", tipo_sangre=\"$this->tipo_sangre\", email=\"$this->email\", cargo=\"$this->cargo\", sector=\"$this->sector\", referencia=\"$this->referencia\", estado_civil=\"$this->estado_civil\", ";
		                 $sql .= "tiene_carnet=\"$this->tiene_carnet\", reentrenamiento=\"$this->reentrenamiento\", monto=\"$this->monto\", hijos=\"$this->hijos\", fechanacimiento=\"$this->fechanacimiento\", altura=\"$this->altura\", ";
		                 $sql .= "copiacedula=\"$this->copiacedula\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", phone3=\"$this->phone3\", genero=\"$this->genero\", bachiller=\"$this->bachiller\", esc_tecnico=\"$this->esc_tecnico\", ";
	                  	 $sql .= "computadora=\"$this->computadora\", celulartactil=\"$this->celulartactil\", curso_realizado=\"$this->curso_realizado\", certificados=\"$this->certificados\", idlugar=\"$this->idlugar\", direccion=\"$this->direccion\", ";
		                 $sql .= "sector=\"$this->sector\", referencia=\"$this->referencia\", referencia1=\"$this->referencia1\", referencia2=\"$this->referencia2\", referencia3=\"$this->referencia3\", usuario_log=\"$this->usuario_log\" ";
		           $sql .= "WHERE id=$this->id"; 
        $query = Executor::doit($sql); 
		return $query;
	}

	public function upd_campo($campo, $valor){ 
		$sql = "update ".self::$tablename." set ".$campo."=\"".$valor."\" where id=$this->id"; 
		Executor::doit($sql);
	}
	
	public function add_backup(){
		$sql = "INSERT INTO person(idcompany, idcard, name, cargo, hijos, monto, ";
		$sql .= "fechanacimiento, phone1, phone2, genero, firma, ";
		$sql .= "bachiller, especializacion1, esc_tecnico, especializacion2, computadora, celulartactil, curso_realizado, certificados, ";
		$sql .= "direccion, sector, referencia, tiene_carnet, is_active, usuario_log, ip, created_at)";
		$sql .= " VALUES (".$_SESSION['id_company'].", \"$this->idcard\", \"$this->name\", \"$this->cargo\", \"$this->hijos\", \"$this->monto\", ";
		$sql .= "1, \"$this->fechanacimiento\", \"$this->phone1\", \"$this->phone2\", \"$this->genero\", \"$this->firma\", ";
		$sql .= "\"$this->bachiller\", \"$this->especializacion1\", \"$this->esc_tecnico\", \"$this->especializacion2\", \"$this->computadora\", \"$this->celulartactil\", \"$this->curso_realizado\", \"$this->certificados\", ";
		$sql .= "\"$this->direccion\", \"$this->sector\", \"$this->refrencia\", \"$this->tiene_carnet\", \"$this->is_active\", \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)";
		Executor::doit($sql);
	}

	public function add_IMGAge(){
		$sql = "insert into person (idcompany, idlocalidad, image, idcard, name, phone1, cargo, genero, tipo_sangre, is_active, usuario_log, ip, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", ".$_SESSION['id_localidad'].", \"$this->image\", \"$this->idcard\", \"$this->name\", \"$this->phone1\", ";
		$sql .= "$this->cargo, $this->genero, $this->tipo_sangre, 1, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; 

		Executor::doit($sql);
	}

	public function add_agente(){
		$sql = "insert into person (idcompany, idlocalidad, idcard, name, phone1, cargo, genero, tipo_sangre, is_active, usuario_log, ip, created_at) ";
		$sql .= "value (".$_SESSION['id_company'].", ".$_SESSION['id_localidad'].", \"$this->idcard\", \"$this->name\", \"$this->phone1\", ";
		$sql .= "$this->cargo, $this->genero, $this->tipo_sangre, 1, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\", $this->created_at)"; 

		Executor::doit($sql);
	}

	public function add_client(){
		$sql = "insert into person (name,address1,email,phone1,kind,created_at,usuario_log, ip) ";
		$sql .= "value (\"$this->name\",\"$this->address1\",\"$this->email\",\"$this->phone1\",1,$this->created_at, \"".$_SESSION['user_name']."\", \"".$_SESSION['ip']."\")";

		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){ 
		$sql = "update ".self::$tablename." set is_active=0 where id=$this->id";
		Executor::doit($sql);
	}

	public function updateIMG(){
		$sql = "UPDATE person SET idcard=\"$this->idcard\", cargo=\"$this->cargo\", name=\"$this->name\", cargo=\"$this->cargo\", startwork=\"$this->startwork\", endwork=\"$this->endwork\", ";
		$sql .= "tiene_carnet=\"$this->tiene_carnet\", hijos=\"$this->hijos\", tipo_contrato=\"$this->tipo_contrato\", sueldo=\"$this->sueldo\", image=\"$this->image\", ";
		$sql .= "licencia=\"$this->licencia\", tipo_licencia=\"$this->tipo_licencia\", copia_licencia=\"$this->copia_licencia\", ";
		$sql .= "fechanacimiento=\"$this->fechanacimiento\", ";
		$sql .= "copiacedula=\"$this->copiacedula\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", genero=\"$this->genero\", bachiller=\"$this->bachiller\", especializacion1=\"$this->especializacion1\", esc_tecnico=\"$this->esc_tecnico\", especializacion2=\"$this->especializacion2\", ";
		$sql .= "computadora=\"$this->computadora\", celulartactil=\"$this->celulartactil\", curso_realizado=\"$this->curso_realizado\", certificados=\"$this->certificados\", tipo_sangre=\"$this->tipo_sangre\", certificadosangre=\"$this->certificadosangre\", altura=\"$this->altura\", ";
		$sql .= "recibe=\"$this->recibe\", decimo=\"$this->acumular_fondosreserva\", acumula3=\"$this->acumula3\", acumula4=\"$this->acumula4\", ";
		$sql .= "direccion=\"$this->direccion\", sector=\"$this->sector\", croquis=\"$this->croquis\", planilla=\"$this->planilla\", contrato=\"$this->contrato\", banco=\"$this->banco\", tipo=\"$this->tipo\", cuenta=\"$this->cuenta\", tipo_pago=\"$this->tipo_pago\", ";
		$sql .= "is_active=\"$this->is_active\", created_at=$this->created_at WHERE id=$this->id"; 

		Executor::doit($sql); 
	}

	public function updateAMD(){
		$sql = "UPDATE person SET idcard=\"$this->idcard\", cargo=\"$this->cargo\", name=\"$this->name\", cargo=\"$this->cargo\", startwork=\"$this->startwork\", endwork=\"$this->endwork\", ";
		$sql .= "hijos=\"$this->hijos\", tipo_contrato=\"$this->tipo_contrato\", sueldo=$this->sueldo, region=\"$this->region\", ";
		$sql .= "fechanacimiento=\"$this->fechanacimiento\", hadicional=\"$this->hadicional\", hnocturna=\"$this->hnocturna\", ";
		$sql .= "copiacedula=\"$this->copiacedula\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", genero=\"$this->genero\", bachiller=\"$this->bachiller\", especializacion1=\"$this->especializacion1\", esc_tecnico=\"$this->esc_tecnico\", especializacion2=\"$this->especializacion2\", ";
		$sql .= "computadora=\"$this->computadora\", celulartactil=\"$this->celulartactil\", curso_realizado=\"$this->curso_realizado\", certificados=\"$this->certificados\", tipo_sangre=\"$this->tipo_sangre\", ";
		$sql .= "recibe=\"$this->recibe\", decimo=\"$this->decimo\", acumula3=\"$this->acumula3\", acumula4=\"$this->acumula4\", ";
		$sql .= "direccion=\"$this->direccion\", sector=\"$this->sector\", croquis=\"$this->croquis\", planilla=\"$this->planilla\", contrato=\"$this->contrato\", banco=\"$this->banco\", tipo=\"$this->tipo\", cuenta=\"$this->cuenta\", tipo_pago=\"$this->tipo_pago\", ";
		$sql .= "is_active=\"$this->is_active\", created_at=$this->created_at WHERE id=$this->id"; 
        
		Executor::doit($sql); 
	}

	public function update(){
		$sql = "UPDATE person SET idcard=\"$this->idcard\", cargo=\"$this->cargo\", name=\"$this->name\", cargo=\"$this->cargo\", startwork=\"$this->startwork\", endwork=\"$this->endwork\", ";
		$sql .= "inscrito_curso=\"$this->inscrito_curso\", tiene_carnet=\"$this->tiene_carnet\", copia_ministerio=\"$this->copia_ministerio\", hijos=\"$this->hijos\", ";
		$sql .= "premilitar=\"$this->premilitar\", militar=\"$this->militar\", carrera_militar=\"$this->carrera_militar\", copia_militar=\"$this->copia_militar\", uso_arma=\"$this->uso_arma\", nombre_curso=\"$this->nombre_curso\", copia_curso=\"$this->copia_curso\", ";
		$sql .= "licencia=\"$this->licencia\", tipo_licencia=\"$this->tipo_licencia\", copia_licencia=\"$this->copia_licencia\", ";
		$sql .= "fechanacimiento=\"$this->fechanacimiento\", ";
		$sql .= "copiacedula=\"$this->copiacedula\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", genero=\"$this->genero\", bachiller=\"$this->bachiller\", especializacion1=\"$this->especializacion1\", esc_tecnico=\"$this->esc_tecnico\", especializacion2=\"$this->especializacion2\", ";
		$sql .= "computadora=\"$this->computadora\", celulartactil=\"$this->celulartactil\", curso_realizado=\"$this->curso_realizado\", certificados=\"$this->certificados\", tipo_sangre=\"$this->certificados\", certificadosangre=\"$this->certificadosangre\", altura=\"$this->altura\", ";
		$sql .= "recibe=\"$this->recibe\", direccion=\"$this->direccion\", sector=\"$this->sector\", referencia=\"$this->referencia\", croquis=\"$this->croquis\", planilla=\"$this->planilla\", contrato=\"$this->contrato\", banco=\"$this->banco\", tipo=\"$this->tipo\", cuenta=\"$this->cuenta\", tipo_pago=\"$this->tipo_pago\", ";
		$sql .= "is_active=\"$this->is_active\", created_at=$this->created_at WHERE id=$this->id";

		Executor::doit($sql);
	}

	public function upd_backup(){
		$sql = "UPDATE person SET idcard=\"$this->idcard\", cargo=\"$this->cargo\", name=\"$this->name\", ";
		$sql .= "tiene_carnet=\"$this->tiene_carnet\", monto=\"$this->monto\", hijos=\"$this->hijos\", fechanacimiento=\"$this->fechanacimiento\", ";
		$sql .= "copiacedula=\"$this->copiacedula\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", genero=\"$this->genero\", bachiller=\"$this->bachiller\", especializacion1=\"$this->especializacion1\", esc_tecnico=\"$this->esc_tecnico\", especializacion2=\"$this->especializacion2\", ";
	    $sql .= "computadora=\"$this->computadora\", celulartactil=\"$this->celulartactil\", curso_realizado=\"$this->curso_realizado\", certificados=\"$this->certificados\", tipo_sangre=\"$this->tipo_sangre\", direccion=\"$this->direccion\", sector=\"$this->sector\", referencia=\"$this->referencia\", ";
		$sql .= "usuario_log=\"".$_SESSION['user_name']."\", is_active=\"$this->is_active\" WHERE id=$this->id"; 

		Executor::doit($sql);
	}

	public function update_vacacion(){ 
		$sql = "UPDATE persond SET tipo_despido=\"$this->tipo_despido\", dias=\"$this->dias\", sueldo=\"$this->sueldo\", startwork=\"$this->startwork\", endwork=\"$this->endwork\", observacion=\"$this->observacion\" where id=$this->id"; 
		Executor::doit($sql);
	}

	public function update_client(){
		$sql = "UPDATE ".self::$tablename." SET name=\"$this->name\",email=\"$this->email\",address1=\"$this->address1\",phone1=\"$this->phone1\" WHERE id=$this->id"; 
		Executor::doit($sql); 
	}

	public function update_telefono(){
		$sql = "UPDATE person SET tipo_sangre=\"$this->tipo_sangre\", phone1=\"$this->phone1\", phone2=\"$this->phone2\", phone3=\"$this->phone3\" WHERE id=$this->id"; 
		Executor::doit($sql);
	}
	
	public function update_datos($id, $despido, $fecha, $observacion){
		$sql = "UPDATE persond SET tipo_despido='$despido', endwork='$fecha', observacion='$observacion', estado='E' WHERE id=".$id; 
		Executor::doit($sql);
	}

	public function update_final($id, $fecha){
		$sql = "UPDATE person SET endwork='$fecha', is_active=0 WHERE id=".$id;
		Executor::doit($sql);
	}
	
	public function update_passwd(){
		$sql = "update ".self::$tablename." set password=\"$this->password\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getByIdDatos($id){
		$sql = "SELECT E.descripcion, A.id, A.idcard, A.name, A.cargo, B.description, A.startwork, A.endwork, A.sueldo 
		          FROM person A, cargo B, personpuestos D, puestos E
				 WHERE A.cargo = B.id AND D.idperson=A.id AND D.idservicio=E.id AND A.id=$id AND D.is_active=0";

		$query = Executor::doit($sql); 
		return Model::one($query[0],new PersonData());
	}
	
	public static function getByIdLiquidacion($id){		
		$sql = "SELECT C.observacion, C.tipo_despido, A.id, A.idcard, A.name, A.cargo, B.description, A.startwork, A.endwork, A.sueldo 
		          FROM person A, cargo B, persond C, personpuestos D, puestos E
				 WHERE A.cargo = B.id AND C.idperson=A.id AND D.idperson=A.id AND D.idservicio=E.id AND A.id=$id AND C.estado='L' AND D.is_active=0"; 
				 
		$sql = "SELECT A.id, A.observacion, A.tipo_despido, B.idcard, B.name, A.startwork, A.endwork, A.sueldo, A.idpuesto
                  FROM persond A, person B WHERE B.id=A.idperson AND A.idperson=$id AND A.estado='L'"; 
		$query = Executor::doit($sql); 
		return Model::one($query[0],new PersonData());
	}

	public static function getByIdVacacion($id){		
		$sql = "select C.id, C.idperson, C.observacion, C.sueldo, C.tipo_despido, C.dias, A.idcard, A.name, A.cargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.cargo = B.id AND A.id=$id AND C.estado='V'"; 

		$query = Executor::doit($sql); 
		return Model::one($query[0],new PersonData());
	}
	
	public static function getByIdTotales($id, $estado){		
		$sql = "SELECT sum(sueldo) AS total FROM persond WHERE idperson=$id AND estado='$estado'"; 

		$query = Executor::doit($sql); 
		return Model::one($query[0],new PersonData());
	}
	
	public static function getTrabajos($id){		
		$sql = "SELECT * FROM persont WHERE idperson=$id";

		$query = Executor::doit($sql); 
		return Model::many($query[0],new PersonData());
	}
	
	public static function getPersona($id){
		$sql = "SELECT A.id, A.idcard, A.name, A.sueldo, A.tipo_contrato, A.created_at, A.startwork, A.cargo, E.descripcion, B.description, A.hijos, A.cargo
		          FROM person A, cargo B, personpuestos D, puestos E
		         WHERE A.cargo = B.id AND D.idperson=A.id AND D.idservicio=E.id AND A.id=$id"; 

		$query = Executor::doit($sql);
		return Model::one($query[0],new PersonData());
	}

	public static function getByDate($numnes){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." AND MONTH(fechanacimiento)='".$numnes."' AND is_active=1";
		$query = Executor::doit($sql); 

		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->fechanacimiento = $r['fechanacimiento'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;
		}
		return $array;
	}

	public static function getTotal(){
		$sql = "SELECT id total FROM person ORDER BY id DESC LIMIT 1"; 
		$query = Executor::doit($sql);

		return Model::one($query[0],new PersonData());
	}

	public static function getCedula($n){
		$sql = "SELECT * FROM person WHERE idcard LIKE '".$n."'"; 
		$query = Executor::doit($sql);

		return Model::one($query[0],new PersonData());
	}
	
	public static function getLike($m, $n){
		$sql = "SELECT * FROM ".self::$tablename." WHERE $m LIKE '%$n%'";
		$query = Executor::doit($sql);

		return Model::one($query[0],new PersonData());
	}

	public static function getById($id){
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=$id"; 
		$query = Executor::doit($sql); 

		return Model::one($query[0],new PersonData());
	}

	public static function getByPerson($id){
		$sql = "SELECT * FROM personas WHERE idperson=$id"; 
		$query = Executor::doit($sql); 

		return Model::one($query[0],new PersonData());
	}
	
	public static function getAllActivo($activo=1){
		$sql = "SELECT C.descripcion, A.*
		          FROM person A 
	         LEFT JOIN personpuestos B ON B.idperson = A.id
	         LEFT JOIN puestos C ON C.id = B.idservicio
	         LEFT JOIN cargo D ON D.id = A.cargo
	             WHERE D.idtipo = 3 AND A.is_active = $activo ORDER BY C.grupo"; 

		$query = Executor::doit($sql); 

		return Model::many($query[0],new PersonData());
	}

	public static function getAllDatos(){
		$sql = "SELECT C.descripcion, A.*
		          FROM person A 
	         LEFT JOIN personpuestos B ON B.idperson = A.id
	         LEFT JOIN puestos C ON C.id = B.idservicio
	             WHERE A.idlocalidad = ".$_SESSION["id_localidad"]." OR C.idlugar = ".$_SESSION["id_localidad"]." ORDER BY C.grupo"; 

		$query = Executor::doit($sql); 

		return Model::many($query[0],new PersonData());
	}

	public static function getAllLiquida($tipo, $activo){
		$sql = "SELECT A.*, B.description FROM person A, cargo B
		         WHERE A.cargo = B.id AND B.idtipo = $tipo AND A.idcompany = ".$_SESSION['id_company']." AND A.is_active = $activo AND A.endwork != '' 
			  ORDER BY name";
		$query = Executor::doit($sql); 

		return Model::many($query[0],new PersonData());
	}
	
	public static function getAllTipo($tipo, $activo){
		$sql = "SELECT A.*, B.description FROM person A, cargo B WHERE A.idcargo = B.id AND B.idtipo = $tipo AND A.idcompany = ".$_SESSION['id_company']." AND A.is_active = $activo ORDER BY name";
		$query = Executor::doit($sql); 
		return Model::many($query[0],new PersonData());
	}

	public static function getAsignado(){
		$sql = "SELECT C.idservicio, A.id, A.name FROM person A LEFT JOIN cargo B ON B.id = A.idcargo LEFT JOIN personpuestos C ON C.idperson = A.id WHERE B.idtipo = 3 AND C.idservicio is null ORDER BY name";
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getAllCargo($cargo){
		$sql = "SELECT * FROM person A, cargo B WHERE A.cargo = B.id AND A.is_active = 1 AND A.idcargo = $cargo ORDER BY name";
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

    public static function getOficina($tipo){
    	 $sql = "SELECT A.id, A.image, A.idcard, A.tipo_sangre, A.name, A.cargo, B.description, A.email, A.phone1, A.direccion, A.startwork, A.endwork, A.kind, A.is_active, A.created_at 
		           FROM person A, cargo B 
				  WHERE A.idcompany = ".$_SESSION['id_company']." AND A.cargo = B.id AND B.idtipo IN (1, 2) AND A.is_active=$tipo
			   ORDER BY A.name, A.is_active"; 
    	 $query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getAll(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." AND is_active = 1 ORDER BY name";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getTodos(){
		$sql = "SELECT * FROM ".self::$tablename." WHERE idcompany = ".$_SESSION['id_company']." ORDER BY name";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getNomina(){
		$sql = "SELECT * FROM person WHERE idcompany = ".$_SESSION['id_company']." AND is_active=1";
		$query = Executor::doit($sql);

		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->idcargo = $r['cargo'];
			$array[$cnt]->sueldo = $r['sueldo'];
			$array[$cnt]->vehiculo = 0;
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->endwork = $r['endwork'];
			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;
		}

		return $array;
	}

	public static function getTipos($id, $tipo){ 
		$sql = "SELECT C.id, C.estado, C.tipo_despido, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.cargo = B.id AND C.estado='$tipo' AND C.idperson=$id
			  ORDER BY C.created_at DESC"; 

		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getContratos($id){
		$sql = "SELECT C.id, C.estado, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.acumula, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.cargo = B.id AND C.estado IN ('I', 'E') AND C.idperson=$id
			  ORDER BY C.created_at DESC";

		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getFiniquito($id){
		$sql = "SELECT C.id, E.name motivo, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B, operation_type E 
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.tipo_despido = E.id AND C.estado='E' AND C.idperson=$id"; 

		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getByCodigo($id){
		$sql = "SELECT C.id, C.idperson, C.dias, C.observacion, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.id=$id"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getVacaciones(){
		$sql = "select C.id, C.dias, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.estado='V'"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getValores($id, $estado){
		$sql = "select C.id, C.sueldo, A.idcard, A.name, A.idcargo, B.description, C.tipo_contrato, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.idperson='".$id."' AND C.estado='".$estado."'"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getMotivo($id, $estado){
		$sql = "select C.id, E.name motivo, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B, operation_type E 
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.tipo_despido = E.id AND C.estado='$estado' AND C.idperson=$id"; 
		$query = Executor::doit($sql);

		return Model::one($query[0],new PersonData());
	}
	
	public static function getLiquidacion(){
		$sql = "select C.id, E.name motivo, A.idcard, A.name, A.idcargo, B.description, A.phone1, C.startwork, C.endwork, C.created_at 
		          FROM persond C, person A, cargo B, operation_type E 
				 WHERE C.idperson = A.id AND A.idcargo = B.id AND C.tipo_despido = E.id AND C.estado='E'"; 
		$query = Executor::doit($sql);

		return Model::many($query[0],new PersonData());
	}

	public static function getClients(){
		$sql = "select A.id, A.idcard, A.name, A.idcargo, B.description, A.email, A.phone1, A.direccion, A.startwork, A.endwork, A.kind, A.is_active, A.created_at from person A, cargo B where A.idcompany = ".$_SESSION['id_company']." and A.cargo = B.id order by name";
		$query = Executor::doit($sql); 

		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();

			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->idcargo = $r['idcargo'];
			$array[$cnt]->cargo = $r['description'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['direccion'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->endwork = $r['endwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}

		return $array;
	}

	public static function getSupervisor(){
		$sql = "select * from person A, cargo B where A.cargo in(4, 5) and A.is_active=1 and A.cargo = B.id";
		$query = Executor::doit($sql);

		$array = array();
		$cnt = 0;

		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();

			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->cargo = $r['nombre'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address1 = $r['address'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;
		}

		return $array;
	}

	public static function getAgentes(){
		$sql = "select * from person A, cargo B where A.cargo in(7) and A.is_active=1 and A.cargo = B.id";
		$query = Executor::doit($sql);
		$array = array();

		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PersonData();

			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idcard = $r['idcard'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->cargo = $r['nombre'];
			$array[$cnt]->phone1 = $r['phone1'];
			$array[$cnt]->address = $r['direccion'];
			$array[$cnt]->startwork = $r['startwork'];
			$array[$cnt]->kind = $r['kind'];
			$array[$cnt]->is_active = $r['is_active'];
			$array[$cnt]->created_at = $r['created_at'];

			$cnt++;
		}

		return $array;
	}
}

