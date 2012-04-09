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

	public function rmUnderscore($str) {
		
		return str_ireplace('_', ' ', $str);
		
	}

	/**
	 Simple Function to draw a table. 
	@param $fields, are the headings
	@param $rows will insert the data into each row. Must be multi-dimensional and have the same number of fields in the second dimension as the fields array.
	*/
	public function drawTable($fields, $rows) {
		
		$oData .='<table><tr>';
			foreach($fields as $field) {
				$oData .= '<th class="view_heading">'.$this->rmUnderscore($field).'</th>';
			}
			$oData .= '<th></th>';
			$oData .= '<th></th>';
			$oData .= "</tr>";
			if (is_array($rows)) {
			foreach ($rows as $data) {
				$oData .= '<tr>';
				foreach($data as $key => $d) {
					if (in_array($key, $fields)) {
						if (strtolower($key) == "id")
							$ID = $d;	
							
						$forign_keys = array("orgid"=>"organization", "userid"=>"users", "clientid"=>"client", "supplierid"=>"supplier", "partnerid"=>"partner", "customerid"=>"customer");
						if (array_key_exists(strtolower($key), $forign_keys)) {
							
							$this->super->Database->setTable($forign_keys[strtolower($key)]);
							$row = $this->super->Database->selectRow($d);
							
							$oData .= '<td>'.$row['name'].'</td>';
						}
						else 
							$oData .= '<td>'.$this->rmUnderscore($d).'</td>';
					}
				}
				$oData .= '<td><a href="?action=edit&table='.$_GET['table'].'&ID='.$ID.'">Edit</a></td>';
				$oData .= '<td><a href="?action=delete&table='.$_GET['table'].'&ID='.$ID.'">Delete</a></td>';
				$oData .= '</tr>';
			}
			}
			$oData .= '</table>';
		
	return $oData;
	}
	
	public function generateForm($table, $custom_fields = null, $selectID= null) {
		$Form = new Form();
		$this->super->Database->setTable($table);
		$fields = $this->super->Database->getFieldsInfo();
		$types = $this->super->Database->getFieldTypes();
		$flags = $this->super->Database->getFieldFlags();
		
		if (!is_null($selectID))
			$selection = $this->super->Database->selectRow($selectID);
		
		if (isset($_POST['Submit'])) {
			if (!is_null($selectID))
			$update = $this->super->Database->updateRow($selectID, $_POST);
			else
			$ID = $this->super->Database->insertRow($_POST);
			
			 if ($ID > 0 || $update) 
				echo $this->drawNotice("Data ".(!is_null($selectID)?"updated":"inserted")." successfully", "success");
			 else {
				echo $this->drawNotice("Data not ".(!is_null($selectID)?"updated":"inserted")." successfully", "error");
			 	echo $this->super->DisplayDBErrors();
			 }
					
		}
			
			if (!is_null($selectID))
			$selection = $this->super->Database->selectRow($selectID);
		
		foreach($fields as $key=>$field ) {
			$custom_flag = false;
			if (! ($flags[$key] & 512)) { //Only display forms fields without the auto increment flag set
			
			if (is_array($custom_fields)) {
				foreach($custom_fields as $Input) {
					
					if ($Input->_get("name") == $field) {
						$Input->_set("value", $selection[$field]);
						$Input->_set("selected", $selection[$field]);
						$Form->custom($this->rmUnderscore($field), $Input);
						$custom_flag = true;
					}
					
					
				}
				
				
			} 
			
			if (!$custom_flag) {
			switch($types[$key]) {
				 case 253: case 254: $Form->text($this->rmUnderscore($field), $field, $selection[$field]); break;
				case 252: $Form->textarea($this->rmUnderscore($field), $field, $selection[$field]); break;
				case 10: $Form->date($this->rmUnderscore($field), $field, (!is_null($selectID)?$selection[$field]:date("Y-m-d")), array("class"=>"datepicker")); break;
				case 246: case 3: $Form->text($this->rmUnderscore($field), $field, $selection[$field], array("class"=>"numeric")); break;
			}
			}
			}
		}
		$Form->submit("","Submit","Submit");
		return $Form;
	}

}


?>