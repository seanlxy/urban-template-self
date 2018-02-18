<?php

#### File: formatSettings.php
############################################################################################################################
## Format the Settings Array (input:$settings_arr) into useful settings (output:$settings_arr)
############################################################################################################################

global $settings_arr;

# CALCULATING YEARS
$startyear = $settings_arr['start_year'];
$thisyear  = date('Y');


if($startyear)
{
    $runningyears = ($thisyear > $startyear) ? "$startyear - $thisyear" : $thisyear;
}
else
{
    $runningyears = $thisyear;
}

$company = $settings_arr['company_name'];

# COPYRIGHT
$settings_arr['copyright'] = "&copy; $company";
$settings_arr['credits']   = 'Tourism websites by <a href="https://www.tomahawk.co.nz/our-work" target="_blank">Tomahawk Tourism</a>'."<br>Powered By Netzone CMS Ver {$cms_version}";

?>