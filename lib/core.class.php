<?php
/**
 * The core class for our Database project. Lets treat this class like a singleton pattern shall we
 * or very similar. We will access all other classes through this class just to keep things
 * in order and all in one spot. I've also programmed it so the classes internally can call any
 * other class by doing the Java style $super. Its rather straight forward. Hopefully this
 * isn't too complicated.
 */

class Core {

    public $Database;
    public $Error;
    
    
    public function Core() {
        $this->Error = new Error($this);
        $this->Database = new Database($this);
        
    
    }


}

?>