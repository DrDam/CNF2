<?php

// cette class est la classe mère de toutes les classes métier de l'application

class Base extends PDO2 {

    static $primary = '';
    static $structure = array();

    static function get_structure($class) {
        return (isset($class::$structure)) ? $class::$structure : null;
    }

    /**
     * @name : __construct
     * @param : $Tattrib => array : table contenant les valeurs des attributs
     * @return : void
     * @desc : la method crée un nouvel objet metier connecter à la BDD
     */
    public function __construct($Tatt = array()) {
        //print_r($Tatt);
        $this->connect();

        $this->set($Tatt);

        return $this;
    }

    /**
     * @name : set
     * @param : $Tatt
     * @return : void
     * @desc : la method hydrate l'objet
     */
    public function set($Tatt = array()) {
        foreach ($Tatt as $att => $value) {
            $this->$att = $value;
        }
    }

    /**
     * @name : truncate
     * @param : void
     * @return : void
     * @desc : la method vide la table concern�
     */
    public function truncate() {
        $table = $this->getTable();

        $req = 'TRUNCATE `' . $table . '`';

        $this->query($req);
    }

    /**
     * @name : save
     * @param : void
     * @return : void
     * @desc : la method sauvegarde l'objet en base
     */
    public function save() {
        $champs = get_object_vars($this);

        foreach ($champs as $key => $value) {
            if ($value == '' && !is_numeric($value))
              unset($champs[$key]);
        }
        
        $class = get_class($this);

        $id = ( $class::$primary != '' ) ? $class::$primary : 'id';

        if (is_array($id)) {
            $class = get_class($this);
            $champs2 = $champs;
            foreach ($champs2 as $key => $value) {
                if (!in_array($key, $id)) {
                    unset($champs2[$key]);
                }
            }

            if ($champs2 != array()) {
                $obj = new $class($champs2);
                $old = $obj->findOne();
            } else {
                $old = null;
            }
        } else {
            $old = (isset($champs[$id]) && $champs[$id] != null) ? $this->findBy($id, $champs[$id]) : null;
        }

        if ($old == null) {
            $req = $this->createInsert(array(0 => $this->getTable()), $champs, true);
        } else {
            $Twhere = (is_array($id)) ? $champs2 : array($id => $champs[$id]);
            $req = $this->createUpdate(array(0 => $this->getTable()), $champs, $Twhere);
        }

        $this->query($req);

        $this->load();
    }

    /**
     * @name : saveCollection
     * @param : void
     * @return : void
     * @desc : la method sauvegarde une collection d'objet en base
     * 					Uniquement des insert !!!
     */
    public function saveCollection($datas, $nonID = true) {
        $req = $this->createInsertCollection(array(0 => $this->getTable()), get_object_vars($this), $datas, $nonID);
        //var_dump($req);
        $this->query($req);
    }

