<?php
class filenames{
    public $path, $extension, $filename, $directory;
    
    function getFileExtension(){
        $str = preg_match('/[a-zA-Z]{2,3}$/',$this->path,$matches);
        $this->extension = $matches[0];
        return $this->extension ? $this->extension : false;
    }
    function getFilename(){
        $str = preg_match('/([^\\/]+)\.[a-zA-Z]{2,3}$/',$this->path,$matches);
        $this->filename = $matches[1];
        return $this->filename ? $this->filename : false;
    }
    function getDirectory(){
        $str = preg_match('/^(.+)[\\/]/',$this->path,$matches);
        $this->directory = $matches[0];
        return $this->directory ? $this->directory : false;
    }
}
?>