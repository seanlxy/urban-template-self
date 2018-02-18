<?php
function is_windows() {
	if(PHP_OS == 'WINNT' || PHP_OS == 'WIN32'){
		return true;
	}
	return false;
}
?>