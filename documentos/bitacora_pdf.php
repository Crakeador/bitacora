<?php
//Reporte de la dotacion entregada a los Guardias
//header('Content-Type: text/html; charset=utf-8');
session_start();
include('conexion.php');
require('../plugins/fpdf/html_table.php');

$query='';
$guardia = 99;

if($_GET['id'] == 0)
    $puesto = "";
else
    $puesto = "AND A.idpuesto = ".$_GET['id'];

if($_GET['turno'] == 0)
    $turno = "";
else
    $turno = "AND A.turno = ".$_GET['turno'];

if($_GET['ini']!="")
    if($_GET['fin']!="")
        $fecha = "AND fecha BETWEEN '".date("Y-m-d",strtotime($_GET['ini']))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($_GET['fin'])))." 00:00:00'";
    else
        $fecha = "AND fecha BETWEEN '".date("Y-m-d",strtotime($_GET['ini']))." 00:00:00' AND '".date("Y-m-d", strtotime("+1 day", strtotime($_GET['ini'])))." 00:00:00'";
else
    $fecha = "";

$mysqli = getConn();

//mysqli_query("SET NAMES 'utf8'",$mysqli);
$query .= "SELECT B.name, B.lastname, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C ";
$query .= "WHERE A.idperson = B.id AND A.idpuesto = C.id ".$puesto." AND A.proceso = 2 ".$turno." ".$fecha." ORDER BY fecha DESC";

$result = $mysqli->query($query);

if (empty($result)){
	echo '<script>alert(\'No hay productos asociados a los guardias\'+\''.$query.'\')</script>';
	echo '<script>window.close();</script>';
	exit;
}else{
  $pdf = new PDF();
  $pdf->SetAuthor('Near Solutions c.a.');
  // First page
  $pdf->AliasNbPages();
  $i=1;
  // Generar la Tabla
  while($row = $result->fetch_array(MYSQLI_ASSOC)){
      if($guardia == $row['idperson']){
			$pdf->Cell(40,5, $row['fecha'], 1,0,'C',0);
			$pdf->Cell(140,5, htmlentities($row['observacion']), 1, 0,'L');
			$pdf->Ln(); $i++;
      }else{
		$guardia = $row['idperson'];

		if($i < 28){
			for($ii = 0; $ii <= (28-$i); $ii ++){
				$pdf->Cell( 40,5, '', 1, 0,'C', 0);
				$pdf->Cell(140,5, '', 1, 1,'C');
			}
			$i=1;
		}
		$pdf->Text( 26, 230, 'Entrega:');
		$pdf->Text( 26, 244, '-----------------------------');
		$pdf->Text(120, 244, '-----------------------------');
		$pdf->Text(120, 230, 'Recibe:');
		$pdf->Text( 26, 250, 'Agente Seguridad');
		$pdf->Text(120, 250, 'Supervisor');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        // Movernos a la derecha
        $pdf->Cell(80);
        // Título
        // $pdf->Text(56, 36,'BITACORA');
        // Salto de línea
        $pdf->Ln(30);
        $pdf->SetLeftMargin(5);
        $pdf->SetFontSize(10);
        $pdf->Text( 26, 45, ' Puesto: '.$row['descripcion'].' ('.$row['codigo'].')');
        $pdf->Text( 26, 50, 'Guardia: '.$row['name'].' '.$row['lastname'].' ('.$row['turno'].')');
        $pdf->SetFont('Arial', 'B',10);
        $pdf->SetXY(5,70);
        $pdf->SetY(70); //distancia de la brra que dice datos estuiante con el borde superior
        $pdf->SetFillColor(232,232,232);
        $pdf->SetXY(20,55);
        $pdf->Ln();

        $pdf->SetLeftMargin(18);
        $pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
        $pdf->Cell(40,5,'FECHA',1,0,'C',1);
        $pdf->Cell(140,5,'NOVEDAD PRESENTADA',1,0,'C',1);
        $pdf->SetTextColor(0,0,0); //color texto de la barra NEGRO
        $pdf->SetFont('Arial','B',11);
        $pdf->Ln();
      }
  }
	if($i < 28){

		for($ii = 0; $ii <= (28-$i); $ii ++){

			$pdf->Cell( 40,5, '', 1, 0,'C', 0);
			$pdf->Cell(140,5, '', 1, 1,'C');
		}

	}

	// $pdf->Text( 26, 220, 'Para validez de lo entregado firman ambas partes.');
	$pdf->Text( 26, 230, 'Entrega:');
	$pdf->Text( 26, 244, '-----------------------------');
	$pdf->Text(120, 244, '-----------------------------');
	$pdf->Text(120, 230, 'Recibe:');
	$pdf->Text( 26, 250, 'Agente Seguridad');
	$pdf->Text(120, 250, 'Supervisor');
	$pdf->Output();
}

mysqli_close($mysqli);

