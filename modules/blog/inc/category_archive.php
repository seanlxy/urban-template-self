<?php


$category_data = fetch_row("SELECT bc.`id`, pmd.`menu_label`, pmd.`title`, pmd.`meta_description`,
	pmd.`og_title`, pmd.`og_meta_description`, pmd.`og_image`
	FROM `blog_category` bc
	LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = bc.`page_meta_data_id`)
	WHERE pmd.`url` = '{$segment2}'
	AND pmd.`status` = 'A'
	LIMIT 1");


$table = "FROM `blog_post` bp";

$joins = "LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = bp.`page_meta_data_id`)
	LEFT JOIN `blog_post_has_category` bphc
	ON(bp.`id` = bphc.`post_id`)
	LEFT JOIN `blog_category` bc
	ON(bc.`id` = bphc.`category_id`)
	LEFT JOIN `page_meta_data` ocpmd
	ON(ocpmd.`id` = bc.`page_meta_data_id`)
	LEFT JOIN `cms_users` cu
	ON(cu.`user_id` = pmd.`updated_by`)";

$condition = "WHERE pmd.`status` = 'A'
	AND bp.`date_posted` != ''
	AND bc.`id` = '{$category_data['id']}'
	GROUP BY bp.`id`
	ORDER BY bp.`date_posted` DESC";
	


$total_rows =  fetch_value("SELECT COUNT(bp.`id`) {$table} {$joins} {$condition}");
require_once 'pagination.php';
$offset = ($current_page - 1);


$posts_arr = fetch_all("SELECT pmd.`heading`, pmd.`full_url`, pmd.`title`, pmd.`description`, pmd.`short_description`,
	pmd.`photo` AS photo_path, pmd.`thumb_photo` AS thumb_photo_path,
	IF(bp.`date_posted`, DATE_FORMAT(bp.`date_posted`, '%M %d, %Y'), '') AS posted_on,
	TRIM(CONCAT(cu.`user_fname`, ' ', cu.`user_lname`)) AS author_name,
	REPLACE(LOWER(TRIM(cu.`user_fname`)), ' ', '-') AS author_url
	{$table}
	{$joins}
	{$condition}
	LIMIT {$offset}, $max_rows");



if( !empty($posts_arr) )
{
	// $tags_arr['title'] = $tags_arr['heading'] = 'Category Archives: '.$posts_arr[0]['category_name'];

	$tags_arr['heading']  = 'Category Archives: '.$category_data['menu_label'];
	$tags_arr['title']    = $category_data['title'];
	$tags_arr['og_title'] = ($category_data['og_title']) ? $category_data['og_title'] : $category_data['title'];
	$tags_arr['mdescr']   = ($category_data['og_meta_description']) ? $category_data['og_meta_description'] : $category_data['meta_description'];
	$tags_arr['og_image'] = ($category_data['og_image']) ? "{$htmlroot}{$category_data['og_image']}" : '';

}

?>