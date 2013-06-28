<?php

class Forms {

    static $no_dataBase = true;

    /**
     * @name : linkTo
     * @param : $controleur : string => le controleur à attaquer
     * 			$texte : string => le texte clicable
     * 			$options : string => 
     * @return : string : l'ancre
     * @desc : génère un lien hypertexte
     */
    static function linkTo($controleur, $texte, $options = null, $class = null) {
        $file = $controleur;

        $arg = ($options != null) ? "?" . $options : null;

        return '<a class="link ' . $class . '" HREF="' . $file . $arg . '" > ' . $texte . ' </a>';
    }

    /*     * ********************** */
    /*                       */
    /*  Element de fieldset  */
    /*                       */
    /*     * ********************** */

    /**
     * @name : label
     * @param : $texte : string => le texte à afficher
     * 			$for : string => le texte clicable
     * @return : string : le label
     * @desc : génère un <label>
     */
    static function label($texte, $for = null, $class = null) {
        $label = "<label ";
        $label .= ($class != null) ? ' class = ' . $class : '';
        $label .= ($for != null) ? ' for = ' . $for : '';
        $label .= " >" . $texte . "</label>";
        return $label;
    }

    /**
     * @name : liste
     * @param : $table : array => un tableau associatif array("nom" => value)
     * 			$select : string => la clef qui est selectionné
     * @return : string
     * @desc : génère le contenue de la liste déroulante
     */
    static function liste($table, $select = null, $null = null, $collect = array()) {
        if ($collect != array()) {
            $table = Forms::getArray($table, $collect[1], $collect[0]);
        }
        $chaine = "";
        $option = "";

        if ($null != null) {
            $chaine .= '<option value="" ';
            if ($select == null) {
                $chaine .= 'selected';
            }
            $chaine .='>' . $null . '</option>';
        }

        foreach ($table as $key => $value) {
            $option = '<option value="' . $key . '" ';

            if ($key == $select) {
                $option .= 'selected';
            }
            $option .='>' . $value . '</option>';

            $chaine .= $option;
        }
        return $chaine;
    }

    static function erreur($ctrl, $Terr) {
        if (isset($Terr[$ctrl])) {
            return "<p class=err>" . $Terr[$ctrl] . "</p>";
        }
    }

    /*     * ****************** */
    /*                   */
    /*  Outils internes  */
    /*                   */
    /*     * ****************** */

    /**
     * @name : getArray
     * @param : 
     * 			$key : string  => le champ qui servira de clef
     * 			$value : string => le champ qui servira de valeur
     * @return :  array => un tableau associatif
     * @desc : transforme une collection d'objet en un tableau associatif
     */
    static function getArray($collection, $key, $value) {
        $table = array();
        foreach ($collection as $object) {
            $table[$object->$value] = $object->$key;
        }
        return $table;
    }

}
