<?php
## ----------------------------------------------------------------------------------------------------------------------
## NetZone 1.0
## inc_settings.php
##
## Author: Ton Jo Immanuel, Tomahawk Brand Management Ltd.
## Date: 19 April 2010
##
## Manage Settings
##
##
## ----------------------------------------------------------------------------------------------------------------------

function do_main(){

    global $message,$valid,$htmladmin,$scripts_onload,$htmlroot, $main_heading;

    $action		= $_REQUEST['action'];
    $main_heading = "Sitemap";
    switch ($action) {

        case 'save':

            $return = save_item();
            break;

    }
   
    if ($message != "") {

        $page_contents .= <<< HTML
          <div class="alert alert-warning page">
             <i class="glyphicon glyphicon-info-sign"></i>
              <strong>$message</strong>
          </div>
HTML;
    }

    $sql = "SELECT UNIX_TIMESTAMP(`set_sitemapupdated`) as lastupdated, `set_sitemapstatus`
	    FROM general_settings
        WHERE `id` = '1'
	    LIMIT 1";
    $result = fetch_row($sql);
    $lastupdated 		= $result['lastupdated'];
    $lastupdated_formatted 	= date('j F Y',$lastupdated).' at '.date('g:i:s a',$lastupdated);
    $sitemapstatus 		= $result['set_sitemapstatus'];
    $xml_exists 		= (bool) file_exists("$htmlroot/Sitemap.xml");
    
    
    // Sitemap currently being updated
    if($sitemapstatus!='I'){
	$content = <<< HTML
<table style="width:100%">
    <tr>
	<td style="width:300px;" id="col1" valign="top">
	    Sitemap updating.
	</td>
	<td id="col2" valign="top">
	    <strong>Status:</strong> <span id="sitemapstatus"></span>
	</td>
    </tr>
</table>
HTML;

	$scripts_onload .= <<< JS
updateStatus();	
JS;
    }
    
    
    // Sitemap already exists
    elseif($lastupdated || $xml_exists){
	$content = <<< HTML
<table style="width:100%">
    <tr>
	<td style="width:300px;" id="col1" valign="top">
	    Date of last sitemap submission:
	</td>
	<td id="col2" valign="top">
	    <strong>$lastupdated_formatted</strong><br/>
	    <br/>
	    <input id="sitemapbt" class="update" type="button" value="Submit new Sitemap"/>
	</td>
    </tr>
</table>
HTML;
    }
    
    
    // Sitemap does not exist
    else{
	
	$content = <<< HTML
<table style="width:100%">
    <tr>
	<td style="width:300px;" id="col1" valign="top">
	    You have not yet created a Sitemap.
	</td>
	<td id="col2" valign="top">
	    <input id="sitemapbt" class="create" type="button" value="Create Sitemap"/>
	</td>
    </tr>
</table>
HTML;
    }
    
$scripts_onload .= <<< JS
$('#sitemapbt').click(function(){
    $('#col1').html('Sitemap Updating');
    $('#col2').html('<strong>Status:</strong> <span id="sitemapstatus">Creating sitemap...</span>');
    $.post('$htmladmin/ajax/sitemap.php','action=update',function(data){
	if(data){
	    $('#sitemapstatus').html(data);
	}
	updateStatus();
    },'html');
})

function updateStatus(){
    $.post('$htmladmin/ajax/sitemap.php','action=getstatus',function(data){
	if(data){
	    $('#sitemapstatus').html(data);
	}
	if(data!='Complete'){
	    $('body').retarder(1000,updateStatus);
	}else{
	    $('body').retarder(2000,reloadPage);
	}
    },'html');
}


function reloadPage(){
    window.location.reload();
}

$.fn.retarder = function(delay, method){
    var node = this;
    if (node.length){
	if (node[0]._timer_) clearTimeout(node[0]._timer_);
	node[0]._timer_ = setTimeout(function(){ method(node); }, delay);
    }
    return this;
};

JS;
   
   

   
        

       ##------------------------------------------------------------------------------------------------------
       ## tab arrays and build tabs

	$temp_array_menutab = array();

	$temp_array_menutab ['Sitemap Status'] 	= $content;

	$counter = 0;
	$tablist ="";
	$contentlist="";

	foreach($temp_array_menutab as $key => $value){

		$tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

		$contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

		$counter++;
	}

	$tablist="<div id=\"tabs\"><ul>".$tablist."</ul><div style=\"padding:10px;\">".$contentlist."</div></div>";

        $page_contents = <<< HTML
                        <form action="$htmladmin/index.php" method="post" name="pageList" enctype="multipart/form-data">
                            $tablist
                            <input type="hidden" name="action" value="" id="action">
                            <input type="hidden" name="do" value="settings">
                            <input type="hidden" name="id" value="$id">
                            <input type="hidden" name="set_id" value="$set_id">
                        </form>
HTML;
    require "resultPage.php";
    echo $result_page;
    exit();
}
function save_item(){

    global $message,$id,$do,$disable_menu;

    $set_id                                 = $_REQUEST['set_id'];
    $temp_array_save['set_company']         = $_REQUEST['set_company'];
    $temp_array_save['set_websitetitle']    = $_REQUEST['set_websitetitle'];
    $temp_array_save['set_country']         = $_REQUEST['cmbCountry'];
    $temp_array_save['set_region']          = $_REQUEST['cmbRegion'];
    $temp_array_save['set_city']            = $_REQUEST['cmbCity'];
    $temp_array_save['set_suburb']          = $_REQUEST['cmbSuburb'];
    $temp_array_save['set_street']          = $_REQUEST['set_street'];
    $temp_array_save['set_post_country']    = $_REQUEST['cmbPostCountry'];

    $temp_array_save['set_post_region']     = $_REQUEST['cmbPostRegion'];
    $temp_array_save['set_post_city']       = $_REQUEST['cmbPostCity'];
    $temp_array_save['set_post_suburb']     = $_REQUEST['cmbPostSuburb'];

    $temp_array_save['set_post_street']     = $_REQUEST['set_post_street'];
    $temp_array_save['set_post_code']       = $_REQUEST['set_post_code'];
    $temp_array_save['set_phone1']          = $_REQUEST['set_phone1'];
    $temp_array_save['set_phone2']          = $_REQUEST['set_phone2'];
    $temp_array_save['set_email']           = $_REQUEST['set_email'];
    $temp_array_save['set_analytics']       = $_REQUEST['set_analytics'];
    $temp_array_save['set_apikey']          = $_REQUEST['set_apikey'];
    $temp_array_save['set_startyear']       = $_REQUEST['set_startyear'];
    $temp_array_save['set_address']	    = $_REQUEST['set_address'];
    $temp_array_save['set_cancellations']   = $_REQUEST['set_cancellations'];
    $temp_array_save['set_paymentpolicy']   = $_REQUEST['set_paymentpolicy'];
    $temp_array_save['set_commissionrate']  = str_replace('%','',$_REQUEST['set_commissionrate']);
    $temp_array_save['set_bookingfee']		= $_REQUEST['set_bookingfee'];
    $temp_array_save['set_emailfooter']  = $_REQUEST['set_emailfooter'];
    $temp_array_save['link_facebook']  = $_REQUEST['link_facebook'];
    $temp_array_save['link_twitter']  = $_REQUEST['link_twitter'];
    
        if(update_row($temp_array_save, 'general_settings', "WHERE set_id = '1'")){
			$message = "Settings have been saved";
		};

    $imppage_id = $_REQUEST['imppage_id'];
    $page_id = $_REQUEST['page_id'];
    $i = 0;
    foreach($imppage_id as $key => $value){
        $end = "WHERE imppage_id = '$value'";
        $temp_array_save = '';
        $temp_array_save['page_id']     = $page_id[$i];
        update_row($temp_array_save, 'general_importantpages', $end);
        $i++;
    }


}

?>
