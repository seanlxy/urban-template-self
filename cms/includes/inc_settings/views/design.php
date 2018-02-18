<?php

$designContentView = '';

//Company logo
##------------------------------------------------------------------------------------------------------
$companyLogoView = <<< H
    <table class="company-logo-input">
        <tr>
            <td width="100"><label for="company_logo_path">Logo:</label></td>
            <td>
            <input name="company_logo_path" type="text" value="$company_logo_path" style="width:250px;" 
            id="company_logo_path" readonly autocomplete="off">
            <input type="button" value="browse" onclick="openFileBrowser('company_logo_path')"> 
            <input type="button" value="clear" onclick="clearValue('company_logo_path')"><br>
            <span class="text-muted"><small>Suggested size: 230x130px</small></span><br>
            <span class="text-muted"><small>For best results we recommend a transparent PNG file</small></span>
            </td>
        </tr>
    </table>
H;

$designContentView .= $companyLogoView;

//Color Palettes
##------------------------------------------------------------------------------------------------------

$colorPalettesSql = run_query("SELECT 
    `color_palette_id`,
    `color_palette_name`,
    `color_palette_id`,
    `color_palette_cms_preview_thumb_path`
    FROM `color_palettes`");

// preprint_r($color_palette_id);die();

if (mysql_num_rows($colorPalettesSql)) {
    
    while ($arrPalettes = mysql_fetch_assoc($colorPalettesSql)) {

        // $isChecked      = ( $color_palette_id == $arrPalettes['color_palette_id']) ? ' checked="checked"' : '';

        $palettesContent .= '<label for="'.$arrPalettes['color_palette_name'].'">'
            . '<input type="radio" id="'.$arrPalettes['color_palette_name'].'" name="palette_id" value="'.$arrPalettes['color_palette_id'].'"'
            .(($color_palette_id == $arrPalettes['color_palette_id']) ? ' checked' : '').' >'
            . '<span>'
                . '<img src="'.$htmladmin.$arrPalettes['color_palette_cms_preview_thumb_path'].'" alt="'
                . $arrPalettes['color_palette_name'].'">'
            . '</span>'
        .'</label>';



    //     $paletteStyleOptions .= '<li class="itemsel">
    //         <label class="checkbox-inline sel">
    //             <input class="do-sel" type="radio" name="palette_id" value="'.$arrPalettes['color_palette_id'].'"'.$isChecked.'> 
    //         </label>
    //         <img src="'.ADMIN_BASE_URL.$arrPalettes['color_palette_cms_preview_thumb_path'].'">
    //     </li>';

     }



   $designContentView .= '
    <hr>
    <label class="design-tab-label">Colour Palette:</label>
        <div class="img-radio-list">'.$palettesContent.'
    </div>';

       // $designContentView .= '
       //  <hr>
       //  <label class="design-tab-label">Colour Palette:</label>
       //      <ul class="selection-box padded">'.$paletteStyleOptions.'</ul>
       //  </div>';


}

//Font Selections
##------------------------------------------------------------------------------------------------------
$fontSelectView = <<< H
    <hr>
    <label class="design-tab-label">Fonts:</label>
    <section class="font-select">
        <label>Select Font 1: Headings and CTAs (Button Fonts):</label>
        <input id="webfont1" name="webfont_headings" value="{$webfont_headings}">
        <p class="webfont-preview-heading">Preview:</p>
        <p class="webfont-preview-1">
          The quick brown fox jumps over the lazy dog.
        </p>
    </section>
    <section class="font-select">
        <label>Select Font 2: All other text:</label>
        <input id="webfont2" name="webfont_text" value="{$webfont_text}">
        <p class="webfont-preview-heading">Preview:</p>
        <p class="webfont-preview-2">
          The quick brown fox jumps over the lazy dog.
    </section>
H;

$designContentView .= $fontSelectView;

//Slideshow Speed
##------------------------------------------------------------------------------------------------------

    $slideshowSpeedView = <<< H
    <hr>
    <table class="slideshow-input">
        <tr>
            <td width="150"><label for="slideshow_speed">Slideshow Speed:</label></td>
        </tr>
        <tr>
            <td><input name="slideshow_speed" type="text" value="$slideshow_speed" style="width:150px;margin-top: 5px;" id="slideshow_speed" value="5"/>  <strong>seconds</strong>
            </td>
        </tr>
        <br>

        
           
       
    </table>
H;



$designContentView .= $slideshowSpeedView;



 //Partner Logos
##------------------------------------------------------------------------------------------------------
$sqlQuery = "SELECT `id`,
                    `logo_label`,
                    `url_label`,
                    `url`,
                    `photo_path`,
                    `alt_text`
            FROM `partner_logos`
            WHERE `is_active` = 'Y'";

$sqlQuery .= " ORDER BY `rank` ";

$partnerlogos = fetch_all($sqlQuery);
    

    if (!empty($partnerlogos)) {

        $logos = '';

    foreach ($partnerlogos as $index => $partnerlogo) {

        $index++;

        $logos .= <<< H
        <tr>
            <td width="100" valign="top"><label for="logo-item-{$index}">{$partnerlogo['logo_label']}:</label></td>
            <td width="200" class="logo-input">
                <input type="hidden" name="logo-item-id[]" value="{$partnerlogo['id']}">
                <input type="text" style="width:180px" name="logo-item-path[]" value="{$partnerlogo['photo_path']}" id="logo-item-path{$index}">
                <input type="button" onclick="openFileBrowser('logo-item-path{$index}')" style="padding:1px 5px;height:25px;margin-top:5px;" value="Browse">
                <input type="button" style="height:25px;" value="clear" onclick="clearValue('logo-item-path{$index}')"><br>
            </td>
            <td width="80" valign="top"><label for="logo-item-{$index}" style="margin-left: 23px; margin-top: 2px";>{$partnerlogo['url_label']}:</label></td>
            <td style="vertical-align:initial;">
                <input type="hidden" name="logo-item-id[]" value="{$partnerlogo['id']}">
                <input type="text" style="width:200px;" name="logo-item-url[]" value="{$partnerlogo['url']}" id="logo-item-url{$index}">
            </td>
            <td width="80" valign="top"><label for="logo-item-{$index}" style="margin-left: 9px; margin-top: 2px;";>Alt Text:</label></td>
            <td style="vertical-align:initial;">
                <input type="hidden" name="logo-item-id[]" value="{$partnerlogo['id']}">
                <input type="text" style="width:210px; margin-left: 10px;" name="logo-item-alt[]" value="{$partnerlogo['alt_text']}" id="logo-item-alt{$index}">
            </td>
        </tr>
H;
    }

    $parterLogoView = <<< H
        <hr>
        <label class="design-tab-label">Partner Logos:</label>
        <p class="text-muted"><small>Suggested size: 230x130px</small></p>
        <table width="80%" class="partner-logos-table" border="0" cellspacing="0" cellpadding="4">
            {$logos}
        </table>
H;
    }
    else
    {
        $parterLogoView = '';    
    }

$designContentView .= $parterLogoView;


?>
