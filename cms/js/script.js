var app = {
    config:{
        gridHolder:'#grid-holder', 
        triggerBtn:'.add-row',
        numColumns:'#column-num',
        maxCols:12
    },
    init:function(p)
    {
        var obj = this;
        obj.config = $.extend(true, obj.config, p);

        

        obj.buildGridContent();

        obj.removeCol('.remove-col');

        obj.mergeCols($('.row').find('.col-merge'));

        obj.enableCKeditor($('.res-col textarea'));

        obj.addColInRow();

        obj.initDatepicker('.ga-date', {minDate:''});

        obj.makeSortable('.grid-holder, .grid-holder > .row');

    },
    pad:function(number, length)
    {
        var str = '' + number;
        while (str.length < length)
        {
            str = '0' + str;
        }
     return str;
    }, // pad()
    getConfigItem:function(prop)
    {
        return this.getVar(prop, this.config);
    },
    setConfigItem:function(prop, value)
    {
       this.config[prop] = value;
    },
    getVar:function(property, obj)
    {
        
        if(property && typeof obj === 'object')
        {

            for(var prop in obj)
            {
                if(prop === property)
                {
                    return obj[property];
                }
                else if(typeof obj[prop] === 'object')
                {
                    return this.getVar(property, obj[prop]);
                }
            }
        }

        return false;
    },
    processTemplate:function(tmpl, data, isHtml)
    {
        
        var newTmpl = ( isHtml ) ? tmpl : $(tmpl).html();

        var _tmpl = _.template(newTmpl);

        return _tmpl(data);
    },
    updateColSpan:function(rowToUpdate)
    {
        if(rowToUpdate.length)
        {
            var cols = rowToUpdate.find('.res-col'),
            totalCols = cols.size(),
            maxCols = this.getConfigItem('maxCols');

            if(maxCols)
            {
                var colCls = 'col-xs-12 res-col sortable-item';  
                colCls = colCls+' col-sm-'+(maxCols/2);
                colCls = colCls+' col-md-'+(maxCols/totalCols);

                cols.attr('class', colCls);
            }
        }
    },
    initDatepicker:function(elm, options)
    {
        var elm = $(elm);
        if(elm.length)
        {
            var minField = $(elm.data('min-field')),
            maxField = $(elm.data('max-field'));
            var defaults = {
                dateFormat:'dd/mm/yy',
                minDate:0,
                changeMonth:true,
                changeYear:true,
                onSelect:function(selectedDate)
                {
                    if(minField.length)
                    {
                        minField.datepicker('option', 'minDate', selectedDate);
                        
                    }
                    if(maxField.length)
                    {
                        maxField.datepicker('option', 'maxDate', selectedDate);
                    }
                    
                }
            };

            defaults = $.extend(true, defaults, options);
            elm.datepicker(defaults);
        }
    },
    buildGridContent:function()
    {
        if(typeof CKEDITOR !== undefined)
        {
            var thisObj = this,
            triggerBtn = $(thisObj.getConfigItem('triggerBtn'));

            if(triggerBtn.length)
            {
                triggerBtn.on('click', function(e){
                    e.preventDefault();
                    var self = $(this);
                    var gridHolder = ( $( self.data('append-to') ).length ) ? $( self.data('append-to') ) : $(thisObj.getConfigItem('gridHolder'));
                    var prefix = (gridHolder.data('prefix')) ? gridHolder.data('prefix')+'-': '';


                    var numColumns = parseInt(self.siblings('.column-num').val());
                   
                    if(numColumns)
                    {
                        var template = jsVars.templates.contentRow;

                        if(template && typeof template != 'undefined')
                        {
                            var rowInex = (gridHolder.find('.row').size());



                            var processedTempl = thisObj.processTemplate(template, { prefix:prefix, rowIndex:rowInex, numColumns:numColumns, colIndex:'', colCls:'', i: 1}, true);
                            
                            gridHolder.append(processedTempl);
                            var recentRow = gridHolder.find('.row:last');

                            var newCols = recentRow.find('.editable-column-content textarea');

                            thisObj.enableCKeditor(newCols);

                            $('.grid-holder').sortable('refresh');

                            thisObj.makeSortable(recentRow);

           
                            thisObj.removeCol('.remove-col');

                            thisObj.mergeCols(recentRow.find('.col-merge'));

                            thisObj.addColInRow();
                        }
                    }
                });
            }
        }
        return false;
    },
    makeSortable:function(elm)
    {

        var jElm = (typeof elm === 'string') ? $(elm) : elm;

        if(jElm.length)
        {

            jElm.sortable({
                placeholder:'placeholder',
                handle:'.move-col',
                items:'> .sortable-item',
                helper:"clone",
                opacity:0.6,
                appendTo:'body',
                forcePlaceholderSize: true,
                start: function(e, ui){
                    ui.placeholder.css({padding:0,margin:0,borderRadius:0}).height(ui.item.height()).width(ui.item.width()).css({marginBottom:ui.item.css('margin-bottom')});
                    $(this).find('div.sortable-item:visible:first').addClass('real-first-child');
                }, 
                stop: function(event, ui) {
                    $(this).find('div.real-first-child').removeClass('real-first-child');
                },
                change: function(event, ui) {
                    $(this).find('div.real-first-child').removeClass('real-first-child');
                    $(this).find('div.sortable-item:visible:first').addClass('real-first-child');
                },
                update: function(event, ui) {
                   var sortableItems =  $(this).sortable('toArray');
                    _.each(sortableItems, function(item, a){

                        console.log(item)
                        
                       if($('#'+item).children('.col-rank').length) $('#'+item).children('.col-rank').val((a+1));
                       if($('#'+item).children('.row-rank').length) $('#'+item).children('.row-rank').val((a+1));
                       if($('#'+item).children('.row-index').length) $('#'+item).children('.row-index').val((a+1));
                    });
                }

            });

            
        }
    },
    removeCol:function(elm)
    {
        if($(elm).length)
        {
            var obj = this;
            $('.row').on('click', elm, function(e){
                e.preventDefault();
                var self = $(this),
                parent = self.parents('.row'),
                toRemove = self.data('to-remove');
                var checkpoint = confirm('Are you sure you want to remove this section?');

                if(checkpoint)
                {
                    if(parent.find(toRemove).length > 1)
                    {
                        self.parents(toRemove).remove();
                        obj.updateColSpan(parent);
                    }
                    else
                    {
                        parent.remove();
                    }
                }
            });
        }
    },
    mergeCols:function(triggerElm)
    {

        var obj = this;
        triggerElm.on('change', function(){
            
            var self = $(this);

            var row = self.parents('.row'),
            checkedBoxs = row.find(triggerElm).filter(':checked');

            if(checkedBoxs.length === 2)
            {
                var col1 = checkedBoxs.first().parents('.res-col'),
                col2 = checkedBoxs.last().parents('.res-col'),
                col1Cls = col1.attr('class'),
                col2Cls = col2.attr('class'),
                textarea1 = col1.find('textarea'),
                textarea2 = col2.find('textarea'),
                contentInstance1 = CKEDITOR.instances[textarea1.attr('id')],
                contentInstance2 = CKEDITOR.instances[textarea2.attr('id')],
                data1 = contentInstance1.getData(),
                data2 = contentInstance2.getData(),
                newData = data1+data2;

                var col1ClsArr = _.toArray(col1Cls.match(/\d+/g)).map(Number),
                col2ClsArr = $.makeArray(col2Cls.match(/\d+/g)).map(Number),
                col1Min =  _.min(col1ClsArr),
                col2Min = _.min(col2ClsArr),
                newCls = 'col-xs-12 col-sm-6 col-md-'+(col1Min+col2Min);
             
                col2.remove();
                col1.attr('class', (newCls+' res-col sortable-item'));
                col1.find('.col-cls').val(newCls);
                contentInstance1.setData(newData);
                checkedBoxs.attr('checked', false);
            }
            else if(checkedBoxs.length > 2)
            {
                triggerElm.not(self).attr('checked', false);
            }
        });
    },
    enableCKeditor:function(elms)
    {
        var obj = this;
        if(elms.length)
        {
            elms.each(function(ins, newCol){
                var self = $(newCol),
                id = self.attr('id');
                CKEDITOR.inline(id, {
                    toolbar:'ToolbarInline',
                    width:550,
                    filebrowserBrowseUrl:jsVars.dataManagerUrl,
                    extraPlugins:'sourcedialog,tags',
                    removePlugins:'sourcearea',
                    on:{
                        focus:function(e)
                        {
                           var textarea =  $(this.element.$);
                           textarea.parents('.editable-column-content').siblings('.action').addClass('hidden');
                        },
                        blur:function(e)
                        {
                            var textarea =  $(this.element.$);
                           textarea.parents('.editable-column-content').siblings('.action').removeClass('hidden');
                        }
                    }
                });

            });
        }
    },
    addColInRow:function()
    {
        var thisObj = this;

        $('.add-col').on('click', function(e){
            e.preventDefault();

            var  numColumns = 1,
            self = $(this),
            pRow = self.parents('.row'),
            rowInex = (pRow.index() - 1);
           
            if(numColumns)
            {
                var template = $(thisObj.getConfigItem('rowTemplate'));


                if(template.length)
                {

                    var processedTempl = thisObj.processTemplate(thisObj.getConfigItem('rowTemplate'), { rowIndex:rowInex, numColumns:numColumns, colIndex:(pRow.find('.res-col').size() + 1)});
                    
                    var newCol = processedTempl.find('.res-col');
                    pRow.find('.res-col:last').after(newCol);
                    thisObj.updateColSpan(pRow);
                    var newCols = newCol.find('.editable-column-content textarea');

                    thisObj.enableCKeditor(newCols);

                    thisObj.makeSortable('#row-'+rowInex);
                    thisObj.removeCol('.remove-col');
                    thisObj.mergeCols($('#row-'+rowInex).find('.col-merge'));
                }
            }
        });
    }
};// end of app