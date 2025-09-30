<?php
//print_r($_SESSION); 

$valores = CompanyData::getById($_SESSION['id_company']);
$users = UserData::getAll();

$companys = (object) $valores[0];
var_dump($companys); 
?>
<section id="main" role="main">
<div class="container-fluid">
	<div class="page-header page-header-block">
		<div class="page-header-section">
			<h4 class="title semibold"> Mi compañia </h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="tabsx">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#empresa" data-toggle="tab" aria-expanded="true"><b>General</b></a></li>
					<li class=""><a href="#usuarios" data-toggle="tab" aria-expanded="false"><b>Usuarios</b></a></li>
					<li class=""><a href="#autorizaciones" data-toggle="tab" aria-expanded="false"><b>Autorizaciones SRI</b></a></li>
					<li class=""><a href="#facturacion_electronica" data-toggle="tab" aria-expanded="false"><b>Facturación Electrónica</b></a></li>
					<li class=""><a href="#adicionales" data-toggle="tab" aria-expanded="false"><b>Otras Configuraciones</b></a></li>
					<li class=""><a href="#tab_config_correo" data-toggle="tab" aria-expanded="false"><b>Notificaciones</b></a></li>
				</ul>
			</div>
			<div class="tab-content panel">
				<div id="empresa" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Respaldar Movimientos Contables</h3>
						</div>
						<div class="panel-body">
							<label class="col-md-1 col-sm-1 text-right control-label">Mes:</label>
							<div class="col-md-2 col-sm-3">
							<select class="form-control input-sm" id="id_mes" name="mes">
								<option value="1">Enero</option>
								<option value="2">Febrero</option>
								<option value="3">Marzo</option>
								<option value="4">Abril</option>
								<option value="5">Mayo</option>
								<option value="6" selected="selected">Junio</option>
								<option value="7">Julio</option>
								<option value="8">Agosto</option>
								<option value="9">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
							</div>
									<label class="col-md-1 col-sm-1 text-right control-label">Año:</label>
									<div class="col-md-2 col-sm-3">
							<select class="form-control input-sm" id="id_anio" name="anio">
								<option value="2017">2017</option>
							</select>
							</div>
									<div class="col-md-2 col-sm-3">
										<a class="btn btn-default btn-sm text-primary" onclick="generarBackup(this);" href="https://grupogps.contifico.com/sistema/empresa/configuracion/backup/">
											<b><span class="ico-file-xml"></span>
											Generar</b>
										</a>
									</div>
							</div>
						</div>
					<form method="POST" name="configForm" enctype="multipart/form-data" class="form-horizontal">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Configuraciones de la Empresa</h3>
							</div>
							<div class="panel-body">
								<table id="tconfig" class="table table-bordered table-hover" style="background-color:white;">
									<thead>
										<tr>
											<th width="80px:"></th>
											<th width="255px;"><b>Configuración</b></th>
											<th><b>Descripción</b></th>
											<th width="50px;"><b>Archivo</b></th>
										</tr>
									</thead>
									<tbody>
										<tr class="even">
											<td></td>
											<td><b>Ruc:</b></td>
											<td>0992831855001</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Razón social:</b></td>
											<td>GPS GLOBAL PROTECTION SECURITY GLOBALPROTECTIONSECURITY CIA. LTDA.</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Nombre comercial:</b></td>
											<td>GRUPO GPS</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Número de Establecimientos:</b><br><span class="recomendacion">(Formato válido: 001,002,003 etc.)</span></td>
											<td>
												<div class="col-md-2 col-sm-3" style="padding-left:0;"><input class="form-control input-sm" id="id_numero_establecimientos" maxlength="300" name="numero_establecimientos" type="text" value="001"></div><br><br>
												<div style="color:blue;font-size:11px;">(Campo requerido para el nuevo ATS 2013)</div>
											</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Obligado a llevar contabilidad:</b><br></td>
											<td>
												<div class="col-md-2 col-sm-3" style="padding-left:0;">
								<select class="select-input form-control input-sm" id="id_obligado_contabilidad" name="obligado_contabilidad">
									<option value="SI" selected="selected">SI</option>
									<option value="NO">NO</option>
								</select>
								</div>
								<br><br>
											</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Contribuyente especial:</b><br></td>
											<td>
												<div class="col-md-2 col-sm-3" style="padding-left:0;"><input class="form-control input-sm" id="id_contribuyente_especial" maxlength="10" name="contribuyente_especial" type="text"></div><br><br>
											</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Exportador:</b><br></td>
											<td>
												<div class="col-md-2 col-sm-3" style="padding-left:0;">
													<div class="checkbox custom-checkbox custom-checkbox-primary">
													<input id="id_exportador" name="exportador" type="checkbox"><label class="control_label_contif" for="id_exportador"></label></div>
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Ciudad:</b></td>
											<td>
												<div class="col-md-4 col-sm-4" style="padding-left:0;">
													<input class="form-control input-sm" id="id_ciudad" maxlength="100" name="ciudad" type="text" value="Guayaquil">
												</div>
											</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Teléfonos:</b></td>
											<td>09 90239653 - 09 81172776</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Dirección:</b></td>
											<td>CDLA. ALBORADA 10 ETAPA VILLA 11 MZ 210</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Actividad económica:</b></td>
											<td>Servicios de Seguridad</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Num. Decimales:</b></td>
											<td>
								<div class="col-md-2 col-sm-3" style="padding-left:0;">
								<select class="select-input form-control input-sm" id="id_decimales" name="decimales">
									<option value="2" selected="selected">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
								</div>
							</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Email Notificación:</b></td>
											<td>
												<input class="form-control input-sm" id="id_email_notificacion" name="email_notificacion" size="40" type="text">
											</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Logo de la Empresa:</b><br><span class="recomendacion">(Ancho y alto recomendado: 110x35 px)</span></td>
											<td>
												<input id="id_logo" name="logo" type="file" class="form-control input-sm">
											</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Firma Proforma:</b><br><span class="recomendacion">(Ancho y alto recomendado: 110x35 px)</span></td>
											<td>
												<input id="id_firma_cotizacion_proforma" name="firma_cotizacion_proforma" type="file" class="form-control input-sm">
											</td>
											<td></td>
										</tr>
										<tr class="odd">
											<td></td>
											<td><b>Garantía:</b><br><span class="recomendacion">Predeterminada en cotizaciones</span></td>
												<td>
													<input class="form-control input-sm" id="id_garantia_default_proforma" maxlength="150" name="garantia_default_proforma" style="width:30%" type="text">
												</td>
											<td></td>
										</tr>
										<tr class="even">
											<td></td>
											<td><b>Forma de Pago:</b><br><span class="recomendacion">Predeterminada en cotizaciones</span></td>
												<td>
													<input class="form-control input-sm" id="id_forma_pago_default_proforma" maxlength="50" name="forma_pago_default_proforma" style="width:30%" type="text">
												</td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<a class="btn btn-primary btn-sm" href="https://grupogps.contifico.com/sistema/empresa/configuracion/registrar/">
									<span class="ico-plus-circle2"></span>Agregar Detalle
								</a>
							</div>
						</div>
						<br>
						<div class="col-md-4 col-sm-4">
								<a class="btn btn-success" href="javascript:document.forms.configForm.submit();">
									<span class="glyphicon glyphicon-floppy-disk"></span>
									Guardar
								</a>
						</div>
						<div class="col-md-4 col-sm-4">
							<br class="visible-xs">
							<div class="progress">
								<div id="progressbar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0.0" style="width: 0.0%">
									<span class="sr-only"></span>
								</div>
							</div>
							<p style="text-align:center;">Espacio utilizado en archivos adjuntos<br>
								<span style="font-weight: bold;">Espacio Utilizado: </span> 0&nbsp;bytes (0.0%)
								<br><span style="font-weight: bold;">Espacio disponible:</span> 300.0&nbsp;MB
							</p>
						</div>
						<div class="clearfix"></div>
					</form>
				</div>
				<div id="usuarios" class="tab-pane">
						<div class="table-responsive">
							<table id="tusuarios" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th width="70px" class="text-center"></th>
										<th width="150px"><b>Usuario</b></th>
										<th width="300px"><b>Nombres</b></th>
										<th width="100px"><b>Perfil</b></th>
										<th width="100px" class="text-center"><b>Estado</b></th>
									</tr>
								</thead>
								<tbody>
										<tr>
											<td class="text-center"></td>
											<td>jfiallos</td>
											<td>Jorge Fiallos</td>
											<td>Administrador</td>
											<td class="text-center">
												<span class="label label-success">Activo</span>
											</td>
										</tr>
										<tr>
											<td class="text-center">
												<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/17422/"><span class="ico-pencil5"></span></a>
												<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarUsuario(this, &#39;&#39;)" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/eliminar/17422/"><span class="ico-remove3"></span></a>
											</td>
											<td></td>
											<td>Maira Chilan</td>
											<td>Asistente Contable</td>
											<td class="text-center">
												<span class="label label-warning">Pendiente</span>
											</td>
										</tr>
										<tr>
											<td class="text-center">
												<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/17424/"><span class="ico-pencil5"></span></a>
												<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarUsuario(this, &#39;etapia &#39;)" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/eliminar/17424/"><span class="ico-remove3"></span></a>
											</td>
											<td>etapia </td>
											<td>Evelyn Tapia Perero</td>
											<td>Asistente Contable</td>
											<td class="text-center">
												<span class="label label-success">Activo</span>
											</td>
										</tr>
										<tr>
											<td class="text-center">
												<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/17425/"><span class="ico-pencil5"></span></a>
												<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarUsuario(this, &#39;&#39;)" href="https://grupogps.contifico.com/sistema/empresa/configuracion/usuario/eliminar/17425/"><span class="ico-remove3"></span></a>
											</td>
											<td></td>
											<td>Marjorie Quimi</td>
											<td>Asistente Contable</td>
											<td class="text-center">
												<span class="label label-warning">Pendiente</span>
											</td>
										</tr>
								</tbody>
							</table>
						</div>
						<br>
						<a class="btn btn-primary btn-sm" onclick="return agregarUsuario(&#39;/sistema/empresa/configuracion/usuario/registrar/&#39;);">
							<span class="ico-plus-circle2"></span>
							Agregar Usuario
						</a>
					</div>
				<div id="autorizaciones" class="tab-pane">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Autorizaciones de Comprobantes de Venta y Retenciones</h3>
						</div>
						<div class="table-responsive panel-collapse pull out">
								<table id="tusuarios" class="table table-hover table-bordered table-striped" style="background-color:white;">
									<thead>
										<tr>
											<th width="70px;"></th>
											<th><b>Autorización</b></th>
											<th><b>Tipo Comp.</b></th>
											<th><b>Sec. Inicio</b></th>
											<th><b>Sec. Fin</b></th>
											<th><b>Fecha Inicio</b></th>
											<th><b>Fecha Fin</b></th>
										</tr>
									</thead>
									<tbody>
											<tr>
													<td>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/138738/"><span class="ico-pencil5"></span></a>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, &#39;1120892512&#39;)" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/138738/"><span class="ico-remove3"></span></a>
													</td>
													<td>1120892512</td>
													<td>Retención</td>
													<td>351</td>
													<td>450</td>
													<td>12/06/2017</td>
													<td>12/06/2018</td>
											</tr>
											<tr>
													<td>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137529/"><span class="ico-pencil5"></span></a>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, &#39;1120677683&#39;)" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137529/"><span class="ico-remove3"></span></a>
													</td>
													<td>1120677683</td>
													<td>Retención</td>
													<td>000000301</td>
													<td>000000351</td>
													<td>04/05/2017</td>
													<td>04/05/2018</td>
											</tr>
											<tr>
													<td>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Modificar" class="btn btn-primary btn-xs" rel="tooltip" href="https://grupogps.contifico.com/sistema/registro/autorizacion/137731/"><span class="ico-pencil5"></span></a>
														<a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" onclick="return eliminarAutorizacion(this, &#39;1120677683&#39;)" href="https://grupogps.contifico.com/sistema/registro/autorizacion/eliminar/137731/"><span class="ico-remove3"></span></a>
													</td>
													<td>1120677683</td>
													<td>Venta</td>
													<td>201</td>
													<td>300</td>
													<td>04/05/2017</td>
													<td>04/05/2018</td>
											</tr>
									</tbody>
								</table>
						</div>
					</div>
					<a class="btn btn-primary btn-sm" href="./?view=addautorizar">
						<span class="fa fa-plus-circle"></span>
						Agregar Autorizaci&oacute;n
					</a>
				</div>
				<div id="facturacion_electronica" class="tab-pane">
						<div class="row">
							<div class="col-md-6">
								<table id="tconfig" class="table table-hover" style="background-color:white;">
									<thead>
										<tr>
											<th width="5%"></th>
											<th width="40%">Configuración General</th>
											<th width="55%"></th>
										</tr>
									</thead>
									<tbody>
											<tr class="odd">
												<td></td>
												<td><b>Limite Documentos Electrónicos</b><br><span class="recomendacion">(Límite mensual de documentos emitidos)</span></td>
												<td>
													200.00
												</td>
											</tr>
											<tr class="even">
												<td></td>
												<td><b>Cupo Disponible</b><br><span class="recomendacion">(Cupo disponible para emitir)</span></td>
												<td>
													200.00
												</td>
											</tr>
											<tr class="odd">
												<td></td>
												<td><b>Firma Electrónica</b><br><span class="recomendacion">(Firma Electrónica del Representante Legal)</span></td>
												<td>
											<div class="input-group">
														<span class="input-group-btn">
														<div class="btn btn-default btn-file">
												<b>Seleccionar&nbsp;</b><span class="ico-folder4"></span><input id="id_firma_electronica" name="firma_electronica" type="file" class="form-control input-sm">
											</div>
														</span>
														<input type="text" class="form-control" readonly="" style="background-color: white;" placeholder="">
													</div>
												</td>
											</tr>
											<tr class="even">
												<td></td>
												<td><b> Clave Firma Electrónica</b><br><span class="recomendacion"></span></td>
												<td>
												<table class="tablaCambiarClave">
													<tbody>
									<tr>
														<td style="padding-right: 5px;">
															<input class="form-control input-sm" id="id_clave_firma_electronica" maxlength="300" name="clave_firma_electronica" type="password">
															<span class="recomendacion">Ingrese clave</span>
														</td><td style="padding-right: 5px;">
															<input class="form-control input-sm" id="id_clave_firma_electronica_confirm" maxlength="300" name="clave_firma_electronica_confirm" type="password">
															<span class="recomendacion">Confirme clave</span>
														</td>
										<td></td>
														</tr>
									<tr></tr>
									</tbody>
								</table>
												</td>
											</tr>
											<tr class="odd">
												<td></td>
												<td><b>Establecimiento - Punto Emisión por defecto</b><br><span class="recomendacion">(Válido para registro manual de documentos)</span></td>
												<td>
													<span class="btn btn-primary btn-xs" onclick="javascript:mostrarModalFactElect(&#39;ptoemi&#39;);" style="float: left;">
														<span class="ico-plus"></span>
													</span>
													<table class="table-est-ptoemi" style="float: left;">
														<!--<tr><td><b>Factura</b></td><td>001</td><td>002</td><td><span class="text-danger ico-cancel-circle2"></span></td></tr>
														<tr><td><b>Retención</b></td><td>001</td><td>004</td><td><span class="text-danger ico-cancel-circle2"></span></td></tr>-->
													</table>
												</td>
											</tr>
											<tr class="even">
												<td></td>
												<td><b>Mensaje Personalizado</b><br><span class="recomendacion">(Se mostrará en la parte inferior de su RIDE)</span></td>
												<td>
													<span class="btn btn-default">
														<a class="text-default" href="javascript:mostrarModalFactElect(&#39;mensaje&#39;);"><b>Editar Mensaje&nbsp;<span class="ico-pencil5"></span></b></a>
													</span>
													<span class="multiselect-native-select"><select id="id_tipodocumentos" name="tipodocumentos" multiple="multiple" class="form-control input-sm"><option value="FAC">Factura</option><option value="RET">Retención</option><option value="NCT">Nota de Crédito</option><option value="NDT">Nota de Débito</option><option value="GUI">Guia Remisión</option></select><div class="btn-group"><button type="button" class="multiselect dropdown-toggle btn btn-default button-select" data-toggle="dropdown" title="Ninguno" style="min-width: 190px;"><span class="multiselect-selected-text">Ninguno</span> <b class="caret"></b></button><ul class="multiselect-container dropdown-menu"><li class="multiselect-item multiselect-all"><a tabindex="0" class="multiselect-all"><label class="checkbox"><input type="checkbox" value="multiselect-all"> Todos</label></a></li><li><a tabindex="0"><label class="checkbox"><input type="checkbox" value="FAC"> Factura</label></a></li><li><a tabindex="0"><label class="checkbox"><input type="checkbox" value="RET"> Retención</label></a></li><li><a tabindex="0"><label class="checkbox"><input type="checkbox" value="NCT"> Nota de Crédito</label></a></li><li><a tabindex="0"><label class="checkbox"><input type="checkbox" value="NDT"> Nota de Débito</label></a></li><li><a tabindex="0"><label class="checkbox"><input type="checkbox" value="GUI"> Guia Remisión</label></a></li></ul></div></span>
													<input id="id_mensaje_tipodocumentos" name="mensaje_tipodocumentos" type="hidden">
												</td>
											</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6"></div>
						</div>
						<div class="clearfix"></div>
							<br>
							<a class="btn btn-success" href="javascript:document.forms.configForm.submit();cargar_claves();">
								<span class="glyphicon glyphicon-floppy-disk"></span>
								Guardar
							</a>
					</div>
				<div id="adicionales" class="tab-pane">
					<div class="table-responsive">
						<table id="tconfig" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><div style="width:450px;">Personas</div></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><p> Persona - Campos Personalizados por Cliente:</p>
										<table cellspacing="0" cellpadding="0" border="0" id="campos_cliente" style="display: none">
											<tbody>
								<tr>
													<td>
														1: <input class="form-control input-sm" id="id_campo_persona_1" maxlength="100" name="campo_persona_1" type="text">
													</td>
													<td>
														2: <input class="form-control input-sm" id="id_campo_persona_2" maxlength="100" name="campo_persona_2" type="text">
													</td>
												</tr>
												<tr>
													<td>
														3: <input class="form-control input-sm" id="id_campo_persona_3" maxlength="100" name="campo_persona_3" type="text">
													</td>
													<td>
														4: <input class="form-control input-sm" id="id_campo_persona_4" maxlength="100" name="campo_persona_4" type="text">
													</td>
												</tr>
											</tbody>
							</table>
									</td>
									<td>
										<!-- <div id="config_campospersonalizados"></div> -->
										<label class="switch switch-success">
											<input id="id_config_campospersonalizados" name="config_campospersonalizados" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
									</td>
								</tr>
								<tr>
									<td><p> Persona - Campos Personalizados por Proveedor:</p>
											<table cellspacing="0" cellpadding="0" id="campos_proveedor" style="display: none">
												<tbody><tr>
													<td>
														1: <input class="form-control input-sm" id="id_campo_persona_1p" maxlength="100" name="campo_persona_1p" type="text">
													</td>
													<td>
														2: <input class="form-control input-sm" id="id_campo_persona_2p" maxlength="100" name="campo_persona_2p" type="text">
													</td>
												</tr>
												<tr>
													<td>
														3: <input class="form-control input-sm" id="id_campo_persona_3p" maxlength="100" name="campo_persona_3p" type="text">
													</td>
													<td>
														4: <input class="form-control input-sm" id="id_campo_persona_4p" maxlength="100" name="campo_persona_4p" type="text">
													</td>
												</tr>
											</tbody>
							</table>
									</td>
									<td>
										<!-- <div id="config_campospersonalizadosp"></div> -->
										<label class="switch switch-success">
											<input id="id_config_campospersonalizadosp" name="config_campospersonalizadosp" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
									</td>
								</tr>
								<tr class="odd">
									<td>Registrar Persona - Crear Eventos:</td>
									<td>
										<!-- <div id="config_eventos"></div> -->
										<label class="switch switch-success">
											<input id="id_config_eventos" name="config_eventos" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
									</td>
								</tr>
								<tr class="even">
									<td>Registrar Persona - Ciudad:</td>
									<td>
										<label class="switch switch-success">
											<input id="id_habilitar_ciudad" name="habilitar_ciudad" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
									</td>
								</tr>
							</tbody>
						</table>
						<table id="tconfig" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><div style="width:450px;">Compra/Venta</div></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd">
									<td>Registrar Documento - Centro de Costo Obligatorio:</td>
									<td>
										<label class="switch switch-success">
											<input id="id_config_ccobligatorio" name="config_ccobligatorio" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
										<!-- <div id="config_ccobligatorio"></div> -->
									</td>
								</tr>
								<tr class="even">
									<td><p>Registrar Documento - Campos Adicionales:</p>
										<table cellspacing="0" cellpadding="0" id="campos_adicionales_documento" style="display: none">
											<tbody><tr>
												<td>
													1: <input class="form-control input-sm" id="id_campo_adicional_doc1" maxlength="100" name="campo_adicional_doc1" type="text">
												</td>
												<td>
													2: <input class="form-control input-sm" id="id_campo_adicional_doc2" maxlength="100" name="campo_adicional_doc2" type="text">
												</td>
											</tr>
										</tbody></table>
									</td>
									<td>
										<!-- <div id="config_camposadicionales"></div> -->
										<label class="switch switch-success">
											<input id="id_config_camposadicionales" name="config_camposadicionales" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
									</td>
								</tr>
								<tr class="odd">
									<td>Aprobar Cotización:</td>
									<td>
										<label class="switch switch-success">
											<input id="id_config_aprobarcotizacion" name="config_aprobarcotizacion" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
										<!-- <div id="config_aprobarcotizacion"></div> -->
									</td>
								</tr>
								<tr class="even">
									<td>Aprobar Prefactura:</td>
									<td>
										<label class="switch switch-success">
											<input id="id_config_aprobarprefactura" name="config_aprobarprefactura" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
										<!-- <div id="config_aprobarprefactura"></div> -->
									</td>
								</tr>
								<tr class="odd">
						<td>Permitir Numero de DNA Repetido:</td>
						<td>
							<label class="switch switch-success">
							<input id="id_config_repetirdna" name="config_repetirdna" type="checkbox" style="display: none;">
									<span class="switch"></span>
								</label>
							<!-- <div id="config_repetirdna"></div> -->
						</td>
						</tr>
						<tr class="even">
						<td>Asiento de Retencion Independiente:</td>
						<td>
							<label class="switch switch-success">
							<input checked="checked" id="id_config_retencionesindependientes" name="config_retencionesindependientes" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
							<!-- <div id="config_retencionesindependientes"></div> -->
						</td>
						</tr>
						<tr class="odd">
						<td>Permitir Reembolso de Gastos:</td>
						<td>
							<label class="switch switch-success">
							<input id="id_config_reembolsogasto" name="config_reembolsogasto" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
							<!-- <div id="config_reembolsogasto"></div> -->
						</td>
						</tr>
						<tr class="even">
							<td>Enviar IVA al Gasto:</td>
							<td>
							<label class="switch switch-success">
								<input checked="checked" id="id_config_enviarivagasto" name="config_enviarivagasto" type="checkbox" style="display: none;">
								<span class="switch"></span>
							</label>
							<!-- <div id="config_enviarivagasto"></div> -->
							</td>
						</tr>
						<!-- para servicios -->
						<tr class="even">
							<td>Porcentaje de Servicio:<br>
								<div class="hide porcentaje-servicio" style="padding: 6px;">
									&nbsp;&nbsp;&nbsp;Porcentaje:&nbsp;<input class="text-right form-control input-sm" id="id_valor_porcentajeservicio" name="valor_porcentajeservicio" size="20" type="text">%
								</div>
							</td>
							<td>
								<!-- <div id="config_porcentajeservicio"></div> -->
								<label class="switch switch-success">
									<input id="id_config_porcentajeservicio" name="config_porcentajeservicio" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
							</td>
						</tr>
								<!-- fin para servicios -->
						<tr class="odd">
						<td colspan="2">Ordenar Items Documento:
							<div class="pull-right" style="padding-right: 40px">
							<select class="select-input form-control input-sm" id="id_config_ordenarbienservicio" name="config_ordenarbienservicio">
								<option value="ABC" selected="selected">Orden Alfabetico</option>
								<option value="ORG">Orden de Registro</option>
							</select>
							</div>
						</td>
						</tr>
						<tr class="even">
						<td>Restringir Días de Vencimiento:</td>
						<td>
							<label class="switch switch-success">
							<input id="id_config_restringir_vencimiento" name="config_restringir_vencimiento" type="checkbox" style="display: none;">
							<span class="switch"></span>
							</label>
							<!-- <div id="config_restringir_vencimiento"></div> -->
						</td>
						</tr>
							</tbody>
						</table>
						<table id="tconfigcaja" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><div style="width:450px;">Caja Online</div></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr class="even">
									<td>Habilitar Cierre de Caja en Nube</td>
									<td>
										<label class="switch switch-success">
											<input id="id_habilitar_caja_online" name="habilitar_caja_online" type="checkbox">
											<span class="switch"></span>
										</label>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="text-right panel-footer">
							<a class="btn btn-success" href="javascript:document.forms.configForm.submit();">
								<span class="glyphicon glyphicon-floppy-disk"></span>
								Guardar
							</a>
						</div>
					</div>
				</div>
				<div id="tab_config_correo" class="tab-pane">
					<div class="row">
						<div class="col-md-12">
						<h5><i>La siguiente configuración de Correo electrónico se utiliza para el envío de <b>documentos electrónicos</b> y notificaciones para <b>pagos de proveedores</b>.</i></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><i class="ico-wrench3 mr5"></i> Datos Generales</h3>
								</div>
								<div class="panel-collapse pull out">
								<div class="panel-body">
										<table id="tconfig" class="table table-hover" style="background-color:white;">
											<tbody>
												<tr class="odd">
													<td></td>
													<td><b>Servidor SMTP</b></td>
													<td>
														<input class="form-control input-sm" id="id_servidor_smtp" maxlength="300" name="servidor_smtp" type="text">
													</td>
												</tr>
												<tr class="even">
													<td></td>
													<td><b>TLS:</b></td>
													<td>
														<div class="checkbox custom-checkbox custom-checkbox-primary check_firmado_auto">
															<input id="id_tls_mail" name="tls_mail" type="checkbox"><label class="control_label_contif" for="id_tls_mail">&nbsp;</label>
														</div>
													</td>
												</tr>
												<tr class="odd">
													<td></td>
													<td><b>Puerto SMTP</b></td>
													<td>
														<input class="form-control input-sm" id="id_puerto_smtp" name="puerto_smtp" type="text">
													</td>
												</tr>
												<tr class="even">
													<td></td>
													<td><b>Usuario</b></td>
													<td>
														<input class="form-control input-sm" id="id_usuario_mail" maxlength="300" name="usuario_mail" type="text">
													</td>
												</tr>
												<tr class="odd">
													<td></td>
													<td><b>Contraseña</b></td>
													<td>
														<div class="input-group">
															<input class="form-control input-sm" id="id_password_mail" maxlength="300" name="password_mail" type="password">
										<span class="input-group-btn">
										<a class="btn btn-primary btn-sm" href="javascript:mailActualizarEstado();" id="btn_probarCorreo">
											<span class="ico-spinner12"></span>&nbsp;Probar
										</a>
										</span>
									</div>
													</td>
												</tr>
											</tbody>
										</table>
								</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="text-left panel-footer">
								<br>
								<a class="btn btn-success" href="javascript:document.forms.configForm.submit()">
									<span class="glyphicon glyphicon-floppy-disk"></span>
									Guardar
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div id="dlgFactElect" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header text-center">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title titulo-factelect"></h4>
					</div>
					<div class="modal-body agregar_ptoemi">
						<div class="indicator ptoemi_indicator"><span class="spinner spinner16"></span></div>
						<div class="row">
						<div class="form-group">
							<label class="col-sm-4">Tipo Documento</label>
							<label class="col-sm-4">Establecimiento</label>
									<label class="col-sm-4">Punto Emisión</label>
							<div class="col-sm-4"><select id="id_tipd" name="tipd" class="form-control input-sm"><option value="FAC">Factura</option><option value="RET">Retención</option><option value="NCT">Nota de Crédito</option><option value="NDT">Nota de Débito</option><option value="GUI">Guia Remisión</option></select></div>
							<div class="col-sm-4"><select id="id_esta" name="esta" class="form-control input-sm">
								<option value="001">001</option></select>
							</div>
									<div class="col-sm-4"><input id="id_ptoe" name="ptoe" class="form-control input-sm" type="text" maxlength="3" value="001"></div>
						</div>
						</div>
					</div>
					<div class="modal-body agregar_mensaje">
						<div class="indicator mensaje_indicator"><span class="spinner spinner16"></span></div>
						<div class="form-group">
							<input id="mensaje_titulo" type="text" class="form-control" placeholder="Título" value="">
							<textarea id="mensaje_contenido" class="form-control" rows="6" placeholder="Mensaje"></textarea>
						</div>
					</div>
					<div class="modal-footer" style="padding-top: 5px;padding-bottom: 5px;">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary agregar_ptoemi" onclick="javascript:AgregarPtoEmi();">Aceptar</button>
						<button type="button" class="btn btn-primary agregar_mensaje" onclick="javascript:AgregarMensaje();">Aceptar</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	</div>
</div>
<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="fa fa-angle-up"></i></a>
<!--/ END To Top Scroller -->
</section>
<script type="text/javascript">
function ejecutarMenu(){
		$('.sidebar-minimized .sidebar .topmenu li .submenu li').hover(function(){
			$(this).addClass('hover open');
		}, function(){
			$(this).removeClass('hover open');
		});
}
function loadMenu(){
	//para el menu expandido o contraido
	if(Cookies.get('menu') == 'xs'){
	//window.adminre.isMinimize = true;
	$('html').removeClass('sidebar-maximized');
	$('html').addClass('sidebar-minimized');
	}else{
	//window.adminre.isMinimize = false;
	$('html').addClass('sidebar-maximized');
	$('html').removeClass('sidebar-minimized');
	}
}
function mostrar_alerta_vencimiento(){
	$('#modal_alerta_vencimiento').modal();
}
loadMenu();
ejecutarMenu();
</script>
<script type="text/javascript">
	var urlprefix = "/sistema";
	var valor_iva = "12.00";
	var label_iva = "12%";
</script>
<script type="text/javascript">
var tipos_doc_default = {'FAC':'Factura','RET':'Retención','NCT':'Nota de Crédito','NDT':'Nota de Débito','GUI':'Guia Remisión'};
$(document).on('change', '.btn-file :file', function() {
	var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
	});
	$.each(tipos_doc_default, function(i, item) {
		option = "<option value='"+i+"'"+">"+item+"</option>";
		$('#id_tipd').append(option);
		$('#id_tipodocumentos').append(option);
	});
	$('#id_tipodocumentos').multiselect({
			allSelectedText: 'Todos',
			includeSelectAllOption: true,
			selectedAll: true,
			nonSelectedText: 'Ninguno',
			selectAllText: 'Todos',
			buttonClass: 'btn btn-default button-select',
			onChange: function(){$('#id_mensaje_tipodocumentos').val($('#id_tipodocumentos').val());console.log('onchange');console.log($('#id_tipodocumentos').val());},
			onSelectAll:function(){$('#id_mensaje_tipodocumentos').val($('#id_tipodocumentos').val());console.log('selectall');console.log($('#id_tipodocumentos').val());},
		}
	);

	$('.button-select').css('min-width','190px');
	$('.button-select').on('click',function(){
		if(!$('.multiselect-container').is(':visible'))
		{
			$('.multiselect-container').show();
		}else{
			$('.multiselect-container').hide();
		}
	});
});
</script>
<script>
$(function() {
	//$('#tabs').tabs();
	//COSAS PARA SETEAR BOTON ON OFF
	var band_config_campospersonalizados = "off";
	var band_config_campospersonalizadosp = "off";
	var band_config_eventos = "off";
	var band_habilitar_ciudad = "off";
	var band_config_menucotizacion = band_config_aprobarcotizacion = band_config_aprobarprefactura = band_config_ccobligatorio = band_config_repetirdna = band_config_reembolsogasto = band_config_facturarsinstock = "off";
	var band_config_enviarivagasto = "off";
	var band_config_porcentajeservicio = "off";
	var band_config_facturarsinstockgeneral = "off";
	var band_config_restringir_vencimiento = "off";

	var band_config_codcatalogo = band_config_conversionunidades = band_config_control_produccion = band_config_control_produccion_stock = band_config_marcas = "off";
	var band_config_codbarra = band_config_camposadicionales = band_config_propina = band_habilitar_costo_maximo = band_config_marcas = "off";
	var band_config_retencionesindependientes = "off";

	$("#id_config_campospersonalizados").css("display", "none");
	$("#id_config_campospersonalizadosp").css("display", "none");
	$("#id_config_eventos").css("display", "none");
	$("#id_habilitar_ciudad").css("display", "none");
	$("#id_config_menucotizacion").css("display", "none");
	$("#id_config_aprobarcotizacion").css("display", "none");
	$("#id_config_aprobarprefactura").css("display", "none");
	$("#id_config_repetirdna").css("display", "none");
	$("#id_config_reembolsogasto").css("display", "none");
	$("#id_config_enviarivagasto").css("display", "none");
	$("#id_config_porcentajeservicio").css("display", "none");
	$("#id_config_ccobligatorio").css("display", "none");
	$("#id_config_facturarsinstock").css("display", "none");
	$("#id_config_facturarsinstockgeneral").css("display", "none");
	$("#id_config_restringir_vencimiento").css("display", "none");
	$("#id_config_codcatalogo").css("display", "none");
	$("#id_config_conversionunidades").css("display", "none");
	$("#id_config_control_produccion").css("display", "none");
	$("#id_config_control_produccion_stock").css("display", "none");
	$("#id_config_marcas").css("display", "none");
	$("#id_config_codbarra").css("display", "none");
	$("#id_habilitar_costo_maximo").css("display", "none");
	$("#id_config_camposadicionales").css("display", "none");
	$("#id_config_propina").css("display", "none");
	$("#id_config_retencionesindependientes").css("display", "none");

	if($("#id_config_campospersonalizados").is(':checked')) band_config_campospersonalizados = "on";
	if($("#id_config_campospersonalizadosp").is(':checked')) band_config_campospersonalizadosp = "on";
	if($("#id_config_eventos").is(':checked')) band_config_eventos = "on";
	if($("#id_habilitar_ciudad").is(':checked')) band_habilitar_ciudad = "on";
	if($("#id_config_menucotizacion").is(':checked')) band_config_menucotizacion = "on";
	if($("#id_config_aprobarcotizacion").is(':checked')) band_config_aprobarcotizacion = "on";
	if($("#id_config_aprobarprefactura").is(':checked')) band_config_aprobarprefactura = "on";
	if($("#id_config_repetirdna").is(':checked')) band_config_repetirdna = "on";
	if($("#id_config_reembolsogasto").is(':checked')) band_config_reembolsogasto = "on";
	if($("#id_config_enviarivagasto").is(':checked')) band_config_enviarivagasto = "on";
	if($("#id_config_porcentajeservicio").is(':checked')) band_config_porcentajeservicio = "on";
	if($("#id_config_porcentajeservicio").is(':checked')) $('.porcentaje-servicio').removeClass('hide');
	if($("#id_config_ccobligatorio").is(':checked')) band_config_ccobligatorio = "on";
	if($("#id_config_facturarsinstockgeneral").is(':checked')) band_config_facturarsinstockgeneral = "on";
	if($("#id_config_facturarsinstock").is(':checked')) band_config_facturarsinstock = "on";
	if($("#id_config_restringir_vencimiento").is(':checked')) band_config_restringir_vencimiento = "on";
	if($("#id_config_codcatalogo").is(':checked')) band_config_codcatalogo = "on";
	if($("#id_config_conversionunidades").is(':checked')) band_config_conversionunidades = "on";
	if($("#id_config_control_produccion").is(':checked')) band_config_control_produccion = "on";
	if($("#id_config_control_produccion_stock").is(':checked')) band_config_control_produccion_stock = "on";
	if($("#id_config_marcas").is(':checked')) band_config_marcas = "on";
	if($("#id_config_codbarra").is(':checked')) band_config_codbarra = "on";
	if($("#id_habilitar_costo_maximo").is(':checked')) band_habilitar_costo_maximo = "on";
	if($("#id_config_camposadicionales").is(':checked')) band_config_camposadicionales = "on";
	if($("#id_config_marcas").is(':checked')) band_config_marcas = "on";
	if($("#id_config_propina").is(':checked')) band_config_propina = "on";
	if($("#id_config_retencionesindependientes").is(':checked')) band_config_retencionesindependientes = "on";

	$('#config_campospersonalizados').iphoneSwitch(band_config_campospersonalizados,
		function() {$("#id_config_campospersonalizados").attr('checked', true); $('#campos_cliente').show();},
		function() {$("#id_config_campospersonalizados").attr('checked', false); $('#campos_cliente').hide();},
		{});
	$('#config_campospersonalizadosp').iphoneSwitch(band_config_campospersonalizadosp,
		function() {$("#id_config_campospersonalizadosp").attr('checked', true); $('#campos_proveedor').show();},
		function() {$("#id_config_campospersonalizadosp").attr('checked', false); $('#campos_proveedor').hide();},
		{});
	$('#config_eventos').iphoneSwitch(band_config_eventos,
		function() {$("#id_config_eventos").attr('checked', true);},
		function() {$("#id_config_eventos").attr('checked', false);},
		{});
	$('#habilitar_ciudad').iphoneSwitch(band_habilitar_ciudad,
		function() {$("#id_habilitar_ciudad").attr('checked', true);},
		function() {$("#id_habilitar_ciudad").attr('checked', false);},
		{});
	$('#config_menucotizacion').iphoneSwitch(band_config_menucotizacion,
		function() {$("#id_config_menucotizacion").attr('checked', true);},
		function() {$("#id_config_menucotizacion").attr('checked', false);},
		{});
	$('#config_aprobarcotizacion').iphoneSwitch(band_config_aprobarcotizacion,
		function() {$("#id_config_aprobarcotizacion").attr('checked', true);},
		function() {$("#id_config_aprobarcotizacion").attr('checked', false);},
		{});
	$('#config_aprobarprefactura').iphoneSwitch(band_config_aprobarprefactura,
		function() {$("#id_config_aprobarprefactura").attr('checked', true);},
		function() {$("#id_config_aprobarprefactura").attr('checked', false);},
		{});
	$('#config_repetirdna').iphoneSwitch(band_config_repetirdna,
	function() {$("#id_config_repetirdna").attr('checked', true);},
	function() {$("#id_config_repetirdna").attr('checked', false);},
	{});
	$('#config_reembolsogasto').iphoneSwitch(band_config_reembolsogasto,
	function() {$("#id_config_reembolsogasto").attr('checked', true);},
	function() {$("#id_config_reembolsogasto").attr('checked', false);},
	{});
	$('#config_enviarivagasto').iphoneSwitch(band_config_enviarivagasto,
	function() {$("#id_config_enviarivagasto").attr('checked', true);},
	function() {$("#id_config_enviarivagasto").attr('checked', false);},
	{});
	$('#config_porcentajeservicio').iphoneSwitch(band_config_porcentajeservicio,
	function() {$("#id_config_porcentajeservicio").attr('checked', true);$('.porcentaje-servicio').removeClass('hide');},
	function() {$("#id_config_porcentajeservicio").attr('checked', false);$('.porcentaje-servicio').addClass('hide');},
	{});
	$('#config_retencionesindependientes').iphoneSwitch(band_config_retencionesindependientes,
	function() {$("#id_config_retencionesindependientes").attr('checked', true);},
	function() {$("#id_config_retencionesindependientes").attr('checked', false);},
	{});
	$('#config_ccobligatorio').iphoneSwitch(band_config_ccobligatorio,
		function() {$("#id_config_ccobligatorio").attr('checked', true);},
		function() {$("#id_config_ccobligatorio").attr('checked', false);},
		{});
	$('#config_facturarsinstockgeneral').iphoneSwitch(band_config_facturarsinstockgeneral,
		function() {$("#id_config_facturarsinstockgeneral").attr('checked', true);},
		function() {$("#id_config_facturarsinstockgeneral").attr('checked', false);},
		{});
	$('#config_facturarsinstock').iphoneSwitch(band_config_facturarsinstock,
		function() {$("#id_config_facturarsinstock").attr('checked', true);},
		function() {$("#id_config_facturarsinstock").attr('checked', false);},
		{});
	$('#config_restringir_vencimiento').iphoneSwitch(band_config_restringir_vencimiento,
		function() {$("#id_config_restringir_vencimiento").attr('checked', true);},
		function() {$("#id_config_restringir_vencimiento").attr('checked', false);},
		{});
	$('#config_codcatalogo').iphoneSwitch(band_config_codcatalogo,
		function() {$("#id_config_codcatalogo").attr('checked', true);},
		function() {$("#id_config_codcatalogo").attr('checked', false);},
		{});
	$('#config_conversionunidades').iphoneSwitch(band_config_conversionunidades,
		function() {$("#id_config_conversionunidades").attr('checked', true);},
		function() {$("#id_config_conversionunidades").attr('checked', false);},
		{});
	$('#config_control_produccion').iphoneSwitch(band_config_control_produccion,
		function() {$("#id_config_control_produccion").attr('checked', true); $('#control_producciones').show();},
		function() {$("#id_config_control_produccion").attr('checked', false); $('#control_producciones').hide();},
		{});
	$('#config_control_produccion_stock').iphoneSwitch(band_config_control_produccion_stock,
		function() {$("#id_config_control_produccion_stock").attr('checked', true);},
		function() {$("#id_config_control_produccion_stock").attr('checked', false);},
		{});
	$('#config_marcas').iphoneSwitch(band_config_marcas,
		function() {$("#id_config_marcas").attr('checked', true);},
		function() {$("#id_config_marcas").attr('checked', false);},
		{});
	$('#config_codbarra').iphoneSwitch(band_config_codbarra,
		function() {$("#id_config_codbarra").attr('checked', true);},
		function() {$("#id_config_codbarra").attr('checked', false);},
		{});
	$('#habilitar_costo_maximo').iphoneSwitch(band_habilitar_costo_maximo,
		function() {$("#id_habilitar_costo_maximo").attr('checked', true);},
		function() {$("#id_habilitar_costo_maximo").attr('checked', false);},
		{});
	$('#config_camposadicionales').iphoneSwitch(band_config_camposadicionales,
		function() {$("#id_config_camposadicionales").attr('checked', true); $('#campos_adicionales_documento').show();},
		function() {$("#id_config_camposadicionales").attr('checked', false); $('#campos_adicionales_documento').hide();},
		{});
	$('#config_propina').iphoneSwitch(band_config_propina,
		function() {$("#id_config_propina").attr('checked', true);},
		function() {$("#id_config_propina").attr('checked', false);},
		{});
	$('#id_config_marcas').iphoneSwitch(band_config_marcas,
		function() {$("#id_config_marcas").attr('checked', true); $('#nombre_marca').show();},
		function() {$("#id_config_marcas").attr('checked', false); $('#nombre_marca').hide();},
		{});

	bodegafield = new ObjectField($('#id_bodega_inventario_transito_id'));
	safe_url_bodegafield = bodegafield['dlgUrl'];

	//los nuevos checks///////
	//Campos adicionales de clientes///////
	if($("#id_config_campospersonalizados").is(':checked')){
		$('#campos_cliente').show();
	}else{
		$('#campos_cliente').hide();
	}
	$("#id_config_campospersonalizados").on('change',function(){
		if($("#id_config_campospersonalizados").is(':checked')){
			$('#campos_cliente').show();
		}else{
			$('#campos_cliente').hide();
		}
	});
	//Campos adicionales de proveedores///////
	if($("#id_config_campospersonalizadosp").is(':checked')){
		$('#campos_proveedor').show();
	}else{
		$('#campos_proveedor').hide();
	}
	$("#id_config_campospersonalizadosp").on('change',function(){
		if($("#id_config_campospersonalizadosp").is(':checked')){
			$('#campos_proveedor').show();
		}else{
			$('#campos_proveedor').hide();
		}
	});
	//Campos adicionales de documentos///////
	if($("#id_config_camposadicionales").is(':checked')){
		$('#campos_adicionales_documento').show();
	}else{
		$('#campos_adicionales_documento').hide();
	}
	$("#id_config_camposadicionales").on('change',function(){
		if($("#id_config_camposadicionales").is(':checked')){
			$('#campos_adicionales_documento').show();
		}else{
			$('#campos_adicionales_documento').hide();
		}
	});
	//Control de producciones///////
	if($("#id_config_control_produccion").is(':checked')){
		$('#control_producciones').show();
	}else{
		$('#control_producciones').hide();
	}
	$("#id_config_control_produccion").on('change',function(){
		if($("#id_config_control_produccion").is(':checked')){
			$('#control_producciones').show();
		}else{
			$('#control_producciones').hide();
		}
	});
	//Tasa Pernoctacion///////
	if($("#id_config_tasapernoctacion").is(':checked')){
		$('.tasa-pernoctacion').removeClass('hide');
	}else{
		$('.tasa-pernoctacion').add('hide');
	}
	$("#id_config_tasapernoctacion").on('change',function(){
		if($("#id_config_tasapernoctacion").is(':checked')){
			$('.tasa-pernoctacion').removeClass('hide');
		}else{
			$('.tasa-pernoctacion').addClass('hide');
		}
	});
	//Porcentaje de Servicio///////
	if($("#id_config_porcentajeservicio").is(':checked')){
		$('.porcentaje-servicio').removeClass('hide');
	}else{
		$('.porcentaje-servicio').add('hide');
	}
	$("#id_config_porcentajeservicio").on('change',function(){
		if($("#id_config_porcentajeservicio").is(':checked')){
			$('.porcentaje-servicio').removeClass('hide');
		}else{
			$('.porcentaje-servicio').addClass('hide');
		}
	});

	//Nombre de marca///////
	if($("#id_config_marcas").is(':checked')){
		$('#nombre_marca').show();
	}else{
		$('#nombre_marca').hide();
	}
	$("#id_config_marcas").on('change',function(){
		if($("#id_config_marcas").is(':checked')){
			$('#nombre_marca').show();
		}else{
			$('#nombre_marca').hide();
		}
	});

	//Bandera de vender sin stock bodega///////
	if($("#id_config_facturarsinstock").is(':checked')){
		$("#id_config_facturarsinstockgeneral").prop('checked', false);
	}
	$("#id_config_facturarsinstock").on('change',function(){
		if($("#id_config_facturarsinstock").is(':checked')){
			$("#id_config_facturarsinstockgeneral").prop('checked', false);
		}
	});

	//Bandera de vender sin stock///////
	if($("#id_config_facturarsinstockgeneral").is(':checked')){
		$("#id_config_facturarsinstock").prop('checked', false);
	}
	$("#id_config_facturarsinstockgeneral").on('change',function(){
		if($("#id_config_facturarsinstockgeneral").is(':checked')){
			$("#id_config_facturarsinstock").prop('checked', false);
		}
	});

	new ObjectField($('#id_aprobador_1-aprobador_id'));
	new ObjectField($('#id_aprobador_2-aprobador_id'));
	new ObjectField($('#id_aprobador_3-aprobador_id'));
	new ObjectField($('#id_aprobador_4-aprobador_id'));
	new ObjectField($('#id_aprobador_5-aprobador_id'));
	new ObjectField($('#id_aprobador_6-aprobador_id'));
	new ObjectField($('#id_aprobador_7-aprobador_id'));
	new ObjectField($('#id_aprobador_8-aprobador_id'));
});

function eliminarConfig(link, nombre) {
	showConfirm('Eliminar dato', '¿Está seguro que desea eliminar el dato de la empresa: ' + nombre + '?', function() {
		document.location.href = link.href;
	});
	return false;
}

function eliminarAutorizacion(link, nombre) {
	showConfirm('Eliminar autorización', '¿Está seguro que desea eliminar la autorización: ' + nombre + '?', function() {
		document.location.href = link.href;
	});
	return false;
}

function agregarUsuario(link) {
	var data = {};
	$.ajax({
		type: "GET",
		url: urlprefix + "/empresa/puede_agregar_usuario/",
		data: data,
		dataType: "json",
		async: true,
		success: function(data, textStatus) {
			var respuesta = data['respuesta'];
			if (respuesta == true){
				document.location.href = link;
				return false;
			}else{
				showMessage('Agregar Usuario','Ha alcanzado el límite máximo de usuarios permitidos.');
			}
		}
	});
}

function eliminarUsuario(link, nombre) {
	showConfirm('Eliminar usuario', '¿Está seguro que desea eliminar el usuario: ' + nombre + '?', function() {
		document.location.href = link.href;
	});
	return false;
}

function generarBackup(link) {
	var url = '/sistema/empresa/configuracion/backup/';
	url = url + '?anio=' + $('#id_anio').val() + '&mes=' + $('#id_mes').val();
	link.href = url;
}

function mailActualizarEstado()
{
	$("#btn_probarCorreo").text("validando...");
	$("#btn_probarCorreo").removeClass("btn-primary");
	$("#btn_probarCorreo").addClass("btn-info");

	var data = {
		'servidor_smtp' : $("#id_servidor_smtp").val(),
		'puerto_smtp' : $("#id_puerto_smtp").val(),
		'usuario_mail' : $("#id_usuario_mail").val(),
		'password_mail' : $("#id_password_mail").val(),
		'tls_mail' : ($("#id_tls_mail").is(':checked'))?1:0
	}
	$.ajax({
			url: "/sistema/empresa/configuracion/correo/",
			type: "POST",
			async: true,
			data: data,
			error:function()
			{
				mailLimpiarClases("Configuración Erronea");
				$("#btn_probarCorreo").addClass("btn-danger");
			},
			success: function(data){
				mailLimpiarClases("Configuración Correcta");
				$("#btn_probarCorreo").addClass("btn-success");
			},
			complete: function(){}
		});
}

function mailLimpiarClases(texto)
{
	$("#btn_probarCorreo").removeClass("btn-danger");
	$("#btn_probarCorreo").removeClass("btn-success");
	$("#btn_probarCorreo").removeClass("btn-info");
	$("#btn_probarCorreo").text(texto);
}

function mostrarFormCambiar(){
	$('.tablaCambiarClave').show();
	$('.cambiarClave').hide();
	$('.check_firmado_auto').hide();
	$('#id_clave_firma_electronica').removeAttr('value');
	$('#id_clave_firma_electronica_confirm').removeAttr('value');
}
function ocultarFormCambiar(){
	$('.tablaCambiarClave').hide();
	$('.cambiarClave').show();
	$('.check_firmado_auto').show();
	$('#id_clave_firma_electronica').removeAttr('value');
	$('#id_clave_firma_electronica_confirm').removeAttr('value');
}
function cargar_claves(){
	if( $('#id_claves_contingencia').val() ) {
		$('#id_claves_contingencia').hide();
		$('#bar-claves').show();
	}
}
function mostrarModalFactElect(content){
	if(content=="mensaje"){
		$('.agregar_mensaje').show();
		$('.agregar_ptoemi').hide();
		titulo="Mensaje Personalizado en RIDE";
	}else{
		$('.agregar_mensaje').hide();
		$('.agregar_ptoemi').show();
		titulo="Establecimiento - Punto de Emisión por Defecto";
	}
	$('.titulo-factelect').text(titulo);
	$('#dlgFactElect').modal();
}
function AgregarMensaje(){
	titulo=$('#mensaje_titulo').val();
	contenido=$('#mensaje_contenido').val();
	$('.mensaje_indicator').show();
	var data={"titulo":titulo,"contenido":contenido};
	$.ajax({
		url: "/sistema/empresa/configuracion/mensaje_ride/",
		type: "POST",
		async: true,
		data: data,
		error:function()
		{$('.mensaje_indicator').hide();},
		success: function(data){
			result=data['result'];
			msg = data['msg'];
			if(result=='ok'){tipo='success';}else{tipo='danger';}
			div = '<div class="alert alert-dismissable alert-'+tipo+'">';
			div+= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
			div+= msg + '</div>';
			$('.modal-body.agregar_mensaje .alert').remove();
			$('.modal-body.agregar_mensaje').prepend(div);
			$('.mensaje_indicator').hide();
		},
		complete: function(){}
	});
}

function AgregarPtoEmi(){
	tipd=$('#id_tipd').val();
	esta=$('#id_esta').val();
	ptoe=$('#id_ptoe').val();
	$('.ptoemi_indicator').show();
	var data={"tipd":tipd,"esta":esta,"ptoe":ptoe};
	$.ajax({
		url: "/sistema/empresa/configuracion/est_ptoemi_default/",
		type: "POST",
		async: true,
		data: data,
		error:function()
		{$('.ptoemi_indicator').hide();},
		success: function(data){
			result=data['result'];
			msg = data['msg'];
			if(result=='ok'){tipo_msg='success';}else{tipo_msg='danger';}
			div = '<div class="alert alert-dismissable alert-'+tipo_msg+'">';
			div+= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
			div+= msg + '</div>';
			$('.modal-body.agregar_ptoemi .alert').remove();
			$('.modal-body.agregar_ptoemi').prepend(div);
			$('.ptoemi_indicator').hide();
			tr='<tr id="default_'+tipd+'">';
			tr+='<td><b>'+tipos_doc_default[tipd]+'</b></td><td>'+esta+'-'+ptoe+'</td>';
			tr+='<td><span class="btn btn-xs btn-danger" onclick="javascript:quitarDefault('+"'"+tipd+"'"+')">';
			tr+='<span class="ico-remove3"></span></span></td></tr>';
			$('#default_'+tipd).remove();
			$('.table-est-ptoemi').append(tr);
		},
		complete: function(){}
	});
}

function quitarDefault(tipo){
		showConfirm('Eliminar', '¿Está seguro que desea eliminar el valor por defecto?', function() {
			var data={"tipd":tipo};
		$.ajax({
			url: "/sistema/empresa/configuracion/est_ptoemi_default/eliminar/",
			type: "POST",
			async: true,
			data: data,
			error:function(){},
			success: function(data){
				result=data['result'];
				msg = data['msg'];
				if(result=='ok'){
					id='#default_'+tipo;
					$(id).remove();
				}
			},
			complete: function(){}
		});
		});
	return false;
}
</script>
<style>
.table-est-ptoemi{
	margin-left: 20px;
}
.table-est-ptoemi td{
	padding-right: 5px;
	padding-bottom: 3px;
}
</style>
<script type="text/javascript" src="function/shell.js"></script>
<script type="text/javascript" src="function/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="function/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="function/jquery.countdown.min.js"></script>
<style type="text/css">
	.ui-autocomplete-loading {
		background: white url('/sistema/shell/media/images/loading.gif') right center no-repeat;
	}

	.ui-autocomplete {
		position: absolute;
		z-index: 3000;
		top: 0;
		left: 0;
		cursor: default;
		background-color: #fff;
		padding:3px;
		border: 1px solid #ccc
	}

	.ui-autocomplete > li.ui-state-focus {
		background-color: #337ab7;
		color:#ffffff !important;
		border:0px;
	}

	li.ui-state-focus a{
		color:white;
	}
</style>
<script type="text/javascript">
var imagen_cargando = '<div style="width: 100%;" align="center"><img src="assets/images/loading.gif"/></div>';
</script>
<iframe src="javascript:false" title="" style="display: none;" src="cuentas_files/saved_resource.html"></iframe>
<style type="text/css">
.jqstooltip {
	position: absolute;left: 0px;top: 0px;visibility: hidden;
	background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
	color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;
	padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;
}
.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
</style>

