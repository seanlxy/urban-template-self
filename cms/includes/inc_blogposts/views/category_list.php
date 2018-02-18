<?php

$categories_list = '';

$sql = "SELECT bc.`id`, pmd.`name`
    FROM `blog_category` bc
    LEFT JOIN `page_meta_data` pmd
    ON(pmd.`id` = bc.`page_meta_data_id`)
    WHERE pmd.`status` != 'D'
    ORDER BY pmd.`name`";


$categories = fetch_all($sql);

$sel_categories_arr = explode(',', $categories_csv);

if( !empty($categories) )
{
	$categories_list = '<ul class="list-grid">';

	foreach ($categories as $category)
	{

		$category_id   = $category['id'];
		$category_name = $category['name'];

		$is_checked = ( in_array($category_id, $sel_categories_arr) ) ? ' checked="checked"' : '';

		$categories_list .= '<li><label class="checkbox-inline"><input'.$is_checked.' type="checkbox" value="'.$category_id.'" name="category_id[]"> <span>'.$category_name.'</span></label></li>';
	}

	$categories_list .= '</ul>';
}


?>