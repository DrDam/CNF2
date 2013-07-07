<?php

class Fact extends Base {

    static $primary = 'id';
    static $structure = array(
        'id' => array('type' => 'serial'),
        'fact' => array('type' => 'text'),
        'points' => array('type' => 'int', 'length' => 11),
        'votes' => array('type' => 'int', 'length' => 11),
        'moyenne' => array('type' => 'float', 'length' => 11),
        'statut' => array('type' => 'int', 'length' => 11),
        'date' => array('type' => 'int', 'length' => 11),
        'berk' => array('type' => 'int', 'length' => 11),
    );
    public $id;
    public $fact;
    public $points = 0;
    public $votes = 0;
    public $moyenne = 0;
    public $statut = 0;
    public $date;
    public $berk;

    public function getFacts($tri, $limits = '0 30', $statut = 1, $addwhere = '') {
        $req = 'select * from ' . $this->getTable() . ' where statut = ' . $statut . ' ' . $addwhere . ' order by ' . $tri . ' LIMIT ' . $limits;

        //var_dump($req);

        $collection = $this->getCollection($req, $this->getTable());

        return $collection;
    }

    public function getToModeration($limits, $valider = false) {
        if ($valider == true) {
            $statut = 'statut = 2';
            $order = 'date desc';
        } else {
            $statut = 'statut in (0,2)';
            $order = 'RAND()';
        }
        $req = 'select * from ' . $this->getTable() . ' where ' . $statut . ' order by '.$order.' LIMIT ' . $limits;

        //	var_dump($req);

        $collection = $this->getCollection($req, $this->getTable());

        return $collection;
    }

    public function setFact($post) {
        $fact = trim($post['facts']);
        $fact = htmlentities($fact, ENT_QUOTES);
        $this->fact = nl2br($fact);
        $this->date = time();
        $this->statut = 0;
        $this->save();
        Helpers::ok('Ca roule ma poule');
    }

    public function enAttente() {
        $req = 'select COUNT(id) from ' . $this->getTable() . ' where statut = 2';

        $result = $this->query($req);

        $data = $result->fetch();

        return (isset($data[0]) && $data[0] != null) ? $data[0] : 0;
    }

    public function nbBerk() {
        $req = 'select COUNT(id) from ' . $this->getTable() . ' where berk > votes';

        $result = $this->query($req);

        $data = $result->fetch();

        return (isset($data[0]) && $data[0] != null) ? $data[0] : 0;
    }

    public function delete() {
        $this->clean();
        $this->fact = '';
        parent::delete();
    }

    public function clean() {
        $hesit = new Hesit();
        $hesit->fact_id = $this->id;
        $hesit->delete();
    }

    public function save($pass = false) {
        $deleted = false;
        if (isset($this->names)) {
            unset($this->names);
        }

        if($pass == false)
        {
        // au dela de 30votes pour une fact non validée
        if ($this->votes > 30 && $this->statut != 1) {
            // si plus de la moitié des votes sont des berk 
            // ou que le moyenne est inférieure à 1/4 
            // ( avant modération => 1 oui pour 3 non) 
            // on supprime la fact
            if ($this->statut == 0 && $this->moyenne < 0.25) {
                $this->delete();
                $deleted = true;
                $this->statut = 0;
            }

            // si la moyenne est supérieur à 2/3
            // ( 2 oui pour 1 non)
            // on envoi la fact à la validation
            if ($this->moyenne > 0.66 && $this->statut == 0) {
                $this->statut = 2;
            }

            // si on a dépassé les 50 votes avec une moyenne toujours supérieur à
            // 2/3 .. alors la fact est auto-validé
            if ($this->votes > 50 && $this->moyenne > 0.66 && $this->statut = !1) {
                $this->statut = 1;
                $this->clean();
            }
        }

        if ($this->statut == 1 && $this->berk > $this->points && $this->date != '0') {
            $this->delete();
            $deleted = true;
        }
        }
        if ($deleted == false && $this->fact != '') {
            $this->date = time();
            parent::save();
        }
    }

    public function getNames() {
        $names = new Hesit();
        $names->fact_id = $this->id;

        $datas = $names->find();

        if ($datas == null) {
            return false;
        }

        $this->names = array();

        foreach ($datas as $obj) {
            $user = new User();
            $user->id = $obj->user_id;
            $user->load();
            $this->names[] = $user->pseudo;
        }

        return true;
    }

    public function printNames() {
        if (isset($this->names)) {
            return implode(', ', $this->names);
        }
    }

    public function search($str) {
        $req = 'select * from ' . $this->getTable() . ' where fact LIKE "' . $str . '" AND statut = 1 order by points LIMIT 0,10;';

        $all = $this->getCollection($req, $this->getTable());

        return $all;
    }

}
