<?php

$tags_arr['websitecredits'] = '';

# COPYRIGHT
    $company = $settings_arr['set_company'];
    $copyright = $settings_arr['copyright'] = <<<HTML
&copy; Copyright $runningyears.  $company.
HTML;

# SIGNATURE
    $signature = $settings_arr['signature'] = <<< HTML
<a href="http://tomahawk.co.nz">Website</a> Tomahawk
HTML;


# STRUCTURE

$websitecredits = <<< HTML
    $copyright<br/>
    $signature
HTML;

$tags_arr['websitecredits'] = $websitecredits;

?>