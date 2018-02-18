<?php

$styles_ext  .= '<link href="/'.$admin_dir.'/css/form-builder.min.css" rel="stylesheet">';
$styles_ext  .= '<link href="/'.$admin_dir.'/css/form-render.min.css" rel="stylesheet">';
$scripts_ext .= '<script src="/'.$admin_dir.'/js/libs/form-builder.min.js"></script>';
$scripts_ext .= '<script src="/'.$admin_dir.'/js/libs/form-render.min.js"></script>';
$scripts_ext .= '<script src="/'.$admin_dir.'/js/form-builder.js"></script>';


$fields_content =<<<HTML
	<div id="build-wrap" class="build-wrap"></div>
	<textarea id="formData" style="display: none;">{$json_data}</textarea>
HTML;

?>