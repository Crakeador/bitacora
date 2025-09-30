<?php
// Listado de los calculos de las nominas
$client = ClientData::getTotal(); 
$inic = ''; $finc = '';

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

if(isset($_GET['client'])) {
	$cliente = $_GET['client'];
	$users = PuestoData::getByIdCliente($_GET['client'], 3, 1, $ano.'-'.$mes.'-01', $ano.'-'.$mes.'-30');
	
	$datos = ClientData::getById($cliente);
	$_SESSION['cliente'] = $cliente; 
	
	// Proceso de Generacion de la nomina
	$fecha = date("Y-m-d");
	$ano = date('Y', strtotime($fecha));
	$mes = date('m', strtotime($fecha));
		
	if(intval($datos->ini_fac) > 0){
		$dia  = $datos->ini_fac;
	}else{
		$dia  = '01';
	}
	$_SESSION['diai'] = $dia;
	$inic = $dia.'-'.$mes.'-'.$ano;
	
	if(intval($datos->fin_fac) > 0){
		if(intval($dia) > $datos->fin_fac){
			$hoy = $ano.'-'.$mes.'-'.$dia;
			$mesf = date('m', strtotime("+30 day", strtotime($hoy)));
		}else{
			$mesf = $mes;
		}
		$_SESSION['mesf'] = $mesf;
		$dia  = $datos->fin_fac;
	}else{
		$dia  = '30';
	}		
	$_SESSION['diaf'] = $dia;
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

if($_SESSION['tipo'] == 3)
	$users = NominaData::getAllGuardias($ano, $mes, $tipo, $cliente);		
else
	$users = NominaData::getAllTotal($ano, $mes, $tipo, $cliente);

$resultado = count($users);
$j=1; $subtotal=0;

$fecha=$ano."-".$mes."-01";
$total=date("t", strtotime($fecha));
$dia=date("w", strtotime($fecha));
$final=$ano."-".$mes."-".$total;

if(!isset($_SESSION['diai'])) $_SESSION['diai'] = '01';
if(!isset($_SESSION['diaf'])) $_SESSION['diaf'] = '30';
if(!isset($_SESSION['mesf'])) $_SESSION['mesf'] = $_SESSION['mes'];

//var_dump($_SESSION);
?>
<section class="content-header">
    <h1>
        Talento Humano
        <small>resumen de ingresos y egresos por empleado</small>
    </h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Registro de Nomina </li>
	</ol>
	<div class="col-lg-12">
	</div>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
	<input type='hidden' name='hid_inic' id='hid_inic' value='<?php echo $inic; ?>'/>
	<input type='hidden' name='hid_finc' id='hid_finc' value='<?php echo $finc; ?>'/>
	<div class="box">
		<div class="box-header with-border">
			<?php
				if($resultado > 0){
				    // echo '<button type="button" class="btn btn-danger btn-sm" onClick="javascript:location.href=\'index.php?action=calcula&ano='.$_SESSION['ano'].'&mes='.$_SESSION['mes'].'\';"><i class="fa fa-calculator"></i> Recalcula Nomina </button>';
				}else{
				    echo '<button type="button" class="btn btn-success btn-sm" onClick="javascript:location.href=\'index.php?action=nomina&ano='.$_SESSION['ano'].'&mes='.$_SESSION['mes'].'\';"><i class="fa fa-refresh"></i> Generar Nomina </button>';
				}
                //RECALCULAR				    
				//echo '<a href="#" id="calcula" class="btn btn-danger btn-sm button"><i class="fa fa-calculator"></i>&nbsp; Recalcular Nomina </a>';
				//cALCULO    
				//echo '<a href="#" id="nomina" class="btn btn-success btn-sm button"><i class="fa fa-users"></i>&nbsp; Generar Nomina </a>';
			?>
			<!-- button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarQuincena();"><i class="fa fa-refresh"></i> Generar Quincena</button -->
			<button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarRecibo();"><i class="fa fa-print"></i> Generar Recibos</button>
			<!-- button type="button" class="btn btn-default btn-sm" onClick="btn_EnviarMovilizacion();"><i class="fa fa-motorcycle"></i> Generar Recibos</button -->
			<div id="content"></div>
			</br></br>
			<label> Cliente: </label>
			<select class="select-input form-control input-sm" id="idclient" name="idclient" onchange="javascript:location.href='index.php?view=rrhnom.lista&client='+value;">
				<option value="0" selected="selected"> Selecione... </option>
				<?php
					foreach($client as $clients): ?>
						<option value="<?php echo $clients->idclient; ?>" <?php if($clients->idclient == $cliente) echo 'selected="selected"'; ?>><?php echo $clients->nombre; //utf8_encode($clients->nombre) ?></option> 
					<?php endforeach;	
				?>
			</select>	
		</div>
		<div class="box-body mailbox-messages">
			<div class="row">
				<div class="col-sm-6">
					<div class="dataTables_length" id="example_length">						
						<?php 					
							if($_SESSION['diai'] > $_SESSION['diaf']){
								$hoy = $ano.'-'.$mes.'-'.$_SESSION['diai'];
								$mesf = date('m', strtotime("+30 day", strtotime($hoy)));
							}else{
								$mesf = $mes;
							}
							
							$_SESSION['mes'] = str_pad($mes, 2, "0", STR_PAD_LEFT);
							$_SESSION['mesf'].'-'.str_pad($mesf, 2, "0", STR_PAD_LEFT);
							
							
							$inicio = $_SESSION['diai'].'-'.str_pad($mes, 2, "0", STR_PAD_LEFT).'-'.$_SESSION['ano'];
							$final = $_SESSION['diaf'].'-'.str_pad($mesf, 2, "0", STR_PAD_LEFT).'-'.$_SESSION['ano'];
							
							if(isset($_SESSION['diai'])) 
								echo 'Inicio: '.$inicio.' Fin: '.$final; 
							else 
								echo 'Inicio: 00-00-0000 Fin: 00-00-0000'; 
								
							$_SESSION['inicia']=$inicio; $_SESSION['finala']=$final;
						?>&nbsp;&nbsp;
						<label>Nomina de:&nbsp;
							<select style="width: 120px; display: inline-block;" id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='index.php?view=rrhnom.lista&mes='+value;">
                                <option value= "1" <?php if($mes == '01') echo 'selected'; ?>>Enero</option>
								<option value= "2" <?php if($mes == '02') echo 'selected'; ?>>Febrero</option>
								<option value= "3" <?php if($mes == '03') echo 'selected'; ?>>Marzo</option>
								<option value= "4" <?php if($mes == '04') echo 'selected'; ?>>Abril</option>
								<option value= "5" <?php if($mes == '05') echo 'selected'; ?>>Mayo</option>
								<option value= "6" <?php if($mes == '06') echo 'selected'; ?>>Junio</option>
								<option value= "7" <?php if($mes == '07') echo 'selected'; ?>>Julio</option>
								<option value= "8" <?php if($mes == '08') echo 'selected'; ?>>Agosto</option>
								<option value= "9" <?php if($mes == '09') echo 'selected'; ?>>Septiembre</option>
								<option value="10" <?php if($mes == '10') echo 'selected'; ?>>Octubre</option>
								<option value="11" <?php if($mes == '11') echo 'selected'; ?>>Noviembre</option>
								<option value="12" <?php if($mes == '12') echo 'selected'; ?>>Diciembre</option>
							</select>
						</label>&nbsp;&nbsp;
						<label>Año:&nbsp;
							<select style="width: 120px; display: inline-block;" id="ano_id" name="ano_id" class="form-control" onchange="javascript:location.href='index.php?view=rrhnom.lista&ano='+value;">
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
							<select id="tipo_id" name="tipo_id" class="form-control" onchange="javascript:location.href='index.php?view=rrhnom.lista&tipo='+value;">
								<option value="1" <?php if($tipo == 1) echo 'selected'; ?>>Administrativo</option>
								<!-- <option value="2" <?php if($tipo == 2) echo 'selected'; ?>>Operativo</option> -->
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
							<th style="width:8%"><div align="center">Nro.</div></th>
							<th><div align="center">Apellidos y Nombres</div></th>
							<th style="width:10%"><div align="center">Ingreso</div></th>
							<th><div align="center">Cuenta</div></th>
							<th style="width:7%"><div align="center">Nro. Falta</div></th>
							<th style="width:7%"><div align="center">Dias</br>trabajados</div></th>
							<th style="width:7%"><div align="center">Total</br>ingresos</div></th>
							<th style="width:7%"><div align="center">Total</br>egresos</div></th>
							<th style="width:7%"><div align="center">Total</br>liquido</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($resultado > 0){
								foreach($users as $tables) {
									$id = $tables->id;										
									$servicio = $tables->idservicio;
									$puesto = $tables->puesto;
									$idcard = $tables->idcard;
									$nombre = $tables->lastname.' '.$tables->name; 
									$cargo = $tables->description;
									//$inicio = $tables->startwork;

									$diassm = 0; $nochem = 0; $totalm = 0; $valor = 0; 
									$diasla = 0; $nochel = 0; $totals = 0; $libret = 0; $diasnd = 0;
									$diassd = 0; $noched = 0; $faltas = 0; $libres = 0; 					
									
									//echo $id.' '.count(PuestoData::getByLibre($id));
									//if($_SESSION['tipo'] == 3){
										$valor=HorarioData::getByIdHorario($servicio, $id, $mes, $ano, 2);

										$diasla=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 1)); //dia
										$nochel=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 2)); //noche
										$libres=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 3)); //libre
										$faltas=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 4)); //falta
										$libret=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 5)); //libre trabajado										
										$diasnd=count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 6)); //libre trabajado
										if($diasnd > 0) $diasnd = $diasnd * 2;
										$diasla=$diasla+count(HorarioData::getTurnoTotal($_SESSION['cliente'], $id, $mes, $ano, 2, 7)); //libre trabajado
										
										if(count(PuestoData::getByLibre($id)) == 1){
											$tipo = 'Agente'; 
										}else{
											$tipo = 'Saca Franco'; 										
										}				

										$totals = $diasla+$nochel+$libres+$libret+$diasnd;										
										$totala = $libret+($noched+$diassd);
										$totalm = $diassm+$nochem;					
									/*}else{
										$valor = 0;
										$tipo = 'Administrativo'; 
										
										$totals = 30; $faltas = 0;
									} */
									
									$rubro = NominaData::getAll($cliente, $id, $ano, $mes); // Calculo de los rubros
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
									
									if($totals == 28 && $mes == 2) $totals = 30;
									if($tables->banco == 0) {
									    $cadena = 'Sin cuenta definida'; 
									}else {
									    $banco=BancoData::getById($tables->banco);
									    $cadena = $banco->description;
									}
									echo '<tr>';
										echo '<td><div align="center">
													<a href="?view=rrhnom.detalle&id='.$id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a> 
													<button type="button" class="btn btn-xs btn-danger" onClick="btn_UpdateOnClick('.$id.', \''.$mes.'\', \''.$ano.'\');"><i class="fa fa-calculator"></i></button>
													<button type="button" class="btn btn-xs btn-warning" onClick="btn_ImprimeRecibo('.$id.');"><i class="fa  fa-print"></i></button>
												  </div></td>';
										echo '<td>';
											echo '<small>';
												echo '('.str_pad($j, 3, "0", STR_PAD_LEFT).') '.$nombre.'</br>'; //utf8_encode($nombre)  ('.$tables->id.')
												echo $tipo;
											echo '</small>';
										echo '</td>';
										echo '<td style="width: 7%"><div align="center">'.$tables->startwork.'</div></td>';
										echo '<td>'.$cadena.'</br><small>Cuenta: '.$tables->cuenta.'</small></td>';
										echo '<td style="width: 7%"><div align="center">'.$faltas.'</div></td>';
										echo '<td style="width: 7%"><div align="center">'.$totals.'</div></td>';
										echo '<td style="width: 7%"><div align="right">'.number_format($ingreso, 2, ',', '.').'</div></td>';
										echo '<td style="width: 7%"><div align="right">'.number_format($egresos, 2, ',', '.').'</div></td>';
										echo '<td style="width: 7%"><div align="right">'.number_format($valor, 2, ',', '.').'</div></td>';
									echo '</tr>';
									$subtotal=$subtotal+$valor;
									$faltas=0; $totals=0; $j++;
								}
							}
							echo '<tr>';
								echo '<td colspan="8"><div align="right">Total de la nomina:&nbsp;</div></td>';
								echo '<td style="width:10%"><div align="right">'.number_format($subtotal, 2, ',', '.').'</div></td>';
							echo '</tr>';
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript">
	document.title = "Near Solutions | Listado del personal"
	
	function btn_EnviarRecibo() {
		VentanaCentrada('documentos/res/cotizacion_html.php','Recibos de Pago','','1024','768','true');
	}
	
	function btn_ImprimeRecibo(id) {
        VentanaCentrada("documentos/res/recibo_html.php?id="+id, "Recibos de Pago", "", "1024", "768", "true");
    } // Imprecion de los recibos
		
	function btn_UpdateOnClick($id, $mes, $ano) {
		let contenedor = document.querySelector('#content');
		console.log('has hecho click en algo!');
		
		window.location.href = "./index.php?action=recalcular&id="+$id+"&mes="+$mes+"&ano="+$ano;
	} //
	
	$(document).ready(function() {    
        $('#calcula').on('click', function(){
			$id = $('#idclient').val();			
			$ini = $('#hid_inic').val();
			$fin = $('#hid_finc').val();
			$mes = $('#mes_id').val();
			$ano = $('#ano_id').val();
			
			console.log('Recalcular: '+$id+' '+$mes+' '+$ano+' '+$ini+' '+$fin);
            // Agrega la imagen de carga en el contenedor 
            $('#content').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor estamos calculando...!!!</div>');

            $.ajax({
                type: "POST",
                url: "ajax/calcular.php?id="+$id+"&mes="+$mes+"&ano="+$ano+"&ini="+$ini+"&fin="+$fin,
                success: function(data) {
                    sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');
                    /* Cargamos finalmente el contenido deseado */
					$('#content').fadeIn(1000).html(data); 
					//window.location="index.php?view=rrhnom.lista&mes="+$mes; 
                }
            });
            return false;
        });

		$('#nomina').on('click', function(){
			$id = $('#idclient').val();			
			$ini = $('#hid_inic').val();
			$fin = $('#hid_finc').val();
			$mes = $('#mes_id').val();
			$ano = $('#ano_id').val();
			
			console.log('Nomina: '+$id+' '+$mes+' '+$ano+' '+$ini+' '+$fin);
            // Agrega la imagen de carga en el contenedor 
            $('#content').html('<div class="loading col-lg-12"><img src="assets/images/esperar.gif"/><br/>Un momento, por favor espere...!!!</div>');

            $.ajax({
                type: "POST",
                url: "ajax/nomina.php?id="+$id+"&mes="+$mes+"&ano="+$ano+"&ini="+$ini+"&fin="+$fin,
                success: function(data) {
                    sweetAlert('Excelente', 'Se genero la nomina correctamente...!!!', 'success');
                    /* Cargamos finalmente el contenido deseado */
					$('#content').fadeIn(1000).html(data); 
					window.location="index.php?view=rrhnom.lista&mes="+$mes; 
                }
            });
            return false;
        });
    });
</script>