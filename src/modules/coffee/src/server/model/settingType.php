<?php

class Setting extends SettingType {
    
    
}

class SettingType extends DBObject {
   
    static $settings_type_checkbox = "settingType.checkbox";
    static $settings_type_text = "settingType.text";
    static $settings_type_textarea = "settingType.textarea";
    static $settings_type_date = "settingType.date";
    static $settings_type_time = "settingType.time";
    static $settings_type_dropdown = "settingType.dropdown";
    
    public $options; 
    public $value; 
    public $label; 
    public $name; 
    public $type; 
    
    function __constructor ($type, $name, $label, $value, $options) {
        
        parent::__constructor(array(
            array(
                "name" => "name",
                "label" => "Name",
                "type" => "varchar",
                "length" => 200,
                "null" => false
            )
        ));
        
        $options = $options;
        $value = $value;
        $label = $label;
        $name = $name;
    }
    
    function html () {
        
        switch ($this->type) {
            case settings_type_checkbox:
                return '<input type="checkbox" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_text:
                return '<input type="text" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_textarea:
                return '<textarea name="'.$this->name.'">'.htmlentities($this->value).'</textarea>';
            case settings_type_date:
                return '<input type="date" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_time:
                return '<input type="time" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_dropdown:
                $options = array();
                foreach ($this->options as $option => $value) {
                    $options []= '<option value="'.$value.'">'.$option.'</option>';
                }
                return '<select name="'.$this->name.'">'.$options.'</select>';
        }
    }
    
    function postValue () {
        
        $this->value = Request::post($this->name);
    }
    
}

?>