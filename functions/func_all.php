<?php
@include_once ('func_browser.php');
@include_once ('func_server.php');
@include_once ('func_validate.php');
@include_once ('func_sanitize.php');
//framework
function pa ($default = "list") {
	if (isset($_REQUEST["pa"])) {
		return $_REQUEST["pa"];
	} else {
		return $default;
	}
}

function arrayToQueryString($array){
	$i = 0;
	if($array){
		foreach($array as $key => $value){
			$b = ($i==0) ? '?' : '&';
			$a .= "$b$key=$value";
			$i++;
		}
		return $a;
	}else{
		return false;	
	}
}

function arrayToSQLWhere($array,$ignorekeys=false){
	$i = 0;
	if($array){
		foreach($array as $key => $value){
			$where = ($ignorekeys) ? $value : $key;
			$b = ($i==0) ? 'WHERE' : 'AND';
			$a .= " $b $where ";
			$i++;
		}
		return $a;
	}else{
		return false;	
	}
}

function arrayToSQLAnd($array,$ignorekeys=false){
	if($array){
		foreach($array as $key => $value){
			$where = ($ignorekeys) ? $value : $key;
			$a .= " AND $where ";
		}
		return $a;
	}else{
		return false;	
	}
}

function arrayToSQLIn($array) {
	$bar = "";
	foreach ($array as $value) {
		if ($bar != "") $bar .= ",";
		$bar .= quoteSQL($value,false);
	}
	return $bar;
}


//session
function isLoggedIn() {
	if (isset($_SESSION['session_user_id']) && ($_SESSION['session_user_id'] != "" && $_SESSION['session_user_id'] != 0)){
		return $_SESSION["session_realname"];
	}
	return false;
}

function loginRequired () {
	if (!isLoggedIn()){
		if (!strstr($_SERVER['PHP_SELF'],"login.php")) {

			$_SESSION["wherewasi"] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
			header('Location: login.php');
		}
	}
}

function adminRequired() {
	if (!$_SESSION["admin"]) {
		header('Location: login.php');
	}
}

function sticky($variable) {
	if (isset($_REQUEST[$variable])) {
		$_SESSION[$variable] = $_REQUEST[$variable];
	}
	return $_SESSION[$variable];
}

//database
function quoteSQL($foo,$null =true) {
	if ($foo =="" && $null) {
		return "null";
	} else {
		return "'" . mysql_escape_string($foo) . "'";
	}
}

function run_query($sql) {

	$result = @mysql_query($sql);
	
	if ($result) {
		return $result;
	} else {
		$GLOBALS["error"] = "Lookup failed: " . mysql_error() . $sql;
		return false;
	}
}

function fetch_row($sql) {
        $result = run_query($sql);
	if ($result) {
		return mysql_fetch_assoc($result);
	}
	return false;
}

