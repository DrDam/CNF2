<?php

class Variables extends Base {

    static $primary = array('label');
    static $structure = array('label' => array('type' => 'varchar', 'length' => 250),
        'value' => array('type' => 'varchar', 'length' => 250),
    );
    public $label;
    public $value;

    static function getArrayVar($table, $champ, $cond = null) {
        $base = new Base();
        $array = $base->getArray($table, $champ, $cond);
        return $array;
    }

    static function get_var($label) {
        $param = new Variables();
        $result = $param->findOneBy('label', $label);

        return (is_object($result)) ? $result->value : null;
    }

    static function set_var($label, $value) {
        $variable = new Variables();
        $variable->set(array('label' => $label, 'value' => $value));
        $variable->save();
    }

}