    public function load() {
        $obj = $this->findOne();

        if ($obj == null) {
            $this->error = TRUE;
        } else {
            // recupère les valeurs des attributs de l'instance
            $datas = get_object_vars($obj);
            foreach ($datas as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    static function autoLoad($class, $elems) {
        $objName = $class;
        $obj = new $objName;

        $datas = get_object_vars($obj);
        foreach ($datas as $key => $value) {
            if (isset($elems[$key])) {
                $obj->$key = $elems[$key];
            }
        }

        $obj->load();

        return $obj;
    }

    /*     * ************************ */
    /** methodes de recherche * */
    /*     * ************************ */

    /**
     * @name : find
     * @param : $one => bool : faut il renvoyer qu'un et un seul résultat ?
     * @return : soit une collection d'objet ou un seul
     * @desc : méthode générique d'interogation de la BDD, à partir d'un objet semi compléter,
     * 			on récupère l'ensemble (ou 1 seul) objet correspondant
     */
    public function find($one = false, $table = null) {
        if ($table == null) {
            $Ttable[0] = $this->getTable($this);
        } else {
            $Ttable[0] = $table;
        }

        // on récupère la liste des attributs et de leur
        // valeur pour trouver un objet equivalent
        $t_where = $this->getWhere($this);

        // si on en veux qu'un seul, on impose la limit
        $t_option = array();
        if ($one === true) {
            $t_option = array("limit" => 1);
        }

        //on ecrit la requete SQL
        $req = $this->createQuery("select", null, $Ttable, null, $t_where, $t_option);

        $collection = $this->getCollection($req, $Ttable[0]);

        if ($collection == array()) {
            return null;
        }

        if ($one == true) { // si on en veux qu'un, on l'extrait de la collection : array(objet) => objet
            //echo "one";
            $collection = $collection[0];
        }

        return $collection;
    }

    /**
     * @name : findOne
     * @param : void
     * @return :  un seul objet
     * @desc : raccourcie de find($one=true)
     */
    public function findOne($table = null) {
        return $this->find(true, $table);
    }

    /**
     * @name : findBy
     * @param : $champ : string => nom du champ de comparaison
     * 			$value : string => valeur de comparaison
     * 			$one : bool => faut il renvoyer qu'un et un seul résultat ?
     * @return :  soit une collection d'objet (array) ou un seul
     * @desc : méthode recherche rapide, à partir d'un objet vide, et d'une seule condition
     * 			on récupère l'ensemble (ou 1 seul) objet correspondant
     */
    public function findBy($champ, $value, $one = false, $table = null) {
        if ($table == null) {
            $Ttable[0] = $this->getTable($this);
        } else {
            $Ttable[0] = $table;
        }
        $t_where[$champ] = array('articulation' => '', 'valeur' => "='" . $value . "'");

        $t_option = array();
        if ($one === true) {
            $t_option = array("limit" => 1);
        }

        $req = $this->createQuery("select", array(), $Ttable, null, $t_where, $t_option);
        //echo $req;

        $collection = $this->getCollection($req, $Ttable[0]);

        if ($one === true && $collection != null) { // si on en veux qu'un, on l'extrait de la collection : array(objet) => objet
            $collection = $collection[0];
        }
        return $collection;
    }

    /**
     * @name : findOne
     * @param : $champ : string => nom du champ de comparaison
     * 			$value : string => valeur de comparaison
     * @return :  objet => un seul objet
     * @desc : raccourcie de findBy($champ,$value,$one=true)
     */
    public function findOneBy($champ, $value, $table = null) {
        return $this->findBy($champ, $value, true, $table);
    }

    /**
     * @name : findOneBy
     * @param : $value : string => valeur de comparaison
     * @return :  objet => un seul objet
     * @desc : raccourcie de findOneBy('id',$value,$one=true)
     */
    public function findById($value, $table = null) {

        return $this->findOneBy("id", $value, $table);
    }

    /*     * ****************************** */
    /** 	methode gestion des objets  * */
    /*     * ****************************** */

    /**
     * @name : getTable
     * @param : $objet  => l'objet de référence ( généralement : this)
     * @return :  string => le nom de la classe
     * @desc : récupère le nom de la class
     */
    public function getTable($objet = null) {
        if ($objet == null)
            $objet = $this;
        $classe = get_class($objet);
        return $classe;
    }

    // crée un tableau qui contient les éléments du where t[champ][valeur]
    /**
     * @name : getWhere
     * @param : $objet  => l'objet de référence ( généralement : this)
     * @return :  array => le nécessaire pour les conditions where
     * @desc : transfom la liste des attributs et un tableau avec le nom des attribut, et leur valeur
     */
    public function getWhere($objet, $just_primary = false) {

        $class = get_class($objet);

        // recupère la liste des attributs de la class
        $public = get_class_vars(get_class($objet));

        // recupère les valeurs des attributs de l'instance
        $values = get_object_vars($objet);

        // on croise les 2 tableau => on ne récupere que les attributs de l'objet de travail (pas des classes meres)
        $intersect = array_intersect_key($values, $public);

        if ($just_primary == true) {
            $primaries = (is_array($class::$primary)) ? $class::$primary : array($class::$primary);
            $out = array();
            foreach ($primaries as $key) {
                $out[$key] = $intersect[$key];
            }
            $intersect = $out;
        }

        $flag = true;
        $articulation = '';
        $t = array();

        foreach ($intersect as $key => $value) {
            if ($value == null)
                continue;

            //var_dump($value);
            // si l'attribut à une valeur
            if (!is_numeric($value))
                $value = "'" . $value . "'";
            // on crée un condition where
            $t[$key] = array('articulation' => $articulation, 'valeur' => '=' . $value);
            if ($flag == true) { // on ne commence à mettre le "AND" qu'à la seconde condition
                $articulation = 'AND';
                $flag = false;
            }
        }
        return $t;
    }

    /**
     * @name : getObject
     * @param : $table : string => l'objet de référence
     * 			$t : array()  => l'ensemble des attribut de l'objet
     * @return :  un objet de la même classe que $table
     * @desc : transfom la liste des attributs en un objet
     */
    public function getObject($table, $t = null) {
        $class = $table;
        $objet = new $class($t);
        return $objet;
    }

    /**
     * @name : getCollection
     * @param : $table : string  => l'objet de référence
     * 			$req : string => requete SQL
     * @return :  array => la collection d'objet
     * @desc : execute la req SQL et transfom le resultat en une collection d'objet
     */
    public function getCollection($req, $table) {
        $recordset = $this->query($req);

        if ($recordset != null) {
            $collection = array();
            foreach ($recordset->fetchAll(PDO::FETCH_ASSOC) as $record) { // on transform en tableau associatif
                $object = $this->getObject($table, $record);

                array_push($collection, $object);
            }
            return $collection;
        }
        else
            return null;
    }

    public function getAll() {
        $T = array();
        $all = $this->find();
        foreach ($all as $obj) {
            $obj->load();
            $T[] = $obj;
        }
        return $T;
    }

    /**
     * @name : getArray
     * @param : $table : string  => l'objet de référence
     * 			$champ : string	=> un champ de la table
     * 			$cond : array() => la condition de requete
     * @return :  array => un tableau associatif
     * @desc : renvoi un tableau associatif array( "id" => "champ" )
     */
    public function getArray($table, $champ, $cond = null) {
        if ($cond != null)
            $cond = "where $cond ";
        $recordset = $this->query("select id, $champ from $table  $cond ");

        //var_dump("select id, $champ from $table  $cond");
        if ($recordset != null) {
            $array = array();
            foreach ($recordset->fetchAll(PDO::FETCH_ASSOC) as $record) { // on transform en tableau associatif
                $array[$record["id"]] = $record[$champ];
            }
            return $array;
        }
        else
            return null;
    }

    public function delete() {
        $req = $this->createDelete($this->getTable(), $this->getWhere($this, true));

        $this->query($req);
    }

}
