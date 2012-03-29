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

	/**
	 Simple Function to draw a table. 
	@param $fields, are the headings
	@param $rows will insert the data into each row. Must be multi-dimensional and have the same number of fields in the second dimension as the fields array.
	*/
	public function drawTable($fields, $rows) {
		
		$oData .='<table><tr>';
			foreach($fields as $field) {
				$oData .= '<th>'.ucfirst($field).'</th>';
			}
			$oData .= "</tr>";
			if (is_array($rows)) {
			foreach ($rows as $data) {
				$oData .= '<tr>';
				foreach($data as $key => $d) {
					if (in_array($key, $fields))
						$oData .= '<td>'.$d.'</td>';
				}
				$oData .= '</tr>';
			}
			}
			$oData .= '</table>';
		
	return $oData;
	}
	
	public function generateForm($table) {
		$Form = new Form();
		$this->super->Database->setTable($table);
		$fields = $this->super->Database->getFieldsInfo();
		$types = $this->super->Database->getFieldTypes();
		$flags = $this->super->Database->getFieldFlags();
		foreach($fields as $key=>$field ) {
			if (! ($flags[$key] & 512)) {
			switch($types[$key]) {
				case 3: case 253: $Form->text($field, $field, ""); break;
			}
			}
		}
		$Form->submit("","Submit","Submit");
		return $Form;
	}

}


?>