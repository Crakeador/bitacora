<?php
// Modulo de Operaciones para el registro del horario de los agentes activos
$_SESSION['tipo']='3';
$puestos = PuestoData::getAll(2);

$_SESSION['mes']=date("m");
$_SESSION['ano']=date("Y");

if(isset($_GET['id'])){
	$lugar=$_GET['id'];
	$_SESSION['id']=$lugar;
}else{
	$lugar=$_SESSION['id']; 
}

$fecha=$_SESSION['ano']."-".$_SESSION['mes']."-01";
$total=date("t", strtotime($fecha));
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
			Oficina:&nbsp;&nbsp;
			<label>
				<?php
					echo '<select id="localidad_id" name="localidad_id" class="form-control" onchange="javascript:location.href=\'index.php?view=consola&tipo=3&id=\'+value;">';
					echo '<option value="0"> -- SELECCIONE PUESTO -- </option>';
					foreach($puestos as $tables) {
						if($tables->id == $lugar) $valor = 'selected'; else $valor = '';
						echo '<option value="'.$tables->id.'" '.$valor.'>'.$tables->descripcion.'</option>';  
					}
					echo '</select>';
				?>
			</label>
		</div>	
		<div class="box-body mailbox-messages">
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-dismissable alert-info">
						<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
						<p> - Los turnos se identifican con los siguientes colores:&nbsp;</br>
							<span class="label label-success">D</span>&nbsp;Diurno,&nbsp;
							<span class="label label-primary">N</span>&nbsp;Nocturno,&nbsp;
							<span class="label label-warning">L</span>&nbsp;Libre,&nbsp;
							<span class="label label-danger" >F</span>&nbsp;Falta,&nbsp;
							<span class="label label-purple">LT</span>&nbsp;Libre trabajado,&nbsp;
							<span class="label label-navy"  >DN</span>&nbsp;
							<span class="label label-broum" >ND</span>&nbsp;Dobladas y
							<span class="label label-motod" >DM</span>&nbsp;Diurno con Moto,&nbsp;
							<span class="label label-moton" >NM</span>&nbsp;Nocturno con Moto
						</p>
					</div>
				</div>
			</div>
			<div id="content"></div>
			<div style="height: 410px; width: 100%; overflow-x: auto;" id="example_length">
				<?php			    
					$ini="2020-01-01"; $fin=$_SESSION['ano']."-".$_SESSION['mes']."-30";
					$users = PuestoData::getByIdHorario($lugar, 3, 1, $ini, $fin); 
					var_dump($users);
					if(count($users) > 0){
						echo '<table id="horario" class="table table-bordered table-hover">';
							echo '<tbody>';
							// Crea tabla de agentes activos
                            $i=0;
							foreach($users as $tables) {							    
								$valor=ConsolaData::getByTurnos($tables['servicio'], $tables['id'], date("m"), date("Y"), 2);
								$resultado = count($valor);
								
								var_dump($valor);
							    switch ($i) {
                                    case 1:
									    $clase = 'btn-success';
                                        break;
                                    case 2:
										$clase = 'btn-primary';
                                        break;
                                    case 3:
										$clase = 'btn-warning';
                                        break;
                                    case 4:
										$clase = 'btn-danger';
                                        break;
                                    case 5:
										$clase = 'bg-purple';
                                        break;
                                    case 6:
										$clase = 'btn-bitbucket';
                                        break;
                                    case 7:
										$clase = 'btn-github';
                                        break;
                                    case 8:
										$clase = 'btn-dropbox';
                                        break;
                                    case 9:
										$clase = 'btn-foursquare';
                                        break;
                                    case 10:
										$clase = 'btn-flickr';
                                        break;
                                    default:
                                        $clase = 'btn-default';
                                }
								
								echo '<tr>';
									echo '<td>';
										echo '<small>';
											echo $tables['nombre']; // $lugar.' '.$tables['id'].' '.
											echo '</br>Ingreso el: '.$tables['startwork']; //$tables['descripcion'].'-'.$tables['cargo']
										echo '</small></br>';									
									echo '</td>';
									echo '<td>';
									    echo '<div align="center"><small>'.date("Y-m-d").'</small></br>';
									        echo '<input type="button" id="button" name="button" class="btn '.$clase.'" value="'.date("H:i:s").'" onClick="btn_NuevoOnClick()"/>'; //onClick="btn_NuevoOnClick('.$iddia.', '.str_pad($i, 2, "0", STR_PAD_LEFT).', '.date("m").', '.date("Y").','.$tables['id'].','.$tables['servicio'].',\'button_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\',\'hiden_'.$tables['servicio'].'_'.$tables['id'].'_'.$i.'\');" value="'.str_pad($i, 2, "0", STR_PAD_LEFT).'"
									    echo '</div>';
									echo '</td>';
								echo '</tr>';
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
		
		// Añadimos la imagen de carga en el contenedor 
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

