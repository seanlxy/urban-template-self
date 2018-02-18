<?php


require_once 'inc/latest_post.php';

if($page_url == $page_blog->url)
{


$ouput_view      = '';
$posts_view      = '';
$extra_view      = '';
$panels_view     = '';
$pagination_view = '';
$max_rows        = 5;
$query_string    = 'page';
$current_page    =  (isset($_GET[$query_string])) ? $_GET[$query_string] : 1;
$is_single       = false;

$segment1 = "option{$page_index}";
$segment1 = $$segment1;

$segment2 = "option".($page_index+1);
$segment2 = $$segment2;

$segment3 = "option".($page_index+2);
$segment3 = $$segment3;

$pg_full_url = $page_blog->full_url;

if( ($segment1 && $segment2) && in_array( $segment1, array('archive', 'author', 'post', 'category') ) )
{
	switch ($segment1)
	{
		case 'author':
			require_once 'inc/author_archive.php';
		break;
		case 'category':
			require_once 'inc/category_archive.php';
		break;
		case 'archive':
			require_once 'inc/archive.php';
		break;
		case 'post':
			require_once 'inc/post.php';
		break;

	}
}
else
{
	require_once 'inc/posts.php';
}


require_once 'inc/generate_view.php';
require_once 'inc/panels/posts.php';
require_once 'inc/panels/archives.php';
require_once 'inc/panels/category.php';

$tags_arr['ex_meta_taga'] .= "\n".'	<meta property="og:type" content="blog"/>';

$ouput_view = <<< HTML
	<section class="section section--grey blog__wrapper">
    	<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<div class="row">
						{$posts_view}
						{$pagination_view}
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					{$panels_view}
				</div>
			</div>
		</div>
	</section>
{$extra_view}
HTML;

$tags_arr['mod_view'] .= $ouput_view;
$pageCanonicalTags = '';
}

?>
