(function(){

	this.Beamer = function(opts){

		var defaults = {
			appendTo:'#campaign-body',
			sectionItem: '.section-item',
			sectionTypeDD: '.section-type-dd',
			sectionItemDD: '.section-item-dd',
			createItemBtn:'.add-section-item',
			removeItemBtn: '.remove-body-item',
			itemsAppendTo: '.body-items',
			createBtn:'#add-campaign-section',
			saveBtn:'.save-item',
			removeBtn:'.remove-item',
			previewBtn:'#campaign-preview',
			sendBtn:'#campaign-send',
			toggleBtn:'.toggle',
			tmplElmSection:'#campaign-section-tmpl',
			tmplElmItemDD: '#section-item-dd-tmpl',
			tmplElmItemBody: '#section-body-item-tmpl',
			sectionTypeArr: {'accommodations': 'Accommodation',
							 'blogs': 'Blog',
							 'pages': 'Pages'},
			serviceUrl:jsVars.baseUrl+'ajax/beamer/beamer.php',
			msgElm:'.action-msg'
		};

		this.options = $.extend(true, defaults, opts);
		
	};

	this.Beamer.prototype.init = function() {
		this.addNew();
		this.getAll();
		this.remove();
		this.updateItem();
		this.preview();
		this.sendBeamer();
		this.doAction();
		this.collapseItem();
		
		$(this.options.appendTo).on('keyup', '.section-heading', function(){
			var self = $(this),
				val = self.val(),
				lblElm = self.parents('.item').find('.head .title');

			lblElm.text(val).attr('title', val);
			
		});
		

	};

	this.Beamer.prototype.preview = function() {
		var ths = this, options = this.options;

		$(options.previewBtn).on('click', function(){
			var self = $(this),
			ind = self.data('token');

			var href  = jsVars.baseUrl+'?do=beamercampaigns&action=preview&token='+ind;
               
            if( href )
            {
                var winWidth = $(window).width();
                var winHeight = $(window).height();

                var popupWidth  = winWidth - 50;
                var popupHeight = winHeight - 50;
                
                var previewWindow = window.open (href,'Campaign Preview','menubar=0,resizable=1,width='+popupWidth+',height='+popupHeight+',location=0');
		
            } 
		});
	};

	this.Beamer.prototype.sendBeamer = function() {
		var ths = this, options = this.options;

		$(options.sendBtn).on('click', function(){
			var self = $(this),
			ind = self.data('token'),
			mod = $('#do').val();

			$.post(options.serviceUrl, 'action=send-beamer&token='+ind+'&do='+mod, function(response){
				ths.showFlashMsg( response.msg, response.state );
			}, 'json');
		});
	};

	this.Beamer.prototype.getAll = function( callback ) {
		var ths = this, options = this.options;

		var ths = this,
		    options = ths.options,
		    parentElm = $(options.appendTo),
		    _tmpl = _.template( $(options.tmplElmSection).html() ),
		    _tmplBodyItem = _.template( $(options.tmplElmItemBody).html() );

		if( parentElm.length )
		{
			$.post(options.serviceUrl, 'action=fetch&token='+parentElm.data('token'), function(response){

				parentElm.empty();

				_.each( response, function( item, i ){
					item.sectionType = options.sectionTypeArr;
					sectionInd = item.ind;
					bodyItems = item.bodyItems;

					parentElm.append( _tmpl( item ) );

					_.each( bodyItems, function( bodyitem, i ){
						$('#section-item-'+sectionInd).find(options.itemsAppendTo).append( _tmplBodyItem( bodyitem) );			
					});


				});

				if( typeof callback === 'function' ) callback.call();

			}, 'json');
		}
		
	};

	this.Beamer.prototype.addNew = function() {
		var ths = this, options = this.options;

		$(options.createBtn).on('click', function(){
			var self = $(this),
			ind = self.data('token');

			if( confirm('Are you sure you want to add a new section?') && ind )
			{
				$.post(options.serviceUrl, 'action=add&token='+ind, function(response){

					if( response.isValid )
					{
						ths.getAll();
					}

					ths.showFlashMsg( response.msg, response.state );

				}, 'json');
			}

		});
	};

	this.Beamer.prototype.remove = function() {
		var ths = this, options = this.options;

		$(options.appendTo).on('click', options.removeBtn, function(){
			var self = $(this),
			parentElm = self.parents('.item'),
			parentElmInd = parentElm.data('section-ind');

			if( confirm('Are you sure you want to delete this section?') && parentElmInd )
			{
				$.post(options.serviceUrl, 'action=remove&token='+parentElmInd, function(response) {

					if( response.isValid )
					{
						self.parents('.item').animate({height:0}, {duration:350, complete:function() {
							$(this).remove();
						}})
					}

					ths.showFlashMsg( response.msg, response.state );
					
				}, 'json');
			}

		});
	};

	this.Beamer.prototype.updateItem = function() {
		var ths = this, options = this.options;

		$(options.appendTo).on('click', options.saveBtn, function(){
            var self       = $(this),
                parentElm  = self.parents(options.sectionItem),
                sectionInd = parentElm.data('section-ind'),
				data 	   = parentElm.find('select , input').serialize();

			$.post(options.serviceUrl, 'action=save&section='+sectionInd+'&'+data, function(response){
				if( response.isValid )
				{
					ths.getAll();					
				}
				ths.showFlashMsg( response.msg, response.state );
			}, 'json');
        })
	};

	this.Beamer.prototype.doAction = function() {
		var ths = this, options = this.options;

		$(options.appendTo).on('change', options.sectionTypeDD, function(){
            var self       = $(this),
                parentElm  = self.parents(options.sectionItem),
                sectionInd = parentElm.data('section-ind'),
                sectionTypeLabel = self.find(':selected').data('label'),
                sectionType = self.val(),
                _tmpl = _.template( $(options.tmplElmItemDD).html() ),
                tragetDDElm = parentElm.find(options.sectionItemDD);

            parentElm.find(".section-heading").val(sectionTypeLabel);
            
            $.post(options.serviceUrl, 'action=fetch-items&type='+sectionType, function(response){
				if( response )
				{
					tragetDDElm.html( _tmpl( response ) );					
				}
			}, 'json');
        });

        $(options.appendTo).on('click', options.createItemBtn, function(){
            var self       = $(this),
                parentElm  = self.parents(options.sectionItem),
                sectionInd = parentElm.data('section-ind'),
                sectionType = parentElm.find(options.sectionTypeDD).val(),
                itemId 	 = parentElm.find(options.sectionItemDD).val(),
                itemRank = parentElm.find('.section-item-rank').val();
            if(sectionInd && itemId && itemRank)
            {
            	var data = '&type='+sectionType+'&section='+sectionInd+'&item='+itemId+'&rank='+itemRank;
	            $.post(options.serviceUrl, 'action=add-item'+data, function(response){
					if( response.isValid )
					{
						_tmplBodyItem = _.template( $(options.tmplElmItemBody).html() );
						//_.each( response.bodyItems, function( bodyitem, i ){
							parentElm.find(options.itemsAppendTo).append( _tmplBodyItem(response.bodyItems) );		
						//});										
					}
				}, 'json');
            }
            else
            {
            	var msg = 'Section item and rank can not be empty.',
            		state = 'danger';
            	ths.showFlashMsg( msg, state );
            }         
	            
        });

        $(options.appendTo).on('click', options.removeItemBtn, function(e){

            e.preventDefault();

            var self            = $(this),
                parentElm       = self.parents('.section-body-item'),
                grandParentElm  = parentElm.parents('.body-items'),
                itemInd         = self.data('item-ind');
            
            if(confirm('Are you sure you want to remove this item?') && itemInd){
                
                $.post(options.serviceUrl, 'action=remove-item&item='+itemInd, function(response){
                    if( response.isValid )
					{
						parentElm.animate({height:0}, {duration:350, complete:function() {
                            $(this).remove();
                    	}});			
					}
					ths.showFlashMsg( response.msg, response.state ); 
                }, 'json');               
            }            
        });
	};

	this.Beamer.prototype.collapseItem = function() {
		var ths = this, options = this.options;

		$(options.appendTo).on('click', options.toggleBtn, function(){
			var self = $(this),
			target = self.parents('.item'),
			targetIsCollapsed = target.hasClass('collapsed'),
			icon = self.find('.fa'),
			labelElm = self.find('span');
			
			if( !targetIsCollapsed ) {
				self.attr('title', 'Expand');
				icon.removeClass('fa-minus-square').addClass('fa-plus-square');
				target.addClass('collapsed');
				labelElm.text('Show');
			}
			else if( targetIsCollapsed ) {
				self.attr('title', 'Collapse');
				icon.removeClass('fa-plus-square').addClass('fa-minus-square');
				target.removeClass('collapsed');
				labelElm.text('Hide');
			}

			
		})
	};

	this.Beamer.prototype.showFlashMsg = function(msg, state) {
		var ths = this, options = ths.options;

		if( msg && state ) {

			$(options.msgElm).text('').removeAttr('class').addClass(options.msgElm.substr(1)).show().addClass('alert alert-'+state).text(msg);

			setTimeout(function(){
				$(options.msgElm).fadeOut();
			}, 4500);

		}
	};


}());

$(window).on('load', function(){

	var beamer = new Beamer({});

	beamer.init();

});