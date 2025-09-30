<html>
    <head>    
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  <!-- Cambiado por mi: <meta charset="utf-8"> -->
        <meta name="googlebot" content="impuestos, creacion de compania">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- Denine el ancho de la pantalla a ser utilizado -->
        <meta name="robots" content="contabilidad, impuestos, facturacion electronica">
        <meta name="author" content="Jorge Fiallos">
        <meta name="keywords" content="nearsolutions, seguridad, facturacion electronica, contabilidad">
        <meta name="description" content="Puedes tener el control de tu negocio con nuestro módulos desarrollados en casos reales de los diferentes negocios en el Ecuador">
        <title>Near Solution | Dashboard</title>
        <meta property="og:url" content="https://near-solution.com/">
        <meta property="og:title" content="Near Soft ERP">
        <link rel="icon" type="image/jpg" href="./assets/images/icon-service.png">
        <link type="text/css" rel="stylesheet" href="assets/css/dashforge.css">
        <link type="text/css" rel="stylesheet" href="assets/css/dashforge.auth.css">
    </head>
    <body id="sidai">
      <!-- Content Wrapper. Contains page content -->
      <!-- Pantalla de Logeo -->
      <header class="navbar navbar-header navbar-header-fixed">
        <div class="navbar-brand">
          <div class="df-logo">Credencial <span>Eléctronica</span></div>
        </div><!-- navbar-brand -->
      </header><!-- navbar -->
      <div class="content content-fixed content-auth" style="background-image: url('assets/images/logo.jpeg'); background-repeat:no-repeat; background-size:cover; background-position:center center;">
        <div class="containerDg">
            <div class="row">
                <?php 
                    var_dump($_GET);
                    if(isset($_GET["id"]) && $_GET["id"]!=""){
                        $persons = PersonData::getLike('idcard', $_GET["id"]);
                        
                        if(count($persons)>0){
                            $cargos = CargoData::getById($persons->cargo);
                            var_dump($cargos);
                            if($persons->is_active=='1'){
                                $activo = 'Activo';
                                $clase = '';
                            } else {
                                $activo = 'Desvinculado';
                                $clase = 'tx-white bg-danger';
                            }
                            if($persons->image==NULL) $cadena = '1234567890.jpg'; else $cadena = $persons->image;
                            
                            switch ($persons->tipo_sangre) {
                                case "0":
                                    $tipo = "No se ha definido";
                                    break;
                                case "1":
                                    $tipo = "A-";
                                    break;
                                case "2":
                                    $tipo = "A+";
                                    break;
                                case "3":   
                                    $tipo = "AB-";
                                    break;
                                case "4":
                                    $tipo = "AB+";
                                    break;
                                case "5":
                                    $tipo = "B-";
                                    break;
                                case "6":
                                    $tipo = "B+";
                                    break;
                                case "7":
                                    $tipo = "O-";
                                    break;
                                case "8":
                                    $tipo = "O+";
                                    break;
                                default:
                                    $tipo = "No se ha definido";
                            }
                            echo '<div class="col-sm">
                                        <div class="card '.$clase.'">
                                            <img src="storage/persons/'.$cadena.'" class="card-img-top" alt="Foto de perfil">
                                            <div class="card-body">
                                                <fieldset class="form-fieldset">
                                                    <legend>Informacion personal</legend>
                                                    <div class="form-group">
                                                        <label for="formGroupExampleInput" class="d-block">Cedula:</label>
                                                        <input type="text" class="form-control" placeholder="Enter your firstname" value="'.$_GET["id"].'">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="formGroupExampleInput" class="d-block">Nombres:</label>
                                                        <input type="text" class="form-control" placeholder="Enter your firstname" value="'.$persons->name.'">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="formGroupExampleInput" class="d-block">Tipo de Sangre:</label>
                                                        <input type="text" class="form-control" placeholder="Enter your firstname" value="'.$tipo.'">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="formGroupExampleInput" class="d-block">Cargo:</label>
                                                        <input type="text" class="form-control" placeholder="Enter your firstname" value="'.$cargos->description.'">
                                                    </div>
                                                    <p class="card-text">Personal: '.$activo.'</p>
                                                    <p class="card-text">Contratado el: '.$persons->startwork.'</p>
                                                    <p class="card-text">Desvinculado el: '.$persons->endwork.'</p>
                                                </fieldset>
                                                </br>
                                                <form>
                                                    <div class="form-group">
                                                        <label for="formGroupExampleInput2" class="d-block">Observaciones</label>
                                                        <input type="text" class="form-control" placeholder="ingrese sus dudas">
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                                </form>
                                            </div>
                                            <div class="card-footer">
                                                Empresa de seguridad
                                                <a href="https://near-solution.com/">Near Solution</a>
                                            </div>
                                        </div>
                                  </div>';
                        }else{
                            echo '<div class="media align-items-stretch justify-content-center ht-100p pos-relative" style="color=white;">
                                        <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                                          <div class="wd-100p" style="color:white;">
                                            <img src="assets/images/american.png" class="img-fluid" alt="SIP Security">
                                              <br>
                                          </div>
                                        </div><!-- sign-wrapper -->
                                    </div><!-- media -->
                                    <div class="col-sm-6 mg-t-10 mg-sm-t-25">
                                    <div class="card tx-white bg-danger">
                                        <div class="card-header tx-semibold">'.$_GET["id"].'</div>
                                            <div class="card-body">
                                                <p class="card-text">Este persona no esta registrada en el sistema y pude ser denunciada por estar en un puesto que no es custodiado por la empresa.</p>
                                            </div>
                                        </div>
                                    </div>
                                 </div>';
                        }
                    }else{
                        echo '<div class="media align-items-stretch justify-content-center ht-100p pos-relative" style="color=white;">
                                    <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                                      <div class="wd-100p" style="color:white;">
                                        <img src="assets/images/american.png" class="img-fluid" alt="SIP Security">
                                          <br>
                                      </div>
                                    </div><!-- sign-wrapper -->
                                </div><!-- media -->
                                <div class="card">';
                            echo '<h4>No tiene permisos para ver esta pagina</h4>';
                            echo '<br><p class="alert alert-danger">No se encontro el producto</p>';
                            echo '<p>El sistema no tiene informaci&oacute;n que mostrar, si tiene alguna duda sobre el proceso que necesita verifique en nuestras oficinas con el personal de RRHH</p>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div><!-- container -->
      </div><!-- content -->
      <footer class="footer">
        <div>
          <span>© 2020 Bitacora <span>Eléctronica</span> v3.0 </span>
          <span>Created by <a href="https://nearsolutions.com.ec">NEAR Solutions</a></span>
        </div>
        <div>
          <nav class="nav">
            <a href="https://nearsolutions.com.ec/licenses/standard" class="nav-link">Licencia</a>
            <a href="https://nearsolutions.com.ec/help" class="nav-link">Ayuda</a>
          </nav>
        </div>
      </footer>
</body></html>