<?php

class Facts {

    protected $facts = array();
    protected $table;
    protected $page;
    protected $pager;

    public function __construct($args = null, $page = 1, $type = 'txt', $nb = null) {
        $datas = Facts::getObject(true, $type);

        $object = $datas['obj'];
        $pager = $datas['pager'];

        $this->table = $datas['table'];
        $this->page = $page;
        $this->pager = ($nb == null ) ? $pager : $nb ;

        $tri = $this->getTri($args);

        $limits = $this->getLimits($page, $this->pager);

        $this->facts = $object->getFacts($tri, $limits);
    }

    public function getFacts() {
        return $this->facts;
    }

    private function getTri($args = null) {

        switch ($args) {
            case 'top':
                $output = 'points DESC';
                break;

            case 'flop':
                $output = 'points ASC';
                break;

            case 'mflop':
                $output = 'moyenne ASC';
                break;

            case 'mtop':
                $output = 'moyenne DESC';
                break;

            case 'alea':
                $output = 'RAND()';
                break;

            case 'first':
                $output = 'id ASC';
                break;
            
            case 'last':
            default :
                $output = 'id DESC';
                break;
        }

        return $output;
    }

    protected function getLimits($page = 1, $pager = 30) {   //LIMITS  debut, nb ligne
        $str = ($page - 1) * $pager . ',' . $pager;
        return $str;
    }

    static function getObject($getpager = false, $type = NULL) {
        $choice = ($type != null) ? $type : arg(0);
        switch ($choice) {
            case 'img':
                $table = 'Images';
                $object = new Images();
                $pager = 10;
                break;

            case 'txt':
            default :
                $table = 'Fact';
                $object = new Fact();
                $pager = 30;
                break;
        }

//		var_dump($object);

        return ($getpager === false) ? $object : array('obj' => $object, 'pager' => $pager, 'table' => $table);
    }

    static function aModerer($type = 'txt', $valider = false) {
        $data = Facts::getObject(true, $type);
        $facts = $data['obj']->getToModeration('0,' . $data['pager'], $valider);
        return $facts;
    }

    static function getBerk($type = 'txt') {
        $obj = Facts::getObject(false, $type);
        $facts = $obj->getFacts('berk desc', '0,10',1,'AND berk > votes/3');

        foreach ($facts as $key => $fact) {
            if ($fact->berk < 1)
                unset($facts[$key]);
        }

        return $facts;
    }

    static function enAttente($type) {
        $obj = Facts::getObject(false, $type);
        return $obj->enAttente();
    }

    static function nbBerk($type) {
        $obj = Facts::getObject(false, $type);
        return $obj->nbBerk();
    }

    public function getNbPage() {
        $bdd = new Base();

        $req = 'select count(*) as tot from ' . $this->table . ' where statut = 1';

        $result = $bdd->query($req);

        $out = $result->fetchAll(PDO::FETCH_ASSOC);

        return floor($out[0]['tot'] / $this->pager) + 1;
    }

    public function getPagination() {
        $page = $this->page;

        $nbPage = $this->getNbPage();

        $links = array();

        if ($page > 1) {
            $links[] = array('<', $page - 1);
            $links[] = array(1, 1);
        }
        if ($page > 5) {
            $links[] = array('...');
        }

        if ($page > 120) {
            $pageCible = (floor($page / 100) - 1) * 100;
            $links[] = array($pageCible, $pageCible);
            $links[] = array('...');
        }

        if ($page > 15) {
            $pageCible = (floor($page / 10) - 1) * 10;
            if ($pageCible >= 10) {
                $links[] = array($pageCible, $pageCible);
                $links[] = array('...');
            }
        }

        if ($page > 4)
            $links[] = array($page - 3, $page - 3);
        if ($page > 3)
            $links[] = array($page - 2, $page - 2);
        if ($page > 2)
            $links[] = array($page - 1, $page - 1);

        $links[] = array($page);

        if ($nbPage - $page > 1)
            $links[] = array($page + 1, $page + 1);
        if ($nbPage - $page > 2)
            $links[] = array($page + 2, $page + 2);
        if ($nbPage - $page > 3)
            $links[] = array($page + 3, $page + 3);


        if ($nbPage - $page > 15) {
            $links[] = array('...');
            $pageCible = (floor($page / 10) + 1) * 10;
            $links[] = array($pageCible, $pageCible);
        }

        if ($nbPage - $page > 120) {
            $links[] = array('...');
            $pageCible = (floor($page / 100) + 1) * 100;
            $links[] = array($pageCible, $pageCible);
        }

        if ($nbPage - $page > 4) {
            $links[] = array('...');
        }

        if ($page < $nbPage) {
            $links[] = array($nbPage, $nbPage);
            $links[] = array('>', $page + 1);
        }

        return $links;
    }

}
