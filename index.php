<?php

## Netzone Cookiecutter CMS ##
// Version: 1.0
// Author: Sam Walsh & Ton Immanuel - Webdirectionz / Tomahawk
// File: index.php
// Date: 12/05/2010

###############################################################################################################################
## Required Files
###############################################################################################################################
session_start();
require_once ('utility/config.php');                              	## System config file
if($debug)
{
	require_once $classdir.'/firephp/fb.php';
	FB::setEnabled($debug);
}


###############################################################################################################################
## Start Sesstion
###############################################################################################################################

## Start session

###############################################################################################################################
## Get the query string and split the name value pairs
###############################################################################################################################
parse_str(parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY),$_GET2); // Add the non-processed mod_rewrite queries to $_GET
$_GET = array_merge($_GET,$_GET2);

$page    = sanitize_one($_GET['pg'], 'sqlsafe');

$option1 = sanitize_one($_GET['a'], 'sqlsafe');
$option2 = sanitize_one($_GET['b'], 'sqlsafe');
$option3 = sanitize_one($_GET['c'], 'sqlsafe');
$option4 = sanitize_one($_GET['d'], 'sqlsafe');
$option5 = sanitize_one($_GET['e'], 'sqlsafe');
$option6 = sanitize_one($_GET['f'], 'sqlsafe');

$uri_segments = array();

if($page)
{
	array_push($uri_segments, $page);
}
if($option1)
{
	array_push($uri_segments, $option1);
}
if($option2)
{
	array_push($uri_segments, $option2);
}
if($option3)
{
	array_push($uri_segments, $option3);
}

if($option4)
{
	array_push($uri_segments, $option4);
}
if($option5)
{
	array_push($uri_segments, $option5);
}
if($option6)
{
	array_push($uri_segments, $option6);
}

###############################################################################################################################
## Get Page/Settings Information
###############################################################################################################################

if(!$c_Connection->Connect())
{
	echo "Database connection failed";
	exit;
}

// require_once ('change_db_collation.php');

// function csv_to_array($filename='', $delimiter=',')
// {
// 	if(!file_exists($filename) || !is_readable($filename))
// 		return FALSE;

// 	$header = NULL;
// 	$data = array();
// 	if (($handle = fopen($filename, 'r')) !== FALSE)
// 	{
// 		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
// 		{
// 			if(!$header)
// 				$header = $row;
// 			else
// 				$data[] = array_combine($header, $row);
// 		}
// 		fclose($handle);
// 	}
// 	return $data;
// }

// $be_categories = csv_to_array('bs_categories.csv');

// if( !empty($be_categories) )
// {
// 	foreach ($be_categories as $category)
// 	{
// 		$bookeasy_name = trim($category['name']);
// 		$bookeasy_id   = trim($category['bookeasy_id']);

// 		$category_data =  $category_meta_data = array();

// 		$url = prepare_item_url($bookeasy_name);

// 		$category_meta_data['name']               = $bookeasy_name;
// 		$category_meta_data['menu_label']         = $bookeasy_name;
// 		$category_meta_data['heading']            = $bookeasy_name;
// 		$category_meta_data['heading']            = $bookeasy_name;
// 		$category_meta_data['title']              = $bookeasy_name;
// 		$category_meta_data['url']                = $url;
// 		$category_meta_data['full_url']           = "/$url";
// 		$category_meta_data['status']             = 'A';
// 		$category_meta_data['date_created']       = date('Y-m-d H:i:s');
// 		$category_meta_data['created_by']         = 1;
// 		$category_meta_data['page_meta_index_id'] = 1;

// 		$page_meta_data_id = insert_row($category_meta_data, 'page_meta_data');

// 		$category_data['bookeasy_id']       = $bookeasy_id;
// 		$category_data['bookeasy_name']     = $bookeasy_name;
// 		$category_data['page_meta_data_id'] = $page_meta_data_id;


// 		insert_row($category_data, 'operator_category');





// 	}
// }

// die();
// $url = 'https://api.instagram.com/oauth/access_token';

// $fields = array(
// 	'client_id' => '4259a3b625c748d4b415563a16a0239c',
// 	'client_secret' => '5e494f4e114a49a7b8d6ee631855d3c9',
// 	'grant_type' => 'authorization_code',
// 	'redirect_uri' => 'http://boiinfo.netzone.co.nz',
// 	'code' => 'ab4fc02d61ae429783eac0d35812ff3c'
// );

// foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
// rtrim($fields_string, '&');


// $headerData = array('Accept: application/json');
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
// curl_setopt($ch, CURLOPT_TIMEOUT, 90);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_HEADER, true);
// curl_setopt($ch, CURLOPT_POST, count($fields_string));
// curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);


