<?php
// INgreso de los Usuarios del Sistema
$local = LugarData::getAll();
$depar = DepartamentoData::getAll();
$roles = RolesData::getRol();
$hoy = date("Y-m-d H:i:s");
$user_id = 0; $error1 =0; $error2 = 0;

$persons = PersonData::getAll();
if(isset($_GET["id"])){
    $mensaje = "modificar un usuario del sistema";
    $enlaces = "Modificar";
	
    $users = UserData::getById($_GET["id"]);
    $user_id = $_GET["id"];
}else{
    $mensaje = "crear un nuevo usuario del sistema";
    $enlaces = "Crear";
    
    if(count($_POST)>0){
        if($_POST["user_id"] == 0){
            $error1 = count(UserData::getCampo("username", $_POST["username"]));
            $error2 = count(UserData::getCampo("email", $_POST["email"]));
        }

        if($error1 == 0 && $error2 == 0 && $_POST["rol_id"] > 0 && $_POST["id_departamento"] > 0){
			if($_POST["avatar"] == "") $avatar = "user15.png"; else $avatar = $_POST["avatar"];
            $user = new UserData();

            $user->name = $_POST["name"];
            $user->lastname = $_POST["lastname"];
            $user->username = $_POST["username"];
            $user->image = $avatar;
            $user->idrol = $_POST["rol_id"];
            $user->idlocalidad = $_POST["id_localidad"];
            $user->iddepartamento = $_POST["id_departamento"];
            $user->email = $_POST["email"];
            $user->is_admin=$_POST["iAdmin"];
            $user->is_active=$_POST["iActivo"];

            if($_POST["user_id"] == 0){
                if($_POST["password"] == "")
                    $user->password = sha1(md5("1234"));
                else
                    $user->password = sha1(md5($_POST["password"]));
                    
                $user->add();
            }else{
                $user->id = $_POST["user_id"];

                if($_POST["password"]!=""){
                    $user->password = sha1(md5($_POST["password"]));
                    $user->update_passwd();

                    Core::alert("Exito...!!!!", "Se ha actualizado el password", "success");
                }
                $user->update();
            }

            Core::redir('usuarios');
        }
        
        $errores = '';
        if($error1 > 0){
            $errores .= '- El nombre del usuario puede estar repetido..!\n';
            if($error2 > 0){
				$errores .= '- El correo del usuario puede estar repetido....!\n';
				if($_POST["rol_id"] == 0){
					$errores .= '- Tienen que seleccionar el ROL del usuario....!\n';
					if($_POST["id_departamento"] == 0){
						 $errores .= '- Tiene que seleccionar un departamento antes\n';
					}
				}
            }
        }

        $users = (object) [
           "id" => $_POST["user_id"],
           "idcompany" => $_SESSION['id_company'],
           "username" => $_POST["username"],
           "name" => $_POST["name"],
           "lastname" => $_POST["lastname"],
           "email" => $_POST["email"],
           "image" => "user00.png",
           "password" => $_POST["password"],
           "created_at" => $hoy,
           "idrol" => $_POST["rol_id"],
           "iddepartamento" => $_POST["id_departamento"],
           "is_admin" => $_POST["iAdmin"],
           "is_active" => $_POST["iActivo"]
        ];

        if($errores == ''){
           // Sin comentarios
        }else{
           Core::alert("Corrija...!!!!", $errores, "error");
        }
    }else{
        $users = (object) [
            "name" => "",
            "lastname" => "",
            "email" => "",
            "image" => "user00.png",
            "password" => "",
            "created_at" => $hoy,
            "id" => 0,
            "idcompany" => $_SESSION['id_company'],
            "username" => "",
            "idrol" => "0",
            "iddepartamento" => "0",			
            "ultima_session" => "",
            "is_admin" => "0",
            "is_active" => "1"
        ];
    }
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    <?php if($users->name == "") echo 'Creacion de Usuario'; else echo $users->name.' '.$users->lastname; ?>
    </h1>
    <ol class="breadcrumb">
		<li><a href="<?php echo $_SESSION["url"]; ?>usuarios"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active">User profile</li>
    </ol>
</section>
<!-- Main content -->
<section class="content" role="main" style="padding: 1.5rem !important;">
    <div class="row"> <?php 
		if($error1 > 0){ ?>
			<div class="col-sm-12">
				<div class="alert alert-danger">
					<strong>Error...!</strong> El nombre del usuario esta repetido.
				</div>
			</div><?php 
		}
		if($error2 > 0){ ?>
			<div class="col-sm-12">
				<div class="alert alert-danger">
					<strong>Error...!</strong> El correo del usuario esta repetido.
				</div>
			</div><?php 
		} ?>
		<div class="col-md-3"><!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" alt="User profile picture" src="<?php echo $_SESSION["url"]; ?>assets/images/avatar/user00.png">
					<br>
					<input type="file" name="image" id="image" placeholder="">
                    <h3 class="profile-username text-center"> </h3>
                    <p class="text-muted text-center">Ultimo ingreso: </p><?php echo $users->ultima_session; ?>
                    <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
		</div>
        <div class="col-md-9">
			<div class="box box-primary">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Administrativos</b></a>
					</li>
					<li>
						<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Operativos</b></a>
					</li>
				</ul>
				<div class="box-body">
					<!-- tabs content -->
					<div class="tab-content panel">
						<div class="tab-pane active" id="tab_activos">
							<form class="form-horizontal" method="post" id="addusuario" action="<?php echo $_SESSION["url"]; ?>usuario" role="form">
								<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
								<input type="hidden" id="avatar" name="avatar" value="">
								<div class="form-group">
									<label for="username" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Usuario:</label>
									<div class="col-sm-4">
										<input class="text-field form-control input-sm" id="username" name="username" value="<?php echo $users->username; ?>" type="text" autocomplete="off" required>
									</div>	
									<label for="id_localidad" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Localidad:</label>
									<div class="col-md-3 col-sm-4">
										<select class="select-input form-control input-sm" id="id_localidad" name="id_localidad">
											<option value="0" selected="selected"> Selecione... </option>
											<?php
												foreach($local as $locals):?>
													<option value="<?php echo $locals->id; ?>" <?php if($locals->id==$users->iddepartamento) echo 'selected="selected"'; ?>><?php echo $locals->descripcion;?></option> 
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
									<div class="col-md-4 col-sm-4">
										<input class="text-field form-control input-sm" id="name" name="name" type="text" value="<?php echo utf8_encode($users->name); ?>" autocomplete="off" required>
									</div>
									<label for="id_departamento" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Departamento:</label>
									<div class="col-md-3 col-sm-4">
										<select class="select-input form-control input-sm" id="id_departamento" name="id_departamento">
											<option value="0" selected="selected"> Selecione... </option>
											<?php
												foreach($depar as $depars):?>
													<option value="<?php echo $depars->id; ?>" <?php if($depars->id==$users->iddepartamento) echo 'selected="selected"'; ?>><?php echo $depars->name; //utf8_encode() ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="lastname" class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Apellido:</label>
									<div class="col-md-4 col-sm-4">
										<input class="text-field form-control input-sm" id="lastname" name="lastname" type="text" value="<?php echo utf8_encode($users->lastname); ?>" required>
									</div>
									<label for="rol_id" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Rol:</label>
									<div class="col-md-3 col-sm-4">
										<select class="select-input form-control input-sm" id="rol_id" name="rol_id">
											<option value="0" selected="selected"> Selecione... </option>
											<?php
												foreach($roles as $rol):?>
													<option value="<?php echo $rol->id; ?>" <?php if($rol->id==$users->idrol) echo 'selected="selected"'; ?>><?php echo utf8_encode($rol->nombre);?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="fecha_ing" class="col-md-2 col-sm-3 control-label">Registrado:</label>
									<div class="col-md-4 col-sm-4">
										<input class="text-field form-control input-sm" name="fecha_ing" id="fecha_ing" type="text" value="<?php echo $users->created_at; ?>" readonly>
									</div>
									<label for="password" class="col-md-3 col-sm-3 control-label"> Password:</label>
									<div class="col-md-3 col-sm-4">
										<input class="text-field form-control input-sm" id="password" name="password" value="" type="password" autocomplete="new-password">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-md-2 col-sm-2 control-label"><span class="text-danger">*</span> Correo:</label>
									<div class="col-md-4 col-sm-8">
										<input class="text-field form-control input-sm" id="email" name="email" value="<?php echo $users->email; ?>" type="text" autocomplete="off" required>
									</div> <?php 
									if($user_id == 0) {
										echo '<div class="col-sm-6">
												<div class="alert alert-info">
													<strong>Alerta...!</strong> Debe indicar una clave, si no se asignara la clave 1234 para que el usuario la cambie posteriormente.
												</div>
											</div>';
									}else{
										echo '<div class="col-sm-6">
												<div class="alert alert-info">
													<strong>Alerta...!</strong> <p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
												</div>
											</div>';
									} ?>								
								</div>
								<div class="form-group">
									<span class="col-sm-2 col-sm-3 control-label">&nbsp;</span>
									<div class="col-md-4 col-sm-8">
										<span class="text-danger">Es un usuario activo...?</span>
										<div class="radiobutton">									<input type="radio" name="iActivo" value="1" <?php if($users->is_active==1) echo 'checked'; ?>> Si
											<input type="radio" name="iActivo" value="0" <?php if($users->is_active==0) echo 'checked'; ?>> No
										</div>
									</div>
									<span class="col-sm-2 control-label">&nbsp;</span>
									<div class="col-md-4 col-sm-5">
										<span class="text-danger">Es un administrador...?</span>
										<div class="radiobutton">
											<input type="radio" name="iAdmin" value="1" <?php if($users->is_admin==1) echo 'checked'; ?>> Si
											<input type="radio" name="iAdmin" value="0" <?php if($users->is_admin==0) echo 'checked'; ?>> No
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2 col-sm-3">
										<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar </button>
									</div>
								</div>
							</form>
						</div>
						<div class="tab-pane" id="tab_inactivos">
							<style>
								.avatar-preview {
									display: flex;
									flex-direction: column;
									align-items: center;
									margin-bottom: 18px;
								}
								.avatar-preview-img {
									width: 140px;
									height: 140px;
									border-radius: 50%;
									object-fit: cover;
									border: 3px solid #007bff;
									box-shadow: 0 2px 8px rgba(0,0,0,0.12);
									margin-bottom: 8px;
								}
								.avatar-grid {
									display: grid;
									grid-template-columns: repeat(6, 1fr);
									gap: 18px;
									margin-top: 10px;
									max-width: 570px;
								}
								.avatar-option {
									position: relative;
									width: 80px;
									height: 80px;
									border-radius: 50%;
									overflow: hidden;
									border: 2px solid transparent;
									transition: border 0.2s;
									cursor: pointer;
									display: flex;
									align-items: center;
									justify-content: center;
									box-sizing: border-box;
								}
								.avatar-option.selected,
								.avatar-option input[type="radio"]:checked + img {
									border: 2px solid #007bff;
								}
								.avatar-option img {
									width: 100%;
									height: 100%;
									object-fit: cover;
									border-radius: 50%;
									pointer-events: none;
								}
								.avatar-option input[type="radio"] {
									position: absolute;
									opacity: 0;
									width: 100%;
									height: 100%;
									margin: 0;
									cursor: pointer;
									z-index: 2;
								}
								@media (max-width: 700px) {
								.avatar-grid {
									grid-template-columns: repeat(3, 1fr);
									max-width: 300px;
								}
								.avatar-option {
									width: 60px;
									height: 60px;
								}
								.avatar-preview-img {
									width: 90px;
									height: 90px;
								}
								}
							</style>
							<div class="col-md-3">
								<div class="avatar-preview">
									<img id="avatarPreviewImg" class="avatar-preview-img" src="<?php 
										if (empty($users->image) || $users->image == 'user00.png') {
											echo $_SESSION["url"].'assets/images/avatar.png';
										} else {
											echo $_SESSION["url"].'assets/images/avatar/'.$users->image;
										}
									?>" alt="Avatar seleccionado">
									<span>Avatar seleccionado</span>
								</div>
							</div>
							<div class="col-md-9">
								<div class="avatar-grid"><?php
									for ($i = 1; $i < 55; $i++) { 										
										$cadena = sprintf("%02d", $i); ?>
										<label class="avatar-option">
											<input type="radio" name="avatar" value="user<?php echo $cadena; ?>.png" <?php echo ($users->image == "user$cadena.png") ? 'checked' : ''; ?> data-img="<?php echo $_SESSION["url"].'assets/images/avatar/user'.$cadena.'.png'; ?>" />
											<img src="<?php echo $_SESSION["url"].'assets/images/avatar/user'.$cadena.'.png'; ?>" alt="Avatar <?php echo $cadena; ?>">
										</label><?php
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</section>
<script type='text/javascript'><!--
    document.title = "Near Solution | Ingreso de los Usuarios";

	document.querySelectorAll('.avatar-option input[type="radio"]').forEach(function(radio) {
		radio.addEventListener('change', function() {
			document.querySelectorAll('.avatar-option').forEach(function(opt) {
				opt.classList.remove('selected');
			});
			if (radio.checked) {
				radio.parentElement.classList.add('selected');
			}
		});
		// Inicializa la selección visual si ya está seleccionado
		if (radio.checked) {
			radio.parentElement.classList.add('selected');
		}
	});
	
	// Resaltado visual de avatar seleccionado y preview grande
	var avatarPreviewImg = document.getElementById('avatarPreviewImg');
	var defaultAvatar = '<?php echo $_SESSION["url"]; ?>assets/images/avatar.png';
	var radios = document.querySelectorAll('.avatar-option input[type="radio"]');
	var avatarInput = document.getElementById('avatar');
	function updateAvatarPreview() {
		var checked = document.querySelector('.avatar-option input[type="radio"]:checked');
		if (checked) {
			avatarPreviewImg.src = checked.getAttribute('data-img');
			// Guardar solo el nombre del archivo en el input oculto
			avatarInput.value = checked.value;
		} else {
			avatarPreviewImg.src = defaultAvatar;
			avatarInput.value = '';
		}
	}
	radios.forEach(function(radio) {
		radio.addEventListener('change', function() {
			document.querySelectorAll('.avatar-option').forEach(function(opt) {
				opt.classList.remove('selected');
			});
			if (radio.checked) {
				radio.parentElement.classList.add('selected');
			}
			updateAvatarPreview();
		});
		// Inicializa la selección visual si ya está seleccionado
		if (radio.checked) {
			radio.parentElement.classList.add('selected');
		}
	});
	// Si no hay ninguno seleccionado, mostrar el default
	if (!document.querySelector('.avatar-option input[type="radio"]:checked')) {
		avatarPreviewImg.src = defaultAvatar;
		avatarInput.value = '';
	} else {
		updateAvatarPreview();
	}
</script>