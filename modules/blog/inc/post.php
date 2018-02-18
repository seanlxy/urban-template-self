<?php

$posts_arr = fetch_all("SELECT pmd.`heading`, pmd.`photo` AS photo_path, pmd.`thumb_photo` AS thumb_photo_path,
	pmd.`title`, pmd.`meta_description`, pmd.`og_title`, 
	pmd.`og_meta_description`, pmd.`og_image`, pmd.`full_url`, pmd.`title`, pmd.`description`,
	IF(bp.`date_posted`, DATE_FORMAT(bp.`date_posted`, '%M %d, %Y'), '') AS posted_on,
	TRIM(CONCAT(cu.`user_fname`, ' ', cu.`user_lname`)) AS author_name,
	REPLACE(LOWER(TRIM(cu.`user_fname`)), ' ', '-') AS author_url,
	cu.`user_thumb_path` AS author_photo, cu.`user_introduction` AS author_intro
	FROM `blog_post` bp
	LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = bp.`page_meta_data_id`)
	LEFT JOIN `cms_users` cu
	ON(cu.`user_id` = pmd.`updated_by`)
	WHERE pmd.`status` = 'A'
	AND pmd.`url` = '{$segment2}'
	AND bp.`date_posted` != ''
	ORDER BY bp.`date_posted` DESC
	LIMIT 1");

$is_single = true;

if( !empty($posts_arr) )
{
	$post = $posts_arr[0];

	$tags_arr['heading']   = $post['heading'];
	$tags_arr['title']     = $post['title'];
	$tags_arr['page_photo']= $post['photo_path'];
	$tags_arr['og_title']  = ($post['og_title']) ? $post['og_title'] : $post['title'];
	$tags_arr['mdescr']    = ($post['og_meta_description']) ? $post['og_meta_description'] : $post['meta_description'];
	$tags_arr['og_image']  = ($post['og_image']) ? "{$htmlroot}{$post['og_image']}" : '';
}

?>