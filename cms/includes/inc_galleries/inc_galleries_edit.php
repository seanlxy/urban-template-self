<?php
## ----------------------------------------------------------------------------------------------------------------------
## Edit page
function edit_item() {
    global $message,$id,$do,$disable_menu,$valid,$htmladmin,$rootadmin,$rootfull, $main_subheading, $do;

    $disable_menu = "true";


    $gallery = fetch_row("SELECT `name`, `menu_label`, `show_on_gallery_page`
        FROM `photo_group`
        WHERE `id` = '{$id}'
        AND `type` = 'G'
        AND `show_in_cms` = 'Y'
        LIMIT 1");

    if( empty($gallery) )
    {
        header("Location: {$htmladmin}?do={$do}");
        exit();
    }

    extract($gallery);


    $gchecked   = ($show_on_gallery_page === 'Y') ? ' checked="checked"':'';
    
    $main_subheading = 'Editing gallery: '.$name;

    ##------------------------------------------------------------------------------------------------------
    ## Page functions

    $page_functions = <<< HTML
        <ul class="page-action">
            <li><button type="button" class="btn btn-default" onclick="submitForm('save',1)"><i class="glyphicon glyphicon-floppy-save"></i> Save</button></li>
            <li><a class="btn btn-default" href="{$htmladmin}/?do={$do}"><i class="glyphicon glyphicon-arrow-left"></i> Cancel</a>
            </li>
        </ul>
HTML;



    $details_content = <<< HTML
        <table width="100%" border="0" cellspacing="0" cellpadding="6" >
            <tr>
                <td width="150"><label for="label">Name:</label></td>
                <td><input name="label" class="textbox" type="text" id="label" value="$name" style="width:300px;" /></td>
            </tr>
            <tr>
                <td width="150"><label for="menu_label">Gallery Label:</label></td>
                <td><input name="menu_label" class="textbox" type="text" id="menu_label" value="$menu_label" style="width:300px;" /></td>
            </tr>
            <tr>
                <td width="150"><label for="show_on_gallery_page">Show on gallery page:</label></td>
                <td><input name="show_on_gallery_page" type="checkbox" id="show_on_gallery_page" value="Y"{$gchecked} /></td>
            </tr>
        </table>
HTML;


    ##------------------------------------------------------------------------------------------------------
    ## Photos
    

    $photos = fetch_all("SELECT `full_path`, `thumb_path`, `rank`, `caption`, `name`, `alt_text`
        FROM `photo`
        WHERE `photo_group_id` = '{$id}'
        ORDER BY `rank`");


    $photos_html = '';

    
    if( !empty($photos) )
    {

        foreach ($photos as $photocount => $photo)
        {

            $photocount++;

            $full_path       = $photo['full_path'];
            $thumb_path      = $photo['thumb_path'];
            $rank            = $photo['rank'];
            $caption         = $photo['caption'];
            $name            = $photo['name'];
            $alt_text        = $photo['alt_text'];
            $photos_html .= <<< HTML

            <li id="photo_{$photocount}" class="img-thumbnail">
                <div class="actions">
                    <input type="text" value="{$rank}" name="photo-rank[]" style="text-align:center">
                    <a  href="#" title="Remove this photo" class="remove-photo"><i class="fa fa-times"></i></a>
                </div>
                <div class="img"><img src="{$full_path}"></div>
                <input type="text" placeholder="Caption" value="{$caption}" name="caption[]" style="width:160px;">
                <input type="text" placeholder="Name" value="{$name}" name="name[]" style="width:160px;">
                
                
                <input type="text" placeholder="Alt text" value="{$alt_text}" name="alt_text[]" style="width:160px;">
                <input type="hidden" value="{$thumb_path}" name="photo-thumb-path[]">
                <input type="hidden" value="{$full_path}" name="photo-full-path[]">
           </li>
HTML;
            
            
        }

       
    }

    
$photo_content = <<< HTML
<input type="hidden" id="tempPhoto" name="tempPhoto" value="">
<input type="hidden" id="lineValue" name="lineValue" value="$total_photos">
<div style="margin-bottom:10px;">
    <a href="javascript:;" onClick="addPhoto();" class="btn btn-primary" style="color:#fff">
        <i class="glyphicon glyphicon-plus-sign" style="vertical-align:text-top;margin:0px 4px 0 0"></i> add new photo
    </a>
</div>
<!--<p><strong>Suggested image size - W800xH500px (or H800xW500px)</strong></p>-->
<ul id="photos" class="grid">
    {$photos_html}
</ul>


<script type="text/javascript">

function addPhoto()
{
    var winl = (screen.width - 1000) / 2;
    var wint = (screen.height - 700) / 2;
    var mypage = jsVars.dataManagerUrl+"&NetZone=tempPhoto";
    var myname = "imageSelector";
    winprops = 'status=yes,height=700,width=1000,top='+wint+',left='+winl+',scrollbars=auto,resizable'
    win = window.open(mypage, myname, winprops)
    if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}

$('#photos').on('click', '.remove-photo', function(e){
    e.preventDefault();
    
    var self = $(this);
    self.parents('li').remove();

});

function SetUrl(p,w,h)
{
    var p;
    var w;
    var h;
    document.getElementById('tempPhoto').value=p;
    setNewPhoto();
}

function setNewPhoto()
{
    var ni = $('#photos');
    var numi = parseInt(ni.find('[id^="photo-"]').size(), 10);
    var num = (document.getElementById('lineValue').value -1)+ 2;
    numi.value = num;
    var newdiv = document.createElement('div');

    var divIdName = 'photo-'+num;

    newdiv.setAttribute('id',divIdName);

    newdiv.setAttribute('style','float:left; width:160px; height:180px; margin-right:10px; margin-bottom:10px;');
    var newPhotoUrl = document.getElementById('tempPhoto').value;

var newSlide = '<li id="photo-'+num+'" class="img-thumbnail">\
            <div class="actions">\
                <input type="text" value="" name="photo-rank[]" style="text-align:center">\
                <a  href="#" title="Remove this photo" class="remove-photo"><i class="fa fa-times"></i></a>\
            </div>\
            <div class="img"><img src="'+newPhotoUrl+'"></div>\
            <input type="text" placeholder="Caption" value="" name="caption[]">\
            <input type="text" placeholder="Name" value="" name="name[]">\
            <input type="text" placeholder="Alt text" value="" name="alt_text[]">\
            <input type="hidden" value="" name="photo-thumb-path[]">\
            <input type="hidden" value="'+newPhotoUrl+'" name="photo-full-path[]">\
       </li>';

ni.append(newSlide);


}
</script>
HTML;

    ##------------------------------------------------------------------------------------------------------
    ## tab arrays and build tabs

    $temp_array_menutab = array();

    $temp_array_menutab ['Settings'] 	= $details_content;
    $temp_array_menutab ['Photos']      = $photo_content;

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
                            <input type="hidden" name="do" value="{$do}">
                            <input type="hidden" name="id" value="$id">
                            <input type="hidden" name="lpage_id" value="$lpage_id">
                        </form>
HTML;
    require "resultPage.php";
    echo $result_page;
    exit();


}

?>