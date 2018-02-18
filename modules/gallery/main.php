<?php

$gallery_list_view = '';
$gallery_ids       = array();

require_once 'inc/views/nav.php';


if( !empty($gallery_ids) )
{

    $gallery_photos = fetch_all("SELECT `full_path`, `thumb_path`, MD5(`photo_group_id`) AS group_key,
        `photo_group_id`, CONCAT(`width`,'x',`height`) AS size, `caption`
        FROM `photo`
        WHERE `photo_group_id` IN (".implode(',', array_keys($gallery_ids)).")
        ORDER BY `photo_group_id`, `rank`");


    if( !empty($gallery_photos) )
    {
        $gallery_list_view .= '<div class="container visible-xs mobile--heading">
                                <h1>Our Photo Gallery</h1>
                               </div> ';
        $gallery_list_view .= '<div class="container container-fw"><div class="row"><div class="col-xs-12"><div class="galleries" id="shuffle">';
        $count=0;

        foreach ($gallery_photos as $photo)
        {

            $thumb_path      = $photo['thumb_path'];
            $thumb_full_path = "{$rootfull}{$thumb_path}";

            $img     = ( is_file( $thumb_full_path ) ) ? ' style="background-image:url('.$thumb_path.');"' : '';

            if($count == 0){

                $gallery_list_view .= '<figure class="col-xs-12 col-sm-4 first-img col-md-2 img ps-item" data-groups="[&#34;all&#34;,&#34;'.$photo['group_key'].'&#34;]" data-fpath="'.$photo['full_path'].'" data-size="'.$photo['size'].'" data-gp="'.$photo['group_key'].'" title="'.$photo['caption'].'">
                            <span'.$img.'></span>
                        </figure>';

            } else{
                $gallery_list_view .= '<figure class="col-xs-12 col-sm-4 other-img col-md-2 img ps-item" data-groups="[&#34;all&#34;,&#34;'.$photo['group_key'].'&#34;]" data-fpath="'.$photo['full_path'].'" data-size="'.$photo['size'].'" data-gp="'.$photo['group_key'].'" title="'.$photo['caption'].'">
                            <span'.$img.'></span>
                        </figure>';
            }
          $count++;
        }

        $gallery_list_view .= '</div></div></div></div>';

        $jsVars['templates']['psGallery'] = file_get_contents("{$tmpldir}/underscore/gallery.tmpl");
    }

}

$tags_arr['mod_view'] .= <<<H
    <section class="section gallery-img">
        {$gallery_list_view}
    </section>
H;

?>