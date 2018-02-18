<?php



// MAP & LOCATION
if($latitude && $longitude)
{

    $marker   = "var markercoords = [$latitude,$longitude];";
    $mylatlng = "var myLatLng = new google.maps.LatLng($latitude, $longitude);";
    $hidemap  = 'display:none';

}
else
{
    $marker   = "var markercoords = [];";
    $mylatlng = "var myLatLng = new google.maps.LatLng(-36.8624287, 174.7583903);";
    $hidemap  = 'display:block';

}


$map_html = <<< HTML

<table style="width:100%;">
    <tbody>
    <tr>
        <td valign="top" style="width:180px;">
            <label>Google Map Address</label>
            <textarea style="height:75px;resize:none;width:150px" name="google_map_address" id="google_map_address">$google_map_address</textarea><br>
            <button style="margin-top:8px;" type="button" id="updatecoords">Update pin</button><br><br>
        </td>
        <td valign="top"><label>Map Location</label><br>
            <span style="color:#777;font-size:12px;">
                If the location of the pin below is incorrect, then simply drag and drop it to the correct location
            </span>
            <span style="color:#777;font-size:11px;display:block;margin:2px 0 5px 0;">
                If map canvas is not loaded correctly, Please <a href="#" id="reload-map">click here</a> to reload again.
            </span>
            <input type="hidden" id="latitude" name="latitude" value="$latitude">
            <input type="hidden" id="longitude" name="longitude" value="$longitude">
            <div id="map_overlay1" style="height:505px;line-height:305px;opacity: 0.5;color:#000;position:absolute;z-index:9999;text-align:center;width:750px;font-size:20px;$hidemap">Please enter an address and click 'update pin'</div>
            <div id="map_overlay2" style="background:#fff;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;height:505px;line-height:305px;opacity: 0.5;color:#000;position:absolute;z-index:999;text-align:center;width:750px;$hidemap"></div>
            <div id="map_canvas" style="border:1px solid #aaa;height:500px;width:746px;position:relative;display:block;visiblility:visible;"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqeRCfbUFp9cDWpnZPu1B8AnNnLCT9ZjQ"></script>
            <script>
                $(function(){

                    marker = ' ';
                    $('#updatecoords').click(function(e){
                        e.preventDefault();
                        marker.setMap(null);

                        var address = $('#google_map_address').val();

                        var form_param = 'action=get-coords&address='+address;

                        $.post('$htmladmin/ajax/ajax_functions.php', form_param ,function(data){

                            if(data)
                            {

                                var latitude = $('#latitude').val(data.lat);
                                var longitude = $('#longitude').val(data.lng);

                                $('#map_overlay1, #map_overlay2').remove();
                                var pos = new google.maps.LatLng(data.lat, data.lng)
                                marker = new google.maps.Marker({
                                    position:pos,
                                    map:map,
                                    title:"$name",
                                    zIndex: 1,
                                    draggable:true
                                });

                                map.setCenter(pos);

                                google.maps.event.addListener(marker, 'dragend', function (event) {

									var pos = this.getPosition();

                                    document.getElementById("latitude").value = pos.lat();
                                    document.getElementById("longitude").value = pos.lng();

                                });

                                $('textarea#google_map_address').val(data.formattedAddress);

                                google.maps.event.trigger(map, "resize");
                            }

                        },'json');

                        return false;
                    });

                    $marker

                    //maps
                    $mylatlng
                    var mapOptions = {
                        zoom:      13,
                        center:    myLatLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        disableDefaultUI: true,
                        mapTypeControl: false,
                        zoomControl: true,
                        scaleControl: true,
                        panControl: true,
                        scrollwheel:true
                    }



                    $("#map_canvas").empty();
                    var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);


                    if(markercoords)
                    {
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(markercoords[0], markercoords[1]),
                            map: map,
                            title:"$name",
                            zIndex:1,
                            draggable:true
                        });

                        google.maps.event.addListener(marker, 'dragend', function (event) {

                            document.getElementById("latitude").value = this.getPosition().lat();
                            document.getElementById("longitude").value = this.getPosition().lng();
                        });

                    }

                    $('#reload-map').on('click', function(){

                        var center = map.getCenter();
                        google.maps.event.trigger(map, "resize");
                        map.setCenter(center);

                    });

                    $('#tabs ul li a').on('click', function(e){
                        e.preventDefault();
                        if($(this).attr('href') === '#tabs-4')
                        {
                            $('#tabs-4').show();
                             var center = map.getCenter();
                            google.maps.event.trigger(map, "resize");
                            map.setCenter(center);
                        }
                    });

                });

            </script>
        </td>
    </tr>

    </tbody>
</table>

HTML;

?>
