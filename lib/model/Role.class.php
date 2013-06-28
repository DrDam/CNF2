<?php

class Role extends Base {

    static $primary = 'id';
    static $structure = array(
        'id' => array('type' => 'int', 'length' => 5),
        'label' => array('type' => 'text'),
    );
    public $id;
    public $label;

    public function save() {
        
    }

    public function __toString() {
        return $this->label;
    }

}
