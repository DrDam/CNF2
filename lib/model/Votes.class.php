<?php

class Votes extends Base {

    static $primary = 'ip';
    static $structure = array(
        'ip' => array('type' => 'varchar', 'length' => 255),
        'votes' => array('type' => 'text'),
    );
    public $ip;
    public $votes;

    public function save() {
        $this->votes = json_encode($this->datas);
        unset($this->datas);
        //  var_dump($this->votes);
        parent::save();
    }

    public function load() {
        parent::load();
        if (isset($this->error))
            unset($this->error);
        $this->datas = json_decode($this->votes);
    }

    public function addCookie() {
        $data = (isset($this->datas)) ? $this->datas : json_decode($this->votes);
        $expire = time() + 365 * 24 * 3600;
        setcookie('votes', json_encode($data), $expire);
    }

}
