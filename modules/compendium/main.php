<?php


if($page == $page_compendium->url && $option1)
{

	$accommodation_url = $option1;

	$sql = "SELECT
		    MD5(c.`id`) AS hash_key,
		    c.`icon`,
		    c.`heading`,
		    c.`default_content`,
		    c.`is_generic`,
		    c.`has_dark_bg`,
		    c.`is_map`,
		    ahcs.`content`,
		    pmd.`name`,
		    a.`latitude`,
		    a.`longitude`,
		    a.`google_map_address`,
		    a.`address`
		FROM
		    `compendium_section` c
		LEFT JOIN `accommodation_has_compendium_section` ahcs
			ON (ahcs.`compendium_section_id` = c.`id`)
		LEFT JOIN `accommodation` a
			ON (ahcs.`accommodation_id` = a.`id`)
		LEFT JOIN `page_meta_data` pmd
			ON (pmd.`id` = a.`page_meta_data_id`)
		WHERE
		    c.`status` = 'A' AND pmd.`url` = '{$accommodation_url}'
		ORDER BY
		    c.`rank`";

	$all_sections = fetch_all($sql);

	if(!empty($all_sections))
	{

		require_once 'inc/map.php';
		require_once 'inc/nav.php';
		require_once 'inc/section_list.php';



	}

}else{
	header("Location: $htmlroot");
	exit();
}

?>
