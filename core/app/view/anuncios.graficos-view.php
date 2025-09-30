<?php
// Gráficos de anuncios y reacciones
if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || intval($_SESSION['is_admin']) !== 1){
    Core::redir('home');
}

$anuncios = AnunciosData::getAll();

// Preparar datos para gráficos
$stats = [
    'reacciones_por_emoji' => [],
    'anuncios_por_tipo' => ['noticia' => 0, 'servicio' => 0],
    'anuncios_por_mes' => [],
    'reacciones_por_mes' => []
];

foreach($anuncios as $anuncio){
    $counts = ReaccionData::getCountsByAnuncio($anuncio->id);
    $totalReac = 0;
    foreach($counts as $ct){ $totalReac += intval($ct); }
    
    $stats['anuncios_por_tipo'][$anuncio->tipo]++;
    
    // Por mes
    $mes = date('Y-m', strtotime($anuncio->fecha_creacion));
    if(!isset($stats['anuncios_por_mes'][$mes])){
        $stats['anuncios_por_mes'][$mes] = 0;
        $stats['reacciones_por_mes'][$mes] = 0;
    }
    $stats['anuncios_por_mes'][$mes]++;
    $stats['reacciones_por_mes'][$mes] += $totalReac;
    
    foreach($counts as $emoji => $count){
        if(!isset($stats['reacciones_por_emoji'][$emoji])){
            $stats['reacciones_por_emoji'][$emoji] = 0;
        }
        $stats['reacciones_por_emoji'][$emoji] += intval($count);
    }
}
?>

<section class="content-header">
    <h1>Gráficos <small>Anuncios y Reacciones</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Reacciones por Emoji</h3>
                </div>
                <div class="box-body">
                    <canvas id="emojiChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Anuncios por Tipo</h3>
                </div>
                <div class="box-body">
                    <canvas id="tipoChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Evolución Mensual</h3>
                </div>
                <div class="box-body">
                    <canvas id="evolucionChart" width="800" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos para los gráficos
const emojiData = <?php echo json_encode($stats['reacciones_por_emoji']); ?>;
const tipoData = <?php echo json_encode($stats['anuncios_por_tipo']); ?>;
const evolucionData = {
    meses: <?php echo json_encode(array_keys($stats['anuncios_por_mes'])); ?>,
    anuncios: <?php echo json_encode(array_values($stats['anuncios_por_mes'])); ?>,
    reacciones: <?php echo json_encode(array_values($stats['reacciones_por_mes'])); ?>
};

// Gráfico de reacciones por emoji (Dona)
const emojiCtx = document.getElementById('emojiChart').getContext('2d');
new Chart(emojiCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(emojiData),
        datasets: [{
            data: Object.values(emojiData),
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de anuncios por tipo (Barras)
const tipoCtx = document.getElementById('tipoChart').getContext('2d');
new Chart(tipoCtx, {
    type: 'bar',
    data: {
        labels: ['Noticias', 'Servicios'],
        datasets: [{
            label: 'Cantidad',
            data: [tipoData.noticia, tipoData.servicio],
            backgroundColor: ['#36A2EB', '#4BC0C0']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de evolución mensual (Líneas)
const evolucionCtx = document.getElementById('evolucionChart').getContext('2d');
new Chart(evolucionCtx, {
    type: 'line',
    data: {
        labels: evolucionData.meses,
        datasets: [{
            label: 'Anuncios',
            data: evolucionData.anuncios,
            borderColor: '#36A2EB',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.1
        }, {
            label: 'Reacciones',
            data: evolucionData.reacciones,
            borderColor: '#FF6384',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
