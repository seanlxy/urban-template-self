<?php

include_once "{$classdir}/mobile_detect.php";


if( !function_exists('main_navigation') )
{
    $level = 0;



    function main_navigation($parent = 0, $current_page = '')
    {

        global $max_pages, $max_pages_generation, $level, $page_arr, $rootfull, $static_map_img, $page_accommodation;


        $sql = "SELECT gp.`id` AS page_id, pmd.`menu_label`, pmd.`title`, pmd.`full_url`, pmd.`url`, gp.`parent_id`
        FROM general_pages gp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = gp.`page_meta_data_id`)
        WHERE pmd.`status` = 'A'
        AND gp.`parent_id` = '$parent'
        AND (pmd.`menu_label` != '')
        ORDER BY pmd.`rank` ASC";

        $pages  = fetch_all($sql);


        $html   = '';

        if( !empty($pages) )
        {
            $total_pages = count($pages);

            foreach ($pages as $page)
            {

                $page_id              = $page['page_id'];
                $item_cls             = ($page['url'] === $current_page || $page_id === $page_arr['parent_id']) ? 'active' : '';
                $url                  = $page['full_url'];


                $sub_menu = '';
                $icon     = '';
                $icon2    = '';
                $home_cls = '';

                $sub_menu = main_navigation($page_id, $current_page );

                 if($page_id == $page_accommodation->id)
                {
                    //make sub menu from accommodations
                    $sql2 = "SELECT pmd.`menu_label`,pmd.`title`,pmd.`full_url`
                            FROM `accommodation` a 
                            LEFT JOIN `page_meta_data` pmd
                            ON(a.`page_meta_data_id` = pmd.`id`)
                            WHERE pmd.`status` = 'A'
                            AND pmd.`menu_label` != ''
                            ORDER BY pmd.`rank`";

                    $accom_arr = fetch_all($sql2);

                    $sub_menu = '<ul>';
                    foreach ($accom_arr as $accom) {
                        $sub_menu .= '<li><a href="'.$accom['full_url'].'" title="'.$accom['title'].'">'.$accom['menu_label'].'</a></li>';
                    }
                    $sub_menu .= '</ul>';
                }

                if( $sub_menu )
                {
                    $icon = '<i class="fa fa-angle-down toggle-sub-nav"></i>';
                    $icon2 = '<i class="fa fa-caret-down"></i>';
                    $item_cls .= ' has-sub';
                }

                //$page['menu_label'] = ($page_id == '1') ? '<i class="fa fa-home"></i>' : $page['menu_label'];
                
                if($item_cls) $item_cls = ' class="'.trim($item_cls).'"';
                
                $html .= '<li'.$item_cls.'>';
                $html .= '<a href="'.$url.'" title="'.$page['title'].'">'.$page['menu_label']. $icon2.'</a>';
                $html .= $icon;
                $html .= $sub_menu;
                $html .= '</li>';


            }



            return sprintf('<ul>%s</ul>', $html);

        }

        return $html;
    }
}

$menu = main_navigation(0, $page);

$tags_arr['nav-main'] = ($menu) ? '<nav id="primary-nav" role="navigation">'.$menu.'</nav>' : '';

?>