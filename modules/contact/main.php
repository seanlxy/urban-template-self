<?php 

require_once 'inc/vars.php';


if(sanitize_input('continue') === '1' && $form_is_valid === true)
{
	require_once 'inc/insert_data.php';
}
elseif( isset($_GET['success']) )
{
	require_once 'inc/views/success.php';
}
else
{

	require_once 'inc/views/form.php';
}


$tags_arr['content'] = ($output) ? '<div class="container"><div class="row contactForm-row">'.$output.'</div></div>' : '';
	
?>