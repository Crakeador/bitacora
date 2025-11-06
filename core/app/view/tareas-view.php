<?php
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Manejar las solicitudes
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Mostrar la lista de anuncios
    break;
    case 'POST': 
        // Manejar la creación de un nuevo anuncio
		var_dump($_POST);
		
		$client = ClientData::getById($_SESSION["user_id"]);
		var_dump($client);
		$email = $client->email;

		$user = new TimelineData();
		$user->consigna = $_POST["consigna"];
		$user->prioridad = $_POST["prioridad"];
		$user->quien_asigna = $client->contacto;
		$user->status = 1;
		$user->type = 3;
		$user->asunto = $_POST["titulo"];
		$user->title = $_POST["cuerpo"];
		$user->date_event = $_POST["fecha"];

		$errors = $user->add_tarea();
			
		if(!empty($errors)){	
			$_SESSION['sweetalert_message'] = ['icon' => 'success', 'title' => '¡Éxito!', 'text' => 'Categoría agregada exitosamente.'];
		}else{
			$_SESSION['sweetalert_message'] = ['icon' => 'error', 'title' => '¡Error!', 'text' => 'Lo siento el registro falló.'];
		}
		$hoy = date("Y-m-d H:i:s");
    break;
}	
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Gestion Administrativa
		<small>listado de las tareas asignadas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <div class="row"><?php
		if (isset($_SESSION['sweetalert_message'])) {;
			echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js?v=1.0.1"></script>';
			$alert = $_SESSION['sweetalert_message'];
			echo "<script>
					document.addEventListener('DOMContentLoaded', function() {
					swal('".$alert['title']."', '".$alert['text']."', '".$alert['icon']."');
					});
				</script>";
			unset($_SESSION['sweetalert_message']); // Limpia la sesión después de usarla
		} ?>
        <div class="col-xs-12">
            <div class="box">
	    		<div class="box-header with-border">
					<button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> Nuevo</button>
	    		</div>
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<form id='frmC' name='frmC' method='post' action=''>
					    <input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
					    <input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
                        <table id="viewBitacora" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><div align="center">Asignado el</div></th>
                                    <th><div align="center">Entregar el</div></th>
                                    <th width="20%"><div align="center">Asignado por</div></th>
                                    <th width="14%"><div align="center">Asignado a</div></th>
                                    <th>Entregado por</th>
                                    <th width="8%"><div align="center">Acci&oacute;n</div></th>
                                </tr>
                            </thead>
                            <tbody>
  								<?php
  								    // Listado de los memos
                                    $users = TimelineData::getTipe(2);

									// Crea tabla de memos
									foreach($users as $tables) {
                                    	$nombre = UserData::getById($tables->idperson)->name.' '.UserData::getById($tables->idperson)->lastname;
                                        $email = UserData::getById($tables->idperson)->email;
									    //var_dump($tables);
										echo '<tr>';
									        echo '<td><div align="center">'.$tables->created_at.'</div></td>';
									        echo '<td><div align="center">'.$tables->date_event.'</div></td>';
									        echo '<td>'.$tables->quien_asigna.'<br>';
									        if($tables->date_pass == "" || $tables->date_pass == "0000-00-00 00:00:00"){
									            $boton = '';
									            
									            if($tables->status == 4){
    												echo '<span class="label label-success">TERMINADA</span>';
									            }else{
    												if($tables->prioridad == 0){
    													echo '<span class="label label-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BAJA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
    												}else{
        												if($tables->prioridad == 1){
        												    echo '<span class="label label-warning">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MEDIA&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        												}else{
        													echo '<span class="label label-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALTA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        												}
    												}
									            }
												$ini = explode(" ", $tables->date_event);
												$fin = date("Y-m-d");
												
												$fecha1 = new DateTime($ini[0]);
                                                $fecha2 = new DateTime($fin);
                                                
                                                $intervalo = $fecha1->diff($fecha2);
                                                $dias = $intervalo->format('%R%a');
                                                
                                                if($dias > 0){
                                                    echo " Se vencio hace: ".abs($intervalo->format('%R%a'))." días\n";
                                                }else{
                                                    echo " Se vence en: ".abs($intervalo->format('%R%a'))." días\n";
                                                }
									        }else{
									            //$boton = ' disabled';
									            echo '<span class="label label-success">TERMINADA</span><br>';
									            echo ' Reportada: '.$tables->date_pass;
									        }
									        echo '</td>';
									        echo '<td>'.$nombre.'<br>'.$email.'</td>';
									        echo '<td>'.$tables->title.'</br><small><span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;Elaborado el:&nbsp;'.$tables->created_at.'</small></td>';
											echo '<td>';
									 		  echo '<div align="center">';
									 		    if($_SESSION["usuario"] == $tables->quien_asigna){
    									 		    if($dias > 0)
    									 		        echo '<a class="btn btn-success btn-sm'.$boton.'" href="labor/'.$tables->id.'"><i class="fa fa-edit"></i></a>';
    									 		    else
    									 		        echo '<a class="btn btn-success btn-sm'.$boton.'" href="tarea/'.$tables->id.'"><i class="fa fa-edit"></i></a>';
									 		    }else{
									 		        echo '<button type="button" class="btn btn-success btn-sm'.$boton.'" onClick="btn_EnviarPermiso(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
									 		    }
											    echo '<button type="button" class="btn btn-danger btn-sm'.$boton.'" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash-o"></i></button>';
											  echo '</div>';
											echo '</td>';
										echo '</tr>';
  									}
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
		<!-- Modal Nuevo -->
		<div class="modal fade" id="modalNuevo">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" action="./tareas" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Ingreso de tareas</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="consigna">Consigna:</label>
								<select id="consigna" name="consigna" class="form-control">
									<option value="1" selected="selected"> Fija </option>
									<option value="2"> Eventual </option>
								</select>
							</div>
							<div class="form-group">
								<label for="titulo">Título</label>
								<input type="text" id="titulo" name="titulo" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="prioridad">Prioridad:</label>
								<select id="prioridad" name="prioridad" class="form-control">
									<option value="0" selected="selected"> Baja </option>
									<option value="1"> Media </option>
									<option value="2"> Alta </option>
								</select>
							</div>
							<div class="form-group">
								<label for="cuerpo">Contenido</label>
								<textarea id="cuerpo" name="cuerpo" class="form-control" rows="5" required></textarea>
							</div>
							<div class="form-group">
								<label for="id_fecha"><span class="text-danger">*</span> Fecha Maxima:</label>
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
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</section>
<!-- Page specific script -->
<script type='text/javascript'><!--
	function btn_EnviarPermiso(valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para modificar los registros', 'error');
	}
	
	function btn_EnviarOnClick(valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;

		 if(idrol > 3){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
				 title: "¿Seguro que deseas continuar?",
				 text: "No podrás deshacer este paso...!!!",
				 type: "warning",
				 showCancelButton: true,
				 cancelButtonText: "No, cancelar...!",
				 confirmButtonColor: "#DD6B55",
				 confirmButtonText: "Si, activar...!",
				 closeOnConfirm: false
			  }, function(isConfirm){
			  	 if (isConfirm) {
					 swal({
						title:"¡Bien Hecho!",
						text:"Se activo el agente en el sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						function(){
							location.href="./?view=delpersonal&id="+valor;
					});
				 }else{
					sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para activar agentes', 'error');
					swal({
						title:"¡Errrooooor!",
						text:"Se activo el agente del sistema.",
						type:"success",
						confirmButtonText:"Aceptar"
						},
						function(){
							location.href="./?view=delpersonal&id="+valor;
					});
				 }
			 });
		 }
	} //--
</script>
