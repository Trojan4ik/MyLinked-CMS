<?php
require_once('engine/config.php');

class lang extends config{
    var $data;
    function tplLink(){
        return "templates/".$this->template_name.'/';
    }
    
    function getFile($file){
        $file = $this->tplLink().$file;
        if(file_exists($file)){
            
            return file_get_contents($file);
        }else{
            return null;
        }
    }
    function decode($string){
        return json_decode($string);
    }
    function getArray($file){
        $string = $this->getFile($file);
        if($string!=null){
            $array = $this->decode($string);
            $this->data = $array;
            
            return $this->decode($string);
        }
    }
    

}
$lang = new lang;
?>