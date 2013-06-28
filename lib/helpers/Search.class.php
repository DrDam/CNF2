<?php

class Search extends Facts {

    private $string;
    
    public function __construct($string='',$page = 1,$type = 'txt') {
        
        $tab = preg_split("/[\s,;]+/", $string);
        $searchData = '%' . implode('%', $tab) . '%';
        $this->string = $searchData;
        
        $datas = Facts::getObject(true, $type);
        
        $object = $datas['obj'];

        $this->table = $datas['table'];
        $this->page = $page;
        $this->pager = $datas['pager'];
        
        $this->facts = $object->search($searchData);
    }    
}
