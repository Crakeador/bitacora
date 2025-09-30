<div class="row">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Talento Humano
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Talento Humano</a></li>
      <li><a href="index.php?view=rrp.lista">Registro de Personal</a></li>
      <li class="active">Datos del Colaborador</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab">Datos Generales</a></li>
            <li><a href="#settings" data-toggle="tab">R.R.H.H.</a></li>
            <li><a href="#timeline" data-toggle="tab">Eventos</a></li>
          </ul>
          <div class="tab-content">
            <!-- Datos Generales -->
            <div class="tab-pane active" id="activity">
                <!-- left column -->
                <div class="row">
                  <div class="col-md-7">
                      <div class="panel panel-default">
                          <!-- panel heading/header -->
                          <div class="panel-heading">
                              <h3 class="panel-title"><i class="mr5"></i>Informaci&oacute;n Personal</h3>
                          </div>
                          <!--/ panel heading/header -->
                          <div class="panel-collapse pull out">
                            <div class="panel-body">
                              <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Primer Nombre:</label>
                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_nombre" maxlength="25" name="nombre_uno" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Segundo Nombre:</label>
                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_segundo_nombre" maxlength="25" name="nombre_dos" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Primer Apellido:</label>
                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_primer_apellido" maxlength="25" name="apellido_uno" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Segundo Apellido:</label>
                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="id_segundo_apellido" maxlength="25" name="apellido_dos" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> G&eacute;nero:</label>
                                    <div class="col-sm-3">
                                        <select class="select-input form-control input-sm" id="id_genero" name="id_genero">
                                          <option value="A" selected="selected">Masculino</option>
                                          <option value="I">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> C&eacute;dula:</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" id="cedula" name="cedula" data-inputmask='"mask": "999999999-9"' data-mask placeholder="999999999-9"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Fecha de nacimiento:</label>
                                    <div class="col-sm-3"><input type="text" class="form-control pull-right" id="datepicker"></div>
                                </div>
                                <div class="form-group">
                              	  <div class="col-sm-offset-1 col-sm-10">
                                    <span class="text-danger">(1) Adjunto la copia a color de c&eacute;dula y certificado de votaci&oacute;n actualizado</span>
                                		<div class="radiobutton">
                                      <input type="radio" name="iCheck"> Si
                                      <input type="radio" name="iCheck" checked> No
                                		</div>
                              	  </div>
                              	</div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Lugar de nacimiento:</label>
                                    <div class="col-sm-6"><input class="text-field form-control input-sm" id="lugar_nacimiento" maxlength="25" name="lugar_nacimiento" type="text" placeholder="Guyaquil - Ecuador"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono convencial:</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono1" data-inputmask='"mask": "(99) 999-9999"' data-mask placeholder="(99) 999-9999"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><span class="text-danger">*</span> Tel&eacute;fono celular:</label>
                                    <div class="col-sm-3"><input type="text" class="form-control" id="telefono2" data-inputmask='"mask": "99-99999999"' data-mask placeholder="99-99999999"></div>
                                </div>
                                <div class="form-group">
                                	  <label class="col-sm-4 control-label"><span class="text-danger">*</span> Direcci&oacute;n de domicilio:</label>
                                	  <div class="col-sm-8">
                                		    <textarea class="form-control" id="inputExperience" placeholder="Dirrecci&oacute;n de su vivienda actual"></textarea>
                                	  </div>
                              	</div>
                                <div class="form-group">
                              	  <div class="col-sm-offset-1 col-sm-10">
                                    El tipo de vivienda es:
                                		<div class="radiobutton">
                                      <input type="radio" name="vivienda"> Propia
                                      <input type="radio" name="vivienda" checked> Alquilada
                                      <input type="radio" name="vivienda"> De un familiar
                                      <input type="radio" name="vivienda"> Otro
                                		</div>
                              	  </div>
                              	</div>
                              	<div class="form-group">
                                	  <label for="inputName" class="col-sm-2 control-label">Especifique:</label>
                                	  <div class="col-sm-10">
                                		    <input type="email" class="form-control" id="inputName" placeholder="Especifique que tipo de vivienda posee">
                                	  </div>
                                </div>
                                <div class="form-group">
                                	  <div class="col-sm-offset-1 col-sm-10">
                                      <span class="text-danger">OBSERVACIONES:</span>
                                	  </div>
                              	</div>
                                <div class="form-group">
                                	  <div class="col-sm-offset-1 col-sm-10">
                                      <span class="text-danger">(2) Adjunto el croquis y foto de la vivienda</span>
                                  		<div class="radiobutton">
                                        <input type="radio" id="croquis" name="croquis"> Si
                                        <input type="radio" id="croquis" name="croquis" checked> No
                                  		</div>
                                	  </div>
                              	</div>
                                <div class="form-group">
                                	  <div class="col-sm-offset-1 col-sm-10">
                                      <span class="text-danger">(3) Adjunto la planilla de servicios b&aacute;sicos de la vivienda</span>
                                  		<div class="radiobutton">
                                        <input type="radio" id="servicios" name="servicios"> Si
                                        <input type="radio" id="servicios" name="servicios" checked> No
                                  		</div>
                                	  </div>
                              	</div>
                                <div class="form-group">
                                	  <div class="col-sm-offset-1 col-sm-10">
                                      <span class="text-danger">(4) De ser una casa alquilada, adjunto el contrato de alquiler?</span>
                                  		<div class="radiobutton">
                                        <input type="radio" id="contrato" name="contrato"> Si
                                        <input type="radio" id="contrato" name="contrato"> No
                                        <input type="radio" id="contrato" name="contrato" checked> No Procede
                                  		</div>
                                	  </div>
                              	</div>
                              	<div class="form-group">
                              	  <div class="col-sm-offset-2 col-sm-10">
                                		<div class="checkbox">
                                			<input type="checkbox"> Esta activo el empleado</a>
                                		</div>
                              	  </div>
                              	</div>
                              	<div class="form-group">
                              	  <div class="col-sm-offset-2 col-sm-10">
                              		<button type="submit" class="btn btn-danger">Submit</button>
                              	  </div>
                              	</div>
                              </form>
                            </div>
                          </div>
                      </div>
                  </div>
                  <!-- Referencias Personales -->
                  <!-- Datos del Proveedor -->
                  <div class="col-md-5">
                      <div id="personalizados_proveedor">
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                  <h3 class="panel-title"><i class="mr5"></i>Datos del Proveedor</h3>
                              </div>
                              <div class="panel-collapse pull out">
                                  <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Campo 2:</label>
                                        <div class="col-sm-9"><input class="form-control input-sm" id="id_campo_2p" maxlength="100" name="campo_2p" type="text"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Campo 2:</label>
                                        <div class="col-sm-9"><input class="form-control input-sm" id="id_campo_2p" maxlength="100" name="campo_2p" type="text"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Campo 2:</label>
                                        <div class="col-sm-9"><input class="form-control input-sm" id="id_campo_2p" maxlength="100" name="campo_2p" type="text"></div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!--/ Form Datos del Proveedor -->
                  <!-- Datos Bancarios -->
                  <div class="col-md-5">
                      <div id="datos_bancarios" class="" style="display: block;">
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                  <h3 class="panel-title"><i class="mr5"></i>Datos Bancarios</h3>
                              </div>
                              <div class="panel-collapse pull out">
                                  <div class="panel-body">
                                      <div class="form-group">
                                          <label class="col-sm-4 control-label">Banco:</label>
                                          <div class="col-md-6 col-sm-6">
                                            <div class="select2-container form-control input-sm" id="s2id_id_banco_codigo">
                                              <a href="javascript:void(0)" class="select2-choice" tabindex="-1" style="margin: -6px -11px 0px;">
                                                <span class="select2-chosen" id="select2-chosen-1">BANCO DEL PICHINCHA</span>
                                              </a>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-4 control-label">N° Cuenta Bco.:</label>
                                          <div class="col-md-6 col-sm-6"><input class="form-control input-sm" id="id_num_tarjta" maxlength="40" name="num_tarjta" size="30" type="text" value="456456456"></div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-sm-4 control-label">Tipo Cuenta Bco.:</label>
                                          <div class="col-md-6 col-sm-6">
                                            <select class="form-control input-sm" id="id_tipo_cuenta" maxlength="2" name="tipo_cuenta">
                                              <option value=""> -- Seleccionar -- </option>
                                              <option value="CA" selected="selected">Cuenta de Ahorros</option>
                                              <option value="CC">Cuenta Corriente</option>
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!--/ Datos Bancarios -->
                </div>
            </div>
            <!-- Recursos Humanos -->
            <div class="tab-pane" id="settings">
              <div class="content_tabs">
                <div class="panel panel-default">
                    <!-- panel heading/header -->
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="mr5"></i>Datos para la Empresa</h4>
                        <!-- panel toolbar -->
                        <div class="panel-toolbar text-right">
                            <!-- option -->
                            <div class="option">
                                <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                            </div>
                            <!--/ option -->
                        </div>
                        <!--/ panel toolbar -->
                    </div>
                    <!--/ panel heading/header -->
                    <!-- panel body with collapse capable -->
                    <div class="panel-collapse pull out">
                        <div class="panel-body">
                            <div class="">
                                <div class="form-group"><!-- add class required -->
                                    <label class="col-md-2 col-sm-3 control-label">Departamento:</label> <!-- add classs control-label-->
                                    <div class="col-md-3 col-sm-4">
                                      <div class="input-group">
                                        <input class="object-description form-control input-sm ui-autocomplete-input" type="text" value="" placeholder="···" size="30" data_id="id_departamento" autocomplete="off">
                                        <span class="input-group-addon object-button btn btn-default input-sm" style="cursor:pointer;" type="button">
                                          <i class="glyphicon glyphicon-search"></i>
                                        </span>
                                      </div>
                                      <input autocompletar="True" class="object-hidden form-control" dlgtitle="Seleccionar departamento" dlgurl="/sistema/rrhh/departamento/seleccionar/" getobjectbydesc="Departamento.getByNombre" getobjectbyid="Departamento.getById" id="id_departamento" name="departamento" size="30" type="hidden" value="2120">
                                    </div>
                                    <label class="col-sm-2 control-label">Fecha de Nacimiento:</label>
                                    <div class="col-md-2 col-sm-. has_error"><input class="form-control input-sm hasDatepicker" id="id_fecha_nacimiento_rrhh" name="fecha_nacimiento_rrhh" type="text"><ul class="errorlist"><li>Fecha Requerida</li></ul></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 control-label">Cargo:</label>
                                    <div class="col-md-3 col-sm-4 has_error">
                                      <div class="input-group">
                                        <input class="object-description form-control input-sm ui-autocomplete-input" type="text" value="" placeholder="···" size="30" data_id="id_cargo" autocomplete="off">
                                        <span class="input-group-addon object-button btn btn-default input-sm" style="cursor:pointer;" type="button">
                                          <i class="glyphicon glyphicon-search"></i>
                                        </span>
                                      </div>
                                      <input autocompletar="True" class="object-hidden form-control" dlgtitle="Seleccionar Cargo" dlgurl="/sistema/rrhh/cargo/seleccionar/" getobjectbydesc="Cargo.getByNombre" getobjectbyid="Cargo.getById" id="id_cargo" name="cargo" size="30" type="hidden" value="5193">
                                      <ul class="errorlist"><li>Cargo Requerido</li></ul>
                                    </div>
                                    <label class="col-md-2 col-sm-2 control-label">Fechas Ingreso/Salida:</label>
                                    <div class="col-md-2 col-sm-2">
                                        <button id="btn_cargar_fechas_empresa" type="button" data-toggle="modal" data-target="#dlg_fechas_empresa" class="btn btn-sm btn-primary mb5" aria-label="">
                                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                            Agregar/Modificar
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-2 col-sm-3 control-label">Tipo Contrato:</label>
                                  <div class="col-md-3 col-sm-4">
                                    <select class="select-input form-control input-sm" id="id_tipo_contrato_rrhh" maxlength="10" name="tipo_contrato_rrhh">
                                      <option value="CA">Indefinido</option>
                                      <option value="CT">Temporal</option>
                                      <option value="SP">Servicios Prestados</option>
                                      <option value="OC">Obra Cierta</option>
                                      <option value="TP">Tarea Período</option>
                                    </select>
                                  </div>
                                  <label class="col-sm-2 control-label">Grupo Pago:</label>
                                  <div class="col-md-2 col-sm-3">
                                    <select class="select-input input-sm form-control" id="id_grupo_pago" maxlength="1" name="grupo_pago">
                                      <option value="A">Administrativo</option>
                                      <option value="V">Ventas</option>
                                      <option value="C">Costos</option>
                                      <option value="O">Otros</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 control-label">Tipo de Pago:</label>
                                    <div class="col-md-3 col-sm-4">
                                      <select class="select-input input-sm form-control" id="id_tipo_pago" maxlength="1" name="tipo_pago">
                                        <option value="B">Cheque</option>
                                        <option value="T">Transferencia</option>
                                      </select>
                                    </div>
                                    <label class="col-md-2 col-sm-3 control-label">Nota:</label>
                                    <div class="col-md-5 col-sm-5"><input class="text-field form-control" id="id_nota" maxlength="100" name="nota" size="40" type="text"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 control-label">Discapacidad:</label>
                                    <div class="col-md-3 col-sm-4">
                                        <span class="checkbox custom-checkbox custom-checkbox-primary">
                                            <input id="id_discapacidad" name="discapacidad" type="checkbox">
                                            <label for="id_discapacidad"></label>
                                        </span>
                                    </div>
                                    <div id="contenedor_discapacidad" style="display: none;">
                                        <label class="col-sm-2 control-label">Porcent. Discapacidad:</label>
                                        <div class="col-md-2 col-sm-.">
                                          <input class="form-control input-sm text-right" id="id_porcent_discapacidad" name="porcent_discapacidad" size="5" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cuenta_x_pagar_rrhh hide">
                                        <label class="col-sm-2 control-label">Cuenta por pagar:</label>
                                        <div class="col-sm-3 "><div class="input-group"><input class="object-description form-control input-sm ui-autocomplete-input" type="text" value="" placeholder="···" size="30" data_id="id_cuenta_por_pagar_rrhh" autocomplete="off"><span class="input-group-addon object-button btn btn-default input-sm" style="cursor:pointer;" type="button"><i class="glyphicon glyphicon-search"></i></span></div><input autocompletar="True" class="object-hidden form-control" dlgtitle="Seleccionar cuenta" dlgurl="/sistema/contabilidad/cuenta/seleccionar/?tipocuenta=Cuenta+por+Pagar" getobjectbydesc="Cuenta.getByCodigo" getobjectbyid="Cuenta.getById" id="id_cuenta_por_pagar_rrhh" name="cuenta_por_pagar_rrhh" size="30" type="hidden" validatedescobj="Cuenta.formatoCodigoValido"></div>
                                    </div>
                                </div>
                            <!-- pop up fechas Ingreso y Salida del empleado-->
                            <!-- START modal -->
                            <div id="dlg_fechas_empresa" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                     <div class="panel-default">
                                        <!-- panel heading/header -->
                                        <div class="panel-heading panel-heading-contifico">
                                            <h3 class="panel-title">Fechas de Ingreso y Salida Empresa</h3>
                                                <div class="panel-toolbar text-right">
                                                <!-- option -->
                                                <div class="option">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                </div>
                                                <!--/ option -->
                                            </div>
                                        </div>
                                        <!--/ panel heading/header -->
                                        <!-- panel body -->
                                        <div class="panel-body">
                                            <div id="msj_error_fechas_empresa" class="alert alert-danger hide">
                                                <p> La Fecha de Entrada no puede ser mayor a la fecha de Salida.</p>
                                            </div>
                                            <div id="msj_fecha_salida_primera_quincena" class="alert alert-info">
                                                <p> <b>Informativo:</b> Cuando se agrega una fecha de salida dentro de una primera quincena, el empleado aparecerá
                                                    en la segunda quincena con todos los valores a cancelar del mes.
                                                    Aplica para empleados con roles quincenales.
                                                </p>
                                            </div>
                                            <table id="table_detalle_entradasalida_empresa" class="table table-bordered table-hover table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"></th>
                                                        <th class="text-center">Entrada</th>
                                                        <th class="text-center">Salida</th>
                                                        <th colspan="2" class="text-center col-md-2">Acta de Finiquito</th>
                                                        <th class="text-center">Liquidación</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tdetalle_entradasalida_empresa">
                                                    <tr id="dtemplate_entradasalida_empresa" style="display:none;">
                                                        <td style="width:2%">
                                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" rel="tooltip" href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="fechas_entrada_salida_empresa.eliminarDetalle(this); return false;"><i class="ico-remove3"></i></a>
                                                        </td>
                                                        <td class="id_entradasalida_empresa" style="display: none;"></td>
                                                        <td style="width:10%">
                                                            <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaempresa_template-fecha_entrada" name="entradasalidaempresa_template-fecha_entrada" type="text">
                                                        </td>
                                                        <td style="width:10%">
                                                            <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaempresa_template-fecha_salida" name="entradasalidaempresa_template-fecha_salida" type="text">
                                                            <input id="id_entradasalidaempresa_template-tipo" maxlength="2" name="entradasalidaempresa_template-tipo" type="hidden">
                                                        </td>
                                                        <td style="width:20%; border-right:solid 1px #F5F5F5;">
                                                            <div class="fileinput-new input-group" data-provides="fileinput">
                                                                <div class="form-control input-sm" data-trigger="fileinput">
                                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename ancho_input_file" style="width"></span>
                                                                </div>
                                                                <span class="input-group-addon btn btn-default btn-file input-sm">
                                                                    <span class="glyphicon glyphicon-open"> </span>
                                                                    <input class="filestyle form-control input-sm" id="id_entradasalidaempresa_template-archivo_acta_finiquito" name="entradasalidaempresa_template-archivo_acta_finiquito" type="file">
                                                                </span>
                                                                <a href="https://grupogps.contifico.com/sistema/persona/1899012/#" class="input-group-addon btn btn-default fileinput-exists" style="color:black !important" data-dismiss="fileinput">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" style="width:2%; border-left:solid 1px #F5F5F5;"></td>
                                                        <td class="text-center" style="width:5%">
                                                                Pendiente
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6">
                                                            <button id="agregar_fechas_empresa" class="btn btn-primary btn-sm">
                                                            <span class="ico-plus-circle2"></span>
                                                            Agregar Fecha
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!--/ panel body -->
                                    </div>

                                    <div class="modal-footer">
                                          <button type="button" class="btn btn-success" data-dismiss="modal">
                                              <span class="glyphicon glyphicon-ok"> </span> Aceptar
                                          </button>
                                    </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <!--/ END modal -->
                            <div id="dlg_fechas_empresa_tmp" style="display:none"></div>
                            <!-- fin popup -->
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-collapse pull out">
                                <div class="panel-body">
                                    <fieldset class="opciones_iess">
                                        <h4>Datos del IESS</h4>
                                        <div class="form-group">
                                            <label class="col-md-4 col-sm-4 control-label">Fechas Ingreso/Salida:</label>
                                            <div class="col-md-2 col-sm-2">
                                                <button id="btn_cargar_fechas_iess" type="button" data-toggle="modal" data-target="#dlg_fechas_iess" class="btn btn-sm btn-primary mb5" aria-label="">
                                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                                Agregar/Modificar
                                            </button>
                                            </div>
                                            <label class="col-md-4 col-sm-4 control-label">Código IESS:</label>
                                            <div class="col-md-2 col-sm-2"><input class="form-control input-sm" id="id_codigo_iess" maxlength="200" name="codigo_iess" type="text"></div>
                                        </div>

                                        <!--IESS NUEVO-->
                                        <!-- pop up fechas Ingreso y Salida del empleado-->
                                        <!-- START modal -->
                                        <div id="dlg_fechas_iess" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                 <div class="panel-default">
                                                    <!-- panel heading/header -->
                                                    <div class="panel-heading panel-heading-contifico">
                                                        <h3 class="panel-title">Fechas de Ingreso y Salida IESS</h3>
                                                            <div class="panel-toolbar text-right">
                                                            <!-- option -->
                                                            <div class="option">
                                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                                            </div>
                                                            <!--/ option -->
                                                        </div>
                                                    </div>
                                                    <!--/ panel heading/header -->
                                                    <!-- panel body -->
                                                    <div class="panel-body">
                                                        <div id="msj_error_fechas_iess" class="alert alert-danger hide">
                                                        <p> La Fecha de Entrada no puede ser mayor a la fecha de Salida.</p>
                                                        </div>
                                                        <table id="table_detalle_entradasalida_iess" class="table table-bordered table-hover table-striped table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center">Entrada</th>
                                                                    <th class="text-center">Salida</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tdetalle_entradasalida_iess">
                                                                <tr id="dtemplate_entradasalida_iess" style="display:none;">
                                                                    <td style="width:2%">
                                                                        <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" rel="tooltip" href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="fechas_entrada_salida_iess.eliminarDetalle(this); return false;"><i class="ico-remove3"></i></a>
                                                                    </td>
                                                                    <td class="id_entradasalida_iess" style="display: none;"></td>

                                                                    <td style="width:10%">
                                                                        <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaiess_template-fecha_entrada" name="entradasalidaiess_template-fecha_entrada" type="text">

                                                                    </td>

                                                                    <td style="width:10%">
                                                                        <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaiess_template-fecha_salida" name="entradasalidaiess_template-fecha_salida" type="text">

                                                                        <input id="id_entradasalidaiess_template-tipo" maxlength="2" name="entradasalidaiess_template-tipo" type="hidden">

                                                                    </td>



                                                                </tr>

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <button id="agregar_fechas_iess" class="btn btn-primary btn-sm">
                                                                        <span class="ico-plus-circle2"></span>
                                                                        Agregar Fecha
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <!--/ panel body -->
                                                </div>

                                                <div class="modal-footer">
                                                      <button type="button" class="btn btn-success" data-dismiss="modal">
                                                          <span class="glyphicon glyphicon-ok"> </span> Aceptar
                                                      </button>
                                                </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <!--/ END modal -->
                                        <div id="dlg_fechas_iess_tmp" style="display:none"></div>
                                        <!-- fin popup -->
                                        <!--/ IESS NUEVO-->


                                    </fieldset>

                                    <fieldset class="opciones_iess">
                                        <h4>Registro de Vacaciones</h4>
                                        <div class="form-group">
                                            <label class="col-md-4 col-sm-4 control-label">Fechas Inicio/Fin:</label>
                                            <div class="col-md-2 col-sm-2">
                                                <button id="btn_cargar_fechas_vacaciones" type="button" data-toggle="modal" data-target="#dlg_fechas_vacaciones" class="btn btn-sm btn-primary mb5" aria-label="">
                                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                                    Agregar/Modificar
                                                </button>
                                            </div>
                                        </div>

                                        <div id="dlg_fechas_vacaciones" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="panel-default">
                                                        <!-- panel heading/header -->
                                                        <div class="panel-heading panel-heading-contifico">
                                                            <h3 class="panel-title">Fechas de Inicio y Fin Vacaciones</h3>
                                                                <div class="panel-toolbar text-right">
                                                                <!-- option -->
                                                                <div class="option">
                                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                                </div>
                                                                <!--/ option -->
                                                            </div>
                                                        </div>
                                                        <!--/ panel heading/header -->
                                                        <!-- panel body -->
                                                        <div class="panel-body">
                                                            <div id="msj_error_fechas_vacaciones" class="alert alert-danger hide">
                                                                <p> La Fecha de Inicio no puede ser mayor a la fecha de Fin.</p>
                                                            </div>
                                                            <table id="table_detalle_entradasalida_vacaciones" class="table table-bordered table-hover table-striped table-condensed">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center" style="width:1%"></th>
                                                                        <th class="text-center col-md-1">Inicio</th>
                                                                        <th class="text-center col-md-1">Fin</th>
                                                                        <th class="text-center col-md-2">Días Tomados</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tdetalle_entradasalida_vacaciones">
                                                                    <tr id="dtemplate_entradasalida_vacaciones" style="display:none;">
                                                                        <td>
                                                                            <a class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" rel="tooltip" href="javascript:void(0);" onclick="fechas_entrada_salida_vacaciones.eliminarDetalle(this); return false;"><i class="ico-remove3"></i></a>

                                                                        </td>
                                                                        <td class="id_entradasalida_vacaciones" style="display: none;">
                                                                        </td>

                                                                        <td style="width:10%">
                                                                                <input class="form-control input-sm datepicker hasDatepicker" id="id_vacacion_template-fecha_salida" name="vacacion_template-fecha_salida" type="text">

                                                                        </td>
                                                                        <td style="width:10%">
                                                                                <input class="form-control input-sm datepicker hasDatepicker" id="id_vacacion_template-fecha_entrada" name="vacacion_template-fecha_entrada" type="text">

                                                                        </td>

                                                                        <td>
                                                                            <input class="form-control input-sm text-right" id="id_vacacion_template-dias_tomados" name="vacacion_template-dias_tomados" size="5" type="text">

                                                                        </td>

                                                                    </tr>


                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <button id="agregar_fechas_vacaciones" class="btn btn-primary btn-sm">
                                                                            <span class="ico-plus-circle2"></span>
                                                                            Agregar Detalle
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        <!--/ panel body -->
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button id="btn_guardar_fechas_vacaciones" type="button" class="btn btn-success" data-dismiss="modal">
                                                              <span class="glyphicon glyphicon-ok"> </span> Aceptar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="dlg_fechas_vacaciones_tmp" style="display:none"></div>
                                        <!-- fin popup -->
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <!-- panel heading/header -->
                            <div class="panel-heading">
                                <h4 class="panel-title"><i class="mr5"></i>Datos Ministerio Laboral</h4>
                                <!-- panel toolbar -->
                                <div class="panel-toolbar text-right">
                                    <!-- option -->
                                    <div class="option">
                                        <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                                    </div>
                                    <!--/ option -->
                                </div>
                                <!--/ panel toolbar -->
                            </div>
                            <!--/ panel heading/header -->

                            <!-- panel body with collapse capable -->
                            <div class="panel-collapse pull out">
                                <div class="panel-body">
                                    <div class="">
                                        <fieldset class="opciones_ml">
                                            <div class="form-group">
                                                <label class="col-md-4 col-sm-4 control-label">Fechas Ingreso/Salida:</label>
                                                <div class="col-md-2 col-sm-2">
                                                    <button id="btn_cargar_fechas_ministeriolab" type="button" data-toggle="modal" data-target="#dlg_fechas_ministeriolab" class="btn btn-sm btn-primary mb5" aria-label="">
                                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>Agregar/Modificar
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="dlg_fechas_ministeriolab" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="panel-default">
                                                            <!-- panel heading/header -->
                                                            <div class="panel-heading panel-heading-contifico">
                                                                <h3 class="panel-title">Fechas de Ingreso y Salida Ministerio Laboral</h3>
                                                                    <div class="panel-toolbar text-right">
                                                                    <!-- option -->
                                                                    <div class="option">
                                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                                    </div>
                                                                    <!--/ option -->
                                                                </div>
                                                            </div>
                                                            <!--/ panel heading/header -->
                                                            <!-- panel body -->
                                                            <div class="panel-body">
                                                                <div id="msj_error_fechas_min" class="alert alert-danger hide">
                                                                    <p> La Fecha de Entrada no puede ser mayor a la fecha de Salida.</p>
                                                                </div>
                                                                <table id="table_detalle_entradasalida_ministeriolab" class="table table-bordered table-hover table-striped table-condensed">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center"></th>
                                                                            <th class="text-center">Entrada</th>
                                                                            <th class="text-center">Salida</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tdetalle_entradasalida_ministeriolab">
                                                                        <tr id="dtemplate_entradasalida_ministeriolab" style="display:none;">
                                                                            <td>
                                                                                <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" rel="tooltip" href="javascript:void(0);" onclick="fechas_entrada_salida_ministeriolab.eliminarDetalle(this); return false;"><span class="ico-remove3"></span>
                                                                                </a>
                                                                            </td>
                                                                            <td class="id_entradasalida_ministeriolab" style="display: none;">
                                                                            </td>

                                                                            <td>
                                                                                <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaministeriolab_template-fecha_entrada" name="entradasalidaministeriolab_template-fecha_entrada" type="text">

                                                                            </td>

                                                                            <td>
                                                                                <input class="form-control datepicker input-sm hasDatepicker" id="id_entradasalidaministeriolab_template-fecha_salida" name="entradasalidaministeriolab_template-fecha_salida" type="text">

                                                                                <input id="id_entradasalidaministeriolab_template-tipo" maxlength="2" name="entradasalidaministeriolab_template-tipo" type="hidden">

                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="6">
                                                                                <button id="agregar_fechas_ministeriolab" class="btn btn-primary btn-sm">
                                                                                <span class="ico-plus-circle2"></span>
                                                                                Agregar Fecha
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            <!--/ panel body -->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success" data-dismiss="modal">
                                                                  <span class="glyphicon glyphicon-ok"> </span> Aceptar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
                                            <div id="dlg_fechas_ministeriolab_tmp" style="display:none"></div>
                                            <!-- fin popup -->
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-right">Cargas personales:</label>
                                                <div class="col-md-2 text-right"><input class="form-control input-sm" id="id_cargas_personales" name="cargas_personales" type="text" value="0"></div>
                                            </div>
                                            </fieldset>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <!-- panel heading/header -->
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="mr5"></i>Configuraciones Generales</h4>
                        <!-- panel toolbar -->
                        <div class="panel-toolbar text-right">
                            <!-- option -->
                            <div class="option">
                                <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                            </div>
                            <!--/ option -->
                        </div>
                        <!--/ panel toolbar -->
                    </div>
                    <!--/ panel heading/header -->

                    <!-- panel body with collapse capable -->
                    <div class="panel-collapse pull out">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tipo de Rol:</label>
                                <div class="col-md-2">
                                  <select class="form-control input-sm" id="id_rrhh_tipo_rol" name="rrhh_tipo_rol">
                                    <option value="RPM">Mensual</option>
                                  </select>
                                </div>
                            </div>
                            <div class="tr_porcentaje_1quincena hide form-group">
                                <label class="col-md-3 col-sm-3 control-label">Porcentaje 1ra. Quincena (%):</label>
                                <div class="col-md-1 col-sm-2">
                                    <input class="form-control input-sm" id="id_porcentaje_quincena" name="porcentaje_quincena" size="3" style="text-align:right;" type="text">
                                </div>
                                <span id="rango1Q_label" class="col-md-3 label_porcent">Rango permitido ( 20% - 60% )</span>
                            </div>
                            <div class="tr_acumular_fondos form-group">
                                <label class="col-md-3 col-sm-4 control-label">Fondos de reserva:</label>
                                <div class="col-sm-8">
                                    <ul id="id_acumular_fondosreserva">
                                      <li><label for="id_acumular_fondosreserva_0"><input checked="checked" id="id_acumular_fondosreserva_0" name="acumular_fondosreserva" type="radio" value="0"> Pagar desde el Año</label></li>
                                      <li><label for="id_acumular_fondosreserva_1"><input id="id_acumular_fondosreserva_1" name="acumular_fondosreserva" type="radio" value="2"> Pagar desde el Ingreso</label></li>
                                      <li><label for="id_acumular_fondosreserva_2"><input id="id_acumular_fondosreserva_2" name="acumular_fondosreserva" type="radio" value="1"> Acumular</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 control-label">Acumular Décimo Tercera y Cuarta Remuneración: </label>
                                <div class="col-md-3 col-sm-4">
                                    <span class="checkbox custom-checkbox custom-checkbox-primary">
                                        <input id="id_acumular_decimos" name="acumular_decimos" type="checkbox">
                                        <label for="id_acumular_decimos"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 control-label">Extensión Conyugal: </label>
                                <div class="col-md-3 col-sm-4">
                                    <span class="checkbox custom-checkbox custom-checkbox-primary">
                                        <input id="id_extension_conyugal" name="extension_conyugal" type="checkbox">
                                        <label for="id_extension_conyugal"></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Archivos Relacionados -->
                <div class="panel panel-default">
                    <!-- panel heading/header -->
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="mr5"></i>Archivos Relacionados</h4>
                    </div>
                    <!--/ panel heading/header -->

                    <!-- panel body with collapse capable -->
                    <div class="panel-collapse pull out">
                        <div class="panel-body">
                            <fieldset class="subir_archivos">
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 text-right control-label">Contrato:</label>
                                    <div class="col-sm-8"><input id="id_archivo_contrato" name="archivo_contrato" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: pdf, doc, docx, odt</span></div>
                                    <div class="col-sm-1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 text-right control-label">CV:</label>
                                    <div class="col-sm-8"><input id="id_archivo_cv" name="archivo_cv" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: pdf, doc, docx, odt</span></div>
                                    <div class="col-md-1">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 text-right control-label">Cédula:</label>
                                    <div class="col-sm-8"><input id="id_archivo_cedula" name="archivo_cedula" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: pdf, png, jpg, doc, docx, odt</span></div>
                                    <div class="col-md-1">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 control-label">Record Policial:</label>
                                    <div class="col-sm-8"><input id="id_archivo_record" name="archivo_record" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: pdf, png, jpg, doc, docx, odt</span></div>
                                     <div class="col-md-1">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 control-label">Solicitud Acumulación Décimo Tercera y Cuarta Remuneración:</label>
                                    <div class="col-sm-8"><input id="id_archivo_acumulacion_decimos" name="archivo_acumulacion_decimos" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: pdf, doc, docx, odt, png, jpg</span></div>
                                     <div class="col-md-1">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-2 col-sm-4 control-label">Otros archivos:</label>
                                    <div class="col-sm-8"><input id="id_archivo_otros_zip" name="archivo_otros_zip" type="file" class="form-control input-sm"><span class="mini-tabla"> * Archivos permitidos: zip, tar, rar</span></div>
                                    <div class="col-md-1">

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <!-- div class="panel panel-default"-->
                <div class="panel-collapse pull out">
                    <div class="panel-body" style="padding-left: 0px; padding-right: 0px;">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="https://grupogps.contifico.com/sistema/persona/1899012/#ingresosproyectados" data-toggle="tab" aria-expanded="true"><b>Ingresos Proyectados</b></a>
                            </li>
                            <li>
                                <a href="https://grupogps.contifico.com/sistema/persona/1899012/#centroscostosproyectos" data-toggle="tab" aria-expanded="true"><b>Centros de Costos</b></a>
                            </li>
                            <li>
                                <a href="https://grupogps.contifico.com/sistema/persona/1899012/#tab_contratos" data-toggle="tab" aria-expanded="true"><b>Contratos</b></a>
                            </li>
                            <li>
                                <a href="https://grupogps.contifico.com/sistema/persona/1899012/#saldosiniciales" data-toggle="tab" aria-expanded="true"><b>Saldos Iniciales</b></a>
                            </li>
                        </ul>
                        <!--/ tab -->
                        <!-- tab content -->
                        <div class="tab-content panel">
                            <div class="tab-pane active" id="ingresosproyectados">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="https://grupogps.contifico.com/sistema/persona/1899012/#tab_detalles_rubros_fijos" data-toggle="tab" aria-expanded="true">Registro Detalles</a></li>
                                    <li class="">
                                        <a href="https://grupogps.contifico.com/sistema/persona/1899012/#tab_detalles_logs_rubros_fijos" data-toggle="tab" aria-expanded="true">Historicos</a>
                                    </li>
                                </ul>
                                <!--/ tab -->
                                <!-- tab content -->
                                <div class="tab-content panel">
                                    <div class="tab-pane active" id="tab_detalles_rubros_fijos">
                                        <!-- BLOQUE DE INGRESOS PROYECTADOS -->
                                        <div class="ingresos" style="">
                                            <div class="table-responsive" id="rubros_ingresos_fijos">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th width="40px;"></th>
                                                            <th class="id_ingreso hide"></th>
                                                            <th class="text-center">Tipo</th>
                                                            <th class="text-center lbl_periodo_ingresos_fijos">Valor Mensual</th>
                                                            <th class="text-center">Valor Diario</th>
                                                            <th class="text-center">Nombre</th>
                                                            <th class="text-center">Deducible</th>
                                                            <th class="text-center">Afecta Aportación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tdetalle_ingreso"><tr id="dtemplate_ingreso" style="display:none;">
                                                      <td>
                                                        <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" href="javascript:void(0);" onclick="ingresos.eliminarDetalle(this); return false;">
                                                          <span class="ico-remove3"></span>
                                                        </a>
                                                      </td>
                                                      <td class="id_ingreso" style="display: none;">
                                                      <input id="id_ingreso_template-id" name="ingreso_template-id" type="hidden">

                                                      </td>
                                                      <td>
                                                      <select class="form-control input-sm" id="id_ingreso_template-tipo" name="ingreso_template-tipo" onchange="autocompletar(this);" style="width:140px;">
                                                        <option value="S">SUELDO</option>
                                                        <option value="A">ALIMENTACION</option>
                                                        <option value="T">TRANSPORTE</option>
                                                        <option value="V">VIVIENDA</option>
                                                        <option value="C">COMISIONES</option>
                                                        <option value="H">HORAS EXTRA</option>
                                                        <option value="O">OTROS</option>
                                                      </select>

                                                      </td>
                                                      <td>
                                                      <input class="det_valor_mensual valor_rubro_ingr form-control input-sm text-right" id="id_ingreso_template-valor_mensual" name="ingreso_template-valor_mensual" onkeyup="calcularTotales_ingresos_deducibles_nodeducibles();" size="12" type="text" value="0.00">

                                                      </td>
                                                      <td>
                                                      <input class="form-control input-sm text-right" id="id_ingreso_template-valor_dia" name="ingreso_template-valor_dia" readonly="readonly" size="12" type="text" value="0.00">

                                                      </td>
                                                      <td>
                                                      <input class="form-control input-sm" id="id_ingreso_template-nombre" maxlength="20" name="ingreso_template-nombre" type="text" value="SUELDO">

                                                      </td>
                                                      <td>
                                                      <div class="checkbox custom-checkbox custom-checkbox-primary">
                                                      <input checked="checked" class="chkdeducible" id="id_ingreso_template-es_deducible" name="ingreso_template-es_deducible" type="checkbox">

                                                      <label for="id_ingreso_template-es_deducible"></label>
                                                      </div>
                                                      </td>
                                                      <td>
                                                      <div class="checkbox custom-checkbox custom-checkbox-primary">
                                                      <input checked="checked" class="" id="id_ingreso_template-para_rol" name="ingreso_template-para_rol" type="checkbox">

                                                      <label for="id_ingreso_template-para_rol"></label>
                                                      </div>
                                                      </td>
                                                      </tr>
                                                      </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="7">
                                                                <button id="btn_agregar_ingreso" class="btn btn-primary btn-sm">
                                                                    <span class="ico-plus-circle2"></span>
                                                                    Agregar Detalle
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label class="col-md-2 text-right">Ingresos deducibles:</label>
                                                <div class="col-md-2"><input id="total_ingresos_deducibles" class="form-control input-sm" type="text" readonly="readonly" value="0.00"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 text-right">Ingresos no deducibles:</label>
                                                <div class="col-md-2"><input id="total_ingresos_no_deducibles" class="form-control input-sm" type="text" readonly="readonly" value="0.00"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 text-right"> Total de Ingresos:</label>
                                                <div class="col-md-2"><input class="form-control input-sm" id="total_ingresos" type="text" readonly="readonly" value="0.00"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_detalles_logs_rubros_fijos" style="width: auto; height: 250px; overflow-y: scroll;">
                                        <!--Log de Registros  Historico Rubros Fijos FORM HIDE -->
                                        <table class="table table-bordered table-hover hide">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Fecha Creación</th>
                                                    <th class="text-center">Tipo</th>
                                                    <th class="text-center">Valor Mensual</th>
                                                    <th class="text-center">Valor Diario</th>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Deducible</th>
                                                    <th class="text-center">Afecta Aportación</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">

                                            </tbody>
                                        </table>
                                        <!-- / Log de Registros  Historico Rubros Fijos FORM HIDE -->

                                        <!-- Registros  Historico Rubros Fijos Consulta -->
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Fecha Creación</th>
                                                    <th class="text-center">Tipo</th>
                                                    <th class="text-center">Valor Mensual</th>
                                                    <th class="text-center">Nombre</th>
                                                    <th class="text-center">Deducible</th>
                                                    <th class="text-center">Afecta Aportación</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <!-- / Registros  Historico Rubros Fijos Consulta -->
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="centroscostosproyectos">
                                <!-- Centros Costos Proyectos Tab -->
                                  <div id="centroscostosproyectos" class="tab-pane content_tabs">
                                        <div class="table-responsive">
                                            <!-- BLOQUE DE CENTRO DE COSTOS -->
                                            <table id="table_detalle_centrocostos" class="table table-bordered table-hover table-striped" style="background-color: white">
                                                <thead>
                                                    <tr>
                                                        <th width="30px"></th>
                                                        <th class="text-center">Centro de Costo</th>
                                                        <th class="text-center col-md-5">Porcentaje de Trabajo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tdetalle_centroscostosproyectos">
                                                    <!-- tr oculto base para generar detalles de costos -->
                                                    <tr id="dtemplate_centroscostosproyectos" style="display:none;">
                                                        <td>
                                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-danger btn-xs" rel="tooltip" href="javasript:void(0);" onclick="centroscostosproyectos.eliminarDetalle(this, calcularPorcentajeTotalCentrosCosto); return false;"><i class="ico-remove3"></i></a>
                                                        </td>
                                                        <td>
                                                            <input autocompletar="True" class="object-hidden form-control" dlgtitle="Seleccionar centro de costo" dlgurl="/sistema/contabilidad/centro_costo/seleccionar/?solo_transaccionales=1" getobjectbyid="CentroCosto.getById" id="id_centrocostoproyecto_template-centro_costo" name="centrocostoproyecto_template-centro_costo" size="10" type="hidden">

                                                        </td>

                                                        <td>
                                                            <input class="form-control input-sm text-right centrocosto" id="id_centrocostoproyecto_template-porcentaje" name="centrocostoproyecto_template-porcentaje" onkeyup="calcularPorcentajeTotalCentrosCosto();" size="5" type="text" value="0">

                                                        </td>
                                                     <!--  -->

                                                    </tr>

                                                </tbody>
                                                <tfoot id="foot_total_porcentaje" style="display: none;">
                                                    <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td class="text-right total_porcentaje danger" style="border-top: 2px solid rgb(137, 137, 137);" id="porcentaje_total_cc">0%</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <br>
                                        <a class="btn btn-primary btn-sm" href="javascript:centroscostosproyectos.agregarDetalle();">
                                            <span class="ico-plus-circle2"></span>
                                            Agregar Detalle
                                        </a><br><br>
                                        <!--  -->
                                </div>
                                <!--/ Centros Costos Proyectos Tab -->
                            </div>

                             <!-- Contratos Tab -->
                            <div id="tab_contratos" class="tab-pane content_tabs">
                                <div class="table-responsive">
                                    <div id="msj_error_fechas_contratos" class="alert alert-danger hide">
                                        <p> La Fecha de Inicio no puede ser mayor a la fecha de Fin del Contrato.</p>
                                    </div>
                                    <table id="table_detalle_contratos" class="table table-bordered table-hover table-striped" style="background-color: white">
                                        <thead>
                                            <tr>
                                                <th width="30px"></th>
                                                <th class="text-center col-md-4">Fecha Inicio</th>
                                                <th class="text-center col-md-4">Fecha Fin</th>
                                                <th class="text-center col-md-4">Archivo Contrato</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tdetalle_contratos">
                                            <!-- tr oculto base para generar detalles de costos -->
                                            <tr id="dtemplate_contratos" style="display:none;">
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" class="btn btn-xs btn-danger" rel="tooltip" href="javasript:void(0);" onclick="contratos.eliminarDetalle(this); return false;"><span class="ico-remove3"></span></a>
                                                </td>
                                                <td>
                                                    <input class="form-control input-sm datepicker hasDatepicker" id="id_contrato_template-fecha_ini" name="contrato_template-fecha_ini" type="text">

                                                </td>

                                                <td>
                                                    <input class="form-control input-sm datepicker hasDatepicker" id="id_contrato_template-fecha_fin" name="contrato_template-fecha_fin" type="text">

                                                </td>

                                                <td>
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput">
                                                            <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename ancho_input_file"></span>
                                                        </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="glyphicon glyphicon-open"> </span>
                                                            <input class="filestyle form-control input-sm" id="id_contrato_template-archivo_contrato" name="contrato_template-archivo_contrato" type="file">
                                                        </span>
                                                        <a href="https://grupogps.contifico.com/sistema/persona/1899012/#" class="input-group-addon btn btn-default fileinput-exists" style="color:black !important" data-dismiss="fileinput">
                                                            <span class="glyphicon glyphicon-trash"> </span>
                                                        </a>
                                                    </div>

                                                </td>
                                             <!--  -->

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <a class="btn btn-primary btn-sm" id="agregar_detalle_contrato" href="javascript:void(0);">
                                    <span class="ico-plus-circle2"></span>
                                    Agregar Detalle
                                </a><br><br>
                                <!--  -->
                            </div>
                            <!-- Fin Contratos Tab -->
                            <div class="tab-pane" id="saldosiniciales">
                                <div class="table-responsive">
                                    <h5>Estos saldos no afectan contabilidad, sólo afecta el estado de cuenta del empleado.</h5>
                                        <table class="table table-bordered " style="background-color: white">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Rubro</th>
                                                    <th class="text-center col-md-5">Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                  <td colspan="2">
                                                      <b>Por Pagar</b>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_1-codigo" name="inicial_1-codigo" type="hidden" value="DTS">
                                                      <input class="form-control input-sm" id="id_inicial_1-rubro" name="inicial_1-rubro" size="60" type="text" value="Décimo Tercer Sueldo" readonly="">
                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_1-valor" name="inicial_1-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_2-codigo" name="inicial_2-codigo" type="hidden" value="DCS">
                                                      <input class="form-control input-sm" id="id_inicial_2-rubro" name="inicial_2-rubro" size="60" type="text" value="Décimo Cuarto Sueldo" readonly="">
                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_2-valor" name="inicial_2-valor" size="10" style="text-align:right;" type="text" value="0.0">
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_3-codigo" name="inicial_3-codigo" type="hidden" value="VAC">
                                                      <input class="form-control input-sm" id="id_inicial_3-rubro" name="inicial_3-rubro" size="60" type="text" value="Vacaciones" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_3-valor" name="inicial_3-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>



                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_4-codigo" name="inicial_4-codigo" type="hidden" value="OTR">
                                                      <input class="form-control input-sm" id="id_inicial_4-rubro" name="inicial_4-rubro" size="60" type="text" value="Otros" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_4-valor" name="inicial_4-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>



                                              <tr>
                                                  <td colspan="2">
                                                      <b>Por Cobrar</b>
                                                  </td>
                                              </tr>

                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_5-codigo" name="inicial_5-codigo" type="hidden" value="ANT">
                                                      <input class="form-control input-sm" id="id_inicial_5-rubro" name="inicial_5-rubro" size="60" type="text" value="Anticipos" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_5-valor" name="inicial_5-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>



                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_6-codigo" name="inicial_6-codigo" type="hidden" value="PPE">
                                                      <input class="form-control input-sm" id="id_inicial_6-rubro" name="inicial_6-rubro" size="60" type="text" value="Préstamos Personales" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_6-valor" name="inicial_6-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>



                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_7-codigo" name="inicial_7-codigo" type="hidden" value="PHI">
                                                      <input class="form-control input-sm" id="id_inicial_7-rubro" name="inicial_7-rubro" size="60" type="text" value="Préstamos Hipotecarios" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_7-valor" name="inicial_7-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>



                                              <tr>
                                                  <td>
                                                      <input id="id_inicial_8-codigo" name="inicial_8-codigo" type="hidden" value="PQU">
                                                      <input class="form-control input-sm" id="id_inicial_8-rubro" name="inicial_8-rubro" size="60" type="text" value="Préstamos Quirografarios" readonly="">

                                                  </td>
                                                  <td style="text-align: right;">
                                                      <input class="form-control input-sm" id="id_inicial_8-valor" name="inicial_8-valor" size="10" style="text-align:right;" type="text" value="0.0">

                                                  </td>
                                              </tr>

                                            </tbody>
                                        </table>
                                 </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!--/div-->
              </div>
            </div>
            <!-- Recursos Humanos -->
            <div class="tab-pane" id="timeline">
              <!-- The timeline -->
              <ul class="timeline timeline-inverse">
                <!-- timeline time label -->
                <li class="time-label">
                      <span class="bg-red">
                        10 Feb. 2014
                      </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-envelope bg-blue"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock"></i> 12:05</span>

                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                    <div class="timeline-body">
                      Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                      weebly ning heekya handango imeem plugg dopplr jibjab, movity
                      jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                      quora plaxo ideeli hulu weebly balihoo...
                    </div>
                    <div class="timeline-footer">
                      <a class="btn btn-primary btn-xs">Read more</a>
                      <a class="btn btn-danger btn-xs">Delete</a>
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-user bg-aqua"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock"></i> 5 mins ago</span>

                    <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                    </h3>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-comments bg-yellow"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock"></i> 27 mins ago</span>

                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                    <div class="timeline-body">
                      Take me to your leader!
                      Switzerland is small and neutral!
                      We are more like Germany, ambitious and misunderstood!
                    </div>
                    <div class="timeline-footer">
                      <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline time label -->
                <li class="time-label">
                      <span class="bg-green">
                        3 Jan. 2014
                      </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-camera bg-purple"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock"></i> 2 days ago</span>

                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                    <div class="timeline-body">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <li>
                  <i class="fa fa-clock bg-gray"></i>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  <script>
  	$(document).ready(function(){
  	  $('input').iCheck({
  	    checkboxClass: 'icheckbox_flat-red',
  	    radioClass: 'iradio_flat-red'
  	  });
  	});
  </script>
</div>
