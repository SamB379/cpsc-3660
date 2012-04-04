<?php

//File is like main. Lets do tests and stuffs here :D

//First lets include files we need
require_once ('core.class.php');
require_once ('error.class.php');
require_once ('database.class.php');
require_once ('input.class.php');
require_once ('form.class.php');
require_once ('utilities.class.php');

require_once ('site.class.php');

error_reporting(E_ALL ^ E_NOTICE);

$Core = new Core();
$Site = new Site();

$Core -> Database -> setTable('user');
$Core -> Database -> setCredentials('localhost', 'exile_3660', '3660pr0j3ct', 'exile_3660');
$Core -> setDefaultPage("viewmainmenu");
//Page Variable
$p = $Core -> get();

$Site -> setTitle("Client Relation Management");
$Site -> addCSS("./css/easy.css");
$Site -> addCSS("./css/style.css");
$Site -> addCSS("./css/jquery-ui-1.8.18.custom.css");
$Site -> addJS("./js/jquery-1.7.1.min.js");
$Site -> addJS("./js/jquery-ui-1.8.18.custom.min.js");
$Site -> addJS("./js/easy.js");
$Site -> addJS("./js/site.js");

$Form = new Form();

echo $Site -> startDraw();

$tables = array("users", "client", "supplier", "partner", "organization", "customer", "commrecord", "association");

?>
<div id="container">
	<div id="header" class="inner">
		<h1>Client Relational Management</h1>
		<ul id="nav" class="inner">
		<?
		
			//Lets build the nav dynamically from the $tables variable
			foreach($tables as $table) {
				echo '<li class="top_level">'.ucfirst($table).'
				<ul>
				<a href="?action=add&table='.$table.'"><li>Add</li></a>
				<a href="?action=view&table='.$table.'"><li>View</li></a>
				</ul></li>';
			}
		?>
		</ul>
		
	</div>

<div class="content">
	<div class="main">
		
			<?php
			$actions = array("view", "add", "edit", "delete");
			

			if (in_array($_GET['action'], $actions)) {
				$action = $_GET['action'];
				if (in_array($_GET['table'], $tables)) {
					$table = $_GET['table'];
					echo '<h3 class="title"> ' . ucfirst($action) . ' ' . ucfirst($Core->Utilities->rmUnderscore($table)) . '</h3>';
					$Core -> Database -> setTable($table);
					$fields = $Core -> Database -> getFieldsInfo();
					$datas = $Core -> Database -> selectRows();

					switch($action) {
						case "view" :
							echo $Core -> Utilities -> drawTable($fields, $datas);
							break;
						case "add" :
						case "edit" :
						
						//Input override section
							$Input[] = new Input("select", "admin_level");
							for ($i = 1; $i <= 10; $i++)
								end($Input) -> addOption("Level " . $i, $i);
							$Input[] = new Input("password", "password");
							$Input[] = new Input("select", "orgID");
							$Core -> Database -> setTable("organization");
							$orgIds = $Core -> Database -> selectRows();
							end($Input) -> addOption('--SELECT--', 0);
							if (is_array($orgIds)) {
							foreach ($orgIds as $org)
								end($Input) -> addOption($org['name'], $org['ID']);
							}
							$Input[] = new Input("select", "age");
							for ($i = 18; $i < 100; $i++)
								end($Input) -> addOption($i, $i);
							$Input[] = new Input("select", "userID");
							$Core -> Database -> setTable("users");
							$users = $Core -> Database -> selectRows();
							end($Input) -> addOption('--SELECT--', 0);
							if (is_array($users)) {
							foreach ($users as $user)
								end($Input) -> addOption($user['name'], $user['ID']);
							}
							$Input[] = new Input("select", "clientID");
							$Core -> Database -> setTable("client");
							$clients = $Core -> Database -> selectRows();
							end($Input) -> addOption('--SELECT--', 0);
							if(is_array($clients)) {
							foreach ($clients as $client)
								end($Input) -> addOption($client['name'], $client['ID']);
							}
							
							$Input[] = new Input("select", "customerID");
							$Core->Database->setTable("customer");
							$customers = $Core->Database->selectRows();
							end($Input) -> addOption('--SELECT--', 0);
							if (is_array($customers)){
								foreach($customers as $customer)
								end($Input)->addOption($customer['name'], $customer['ID']);
							}
							
							$Input[] = new Input("select", "supplierID");
							$Core->Database->setTable("supplier");
							$customers = $Core->Database->selectRows();
							end($Input) -> addOption('--SELECT--', 0);
							if (is_array($customers)){
								foreach($customers as $customer)
								end($Input)->addOption($customer['name'], $customer['ID']);
							}
							
							$Input[] = new Input("select", "partnerID");
												$Core->Database->setTable("partner");
												$customers = $Core->Database->selectRows();
												end($Input) -> addOption('--SELECT--', 0);
												if (is_array($customers)){
													foreach($customers as $customer)
													end($Input)->addOption($customer['name'], $customer['ID']);
												}
							$Input[] = new Input("select", "sex");
							end($Input) -> addOption('--SELECT--', 0);
							end($Input)->addOption("Male", "male");
							end($Input)->addOption("Female", "female");
							
							$Input[] = new Input("select", "medium");
							$mediums = array('phone_call','text_message','email','in_person','voice_mail','postal_letter','video_conference','instant_messanger');
							end($Input) -> addOption('--SELECT--', 0);
							foreach($mediums as $medium)
								end($Input)->addOption($Core->Utilities->rmUnderscore($medium), $medium);
							
							echo $Core -> Utilities -> generateForm($table, $Input, (isset($_GET['ID']) && $_GET['action'] == "edit" ? $_GET['ID'] : null)) -> Build();

							break;
						case "delete" :
							
							if (isset($_GET['ID'])) {
								$Core -> Database -> setTable($table);
								$result = $Core -> Database -> deleteRow($_GET['ID']);
								
								if ($result)
									echo $Core->Utilities -> drawNotice("Data deleted successfully", "success");
								else {
									echo $Core ->Utilities -> drawNotice("Data not deleted successfully", "error");
									echo $Core -> DisplayDBErrors();
								}
							} else {
								echo $this -> drawNotice("What are you trying to delete?", "error");
							}
							break;
					}
					
				}
			}

			

			//This is here to display any errors that may arise from the Database class.
			echo $Core -> displayDBErrors();
			?>
			
		</div>
	</div>
	<div id="footer"></div>
</div>
<? echo $Site -> endDraw();?>
