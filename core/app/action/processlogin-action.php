<?php
// Procedimiento de verificacion de Usuarios
//Core::cargando();

date_default_timezone_set('America/Guayaquil');
$fecha = date('Y-m-d'); $hora = date('H:i:s');
$fechaActual = date('Y-m-d').' '.date('H:i:s');
$_SESSION["name"] = ''; $_SESSION["lastname"] = ''; $_SESSION["cambio"] = '';

if(!isset($_SESSION["user_id"])) {
	$user = $_POST['username'];
	$pass = sha1(md5($_POST['password']));

	$base = new Database();
	$con = $base->connect();

	$sql = "select * from configuration where short like 'consigna_guardia'";
	$query = $con->query($sql);
    $r = $query->fetch_array();
	$consigna = $r['val'];

	$sql = "select * from configuration where short like 'email_parte'";
	$query = $con->query($sql);
    $r = $query->fetch_array();
	$correos = $r['val'];
	
	$_SESSION['consigna']=$consigna;
	$_SESSION['correos']=$correos;
	$_SESSION['ingreso']=0; $_SESSION['etapas']=0;
	if(is_numeric($_POST['username'])){
		if(strlen($_POST['username']) > 10){
			if($_POST['username'] && $_POST['password']){
				echo "Son iguales..!!!<br>";
				$sql = "SELECT * FROM client WHERE ruc = \"".$user."\" AND telefono1 = \"".$_POST['password']."\" AND is_active = 1"; 
				
				if($query = $con->query($sql)){
					$total = mysqli_num_rows($query);

					if($total==0){
						$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'El número de identificación no esta registrado en el sistema.'];
						echo "<script>window.location='./';</script>";
					}else{
						$id = 0; $residencial = 0;
						$name = '';
						$userid = null;

						while($r = $query->fetch_array()){
							$userid = $r['idclient'];
							$name = $r['contacto'];
							$idclient = $r['idclient'];
							$etapas = $r['etapas'];
						}
 
						$_SESSION['user_id']=$userid;
						$_SESSION["client_id"]=$userid;
						$_SESSION['id_card']=$_POST['username'];
						$_SESSION['usuario']='Sistema de Consultas';
						$_SESSION['id_corporacion']=1;
						$_SESSION['id_company']=1;
						$_SESSION['id_client']=$idclient;
						$_SESSION['id_localidad']=1;
						$_SESSION['id_actividad']=8;
						$_SESSION['company']='SECURITY';
						$_SESSION['email']='info@nearsolution.com';
						$_SESSION['logo-recibo']='logo.png';
						$_SESSION['se_imprime']='logo.png';
						$_SESSION['mision']='Cumplir con lo mejor de calidad';
						$_SESSION['residencial']=$residencial;
						$_SESSION['is_admin']=0;

						$_SESSION['name']=$name;
						$_SESSION['lastname']='';
						$_SESSION['idrol']=8;
						$_SESSION['desrol']="Administrador";
						$_SESSION['depart']=9;
						$_SESSION['reportes']='';
						$_SESSION['ultima_sesion']=$fechaActual;
						$_SESSION['etapas']=$etapas;
						$_SESSION['user_name']='Bitacora Electronica';

						setcookie('userid', $userid);
						Core::redir('fechas');
					}
				}else{
					echo "Error, al ejecutar una consulta";
				}
			}
		}else{
			if($_POST['username'] && $_POST['password']){
				$sql = "SELECT * FROM person WHERE idcard = '".$user."' AND is_active=1"; 
				
				if($query = $con->query($sql)){
					$total = mysqli_num_rows($query);
					if($total==0){
						$sql = "SELECT B.nombre AS clientes, A.* FROM residente A, client B WHERE B.idclient = A.idclient AND A.cedula = '".$user."' AND A.is_active=1";
						
						if($query = $con->query($sql)){
							$total = mysqli_num_rows($query);
							
							if($total==0){
								$_SESSION['error']=3;
								$_SESSION['ingreso']=0;
								$_SESSION['user_id']=1;
								$_SESSION['id_card']=$_POST['username'];
								$_SESSION['usuario']='Ingreso de Aspirantes';
								$_SESSION['asigna']=0;
								$_SESSION['id_corporacion']=1;
								$_SESSION['id_company']=1;
								$_SESSION['id_client']=4;
								$_SESSION['id_localidad']=1;
								$_SESSION['id_actividad']=8;
								$_SESSION['company']='SECURITY';
								$_SESSION['email']='info@security.ec';
								$_SESSION['logo-recibo']='logo.png';
								$_SESSION['se_imprime']='logo.png';
								$_SESSION['mision']='Cumplir con lo mejor de calidad';
								$_SESSION['residencial']='0';
								$_SESSION['etapas']='0';
								$_SESSION['principal']='0';
								$_SESSION['is_admin']=0;
								$_SESSION['name']='Aspirante Nuevo';
								$_SESSION['idrol']=11;
								$_SESSION['desrol']='Aspirante';
								$_SESSION['depart']=3;
								$_SESSION['reportes']='';
								$_SESSION['ultima_sesion']=$fechaActual;
								$_SESSION['user_name']='Aspirante Nuevo';
								$_SESSION['consigna']=$consigna;
								$_SESSION['correos']=$correos;

								setcookie('userid', $_POST['username']); 
								echo '<script>
										if(localStorage.getItem("usuario") != null){
											var usuario = localStorage.getItem("usuario");
											var puesto = localStorage.getItem("puesto");
											var ingreso = localStorage.getItem("ingreso");
											var turno = localStorage.getItem("turno");
												
											window.location="index.php?view=aspirantes&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
										}else{
											window.location="index.php?view=aspirantes";
										}
									  </script>';
							}else{
								$rolid = 9;
								$roldes = 'Residente';

								$id = 0; $residencial = 9;
								$name = '';

								$userid = null;
								while($r = $query->fetch_array()){
									$id = $r['id'];
									$idclient = $r['idclient'];
									$clientes = $r['clientes'];
									$nombre = $r['nombre'];
									$manzana = $r['manzana'];
									$villa = $r['villa'];
								}

								$_SESSION['ingreso']=0;
								$_SESSION['user_id']=$id;
								$_SESSION['id_card']=$_POST['username'];
								$_SESSION['usuario']='Autorizan las visita';
								$_SESSION['asigna']=$asigna;
								$_SESSION['id_corporacion']=1;
								$_SESSION['id_company']=1;
								$_SESSION['id_client']=$idclient;
								$_SESSION['clientes']=$clientes;
								$_SESSION['id_localidad']=1;
								$_SESSION['id_actividad']=1;
								$_SESSION['company']='SECURITY';
								$_SESSION['email']='info@nearsolution.com';
								$_SESSION['logo-recibo']='logo.png';
								$_SESSION['se_imprime']='logo.png';
								$_SESSION['mision']='Cumplir con lo mejor de calidad';
								$_SESSION['residencial']=$residencial;
								$_SESSION['is_admin']=0;

								$_SESSION['name']=$nombre;
								$_SESSION['lastname']='';

								$_SESSION['idrol']=$rolid;
								$_SESSION['desrol']=$roldes;
								$_SESSION['depart']=9;
								$_SESSION['reportes']='';
								$_SESSION['manzana']=$manzana;
								$_SESSION['villa']=$villa;
								$_SESSION['ultima_sesion']=$fechaActual;
								$_SESSION['user_name']='Residente';
								$_SESSION['consigna']=$consigna;
								$_SESSION['correos']=$correos;

								setcookie('userid', $userid);
								echo '<script>window.location="noticias";</script>';
							}
						}
						$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => '1. Usuario no registrado en el sistema, consulte con el administrador.'];
						echo "<script>window.location='./';</script>";
					}else{						
						$rolid = 7;
						$roldes = 'Agente de Seguridad';

						$id = 0; $residencial = 9;
						$name = ''; 

						$userid = null;
						while($r = $query->fetch_array()){
							$id = $r['id'];
							$name = $r['name'];
							$roldes = 'Agente en servicio';
						}

						$sql1 = "SELECT C.idcompany, D.name, C.etapas, A.*, B.idclient, B.residencial, B.principal FROM personpuestos A, puestos B, client C, company D 
						          WHERE A.idservicio = B.id AND B.idclient = C.idclient AND D.id = C.idcompany AND A.idperson = ".$id." AND A.is_active = 1"; 
						
						if($query = $con->query($sql1)){ 
							$total = mysqli_num_rows($query);
							
							if($total==0){								
								$_SESSION['error']=4;
								$_SESSION['ingreso']=0;
								$_SESSION['user_id']=$id;
								$_SESSION['id_card']=$_POST['username'];
								$_SESSION['usuario']='Ingreso de Aspirantes';
								$_SESSION['asigna']=0;
								$_SESSION['id_corporacion']=1;
								$_SESSION['id_company']=1;
								$_SESSION['id_client']=4;
								$_SESSION['id_localidad']=1;
								$_SESSION['id_actividad']=8;
								$_SESSION['company']='SECURITY';
								$_SESSION['email']='info@security.ec';
								$_SESSION['logo-recibo']='logo.png';
								$_SESSION['se_imprime']='logo.png';
								$_SESSION['mision']='Cumplir con lo mejor de calidad';
								$_SESSION['residencial']='0';
								$_SESSION['etapas']='0';
								$_SESSION['principal']='0';
								$_SESSION['is_admin']=0;

								$_SESSION['name']=$name;
								$_SESSION['lastname']='';
								$_SESSION['idrol']=11;
								$_SESSION['desrol']='Aspirante';
								$_SESSION['depart']=3;
								$_SESSION['reportes']='';
								$_SESSION['ultima_sesion']=$fechaActual;
								$_SESSION['user_name']='Aspirante Registrado';
								$_SESSION['consigna']=$consigna;
								$_SESSION['correos']=$correos;
								
								echo '<script>window.location="index.php?view=aspirantes&id='.$id.'";</script>';
							}else{
								$asigna = array(); $i = 0;
								while($m = $query->fetch_array()){
									$idclient = $m['idclient'];
									$etapas = $m['etapas'];
									$compania = $m['name'];
									$principal = $m['principal'];
									if($residencial == 9) $residencial = $m['residencial'];
									$asigna[$i] = $m['idservicio']; $i++;
								}							
								
								$_SESSION['ingreso']=0;
								$_SESSION['user_id']=$id;
								$_SESSION['id_card']=$_POST['username'];
								$_SESSION['usuario']='Sistema de Ingreso';
								$_SESSION['asigna']=$asigna;
								$_SESSION['id_corporacion']=1;
								$_SESSION['id_company']=1;
								$_SESSION['id_client']=$idclient;
								$_SESSION['id_localidad']=1;
								$_SESSION['id_actividad']=8;
								$_SESSION['company']=$compania;
								$_SESSION['email']='info@nearsolution.com';
								$_SESSION['logo-recibo']='logo.png';
								$_SESSION['se_imprime']='logo.png';
								$_SESSION['mision']='Cumplir con lo mejor de calidad';
								$_SESSION['residencial']=$residencial;
								$_SESSION['etapas']=$etapas;
								$_SESSION['principal']=$principal;
								$_SESSION['is_admin']=0;

								$_SESSION['name']=$name;
								$_SESSION['lastname']='';

								$_SESSION['idrol']=$rolid;
								$_SESSION['desrol']=$roldes;
								$_SESSION['depart']=3;
								$_SESSION['reportes']='';
								$_SESSION['ultima_sesion']=$fechaActual;
								$_SESSION['user_name']='Agente Seguro';
								$_SESSION['consigna']=$consigna;
								$_SESSION['correos']=$correos;

								setcookie('userid', $userid); 
								echo '<script>
										if(localStorage.getItem("usuario") != null){
											var usuario = localStorage.getItem("usuario");
											var puesto = localStorage.getItem("puesto");
											var ingreso = localStorage.getItem("ingreso");
											var turno = localStorage.getItem("turno");
												
											window.location="index.php?view=novedad&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
										}else{
											window.location="index.php?view=asignar";
										}
									  </script>'; 
							}
						}
					}
				}else{
					$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'El número de identificación debe tener 10 o 13 dígitos.'];
					echo "<script>window.location='./';</script>";
				}
			}else{
				$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'El número de identificación debe tener 10 o 13 dígitos.'];
				echo "<script>window.location='./';</script>";
			}
		}
	}else{
		$sql = "SELECT B.name AS compania, A.id AS user, A.username, A.name AS nombre, A.lastname, A.email AS correo, A.cambio, A.is_admin, A.idrol, A.idperson, A.iddepartamento, idlocalidad, A.ultima_session, B.id AS company, B.*, C.nombre desrol FROM user A, company B, rol C 
		         WHERE username= \"".$user."\" and password= \"".$pass."\" and A.idcompany = B.id and A.idrol = C.id and A.is_active=1";
		$query = $con->query($sql);
		
		if($query->num_rows > 0){
			$r = $query->fetch_array();

			$_SESSION['user_id']=$r['user'];
			$_SESSION['usuario']=$r['nombre'].' '.$r['lastname'];
			$_SESSION['id_company']=$r['company'];
			$_SESSION['actividad']=$r['actividad'];
			$_SESSION['id_localidad']=$r['idlocalidad'];
			$_SESSION['id_person']=$r['idperson'];
			$_SESSION['company']=$r['compania'];
			$_SESSION['email']=$r['correo'];
			$_SESSION['logo-recibo']=$r['logo_recibo'];
			$_SESSION['se_imprime']=$r['se_imprime'];
			$_SESSION['mision']=$r['mision'];
			$_SESSION['is_admin']=$r['is_admin'];
			$_SESSION['idrol']=$r['idrol'];
			$_SESSION['desrol']=$r['desrol'];
			$_SESSION['depart']=$r['iddepartamento'];
			$_SESSION['ultima_sesion']=$r['ultima_session'];
			$_SESSION['user_name']=$r['username'];
			$_SESSION['cambio']=$r['cambio'];
			$_SESSION['id_puesto']=0;
			$_SESSION['residencial']=0;
			$_SESSION['ingreso']=0;

			setcookie('userid', $_SESSION['user_id']);

			$ultimoLogin = UserData::update_user($fechaActual);
			Core::redir('home');
		}else{
			$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'No es un usuario del sistema, comuniquese con el administrador.'];
			echo "<script>window.location='./';</script>";
		}
	}
}else{
	Core::redir('home');
}

