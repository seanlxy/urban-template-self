<?php

if($latitude && $longitude && $zoom_level)
{
	
	$tags_arr['map'] = '';

	$jsVars['latitude']  = $latitude;
	$jsVars['longitude'] = $longitude;
	$jsVars['zoomLevel'] = $zoom_level;
	$jsVars['address']   = '<h2>'.$company_name.'</h2><p>'.$map_address.'</p>';

	$jsVars['mapStyles']  = file_get_contents("{$root}/themes/{$themeDir}/map_styles/map_styles.json");


	$tags_arr['script-ext'] .= <<<H

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqeRCfbUFp9cDWpnZPu1B8AnNnLCT9ZjQ"></script>
H;

	$map = <<<H

	<div class="map-wrappper">
		<div id="map-canvas"></div>
	</div>

H;

$tags_arr['map_view'] = $map;

}



?>