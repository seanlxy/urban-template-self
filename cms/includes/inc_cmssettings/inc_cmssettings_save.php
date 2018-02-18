<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_faq.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage FAQ
##
##
## ----------------------------------------------------------------------------------------------------------------------

function save_items() {
	global $message,$cmsset_value,$cmsset_status,$pages_maximum,$cmsset_id;
                    foreach($cmsset_id as $i => $j){
                        $this_row = $i+1;
                        $this_cmsset_id = $j;
                        $this_cmsset_value = $_REQUEST['cmsset_value_'.$this_cmsset_id];
                        $this_cmsset_status = $_REQUEST['cmsset_status_'.$this_cmsset_id];

                        if(isset($this_cmsset_status)){
                            $this_cmsset_status = 'A';
                        }else{
                            $this_cmsset_status = 'I';
                        }

                        $temp_array_publish['cmsset_value'] = $this_cmsset_value;
                        $temp_array_publish['cmsset_id'] = $this_cmsset_id;
                        $temp_array_publish['cmsset_status'] = $this_cmsset_status;
                        $end = "WHERE cmsset_id = '$this_cmsset_id'";
			update_row($temp_array_publish,'cms_settings',$end);

                        $message = "All CMS settings have been updated";
                    }
}

?>
