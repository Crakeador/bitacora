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
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified" onclick="openMovimiento(&#39;update&#39;,&#39;&#39;)"><i class="icon-pen-minus pull-right"></i> Editar Monto Inicial</a></li>
							<li><a href="reportes/Reporte_Caja.php?fecha=2020-12-17" target="_blank"><i class="icon-printer2 pull-right"></i> Imprimir Reporte Detallado</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified" onclick="openMovimiento(&#39;cerrar&#39;,&#39;&#39;)"><i class="icon-drawer-in pull-right"></i> Cerrar Caja</a></li>
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
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento(&#39;devolucion&#39;,&#39;&#39;)"><i class="icon-rotate-ccw3 pull-right"></i> Devolucion</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento(&#39;prestamo&#39;,&#39;&#39;)"> <i class="icon-cash2 pull-right"></i> Prestamo</a></li>
							<li><a href="index.php?view=Caja#" data-toggle="modal" data-target="#modal_iconified_movimiento" onclick="openMovimiento(&#39;gasto&#39;,&#39;&#39;)"><i class="icon-cash pull-right"></i> Gasto</a></li>
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
											<td id="inicial" class="text-right">  800.00$</td>
											<input type="hidden" id="txtinicial" value="800.00">
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#5cb85c;" aria-hidden="true"></i></td>
											<td class="text-teal"><left>INGRESOS</left> <a data-toggle="modal" data-target=".bs-example-modal-sm" style="color:#5b5d5f"> </a></td>
											<td></td>
											<td id="ingresos" class="text-right">3000.00$</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#e9573f;" aria-hidden="true"></i></td>
											<td><left>DEVOLUCIONES</left></td>
											<td></td>
											<td id="devoluciones" class="text-right">S/. 0.00</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#f6bb42;" aria-hidden="true"></i></td>
											<td><left>PRÉSTAMOS</left></td>
											<td></td>
											<td id="prestamos" class="text-right">S/. 0.00</td>
										</tr>
										<tr>
											<td><i class="icon-square" style="color:#63d3e9;" aria-hidden="true"></i></td>
											<td class=" "><left>GASTOS</left></td>
											<td></td>
											<td id="gastos" class="text-right">S/. 0.00</td>
										</tr>
										<tr class="">
											<th class=""></th>
											<th class="text-success "><h5><left><strong>INGRESOS TOTALES</strong></left></h5></th>
											<th class=""></th>
											<th class="text-right text-success"><h5><strong id="Ingresos">S/. 3000.00</strong></h5></th>
										</tr>
										<tr class="">
											<th class=""></th>
											<th class="text-danger "><h5><left><strong>EGRESOS TOTALES</strong></left></h5></th>
											<th class=""></th>
											<th class="text-right text-danger"><h5><strong id="Egresos">S/. 0.00</strong></h5></th>
										</tr>
										<tr class="">
											<td class=""></td>
											<td class=""><h5><left><strong>SALDO</strong></left></h5></td>
											<th class=""></th>
											<th class="text-right"><h5><strong id="Saldo">S/. 3000.00</strong></h5></th>
										</tr>
										<tr class="">
											<td class=""></td>
											<td class="text-info"><h5><left><strong>MONTO INICIAL + SALDO </strong></left></h5></td>
											<th class=""></th>
											<th class="text-right text-info"><h5><strong id="Diferencia">S/. 3,008.00</strong></h5></th>
											<input type="hidden" id="txtdiferencia" value="3008.00">
										</tr>
									</tbody>
								</table>
							</div>
					   	</div>
					</div>
					<div class="col-md-7">
						<div class="chart-container text-center">
							<div class="display-inline-block c3" id="c3-pie-chart" style="max-height: 320px; position: relative;">
								<svg width="500" height="320" style="overflow: hidden;">
									<defs>
										<clippath id="c3-1608241707142-clip"><rect width="500" height="296"></rect></clippath>
										<clippath id="c3-1608241707142-clip-xaxis"><rect x="-31" y="-20" width="562" height="40"></rect></clippath>
										<clippath id="c3-1608241707142-clip-yaxis"><rect x="-29" y="-4" width="20" height="320"></rect></clippath>
										<clippath id="c3-1608241707142-clip-grid"><rect width="500" height="296"></rect></clippath>
										<clippath id="c3-1608241707142-clip-subchart"><rect width="500"></rect></clippath>
									</defs>
									<g transform="translate(0.5,4.5)">
										<text class="c3-text c3-empty" text-anchor="middle" dominant-baseline="middle" x="250" y="148" style="opacity: 0;"></text>
										<rect class="c3-zoom-rect" width="500" height="296" style="opacity: 0;"></rect>
										<g clip-path="url(index.php?view=Caja#c3-1608241707142-clip)" class="c3-regions" style="visibility: hidden;"></g>
										<g clip-path="url(index.php?view=Caja#c3-1608241707142-clip-grid)" class="c3-grid" style="visibility: hidden;">
											<g class="c3-xgrid-focus">
												<line class="c3-xgrid-focus" x1="-10" x2="-10" y1="0" y2="296" style="visibility: hidden;"></line>
											</g>
										</g>
										<g clip-path="url(index.php?view=Caja#c3-1608241707142-clip)" class="c3-chart">
											<g class="c3-event-rects c3-event-rects-single" style="fill-opacity: 0;">
												<rect class=" c3-event-rect c3-event-rect-0" x="0" y="0" width="500" height="296"></rect>
											</g>
											<g class="c3-chart-bars">
												<g class="c3-chart-bar c3-target c3-target-MONTO-INICIAL" style="opacity: 1; pointer-events: none;">
													<g class=" c3-shapes c3-shapes-MONTO-INICIAL c3-bars c3-bars-MONTO-INICIAL" style="cursor: pointer;"></g>
												</g>
												<g class="c3-chart-bar c3-target c3-target-INGRESOS" style="opacity: 1; pointer-events: none;">
													<g class=" c3-shapes c3-shapes-INGRESOS c3-bars c3-bars-INGRESOS" style="cursor: pointer;"></g>
												</g>
												<g class="c3-chart-bar c3-target c3-target-DEVOLUCIONES" style="opacity: 1; pointer-events: none;">
													<g class=" c3-shapes c3-shapes-DEVOLUCIONES c3-bars c3-bars-DEVOLUCIONES" style="cursor: pointer;"></g>
												</g>
												<g class="c3-chart-bar c3-target c3-target-PRESTAMOS" style="opacity: 1; pointer-events: none;">
													<g class=" c3-shapes c3-shapes-PRESTAMOS c3-bars c3-bars-PRESTAMOS" style="cursor: pointer;"></g>
												</g>
												<g class="c3-chart-bar c3-target c3-target-GASTOS" style="opacity: 1; pointer-events: none;">
													<g class=" c3-shapes c3-shapes-GASTOS c3-bars c3-bars-GASTOS" style="cursor: pointer;"></g>
												</g>
											</g>
											<g class="c3-chart-lines"><g class="c3-chart-line c3-target c3-target-MONTO-INICIAL" style="opacity: 1; pointer-events: none;">
												<g class=" c3-shapes c3-shapes-MONTO-INICIAL c3-lines c3-lines-MONTO-INICIAL"></g>
												<g class=" c3-shapes c3-shapes-MONTO-INICIAL c3-areas c3-areas-MONTO-INICIAL"></g>
												<g class=" c3-selected-circles c3-selected-circles-MONTO-INICIAL"></g>
												<g class=" c3-shapes c3-shapes-MONTO-INICIAL c3-circles c3-circles-MONTO-INICIAL" style="cursor: pointer;"></g>
											</g>
											<g class="c3-chart-line c3-target c3-target-INGRESOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-shapes c3-shapes-INGRESOS c3-lines c3-lines-INGRESOS"></g>
												<g class=" c3-shapes c3-shapes-INGRESOS c3-areas c3-areas-INGRESOS"></g>
												<g class=" c3-selected-circles c3-selected-circles-INGRESOS"></g>
												<g class=" c3-shapes c3-shapes-INGRESOS c3-circles c3-circles-INGRESOS" style="cursor: pointer;"></g>
											</g>
											<g class="c3-chart-line c3-target c3-target-DEVOLUCIONES" style="opacity: 1; pointer-events: none;">
												<g class=" c3-shapes c3-shapes-DEVOLUCIONES c3-lines c3-lines-DEVOLUCIONES"></g>
												<g class=" c3-shapes c3-shapes-DEVOLUCIONES c3-areas c3-areas-DEVOLUCIONES"></g>
												<g class=" c3-selected-circles c3-selected-circles-DEVOLUCIONES"></g>
												<g class=" c3-shapes c3-shapes-DEVOLUCIONES c3-circles c3-circles-DEVOLUCIONES" style="cursor: pointer;"></g>
											</g>
											<g class="c3-chart-line c3-target c3-target-PRESTAMOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-shapes c3-shapes-PRESTAMOS c3-lines c3-lines-PRESTAMOS"></g>
												<g class=" c3-shapes c3-shapes-PRESTAMOS c3-areas c3-areas-PRESTAMOS"></g>
												<g class=" c3-selected-circles c3-selected-circles-PRESTAMOS"></g>
												<g class=" c3-shapes c3-shapes-PRESTAMOS c3-circles c3-circles-PRESTAMOS" style="cursor: pointer;"></g>
											</g>
											<g class="c3-chart-line c3-target c3-target-GASTOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-shapes c3-shapes-GASTOS c3-lines c3-lines-GASTOS"></g>
												<g class=" c3-shapes c3-shapes-GASTOS c3-areas c3-areas-GASTOS"></g>
												<g class=" c3-selected-circles c3-selected-circles-GASTOS"></g>
												<g class=" c3-shapes c3-shapes-GASTOS c3-circles c3-circles-GASTOS" style="cursor: pointer;"></g>
											</g>
										</g>
										<g class="c3-chart-arcs" transform="translate(250,143)">
											<text class="c3-chart-arcs-title" style="text-anchor: middle; opacity: 0;"></text>
											<g class="c3-chart-arc c3-target c3-target-MONTO-INICIAL">
												<g class=" c3-shapes c3-shapes-MONTO-INICIAL c3-arcs c3-arcs-MONTO-INICIAL">
													<path class=" c3-shape c3-shape c3-arc c3-arc-MONTO-INICIAL" transform="" style="fill: rgb(55, 71, 79); cursor: pointer; opacity: 1;" d="M-2.270029252038606,-135.83103278409865A135.85,135.85 0 0,1 -2.4955240149625186e-14,-135.85L0,0Z"></path>
												</g>
												<text dy=".35em" class="" transform="translate(-0.9080433963542192,-108.67620649061291)" style="opacity: 1; text-anchor: middle; pointer-events: none;"></text>
											</g>
											<g class="c3-chart-arc c3-target c3-target-INGRESOS">
												<g class=" c3-shapes c3-shapes-INGRESOS c3-arcs c3-arcs-INGRESOS">
													<path class=" c3-shape c3-shape c3-arc c3-arc-INGRESOS" transform="" style="fill: rgb(92, 184, 92); cursor: pointer; opacity: 1;" d="M8.318413383208396e-15,-135.85A135.85,135.85 0 1,1 -2.270029252038606,-135.83103278409865L0,0Z"></path>
												</g>
												<text dy=".35em" class="" transform="translate(0.9080433963541577,108.67620649061291)" style="opacity: 1; text-anchor: middle; pointer-events: none;">49.7%</text>
											</g>
											<g class="c3-chart-arc c3-target c3-target-DEVOLUCIONES">
												<g class=" c3-shapes c3-shapes-DEVOLUCIONES c3-arcs c3-arcs-DEVOLUCIONES">
													<path class=" c3-shape c3-shape c3-arc c3-arc-DEVOLUCIONES" transform="" style="fill: rgb(233, 87, 63); cursor: pointer; opacity: 1;" d="M-2.4955240149625186e-14,-135.85A135.85,135.85 0 0,1 -2.4955240149625186e-14,-135.85L0,0Z"></path>
												</g>
												<text dy=".35em" class="" transform="translate(-1.996419211970015e-14,-108.68)" style="opacity: 1; text-anchor: middle; pointer-events: none;"></text>
											</g>
											<g class="c3-chart-arc c3-target c3-target-PRESTAMOS">
												<g class=" c3-shapes c3-shapes-PRESTAMOS c3-arcs c3-arcs-PRESTAMOS">
													<path class=" c3-shape c3-shape c3-arc c3-arc-PRESTAMOS" transform="" style="fill: rgb(246, 187, 66); cursor: pointer; opacity: 1;" d="M-2.4955240149625186e-14,-135.85A135.85,135.85 0 0,1 -2.4955240149625186e-14,-135.85L0,0Z"></path>
												</g>
												<text dy=".35em" class="" transform="translate(-1.996419211970015e-14,-108.68)" style="opacity: 1; text-anchor: middle; pointer-events: none;"></text>
											</g>
											<g class="c3-chart-arc c3-target c3-target-GASTOS">
												<g class=" c3-shapes c3-shapes-GASTOS c3-arcs c3-arcs-GASTOS">
													<path class=" c3-shape c3-shape c3-arc c3-arc-GASTOS" transform="" style="fill: rgb(99, 211, 233); cursor: pointer; opacity: 1;" d="M-2.4955240149625186e-14,-135.85A135.85,135.85 0 0,1 -2.4955240149625186e-14,-135.85L0,0Z"></path>
												</g>
												<text dy=".35em" class="" transform="translate(-1.996419211970015e-14,-108.68)" style="opacity: 1; text-anchor: middle; pointer-events: none;"></text>
											</g>
										</g>
										<g class="c3-chart-texts">
											<g class="c3-chart-text c3-target c3-target-MONTO-INICIAL" style="opacity: 1; pointer-events: none;">
												<g class=" c3-texts c3-texts-MONTO-INICIAL"></g>
											</g>
											<g class="c3-chart-text c3-target c3-target-INGRESOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-texts c3-texts-INGRESOS"></g>
											</g>
											<g class="c3-chart-text c3-target c3-target-DEVOLUCIONES" style="opacity: 1; pointer-events: none;">
												<g class=" c3-texts c3-texts-DEVOLUCIONES"></g>
											</g>
											<g class="c3-chart-text c3-target c3-target-PRESTAMOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-texts c3-texts-PRESTAMOS"></g>
											</g>
											<g class="c3-chart-text c3-target c3-target-GASTOS" style="opacity: 1; pointer-events: none;">
												<g class=" c3-texts c3-texts-GASTOS"></g>
										</g>
									</g>
								</g>
								<g clip-path="url(index.php?view=caja#c3-1608241707142-clip-grid)" class="c3-grid c3-grid-lines">
									<g class="c3-xgrid-lines"></g>
									<g class="c3-ygrid-lines"></g>
								</g>
								<g class="c3-axis c3-axis-x" clip-path="url(index.php?view=caja#c3-1608241707142-clip-xaxis)" transform="translate(0,296)" style="visibility: visible; opacity: 0;">
									<text class="c3-axis-x-label" transform="" style="text-anchor: end;" x="500" dx="-0.5em" dy="-0.5em"></text>
									<g class="tick" transform="translate(250, 0)" style="opacity: 1;">
										<line y2="6" x1="0" x2="0"></line>
										<text y="9" x="0" transform="" style="text-anchor: middle; display: block;">
											<tspan x="0" dy=".71em" dx="0">0</tspan>
										</text>
									</g>
									<path class="domain" d="M0,6V0H500V6"></path>
								</g>
								<g class="c3-axis c3-axis-y" clip-path="url(index.php?view=caja#c3-1608241707142-clip-yaxis)" transform="translate(0,0)" style="visibility: visible; opacity: 0;">
									<text class="c3-axis-y-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="1.2em"></text>
									<g class="tick" transform="translate(0,272)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,231)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">500</tspan></text></g><g class="tick" transform="translate(0,190)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">1000</tspan></text></g><g class="tick" transform="translate(0,149)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">1500</tspan></text></g><g class="tick" transform="translate(0,108)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">2000</tspan></text></g><g class="tick" transform="translate(0,67)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">2500</tspan></text></g><g class="tick" transform="translate(0,26)" style="opacity: 1;"><line x2="-6"></line><text x="-9" y="0" style="text-anchor: end;"><tspan x="-9" dy="3">3000</tspan></text></g><path class="domain" d="M-6,1H0V296H-6"></path></g><g class="c3-axis c3-axis-y2" transform="translate(500,0)" style="visibility: hidden; opacity: 0;"><text class="c3-axis-y2-label" transform="rotate(-90)" style="text-anchor: end;" x="0" dx="-0.5em" dy="-0.5em"></text><g class="tick" transform="translate(0,296)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0</tspan></text></g><g class="tick" transform="translate(0,267)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.1</tspan></text></g><g class="tick" transform="translate(0,237)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.2</tspan></text></g><g class="tick" transform="translate(0,208)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.3</tspan></text></g><g class="tick" transform="translate(0,178)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.4</tspan></text></g><g class="tick" transform="translate(0,149)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.5</tspan></text></g><g class="tick" transform="translate(0,119)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.6</tspan></text></g><g class="tick" transform="translate(0,90)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.7</tspan></text></g><g class="tick" transform="translate(0,60)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.8</tspan></text></g><g class="tick" transform="translate(0,31)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">0.9</tspan></text></g><g class="tick" transform="translate(0,1)" style="opacity: 1;"><line x2="6" y2="0"></line><text x="9" y="0" style="text-anchor: start;"><tspan x="9" dy="3">1</tspan></text></g><path class="domain" d="M6,1H0V296H6"></path></g></g><g transform="translate(0.5,320.5)" style="visibility: hidden;"><g clip-path="url(index.php?view=caja#c3-1608241707142-clip-subchart)" class="c3-chart"><g class="c3-chart-bars"></g><g class="c3-chart-lines"></g></g><g clip-path="url(index.php?view=caja#c3-1608241707142-clip)" class="c3-brush" style="pointer-events: all; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><rect class="background" x="0" width="500" style="visibility: hidden; cursor: crosshair;"></rect><rect class="extent" x="0" width="0" style="cursor: move;"></rect><g class="resize e" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g><g class="resize w" transform="translate(0,0)" style="cursor: ew-resize; display: none;"><rect x="-3" width="6" height="6" style="visibility: hidden;"></rect></g></g><g class="c3-axis-x" transform="translate(0,0)" clip-path="url(index.php?view=caja#c3-1608241707142-clip-xaxis)" style="visibility: visible; opacity: 0;"><g class="tick" transform="translate(250, 0)" style="opacity: 1;"><line y2="6" x1="0" x2="0"></line><text y="9" x="0" transform="" style="text-anchor: middle; display: block;"><tspan x="0" dy=".71em" dx="0">0</tspan></text></g><path class="domain" d="M0,6V0H500V6"></path></g></g><g transform="translate(0,300)"><g class="c3-legend-item c3-legend-item-MONTO-INICIAL" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="34" y="9" style="pointer-events: none;">MONTO INICIAL</text><rect class="c3-legend-item-event" x="20" y="-5" width="111" height="20" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" stroke-width="10" x1="18" y1="4" x2="28" y2="4" style="pointer-events: none; stroke: rgb(55, 71, 79);"></line></g><g class="c3-legend-item c3-legend-item-INGRESOS" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="145" y="9" style="pointer-events: none;">INGRESOS</text><rect class="c3-legend-item-event" x="131" y="-5" width="82" height="20" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" stroke-width="10" x1="129" y1="4" x2="139" y2="4" style="pointer-events: none; stroke: rgb(92, 184, 92);"></line></g><g class="c3-legend-item c3-legend-item-DEVOLUCIONES" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="227" y="9" style="pointer-events: none;">DEVOLUCIONES</text><rect class="c3-legend-item-event" x="213" y="-5" width="112" height="20" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" stroke-width="10" x1="211" y1="4" x2="221" y2="4" style="pointer-events: none; stroke: rgb(233, 87, 63);"></line></g><g class="c3-legend-item c3-legend-item-PRESTAMOS" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="339" y="9" style="pointer-events: none;">PRESTAMOS</text><rect class="c3-legend-item-event" x="325" y="-5" width="95" height="20" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" stroke-width="10" x1="323" y1="4" x2="333" y2="4" style="pointer-events: none; stroke: rgb(246, 187, 66);"></line></g><g class="c3-legend-item c3-legend-item-GASTOS" style="visibility: visible; cursor: pointer; opacity: 1;"><text x="434" y="9" style="pointer-events: none;">GASTOS</text><rect class="c3-legend-item-event" x="420" y="-5" width="60" height="20" style="fill-opacity: 0;"></rect><line class="c3-legend-item-tile" stroke-width="10" x1="418" y1="4" x2="428" y2="4" style="pointer-events: none; stroke: rgb(99, 211, 233);"></line></g></g><text class="c3-title" x="250" y="0"></text>
								</svg>
								<div class="c3-tooltip-container" style="position: absolute; pointer-events: none; display: none; top: 159.5px; left: 387.062px;">
									<table class="c3-tooltip">
										<tbody>
											<tr class="c3-tooltip-name-INGRESOS">
												<td class="name"><span style="background-color:#5CB85C"></span>INGRESOS</td>
												<td class="value">99.7%</td>
											</tr>
										</tbody>
									</table>
								</div>
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