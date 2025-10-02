<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bitacora Electronica
		<small>ubicacion del reporte</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php?view=bitacora"><i class="fa fa-dashboard"></i> Panel de control </a></li>
	</ol>
</section>
<section class="content container-fluid" style="padding: 1.5rem !important;">
    <div class="row">
        <div class="col-xs-12">
            <div id="map_canvas" style="height:350px">  </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnge7sTWX0Bg9KprAw2W2bsUPcT4QwM3U&callback=initMap&v=weekly&libraries=marker"></script>
<script>
    var vMarker
    var map

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 16,
        center: new google.maps.LatLng(-2.1480534,-79.8841984),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    vMarker = new google.maps.Marker({
        position: {lat: <?php echo $_GET['lat']; ?>, lng: <?php echo $_GET['lot']; ?>},
        draggable: true
    });

    map.setCenter(vMarker.position);
    vMarker.setMap(map);
</script>
