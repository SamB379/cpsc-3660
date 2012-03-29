<?php

    //File is like main. Lets do tests and stuffs here :D
    
    //First lets include files we need
    require_once('core.class.php');
    require_once('error.class.php');
    require_once('database.class.php');
    require_once('utilities.class.php');
    require_once('form.class.php');
    require_once('site.class.php');
    
    error_reporting(E_ALL^E_NOTICE);

    $Core = new Core();
    $Site = new Site();
    
    $Core->Database->setTable('user');
    $Core->Database->setCredentials('localhost', 'exile_3660', '3660pr0j3ct', 'exile_3660');
    $Core->setDefaultPage("viewmainmenu");
    //Page Variable
    $p = $Core->get();
    
    $Site->setTitle("Client Relation Management");
    $Site->addCSS("./css/easy.css");
    $Site->addCSS("./css/style.css");
    
    
    $Form = new Form();


	echo $Site->startDraw();
?>
    <div id="container">
    <div id="header">
        <h1>Client Relational Management</h1>
		</br></br>	
		
				

        
    </div>
			
        

			
			
			
			

			
			</div>
        <div class="content">
            <div class="main">
			<div align="center">
                <?php
                  
switch($p) 
{
	case "viewmainmenu":
			echo '<table>
			<tr>
			<td>
            <h3 align="center">Navigation</h3></td></tr>
			<tr><td>
			<li><a href="?p=addmenu">Add</a></li>
			</td>
			<td>
			<li><a href="?p=editmenu">Edit</a></li>
			</td>
			<td>
			<li><a href="?p=viewmenu">View</a></li>
			</td>
			<td>
			<li><a href="?p=deletemenu">Delete</a></li>
			</td>
			</tr>
			</table>';
			
			
	break;
	
	case "addmenu":
		echo '<table>
			<tr>
			<td>
            <h3 align="center">Add</h3></td>
			<tr><td>
			<li><a href="?p=adduser">Add New User</a></li>
			</td>
			<td>
			<li><a href="?p=addclient">Add New Client</a></li>
			</td>
			<td>
			<li><a href="?p=addorganization">Add New Organization</a></li>
			</td>
			</tr>
			<td>
			<li><a href="?p=addcommrecord">Add New Communication Record</a></li>
			</td><td>
			<li><a href="?p=addassociation">Add New Association</a></li>
			</td>
			<td>
			<li><a href="?p=addpartner">Add New Partner</a></li>
			</td><tr><td>
			<li><a href="?p=addsupplier">Add New Supplier</a></li>
			</td>
			<td>
			<li><a href="?p=addcustomer">Add New Customer</a></li>
			</td>
			</tr>
			</table>';
			
			echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
			
	break;
	
	case "viewmenu":
		echo '<table>
			<tr>
			<td>
			<h3 align="center">View</h3>
			</td></tr>
			<div align="center">
			<tr><td>
			<li><a href="?p=viewusers">View Users</a></li></td>
			<td>
			<li><a href="?p=viewclients">View Clients</a></li></td>
			<td>
			<li><a href="?p=vieworganizations">View Organizations</a></li></td></tr>
			<tr><td>
			<li><a href="?p=viewcommrecords">View Communication Records</a></li></td>
			<td>
			<li><a href="?p=viewassociations">View Associations</a></li>
			</td>
			<td>
			<li><a href="?p=viewpartners">View Partners</a></li>
			</td></tr>
			<tr><td>
			<li><a href="?p=viewsuppliers">View Suppliers</a></li>
			</td><td>
			<li><a href="?p=viewcustomers">View Customers</a></li>
			</td></tr>
			</table>';
			
			echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	case "editmenu":
		echo '<table>
			<tr>
			<td>
            <h3 align="center">Edit</h3></td>
			<tr><td>
			<li><a href="?p=edituser">Edit User</a></li>
			</td>
			<td>
			<li><a href="?p=editclient">Edit Client</a></li>
			</td>
			<td>
			<li><a href="?p=editorganization">Edit Organization</a></li>
			</td>
			</tr>
			<td>
			<li><a href="?p=editcommrecord">Edit Communication Record</a></li>
			</td><td>
			<li><a href="?p=editassociation">Edit Association</a></li>
			</td>
			<td>
			<li><a href="?p=editpartner">Edit Partner</a></li>
			</td><tr><td>
			<li><a href="?p=editsupplier">Edit Supplier</a></li>
			</td>
			<td>
			<li><a href="?p=editcustomer">Edit Customer</a></li>
			</td>
			</tr>
			</table>';
			
			echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	
	case "deletemenu":
		echo '<table>
			<tr>
			<td>
            <h3 align="center">Delete</h3></td>
			<tr><td>
			<li><a href="?p=deleteuser">Delete User</a></li>
			</td>
			<td>
			<li><a href="?p=deleteclient">Delete Client</a></li>
			</td>
			<td>
			<li><a href="?p=deleteorganization">Delete Organization</a></li>
			</td>
			</tr>
			<td>
			<li><a href="?p=deletecommrecord">Delete Communication Record</a></li>
			</td><td>
			<li><a href="?p=deleteassociation">Delete Association</a></li>
			</td>
			<td>
			<li><a href="?p=deletepartner">Delete Partner</a></li>
			</td><tr><td>
			<li><a href="?p=deletesupplier">Delete Supplier</a></li>
			</td>
			<td>
			<li><a href="?p=deletecustomer">Delete Customer</a></li>
			</td>
			</tr>
			</table>';
			
			echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	///////////////////VIEW///////////////////////
	case "viewusers":
		echo '<h3> Viewing Users</h3>';
		$Core->Database->setTable('users');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';

	break;
	
	case "viewclients":
		echo '<h3> Viewing Clients</h3>';
		$Core->Database->setTable('client');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
		
	break;
	
    case "vieworganizations":
		echo '<h3> Viewing Organizations</h3>';
		$Core->Database->setTable('organization');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "viewcommrecords":
		echo '<h3> Viewing Communication Records</h3>';
		$Core->Database->setTable('commrecord');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "viewassociations":
		echo '<h3> Viewing Associations</h3>';
		$Core->Database->setTable('association');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "viewpartners":
		echo '<h3> Viewing Partners</h3>';
		$Core->Database->setTable('partner');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "viewsuppliers":
		echo '<h3> Viewing Suppliers</h3>';
		$Core->Database->setTable('supplier');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "viewcustomers":
		echo '<h3> Viewing Customers</h3>';
		$Core->Database->setTable('customer');
		$fields = $Core->Database->getFieldsInfo();
		$datas = $Core->Database->selectRows();
		
		
		echo '<table><tr>';
		foreach($fields as $field) {
			echo '<th>'.ucfirst($field).'</th>';
			$row .= '<td>'.$data[$field].'</td>';    
		}
		echo "</tr>";
		foreach ($datas as $data) {
			echo '<tr>';
			foreach($data as $key => $d) {
				if (in_array($key, $fields))
					echo '<td>'.$d.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
		echo '<h3><a href="?p=viewmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	///////////////////////ADD/////////////////////
	case "adduser":
		echo '<h3> Add User</h3>';

		
		
		$Core->Database->setTable('users');
		$Form->openFieldset("Adding User");
        $Form->text("Username", "username", "");
		$Form->text("Name", "name", "");
		$Form->password("Password", "password", "");
		
		for($i=1; $i<11; $i++)
			$levels[$i] = "Level ".$i;
			
		$Form->select("Administrator Level", "admin_level", $levels);
		//$Form->ageSelector("Administrator level", "admin_level");
        $Form->closeFieldSet();
        $Form->submit("", "submit","Insert");
		echo $Form->Build();
		
		if (isset($_POST['submit'])) {
			
		  $ID = $Core->Database->insertRow($_POST);
		  
		  if ($ID > 0) {
			echo $Core->Utilities->drawNotice("Data inserted successfully", "success");
		  } else
			echo $Core->Utilities->drawNotice("Data not inserted successfully", "error");
		}
		
		echo '<h3><a href="?p=addmenu">Back</a></h3>';
		echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	case "addclient":
	echo '<h3> Add Client</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addorganization":
	echo '<h3> Add Organization</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addcommrecord":
	echo '<h3> Add Communication Record</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addassociation":
	echo '<h3> Add Association</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addpartner":
	echo '<h3> Add Partner</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addsupplier":
	echo '<h3> Add Supplier</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "addcustomer":
	echo '<h3> Add Customer</h3>';
	
	echo '<h3><a href="?p=addmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	/////////////DELETE///////////////////////
	case "deleteuser":
	echo '<h3> Delete User</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	case "deleteclient":
	echo '<h3> Delete Client</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deleteorganization":
	echo '<h3> Delete Organization</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deletecommrecord":
	echo '<h3> Delete Communication Record</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deleteassociation":
	echo '<h3> Delete Association</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deletepartner":
	echo '<h3> Delete Partner</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deletesupplier":
	echo '<h3> Delete Supplier</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "deletecustomer":
	echo '<h3> Delete Customer</h3>';
	
	echo '<h3><a href="?p=deletemenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	///////////////////EDIT///////////////////
	case "edituser":
	echo '<h3> Edit User</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
	case "editclient":
	echo '<h3> Edit Client</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editorganization":
	echo '<h3> Edit Organization</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editcommrecord":
	echo '<h3> Edit Communication Record</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editassociation":
	echo '<h3> Edit Association</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editpartner":
	echo '<h3> Edit Partner</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editsupplier":
	echo '<h3> Edit Supplier</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
	
    case "editcustomer":
	echo '<h3> Edit Customer</h3>';
	
	echo '<h3><a href="?p=editmenu">Back</a></h3>';
	echo '<h3><a href="?p=viewmainmenu">Home</a></h3>';
	break;
}
                    
                    
					
                    //This is here to display any errors that may arise from the Database class.
                    echo $Core->displayDBErrors();
                ?>
				</div >
            </div>
        </div>
        <div id="footer">
            
        </div>
    </div>
<? echo $Site->endDraw(); ?>