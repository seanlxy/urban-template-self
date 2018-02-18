<?php

if($page_url == $page_accommodation->url)
{
	
	if($option1)
	{
		require_once 'inc/single.php';
	}
	
	else{
		
		require_once 'inc/list.php';
	}
}

?>