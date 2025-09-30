<?php
// Modulo de Operaciones para el registro del horario de los agentes activos
$_SESSION['tipo']='3';
$puestos = PuestoData::getAll(2);

if(!isset($_SESSION['mes'])) $_SESSION['mes']=date("m"); else $mes=$_SESSION['mes'];
if(!isset($_SESSION['ano'])) $_SESSION['ano']=date("Y"); else $ano=$_SESSION['ano'];

if(isset($_GET['id'])){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	if(isset($_SESSION['id'])) 
		$lugar=$_SESSION['id'];
	else
		$lugar=0;
}

$fecha=$_SESSION['ano']."-".$_SESSION['mes']."-01";
$total=date("t");
$dia=date("d");

?>
<section class="content-header">
	<h1>
		Agentes Activos
		<small>registro de la asistencia de los agentes activos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
	<div class="box">		
		<div class="box-header with-border">
			<div class="col-md-6 col-sm-10">
				<div id="example_filter">
					Puesto de trabajo:&nbsp;&nbsp;
					<label>
						<?php
							echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?action=despliegue&tipo=3&id=\'+value;">';
							echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
							foreach($puestos as $tables) {
								if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
								echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';  
							}
							echo '</select>';
						?>
					</label>					
				</div>
			</div>
			<div class="pull-right">
				<a id="btn_productos" class="btn btn-success btn-sm" href="./index.php?view=reporte">
					<span class="glyphicon glyphicon-plus"></span> Novedades
				</a>
			    <!-- Obseraciones con Ventana Modal
				<button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
					Observaciones
				</button> -->
			</div>
		</div>	
		<div class="box-body mailbox-messages">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-dismissable alert-info">
						<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
						<p> - Los turnos se identifican con los siguientes colores:&nbsp;</br>
							<span class="external-event bg-green" >D</span>&nbsp;Diurno,&nbsp;
							<span class="external-event bg-teal"  >N</span>&nbsp;Nocturno,&nbsp;
							<span class="external-event bg-yellow">L</span>&nbsp;Libre,&nbsp;
							<span class="external-event bg-red"   >F</span>&nbsp;Falta,&nbsp;
							<span class="external-event bg-purple">LT</span>&nbsp;Libre trabajado,&nbsp;
							<span class="external-event bg-blue"  >DN</span>&nbsp;
							<span class="external-event bg-fuchsia" >ND</span>&nbsp;Dobladas y
							<span class="external-event bg-orange" >DM</span>&nbsp;Diurno con Moto,&nbsp;
							<span class="external-event bg-maroon" >NM</span>&nbsp;Nocturno con Moto
						</p>
					</div>
				</div>
			</div>
			<div id="content"></div>
			<div style="height: 410px; width: 100%; overflow-x: auto;" id="example_length">
				<?php			    
					$ini="2020-01-01"; $fin=$_SESSION['ano']."-".$_SESSION['mes']."-30";
					if($lugar != 0){
						$users = PuestoData::getByIdHorario($lugar, 3, 1, $ini, $fin); 
						
						echo '<table id="horario" class="table table-bordered table-hover">';
							echo '<tbody>';
							// Crea tabla de agentes activos

							foreach($users as $tables) {
								$valores = HorarioData::getByTurnos($tables['servicio'], $tables['id'], $mes, $ano, 2);
								$resultado = count($valores); $i = 0; $asi = 0; $lib = 0; $fal = 0; $turno = ''; $clase = 'btn-default'; $id = 0;
								
								foreach($valores as $valor) {
								    $i++;
								    //Totalizar los valores
									if($valor['turno']=="1") $asi++;
									if($valor['turno']=="2") $asi++;
									if($valor['turno']=="3") $lib++;
									if($valor['turno']=="4") $fal++;
									if($valor['turno']=="5") $asi++;
									if($valor['turno']=="6") $asi++;
									if($valor['turno']=="7") $asi++;
									if($valor['turno']=="8") $asi++;
									if($valor['turno']=="9") $asi++;
									
									if($valor['dia']==date("d")){ 
									    $turno = $valor['turno'];
									    $id = $valor['id'];
									}
								} 
								
								if($turno== 1) $clase = 'btn-success';
								if($turno== 2) $clase = 'btn-primary';
								if($turno== 3) $clase = 'btn-warning';
								if($turno== 4) $clase = 'btn-danger';
								if($turno== 5) $clase = 'bg-purple';
								if($turno== 6) $clase = 'btn-bitbucket';
								if($turno== 7) $clase = 'btn-github';
								if($turno== 8) $clase = 'btn-dropbox';
								if($turno== 9) $clase = 'btn-foursquare';
								if($turno==10) $clase = 'btn-flickr';
								
								$por = (($asi+$lib)*100)/date("t"); $i = date("d");
								
								if($tables['phone1'] == '')
								    $telefono = ' - <span class="glyphicon glyphicon-phone text-red"></span> <span class="text-red">Telefono no definido</span>';
								else
								    $telefono = ' - <span class="glyphicon glyphicon-phone text-success"></span> '.$tables['phone1'];
								    
								if($tables['phone2'] == '')
								    $telefono .= '';
								else
								    $telefono .= ' - <span class="glyphicon glyphicon-earphone text-success"></span>'.$tables['phone2'];
																
								$por = (($asi+$lib)*100)/date("t"); $i = date("d");
								echo '<tr>
                                        <td width="30%" align="center">Agente</td>
                                        <td width="8%" align="center">HOY</td>
                                        <td width="8%" align="center">Asistencias</td>
                                        <td width="8%" align="center">Libres</td>
                                        <td width="8%" align="center">Faltas</td>
                                        <td width="10%" align="center">%</td>
                                      </tr>
                                      <tr>
									    <td>
										   <small>'
											.$tables['nombre'].
											'</br>Ingreso el: '.$tables['startwork'].$telefono.'
										   </small></br>
									    </td>
									    <td align="center">
									    	<input type="hidden" id="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" value="'.$tables['servicio'].'-'.$tables['id'].'-'.str_pad($i, 2, "0", STR_PAD_LEFT).'-'.$mes.'-'.$ano.'-0">
											<input type="button" id="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" name="button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'" class="btn '.$clase.'" onClick="btn_NuevoOnClick('.$id.', '.str_pad($i, 2, "0", STR_PAD_LEFT).', '.$mes.', '.$ano.','.$tables['id'].','.$tables['servicio'].',\'button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\',\'hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\');" value="'.date("d").'"/>
										</td>
									    <td align="center">'.$asi.'</td>
									    <td align="center">'.$lib.'</td>
									    <td align="center">'.$fal.'</td>									    
									    <td align="center">'.number_format($por, 2, ',', ' ').' %</td>
									  </tr>';
							}
							echo '</tbody>';
						echo '</table>';
					}else{
						echo '<div class="alert alert-dismissable alert-danger">
								<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
								<p> - A&uacute;n no se ha reclutado a ningun agente.</p>
							  </div>';
					} 
				?>
			</div>
		</div>
	</div>	
	<!-- pop up fechas Ingreso y Salida del empleado -->
	<div id="dlg_fechas_empresa" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="box-header with-border">
					<h3 class="box-title">Valores a Cotizar</h3>
					<div class="box-tools pull-right">
						<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body" style="display: block;">							
					<div class="form-group">
						<label for="rubro" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Descripci&oacute;n:</label>
						<div class="col-md-5 col-sm-5">
						    <textarea name="textarea" rows="10" cols="46">Observacion del puesto </textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="agregar_fechas_empresa" class="btn btn-success">
						<span class="glyphicon glyphicon-floppy-disk"></span> Grabar
					</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove"> </span> Cancelar
					</button>
					<div id="finiquito"></div>
				</div>
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!--/ END modal -->	
</section>
<script>
	var element = document.getElementById("sidai");

	element.classList.add("sidebar-collapse");
	document.title = "Near Solution | Horario de Activos"
	
	function btn_NuevoOnClick(id, dia, mes, ano, agente, servicio, boton, hiden) {
		var oculto = document.getElementById(hiden);
		var elemento = document.getElementById(boton);
		var valor = 0;
		
		if(dia < 10) dia = '0' + dia;
		if (elemento.className == "btn btn-default") {
			elemento.value = "D";
			elemento.className = "btn btn-success";
			oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-1";
			valor = 1;
		}else{
			if (elemento.className == "btn btn-success") {
				elemento.value = "N";
				elemento.className = "btn btn-primary";
				oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-2";
				valor = 2;
			}else{
				if (elemento.className == "btn btn-primary") {
					elemento.value = "L";
					elemento.className = "btn btn-warning";
					oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-3";
					valor = 3;
				}else{
					if (elemento.className == "btn btn-warning") {
						elemento.value = "F";
						elemento.className = "btn btn-danger";
						oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-4";
						valor = 4;
					}else{
						if (elemento.className == "btn btn-danger") {
							elemento.value = "LT";
							elemento.className = "btn bg-purple";
							oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-5";
							valor = 5;
						}else{
							if (elemento.className == "btn bg-purple") {
								elemento.value = "DN";
								elemento.className = "btn btn-bitbucket";
								oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-6";
								valor = 6;
							}else{
								if (elemento.className == "btn btn-bitbucket") {
									elemento.value = "ND";
									elemento.className = "btn btn-github";
									oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-7";
									valor = 7;
								}else{
									if (elemento.className == "btn btn-github") {
										elemento.value = "DM";
										elemento.className = "btn btn-dropbox";
										oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-8";
										valor = 8;
									}else{
										if (elemento.className == "btn btn-dropbox") {
											elemento.value = "NM";
											elemento.className = "btn btn-foursquare";
											oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-9";
											valor = 9;
										}else{
											if (elemento.className == "btn btn-foursquare") {
												elemento.value = dia;
												elemento.className = "btn btn-default";
												oculto.value = id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-0";
												valor = 0;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}	
		
		// Anadimos la imagen de carga en el contenedor 
		$.ajax({
			type: "POST",
			url: "ajax/horario.php?id="+id+"&servicio="+servicio+"&agente="+agente+"&dia="+dia+"&mes="+mes+"&ano="+ano+"&valor="+valor,
			success: function(data) {
				/* Cargamos finalmente el contenido deseado */
				console.log("id="+id+"-"+servicio+"-"+agente+"-"+dia+"-"+mes+"-"+ano+"-"+valor);
				//sweetAlert('Excelente', data, 'success');
				$('#content').fadeIn(1000).html(data); 
			}
		});
	}
</script>

