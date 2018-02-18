<?php

$booking .= <<<H

<form action="/{$page_bookings->url}" method="post" class="form" role="form">
    <div class="form-group">
    <div class="check-in-text">Check in</div>
        <div class="input-group">
          <label class="input-group-addon" for="check-in"><i class="fa fa-calendar"></i></label>
          <input type="text" class="form-control" readonly id="check-in" value="" name="check-in" placeholder="Check-in date">
        </div>
    </div>
    <button type="submit" class="btn btn-green" value="1" name="check-avail" id="check-avail">Check Availability</button>
    <div class="clearfix"></div>
</form>

H;


?>