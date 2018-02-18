<?php

$gallery_tabs = '';

$tabs = fetch_all("SELECT `id`, MD5(`id`) AS hashed_key, `menu_label`
FROM `photo_group`
WHERE `show_on_gallery_page` = 'Y'
AND `type` = 'G'
AND `menu_label` != ''
ORDER BY `menu_label`");



if( !empty($tabs) && count($tabs) > 1 )
{
	
	// $gallery_tabs = '<nav class="tab-nav">';

	$gallery_tabs = '<div class="container hidden-xs"><div class="gallery-nav text-center">';
	$gallery_tabs .= '<a class="shuffle-trigger btn btn-grey active" title="All Photos" href="#" data-group="all">All Photos</a>';

	foreach ($tabs as $tab)
	{
		$gallery_ids[$tab['id']] = $tab['menu_label'];
		$gallery_tabs .= '<a class="shuffle-trigger btn btn-grey" title="'.$tab['menu_label'].'" href="#" data-group="'.$tab['hashed_key'].'">'.$tab['menu_label'].'</a>';
	}

	// $gallery_tabs .= '</nav>';

	$gallery_tabs .= '</div></div>';
}
else
{
	$gallery_ids[$tabs[0]['id']] = $tabs[0]['menu_label'];
}


$gallery_list_view .= $gallery_tabs;

?>