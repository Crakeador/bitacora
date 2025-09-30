<?php
// Listado de las observaciones
// Visualicacion de la Bitacora Electronica
$hoy = date("Y-m-d"); $cadena = ""; $ahora=date("Y");

if(!isset($_SESSION['ano'])) $_SESSION['ano']=$ahora;
if(!isset($_SESSION['mes'])) $_SESSION['mes']=date("m");

if(isset($_GET['valor'])){
    if(isset($_GET['mes'])) $_SESSION['mes']=$_GET['mes'];
    if(isset($_GET['ano'])) $_SESSION['ano']=$_GET['ano'];
    
    $ini = $_SESSION['ano'].'-'.$_SESSION['mes'].'-'.'01 00:00:00';
    $fin = $_SESSION['ano'].'-'.$_SESSION['mes'].'-'.'31 00:00:00';
    
    $cadena = " AND fecha BETWEEN '".$ini."' AND '".$fin."'";
}else{
    if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
    if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
}

$users = BitacoraData::getParte($cadena);

if($_SESSION['is_admin'] == 1) {
    if($_SESSION['mes'] == '01') $cadena01 = 'selected'; else $cadena01 = '';
    if($_SESSION['mes'] == '02') $cadena02 = 'selected'; else $cadena02 = '';
    if($_SESSION['mes'] == '03') $cadena03 = 'selected'; else $cadena03 = '';
    if($_SESSION['mes'] == '04') $cadena04 = 'selected'; else $cadena04 = '';
    if($_SESSION['mes'] == '05') $cadena05 = 'selected'; else $cadena05 = '';
    if($_SESSION['mes'] == '06') $cadena06 = 'selected'; else $cadena06 = '';
    if($_SESSION['mes'] == '07') $cadena07 = 'selected'; else $cadena07 = '';
    if($_SESSION['mes'] == '08') $cadena08 = 'selected'; else $cadena08 = '';
    if($_SESSION['mes'] == '09') $cadena09 = 'selected'; else $cadena09 = '';
    if($_SESSION['mes'] == '10') $cadena10 = 'selected'; else $cadena10 = '';
    if($_SESSION['mes'] == '11') $cadena11 = 'selected'; else $cadena11 = '';
    if($_SESSION['mes'] == '12') $cadena12 = 'selected'; else $cadena12 = '';
    
    $lista = '';
    for ($i = 2022; $i <= $ahora; $i++) {
        if($_SESSION['ano'] == $i) $cadena = 'selected'; else $cadena = '';
        
        $lista = $lista . '<option value="'.$i.'" '.$cadena.'>'.$i.'</option>';
    }
    
    $valor = '</br>
        <div class="col-md-6 col-sm-10">
        	<label>Ver el reporte de asistencia de:&nbsp;
        		<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href=\'index.php?view=parte&valor=0&mes=\'+value;">
        			<option value="01" '.$cadena01.'>Enero</option>
        			<option value="02" '.$cadena02.'>Febrero</option>
        			<option value="03" '.$cadena03.'>Marzo</option>
        			<option value="04" '.$cadena04.'>Abril</option>
        			<option value="05" '.$cadena05.'>Mayo</option>
        			<option value="06" '.$cadena06.'>Junio</option>
        			<option value="07" '.$cadena07.'>Julio</option>
        			<option value="08" '.$cadena08.'>Agosto</option>
        			<option value="09" '.$cadena09.'>Septiembre</option>
        			<option value="10" '.$cadena10.'>Octubre</option>
        			<option value="11" '.$cadena11.'>Noviembre</option>
        			<option value="12" '.$cadena12.'>Diciembre</option>
        		</select>
        	</label>
        </div>										
        <div class="col-md-3 col-sm-10">			
        	<label>A&ntilde;o:&nbsp;&nbsp;
        		<select style="width: 120px; display: inline-block;" id="ano_id" name="ano_id" class="form-control" onchange="javascript:location.href=\'index.php?view=parte&valor=0&ano=\'+value;">'.
        			$lista.
        		'</select>
        	</label>
        </div>';
}else{
    $valor = '';
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora Electronica
		<small>listado de las observaciones</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">			
            <div class="box">
				<div class="box-header with-border">
					<a id="btn_productos" class="btn btn-success btn-sm" href="index.php?view=reporte">
						<span class="glyphicon glyphicon-plus"></span> Ingresar Parte
					</a>
					<?php
					    echo $valor;
            		?>
        		</div>					
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
					<form id='frmC' name='frmC' method='post' action=''>
                        <table id="viewBitacora" class="table table-bordered table-hover">
                            <thead>
                                <tr>
									<th><div align="center">Ingreso</div></th>
                                    <th width="8%"><div align="center">Codigo</div></th>
                                    <th width="8%"><div align="center">Foto</div></th>
                                    <th width="8%"><div align="center">Turno</div></th>
                                    <th width="8%"><div align="center">Punto GPS</div></th>
                                    <th>Nombre Completos</th>
                                    <th width="30%"><div align="center">Parte Informativo</div></th>
                                    <th width="8%"><div align="center">Acci&oacute;n</div></th>
                                </tr>
                            </thead>
                            <tbody>
  								<?php
									// Crea tabla de Ventas

									foreach($users as $tables){
										if($tables->foto1 == '') $cadena = 'storage/persons/american.png'; else $cadena = 'storage/parte/'.$tables->foto1;
										
										echo '<tr>';
											echo '<td><div align="center">'.$tables->fecha.'</div></td>';
										    echo '<td>'.$tables->codigo.'</td>';
    										echo '<td><div align="center"><img src="'.$cadena.'" style="width:64px;"></div></td>';
									        echo '<td>'.$tables->turno.'</td>';
											if($tables->mensaje == "")
												echo '<td><div align="center"><a class="text-primary" href="index.php?view=mapas&lat='.$tables->latitude.'&lot='.$tables->longitude.'">'.$tables->latitude.', '.$tables->longitude.'</a></div></td>';
											else
												echo '<td>'.$tables->mensaje.'</td>';
											echo '<td>';
										        echo $tables->lastname.' '.$tables->name.'</br>';
										        echo '<small>';
													if($tables->vistas == 0){
														echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
														echo '<span class="text-danger">Este parte no ha sido verificado</span>';
													}else{
														echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
														echo '<span class="text-success">Este evento se a visto '.$tables->vistas.' veces</span>';
													}
												echo '</small>';
    										echo '</td>';
        									echo '<td>'.$tables->observacion.'</td>';
											echo '<td>';
									 			  echo '<div align="center">';
									 			    echo '<a class="btn btn-info btn-sm" href="index.php?view=cambio&id='.$tables->id.'&ruta=3"><i class="fa fa-edit"></i></a>
														  <button type="button" class="btn btn-success btn-sm" onClick="btn_Imprimir('.$tables->id.')"><i class="fa fa-print"></i></button>';
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
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");
	
    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Reporte de Parte ";
	
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/parte_pdf.php?id='+$id,'Reporte de Bitacora','','1024','768','true');
	}
</script>
