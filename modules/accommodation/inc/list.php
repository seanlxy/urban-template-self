<?php

$sql = "SELECT
		    a.`from_price`,
		    a.`beds`,
		    a.`sqm`,
		    a.`pax`,
		    pmd.`name`,
		    pmd.`short_description`,
		    pmd.`thumb_photo`,
		    pmd.`full_url`
		FROM
		    `accommodation` a
		LEFT JOIN `page_meta_data` pmd ON
		    (pmd.`id` = a.`page_meta_data_id`)
		WHERE
		    pmd.`status` = 'A'
		ORDER BY
		    pmd.`rank`";

$all_accom = fetch_all($sql);

if(!empty($all_accom))
{

	//$index = 0;
	$curCount=1;

	foreach ($all_accom as $accom) {
		//preprint_r($accom['thumb_photo']);die;
		//$index++;
		if($curCount%2==0){
			$col='second-ql-hero-img';
			$accom_items .=<<<H
				<div class="col-xs-12 ql-col hidden-sm-down">
					<div class="quicklink-block">
						<div class="col-sm-6 col-md-6 quicklink-details">
							<div class="quicklinks-heading">
								<h2><a href="{$accom['full_url']}">{$accom['name']}</a><hr></hr></h2>
							</div>
							<p class="quicklinks-descr  acco-quicklink-descr">{$accom['short_description']}</p>
							<div class="acco-quicklink-foot">
								<div class="quicklink-icons">
									<span class="quicklink-icons__stats"> <i class="fa fa-bed"></i> {$accom['beds']}</span>
								    <span class="quicklink-icons__stats"><i class="fa fa-user"></i> {$accom['pax']}</span>
 									<span class="quicklink-icons__stats"><i></i>SQM: {$accom['sqm']}</span>
								</div>
								<div class="price-quicklink">FROM: {$accom['from_price']}</div>
							</div>
							<div class="foot acco-foot">
								<a href="{$accom['full_url']}" class="btn btn-quicklink">Discover more<hr></a>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 quicklink-image">
                            <div class="second-ql-hero-img">
                                <a href="{$accom['full_url']}">
                                    <span style="background-image:url('{$accom['thumb_photo']}');" class="quick-'.$curCount.'">
                                    </span>
                                </a>
                            </div>
                        </div>
					</div>
				</div>
H;
			$curCount++;
		}else{
			$col='ql-hero-img';
			$accom_items .=<<<H
				<div class="col-xs-12 ql-col hidden-sm-down">
					<div class="quicklink-block">
						
						<div class="col-sm-6 col-md-6 quicklink-image">
                            <div class="ql-hero-img">
                                <a href="{$accom['full_url']}">
                                    <span style="background-image:url('{$accom['thumb_photo']}');" class="quick-'.$curCount.'">
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 quicklink-details">
							<div class="quicklinks-heading">
								<h2><a href="{$accom['full_url']}">{$accom['name']}</a><hr></hr></h2>
							</div>
							<p class="quicklinks-descr  acco-quicklink-descr">{$accom['short_description']}</p>
							<div class="acco-quicklink-foot">
								<div class="quicklink-icons">
									<span class="quicklink-icons__stats"> <i class="fa fa-bed"></i> {$accom['beds']}</span>
								    <span class="quicklink-icons__stats"><i class="fa fa-user"></i> {$accom['pax']}</span>
 									<span class="quicklink-icons__stats"><i></i>SQM: {$accom['sqm']}</span>
								</div>
								<div class="price-quicklink">FROM: {$accom['from_price']}</div>
							</div>
							<div class="foot acco-foot">
								<a href="{$accom['full_url']}" class="btn btn-quicklink">Discover more<hr></a>
							</div>
						</div>
					</div>
				</div>
H;
			$curCount++;
		}
		 	$accom_items .=<<<H
				<div class="col-xs-12 ql-col hidden-sm-up">
					<div class="quicklink-block">
						<div class="col-sm-6 col-md-6 quicklink-details">
							<div class="quicklinks-heading">
								<h2><a href="{$accom['full_url']}">{$accom['name']}</a><hr></hr></h2>
							</div>
							<p class="quicklinks-descr  acco-quicklink-descr">{$accom['short_description']}</p>
							<div class="acco-quicklink-foot">
								<div class="quicklink-icons">
									<span class="quicklink-icons__stats"> <i class="fa fa-bed"></i> {$accom['beds']}</span>
								    <span class="quicklink-icons__stats"><i class="fa fa-user"></i> {$accom['pax']}</span>
 									<span class="quicklink-icons__stats"><i></i>SQM: {$accom['sqm']}</span>
								</div>
								<div class="price-quicklink">FROM: {$accom['from_price']}</div>
							</div>
							<div class="foot acco-foot">
								<a href="{$accom['full_url']}" class="btn btn-quicklink">Discover more<hr></a>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 quicklink-image">
                            <div class="second-ql-hero-img">
                                <a href="{$accom['full_url']}">
                                    <span style="background-image:url('{$accom['thumb_photo']}');" class="quick-'.$curCount.'">
                                    </span>
                                </a>
                            </div>
                        </div>
					</div>
				</div>
H;

	}

	$accom_list = <<<H
		<section class="section section--slate quicklinks">
			<div class="container container-fw">
			  <div class="row">
				{$accom_items}
			  </div>
			</div>
		</section>

H;

	$tags_arr['mod_view'] = $accom_list;
}


?>