// $jsonData = curl_exec($ch);

// $insta_photos = json_decode(file_get_contents('https://api.instagram.com/v1/tags/bayofislands/media/recent?access_token=2159900925.4259a3b.abe1a039df4a4a8ba719b090e60ab39d'));
// preprint_r($insta_photos);
// die();

################## Import blog data ###############################

// $blog_caategories = fetch_all("SELECT `id`, `label`, `url`, `title`, `meta_description`, `status`, `rank`
// FROM `blog_category_old`
// WHERE 1");


// foreach ($blog_caategories as $blog_caategory)
// {


// 	$meta_data = $page_data = array();

// 	$meta_data['name']                = $blog_caategory['label'];
// 	$meta_data['menu_label']          = $blog_caategory['label'];
// 	$meta_data['heading']             = $blog_caategory['label'];
// 	$meta_data['url']                 = "{$blog_caategory['url']}";
// 	$meta_data['full_url']            = "/category/{$blog_caategory['url']}";
// 	$meta_data['title']               = $blog_caategory['title'];
// 	$meta_data['og_title']            = $blog_caategory['og_title'];
// 	$meta_data['og_meta_description'] = $blog_caategory['meta_description'];
// 	$meta_data['meta_description']    = $blog_caategory['meta_description'];
// 	$meta_data['status']              = $blog_caategory['status'];
// 	$meta_data['rank']                = $blog_caategory['rank'];
// 	$meta_data['date_created']        = date('Y-m-d H:i:s');

// 	$meta_id = insert_row($meta_data, 'page_meta_data');



// 	$page_data['old_id'] = $blog_caategory['id'];
// 	$page_data['page_meta_data_id'] = $meta_id;

// 	insert_row($page_data, 'blog_category');



// }


// $blog_posts = fetch_all("SELECT `id`, `name`, `url`, `long_description`, `title`, `meta_keywords`, `meta_description`,
// 	`status`, `date_created`, `date_posted`, `date_updated`, `author_id`
// 	FROM `blog_post_old`
// 	WHERE 1
// 	ORDER BY `date_posted` DESC");

// foreach ($blog_posts as $blog_post)
// {


// 	$meta_data = $page_data = array();

// 	$meta_data['name']                = $blog_post['name'];
// 	$meta_data['menu_label']          = $blog_post['name'];
// 	$meta_data['heading']             = $blog_post['name'];
// 	$meta_data['url']                 = "{$blog_post['url']}";
// 	$meta_data['full_url']            = "/post/{$blog_post['url']}";
// 	$meta_data['title']               = $blog_post['title'];
// 	$meta_data['og_title']            = $blog_post['title'];
// 	$meta_data['og_meta_description'] = $blog_post['meta_description'];
// 	$meta_data['meta_description']    = $blog_post['meta_description'];
// 	$meta_data['description']         = $blog_post['long_description'];
// 	$meta_data['status']              = $blog_post['status'];
// 	$meta_data['rank']                = $blog_post['rank'];
// 	$meta_data['date_created']        = $blog_post['date_created'];
// 	$meta_data['date_updated']        = $blog_post['date_updated'];
// 	$meta_data['created_by']          = 1;
// 	$meta_data['updated_by']          = 1;

// 	$meta_id = insert_row($meta_data, 'page_meta_data');



// 	$page_data['old_id']            = $blog_post['id'];
// 	$page_data['date_posted']       = $blog_post['date_posted'];
// 	$page_data['page_meta_data_id'] = $meta_id;

// 	insert_row($page_data, 'blog_post');



// }


// die();


// $blog_posts_relations = fetch_all("SELECT bc.`id` AS category_id, bp.`id` AS post_id
// FROM `blog_post_has_category_old` bphc
// LEFT JOIN `blog_post` bp
// ON(bp.`old_id` = bphc.`post_id`)
// LEFT JOIN `blog_category` bc
// ON(bc.`old_id` = bphc.`category_id`)
// WHERE 1");


// if( !empty($blog_posts_relations) )
// {
// 	foreach ($blog_posts_relations as $relation)
// 	{
// 		insert_row( array('category_id' => $relation['category_id'], 'post_id' => $relation['post_id']),  'blog_post_has_category');
// 	}
// }

// die();


$requested_url = $_SERVER['REQUEST_URI'];

$new_redirect_details = fetch_row("SELECT `new_url`, `status_code` FROM `redirect` WHERE REPLACE(`old_url`, '$htmlroot/', '/') = '$requested_url' AND `status` = 'A' LIMIT 1");

