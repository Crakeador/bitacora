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
								<li class="active"><a href="#tab-asignadas" data-toggle="tab"><i class="icon-folder-plus"></i> Tareas Asignadas</a></li>
								<li><a href="#tab-pendientes" data-toggle="tab"><i class="icon-hourglass"></i> Tareas Pendientes</a></li>
								<li><a href="#tab-ejecutadas" data-toggle="tab"><i class="icon-checkmark-circle"></i> Tareas Entregadas</a></li>
								<li><a href="#tab-vencidas" data-toggle="tab"><i class="icon-alert"></i> Tareas Vencidas</a></li>
								<li><a href="#tab-eficiencia" data-toggle="tab"><i class="icon-stats-dots"></i> Eficiencia</a></li>
							</ul>
							<div class="tab-content">
								<!-- Tab: Tareas Asignadas -->
								<div class="tab-pane active" id="tab-asignadas">
									<div class="chart-container" style="position: relative; height: 400px; margin-top: 20px;">
										<?php
										$users = UserData::getEstado(1);
										$maxTareas = 0;
										$statsAsignadas = array();
										
										foreach($users as $user){
											$asignadas = count(TimelineData::getById($user->id));
											$statsAsignadas[$user->id] = array(
												'nombre' => $user->name.' '.$user->lastname,
												'asignadas' => $asignadas,
												'pendientes' => TimelineData::getByTotalID($user->id, 1)->total,
												'entregadas' => $asignadas,
												'vencidas' => $asignadas
											);
											if($asignadas > $maxTareas) $maxTareas = $asignadas;
										}
										
										// Calcular el máximo para la escala
										if($maxTareas == 0) $maxTareas = 1;
										?>
										<div class="chart-bars-horizontal">
											<?php 
											$colors = array('#E53935', '#FDD835', '#43A047', '#1E88E5', '#8E24AA', '#FB8C00', '#00ACC1', '#D81B60');
											$i = 0;
											foreach($statsAsignadas as $id => $stat): 
												$porcentaje = ($stat['asignadas'] / $maxTareas) * 100;
												$color = $colors[$i % count($colors)];
											?>
											<div class="bar-row" style="margin-bottom: 15px;">
												<div class="bar-label" style="width: 200px; display: inline-block; vertical-align: middle; font-size: 13px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
													<i class="icon-circle" style="color: <?php echo $color; ?>;"></i> <?php echo $stat['nombre']; ?>
												</div>
												<div class="bar-container" style="display: inline-block; width: calc(100% - 220px); vertical-align: middle;">
													<div class="bar-fill" style="height: 24px; background: linear-gradient(90deg, <?php echo $color; ?> 0%, <?php echo $color; ?> <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) 100%); border-radius: 4px; position: relative;">
														<span class="bar-value" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"><?php echo $stat['asignadas']; ?></span>
													</div>
												</div>
											</div>
											<?php $i++; endforeach; ?>
										</div>
									</div>
								</div>
								
								<!-- Tab: Tareas Pendientes -->
								<div class="tab-pane" id="tab-pendientes">
									<div class="chart-container" style="position: relative; height: 400px; margin-top: 20px;">
										<div class="chart-bars-horizontal">
											<?php 
											$i = 0;
											foreach($statsAsignadas as $id => $stat): 
												$porcentaje = ($stat['pendientes'] / $maxTareas) * 100;
												$color = '#FF9800';
											?>
											<div class="bar-row" style="margin-bottom: 15px;">
												<div class="bar-label" style="width: 200px; display: inline-block; vertical-align: middle; font-size: 13px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
													<i class="icon-circle" style="color: <?php echo $color; ?>;"></i> <?php echo $stat['nombre']; ?>
												</div>
												<div class="bar-container" style="display: inline-block; width: calc(100% - 220px); vertical-align: middle;">
													<div class="bar-fill" style="height: 24px; background: linear-gradient(90deg, <?php echo $color; ?> 0%, <?php echo $color; ?> <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) 100%); border-radius: 4px; position: relative;">
														<span class="bar-value" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"><?php echo $stat['pendientes']; ?></span>
													</div>
												</div>
											</div>
											<?php $i++; endforeach; ?>
										</div>
									</div>
								</div>
								
								<!-- Tab: Tareas Entregadas -->
								<div class="tab-pane" id="tab-ejecutadas">
									<div class="chart-container" style="position: relative; height: 400px; margin-top: 20px;">
										<div class="chart-bars-horizontal">
											<?php 
											$i = 0;
											foreach($statsAsignadas as $id => $stat): 
												$porcentaje = ($stat['entregadas'] / $maxTareas) * 100;
												$color = '#4CAF50';
											?>
											<div class="bar-row" style="margin-bottom: 15px;">
												<div class="bar-label" style="width: 200px; display: inline-block; vertical-align: middle; font-size: 13px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
													<i class="icon-circle" style="color: <?php echo $color; ?>;"></i> <?php echo $stat['nombre']; ?>
												</div>
												<div class="bar-container" style="display: inline-block; width: calc(100% - 220px); vertical-align: middle;">
													<div class="bar-fill" style="height: 24px; background: linear-gradient(90deg, <?php echo $color; ?> 0%, <?php echo $color; ?> <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) 100%); border-radius: 4px; position: relative;">
														<span class="bar-value" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"><?php echo $stat['entregadas']; ?></span>
													</div>
												</div>
											</div>
											<?php $i++; endforeach; ?>
										</div>
									</div>
								</div>
								
								<!-- Tab: Tareas Vencidas -->
								<div class="tab-pane" id="tab-vencidas">
									<div class="chart-container" style="position: relative; height: 400px; margin-top: 20px;">
										<div class="chart-bars-horizontal">
											<?php 
											$i = 0;
											foreach($statsAsignadas as $id => $stat): 
												$porcentaje = ($stat['vencidas'] / $maxTareas) * 100;
												$color = '#F44336';
											?>
											<div class="bar-row" style="margin-bottom: 15px;">
												<div class="bar-label" style="width: 200px; display: inline-block; vertical-align: middle; font-size: 13px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
													<i class="icon-circle" style="color: <?php echo $color; ?>;"></i> <?php echo $stat['nombre']; ?>
												</div>
												<div class="bar-container" style="display: inline-block; width: calc(100% - 220px); vertical-align: middle;">
													<div class="bar-fill" style="height: 24px; background: linear-gradient(90deg, <?php echo $color; ?> 0%, <?php echo $color; ?> <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) 100%); border-radius: 4px; position: relative;">
														<span class="bar-value" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"><?php echo $stat['vencidas']; ?></span>
													</div>
												</div>
											</div>
											<?php $i++; endforeach; ?>
										</div>
									</div>
								</div>
								
								<!-- Tab: Eficiencia -->
								<div class="tab-pane" id="tab-eficiencia">
									<div class="chart-container" style="position: relative; height: 400px; margin-top: 20px;">
										<div class="chart-bars-horizontal">
											<?php 
											$i = 0;
											foreach($statsAsignadas as $id => $stat): 
												$total = $stat['asignadas'] > 0 ? $stat['asignadas'] : 1;
												$eficiencia = ($stat['entregadas'] * 100) / $total;
												$porcentaje = $eficiencia;
												
												// Color según eficiencia
												if($eficiencia >= 80) $color = '#4CAF50';
												elseif($eficiencia >= 50) $color = '#FF9800';
												else $color = '#F44336';
											?>
											<div class="bar-row" style="margin-bottom: 15px;">
												<div class="bar-label" style="width: 200px; display: inline-block; vertical-align: middle; font-size: 13px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
													<i class="icon-circle" style="color: <?php echo $color; ?>;"></i> <?php echo $stat['nombre']; ?>
												</div>
												<div class="bar-container" style="display: inline-block; width: calc(100% - 220px); vertical-align: middle;">
													<div class="bar-fill" style="height: 24px; background: linear-gradient(90deg, <?php echo $color; ?> 0%, <?php echo $color; ?> <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) <?php echo $porcentaje; ?>%, rgba(0,0,0,0.1) 100%); border-radius: 4px; position: relative;">
														<span class="bar-value" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"><?php echo number_format($eficiencia, 1); ?>%</span>
													</div>
												</div>
											</div>
											<?php $i++; endforeach; ?>
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