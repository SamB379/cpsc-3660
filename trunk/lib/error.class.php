<?php

class Error {

    public $errors;
    private $super;
    private $error_count;
    
    public function Error(&$parent) {
        
        $this->super = $parent;
        $this->error_count = 0;
        
        
    }
    
    public function record($err_str, $class, $line, $function) {
        $this->errors[] = $err_str." $class::$function on Line $line";
        $this->error_count++;
    }
    
    public function report() {
        if (is_array($this->errors)) {
        foreach ($this->errors as $error)
            $str .= $error."<br />";
        }
        
        return $str;
    }
    
    public function getErrorCount() {
        return $this->error_count;
    }

}

?>