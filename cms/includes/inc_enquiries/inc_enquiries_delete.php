<?php

############################################################################################################################
## Delete Enquiries
############################################################################################################################

function delete_item()
{
    global $message,$item_select;

    if(!empty($item_select))
    {
       $to_delete = implode(', ', $item_select);
        
        $query = "UPDATE `enquiry` SET status = 'D'  WHERE `id` IN ({$to_delete})";
	 	run_query($query);

        $message = "Selected items have been deleted";
    }
    else
    {
        $message = "Please select a item from the list";
    }
}

?>