<?php

//var_dump($_SESSION);
?>
<div class="row">
    <?php
        $persons = PersonData::getLike('idcard', $_GET["id"]);
        
        if(count($persons)>0){
            $cargos = CargoData::getById($persons->cargo);
            
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
    ?>
</div>