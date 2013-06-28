<?php

class Hesit extends Base {

    static $primary = array('fact_id', 'user_id');
    static $structure = array(
        'fact_id' => array('type' => 'int',
        'length' => 11),
        'user_id' => array('type' => 'int',
        'length' => 11)
    );
    public $fact_id;
    public $user_id;

    public function save() {
        global $user;
        $this->user_id = $user->id;
        parent::save();
    }

}
