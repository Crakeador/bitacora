<?php
// Listado de los aspirantes
$users = PersonData::getAllTipo(4, 1);
$total = count($users);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Operaciones
		<small>listado de los aspirantes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">                	
	    		<div class="box-header with-border">
    				<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=opeasp.persons">
    					<span class="glyphicon glyphicon-plus"></span> Ingresar Aspirante
    				</a>
	    		</div>
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<form id='frmC' name='frmC' method='post' action=''>
					    <input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
					    <input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
                        <table id="viewlista" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="8%"><div align="center">Tel&eacute;fonos</div></th>
                                    <th>Nombre Completos</th>
                                    <th width="30%"><div align="center">Direcci&oacute;n</div></th>
                                    <th><div align="center">Ingreso</div></th>
                                    <th width="8%"><div align="center">Estado</div></th>
                                    <th width="8%"><div align="center">Acci&oacute;n</div></th>
                                </tr>
                            </thead>
                            <tbody>
  								<?php
									// Crea tabla de Ventas
									foreach($users as $tables) {
										echo '<tr>';
										    echo '<td>';
											    echo '<a href="tel:'.$tables->phone1.'">'.$tables->phone1.'</a></br><a href="tel:'.$tables->phone2.'">'.$tables->phone2.'</a></br><a href="tel:'.$tables->phone3.'">'.$tables->phone3.'</a>';
												echo '<td>';
										    	if($_SESSION["idrol"] == 1 && $_SESSION["idrol"] == 6)
													echo utf8_encode($tables->name).'</br>';
												else
													echo '<a class="text-primary" href="index.php?view=opeasp.persons&id='.$tables->id.'">'.utf8_encode($tables->name).'</a></br>';

												echo '<small>';
													if($tables->tiene_carnet == 1){
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Tiene carnet</span>';
													}else{
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Sin carnet</span>';
													}
													echo '&nbsp;&nbsp;-&nbsp;&nbsp;';
													if($tables->tiene_afis == 1){
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Tiene AFIS</span>';
													}else{
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Sin AFIS</span>';
													}
												echo '</small>';
										echo '</td>';
									echo '<td>'.$tables->direccion.'</td>';
									echo '<td><div align="center">'.$tables->update_at.'</div></td>';
											echo '<td>';
												if($tables->demanda == 0){
													echo '<span class="label label-success">&nbsp;&nbsp;&nbsp;&nbsp;Sin demanda&nbsp;&nbsp;&nbsp;&nbsp;</span>';
												}else{
													echo '<span class="label label-danger">Esta demandado&nbsp;&nbsp;</span>';
												}
											echo '</td>';
											echo '<td>';
									 			  echo '<div align="center">';
														echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-edit"></i></button>';
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
    </div>
</section>
<!-- Page specific script -->
<script type='text/javascript'><!--
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
