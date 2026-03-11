<?php 
//Asignacion de Tarea
$companys = CompanyData::getById($_SESSION["id_company"]); 
$users = UserData::getAll();

if(count($_POST)>0){
	$client = ClientData::getById($_SESSION["user_id"]);
    $email = $client->email;
	
    if(isset($_POST["prorroga"])) $prorroga = 1; $prorroga = 0;
 
	$user = new TimelineData();
	$user->idperson = $_SESSION["id_person"];
	$user->prioridad = $_POST["prioridad"];
	$user->quien_asigna = $client->contacto;
	$user->status = 1;
	$user->type = 3;
	$user->asunto = $_POST["asunto"];
	$user->title = $_POST["descripcion"];
	$user->date_event = $_POST["fecha"];
	$user->prorroga = $prorroga;
	$user->add_task();
 
	$hoy = date("Y-m-d H:i:s");

	// Varios destinatarios
	$para  = $email; // atención a la coma
	$email_from = 'Gilbert Lerma <j.fiallos@grupolatinamerica.com>';
	$título = 'Solicitud de actividades asignada por: '.$nombre;

    if($_POST["prioridad"]==1) 
    
    switch ($_POST["prioridad"]) {
      case "1":
        $color = 'background-color:#59baa8;color:#ffffff;';
        $prioridad = 'Prioridad: Baja';
        break;
      case "2":
        $color = 'background-color:#FFFF00;color:#000000;';
        $prioridad = 'Prioridad: Media';
        break;
      case "3":
        $color = 'background-color:#FF0000;color:#ffffff;';
        $prioridad = 'Prioridad: Media';
        break;
      default:
        $prioridad = "No definido";
    }
    
    if($prorroga) $nada = 'Tiene opcion a prorroga de la fecha maxima'; else $nada = 'No tiene opcion a porrogar la fecha maxima de entrega';
	/* Envio de correos */
	$mensaje = '<html>
            	<head>
            	    <title>Tiene Una actividad Pendiente</title>
            	</head>
            	<body>            	
            		<div style="font-size:14px;font-weight:normal;color:#333333;line-height:20px;margin:20px">
                		<table style="box-sizing:border-box;border-collapse:separate!important;width:100%;background-color:#fff;border-spacing:0;vertical-align:top;text-align:left;height:100%;color:#222222;font-family:&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px" width="100%" bgcolor="#fff">
                        	<tbody>
                            	<tr style="vertical-align:top;text-align:left;padding:0" align="left">
                            		<td style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,Helvetica,Arial,sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;width:580px;word-break:break-word;border-collapse:collapse!important;text-align:left;color:#222222;font-weight:normal;line-height:19px;margin:0 auto;padding:24px" width="580" valign="top" align="left">
                                		<div style="box-sizing:border-box;border-collapse:separate!important;width:100%;background-color:#fff;border-spacing:0;vertical-align:top;text-align:left;height:100%;color:#222222;font-family:&quot;Helvetica&quot;,&quot;Arial&quot;,sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:10px" width="100%" bgcolor="#fff">
                                            <p style="font-size:16px">Hola, <strong style="color:#3366bb">'.$_SESSION["usuario"].'</strong> le asigno una tarea, tienes una asignacion de <strong style="color:#5cb85c">1 Tarea pendiente</strong>:</p>                                            
                                            <div style="font-family:Arial,sans-serif;font-size:15px;background-color:#ffffff;border-radius:10px;border:1px solid #e1e5ea">
                                            	<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family:Arial,sans-serif;border-radius:10px">
                                            		<tbody>
                                            			<tr>
                                            				<td class="m_7958746675968730075box_mbl" style="padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                                            					<table style="font-family:Arial,sans-serif" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            						<tbody>
                                            							<tr>
                                            								<td style="font-size:14px;padding-bottom:10px">
                                            								    <span style="border-radius:50px;'.$color.'font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;display:inline-block;margin-top:5px;margin-right:5px">'.$prioridad.'</span>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075title_oferta" style="font-size:18px;padding-bottom:10px;line-height:24px">
                                            									<strong>ASUNTO DE TAREA: '.$_POST["asunto"].'</strong>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075texto_oferta" style="font-size:16px;padding-bottom:5px;line-height:24px">
                                            									<p><b>FECHA DE INICIO DE LA SOLICITUD: </b>'.$hoy.'</p>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075texto_oferta" style="font-size:16px;padding-bottom:10px;line-height:24px">
                                            									<p><b>FECHA MÁXIMA DE ENTREGA ES: </b>'.$_POST["fecha"].'</p>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075texto_oferta" style="font-size:16px;padding-bottom:10px;line-height:24px">
                                            									<p><b>PORCENTAJE DE INCUMPLIMIENTO: </b>'.$_POST ["porcentaje"].'% salario básico<p>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075texto_oferta" style="font-size:16px;padding-bottom:10px;line-height:24px">
                                            									<p><b>OPCIÓN A PRORROGA: </b>'.$nada.'</p>
                                            								</td>
                                            							</tr>
                                            							<tr>
                                            								<td class="m_7958746675968730075texto_oferta" style="font-size:16px;padding-bottom:10px;line-height:24px">
                                            									<p><b>OBSERVACION: </b>'.$_POST["descripcion"].'</p>
                                            								</td>
                                            							</tr>
                                            						</tbody>
                                            					</table>
                                            				</td>
                                            			</tr>
                                            		</tbody>
                                            	</table>
                                            </div> 
                                    		<!-- p><b>FECHA DE INICIO DE LA SOLICITUD: </b>'.$hoy.'</p>
                                    	    <p><b>FECHA MÁXIMA DE ENTREGA ES: </b>'.$_POST["fecha"].'</p>
                                    	    <p><b>ASUNTO DE TAREA: </b>'.$_POST["asunto"].'</p>
                                    	    <P><b>IMPORTANCIA: </b>'.$prioridad.'<P>
                                            <p><b>PORCENTAJE DE INCUMPLIMIENTO: </b>'.$_POST ["porcentaje"].'% salario básico<p>
                                            <p><b>OPCIÓN A PRORROGA: </b>'.$nada.'</p>
                                    	    
                                    	    <p><b>OBSERVACION: </b>'.$_POST["descripcion"].'</p -->
                                    	</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            	</body>
            	</html>';
    
    // Set the headers
    $headers = [
        "MIME-Version: 1.0",
        "Content-type: text/html; charset=UTF-8",
        'From: Recordatorio <info@grupolatinamerica.com>',
        'Cc: Jorge Fiallos <jorgefiallos@gmail.com>',
    ];
    
	// Enviarlo
	$bool = mail($para, $título, $mensaje, implode("\r\n", $headers));
	
	if ($bool) {
        //echo '<br>----------------------<br>Success...!' . PHP_EOL;
    } else {
        echo 'Error.' . PHP_EOL;
    }
	
	//Core::redir('tareas'); 
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tareas
		<small>asignaci&oacute;n de tareas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php if($_SESSION["idrol"] == 8) echo 'tareas'; else echo 'home'; ?>"><?php if($_SESSION["is_admin"] == 1) echo '<i class="fa fa-database"></i> Tareas'; else echo '<i class="fa fa-dashboard"></i> Inicio'; ?> </a></li>
		<li class="active"> Asignaci&oacute;n</li>
	</ol>
</section>
</br>
<section id="main" role="main">
    <div class="container-fluid">
		<!-- Dialogo para seleccionar una cuenta -->
		<p class="alert alert-info">
			<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
			- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
		</p>
		<!-- START panel -->
		<form class="form-horizontal" method="post" id="addtask" action="tarea" role="form">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Asignaci&oacute;n de tareas</h3>
				</div>
				<div class="panel-body">				    
			        <button type="submit" id="signin-button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Agregar Tarea</button>
					<div class="form-group">
						<div class="col-md-6 col-sm-3">
							<span class="text-danger">&nbsp;</span>
						</div>
						<div class="col-sm-2">
							<span class="text-danger">&nbsp;</span>
						</div>
					</div>
					<div class="form-group">
						<label for="id_fecha" class="col-md-2 control-label"><span class="text-danger">*</span> Fecha Maxima:</label>
						<div class="col-md-4">
							<div class="input-group date" id="datetimepicker1">
                               <input type="text" class="form-control" id="id_fecha" name="fecha" required/>
                               <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-remove"></span>
                               </span>
                               <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                               </span>
                            </div>
						</div>
					</div>
					<div class="form-group">
						<label for="id_prioridad" class="col-sm-2 control-label"> Prioridad:</label>
						<div class="col-md-4">
							<select class="select-input form-control" id="id_prioridad" name="prioridad">
								<option value="0" selected="selected"> Baja </option>
								<option value="1"> Media </option>
								<option value="2"> Alta </option>
							</select>
						</div>
					</div>			
    				<div class="form-group">
    					<label for="asunto" class="col-sm-2 control-label"><span class="text-danger">*</span> Asunto:</label>
    					<div class="col-sm-4">
    					    <input class="text-field form-control input-sm" id="asunto" name="asunto" type="text" value="" placeholder="Asunto de la Tarea" required>
    					</div>
    				</div>
					<div class="form-group">
						<label for="id_descripcion" class="col-sm-2 col-sm-4 control-label"><span class="text-danger">*</span> Observaci&oacute;n:</label>
						<div class="col-md-4">
							<textarea class="form-control input-sm" cols="50%" id="id_descripcion" name="descripcion" rows="4" required></textarea>
						</div>
					</div>
    				<div class="form-group">
    				    <div class="col-sm-3">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="optionsRadios" id="optionsRadios1" value="0" checked="">
                                  No tiene proroga
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="optionsRadios" id="optionsRadios2" value="1">
                                  Si tiene proroga
                                </label>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</form>
		</br>
	</div>
	<!--/ END To Top Scroller -->
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Asignacion de las tareas";
	
	$(document).ready(function(){
    	$('input').iCheck({
    	    checkboxClass: 'icheckbox_flat-red',
    	    radioClass: 'iradio_flat-red'
    	});
	
    	$(function () {
            $('#datetimepicker1').datetimepicker();
        });
	});
</script>