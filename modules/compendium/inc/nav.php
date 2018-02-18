<?php


$nav_links_view = '';

$tags_arr['main-nav'] = '';

$tags_arr['static-nav'] = '';

foreach ($all_sections as $section) {
	
	$map_class = '';

	if(!$show_map_section && $section['is_map'] == '1')
	{
		$map_class = ' class="hide"';
	}

	$nav_links .= '<li'.$map_class.'><div class="icon-wrap"><i class="'.$section['icon'].'"></i></div><a href="#'.$section['hash_key'].'" title="'.$section['heading'].'">'.$section['heading'].' </a></li>';

	$nav_links_static .= '<li'.$map_class.'><i class="'.$section['icon'].'"></i><a href="#'.$section['hash_key'].'" title="'.$section['heading'].'">'.$section['heading'].' </a></li>';
}


$nav_links_view .= <<< H
<nav id="main-nav">
    <ul>
 		{$nav_links}
    </ul>
</nav>
H;

$tags_arr['main-nav'] = $nav_links_view;

$nav_links_static_view .= <<< H
<nav id="static-nav">
    <ul>
 		{$nav_links_static}
    </ul>
</nav>
H;

$tags_arr['main-nav'] = $nav_links_view;

$tags_arr['static-nav'] = $nav_links_static_view;

?>