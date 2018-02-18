<?php

$body_cls = (!empty($is_home_page))? ' home' : '';

$slideshow_view = '<div class="heroshot heroshot--overlay'.((!empty($is_home_page)) ? ' heroshot--fs' : '').'" style="background-image: url('.$page_photo.');">
    '.(($page_photo_caption) ? '<div class="heroshot__caption"><p class="heroshot__caption__text">'.$page_photo_caption.'</p></div>' : '').$scroll_icon.'
</div><!-- /.heroshot -->';

$slideshow_view .= $booking;

?>