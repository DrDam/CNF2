<?php

class Doublons extends Base {

    static $primary = 'id';
    static $structure = array(
        'id' => array('type' => 'int', 'length' => 11),
        'cut' => array('type' => 'text'),
    );
    public $id;
    public $cut;

    public function save() {

        if(isset($this->data)) unset($this->data);
        
        if (isset($this->cutData)) {
            $this->cut = json_encode($this->cutData);
            unset($this->cutData);
        }
        parent::save();
    }

    public function getDoublon($string = '') {
        $limit = '';
        if ($string == '') {
            $stringCut = (array) json_decode($this->cut);
            $limit = 'and id < ' . $this->id;
        } else {
            $fact = trim($string);
         //   $fact = htmlentities($fact, ENT_QUOTES);
            $string = nl2br($fact);
            $this->cut($string);
            $stringCut = $this->cutData;
        }

        $where = '%' . implode('%" and cut like "%', $stringCut) . '%';
        $obj = new Base();
        $req = 'select * from Doublons where cut like "' . $where . '" ' . $limit . ' order by id ';
        $collection = $obj->getCollection($req, 'Doublons');
        if (count($collection) == 0) {
            return null;
        }

        //selection de la fact la plus proche
        $count = 0;
        $id_ok = null;

        foreach ($collection as $key => $data) {
            if ($limit != null && $data->id > $limit)
                break;

            $ref = (array) json_decode($data->cut);

            $count_ok = count(array_intersect($ref, $stringCut));
                // i le nb d'elem correspondant est supérieur 
            // au résultat de la derniere fact
            if ($count < $count_ok 
                    && $count_ok >= count($stringCut) / 2 
                    && $count_ok >= count($ref) / 2) {
                $count = $count_ok;
                $id_ok = $data->id;
                $this->data = count($stringCut). ' - '.count($ref). ' - '.$count ;
            }
        }

        // si une fact a été selectionnée
        return ($id_ok != null) ? $id_ok : null;
    }

    public function cut($str) {
        $str = Helpers::slugify($str);

        $str = str_replace('-', ' ', $str);
        $str = str_replace('chuck', ' ', $str);
        $str = str_replace('norris', ' ', $str);
        $datas = explode(' ', $str);

        foreach ($datas as $key => $data) {
            if (strlen($data) < 3)
                unset($datas[$key]);
        }

        $this->cutData = array_values($datas);
    }

}
