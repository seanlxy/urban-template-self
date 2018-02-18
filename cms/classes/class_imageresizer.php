<?php
include_once("class_filenames.php");
class images extends filenames{
        
    public $maxwidth, $maxheight, $path, $image, $savetype, $error_arr, $orientation_relative,
            $orientation, $newheight, $newwidth, $suffix, $savedirectory, $newimage, $new_image_new_name;
        
    function __construct(){
        $this->new_image_new_name = null;
    }

    function setMaxWidth($maxwidth){
        return $this->maxwidth         = $maxwidth;
    }
    
    function setMaxHeight($maxheight){
        return $this->maxheight        = $maxheight;
    }
    
    function setSaveType($savetype){
        return $this->savetype      = $savetype;
    }
    
    function setSuffix($suffix){
        return $this->suffix        = $suffix;
    }
    
    function setSaveDirectory($savedirectory){
        return $this->savedirectory = $savedirectory;
    }
    
    function setQuality($quality){
        return $this->quality = $quality;
    }
    
    function allowOverwrite($value){
        return $this->overwrite = (bool)$value;
    }
    
    function initiate(){
        $this->error_arr = array();
        if(!$this->maxwidth && !$this->maxheight){
            $this->error_arr[] = 'Please specify a maximum width and/or height.';
        }
        if(!$this->path){
            $this->error_arr[] = 'Please specify an image path.';
        }else{
            if(!fopen($this->path,'r')){
               $this->error_arr[] = 'Sorry, but the file specified does not exist.'; 
            }else{
                $this->getFileExtension();
                $this->getFilename();
                $this->getDirectory();
                switch(strtolower($this->extension)){
                    case('jpg'): case('jpeg'):
                        $this->image = imagecreatefromjpeg($this->path);
                        break;
                    case('gif'):
                        $this->image = imagecreatefromgif($this->path);
                        break;
                    case('png'):
                        $this->image = imagecreatefrompng($this->path);
                        break;
                    case('wbmp'): case('bmp'):
                        $this->image = imagecreatefromwbmp($this->path);
                        break;
                }
                if(!$this->image){
                    $this->error_arr[] = 'Sorry, but the image specified is not supported.';
                }else{
                    $this->imageinfo = getimagesize($this->path);
                    $this->width = $this->imageinfo[0];
                    $this->height = $this->imageinfo[1];
                }
            }
        }
        if(!$this->savedirectory){
            $this->error_arr[] = 'Please specify a directory to save the image to.';
        }else{
            if(!file_exists($this->savedirectory)){
                $this->error_arr[] = 'The save directory specified does not exist.';
            }
            if(!is_writeable($this->savedirectory)){
                $this->error_arr[] = 'The save directory specified does not have writing permission.';
            }
        }
        if(!$this->quality){
            $this->quality = 80;
        }else{
            $this->quality = str_replace('%','',$this->quality);
        }
    }
    
    function saveImage($crop=false){
        if($crop){
            $this->newimage = imagecreatetruecolor($this->maxwidth, $this->maxheight);
            $newx = ($this->maxwidth - $this->newwidth) / 2;
            $newy = ($this->maxheight - $this->newheight) / 2;


            imagecopyresampled($this->newimage, $this->image, $newx, $newy, 0, 0, $this->newwidth, $this->newheight, $this->width, $this->height);
        }else{
            $this->newimage = imagecreatetruecolor($this->newwidth, $this->newheight);
            imagecopyresampled($this->newimage, $this->image, 0, 0, 0, 0, $this->newwidth, $this->newheight, $this->width, $this->height);
        }
        
        if(!$this->savetype){
            $this->savetype = $this->extension;
        }
        switch(strtolower($this->savetype)){
            case('jpg'): case('jpeg'):
                imagejpeg($this->newimage,$this->savedirectory.'/'.((!is_null($this->new_image_new_name)) ? $this->new_image_new_name : $this->filename).$this->suffix.'.'.$this->savetype,$this->quality);
                break;
            case('gif'):
                imagegif($this->newimage,$this->savedirectory.'/'.((!is_null($this->new_image_new_name)) ? $this->new_image_new_name : $this->filename).$this->suffix.'.'.$this->savetype,$this->quality);
                break;
            case('png'):
                imagepng($this->newimage,$this->savedirectory.'/'.((!is_null($this->new_image_new_name)) ? $this->new_image_new_name : $this->filename).$this->suffix.'.'.$this->savetype,$this->quality);
                break;
            //case('wbmp'): case('bmp'):
            //    imagewbmp($this->newimage,$this->savedirectory.'/'.$this->filename.$this->suffix.'.'.$this->savetype,$this->quality);
            //    break;
            default:
                $this->error_arr[] = 'The savetype specified is not supported';
                return $this->displayErrors();
        }
        return true;
    }
    
