<?php
// Datos de Nomina
$client = ClientData::getTodos(); 

$inic = ''; $finc = '';
if(isset($_GET['id'])) {
	$cliente = $_GET['id'];
	$datos = ClientData::getById($cliente);
	$_SESSION['cliente'] = $cliente; 
	
	//var_dump();
	
	// Proceso de Generacion de la nomina
	$fecha = date("Y-m-d");
	$ano = date('Y', strtotime($fecha));
	$mes = date('m', strtotime($fecha));
		
	if(intval($datos->ini_fac) > 0){
		$dia  = $datos->ini_fac;
	}else{
		$dia  = '01';
	}
	
	$inic = $dia.'-'.$mes.'-'.$ano;
	
	if(intval($datos->fin_fac) > 0){
		$mes = date('m', strtotime("+30 day", strtotime($hoy)));
		$dia  = $datos->fin_fac;
	}else{
		$dia  = '30';
	}
		
	$finc = $dia.'-'.$mes.'-'.$ano;
}else{
	if(isset($_SESSION['cliente'])) 
		$cliente = $_SESSION['cliente'];
	else
		$cliente = 1;
		$_SESSION['cliente']=$cliente;
}

if(isset($_GET['tipo'])) {
	$tipo = $_GET['tipo'];
	$_SESSION['tipo'] = $tipo; 
}else{
	if(isset($_SESSION['tipo'])) 
		$tipo = $_SESSION['tipo'];
	else
		$tipo = 3;
		$_SESSION['tipo']=$tipo;
}

if(isset($_GET['ano'])){
	$ano=$_GET['ano'];
	$_SESSION['ano']=$ano;
}else{
	if(isset($_SESSION['ano'])){
		$ano=$_SESSION['ano'];
	}else{
		$ano=date("Y");
		$_SESSION['ano']=$ano;
	}
}

if(isset($_GET['mes'])){
	$mes=$_GET['mes'];
	$_SESSION['mes']=$mes;
}else{
	if(isset($_SESSION['mes']) && $_SESSION['mes'] > 1){
		$mes=$_SESSION['mes'];
	}else{		
		$mes=1;
		$_SESSION['mes']=$mes;
	}
}

if(isset($_GET['idperson'])){
	$user = new PagosData();
	$user->idperson = $_GET['idperson'];
	$user->mes = $_SESSION['mes'];
	$user->ano = $_SESSION['ano'];
	$user->tipo = $_SESSION['tipo'];	
	$user->monto = $_GET['monto'];
	
	$activo = PagosData::getLike($_GET['idperson'], $mes, $ano);
	
	if(!isset($activo->is_active)){		
		$user->is_active = 1;
		$user->add();
	}else{
		if($activo->is_active == 1)
			$user->is_active = 0;
		else
			$user->is_active = 1;
		
		$user->update();
	}
}

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
$final=$ano."-".$mes."-".$total;

