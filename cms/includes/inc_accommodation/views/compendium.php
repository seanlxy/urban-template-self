<?php


$sql = "SELECT `id`, `heading`, `is_map`
FROM `compendium_section`
WHERE `is_generic` != '1'
AND `status` = 'A'
ORDER BY `rank`";

$result = fetch_all($sql);
$section_view = '';

if(!empty($result))
{
    foreach ($result as $key => $section) {

        $this_section_id = $section['id'];
        $this_accommodation_id = $id;
        $this_section_content = fetch_value("SELECT `content` FROM `accommodation_has_compendium_section` WHERE `accommodation_id` = '$this_accommodation_id' AND `compendium_section_id` = '$this_section_id'");

        $is_map = ($section['is_map'] == 1) ? 1 : 0;

        $section_view .= <<<HTML

            <tr>
                <td>
                    <label>{$section['heading']}</label>
                    <textarea name="compendium_content[]" id="section-{$key}" style="width:930px; height:150px;">{$this_section_content}</textarea>
                    <input type="hidden" value="{$this_section_id}" name="compendium_id[]" />
                    <input type="hidden" value="{$is_map}" name="is_map[]" />
                    <script type="text/javascript">
                        CKEDITOR.replace( 'section-{$key}',
                        {
                            toolbar : 'MyToolbar',
                            forcePasteAsPlainText : true,
                            resize_enabled : false,
                            height:500,
                            filebrowserBrowseUrl : jsVars.dataManagerUrl
                        });
                    </script>
                </td>
            </tr>

HTML;
    }
}

$compendium_html = <<< H
<table width="100%" border="0" cellspacing="0" cellpadding="10">
   {$section_view}
</table>
H;

?>
