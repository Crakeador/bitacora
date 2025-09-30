<!DOCTYPE html>
<html><!-- START Head -->
<head>
  <script type="text/javascript" src="function/vendor.js"></script>
  <script type="text/javascript" src="function/js.cookie.js"></script>
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
      var urlprefix = "/inventiolite";
      var valor_iva = "12.00";
      var label_iva = "12%";
  </script>
  <script type="text/javascript" src="function/jquery.contextMenu.js"></script>
  <script type="text/javascript" src="function/jquery.form.js"></script>
  <script type="text/javascript" src="function/jquery.cookie.js"></script>
  <script type="text/javascript" src="function/util.js"></script>
  <script type="text/javascript" src="function/objectfield.js"></script>
  <script type="text/javascript" src="function/masterdetail.js"></script>
  <script type="text/javascript" src="function/quicksearch.js"></script>
  <script type="text/javascript" src="function/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="function/jquery.jeditable.mini.js"></script>
  <script type="text/javascript" src="function/FixedHeader.js"></script>
  <script type="text/javascript" src="function/ZeroClipboard.js"></script>
  <script type="text/javascript" src="function/TableTools.js"></script>
  <script type="text/javascript" src="function/dataTablesExt.js"></script>
  <script type="text/javascript" src="function/dropdown.js"></script>
  <link href="function/jquery.contextMenu.min.css" media="all" rel="stylesheet" type="text/css">
  <meta http-equiv="X-UA-Compatible" content="IE=8">
  <script type="text/javascript" src="function/jquery.dropdown.js"></script>
  <script type="text/javascript" src="function/tipocuenta.js"></script>
  <script type="text/javascript" src="function/cuenta.js"></script>
  <script type="text/javascript" src="function/plancuentas.js"></script>
  <script type="text/javascript">
  	var tipoCuenta = null;
  	var mostrarSaldos = true;
  	$(function() {
  		tipoCuenta = new ObjectField({
  			'el': $('#tipo_cuenta_id'),
  			'getObjectById': TipoCuenta.getById,
  			'getObjectByDesc': TipoCuenta.getByCodigo,
  			'getObjDesc': TipoCuenta.getObjDesc,
  			'dlgTitle': 'Seleccionar tipo de cuenta',
  			'autocompletar': 'True',
  			'dlgUrl': "/sistema/contabilidad/cuenta/tipo/seleccionar/"
  		});

  		$('#btn-expandir').click(function(){
  			$('#btn-expandir').hide();
  			$('#btn-contraer').show();
  		});
  		$('#btn-contraer').click(function(){
  			$('#btn-contraer').hide();
  			$('#btn-expandir').show();
  		});

  	});
  </script>
  <script type="text/javascript" src="function/shell.js"></script>
  <script type="text/javascript" src="function/jquery.tablesorter.min.js"></script>
  <script type="text/javascript" src="function/jquery.tablesorter.widgets.min.js"></script>
  <script type="text/javascript" src="function/jquery.countdown.min.js"></script>
  <style type="text/css">
      .ui-autocomplete-loading {
          background: white url('assets/images/loading.gif') right center no-repeat;
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
    .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
  </style>
</head>
<body data-baseurl="/sistema/shell/media/adminre/">
  <section id="main" role="main">
      <div class="container-fluid">
          <div class="page-header page-header-block">
              <div class="page-header-section">
                  <h4 class="title semibold"> Plan de Cuentas </h4>
              </div>
              <div class="page-header-section">
                	<div class="toolbar">
                		<a href="https://grupogps.contifico.com/sistema/contabilidad/cuenta/?excel=1" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="Exportar Excel" rel="tooltip" class="btn btn-default btn-sm text-success"><i class="fa fa-file-excel-o"></i></a>
                		<a href="https://grupogps.contifico.com/sistema/contabilidad/cuenta/?pdf=1" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="Exportar PDF" rel="tooltip" class="btn btn-default btn-sm text-danger"><i class="fa fa-file-pdf-o"></i></a>
                	</div>
              </div>
          </div>
          <div class="row">
            <div id="popover_content_wrapper" class="hide">
            		<ul id="myMenu1" style="width:150px;">
            		    <li class="new" style="padding:3px;">
            		        <a href="#agregar-cuenta">Agregar Cuenta</a>
            		    </li>
            		    <li class="edit" style="padding:3px;">
            		        <a href="#modificar">Modificar</a>
            		    </li>
            		    <li class="delete" style="padding:3px;">
            		        <a href="#eliminar">Eliminar</a>
            		    </li>
            		    <li class="money separator" style="padding:3px;">
            		        <a href="#mayor">Ir a Mayor</a>
            		    </li>
            		    <li class="book" style="padding:3px;">
            		        <a href="#libro">Ir a Libro Diario</a>
            		    </li>
            		</ul>
            		<ul id="myMenu2" style="width:150px;">
            		    <li class="new">
            		        <a href="#agregar-cuenta">Agregar Cuenta</a>
            		    </li>
            		</ul>
            </div>
            <!-- Dialogo para crear un hijo en una cuenta o para modificar una cuenta -->
            <div id="dlgCuenta" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 id="titulo_ventana_cuenta" class="modal-title text-default"></h4>
                        </div>
                        <div class="modal-body">
                            <!-- contenido -->
                            <form id="formCuenta" name="formCuenta" action="https://grupogps.contifico.com/sistema/contabilidad/cuenta/" method="POST" onsubmit="return false;">
                    					<input type="hidden" id="padre_id" name="padre_id" value="">
                    					<input type="hidden" id="tipo" name="tipo" value="">
                    					<input type="hidden" id="id" name="id" value="">
                    					<label id="labelGrupo" for="grupo">Grupo:</label>
                    					<br>
                    					<label id="grupo" style="font-style:italic;font-weight:normal;"></label>
                    					<br>
                    					<label id="labelCuenta" for="cuenta">Cuenta:</label>
                    					<input type="text" name="nombre" id="nombre" value="" class="form-control">
                    					<br>
                    					<label id="labelCuenta" for="tipocuenta"><b>Tipo cuenta:</b></label>
                    					<div class="input-group">
                                <input class="object-description form-control input-sm ui-autocomplete-input" type="text" value="" placeholder="···" size="30" data_id="tipo_cuenta_id" autocomplete="off">
                                <span class="input-group-addon object-button btn btn-default input-sm" style="cursor:pointer;" type="button">
                                  <i class="glyphicon glyphicon-search"></i>
                                </span>
                              </div>
                              <input type="hidden" id="tipo_cuenta_id" name="tipo_cuenta_id" value="">
                    				</form>
                            <!--/ contenido -->
                          </div>
                          <div class="modal-footer">
                              <button type="button" id="btn_agregar_cuenta" class="btn btn-primary">Agregar</button>
                              <button type="button" id="btn_cancelar_cuenta" class="btn btn-danger">Cancelar</button>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- Tabla con el plan de cuentas -->
              <div id="loading" style="text-align:center;display:none;"><img src="assets/images/ajax-loader.gif"></div>
              <div class="col-md-12">
              	<div class="panel panel-primary">
              	    <div class="table-responsive panel-collapse">
                      <table class="table table-hover table-bordered">
                        <thead>
                          <tr>
                            <th width="10px">
                              <a id="btn-expandir" class="btn btn-default btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Expandir" href="javascript:PlanCuenta.expandir();" style="display: inline-block;" aria-describedby="tooltip149576">
                                <i class="fa fa-plus"></i>
                              </a>
                              <a id="btn-contraer" class="btn btn-default btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Contraer" href="javascript:PlanCuenta.contraer();" style="display: none;">
                                <i class="fa fa-minus"></i>
                              </a>
                            </th>
                            <th style="text-align:center;">Cuenta</th>
                            <th class="text-right;" width="160">Saldo</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr style="">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>
                              <td class="pad-cuenta" style="padding-left:0px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445760" padre="" class="cuenta" codigo="1" desc="1 Activos">1 Activos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $90,521.42</td>
                              <!---->
                            </tr>
                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>
                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445761" padre="1445760" class="cuenta" codigo="1.1" desc="1.1 Activo Corriente">1.1 Activo Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $89,965.06</td>
                              <!---->
                            </tr>
                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445762" padre="1445761" class="cuenta" codigo="1.1.1" desc="1.1.1 Efectivo y Equivalentes a Efectivo">1.1.1 Efectivo y Equivalentes a Efectivo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $666.27</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445763" padre="1445762" class="cuenta" codigo="1.1.1.1" desc="1.1.1.1 Caja">1.1.1.1 Caja</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445764" padre="1445762" class="cuenta" codigo="1.1.1.2" desc="1.1.1.2 Caja Chica">1.1.1.2 Caja Chica</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> -$3.50</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1457237" padre="1445764" class="cuenta" codigo="1.1.1.2.1" desc="1.1.1.2.1 caja chica">1.1.1.2.1 caja chica</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> -$3.50</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445765" padre="1445762" class="cuenta" codigo="1.1.1.3" desc="1.1.1.3 Bancos">1.1.1.3 Bancos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $669.77</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1457252" padre="1445765" class="cuenta" codigo="1.1.1.3.1" desc="1.1.1.3.1 Banco Pichincha  2100100342">1.1.1.3.1 Banco Pichincha  2100100342</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $669.77</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445766" padre="1445762" class="cuenta" codigo="1.1.1.4" desc="1.1.1.4 Banco dinero electrónico">1.1.1.4 Banco dinero electrónico</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445767" padre="1445761" class="cuenta" codigo="1.1.2" desc="1.1.2 Activos Financieros">1.1.2 Activos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $84,810.77</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445768" padre="1445767" class="cuenta" codigo="1.1.2.1" desc="1.1.2.1 Activos Financieros con cambios en resultados">1.1.2.1 Activos Financieros con cambios en resultados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445769" padre="1445767" class="cuenta" codigo="1.1.2.2" desc="1.1.2.2 Activos Financieros Disponibles para la Venta">1.1.2.2 Activos Financieros Disponibles para la Venta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445770" padre="1445767" class="cuenta" codigo="1.1.2.3" desc="1.1.2.3 Activos Financieros mantenidos hasta el vencimiento">1.1.2.3 Activos Financieros mantenidos hasta el vencimiento</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445771" padre="1445767" class="cuenta" codigo="1.1.2.4" desc="1.1.2.4 (-) Provisión por Deterioro">1.1.2.4 (-) Provisión por Deterioro</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445772" padre="1445767" class="cuenta" codigo="1.1.2.5" desc="1.1.2.5 Cuentas por Cobrar">1.1.2.5 Cuentas por Cobrar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $84,810.77</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445773" padre="1445772" class="cuenta" codigo="1.1.2.5.1" desc="1.1.2.5.1 Clientes Comerciales">1.1.2.5.1 Clientes Comerciales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $84,810.77</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445774" padre="1445772" class="cuenta" codigo="1.1.2.5.2" desc="1.1.2.5.2 Clientes Comerciales Exterior">1.1.2.5.2 Clientes Comerciales Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445775" padre="1445772" class="cuenta" codigo="1.1.2.5.3" desc="1.1.2.5.3 Socios o Accionistas">1.1.2.5.3 Socios o Accionistas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445776" padre="1445772" class="cuenta" codigo="1.1.2.5.4" desc="1.1.2.5.4 Funcionarios y/o Empleados">1.1.2.5.4 Funcionarios y/o Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445777" padre="1445772" class="cuenta" codigo="1.1.2.5.5" desc="1.1.2.5.5 Compañías Relacionadas">1.1.2.5.5 Compañías Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445778" padre="1445772" class="cuenta" codigo="1.1.2.5.6" desc="1.1.2.5.6 Cheques por Cobrar">1.1.2.5.6 Cheques por Cobrar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445779" padre="1445767" class="cuenta" codigo="1.1.2.6" desc="1.1.2.6 Documentos por Cobrar">1.1.2.6 Documentos por Cobrar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445780" padre="1445779" class="cuenta" codigo="1.1.2.6.1" desc="1.1.2.6.1 Clientes Comerciales">1.1.2.6.1 Clientes Comerciales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445781" padre="1445779" class="cuenta" codigo="1.1.2.6.2" desc="1.1.2.6.2 Socios o Accionistas">1.1.2.6.2 Socios o Accionistas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445782" padre="1445779" class="cuenta" codigo="1.1.2.6.3" desc="1.1.2.6.3 Funcionarios y/o Empleados">1.1.2.6.3 Funcionarios y/o Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445783" padre="1445779" class="cuenta" codigo="1.1.2.6.4" desc="1.1.2.6.4 Compañías Relacionadas">1.1.2.6.4 Compañías Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445784" padre="1445767" class="cuenta" codigo="1.1.2.7" desc="1.1.2.7 Otras Cuentas por Cobrar">1.1.2.7 Otras Cuentas por Cobrar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445785" padre="1445767" class="cuenta" codigo="1.1.2.8" desc="1.1.2.8 Provision para Cuentas Incobrables">1.1.2.8 Provision para Cuentas Incobrables</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445786" padre="1445761" class="cuenta" codigo="1.1.3" desc="1.1.3 Inventario">1.1.3 Inventario</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445787" padre="1445786" class="cuenta" codigo="1.1.3.1" desc="1.1.3.1 Materia Prima">1.1.3.1 Materia Prima</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445788" padre="1445786" class="cuenta" codigo="1.1.3.2" desc="1.1.3.2 Producto en Proceso">1.1.3.2 Producto en Proceso</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445789" padre="1445786" class="cuenta" codigo="1.1.3.3" desc="1.1.3.3 Suministros o materiales a ser consumidos en el proceso de producción ">1.1.3.3 Suministros o materiales a ser consumidos en el proceso de producción </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445790" padre="1445786" class="cuenta" codigo="1.1.3.4" desc="1.1.3.4 Suministros o materiales a ser consumidos en la prestación de servicios">1.1.3.4 Suministros o materiales a ser consumidos en la prestación de servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445791" padre="1445786" class="cuenta" codigo="1.1.3.5" desc="1.1.3.5 Productos terminados y mercadería producidos por la compañía">1.1.3.5 Productos terminados y mercadería producidos por la compañía</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445792" padre="1445786" class="cuenta" codigo="1.1.3.6" desc="1.1.3.6 Productos terminados y mercadería comprados a terceros">1.1.3.6 Productos terminados y mercadería comprados a terceros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445793" padre="1445786" class="cuenta" codigo="1.1.3.7" desc="1.1.3.7 Mercaderías en Transito">1.1.3.7 Mercaderías en Transito</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445794" padre="1445786" class="cuenta" codigo="1.1.3.8" desc="1.1.3.8 Obras en Construcción">1.1.3.8 Obras en Construcción</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445795" padre="1445786" class="cuenta" codigo="1.1.3.9" desc="1.1.3.9 Inventarios repuestos, herramientas y accesorios">1.1.3.9 Inventarios repuestos, herramientas y accesorios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445796" padre="1445786" class="cuenta" codigo="1.1.3.10" desc="1.1.3.10 Otros Inventarios">1.1.3.10 Otros Inventarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445797" padre="1445786" class="cuenta" codigo="1.1.3.11" desc="1.1.3.11 (-) Provisión de Inventarios por valor neto de realización">1.1.3.11 (-) Provisión de Inventarios por valor neto de realización</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445798" padre="1445786" class="cuenta" codigo="1.1.3.12" desc="1.1.3.12 (-) Provisión de Inventarios por deterioro">1.1.3.12 (-) Provisión de Inventarios por deterioro</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445799" padre="1445761" class="cuenta" codigo="1.1.4" desc="1.1.4 Servicios y otros Pagos Anticipados">1.1.4 Servicios y otros Pagos Anticipados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445800" padre="1445799" class="cuenta" codigo="1.1.4.1" desc="1.1.4.1 Seguros">1.1.4.1 Seguros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445801" padre="1445799" class="cuenta" codigo="1.1.4.2" desc="1.1.4.2 Arriendos">1.1.4.2 Arriendos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445802" padre="1445799" class="cuenta" codigo="1.1.4.3" desc="1.1.4.3 Anticipo a Proveedores">1.1.4.3 Anticipo a Proveedores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445803" padre="1445799" class="cuenta" codigo="1.1.4.4" desc="1.1.4.4 Otros Anticipos Entregados">1.1.4.4 Otros Anticipos Entregados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445804" padre="1445761" class="cuenta" codigo="1.1.5" desc="1.1.5 Activos por Impuestos Corrientes">1.1.5 Activos por Impuestos Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4,488.02</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445805" padre="1445804" class="cuenta" codigo="1.1.5.1" desc="1.1.5.1 IVA sobre Compras">1.1.5.1 IVA sobre Compras</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $427.03</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445806" padre="1445805" class="cuenta" codigo="1.1.5.1.1" desc="1.1.5.1.1 IVA sobre Compras">1.1.5.1.1 IVA sobre Compras</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $427.03</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445807" padre="1445804" class="cuenta" codigo="1.1.5.2" desc="1.1.5.2 Retenciones del IVA">1.1.5.2 Retenciones del IVA</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $3,277.31</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445808" padre="1445807" class="cuenta" codigo="1.1.5.2.1" desc="1.1.5.2.1 30% Bienes">1.1.5.2.1 30% Bienes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445809" padre="1445807" class="cuenta" codigo="1.1.5.2.2" desc="1.1.5.2.2 70% Servicios">1.1.5.2.2 70% Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $1,737.31</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445810" padre="1445807" class="cuenta" codigo="1.1.5.2.3" desc="1.1.5.2.3 100% Honorarios, Arrendamientos, Personas Naturales">1.1.5.2.3 100% Honorarios, Arrendamientos, Personas Naturales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $1,540.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445811" padre="1445807" class="cuenta" codigo="1.1.5.2.4" desc="1.1.5.2.4 100% Exportadores">1.1.5.2.4 100% Exportadores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445812" padre="1445807" class="cuenta" codigo="1.1.5.2.5" desc="1.1.5.2.5 10% Bienes (Contribuyentes Especiales)">1.1.5.2.5 10% Bienes (Contribuyentes Especiales)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445813" padre="1445807" class="cuenta" codigo="1.1.5.2.6" desc="1.1.5.2.6 20% Servicios (Contribuyentes Especiales)">1.1.5.2.6 20% Servicios (Contribuyentes Especiales)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445814" padre="1445807" class="cuenta" codigo="1.1.5.2.7" desc="1.1.5.2.7 50% Servicios (Exportadores de Recursos Naturales No Renovables)">1.1.5.2.7 50% Servicios (Exportadores de Recursos Naturales No Renovables)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445815" padre="1445804" class="cuenta" codigo="1.1.5.3" desc="1.1.5.3 Retenciones en la Fuente del Impuesto a la Renta">1.1.5.3 Retenciones en la Fuente del Impuesto a la Renta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $783.68</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445816" padre="1445815" class="cuenta" codigo="1.1.5.3.1" desc="1.1.5.3.1 1% Bienes Muebles de Naturaleza Corporal">1.1.5.3.1 1% Bienes Muebles de Naturaleza Corporal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445817" padre="1445815" class="cuenta" codigo="1.1.5.3.2" desc="1.1.5.3.2 2% Servicios">1.1.5.3.2 2% Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $783.68</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445818" padre="1445815" class="cuenta" codigo="1.1.5.3.3" desc="1.1.5.3.3 8% Honorarios, Arrendamientos, Docencia, Deportistas">1.1.5.3.3 8% Honorarios, Arrendamientos, Docencia, Deportistas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445819" padre="1445815" class="cuenta" codigo="1.1.5.3.4" desc="1.1.5.3.4 25% Extranjeros No Residentes">1.1.5.3.4 25% Extranjeros No Residentes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445820" padre="1445815" class="cuenta" codigo="1.1.5.3.5" desc="1.1.5.3.5 10% Honorarios Profesionales y Dietas">1.1.5.3.5 10% Honorarios Profesionales y Dietas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445821" padre="1445815" class="cuenta" codigo="1.1.5.3.6" desc="1.1.5.3.6 15% Loterías, Rifas y Similares">1.1.5.3.6 15% Loterías, Rifas y Similares</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445822" padre="1445815" class="cuenta" codigo="1.1.5.3.7" desc="1.1.5.3.7 Otras Retenciones Aplicables al Cód. 343">1.1.5.3.7 Otras Retenciones Aplicables al Cód. 343</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445823" padre="1445804" class="cuenta" codigo="1.1.5.4" desc="1.1.5.4 Anticipo de Impuesto a Renta">1.1.5.4 Anticipo de Impuesto a Renta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445824" padre="1445823" class="cuenta" codigo="1.1.5.4.1" desc="1.1.5.4.1 1era. Cuota Julio">1.1.5.4.1 1era. Cuota Julio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445825" padre="1445823" class="cuenta" codigo="1.1.5.4.2" desc="1.1.5.4.2 2da. Cuota Septiembre">1.1.5.4.2 2da. Cuota Septiembre</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445826" padre="1445761" class="cuenta" codigo="1.1.6" desc="1.1.6 Activos No Corrientes Mantenidos para la Venta y Op. desc.">1.1.6 Activos No Corrientes Mantenidos para la Venta y Op. desc.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445827" padre="1445761" class="cuenta" codigo="1.1.7" desc="1.1.7 Otros Activos Corrientes">1.1.7 Otros Activos Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445828" padre="1445760" class="cuenta" codigo="1.2" desc="1.2 Activos No Corrientes">1.2 Activos No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $556.36</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445829" padre="1445828" class="cuenta" codigo="1.2.1" desc="1.2.1 Propiedad, Planta y Equipos">1.2.1 Propiedad, Planta y Equipos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $556.36</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445830" padre="1445829" class="cuenta" codigo="1.2.1.1" desc="1.2.1.1 Terrenos">1.2.1.1 Terrenos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445831" padre="1445829" class="cuenta" codigo="1.2.1.2" desc="1.2.1.2 Edificios">1.2.1.2 Edificios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445832" padre="1445829" class="cuenta" codigo="1.2.1.3" desc="1.2.1.3 Construcciones en Curso ">1.2.1.3 Construcciones en Curso </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445833" padre="1445829" class="cuenta" codigo="1.2.1.4" desc="1.2.1.4 Instalaciones ">1.2.1.4 Instalaciones </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445834" padre="1445829" class="cuenta" codigo="1.2.1.5" desc="1.2.1.5 Muebles y Enseres">1.2.1.5 Muebles y Enseres</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445835" padre="1445829" class="cuenta" codigo="1.2.1.6" desc="1.2.1.6 Maquinarias y Equipos">1.2.1.6 Maquinarias y Equipos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445836" padre="1445829" class="cuenta" codigo="1.2.1.7" desc="1.2.1.7 Equipos de Computación">1.2.1.7 Equipos de Computación</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $556.36</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445837" padre="1445829" class="cuenta" codigo="1.2.1.8" desc="1.2.1.8 Vehículos, equipos de transporte y equipo caminero móvil">1.2.1.8 Vehículos, equipos de transporte y equipo caminero móvil</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445838" padre="1445829" class="cuenta" codigo="1.2.1.9" desc="1.2.1.9 Otras Propiedades, Planta y Equipo">1.2.1.9 Otras Propiedades, Planta y Equipo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445839" padre="1445829" class="cuenta" codigo="1.2.1.10" desc="1.2.1.10 Repuestos y Herramientas">1.2.1.10 Repuestos y Herramientas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445840" padre="1445829" class="cuenta" codigo="1.2.1.11" desc="1.2.1.11 (-) Depreciación Acumulada Propiedades, Planta y Equipo">1.2.1.11 (-) Depreciación Acumulada Propiedades, Planta y Equipo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445841" padre="1445829" class="cuenta" codigo="1.2.1.12" desc="1.2.1.12 (-) Deterioro Acumulado Propiedades, Planta y Equipo">1.2.1.12 (-) Deterioro Acumulado Propiedades, Planta y Equipo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445842" padre="1445829" class="cuenta" codigo="1.2.1.13" desc="1.2.1.13 Activos de Exploración y Explotación ">1.2.1.13 Activos de Exploración y Explotación </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445843" padre="1445829" class="cuenta" codigo="1.2.1.14" desc="1.2.1.14 Naves, Aeronaves, Barcazas y Similares">1.2.1.14 Naves, Aeronaves, Barcazas y Similares</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445844" padre="1445828" class="cuenta" codigo="1.2.2" desc="1.2.2 Propiedades de Inversion">1.2.2 Propiedades de Inversion</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445845" padre="1445844" class="cuenta" codigo="1.2.2.1" desc="1.2.2.1 Terrenos">1.2.2.1 Terrenos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445846" padre="1445844" class="cuenta" codigo="1.2.2.2" desc="1.2.2.2 Edificios">1.2.2.2 Edificios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445847" padre="1445844" class="cuenta" codigo="1.2.2.3" desc="1.2.2.3 (-) Depreciación Acumulada de Propiedades de Inversión">1.2.2.3 (-) Depreciación Acumulada de Propiedades de Inversión</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445848" padre="1445844" class="cuenta" codigo="1.2.2.4" desc="1.2.2.4 (-) Deterioro Acumulado de Propiedades de Inversión">1.2.2.4 (-) Deterioro Acumulado de Propiedades de Inversión</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445849" padre="1445828" class="cuenta" codigo="1.2.3" desc="1.2.3 Activos Biológicos">1.2.3 Activos Biológicos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445850" padre="1445849" class="cuenta" codigo="1.2.3.1" desc="1.2.3.1 Animales Vivos en Crecimiento">1.2.3.1 Animales Vivos en Crecimiento</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445851" padre="1445849" class="cuenta" codigo="1.2.3.2" desc="1.2.3.2 Animales Vivos en Producción">1.2.3.2 Animales Vivos en Producción</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445852" padre="1445849" class="cuenta" codigo="1.2.3.3" desc="1.2.3.3 (-) Depreciación Activos Biológicos">1.2.3.3 (-) Depreciación Activos Biológicos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445853" padre="1445849" class="cuenta" codigo="1.2.3.4" desc="1.2.3.4 (-) Deterioro Activos Biológicos">1.2.3.4 (-) Deterioro Activos Biológicos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445854" padre="1445828" class="cuenta" codigo="1.2.4" desc="1.2.4 Intangibles">1.2.4 Intangibles</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445855" padre="1445854" class="cuenta" codigo="1.2.4.1" desc="1.2.4.1 Plusvalías">1.2.4.1 Plusvalías</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445856" padre="1445854" class="cuenta" codigo="1.2.4.2" desc="1.2.4.2 Marcas, Patentes, Derechos de Llave, Cuotas Patrimoniales">1.2.4.2 Marcas, Patentes, Derechos de Llave, Cuotas Patrimoniales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445857" padre="1445854" class="cuenta" codigo="1.2.4.3" desc="1.2.4.3 Activos de Exploración y Explotación">1.2.4.3 Activos de Exploración y Explotación</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445858" padre="1445854" class="cuenta" codigo="1.2.4.4" desc="1.2.4.4 (-) Amortización Acumulada de Activos Intangibles">1.2.4.4 (-) Amortización Acumulada de Activos Intangibles</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445859" padre="1445854" class="cuenta" codigo="1.2.4.5" desc="1.2.4.5 (-) Deterioro Acumulado de Activos Intangibles">1.2.4.5 (-) Deterioro Acumulado de Activos Intangibles</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445860" padre="1445854" class="cuenta" codigo="1.2.4.6" desc="1.2.4.6 Otros Activos Intangibles">1.2.4.6 Otros Activos Intangibles</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445861" padre="1445828" class="cuenta" codigo="1.2.5" desc="1.2.5 Activos por Impuestos Diferidos">1.2.5 Activos por Impuestos Diferidos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445862" padre="1445828" class="cuenta" codigo="1.2.6" desc="1.2.6 Activos Financieros No Corrientes">1.2.6 Activos Financieros No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445863" padre="1445862" class="cuenta" codigo="1.2.6.1" desc="1.2.6.1 Activos Financieros mantenidos hasta el Vencimiento No Corrientes">1.2.6.1 Activos Financieros mantenidos hasta el Vencimiento No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445864" padre="1445862" class="cuenta" codigo="1.2.6.2" desc="1.2.6.2 (-) Deterioro de Activos Financieros hasta el Vencimiento No Corrientes">1.2.6.2 (-) Deterioro de Activos Financieros hasta el Vencimiento No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445865" padre="1445862" class="cuenta" codigo="1.2.6.3" desc="1.2.6.3 Documentos y Cuentas por Cobrar No Corrientes">1.2.6.3 Documentos y Cuentas por Cobrar No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445866" padre="1445862" class="cuenta" codigo="1.2.6.4" desc="1.2.6.4 (-) Cuentas Incobrables de Activos Financieros No Corrientes">1.2.6.4 (-) Cuentas Incobrables de Activos Financieros No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445867" padre="1445828" class="cuenta" codigo="1.2.7" desc="1.2.7 Otros Activos No Corrientes">1.2.7 Otros Activos No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:0px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445868" padre="" class="cuenta" codigo="2" desc="2 Pasivos">2 Pasivos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $15,819.31</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445869" padre="1445868" class="cuenta" codigo="2.1" desc="2.1 Pasivo Corriente">2.1 Pasivo Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $15,819.31</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445870" padre="1445869" class="cuenta" codigo="2.1.1" desc="2.1.1 Pasivos Financieros con Cambios en Resultados">2.1.1 Pasivos Financieros con Cambios en Resultados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445871" padre="1445869" class="cuenta" codigo="2.1.2" desc="2.1.2 Pasivos por Contratos de Arrendamientos Financieros">2.1.2 Pasivos por Contratos de Arrendamientos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445872" padre="1445869" class="cuenta" codigo="2.1.3" desc="2.1.3 Cuentas y Documentos por Pagar">2.1.3 Cuentas y Documentos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $5,447.03</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445873" padre="1445872" class="cuenta" codigo="2.1.3.1" desc="2.1.3.1 Cuentas por Pagar">2.1.3.1 Cuentas por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $5,447.03</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445874" padre="1445873" class="cuenta" codigo="2.1.3.1.1" desc="2.1.3.1.1 Proveedores">2.1.3.1.1 Proveedores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $5,447.03</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445875" padre="1445873" class="cuenta" codigo="2.1.3.1.2" desc="2.1.3.1.2 Proveedores Exterior">2.1.3.1.2 Proveedores Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445876" padre="1445872" class="cuenta" codigo="2.1.3.2" desc="2.1.3.2 Documentos por Pagar">2.1.3.2 Documentos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445877" padre="1445876" class="cuenta" codigo="2.1.3.2.1" desc="2.1.3.2.1 Documentos por Pagar Proveedores">2.1.3.2.1 Documentos por Pagar Proveedores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445878" padre="1445876" class="cuenta" codigo="2.1.3.2.2" desc="2.1.3.2.2 Documentos por Pagar Proveedores Exterior">2.1.3.2.2 Documentos por Pagar Proveedores Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445879" padre="1445869" class="cuenta" codigo="2.1.4" desc="2.1.4 Obligaciones Con Instituciones Financieras">2.1.4 Obligaciones Con Instituciones Financieras</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445880" padre="1445879" class="cuenta" codigo="2.1.4.1" desc="2.1.4.1 Obligaciones con Instituciones Financieras Locales">2.1.4.1 Obligaciones con Instituciones Financieras Locales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445881" padre="1445879" class="cuenta" codigo="2.1.4.2" desc="2.1.4.2 Obligaciones con Instituciones Financieras del Exterior">2.1.4.2 Obligaciones con Instituciones Financieras del Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445882" padre="1445869" class="cuenta" codigo="2.1.5" desc="2.1.5 Provisiones">2.1.5 Provisiones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445883" padre="1445882" class="cuenta" codigo="2.1.5.1" desc="2.1.5.1 Provisiones Locales">2.1.5.1 Provisiones Locales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445884" padre="1445882" class="cuenta" codigo="2.1.5.2" desc="2.1.5.2 Provisiones del Exterior">2.1.5.2 Provisiones del Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445885" padre="1445869" class="cuenta" codigo="2.1.6" desc="2.1.6 Porcion Corriente de Obligaciones Emitidas">2.1.6 Porcion Corriente de Obligaciones Emitidas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445886" padre="1445869" class="cuenta" codigo="2.1.7" desc="2.1.7 Otras Obligaciones Corrientes">2.1.7 Otras Obligaciones Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $10,372.28</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445887" padre="1445886" class="cuenta" codigo="2.1.7.1" desc="2.1.7.1 Retenciones del I.E.S.S.">2.1.7.1 Retenciones del I.E.S.S.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445888" padre="1445887" class="cuenta" codigo="2.1.7.1.1" desc="2.1.7.1.1 9.35% Aportes Individuales">2.1.7.1.1 9.35% Aportes Individuales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445889" padre="1445887" class="cuenta" codigo="2.1.7.1.2" desc="2.1.7.1.2 Prestamos Quirografarios">2.1.7.1.2 Prestamos Quirografarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445890" padre="1445887" class="cuenta" codigo="2.1.7.1.3" desc="2.1.7.1.3 Prestamos Hipotecarios">2.1.7.1.3 Prestamos Hipotecarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445891" padre="1445886" class="cuenta" codigo="2.1.7.2" desc="2.1.7.2 Retenciones en la Fuente de Impuestos a la Renta">2.1.7.2 Retenciones en la Fuente de Impuestos a la Renta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4.61</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445892" padre="1445891" class="cuenta" codigo="2.1.7.2.1" desc="2.1.7.2.1 1% Bienes Muebles de Naturaleza Corporal">2.1.7.2.1 1% Bienes Muebles de Naturaleza Corporal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445893" padre="1445891" class="cuenta" codigo="2.1.7.2.2" desc="2.1.7.2.2 2% Servicios">2.1.7.2.2 2% Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445894" padre="1445891" class="cuenta" codigo="2.1.7.2.3" desc="2.1.7.2.3 8% Honorarios, Arrendamientos, Docencia, Deportistas">2.1.7.2.3 8% Honorarios, Arrendamientos, Docencia, Deportistas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4.61</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445895" padre="1445891" class="cuenta" codigo="2.1.7.2.4" desc="2.1.7.2.4 25% Extranjeros No Residentes">2.1.7.2.4 25% Extranjeros No Residentes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445896" padre="1445891" class="cuenta" codigo="2.1.7.2.5" desc="2.1.7.2.5 10% Honorarios Profesionales y Dietas">2.1.7.2.5 10% Honorarios Profesionales y Dietas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445897" padre="1445891" class="cuenta" codigo="2.1.7.2.6" desc="2.1.7.2.6 15% Loterías, Rifas y Similares">2.1.7.2.6 15% Loterías, Rifas y Similares</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445898" padre="1445891" class="cuenta" codigo="2.1.7.2.7" desc="2.1.7.2.7 Otras Retenciones Aplicables al Cód. 343">2.1.7.2.7 Otras Retenciones Aplicables al Cód. 343</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445899" padre="1445886" class="cuenta" codigo="2.1.7.3" desc="2.1.7.3 Retenciones del Impuesto al Valor Agregado">2.1.7.3 Retenciones del Impuesto al Valor Agregado</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $6.91</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445900" padre="1445899" class="cuenta" codigo="2.1.7.3.1" desc="2.1.7.3.1 30% Bienes">2.1.7.3.1 30% Bienes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445901" padre="1445899" class="cuenta" codigo="2.1.7.3.2" desc="2.1.7.3.2 70% Servicios">2.1.7.3.2 70% Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445902" padre="1445899" class="cuenta" codigo="2.1.7.3.3" desc="2.1.7.3.3 100% Honorarios, Arrendamientos">2.1.7.3.3 100% Honorarios, Arrendamientos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $6.91</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445903" padre="1445899" class="cuenta" codigo="2.1.7.3.4" desc="2.1.7.3.4 100% Exportadores">2.1.7.3.4 100% Exportadores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445904" padre="1445899" class="cuenta" codigo="2.1.7.3.5" desc="2.1.7.3.5 10% Bienes (Contribuyentes Especiales)">2.1.7.3.5 10% Bienes (Contribuyentes Especiales)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445905" padre="1445899" class="cuenta" codigo="2.1.7.3.6" desc="2.1.7.3.6 20% Servicios (Contribuyentes Especiales)">2.1.7.3.6 20% Servicios (Contribuyentes Especiales)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445906" padre="1445899" class="cuenta" codigo="2.1.7.3.7" desc="2.1.7.3.7 50% Servicios (Exportadores de Recursos Naturales No Renovables)">2.1.7.3.7 50% Servicios (Exportadores de Recursos Naturales No Renovables)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445907" padre="1445886" class="cuenta" codigo="2.1.7.4" desc="2.1.7.4 IVA Sobre Ventas">2.1.7.4 IVA Sobre Ventas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $10,360.76</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445908" padre="1445907" class="cuenta" codigo="2.1.7.4.1" desc="2.1.7.4.1 IVA sobre Ventas">2.1.7.4.1 IVA sobre Ventas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $10,360.76</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445909" padre="1445886" class="cuenta" codigo="2.1.7.5" desc="2.1.7.5 Impuestos por Pagar">2.1.7.5 Impuestos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445910" padre="1445909" class="cuenta" codigo="2.1.7.5.1" desc="2.1.7.5.1 Impuesto a la Renta Cía.">2.1.7.5.1 Impuesto a la Renta Cía.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445911" padre="1445909" class="cuenta" codigo="2.1.7.5.2" desc="2.1.7.5.2 Impuesto a la Junta de Beneficiencia">2.1.7.5.2 Impuesto a la Junta de Beneficiencia</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445912" padre="1445909" class="cuenta" codigo="2.1.7.5.3" desc="2.1.7.5.3 Impuesto a los Activos Totales">2.1.7.5.3 Impuesto a los Activos Totales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445913" padre="1445909" class="cuenta" codigo="2.1.7.5.4" desc="2.1.7.5.4 Impuestos a la Universidad de Guayaquil">2.1.7.5.4 Impuestos a la Universidad de Guayaquil</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445914" padre="1445909" class="cuenta" codigo="2.1.7.5.5" desc="2.1.7.5.5 Impuestos Prediales">2.1.7.5.5 Impuestos Prediales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445915" padre="1445909" class="cuenta" codigo="2.1.7.5.6" desc="2.1.7.5.6 Impuesto a los Consumos Especiales">2.1.7.5.6 Impuesto a los Consumos Especiales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445916" padre="1445886" class="cuenta" codigo="2.1.7.6" desc="2.1.7.6 Beneficios Sociales por Pagar">2.1.7.6 Beneficios Sociales por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445917" padre="1445916" class="cuenta" codigo="2.1.7.6.1" desc="2.1.7.6.1 Décimo Tercer Sueldo">2.1.7.6.1 Décimo Tercer Sueldo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445918" padre="1445916" class="cuenta" codigo="2.1.7.6.2" desc="2.1.7.6.2 Décimo Cuarto Sueldo">2.1.7.6.2 Décimo Cuarto Sueldo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445919" padre="1445916" class="cuenta" codigo="2.1.7.6.3" desc="2.1.7.6.3 Vacaciones">2.1.7.6.3 Vacaciones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445920" padre="1445916" class="cuenta" codigo="2.1.7.6.4" desc="2.1.7.6.4 11.15% Aportes Patronales I.E.S.S.">2.1.7.6.4 11.15% Aportes Patronales I.E.S.S.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445921" padre="1445916" class="cuenta" codigo="2.1.7.6.5" desc="2.1.7.6.5 1% Secap - Iece">2.1.7.6.5 1% Secap - Iece</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445922" padre="1445916" class="cuenta" codigo="2.1.7.6.6" desc="2.1.7.6.6 Fondos de Reservas">2.1.7.6.6 Fondos de Reservas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445923" padre="1445916" class="cuenta" codigo="2.1.7.6.7" desc="2.1.7.6.7 Provisión de Jubilación Patronal">2.1.7.6.7 Provisión de Jubilación Patronal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445924" padre="1445916" class="cuenta" codigo="2.1.7.6.8" desc="2.1.7.6.8 Provisión por Desahucio">2.1.7.6.8 Provisión por Desahucio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445925" padre="1445886" class="cuenta" codigo="2.1.7.7" desc="2.1.7.7 Nominas">2.1.7.7 Nominas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445926" padre="1445925" class="cuenta" codigo="2.1.7.7.1" desc="2.1.7.7.1 Sueldos por Pagar">2.1.7.7.1 Sueldos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445927" padre="1445886" class="cuenta" codigo="2.1.7.8" desc="2.1.7.8 Participación de Trabajadores">2.1.7.8 Participación de Trabajadores</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445928" padre="1445927" class="cuenta" codigo="2.1.7.8.1" desc="2.1.7.8.1 10% Trabajadores en General">2.1.7.8.1 10% Trabajadores en General</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445929" padre="1445927" class="cuenta" codigo="2.1.7.8.2" desc="2.1.7.8.2 5% Cargas Familiares">2.1.7.8.2 5% Cargas Familiares</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445930" padre="1445886" class="cuenta" codigo="2.1.7.9" desc="2.1.7.9 Dividendos por Pagar a Socios">2.1.7.9 Dividendos por Pagar a Socios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445931" padre="1445869" class="cuenta" codigo="2.1.8" desc="2.1.8 Cuentas por Pagar Diversas/Relacionadas">2.1.8 Cuentas por Pagar Diversas/Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445932" padre="1445931" class="cuenta" codigo="2.1.8.1" desc="2.1.8.1 Cuenta por Pagar Socios o Accionistas">2.1.8.1 Cuenta por Pagar Socios o Accionistas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445933" padre="1445931" class="cuenta" codigo="2.1.8.2" desc="2.1.8.2 Cuenta por Pagar Funcionarios y/o Empleados">2.1.8.2 Cuenta por Pagar Funcionarios y/o Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445934" padre="1445931" class="cuenta" codigo="2.1.8.3" desc="2.1.8.3 Cuenta por Pagar Compañías Relacionadas">2.1.8.3 Cuenta por Pagar Compañías Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445935" padre="1445931" class="cuenta" codigo="2.1.8.4" desc="2.1.8.4 Cuenta por Pagar Compañías Relacionadas del Exterior">2.1.8.4 Cuenta por Pagar Compañías Relacionadas del Exterior</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445936" padre="1445931" class="cuenta" codigo="2.1.8.5" desc="2.1.8.5 Documentos por Pagar Funcionarios y/o Empleados">2.1.8.5 Documentos por Pagar Funcionarios y/o Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445937" padre="1445931" class="cuenta" codigo="2.1.8.6" desc="2.1.8.6 Documentos por Pagar Compañías Relacionadas">2.1.8.6 Documentos por Pagar Compañías Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445938" padre="1445931" class="cuenta" codigo="2.1.8.7" desc="2.1.8.7 Cuenta por Pagar Funcionarios y/o Empleados (10% Servicio)">2.1.8.7 Cuenta por Pagar Funcionarios y/o Empleados (10% Servicio)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445939" padre="1445869" class="cuenta" codigo="2.1.9" desc="2.1.9 Otros Pasivos Financieros">2.1.9 Otros Pasivos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445940" padre="1445869" class="cuenta" codigo="2.1.10" desc="2.1.10 Anticipos de Clientes">2.1.10 Anticipos de Clientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445941" padre="1445869" class="cuenta" codigo="2.1.11" desc="2.1.11 Pasivos directamente relacionados con los Activos No Corrientes">2.1.11 Pasivos directamente relacionados con los Activos No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445942" padre="1445869" class="cuenta" codigo="2.1.12" desc="2.1.12 Porción Corriente de Provisiones por Beneficios a Empleados">2.1.12 Porción Corriente de Provisiones por Beneficios a Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445943" padre="1445942" class="cuenta" codigo="2.1.12.1" desc="2.1.12.1 Jubilación Patronal">2.1.12.1 Jubilación Patronal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445944" padre="1445942" class="cuenta" codigo="2.1.12.2" desc="2.1.12.2 Otros Beneficios a largo Plazo para los Empleados">2.1.12.2 Otros Beneficios a largo Plazo para los Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445945" padre="1445869" class="cuenta" codigo="2.1.13" desc="2.1.13 Otros Pasivos Corrientes">2.1.13 Otros Pasivos Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445946" padre="1445869" class="cuenta" codigo="2.1.14" desc="2.1.14 Anticipo Gastos Administrativos">2.1.14 Anticipo Gastos Administrativos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445947" padre="1445868" class="cuenta" codigo="2.2" desc="2.2 Pasivo No Corriente">2.2 Pasivo No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445948" padre="1445947" class="cuenta" codigo="2.2.1" desc="2.2.1 Pasivos por Contratos de Arrendamiento Financiero">2.2.1 Pasivos por Contratos de Arrendamiento Financiero</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445949" padre="1445947" class="cuenta" codigo="2.2.2" desc="2.2.2 Cuentas y Documentos por Pagar">2.2.2 Cuentas y Documentos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445950" padre="1445949" class="cuenta" codigo="2.2.2.1" desc="2.2.2.1 Cuentas por Pagar">2.2.2.1 Cuentas por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445951" padre="1445950" class="cuenta" codigo="2.2.2.1.1" desc="2.2.2.1.1 Proveedores No Corriente">2.2.2.1.1 Proveedores No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445952" padre="1445950" class="cuenta" codigo="2.2.2.1.2" desc="2.2.2.1.2 Proveedores Exterior No Corriente">2.2.2.1.2 Proveedores Exterior No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445953" padre="1445949" class="cuenta" codigo="2.2.2.2" desc="2.2.2.2 Documentos por Pagar">2.2.2.2 Documentos por Pagar</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445954" padre="1445953" class="cuenta" codigo="2.2.2.2.1" desc="2.2.2.2.1 Documento por Pagar Proveedores No Corriente">2.2.2.2.1 Documento por Pagar Proveedores No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445955" padre="1445953" class="cuenta" codigo="2.2.2.2.2" desc="2.2.2.2.2 Documentos por Pagar Proveedores Exterior No Corriente">2.2.2.2.2 Documentos por Pagar Proveedores Exterior No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445956" padre="1445947" class="cuenta" codigo="2.2.3" desc="2.2.3 Obligaciones con Instituciones Financieras">2.2.3 Obligaciones con Instituciones Financieras</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445957" padre="1445956" class="cuenta" codigo="2.2.3.1" desc="2.2.3.1 Obligaciones con Instituciones Financieras Locales No Corrientes">2.2.3.1 Obligaciones con Instituciones Financieras Locales No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445958" padre="1445956" class="cuenta" codigo="2.2.3.2" desc="2.2.3.2 Obligaciones con Instituciones Financieras del Exterior No Corriente">2.2.3.2 Obligaciones con Instituciones Financieras del Exterior No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445959" padre="1445947" class="cuenta" codigo="2.2.4" desc="2.2.4 Cuenta por Pagar Diversas/Relacionadas">2.2.4 Cuenta por Pagar Diversas/Relacionadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445960" padre="1445959" class="cuenta" codigo="2.2.4.1" desc="2.2.4.1 Cuenta por Pagar Socios o Accionistas No Corrientes">2.2.4.1 Cuenta por Pagar Socios o Accionistas No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445961" padre="1445959" class="cuenta" codigo="2.2.4.2" desc="2.2.4.2 Cuenta por Pagar Funcionarios y/o Empleados No Corriente">2.2.4.2 Cuenta por Pagar Funcionarios y/o Empleados No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445962" padre="1445959" class="cuenta" codigo="2.2.4.3" desc="2.2.4.3 Cuenta por Pagar Compañias Relacionadas No Corriente">2.2.4.3 Cuenta por Pagar Compañias Relacionadas No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445963" padre="1445959" class="cuenta" codigo="2.2.4.4" desc="2.2.4.4 Cuenta por Pagar Compañías Relacionadas del Exterior No Corriente">2.2.4.4 Cuenta por Pagar Compañías Relacionadas del Exterior No Corriente</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445964" padre="1445947" class="cuenta" codigo="2.2.5" desc="2.2.5 Obligaciones Emitidas">2.2.5 Obligaciones Emitidas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445965" padre="1445947" class="cuenta" codigo="2.2.6" desc="2.2.6 Anticipos de Clientes">2.2.6 Anticipos de Clientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445966" padre="1445947" class="cuenta" codigo="2.2.7" desc="2.2.7 Provisiones por Beneficios a Empleados">2.2.7 Provisiones por Beneficios a Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445967" padre="1445966" class="cuenta" codigo="2.2.7.1" desc="2.2.7.1 Jubilación Patronal">2.2.7.1 Jubilación Patronal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445968" padre="1445966" class="cuenta" codigo="2.2.7.2" desc="2.2.7.2 Otros Beneficios No Corrientes Para los Empleados">2.2.7.2 Otros Beneficios No Corrientes Para los Empleados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445969" padre="1445947" class="cuenta" codigo="2.2.8" desc="2.2.8 Pasivo Diferido">2.2.8 Pasivo Diferido</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445970" padre="1445969" class="cuenta" codigo="2.2.8.1" desc="2.2.8.1 Ingresos Diferidos">2.2.8.1 Ingresos Diferidos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445971" padre="1445969" class="cuenta" codigo="2.2.8.2" desc="2.2.8.2 Pasivos por Impuestos Diferidos">2.2.8.2 Pasivos por Impuestos Diferidos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445972" padre="1445947" class="cuenta" codigo="2.2.9" desc="2.2.9 Otros Pasivos No Corrientes">2.2.9 Otros Pasivos No Corrientes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:0px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445973" padre="" class="cuenta" codigo="3" desc="3 Patrimonio">3 Patrimonio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $74,702.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445974" padre="1445973" class="cuenta" codigo="3.1" desc="3.1 Patrimonio Atribuible a Propietarios">3.1 Patrimonio Atribuible a Propietarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $74,702.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445975" padre="1445974" class="cuenta" codigo="3.1.1" desc="3.1.1 Capital Social">3.1.1 Capital Social</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445976" padre="1445975" class="cuenta" codigo="3.1.1.1" desc="3.1.1.1 Capital Social suscrito o pagado">3.1.1.1 Capital Social suscrito o pagado</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445977" padre="1445975" class="cuenta" codigo="3.1.1.2" desc="3.1.1.2 (-) Capital suscrito no pagado, acciones en tesorería">3.1.1.2 (-) Capital suscrito no pagado, acciones en tesorería</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445978" padre="1445974" class="cuenta" codigo="3.1.2" desc="3.1.2 Aportes de Socios o Accionistas para Futura Capitalización ">3.1.2 Aportes de Socios o Accionistas para Futura Capitalización </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445979" padre="1445974" class="cuenta" codigo="3.1.3" desc="3.1.3 Prima por Emisión Primaria de Acciones">3.1.3 Prima por Emisión Primaria de Acciones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445980" padre="1445974" class="cuenta" codigo="3.1.4" desc="3.1.4 Reservas">3.1.4 Reservas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445981" padre="1445980" class="cuenta" codigo="3.1.4.1" desc="3.1.4.1 Legal">3.1.4.1 Legal</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445982" padre="1445980" class="cuenta" codigo="3.1.4.2" desc="3.1.4.2 Facultativa y Estatutaria">3.1.4.2 Facultativa y Estatutaria</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445983" padre="1445980" class="cuenta" codigo="3.1.4.3" desc="3.1.4.3 Reserva de Capital">3.1.4.3 Reserva de Capital</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445984" padre="1445974" class="cuenta" codigo="3.1.5" desc="3.1.5 Otros Resultados Integrales">3.1.5 Otros Resultados Integrales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445985" padre="1445984" class="cuenta" codigo="3.1.5.1" desc="3.1.5.1 Superávit por Valuación de Activos Financieros">3.1.5.1 Superávit por Valuación de Activos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445986" padre="1445984" class="cuenta" codigo="3.1.5.2" desc="3.1.5.2 Superávit por Revaluación de Propiedad, Plantas y Equipos">3.1.5.2 Superávit por Revaluación de Propiedad, Plantas y Equipos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445987" padre="1445984" class="cuenta" codigo="3.1.5.3" desc="3.1.5.3 Superávit por Valuación de Activos Intagibles">3.1.5.3 Superávit por Valuación de Activos Intagibles</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445988" padre="1445984" class="cuenta" codigo="3.1.5.4" desc="3.1.5.4 Otros Superávit por Revaluación">3.1.5.4 Otros Superávit por Revaluación</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445989" padre="1445974" class="cuenta" codigo="3.1.6" desc="3.1.6 Resultados Acumulados">3.1.6 Resultados Acumulados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445990" padre="1445989" class="cuenta" codigo="3.1.6.1" desc="3.1.6.1 Resultados Acumulados">3.1.6.1 Resultados Acumulados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445991" padre="1445989" class="cuenta" codigo="3.1.6.2" desc="3.1.6.2 Resultados provenientes de la adopción por 1era vez del las NIIF">3.1.6.2 Resultados provenientes de la adopción por 1era vez del las NIIF</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445992" padre="1445974" class="cuenta" codigo="3.1.7" desc="3.1.7 Resultado del Ejercicio">3.1.7 Resultado del Ejercicio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $74,702.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445993" padre="1445992" class="cuenta" codigo="3.1.7.1" desc="3.1.7.1 Resultado del Ejercicio">3.1.7.1 Resultado del Ejercicio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $74,702.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445994" padre="1445973" class="cuenta" codigo="3.2" desc="3.2 Participación No Controladas">3.2 Participación No Controladas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445995" padre="1445994" class="cuenta" codigo="3.2.1" desc="3.2.1 Participación No Controladas">3.2.1 Participación No Controladas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:0px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445996" padre="" class="cuenta" codigo="4" desc="4 Ingresos">4 Ingresos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $79,207.22</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445997" padre="1445996" class="cuenta" codigo="4.1" desc="4.1 Ingresos de Actividades Ordinarias">4.1 Ingresos de Actividades Ordinarias</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $79,207.22</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445998" padre="1445997" class="cuenta" codigo="4.1.1" desc="4.1.1 Venta de Bienes">4.1.1 Venta de Bienes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1445999" padre="1445997" class="cuenta" codigo="4.1.2" desc="4.1.2 Prestación de Servicios">4.1.2 Prestación de Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $79,207.22</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446000" padre="1445997" class="cuenta" codigo="4.1.3" desc="4.1.3 Devoluciones sobre Ventas">4.1.3 Devoluciones sobre Ventas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446001" padre="1445997" class="cuenta" codigo="4.1.4" desc="4.1.4 Rebaja y/o Descuentos sobre Ventas">4.1.4 Rebaja y/o Descuentos sobre Ventas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446002" padre="1445997" class="cuenta" codigo="4.1.5" desc="4.1.5 Ingresos por Regalías Cuotas y Comisiones">4.1.5 Ingresos por Regalías Cuotas y Comisiones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446003" padre="1445997" class="cuenta" codigo="4.1.6" desc="4.1.6 Ingresos por Contratos de Intermediación">4.1.6 Ingresos por Contratos de Intermediación</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446004" padre="1445997" class="cuenta" codigo="4.1.7" desc="4.1.7 Ingresos por Primas y Prestaciones">4.1.7 Ingresos por Primas y Prestaciones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446005" padre="1445997" class="cuenta" codigo="4.1.8" desc="4.1.8 Contratos de Construcción">4.1.8 Contratos de Construcción</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446006" padre="1445997" class="cuenta" codigo="4.1.9" desc="4.1.9 Subvenciones del Gobierno">4.1.9 Subvenciones del Gobierno</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446007" padre="1445997" class="cuenta" codigo="4.1.10" desc="4.1.10 Ingresos por Dividendos">4.1.10 Ingresos por Dividendos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446008" padre="1445997" class="cuenta" codigo="4.1.11" desc="4.1.11 Otros Ingresos de Actividades Ordinarias">4.1.11 Otros Ingresos de Actividades Ordinarias</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446009" padre="1445996" class="cuenta" codigo="4.2" desc="4.2 Otros Ingresos de Actividades Ordinarias">4.2 Otros Ingresos de Actividades Ordinarias</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446010" padre="1446009" class="cuenta" codigo="4.2.1" desc="4.2.1 Fletes">4.2.1 Fletes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446011" padre="1446009" class="cuenta" codigo="4.2.2" desc="4.2.2 Multas">4.2.2 Multas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446012" padre="1446009" class="cuenta" codigo="4.2.3" desc="4.2.3 Intereses">4.2.3 Intereses</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446013" padre="1446009" class="cuenta" codigo="4.2.4" desc="4.2.4 Propinas (No Gravables)">4.2.4 Propinas (No Gravables)</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446014" padre="1445996" class="cuenta" codigo="4.3" desc="4.3 Otros Ingresos Financieros">4.3 Otros Ingresos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446015" padre="1446014" class="cuenta" codigo="4.3.1" desc="4.3.1 Dividendos Financieros">4.3.1 Dividendos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446016" padre="1446014" class="cuenta" codigo="4.3.2" desc="4.3.2 Intereses Financieros">4.3.2 Intereses Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446017" padre="1446014" class="cuenta" codigo="4.3.3" desc="4.3.3 Ganancia de Asociadas y Negocios Conjuntos">4.3.3 Ganancia de Asociadas y Negocios Conjuntos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446018" padre="1446014" class="cuenta" codigo="4.3.4" desc="4.3.4 Valuación de Instrumentos Financieros">4.3.4 Valuación de Instrumentos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446019" padre="1446014" class="cuenta" codigo="4.3.5" desc="4.3.5 Otras Rentas">4.3.5 Otras Rentas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446020" padre="1445996" class="cuenta" codigo="4.4" desc="4.4 Ingresos por Operaciones Discontinuadas">4.4 Ingresos por Operaciones Discontinuadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:0px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446021" padre="" class="cuenta" codigo="5" desc="5 Costos y Gastos">5 Costos y Gastos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4,505.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446022" padre="1446021" class="cuenta" codigo="5.1" desc="5.1 Costos de Venta y Producción ">5.1 Costos de Venta y Producción </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $22.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446023" padre="1446022" class="cuenta" codigo="5.1.1" desc="5.1.1 Materiales Utilizados o Productos Vendidos ">5.1.1 Materiales Utilizados o Productos Vendidos </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446024" padre="1446023" class="cuenta" codigo="5.1.1.1" desc="5.1.1.1 Bienes No Producidos">5.1.1.1 Bienes No Producidos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446025" padre="1446023" class="cuenta" codigo="5.1.1.2" desc="5.1.1.2 Bienes No Producidos Importados">5.1.1.2 Bienes No Producidos Importados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446026" padre="1446023" class="cuenta" codigo="5.1.1.3" desc="5.1.1.3 Materia Prima">5.1.1.3 Materia Prima</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446027" padre="1446023" class="cuenta" codigo="5.1.1.4" desc="5.1.1.4 Materia Prima Importada">5.1.1.4 Materia Prima Importada</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446028" padre="1446023" class="cuenta" codigo="5.1.1.5" desc="5.1.1.5 Productos en Proceso">5.1.1.5 Productos en Proceso</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446029" padre="1446023" class="cuenta" codigo="5.1.1.6" desc="5.1.1.6 Productos Terminados">5.1.1.6 Productos Terminados</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446030" padre="1446022" class="cuenta" codigo="5.1.2" desc="5.1.2 Mano de Obra Directa">5.1.2 Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446031" padre="1446030" class="cuenta" codigo="5.1.2.1" desc="5.1.2.1 Sueldos Mano de Obra Directa">5.1.2.1 Sueldos Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446032" padre="1446030" class="cuenta" codigo="5.1.2.2" desc="5.1.2.2 Sobretiempos Mano de Obra Directa">5.1.2.2 Sobretiempos Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446033" padre="1446030" class="cuenta" codigo="5.1.2.3" desc="5.1.2.3 Décimo Tercer Sueldo Mano de Obra Directa">5.1.2.3 Décimo Tercer Sueldo Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446034" padre="1446030" class="cuenta" codigo="5.1.2.4" desc="5.1.2.4 Decimo Cuarto Sueldo Mano de Obra Directa">5.1.2.4 Decimo Cuarto Sueldo Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446035" padre="1446030" class="cuenta" codigo="5.1.2.5" desc="5.1.2.5 Vacaciones Mano de Obra Directa">5.1.2.5 Vacaciones Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446036" padre="1446030" class="cuenta" codigo="5.1.2.6" desc="5.1.2.6 Aportes Patronales al I.E.S.S. Mano de Obra Directa">5.1.2.6 Aportes Patronales al I.E.S.S. Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446037" padre="1446030" class="cuenta" codigo="5.1.2.7" desc="5.1.2.7 Secap - Iece Mano de Obra Directa">5.1.2.7 Secap - Iece Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446038" padre="1446030" class="cuenta" codigo="5.1.2.8" desc="5.1.2.8 Fondos de Reserva Mano de Obra Directa">5.1.2.8 Fondos de Reserva Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446039" padre="1446030" class="cuenta" codigo="5.1.2.9" desc="5.1.2.9 Gastos Planes de Beneficios a Empleados Mano de Obra Directa">5.1.2.9 Gastos Planes de Beneficios a Empleados Mano de Obra Directa</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446040" padre="1446022" class="cuenta" codigo="5.1.3" desc="5.1.3 Mano de Obra Indirecta">5.1.3 Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446041" padre="1446040" class="cuenta" codigo="5.1.3.1" desc="5.1.3.1 Sueldos Mano de Obra Indirecta">5.1.3.1 Sueldos Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446042" padre="1446040" class="cuenta" codigo="5.1.3.2" desc="5.1.3.2 Sobretiempos Mano de Obra Indirecta">5.1.3.2 Sobretiempos Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446043" padre="1446040" class="cuenta" codigo="5.1.3.3" desc="5.1.3.3 Décimo Tercer Sueldo Mano de Obra Indirecta">5.1.3.3 Décimo Tercer Sueldo Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446044" padre="1446040" class="cuenta" codigo="5.1.3.4" desc="5.1.3.4 Décimo Cuarto Sueldo Mano de Obra Indirecta">5.1.3.4 Décimo Cuarto Sueldo Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446045" padre="1446040" class="cuenta" codigo="5.1.3.5" desc="5.1.3.5 Vacaciones Mano de Obra Indirecta">5.1.3.5 Vacaciones Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446046" padre="1446040" class="cuenta" codigo="5.1.3.6" desc="5.1.3.6 Aportes Patronales al I.E.S.S. Mano de Obra Indirecta">5.1.3.6 Aportes Patronales al I.E.S.S. Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446047" padre="1446040" class="cuenta" codigo="5.1.3.7" desc="5.1.3.7 Secap - Iece Mano de Obra Indirecta">5.1.3.7 Secap - Iece Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446048" padre="1446040" class="cuenta" codigo="5.1.3.8" desc="5.1.3.8 Fondos de Reserva Mano de Obra Indirecta">5.1.3.8 Fondos de Reserva Mano de Obra Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446049" padre="1446040" class="cuenta" codigo="5.1.3.9" desc="5.1.3.9 Gastos Planes de Beneficios a Empleados - Indirecta">5.1.3.9 Gastos Planes de Beneficios a Empleados - Indirecta</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446050" padre="1446022" class="cuenta" codigo="5.1.4" desc="5.1.4 Costos Indirectos de Fabricación">5.1.4 Costos Indirectos de Fabricación</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $22.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446051" padre="1446050" class="cuenta" codigo="5.1.4.1" desc="5.1.4.1 Depreciación Propiedades, Plantas y Equipos">5.1.4.1 Depreciación Propiedades, Plantas y Equipos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446052" padre="1446050" class="cuenta" codigo="5.1.4.2" desc="5.1.4.2 Depreciación de Activos Biológicos">5.1.4.2 Depreciación de Activos Biológicos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446053" padre="1446050" class="cuenta" codigo="5.1.4.3" desc="5.1.4.3 Deterioro de Propiedad, Planta y Equipo">5.1.4.3 Deterioro de Propiedad, Planta y Equipo</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446054" padre="1446050" class="cuenta" codigo="5.1.4.4" desc="5.1.4.4 Efecto valor neto de realización de Inventarios">5.1.4.4 Efecto valor neto de realización de Inventarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446055" padre="1446050" class="cuenta" codigo="5.1.4.5" desc="5.1.4.5 Gasto por Garantías en Venta de Productos o Servicios">5.1.4.5 Gasto por Garantías en Venta de Productos o Servicios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446056" padre="1446050" class="cuenta" codigo="5.1.4.6" desc="5.1.4.6 Mantenimiento y Reparaciones Costos">5.1.4.6 Mantenimiento y Reparaciones Costos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446057" padre="1446050" class="cuenta" codigo="5.1.4.7" desc="5.1.4.7 Suministros, Materiales y Repuestos Costos">5.1.4.7 Suministros, Materiales y Repuestos Costos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $22.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446058" padre="1446050" class="cuenta" codigo="5.1.4.8" desc="5.1.4.8 Otros Costos de Producción">5.1.4.8 Otros Costos de Producción</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:35px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446059" padre="1446021" class="cuenta" codigo="5.2" desc="5.2 Gastos">5.2 Gastos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4,483.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446060" padre="1446059" class="cuenta" codigo="5.2.1" desc="5.2.1 Gastos de Actividades Ordinarias">5.2.1 Gastos de Actividades Ordinarias</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4,483.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446061" padre="1446060" class="cuenta" codigo="5.2.1.1" desc="5.2.1.1 Ventas">5.2.1.1 Ventas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446062" padre="1446061" class="cuenta" codigo="5.2.1.1.1" desc="5.2.1.1.1 Sueldos Unificados Vtas.">5.2.1.1.1 Sueldos Unificados Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446063" padre="1446061" class="cuenta" codigo="5.2.1.1.2" desc="5.2.1.1.2 Sobretiempos Vtas.">5.2.1.1.2 Sobretiempos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446064" padre="1446061" class="cuenta" codigo="5.2.1.1.3" desc="5.2.1.1.3 Gratificaciones Vtas. ">5.2.1.1.3 Gratificaciones Vtas. </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446065" padre="1446061" class="cuenta" codigo="5.2.1.1.4" desc="5.2.1.1.4 Alimentación Vtas.">5.2.1.1.4 Alimentación Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446066" padre="1446061" class="cuenta" codigo="5.2.1.1.5" desc="5.2.1.1.5 Aportes Patronales al IESS Vtas.">5.2.1.1.5 Aportes Patronales al IESS Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446067" padre="1446061" class="cuenta" codigo="5.2.1.1.6" desc="5.2.1.1.6 Secap - Iece Vtas.">5.2.1.1.6 Secap - Iece Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446068" padre="1446061" class="cuenta" codigo="5.2.1.1.7" desc="5.2.1.1.7 Fondos de Reserva Vtas.">5.2.1.1.7 Fondos de Reserva Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446069" padre="1446061" class="cuenta" codigo="5.2.1.1.8" desc="5.2.1.1.8 Décimo Tercer Sueldo Vtas.">5.2.1.1.8 Décimo Tercer Sueldo Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446070" padre="1446061" class="cuenta" codigo="5.2.1.1.9" desc="5.2.1.1.9 Décimo Cuarto Sueldo Vtas.">5.2.1.1.9 Décimo Cuarto Sueldo Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446071" padre="1446061" class="cuenta" codigo="5.2.1.1.10" desc="5.2.1.1.10 Vacaciones Vtas.">5.2.1.1.10 Vacaciones Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446072" padre="1446061" class="cuenta" codigo="5.2.1.1.11" desc="5.2.1.1.11 Desahucio Vtas.">5.2.1.1.11 Desahucio Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446073" padre="1446061" class="cuenta" codigo="5.2.1.1.12" desc="5.2.1.1.12 Gastos Planes de Beneficios a Empleados Vtas">5.2.1.1.12 Gastos Planes de Beneficios a Empleados Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446074" padre="1446061" class="cuenta" codigo="5.2.1.1.13" desc="5.2.1.1.13 Honorarios Profesionales Vtas.">5.2.1.1.13 Honorarios Profesionales Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446075" padre="1446061" class="cuenta" codigo="5.2.1.1.14" desc="5.2.1.1.14 Servicios Contratados Vtas.">5.2.1.1.14 Servicios Contratados Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446076" padre="1446061" class="cuenta" codigo="5.2.1.1.15" desc="5.2.1.1.15 Gastos Remuneraciones a otros trabajadores autónomos Vtas">5.2.1.1.15 Gastos Remuneraciones a otros trabajadores autónomos Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446077" padre="1446061" class="cuenta" codigo="5.2.1.1.16" desc="5.2.1.1.16 Gastos Honorarios a extranjeros por Servicios Ocasionales Vtas">5.2.1.1.16 Gastos Honorarios a extranjeros por Servicios Ocasionales Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446078" padre="1446061" class="cuenta" codigo="5.2.1.1.17" desc="5.2.1.1.17 Mantenimiento de Equipos Vtas.">5.2.1.1.17 Mantenimiento de Equipos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446079" padre="1446061" class="cuenta" codigo="5.2.1.1.18" desc="5.2.1.1.18 Reparaciones de Equipos Vtas.">5.2.1.1.18 Reparaciones de Equipos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446080" padre="1446061" class="cuenta" codigo="5.2.1.1.19" desc="5.2.1.1.19 Arriendos Vtas">5.2.1.1.19 Arriendos Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446081" padre="1446061" class="cuenta" codigo="5.2.1.1.20" desc="5.2.1.1.20 Comisiones Vtas">5.2.1.1.20 Comisiones Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446082" padre="1446061" class="cuenta" codigo="5.2.1.1.21" desc="5.2.1.1.21 Publicidad y Promoción Vtas.">5.2.1.1.21 Publicidad y Promoción Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446083" padre="1446061" class="cuenta" codigo="5.2.1.1.22" desc="5.2.1.1.22 Publicaciones y Agencias Vtas.">5.2.1.1.22 Publicaciones y Agencias Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446084" padre="1446061" class="cuenta" codigo="5.2.1.1.23" desc="5.2.1.1.23 Combustible Vtas.">5.2.1.1.23 Combustible Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446085" padre="1446061" class="cuenta" codigo="5.2.1.1.24" desc="5.2.1.1.24 Lubricantes Vtas.">5.2.1.1.24 Lubricantes Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446086" padre="1446061" class="cuenta" codigo="5.2.1.1.25" desc="5.2.1.1.25 Seguros Vtas.">5.2.1.1.25 Seguros Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446087" padre="1446061" class="cuenta" codigo="5.2.1.1.26" desc="5.2.1.1.26 Movilización y Transporte Vtas.">5.2.1.1.26 Movilización y Transporte Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446088" padre="1446061" class="cuenta" codigo="5.2.1.1.27" desc="5.2.1.1.27 Guías de Transportes Vtas.">5.2.1.1.27 Guías de Transportes Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446090" padre="1446061" class="cuenta" codigo="5.2.1.1.28" desc="5.2.1.1.28 Fletes Vtas.">5.2.1.1.28 Fletes Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446091" padre="1446061" class="cuenta" codigo="5.2.1.1.29" desc="5.2.1.1.29 Gastos de Gestión Vtas.">5.2.1.1.29 Gastos de Gestión Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446092" padre="1446061" class="cuenta" codigo="5.2.1.1.30" desc="5.2.1.1.30 Viajes Vtas.">5.2.1.1.30 Viajes Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446093" padre="1446061" class="cuenta" codigo="5.2.1.1.31" desc="5.2.1.1.31 Viajes al Exterior Vtas.">5.2.1.1.31 Viajes al Exterior Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446094" padre="1446061" class="cuenta" codigo="5.2.1.1.32" desc="5.2.1.1.32 Pasajes Aereos Vtas.">5.2.1.1.32 Pasajes Aereos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446095" padre="1446061" class="cuenta" codigo="5.2.1.1.33" desc="5.2.1.1.33 Energía Eléctrica Vtas.">5.2.1.1.33 Energía Eléctrica Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446096" padre="1446061" class="cuenta" codigo="5.2.1.1.34" desc="5.2.1.1.34 Teléfonos Convencionales Vtas.">5.2.1.1.34 Teléfonos Convencionales Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446097" padre="1446061" class="cuenta" codigo="5.2.1.1.35" desc="5.2.1.1.35 Celulares Vtas.">5.2.1.1.35 Celulares Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446098" padre="1446061" class="cuenta" codigo="5.2.1.1.36" desc="5.2.1.1.36 Internet Vtas.">5.2.1.1.36 Internet Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446099" padre="1446061" class="cuenta" codigo="5.2.1.1.37" desc="5.2.1.1.37 Agua Vtas.">5.2.1.1.37 Agua Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446100" padre="1446061" class="cuenta" codigo="5.2.1.1.38" desc="5.2.1.1.38 Televisión Pagada Vtas. ">5.2.1.1.38 Televisión Pagada Vtas. </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446101" padre="1446061" class="cuenta" codigo="5.2.1.1.39" desc="5.2.1.1.39 Gastos Notariales Vtas.">5.2.1.1.39 Gastos Notariales Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446102" padre="1446061" class="cuenta" codigo="5.2.1.1.40" desc="5.2.1.1.40 Gastos de Registro Mercantil Vtas.">5.2.1.1.40 Gastos de Registro Mercantil Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446103" padre="1446061" class="cuenta" codigo="5.2.1.1.41" desc="5.2.1.1.41 Impuesto a los Consumos Especiales Vtas. ">5.2.1.1.41 Impuesto a los Consumos Especiales Vtas. </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446104" padre="1446061" class="cuenta" codigo="5.2.1.1.42" desc="5.2.1.1.42 Impuesto a Consumos Vtas. ">5.2.1.1.42 Impuesto a Consumos Vtas. </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446105" padre="1446061" class="cuenta" codigo="5.2.1.1.43" desc="5.2.1.1.43 Tasas y Contribuciones Vtas. ">5.2.1.1.43 Tasas y Contribuciones Vtas. </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446106" padre="1446061" class="cuenta" codigo="5.2.1.1.44" desc="5.2.1.1.44 Contribuciones a Superintendencia de Compañías Vtas.">5.2.1.1.44 Contribuciones a Superintendencia de Compañías Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446107" padre="1446061" class="cuenta" codigo="5.2.1.1.45" desc="5.2.1.1.45 IVA Gasto Vtas.">5.2.1.1.45 IVA Gasto Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446108" padre="1446061" class="cuenta" codigo="5.2.1.1.46" desc="5.2.1.1.46 Depreciaciones Propiedades Planta y Equipos Vtas.">5.2.1.1.46 Depreciaciones Propiedades Planta y Equipos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446109" padre="1446061" class="cuenta" codigo="5.2.1.1.47" desc="5.2.1.1.47 Depreciaciones de Inversiones Vtas.">5.2.1.1.47 Depreciaciones de Inversiones Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446110" padre="1446061" class="cuenta" codigo="5.2.1.1.48" desc="5.2.1.1.48 Amortizaciones Intangibles Vtas.">5.2.1.1.48 Amortizaciones Intangibles Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446111" padre="1446061" class="cuenta" codigo="5.2.1.1.49" desc="5.2.1.1.49 Amortizaciones Otros Activos Vtas.">5.2.1.1.49 Amortizaciones Otros Activos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446112" padre="1446061" class="cuenta" codigo="5.2.1.1.50" desc="5.2.1.1.50 Gastos por Deterioro Propiedades Planta y Equipos Vtas">5.2.1.1.50 Gastos por Deterioro Propiedades Planta y Equipos Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446113" padre="1446061" class="cuenta" codigo="5.2.1.1.51" desc="5.2.1.1.51 Gastos de Deterioro Inventario Vtas">5.2.1.1.51 Gastos de Deterioro Inventario Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446114" padre="1446061" class="cuenta" codigo="5.2.1.1.52" desc="5.2.1.1.52 Gastos por Deterioro Instrumentos Financieros Vtas">5.2.1.1.52 Gastos por Deterioro Instrumentos Financieros Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446115" padre="1446061" class="cuenta" codigo="5.2.1.1.53" desc="5.2.1.1.53 Gastos por Deterioro Intangibles Vtas.">5.2.1.1.53 Gastos por Deterioro Intangibles Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446116" padre="1446061" class="cuenta" codigo="5.2.1.1.54" desc="5.2.1.1.54 Gastos por Deterioro Cuentas por Cobrar Vtas">5.2.1.1.54 Gastos por Deterioro Cuentas por Cobrar Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446117" padre="1446061" class="cuenta" codigo="5.2.1.1.55" desc="5.2.1.1.55 Gastos por Deterioro Otros Activos Vtas.">5.2.1.1.55 Gastos por Deterioro Otros Activos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446118" padre="1446061" class="cuenta" codigo="5.2.1.1.56" desc="5.2.1.1.56 Gastos Anormales Mano de Obra Vtas.">5.2.1.1.56 Gastos Anormales Mano de Obra Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446119" padre="1446061" class="cuenta" codigo="5.2.1.1.57" desc="5.2.1.1.57 Gastos Anormales Materiales Vtas.">5.2.1.1.57 Gastos Anormales Materiales Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446120" padre="1446061" class="cuenta" codigo="5.2.1.1.58" desc="5.2.1.1.58 Gastos Anormales Costos de Produccion Vtas">5.2.1.1.58 Gastos Anormales Costos de Produccion Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446121" padre="1446061" class="cuenta" codigo="5.2.1.1.59" desc="5.2.1.1.59 Gastos por Restructuracion Vtas">5.2.1.1.59 Gastos por Restructuracion Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446122" padre="1446061" class="cuenta" codigo="5.2.1.1.60" desc="5.2.1.1.60 Gastos por Valor Neto de realizacion de Inventarios Vtas">5.2.1.1.60 Gastos por Valor Neto de realizacion de Inventarios Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446123" padre="1446061" class="cuenta" codigo="5.2.1.1.61" desc="5.2.1.1.61 Asociaciones y Suscripciones Vtas.">5.2.1.1.61 Asociaciones y Suscripciones Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446124" padre="1446061" class="cuenta" codigo="5.2.1.1.62" desc="5.2.1.1.62 Cuotas y Afiliaciones Vtas.">5.2.1.1.62 Cuotas y Afiliaciones Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446125" padre="1446061" class="cuenta" codigo="5.2.1.1.63" desc="5.2.1.1.63 Gastos de Oficina Vtas">5.2.1.1.63 Gastos de Oficina Vtas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446126" padre="1446061" class="cuenta" codigo="5.2.1.1.64" desc="5.2.1.1.64 Capacitación y Entrenamiento Vtas.">5.2.1.1.64 Capacitación y Entrenamiento Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446127" padre="1446061" class="cuenta" codigo="5.2.1.1.65" desc="5.2.1.1.65 Uniformes Vtas.">5.2.1.1.65 Uniformes Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446128" padre="1446061" class="cuenta" codigo="5.2.1.1.66" desc="5.2.1.1.66 Miscelaneos Vtas.">5.2.1.1.66 Miscelaneos Vtas.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446129" padre="1446060" class="cuenta" codigo="5.2.1.2" desc="5.2.1.2 Administrativos">5.2.1.2 Administrativos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $4,483.11</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446130" padre="1446129" class="cuenta" codigo="5.2.1.2.1" desc="5.2.1.2.1 Sueldos Unificados Adm.">5.2.1.2.1 Sueldos Unificados Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446131" padre="1446129" class="cuenta" codigo="5.2.1.2.2" desc="5.2.1.2.2 Sobretiempos Adm.">5.2.1.2.2 Sobretiempos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446132" padre="1446129" class="cuenta" codigo="5.2.1.2.3" desc="5.2.1.2.3 Gratificaciones Adm.">5.2.1.2.3 Gratificaciones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446133" padre="1446129" class="cuenta" codigo="5.2.1.2.4" desc="5.2.1.2.4 Alimentación Adm.">5.2.1.2.4 Alimentación Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $3.07</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446134" padre="1446129" class="cuenta" codigo="5.2.1.2.5" desc="5.2.1.2.5 Aportes Patronales al IESS Adm.">5.2.1.2.5 Aportes Patronales al IESS Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446135" padre="1446129" class="cuenta" codigo="5.2.1.2.6" desc="5.2.1.2.6 Secap - Iece Adm.">5.2.1.2.6 Secap - Iece Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446136" padre="1446129" class="cuenta" codigo="5.2.1.2.7" desc="5.2.1.2.7 Fondos de Reserva Adm.">5.2.1.2.7 Fondos de Reserva Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446137" padre="1446129" class="cuenta" codigo="5.2.1.2.8" desc="5.2.1.2.8 Décimo Tercer Sueldo Adm.">5.2.1.2.8 Décimo Tercer Sueldo Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446138" padre="1446129" class="cuenta" codigo="5.2.1.2.9" desc="5.2.1.2.9 Décimo Cuarto Sueldo Adm.">5.2.1.2.9 Décimo Cuarto Sueldo Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446139" padre="1446129" class="cuenta" codigo="5.2.1.2.10" desc="5.2.1.2.10 Vacaciones Adm.">5.2.1.2.10 Vacaciones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446140" padre="1446129" class="cuenta" codigo="5.2.1.2.11" desc="5.2.1.2.11 Desahucio Adm.">5.2.1.2.11 Desahucio Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446141" padre="1446129" class="cuenta" codigo="5.2.1.2.12" desc="5.2.1.2.12 Gastos Planes de Beneficios a Empleados Adm.">5.2.1.2.12 Gastos Planes de Beneficios a Empleados Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446142" padre="1446129" class="cuenta" codigo="5.2.1.2.13" desc="5.2.1.2.13 Honorarios Profesionales Adm.">5.2.1.2.13 Honorarios Profesionales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $2,442.90</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446143" padre="1446129" class="cuenta" codigo="5.2.1.2.14" desc="5.2.1.2.14 Servicios Contratados Adm.">5.2.1.2.14 Servicios Contratados Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446144" padre="1446129" class="cuenta" codigo="5.2.1.2.15" desc="5.2.1.2.15 Gastos Remuneraciones a otros trabajadores autónomos Adm.">5.2.1.2.15 Gastos Remuneraciones a otros trabajadores autónomos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446145" padre="1446129" class="cuenta" codigo="5.2.1.2.16" desc="5.2.1.2.16 Gastos Honorarios a extranjeros por Servicios Ocasionales Adm.">5.2.1.2.16 Gastos Honorarios a extranjeros por Servicios Ocasionales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446146" padre="1446129" class="cuenta" codigo="5.2.1.2.17" desc="5.2.1.2.17 Mantenimiento de Equipos Adm.">5.2.1.2.17 Mantenimiento de Equipos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446147" padre="1446129" class="cuenta" codigo="5.2.1.2.18" desc="5.2.1.2.18 Reparaciones de Equipos Adm.">5.2.1.2.18 Reparaciones de Equipos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446148" padre="1446129" class="cuenta" codigo="5.2.1.2.19" desc="5.2.1.2.19 Arriendos Adm.">5.2.1.2.19 Arriendos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446149" padre="1446129" class="cuenta" codigo="5.2.1.2.20" desc="5.2.1.2.20 Comisiones Adm.">5.2.1.2.20 Comisiones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446150" padre="1446129" class="cuenta" codigo="5.2.1.2.21" desc="5.2.1.2.21 Publicidad y Promoción Adm.">5.2.1.2.21 Publicidad y Promoción Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446151" padre="1446129" class="cuenta" codigo="5.2.1.2.22" desc="5.2.1.2.22 Publicaciones y Agencias Adm.">5.2.1.2.22 Publicaciones y Agencias Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446152" padre="1446129" class="cuenta" codigo="5.2.1.2.23" desc="5.2.1.2.23 Combustible Adm.">5.2.1.2.23 Combustible Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $14.01</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446153" padre="1446129" class="cuenta" codigo="5.2.1.2.24" desc="5.2.1.2.24 Lubricantes Adm.">5.2.1.2.24 Lubricantes Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446154" padre="1446129" class="cuenta" codigo="5.2.1.2.25" desc="5.2.1.2.25 Seguros Adm.">5.2.1.2.25 Seguros Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446155" padre="1446129" class="cuenta" codigo="5.2.1.2.26" desc="5.2.1.2.26 Movilización y Transporte Adm.">5.2.1.2.26 Movilización y Transporte Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446156" padre="1446129" class="cuenta" codigo="5.2.1.2.27" desc="5.2.1.2.27 Guías de Transportes Adm.">5.2.1.2.27 Guías de Transportes Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446157" padre="1446129" class="cuenta" codigo="5.2.1.2.28" desc="5.2.1.2.28 Fletes Adm.">5.2.1.2.28 Fletes Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446158" padre="1446129" class="cuenta" codigo="5.2.1.2.29" desc="5.2.1.2.29 Gastos de Gestión Adm.">5.2.1.2.29 Gastos de Gestión Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $2.47</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446159" padre="1446129" class="cuenta" codigo="5.2.1.2.30" desc="5.2.1.2.30 Gastos de Viajes Adm.">5.2.1.2.30 Gastos de Viajes Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446160" padre="1446129" class="cuenta" codigo="5.2.1.2.31" desc="5.2.1.2.31 Viajes al Exterior Adm.">5.2.1.2.31 Viajes al Exterior Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446161" padre="1446129" class="cuenta" codigo="5.2.1.2.32" desc="5.2.1.2.32 Pasajes Aereos Adm.">5.2.1.2.32 Pasajes Aereos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446162" padre="1446129" class="cuenta" codigo="5.2.1.2.33" desc="5.2.1.2.33 Energía Eléctrica Adm.">5.2.1.2.33 Energía Eléctrica Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446163" padre="1446129" class="cuenta" codigo="5.2.1.2.34" desc="5.2.1.2.34 Teléfonos Convencionales Adm.">5.2.1.2.34 Teléfonos Convencionales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446164" padre="1446129" class="cuenta" codigo="5.2.1.2.35" desc="5.2.1.2.35 Celulares Adm.">5.2.1.2.35 Celulares Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446165" padre="1446129" class="cuenta" codigo="5.2.1.2.36" desc="5.2.1.2.36 Internet Adm.">5.2.1.2.36 Internet Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $103.66</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446166" padre="1446129" class="cuenta" codigo="5.2.1.2.37" desc="5.2.1.2.37 Agua Adm.">5.2.1.2.37 Agua Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446167" padre="1446129" class="cuenta" codigo="5.2.1.2.38" desc="5.2.1.2.38 Televisión Pagada Adm.">5.2.1.2.38 Televisión Pagada Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446168" padre="1446129" class="cuenta" codigo="5.2.1.2.39" desc="5.2.1.2.39 Gastos Notariales Adm.">5.2.1.2.39 Gastos Notariales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446169" padre="1446129" class="cuenta" codigo="5.2.1.2.40" desc="5.2.1.2.40 Gastos de Registro Mercantil Adm.">5.2.1.2.40 Gastos de Registro Mercantil Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $35.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446170" padre="1446129" class="cuenta" codigo="5.2.1.2.41" desc="5.2.1.2.41 Impuesto a los Consumos Especiales Adm.">5.2.1.2.41 Impuesto a los Consumos Especiales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446171" padre="1446129" class="cuenta" codigo="5.2.1.2.42" desc="5.2.1.2.42 Impuesto a los Consumos Adm.">5.2.1.2.42 Impuesto a los Consumos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446172" padre="1446129" class="cuenta" codigo="5.2.1.2.43" desc="5.2.1.2.43 Tasas y Contribuciones Adm.">5.2.1.2.43 Tasas y Contribuciones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446173" padre="1446129" class="cuenta" codigo="5.2.1.2.44" desc="5.2.1.2.44 Contribuciones a Superintendencia de Compañías Adm.">5.2.1.2.44 Contribuciones a Superintendencia de Compañías Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446174" padre="1446129" class="cuenta" codigo="5.2.1.2.45" desc="5.2.1.2.45 IVA Gasto Adm.">5.2.1.2.45 IVA Gasto Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446175" padre="1446129" class="cuenta" codigo="5.2.1.2.46" desc="5.2.1.2.46 Depreciaciones Propiedades Planta y Equipos Adm.">5.2.1.2.46 Depreciaciones Propiedades Planta y Equipos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446176" padre="1446129" class="cuenta" codigo="5.2.1.2.47" desc="5.2.1.2.47 Depreciaciones de Inversiones Adm.">5.2.1.2.47 Depreciaciones de Inversiones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446177" padre="1446129" class="cuenta" codigo="5.2.1.2.48" desc="5.2.1.2.48 Amortizaciones Intangibles Adm.">5.2.1.2.48 Amortizaciones Intangibles Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446178" padre="1446129" class="cuenta" codigo="5.2.1.2.49" desc="5.2.1.2.49 Amortizaciones Otros Activos Adm.">5.2.1.2.49 Amortizaciones Otros Activos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446179" padre="1446129" class="cuenta" codigo="5.2.1.2.50" desc="5.2.1.2.50 Gastos por Deterioro Propiedades Planta y Equipos Adm.">5.2.1.2.50 Gastos por Deterioro Propiedades Planta y Equipos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446180" padre="1446129" class="cuenta" codigo="5.2.1.2.51" desc="5.2.1.2.51 Gastos de Deterioro Inventario Adm.">5.2.1.2.51 Gastos de Deterioro Inventario Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446181" padre="1446129" class="cuenta" codigo="5.2.1.2.52" desc="5.2.1.2.52 Gastos por Deterioro Instrumentos Financieros Adm.">5.2.1.2.52 Gastos por Deterioro Instrumentos Financieros Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446182" padre="1446129" class="cuenta" codigo="5.2.1.2.53" desc="5.2.1.2.53 Gastos por Deterioro Instrumentos Financieros Adm.">5.2.1.2.53 Gastos por Deterioro Instrumentos Financieros Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446183" padre="1446129" class="cuenta" codigo="5.2.1.2.54" desc="5.2.1.2.54 Gastos por Deterioro Cuentas por Cobrar Adm.">5.2.1.2.54 Gastos por Deterioro Cuentas por Cobrar Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446184" padre="1446129" class="cuenta" codigo="5.2.1.2.55" desc="5.2.1.2.55 Gastos por Deterioro Otros Activos Adm.">5.2.1.2.55 Gastos por Deterioro Otros Activos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446185" padre="1446129" class="cuenta" codigo="5.2.1.2.56" desc="5.2.1.2.56 Gastos Anormales Mano de Obra Adm.">5.2.1.2.56 Gastos Anormales Mano de Obra Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446186" padre="1446129" class="cuenta" codigo="5.2.1.2.57" desc="5.2.1.2.57 Gastos Anormales Materiales Adm.">5.2.1.2.57 Gastos Anormales Materiales Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446187" padre="1446129" class="cuenta" codigo="5.2.1.2.58" desc="5.2.1.2.58 Gastos Anormales Costos de Producción Adm.">5.2.1.2.58 Gastos Anormales Costos de Producción Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446188" padre="1446129" class="cuenta" codigo="5.2.1.2.59" desc="5.2.1.2.59 Gastos por Restructuracion Adm.">5.2.1.2.59 Gastos por Restructuracion Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446189" padre="1446129" class="cuenta" codigo="5.2.1.2.60" desc="5.2.1.2.60 Gastos por Valor Neto de realizacion de Inventarios Adm.">5.2.1.2.60 Gastos por Valor Neto de realizacion de Inventarios Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446190" padre="1446129" class="cuenta" codigo="5.2.1.2.61" desc="5.2.1.2.61 Asociaciones y Suscripciones Adm.">5.2.1.2.61 Asociaciones y Suscripciones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446191" padre="1446129" class="cuenta" codigo="5.2.1.2.62" desc="5.2.1.2.62 Cuotas y Afiliaciones Adm.">5.2.1.2.62 Cuotas y Afiliaciones Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446192" padre="1446129" class="cuenta" codigo="5.2.1.2.63" desc="5.2.1.2.63 Gastos de Oficina Adm.">5.2.1.2.63 Gastos de Oficina Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $1,882.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446193" padre="1446129" class="cuenta" codigo="5.2.1.2.64" desc="5.2.1.2.64 Capacitación y Entrenamiento Adm.">5.2.1.2.64 Capacitación y Entrenamiento Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446194" padre="1446129" class="cuenta" codigo="5.2.1.2.65" desc="5.2.1.2.65 Uniformes Adm.">5.2.1.2.65 Uniformes Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446195" padre="1446129" class="cuenta" codigo="5.2.1.2.66" desc="5.2.1.2.66 Miscelaneos Adm.">5.2.1.2.66 Miscelaneos Adm.</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446196" padre="1446060" class="cuenta" codigo="5.2.1.3" desc="5.2.1.3 Gastos Financieros">5.2.1.3 Gastos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446197" padre="1446196" class="cuenta" codigo="5.2.1.3.1" desc="5.2.1.3.1 Intereses">5.2.1.3.1 Intereses</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446198" padre="1446196" class="cuenta" codigo="5.2.1.3.2" desc="5.2.1.3.2 Comisiones">5.2.1.3.2 Comisiones</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446199" padre="1446196" class="cuenta" codigo="5.2.1.3.3" desc="5.2.1.3.3 Gastos de Financiamiento de Activos">5.2.1.3.3 Gastos de Financiamiento de Activos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446200" padre="1446196" class="cuenta" codigo="5.2.1.3.4" desc="5.2.1.3.4 Gastos Diferencia en Cambio">5.2.1.3.4 Gastos Diferencia en Cambio</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446201" padre="1446196" class="cuenta" codigo="5.2.1.3.5" desc="5.2.1.3.5 Otros Gastos Financieros">5.2.1.3.5 Otros Gastos Financieros</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446202" padre="1446059" class="cuenta" codigo="5.2.2" desc="5.2.2 Gastos No Operacionales">5.2.2 Gastos No Operacionales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:105px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446203" padre="1446202" class="cuenta" codigo="5.2.2.1" desc="5.2.2.1 Otros Gastos">5.2.2.1 Otros Gastos</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446204" padre="1446203" class="cuenta" codigo="5.2.2.1.1" desc="5.2.2.1.1 Perdida en Inversiones en Asociadas/Subsidiarias y otras">5.2.2.1.1 Perdida en Inversiones en Asociadas/Subsidiarias y otras</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446205" padre="1446203" class="cuenta" codigo="5.2.2.1.2" desc="5.2.2.1.2 Intereses Tributarios">5.2.2.1.2 Intereses Tributarios</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446206" padre="1446203" class="cuenta" codigo="5.2.2.1.3" desc="5.2.2.1.3 Multas Tributarias ">5.2.2.1.3 Multas Tributarias </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446207" padre="1446203" class="cuenta" codigo="5.2.2.1.4" desc="5.2.2.1.4 Multas Superintendencia de Compañías ">5.2.2.1.4 Multas Superintendencia de Compañías </a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446208" padre="1446203" class="cuenta" codigo="5.2.2.1.5" desc="5.2.2.1.5 Faltantes de Inventario">5.2.2.1.5 Faltantes de Inventario</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446209" padre="1446203" class="cuenta" codigo="5.2.2.1.6" desc="5.2.2.1.6 Faltantes de Caja">5.2.2.1.6 Faltantes de Caja</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446210" padre="1446203" class="cuenta" codigo="5.2.2.1.7" desc="5.2.2.1.7 Comprobantes de Ventas que no cumplen requisitos legales">5.2.2.1.7 Comprobantes de Ventas que no cumplen requisitos legales</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446211" padre="1446203" class="cuenta" codigo="5.2.2.1.8" desc="5.2.2.1.8 Gastos de Viajes">5.2.2.1.8 Gastos de Viajes</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446212" padre="1446203" class="cuenta" codigo="5.2.2.1.9" desc="5.2.2.1.9 Gastos de Gestión">5.2.2.1.9 Gastos de Gestión</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446213" padre="1446203" class="cuenta" codigo="5.2.2.1.10" desc="5.2.2.1.10 Retenciones Asumidas">5.2.2.1.10 Retenciones Asumidas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:140px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446214" padre="1446203" class="cuenta" codigo="5.2.2.1.11" desc="5.2.2.1.11 Gastos por Cancelación de Propinas">5.2.2.1.11 Gastos por Cancelación de Propinas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>

                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class="glyphicon glyphicon-plus" style="cursor:pointer;" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>

                              <td class="pad-cuenta" style="padding-left:70px;font-weight: bold;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446215" padre="1446059" class="cuenta" codigo="5.2.3" desc="5.2.3 Gastos de Operaciones Descontinuadas">5.2.3 Gastos de Operaciones Descontinuadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>
                            <tr style="display: none;">
                              <td class="text-center" style="color:#0088cc;font-size:11px;">
                                <span class=" " style="" onclick="PlanCuenta.toggleGrupo(this);"></span>
                              </td>
                              <td class="pad-cuenta" style="padding-left:105px;font-style: italic;">
                                &nbsp;&nbsp;<a href="javascript:void(0);" rel="" data-popover-content="#popover_content_wrapper" data-placement="right" data-title="Menú Opciones" data-trigger="focus" style="color:black;" id="1446216" padre="1446215" class="cuenta" codigo="5.2.3.1" desc="5.2.3.1 Gastos de Operaciones Descontinuadas">5.2.3.1 Gastos de Operaciones Descontinuadas</a>
                              </td>
                              <!---->
                              <td style="text-align:right;color:black;" width="160"> $0.00</td>
                              <!---->
                            </tr>
                        </tbody>
                      </table>
              	    </div>
              	</div>
              </div>
              <div id="dlgmsgcuenta" class="modal fade" data-keyboard="false" data-backdrop="static">
                  <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                          <div class="modal-header text-center">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title text-default">Cuenta Contable</h4>
                          </div>
                          <div class="modal-body">
              				        <div class="text-center"><span class="ico-time"></span> <b> Procesando...</b></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="text-right">
        <a href="#" id="js_up" class="ir-arriba" title="Volver arriba">
          <span class="fa-stack">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
          </span>
        </a>
      </div>
      <!--/ END To Top Scroller -->
  </section>
  <script type="text/javascript" src="function/inputmask.js"></script>
  <script type="text/javascript" src="function/core.js"></script>
  <script type="text/javascript" src="function/app.js"></script>
  <script type="text/javascript" src="function/selectize.js"></script>
  <script type="text/javascript" src="function/modernizr.js"></script>
  <script type="text/javascript" src="function/jquery-ui.js"></script>
  <script type="text/javascript" src="function/jquery-ui-timepicker.js"></script>
  <script type="text/javascript" src="function/jquery-ui-touch.js"></script>
  <script type="text/javascript" src="function/select2.js"></script>
  <script type="text/javascript" src="function/jquery.bootstrap-touchspin.js"></script>
  <script type="text/javascript" src="function/bootbox.js"></script>
  <script type="text/javascript" src="function/jquery.gritter.js"></script>
  <script type="text/javascript" src="function/notification.js"></script>
  <script type="text/javascript" src="function/jquery.magnific-popup.js"></script>
  <script type="text/javascript" src="function/jquery.shuffle.js"></script>
  <script type="text/javascript" src="function/media-gallery.js"></script>
  <script type="text/javascript" src="function/jquery.contextMenu.min.js"></script>
  <script type="text/javascript" src="function/jquery.ui.position.min.js"></script>
  <!--Calendario en Español -->
  <script type="text/javascript" src="function/ui.datepicker-es.js"></script>
  <script type="text/javascript" src="function/intro.js"></script>
	<script type="text/javascript">
		$(function(){
			ejecutarMenu();
		});
	</script>
  <script type="text/javascript">
		$(function(){

		});
	</script>
  <script type="text/javascript">
  	$(function(){
  		$.contextMenu({
  	        selector: '.cuenta',
  	        trigger: 'left',
  	        callback: function(key, opt) {
  	            handleContextMenu(key, opt.$trigger);
  	        },
  	        items: {
		            "agregar-cuenta": {name: "Agregar Cuenta", icon: "add"},
		            "modificar": {name: "Modificar", icon: "edit"},
		            "eliminar": {name: "Eliminar", icon: "delete"},
  	            sep1: "---------",
  	            "mayor": {name: "Ir a Mayor", icon: "copy"},
  	            "libro": {name: "Ir a Libro Diario", icon: "paste"},
  	        }
  	    });
  	});
  </script>
  <script type="text/javascript">
      $(function(){
          //Popup de Notificaciones
          $('#notificaciones').on('show.bs.popover', function(){
              $(this).tooltip('destroy');
          });

          $('#notificaciones').on('hide.bs.popover', function(){
              $('.popover.bottom').css('display','none');
          });

          $('#notificaciones').popover({
              html: true,
              content: function() {
                  return $('#not-main').html();
              }
          });

          var notificaciones_show = 0;
          $('#notificaciones').on('show.bs.popover', function(){
              notificaciones_show = 1;
          });

          $('#notificaciones').on('hide.bs.popover', function(){
              notificaciones_show = 0;
              $('.popover.bottom').css('display','none');
          });

          $('#notificaciones').popover({
              html: true,
              content: function() {
                  return $('#not-main').html();
              }
          });

          $('body').on('click', function (e) {
              if(notificaciones_show){
                  $('#notificaciones').each(function () {
                      //the 'is' for buttons that trigger popups
                      //the 'has' for icons within a button that triggers a popup
                      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                          $(this).popover('hide');
                      }
                  });
              }
          });

          $(document).ready(function() {
              var toggled = false;
              $('.dropdown-toggle').on('click', function() {
                  if (toggled === false) {
                      $('.nav .open ul').hide();
                      $('.nav .dropdown ul').show();
                      toggled = true;
                  } else {
                      $('.nav .dropdown ul').hide();
                      $('.nav .open ul').show();
                      toggled = false;
                  }
              });
          });
      });
  </script>
  <script>
    $(document).ready(function(){
      //invocamos al objeto (window) y a su método (scroll), solo se ejecutara si el usuario hace scroll en la página
      $(window).scroll(function(){
        if($(this).scrollTop() > 300){ //condición a cumplirse cuando el usuario aya bajado 301px a más.
          $("#js_up").slideDown(300); //se muestra el botón en 300 mili segundos
        }else{ // si no
          $("#js_up").slideUp(300); //se oculta el botón en 300 mili segundos
        }
      });

      //creamos una función accediendo a la etiqueta i en su evento click
      $("#js_up i").on('click', function (e) {
        e.preventDefault(); //evita que se ejecute el tag ancla (<a href="#">valor</a>).
        $("body,html").animate({ // aplicamos la función animate a los tags body y html
          scrollTop: 0 //al colocar el valor 0 a scrollTop me volverá a la parte inicial de la página
        },700); //el valor 700 indica que lo ara en 700 mili segundos
        return false; //rompe el bucle
      });
    });
  </script>
  <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul><span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span><ul class="context-menu-list context-menu-root" style="display: none;"><li class="context-menu-item context-menu-icon-add"><span>Agregar Cuenta</span></li><li class="context-menu-item context-menu-icon-edit"><span>Modificar</span></li><li class="context-menu-item context-menu-icon-delete"><span>Eliminar</span></li><li class="context-menu-item context-menu-separator context-menu-not-selectable"><span></span></li><li class="context-menu-item context-menu-icon-copy"><span>Ir a Mayor</span></li><li class="context-menu-item context-menu-icon-paste"><span>Ir a Libro Diario</span></li></ul><div><iframe data-reactroot="" id="ticketSubmissionForm" class="zEWidget-ticketSubmissionForm" style="border: none; background: transparent; z-index: 999999; transform: translateZ(0px); position: fixed; opacity: 0; left: 0px; bottom: 0px; width: 357px; margin-left: 15px; margin-right: 15px; margin-top: 0px; height: 476px; transition-property: none; transition-timing-function: unset; top: -9999px;" src="./cuentas_files/saved_resource(1).html"></iframe></div><div><iframe data-reactroot="" id="launcher" class="zEWidget-launcher " style="border: none; background: transparent; z-index: 999998; transform: translateZ(0px); position: fixed; opacity: 0; left: 0px; bottom: 0px; width: 138px; height: 48px; margin: 10px 20px; transition-property: none; transition-timing-function: unset; top: -9999px;" src="./cuentas_files/saved_resource(2).html"></iframe></div><div><iframe data-reactroot="" id="nps" class="zEWidget-nps" style="border: none; background: transparent; z-index: 2147483647; transform: translateZ(0px); position: fixed; opacity: 0; right: 0px; bottom: 0px; left: 50%; margin-left: -310px; margin-bottom: 15px; width: 640px; margin-top: 0px; height: 177px; transition-property: none; transition-timing-function: unset; top: -9999px;" src="./cuentas_files/saved_resource(3).html"></iframe></div><div><iframe data-reactroot="" id="ipm" class="zEWidget-ipm" style="border: none; background: transparent; z-index: 2147483647; transform: translateZ(0px); position: fixed; opacity: 0; right: 0px; top: -245px; margin-right: 15px; margin-top: 0px; height: 195px; width: 395px; transition-property: none; transition-timing-function: unset;" src="./cuentas_files/saved_resource(4).html">
  </iframe>
</div>
</body>
</html>
