<?php

## ----------------------------------------------------------------------------------------------------------------------
## Edit page
function edit_item() {
    global $message,$id,$do,$disable_menu,$valid,$htmladmin,$rootadmin,$rootfull, $main_subheading;

    $disable_menu = "true";

    $row = fetch_row("SELECT LPAD(`id`, 4, 0) AS ind, TRIM(CONCAT(`first_name`, ' ', `last_name`)) AS name, `email_address`, `contact_number`,
            `comments`, DATE_FORMAT(`date_of_enquiry`, '%e %M %Y @ %h:%i %p') AS date_enquired
            FROM `enquiry`
            WHERE `id` = '$id'
            LIMIT 1");

    extract($row);

    $email_address = mail_to($email_address);

    $main_subheading = 'Enquiry from: '.$name;

    $comments = stripcslashes(nl2br($comments));

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

 $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('cancelpagesave',1)"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>
            </li>
        </ul>
HTML;
    
    
    $details_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="10" >
            <tr>
                <td width="120"><strong>Enquiry ID:</strong></td>
                <td>#$ind</td>
            </tr>
            <tr>
                <td width="120"><strong>Date of Enquiry:</strong></td>
                <td>$date_enquired</td>
            </tr>
            <tr>
                <td width="120"><strong>Name:</strong></td>
                <td>$name</td>
            </tr>
            <tr>
                <td width="120"><strong>Email:</strong></td>
                <td>$email_address</td>
            </tr>
            <tr>
                <td width="120"><strong>Phone/Mobile:</strong></td>
                <td>$contact_number</td>
            </tr>
            <tr>
                

                <td width="120"><strong>Comments:</strong></td>
                <td>$comments</td>
            </tr>
        </table>
HTML;


    ##------------------------------------------------------------------------------------------------------
    ## tab arrays and build tabs

    $temp_array_menutab = array();

    $temp_array_menutab ['Details'] 	= $details_content;

    $counter = 0;
    $tablist ="";
    $contentlist="";

    foreach($temp_array_menutab as $key => $value) {

        $tablist.= "<li><a href=\"#tabs-$counter\">$key</a></li>";

        $contentlist.=" <div id=\"tabs-$counter\">$value</div>";

        $counter++;
    }

    $tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">$contentlist</div></div>";

    $page_contents = <<< HTML
                        <form action="$htmladmin/index.php" method="post" name="pageList" enctype="multipart/form-data">
			    $tablist
                            <input type="hidden" name="action" value="" id="action">
                            <input type="hidden" name="do" value="enquiries">
                            <input type="hidden" name="id" value="$id">
                            <input type="hidden" name="lpage_id" value="$lpage_id">
                        </form>
HTML;
    require "resultPage.php";
    echo $result_page;
    exit();


}

?>
