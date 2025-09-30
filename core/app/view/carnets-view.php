<?php
//Generacion de codigos QR
//Generado el: 08/02/2024

if(isset($_GET["id"])){
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = '/var/www/latin.near-solution.com/public_html/temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "plugins/phpqrcode/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';

    $matrixPointSize = 4;
    $data = "https://latin.near-solution.com/index.php?action=searchpersons&id=".$_GET["id"];
    // user data
    
    $name = 'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    $filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    //display generated file
    echo "<script src=\"plugins/sweetalert/sweetalert.min.js\"></script>
          <script type=\"text/javascript\"><!--
              swal({                
              	 title: 'Codigo Generado',
                 text: '<img src=\"https://latin.near-solution.com/temp/".$name."\"/>',                 
                 html: true,
                 type: 'success'
              });
          </script>";  
}

?>
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
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab_activos" data-toggle="tab" aria-expanded="false"><b>Administrativos</b></a>
			</li>
			<li>
				<a href="#tab_inactivos" data-toggle="tab" aria-expanded="false"><b>Operativos</b></a>
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
										
										if($tables->tipo_sangre==0) $tipo = 'Sin definir';
                                        if($tables->tipo_sangre==1) $tipo = 'Tipo de Sangre: A-';
                                        if($tables->tipo_sangre==2) $tipo = 'Tipo de Sangre: A+';
                                        if($tables->tipo_sangre==3) $tipo = 'Tipo de Sangre: AB-';
                                        if($tables->tipo_sangre==4) $tipo = 'Tipo de Sangre: AB+';
                                        if($tables->tipo_sangre==5) $tipo = 'Tipo de Sangre: B-';
                                        if($tables->tipo_sangre==6) $tipo = 'Tipo de Sangre: B+';
                                        if($tables->tipo_sangre==7) $tipo = 'Tipo de Sangre: O-';
                                        if($tables->tipo_sangre==8) $tipo = 'Tipo de Sangre: O+';

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
											echo '</small>';
										echo '</td>';
										echo '<td><div align="center">'.$tables->phone1.'</div></td>';
										echo '<td>'.$tables->description.'</br>'.$tipo.'</td>';
										echo '<td><div align="center">'.$tables->startwork.'</div></td>';
										echo '<td><div align="center">'.$tables->endwork.'</div></td>';
										echo '<td width="8%">';
											echo '<div align="center">';
												echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idcard.'\');"><i class="fa fa-qrcode"></i></button>';
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
								<th style="width: 30%;">Nombre Completos</th>
								<th width="10%"><div align="center">Telefono</div></th>
								<th style="width: 20%;"><div align="center">Cargo</div></th>
								<th width="10%"><div align="center">Ingreso</div></th>
								<th width="10%"><div align="center">Salida</div></th>
								<th><div align="center">Acci&oacute;n</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$users = PersonData::getAllTipo(3, 1);

								// Crea tabla de personal administrativo
								foreach($users as $tables) {
									echo '<tr>';
										if (is_null($tables->image)) {
											echo '<td><div align="center"><img src="storage/persons/1234567890.jpg" style="width:64px;"></div></td>';
										} else {
											echo '<td><div align="center"><img src="storage/persons/'.$tables->image.'" style="width:64px;"></div></td>';
										}										
										
										if($tables->tipo_sangre==0) $tipo = 'Sin definir';
                                        if($tables->tipo_sangre==1) $tipo = 'Tipo de Sangre: A-';
                                        if($tables->tipo_sangre==2) $tipo = 'Tipo de Sangre: A+';
                                        if($tables->tipo_sangre==3) $tipo = 'Tipo de Sangre: AB-';
                                        if($tables->tipo_sangre==4) $tipo = 'Tipo de Sangre: AB+';
                                        if($tables->tipo_sangre==5) $tipo = 'Tipo de Sangre: B-';
                                        if($tables->tipo_sangre==6) $tipo = 'Tipo de Sangre: B+';
                                        if($tables->tipo_sangre==7) $tipo = 'Tipo de Sangre: O-';
                                        if($tables->tipo_sangre==8) $tipo = 'Tipo de Sangre: O+';
                                        
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
											echo '</small>';
										echo '</td>';
										echo '<td><div align="center">'.$tables->phone1.'</div></td>';
										echo '<td>'.$tables->description.'</br>'.$tipo.'</td>';
										echo '<td><div align="center">'.$tables->startwork.'</div></td>';
										echo '<td><div align="center">'.$tables->endwork.'</div></td>';
										echo '<td width="8%">';
											echo '<div align="center">';
												echo '<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarOnClick(\''.$tables->idcard.'\');"><i class="fa fa-qrcode"></i></button>';
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
<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Generacion de codigos";
	
	function btn_EnviarOnClick($id) {		
		window.location.href = "./index.php?view=carnets&id="+$id;
	} //--
</script>
