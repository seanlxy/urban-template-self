<?php

$styles_ext  .= '<link href="/'.$admin_dir.'/css/elfinder/main.min.css" rel="stylesheet">';
$styles_ext  .= '<link href="/'.$admin_dir.'/css/elfinder/theme.css" rel="stylesheet">';
$scripts_ext .= '<script src="/'.$admin_dir.'/js/elfinder/elfinder.min.js"></script>';

$page_contents = '<div id="elfinder"></div>';

$temp_photo = (isset($_GET['NetZone']) && $_GET['NetZone']) ? sanitize_one($_GET['NetZone'], 'sqlsafe') : '';
$ck_call    = (isset($_GET['CKEditorFuncNum'])) ? sanitize_one($_GET['CKEditorFuncNum'], 'sqlsafe') : '';

$gallery_id    = (isset($_GET['gtoken']) && $_GET['gtoken']) ? sanitize_one($_GET['gtoken'], 'sqlsafe') : '';

if($temp_photo || $ck_call || $ck_call == '0')
{
	$template = "templates/fullwidth.html";
}

$scripts_onload = <<< JS

$(document).ready(function(){

	var elf = $('#elfinder').elfinder({
		url:'requests/service/connector',
		height:550,
		resizable:false,
		validName:'/^[^\s]$/',
		getFileCallback:function(imgData, file)
		{
			
			var url = imgData.url;

			var photoCall = '{$temp_photo}',
			    ckCall    = '{$ck_call}';
			    gToken   = '{$gallery_id}';
			
			if(photoCall)
			{
				var setValOf = window.opener.document.getElementById(photoCall);
				
				var wJQuery = window.opener.jQuery;

				if(typeof setValOf != 'undefined')
				{
					
					setValOf.value = url;

					
					if(typeof window.opener.setNewPhoto === 'function' && photoCall == 'tempPhoto')
					{
						window.opener.setNewPhoto();
						window.close();
					}
					else if(typeof window.opener.setNewGalleryPhoto === 'function' && photoCall == 'tempGalleryPhoto')
					{
						window.opener.setNewGalleryPhoto();
						window.close();
					}
					else if(window.opener.Suite && photoCall == 'set-item-gallery-photo')
					{
						var suite = new window.opener.Suite({});
				
						if( gToken )
						{
							wJQuery(setValOf).attr('data-token', gToken);
						}

						suite.setPhoto();
						window.close();
					}
					else
					{
						window.close();
					}
					
				}

			}

			if(window.opener.CKEDITOR)
			{
							
				if(ckCall)
				{
					window.opener.CKEDITOR.tools.callFunction(ckCall, url);
	                window.close();
                }
			}

		},
	}).elfinder('instance');
});

JS;


?>