if(is_array($new_redirect_details) && count($new_redirect_details) === 2)
{

	$location = $new_redirect_details['new_url'];

	$status_code = $new_redirect_details['status_code'];

	if($status_code)
	{
		header("Location: {$location}", true, $status_code);
	}
	else
	{
		header("Location: {$location}", false);
	}
	exit();
}


## REQUIRED FILES ###################
require "$incdir/pageInfo.php";                                         ## Get page/website-settings/module information from db

###############################################################################################################################
## Timebased publishing
###############################################################################################################################
// $sql = "SELECT page_id, page_timebase_publishing, page_publish_date, page_hide_date, page_publish_time, page_hide_time
// FROM general_pages
// WHERE page_id NOT IN(1,2)
// AND  page_status != 'D'
// AND page_timebase_publishing = 'Y'";
// $res = fetch_all($sql);
// // date_default_timezone_set('Pacific/Auckland');
// $today = date('Y-m-d H:i:s');


// foreach($res as $row)
// {
//     $publish_datetime	= $row['page_publish_date'].' '.$row['page_publish_time'];
//     $hide_datetime	= $row['page_hide_date'].' '.$row['page_hide_time'];
//     $pid		= $row['page_id'];

// 	if($today >= $publish_datetime && $hide_datetime >= $today)
// 	{
// 	    $timesavearr['page_status'] = 'A';
// 	    $end = "WHERE page_id='$pid'";
// 	    update_row($timesavearr,'general_pages',$end);
// 	}
// 	else
// 	{
// 	    $timesavearr['page_status'] = 'H';
// 	    $timesavearr['page_timebase_publishing'] = 'N';
// 	    $end = "WHERE page_id='$pid'";
// 	    update_row($timesavearr,'general_pages',$end);
// 	}
// }


###############################################################################################################################
## Make the menus
###############################################################################################################################
require "$incdir/components/main.php";                                       ## Menu former file

###############################################################################################################################
## Get Modules
###############################################################################################################################
// Clear module-count tags in template
for($i=0;$i<$number_of_module_tags;$i++)
{
$tags_arr['module'.($i+1)] = '';
}
// Clear module tags in template
$sql = "SELECT mod_path
    FROM modules
    WHERE (mod_mobile = '' OR mod_mobile IS NULL)";
foreach(fetch_all($sql) as $key => $array)
{
    $path = $array['mod_path'];
    include_once("$moddir/$path/cleartags.php");
}
$sql = "SELECT mt.mod_id AS id, tmplmod_rank AS rank, mod_path
    FROM module_templates mt
    LEFT JOIN modules m ON m.mod_id = mt.mod_id
    WHERE tmpl_id = $template_id
    AND (m.mod_mobile = '' OR m.mod_mobile IS NULL)

    UNION

    SELECT mp.mod_id AS id, modpages_rank AS rank, mod_path
    FROM module_pages mp
    LEFT JOIN modules m ON m.mod_id = mp.mod_id
    WHERE page_id = $page_id
    AND (m.mod_mobile = '' OR m.mod_mobile IS NULL)

    ORDER BY rank ASC";
$mod_path = array_extract(fetch_all($sql),'mod_path');
$mod_id = array_extract(fetch_all($sql),'mod_id');
if(!empty($mod_path))
{
	foreach($mod_path as $key => $path)
	{
	    include_once ("$moddir/$path/main.php");
	    $tags_arr["module".($key+1)] = $result;
	}
}
$module_count = $newkey;



if( !empty($asset_files) )
{
	foreach ($asset_files as $asset_file)
	{
		if($asset_file['css']) $tags_arr['style-ext'] .= "\n\t\t".'<link rel="stylesheet" href="'.$tags_arr['fromroot'].'/assets/css/'.$asset_file['css'].'.css">';
		if($asset_file['js'])  $tags_arr['script-ext'] .= "\n\t\t".'<script src="'.$tags_arr['fromroot'].'/assets/js/'.$asset_file['js'].'.js"></script>';
	}
}

$tags_arr['jsVars']   = '<script> var jsVars = '.json_encode($jsVars).'; </script>';
$tags_arr['body_cls'] = ($tags_arr['body_cls']) ? ' class="'.trim($tags_arr['body_cls']).'"' : '';
if (!empty($pageCanonicalTags)) {
    $tags_arr['ex_meta_taga'] .= <<< H
\n\t{$pageCanonicalTags}
H;
}
###############################################################################################################################
## Echo Result Page
##############################################################################################################################
require "$incdir/resultPage.php";                                       ## Result page file

// ob_start("ob_gzhandler");
// ob_start("sanitize_output");
echo $result_page;                                                      ## Echo page
// ob_end_flush();

exit();

?>
