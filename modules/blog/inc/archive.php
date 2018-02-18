<?php


$is_year_monthly = ($segment2 && $segment3);
$is_yearly       = ($segment2 && !$segment3);

$table = "FROM `blog_post` bp";

$joins = "LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = bp.`page_meta_data_id`)
	LEFT JOIN `cms_users` cu
	ON(cu.`user_id` = pmd.`updated_by`)";

$condition = "WHERE pmd.`status` = 'A'
	AND bp.`date_posted` != ''
	AND ".( ($is_year_monthly) ? "MONTH(bp.`date_posted`) = '{$segment3}' AND YEAR(bp.`date_posted`) = '{$segment2}'" : (($segment2) ? "YEAR(bp.`date_posted`) = '{$segment2}'" : '')  )."
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
	if( $is_year_monthly )
	{
		$tags_arr['title'] = $tags_arr['heading'] = 'Monthly Archives: '.date('F Y', mktime(0,0,0,$segment3, 1, $segment2));
	}
	elseif($is_yearly)
	{
		$tags_arr['title'] = $tags_arr['heading'] = 'Yearly Archives: '.$segment2;
	}
}


?>