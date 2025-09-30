<?php
// INgreso de los Usuarios del Sistema
$local = LugarData::getAll();
$depar = DepartamentoData::getDepart();
$roles = RolesData::getRol();
$hoy = date("Y-m-d H:i:s");
$user_id = 0; $error1 =0; $error2 = 0;

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
            $user = new UserData();

            $user->name = $_POST["name"];
            $user->lastname = $_POST["lastname"];
            $user->username = $_POST["username"];
            $user->image = "user15.png";
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
            "is_admin" => "0",
            "is_active" => "1"
        ];
    }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Usuarios
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="usuarios"><i class="fa fa-user"></i> Usuarios </a></li>
		<li class="active"> <?php echo $enlaces; ?> </li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="container-fluid">
		<input type="hidden" id="ndetalles" value="2">
		<!-- Dialogo para seleccionar una cuenta -->
		<p class="alert alert-info">
			<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
			- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</p>
		<form class="form-horizontal" method="post" id="user" enctype="multipart/form-data" action="index.php?view=sisusu.user" role="form">
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<div class="panel panel-default">
				<div class="panel-body"> 
					<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger">*</span> Imagen:</label>
						<div class="col-sm-2">
							<input type="file" name="image" id="image" placeholder="">
							<br>
							<img src="<?php echo 'assets/images/avatar/'.$users->image;?>" class="img-responsive">
						</div>
					</div> 
					<div class="form-group">
						<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Usuario:</label>
						<div class="col-sm-4">
							<input class="text-field form-control input-sm" id="username" name="username" value="<?php echo $users->username; ?>" type="text" required>
						</div>
						<?php if($error1 > 0): ?>
							<div class="col-sm-6">
									<div class="alert alert-danger">
									<strong>Error...!</strong> El nombre del usuario esta repetido.
								</div>
							</div>
						<?php endif; ?>		
						<label class="col-sm-3 control-label"><span class="text-danger">*</span> Localidad:</label>
						<div class="col-sm-3">
							<select class="select-input form-control input-sm" id="id_localidad" name="id_localidad">
								<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($local as $locals):?>
										<option value="<?php echo $locals->id; ?>" <?php if($locals->id==$users->iddepartamento) echo 'selected="selected"'; ?>><?php echo utf8_encode($locals->descripcion);?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
						<div class="col-md-4 col-sm-4">
							<input class="text-field form-control input-sm" id="name" name="name" type="text" value="<?php echo utf8_encode($users->name); ?>" required>
						</div>
						<label class="col-sm-3 control-label"><span class="text-danger">*</span> Departamento:</label>
						<div class="col-sm-3">
							<select class="select-input form-control input-sm" id="id_departamento" name="id_departamento">
								<option value="0" selected="selected"> Selecione... </option>
								<?php
									foreach($depar as $depars):?>
										<option value="<?php echo $depars->id; ?>" <?php if($depars->id==$users->iddepartamento) echo 'selected="selected"'; ?>><?php echo utf8_encode($depars->description);?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Apellido:</label>
						<div class="col-md-4 col-sm-4">
							<input class="text-field form-control input-sm" id="lastname" name="lastname" type="text" value="<?php echo utf8_encode($users->lastname); ?>" required>
						</div>
						<label class="col-sm-3 control-label"><span class="text-danger">*</span> Rol:</label>
						<div class="col-sm-3">
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
						<label class="col-md-2 col-sm-3 control-label"> Password:</label>
						<div class="col-sm-4">
							<input class="text-field form-control input-sm" id="password" name="password" value="" type="password" autocomplete="new-password">
						</div>

						<?php if($user_id == 0): ?>
							<div class="col-sm-6">
								<div class="alert alert-info">
									<strong>Alerta...!</strong> debe indicar una clave, si no se asignara la clave 1234 para que el usuario la cambie posteriormente.
								</div>
							<?php else: ?>
								<div class="col-sm-6">
									<div class="alert alert-info">
										<strong>Alerta...!</strong> <p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
									</div>
								</div>
							<?php endif; ?>
								</div>
								<div class="form-group">
									<label class="col-md-2 col-sm-3 control-label"><span class="text-danger">*</span> Correo:</label>
									<div class="col-md-4 col-sm-8">
										<input class="text-field form-control input-sm" id="email" name="email" value="<?php echo $users->email; ?>" type="text" required>
									</div>
									<?php if($error2 > 0): ?>
											<div class="col-sm-6">
												<div class="alert alert-danger">
								<strong>Error...!</strong> El correo del usuario esta repetido.
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="form-group">
						<label class="col-md-2 col-sm-3 control-label">Registrado:</label>
						<div class="col-md-2 col-sm-4">
							<input class="text-field form-control input-sm" name="fecha_ing" id="fecha_ing" type="text" value="<?php echo $users->created_at; ?>" readonly>
						</div>

						<label class="col-sm-3 control-label">&nbsp;</label>
						<div class="col-sm-5">
							<span class="text-danger">Es un administrador...?</span>
							<div class="radiobutton">
								<input type="radio" name="iAdmin" value="1" <?php if($users->is_admin==1) echo 'checked'; ?>> Si
								<input type="radio" name="iAdmin" value="0" <?php if($users->is_admin==0) echo 'checked'; ?>> No
							</div>
						</div>
					</div>
						<div class="form-group">
							<label class="col-sm-2 col-sm-3 control-label">&nbsp;</label>
							<div class="col-md-4 col-sm-8">
								<span class="text-danger">Es un usuario activo...?</span>
								<div class="radiobutton">									<input type="radio" name="iActivo" value="1" <?php if($users->is_active==1) echo 'checked'; ?>> Si
									<input type="radio" name="iActivo" value="0" <?php if($users->is_active==0) echo 'checked'; ?>> No
								</div>
							</div>
						</div>
						<div class="col-sm-2 col-sm-3">
							<button type="submit" class="btn btn-success" onclick="javascript:verificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar </button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<!-- Page specific script -->
<script type='text/javascript'>
    document.title = "Near Solucions | Ingreso de Usuarios";
</script>