function mysql_quick_call($sql) {

	$result = run_query($sql);

	if ($result) {
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	return false;

}

function fetch_all($q){

	$r = run_query($q);
	$arr = array();
	while ($row = @mysql_fetch_assoc($r))
		$arr[] = $row;
		return $arr;
}
 
function image_stretch($img_path,$container_width,$container_height){
    $box_width = $container_width.'px';
    $box_height = $container_height.'px';
    return "position:absolute;width:$box_width;height:$box_height;left:0;top:0;";
}

function image_fit($img_path,$container_width,$container_height){
    $box_ratio      = $container_width/$container_height;
    list($img_width,$img_height) = @getimagesize($img_path);
    if($img_width!=0 && $img_height !=0){
        $img_ratio = $img_width/$img_height;
        if($box_ratio > $img_ratio) {
             // relatively portrait
            $img_height_new = $container_height;
            $resizeScale = $img_height_new/$img_height;
            $img_width_new = $img_width*$resizeScale;
            $marginTop = $img_height_new/2*(-1);
            $marginLeft = $img_width_new/2*(-1);
            $marginTop_px = $marginTop.'px';
            $marginLeft_px = $marginLeft.'px';
            $img_width_px = $img_width_new.'px';
            $img_height_px = $img_height_new.'px';
        }else{
            // relatively landscape
            $img_width_new = $container_width;
            $resizeScale = $img_width_new/$img_width;
            $img_height_new = $img_height*$resizeScale;
            $marginTop = $img_height_new/2*(-1);
            $marginLeft = $img_width_new/2*(-1);
            $marginTop_px = $marginTop.'px';
            $marginLeft_px = $marginLeft.'px';
            $img_width_px = $img_width_new.'px';
            $img_height_px = $img_height_new.'px';
        }
        return "position:absolute;width:$img_width_px;height:$img_height_px;left:50%;top:50%;margin-left:$marginLeft_px;margin-top:$marginTop_px;";
    }else{
        return false;
    }

}

function image_fill($img_path,$container_width,$container_height){
    $box_ratio      = $container_width/$container_height;

    if(@getimagesize($img_path)){
        list($img_width,$img_height) = getimagesize($img_path);
        if($img_width!=0 && $img_height !=0){
            $img_ratio = $img_width/$img_height;
            if($box_ratio > $img_ratio) {
                 // relatively portrait
                $img_width_new = $container_width;
                $resizeScale = $img_width_new/$img_width;
                $img_height_new = $img_height*$resizeScale;
                $marginTop = $img_height_new/2*(-1);
                $marginLeft = $img_width_new/2*(-1);
                $marginTop_px = $marginTop.'px';
                $marginLeft_px = $marginLeft.'px';
                $img_width_px = $img_width_new.'px';
                $img_height_px = $img_height_new.'px';
            }else{
                // relatively landscape
                $img_height_new = $container_height;
                $resizeScale = $img_height_new/$img_height;
                $img_width_new = $img_width*$resizeScale;
                $marginTop = $img_height_new/2*(-1);
                $marginLeft = $img_width_new/2*(-1);
                $marginTop_px = $marginTop.'px';
                $marginLeft_px = $marginLeft.'px';
                $img_width_px = $img_width_new.'px';
                $img_height_px = $img_height_new.'px';
            }
            return "position:absolute;width:$img_width_px;height:$img_height_px;left:50%;top:50%;margin-left:$marginLeft_px;margin-top:$marginTop_px;";
        }else{
            return false;
        }
    }else{
        return false;
    }

}

function image_center($img_path){
    list($img_width,$img_height) = @getimagesize($img_path);
    if($img_width!=0 && $img_height!=0){
        $img_width_px = $img_width.'px';
        $img_height_px = $img_height.'px';
        $marginTop = $img_height/2*(-1);
        $marginLeft = $img_width/2*(-1);
        $marginTop_px = $marginTop.'px';
        $marginLeft_px = $marginLeft.'px';
        return "position:absolute;width:$img_width_px;height:$img_height_px;left:50%;top:50%;margin-left:$marginLeft_px;margin-top:$marginTop_px";
    }else{
        return false;
    }

}
//############################ array ############################################

//Input array must be 2-dimensional and second dimension must be associative

//$val represents the key in the 2nd dimension that needs to be extracted

//optional $key will create an associative array with that key will be also extracted from the 2nd dimension of original array

function array_extract($arr, $val, $key = NULL){
    $new = array();

    if ($key){
        foreach ($arr as $item){
            if(isset($item[$key]) && isset($item[$val])){
                $new[$item[$key]] = $item[$val];
            }
        }
    }else{
        foreach ($arr as $item){
            array_push($new,$item[$val]);
        }
    }
    return $new;
}


function fetch_value($q)
{
	
    $r = run_query($q);
    if (mysql_num_rows($r) == 1){
        return mysql_result($r, 0);
    }else{
        return false;
    }

}


function fetch_assoc($q) {
    $r = run_query($q);
    if (mysql_num_rows($r) == 1){
        return mysql_fetch_assoc($r);
    }else{
        return false;
    }
}

//Prepares string to be used in MySQL query

function for_query($str){
	//trim
	$str = trim($str);
	//strip slashes if magic quotes is on
	if (get_magic_quotes_gpc())
		$str = stripslashes($str);
	//escape and wrap in quotes only if string is not numeric
	if (!is_int($str))
		$str = "'" . mysql_real_escape_string($str) . "'";
	return $str;

}

function insert_row($arr, $table){
	$q = "INSERT INTO $table (" . implode(', ', array_keys($arr)) . ")
		    	VALUES (" . implode(", ", array_map('for_query', $arr)) . ")";
	$r = run_query($q);
		if (mysql_affected_rows() == 1)
			return mysql_insert_id();
		else
			return false;
}


function update_row($arr, $table, $end){

	$str = '';
	foreach ($arr as $key => $val)
		$str .= $key . ' = ' . for_query($val) . ', ';
	$str = substr($str, 0, -2);
	$q = "UPDATE $table SET $str $end";
	
	$r = run_query($q);
	if (mysql_affected_rows() == 1)
		return true;
	else
		return false;
}


function getAbsoluteParentId($cursorpage_id){
	global $absparent;

	$sql = "SELECT `id`, `parent_id` FROM `general_pages` WHERE `id` = '$cursorpage_id'";
	
	$parent_arr = fetch_row($sql);

	$cursorpage_parent = $parent_arr['parent_id'];
	$cursorpage_id     = $parent_arr['id'];

	if( $cursorpage_parent != 0 ){
		getAbsoluteParentId($cursorpage_parent);
	}else{
		$absparent = $cursorpage_id;
	}
	return $absparent;
}

function isChildOf($page_id1, $page_id2, $includeself=false){
	if($includeself && $page_id1==$page_id2){
		return true;
	}
	$sql = "SELECT page_parentid
                FROM general_pages
                WHERE page_id = '$page_id1'";
	$parent_arr = fetch_row($sql);
	$cursorpage_parent 	= $parent_arr['page_parentid'];
	if($cursorpage_parent){
		if($cursorpage_parent==$page_id2){
			return true;
		}else{
			return isChildOf($cursorpage_parent, $page_id2, false);
		}
	}else{
		return false;
	}
}

//display
function optionValue($value,$selectedValue) {
	if ($value == $selectedValue) {
		return "value=\"$value\" SELECTED ";
	} else {
		return "value=\"$value\"";
	}
}
function radioValue($value,$selectedValue) {
	if ($value == $selectedValue) {
		return "value=\"$value\" CHECKED ";
	} else {
		return "value=\"$value\"";
	}
}

function boolColourView($value,$true,$false) {
	if ($value) {
		return "<span \"style=color:green\">$true</span>";
	} else {
		return "<span \"style=color:red\">$false</span>";
	}
}

function alt($a,$b) {
	global $alt;
	if ($alt == $a) {
		$alt = $b;
	} else {
		$alt = $a;
	}
	return $alt;
}

//date
function nzDateToDBDate($nzDate, $nzTime = "00:00:00") {
	$myArray = explode('/',$nzDate);
	if (count($myArray) != 3) {
		return "null";
	}
	$pm = (bool)strpos($nzTime,"p");
	$am = (bool)strpos($nzTime,"a");
	$time = preg_replace("[apm]","",$nzTime);
	list ($hour, $min, $sec) = explode (':', $time);
	if (!isset($min)) {
		$min = 0;
	}
	if (!isset($sec)) {
		$sec = 0;
	}
	if (!is_numeric($hour) || !is_numeric($min) || !is_numeric($sec)) {
		return "null";
	}
	if ($pm && $hour < 12) {
		$hour += 12;
	}
	if ($am && $hour == 12) {
		$hour = 0;
	}
	return $myArray[2] . "-" . $myArray[1] . "-" . $myArray[0] . " " . $hour . ":" . $min . ":" . $sec;
}


function dbDateToNZDate($dbDate) {
	$dbDate = substr($dbDate,0,10);
	$myArray = explode("-",$dbDate);
	if (count($myArray) != 3) {
		return "";
	} else {
		return $myArray[2] . "/" . $myArray[1] . "/" . $myArray[0];
	}
}

function dbDateToNZTime($dbDate, $sec = false) {
	if ($sec) {
		$dbDate = substr($dbDate,11);
	} else {
		$dbDate = substr($dbDate,11,5);
	}
	return $dbDate;
}


function validDate($dateString) {
	list ($day, $month, $year) = explode ("[/.-]", $dateString);
	if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
		return false;
	}
	if (checkdate($month,$day,$year)) {
		return true;
	} else {
		return false;
	}
}

