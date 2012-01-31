<?php
error_reporting(E_ALL);
    //Two dimentional test
    $cond['name']['>='] = "fart";
    
    foreach ($cond as $key=>$rest) {
        echo $key;
        foreach($rest as $key=>$val) {
            echo $key.$val;
        }
        
    }
    
    
?>