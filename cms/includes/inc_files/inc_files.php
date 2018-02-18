<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_files.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 16 April 2010
##
## File Mangement System
##
## ----------------------------------------------------------------------------------------------------------------------

function do_main()
{

    global $valid, $htmladmin, $main_heading, $rootadmin, $root, $tmpldir, $admin_dir;

	$main_heading  = 'File Manager';
	$page_contents = '';

 	// $page_contents="<iframe src=\"$htmladmin/filemanager/index.html\" scrolling=\"no\" style=\"border:0px; height:600px; width:1000px;\"></iframe>";

	$manager_path = "$rootadmin/includes/inc_files/datamanager";

	$error_file = file_get_contents("$tmpldir/403.html");

	$user_id = fetch_value("SELECT `user_id` FROM `cms_users` WHERE `user_id` = '".sanitize_one($_SESSION['s_user_id'], 'sqlsafe')."' LIMIT 1");

 	if(is_dir($manager_path) && file_exists("{$manager_path}/init.php") && !is_dir("{$manager_path}/init.php"))
 	{
 		
 		if(isset($_SESSION['s_user_id']) && $user_id)
		{
			include_once "{$manager_path}/init.php";
		}
		else
		{
			echo $error_file;
			die();
		}

 	}
    
    require "resultPage.php";
    echo $result_page;
    exit();
}

?>
