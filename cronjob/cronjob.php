<?php 

require_once ('../utility/config.php');
// error_reporting(E_ALL);

if(!$c_Connection->Connect())
{
    echo "Database connection failed";
    exit;
}

if($debug)
{
    include_once $classdir.'/firephp/fb.php';
    FB::setEnabled($debug);
}


// $current_time = date('Y-m-d H:i:s');

$general_pages = fetch_all("SELECT `id`, `page_meta_data_id`, `publish_on`, `hide_on`
                            FROM `general_pages` 
                            WHERE `publish_on_set_time` = 'Y'");
            

foreach ($general_pages as $general_page) {

    $publish_query = "UPDATE `page_meta_data` SET `status` = 'A' 
                    WHERE `id` = {$general_page['page_meta_data_id']}
                    AND (NOW() BETWEEN '{$general_page['publish_on']}' AND '{$general_page['hide_on']}')
                    AND `status` = 'H'";
        
    $publish = run_query($publish_query);

}
foreach ($general_pages as $general_page) {
    
    $hide_query = "UPDATE `page_meta_data` SET `status` = 'H' 
                WHERE `id` = {$general_page['page_meta_data_id']}
                AND NOW() >= '{$general_page['hide_on']}'
                AND `status` = 'A'";

    $hide = run_query($hide_query);

}

 ?>