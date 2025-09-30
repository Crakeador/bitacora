<div class="content" style="padding: 1.5rem !important;">
	<!-- Mini modal (Cambio de contraseña) -->
	<div id="modal_mini" class="modal fade">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Cambiar mi Contraseña</h5>
				</div>
				<div class="modal-body">
				 	<!-- Password recovery -->
					<form id="frmResend" method="POST" action="index.php?view=Caja" class="form-validate-jquery">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-warning text-warning"><i class=" icon-user-lock"></i></div>
								<h5 class="content-group">Restaurar Contraseña <small class="display-block">Ingrese su nueva contraseña.</small></h5>
							</div>
							<div class="form-group has-feedback">
								<input type="password" id="passwordr" name="passwordr" class="form-control" placeholder="Ingresar password">
								<div class="form-control-feedback">
									<i class="icon-user-lock text-muted"></i>
								</div>
							</div>
							<div class="form-group has-feedback">
								<input type="password" id="rpasswordr" name="rpasswordr" class="form-control" placeholder="Repetir password">
								<div class="form-control-feedback">
									<i class="icon-user-lock text-muted"></i>
								</div>
							</div>
							<button type="submit" class="btn bg-blue btn-block">Restaurar<i class="icon-key position-right"></i></button>
						</div>
					</form>
					<!-- /password recovery -->
				</div>
			</div>
		</div>
	</div>
	<!-- /mini modal -->

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
				<div class="dataTables_length" id="viewBitacora_length">
				    <label>Modulos:
				    <select>
				        <option value="10">Ingresos</option>
				        <option value="25">Asistencia</option>
				        <option value="50">Bitacora</option>
				        <option value="-1">Comercial</option>
				    </select> registros</label>
				</div>
			</div>
			<hr>
			<div class="panel-body">
				<div class="row">
			 		<div class="col-md-10">
			 		  	<!-- Navigation widget -->
					  	<div class="panel panel-flat">
							<div class="table-responsive">
								<table class="table table-xxs">
									<tbody>
										<tr>
											<td class="text-grey-800"><left>USUARIOS</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>
											<td><i class="icon-square" style="color:#37474F;" aria-hidden="true">ULTIMO INGRESO</i></td>
											<td class="text-center"> Total Ingresos </td>
											<td class="text-center"> Asignadas </td>
											<td class="text-center"> Pendientes </td>
											<td class="text-center"> Ejecutadas </td>
											<td class="text-center"> % Eficiencia </td>
										</tr>
									    <?php
                                            $users = UserData::getEstado(1);
	
        									// Crea tabla de Ventas
        									foreach($users as $tables){
        									    $events = count(TimelineData::getById($tables->id));
        									    
        										echo '<tr>';
        											echo '<td class="text-grey-800"><left>'.$tables->name.' '.$tables->lastname.'</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>';
        											echo '<td><i class="icon-square" style="color:#37474F;" aria-hidden="true">'.$tables->ultima_session.'</i></td>';
        											echo '<td class="text-center">'.$tables->ingresos.'</td>';
        											echo '<td class="text-right">'.$events.'</td>';
        											echo '<td class="text-right">'.$events.'</td>';
        											echo '<td class="text-right">'.$events.'</td>';
        											echo '<td class="text-right">'.($events*100)/$events.'</td>';
        										echo '</tr>';
        									}
                                        ?>
									</tbody>
								</table>
							</div>
					   	</div>
					</div>
				</div>
				<!-- Labels -->
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Movimientos de Caja</h6>
							</div>
							<div class="panel-body">
								<div class="tabbable">
									<ul class="nav nav-tabs nav-tabs-highlight">
										<li class="active"><a href="index.php?view=caja#label-tab1" data-toggle="tab">INGRESOS <span id="span-ing" class="label
										label-success position-right">2</span></a></li>
										<li><a href="index.php?view=caja#label-tab2" data-toggle="tab">DEVOLUCIONES <span id="span-dev" class="label bg-danger
										position-right">0</span></a></li>
										<li><a href="index.php?view=caja#label-tab3" data-toggle="tab">PRÉSTAMOS <span id="span-pre" class="label bg-warning
										position-right">0</span></a></li>
										<li><a href="index.php?view=caja#label-tab4" data-toggle="tab">GASTOS <span id="span-gas" class="label bg-info
										position-right">0</span></a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="label-tab1">
											<table class="table datatable-basic table-xxs table-hover dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
												<thead>
													<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Descripcion: activate to sort column descending">Descripcion</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Monto: activate to sort column ascending">Monto</th></tr>
												</thead>
												<tbody>
													<tr role="row" class="odd">
											           	<td class="sorting_1">POR VENTA FACTURA # 7</td>
											           	<td>1500.00</td>
											        </tr>
											        <tr role="row" class="even">
											           	<td class="sorting_1">POR VENTA FACTURA # 8</td>
											           	<td>1500.00</td>
											        </tr>
											    </tbody>
											</table>
										</div>
										<div class="tab-pane" id="label-tab2">
											<table class="table datatable-basic table-xxs table-hover dataTable no-footer" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
												<thead>
													<tr role="row">
														<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Descripcion: activate to sort column descending">Descripcion</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Monto: activate to sort column ascending">Monto</th>
													</tr>
												</thead>
												<tbody>
												  	<tr class="odd">
											           	<td class="sorting_1">POR VENTA FACTURA # 7</td>
											           	<td>1500.00</td>
											        </tr>
											        <tr role="row" class="even">
											           	<td class="sorting_1">POR VENTA FACTURA # 8</td>
											           	<td>1500.00</td>
												  	</tr>
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="label-tab3">
											<table class="table datatable-basic table-xxs table-hover dataTable no-footer" id="DataTables_Table_2" role="grid" aria-describedby="DataTables_Table_2_info">
												<thead>
													<tr role="row">
														<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Descripcion: activate to sort column descending">Descripcion</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Monto: activate to sort column ascending">Monto</th>
													</tr>
												</thead>
												<tbody>
												  	<tr class="odd">
											           	<td class="sorting_1">POR VENTA FACTURA # 7</td>
											           	<td>1500.00</td>
											        </tr>
											        <tr role="row" class="even">
											           	<td class="sorting_1">POR VENTA FACTURA # 8</td>
											           	<td>1500.00</td>
												  	</tr>
											  	</tbody>
											</table>
										</div>
										<div class="tab-pane" id="label-tab4">
											<table class="table datatable-basic table-xxs table-hover dataTable no-footer" id="DataTables_Table_3" role="grid" aria-describedby="DataTables_Table_3_info">
												<thead>
													<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Descripcion: activate to sort column descending">Descripcion</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_3" rowspan="1" colspan="1" aria-label="Monto: activate to sort column ascending">Monto</th></tr>
												</thead>
												<tbody>
													<tr class="odd">
											           	<td class="sorting_1">POR VENTA FACTURA # 7</td>
											           	<td>1500.00</td>
											        </tr>
											        <tr role="row" class="even">
											           	<td class="sorting_1">POR VENTA FACTURA # 8</td>
											           	<td>1500.00</td>
												  	</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /labels -->
			</div>
			<div class="panel-footer">
				<p>DDDDDDDDDDDD</p>
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