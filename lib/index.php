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
?>
<div id="container">
	<div id="header">
		<h1>Client Relational Management</h1>
		<ul id="nav">
			<li>Client
				<ul>
				<li><a href="?action=add&table=client">Add</a></li>
				<li><a href="?action=view&table=client">View</a></li>
				</ul></li>
			<li>Customer
				<ul>
					<li><a href="?action=add&table=customer">Add</a></li>
				<li><a href="?action=view&table=customer">View</a></li>
				
				</ul>
				</li>
			<li>User
				<ul>
					<li><a href="?action=add&table=users">Add</a></li>
				<li><a href="?action=view&table=users">View</a></li>
				
				</ul>
				
			</li>
				<li>Communication Records
				<ul>
					<li><a href="?action=add&table=commrecords">Add</a></li>
				<li><a href="?action=view&table=commrecords">View</a></li>
				
				</ul>
				
			</li>
			
				<li>Organization
				<ul>
					<li><a href="?action=add&table=organization">Add</a></li>
				<li><a href="?action=view&table=organization">View</a></li>
					
				</ul>
				
			</li>
				<li>Partner
				<ul>
					<li><a href="?action=add&table=partner">Add</a></li>
				<li><a href="?action=view&table=partner">View</a></li>
					
				</ul>
				
			</li>
				<li>Supplier
				<ul>
					<li><a href="?action=add&table=supplier">Add</a></li>
				<li><a href="?action=view&table=supplier">View</a></li>
					
				</ul>
				
			</li>
			</ul>
	</div>

<div class="content">
	<div class="main">
		
			<?php
			$actions = array("view", "add", "edit", "delete");
			$tables = array("users", "client", "supplier", "partner", "organization", "customer", "commrecord");

			if (in_array($_GET['action'], $actions)) {
				$action = $_GET['action'];
				if (in_array($_GET['table'], $tables)) {
					$table = $_GET['table'];
					echo '<h3> ' . ucfirst($action) . ' ' . ucfirst($table) . '</h3>';
					$Core -> Database -> setTable($table);
					$fields = $Core -> Database -> getFieldsInfo();
					$datas = $Core -> Database -> selectRows();

					switch($action) {
						case "view" :
							echo $Core -> Utilities -> drawTable($fields, $datas);
							break;
						case "add" :
						case "edit" :
							$Input[] = new Input("select", "admin_level");
							for ($i = 1; $i <= 10; $i++)
								end($Input) -> addOption("Level " . $i, $i);
							$Input[] = new Input("password", "password");
							$Input[] = new Input("select", "orgID");
							$Core -> Database -> setTable("organization");
							$orgIds = $Core -> Database -> selectRows();
							foreach ($orgIds as $org)
								end($Input) -> addOption($org['name'], $org['ID']);
							$Input[] = new Input("select", "age");
							for ($i = 18; $i < 100; $i++)
								end($Input) -> addOption($i, $i);
							$Input[] = new Input("select", "userID");
							$Core -> Database -> setTable("users");
							$users = $Core -> Database -> selectRows();
							foreach ($users as $user)
								end($Input) -> addOption($user['name'], $user['ID']);

							$Input[] = new Input("select", "clientID");
							$Core -> Database -> setTable("client");
							$clients = $Core -> Database -> selectRows();
							foreach ($clients as $client)
								end($Input) -> addOption($client['name'], $client['ID']);

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
