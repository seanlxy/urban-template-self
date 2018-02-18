CKEDITOR.plugins.add( 'tags',
{
requires : ['richcombo'], //, 'styles' ],
init : function( editor )
{

var config = editor.config, lang = editor.lang.format;

// Gets the list of tags from the settings.

//this.add('value', 'drop_text', 'drop_label')
var tags = (typeof jsVars.ckTags != 'undefined') ? jsVars.ckTags : []; //new Array();

if(tags.length)
{
// Create style objects for all defined styles.



editor.ui.addRichCombo( 'tags',{
label : "Insert Tag",
title :"Insert Tag",
voiceLabel : "Insert Tag",
className : 'cke_format custom_dd',
multiSelect : false,

panel :
{
css : [ config.contentsCss, CKEDITOR.getUrl( jsVars.baseUrl+'ckeditor/skins/moono/editor.css') ],
voiceLabel : lang.panelVoiceLabel
},

init : function()
{
this.startGroup( "Tags" );
//this.add('value', 'drop_text', 'drop_label');
for (var this_tag in tags){
this.add('{'+tags[this_tag]['tag']+'}', tags[this_tag]['label'], tags[this_tag]['tag']);
}
},

onClick : function( value )
{
editor.focus();
editor.fire( 'saveSnapshot' );
editor.insertHtml(value);
editor.fire( 'saveSnapshot' );
}
});

}

}
});