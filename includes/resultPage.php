<?php
#### File: inc_resultPage.php

############################################################################################################################
## Insert the page items into their places (e.g. $page_arr['page-title'] -> ==page_title==)
############################################################################################################################
// Check Template

$sql = "SELECT tn.`tmpl_path`
    FROM `templates_normal` tn
    WHERE tn.`tmpl_id` = '$template_id'";                                    ## Select the URL for the template for the current page

$template = fetch_value($sql);

$result_page = file_get_contents("$tmpldir/$template");                     ## Load the template ready for template tag insertion

foreach($tags_arr as $key => $value)
{
    $result_page = str_replace('=='.$key.'==', $value, $result_page);       ## (template tag, tag value, result page)
}

?>