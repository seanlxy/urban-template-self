<?php
$blog_post_list = '';

//fetch the latest blog post
$post = fetch_row("SELECT pmd.`heading`, pmd.`title`, pmd.`full_url`, pmd.`short_description`, pmd.`description`,pmd.`thumb_photo`
            FROM `blog_post` bp
            LEFT JOIN `page_meta_data` pmd
            ON(pmd.`id` = bp.`page_meta_data_id`)
            WHERE pmd.`status` = 'A'
            ORDER BY bp.`date_posted` DESC
            LIMIT 1");

$blog_view = '';

if(!empty($post))
{
    $full_url         = $page_blog->full_url.$post['full_url'];
    $descr            = strip_tags($post['description']);
    $short_descr      = (strlen($descr) > 100) ? substr($descr, 0, 100).'...' : $descr;
    $long_description = substr($descr, 0, strpos($descr, '.')).'.';
    $thumb_photo      = $post['thumb_photo'];
    
    
    $blog_post_list .= <<<H
        <div class="grid__col__item">
            <div class="grid__col__img">
                <a href="{$full_url}" title="{$title}">
                    <span style="background-image:url({$thumb_photo})">
                    </span>
                </a>
            </div>
            <div class="grid__col__content">
                <h3 class="grid__col__heading blog__heading"><a href="{$full_url}" title="{$title}" class="btn--link btn--link-blue">{$post['heading']}</a></h3>
                <p>{$short_descr}</p>
                <a href="{$full_url}" title="{$title}" class="btn btn-brown">Continue Reading</a>
            </div>
        </div>
H;


    $tags_arr['blog_view'] .= $blog_post_list;

}

?>