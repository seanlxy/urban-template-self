<?php

// Validate
function is_notempty($var){
    return (bool)$var;
}
function is_instring($haystack,$needle){
    return (bool)(strpos($haystack,$needle)!==false);
}
function is_email($str){
    return filter_var($str, FILTER_VALIDATE_EMAIL);
}
function is_number($val,$type='float'){
    switch($type){
        case('float'):  return filter_var($val,FILTER_VALIDATE_FLOAT); break;
        case('int'):    return filter_var($val,FILTER_VALIDATE_INT); break;
        default:        return false;
    }
}
function is_length($str,$len=1){
    return isset($str) && strlen(strip_tags($str)) >= $len;
}
function is_match($str1,$str2){
    return (bool)($str1 === $str2);
}
function is_phone($str){
    return preg_match("/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/",$str);
}

function is_alpha($str){
    return preg_match("/^([A-Za-z\s ]+)$/",$str);
}

function is_lower_alpha($str){
    $str = trim($str);
    if(preg_match("/^([a-z]+)$/",$str))
    {
        return $str;
    }
    return false;
}

function is_alphanumeric($str){
    return ctype_alnum($str);
}
function is_url($str){
    return filter_var($str, FILTER_VALIDATE_URL);
}
function is_ipaddress($str){
  return filter_var($str, FILTER_VALIDATE_IP);
}
function is_creditcard($str){
    return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/', $str);
}
function is_hexcolour($str){
    return preg_match('/^#(?:(?:[a-f0-9]{3}){1,2})$/i', $str);
}
function is_date($str,$format='nz'){
    switch($dateformat){
        case('nz'):
            list($d,$m,$y) = explode('/',$str); break;
        default:
            list($d,$m,$y) = explode('/',$str);
    }
    return ($m && $d && $y) ? checkdate($m,$d,$y) : false;
}


//// Validate (Exists)
function is_existing_url($url){
    $url = @parse_url($url);
    if(!$url){ return false; }
 
    $url = array_map('trim', $url);
    $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
    $path = (isset($url['path'])) ? $url['path'] : '';
 
    $path = $path=='' ? '/' : $path;
 
    $path .= (isset($url['query'])) ? '?$url[query]' : '';
 
    if (isset($url['host']) AND $url['host'] != @gethostbyname($url['host'])){
        $headers = @get_headers('$url[scheme]://$url[host]:$url[port]$path');
        $headers = (is_array($headers)) ? implode('\n', $headers) : $headers;
        return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
    }
    return false;
}
function is_existing_image($url){
    if(@file_get_contents($url,0,NULL,0,1)){return 1;}else{ return 0;}
}


// Sanitize
function sanitize_email($str){
    return filter_var($url, FILTER_SANITIZE_EMAIL);
}
function sanitize_number($val,$type='float'){
    switch($type){
        case('float'):  return filter_var($val, FILTER_SANITIZE_NUMBER_FLOAT);
        case('int'):    return filter_var($val, FILTER_SANITIZE_NUMBER_INT);
        default:        return false;
    }
}
function sanitize_string($val,$type){
    return filter_var($str, FILTER_SANITIZE_STRIPPED);
}
function sanitize_alphanumeric($str){
    return preg_replace('/[^a-zA-Z0-9]/', '', $str);
}
function sanitize_url($str){
     return filter_var($str, FILTER_SANITIZE_URL);
}
function sanitize_sql($str){
    return is_array($str) ? array_map('_clean', $str) : str_replace('\\', '\\\\', htmlspecialchars((get_magic_quotes_gpc() ? stripslashes($str) : $str), ENT_QUOTES));
}
function sanitize_xss($str){
    return is_array($str) ? array_map('_clean', $str) : str_replace('\\', '\\\\', strip_tags(trim(htmlspecialchars((get_magic_quotes_gpc() ? stripslashes($str) : $str), ENT_QUOTES))));
}

?>