function validTime($nzTime) {
	$pm = (bool)strpos($nzTime,"p");
	$am = (bool)strpos($nzTime,"a");
	$time = preg_replace("[apm]","",$nzTime);
	list ($hour, $min, $sec) = split ("[:. ]", $time);
	if (!isset($min)) {
		$min = 0;
	}
	if (!isset($sec)) {
		$sec = 0;
	}
	if (!is_numeric($hour) || !is_numeric($min) || !is_numeric($sec)) {
		return false;
	}
	if ($pm && $hour < 12) {
		$hour += 12;
	}
	if ($am && $hour == 12) {
		$hour = 0;
	}
	if ($hour > 23 || $min > 59 || $sec > 59) {
		return false;
	}
	return true;

}

//useful
function zeroIfBlank($foo) {
	if ($foo == "") {
		$foo = 0;
	}
	return $foo;
}

function array_depth($array) {
    $max_depth = 1;

    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = array_depth($value) + 1;

            if ($depth > $max_depth) {
                $max_depth = $depth;
            }
        }
    }

    return $max_depth;
}

function validateEmail($email){
	if (eregi("/^([a-zA-Z0-9_.\-'])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/", $email)) {
		return true;
	} else {
		return false;
	}
}

function page() {
	return substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],"/")+1);
}

function returnToBR ($foo) {
	return ereg_replace("\n","<br>",$foo);
}

function pageLinker($page_size=20,$pages_to_link=10) {
	$link=$_SERVER['PHP_SELF'] . "?". $_SERVER['QUERY_STRING'];
	$link = eregi_replace("&pg=.*&","&",$link);
	$link = eregi_replace("&pg=.*","",$link);

	$total = mysql_quick_call("select found_rows()");
	$pg = (isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : 1);
	$pages = ceil($total / $page_size);

	echo "<br/><center class='paging'>Total Results Found: $total<br/>Page No<br/>";
	$start_page = round($pg - ($pages_to_link /2),0);
	$end_page = round($pg + ($pages_to_link /2),0);

	if ($pg < ($pages_to_link /2)) {
		$end_page += ceil(($pages_to_link /2)-$pg);
	}
	if ($pages - $pg < ($pages_to_link /2)) {
		$start_page -= 	ceil(($pages_to_link /2)-($pages - $pg));
	}

	$end_page = ($end_page >= $pages?$pages:$end_page);
	$start_page = ($start_page <1?1:$start_page);

	for ($i =$start_page;$i <= $end_page;$i++) {
		if ($pg == $i) {
			echo "<b>$i</b> ";
		} else {
			echo "<a href='$link&pg=$i'>$i</a> ";
		}

	}
	echo "</center>";
}
function yn($foo) {
	if (!$foo) {
		return "n";
	}
	if ($foo == "y" || $foo == "Y" || $foo == 1) {
		return "y";
	} else {
		return "n";
	}
}
function controlBreak($cb,&$result,$key) {

	global $cb_array;
	if (!isset($cb_array)) $cb_array = array();
	if (!isset($cb_array[$cb])) $cb_array[$cb] = array();

	if (!isset($cb_array[$cb]["nextrow"])) {
		if (!$cb_array[$cb]["nextrow"] = mysql_fetch_assoc($result)) {
			unset($cb_array[$cb]);
			return false;
		}
	}
	echo $cb_array[$cb]["cb_nextrow"];
	$cb_array[$cb]["lastrow"] = $cb_array[$cb]["currentrow"];
	$cb_array[$cb]["currentrow"] = $cb_array[$cb]["nextrow"];
	if (!$cb_array[$cb]["nextrow"] = mysql_fetch_assoc($result)) {
		$cb_array[$cb]["footer"] = true;
		unset($cb_array[$cb]["nextrow"]);
	} else {
		$cb_array[$cb]["footer"] = ($cb_array[$cb]["currentrow"][$key] != $cb_array[$cb]["nextrow"][$key]);
	}
	$cb_array[$cb]["header"] = ($cb_array[$cb]["currentrow"][$key] != $cb_array[$cb]["lastrow"][$key]);

	return $cb_array[$cb]["currentrow"];
}


function str_getbetween($str,$start,$end){
	$r = explode($start, $str);
	if (isset($r[1])){
		$r = explode($end, $r[1]);
		return $r[0];
	}
	return '';
}

function str_urltohyperlinks($str){
	return preg_replace("#http://([A-z0-9./-]+)#", '<a href="$1">$0</a>', $str);
}

function str_removehyperlinks($str){
	return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $str);
}

function str_contains($str, $content, $ignorecase=true){
    if ($ignorecase){
        $str = strtolower($str);
        $content = strtolower($content);
    }
    return strpos($content,$str) ? true : false;
}

function str_beginswith($needle, $haystack) {
    return (substr($haystack, 0, strlen($needle))==$needle);
}

function getTinyUrl($url) {
	return file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
}

function make_ranked($rank) {
	$last = substr( $rank, -1 );
	$seclast = substr( $rank, -2, -1 );
	if( $last > 3 || $last == 0 ) $ext = 'th';
	else if( $last == 3 ) $ext = 'rd';
	else if( $last == 2 ) $ext = 'nd';
	else $ext = 'st'; 

	if( $last == 1 && $seclast == 1) $ext = 'th';
	if( $last == 2 && $seclast == 1) $ext = 'th';
	if( $last == 3 && $seclast == 1) $ext = 'th'; 

	return $rank.$ext;
}

