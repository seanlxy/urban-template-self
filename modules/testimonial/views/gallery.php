<?php

//List single testimonial - Footer
$sql = "SELECT `person`,`detail` FROM `testimonial` WHERE `status` = 'A' ORDER BY RAND() LIMIT 1";
$testm_arr = fetch_all($sql);


if (empty($testm_arr)) {
	$tags_arr['no_testimonial_class'] = 'no-testimonial';
}

if (!empty($testm_arr)) {

	foreach ($testm_arr as $testm) {

	$detail = $testm['detail'];
	$person = $testm['person'];

	$testimonial .= <<<H
		<div class="item">
				<p class="detail">{$detail}</p>
				<p class="person">{$person}</p>
		</div>
H;

	}


$testimonial = <<<H
			<div class="col-xs-12 text-center ">
				<h1>What our previous guests have said</h1>
				{$testimonial}
				<p class="pb"><a href="{$page_testimonial->full_url}" class="btn btn-blue-ghost">Read More Reviews</a></p>
			</div>

H;

}

if ($page_url == $page_home->url) {

	if (!empty($testm_arr)) {

		$lg_link_class = '';

		if ($tripadvisor_widget_code) {

			$lg_link_class = 'lg-link';

			$tripadvisor_logo = '<div class="ta-logo-wrap"><img src="themes/global/graphics/ta_brand_logo.png" alt="Tripadvisor Logo"/></div>';

		}

		$reviews_link = '<div class="read-reviews-wrap '.$lg_link_class.'"><a class="read-reviews btn--review" href="'.$page_testimonial->full_url.'">Read our reviews</a>
		'.$tripadvisor_logo.'</div>';
		
		$tags_arr['content']  .= $reviews_link;
	}
    
}




?>
