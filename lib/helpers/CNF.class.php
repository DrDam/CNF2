<?php

class CNF {

    static function start() {
        CNF::autologin();
        addCss('style');
        addJs('jquery-1.8.3.min');
        addCss('lightbox');
        addJs('lightbox/jquery-ui-1.8.18.custom.min');
        addJs('lightbox/jquery.smooth-scroll.min');
        addJs('lightbox/lightbox');

    }

    static function autologin() {
        // test si l'utilisateur est logué
        $user = '';
        $GLOBALS['user'] = null;

        if (isset($_SESSION['pseudo'])) {
            $user = Base::autoLoad('User', array('pseudo' => $_SESSION['pseudo']));
        } else {
            if (isset($_COOKIE['cnf'])) {
                $datas = unserialize($_COOKIE['cnf']);
                $nom = trim($datas['n']);
                $nom = htmlentities($nom, ENT_QUOTES);
                $pass = trim($datas['p']);
                $pass = htmlentities($pass, ENT_QUOTES);
                $user = new User();
                $user->pseudo = $nom;
                $user->password = $pass;
                $user->load();
            }
        }

        if (isset($user->id)) {
            $GLOBALS['user'] = $user;
        }
    }

}
