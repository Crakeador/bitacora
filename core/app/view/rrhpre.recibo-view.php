<?php
header('Content-Type: text/html; charset=utf-8');

$persons = PersonData::getAll(); 
$rubros = DescuentoData::getAll(); 

if(isset($_GET["id"])){
	$mensaje = "modificar los datos adicionales de un agente";
    $enlaces = "Modificar";

	$valores = ReciboData::getById($_GET["id"]);
	
	$discounts = (object) $valores[0];
	$adicional = $_GET["id"];
}else{
	$mensaje = "agregar un nuevo grupo adicional";
    $enlaces = "Agregar";

	if(count($_POST)>0){ 
		if(isset($_POST["active"])) $activo=1; else $activo=0;
		$porcion = explode(" ", $_POST["dtp_input"]);

		$discount = new ReciboData();

		$discount->idperson = $_POST["person"];
		$discount->iddescuento = $_POST["descuento"];
		$discount->cuota = $_POST["cuota"];
		$discount->monto = $_POST["money"];
		$discount->observacion = $_POST["motivo"];
		$discount->entregado = $porcion[0];
		$discount->is_active = $activo;
	
		if($_POST["adicional"] == 0){
			$discount->add();
		}else{
			$discount->id = $_POST["adicional"];
			$discount->update();
		}
		Core::redir('rrhpre.lista');
	}else{
		$adicional = 0; 
		$discounts = (object) [
			"idperson" => "",
			"iddescuento" => "",
			"cuota" => "",
			"monto" => "",
			"entregado" => date("Y-m-d"),			
			"observacion" => null,
			"is_active" => "1"
		];
	}
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small><?php echo $mensaje; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="?view=rrhpre.lista"><i class="fa fa-book"></i> Lista de adicionales </a></li>
		<li class="active"><?php echo $enlaces; ?></li>
	</ol>
</section>
<section id="main" role="main" style="padding: 1.5rem !important;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<p class="alert alert-info">
					<strong><i class="fa fa-bullhorn"></i> Importante...!</strong>
					- Los campos obligatorios estan marcados con asteriscos rojo <span class="text-danger">*</span>
				</p>
				<form class="form-horizontal" id="datos_prestamo" role="form" action="index.php?view=rrhpre.recibo" method="post">
					<input type="hidden" name="adicional" id="adicional" value="<?php echo $adicional; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Detalle del adicional</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Nombre:</label>
								<div class="col-md-5 col-sm-5">
									<select class="select-input form-control input-sm select2" id="id_person" name="person">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($persons as $person):
												if($person->id == $discounts->idperson) $valor = 'selected'; else $valor = ''; ?>
												<option value="<?php echo $person->id; ?>" <?php echo $valor; ?>><?php echo utf8_encode($person->name); ?></option>
											<?php endforeach;
										?>
									</select>
				                </div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Tipo de Descuentos:</label>
								<div class="col-md-3 col-sm-4">
									<select class="select-input form-control input-sm" id="id_descuento" name="descuento">
										<option value="0" selected="selected"> Selecione... </option>
										<?php
											foreach($rubros as $rubro):
												if($rubro->id == $discounts->iddescuento) $valor = 'selected'; else $valor = ''; ?>
												<option value="<?php echo $rubro->id; ?>" <?php echo $valor; ?>><?php echo $rubro->descripcion;?></option>
										<?php endforeach; ?>
									</select>
				                </div>
								<label class="col-sm-2 control-label">&nbsp;</label>
								<div class="col-sm-5"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Cuotas:</label>
								<div class="col-sm-2"><input type="text" class="form-control" id="cuota" name="cuota" value="<?php echo $discounts->cuota; ?>" maxlength="2" data-mask placeholder="99"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Monto:</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="money" name="money" value="<?php echo $discounts->monto; ?>" data-mask placeholder="$ 9.999,99">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 control-label"> Observaci&oacute;n:</label>
								<div class="col-md-6">
									<textarea class="form-control input-sm" cols="50%" id="id_motivo" name="motivo" rows="4"><?php echo $discounts->observacion; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="dtp_input1" class="col-md-3 col-sm-3 control-label"><span class="text-danger">*</span> Fecha de la entrega:</label>
								<div class="col-md-5 col-sm-5">
									<div class="input-group date form_date col-sm-6" data-date-format="yyyy-mm-dd">
										<input id="dtp_input" name="dtp_input" class="form-control datepicker" size="16" type="text" value="<?php echo $discounts->entregado; ?>">
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
									</div>
								</div>
							</div>							
							<button type="submit" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-floppy-disk"></span> Guadar Descuento
							</button>
							</br>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script>document.title = "Listado de adicionales"</script>
<script type='text/javascript'>
	$("#datos_prestamo").submit(function(){
		var nombre = $("#id_person").val();
		var descuento = $("#id_descuento").val();
		var valor1 = $("#cuota").val();
		var valor2 = $("#money").val();
		var id_motivo = $("#id_motivo").val();
		var dtp_input = $("#dtp_input").val();
		var cuota = parseInt(valor1);
		var money = parseInt(valor2);

		if(nombre == null || nombre == 0) {
			sweetAlert('Error...!!!', 'Usted debe de seleccionar el personal del formulario.', 'error');
			return false;
		}else{
			if(descuento == null || descuento == 0) {
				sweetAlert('Error...!!!', 'Usted debe de el tipo de descuento del formulario.', 'error');
				return false;
			}else{
				if(cuota == null || cuota.length == 0) {
					sweetAlert('Error...!!!', 'Usted debe de complerar el numero de las cuotas.', 'error');
					return false;
				}else{
					if(money == null || money.length == 0) {
						sweetAlert('Error...!!!', 'Usted debe de complerar el monto del descuento del formulario.', 'error');
						return false;
					}
				}
			}
		}

		sweetAlert('Genial...!!!', 'Usted ha completado todos los datos del formulario.', 'success');
		// window.location.href = "./index.php?view=rrhpre.recibo";
	});
</script>
