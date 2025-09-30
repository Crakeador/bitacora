<?php
//Generacion de codigos QR
//Generado el: 08/02/2024

if(isset($_GET["id"])){
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = '/var/www/html/bitacora'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
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
    $data = "https://latin.near-solution.com/index.php?view=supervisar&puesto=".$_GET["id"];
    //$data = "http://bitacora/api/person/".$_GET["id"]; Generacion para la apliacion Mobil
    //user data
    
    $name = 'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    $filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    //display generated file
    echo "<script src=\"plugins/sweetalert/sweetalert.min.js\"></script>
          <script type=\"text/javascript\"><!--
              swal({                
              	 title: 'Codigo Generado',
                 text: '<img src=\"https://latin.near-solution.com/bitacora/temp/".$name."\"/>',                 
                 html: true,
                 type: 'success'
              });
          </script>";  
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Puestos
		<small>lista de los puestos de servicio</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Listado </li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<a id="btn_productos" class="btn btn-success btn-sm" href="puesto">
				<span class="glyphicon glyphicon-plus"></span> Ingresar un Puesto
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
					<form id='frmC' name='frmC' method='post' action=''>
						<input type='hidden' name='hid_frmEstado' id='hid_frmEstado' value='' />
						<input type='hidden' name='hid_frmIdrol' id='hid_frmIdrol' value='<?php echo $_SESSION['idrol']; ?>'/>
						<table id="viewlista" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Cientes</th>
								<th>Lugar</th>
								<th>Codigo</th>
								<th><div align="center">Horario</div></th>
								<th style="width:8%;"></th>
							</tr>
							</thead>
							<tbody>
							<?php
								$puestos = PuestoData::getAll(2);

								// Crea tabla de Ventas
								foreach($puestos as $sell) {
									if($sell->is_active == 1){ $activo = '<i class="fa fa-check"></i>'; }else{ $activo = '<i class="fa fa-times"></i>'; }

									echo '<tr>';
										echo '<td>'.$sell->cliente.'</br><small>'.$sell->lugar.'</small></td>';
										echo '<td>'.$sell->descripcion.'</br><small><i class="fa fa-toggle-on">&nbsp;</i>'.$sell->observacion.'</small></td>';
										echo '<td><b>'.$sell->codigo.'</b></td>';
										echo '<td>'.$sell->horas.' '.$sell->horario.'</td>';
										echo '<td><div align="center">';
										    echo '<button id="buttonQR'.$sell->id.'" title="Codigo'.$sell->id.'" type="button" class="btn btn-xs btn-default" onClick="btn_EnviarOnClick(\''.$sell->id.'\');"><i class="fa fa-qrcode"></i></button>';
										    echo '<a id="buttPuesto'.$sell->id.'" title="Resumen'.$sell->id.'"href="index.php?view=resumenpuesto&id='.$sell->id.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-eye-open"></i></a>';
										    echo '<a id="buttResumen'.$sell->id.'" title="Puesto'.$sell->id.'"href="index.php?view=puesto&id='.$sell->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a></div>';
										echo '</td>';
									echo '</tr>';
								}
							?>
							</tbody>
						</table>
					</form>
				</div>				
				<div class="tab-pane" id="tab_inactivos">
					<table id="viewlista" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Cientes</th>
							<th>Lugar</th>
							<th>Codigo</th>
							<th><div align="center">Horario</div></th>
							<th style="width:30px;"></th>
						</tr>
						</thead>
						<tbody>
						<?php
							$puestos = PuestoData::getAll(2, 0);

							// Crea tabla de Ventas
							foreach($puestos as $sell) {
								if($sell->is_active == 1){ $activo = '<i class="fa fa-check"></i>'; }else{ $activo = '<i class="fa fa-times"></i>'; }

								echo '<tr>';
									echo '<td>'.$sell->cliente.'</br><small>'.$sell->lugar.'</small></td>';
									echo '<td>'.$sell->descripcion.'</br><small><i class="fa fa-toggle-on">&nbsp;</i>'.$sell->observacion.'</small></td>';
									echo '<td><b>'.$sell->codigo.'</b></td>';
									echo '<td>'.$sell->horas.' '.$sell->horario.'</td>';
									echo '<td>';
									   echo '<a id="buttonOne" title="Resumen" href="index.php?view=resumenpuesto&id='.$sell->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-eye-open"></i></a>';
									   echo '<a id="buttonTwo" title="Imprime" href="index.php?view=puestos&id='.$sell->id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i></a>';
									echo '</td>';
								echo '</tr>';
							}
						?>
						</tbody>
					</table>
			</div>
		</div>
	</div>
</section>

<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Listado de puestos";
	
	function btn_EnviarOnClick($id) {		
		window.location.href = "./index.php?view=puestos&id="+$id;
	} //--
</script>