<?php

class Error {

    public $errors;
    private $super;
    
    public function Error(&$parent) {
        
        $this->super = $parent;
        
        
    }
    
    public function record($err_str, $class, $line, $function) {
        $this->errors[] = $err_str." $class::$function on Line $line";
    }
    
    public function report() {
        if (is_array($this->errors)) {
        foreach ($this->errors as $error)
            $str .= $error."<br />";
        }
        
        return $str;
    }

}

?>