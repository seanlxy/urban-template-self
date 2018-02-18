<?php

$nav_items = '';
$sql = "SELECT a.`from_price`,
	pmd.`name`,pmd.`short_description`,pmd.`thumb_photo`,pmd.`full_url`,pmd.`url`
	FROM `accommodation` a
	LEFT JOIN `page_meta_data` pmd
	ON(pmd.`id` = a.`page_meta_data_id`)
	WHERE pmd.`status` = 'A'
	ORDER BY pmd.`rank`";

$all_accom = fetch_all($sql);

if(!empty($all_accom))
{
	foreach ($all_accom as $accom) 
	{	
		$active_cls = ($accom["url"] === $accom_url) ? ' active' : '';
		$hr_active_cls = ($accom["url"] === $accom_url) ? ' active-hr' : '';
		$nav_items .= '<li><a href="'.$accom["full_url"].'" class="grid__nav--link'.$active_cls.'">'.$accom["name"].'</a><hr class="'.$hr_active_cls.'"></li>';
	}
}

$tags_arr['sub_nav_view']  = <<<H

  	<section class="section section_padding--xs section-nav-grey accom-sub-nav">
	  	<div class="container">
	  		<div class="row hidden-md hidden-lg accom-container">
	  			<div class="col-xs-12">
	  				<div class="hidden-md hidden-lg">
	  					<div class="sub-nav-toggle">
	  						<i class="fa-ellipsis-h fa">
	  						</i>
	  						<div class="nav-heading">
	  							<span>more options</span>
	  						</div>
	  					</div>
	  					<div class="sub-nav-heading">
	  						<span>{$heading}</span>
	  					</div>
	  				</div>
	  			</div>
	  		</div>
	  		<div class="row">
                <div class="col-xs-12 text-center">
                	<nav id="accom-nav" role="navigation">
	     				<ul class="grid__nav">
							{$nav_items}
						</ul>
					</nav>
     			</div>	            	
        	</div>
        </div>
	</section>
H;
?>