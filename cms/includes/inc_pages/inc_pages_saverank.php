<?php

############################################################################################################################
## Save page positions
############################################################################################################################

function save_rank()
{
    global $message, $page_rank, $page_id;

    
    for($i=0;$i<=count($page_id);$i++)
    {
		$temp_array_positions['rank'] = $page_rank[$i];
		$wherepageid                  = $page_id[$i];

		$end                          = "WHERE id = '$wherepageid'";
		
        update_row($temp_array_positions,'page_meta_data',$end);
    }
    
    $message = "Page ranking has been saved";
}

?>
