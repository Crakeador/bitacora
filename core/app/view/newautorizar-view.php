  <section id="main" role="main">
    <div class="container-fluid">
        <div class="page-header page-header-block">
            <div class="page-header-section">
                <h4 class="title semibold"> Registrar Autorización </h4>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          	<form method="POST" name="autForm" class="form-horizontal">
          		<input id="id_id" name="id" type="hidden">
          		<div class="panel panel-default">
          		    <div class="panel-heading">
          		        <h3 class="panel-title">Datos Generales</h3>
          		    </div>
          		    <div class="panel-body">
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Tipo de Comprobante:</label>
            					<div class="col-md-3 col-sm-4">
            						<select class="form-control input-sm" id="id_tipo_documento" name="tipo_documento">
                          <option value="VEN">Venta</option>
                          <option value="RET">Retencion</option>
                        </select>
            					</div>
            				</div>
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Autorizaci&oacute;n:</label>
            					<div class="col-md-3 col-sm-4">
            						<input class="form-control input-sm" id="id_autorizacion" maxlength="49" name="autorizacion" type="text">
            					</div>
            				</div>
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Secuencial Inicio:</label>
            					<div class="col-md-3 col-sm-4">
            						<input class="form-control input-sm" id="id_serie_inicio" maxlength="9" name="serie_inicio" type="text">
            					</div>
            				</div>
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Secuencial Fin:</label>
            					<div class="col-md-3 col-sm-4">
            						<input class="form-control input-sm" id="id_serie_fin" maxlength="9" name="serie_fin" type="text">
            					</div>
            				</div>
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Fecha Inicio:</label>
            					<div class="col-md-3 col-sm-4">
            						<input class="date form-control input-sm hasDatepicker" id="id_fecha_inicio" name="fecha_inicio" type="text">
            					</div>
            				</div>
            				<div class="form-group">
            					<label class="col-md-2 col-sm-3 control-label">Fecha Fin:</label>
            					<div class="col-md-3 col-sm-4">
            						<input class="date form-control input-sm hasDatepicker" id="id_fecha_fin" name="fecha_fin" size="12" type="text">
            					</div>
            				</div>
            		  </div>
          		</div>
        			<a class="btn btn-success" href="javascript:document.forms.autForm.submit();">
        				<span class="glyphicon glyphicon-floppy-disk"></span>
        				Guardar
        			</a>
          	</form>
          </div>
        </div>
    </div>
  </section>
  <br><br><br><br><br><br><br><br><br>
