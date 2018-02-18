<?php

function get_partner_logos($sql)
{
	global $rootfull, $htmlroot, $page;
	$partner_logos = fetch_all($sql);


	$html = '';
	if(count($partner_logos) > 0)
	{

		foreach ($partner_logos as $partner_logo)
		 {	
			
			if($partner_logo['photo_path'] != 'NULL')
			{
			
					$html .= '<a href="'.$partner_logo['url'].'" target="_blank"><img src="'.$partner_logo['photo_path'].'" alt="'.$partner_logo['alt_text'].'"></a>';
			}
			else{

				$html .= '<img src="" alt="'.$partner_logo['alt_text'].'">';

			}
		}
	}

	return $html;
}

$sql = "SELECT
		    `url`,
		    `photo_path`,
		    `alt_text`
		FROM
		    `partner_logos`
		WHERE
		    `is_active` = 'Y'
		ORDER BY
		    `rank` ASC ";

$partner_logos = get_partner_logos($sql);

$partnerlogos = ($partner_logos) ? '<ul class="partner-logos">'.$partner_logos.'</ul>' : '';
$tags_arr['partnerlogos'] = $partnerlogos;

//echo $partnerlogos;die;


?>
