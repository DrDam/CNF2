<?php

class Images extends Fact {

    static function get_structure($class) {
        $structure = Base::get_structure('Fact');

        $structure['pseudo'] = array('type' => 'varchar', 'length' => 255);
        $structure['blog'] = array('type' => 'varchar', 'length' => 255);
        $structure['mail'] = array('type' => 'varchar', 'length' => 255);
        $structure['ip'] = array('type' => 'varchar', 'length' => 255);

        return $structure;
    }

    public $pseudo;
    public $blog;
    public $mail;
    public $ip;

    // fournis par la class mere
    /*
      static $primary  = array('id');
      public $id;
      public $fact; // uri de l'image
      public $date;
      public $statut;
      public $points;
      public $votes;
      public $moyenne;
     */


    public function delete() {
        unlink('../' . $this->fact);
        parent::delete();
    }

}
