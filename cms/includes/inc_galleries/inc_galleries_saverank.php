<?php

############################################################################################################################
## Save page positions
############################################################################################################################

function save_rank()
{

    global $message, $testm_id, $testm_rank, $htmladmin;

    $testm_id   = $_POST['testm_id'];
    $testm_rank = $_POST['testm_rank'];

    for($i=0;$i<=count($testm_id);$i++)
    {
        $temp_array_ranking = array();
        $temp_array_ranking['rank'] = $testm_rank[$i];

        $end = "WHERE id='".$testm_id[$i]."'";

        update_row($temp_array_ranking,'photo_group',$end);
    }
    
    $message = "Item ranking has been saved";
}

?>
