<?php
############################################################################################################################
## Save Meta
############################################################################################################################

function save_meta(){
    global $message,$page_id;

    $page_id            = $_REQUEST['page_id'];
    $page_url 		= $_REQUEST['page_url'];
    $page_heading 	= $_REQUEST['page_heading'];
    $page_title 	= $_REQUEST['page_title'];
    $page_mkeyw         = $_REQUEST['page_mkeyw'];
    $page_seokeyw         = $_REQUEST['page_seokeyw'];
    $page_mdescr        = $_REQUEST['page_mdescr'];

    for($i=0;$i<=count($page_id);$i++){
        $temp_array_savemeta['page_title']      = $page_title[$i];
        $temp_array_savemeta['page_mkeyw']      = $page_mkeyw[$i];
        // $temp_array_savemeta['page_seokeyw']    = $page_seokeyw[$i];
        // $temp_array_savemeta['page_url']        = $page_url[$i];
        $temp_array_savemeta['page_mdescr']     = $page_mdescr[$i];
        // $temp_array_savemeta['page_heading']    = $page_heading[$i];

        $end = "WHERE page_id='".$page_id[$i]."'";

        update_row($temp_array_savemeta,'general_pages',$end);
    }

    $message = "Meta tags have been saved";
}

?>