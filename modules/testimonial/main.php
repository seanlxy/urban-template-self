<?php

$testimonial = '';
$all_testm   = '';
$tags_arr['testm_heading'] = '';

if($page == $page_testimonial->url)
{	
	require_once "views/list.php";
	require_once "views/gallery.php";
}
else
{
	require_once "views/gallery.php";	
}

$tags_arr['testimonial_view'] = $testimonial;
$tags_arr['mod_view'] .= $all_testm;

?>