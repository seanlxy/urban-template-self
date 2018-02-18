<?php
############################################################################################################################
## Edit Meta
############################################################################################################################

function edit_meta(){

	global $message, $htmladmin, $disable_menu,$home_page, $menu_pages;

	$disable_menu = "true";
	$url_content="";
	$headings_content="";
	$keywords_content="";
	$descriptions_content="";
	$titles_content="";

	$sql = "SELECT *
                FROM general_pages
		WHERE page_status = 'A'
		AND page_id NOT IN(1)
		AND (page_mobile = '' OR page_mobile IS NULL)";
	$result = run_query($sql);

	while($row = mysql_fetch_assoc($result)){
		$page_id		= $row['page_id'];
		$page_url		= $row['page_url'];
		$page_label		= $row['page_label'];
		$page_title		= $row['page_title'];
		$page_mkeyw		= $row['page_mkeyw'];
                $page_seokeyw		= $row['page_seokeyw'];
		$page_mdescr             = $row['page_mdescr'];
		$page_heading		= $row['page_heading'];
		$page_introduction	= $row['page_introduction'];

		$titles_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td ><input type="text" name="page_title[]" value="$page_title" style="width:500px;"></td>
                                    </tr>
HTML;
		if ($page_id == 1) {
			$url_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td><input type="hidden" name="page_url[]" value=""></td>
                                    </tr>
HTML;
		}else {
			$url_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td ><input type="text" name="page_url[]" value="$page_url" style="width:500px;"></td>
                                    </tr>
HTML;
		}
		$headings_content .= <<< HTML
                                    <tr>
                                        <td><input type="hidden" name="page_id[]" value="$page_id">$page_label</td>
                                        <td ><input type="text" name="page_heading[]" value="$page_heading" style="width:500px"></td>
                                    </tr>
HTML;
		$keywords_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td ><textarea name="page_mkeyw[]" style="width:800px;" rows="2" >$page_mkeyw</textarea></td>
                                    </tr>
HTML;
                $seokeywords_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td ><textarea name="page_seokeyw[]" style="width:800px;" rows="2" >$page_seokeyw</textarea></td>
                                    </tr>
HTML;
		$descriptions_content .= <<< HTML
                                    <tr>
                                        <td>$page_label</td>
                                        <td><textarea name="page_mdescr[]" style="width:800px;" rows="3" >$page_mdescr</textarea></td>
                                    </tr>
HTML;
	}


	$url_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$url_content</table>";
	$titles_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$titles_content</table>";
	$headings_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$headings_content</table>";
	$keywords_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$keywords_content</table>";
        $seokeywords_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$seokeywords_content</table>";
	$descriptions_content="<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" >$descriptions_content</table>";

	$temp_array_metatagtab = array();

	$temp_array_metatagtab ['Page Titles']          = $titles_content;
	// $temp_array_metatagtab ['Headings']             = $headings_content;
	$temp_array_metatagtab ['Keywords']             = $keywords_content;
        // $temp_array_metatagtab ['SEO Keywords']         = $seokeywords_content;
	$temp_array_metatagtab ['Descriptions']         = $descriptions_content;
	// $temp_array_metatagtab ['URLs'] 		= $url_content;

	$counter = 0;
	$tablist = "";
	$contentlist = "";

	foreach($temp_array_metatagtab as $key => $value){
		$tablist .= "<li><a href=\"#tabs-".$counter."\">$key</a></li>";
		$contentlist .= " <div id=\"tabs-".$counter."\">$value</div>";
		$counter++;
	}

	$tablist="<div id=\"tabs\"><ul>$tablist</ul>$contentlist</div>";

	$page_functions = <<< HTML

     	<ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('savemeta',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
            <li><button type="button" class="btn btn-default" onclick="submitForm('cancel',1)"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</button>
            </li>
        </ul>
HTML;

	$page_contents = <<< HTML
                        <form action="$htmladmin/index.php" method="post" id="pageList" name="pageList" style="margin:0px;">
                            $tablist
                            <input type="hidden" name="action" value="" id="action">
                            <input type="hidden" name="do" value="pages">
			</form>
HTML;
	require "resultPage.php";
	echo $result_page;
	exit();
}

?>