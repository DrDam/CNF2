<?php

/*
 * 	Cette classe contient des extension de PDO
 */

class PDO2 extends PDO {

    private $cnx = null; // connecteur à la BDD

    /**
     * @name : connect
     * @param : void
     * @return : void
     * @desc : la method récupère le contenu du fichier de config et se connect à la BDD
     */

    protected function connect() {
        if ($this->cnx == null) {
            $this->cnx = SPDO::getInstance();
            $this->cnx->query("SET NAMES 'utf8'");
        }
    }

    /**
     * @name : safe
     * @param : $chaine => string
     * @return : string
     * @desc : la method "sécurise" une chaine de texte
     */
    public function safe($chaine) {
        return $this->cnx->quote($chaine);
    }

    public function beginTransaction() {
        return $this->cnx->beginTransaction();
    }

    public function commit() {
        return $this->cnx->commit();
    }

    //TODO voir pour un refactor
    /**
     * @name : query
     * @param : $req => string : requete SQL
     * @return :
     * @desc : la method execute une requete
     */
    public function query($req) {
        if ($this->cnx == null) {
            $this->connect();
        }
        $result = $this->cnx->query($req);

        if ($result != false)
            return $result;
        else
            return null;
    }

    /**
     * @name : createQuery
     * @param :	$type => string : le type de requete à créer (Select, insert...)
     * 			$Tchamp => array : la liste des champs
     * 			$TTable => array : liste des tables
     * 			$Tjoin  => array : liste des condition de jointures
     * 			$Twhere => array : liste des conditions du where
     * 			$Toption => array : autres options du SQL (Limit, groupe by ...)
     * @return : string => requete SQL
     * @desc : génère la requete SQL
     */
    public function createQuery($type = "select", $Tchamp = array(), $TTable = array(), $Tjoin = array(), $Twhere = array(), $Toption = array()) {
        switch ($type) {
            case "select":
                return $this->createSelect($Tchamp, $TTable, $Tjoin, $Twhere, $Toption);
                break;

            case "insert":
                return $this->createInsert($TTable, $Tchamp, $Twhere);
                break;

            case "update":
                return $this->createUpdate($TTable, $Twhere, $Toption);
                break;

            case "delete":
                return $this->createDelete($TTable, $Twhere);
                break;
        }
    }

    /**
     * @name : createSelect
     * @param :	$Tchamp => array : la liste des champs
     * 			$TTable => array : liste des tables
     * 			$Tjoin  => array : liste des condition de jointures
     * 			$Twhere => array : liste des conditions du where
     * 			$Toption => array : autres options du SQL (Limit, groupe by ...)
     * @return : string => requete SQL
     * @desc : genère une requete de type Select
     */
    public function createSelect($Tchamp = array(), $TTable = array(), $Tjoin = array(), $Twhere = array(), $Toption = array()) {
        $req = "SELECT ";
        $req .= $this->addChamp($Tchamp);
        $req .= " FROM ";
        $req .= $this->addTable($TTable, $Tjoin);
        if ($Twhere != array()) {
            $req .= " WHERE ";
        }
        $req .= $this->addWhere($Twhere);
        $req .= $this->addOption($Toption);

        //echo $req."<hr>";

        return $req;
    }

    /**
     * @name : createInsert
     * @param :	$Table => string : nom de la table à mettre à jour
     * 			$Tatt => array : la liste des attributs de l'objet
     * 			$nonID => Le champ ID n'est pas pr�sent
     * @return : string => requete SQL
     * @desc : genère une requete de type Insert Into
     */
    public function createInsert($Table = null, $Tatt = array(), $nonID = false) {
        $keys = ($nonID === false ) ? array('id') : array();
        $values = ($nonID === false ) ? array('') : array();

        $req = "INSERT INTO ";
        $req .= $this->addTable($Table, null);
        foreach ($Tatt as $key => $value) {
            $keys[] = "`" . $key . "`";
            $values[] = "'" . $value . "'";
        }
        $req .= " ( ";
        $req .= implode(',', $keys);
        $req .= " ) VALUES ( ";
        $req .= implode(',', $values);
        $req .= " ) ";
        //var_dump($req);
        return $req;
    }

