<?php

############################################################################################################################
## Save Testimonial Item
############################################################################################################################

function save_item()
{

    global $message,$id,$do,$disable_menu, $root, $rootfull, $rootadmin, $upload_dir;


    $compendium_section_data                    = array();
    $compendium_section_data['icon']            = $_POST['icon'];
    $compendium_section_data['heading']         = $_POST['heading'];
    $compendium_section_data['is_generic']      = $_POST['is_generic'];

    $compendium_section_data['has_dark_bg']      = $_POST['has_dark_bg'];
    $compendium_section_data['is_map']      = $_POST['is_map'];

    $compendium_section_data['default_content'] = $_POST['default_content'];
    
    update_row($compendium_section_data,'compendium_section', "WHERE id = '{$id}'");

    $message = "Item has been saved";

    
}

?>