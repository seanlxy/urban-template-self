<?php

$gallery_view = '';

if($page_gallery_id)
{
	require_once 'inc/gallery.php';
}

$tags_arr['gallery_view'] .= $gallery_view;

?>