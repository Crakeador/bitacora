<?php

setlocale(LC_ALL, 'es_ES');

session_start();

include('../core/controller/Database.php');
require('../plugins/fpdf/fpdf.php');

class PDF extends FPDF{
	function Header()	{
		// Logo
		$this->Image('../assets/images/parte.png',0, 0, 214);
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->SetTextColor(220, 50, 50);
		$this->SetTextColor(0, 0, 0);
		$this->Ln(5);
		$this->Cell(90);
		$this->SetFont('Arial', '',20);
		$this->Cell(20,10,'PARTE INFORMATIVO',0,0,'C');
		$this->Ln(5);
		$this->Ln(20);
	}

	// Page footer
	function Footer(){
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}	
}

$base = new Database();
$con = $base->connect();

$sql = "SELECT B.name, C.descripcion, C.codigo, A.* FROM bitacora A, person B, puestos C 
         WHERE A.idperson = B.id AND A.idpuesto = C.id AND A.id = ".$_GET["id"];

$lugares = $con->query($sql);
if (empty($lugares)){
	echo '<script>alert(\'No hay productos agregados a la cotizacion\')</script>';
	echo '<script>window.close();</script>';
	exit;
}else{
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetFont('Times','',12);
	$pdf->AddPage();

	$i=1; $titulo='';
	while($r = $lugares->fetch_array()){
	    //echo '<script>alert(\'No hay productos agregados a la cotizacion\''.'../storage/parte/'.$r['foto1'].')</script>';
    	$pdf->SetLeftMargin(5);
    	$pdf->SetFontSize(10);

    	$pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
    	$pdf->Cell(40,5,'LUGAR:',1,0,'C',1);
    	$pdf->Cell(142,5,$r['codigo'],1,0,'L',1); //color texto de la barra NEGRO
    	$pdf->SetFont('Arial','B',11);
    	$pdf->Ln(); 

    	$pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
    	$pdf->Cell(40,5,'FECHA',1,0,'C',1);
    	$pdf->Cell(142,5,$r['fecha'],1,0,'L',1); //color texto de la barra NEGRO
    	$pdf->Ln();    	

    	$pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
    	$pdf->Cell(40,5,'DE:',1,0,'C',1);
    	$pdf->Cell(142,5,$r['name'].' '.$r['lastname'],1,0,'L',1); //color texto de la barra NEGRO
    	$pdf->Ln(); 

        $pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado

    	$pdf->Cell( 40,40,'DESCRIPCION DE',1,0,'C',1);
		$pdf->Cell(142,40,'',1,0,'L',1);
    	$pdf->Ln(); 

        $pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
    	$pdf->Cell( 40,40,'ACCIONES Y/O',1,0,'C',1);
    	$pdf->Cell(142,40,$r['accion'],1,0,'L',1); //color texto de la barra NEGRO
    	$pdf->Ln(); 
   	
    	$pdf->SetFont('Arial','B',11);
    	$pdf->Cell(0,10,'ADJUNTO DETALLES',1,0,'C',1);
    	$pdf->Ln();
    	$pdf->SetLeftMargin(18);
    	$pdf->SetFillColor(232,232,232);
    	$pdf->SetFont('Arial','',10); //si colocara antes de B que es para negrita colocara U saliera subrayado
    	$pdf->Cell(90,60,'FOTO 1',1,0,'C',0);
    	$pdf->Cell(92,60,'FOTO 2',1,0,'C',0); //color texto de la barra NEGRO
    	$pdf->Ln(); 
 	 	
        $pdf->Image('../storage/novedad/'.$r['foto1'],40,150,35);

        if($r['foto2'] == "")
            $pdf->Image('../assets/images/american.jpg',124,152,50);
        else
            $pdf->Image('../storage/novedad/'.$r['foto2'],120,150,35);
         
        $pdf->SetFont('Arial','',10);
    	$pdf->Text( 26, 80,'LA NOVEDAD:');
    	$pdf->Text( 22,120,'MEDIDAS TOMADAS');

    	// Put the position to the right of the cell
        $pdf->SetXY(60, 60);
		$pdf->MultiCell(130, 5, utf8_decode($r['observacion']), 0, 1);
        
    	$pdf->SetFont('Arial','B',11);   

        $pdf->Text( 26, 225, 'Entrega:');
    	$pdf->Text( 26, 240, '-----------------------------');
    	$pdf->Text( 26, 245, 'Agente de Seguridad');
	} 

	$pdf->Output(); 
}
