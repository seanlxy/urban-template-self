<?php 

$hashed_entry_id = sanitize_var($_GET['success']);
$is_valid_entry = fetch_value("SELECT `id` FROM `form_entry` WHERE MD5(`id`) = '{$hashed_entry_id}' LIMIT 1");

if( !$success_message )
{
	$success_message = 'We\'ve received your request. We\'ll get back to you as soon as possible.';
}

if( $is_valid_entry && $success_message )
{

	$tags_arr['content'] = <<< H

	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-success col-xs-12 text-center">
			    <p style="margin:0;font-weight:700;">{$success_message}</p>
			</div>
		</div>
	</div>
	
H;

	
	$tags_arr['accom_details'] = '';
	$tags_arr['intro']         = '';

}
else
{
	header( "Location: {$htmlrootfull}{$page_full_url}" );
	exit();
}



?>