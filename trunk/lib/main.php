<?php

    //File is like main. Lets do tests and stuffs here :D
    
    //First lets include files we need
    require_once('core.class.php');
    require_once('error.class.php');
    require_once('database.class.php');
    require_once('utilities.class.php');
    require_once('form.class.php');
    
    error_reporting(E_ALL^E_NOTICE);

    $Core = new Core();
    $Core->Database->setTable('user');
    $Core->Database->setCredentials('localhost', 'root', 'root', 'CRM');
    $Core->setDefaultPage("insert");
    //Page Variable
    $p = $Core->get();
    
    $Form = new Form();
    $Form->openFieldset("Lets insert into User table");
    $Form->text("Name", "name", "");
     $Form->text("Date of Birth", "dob", "");
     $Form->closeFieldSet();
     $Form->submit("", "submit","Insert");

?><html>
    <head>
        <title>Client Relational Managment</title>
        <link rel="stylesheet" href="./css/easy.css" />
        <link rel="stylesheet" href="./css/style.css" />
    </head>
    <body>
    <div id="container">
    <div id="header">
        <h1>Client Relational Management</h1>
        <ul id="nav">
            <li><a href="?p=insert">Insert Into User Table</a></li>
            <li><a href="?p=view">View User Table</a></li>
        </ul>
    </div>
        <div class="content">
            <div class="main">
                <?php
                  
                  switch($p) {
case "insert":                    
                    echo $Form->Build();
                    if (isset($_POST['submit'])) {
                        
                      $ID = $Core->Database->insertRow($_POST);
                      
                      if ($ID > 0) {
                        echo $Core->Utilities->drawNotice("Data inserted successfully", "success");
                      } else
                        echo $Core->Utilities->drawNotice("Data not inserted successfully", "error");
                    }
break;
case "view":
    
    var_dump($Core->Database->selectRows());
    break;
                  }
                    
                    
                    //This is here to display any errors that may arise from the Database class.
                    echo $Core->displayDBErrors();
                ?>
            </div>
        </div>
        <div id="footer">
            
        </div>
    </div>
        
    </body>
</html>