?>
<section class="content-header">
    <h1>
        Talento Humano
        <small>resumen de ingresos y egresos por empleado</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=cobnom.lista"><i class="fa fa-dashboard"></i> Control de Nomina </a></li>
		<li class="active"> Registro de Nomina </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
	<div class="box">
		<div class="box-header with-border">
			<label> Cliente: </label>
			<select class="select-input form-control input-sm" id="idclient" name="idclient" onchange="javascript:location.href='index.php?view=cobnom.detalle&client='+value;">
				<option value="0" selected="selected"> Selecione... </option>
				<?php
					foreach($client as $clients): ?>
						<option value="<?php echo $clients->idclient; ?>" <?php if($clients->idclient == $cliente) echo 'selected="selected"'; ?>><?php echo utf8_encode($clients->nombre);?></option>
					<?php endforeach;	
				?>
			</select>	
		</div>
		<div class="box-body mailbox-messages">
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_length" id="example_length">
						<label>Nomina de:&nbsp;
							<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='index.php?view=cobnom.detallea&mes='+value;">
                                <option value= "1" <?php if($mes ==  1) echo 'selected'; ?>>Enero</option>
								<option value= "2" <?php if($mes ==  2) echo 'selected'; ?>>Febrero</option>
								<option value= "3" <?php if($mes ==  3) echo 'selected'; ?>>Marzo</option>
								<option value= "4" <?php if($mes ==  4) echo 'selected'; ?>>Abril</option>
								<option value= "5" <?php if($mes ==  5) echo 'selected'; ?>>Mayo</option>
								<option value= "6" <?php if($mes ==  6) echo 'selected'; ?>>Junio</option>
								<option value= "7" <?php if($mes ==  7) echo 'selected'; ?>>Julio</option>
								<option value= "8" <?php if($mes ==  8) echo 'selected'; ?>>Agosto</option>
								<option value= "9" <?php if($mes ==  9) echo 'selected'; ?>>Septiembre</option>
								<option value="10" <?php if($mes == 10) echo 'selected'; ?>>Octubre</option>
								<option value="11" <?php if($mes == 11) echo 'selected'; ?>>Noviembre</option>
								<option value="12" <?php if($mes == 12) echo 'selected'; ?>>Diciembre</option>
							</select>
						</label>&nbsp;&nbsp;
						<label>Año:&nbsp;
							<select style="width: 120px; display: inline-block;" id="ano_id" name="ano_id" class="form-control" onchange="javascript:location.href='index.php?view=cobnom.detalle&ano='+value;">
                                <option value="2020" <?php if($ano == '2020') echo 'selected'; ?>>2020</option>
								<option value="2021" <?php if($ano == '2021') echo 'selected'; ?>>2021</option>
								<option value="2022" <?php if($ano == '2022') echo 'selected'; ?>>2022</option>
								<option value="2023" <?php if($ano == '2023') echo 'selected'; ?>>2023</option>
								<option value="2024" <?php if($ano == '2024') echo 'selected'; ?>>2024</option>
								<option value="2025" <?php if($ano == '2025') echo 'selected'; ?>>2025</option>
								<option value="2026" <?php if($ano == '2026') echo 'selected'; ?>>2026</option>
								<option value="2027" <?php if($ano == '2027') echo 'selected'; ?>>2027</option>
								<option value="2028" <?php if($ano == '2028') echo 'selected'; ?>>2028</option>
								<option value="2029" <?php if($ano == '2029') echo 'selected'; ?>>2029</option>
								<option value="2030" <?php if($ano == '2030') echo 'selected'; ?>>2030</option>
								<option value="2031" <?php if($ano == '2031') echo 'selected'; ?>>2031</option>
								<option value="2032" <?php if($ano == '2032') echo 'selected'; ?>>2032</option>
							</select>
						</label>
					</div>
				</div>
	            <div class="col-sm-6">
					<div id="example_filter" class="dataTables_filter">
						Tipo de personal:&nbsp;&nbsp;
						<label>
							<select id="tipo_id" name="tipo_id" class="form-control" onchange="javascript:location.href='index.php?view=cobnom.detalle&tipo='+value;">
								<option value="1" <?php if($tipo == 1) echo 'selected'; ?>>Administrativo</option>
								<option value="2" <?php if($tipo == 2) echo 'selected'; ?>>Operativo</option>
								<option value="3" <?php if($tipo == 3) echo 'selected'; ?>>Agentes</option>
							</select>
						</label>
					</div>
				</div>
			</div>
			<hr>
			<div style="height: 500px; width: 100%; overflow-x: auto;" id="example_length">
				<table id="cabecera" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><div align="center">Apellidos y Nombres</div></th>
							<th style="width:10%"><div align="center">Ingreso</div></th>
							<th style="width:10%"><div align="center">Desde</div></th>
							<th style="width:10%"><div align="center">Hasta</div></th>
							<th  style="width:7%"><div align="center">Nro. Falta</div></th>
							<th  style="width:7%"><div align="center">Dias</br>trabajados</div></th>
							<th  style="width:7%"><div align="center">Total</br>ingresos</div></th>
							<th  style="width:7%"><div align="center">Total</br>egresos</div></th>
							<th style="width:10%"><div align="center">Total</br>liquido</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$users = NominaData::getHistorico($ano, $mes, $cliente);				

							$resultado = count($users);
							$j=1; $subtotal=0;

							if($resultado > 0){
								foreach($users as $tables) {
									$id = $tables->id;										
									$servicio = $tables->idservicio;
									$puesto = $tables->puesto;
									$idcard = $tables->idcard;
									$nombre = $tables->name;
									$cargo = $tables->description;
									$inicio = $tables->startwork;

									$activo = PagosData::getById($id, $mes, $ano);
									
									if(!isset($activo->id)){
										$control = 0; $boton = 'btn-success'; $image = 'fa-plus';
									}else{
										$control = 1; $boton = 'btn-danger'; $image = 'fa-minus';
									}
									$nochem = 0; $diassm = 0; $totalm = 0; 

									$totals = 0;
									$diasla = 0;
									$nochel = 0;
									$faltas = 0;
									$libres = 0;
									$noched = 0;
									$diassd = 0;
									$libret = 0;

									//echo $id.' '.count(PuestoData::getByLibre($id));
									if($_SESSION['tipo'] == 3){
										if(count(PuestoData::getByLibre($id)) == 1){
											$valor=count(HorarioData::getByIdHorario($servicio, $id, $mes, $ano, 2));
											$tipo = 'Agente'; 
										}else{ 											
											$valor=count(HorarioData::getByIdHorarioAll($id, $mes, $ano, 2));
											$tipo = 'Saca Franco'; 										
										}
									}else{
										$valor = 0;
										$tipo = 'Administrativo'; 
									}

									if($valor == 0){
										$totals = 30; $faltas = 0;
									}else{
										for ($i = 1; $i <= $total; $i++) {
											if($valor[$i-1]['turno']==1) {//dia
												$diasla++;
											}else{
												if($valor[$i-1]['turno']==2) {// noche
													$nochel++;
												}else{
													if($valor[$i-1]['turno']==3) {// libres
														$libres++;
													}else{
														if($valor[$i-1]['turno']==4) {// faltas
															$faltas++;
														}else{
															if($valor[$i-1]['turno']==5) {// libre trabajado
																$libret++;
															}else{
																if($valor[$i-1]['turno']==6) {// turno doble noche
																	$noched++; $diasla++;
																}else{
																	if($valor[$i-1]['turno']==7) {// turno doble dia
																		$diassd++; $nochel++;
																	}else{
																		if($valor[$i-1]['turno']==8) {// turno doble dia
																			$diassm++;
																		}else{
																			if($valor[$i-1]['turno']==9) {// turno dia moto
																				$nochem++;
																			}else{
																				if($valor[$i-1]['turno']==10) {// turno doble dia
																					$renuncio = $ano.'-'.$mes.'-'.$i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}

											$totals = $diasla+$nochel+$libres;
											$totala = $libret+($noched+$diassd);
											$totalm = $diassm+$nochem;
										}
									}

									$rubro = NominaData::getAll($cliente, $id, $ano, $mes);
									$ingreso=0; $egresos=0;
									foreach($rubro as $rubros) {
										if($rubros->tipo_cuenta == 'I'){
											$ingreso = $ingreso + $rubros->monto;
										}else{
											$egresos = $egresos + $rubros->monto;
										}
									}

									$numero = $ingreso-$egresos;
									$entero = floor($numero);
									$decimales = $numero-$entero;

									if(strval($decimales) == 0.99)
										$valor = round($numero);
									else
										$valor = $numero;

									echo '<tr>';
										echo '<td>';
											echo '<small>';
												echo str_pad($j, 3, "0", STR_PAD_LEFT).'-'.$nombre.'</br>'; //utf8_encode($nombre)
												echo $tipo;
											echo '</small>';
										echo '</td>';
										echo '<td style="width: 7%"><div align="center">'.$inicio.'</div></td>';
										echo '<td style="width: 7%"><div align="center">'.$fecha.'</div></td>';
										echo '<td style="width: 7%"><div align="center">'.$final.'</div></td>';
										echo '<td style="width: 7%"><div align="center">'.$faltas.'</div></td>';
										echo '<td style="width: 7%"><div align="center">'.$totals.'</div></td>';
										echo '<td style="width: 7%"><div align="right">'.number_format($ingreso, 2, ',', '.').'</div></td>';
										echo '<td style="width: 7%"><div align="right">'.number_format($egresos, 2, ',', '.').'</div></td>';
										echo '<td style="width:10%"><div align="right">'.number_format($valor, 2, ',', '.').'&nbsp;&nbsp;<button type="button" class="btn '.$boton.' btn-sm" onClick="btn_EnviarOnClick(\''.$tables->id.'\', '.$control.', '.$valor.');"><i class="fa '.$image.'"></i></button>';
									echo '</tr>';
									$subtotal=$subtotal+$valor;
									$faltas=0; $totals=0; $j++;
								}
							}
							echo '<tr>';
								echo '<td colspan="8"><div align="right">Total de la nomina:&nbsp;</div></td>';
								echo '<td style="width:10%"><div align="right">'.number_format($subtotal, 2, ',', '.').'&nbsp;&nbsp;<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;</div></td>';
							echo '</tr>';
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<script>document.title = "Visteseg | Detalle de Nominas"</script>
<script src="plugins/sweetalert/sweetalert.min.js"></script>
<script type='text/javascript'><!--
	function btn_EnviarOnClick($id, $is_active, $monto) {
		 var valor = 1;
		 var copia = <?php echo $_SESSION['is_admin']; ?>;

		 if(valor == "0"){
			 sweetAlert('No autorizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
		 	if($is_active == "1"){
				window.location.href = "./index.php?view=cobnom.detalle&idperson="+$id+"&estado="+$is_active+"&monto="+$monto;
			}else {
				window.location.href = "./index.php?view=cobnom.detalle&idperson="+$id+"&estado="+$is_active+"&monto="+$monto;
			}
		 }

	} //--
</script>