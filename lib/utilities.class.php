<?php

class Utilities {
    private $super;
    public function Utilities(&$parent) {
        $this->super = $parent;
    }
    
    /**
     * Function to draw simple notifications. $type a string: notice, success, error
     * @param $msg
     * @param $type
     */
    public function drawNotice($msg, $type) {
        return '<div class="'.$type.'">'.$msg.'</div>';
    }

}


?>