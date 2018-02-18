<?php

$slideshow_view = '';
$body_cls     = '';

$is_home_page = ($main_page_id == $page_home->id);

require_once "views/booking.php";

$booking = <<<H
    <div class="booking-wrapper">
       {$booking}
    </div>

H;

$scroll_icon = <<<H
<span class="scroll">
<i class="fa fa-angle-down"></i>
</span>
H;

$scroll_icon = (!empty($is_home_page)) ? $scroll_icon : '';

if(!empty($slideshow_id ))
{
	require_once "views/slider.php";
}

else{
	$body_cls = "no-heroshot";
}


$tags_arr['body_cls'] .= " {$body_cls}";

$tags_arr['slideshow_view'] = $slideshow_view;


?>