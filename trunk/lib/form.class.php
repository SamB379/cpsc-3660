<?php

class Form {

    private $action;
    private $method;
    private $items;
    private $fieldsetOpen;
    
    public function Form($action = "", $method = "POST") {
        $this->action = $action;
        $this->method = $method;
    }

    public function text($label, $name, $value) {
        $this->makeFieldRow($label, $name, $value, "text");        
    }
	
	public function select($label, $name, $values, $selected = null) {
		$this->makeFieldRow($label, $name, $values, "select", $selected);
	}
	
	public function password($label, $name, $value) {
		$this->makeFieldRow($label, $name, $value, "password");
	}
	
	public function checkbox($label, $name, $value) {
		$this->makeFieldRow($label, $name, $value, "checkbox");
	}
	public function radiobutton($label, $name, $value) {
		$this->makeFieldRow($label, $name, $value, "radio");
	}
	
	private function buildOptions($values, $selected = null) {
		if (is_array($values)) {
			
			foreach ($values as $key=>$value) {
				if (is_null($selected))
					$options .=	$this->option($key, $value);
				else {
					$options .= $this->option($key, $value, $selected);
				}
			}
		}
		
		return $options;
	}
	
	private function option($value, $label, $selected = null) {
		return '<option value="'.$value.'" '.(!is_null($selected)?'selected="selected"':'').'>'.$label.'</option>';
	}
	
    
    public function submit($label, $name, $value) {
        $this->makeFieldRow($label, $name, $value, "submit");
        
    }
    
    private function makeFieldRow($label, $name, $value, $type, $selected = null) {
     $data .= '<div><label for="'.$name.'">'.$label.'</label>'; 
	
	if ($type == "select") {
		if (is_array($value)) {
			$data .= $this->makeSelectField($name, $value, $selected);
		}
	}
	else {
		$data .= $this->makeInputField($name, $value, $type);
		} 
	
	$data .= '</div>';
	$this->add($data);

  
    }
    
	private function makeInputField($name, $value, $type) {
		return '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" />';
	}
	
	private function makeSelectField($name, $values, $selected) {
		return '<select name="'.$name.'">'.$this->buildOptions($values, $selected).'</select>';
	}

public function openFieldset($legend = null) {

    if ($this->fieldsetOpen)
        $this->Add('</fieldset>');
    
    $this->Add('<fieldset>');

    $this->fieldsetOpen = true;
    
        if (!is_null($legend))
            $this->Add('<legend>'.$legend.'</legend>');
    
}

public function closeFieldSet() {
    $this->Add('</fieldset>');
}
    
    public function Build() {
            $oData = '<form action="'.$this->action.'" method="'.$this->method.'">';
            
            if ($this->fieldsetOpen)
                $this->Add('</fieldset>');
            
            foreach ($this->items as $item)
                $oData .= $item; 
            $oData .= '</div>';
            
            return $oData;
    }

    public function Add($data) {
        $this->items[] = $data;
    }
    

}

?>