    function resizeToFill($crop=false){
        $this->initiate();
        if($this->height>$this->maxheight || $this->width>$this->maxwidth || !$dontenlarge){
            if($this->maxheight && $this->maxwidth){
                if($this->getOrientation_relative() == "portrait") {
                    $image_resize                   = $this->maxwidth / $this->width;
                    $this->newwidth                 = round(($this->maxwidth),0);
                    $this->newheight                = round(($this->height * $image_resize),0);
                }else{
                    $image_resize                   = $this->maxheight / $this->height;
                    $this->newheight                = round(($this->maxheight),0);
                    $this->newwidth                 = round(($this->width * $image_resize),0);
                }
            }else{
                $this->error_arr[] = 'In order to use the resizeToFill method, you must specify both the max height and max width';
            }
        }else{
            $this->newwidth = $this->width;
            $this->newheight = $this->height;
        }
        return count($this->error_arr) ? $this->displayErrors() : $this->saveImage($crop);
    }
    
    function resizeToFillCropped(){
        $this->resizeToFill(true);
    }
    
    function resizeToFit($dontenlarge=false){
        $this->initiate();
        if($this->height>$this->maxheight || $this->width>$this->maxwidth || !$dontenlarge){
            if($this->getOrientation_relative() == "portrait" || !$this->maxwidth) {
                if($this->maxheight){
                    $image_resize                   = $this->height / $this->maxheight;
                    $this->newheight                = round(($this->maxheight),0);
                    $this->newwidth                 = round(($this->width / $image_resize),0);
                }else{
                    $this->error_arr[] = 'In order to use the resizeToFit with this relatively-portrait image, you must specify a max height';
                }
            }elseif($this->getOrientation_relative() == "landscape" || !$this->maxheight){
                if($this->maxwidth){
                    $image_resize                   = $this->maxwidth / $this->width;
                    $this->newwidth                 = round(($this->maxwidth),0);
                    $this->newheight                = round(($this->height * $image_resize),0);
                }else{
                    $this->error_arr[] = 'In order to use the resizeToFit with this relatively-landscape image, you must specify a max width';
                }
            }
        }else{
            $this->newheight = $this->height;
            $this->newwidth = $this->width;

        }
        
        return count($this->error_arr) ? $this->displayErrors() : $this->saveImage();
    }
    
    function resizeStretch(){
        $this->initiate();
        $this->newheight = $this->maxheight;
        $this->newwidth = $this->maxwidth;
        return count($this->error_arr) ? $this->displayErrors() : $this->saveImage();
    }

    function displayErrors(){
        if(count($this->error_arr)){
            $str = 'The image could not be resized for the following reason'.(count($this->error_arr)>1?'s':'').'... <br/><ul>';
            foreach($this->error_arr as $value){
                $str .= '<li>'.$value.'</li>';
            }
            $str .= '</ul>';
            return $str;
        }else{
            return false;
        }
        
    }

    function getOrientation_relative(){
        if($this->width!=0 && $this->height!=0 && $this->maxheight!=0 && $this->maxwidth != 0){
            $container_ratio                    = $this->maxwidth / $this->maxheight;
            $image_ratio                        = $this->width / $this->height;
            return $this->orientation_relative  = ($container_ratio > $image_ratio) ? "portrait" : "landscape";
        }else{return false;}
    }
    
    function getOrientation(){
        if($this->width!=0 && $this->height!=0){
            $image_ratio                        = $this->width / $this->height;
            return $this->orientation           = ($image_ratio >= 1) ? "landscape" : "portrait";
        }else{return false;}
    }
    
    
    function resizer($saveDir, $path, $maxWidth, $maxHeight, $new_name = null, $saveType='jpg', $scaleType='fill', $qlty=80){
        $this->setSaveDirectory($saveDir);
        $this->path = $path;
        $this->setMaxWidth($maxWidth);
        $this->setMaxHeight($maxHeight);
        $this->new_image_new_name = $new_name;

        if($saveType === 'jpg' || $saveType === 'jpeg') $this->setQuality($qlty);
        $this->setSaveType($saveType);
    if( $scaleType == 'fill' ){
        $this->resizeToFillCropped();  
    }else{
        $this->resizeToFitCropped();
    }
    }

    function scaleImage($path,$containerHeight,$containerWdith,$scaleType='fill'){
        $this->setContainerHeight($containerHeight);
        $this->setContainerWidth($containerWdith);
        $this->setScaling($scaleType);
        
        $dimentions = @getimagesize($path);
        
        if($dimentions && is_array($dimentions) && count($dimentions)>3){
            
            $this->setWidth($dimentions[0]);
            $this->setHeight($dimentions[1]);
            $image_styles = $this->initiateScaling();
            
            if($image_styles){
                return $image_styles;
            }
        }
    }
}
?>