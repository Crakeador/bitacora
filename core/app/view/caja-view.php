<style>
    /* Estilo opcional para que el card se vea bien en el canvas */
    .card { max-width: 800px; margin: 40px auto; }
    /* Asegura que el canvas tenga buen tamaño en distintos dispositivos */
    #donutContainer {
      position: relative;
      height: 420px;
    }
</style>
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
					<li class="active">Administrar Caja - Movimientos de Caja</li>
				</ul>
			</div>
			<div class="panel-heading">
				<h4 class="panel-title">Administrar Caja - Movimientos de Caja<a class="heading-elements-toggle"><i class="icon-more"></i></a></h4>
				<small class="display-block">Fecha de Caja : 17/12/2020 - <strong>
				<span class="label label-success label-rounded"><span class="text-bold">VIGENTE / ABIERTA</span></span> </strong></small>
				<div class="heading-elements">
					<div class="btn-group heading-btn">						
						<button type="button" class="btn bg-green-700 dropdown-opcion" data-toggle="dropdown">
						<i class="icon-cash3 position-left"></i> <strong>Opciones</strong> <span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified" onclick="openMovimiento("update","")"><i class="icon-pen-minus pull-right"></i> Editar Monto Inicial</a></li>
							<li><a href="reportes/Reporte_Caja.php?fecha=2020-12-17" target="_blank"><i class="icon-printer2 pull-right"></i> Imprimir Reporte Detallado</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified" onclick="openMovimiento("cerrar;","")"><i class="icon-drawer-in pull-right"></i> Cerrar Caja</a></li>
						</ul>
					</div>
	                <div class="btn-group heading-btn">
	                    <button type="button" class="btn bg-slate-700 dropdown-corte" data-toggle="dropdown"><i class="icon-price-tag position-left"></i> <strong> Cortes de Caja</strong> <span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a id="print_diario" href="javascript:void(0)"><i class="icon-flag8 pull-right"></i> Corte Z - Diario</a></li>
							<li><a id="print_mes" href="javascript:void(0)"><i class="icon-flag7 pull-right"></i> Corte Z - Mensual</a></li>
						</ul>
	                </div>
	                <div class="btn-group heading-btn">
	                    <button type="button" class="btn bg-blue-400 dropdown-caja" data-toggle="dropdown" aria-expanded="false"><i class="icon-coin-dollar position-left"></i> <strong> Movimientos de Caja</strong> <span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento("devolucion","")"><i class="icon-rotate-ccw3 pull-right"></i> Devolucion</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento("prestamo","")"> <i class="icon-cash2 pull-right"></i> Prestamo</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento("gasto","")"><i class="icon-cash pull-right"></i> Gasto</a></li>
						</ul>
	                </div>
				</div>
			</div>
			<hr>
			<div class="panel-body">
				<div class="row">
			 		<div class="col-md-5">
			 		  	<!-- Navigation widget -->
					  	<div class="panel panel-flat">
							<div class="table-responsive">
								<table class="table table-xxs">
									<tbody>
										<tr>
											<td><i class="icon-square" style="color:#37474F;" aria-hidden="true"></i></td>
											<td class="text-grey-800"><left>MONTO INICIAL</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"></a></td>
											<td></td>
											<td id="inicial" class="text-right">  2600.00$</td>
											<input type="hidden" id="txtinicial" value="2600.00">
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#5cb85c;" aria-hidden="true"></i></td>
											<td class="text-teal"><left>INGRESOS</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"> </a></td>
											<td></td>
											<td id="ingresos" class="text-right">  700.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#e9573f;" aria-hidden="true"></i></td>
											<td><left>DEVOLUCIONES</left></td>
											<td></td>
											<td id="devoluciones" class="text-right"> 500.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#f6bb42;" aria-hidden="true"></i></td>
											<td><left>PRESTAMOS</left></td>
											<td></td>
											<td id="prestamos" class="text-right"> 400.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#63d3e9;" aria-hidden="true"></i></td>
											<td class=" "><left>GASTOS</left></td>
											<td></td>
											<td id="gastos" class="text-right"> 300.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#63d3e9;" aria-hidden="true"></i></td>
											<td class=" "><left>DESCUENTOS</left></td>
											<td></td>
											<td id="gastos" class="text-right"> 100.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#63d3e9;" aria-hidden="true"></i></td>
											<td class=" "><left>COMBUSTIBLE</left></td>
											<td></td>
											<td id="gastos" class="text-right"> 600.00$</td>
										</tr>
										<tr class="">
											<th class=""></th>
											<th class="text-success "><h5><left><strong>INGRESOS TOTALES</strong></left></h5></th>
											<th class=""></th>
											<th class="text-right text-success"><h5><strong id="Ingresos"> 13000.00$</strong></h5></th>
										</tr>
										<tr class="">
											<th class=""></th>
											<th class="text-danger "><h5><left><strong>EGRESOS TOTALES</strong></left></h5></th>
											<th class=""></th>
											<th class="text-right text-danger"><h5><strong id="Egresos"> 13000.00$</strong></h5></th>
										</tr>
										<tr class="">
											<td class=""></td>
											<td class=""><h5><left><strong>SALDO</strong></left></h5></td>
											<th class=""></th>
											<th class="text-right"><h5><strong id="Saldo">   0.00$</strong></h5></th>
										</tr>
										<tr class="">
											<td class=""></td>
											<td class="text-info"><h5><left><strong>MONTO INICIAL + SALDO </strong></left></h5></td>
											<th class=""></th>
											<th class="text-right text-info"><h5><strong id="Diferencia"> 26,000.00</strong></h5></th>
											<input type="hidden" id="txtdiferencia" value="26000.00">
										</tr>
									</tbody>
								</table>
							</div>
					   	</div>
					</div>
					<div class="col-md-7">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Grafico de Gastos</h3>
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
								</div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<div class="row">
									<div class="col-md-8">
										<div class="card-body" id="donutContainer">
											<canvas id="pieChart" height="285" width="305" style="width: 244px; height: 228px;"></canvas>
										</div>
										<!-- ./chart-responsive -->
									</div>	<!-- /.col -->
									<div class="col-md-4">
										<ul class="chart-legend clearfix">
											<li><i class="fa fa-circle-o text-red"></i> Ingresos </li>
											<li><i class="fa fa-circle-o text-green"></i> Devoluciones </li>
											<li><i class="fa fa-circle-o text-yellow"></i> Prestamos </li>
											<li><i class="fa fa-circle-o text-aqua"></i> Gastos </li>
											<li><i class="fa fa-circle-o text-light-blue"></i> Descuentos </li>
											<li><i class="fa fa-circle-o text-gray"></i> Combustible </li>
										</ul>
									</div>	<!-- /.col -->
								</div> 	<!-- /.row -->
							</div>	<!-- /.box-body -->
							<div class="box-footer no-padding">
								<ul class="nav nav-pills nav-stacked">
									<li>
										<a href="#">Ingresos
											<span class="pull-right text-red"><i class="fa fa-angle-down"></i> 50%</span>
										</a>
									</li>
									<li>
										<a href="#">Egresos 
											<span class="pull-right text-green"><i class="fa fa-angle-up"></i> 50%</span>
										</a>
									</li>
									<li>
										<a href="#">Diferencia
											<span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span>
										</a>
									</li>
								</ul>
							</div>	<!-- /.footer -->
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
				</div>	<!-- /labels -->
			</div>
			<div class="panel-footer">
				<h5><div class="text-danger"><left><strong>* NOTA: Datos de referencia, para efectos de las pruebas</strong></left></div></h5>
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
									<label for="txtMonto">Monto <span class="text-danger">*</span></label>
									<div class="input-group bootstrap-touchspin">
										<span class="input-group-btn">
											<button class="btn btn-default bootstrap-touchspin-down" type="button">-</button>
										</span>
										<span class="input-group-addon bootstrap-touchspin-prefix">$</span>
										<input type="number" id="txtMonto" name="txtMonto" placeholder="EJ. 35.00" class="touchspin-prefix form-control" value="0" style="text-transform: uppercase; display: block;" onkeyup="javascript:this.value=this.value.toUpperCase();">
										<span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
										<span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label for="txtDescripcion">Descripcion de Movimiento <span class="text-danger"> * </span></label>
									<textarea id="txtDescripcion" name="txtDescripcion" rows="3" cols="3" class="form-control" placeholder="INGRESE UNA BREVE DESCRIPCION" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
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
									<label for="txtCantidad">Monto <span class="text-danger">*</span></label>
									<div class="input-group bootstrap-touchspin">
										<span class="input-group-btn">
											<button class="btn btn-default bootstrap-touchspin-down" type="button">-</button>
										</span>
										<span class="input-group-addon bootstrap-touchspin-prefix">$</span>
										<input type="number" id="txtCantidad" name="txtCantidad" placeholder="EJ. 35.00" class="touchspin-prefix form-control" value="0" style="text-transform: uppercase; display: block;" onkeyup="javascript:this.value=this.value.toUpperCase();"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
										<span class="input-group-btn">
											<button class="btn btn-default bootstrap-touchspin-up" type="button">+</button>
										</span>
									</div>
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
<!-- Scriptos necesarios (ajusta las rutas a tu proyecto) -->
<!-- jQuery (si ya lo tienes en AdminLTE, puedes omitir esta línea) -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- AdminLTE JS -->
<script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- Chart.js (incluido si AdminLTE ya trae una versión; si no, usa este CDN) -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/chart.js/Chart.js"></script>
<!-- Script principal (todo en este archivo) -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// -------------
		// - PIE CHART -
		// -------------
		// Get context with jQuery - using jQuery's .get() method.
		var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
		var pieChart       = new Chart(pieChartCanvas);
		var PieData        = [
			{
				value    : 700,
				color    : '#f56954',
				highlight: '#f56954',
				label    : 'Ingresos'
			},
			{
				value    : 500,
				color    : '#00a65a',
				highlight: '#00a65a',
				label    : 'Devoluciones'
			},
			{
				value    : 400,
				color    : '#f39c12',
				highlight: '#f39c12',
				label    : 'Prestamos'
			},
			{
				value    : 300,
				color    : '#3c8dbc',
				highlight: '#3c8dbc',
				label    : 'Gastos'
			},
			{
				value    : 100,
				color    : '#d2d6de',
				highlight: '#d2d6de',
				label    : 'Descuentos'
			},
			{
				value    : 600,
				color    : '#00c0ef',
				highlight: '#00c0ef',
				label    : 'Combustible'
			}
		];
		var pieOptions     = {
			// Boolean - Whether we should show a stroke on each segment
			segmentShowStroke    : true,
			// String - The colour of each segment stroke
			segmentStrokeColor   : '#fff',
			// Number - The width of each segment stroke
			segmentStrokeWidth   : 1,
			// Number - The percentage of the chart that we cut out of the middle
			percentageInnerCutout: 50, // This is 0 for Pie charts
			// Number - Amount of animation steps
			animationSteps       : 100,
			// String - Animation easing effect
			animationEasing      : 'easeOutBounce',
			// Boolean - Whether we animate the rotation of the Doughnut
			animateRotate        : true,
			// Boolean - Whether we animate scaling the Doughnut from the centre
			animateScale         : false,
			// Boolean - whether to make the chart responsive to window resizing
			responsive           : true,
			// Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio  : false,
			// String - A legend template
			legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
			// String - A tooltip template
			tooltipTemplate      : '<%=value %> <%=label%> '
		};
		// Create pie or douhnut chart
		// You can switch between pie and douhnut using the method below.
		pieChart.Doughnut(PieData, pieOptions);
		// -----------------
		// - END PIE CHART -
		// -----------------
	});
</script>