<?php

class Valid {

    static $no_dataBase = true;

    /**
     * @name : validation
     * @param : $form : le formulaire à valider
     * 			$values : les données à valider
     * @return : un tableau d'erreur
     * @desc : valide le formualire
     */
    public function validation($form, $values) {
        $t_err = array();
        require($this->load($form));

        foreach ($t_valid as $elem => $t_ctrl) {
            $t_ctrls = $t_ctrl[0];
            $t_errs = $t_ctrl[1];

            foreach ($t_ctrls as $ctrl => $value_ctrl) {
                // récupère la valeur correspondante dans $values => $value
                if (isset($values[$elem]) && $values[$elem] != "") {
                    if (!$this->validate($values[$elem], $ctrl, $value_ctrl)) {
                        $t_err[$elem] = $t_errs[$ctrl];
                    }
                } else {
                    if (isset($t_ctrls['notNull'])) {
                        $t_err[$elem] = $t_errs['notNull'];
                    }
                }
            }
        }
        return $t_err;
    }

    /**
     * @name : load
     * @param : le fichier de controle à utiliser
     * @return : la somme des controles
     * @desc : renvoie la liste des controles à effectuer (t_ctrl)
     */
    private function load($form) {
        return ROOT . 'lib/model/valid/' . $form . '.php';
    }

    /**
     * @name : validate
     * @param : $value : la valeur à controler
     * 			$c_ctrl : la somme de controle à verifier
     * 						type = varchar , int, float , mail , bool (obligatoire)
     * 						min = nb de caractère mini
     * 						max = nb de caractère max
     * 						values = array() liste des valeurs autorise (si spécifié)
     * @return : bool
     * @desc : controle une valeur contre une somme de controle
     */
    private function validate($value, $c_ctrl, $value_ctrl) {
        switch ($c_ctrl) {
            case 'type':
                return $bool = ($this->validType($value, $value_ctrl));
                break;

            case 'min':
                $bool = (strlen($value) < $value_ctrl - 1) ? false : true;
                return $bool;
                break;

            case 'max':
                return $bool = (strlen($value) > $value_ctrl + 1) ? false : true;
                break;

            case 'values':
                if ($value_ctrl != array()) {
                    return $bool = (array_key_exists($value, $value_ctrl) || in_array($value, $value_ctrl)) ? true : false;
                } else {
                    return true;
                }
                break;
        }
        return true;
    }

    /**
     * @name : validType
     * @param : $value : la valeur à controler
     * 			$value_ctrl : le type de référence
     * 				type = int, float , mail , bool
     * @return : bool
     * @desc : controle la taille de la réponse
     */
    private function validType($value, $value_ctrl) {
        switch ($value_ctrl) {
            case 'int':
                $bool = (is_numeric($value)) ? true : false;
                break;

            case 'float':
                $bool = (is_float($value + 0)) ? true : false;
                break;

            case 'mail':
                $Syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
                $bool = (preg_match($Syntaxe, $value)) ? true : false;
                break;

            case 'bool':
                $bool = ($value == "true" || $value == "false") ? true : false;
                break;
        }
        return $bool;
    }

}
