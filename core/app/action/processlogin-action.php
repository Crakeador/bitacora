<?php
//Procedimiento de verificacion de Usuarios
 
date_default_timezone_set('America/Guayaquil');
$fecha = date('Y-m-d'); $hora = date('H:i:s');
$fechaActual = date('Y-m-d').' '.date('H:i:s');
$_SESSION["name"] = ''; $_SESSION["lastname"] = ''; $_SESSION["cambio"] = '';

// Registra un evento de login por usuario en storage/login/{user_id}.log
function save_login_event($userId){
	if(!$userId) return;
	$dir = __DIR__ . '/../../../storage/login';
	if(!is_dir($dir)) @mkdir($dir, 0777, true);
	$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	$ts_iso = date('c');
	$entry = json_encode([ 'ts' => $ts_iso, 'ip' => $ip, 'ua' => $ua ]);
	@file_put_contents($dir.'/'.intval($userId).'.log', $entry.PHP_EOL, FILE_APPEND|LOCK_EX);

	// También guarda en BD si existe/crea la tabla user_login
	$ts = date('Y-m-d H:i:s');
	try{
		$base = new Database();
		$con = $base->connect();
		$uaEsc = $con->real_escape_string($ua);
		$ipEsc = $con->real_escape_string($ip);
		$con->query("CREATE TABLE IF NOT EXISTS user_login (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, ts DATETIME NOT NULL, ip VARCHAR(64) NULL, ua VARCHAR(255) NULL, INDEX idx_user_login_user (user_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$sql = "INSERT INTO user_login (user_id, ts, ip, ua) VALUES (".intval($userId).", '$ts', '$ipEsc', '$uaEsc')";
		$con->query($sql);
	}catch(Exception $e){ /* noop */ }
}

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
		if(strlen($_POST['username']) == 13){
			if($_POST['username'] && $_POST['password']){				
				Core::cargando();

				$sql = "SELECT * FROM client WHERE ruc = \"".$user."\" AND telefono1 = \"".$_POST['password']."\" AND is_active = 1"; 

				if($query = $con->query($sql)){
					$total = mysqli_num_rows($query);

					if($total==0){
						$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'El número de identificación no esta registrado en el sistema.'];
						echo "<script>window.location='./';</script>";
					}else{
						$id = 0; $residencial = 0; $name = ''; $userid = null;
						$query = $con->query($sql);
						$r = $query->fetch_array();
						
						$_SESSION['user_id']=$r['id'];
						$_SESSION['client_id']=$r['id'];
						$_SESSION['id_card']=$_POST['username'];
						$_SESSION['usuario']='Sistema de Consultas';
						$_SESSION['id_corporacion']=1;
						$_SESSION['id_company']=1;
						$_SESSION['id_client']=$r['id'];
						$_SESSION['id_localidad']=1;
						$_SESSION['id_actividad']=8;
						$_SESSION['company']='SECURITY';
						$_SESSION['email']='info@nearsolution.com';
						$_SESSION['logo-recibo']='logo.png';
						$_SESSION['se_imprime']='logo.png';
						$_SESSION['mision']='Cumplir con lo mejor de calidad';
						$_SESSION['residencial']=$residencial;
						$_SESSION['is_admin']=0;

						$_SESSION['name']=$r['contacto'];
						$_SESSION['lastname']='';
						$_SESSION['idrol']=8;
						$_SESSION['desrol']="Administrador";
						$_SESSION['depart']=9;
						$_SESSION['reportes']='';
						$_SESSION['ultima_sesion']=$fechaActual;
						$_SESSION['etapas']=$r['etapas'];
						$_SESSION['user_name']='Bitacora Electronica';

						setcookie('userid', $userid);
						save_login_event($_SESSION['user_id']);
						Core::redir('fechas');
					}
				}else{					
					$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Este usuario no tiene acceso al sistema.'];
					echo "<script>window.location='./';</script>";
				}
			}
		}else{
			if(strlen($_POST['username']) == 10){
				$sql = "SELECT * FROM person WHERE idcard = '".$user."'";
				
				if($query = $con->query($sql)){
					$total = mysqli_num_rows($query);
					
					if($total==0){
						$sql = "SELECT B.nombre AS clientes, A.* FROM residente A, client B WHERE B.id = A.idclient AND A.cedula = '".$user."' AND A.is_active=1";
						
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
								save_login_event($_SESSION['user_id']); 								
								
								echo '<!DOCTYPE html><html lang="es">
										<head>
											<meta charset="UTF-8">
											<title>Aceptar Términos</title>
											<style>
												body{font-family:Inter,system-ui,Arial,sans-serif;background:linear-gradient(135deg,#0b1320 0%,#121d34 45%,#101b2d 100%);color:#e2e8f0;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:24px}
												.overlay{position:fixed;inset:0;background:rgba(8,15,32,.78);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;}
												.popup{background:rgba(15,23,42,.98);border:1px solid rgba(148,163,184,.16);border-radius:24px;max-width:560px;width:100%;padding:32px;box-shadow:0 32px 70px rgba(15,23,42,.35);}
												.popup h1{font-size:28px;margin-bottom:16px;color:#f8fafc;line-height:1.1;} 
												.popup p{font-size:15px;line-height:1.9;color:#cbd5e1;margin-bottom:24px;} 
												.popup label{display:grid;grid-template-columns:auto 1fr;gap:14px;align-items:flex-start;padding:18px 16px;border:1px solid rgba(148,163,184,.16);border-radius:18px;background:rgba(148,163,184,.05);color:#e2e8f0;font-size:15px;line-height:1.8;} 
												.popup input[type=checkbox]{width:20px;height:20px;margin:0;accent-color:#2563eb;border-radius:6px;} 
												.popup p a {
													color: #60a5fa;
													text-decoration: underline;
													text-decoration-color: transparent;
													text-underline-offset: 3px;
													transition: color 0.2s ease, text-decoration-color 0.2s ease;
													font-weight: 500;
													outline-offset: 3px;
													border-radius: 3px;
												}

												.popup p a:hover {
													color: #93c5fd;
													text-decoration-color: #93c5fd;
												}

												.popup p a:focus-visible {
													outline: 2px solid #3b82f6;
													text-decoration-color: #60a5fa;
												}

												.popup p a:visited {
													color: #a78bfa;
												}
												.actions{display:flex;flex-wrap:wrap;gap:12px;justify-content:flex-end;margin-top:28px;} 
												.actions button{min-width:150px;border:none;border-radius:14px;padding:14px 22px;font-size:15px;font-weight:700;cursor:pointer;transition:transform .2s ease,background .2s ease;color:#fff;} 
												.actions button:hover:not(:disabled){transform:translateY(-1px);} 
												.actions button:disabled{background:#334155;cursor:not-allowed;color:#94a3b8;} 
												.actions button.primary{background:linear-gradient(90deg,#2563eb 0%,#3b82f6 100%);box-shadow:0 12px 25px rgba(59,130,246,.28);} 
												.actions button.secondary{background:#1e293b;color:#cbd5e1;}
											</style>
										</head>
										<body>
											<div class="overlay">
												<div class="popup">
													<h1>Confirmar aceptación</h1>
													<p>Antes de continuar como aspirante debes aceptar los términos y condiciones <a href="https://latin.grupolatinamerica.com/storage/documentos/politicas.pdf" target="_blank">de la Política de Protección de Datos de LATIN AMERICA CLOSE PROTECTION &amp; SECURITY CLOSEPROT CIA. LTDA.</a></p>
													<label>
														<input type="checkbox" id="acceptTerms"> He leído y estoy de acuerdo con los términos y condiciones 
													</label>
													<div class="actions">
														<button id="cancelBtn" type="button" class="secondary">Volver</button>
														<button id="continueBtn" type="button" class="primary" disabled>Continuar a Aspirante</button>
													</div>
												</div>
											</div>
											<script>
												const btnContinue=document.getElementById("continueBtn");
												const chkAccept=document.getElementById("acceptTerms");
												const btnCancel=document.getElementById("cancelBtn");
												
												chkAccept.addEventListener("change",()=>{
													btnContinue.disabled=!chkAccept.checked;
												});
												
												btnContinue.addEventListener("click",()=>{
													window.location.href="aspirante";
												});
												
												btnCancel.addEventListener("click",()=>{
													window.location.href="./logout.php";
												});
											</script>
										</body>
									</html>'; 
								echo '<script>
										if(localStorage.getItem("usuario") != null){
											var usuario = localStorage.getItem("usuario");
											var puesto = localStorage.getItem("puesto");
											var ingreso = localStorage.getItem("ingreso");
											var turno = localStorage.getItem("turno");
												
											window.location="index.php?view=aspirante&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
										}else{
											//window.location="aspirante";
										}
									  </script>'; 
							}else{
								Core::cargando();
								$rolid = 9;
								$roldes = 'Residente';

								$id = 0; $residencial = 9;
								$name = '';

								$userid = null;								
								$query = $con->query($sql);
								$r = $query->fetch_array();

								$_SESSION['ingreso']=0;
								$_SESSION['user_id']=$r['id'];
								$_SESSION['id_card']=$_POST['username'];
								$_SESSION['usuario']='Autorizan las visita';
								$_SESSION['asigna']=$asigna;
								$_SESSION['id_corporacion']=1;
								$_SESSION['id_company']=1;
								$_SESSION['id_client']=$r['idclient'];
								$_SESSION['clientes']=$r['clientes'];
								$_SESSION['id_localidad']=1;
								$_SESSION['id_actividad']=1;
								$_SESSION['company']='SECURITY';
								$_SESSION['email']='info@nearsolution.com';
								$_SESSION['logo-recibo']='logo.png';
								$_SESSION['se_imprime']='logo.png';
								$_SESSION['mision']='Cumplir con lo mejor de calidad';
								$_SESSION['residencial']=$residencial;
								$_SESSION['is_admin']=0;

								$_SESSION['name']=$r['nombre'];
								$_SESSION['lastname']='';

								$_SESSION['idrol']=$rolid;
								$_SESSION['desrol']=$roldes;
								$_SESSION['depart']=9;
								$_SESSION['reportes']='';
								$_SESSION['manzana']=$r['manzana'];
								$_SESSION['villa']=$r['villa'];
								$_SESSION['ultima_sesion']=$fechaActual;
								$_SESSION['user_name']='Residente';
								$_SESSION['consigna']=$consigna;
								$_SESSION['correos']=$correos;

								setcookie('userid', $userid);
								save_login_event($_SESSION['user_id']);
								echo '<script>window.location="noticias";</script>';
							}
						}else{
							echo '<script>window.location="aspirante/'.$user.'";</script>';
						}
					}else{
						$r = $query->fetch_array();
						$id = $r['id'];
						$name = $r['name'];
						if($r["password"] == $_POST['password']){
							if($r["is_active"] == 1){
								if($r["idcargo"] == 22){
									$_SESSION['error']=0;
									$_SESSION['ingreso']=0;
									$_SESSION['user_id']=$r["id"];
									$_SESSION['id_card']=$r["idcard"];
									$_SESSION['usuario']=$r["name"];
									$_SESSION['asigna']=0;
									$_SESSION['id_corporacion']=1;
									$_SESSION['id_company']=$r["idcompany"];
									$_SESSION['id_client']=4;
									$_SESSION['id_localidad']=1;
									$_SESSION['id_actividad']=8;
									$_SESSION['company']='EXTREME SECURITY';
									$_SESSION['email']='info@security.ec';
									$_SESSION['logo-recibo']='logo.png';
									$_SESSION['se_imprime']='logo.png';
									$_SESSION['mision']='Cumplir con lo mejor de calidad';
									$_SESSION['residencial']='0';
									$_SESSION['etapas']='0';
									$_SESSION['principal']='0';
									$_SESSION['is_admin']=0;

									$_SESSION['name']=$r["name"];
									$_SESSION['lastname']='';
									$_SESSION['idrol']=22;
									$_SESSION['desrol']='Administrativo';
									$_SESSION['depart']=1;
									$_SESSION['reportes']='';
									$_SESSION['ultima_sesion']=$fechaActual;
									$_SESSION['user_name']='Registro Horario';
									$_SESSION['consigna']=$consigna;
									$_SESSION['correos']=$correos;
									
									save_login_event($_SESSION['user_id']);							
									echo '<script>window.location="horario";</script>';
								}else{
									$rolid = 7;
									$roldes = 'Agente de Seguridad';

									$residencial = 9;
									$name = ''; 

									$userid = null;
									$roldes = 'Agente en servicio';

									$sql1 = "SELECT C.idcompany, D.name, C.etapas, A.*, B.idclient, B.residencial, B.principal FROM personpuestos A, puestos B, client C, company D 
											WHERE A.idservicio = B.id AND B.idclient = C.id AND D.id = C.idcompany AND A.idperson = ".$id." AND A.is_active = 1"; 
									
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
											
											save_login_event($_SESSION['user_id']);
											echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Aceptar Términos</title><style>body{font-family:Inter,system-ui,Arial,sans-serif;background:linear-gradient(135deg,#0b1320 0%,#121d34 45%,#101b2d 100%);color:#e2e8f0;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:24px}.overlay{position:fixed;inset:0;background:rgba(8,15,32,.78);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;} .popup{background:rgba(15,23,42,.98);border:1px solid rgba(148,163,184,.16);border-radius:24px;max-width:560px;width:100%;padding:32px;box-shadow:0 32px 70px rgba(15,23,42,.35);} .popup h1{font-size:28px;margin-bottom:16px;color:#f8fafc;line-height:1.1;} .popup p{font-size:15px;line-height:1.9;color:#cbd5e1;margin-bottom:24px;} .popup label{display:grid;grid-template-columns:auto 1fr;gap:14px;align-items:flex-start;padding:18px 16px;border:1px solid rgba(148,163,184,.16);border-radius:18px;background:rgba(148,163,184,.05);color:#e2e8f0;font-size:15px;line-height:1.8;} .popup input[type=checkbox]{width:20px;height:20px;margin:0;accent-color:#2563eb;border-radius:6px;} .actions{display:flex;flex-wrap:wrap;gap:12px;justify-content:flex-end;margin-top:28px;} .actions button{min-width:150px;border:none;border-radius:14px;padding:14px 22px;font-size:15px;font-weight:700;cursor:pointer;transition:transform .2s ease,background .2s ease;color:#fff;} .actions button:hover:not(:disabled){transform:translateY(-1px);} .actions button:disabled{background:#334155;cursor:not-allowed;color:#94a3b8;} .actions button.primary{background:linear-gradient(90deg,#2563eb 0%,#3b82f6 100%);box-shadow:0 12px 25px rgba(59,130,246,.28);} .actions button.secondary{background:#1e293b;color:#cbd5e1;}</style></head><body><div class="overlay"><div class="popup"><h1>Confirmar aceptación</h1><p>Antes de continuar como aspirante debes aceptar los términos y condiciones de la Política de Protección de Datos de LATIN AMERICA CLOSE PROTECTION & SECURITY CLOSEPROT CIA. LTDA.</p><label><input type="checkbox" id="acceptTerms"> He leído y estoy de acuerdo con los términos y condiciones de la Política de Protección de Datos de LATIN AMERICA CLOSE PROTECTION & SECURITY CLOSEPROT CIA. LTDA.</label><div class="actions"><button id="cancelBtn" type="button" class="secondary">Volver</button><button id="continueBtn" type="button" class="primary" disabled>Continuar a Aspirante</button></div></div></div><script>const btnContinue=document.getElementById("continueBtn");const chkAccept=document.getElementById("acceptTerms");const btnCancel=document.getElementById("cancelBtn");chkAccept.addEventListener("change",()=>{btnContinue.disabled=!chkAccept.checked;});btnContinue.addEventListener("click",()=>{window.location.href="index.php?view=aspirante&id='.intval($id).'";});btnCancel.addEventListener("click",()=>{window.location.href="./";});</script></body></html>';
											exit;
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
											save_login_event($_SESSION['user_id']); 
											echo '<script>
													if(localStorage.getItem("usuario") != null && localStorage.getItem("puesto") != null){
														var usuario = localStorage.getItem("usuario");
														var puesto = localStorage.getItem("puesto");
														var ingreso = localStorage.getItem("ingreso");
														var turno = localStorage.getItem("turno");
															
														window.location="index.php?view=novedad&usuario="+usuario+"&puesto="+puesto+"&ingreso="+ingreso+"&turno="+turno;
													}else{
														window.location="asignar";
													}
												</script>';
										}
									}
								}
							}else{
								$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Usted no tiene acceso al sistema, comuniquese con el administrador...!!!'];
								echo "<script>window.location='./';</script>";
							}
						}else{
							$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'La Clave esta errada, corrija por favor...!!!'];
							echo "<script>window.location='./';</script>";
						}
					}
				}
			}else{
				$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'El número de identificación debe tener 10 o 13 dígitos.'];
				echo "<script>window.location='./';</script>";
			}
		}
	}else{
		Core::cargando();

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

			$ultimoLogin = UserData::update_user($_SESSION['user_id']);
			save_login_event($_SESSION['user_id']);
			Core::redir('home');
		}else{
			$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'No es un usuario del sistema, comuniquese con el administrador.'];
			echo "<script>window.location='./';</script>";
		}
	}
}else{
	Core::redir('home');
}

