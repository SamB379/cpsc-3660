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

    public function text($label, $name, $value, $attributes = null) {
        $this->makeFieldRow($label, $name, $value, "text", null, $attributes);        
    }
	
	public function select($label, $name, $values, $selected = null, $attributes = null) {
		$this->makeFieldRow($label, $name, $values, "select", $selected, $attributes);
	}
	
	public function password($label, $name, $value, $attributes = null) {
		$this->makeFieldRow($label, $name, $value, "password", null, $attributes);
	}
	
	public function checkbox($label, $name, $value, $attributes = null) {
		$this->makeFieldRow($label, $name, $value, "checkbox", null, $attributes);
	}
	public function radiobutton($label, $name, $value, $attributes = null) {
		$this->makeFieldRow($label, $name, $value, "radio", null, $attributes);
	}
	public function textarea($label, $name, $value, $attributes = null) {
		$this->makeFieldRow($label, $name, $value, "textarea", null, $attributes);
	}
	public function date($label, $name, $value, $attributes = null) {
			$this->makeFieldRow($label, $name, $value, "text", null, $attributes, '<img src="./images/calendar.png" class="datepicker_icon" />');
		}
	
	private function buildOptions($values, $selected = null) {
		if (is_array($values)) {
			
			foreach ($values as $key=>$value) 
			{
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
    
    private function makeFieldRow($label, $name, $value, $type, $selected = null, $attributes = null, $extra = null) {
     $data .= '<div><label for="'.$name.'">'.$label.'</label>'; 
	
	if ($type == "select") {
		if (is_array($value)) {
			$data .= $this->makeSelectField($name, $value, $selected, $attributes);
		}
	} else if ($type == "textarea") {
			$data .= $this->makeTextArea($name, $value, $attributes);
	}
	else {
		$data .= $this->makeInputField($name, $value, $type, $attributes);
		} 
	$data .= $extra;
	$data .= '</div>';
	$this->add($data);

  
    }
    private function makeTextArea($name, $value, $attributes) {
		return '<textarea name="'.$name.'" '.$this->buildAttributes($attributes).'>'.$value.'</textarea>';
	}
	private function makeInputField($name, $value, $type, $attributes) {
		return '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" '.$this->buildAttributes($attributes).' />';
	}
	
	private function makeSelectField($name, $values, $selected, $attributes) {
		return '<select name="'.$name.'" '.$this->buildAttributes($attributes).'>'.$this->buildOptions($values, $selected).'</select>';
	}
	
	private function buildAttributes($array) {
		$data = "";
		if (is_array($array)) {
			foreach($array as $key=>$arr) {
				$data .= $key.'="'.$arr.'"';
			}
		}
		return $data;
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