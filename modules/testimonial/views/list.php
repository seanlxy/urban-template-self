<?php

//List all testimonials - Reviews page
$sql = "SELECT `person`,`detail` FROM `testimonial` WHERE `status` = 'A' ORDER BY `rank`";
$testm_arr = fetch_all($sql);

if(!empty($testm_arr))
{
	$all_testm = '';
	$list = '';
	foreach ($testm_arr as $testm) {
		$detail = $testm['detail'];
		$person = $testm['person'];

		$list .= <<<H
				<blockquote>
					<p class="detail">{$detail}</p>
					<p class="person">{$person}</p>
				</blockquote>
H;

	}

	if ($tripadvisor_widget_code) {

		$all_testm = <<<H
		<div class="container">
        	<div class="row">
        		<div class="col-xs-12 col-md-4">
        			<div class="tripadvisor-wrapper">
        				{$tripadvisor_widget_code}
        			</div>
        		</div>
            	<div class="col-xs-12 col-md-8 text-center">
					{$list}
				</div>
			</div>
		</div>
H;

	}
	else{

		$all_testm = <<<H
		<div class="container">
        	<div class="row">
            	<div class="col-xs-12 text-center">
					{$list}
				</div>
			</div>
		</div>
H;

	}

}

?>
