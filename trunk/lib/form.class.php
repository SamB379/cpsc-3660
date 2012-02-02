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