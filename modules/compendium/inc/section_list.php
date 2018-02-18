<?php


foreach ($all_sections as $section) {

	@extract($section);

	$tags_arr['prop-name'] = $name;

	$tags_arr['prop-address'] = $address;

	$section_id = $section['hash_key'];

	$colour_class = ($has_dark_bg) ? ' dark' : '';

	$section_content_view = ($content) ? $content : $default_content;

	$section_map_view = ($is_map) ? '<div id="map-canvas"></div>' : '';

	$map_class = '';

	if(!$show_map_section && $is_map)
	{
		$map_class = ' hide';
	}

	$section_items .= <<<H

			<div class="section-item{$colour_class}{$map_class}" id="{$section_id}">
				<div class="inner">
					<div class="icon-wrap">
						<i class="{$icon}"></i>
					</div>
					<h2 class="section__heading" >{$heading}</h2>
					<div class="section-content">
						{$section_content_view}
						{$section_map_view}
					</div>
				</div>
			</div>

H;
}


$section_list = <<<H

	<div class="section-wrap">
		 <div class="container">
			<div class="row">
				{$section_items}
			</div>
		</div>
	</div>


H;



$tags_arr['compendium-section-view'] = $section_list;


?>
