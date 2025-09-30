<?php
// Estadísticas de anuncios y reacciones
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

$formato = isset($_GET['formato']) ? $_GET['formato'] : 'excel';
$anuncios = AnunciosData::getAll();

// Calcular estadísticas
$stats = [
    'total_anuncios' => count($anuncios),
    'total_reacciones' => 0,
    'reacciones_por_emoji' => [],
    'anuncios_por_tipo' => ['noticia' => 0, 'servicio' => 0],
    'anuncios_con_imagen' => 0,
    'anuncios_sin_reacciones' => 0
];

foreach($anuncios as $anuncio){
    $counts = ReaccionData::getCountsByAnuncio($anuncio->id);
    $totalReac = 0;
    foreach($counts as $ct){ $totalReac += intval($ct); }
    
    $stats['total_reacciones'] += $totalReac;
    $stats['anuncios_por_tipo'][$anuncio->tipo]++;
    if($anuncio->imagen) $stats['anuncios_con_imagen']++;
    if($totalReac == 0) $stats['anuncios_sin_reacciones']++;
    
    foreach($counts as $emoji => $count){
        if(!isset($stats['reacciones_por_emoji'][$emoji])){
            $stats['reacciones_por_emoji'][$emoji] = 0;
        }
        $stats['reacciones_por_emoji'][$emoji] += intval($count);
    }
}

if($formato === 'excel'){
    // Exportar a Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="estadisticas_anuncios_'.date('Y-m-d').'.xls"');
    
    echo "<table border='1'>";
    echo "<tr><th colspan='2'>ESTADÍSTICAS DE ANUNCIOS</th></tr>";
    echo "<tr><td>Total Anuncios</td><td>".$stats['total_anuncios']."</td></tr>";
    echo "<tr><td>Total Reacciones</td><td>".$stats['total_reacciones']."</td></tr>";
    echo "<tr><td>Anuncios con Imagen</td><td>".$stats['anuncios_con_imagen']."</td></tr>";
    echo "<tr><td>Anuncios sin Reacciones</td><td>".$stats['anuncios_sin_reacciones']."</td></tr>";
    echo "<tr><td colspan='2'><strong>Por Tipo</strong></td></tr>";
    echo "<tr><td>Noticias</td><td>".$stats['anuncios_por_tipo']['noticia']."</td></tr>";
    echo "<tr><td>Servicios</td><td>".$stats['anuncios_por_tipo']['servicio']."</td></tr>";
    echo "<tr><td colspan='2'><strong>Reacciones por Emoji</strong></td></tr>";
    foreach($stats['reacciones_por_emoji'] as $emoji => $count){
        echo "<tr><td>".$emoji."</td><td>".$count."</td></tr>";
    }
    echo "<tr><td colspan='2'><strong>DETALLE DE ANUNCIOS</strong></td></tr>";
    echo "<tr><td>ID</td><td>Título</td><td>Tipo</td><td>Fecha</td><td>Reacciones</td></tr>";
    foreach($anuncios as $a){
        $counts = ReaccionData::getCountsByAnuncio($a->id);
        $totalReac = 0;
        foreach($counts as $ct){ $totalReac += intval($ct); }
        echo "<tr><td>".$a->id."</td><td>".htmlspecialchars($a->titulo)."</td><td>".$a->tipo."</td><td>".$a->fecha_creacion."</td><td>".$totalReac."</td></tr>";
    }
    echo "</table>";
    exit;
}

if($formato === 'pdf'){
    // Exportar a PDF
    require_once('../plugins/fpdf/fpdf.php');
    
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'ESTADISTICAS DE ANUNCIOS',0,1,'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,'Resumen General',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,'Total Anuncios: '.$stats['total_anuncios'],0,1);
    $pdf->Cell(0,6,'Total Reacciones: '.$stats['total_reacciones'],0,1);
    $pdf->Cell(0,6,'Anuncios con Imagen: '.$stats['anuncios_con_imagen'],0,1);
    $pdf->Cell(0,6,'Anuncios sin Reacciones: '.$stats['anuncios_sin_reacciones'],0,1);
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,'Por Tipo',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,6,'Noticias: '.$stats['anuncios_por_tipo']['noticia'],0,1);
    $pdf->Cell(0,6,'Servicios: '.$stats['anuncios_por_tipo']['servicio'],0,1);
    $pdf->Ln(5);
    
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,'Reacciones por Emoji',0,1);
    $pdf->SetFont('Arial','',10);
    foreach($stats['reacciones_por_emoji'] as $emoji => $count){
        $pdf->Cell(0,6,$emoji.' : '.$count,0,1);
    }
    
    $pdf->Output('D', 'estadisticas_anuncios_'.date('Y-m-d').'.pdf');
    exit;
}
?>

<section class="content-header">
    <h1>Estadísticas <small>Anuncios y Reacciones</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Resumen General</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-bullhorn"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Anuncios</span>
                                    <span class="info-box-number"><?php echo $stats['total_anuncios']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-heart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Reacciones</span>
                                    <span class="info-box-number"><?php echo $stats['total_reacciones']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-image"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Con Imagen</span>
                                    <span class="info-box-number"><?php echo $stats['anuncios_con_imagen']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-frown-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sin Reacciones</span>
                                    <span class="info-box-number"><?php echo $stats['anuncios_sin_reacciones']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Por Tipo</h3>
                </div>
                <div class="box-body">
                    <div class="progress-group">
                        <span class="progress-text">Noticias</span>
                        <span class="float-right"><b><?php echo $stats['anuncios_por_tipo']['noticia']; ?></b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-blue" style="width: <?php echo $stats['total_anuncios'] > 0 ? ($stats['anuncios_por_tipo']['noticia'] / $stats['total_anuncios']) * 100 : 0; ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Servicios</span>
                        <span class="float-right"><b><?php echo $stats['anuncios_por_tipo']['servicio']; ?></b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-green" style="width: <?php echo $stats['total_anuncios'] > 0 ? ($stats['anuncios_por_tipo']['servicio'] / $stats['total_anuncios']) * 100 : 0; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Reacciones por Emoji</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php foreach($stats['reacciones_por_emoji'] as $emoji => $count): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow" style="font-size: 24px;"><?php echo $emoji; ?></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $emoji; ?></span>
                                    <span class="info-box-number"><?php echo $count; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
