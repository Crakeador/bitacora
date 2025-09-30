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
        <form class="form-horizontal" id="changepasswd" method="post" action="index.php?view=password" role="form" autocomplete="off">
          <div class="box-body">
            <div class="col-lg-12">
              <div class="form-group">
                  <label for="oldpassword">Contraseña anterior</label>
                  <input type="text" class="form-control" id="password" name="password" placeholder="Contraseña Actual">
              </div>
              <div class="form-group">
                <label for="newpassword">Nueva contraseña</label>
                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Nueva Contraseña">
              </div>
              <div class="form-group">
                <label for="confirmpassword">Confirmar contraseña</label>
                <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" placeholder="Confirmar Nueva Contraseña">
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
                <label for="name"><strong>Nombre de usuario:</strong></label>
                <span class='text-data'> <?php echo $_SESSION['user_name']; ?></span><br>
                <label for="name"><strong>Nombre completo:</strong></label>
                <span class='text-data'> <?php echo utf8_decode(UserData::getById($_SESSION["user_id"])->name).' '.htmlentities(UserData::getById($_SESSION["user_id"])->lastname); ?></span><br>
                <label for="name"><strong>Correo:</strong></label>
                <span class='text-data'> <?php echo $_SESSION['email']; ?></span><br>
                <label for="name"><strong>Ultimo ingreso:</strong></label>
                <span class='text-data'> <?php echo $_SESSION['ultima_sesion']; ?></span>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
<script>
  document.title = "Near Solutions | Cambio de clave";
 
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