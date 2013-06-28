<?php

class User extends Base {

    static $primary = 'id';
    static $structure = array(
        'id' => array('type' => 'serial'),
        'pseudo' => array('type' => 'varchar', 'length' => 255),
        'password' => array('type' => 'varchar', 'length' => 255),
        'mail' => array('type' => 'varchar', 'length' => 255),
        'role' => array('type' => 'int', 'length' => 11),
    );
    public $id;
    public $pseudo;
    public $password;
    public $mail;
    public $role;

    public function save() {
        if (isset($this->error))
            unset($this->error);

        parent::save();
    }

    public function load() {
        parent::load();

        //get roles 
        $objRole = new Role();
        $objRole->id = $this->role;
        $objRole->load();
        $this->role = $objRole;
    }

    public function delete() {
        $hesit = new Hesit();
        $hesit->user_id = $this->id;
        $hesit->delete();

        unset($this->role);
        parent::delete();
    }

}
