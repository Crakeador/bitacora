<!-- Content Header (Page header) --> 
<section class="content-header">
	<h1>
		Talento Humano
		<small>listado del personal administrativo</small>
	</h1>
	<ol class="breadcrumb">
		<li class="active"><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
    <div class="box box-primary">
    	<div class="box-header with-border">
    		<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=addpersons">
    			<span class="glyphicon glyphicon-plus"></span> Ingresar Personal
    		</a>
    	</div>
		<!-- tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Activos</b></a>
			</li>
			<li>
				<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Inactivos</b></a>
			</li>
		</ul>
        <div class="box-body mailbox-messages">
			<!-- tabs content -->
			<div class="tab-content panel">
              	<div class="tab-pane active" id="tab_activos">
					<table id="viewactivo" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="8%"><div align="center">Fotos</div></th>
								<th width="8%"><div align="center">C.C.</div></th>
								<th>Nombre Completos</th>
								<th width="10%"><div align="center">Telefono</div></th>
								<th><div align="center">Cargo</div></th>
								<th width="10%"><div align="center">Ingreso</div></th>
								<th width="10%"><div align="center">Salida</div></th>
								<th><div align="center">Acci&oacute;n</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$users = PersonData::getOficina(1);

								// Crea tabla de personal administrativo
								foreach($users as $tables) {
									echo '<tr>';
										if (is_null($tables->image)) {
											echo '<td><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
										} else {
											echo '<td><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
										}

										echo '<td><div align="center">'.$tables->idcard.'</div></td>';
										echo '<td>';
											echo $tables->name.'</br>'; //utf8_encode()
											echo '<small>';
											if($tables->is_active == 1){
												echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
												echo '<span class="text-success">Activo</span>';
											}else{
												echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
												echo '<span class="text-danger">Inactivo</span>';
											}
											echo '</small>';/*
											echo '<small>';
												if($tables->completo == 1){
													echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
													echo '<span class="text-success">El formulario esta completo</span>';
												}else{
													echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
													echo '<span class="text-danger">El formulario le falta datos</span>';
												}
											echo '</small>';*/
										echo '</td>';
										echo '<td><div align="center">'.$tables->phone1.'</div></td>';
										echo '<td>'.$tables->description.'</td>';
										echo '<td><div align="center">'.$tables->startwork.'</div></td>';
										echo '<td><div align="center">'.$tables->endwork.'</div></td>';
										echo '<td width="8%">';
											echo '<div align="center">';
												echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
												echo '<a href="index.php?view=addpersons&id='.$tables->id.'" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
											echo '</div>';
										echo '</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab_inactivos">
					<table id="viewnomina" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th width="8%"><div align="center">Fotos</div></th>
								<th width="8%"><div align="center">C.C.</div></th>
								<th>Nombre Completos</th>
								<th width="10%"><div align="center">Telefono</div></th>
								<th><div align="center">Cargo</div></th>
								<th width="10%"><div align="center">Ingreso</div></th>
								<th width="10%"><div align="center">Salida</div></th>
								<th><div align="center">Acci&oacute;n</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$users = PersonData::getOficina(0);

								// Crea tabla de personal administrativo
								foreach($users as $tables) {
									echo '<tr>';
										if (is_null($tables->image)) {
											echo '<td><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
										} else {
											echo '<td><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
										}
										echo '<td><div align="center">'.$tables->idcard.'</div></td>';
										echo '<td>';
											echo $tables->name.'</br>';
											echo '<small>';
											if($tables->is_active == 1){
												echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
												echo '<span class="text-success">Activo</span>';
											}else{
												echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
												echo '<span class="text-danger">Inactivo</span>';
											}
											echo '</small>';/*
											echo '<small>';
												if($tables->completo == 1){
													echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
													echo '<span class="text-success">El formulario esta completo</span>';
												}else{
													echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
													echo '<span class="text-danger">El formulario le falta datos</span>';
												}
											echo '</small>';*/
										echo '</td>';
										echo '<td><div align="center">'.$tables->phone1.'</div></td>';
										echo '<td>'.$tables->description.'</td>';
										echo '<td><div align="center">'.$tables->startwork.'</div></td>';
										echo '<td><div align="center">'.$tables->endwork.'</div></td>';
										echo '<td width="8%">';
											echo '<div align="center">';
												echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\');"><i class="fa fa-trash"></i></button>';
												echo '<a href="index.php?view=addpersons&id='.$tables->id.'" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>';
											echo '</div>';
										echo '</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>

			</div>

        </div>

    </div>

</section>

<!-- Page specific script -->

<script>document.title = "Listado del personal"</script>

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

				 confirmButtonText: "Si, Eliminar...!",

				 closeOnConfirm: false

			  }, function(isConfirm){

			  	 if (isConfirm) {

					 swal({

						title:"¡Bien Hecho!",

						text:"Se desincorporo el agente del sistema.",

						type:"success",

						confirmButtonText:"Aceptar"

						},



						function(){

							location.href="./index.php?view=delpersonal&id="+valor;

					});

				 }else{

					sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');

					swal({

						title:"¡Bien Hecho!",

						text:"Se desincorporo el agente del sistema.",

						type:"success",

						confirmButtonText:"Aceptar"

						},



						function(){

							location.href="./index.php?view=delpersonal&id="+valor;

					});

				 }

			 });

		 }

	} //--

</script>

