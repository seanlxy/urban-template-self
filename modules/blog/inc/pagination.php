<?php
// $max_rows
if( isset($total_rows) && $total_rows > 0 )
{
	require_once "{$classdir}/pagination.php";


	$config = array();

	$config['base_url']     = "{$page_blog->full_url}".(($segment1) ? "/{$segment1}" : '').(($segment2) ? "/{$segment2}" : '').(($segment3) ? "/{$segment3}" : '');
	$config['total_rows']   = $total_rows;
	$config['per_page']     = $max_rows;
	$config['cur_page']     = $current_page;
	$config['query_string'] = $query_string;

	$pagination = new Pagination($config);

	$pagination_view = $pagination->generate_links();
}


?>