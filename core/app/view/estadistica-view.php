<div class="content" style="padding: 1.5rem !important;">
	<!-- Aqui entra el Layout, // Las vistas se cargaran aqui adentro -->
	<div id="reload-div">
		<!-- Basic initialization -->
		<div class="panel panel-flat">
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="home"><i class='fa fa-home'></i> Inicio</a></li>
					<li class="active">Estadisticas Laborales</li>
				</ul>
			</div>
			<div class="panel-heading">
				<h4 class="panel-title">Ingresos del personal al sistema</h4>
			</div>
			<hr>
			<div class="panel-body">
				<!-- Gráficos Estadísticos -->
				<div class="row">
					<div class="col-md-12">
						<div class="tabbable">
							<ul class="nav nav-tabs nav-tabs-highlight">
								<li class="active"><a href="#tab-asignadas" data-toggle="tab"><i class="icon-folder-plus"></i> Resumen de Tareas </a></li>
								<li><a href="#tab-pendientes" data-toggle="tab"><i class="icon-hourglass"></i> Grafico de Tareas </a></li>
							</ul>
							<div class="tab-content">
								<!-- Tab: Tareas Asignadas -->
								<div class="tab-pane active" id="tab-asignadas">									
									<!-- Navigation widget -->
									<div class="panel panel-flat">
										<div class="table-responsive">
											<table id="viewBitacora" class="table table-bordered table-hover">
												<tbody>
													<tr>
														<td class="text-grey-800"><left>USUARIOS</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>
														<td class="text-grey-800"><left>DEPARTAMENTO</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>
														<td class="text-center"> Asignadas </td>
														<td class="text-center"> En Curso </td>
														<td class="text-center"> Ejecutadas </td>
														<td class="text-center"> Vencidas </td>
														<td class="text-center"> % Eficiencia </td>
													</tr>
													<?php
														$users = UserData::getAllTipo();
													 
														// Crea tabla de Ventas
														foreach($users as $tables){														
															$total1 = TimelineData::getStatus($tables->id, 1); // getByTotalID($tables->id, 1);
															
															$events = TimelineData::getAsignado($tables->id);
															$total2 = TimelineData::getByTotalID($tables->id, 2);
															$total3 = TimelineData::getByTotalID($tables->id, 3);
															$total4 = TimelineData::getByTotalID($tables->id, 4);
															
															$events1 = (is_object($total1) && isset($total1->total) ? $total1->total : 0);
															$events2 = (is_object($total2) && isset($total2->total) ? $total2->total : 0);
															$events3 = (is_object($total3) && isset($total3->total) ? $total3->total : 0);
															$events4 = (is_object($total3) && isset($total4->total) ? $total4->total : 0);
															$total = (is_object($events) && isset($events->total) ? $events->total : 0);
 
															echo '<tr>';
																echo '<td class="text-grey-800"><left>'.$tables->name.' '.$tables->lastname.'</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>';
																echo '<td class="text-grey-800"><left>'.$tables->departamento.'</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>';
																echo '<td class="text-right">'.(is_object($events) && isset($events->total) ? $events->total : 0).'</td>'; // $events1
																echo '<td class="text-right">'.$events2.'</td>';
																echo '<td class="text-right">'.$events3.'</td>';
																echo '<td class="text-right">'.$events4.'</td>';
																echo '<td class="text-right">'.number_format(($total > 0 ? ($events3*100)/$total : 0), 2, '.', ',').'%</td>';
															echo '</tr>';
														}
													?>
												</tbody>
											</table>
										</div>
									</div>									
								</div>								
								<!-- Tab: Tareas Pendientes -->
								<div class="tab-pane" id="tab-pendientes">
									<div class="panel panel-flat">
										<div class="panel-heading">
											<h6 class="panel-title"><i class="icon-graph"></i> Estadísticas de Tareas por Usuario</h6>
										</div>
										<div class="panel-body">
											<?php
											$users = UserData::getEstado(1);
											$statsTareas = array();

											foreach($users as $user){
												$asignadas = count(TimelineData::getById($user->id));
												$pendientes = TimelineData::getByTotalID($user->id, 1)->total;
												$ejecutadas = TimelineData::getByTotalID($user->id, 3)->total;
												$vencidas = TimelineData::getByTotalID($user->id, 4)->total;

												$statsTareas[$user->id] = array(
													'nombre' => $user->name.' '.$user->lastname,
													'asignadas' => $asignadas,
													'pendientes' => $pendientes,
													'entregadas' => $ejecutadas,
													'vencidas' => $vencidas
												);
											}
											?>
											<!-- Gráfico de Barras Horizontales Apiladas -->
											<div class="chart-container" style="position: relative; height: 500px; margin-top: 20px;">
												<canvas id="barChart"></canvas>
											</div>
											<!-- Leyenda -->
											<div class="text-center" style="margin-top: 20px;">
												<span style="display: inline-block; width: 20px; height: 20px; background: #FDD835; margin-right: 8px; vertical-align: middle; border-radius: 3px;"></span>
												<span style="margin-right: 20px; font-weight: 600;">Asignadas</span>
												
												<span style="display: inline-block; width: 20px; height: 20px; background: #F44336; margin-right: 8px; vertical-align: middle; border-radius: 3px;"></span>
												<span style="margin-right: 20px; font-weight: 600;">Vencidas</span>
												
												<span style="display: inline-block; width: 20px; height: 20px; background: #43A047; margin-right: 8px; vertical-align: middle; border-radius: 3px;"></span>
												<span style="font-weight: 600;">Entregadas</span>
											</div>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Gráficos Estadísticos -->
			</div>
			<div class="panel-footer">
				<!-- Leyenda -->
				<div class="chart-legend" style="margin-top: 30px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
					<h6 style="margin-bottom: 10px; font-weight: 600;"><i class="icon-info-circle"></i> Leyenda:</h6>
					<div style="display: flex; flex-wrap: wrap; gap: 20px;">
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="icon-circle" style="color: #E53935;"></i>
							<span style="font-size: 13px;">Tareas Asignadas</span>
						</div>
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="icon-circle" style="color: #FF9800;"></i>
							<span style="font-size: 13px;">Tareas Pendientes</span>
						</div>
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="icon-circle" style="color: #4CAF50;"></i>
							<span style="font-size: 13px;">Tareas Entregadas</span>
						</div>
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="icon-circle" style="color: #F44336;"></i>
							<span style="font-size: 13px;">Tareas Vencidas</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Iconified modal -->
	<div id="modal_iconified_movimiento" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; <span class="title-form">Devolucion de Efectivo de Caja</span></h5>
				</div>

		        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmModal" novalidate="novalidate">
					<div class="modal-body" id="modal-container">

					<div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                <span class="text-semibold">Estimado usuario</span>
			                Los campos remarcados con <span class="text-danger"> * </span> son necesarios.
			                <button type="button" class="close" data-dismiss="alert">×</button>
	                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="Devolucion">
			           </div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Monto <span class="text-danger">*</span></label>
									<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix">S/.</span><input type="text" id="txtMonto" name="txtMonto" placeholder="EJ. 35.00" class="touchspin-prefix form-control" value="0" style="text-transform: uppercase; display: block;" onkeyup="javascript:this.value=this.value.toUpperCase();"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
								</div>
							</div>
						</div>


						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Descripcion de Movimiento <span class="text-danger"> * </span></label>
									<textarea id="txtDescripcion" name="txtDescripcion" rows="3" cols="3" class="form-control" placeholder="INGRESE UNA BREVE DESCRIPCION" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">												 </textarea>
								</div>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="reset" class="btn btn-default" id="reset" data-dismiss="modal">Cerrar</button>
						<button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /iconified modal -->

	<!-- Iconified modal -->
	<div id="modal_iconified" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title"><i class="icon-pencil7"></i> &nbsp; <span class="title-form"></span></h5>
				</div>

		        <form role="form" autocomplete="off" class="form-validate-jquery" id="frmMonto" novalidate="novalidate">
					<div class="modal-body" id="modal-container">

					<div class="alert alert-info alert-styled-left text-blue-800 content-group">
			                <span class="text-semibold">Estimado usuario</span>
			                Los campos remarcados con <span class="text-danger"> * </span> son necesarios.
			                <button type="button" class="close" data-dismiss="alert">×</button>
	                      	<input type="hidden" id="txtProceso" name="txtProceso" class="form-control" value="">
			           </div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Monto <span class="text-danger">*</span></label>
									<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix">S/.</span><input type="text" id="txtCantidad" name="txtCantidad" placeholder="EJ. 35.00" class="touchspin-prefix form-control" value="0" style="text-transform: uppercase; display: block;" onkeyup="javascript:this.value=this.value.toUpperCase();"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>
								</div>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="reset" class="btn btn-default" id="reset" data-dismiss="modal">Cerrar</button>
						<button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /iconified modal -->
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener datos desde PHP
    var statsTareas = <?php echo json_encode(array_values($statsTareas)); ?>;
    
    // Extraer etiquetas (nombres de usuarios) y datos
    var labels = statsTareas.map(function(item) {
        return item.nombre;
    });
    
    var datosAsignadas = statsTareas.map(function(item) {
        return item.asignadas;
    });
    
    var datosVencidas = statsTareas.map(function(item) {
        return item.vencidas;
    });
    
    var datosEntregadas = statsTareas.map(function(item) {
        return item.entregadas;
    });
    
    // Crear gráfico de barras horizontales apiladas
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Asignadas',
                    data: datosAsignadas,
                    backgroundColor: '#FDD835', // Amarillo
                    borderColor: '#F9A825',
                    borderWidth: 1
                },
                {
                    label: 'Vencidas',
                    data: datosVencidas,
                    backgroundColor: '#F44336', // Rojo
                    borderColor: '#C62828',
                    borderWidth: 1
                },
                {
                    label: 'Entregadas',
                    data: datosEntregadas,
                    backgroundColor: '#43A047', // Verde
                    borderColor: '#2E7D32',
                    borderWidth: 1
                }
            ]
        },
        options: {
            indexAxis: 'y', // Barras horizontales
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Ocultar leyenda (usamos la personalizada)
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    stacked: true, // Apilar barras
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                y: {
                    stacked: true, // Apilar barras
                    ticks: {
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'y',
                intersect: false
            }
        }
    });
});
</script> 