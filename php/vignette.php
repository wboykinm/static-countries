<?php

#Get parameters from the URL
$countryName = $_GET['name'];
$mapID = $_GET['mapid'];
$height = $_GET['height'];
$width = $_GET['width'];

# Hand the country to the CartoDB-hosted table, see what it fires back
$urlPass = "http://geosprocket.cartodb.com/api/v2/sql?q=SELECT%20Box2D(the_geom),ST_AsText(ST_Centroid(the_geom))%20FROM%20countries%20WHERE%20name%20ILIKE%20%27%25" . $countryName . "%25%27";

# Get the response JSON for the given country
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $urlPass);
curl_setopt($ch, CURLOPT_HEADER, 0);
$result=curl_exec($ch);
curl_close($ch);

# Parse results of bounding box and centroid call from CartoDB
$deets = json_decode($result, true);
$splits = array("("," ",",",")");
$centroid = explode( $splits[0], str_replace($splits, $splits[0], $deets["rows"][0]["st_astext"]) );
$lat = $centroid[2];
$lon = $centroid[1];
$bbox = explode( $splits[0], str_replace($splits, $splits[0], $deets["rows"][0]["box2d"]) );
$box_sw_lon = $bbox[1];
$box_sw_lat = $bbox[2];
$box_ne_lon = $bbox[3];
$box_ne_lat = $bbox[4];

# Black magic - conversion of bounding box to zoom
$GLOBE_WIDTH = 256;
$west = $box_sw_lon;
$east = $box_ne_lon;
$angle = $east - $west;
if ($angle < 0) {
  $angle += 360;
}
$zoom = floor(log(256 * 360 / $angle / $GLOBE_WIDTH) / 0.6931471805599453);
if ($zoom < 1) {
  $zoom = 1;
}
# Build the call to the Mapbox static API and request the image
$targetMap = "http://api.tiles.mapbox.com/v3/" . $mapID . "/" . $lon . "," . $lat . "," . $zoom . "/" . $width . "x" . $height . ".png";

header("Location: " . $targetMap);
exit; 
?>