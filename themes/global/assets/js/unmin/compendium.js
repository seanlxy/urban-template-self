var app = {
    config:{
        serviceUrl:'/requests/service',
        totalItems:[],
        isScrolling:false,
        calRequest:false
    },
    init:function(p)
    {
        this.config = $.extend(true, this.config, jsVars, p);

        this.toggleNav('.static-nav-toggle');
        this.loadMap();

        $(function(){

            var toggleWrap = $(".static-outer-wrap");

            $(window).scroll(function() {    
            var scroll = $(window).scrollTop();
               if (scroll >= window.innerHeight) {
           
                   toggleWrap.addClass("fixed");
                } else {
          
                  toggleWrap.removeClass("fixed");
                }
            });
         
        });

        //Smooth scroll
        $(document).on('click', 'a[href*="#"]:not([href="#"])', function(e) {
            if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top -100
                    }, 1000);
                    e.preventDefault();
                }
            }
        });
      
    },// init()

    getVar:function(property, obj)
    {
        if(obj.hasOwnProperty(property)) return obj[property];

        for(var prop in obj)
        {
            if(obj[prop].hasOwnProperty(property))
            {
                return obj[prop][property];
            }
        }
        
        return false;
    }, // getVar()

    getConfigItem:function(prop)
    {
        return this.getVar(prop, this.config);
    },// getConfigItem()




    toggleNav:function(elm)
    {

        var jElm = $(elm);

        if( jElm.length )
        {
            jElm.on('click', function(e){
                e.preventDefault();

                var self = $(this),
                    target = $('.static-nav-wrap');

                if( target.length )
                {
                    target.toggle();
                    $('.static-nav-toggle').toggleClass('active');
      
                }

            });

        }
    },

    loadMap:function()
    {
        if($('#map-canvas').length)
        {
            var latitude = app.getConfigItem('latitude'),
                longitude = app.getConfigItem('longitude'),
                zoomLevel = app.getConfigItem('zoomLevel'),
                address = app.getConfigItem('address');
                image = '/themes/global/graphics/map-marker.png',
                mapStyle = $.parseJSON(app.getConfigItem('mapStyles'));


            if(latitude && longitude)
            {
                // console.log('test');
                var map,
                windowWidth = $(window).width(),
                isDraggable = false;

                if(windowWidth > 992)
                {
                    isDraggable = true;
                }

                var mapOptions = {
                    zoom: parseInt(zoomLevel),
                    center: new google.maps.LatLng(latitude,longitude),
                    scrollwheel: false,
                    zoomControl:true,
                    draggable:isDraggable,
                    styles: mapStyle
                    // mapTypeId:google.maps.MapTypeId.ROADMAP
                };

                var infowindow = new google.maps.InfoWindow({
                    content: address
                });

                map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    map: map,
                    icon: image
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
    
            }

        }
    },



};// end of app