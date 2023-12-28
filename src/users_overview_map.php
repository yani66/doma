<?php
  include_once(dirname(__FILE__) ."/include/main.php");
  include_once(dirname(__FILE__) ."/include/data_access.php");

  $dA = new DataAccess();
  $ids = $dA->GetAllMapIds();
?>

<?php
function console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.7/dist/leaflet-src.js"></script>
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
	<link type="text/css" rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
	<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster-src.js"></script>

  <style>
        html, body, #map {
        	margin: auto;
        	position: float;
            height: 500px;
            width: 100%;
        }
  </style>
</head>

<body>
  <h2></h2>
	<div id="map"></div>



	<?php

    if($ids != null) {
    	$coords = array();
    	$coo = array();
    	foreach ($ids as $value) {
    		$coo = $dA->GetMapData($value);
        $coo["user"] = $dA->GetUserByID($coo["userID"])->Username;
    		array_push($coords, $coo);
    	}
    }
  ?>
<a id='a' type="hidden" href=""></a>
<script>

	var iconOl = L.icon({
        iconUrl: './gfx/MapMarkerOL.png',

        iconAnchor: [17,44],
        popupAnchor: [0, -45]
      })
  var map = L.map('map', {worldCopyJump: true}).setView([0,0], 2);
  var coo = <?php echo json_encode($coords); ?>;

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    minZoom:1
  }).addTo(map)
  L.Control.geocoder().addTo(map);
  var shelter = new L.markerClusterGroup();

  for (var i = coo.length -  1; i >= 0; i--) {
  	if(coo[i]["latitude"] != null) {
	var elem = document.getElementById('a').cloneNode(true);
	elem.href = "http://map-warehouse.bplaced.net/DOMA/show_map.php?user=";
  	elem.text = coo[i]["name"];
    elem.href += coo[i]["user"];
    elem.href += "&map=";
    elem.href += coo[i]["id"];
    coo[i].link= elem.cloneNode(true);
  	shelter.addLayer(L.marker([coo[i]["latitude"],coo[i]["longitude"]], {icon: iconOl}).bindPopup(coo[i]["link"]));
  }
  }
  map.addLayer(shelter);
  map.fitBounds(shelter.getBounds());

</script>

</body>
</html>