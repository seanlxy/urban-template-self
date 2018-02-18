<?php
############################################################################################################################
## Edit page
############################################################################################################################
function edit_item()
{


    global $htmladmin,$message,$id,$page_slidegroup,$do,$disable_menu,$valid, $pages_maximum, $pages_generations,
    $scripts_onload, $main_subheading, $main_heading, $htmlroot, $action;


    $messages = array(
        1 => 'Page heroshot is required'
    );

    $disable_menu = "true";

    $sql = "SELECT
                gp.`id`,
                gp.`slideshow_type`,
                gp.`parent_id`,
                gp.`publish_on_set_time`,
                gp.`publish_on`,
                gp.`hide_on`,
                pmd.`slideshow_id`,
                pmd.`gallery_id`,
                gp.`template_id`,
                gp.`access_level`,
                gp.`form_id`,
                -- pmd.`publish_on`,
                -- pmd.`hide_on`,
                -- pmd.`time_based_publishing`,
                pmd.`id` AS meta_data_id,
                pmd.`name`,
                pmd.`url`,
                pmd.`full_url`,
                pmd.`page_meta_index_id`,
                pmd.`menu_label`,
                pmd.`footer_menu`,
                pmd.`heading`,
                pmd.`sub_heading`,
                pmd.`introduction`,
                pmd.`quicklink_heading`,
                pmd.`quicklink_menu_label`,
                pmd.`photo`,
                pmd.`thumb_photo`,
                pmd.`photo_caption`,
                pmd.`title`,
                pmd.`meta_description`,
                pmd.`og_title`,
                pmd.`og_meta_description`,
                pmd.`og_image`,
                pmd.`short_description`,
                pmd.`page_js_code_head_close`,
                pmd.`page_js_code_body_open`,
                pmd.`page_js_code_body_close`,
                pmd.`quicklink_photo`

            FROM
                `general_pages` gp
            LEFT JOIN `page_meta_data` pmd ON
                (gp.`page_meta_data_id` = pmd.`id`)
            WHERE
                gp.`id` = '{$id}'
            LIMIT 1";

    $row = fetch_row($sql);


    if(empty($row))
    {
        header("Location: {$htmladmin}/?do={$do}");
        exit();
    }

    ##Create drop down for gallery
    $sql2 = "SELECT `id`, `name` FROM `photo_group` WHERE `type` = 'G'";

    $gallery_list = fetch_all($sql2);
    $gallery_view = '<select name="gallery_id" style="height:25px;width:200px;"><option value="">--Choose gallery--</option>';

    foreach ($gallery_list as $gallery) {

        $sel = ($gallery_id == $gallery['id']) ? 'selected' : '';
        $gallery_view .= '<option '.$sel.' value="'.$gallery['id'].'">'.$gallery['name'].'</option>';
    }

    $gallery_view .= '</select>';

    $meta_data_id             = $row['meta_data_id'];
    $page_url                 = $row['url'];
    $page_full_url            = $row['full_url'];
    $page_label               = $row['name'];
    $page_heading             = $row['heading'];
    $page_sub_heading         = $row['sub_heading'];
    $introduction             = $row['introduction'];
    $short_description        = $row['short_description'];
    $title                    = $row['title'];
    $meta_description         = $row['meta_description'];
    $og_title                 = $row['og_title'];
    $og_meta_description      = $row['og_meta_description'];
    $og_image                 = $row['og_image'];
    $page_meta_index_id       = $row['page_meta_index_id'];
    $page_photo               = $row['photo'];
    $page_thumb_photo         = $row['thumb_photo'];
    $page_photo_caption       = $row['photo_caption'];
    $menu_heading             = $row['menu_heading'];
    $quicklink_heading        = $row['quicklink_heading'];
    $quicklink_photo          = $row['quicklink_photo'];
    $quicklink_menu_label     = $row['quicklink_menu_label'];
    $quicklink_info           = $row['quicklink_info'];
    $quicklink_image          = $row['quicklink_image'];
    $slideshow_type           = $row['slideshow_type'];
    $slideshow_id             = $row['slideshow_id'];
    $gallery_id               = $row['gallery_id'];
    $template_id              = $row['template_id'];
    $page_menu                = $row['menu_label'];
    $page_footer              = $row['footer_menu'];
    $page_parentid            = $row['parent_id'];
    $page_accesslevel         = $row['access_level'];
    $publish_datetime         = $row['publish_on'];
    $hide_datetime            = $row['hide_on'];
    $form_id                  = $row['form_id'];
    $page_timebase_publishing = $row['publish_on_set_time'];
    $page_js_code_head_close       = $row['page_js_code_head_close'];
    $page_js_code_body_open        = $row['page_js_code_body_open'];
    $page_js_code_body_close       = $row['page_js_code_body_close'];

    $time_is_hidden         = ($page_timebase_publishing == 'N') ? ' class="hidden"' : '';
    $time_is_checked        = ($page_timebase_publishing == 'Y') ? ' checked="checked"' : '';

    $publish_datetime_obj = new DateTime($publish_datetime);
    $hide_datetime_obj    = new DateTime($hide_datetime);

    $publish_date = $publish_time = $hide_date = $hide_time = '';


    if($publish_datetime_obj->format('Y') != '-0001')
    {
        $publish_date =  $publish_datetime_obj->format('d/m/Y');
        $publish_time =  $publish_datetime_obj->format('H:i:s');
    }

    if($hide_datetime_obj->format('Y') != '-0001')
    {
        $hide_date =  $hide_datetime_obj->format('d/m/Y');
        $hide_time =  $hide_datetime_obj->format('H:i:s');
    }


    $ex_meg = (preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/',$page_url)) ? ' <i class="glyphicon glyphicon-arrow-left" style="margin:3px 0 0 10px"></i> please edit' : '';

    $main_subheading = 'Editing page: '.$page_label.'<a href="'.$htmlroot.$page_full_url.'" target="_blank">('.$htmlroot.$page_full_url.'</a>'.$ex_meg.')';


    $home_urls = array('/', 'home');


    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" id="pg-save" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
            <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
            </li>
        </ul>
HTML;

    ##------------------------------------------------------------------------------------------------------
    ## Modules

    $sql = "SELECT m.`mod_id`, m.`mod_name`,
        (SELECT modpages_rank FROM module_pages WHERE page_id = '$id' AND mod_id = m.`mod_id` LIMIT 1) AS mod_rank
        FROM modules m
        WHERE m.`mod_showincms` = 'Y'
        ORDER BY m.`mod_name`";


    $result = run_query($sql);
    $modules = "";

    while($row = mysql_fetch_assoc($result)) {

        $mod_id		= $row['mod_id'];
        $mod_name   = $row['mod_name'];
        $mp_rank	= $row['mod_rank'];

        $sel = ($mp_rank != "") ? ' checked="checked"' : '';

        $modules .= "<div class=\"md-row\"><input type=\"hidden\" name=\"mod_id[]\" value=\"$mod_id\" $sel>
            <label><input name=\"mp_rank[]\" type=\"text\" class=\"input-text\" style=\"width:35px;\" value=\"$mp_rank\"> &nbsp;$mod_name</label></div>";

    }
    $modules_content = <<< HTML
        <p><strong>Select the modules you would like included on this page by entering a rank number for each (Leave those you don't want)</strong></p>
        $modules
HTML;
    ##------------------------------------------------------------------------------------------------------
    ## Slideshows

    $slideshow_dd = '';


        $sql = "SELECT `id` AS ind, `name` AS label
        FROM `photo_group`
        WHERE `name` != ''
        AND `type` = 'S'
        AND `show_in_cms` = 'Y'
        ORDER BY `name`";

        $slideshow_dd = '<select name="slideshow_id" id="slideshow_id" style="width:250px"><option value="">Please Select Slideshow</option>';
        $slideshow_dd .= create_item_list($sql, $slideshow_id);
        $slideshow_dd .= '</select>';

        $slideshow_dd = <<< H
        <td width="130"><label for="slideshow_id">Slideshow:</label></td>
        <td>$slideshow_dd</td>
H;


    $forms_dd = '';

    $sql = "SELECT `id` AS ind, `name` AS label
        FROM `form`
        WHERE `status` = 'A'
        AND `xml_data` != ''
        ORDER BY `name`";
      
        $forms_dd = '<select name="form_id" id="form_id" style="width:250px"><option value="">-- select --</option>';
        $forms_dd .= create_item_list($sql, $form_id);
        $forms_dd .= '</select>';

        $forms_dd = <<< H
        
        <tr>
            <td width="200"><label for="form_id">Form</label></td>
            <td>$forms_dd</td>
        </tr>
H;

    $query = "SELECT `id` AS ind, `name` AS label
    FROM `photo_group`
    WHERE `name` != ''
    AND `type` = 'G'
    AND `show_in_cms` = 'Y'
    ORDER BY `name`";

    $gallery_dd = '<select name="gallery_id" id="gallery_id" style="width:250px"><option value="">Please Select Gallery</option>';
    $gallery_dd .= create_item_list($query, $gallery_id);
    $gallery_dd .= '</select>';

     $gallery_dd = <<< H
        <td width="130"><label for="gallery_id">Gallery Carousel:</label></td>
        <td>$gallery_dd</td>
H;

    $types = array(
        'D' => 'Default',
        'C' => 'Carousel'
    );

    $types_list = '';

    foreach ($types as $key => $value)
    {
       $types_list .= '<label class="radio-inline"><input'.( ($key == $slideshow_type) ? ' checked="checked"' : '' ).' type="radio" name="slideshow_type" value="'.$key.'"> '.$value.'</label>';
    }


    ##------------------------------------------------------------------------------------------------------
    ## Templates


    $tmpl_sql = "SELECT tn.`tmpl_id` AS ind, tn.`tmpl_name` AS label
    FROM `templates_normal` tn
    WHERE tn.`tmpl_showincms` = 'Y'";

    $template_dd = '<select name="template_id" id="template_id" style="width:250px">';
    $template_dd .= create_item_list($tmpl_sql, $template_id);
    $template_dd .= '</select>';


    $max_coulmns_dd = generate_num_dd(1, MAX_COLUMNS);


    ##------------------------------------------------------------------------------------------------------
    ## Content tabs

    $content_rows = fetch_all("SELECT `id`, `rank`
        FROM `content_row`
        WHERE `page_meta_data_id` = '{$meta_data_id}'
        ORDER BY `rank`");

    $content_view = '';

    if( !empty($content_rows) )
    {
        foreach ($content_rows as $inx => $content_row)
        {

$content_view .= <<< H

        <div class="row sortable-item clear" id="row-{$inx}">
H;

            $rank = $inx+1;

            $row_columns = fetch_all("SELECT `content`, `css_class`, `rank` FROM `content_column` WHERE `content_row_id` = '{$content_row['id']}' ORDER BY `rank`");

            foreach ($row_columns as $cindx => $row_column)
            {
                $content_view .= <<< H

                <div class="{$row_column['css_class']} res-col sortable-item" id="col-{$inx}-{$cindx}">
                    <ul class="action">
                        <li><input type="checkbox" class="col-merge" value="1"><li/>
                        <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                        <li><a href="#" data-to-remove=".res-col" title="click to remove section"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
                    </ul>
                    <div class="editable-column-content" title="Click to edit this content section.">
                        <textarea id="content-{$inx}-{$cindx}" name="content-{$inx}-text[]">{$row_column['content']}</textarea>
                    </div>
                    <input type="hidden" value="{$row_column['rank']}" class="col-rank" name="content-{$inx}-rank[]">
                    <input type="hidden" value="{$row_column['css_class']}" name="content-{$inx}-class[]" class="col-cls">
                </div>

H;
            }

           $content_view .= <<< H
            <input type="hidden" value="{$inx}" name="row-index[]">
            <input type="hidden" value="{$content_row['rank']}" name="row-rank[]" class="row-rank">
            <div class="clear"></div>
            <ul class="roww action">
                <li><a href="#" title="add new column to this row" class="add-col"><i class="glyphicon glyphicon-plus-sign"></i></a><li/>
                <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                <li><a href="#" title="click to remove row" data-to-remove=".row"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
            </ul>
        </div>

H;
        }
    }

    $main_content = <<< HTML
        <h2>Heading</h2>
        <p style="margin-bottom:20px;"><input name="page_heading" type="text" id="page_heading" value="$page_heading" style="width:800px;" /></p>
        <h2>Introduction</h2>
        <textarea name="introduction" class="check-max" style="width:800px; font-family: sans-serif, Verdana, Arial, Helvetica;" rows="5" id="introduction">$introduction</textarea>
                <br><span class="text-muted"><small>Introduction (including spaces) <em></em></small></span>
        <p>Add new row with &nbsp;<select name="column-num" id="column-num" class="column-num">
            {$max_coulmns_dd}
        </select> &nbsp;columns. <button type="button" class="add-row">Go</button></p>


        <div id="grid-holder" class="grid-holder">
            {$content_view}
        </div>


HTML;

    ##------------------------------------------------------------------------------------------------------
    ## Meta tags tab content

    $meta_content = <<< HTML
   <table width="100%" border="0" cellspacing="0" cellpadding="6" >
        <tr>
            <td width="150" valign="top"><label for="title">Title:</label></td>
            <td>
                <input name="title" type="text" id="title" class="check-max" value="$title" style="width:600px;"><br>
                <span class="text-muted"><small>Page titles should be under 65 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="meta_description">Meta Description:</label> <span class="tooltip" title="This description is hidden from the user but useful to some search engines and appears in search results"></span></td>
            <td>
                <textarea name="meta_description" class="check-max" style="width:600px; font-family: sans-serif, Verdana, Arial, Helvetica;" rows="5" id="meta_description">$meta_description</textarea>
                <br><span class="text-muted"><small>Meta descriptions should be between 150-160 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td width="150" valign="top"><label for="og_title">Open Graph Title:</label></td>
            <td>
                <input name="og_title" type="text" id="og_title" class="check-max" value="$og_title" style="width:600px;"><br>
                <span class="text-muted"><small>Page titles should be under 65 characters (including spaces) <em></em></small></span>
            </td>
        </tr>
        <tr>
            <td width="150" valign="top"><label for="og_image">Open Graph Photo:</label></td>
            <td>
                <input name="og_image" type="text" value="$og_image" style="width:350px;" id="og_image" readonly autocomplete="off">
                <input type="button" value="browse" onclick="openFileBrowser('og_image')">
                <input type="button" value="clear" onclick="clearValue('og_image')"><br>
            </td>
        </tr>
    </table>
HTML;

    //Making the list of Parent
    function generateParentList($list, $parent_id = 0, $disabled = "", $sel = '')
    {
        global $generation, $pages_generations, $id;

        if($parent_id == 0)
        {
            $list .= '<option value="0" '.$selected.'>This is the parent</option>';
        }


        $sql = "SELECT gp.`id`, gp.`parent_id`, pmd.`name`, pmd.`title`, pmd.`url`
                FROM `general_pages` gp
                LEFT JOIN `page_meta_data` pmd
                ON(gp.`page_meta_data_id` = pmd.`id`)
                WHERE pmd.`status` != 'H'
                AND pmd.`status` != 'D'
                AND gp.`parent_id` = '{$parent_id}'
                ORDER BY pmd.`rank`";
        $result = run_query($sql);

        $generation++;
        $indentation = '';
        for($i=1;$i<$generation;$i++){ $indentation .= '......'; }

        while($row = mysql_fetch_assoc($result)) {

            // Set all of this page's values
            $result_page_id             = $row['id'];
            $result_page_parentid       = $row['parent_id'];
            $result_page_url            = $row['url'];
            $result_page_title          = $row['title'];
            $result_page_label          = $row['name'];
            ## if this page's label is empty, then set it to be the page's title
            if($result_page_label==''){ $result_page_label = $result_page_title; }
            ## if this page's label is STILL empty, then set it to be the page's url
            if($result_page_label==''){ $result_page_label = $result_page_url;   }

            // Figure out whether or not to disable this page from being selected
            if( ($generation        >= ($pages_generations)   ) ||            ## if this page's generation exceeds the generation limit in the CMS settings
                ($result_page_id    == $id                      ) ||            ## if this page is the page that is currently being edited
                ($disabled          != ''                       )               ## if this page's parent is the page that is currently being edited
            ){
                $disabled = "disabled=\"disabled\"";                            ## disable the page from being selected
            }else{
                $disabled = "";                                                 ## the page can be selected
            }

            // Figured out whether or not to initially select this page on CMS-page-load
            if($sel == $result_page_id)
            {                              ## if the page's id matches the parent id of the page being edited
                $selected = "selected=\"selected\"";                            ## make this page initially selected on CMS-page-load
                $boldstart = "<b>";
                $boldend = "</b>";
            }else{
                $selected = "";                                                 ## do not initially select this page
                $boldstart = "";
                $boldend = "";
            }

            // Add this page to the dropdown menu
            $list .= <<< HTML
                    <option value="$result_page_id" $disabled $selected>$indentation$result_page_label</option>
HTML;
            // Get all of the children of this page.
            // put the $disabled parameter to make sure that if this page can not be selected, then all of its childeren should not be able to be selected.
            $list = generateParentList($list,$result_page_id,$disabled, $sel);
            // Reset the disabled variable to 'enabled' (effectively) so that all of the siblings of this page CAN be selected
            $disabled = '';
        }
        $generation--;
        return $list;
    }


    if( !in_array($page_url, $home_urls) )
    {
        $parentlist ="<select name=\"page_parentid\" style=\"width:250px\">";
        $parentlist = generateParentList($parentlist, 0, '', $page_parentid);
        $parentlist .= "</select>";
    }
    else
    {
        $parentlist = 'Sorry, this page can not be a child.';
    }

    $sql = "SELECT cmsset_value FROM cms_settings WHERE cmsset_name='pages_generations' LIMIT 1";
    $pagegenerations = fetch_value($sql);

    if($pagegenerations>1){
        $parentlist = <<< HTML

        <td width="130"><label for="page_parentid">Parent of this page</label></td>
        <td>$parentlist</td>

HTML;
    }else{
        $parentlist = '';
    }

    ##------------------------------------------------------------------------------------------------------
    ## Page Code

    $developer_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
                <td valign="top"><label for="page_js_code_head_close">Head Code</label></td>
                <td valign="top">
                    <textarea name="page_js_code_head_close" style="width:720px; height:150px;resize:none;" id="js_code_head_close">{$page_js_code_head_close}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code before closing head tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
            <tr>
                <td valign="top"><label for="page_js_code_body_open">Opening Body Code</label></td>
                <td valign="top">
                    <textarea name="page_js_code_body_open" style="width:720px; height:150px;resize:none;" id="js_code_body_open">{$page_js_code_body_open}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code after opening body tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
            <tr>
                <td valign="top"><label for="page_js_code_body_close">Closing Body Code</label></td>
                <td valign="top">
                    <textarea name="page_js_code_body_close" style="width:720px; height:150px;resize:none;" id="js_code_body_close">{$page_js_code_body_close}</textarea>
                    <span data-toggle="tooltip" data-placement="left" data-title="Insert code before closing body tag e.g Google Analytics, Facebook Pixel"></span>
                </td>
            </tr>
        </table>
HTML;


    ##------------------------------------------------------------------------------------------------------
    ## Settings tab content


    if( in_array($page_url, $home_urls) )
    {
        $url = <<< HTML
        <td></td>
        <td><input name="page_url" type="hidden" id="page_url" value="$page_url" data-cvalue="$page_url"> <span id="page_url_msg" class="text-danger"></span></td>
HTML;
    }
    else{
        $url = <<< HTML
        <td width="130"><label for="page_url">URL</label></td>
        <td><input name="page_url" type="text" id="page_url" value="$page_url" data-cvalue="$page_url" style="width:250px;" class="item-url" />
        <span id="page_url_msg" style="margin-left:10px;" class="text-danger"></span></td>
HTML;
    }

    $settings_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
                $url
            </tr>
            <tr>
                <td width="130"><label for="page_label">CMS Name:</label></td>
                <td><input name="page_label" type="text" id="page_label" value="$page_label" style="width:250px;"/></td>
            </tr>
            <tr>
                <td width="130"><label for="page_menu">Menu Label:</label> <span class="tooltip" title="Leave empty if you do not want it to appear on the main menu"></span></td>
                <td><input name="page_menu" type="text" id="page_menu" value="$page_menu" style="width:250px;" /></td>
            </tr>
            <tr>
                <td width="130"><label for="page_footer">Footer Menu Label:</label> <span class="tooltip" title="Leave empty if you do not want it to appear on the footer menu"></span></td>
                <td><input name="page_footer" type="text" id="page_footer" value="$page_footer" style="width:250px;" /></td>
            </tr>
            <tr>
                {$slideshow_dd}
            </tr>
            <tr>
                {$gallery_dd}
            </tr>
            <tr>
                {$forms_dd}
            </tr>
           <tr>
                <td width="130"><label for="photo">Page Heroshot:</label></td>
                <td>
                    <input name="photo" type="text" value="$page_photo" style="width:250px;" data-thumb-elm="#page_thumb_photo" id="photo" readonly autocomplete="off">
                    <input name="page_thumb_photo" type="hidden" value="$page_thumb_photo" id="page_thumb_photo" readonly autocomplete="off">

                    <input type="button" value="browse" onclick="openFileBrowser('photo')">
                    <input type="button" value="clear" onclick="clearValue('photo')"><br>
                </td>
            </tr>
            <tr>
                <td width="130"><label for="page_photo_caption">Heroshot Caption:</label></td>
                <td><input name="page_photo_caption" type="text" id="page_photo_caption" value="$page_photo_caption" style="width:250px;" /></td>
            </tr>
            <tr>
                <td width="130"><label for="template_id">Template:</label></td>
                <td>$template_dd</td>
            </tr>
            <tr>
                $parentlist
            </tr>
             <tr>
                <td width="100"><label for="page_timebase_publishing">Use time-based publishing?</label></td>
                <td colspan="3"><input name="page_timebase_publishing" type="checkbox" style="margin-left:0;" id="page_timebase_publishing" value="Y"$time_is_checked></td>
            </tr>

            <tr id="publish"$time_is_hidden>
                <td width="100">Publish Date</td>
                <td><input name="page_publish_date" type="text" style="width:200px;" id="page_publish_date" value="$publish_date"></td>

                <td width="100">Publish Time</td>
                <td><input name="page_publish_time" type="text" style="width:200px;" id="page_publish_time" value="$publish_time"></td>
            </tr>
            <tr id="hide"$time_is_hidden>
               <td width="100">Hide Date</td>
                <td><input name="page_hide_date" type="text" style="width:200px;" id="page_hide_date" value="$hide_date"></td>

                <td width="100">Hide Time</td>
                <td><input name="page_hide_time" type="text" style="width:200px;" id="page_hide_time" value="$hide_time"></td>
            </tr>
        </table>

        <script>
            $(function(){
                $('#page_publish_date, #page_hide_date').datepicker({
                    dateFormat:'dd/mm/yy'
                });

                var publishTimeStr = '{$publish_time}',
                hideTimeStr = '{$hide_time}',
                publishTimeArr = publishTimeStr.split(':'),
                hideTimeArr = hideTimeStr.split(':');



                $('#page_publish_time').timepicker({
                    hour:(publishTimeArr.length == 3) ? publishTimeArr[0] : '00',
                    minute:(publishTimeArr.length == 3) ? publishTimeArr[1] : '00',
                    second:(publishTimeArr.length == 3) ? publishTimeArr[2] : '00',
                    showSecond: true,
                    timeFormat: 'hh:mm:ss',
                    showTime:false
                });

                $('#page_hide_time').timepicker({
                    hour:(hideTimeArr.length == 3) ? hideTimeArr[0] : '00',
                    minute:(hideTimeArr.length == 3) ? hideTimeArr[1] : '00',
                    second:(hideTimeArr.length == 3) ? hideTimeArr[2] : '00',
                    showSecond: true,
                    timeFormat: 'hh:mm:ss',
                    showTime:false
                });


                $('#page_timebase_publishing').on('change', function(){

                    $('#publish, #hide').toggleClass('hidden');
                });
            });


        </script>
HTML;



    ##------------------------------------------------------------------------------------------------------
    ## Privacy tab content

    ##------------------------------------------------------------------------------------------------------
    ## Robot List - Index, Follow, No-Index, No-Follow, None, No-archive

    $robotslist = '';
    $robots = fetch_all("SELECT `id`, `name`, `title` FROM `page_meta_index`");

    if(count($robots) > 0)
    {
        foreach ($robots as  $robot)
        {
            $checked = ($robot['id'] === $page_meta_index_id) ? ' checked="checked"' : '';

           $robotslist .= <<< H
        <div style="margin-bottom:5px;">
            <label class="checkbox-inline">
                <span data-title="{$robot['title']}" data-placement="left" data-toggle="tooltip" style="margin-top:2px;"></span>
                <input type="radio"  value="{$robot['id']}" style="margin:2px 0 0 8px;vertical-align:text-top;" name="page_mrobots"{$checked}> {$robot['name']}
            </label>
        </div>

H;
        }
    }


    $privacy_content = <<< HTML
        <table width="100%">
            <tr>
                <td colspan="2"><strong>Edit the following settings with caution. If in doubt, leave them in their default values</strong></td>
            </tr>
            <tr>
                <td colspan="2"><p>&nbsp;</p></td>
            </tr>
            <tr>

                <td valign="top">Robots <span data-toggle="tooltip" data-placement="bottom" data-title="Restrict search engines from archiving this page, following links on this page etc. Hover over the selections to the right to see what they mean."></span></td>
               <td>$robotslist</td>
            </tr>
        </table>
HTML;

    ##------------------------------------------------------------------------------------------------------
    ## Quick Links tab content
    $quicklink_list = '<p><strong>Choose quicklinks to display on page</strong></p>';

    $ql_sql = "SELECT gp.`id`, pmd.`quicklink_heading`, pmd.`name`
        FROM `general_pages` gp
        LEFT JOIN `page_meta_data` pmd
        ON(gp.`page_meta_data_id` = pmd.`id`)
        WHERE pmd.`status` = 'A'
        AND gp.`id` != '{$id}'
        AND pmd.`quicklink_heading` != ''
        ORDER BY pmd.`rank`";

    $quicklinks = fetch_all($ql_sql);

    if( !empty($quicklinks) )
    {
        $attached_qls = fetch_value("SELECT GROUP_CONCAT(`quicklink_page_id`) FROM `page_has_quicklink` WHERE `page_id` = '{$id}'");

        $attached_qls_arr = explode(',', $attached_qls);

        $quicklink_list .= '<ul class="list-grid">';

        foreach($quicklinks as $quicklink)
        {
            $is_checked = (in_array($quicklink['id'], $attached_qls_arr)) ? ' checked="checked"' : '';

            $ql_label = ($quicklink['quicklink_heading']) ? $quicklink['quicklink_heading'] : $quicklink['name'];

            $quicklink_list .= '<li><label class="checkbox-inline"><input'.$is_checked.' type="checkbox" value="'.$quicklink['id'].'" name="quicklink_id[]"> <span>'.$ql_label.'</span></label></li>';
        }

        $quicklink_list .= '</ul>';
    }


    $link_snippets = <<< HTML
    <table width="100%" cellpadding="6" cellspacing="0" border="0">
        <tr>
            <td width="130"><label for="quicklink_heading">Quicklink Heading:</label></td>
            <td><input name="quicklink_heading" type="text" id="quicklink_heading" value="$quicklink_heading" style="width:300px;" /></td>
        </tr>
        <tr>
            <td width="130"><label for="quicklink_menu_label">Button Label:</label></td>
            <td><input name="quicklink_menu_label" type="text" id="quicklink_menu_label" value="$quicklink_menu_label" style="width:300px;" /></td>
        </tr>
        <tr>
            <td valign="top"><label for="short_description">Quicklink Description:</label></td>
            <td valign="top">
                <textarea maxlength="171" name="short_description" id="short_description" class="check-max" maxlength="200" style="width:730px;height:100px;">$short_description</textarea>
                <br><span class="text-muted"><small>Quicklink description should be maximum 170 characters (including spaces) <em> - 0 character typed</em></small></span>
            </td>
        </tr>
        <tr>
           <td><label>Quicklink Photo:</label></td>
           <td>
               <input name="quicklink_photo" type="text" id="quicklink_photo" value="$quicklink_photo" style="margin-right:5px;width:300px;height:25px;float:left;" />
               <input type="button" onclick="openFileBrowser('quicklink_photo')" style="height:25px;padding:1px 5px;" value="Browse">
               <input type="button" value="clear" onclick="clearValue('quicklink_photo')" style="height:25px;"><br>
           </td>
       </tr>

    </table>

HTML;

    ##------------------------------------------------------------------------------------------------------
    ## tab arrays and build tabs

    if( isset($_GET['msg']) )
    {
        $msg_key = $_GET['msg'];

        $message = ( isset($messages[$msg_key]) ) ? $messages[$msg_key] : '';

        if( $message )
        {
            $message_view = <<< H
            <div class="alert alert-warning page">
                <i class="glyphicon glyphicon-info-sign"></i>
                <strong>$message</strong>
            </div>
H;
        }
    }
    else
    {
        $message_view = '';
    }

    $temp_array_menutab = array();


    $temp_array_menutab['Content']         = $main_content;
    $temp_array_menutab['Modules']         = $modules_content;
    $temp_array_menutab['Meta Content']    = $meta_content;
    $temp_array_menutab['Page Code']       = $developer_content;
    $temp_array_menutab['Quicklinks']      = $quicklink_list;
    $temp_array_menutab['Quicklink Info']  = $link_snippets;
    $temp_array_menutab['Robots']          = $privacy_content;
    $temp_array_menutab['Page Settings']   = $settings_content;

    $counter = 0;
    $tablist ="";
    $contentlist="";

    foreach($temp_array_menutab as $key => $value) {
        $tablist.= "<li><a href=\"#tabs-".$counter."\">".$key."</a></li>";
        $contentlist.=" <div id=\"tabs-".$counter."\">".$value."</div>";
        $counter++;
    }

    $tablist="<div id=\"tabs\"><ul>".$tablist."</ul>".$contentlist."</div>";

    ##------------------------------------------------------------------------------------------------------
    ## produce the page

    $page_contents = <<< HTML
        <style>
            .md-row{
                margin:10px 0;
            }
        </style>
        <form action="$htmladmin/?do={$do}" method="post" name="pageList" enctype="multipart/form-data">
        {$message_view}
        $tablist
            <input type="hidden" name="action" value="" id="action">
            <input type="hidden" name="do" value="$do">
            <input type="hidden" name="id" value="$id">
            <input type="hidden" name="meta_data_id" value="$meta_data_id">
        </form>
HTML;

    require "resultPage.php";
    echo $result_page;
    exit();
}
?>
