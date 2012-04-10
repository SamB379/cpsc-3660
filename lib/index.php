<?php session_start();

//File is like main. Lets do tests and stuffs here :D

//First lets include files we need
require_once ('core.class.php');
require_once ('error.class.php');
require_once ('database.class.php');
require_once ('input.class.php');
require_once ('form.class.php');
require_once ('utilities.class.php');

require_once ('site.class.php');

error_reporting(0);

$Core = new Core();
$Site = new Site();

$Core -> Database -> setTable('user');
$Core -> Database -> setCredentials('localhost', 'exile_3660', '3660pr0j3ct', 'exile_3660');
$Core -> setDefaultPage("viewmainmenu");
//Page Variable
$p = $Core -> get();


if ($p == "logout") {
	unset($_SESSION['username']);
	unset($_SESSION['password']);
}

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


if (isset($_POST['submit'])) {
	
	$Core->Database->setTable('users');
	
	$conditions['username']['='] = $_POST['username'];
	$result = $Core->Database->selectRows($conditions);
	
	if (is_array($result)) {
		
		foreach($result as $r) {
			if ($_POST['password'] == $r['password']) {
				$_SESSION['username'] = $r['username'];
				$_SESSION['password'] = $r['password'];
			}
		}
		
	}
	
	 echo $Core -> displayDBErrors(); 
	
}

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

$tables = array("users", "client", "supplier", "partner", "organization", "customer", "commrecord", "association");

?>
<div id="container">
	<div id="header" class="inner">
		<h1>Client Relational Management</h1>
		(<a href="?p=logout">Logout</a>)
		<ul id="nav" class="inner">
		<?
		
			//Lets build the nav dynamically from the $tables variable
			//lets not, casue the names look .fucking. stupid
			//foreach($tables as $table) {
			//	echo '<li class="top_level">'.ucfirst($table).'
			//	<ul>
			//	<a href="?action=add&table='.$table.'"><li>Add</li></a>
			//	<a href="?action=view&table='.$table.'"><li>View</li></a>
			//	</ul></li>';
			//}
			
			echo '<li class="top_level">'.Users.'
				<ul>
				<a href="?action=add&table='.users.'"><li>Add</li></a>
				<a href="?action=view&table='.users.'"><li>View</li></a>
				</ul></li>';
			echo '<li class="top_level">'.Clients.'
				<ul>
				<a href="?action=add&table='.client.'"><li>Add</li></a>
				<a href="?action=view&table='.client.'"><li>View</li></a>
				</ul></li>';
			echo '<li class="top_level">'.Organizations.'
				<ul>
				<a href="?action=add&table='.organization.'"><li>Add</li></a>
				<a href="?action=view&table='.organization.'"><li>View</li></a>
				</ul></li>';
				$text = "Communication Records";
			echo '<li class="top_level">'.$text.'
				<ul>
				<a href="?action=add&table='.commrecord.'"><li>Add</li></a>
				<a href="?action=view&table='.commrecord.'"><li>View</li></a>
				</ul></li>';
				$text = "Customer Data";
			echo '<li class="top_level">'.$text.'
				<ul>
				<a href="?action=add&table='.customer.'"><li>Add</li></a>
				<a href="?action=view&table='.customer.'"><li>View</li></a>
				</ul></li>';
				$text = "Supplier Data";
			echo '<li class="top_level">'.$text.'
				<ul>
				<a href="?action=add&table='.supplier.'"><li>Add</li></a>
				<a href="?action=view&table='.supplier.'"><li>View</li></a>
				</ul></li>';
				$text = "Partner Data";
			echo '<li class="top_level">'.$text.'
				<ul>
				<a href="?action=add&table='.partner.'"><li>Add</li></a>
				<a href="?action=view&table='.partner.'"><li>View</li></a>
				</ul></li>';
				$text = "Client Associations";
			echo '<li class="top_level">'.$text.'
				<ul>
				<a href="?action=add&table='.association.'"><li>Add</li></a>
				<a href="?action=view&table='.association.'"><li>View</li></a>
				</ul></li>';
			
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
							$mediums = array('phone_call','text_message','email','in_person','voice_mail','postal_letter','video_conference','instant_messenger');
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
<? 

} else {
	?>
	<div id="container">
		<div id="header" class="inner">
			<h1>Login</h1>
		</div>
		<div class="content">
			<div class="main">
				
				<form method="POST">
				<div class="form_row">
				<label>Username</label>
				<input type="text" name="username" value="" />
				</div>
				<div class="form_row">
				<label>Password</label>
				<input type="password" name="password" value="" />
				</div>
				<div class="form_row">
				<label></label>
				<input type="submit" name="submit" value="Login" />
				</div>
				
			</div>		
		</div>
		
	</div>
	
	<?
	
}

echo $Site -> endDraw();?>
