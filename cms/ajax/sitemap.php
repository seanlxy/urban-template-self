<?php

require_once ('../../utility/config.php'); ## System config file
if(!$c_Connection->Connect()) {

    echo "Database connection failed";
    exit;
}
$Message = "";
$c_Message	= $c_Connection->GetMessage();


$action = $_POST['action'];

switch($action){
    case('update'):
	echo 'Creating sitemap...';
	include_once("../includes/inc_sitemap/inc_sitemap_update.php");
	break;
    case('getstatus'):
	echo getSitemapStatus();
	break;
}

function getSitemapStatus(){
    $sql = "SELECT `set_sitemapstatus`
	    FROM `general_settings`
	    WHERE `id` = '1'
	    LIMIT 1";
    $statuscode = fetch_value($sql);
    switch($statuscode){
	case('I'):
	    return 'Complete';
	case('F'):
	    return 'Creating sitemap...';
	case('U'):
	    return 'Sending sitemap to Google...';
    }
}

exit;


?>