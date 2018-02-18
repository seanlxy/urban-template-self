<?php
############################################################################################################################
## Delete a payment request
############################################################################################################################

function delete_items()
{
	global $message, $id, $htmladmin, $do, $obj_payment, $disable_menu, $valid, $main_heading;

	$disable_menu = "true";
    $valid        = 1;

    $main_heading = "";

	if( !empty($id) )
	{
		$confirm = filter_input(INPUT_GET, 'confirm', FILTER_VALIDATE_INT);

		if( $confirm === 1 )
		{

			$is_deleted = $obj_payment->delete($id);

			if( $is_deleted )
			{
				$_SESSION['flash_msg'] = 'Payment request has been deleted successfully.';
				header("Location: {$htmladmin}?do={$do}");
				exit();

			}

		}
		else
		{
			$settings_content = '<div class="alert alert-danger confirm-box">
				<strong style="font-size:15px;">Are you sure you want to delete this payment request?</strong>
				<div style="margin-top: 20px;">
					<a href="'.$htmladmin.'?do='.$do.'&action=delete&id='.$id.'&confirm=1" class="btn btn-danger" style="color: #fff;font-size:14px;"><i class="glyphicon glyphicon-remove"></i> Delete</a>
					<a href="'.$htmladmin.'?do='.$do.'" class="btn btn-default" style="font-size:14px; color:#000;margin-left:10px;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
				</div>
			</div>';
		}

		
	}
	else
	{
		header("Location: {$htmladmin}?do={$do}");
		exit();
	}



	$page_contents="{$message}<form action=\"$htmladmin/?do={$do}&action=new\" method=\"post\" name=\"pageList\" enctype=\"multipart/form-data\">
	    {$settings_content}
	</form>";

	require "resultPage.php";
	echo $result_page;
	exit();
}

?>