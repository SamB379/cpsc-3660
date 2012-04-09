<?

class Input {
	
	private $type;
	private $name;
	private $options;
	private $attributes;
	private $selected;
	private $value;

	
	public function Input($type, $name) {
		$this->type = $type;
		$this->name = $name;
		$this->selected = null;
		
		//lets set required for every input field. 
		$this->attributes["class"] = "required";
		$this->attributes["title"] = "";
	}
	

	
	public function _get($var) {
		
		if (key_exists($var, get_class_vars(__CLASS__))) {
			return $this->$var;
		}
		
	}
	
	public function _set($var, $value) {
	
		
		if (key_exists($var, get_class_vars(__CLASS__))) {
			if ($var == "attributes") {
					
					if ($value != NULL) {
					//check to see if it exists in the array 
					foreach($value as $key=>$val) {
						if(array_key_exists($key, $this->attributes)) {
							$this->attributes[$key] .= " ".$val;
							unset($this->$value[$key]);
						}
					}
					
					$this->attributes = array_merge($value, $this->attributes);
					}
				}
			else			
				$this->$var = $value;
		}
		
	}


	public function addOption($label, $value) {
		$this->options[$value] = $label;
	}
	public function addAttribute($attribute, $value){
		$this->attributes[$attribute] = $value;
	}
	
	public function build() {
		$data ="";
		switch($this->type) {
			case "textarea":
				$data = '<textarea name="'.$this->name.'">'.$this->value.'</textarea>';
			break;
			case "select":
				$data = '<select name="'.$this->name.'"'.$this->buildAttributes().'>'.$this->buildOptions().'</select>';
			break;
			default:
				
				$data .= '<input name="'.$this->name.'" type="'.$this->type.'" value="'.$this->value.'" '.$this->buildAttributes().' />';
			break;
		}
		return $data;
	}
	
	private function buildAttributes() {
		$data = "";
		if (is_array($this->attributes)) {
			foreach($this->attributes as $key=>$arr) {
				$data .= $key.'="'.$arr.'"';
			}
		}
		return $data;
	}
	
	private function buildOptions() {
		if (is_array($this->options)) {
			
			foreach ($this->options as $key=>$value) 
			{
				if (!is_null($this->selected) && $key == $this->selected)
					$options .=	$this->option($key, $value, $this->selected);
				else {
					$options .= $this->option($key, $value);
				}
			}
		}
		
		return $options;
	}
	
	private function option($value, $label, $selected = null) {
		return '<option value="'.$value.'" '.(!is_null($selected)?'selected="selected"':'').'>'.$label.'</option>';
	}
}


?>