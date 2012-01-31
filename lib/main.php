<?php

    //File is like main. Lets do tests and stuffs here :D
    
    //First lets include files we need
    require_once('core.class.php');
    require_once('error.class.php');
    require_once('database.class.php');

    
    error_reporting(E_ALL^E_NOTICE);

    $Core = new Core();
    $Core->Database->setTable('user');
    $Core->Database->setCredentials('localhost', 'root', 'root', 'CRM');
    
    $cond['name']['='] = "Chad";
    
   
    var_dump($Core->Database->selectRows($cond));
    echo $Core->Error->report();
    
    

?>