<?php

    // General Sitemap
    $sitemap_xml = '';
    $addedurls = array();


    // Change Sitemap Status
    run_query("UPDATE `general_settings` SET `set_sitemapstatus` = 'F' WHERE `id` = '1'");
    
//     // Get Pages from database

    $sql = "SELECT gp.`id`, pmd.`full_url`, UNIX_TIMESTAMP(pmd.`date_updated`) AS updated_on,
        (SELECT GROUP_CONCAT(`mod_id`) FROM `module_pages` WHERE `page_id` = gp.`id`) AS csv_mod_id
        FROM `general_pages` gp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = gp.`page_meta_data_id`)
        WHERE pmd.`status` = 'A'
        AND pmd.`url` != ''
        AND pmd.`page_meta_index_id` = '1'
        ORDER BY pmd.`rank`";

//     $pages_arr = fetch_all($sql);


//     if( !empty($pages_arr) )
//     {
    
//         // Add each page to XML structure
//         foreach($pages_arr as $key => $array)
//         {
//             $page_url = $array['full_url'];

//             $loc     = htmlentities("{$htmlroot}{$page_url}", ENT_QUOTES, 'UTF-8');
//             $lastmod = date('c', $array['updated_on']);
            
//             if( !in_array($loc,$addedurls) )
//             {

//                 $addedurls[] = $loc;
                
//                 $sitemap_xml = <<< XML
//     $sitemap_xml
//     <url>
//         <loc>$loc</loc>
//         <lastmod>$lastmod</lastmod>
//     </url>
// XML;

//                 $mod_id_arr = explode(',', $array['csv_mod_id']);

//             }
//         }
    
//     }



    $pages = fetch_all("SELECT pmd.`full_url`, UNIX_TIMESTAMP(pmd.`date_updated`) AS updated_on
        FROM `page_meta_data` pmd
        WHERE pmd.`status` = 'A'
        AND pmd.`url` != ''
        AND pmd.`page_meta_index_id` = '1'");


    if( !empty($pages) )
    {
        foreach ($pages as $page)
        {

            $page_url = $page['full_url'];

            $loc     = htmlentities("{$htmlroot}{$page_url}", ENT_QUOTES, 'UTF-8');
            $lastmod = date('c', $page['updated_on']);
            
            if( !in_array($loc, $addedurls) )
            {

                $addedurls[] = $loc;
                
                $sitemap_xml = <<< XML
    $sitemap_xml
    <url>
        <loc>$loc</loc>
        <lastmod>$lastmod</lastmod>
    </url>
XML;



            }
        }
    }


$sitemap_xml = <<< XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    $sitemap_xml
</urlset>
XML;

// Save XML to file

// Update Sitemap Status

run_query("UPDATE `general_settings` SET `set_sitemapstatus` = 'S' WHERE `id` = '1'");


$xmlfile = fopen('../../sitemap.xml','w');
fwrite($xmlfile,$sitemap_xml);
fclose($xmlfile);


// Save to robots.txt if not already in there

// Get robots.txt file
$robotstxt_path = "../../robots.txt";
$robotstxt = fopen($robotstxt_path,'w');
$robotstxt_contents = @fread($robotstxt,filesize($robotstxt_path));
$robotstxt_contents .= <<< TXT
Sitemap: $htmlroot/sitemap.xml 
TXT;

fwrite($robotstxt,$robotstxt_contents);
fclose($robotstxt);



// Sending XML to Google

    
file_get_contents("http://www.google.com/webmasters/tools/ping?sitemap=$htmlroot/sitemap.xml");

// Update Sitemap Status
run_query("UPDATE `general_settings` SET `set_sitemapstatus` = 'U' WHERE `id` = '1'");

// Sitemap Update Complete.

// Update Sitemap Status
run_query("UPDATE `general_settings` SET `set_sitemapstatus` = 'I' WHERE `id` = '1'");

// Log update time
run_query("UPDATE `general_settings` SET `set_sitemapupdated` = NOW() WHERE `id` = '1'");

?>