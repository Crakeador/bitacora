<?php
setlocale(LC_ALL, 'es_ES');
session_start();

include('../core/controller/Database.php');
require('../plugins/fpdf/fpdf.php');

class PDF extends FPDF{
	function Header(){
		// Logo
		$this->Image('../assets/images/parte.jpg',0, 0, 214);
		$this->SetFont('Arial','B',15);
	}

	// Page footer
	function Footer(){
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}	
}

$base = new Database();
$con = $base->connect();
$sql = "UPDATE cotizacion SET status=3 WHERE id = ".$_GET["id"];
$con->query($sql);

$sql = "SELECT A.* FROM cotizacion A WHERE A.id = ".$_GET["id"];
$coriza = $con->query($sql);

if (empty($coriza)){
	echo '<script>alert(\'No hay productos agregados a la cotizacion\')</script>';
	echo '<script>window.close();</script>';
	exit;
}else{
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetFont('Times','',12);
	$pdf->AddPage();

	while($r = $coriza->fetch_array()){
		// Salto de línea
        $pdf->SetFont('Arial', 'B',11);
        $pdf->Text(136, 20, 'COTIZACION Nro. '.$r['oficio']);
        $pdf->Ln(30);
        $pdf->SetLeftMargin(5);
        $pdf->SetFontSize(10);
        $pdf->Text( 26, 40, '   FECHA: '.$r['ini_fec']);
        $pdf->Text( 26, 45, 'CLEINTE: '.$r['contacto']);
        $pdf->Text( 26, 50, 'ASUNTO: '.$r['asunto']);
        $pdf->SetFont('Arial', 'B',10);
        $pdf->SetXY(5,70);
        $pdf->SetY(70); //distancia de la barra que dice datos estuiante con el borde superior
        $pdf->SetFillColor(232,232,232);
        $pdf->SetXY(20,60);
        $pdf->Ln();

        $pdf->SetLeftMargin(18);
        $pdf->SetTextColor(255,255,255); //color texto de la barra BLANCO		
    	$pdf->SetFillColor(0,0,0);
        $pdf->SetFont('Arial','B',16); //si colocara antes de B que es para negrita colocara U saliera subrayado
        $pdf->Cell(180,10,'COTIZACION',1,0,'C',TRUE);
        $pdf->SetFont('Arial','B',11);
        $pdf->Ln();
		
    	$pdf->SetLeftMargin(18);
        $pdf->SetTextColor(0,0,0); //color texto de la barra BLANCO	
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','B', 8); 
    	$pdf->Cell( 20,10,'ITEM',1,0,'C',1);
    	$pdf->Cell(100,10,'DESCRIPCION',1,0,'C',1); 
    	$pdf->Cell( 20,10,'',1,0,'C',1); 
    	$pdf->Cell( 20,10,'',1,0,'C',1); 
    	$pdf->Cell( 20,10,'',1,0,'C',1); 
    	$pdf->Ln();

        $pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','B', 6); 
        $pdf->Text(140, 75, 'CANTIDAD DE');
		$pdf->Text(144, 77, 'PUNTOS');
        $pdf->Text(164, 75, 'VALOR');
		$pdf->Text(163, 77, 'UNITARIO');
        $pdf->Text(184, 75, 'VALOR');
		$pdf->Text(184, 77, 'TOTAL');
    	$pdf->Ln(); 
		
		$sql1 = "SELECT A.* FROM cotizaciond A WHERE A.idcotizacion = ".$_GET["id"];
		$detalle = $con->query($sql1);

		$pdf->SetXY(18,80);		
    	$pdf->SetFillColor(255,255,255);
		$i=1; $j=0; $total=0; $subtotal=0; 
		while($c = $detalle->fetch_array()){			
			if(strlen($c['descripcion'])<50) $cadena='                                ';
				
			$subtotal = $c['cantidad']*$c['monto'];
			$total = $total + $subtotal;
			$pdf->Cell( 20,10,$i,1,0,'C',1);
			$pdf->Cell(100,10,'',1,0,'C',1); 
			$pdf->Cell( 20,10,number_format($c['cantidad'], 2, ',', '.'),1,0,'C',1); 
			$pdf->Cell( 20,10,number_format($c['monto'], 2, ',', '.'),1,0,'C',1); 
			$pdf->Cell( 20,10,number_format($subtotal, 2, ',', '.'),1,0,'C',1); 
			$pdf->SetXY(40,80+$j);	
			$pdf->MultiCell(80, 5, utf8_decode($c['descripcion']).$cadena, 0, 'J');
			
			$j=$j+10; 			
			$i++; $subtotal=0;
		}
		if($i == 2) 
		    $pdf->SetXY(18, 80+$j);	
		else
		    $pdf->SetXY(18, 80+$j);		
		    
		//$pdf->SetXY(18, 120);	
		$pdf->Cell( 20,10,'',0,0,'C',0);
		$pdf->Cell(100,10,'',0,0,'C',0); 
		$pdf->Cell( 20,10,'',0,0,'R',0); 
		$pdf->Cell( 20,10,'Total '.$j,1,0,'C',1); 
		$pdf->Cell( 20,10,number_format($total, 2, ',', '.'),1,0,'C',1); 

		$j=$j+90;		
    	$pdf->SetFont('Arial','B',10);   
        $pdf->Text(26, $j, 'OBSERVACIONES');
		$sql2 = "SELECT B.name FROM observaciones A, operation_type B WHERE B.id = A.idoperation_type AND A.idcotizacion = ".$_GET["id"];
		$observa = $con->query($sql2);

    	$pdf->SetFont('Arial','',10);   
		$pdf->SetXY(18, 145);
		$i = 5;
		while($c = $observa->fetch_array()){
			$pdf->Text(26, $j+$i, '- '.utf8_decode($c['name']));
			$i=$i+6;
		}        
        $pdf->Text(26, 225, 'Atentamente,');
    	$pdf->Text(26, 240, '-----------------------------');
    	$pdf->Text(26, 245, 'Gilbert Rider Lerma Cabezas');
    	$pdf->Text(26, 250, 'Gerente General');
	} 

	$pdf->Output(); 
}
