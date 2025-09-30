<?php

if(isset($_GET['ano'])){	
	$ano = $_GET['ano'];
}else{
	$ano = date("Y");
}

if(isset($_GET['mes'])){
	$mes = str_pad($_GET['mes'], 2, "0", STR_PAD_LEFT);
}else{
	$mes = '00';
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>listado de prestamos</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
		<li class="active"> Prestamos </li>
	</ol>
</section>
<!-- Main content --> 
<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<label>Adicionales de:&nbsp;
				<select id="mes_id" name="mes_id" class="form-control" onchange="javascript:location.href='index.php?view=rrhpre.lista&mes='+value;">
					<option value= "0" <?php if($mes == '00') echo 'selected'; ?>>Seleccione</option>
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
				<select id="ano_id" name="ano_id" class="form-control" onchange="javascript:location.href='index.php?view=rrhnom.lista&ano='+value;">
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
			<a id="btn_productos" class="btn btn-success btn-sm" onClick="btn_NuevoOnClick();">
				<span class="glyphicon glyphicon-plus"></span> Ingresar agente
			</a>
		</div>
		<div class="box-body mailbox-messages">
			<table id="viewlista" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th>Nombre Completos</th>
					<th><div align="center">C.C.</div></th>
					<th><div align="center">Descuento</div></th>
					<th><div align="center">Cuotas</div></th>
					<th><div align="center">Monto</div></th>
					<th><div align="center">Entregado</div></th>
					<th><div align="center">Activo</div></th>
					<th><div align="center"></div></th>
				</tr>
				</thead>
				<tbody>
					<?php
						$users = ReciboData::getAll($mes, $ano);

						// Crea tabla de Ventas
						foreach($users as $tables) {
							$cuotas = ReciboData::getAllPago($tables->id); 
							
							echo '<tr>';
								echo '<td width="26%">'.utf8_encode($tables->nombre).'</td>';
								echo '<td width="8%"><div align="center">'.$tables->idcard.'</div></td>';
								echo '<td>'.$tables->descripcion.'</td>';
								echo '<td width="8%"><div align="center">'.$tables->cuota.'</div></td>';
								echo '<td width="8%"><div align="right">'.$tables->monto.'</div></td>';
								echo '<td width="8%"><div align="center">'.$tables->entregado.'</div></td>';
								echo '<td width="8%">';
									echo '<small>';
									if($tables->is_active == 1){
										echo '<span class="glyphicon glyphicon-ok-sign text-success"></span>&nbsp;';
										echo '<span class="text-success">Activo</span>';
									}else{
										echo '<span class="text-danger glyphicon glyphicon-minus-sign"></span>&nbsp;';
										echo '<span class="text-danger">Inactivo</span>';
									}
									echo '</small>';
								echo '</td>';
								echo '<td>';
									echo '<div align="center">&nbsp;&nbsp;<a href="index.php?view=rrhpre.recibo&id='.$tables->id.'" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-edit"></i></a></div>';
								echo '</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div> 	<!-- /.box-body --> 
	</div>	<!-- /.box -->
</section>	<!-- /.content -->
<script>document.title = "Listado de Adicionales"</script>
<script type='text/javascript'><!--
	function btn_EnviarOnClick($valor) {
		 var f = document.frmC;
		 var idrol = f.hid_frmIdrol;
		 
		 alert('aaaaa');
		 if(idrol > 3){
			 sweetAlert('No autrizado...!!!', 'Usted no tiene permisos para eliminar registros', 'error');
		 }else{
			 swal({
					title: 'Confirm',
					text: 'Are you sure to delete this message?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#987463',
					timer: 1500
			 });
		 }
	} //--

	function btn_NuevoOnClick() {
		window.location.href = "./index.php?view=rrhpre.recibo";
	} //
</script>
