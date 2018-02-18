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
	global $message,$access_id;
                    function changeStatusValue($name){
                            if(isset($name)){ return 'Y'; }
                            else{ return 'N'; }
                    }
                    foreach($access_id as $i => $j){
                        $this_row = $i+1;
                        $this_access_id = $j;

                        $temp_array_publish['access_users']             = $this_access_users               = changeStatusValue($_REQUEST['access_users_'.$this_access_id]);
                        $temp_array_publish['access_userpasswords']     = $this_access_userpasswords       = changeStatusValue($_REQUEST['access_userpasswords_'.$this_access_id]);
                        $temp_array_publish['access_useraccesslevel']   = $this_access_useraccesslevel     = changeStatusValue($_REQUEST['access_useraccesslevel_'.$this_access_id]);
                        $temp_array_publish['access_accessgroups']      = $this_access_accessgroups        = changeStatusValue($_REQUEST['access_accessgroups_'.$this_access_id]);
                        $temp_array_publish['access_cmssettings']       = $this_access_cmssettings         = changeStatusValue($_REQUEST['access_cmssettings_'.$this_access_id]);
                        $temp_array_publish['access_settings']          = $this_access_settings            = changeStatusValue($_REQUEST['access_settings_'.$this_access_id]);

                        $end = "WHERE access_id = '$this_access_id'";
			update_row($temp_array_publish,'cms_accessgroups',$end);

                        $message = "All CMS settings have been updated";
                    }
}

?>
