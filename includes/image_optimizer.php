<?php
include_once('../utility/config.php');


if( isset($_GET['imv']) )
{

    $image_path = $_SERVER['REDIRECT_URL'];
    $image_full_path = "$rootfull{$image_path}";
        


    if( is_file($image_full_path) )
    {
        
        list($image_width, $image_height) = explode('x', $_GET['imv']);

        
        $requested_image = imagecreatefromjpeg($image_full_path);
        
        if ($requested_image === false) { die ('Unable to open image'); }
        
        $current_width  = imagesx($requested_image);
        $current_height = imagesy($requested_image);
        
        $max_width  = 1200;
        $max_height = 900;
        
        if( isset($_GET['ratio']) )
        {
            //calculate new image dimensions (preserve aspect)
            if($image_width && !$image_height)
            {
                $new_w = $image_width;
                $new_h = $new_w * ($current_height/$current_width);
            }
            elseif($image_height && !$image_width)
            {
                $new_h = $image_height;
                $new_w = $new_h * ($current_width/$current_height);
            }
            elseif(($current_width < $max_width) && ($current_height > $current_height))
            {
                $new_w = $current_width;
                $new_h = ceil($new_w * ($current_height/$current_width));
            }
            elseif(($current_width < $max_width) || ($current_height < $current_height))
            {
                $new_h = $current_height;
                $new_w = $current_width;
            }
            else
            {
                $new_w = $image_width ? $image_width : 1200;
                $new_h = $image_height ? $image_height : 900;

                $ratio_orig = ($current_width/$current_height);
                $ratio_new  = ($new_w/$new_h);

                if($ratio_orig >  $ratio_new)
                {
                    $new_h = ceil($new_w * ($current_height/$current_width));
                }
                else
                {
                    $new_w = ceil($new_h * ($current_width/$current_height));    
                }
            }
        }
        else
        {
            $new_w = $image_width;
            $new_h = $image_height;
        }

        $new_image = imagecreatetruecolor($new_w, $new_h);
        
        imagecopyresampled($new_image, $requested_image, 0, 0, 0, 0, $new_w, $new_h, $current_width, $current_height);



        // send resized image to browser
        $image_name = basename($image_path);
        $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
        $browser_cache = 60*60*24*7;

        header('Content-Type: image/'.$image_ext);
        imagejpeg($new_image);
        imagedestroy($new_image);
        exit();
    }
}

?>