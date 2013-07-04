<?php

class API {

    private $action;
    private $params = array('tri' => 'last', 'type' => 'txt', 'nb' => '10', 'page' => 1);
    private static $tris = array('last', 'first', 'alea', 'top', 'flop', 'mtop', 'mflop');
    private static $types = array('txt', 'img');
    private static $actions = array('get');
    private static $max = 100;

    public function __construct($action, $params) {
        if (in_array($action, API::$actions))
            $this->action = $action;

        $all_params = explode(';', $params);
        foreach ($all_params as $param) {
            $datas = explode(':', $param);
            switch ($datas[0]) {
                case 'tri': $ref = API::$tris;
                    break;
                case 'type': $ref = API::$types;
                    break;
                case 'nb': $ref = API::$max;
                    break;
                case 'page': $ref = 999;
                    break;
            }

            if (isset($ref) && (
                    // gestion du max
                    ( is_numeric($ref) && is_numeric($datas[1]) && $datas[1] < $ref )
                    // gestion du tri et du type
                    || ( is_array($ref) && in_array($datas[1], $ref) )
                    )) {
                $this->params[$datas[0]] = $datas[1];
            }
        }
    }

    // fin constructeur

    private function loadFacts() {
        $poolfacts = new Facts($this->params['tri'], $this->params['page'], $this->params['type'], $this->params['nb'], true);

        $facts = $poolfacts->getFacts();

        return $facts;
    }

    public function getFacts() {
        $facts = $this->loadFacts();

        $url = 'http://' . SERVER_ROOT . '/';

        $out = array();
        foreach ($facts as $fact) {


            $data = array('fact' => $fact->fact,
                'date' => $fact->date,
                'vote' => $fact->votes,
                'points' => $fact->points
            );

            if ($this->params['type'] == 'img')
                $data['fact'] = $url . $data['fact'];

            $out[] = $data;
        }

        return json_encode($out);
    }

}
