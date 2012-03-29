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
	
	public function ageSelector($label,$name) {
        $this->add ('<div><label for="'.$name.'">'.$label.'</label>
				<select name="'.$name.'">
				<option value="Milk">13</option>
				<option value="Cheese">14</option>
				<option value="Bread">15</option>
				<option value="Bread">16</option>
				<option value="Bread">17</option>
				<option value="Bread">18</option>
				<option value="Bread">19</option>
				<option value="Bread">20</option>
				<option value="Bread">21</option>
				<option value="Bread">22</option>
				<option value="Bread">23</option>
				<option value="Bread">24</option>
				<option value="Bread">25</option>
				<option value="Bread">26</option>
				<option value="Bread">27</option>
				<option value="Bread">28</option>
				<option value="Bread">29</option>
				<option value="Bread">30</option>
				<option value="Bread">31</option>
				<option value="Bread">32</option>
				<option value="Bread">33</option>
				<option value="Bread">34</option>
				<option value="Bread">35</option>
				<option value="Bread">36</option>
				<option value="Bread">37</option>
				<option value="Bread">38</option>
				<option value="Bread">39</option>
				<option value="Bread">40</option>
				<option value="Bread">41</option>
				<option value="Bread">42</option>
				<option value="Bread">43</option>
				<option value="Bread">44</option>
				<option value="Bread">45</option>
				<option value="Bread">46</option>
				<option value="Bread">47</option>
				<option value="Bread">48</option>
				<option value="Bread">49</option>
				<option value="Bread">50</option>
				</select>');
    }
    
    public function submit($label, $name, $value) {
        $this->makeFieldRow($label, $name, $value, "submit");
        
    }
    
    private function makeFieldRow($label, $name, $value, $type) {
     $this->Add('<div><label for="'.$name.'">'.$label.'</label>
        <input type="'.$type.'" name="'.$name.'" value="'.$value.'" /></div>');  
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