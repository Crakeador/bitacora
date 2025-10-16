<?php
setlocale(LC_ALL, 'es_ES');
session_start();
include('../core/controller/Database.php');
require('../plugins/fpdf/fpdf.php');

$meses = array("", "ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
 
class PDF extends FPDF
{
	function Header()
	{
		// Logo
		//$this->Image('../assets/images/logo-recibo.png',10,6,30);
		//$this->Image('../assets/images/logo-recibo.png',258,6,30);
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->SetTextColor(220, 50, 50);
		$this->Cell(120);
		$this->Cell(40,10,'GLOBAL PROTECTION SECURITY GPS CIA. LTDA.',0,0,'C');
		$this->SetTextColor(0, 0, 0);
		$this->Ln(5);
		$this->Cell(120);
		$this->SetFont('Arial', '',12);
		$this->Cell(30,10,'ALBORADA 10ma ETAPA MZ 210 VILLA 11',0,0,'C');
		$this->Ln(5);
		$this->Cell(120);
		$this->SetFont('Arial', '',12);
		$this->Cell(30,10,'QUINCENA '.$_SESSION['pagado'].' '.$_SESSION['ano'],0,0,'C');
		$this->Ln(20);
	}
	
	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}	
}

$ano = $_SESSION['ano']; 
$mes = (int) $_SESSION['mes'];
$tipo = $_SESSION['tipo'];

$fecha=$ano."-".$mes."-01";
$_SESSION['pagado']=$meses[$mes];

$base = new Database();
$con = $base->connect();

$sql = 'SELECT C.idservicio, D.descripcion, E.descripcion lugar FROM nomina A, person B, personpuestos C, puestos D, localidad E, cargo F ';
$sql .= 'WHERE A.person = B.id AND B.cargo = F.id AND B.id = C.idperson AND C.idservicio = D.id AND D.idlugar = E.id AND A.mes = '.$mes.' AND A.ano = '.$ano.' AND B.company = '.$_SESSION['id_company'].' AND F.idtipo = '.$tipo.' GROUP BY C.idservicio ORDER BY E.descripcion, D.descripcion ';
$lugares = $con->query($sql);

if (empty($lugares)){
	echo '<script>alert(\'No hay productos agregados a la cotizacion\')</script>';
	echo '<script>window.close();</script>';
	exit;
}else{
	$pdf = new PDF('L');
	$pdf->AliasNbPages();
	$pdf->SetFont('Times','',12);
	
	$i=1; $titulo='';
	
	while($r = $lugares->fetch_array()){	
		//var_dump($r);
		$pdf->AddPage();
		$pdf->Cell(0,10,$r['descripcion'].' ('.$r['lugar'].')',0,1);

		$sql2 = 'SELECT C.id, C.idcard, C.name, C.startwork, D.description, A.monto ';
		$sql2 .=  'FROM nomina A, rubro B, person C, cargo D, personpuestos E, puestos F ';
		$sql2 .= 'WHERE A.mes = '.$mes.' and A.ano = '.$ano.' and A.rubro = B.id and A.person = C.id and C.cargo = D.id and ';
		$sql2 .=       'A.person = E.idperson and E.idservicio = F.id and D.idtipo = '.$tipo.' and C.company = '.$_SESSION['id_company'].' and ';
		$sql2 .=       'A.rubro = 11 and E.idservicio = '.$r['idservicio'].' ORDER BY F.descripcion, C.name';
		$persons = $con->query($sql2);

		$pdf->SetFont('Arial','',9);

		// Column widths
		$header = array('Nro.', 'APELLIDOS Y NOMBRES', 'CEDULA', 'CARGO', 'INGRESO', 'QUINCENA', 'FIRMA');
		$w = array(10, 100, 30, 40, 25, 25, 45);
		// Header
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
		$pdf->Ln();

		$j=1;
		while($row = $persons->fetch_array()){	
			$pdf->Cell($w[0],6,$j,'LR',0,'R');
			$pdf->Cell($w[1],6,$row[4].' '.$row[5].' '.$row[2].' '.$row[3],'LR');
			$pdf->Cell($w[2],6,$row[1],'LR',0,'C');
			$pdf->Cell($w[3],6,$row[7],'LR');
			$pdf->Cell($w[4],6,$row[6],'LR',0,'C');
			$pdf->Cell($w[5],6,'$ '.number_format($row[8]),'LR',0,'R');
			$pdf->Cell($w[6],6,'    ','LR',0,'R');
			$pdf->Ln(); 
			// Closing line
			$pdf->Cell(array_sum($w),0,'','T');
			$pdf->Cell(-275);
			$j++;
		} 
	} 

	$pdf->Output(); 
}