    /**
     * @name : createInsertCollection
     * @param :	$Table => string : nom de la table � mettre � jour
     * 					$Tkey => le nom des champs
     * 					$Tatt => les datas
     * 					$nonID => Le champ ID n'est pas pr�sent
     * @return : string => requete SQL
     * @desc : genère une requete de type Insert Into pour une collection
     */
    public function createInsertCollection($Table = null, $Tkey = array(), $Tatt = array(), $nonID = false) {
        $keys = /* ($nonID === false ) ? array('id') : */ array();
        $values = /* ($nonID === false ) ? array('') : */ array();

        $req = "INSERT INTO ";
        $req .= $this->addTable($Table, null);
        foreach ($Tkey as $key => $value) {
            $keys[] = "`" . $key . "`";
        }
        $req .= " ( ";
        $req .= implode(',', $keys);
        $req .= " ) VALUES ( ";
        foreach ($Tatt as $key => $value) {
            if ($nonID === false)
                array_unshift($value, '');
            $values[] = "'" . implode("','", $value) . "'";
        }
        $req .= implode('),(', $values);
        $req .= " ) ";
        return $req;
    }

    /**
     * @name : createUpdate
     * @param :	$Table => string : nom de la table à mettre à jour
     * 			$Tset => array : la liste des champs à modifier
     * 			$Twhere => array : liste des conditions du where
     * @return : string => requete SQL
     * @desc : genère une requete de type update
     */
    public function createUpdate($Table = null, $Tset = array(), $Twhere = array()) {
        $req = "UPDATE ";
        $req .= $this->addTable($Table, null);
        $req .= " SET ";
        $req .= $this->addSet($Tset);
        if ($Twhere != array()) {
            $req .= " WHERE ";
        }
        $req .= $this->addOption($Twhere, true);

        return $req;
    }

    /**
     * @name : createDelete
     * @param :	$Table => string : nom de la table à mettre à jour
     * 			$Twhere => array : liste des conditions du where
     * @return : string => requete SQL
     * @desc : genère une requete de type Delete
     */
    public function createDelete($Table = null, $Twhere = array()) {
        $req = "DELETE FROM ";
        $req .= $this->addTable(array($Table), null);
        if ($Twhere != array()) {
            $req .= " WHERE ";
        }
        $req .= $this->addWhere($Twhere);
        return $req;
    }

    /**
     * @name : addChamp
     * @param :	$Tchamp => array : liste des champs
     * @return : string => SQL
     * @desc : genère une partie de requete SQL
     */
    public function addChamp($Tchamp = array()) {
        if ($Tchamp == array()) {
            return "*";
        } else {
            $chaine = "";
            $flag = false;

            foreach ($Tchamp as $champ) {
                $chaine .= ($flag === true) ? ',' : $flag = false;
                $chaine .= ' ' . $champ . ' ';
            }

            return $chaine;
        }
    }

    /**
     * @name : addTable
     * @param :	$TTable => array : liste des champs
     * 			$Tjoin => array : liste des conditions de jointures
     * @return : string => SQL
     * @desc : genère une partie de requete SQL
     */
    public function addTable($TTable, $Tjoin) {

        if (count($TTable) == 1) {
            return $TTable[0];
        } else {
            $chaine = "";
            $flag = true;

            for ($i = 0; $i < count($TTable); $i++) {
                $chaine .= ' ' . $Tjoin[$i]['type'] . ' ' . $TTable[$i] . ' ' . $Tjoin[$i]['cond'];
            }
            return $chaine;
        }
    }

    /**
     * @name : addOption
     * @param :	$Toption => array : liste des options
     * 			$isWhere => bool : cas particulier du update => to addwhere
     * @return : string => SQL
     * @desc : genère une partie de requete SQL
     */
    public function addOption($Toption = array(), $isWhere = false) {
        if ($isWhere === true) {
            return $this->addWhere($Toption, true, true);
        }
        $chaine = "";

        foreach ($Toption as $option => $value) {
            $chaine .= '  ' . $option . ' ' . $value . ' ';
        }
        return $chaine;
    }

    public function addSet($Tset) {
        //	var_dump($Tset);
        return $this->addWhere($Tset, true, true);
    }

    /**
     * @name : addWhere
     * @param :	$Twhere => array : liste des elements du where
     * 			$and => bool : articulation
     * 			$or => bool : articulation
     * 			$justValues => bool : cas particulier du update => to addwhere
     * @return : string => SQL
     * @desc : genère une partie de requete SQL
     */
    public function addWhere($Twhere, $justValues = FALSE, $update = false) {
        $chaine = "";
        foreach ($Twhere as $champ => $value) {
            if ($justValues === FALSE) {
                $chaine .= $value["articulation"] . " " . $champ . " " . $value["valeur"] . " ";
            } else {
                if ($update == TRUE) {
                    $T[] = $champ . " = '" . $value . "' ";
                } else {
                    $chaine .= $value . ',';
                }
            }
        }
        if ($update == true && $T != array()) {
            $chaine = implode(',', $T);
        }
        return $chaine;
    }

}
