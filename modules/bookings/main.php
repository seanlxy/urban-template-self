<?php

if($page == $page_bookings->url && $resbook_id){

    $extra_qs = '';
    
    if($_POST){

        $booking_date = $_POST['check-in'];

        if(validate_date($booking_date, 'D M d Y'))
        {
            $booking_date_obj = date_create_from_format('D M d Y', $booking_date);

            $extra_qs .= '&amp;dd='.$booking_date_obj->format('d').'&amp;mm='.$booking_date_obj->format('m').'&amp;yyyy='.$booking_date_obj->format('Y');
            $date = $booking_date == '' ? date('d M Y') : $booking_date;
            
        }
    }
    
    
    $tags_arr['content'] .= <<< H
    <div class="row">
        <div class="col-xs-12 text-center">
            <iframe style="background-color:transparent;height:390px;width:100%;margin-top:30px;" class="iframe" src="https://www.resbook.co.nz/art/guests/?pid={$resbook_id}&pmpid=&referrer=&availability=show&iframe=1&center=true{$extra_qs}" frameborder="0" scrolling="no"></iframe>
            <h1>Book Direct for Guaranteed Best Rates</h1>
        </div>
    </div>

H;
    
}

?>