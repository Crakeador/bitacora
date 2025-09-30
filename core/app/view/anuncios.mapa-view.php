<?php 
// Vista de mapa con anuncios geolocalizados
if(!isset($_SESSION['user_id'])){ Core::redir('./'); }

$anuncios = AnuncioData::getAll();
?>
<style>
.map-container {
    height: 500px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.map-info {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}
.photo-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 10px;
}
</style>

<section class="content-header">
    <h1>Mapa de Anuncios <small>Ubicaciones geolocalizadas</small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-map"></i> Mapa Interactivo</h3>
                </div>
                <div class="box-body">
                    <div id="map" class="map-container"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list"></i> Anuncios con Ubicación</h3>
                </div>
                <div class="box-body" style="max-height: 450px; overflow-y: auto;">
                    <?php 
                    $anunciosConUbicacion = 0;
                    foreach($anuncios as $ann): 
                        $locations = AnuncioLocationData::getByAnuncioId($ann->id);
                        if(!empty($locations)):
                            $anunciosConUbicacion++;
                    ?>
                    <div class="map-info">
                        <div class="row">
                            <div class="col-md-4">
                                <?php 
                                $imagenes = json_decode($ann->imagen, true);
                                if(is_array($imagenes) && isset($imagenes[0])){
                                    echo '<img src="storage/anuncios/'.htmlspecialchars($imagenes[0]).'" class="photo-thumb" alt="Foto">';
                                } elseif($ann->imagen) {
                                    echo '<img src="storage/anuncios/'.htmlspecialchars($ann->imagen).'" class="photo-thumb" alt="Foto">';
                                } else {
                                    echo '<div class="photo-thumb bg-light d-flex align-items-center justify-content-center"><i class="fa fa-image text-muted"></i></div>';
                                }
                                ?>
                            </div>
                            <div class="col-md-8">
                                <h5 style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($ann->titulo); ?></h5>
                                <p class="text-muted small" style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($ann->tipo); ?> - <?php echo date('d/m/Y', strtotime($ann->fecha_creacion)); ?></p>
                                <p class="small" style="margin: 0 0 5px 0;"><?php echo nl2br(htmlspecialchars(mb_strimwidth($ann->cuerpo, 0, 80, '...'))); ?></p>
                                <button class="btn btn-xs btn-primary" onclick="showAnuncioOnMap(<?php echo $ann->id; ?>)">
                                    <i class="fa fa-map-marker"></i> Ver en Mapa
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    
                    if($anunciosConUbicacion == 0):
                    ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <p>No hay anuncios con ubicación geolocalizada.</p>
                        <p>Los anuncios aparecerán aquí cuando se creen con fotos que incluyan coordenadas GPS.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
// Datos de anuncios con ubicación
const anunciosData = <?php 
$data = [];
foreach($anuncios as $ann) {
    $locations = AnuncioLocationData::getByAnuncioId($ann->id);
    if(!empty($locations)) {
        $imagenes = json_decode($ann->imagen, true);
        $data[] = [
            'id' => $ann->id,
            'titulo' => $ann->titulo,
            'tipo' => $ann->tipo,
            'cuerpo' => $ann->cuerpo,
            'fecha' => $ann->fecha_creacion,
            'imagen' => is_array($imagenes) ? $imagenes[0] : $ann->imagen,
            'locations' => array_map(function($loc) {
                return [
                    'lat' => floatval($loc->latitude),
                    'lng' => floatval($loc->longitude),
                    'address' => $loc->address,
                    'foto_index' => $loc->foto_index
                ];
            }, $locations)
        ];
    }
}
echo json_encode($data);
?>;

let map;
let markers = [];

// Inicializar mapa
function initMap() {
    // Centro por defecto (Guayaquil, Ecuador)
    map = L.map('map').setView([-2.1894, -79.8891], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Agregar marcadores
    anunciosData.forEach(anuncio => {
        anuncio.locations.forEach(location => {
            const marker = L.marker([location.lat, location.lng])
                .addTo(map)
                .bindPopup(`
                    <div style="min-width: 200px;">
                        <h6>${anuncio.titulo}</h6>
                        <p class="small text-muted">${anuncio.tipo} - ${anuncio.fecha}</p>
                        ${anuncio.imagen ? `<img src="storage/anuncios/${anuncio.imagen}" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px; margin: 5px 0;">` : ''}
                        <p class="small">${anuncio.cuerpo.substring(0, 100)}...</p>
                        <button class="btn btn-xs btn-primary" onclick="verAnuncio(${anuncio.id})">
                            Ver Completo
                        </button>
                    </div>
                `);
            
            marker.anuncioId = anuncio.id;
            markers.push(marker);
        });
    });
    
    // Ajustar vista para mostrar todos los marcadores
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

function showAnuncioOnMap(anuncioId) {
    const anuncioMarkers = markers.filter(marker => marker.anuncioId == anuncioId);
    if (anuncioMarkers.length > 0) {
        map.setView(anuncioMarkers[0].getLatLng(), 16);
        anuncioMarkers[0].openPopup();
    }
}

function verAnuncio(id) {
    window.location.href = `index.php?view=anuncios.feed&id=${id}`;
}

// Inicializar mapa cuando la página esté lista
document.addEventListener('DOMContentLoaded', initMap);
</script>
