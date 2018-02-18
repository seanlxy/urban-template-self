<?php
    session_start();
    require_once '../utility/config.php';
    
    $captcha_text_len = ( $is_local ) ? 1 : 5;
    
    // generate random number and store in session
    $config = array();

    $config['min_len']            = $captcha_text_len;
    $config['max_len']            = $captcha_text_len;
    $config['make_alpha_numeric'] = TRUE;

    $randomnr            = create_rand_chars($config);
    $_SESSION['captcha'] = hash('sha512', sha1(md5($randomnr)));


    // Init variables 
    $image_width  = 200;
    $image_height = 60;
    $font         = realpath('../themes/global/assets/fonts/ubuntu/regular/webfont.ttf');
    $font_size    = 25;
    $min_angle    = -3;
    $max_angle    = 3;
    $angle        = rand($min_angle, $max_angle);


    //generate image
    $im                  = imagecreatetruecolor($image_width, $image_height);
    
    //colors:
    $white               = imagecolorallocate($im, 249, 247, 247);
    $grey                = imagecolorallocate($im, 128, 128, 128);
    $black               = imagecolorallocate($im, 0, 0, 0);
    
    imagefilledrectangle($im, 0, 0, $image_width, $image_height, $white);

    // Write text on image


    // center text in image
    $text_box    = imagettfbbox($font_size, ($angle+15), $font, $randomnr);
    
    $text_width  = $text_box[2] - $text_box[0];
    $text_height = $text_box[3] - $text_box[1];


    // $ix = ($image_width/2) - (($text_width/2) + 7);
    $ix = 20;
    $iy = ($image_height/2) - (($text_height/2) + 7) + 14;

    //draw text && create image:
    for($i=0; $i < strlen($randomnr); $i++)
    { 
        
        $angle        = rand($min_angle, $max_angle);
        $x = $ix + ($ix * $i+2);
        $y = $iy + $angle;

        imagettftext($im, $font_size,2, $x, $y, $grey, $font, $randomnr[$i]);
        imagettftext($im, $font_size, $angle, ($x-6), ($y-5), $black, $font, $randomnr[$i]);
    }



    // avoid browser caching
    header('Expires: Wed, 1 Jan 1997 00:00:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
 
    //send image to browser
    header ("Content-type: image/jpeg");
    imagejpeg($im);
    imagedestroy($im);
    exit();
?>