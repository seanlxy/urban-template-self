(function(){

	var mapCanvas    = document.getElementById('gmap-canvas'),
		addedMarkers = [],
		map,
		mapStyles,
		marker;

	var mapElms = {

		ADDRESS_BTN: $('#get-map-address'),
		ADDRESS: $('#map_address'),
		TITLE: $('#marker_title'),
		MAP_LAT: $('#map_latitude'),
		MAP_LNG: $('#map_longitude'),
		MAP_ZOOM_LEVEL: $('#map_zoom_level'),
		MAP_MARKER_LAT: $('#map_marker_latitude'),
		MAP_MARKER_LNG: $('#map_marker_longitude'),
		MAP_STYLES: $('#map_styles')

	};

	function renderMap() {
		
		mapStylesStr = getElmVal('MAP_STYLES');
		mapStyles    = (mapStylesStr) ? $.parseJSON(getElmVal('MAP_STYLES')) : [];

		map = new google.maps.Map(mapCanvas, {
            center: {lat: parseFloat(getElmVal('MAP_LAT')), lng: parseFloat(getElmVal('MAP_LNG'))},
            zoom: parseInt(getElmVal('MAP_ZOOM_LEVEL')),
            styles:mapStyles,
            scrollwheel:false,
            draggable: true,
            mapTypeControl: false,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            },
            scaleControl: false,
            streetViewControl: false
        });

        var markerLat = getElmVal('MAP_MARKER_LAT'),
            markerLng = getElmVal('MAP_MARKER_LNG');

        if( markerLat && markerLng ) {

        	var mapMarkerPos = new google.maps.LatLng(markerLat, markerLng);

        	addMapMarker( mapMarkerPos );
        }
	}

	function removeMarkers() {

		_.each(addedMarkers, function(addedMarker){
			addedMarker.setMap(null);
		});

		addedMarkers = [];

	}

	function panToMarker( markerPos ) {

		if( map && markerPos ) {
			setTimeout(function(){
				map.panTo( markerPos );
			}, 300);
		}

	}

	function addMapMarker( markerPos, callback ) {

		if( map ) {

			removeMarkers();

			if( markerPos ) {

				var markerLat = markerPos.lat().toFixed(6),
					markerLng = markerPos.lng().toFixed(6);

				marker = new google.maps.Marker({
					position: markerPos,
					map: map,
					draggable: true
		        });

				getElmVal( 'MAP_MARKER_LAT', markerLat );
				getElmVal( 'MAP_MARKER_LNG', markerLng );

				

				google.maps.event.addListener(marker, 'dragend', function(event) {

					var dMarkerPos = this.position,
						dMarkerLat = dMarkerPos.lat().toFixed(6),
						dMarkerLng = dMarkerPos.lng().toFixed(6);

					getElmVal( 'MAP_MARKER_LAT', dMarkerLat );
					getElmVal( 'MAP_MARKER_LNG', dMarkerLng );

					getGeocoderData(dMarkerPos)

			    });

				if( marker ) addedMarkers.push(marker);
			}

			if( typeof callback === 'function' ) callback.call(null, markerPos);

		}
	}

	function updateCenter() {

		if( map ) {

			map.addListener('center_changed', function() {

				var mapCtr = this.getCenter(),
					newMapLat = mapCtr.lat().toFixed(6),
					newMapLng = mapCtr.lng().toFixed(6);

				if( newMapLat && newMapLng ) {

					getElmVal( 'MAP_LAT', newMapLat );
					getElmVal( 'MAP_LNG', newMapLng );

				}
		  	});

		  	map.addListener('click', function( event ) {
		  		
		  		addMapMarker(event.latLng, function(position){
		  			getGeocoderData(position);
		  		});
		  	});

		}

	}

	function updateZoomLvl() {

		if( map ) {

			map.addListener('zoom_changed', function() {

				var mapNewZoomLvl = parseInt(this.getZoom());

				if( mapNewZoomLvl ) {
					getElmVal( 'MAP_ZOOM_LEVEL', mapNewZoomLvl );
				}
			  
		  	});

		}

	}


	function refreshMap() {
		
	}

	function getElmVal(prop, val) {

		if( mapElms.hasOwnProperty(prop) ) {

			if( mapElms[prop].length == 1 && typeof mapElms[prop] === 'object' ) {

				if( val ) {
					mapElms[prop].val(val);
				}

				return mapElms[prop].val();

			}

		}

		return '';

	}

	function getGeocoderData( locationData, callback ) {

		var geocoder = new google.maps.Geocoder();

		var geocoderData = ( typeof locationData === 'string' ) ? { 'address' : locationData }  : { 'location' : locationData };

		geocoder.geocode( geocoderData, function( results, status ) {

	        if( status == google.maps.GeocoderStatus.OK ) {

	        	var markerPos = results[0].geometry.location;

	        	getElmVal('ADDRESS', results[0].formatted_address)

	        	if( markerPos && typeof callback === 'function' ) {
	        		callback.call(null, markerPos);
	        		panToMarker( markerPos );
	        	}
	            
	        } else {
	            alert( 'Geocode was not successful for the following reason: ' + status );
	        }

	    } );


	}

	function setAddress() {

		mapElms.ADDRESS_BTN.on('click', function(e){
			e.preventDefault();
			var address = getElmVal('ADDRESS');

			if( address ) {
				getGeocoderData( address, addMapMarker );
			} else {
				alert('Please provide valid address.');
			}

		});
	}


	function init() {
		renderMap();
		updateCenter();
		updateZoomLvl();
		setAddress();
	}

	if( mapCanvas ) {	

		$('#tabs').on('click', '#ui-id-3', function(e){
			e.preventDefault();
			var self = $(this);
			
			if( !self.hasClass('clicked') ) {
				init();
				self.addClass('clicked');
			}
		});
		
	}

}());