<?php 

$post_date_range = fetch_all("SELECT DISTINCT DATE_FORMAT(bp.`date_posted`, '%M %Y') AS mon, YEAR(bp.`date_posted`) AS date_year,
	LPAD(MONTH(bp.`date_posted`), 2, '0') AS date_month
	FROM `blog_post` bp 
	LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = bp.`page_meta_data_id`)
	WHERE pmd.`status` = 'A'
	ORDER BY bp.`date_posted` DESC");

if( !empty($post_date_range) )
{
	$panels_view .= '<div class="well well-small"><h2>Archives</h2> <ul class="list__blogs">';
	
	foreach ($post_date_range as $item)
	{
		$panels_view .= '<li class="list__blogs__item"><a href="'.$pg_full_url.'/archive/'.$item['date_year'].'/'.$item['date_month'].'" class="btn--link btn--link-grey">'.$item['mon'].'</a></li>';
	}

	$panels_view .= '</ul></div>';
}

?>