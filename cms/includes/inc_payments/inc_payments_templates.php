<?php


function templates()
{
	global $message, $id, $htmladmin, $do, $obj_payment,
		$disable_menu, $valid, $main_heading, $js_vars;


	$disable_menu      = "true";
	$valid             = 1;
	$pr_templates_view = '';

    $main_heading = "Payment Requests - Templates";


	$pr_template_id        = filter_input(INPUT_GET, 'tmpl-id', FILTER_VALIDATE_INT);
	

	if( filter_input(INPUT_POST, 'update-tmpl', FILTER_VALIDATE_INT) === 1 )
	{
		$template_id                 = filter_input(INPUT_POST, 'template_id', FILTER_VALIDATE_INT);
		$template_name               = filter_input(INPUT_POST, 'name');
		$template_short_description  = filter_input(INPUT_POST, 'short_description');
		$template_from_name          = filter_input(INPUT_POST, 'from_name');
		$template_from_email_address = filter_input(INPUT_POST, 'from_email_address', FILTER_VALIDATE_EMAIL);
		$template_subject            = filter_input(INPUT_POST, 'subject');
		$template_content            = filter_input(INPUT_POST, 'content');


		if( !empty($template_id) )
		{
			$tmpl_data = array();

			$tmpl_data['name']               = $template_name;
			$tmpl_data['short_description']  = $template_short_description;
			$tmpl_data['from_name']          = $template_from_name;
			$tmpl_data['from_email_address'] = $template_from_email_address;
			$tmpl_data['subject']            = $template_subject;
			$tmpl_data['content']            = $template_content;


			update_row($tmpl_data, 'pmt_template', "WHERE `id` = '{$template_id}'");

			$_SESSION['flash_msg'] = 'Changes has been saved successfully.';

			header("Location: {$htmladmin}?do={$do}&action=templates");
			exit();


		}
	}
    elseif( !empty($pr_template_id) )
    {

    	$pr_template_details = Payment::getTemplateDetails($pr_template_id);

    	if( !empty($pr_template_details) )
    	{

    		$main_heading = "Payment Request Template - {$pr_template_details['name']}";


    		$email_template_content = $pr_template_details['content'];

	        $template_tags = $obj_payment->getTemplateTags();

	        if( !empty($template_tags) )
	        {
	            foreach ($template_tags as $template_tag)
	            {
	                $js_vars['ckTags'][] = array(
	                    'label' => $template_tag['label'],
	                    'tag' => $template_tag['key']
	                );
	            }
	        }

    		$pr_templates_view = <<< H
    			<div id="tabs">
    			<div style="padding:10px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="8">
		                <tr>
		                    <td width="100" valign="top"><label for="name">Name:</label></td>
		                    <td>
		                        <input name="name" type="text" id="name" value="{$pr_template_details['name']}" style="width:350px;" />
		                        <input name="template_id" type="hidden" id="template_id" value="{$pr_template_id}" style="width:350px;" />
		                        <input name="update-tmpl" type="hidden"  value="1" />
		                    </td>
		                </tr>
		                <tr>
		                    <td width="100" valign="top"><label for="short_description">Short Description:</label></td>
		                    <td>
		                        <input name="short_description" type="text" id="short_description" value="{$pr_template_details['short_description']}" style="width:350px;" />
		                    </td>
		                </tr>
		                <tr>
		                    <td width="100" valign="top"><label for="from_name">From Name:</label></td>
		                    <td>
		                        <input name="from_name" type="text" id="from_name" value="{$pr_template_details['from_name']}" style="width:350px;" />
		                    </td>
		                </tr>
		                <tr>
		                    <td width="100" valign="top"><label for="from_email_address">From Email Address:</label></td>
		                    <td>
		                        <input name="from_email_address" type="email" id="from_email_address" value="{$pr_template_details['from_email_address']}" style="width:350px;" />
		                    </td>
		                </tr>
	                 	<tr>
		                    <td width="100" valign="top"><label for="subject">Subject:</label></td>
		                    <td>
		                        <input name="subject" type="text" id="subject" value="{$pr_template_details['subject']}" style="width:350px;" />
		                    </td>
		                </tr>
		                <tr>
		                    <td width="100" valign="top"><label for="content">Content:</label></td>
		                    <td>
		                        <textarea name="content" id="tmpl-content">{$email_template_content}</textarea>
		                    </td>
		                </tr>
		            </table>
		           <script>
		                CKEDITOR.replace( 'tmpl-content',
		                {
		                    toolbar : 'MyToolbar',
		                    forcePasteAsPlainText : true,
		                    resize_enabled : false,
		                    height : 600,
		                    extraPlugins:'tags',
		                    filebrowserBrowseUrl : jsVars.dataManagerUrl
		                });               
		            </script>
    			</div>
    		</div>
H;

			
			$page_functions = <<< HTML

           <ul class="page-action">
                <li>
                    <button type="button" class="btn btn-default" onclick="submitForm('update-tmpl', 1)"><i class="glyphicon glyphicon-floppy-save"></i> Update</button>
                </li>
                <li>
                    <a class="btn btn-default" href="{$htmladmin}/?do={$do}&action=templates"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                </li>
            </ul>
HTML;



    	}
	
	}
	else
	{

		$pr_templates = $obj_payment->getTemplates();

		if( !empty($pr_templates) )
		{

			foreach ($pr_templates as $pr_template)
			{

				$pr_templates_view .= '<tr title="'.$pr_template['short_description'].'">
	                <td align="left" width="200" height="25">'.$pr_template['name'].'</td>
	                <td align="left" width="200">'.$pr_template['from_name'].'</td>
	                <td align="left" width="200"><a href="mailto:'.$pr_template['from_email_address'].'">'.$pr_template['from_email_address'].'</a></td>
	                <td align="left" width="50"><a href="'.$htmladmin.'/?do='.$do.'&action=templates&tmpl-id='.$pr_template['id'].'" title="View template details">VIEW</a></td>
	            </tr>';
			}

			$pr_templates_view = '<table width="100%" class="bordered">
	            <thead>
	                <tr>
	                    <th align="left" width="200" height="25">NAME</th>
	                    <th align="left" width="200">FROM NAME</th>
	                    <th align="left" width="200">FROM EMAIL ADDRESS</th>
	                    <th align="left" width="50">VIEW</th>
	                </tr>
	            </thead>
	            <tbody>
	                '.$pr_templates_view.'
	            </tbody>
	        </table>';

	        $page_functions = <<< HTML

	           <ul class="page-action">
	                <li>
	                    <a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
	                </li>
	            </ul>
HTML;


		}


	}


   if ($message != "") {

        $page_contents .= <<< HTML
          <div class="alert alert-warning page">
             <i class="glyphicon glyphicon-info-sign"></i>
              <strong>$message</strong>
          </div>
HTML;
    }


	##------------------------------------------------------------------------------------------------------
	## tab arrays and build tabs

	$temp_array_menutab = array();

	$temp_array_menutab['Details'] = $pr_templates_view;


	$counter = 0;
	$tablist ="";
	$contentlist="";

	foreach($temp_array_menutab as $key => $value)
	{

	    $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";

	    $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";

	    $counter++;
	}


	// $tablist="<div id=\"tabs\"><ul>$tablist</ul><div style=\"padding:10px;\">{$contentlist}</div></div>";

	    $page_contents.="{$message}<form action=\"$htmladmin/?do={$do}&action=templates\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
	        {$pr_templates_view}
	    </form>";

	require "resultPage.php";
	echo $result_page;
	exit();
}

?>