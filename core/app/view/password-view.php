<?php
//Cambio de clave del sistema
//Session::seguridad();

if(isset($_POST['btn_update'])){
  if(isset($_SESSION["user_id"])){
    $user = UserData::getById($_SESSION["user_id"]);
    $password = sha1(md5($_POST["password"]));
    if($password==$user->password){
      $user->password = sha1(md5($_POST["newpassword"]));
      $user->update_passwd();
      setcookie("password_updated","true");
      print "<script>window.location='logout.php';</script>";
    }else{      
      echo'<script type="text/javascript">
            jQuery(function validation(){
              swal("Warning", "Confirma tu contraseña está mal ingresada", "warning", {
                button: "Continue",
              });
            });
          </script>';
    }
  }else {
    print "<script>window.location='home';</script>";
  }
}
?>
<section class="content-header">
    <h1>
        Perfil Actual: <?php echo $_SESSION['desrol']; ?> <small>el acceso al sistema es su responsabilidad</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content container-fluid"  style="padding: 1.5rem !important;">
  <div class="row">
    <div class="col-md-4">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Cambiar contraseña</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="changepasswd" method="post" action="password" role="form" autocomplete="off">
          <div class="box-body">
            <div class="col-lg-12">
              <div class="form-group">
                  <label for="password">Contraseña anterior</label>
                  <input type="text" class="form-control" id="password" name="password" placeholder="Contraseña Actual" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="newpassword">Nueva contraseña</label>
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Nueva Contraseña" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="confirmnewpassword">Confirmar contraseña</label>
                <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" placeholder="Confirmar Nueva Contraseña" autocomplete="off" required>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" name="btn_update">Actualización</button>
          </div>
        </form>
      </div>
    </div> <!-- /.box -->
    <div class="col-md-8">
      <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Perfil de usuario</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class='detail-text'>
                <strong>Nombre de usuario:</strong>
                <span class='text-data'> <?php echo $_SESSION['user_name']; ?></span><br><br>
                <strong>Nombre completo:</strong>
                <span class='text-data'> <?php echo utf8_decode(UserData::getById($_SESSION["user_id"])->name).' '.htmlentities(UserData::getById($_SESSION["user_id"])->lastname); ?></span><br><br>
                <strong>Correo:</strong>
                <span class='text-data'> <?php echo $_SESSION['email']; ?></span><br><br>
                <strong>Ultimo ingreso:</strong>
                <span class='text-data'> <?php echo $_SESSION['ultima_sesion']; ?></span><br>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
<script>
  document.title = "Near Solution | Cambio de clave";
 
  $("#changepasswd").submit(function(e){
    if($("#password").val()=="" || $("#newpassword").val()=="" || $("#confirmnewpassword").val()==""){
      e.preventDefault();
      sweetAlert('Error...!!!', 'Usted no puede dejar los campos vacios', 'error');
    }else{
      if($("#newpassword").val() == $("#confirmnewpassword").val()){
        //alert("Correcto");			
      }else{
        e.preventDefault();
        sweetAlert('Error...!!!', 'Las nueva contraseña no coincide con la confirmacion', 'error');
      }
    }
  });
</script>