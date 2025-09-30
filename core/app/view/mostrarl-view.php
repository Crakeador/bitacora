<?php 
$valores = PersonData::getByIdDatos($_GET["id"]);
$liquida = $_GET["id"];

var_dump($valores);

/*
if(isset($_POST["submit"])){
	$query = "UPDATE empleado SET nombre='".$_POST["cod"]."'";
	$result=mysql_query($query,$link) or die("Error: ".mysql_error());
	echo"</br>";
	echo"</br>";
	echo"<center>";
	echo "Se ha modificado el producto con exito ".$x1;
	echo"</center>";
}else{
	$x1=$_GET['codigo'];

	$query="SELECT * FROM empleados WHERE cod='".$x1."'";
	$result=mysql_query($query,$link) or die("Error: ".mysql_error());

}

$fechaf="select ultimal,fechai from empleados where cod='".$x1."'";
$suma2 = $conexion->query($fechaf);

if (!$suma2) {
    echo 'No se pudo ejecutar la consulta: ';
    exit;
}
$fila = $suma2-> fetch_row();
$fechaff = $fila[0]; // el valor que quiero 
$fechaii = $fila[1]; // 

if($fechaff==""){
	$fechaff=$fecha;
}
	
$fecha111= $fechaff;
$fecha222=date("Y-m-d",strtotime($fecha111)); 
	
//$rango="SELECT * FROM empleados,salario WHERE fechai BETWEEN '2014-01-1 13:40:41' AND '2016-04-06 13:40:41'"; //buscar lista por fecha

$salario="SELECT * FROM empleados,salario WHERE cod='".$x1."' and  fechai and fechaf BETWEEN '$fechaii' AND '$fecha222' order by id";
$result2=mysql_query($salario,$link) or die("Error: ".mysql_error());
		
date_default_timezone_set('America/caracas');
$hora = date('H:i:s a');
$fecha = date('d-m-Y ');
$aaaa= date('Y');

$x1=$_GET['codigo'];

$query="select * from empleados,liquidacion where cod='".$x1."' and codigo='".$x1."'  order by id asc limit 1 ";

//$query="SELECT * FROM empleados,liquidacion WHERE cod='".$x1."' and codigo='".$x1."'";
$result=mysql_query($query,$link) or die("Error: ".mysql_error());
	 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Talento Humano
		<small>liquidaciones del Personal</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="./index.php?view=home"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<!-- Main content -->
<section class="content" style="padding: 1.5rem !important;"> 
    <div class="row">
		<div class="col-xs-4">
            <div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Datos Personales </h3>
					<div class="box-tools pull-right">
						<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<table id="datos" class="table table-bordered table-striped" >
						<tr>
							<td><label for="exampleInputFile">Cedula</label></td>
							<td><?php echo $valores->idcard; ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Nombre</label></td>
							<td><?php echo $valores->name; ?> </br></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Cargo</label></td>
							<td><?php  echo $valores->description; ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Puesto</label></td>
							<td><?php  echo $valores->descripcion; ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Causa</label></td>
							<td><?php  echo $valores->sueldo;  ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Sueldo</label></td>
							<td><?php  echo $valores->sueldo;  ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Fecha De Ingreso</label></td>
							<td><?php echo $valores->startwork; ?></td>
						</tr>
						<tr>
							<td><label for="exampleInputFile">Fecha De Salida</label></td>
							<td><?php echo $valores->endwork; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-xs-8">
 
 
                                  <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Liquidacion </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                      
                                    </div>
                                </div>

 <div class="box-body">
 <table  align="center" id="example1" class="table table-bordered table-striped" >
<thead    bgcolor="#999999">
 <tr>
 <td  align="center" width="10%">
	<label   for="exampleInputFile">Dias</label>
	</td>
	<td  align="center" width="10%">
	
<label for="exampleInputFile">Bs</label>
	</td>
	<td align="center">
	
<label   for="exampleInputFile">Descripcion</label>
	</td>
	<td  align="center" >
	
<label for="exampleInputFile">Total Bs</label>
	</td>
	</tr>
	</thead>
	<tr>
	<td align="center"><label for="exampleInputFile">--</label>
	</td><td align="center">
--
</td>
<td align="center">
<label for="exampleInputFile">Prestacion de Antiguedad (Art 142 L.O.T.T.T)</label>
</td>
<td align="center">
--
</td>
</tr>
<tr>
<td align="center">
<? 	
$tiempo=$Rs["tiempo"];
$sueldo=$Rs["sueldo"];



		
	$dia1= 15/12*$tiempo;
	echo $dia1;
?>
	</td>
	<td align="center">
	
<?	$bs1= $sueldo/30;
	echo round( $bs1,2);
	
?>
	</td>
	<td align="center">
<label for="exampleInputFile">Vacaciones Fraccionadas (Art 196 L.O.T.T.T)</label>

</td>
<td align="center"> 	
<?	$bs2= $dia1*$bs1;
	echo round( $bs2,2);
	
?>
</td>
</tr>

<tr>
<td align="center">
	<?	$dia2= 30/12*$tiempo;
	echo round( $dia2,2);
	
?>
	</td>
	<td align="center">
	<?	$bs3= $sueldo/30;
	echo round( $bs3,2);
	
?>
	
	
	</td>
	<td align="center">
<label for="exampleInputFile">Bono de Fin de A&ntilde;o</label>

</td>
<td align="center"> <?	$bs4= $dia2*$bs3;
	echo round( $bs4,2);
	
?>
</td>
</tr>

<tr>
<td align="center">
	
	<?php	
	$dia3= 15/12*$tiempo;
	echo $dia3;
?>
	</td>
	<td  align="center">
	<?php
	echo round( $bs3,2);
	?>
	
	</td>
	<td  align="center">
<label   for="exampleInputFile">Bono Vacacional Fraccionado (Art 196 L.O.T.T.T)</label>

</td>
<td align="center"> <?	$bs5= $dia3*$bs3;
	echo round( $bs5,2);
	
?>
</td>
</tr>

<tr>
<td align="center">
	--
	</td>
	<td align="center">
	--
	</td>
	<td align="center">
<label for="exampleInputFile">Intereses sobre Prestaciones Sociales (Art 143 L.O.T.T.T)</label>

</td>
<td align="center"> --
</td>
</tr>
 <tfoot  bgcolor="#999999">
<tr>
<td align="center">
	
	</td>
	<td align="center">
	
	</td>
	<td align="center">
<label for="exampleInputFile">Total</label>

</td>
<td align="center"> 

<?php
$total= $bs5+$bs4+$bs2;
echo round( $total,2);
echo '</td></tr>
</tfoot></table>';

?>
</div>

</div></div>

				

								
							
	</br>
	</br>
	
 <section class="content">
                    <div class="row">
					 
 <div class="col-xs-8">
	
	<center> 
<a href="<?php echo "../pdf/liquidacionpdf.php?codigo=".$x1.""; ?>" target="_blank" class="small-box-footer"><img src="../img/impresora.png"  width='50' height='50'  title="Imprimir" alt=""></a>
</center>

</div>
</div>

<?php
/*
	   
	}else{
		
		echo"<center>";
	    echo "No fu� posible realizar la operaci�n solicitada  ".$x1;
		echo"</center>";
	
	  echo"<center>";
  echo"<div class='button black'><a href='modificar.php'>Intentar nuevamente</a></div>";
   echo"</center>";
	}
}
*/
?>

</div>
</div>
</div>





<?php



include("pie.php");

?>