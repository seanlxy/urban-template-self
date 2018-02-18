// General App
(function(w){

    w.App = function(){
        this.config = {
            serviceUrl:'/requests/service',
            loadedGalleries:{}

        };
    };

    w.App.prototype.init = function() {
        var ths = this;

        this.config = $.extend(true, this.config, jsVars);

        //this.toggleNav('.nav-toggle');
        //this.toggleSubNav('.toggle-sub-nav');
        //this.toggleNav('.header__nav__list-toggle');
       // this.toggleElm('.toggle-elm, .header__nav-trigger');    

        this.toggleNav('.nav-toggle');
        this.toggleSubNav('.toggle-sub-nav');
        this.toggleAccomSubNav('.sub-nav-toggle');         
        this.initNewsletterSignup('#news-signup-form');
        this.initSlickSlider('.slider');
        this.initFlexslider('.flexslider');
        this.initSlickCarousel('.testimonial-carousel');
        this.initCarousel('.gallery-carousel');
        this.initPhotoswipe('.gallery-carousel a');
        this.initShuffle('#shuffle');
        this.initMap();
        this.setHeaderContainer();
        this.matchElmHeight('.quicklinks-descr');

       // // Datepicker init---------------------
       //  $('#check-in').datepicker({
       //      dateFormat:'dd M yy',
       //      minDate:0
       //  });

        this.initDatepicker('check-in');
        this.initDateControl('date-control');
        // Scroll Top Trigger

        // Add smooth scrolling to all links
        $('.scroll').on('click', function(e){
            e.preventDefault();
            $('html, body').delay(100).animate({
               scrollTop: $("#main").offset().top-130
            }, 400);
        });

        $(document).on('ready', function(e){
            e.preventDefault();

            var scrollTo = $(window).height();
                scrollPoint = $(window).scrollTop();

            if( scrollPoint < scrollTo ) {
                $('html, body').delay(200).animate({ scrollTop: scrollTo }, { duration: 350 });
            }

        });

        $(window).on('resize',function(){
            app.setHeaderContainer();
        }).trigger('resize');

        // QUICKLINKS HOVER
        $('.quicklinks-heading').hover(
            function() {
              var id = $(this).data('id');
              $('.'+id).addClass('zoomImage');
            },
            function(e) {
              var id = $(this).data('id');
              $('.'+id).removeClass('zoomImage');
            }
        );
        // END QUICKLINKS HOVER  
        
        //form
        $('.trigger-tc-modal').on('click', function(e){
            e.preventDefault();

            $('#tc-modal').modal({
                backdrop: 'static'
            }).on('hidden.bs.modal', function (e) {
               

               $(window).scrollTop(($('#tc').offset().top - 500))
            }).modal('show');

        });
        function changeCompBtnState(  ) {

            var tcEl    = $('#tc');
            var agEl    = $('#age-limit');
            var hasTcEl = (tcEl.length == 1);
            var hasAgEl = (agEl.length == 1);
            var compBtn = $('#form-submit-btn');
            var enableBtn = false;
            
            compBtn.addClass('disabled').attr('disabled', 'disabled');

            if( hasTcEl && hasAgEl && tcEl.is(':checked') && agEl.is(':checked') ) {

                enableBtn = true;

            } else if( hasTcEl && !hasAgEl && tcEl.is(':checked') ) {

                enableBtn = true;

            } else if( !hasTcEl && hasAgEl && agEl.is(':checked') ) {

                enableBtn = true;

            }

            if( enableBtn ) {
                compBtn.removeClass('disabled').removeAttr('disabled');
            }
        }


        $('#tc, #age-limit').on('change', changeCompBtnState);

        $('.accept-tc').on('click', function(e){
            e.preventDefault();
            $('#tc').attr({disabled: false, checked: true})
            changeCompBtnState();
        })
      
    };

    w.App.prototype.setHeaderContainer = function(){
        var windowWidth = $(window).width();
        if(windowWidth <= 991)
        {
            $('header').find('.container').addClass('container-fs');
        }
        else{
            $('header').find('.container').removeClass('container-fs');
        }
    };

    w.App.prototype.initDatepicker = function(field, opts) {

        field = document.getElementById( field );

        var defaults = { 
            field: field,
            format: 'DD/MM/YYYY',
            minDate: new Date()
        };

        opts = $.extend(true, defaults, opts);
        
        if( field ) {
            $(field).attr({autocomplete: 'off', readonly: true})
            var picker = new Pikaday(opts);
        }

        return picker;

    };
     w.App.prototype.initDateControl = function(field, opts) {

        fieldElm = $('.'+field);

        if(fieldElm.length) {
            
            fieldElm.each(function(index) {

                var filedId = $(this).attr('id'),
                    field   = document.getElementById( filedId );
                
                $(field).attr({autocomplete: 'off', readonly: true});

                new Pikaday({ 
                    field: field,
                    format: 'DD/MM/YYYY',
                    minDate: new Date()
                });

            });
        }
    };
    w.App.prototype.initSlickSlider = function (elm) {

        var slick = $(elm);

        slickInst = slick.slick({
            dots: false,
            infinite: true,
            speed: 600,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: (app.getConfigItem('slideshow_speed') * 1000),
            fade: true,
            cssEase: 'linear',
            arrows: true,
            prevArrow:'<span class="slider__nav slider__nav--prev"><i class="fa fa-angle-left"></i></span>',
            nextArrow:'<span class="slider__nav slider__nav--next"><i class="fa fa-angle-right"></i></span>',
            
            mobileFirst:true,
            adaptiveHeight:false,
        });
    };

    w.App.prototype.initFlexslider = function(elm, opts){

        var jElm = $(elm);

        if( jElm.length )
        {
            var ths = this;

            var defaults = {
                controlNav:false,
                directionNav:false,
                prevText:'',
                nextText:''
            };

            opts = $.extend(true, defaults, opts);

            jElm.flexslider(opts);

            $('.flexslider .prev').on('click', function(){
                jElm.flexslider('prev');
                return false;
            })

            $('.flexslider .next').on('click', function(){
                jElm.flexslider('next');
                return false;
            })


        }

    };

    w.App.prototype.initSlickCarousel = function (elm) {

        var slick = $(elm);

        slickInst = slick.slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 6000,
            fade: true,
            cssEase: 'linear',
            arrows: false,
            mobileFirst:true,
            adaptiveHeight:true,
        });
    };

    w.App.prototype.initCarousel = function (elm) {

        var slick = $(elm);

        slickInst = slick.slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow:'<div class="gallery__carousel__prev"><i class="fa fa-angle-left"></i></div>',
            nextArrow:'<div class="gallery__carousel__next"><i class="fa fa-angle-right"></i></div>',
            mobileFirst:true,
            adaptiveHeight:false,
            responsive: [
                {
                    breakpoint: 340,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                }, {
                    breakpoint: 590,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                },{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    };

    w.App.prototype.initPhotoswipe = function(elm){

        var jElm = $(elm);
        
        if(jElm.length)
        {
            var slides    = app.getConfigItem('galleryImages');

            var options = {
                index:0,
                shareEl:false,
                preload:[1,2],
                history:false,
                bgOpacity:0.8
            };

            $.each(slides, function(i, item){
                slides[i].src   = item.full_path;
            });
            
            jElm.on('click', function(e){
                e.preventDefault();

                options.index = $(this).data('key');
               
                var gallery = new PhotoSwipe( $('.pswp').get(0), PhotoSwipeUI_Default, slides, options);
                gallery.init();
            });            
        }
    };

    w.App.prototype.initShuffle = function(elm){
        var jElm = $(elm),
        ths = this;

        if(jElm.length)
        {
            jElm.shuffle({
                group:'all',
                itemSelector:'figure',
                speed:450
            });

            $('.shuffle-trigger').on('click', function(e) {

                e.preventDefault();

                jElm.shuffle( 'shuffle', $(this).attr('data-group') );

                $('.shuffle-trigger').removeClass('active');
                $(this).addClass('active');
                
            });

            jElm.on('done.shuffle', function(){
                ths.initPhotoswipeShuffle(elm+' .img.ps-item');
            });
        }
    };

    w.App.prototype.initPhotoswipeShuffle = function(elm){

        var jElm = $(elm);
        
        if(jElm.length)
        {         
            var template = app.getConfigItem('templates').psGallery;

            if( $('.pswp').length == 0 )
            {
                $('body').append(template);
            }

            var options = {
                index:0,
                shareEl:false,
                preload:[1,2],
                history:false,
                bgOpacity:0.8
            };


            jElm.on('click', function(e){
                e.preventDefault();

                var self = $(this),
                group = self.data('gp'),
                siblings = $(elm).siblings('.filtered'),
                href = self.data('fpath'),
                photos = [];

                if( siblings.length )
                {
                    siblings.each(function(i, e){
                        var jE = $(e);
                        var src = jE.attr('data-fpath'),
                        title = jE.attr('title'),
                        size = jE.data('size').split('x');

                        photos.push({src:src, w:size[0], h:size[1], title:title});
                    });
                }


                if( photos.length )
                {
                   
                    var srcs = $.map(photos, function(photo, i) {
                       return photo.src;
                    });
                    
                    options.index = srcs.indexOf(href);
                   
                    var gallery = new PhotoSwipe( $('.pswp').get(0), PhotoSwipeUI_Default, photos, options);
                    
                    gallery.init();

                }
            });            
        }
    };

    w.App.prototype.initMap = function()
    {
        if($('#map-canvas').length)
        {
            var latitude = app.getConfigItem('latitude'),
            longitude = app.getConfigItem('longitude'),
            zoomLevel = app.getConfigItem('zoomLevel'),
            address = app.getConfigItem('address'),
            mapStyle = $.parseJSON(app.getConfigItem('mapStyles'));

            if(latitude && longitude)
            {
                var map,
                windowWidth = $(window).width(),
                isDraggable = false,
                image = '/themes/global/graphics/map-marker.png';

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
                    mapTypeId:google.maps.MapTypeId.ROAD,
                    styles: mapStyle
                };

                console.log(mapOptions);

                var infowindow = new google.maps.InfoWindow({
                    content: address
                });

                map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions)
                    ;

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
    

    w.App.prototype.getVar = function(property, obj){
        if(obj.hasOwnProperty(property)) return obj[property];

        for(var prop in obj)
        {
            if(obj[prop].hasOwnProperty(property))
            {
                return obj[prop][property];
            }
        }
        
        return false;
    };


    w.App.prototype.getConfigItem = function(prop)
    {
        return this.getVar(prop, this.config);

    };

    w.App.prototype.toggleNav = function(elm){
        
        var jElm = $(elm);

        if( jElm.length )
        {
            jElm.on('click', function(e){
                e.preventDefault();

                var self = $(this),
                    target = $('header nav');

                if( target.length )
                {
                    target.slideToggle("slow");
                    $('.nav-toggle').toggleClass('active');
                    $('body').toggleClass('no-scroll');
                }

            });
        }
    };


     w.App.prototype.toggleSubNav = function(elm){

        var jElm = $(elm);

        if( jElm.length )
        {
        
            jElm.on('click', function(e){
                e.preventDefault();
                
                var self = $(this),
                    target = self.parents('.has-sub').find('ul');

                if( target.length )
                {
                    target.toggleClass('active');
                    self.toggleClass('active');
                }

            }); 
        }
    };
    w.App.prototype.toggleAccomSubNav = function(elm){
        
        var jElm = $(elm);

        if( jElm.length )
        {
            jElm.on('click', function(e){
                e.preventDefault();
                var self = $(this),
                    target = $('main nav');

                if( target.length )
                {
                    target.toggle();
                    $('.sub-nav-toggle').toggleClass('active');
                    $('.nav-heading').toggleClass('hidden');
                }

            });
        }
    };

    w.App.prototype.toggleNav = function(elm){
        
        var jElm = $(elm);

        if( jElm.length )
        {
            jElm.on('click', function(e){
                e.preventDefault();

                var self = $(this),
                    target = $('header nav');

                if( target.length )
                {
                    target.fadeToggle(400);
                    $('.nav-toggle').toggleClass('active');
                    $('body').toggleClass('no-scroll');
                }

            });
        }
    };

    w.App.prototype.matchElmHeight = function(elm) {
        var jElm = (typeof elm == 'string') ? $(elm) : elm;

        if( jElm )
        {
            jElm.css('height','auto');

            var height = 0;

            jElm.each(function(i, el) {
                var jEl = $(el),
                elHeight = jEl.height();

                if( elHeight > height ) height = elHeight;
            });

            jElm.css('height', height);
        }
    };

    w.App.prototype.initNewsletterSignup = function(elm)
    {
        var jElm = $(elm);

        if(jElm.length)
        {

            var triggerBtn = jElm.find('#newsletter-submit');

            if(triggerBtn.length)
            {
                triggerBtn.on('click', function(e){
                    e.preventDefault();

                    var emailAddress =  $.trim(jElm.find('#signup-email').val()),
                    msg = '',
                    msgType = 'msg--error';


    
                    var msgHodler = jElm.find('.msg');

                    if(emailAddress)
                    {
                        var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        
                        if(emailRegex.test(emailAddress))
                        {
                            $.post(app.getConfigItem('serviceUrl'), 'action=sign-up&email='+emailAddress, function(response){
                              
                                if(response.msg)
                                {
                                    msgHodler.removeAttr('class').addClass('msg '+response.type).html(response.msg);
                                }


                                if(response.isValid)
                                {
                                    setTimeout(function(){
                                        msgHodler.removeClass(response.type).html('');
                                        jElm.find('#full-name').val('');
                                        jElm.find('#signup-email').val('');
                                        
                                    }, 5000);
                                }


                                return false;

                            }, 'json');
                        }
                        else
                        {
                            msg = 'Invalid email address provided.';
                        }
                    }
                    else
                    {
                        msg = 'Your email address is required.';

                    }


                    if(msg)
                    {
                        msgHodler.removeAttr('class').addClass('msg '+msgType).html(msg);
                    }

                });
            }
        }
    };

}(window));
var app = new App();