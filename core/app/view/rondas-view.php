<?php
// Visualicacion de la Bitacora Electronica
date_default_timezone_set('America/Guayaquil');
$mes = date("m"); $ano=date("Y");
$hoy = date("Y-m-d"); $cadena = "";

if($_SERVER['dispositivo'] == 1) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-30 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";
if($_SERVER['dispositivo'] == 2) $cadena = " AND fecha BETWEEN '".date("Y-m-d", strtotime("-10 day", strtotime($hoy)))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($hoy)))." 00:00:00'";

$users = BitacoraData::getRonda($cadena);

if(isset($_GET['mes'])){
	$mes=$_GET['mes'];
	$_SESSION['mes']=$mes;
}else{
	if(isset($_SESSION['mes']) && $_SESSION['mes'] > 1){
		$mes=$_SESSION['mes'];
	}else{
		$_SESSION['mes']=$mes;
	}
}

$puestos = PuestoData::getAll(2); $lugar = '';

If(isset($_POST["sd"])){
    $_SECCION["LOC"]=$_POST["id_localidad"];
    $_SECCION["INI"]=$_POST["sd"];
    $_SECCION["FIN"]=$_POST["ed"];
}else{
    $_SECCION["LOC"]=0;
    $_SECCION["INI"]="";
    $_SECCION["FIN"]="";
}

//var_dump($_SESSION);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora Electronica
		<small>listado de las rondas</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Busqueda de Datos</h3>
        
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Date range:</label>
                			<?php
                				echo '<select id="localidad_id" name="localidad_id" class="form-control">';
                				echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
                				foreach($puestos as $tables) {
                					if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
                					echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';
                				}
                				echo '</select>';
                			?>  
                      </div>
                      <!-- /.form-group -->
                      <div class="form-group">
                        <label>Date range:</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form-group -->
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
                  the plugin.
                </div>
              </div>
            <div class="box">
            	<!-- Main content -->
                <div class="box-body mailbox-messages">
                    <table id="viewBitacora" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="12%"><div align="center">Ingreso</div></th>
                                <th width="16%"><div align="center">Codigo</div></th>
                                <th width="20%">Nombre Completos</th>
                                <th width="8%"><div align="center">Punto GPS</div></th>
                                <th><div align="center">Observaci&oacute;n</div></th>
                                <th width="8%"><div align="center">Acci&oacute;n</div></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
								// Crea tabla de Rondas
								foreach($users as $tables){
									$rondas = BitacoraData::getByRondas($tables->idpuesto, $tables->punto);								    
								    $lati1 = substr($tables->latitude, 1, 5);
								    $lati2 = substr($rondas->latitude, 1, 5);
								    
								    if($lati1 == $lati2) 
								        $cadena = '<p class="text-green"><i class="fa fa-thumbs-o-up"></i> Esta dentro del rango</p>';
								    else 
								        $cadena = '<p class="text-red"><i class="fa fa-thumbs-o-down"></i> Esta fuera del rango</p>';
									/*
									//echo '<br><br>'.$tables->idpuesto.'-'.$tables->grupo.'-'.$tables->fecha.' Grupo: '.$tables->todos.'<br>';
									$i=0; $sumA=0; $sumB=0; 
									foreach($rondas as $ronda){
									    $i++; 
									    if($i > 1){
									        //echo '<br>   Fin: '.$ronda->fecha;
                                            // Fecha de finalizacion (puede ser la fecha actual)
                                            $fechaFin = new DateTime($ronda->fecha);
                                            // Calcular la diferencia entre las fechas
                                            $diff = $fechaIni->diff($fechaFin);
                                            
                                            //echo '<br>'.$diferencia->format('%Y anos %m meses %d days %H horas %i minutos %s segundos').'<br>';
                                            
                                            //echo "Diferencia de meses: " . $diferencia->i . " meses<br>";
                                            //echo "Diferencia de anos: " . $diferencia->s . " anos<br>";
                                            $sumA=$sumA+$diff->i;
                                            $sumB=$sumB+$diff->s;
                                            
                                            $sumA = $sumA + ((($diff->days * 24) * 60) + ($diff->i));

									        $fechaIni = new DateTime($ronda->fecha);
									        //echo '<br>Inicio: '.$ronda->fecha;
									    }else{
									        $fechaIni = new DateTime($ronda->fecha);
									        //echo '<br>Inicio: '.$ronda->fecha;
									    }
									} */
									
									echo '<tr>';
										echo '<td><div align="center">'.$tables->fecha.'</div></td>';
										echo '<td>'.$tables->descripcion.'</td>';
										echo '<td>';
										    echo $tables->name.'<br>';
										    echo '<small>';
										        if($tables->phone1 != '') echo '<span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$tables->phone1.'&nbsp;';
										        if($tables->phone2 != '') echo '- <span class="glyphicon glyphicon-phone text-success"></span>&nbsp;'.$tables->phone2;
										echo '</td>';
										if($tables->latitude == ""){
										    $cadena = 'No hay coordenadas registradas';
											if($tables->mensaje == "")
												echo '<td>'.$tables->mensaje.'</td>';
											else
												echo '<td>GPS Desconectado</td>';
										}else{
											echo '<td><div align="center"><a class="text-primary" href="index.php?view=mapas&lat='.$tables->latitude.'&lot='.$tables->longitude.'">'.$tables->latitude.', '.$tables->longitude.'</a></div></td>';
										}

										echo '<td>'.$tables->observacion.'<br>'.$cadena.'</td>';
										//echo '<td><div align="center">'.$sumA.' min.</div></td>';
										echo '<td>';
											  echo '<div align="center">';
												echo '<a href="index.php?view=rutas&id='.$tables->idpuesto.'&grupo='.$tables->grupo.'&fecha='.$tables->fecha.'" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>';
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
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type='text/javascript'><!--
    var element = document.getElementById("sidai");

    element.classList.add("sidebar-collapse");
    document.title = "Near Solutions | Bitacora Electronica";
	
	function btn_Imprimir($id) {
		VentanaCentrada('documentos/novedad_pdf.php?id='+$id,'Reporte de Bitacora','','1024','768','true');
	}
	
	function btn_Lista() {
		var valor1 = document.getElementById('localidad');
		var valor2 = document.getElementById('turno');
		var valor3 = document.getElementById('sd');
		var valor4 = document.getElementById('sm');

		puesto = valor1.value;
		turno = valor2.value;
		sd = valor3.value;
		sm = valor4.value;

		VentanaCentrada('documentos/bitacora_pdf.php?id='+puesto+'&turno='+turno+'&ini='+sd+'&fin='+sm,'Reporte de Bitacora','','1024','768','true');
	}
</script>

