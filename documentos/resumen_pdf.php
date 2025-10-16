<?php
//Reporte de la dotacion entregada a los Guardias
session_start();
include('conexion.php');
require('../plugins/fpdf/html_table.php');

$html='';
$mysqli = getConn();
$query = "SELECT A.*, B.idcard, B.name, C.description, E.descripcion 
            FROM sell A, person B, cargo C, personpuestos D, puestos E 
           WHERE A.person_id = B.id AND B.idcargo = C.id AND D.idperson = A.person_id AND D.idservicio = E.id AND A.id = ".$_GET['id'];
$result = $mysqli->query($query);

if (empty($result)){
	echo '<script>alert("'.$query.'")</script>'; //No hay productos asociados a los guardias
	//echo '<script>window.close();</script>';
	//exit;
}else{
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$venta = $row['id'];
		$nombre = $row['name'];
		$cedula = $row['idcard'];
		$entrega = $row['created_at'];
		$cargo = $row['description'];
		$contrato = $row['descripcion'];
	}
	if(!isset($venta)){
		echo '<script>alert("'.$query.'")</script>'; //\'No hay productos asociados a los guardias\
		//echo '<script>window.close();</script>';
		//exit;
	}

	$sql = "SELECT A.*, B.description FROM operation A, product B ";
	$sql .= "WHERE A.product_id = B.id AND A.sell_id=$venta ORDER BY created_at DESC";
	$result = $mysqli->query($sql);
	
	if($_SESSION["valor"] == 1) $nombre = $_SESSION["puesto"]; 

	$pdf = new PDF();
	$pdf->SetAuthor('Near Solutions c.a.');
	// First page
	$pdf->AliasNbPages();
	$pdf->AddPage();	
	// Arial bold 15
	$pdf->SetFont('Arial','B',16);
	// Movernos a la derecha
	$pdf->Cell(80);
	// Título
	$pdf->Text(56, 36,'ACTA DE ENTREGA DE DOTACIONES');
	// Salto de línea
	$pdf->Ln(30);
	$pdf->SetLeftMargin(5);
	$pdf->SetFontSize(10);		
	$pdf->Text( 26, 45, 'Nombre: '.$nombre);
	$pdf->Text( 26, 50, 'Numero de cedula: '.$cedula);
	$pdf->Text( 26, 55, 'Fecha de entrega: '.$entrega);
	$pdf->Text( 26, 60, 'Cargo asignado: '.$cargo);
	$pdf->Text( 26, 65, 'Contrato: '.$contrato);
	$pdf->SetFont('Arial', 'B',10);
	$pdf->SetXY(5,70);
	$pdf->SetY(70); //distancia de la brra que dice datos estuiante con el borde superior	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetXY(20,70);
	$pdf->Ln(); 
	
	$pdf->SetLeftMargin(18);
	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
	$pdf->Cell(20,5,'UNID',1,0,'C',1);
	$pdf->Cell(100,5,'DESCRIPCION DEL PRODUCTO',1,0,'C',1);
	$pdf->Cell(60,5,'OBSERVACION',1,0,'C',1);
	$pdf->SetTextColor(0,0,0); //color texto de la barra NEGRO
	$pdf->SetFont('Arial','B',11);
	$pdf->Ln(); 

	$i=1;
	// Generar la Tabla
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$pdf->Cell(20,5, $row['q'], 1,0,'C',0);
		$pdf->Cell(100,5, utf8_decode($row['description']), 1, 0,'L');
		$pdf->Cell(60,5, "S/N", 1, 0,'C');
		$pdf->Ln(); $i++;
	}
	
	if($i < 28){
		for($ii = 0; $ii <= (28-$i); $ii ++){
			$pdf->Cell( 20,5, '', 1, 0,'C', 0);
			$pdf->Cell(100,5, '', 1, 0,'L');
			$pdf->Cell( 60,5, '', 1, 1,'C');
		}
	}		
	$pdf->Text( 26, 220, 'Para validez de lo entregado firman ambas partes.');

	$pdf->WriteHTML($html);
	$pdf->Text( 26, 230, 'Entrega:');
	$pdf->Text( 26, 244, '-----------------------------');
	$pdf->Text(120, 244, '-----------------------------');
	$pdf->Text(120, 230, 'Recibe:');
	$pdf->Text( 26, 250, 'LOGISTICA');
	$pdf->Text(120, 250, $cargo);
	$pdf->Output(); 
}

mysqli_close($mysqli);
