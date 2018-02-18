<?php

function get_social_links($sql, $use_alt = false)
{
	global $rootfull, $htmlroot, $page;
	$social_links = fetch_all($sql);

	$html = '';
	if(count($social_links) > 0)
	{


		foreach ($social_links as $social_link)
		{	$active = (($htmlroot.'/'.$page) === $social_link['url']) ? ' class="'.$social_link['element_class'].' active"' : ' class="'.$social_link['element_class'].'"';
			$target = ($social_link['is_external']) ? ' target="_blank"' : '';
			$placement = ' data-placement="'.$social_link['placement'].'"';

			if($social_link['use_icon'])
			{
				$elm = '<i class="'.$social_link['icon_cls'].'"></i>';
			}
			else
			{
				if($use_alt)
				{
					$icon_path = $social_link['second_icon_path'];
				}
				else
				{
					$icon_path = $social_link['icon_path'];
				}
				$src    = ($icon_path) ? image_to_base64($rootfull.$icon_path) : '';

				$elm = '<img src="'.$src.'" alt="'.$social_link['icon_alt'].'">';
			}

			if($social_link['has_widget'])
			{
				$html .= '<li'.$active.' title="'.$social_link['title'].'"'.$placement.'>'.$social_link['widget_blob'].'</li>';
			}
			else
			{
				$html .= '<li><a title="'.$social_link['title'].'"'.$target.' href="'.$social_link['url'].'">'.$elm.'</a></li>';
			}
		}

	}

	return $html;
}

$sql = "SELECT `url`, `title`, `icon_path`, `icon_alt`, `second_icon_path`, widget_blob, `placement`, `has_widget`, `is_external`, `element_class`,
		`use_icon`, `icon_cls`
		FROM `social_links`
		WHERE `is_active` = '1'
		AND `placement` = 'L'
		AND (`url` != '' OR `has_widget` = '1')
		ORDER BY `rank` ASC";

$social_links = get_social_links($sql);

$social = ($social_links) ? '<ul class="social-links">'.$social_links.'</ul>' : '';
$tags_arr['social'] = $social;


?>
