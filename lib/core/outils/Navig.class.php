<?php

class Navig {

    static $no_dataBase = true;

    /**
     * @name : maVue
     * @param : $vue : string => la vue à afficher
     * @return : string : le path
     * @desc : génère le path de la vue
     */
    static function maVue($vue = null) {
        if ($vue == null) {
            $args = arg();
            $vue = $args[0];
        }
        return ROOT . 'vues/' . $vue . '.tpl.php';
    }

    static function requireLib($lib) {
        return ROOT . 'lib/helpers/' . $lib;
    }

    /**
     * @name : template
     * @param : $type : string => le groupe de template
     * 			$nom : string => la vue à afficher
     * @return : string : le path
     * @desc : génère le path de la vue
     */
    static function template($type, $nom) {
        return ROOT . 'vues/' . $type . '/' . $nom . '.tpl.php';
    }

    /**
     * @name : ctrl
     * @param : $controleur : string => le controleur à attaquer
     * @return : string : le path
     * @desc : génère le path du controleur
     */
    static function ctrl($controleur) {
        $uri = ROOT . 'ctrl/' . $controleur . '.php';
        return (file_exists($uri)) ? $uri : ROOT . 'ctrl/inc/404.php';
    }

    /**
     * @name : JsFile
     * @param : le fichier Js à rajouter
     * @return : string : le path
     * @desc : ajoute le path du fichier désiré
     */
    static function JsFile($js) {
        return ROOT . 'Javascript/' . $js . '.js';
    }

    /**
     * @name : redirect
     * @param : le controleur à rejoindre
     * @return : string : l'instruction de redirection
     * @desc : redirige vers un controleur
     */
    static function redirect($controleur) {
        echo '<META http-equiv="refresh" content="0; URL=' . $controleur . '">';
    }

    static function routing() {
        $args = arg();
        return Navig::ctrl($args[0]);
    }

}
