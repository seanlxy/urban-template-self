<?php
############################################################################################################################
## Add a new page
############################################################################################################################

function new_item()
{
	global $message,$id,$pages_maximum, $do;

	$now = date("Y-m-d H:i:s");
	
	$temp_array_new['name']               = 'Untitled';
	$temp_array_new['url']                = $now;
	$temp_array_new['date_created']       = $now;
	$temp_array_new['date_updated']       = $now;
	$temp_array_new['created_by']         = $_SESSION['s_user_id'];
	$temp_array_new['status']             = 'H';
	$temp_array_new['page_meta_index_id'] = 1;

    $meta_id = insert_row($temp_array_new,'page_meta_data');

    $id = insert_row(array('parent_id' => 0, 'page_meta_data_id' => $meta_id), 'general_pages');


    $message = "New page has been added and ready to edit";

    @include('inc_'.$do.'_edit.php');
    edit_item();
        
}

?>