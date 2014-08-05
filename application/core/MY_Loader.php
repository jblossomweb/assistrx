<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php"; //extends CI_Loader

class MY_Loader extends MX_Loader{
    public function __construct(){
        parent::__construct();
    }
    public function controller($file_path,$object_name=false){
        $CI = & get_instance();
      
        $el = array_reverse(explode(DIRECTORY_SEPARATOR,$file_path));
        $file_name = $el[0];

        if(!$object_name){
            $object_name = $file_name;
        } 
        $class_name = ucfirst($file_name);

        $file_path = APPPATH.'controllers/'.$file_path.'.php';
      
        if(file_exists($file_path)){
            require $file_path;
            $CI->$object_name = new $class_name();
        }
        else{
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }
}