function str_truncate($text, $length = 100, $ending = '...', $bywords = true, $html = true) {
    if ($html) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag
                }elseif (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {

                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                }elseif (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if ($bywords) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($html) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}


    function leading_zeros($value, $places){
        if(is_numeric($value)){
            for($x = 1; $x <= $places; $x++){
                $ceiling = pow(10, $x);
                if($value < $ceiling){
                    $zeros = $places - $x;
                    for($y = 1; $y <= $zeros; $y++){
                        $leading .= "0";
                    }
                $x = $places + 1;
                }
            }
            $output = $leading . $value;
        }
        else{
            $output = $value;
        }
        return $output;
    }

    /*
     *
     *
     *
     *
     * URL functions
     *
     *
     *
     *
     */

    /*
     * function: make_querystring
     * makes the URL with all of the current gets, plus additions
     *
     */
    //function make_querystring('page','level','id'){
    //    };






    /*
     *
     *
     *
     *
     * Validation functions
     *
     *
     *
     *
     */

    /*
     * function: is_length
     * checks if variable($str) is a given length($len)
     *
     */
    //function is_length($str,$len=2){
    //        return isset($str) && strlen(strip_tags($str)) > $len;
    //}

    /*
     * function: is_email
     * checks if variable($str) is an email
     *
     */
    //function is_email($str){
    //        return preg_match("/^([a-zA-Z0-9_.\-'])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/", $str);
    //}

    /*
     * function: user_exists
     * checks is a user($str) exists in the database
     *
     */
    function user_exists($str){
        global $db;
        $sql = "SELECT 	su_email, su_password
                FROM 	shop_users
                WHERE 	su_email = '$str'
                AND     su_password != ''";
        $db->query($sql);
        while($row = $db->result->fetch_array(MYSQLI_ASSOC)){
            if($row['su_password'] && ($_SESSION['ls_loggedin']!=$row['su_email'])){
                return true;
            }else{
                return false;
            }
        }
    }

    /*
     * function: is_matching
     * checks if variable1($str1) and variable2($str2) matches(are the same)
     *
     */
    //function is_match($str1, $str2){
    //    if($str1!=$str2){
    //        return false;
    //    }else{
    //        return true;
    //    }
    //}

    /*
     * function: is_alpha
     * checks if variable($str) is made up only of alpha characters
     *
     */
    //function is_alpha($str)
    //{
    //        return preg_match("/^[a-zA-Z\s]+$/", $str);
    //}

    /*
     * function: is_date
     * checks variable($str) is in a dd/mm/yyyy format
     *
     */
    //function is_date($str) ## dd/mm/yyyy
    //{
    //    return preg_match("/^(((((0[1-9])|(1\d)|(2[0-8]))\/((0[1-9])|(1[0-2])))|((31\/((0[13578])|(1[02])))|((29|30)\/((0[1,3-9])|(1[0-2])))))\/((20[0-9][0-9])|(19[0-9][0-9])))|((29\/02\/(19|20)(([02468][048])|([13579][26]))))$/", $str);
    //}

    /*
     * function: is_url
     * checks if variable($str) is a URL
     *
     */
    //function is_url($str){
    //    return preg_match("/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/", $str);
    //}

    /*
     * function: is_phone
     * checks if variable($str) is a phone number (allows + ( ) and *)
     *
     */
    //function is_phone($str){
    //    return preg_match("/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/",$str);
    //}

	function update_var(&$var1,$var2){
		$var1 = ($var2=='') ? $var1 : $var2;
	}
	
	
/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Arguments : $contents - The XML text
 *             $get_attributes             - 1 or 0. If this is 1 the function
 * will get the attributes as well as the tag values - this results in a
 * different array structure in the return value. 
 * Return: The parsed XML in an array form.
 */
function test($str, $die=FALSE){
	if($die) die($str);
	else return $str;
}
function _xml2array($contents, $get_attributes=1){

    if ( ! $contents ) 
                return array();

    if( ! function_exists('xml_parser_create') ) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }
    
    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $contents, $xml_values);
    xml_parser_free($parser);

    if( ! $xml_values ) 
                return array();

    //*** Initializations
    $xml_array                     = array();
    $parents                          = array();
    $opened_tags               = array();
    $arr                                    = array();
    
    $current = &$xml_array;
    //*** Go through the tags.
    foreach ($xml_values as $data) {
        //*** Remove existing values, or there will be trouble
        unset($attributes, $value);

        //*** This command will extract these variables into the foreach scope: tag(string), type(string), level(int), attributes(array), value(string).
        extract($data);

        $result = '';
        if ($get_attributes) {
            $result = array();

            //*** Set the attributes too.
            if ( isset($attributes) ) {
                foreach ($attributes as $attr => $val) {
                    if($get_attributes == 1) 
                                $result["${tag}_ATTRIBUTES"][$attr] = $val;
                }
            }
            
            if( isset($value) ) {
                $result["${tag}_VALUE"] = $value;
            }
        } 
        else if( isset($value) ) {
            $result = $value;
        }

        //*** See tag status and do the needed.
        if ( $type == "open" ) {//*** The starting of the tag '<tag>'
            $parent[$level-1] = &$current;

            if ( !is_array($current) || !in_array($tag, array_keys($current)) ) { 
                //*** Insert New tag
                $current[$tag] = $result;
                $current = &$current[$tag];

            } 
            else { //*** There is another element with the same tag name
                if ( isset($current[$tag][0]) ) {
                    array_push($current[$tag], $result);
                } 
                else {
                    $current[$tag] = array($current[$tag], $result);
                }
                
                $last = count($current[$tag]) - 1;
                $current = &$current[$tag][$last];
            }
        } 
        else if ( $type == "complete" ) { //*** Tags that ends in 1 line '<tag />'
            //*** See if the key is already taken.
            if ( ! isset($current[$tag]) ) { //*** New Key
                $current[$tag] = $result;
            } 
            else { //*** If taken, put all things inside an array
                if ( (is_array($current[$tag]) && $get_attributes == 0) || (isset($current[$tag][0]) && is_array($current[$tag][0]) && $get_attributes==1) ) {
                    //*** push the new element into that array.
                    array_push($current[$tag],$result); 
                } 
                else { //*** If it is not an array
                    //*** Make it an array using the existing value and the new value
                    $current[$tag] = array($current[$tag],$result); 
                }
            }
        } 
        else if ( $type == 'close' ) { //*** End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }

    return($xml_array); 
}
function _buildErrorCodeXML($errCode, $errMsg) {
    $dataArr['Error'] = array('_ATTRIBUTES'=>array('Code'=>$errCode), '_DATA'=>"$errMsg");
    return _array2XML($dataArr);
}


function _buildSuccessXML($successCode, $message) {
	$dataArr['Success'] = array('_ATTRIBUTES'=>array('Code'=>$successCode), '_DATA'=>"$message");
	return _array2XML($dataArr);
}



function _array2XML($arr){
	global $htmlroot;
                $_nameSpace = "$htmlroot";
                
                $_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n\n"; // or "ISO-8859-1" encoding          
                $_xml .= "<string xmlns=\"$_nameSpace/\">\n";
                $_xml .= _array2XMLNode($arr);
                $_xml .= "</string>";

                return $_xml;
}

function _array2XMLNode($arr, $parentKey=''){
	if ( !is_array($arr) )
	return;

	foreach ($arr as $fieldname=>$fieldvalue) {
		$fieldname = _xmlSafeStr(trim($fieldname));

		$openKey = $parentKey? $parentKey : $fieldname;
		$openTag = "<$openKey>";
		$closeTag = "</$openKey>";

		if ( is_array($fieldvalue) ) {
			if ( array_keys($fieldvalue)===array('_ATTRIBUTES', '_DATA') ) {
				$attribStr = '';
				foreach ($fieldvalue['_ATTRIBUTES'] as $k=>$v) {
				$k = _xmlSafeStr($k);
				$v = _xmlSafeStr($v);
				$attribStr .= " $k=\"$v\"";
				}

				$openKey = $openKey.$attribStr;
				$openTag = "<$openKey>";

				if ( ! is_array($fieldvalue['_DATA']) )
				$data = _xmlSafeStr($fieldvalue['_DATA']);         
				else if ( _is_sequential_array($fieldvalue['_DATA']) ) {
				$data = _array2XMLNode($fieldvalue['_DATA'], $openKey);
				$openTag = $closeTag = '';
				}
				else 
				$data = _array2XMLNode($fieldvalue['_DATA']);
			}
			else if ( _is_sequential_array($fieldvalue) ) {
				$data = _array2XMLNode($fieldvalue, $openKey);
				$openTag = $closeTag = '';
			}
			else
				$data = _array2XMLNode($fieldvalue);
			}
		else
		$data = _xmlSafeStr($fieldvalue);

		$_xml .= $openTag.$data.$closeTag;
	}

	return $_xml;
}
function _xmlSafeStr($print_friendly_string){
                //return htmlentities($print_friendly_string, ENT_QUOTES); // all characters which have HTML character entity equivalents are translated into these entities
                if ( is_string($print_friendly_string) )
                                //return htmlspecialchars($print_friendly_string, ENT_QUOTES); // only convert &, ', ", <, >
                                return preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", htmlspecialchars($print_friendly_string, ENT_QUOTES)); // only convert &, ', ", <, > (but exclude BINARY data type which is the format of &#[0-9]+|[a-z]+
                else
                                return $print_friendly_string;
}

function _is_sequential_array($array) {
	if ( !is_array($array) || empty($array) )
	return false;

	$keys = array_keys($array);
	return array_keys($keys) === $keys;
}

function webCurlPost($portal_api_url, $xml_data){
                // this function is to POST to post to an HTTP post. Check that CURL_POSTFIELDS paramaters are correct.
                
                $_urlInfoArr = parse_url($portal_api_url);
                $page = $_urlInfoArr['path'];
                
                $header = array();
                $header[] = "POST ".$page." HTTP/1.0 \r\n";
                $header[] = "MIME-Version: 1.0";
                $header[] = "Content-type: text/xml;charset=\"utf-8\""; //"Content-type: multipart/mixed";
                $header[] = "Accept: text/xml";
		$header[] = "Expect: ";
                $header[] = "Cache-Control: no-cache";
                $header[] = "Pragma: no-cache";
                $header[] = "SOAPAction: \"run\"";
                $header[] = "Content-length: ".strlen($xml_data);
                //$header[] = "Authorization: Basic " . base64_encode($credentials);
                
                //////////////////////////////
                $ch=curl_init($portal_api_url);
                curl_setopt($ch,CURLOPT_VERBOSE,0);
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
                curl_setopt($ch,CURLOPT_POST,0);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_NOPROGRESS,0);
                curl_setopt($ch,CURLOPT_HTTPDHEADER,$header);
                curl_setopt($ch,CURLOPT_POSTFIELDS,"ResBookRQXml=".$xml_data);
                $webCurlRS=curl_exec($ch); 
                //*** Close connection 
                curl_close($ch);                
                //*** log the data sent in a file
                //fwrite($fetchBookings_Data_fp, "RQ:\n$strPostVars\n\nRS:\n$rtnStr\n==========\n\n\n");
                return $webCurlRS;
                /////////////////////////?////
}

function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function calculate_offset($date, $offset_type = 'days'){
	if($date){
		switch($offset_type){
			case('days'):
				$date_offset 	= $date - time();
				return round(($date_offset / 60 / 60 / 24),0);
			case('hours'):
				$date_offset 	= $date - time();
				return round(($date_offset / 60 / 60),0);
			case('minutes'):
				$date_offset 	= $date - time();
				return round(($date_offset / 60),0);
			case('seconds'):
				$date_offset 	= $date - time();
				return round(($date_offset),0);
			case('dd/mm/yyyy'):
				list($day,$month,$year) = explode('/',$date);
				return ceil(((mktime(0,0,0,$month,$day,$year)-time())/60/60/24));
			case('mm/dd/yyyy'):
				list($month,$day,$year) = explode('/',$date);
				return ceil(((mktime(0,0,0,$month,$day,$year)-time())/60/60/24));
		}
	}else{
		return false;
	}
}

function calculate_date_from_offset($offset){
	$timestamp_total = time() + ($offset*60*60*24);
	return date('d/m/Y',$timestamp_total);
}

function dateToUnixTimestamp($date){ // dd/mm/yyy
	list($day,$month,$year) = explode('/',$date);
	if($day && $month && $year){
		return mktime(0,0,0,$month,$day,$year);
	}else{
		return false;
	}
}

function preprint_r($print, $die=FALSE){
	echo '<pre>';
	print_r($print);
	echo '</pre><hr>';

	if($die) die();
}


function is_country($id){
	$sql = "SELECT country_id
	FROM data_countries
	WHERE country_id = '$id'";
	return (bool)fetch_value($sql);
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function prepareJsString( $str){
	$searches = array( "'", "\n" );
	$replacements = array( "\\'", "\\n'\n\t+'" );
	return str_replace( $searches, $replacements, $str);
}


if( !function_exists('set_flash_msg') )
{

    function set_flash_msg( $msg )
    {
        $_SESSION['flash_msg'] = $msg;
    }

}

if( !function_exists('get_flash_msg') )
{

    function get_flash_msg()
    {
        return ( ($_SESSION['flash_msg']) ? $_SESSION['flash_msg'] : '' );
    }

}

if( !function_exists('redirect') )
{

    function redirect( $url )
    {

        $url = filter_var($url, FILTER_VALIDATE_URL);

        if( $url )
        {
            header("Location: {$url}");
            exit();

        }

    }

}

if( !function_exists('destroy_flash_msg') )
{
    function destroy_flash_msg()
    {
        if( isset($_SESSION['flash_msg']) )
        {
            unset($_SESSION['flash_msg']);
        }
    }
}

function is_firefox() {
	$agent = $_SERVER["HTTP_USER_AGENT"];
	if (!empty($agent) && preg_match("/firefox/si", $agent)) return true;
	return false;
}

if( !function_exists('mkformatted_date') ){
	function mkformatted_date($date, $format,$seprator='-'){
		$date_arr = explode($seprator, $date);
		switch($seprator){
			case '-':
				$d = date($format, mktime(0,0,0,$date_arr[1],$date_arr[2],$date_arr[0]));
			break;
			case '/':
				$d = date($format, mktime(0,0,0,$date_arr[1],$date_arr[0],$date_arr[2]));
			break;
		}
		return $d;
	}
}

// function to create element
function createElement($attributes = array('class'=>'element-class'),$element='div', $html = ''){

	$tag = '';
	$attrs = '';
	$self_closing_elements = array('area', 'base', 'basefont', 'br', 'col', 'frame', 'hr', 'img', 'input', 'link', 'meta', 'param');

	if( @is_array($attributes) ){
		ksort($attributes);
		foreach($attributes as $key => $value){
			$attrs .= ' '.$key.'="'.$value.'"';
		}
	}
	if($element){
		$tag = "<$element$attrs>";
		if( !@in_array($element, $self_closing_elements) ){
			$tag .= "$html</$element>";
		}
	}
	return $tag;
}


function getTimeArray($time= '00:00:00')
{
	$arr = array();
	if($time){
		$arr = explode(':', $time);
	}
	return $arr;
}

if ( ! function_exists('mail_to'))
{
	function mail_to($email)
	{
		if($email)
		{
			return '<a href="mailto:'.$email.'">'.$email.'</a>';
		}

		return FALSE;
	}
}

if(!function_exists('str_concat'))
{
	function str_concat()
	{
		$args = func_get_args();
		if(count($args) > 0)
		{
			$str = '';
			foreach ($args as $key => $value) 
				if(preg_match("/[0-9a-zA-Z ]/", $value))
					$str .= $value;
			return $str;
		}
		else
		{
			$debug_backtrace = debug_backtrace();
			$debug_backtrace = $debug_backtrace[0];
			
			$error = '<strong>Warning:</strong>';
			$error .= ' Missing argument for function '.$debug_backtrace['function'].'(),';
			$error .= ' Atleast one argument required called in '.$debug_backtrace['file'];
			$error .= ' on line '.$debug_backtrace['line'].'';
			
			echo $error;
			die();
		}
	}
}

if(!function_exists('to_camel_case'))
{
	function to_camel_case($str)
	{
		return preg_replace_callback ('/-(.)/', create_function('$matches','return strtoupper($matches[1]);'), $str);
	}
}

if(!function_exists('prepare_item_url'))
{
	function prepare_item_url($str)
	{
		$url = '';
		if($str)
		{
			$url  = preg_replace('/[^_a-z0-9-]/i','', preg_replace('/\s+/', '-', strtolower(trim($str))));
            $url  = trim(preg_replace('/-+/', '-', $url), '-');
		}
		return $url;
	}
}
if(!function_exists('image_to_base64'))
{
	function image_to_base64($file)
	{

		if($file && file_exists($file))
		{

			$image_details = getimagesize($file);

			$mime = $image_details['mime'];
			
			if(preg_match('/(jpeg|png|gif|jpg)$/', $mime))
			{

				$handler = fopen($file, "r");
				$picture = fread($handler,filesize($file));
				
				fclose($handler);
				
				return 'data:'.$mime.';base64,'.base64_encode($picture);
			}
			else
			{
				return false;
			}

		}
		else
		{
			return false;
		}
	}
}

if(!function_exists('page_list'))
{
	$step = 0;
	
	function page_list($is_mobile= false, $parent=0, $sel='')
    {

    	global $step;

    	if($sel_field && !@in_array($sel_field, $fields)) $fields[] = $sel_field;

    	$sql = "SELECT gp.`id`, pmd.`name`, gp.`parent_id`
    	    FROM `general_pages` gp
            LEFT JOIN `page_meta_data` pmd
            ON(pmd.`id` = gp.`page_meta_data_id`)
            WHERE pmd.`status` != 'H'
            AND pmd.`status` != 'D'
            AND gp.`parent_id` = '{$parent}'
            ORDER BY pmd.`rank`";

        
		$pages  = fetch_all($sql);
    	
		$html   = '';
		$hellip = '';
		$step++;

    	if(count($pages) > 0)
    	{

	        for($i=1;$i<$step;$i++){ $hellip .= '&hellip;&hellip;'; }
    		
    		foreach ($pages as $page)
    		{
    			$page_id = $page['id'];
    			$label = $hellip.(($page['name']) ? $page['name'] : 'Untitled '.$page_id);


				$opt_attr = array('value'=>$page_id);

				if($page_id == $sel) $opt_attr['selected'] = 'selected';

		    	$html .= createElement($opt_attr, 'option', $label)."\n";

		    	$html .= page_list($is_mobile, $page_id, $sel);

    		}
    	}
    	
    	$step--;


    	return $html;
    }
}


if ( ! function_exists('delete_files'))
{
	function delete_files($path, $del_dir = FALSE, $level = 0)
	{
		// Trim the trailing slash
		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if ( ! $current_dir = @opendir($path))
		{
			return FALSE;
		}

		while (FALSE !== ($filename = @readdir($current_dir)))
		{
			if ($filename != "." and $filename != "..")
			{
				if (is_dir($path.DIRECTORY_SEPARATOR.$filename))
				{
					// Ignore empty folders
					if (substr($filename, 0, 1) != '.')
					{
						delete_files($path.DIRECTORY_SEPARATOR.$filename, $del_dir, $level + 1);
					}
				}
				else
				{
					unlink($path.DIRECTORY_SEPARATOR.$filename);
				}
			}
		}
		@closedir($current_dir);

		if ($del_dir == TRUE AND $level > 0)
		{
			return @rmdir($path);
		}

		return TRUE;
	}
}

if(!function_exists('array_search_recursive'))
{

	function array_search_recursive($needle,$haystack)
	{
	    foreach($haystack as $key=>$value)
	    {
	        $current_key = $key;
	        if($needle===$value OR (is_array($value) && recursive_array_search($needle, $value) !== false))
	        {
	            return $current_key;
	        }
	    }
	    return false;
	}

}

if(!function_exists('create_rand_chars'))
{

    function create_rand_chars($config = array())
    {
    	$defaults = array();

		$defaults['min_len']            = 8;
		$defaults['max_len']            = 8;
		$defaults['make_uppercase']     = FALSE;
		$defaults['only_numbers']       = TRUE;
		$defaults['only_alphabets']     = FALSE;
		$defaults['make_alpha_numeric'] = TRUE;
		$defaults['alpha_numeric']      = ($defaults['only_numbers'] === TRUE && $defaults['only_alphabets'] === TRUE)? TRUE: $defaults['make_alpha_numeric'];
		$defaults['inc_special_chars']  = FALSE;

		$config = array_merge($defaults, $config);

        $length = rand($config['min_len'], $config['max_len']);
        $selection = '';
        if(($config['only_numbers'] || $config['alpha_numeric']))
        {
            $selection .= str_shuffle('2591730648');
        }
        if(($config['only_alphabets'] || $config['alpha_numeric']))
        {
            $selection .= str_shuffle('aeuoyibcdfghjklmnpqrstvwxz');
        }
        if($config['inc_special_chars'])
        {
            $selection .= "!@04f7c318ad0360bd7b04c980f950833f11c0b1d1quot;#$%&[]{}?|";
        }

        $selection = str_shuffle($selection);
        
        $str = '';
        for($i=0; $i<$length; $i++) {
           $str .= ($config['make_uppercase']) ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
        }
        return $str;
    }

}

function create_item_list($sql, $sel='')
{
	$html = '';
	if($sql)
	{
		$items = fetch_all($sql);
		if(count($items) > 0)
		{
			foreach ($items as $item)
			{
				$selected = ($item['ind'] == $sel) ? ' selected="selected"' : '';
				$html .= '<option value="'.$item['ind'].'"'.$selected.'>'.$item['label'].'</option>';
			}
		}
	}
	return $html;
}

if(!function_exists('get_month'))
{

	function get_month($val, $ucword = FALSE, $long_name = FALSE)
	{
		$months = array('', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');

		if(is_bool($long_name) && $long_name)
			$months = array('', 'january','february','march','april','may','june','july','august','september','october','november','december');

		unset($months[0]);

		$flipped = array_flip($months);

		if(in_array($val, $flipped))
			return ($ucword && is_bool($ucword)) ? ucwords($months[$val]) : $months[$val];
		elseif(in_array($val, $months))
			return $flipped[$val];
	}

}

if(!function_exists('convert_jMY_to_timestamp'))
{
	// convert 'j M Y' to timestamp
	function convert_jMY_to_timestamp($string)
	{
		if(validate_date($string, 'j M Y'))
		{
			return strtotime($string);
		}
		return FALSE;
	}
}

if(!function_exists('display_message'))
{
	function display_message($message, $type = 'danger', $elm = 'p')
	{
		if($message || !empty($message))
		{
			return createElement(array('class'=>"text-{$type}"), $elm, $message);
		}
		return false;
	}
}

function return_json($array)
{
	return json_encode($array);
}

if(!function_exists('create_date_range_array'))
{
	function create_date_range_array($strDateFrom,$strDateTo)
	{

		$begin = new DateTime($strDateFrom);
		$end = new DateTime($strDateTo);

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		$date_range = array();
		foreach($daterange as $date) array_push($date_range, $date->format("Y-m-d"));

	    return $date_range;
	}
}

if(!function_exists('process_template'))
{
	function process_template($path, $tags = array(), $start_tag = '{', $end_tag = '}')
	{

		if(file_exists($path))
		{
			// read email tempalte file
			$template = file_get_contents($path);

			// replace tags with value
			foreach ($tags as $tag => $value)
			{
				$value    = ($value) ? $value : '';
				$template = str_replace("$start_tag{$tag}$end_tag", $value, $template);
			}

			return $template;
			
		}
		else
		{
			return FALSE;
		}

	}
}

if(!function_exists('validate_date'))
{
	function validate_date($date, $format = 'Y-m-d')
	{

		if( $date && $format )
		{

			$d = DateTime::createFromFormat($format, $date);
			
			return $d && $d->format($format) == $date;

		}
		return false;
	}
}

if(!function_exists('generate_num_dd'))
{
	function generate_num_dd($min, $max, $sel = '', $show_last_plus = false)
	{

		$output = '';
		if(is_numeric($min) && is_numeric($max))
		{
			for ($i=$min; $i <= $max; $i++)
			{ 
				$selected = ($sel == $i) ? ' selected="selected"' : '';
				$output .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
			}

			if($show_last_plus) $output .= '<option value="'.$max.'+"'.(($sel === "{$max}+")? ' selected="selected"' : '').'>'.$max.'+</option>';
			
			return $output;
		}

		return false;
	}
}

if(!function_exists('get_email_list'))
{
	function get_email_list($emails)
	{

		if($emails)
		{
			$email_addresses = array_filter(explode(';', str_replace(array("\r", "\n", "\t", " "), '', $emails)), 'is_email');

			if(count($email_addresses) > 0)
			{
				$email_list = array();
				$email_list['primaryEmail'] = $email_addresses[0];
				unset($email_addresses[0]);
				$email_list['list'] = (object) $email_addresses;

				return (object) $email_list;
			}
		}

		return false;

	}
}
if(!function_exists('format_bytes'))
{
	function format_bytes($bytes, $precision = 2)
	{ 
	    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	    $bytes = max($bytes, 0); 
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	    $pow = min($pow, count($units) - 1); 

	    // Uncomment one of the following alternatives
	    // $bytes /= pow(1024, $pow);
	    // $bytes /= (1 << (10 * $pow)); 

	    return round($bytes, $precision) . ' ' . $units[$pow]; 
	}
}


function get_unique_key($table, $field)
{
	if($table && $field)
	{
		$new_key = create_rand_chars();

		$is_existing = fetch_value("SELECT `id` FROM `{$table}` WHERE `{$field}` = '$new_key' LIMIT 1");

		if($is_existing)
		{
			get_unique_key($table, $field);
		}
		else
		{
			return $new_key;
		}
	}
	else
	{
		die('Arguments required.');
	}

}

function fetchImportantPageInfo($id)
{

	
	if( $id )
	{
	    $sql = "SELECT pmd.`url`, pmd.`full_url`, pmd.`name` AS menu_name, pmd.`menu_label`,
	    pmd.`title`, gp.`id` AS pg_id
	    FROM `general_importantpages` ip
	    LEFT JOIN `general_pages` gp
	    ON(gp.`id` = ip.`page_id`)
	    LEFT JOIN `page_meta_data` pmd
	    ON(gp.`page_meta_data_id` = pmd.`id`)
	    WHERE pmd.`status` = 'A'
	    AND ip.`imppage_id` = '{$id}'
	    AND pmd.`url` != ''
	    LIMIT 1";

	    $array = fetch_row($sql);

	   
	    if($array)
	    {

	        $this_importantpage_url  = $array['url'];

	        return (object) array(
	            'menu_label' => (($array['menu_label'])?$array['menu_label']:$array['menu_name']),
	            'url' => $this_importantpage_url,
	            'full_url' => $array['full_url'],
	            'id' => $array['pg_id'],
	            'title' => $array['title']
	        );
	    }

    }

    return false;
}

function get_file_path($file_path, $append_version = true)
{
    if( !$file_path ) return false;

    $file_full_path = realpath(ltrim($file_path, '/'));

    if( is_file($file_full_path) )
    {
		return $file_path.(($append_version) ? '?v='.filemtime($file_full_path) : '');
    }
    return false;
}

function get_heroshot($photo_path, $thumb_path, $alt = '')
{
	global $classdir;

	require_once "{$classdir}/mobile_detect.php";

	$detect = new Mobile_Detect;

	$is_mobile = ($detect->isMobile() && !$detect->isTablet());

	$real_photo_path = realpath( ltrim( $photo_path, '/' ) );
	$real_thumb_path = realpath( ltrim( $thumb_path, '/' ) );

	$photo_view       = '';
	$thumb_photo_view = '';
	$bm_logo          = '<img src="/graphics/partners/logo-bmw.jpg" class="plogo" alt="Official Partner of BMW Motorrad" width="211" height="77">';

	if( (!$is_mobile && is_file($real_photo_path)) || (getenv('REMOTE_ADDR') == '127.0.0.1' && is_file($real_photo_path)))
	{
		$photo_view = '<img src="'.$photo_path.'" class="hero" alt="'.$alt.'">'.$bm_logo;

	}

	if( ($is_mobile && is_file($real_thumb_path)) || (getenv('REMOTE_ADDR') == '127.0.0.1' && is_file($real_thumb_path) ))
	{
		$thumb_photo_view = '<div class="heroshot xs"><img src="'.$thumb_path.'" alt="'.$alt.'" class="hero">'.$bm_logo.'</div>';
	}

	return (object) array(
		'photo' => $photo_view,
		'thumb_photo' => $thumb_photo_view,
	);
	
}

?>