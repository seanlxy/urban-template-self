<?php

$map_view = '';

$zoom_level = 16;

$property_lat = $all_sections[0]['latitude'];
$property_lng = $all_sections[0]['longitude'];
$property_addr = $all_sections[0]['address'];

$show_map_section = false;

if($property_lat && $property_lng && $zoom_level)
{

	$show_map_section = true;

	//Put lat / long / zoom / address into jsVars array to be used site-wide by google map plugin
	$jsVars['latitude']  = $property_lat;
	$jsVars['longitude'] = $property_lng;
	$jsVars['zoomLevel'] = $zoom_level;
	$jsVars['address']   = $property_addr;
	$jsVars['mapStyles'] = file_get_contents("{$root}/themes/{$themeDir}/map_styles/map_styles.json");

	// preprint_r($jsVars);die;

	$tags_arr['script-ext'] = <<<H

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqeRCfbUFp9cDWpnZPu1B8AnNnLCT9ZjQ"></script>
H;

	$map_view = <<<H
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2 style="margin-top:30px;">Property Location</h2>
				<div id="map-canvas" style="height:500px;border:10px solid #fff;"></div>
			</div>
		</div>
	</div>

H;

}



?>