

<?php

class Database {

	private $mysqli;
	private $table;
	private $host;
	private $username;
	private $database;
	private $password;
	private $super;
	
	public function Database(&$parent) {
		$this->table = null;
		$this->mysqli = null;
		$this->super = $parent;
		
		
	}
	
	public function setCredentials($host, $username, $password, $db) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->setDB($db);
		$this->mysqli = new mysqli($host, $username, $password, $db);	
	}
	
	public function setDB($db) {
		$this->database = $db;
	}
	
	/**
	 * Helper function to set the table, this will be used rather then asking
	 * in each parameter to provide a table.
	 * @param $var
	 */
	public function setTable($var) {
		$this->table = $var;
	}
	
	private function isTableSet() {
		if (is_null($this->table))
			return false;
		else
			return true;
	}
	
	private function isMysqliSet() {
		
		if (is_null($this->mysqli)) {
			$this->super->Error->record('mysqli Credentials not set', __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		return true;
		
	}
	
	/**
	 * Helper function important to make sure everything is set before you can
	 * call the public functions. 
	 */
	private function doChecks() {
		$exit = false; // Flag, it will allow us to exit if there is even one check that returns false, but get all the errors.
		
		if (!$this->isTableSet()) { 
			$this->super->Error->record("No table selected. ", __CLASS__, __LINE__, __FUNCTION__);	
		}
		
		if (!$this->isMysqliSet()) {
			$this->super->Error->record("Mysqli credentials missing or wrong. ", __CLASS__, __LINE__, __FUNCTION__);
		}
			
			
		
		
	}
	
/**
 * Helper function to return the field names in the table. Could be expanded further to include more
 * information but don't think there is more information that we need.
 * @param $table
 * @return array
 */
	public function getFieldsInfo() {
		$this->doChecks();
		if ($result = $this->mysqli->query("SELECT * FROM ".$this->table)) {
			$fields = $result->fetch_fields();
			foreach($fields as $field) {
				$info[] = $field->name;
			}
			return $info;
		}
		return false;
	}
	
	public function getFieldTypes() {
		$this->doChecks();
		if ($result = $this->mysqli->query("SELECT * FROM ".$this->table)) {
			$fields = $result->fetch_fields();
			foreach($fields as $field) {
				$info[] = $field->type;
			}
			return $info;
		}
		return false;
	}
	
	public function getFieldFlags() {
		$this->doChecks();
		if ($result = $this->mysqli->query("SELECT * FROM ".$this->table)) {
			$fields = $result->fetch_fields();
			foreach($fields as $field) {
				$info[] = $field->flags;
			}
			return $info;
		}
		return false;
	}
	
	/**
	 * Helper function to detect type of data for prepared statements.
	 * @param $data
	 * @return char
	 */
	private function checkDataType($data) {
		if (is_string($data))
			return 's'; //Is string
		else if (is_int($data))
			return 'i'; //is integer
		else if (is_double($data)) 
			return 'd'; //is double
		else
			return 'b'; //is blob, therefore it will be sent in packets
	}
	
	/**
	 * Function to insert items into a database table. $items needs to be an
	 * array and the key's to the item need to be the name of the field. Returns the
	 * ID when it is successful.
	 * @param $items
	 * @return bool
	 */
	public function insertRow($items) {
		
		$this->doChecks();
		
		
		$fields = $this->getFieldsInfo();
		
		if ($fields) {
			$query = "INSERT INTO ".$this->table." (";
			$query_suffix = " VALUES (";
			$bind_str = "";
			$bind_values = array();
		if (is_array($items)) {
			
			//Lets build the prepared string based on the array given
			foreach($items as $key=>&$item) {
				
				if (in_array($key, $fields)) {
					$query .= $key.",";
					$query_suffix .= " ? ,";
					$bind_str .= $this->checkDataType($item);
					
					//Need to reference the items for call_user_func_array later
					$bind_values[] = &$item;
				}
			}
			
			//Gotta take care of loose ends to make sure the query is built properly
			$query = substr($query,0,-1);
			$query_suffix = substr($query_suffix,0, -1);
			$query .= ')';
			$query_suffix .= ');';
			
			//Now we can use the string as a prepared statement
			
			if ($stmt = $this->mysqli->prepare($query.$query_suffix)) {
				$params = array_merge(array($bind_str), &$bind_values);
				call_user_func_array(array($stmt, 'bind_param'), $params);
				$stmt->execute();
				$ID = $stmt->insert_id;
				$stmt->close();
				return $ID;
			} else {
				$this->super->Error->record("Prepared Statment didn't work. ", __CLASS__, __LINE__, __FUNCTION__);
				return false;
			}
			
			return true;
		} else {
			$this->super->Error->record(" \$items isn't an array.", __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		} else {
			$this->super->Error->record(" Table: {$this->table} doesn't exist. ", __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		
	}
	
	/**
	 * Function will update an existing table row with the array of items, where table name
	 * and ID match.
	 * @param $ID
	 * @param $items
	 * @return bool
	 */
	public function updateRow($ID, $items) {
		
		
		$this->doChecks();
		
		$fields = $this->getFieldsInfo();
		
		if (is_array($fields)) {
			
			$query = "UPDATE ".$this->table." SET ";
			$bind_str = "";
			$bind_values = array();
			
			if (is_array($items)) {
			foreach($items as $key=>&$item) {
				
				if (in_array($key, $fields)) {
					$query .= $key."=?,";
					$bind_str .= $this->checkDataType($item);
					
					//Need to reference the items for call_user_func_array later
					$bind_values[] = &$item;
				}	
				
			}
			
			//Remove last comma and add the where clause
			$query = substr($query, 0,-1);
			$query .= " WHERE ID = $ID ";
			
			if ($stmt=$this->mysqli->prepare($query)) {
				$params = array_merge(array($bind_str), &$bind_values);
				call_user_func_array(array($stmt, 'bind_param'), $params);
				$stmt->execute();
				$stmt->close();
				return true;
			} else {
				$this->super->Error->record("Prepared Statment didn't work. ", __CLASS__, __LINE__, __FUNCTION__);
				return false;
			}
			
			
			} else {
				$this->super->Error->record(" \$items isn't an array.", __CLASS__, __LINE__, __FUNCTION__);
				return false;
			}
			
			
		} else {
			$this->super->Error->record(" Table: {$this->table} doesn't exist. ", __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		
	}
	
	
	/**
	 * Lazy delete row, just returns true or false depending if the delete was successful
	 * @param $ID
	 * @return bool
	 */
	public function deleteRow($ID) {
		$this->doChecks();
		return $this->mysqli->query("DELETE FROM ".$this->table." WHERE ID = $ID");
	}
	
	/**
	 * Select a single row from the database, knowing the ID of the row will give direct access.
	 * @param $ID
	 * @return bool
	 */
	public function selectRow($ID) {
		$this->doChecks();
		$query = "SELECT * FROM ".$this->table." WHERE ID = $ID";
		if ($result = $this->mysqli->query($query)) {
			return $result->fetch_assoc();
		} else {
			$this->super->Error->record(" Query has errors in it:  $query ", __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		
	}
	
	/**
	 * Select multiple rows from a table in the database. The paramter condtions should be
	 * two dimensional. I.e. $conditions['field name']['logical operator'] = 2nd operand.
	 * I hope this function can be followed, I had to do some pretty wonky stuff to get
	 * this function to work like I wanted. So, as a result it will return an array like this:
	 *
	 * array(2) {
		[0]=>
		array(3) {
		["ID"]=>
		int(1)
		["name"]=>
		string(4) "Chad"
		["dob"]=>
		string(9) "yesterday"
		}
		[1]=>
		array(3) {
		["ID"]=>
		int(2)
		["name"]=>
		string(4) "Chad"
		["dob"]=>
		string(5) "today"
		}
	}
	 * That is given that you have a database with three Rows, ID, name, and dob.
	 * default $conditions is an empty array, this will return everything in the table.
	 */
	public function selectRows($conditions = array(), $glue = 'AND', $order = "ORDER BY ID") {
		
		$this->doChecks();
		
		$fields = $this->getFieldsInfo();
		
		if (is_array($fields)) {
			
			$query = "SELECT ";
			$result_params = array();
			$bind_str = "";
			$fields_static = $fields; //This is needed to store a copy of fields
			
			//specificly specify the fields to retreive. Will reference field changing the address location.
			//This is used for the result fetcher after the query has been made.
			//$fields_static is used to store the field names to return as an associative array.
			
			foreach ($fields as &$field) {
				$query .= "$field, ";
				$result_params[] = &$field;
			}
			
			//Remove the last two characters from the query string.
			$query = substr($query, 0, -2);
			
			//Append more query, to just after the WHERE keyword
			$query .= " FROM {$this->table} WHERE ";
			$bind_str .= '';
			$bind_values = array();
			
			//Make sure $conditions parameter is an array.
			//Should probably make this check for a 2D array.
			if (is_array($conditions)) {
				
				//Loop Through
				foreach ($conditions as $key=>$rest) {
					
					//Make sure the key in the first dimension of the array is in the fields.
					//NOTE: Changed from $fields to $fields_static to ensure the values don't change
					if (in_array($key, $fields_static)) {
						
						//Then dig into the second dimension of the array
						foreach($rest as $cond => &$val) {
							
							//Lets start appending to the query string using a parameterized string
							$query .= " $key  $cond ? $glue ";
							
							//Create bind string, used in bind_param function later
							$bind_str .= $this->checkDataType($val);
							
							//These are the values that will be bound to the question marks later on. in the query string
							$bind_values[] = &$val;
							
						}
						
						
					}
					
				}
				
				if (count($bind_values) > 0) {
				//Remove the additional $glue from the query string
					$query = substr($query, 0, -(strlen($glue)+1));
				} else {
					$query = substr($query, 0, -6);
				}
			$query .= $order;
			
			//Send the prepared statment
			if ($stmt=$this->mysqli->prepare($query)) {
				
				//Use call_user_func_array rather then $stmt->bind_param('s', $val);
				//Because we have a variable number of parameters.
				if (count($bind_values) > 0) {				
				$params = array_merge(array($bind_str), &$bind_values);
				call_user_func_array(array($stmt, 'bind_param'), $params);
				}
				//Execute the statement
				$stmt->execute();
				
				//Call bind result, the same way as bind_param
				call_user_func_array(array($stmt, 'bind_result'), &$result_params);
				
				$count = 0; //To keep the index unique on the return array.
				//Loop through the results, fetch them if you will
				while($r = $stmt->fetch()) {
					
					//Loop through the result_params, this is where bind_result returns the values found in the Database
					foreach ($result_params as $key => $result) {
						//Assign it to a Human readable Array.
						$results[$count][$fields_static[$key]] = $result;
					}
							    
					$count ++;
					
				}
				
				return $results;
			} else {
				
				$this->super->Error->record("Prepared Statement didn't work. {$this->mysqli->error} ", __CLASS__, __LINE__, __FUNCTION__);
				return false;
			}
				
			} else {
				
				$this->super->Error->record(" \$items isn't an array.", __CLASS__, __LINE__, __FUNCTION__);
				return false;
			}
			
			
		} else {
			$this->super->Error->record(" Table: {$this->table} doesn't exist. ", __CLASS__, __LINE__, __FUNCTION__);
			return false;
		}
		
	}
	
}

?>