<?php
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : -2.1480534;
$lng = isset($_GET['lot']) ? floatval($_GET['lot']) : -79.8841984;
$puestos = PuestoData::getAllLugar(2);

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora Electronica
		<small>Ubicación del reporte de novedad</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=bitacora"><i class="fa fa-dashboard"></i> Panel de control </a></li>
        <li class="active">Mapa</li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-map-marker"></i> Coordenadas: <?php echo $lat . ', ' . $lng; ?></h3>
                </div>
                <div class="box-body">
                    <div id="map_canvas" style="height:450px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    async function initMap() {
        var myLatLng = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>};
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        var bounds = new google.maps.LatLngBounds();

        var map = new Map(document.getElementById('map_canvas'), {
            zoom: 18,
            center: myLatLng,
            mapTypeId: 'hybrid',
            mapId: "DEMO_MAP_ID"
        });

        var marker = new AdvancedMarkerElement({
            position: myLatLng,
            map: map,
            title: 'Ubicación del Reporte'
        });
        bounds.extend(myLatLng);

        var contentString = '<div id="content">'+
            '<h5 class="firstHeading">Ubicación Reportada</h5>'+
            '<div id="bodyContent">'+
            '<p><b>Latitud:</b> <?php echo $lat; ?></p>'+
            '<p><b>Longitud:</b> <?php echo $lng; ?></p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
        
        infowindow.open(map, marker);
        console.log('Mapa inicializado con coordenadas: ' + myLatLng.lat + ', ' + myLatLng.lng);
        // Graficar puntos de PuestoData::getAllLugar
        <?php foreach($puestos as $puesto): ?>
            <?php if(!empty($puesto->latitud) && !empty($puesto->longitud)): ?>
            var ptLatLng = {lat: <?php echo $puesto->latitud; ?>, lng: <?php echo $puesto->longitud; ?>};
            var iconImg = document.createElement('img');
            iconImg.src = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
            new AdvancedMarkerElement({
                position: ptLatLng,
                map: map,
                title: '<?php echo $puesto->descripcion; ?>',
                content: iconImg
            });
            bounds.extend(ptLatLng);
            <?php endif; ?>
        <?php endforeach; ?>
        map.fitBounds(bounds);
    }
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnge7sTWX0Bg9KprAw2W2bsUPcT4QwM3U&callback=initMap&libraries=marker" async defer></script>
