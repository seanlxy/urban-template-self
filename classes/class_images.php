<?php
class images {
        
    public $width, $height, $left, $top, $margin_left, $margin_top, $scaling, $container_width, $container_height, $orientation_relative, $styles_image, $styles_container;
        
    function __construct(){
    }

    function setScaling($scaling){
        $this->scaling                      = $scaling;
    }
    
    function setHeight($height){
        $this->height                       = $height;
        $this->margin_top                   = NULL;
        $this->top                          = NULL;
    }
    
    function setWidth($width){
        $this->width                        = $width;
        $this->margin_left                  = NULL;
        $this->left                         = NULL;
    }
    
    function setContainerWidth($width){
        return $this->container_width              = $width;
    }
    
    function setContainerHeight($height){
        return $this->container_height             = $height;
    }
    
    function initiateScaling(){
        if(!$this->height)              {   $this->err_msg['height']            = "The image height has not been set.";             }
        if(!$this->width)               {   $this->err_msg['width']             = "The image width has not been set.";              }
        if(!$this->scaling)             {   $this->err_msg['scaling']           = "The image scaling has not been set.";            }
        if(!$this->container_height)    {   $this->err_msg['container_height']  = "The image container height has not been set.";   }
        if(!$this->container_width)     {   $this->err_msg['container_width']   = "The image container width has not been set.";    }
        
        if(!count($this->err_msg)){
            switch($this->scaling){
                case('stretch'):            $this->image_stretch();             break;
                case('fit'):                $this->image_fit();                 break;
                case('fill'):               $this->image_fill();                break;
                case('center'):             $this->image_center();              break;
                default:                    $this->err_msg['scaling']           = "The scaling type set does not exist.";
            }
        }
        
        return (count($this->err_msg)) ? false : $this->styles_image;
    }
    
    
    function image_stretch(){
        if($this->width!=0 && $this->height!=0 && $this->container_height!=0 && $this->container_width != 0){
            $this->left                         = 0;
            $this->right                        = 0;
            $this->margin_left                  = 0;
            $this->margin_top                   = 0;
            $this->orientation_relative         = NULL;
            $this->getOrientation();
            
            return $this->form_styles();
        }else{return false;}
    }

    function image_fill(){
        if($this->width!=0 && $this->height!=0 && $this->container_height!=0 && $this->container_width != 0){
            $this->getOrientation();
            $orientation = $this->getOrientation_relative();
            if($orientation == "portrait") {
                $image_resize                   = $this->container_width / $this->width;
                $this->width                    = round(($this->container_width),0);
                $this->height                   = round(($this->height * $image_resize),0);
            }else{
                $image_resize                   = $this->container_height / $this->height;
                $this->height                   = round(($this->container_height),0);
                $this->width                    = round(($this->width * $image_resize),0);
            }
            $this->margin_top                   = round(($this->height / 2*(-1)),0);
            $this->margin_left                  = round(($this->width / 2*(-1)),0);
            $this->left                         = "50%";
            $this->top                          = "50%";
            
            return $this->form_styles();
        }else{return false;}
    }

    function image_fit(){
        if($this->width!=0 && $this->height!=0 && $this->container_height!=0 && $this->container_width != 0){
            //$this->getOrientation();
            //echo $this->width;
            //echo $this->height;
            $orientation = $this->getOrientation_relative();
            if($orientation == "portrait") {
                $image_resize                   = $this->height / $this->container_height;
                $this->height                   = round(($this->container_height),0);
                $this->width                    = round(($this->width / $image_resize),0);
            }else{
                $image_resize                   = $this->container_width / $this->width;
                $this->width                    = round(($this->container_width),0);
                $this->height                   = round(($this->height * $image_resize),0);
            }
            $this->margin_top                   = round(($this->height / 2*(-1)),0);
            $this->margin_left                  = round(($this->width / 2*(-1)),0);
            $this->left                         = "50%";
            $this->top                          = "50%";
            
            return $this->form_styles();
        }else{return false;}
    }

    function image_center(){
        $this->left                          = "50%";
        $this->top                           = "50%";
        $this->margin_top                   = round(($this->height /2 * (-1)),0);
        $this->margin_left                  = round(($this->width /2 * (-1)),0);
        $this->orientation_relative         = NULL;
        $this->getOrientation();
        
        return $this->form_styles();
    }
    
    function form_styles(){
        $this->styles_image                 = "";
        $this->styles_image                 .= "position:absolute;";
        $this->styles_image                 .= "width:{$this->width}px;";
        $this->styles_image                 .= "height:{$this->height}px;";
        $this->styles_image                 .= "left:{$this->left};";
        $this->styles_image                 .= "top:{$this->top};";
        $this->styles_image                 .= "margin-top:{$this->margin_top}px;";
        $this->styles_image                 .= "margin-left:{$this->margin_left}px;";
        
        return $this->styles_image;
    }

    function getOrientation_relative(){
        if($this->width!=0 && $this->height!=0 && $this->container_height!=0 && $this->container_width != 0){
            $container_ratio                    = $this->container_width / $this->container_height;
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
}
?>