<?php

require_once('transliteration.inc');

class Helpers {

    static function capchat() {
        $nb1 = mt_rand(1, 9);
        $nb2 = mt_rand(1, 9);

        $_SESSION['nb_alea'] = $res = $nb1 + $nb2;

        return array($nb1, $nb2);
    }

    // Fonction permettant l'insertion rapide d'un message d'erreur
    static function error($msg = "Erreur sur la page") {
        $_SESSION['messages'][] = array('type' => 'erreur', 'message' => $msg);
    }

    // Idem pour un message de confirmation
    static function ok($msg) {
        $_SESSION['messages'][] = array('type' => 'ok', 'message' => $msg);
    }

    static function printMessages() {
        $output = '';
        if (!isset($_SESSION['messages']))
            return '';

        foreach ($_SESSION['messages'] as $msg) {
            $output .= '<div class="' . $msg['type'] . '">' . $msg['message'] . '</div>';
        }
        unset($_SESSION['messages']);
        return $output;
    }

    static function printUser() {
        global $user;
        $text = '';
        if (isset($user->id)) {
            $text = '<span class="hello">';

            $text .= 'Salut ' . $user->pseudo . ' !!';
            $text .= ' Je pense qu\'il te reste du taf ... ';
            $text .= Forms::linkTo('/admin', 'allons voir');
            $text .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            $text .= Forms::linkTo('/logout', 'déconnexion');
            $text .= '</span>';
        }
        return $text;
    }

    static function isMail($mail) {
        if (ereg('.+@.+\..{2,4}', $mail))
            return true;
        return false;
    }

    static function is_valid_type($type) {
        global $types_facts;
        return in_array($type, $types_facts);
    }

    static function saveImage($post, $file) {
//		var_dump($post);
//		var_dump($file);
        if (isset($_POST['pseudo'])) {

            $error = false;
            $pseudo = trim($_POST['pseudo']);
            $pseudo = htmlentities($pseudo, ENT_QUOTES);

            $url = trim($_POST['url']);
            $url = htmlentities($url, ENT_QUOTES);

            $mail = trim($_POST['mail']);
            $mail = htmlentities($mail, ENT_QUOTES);

            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');

            if (empty($pseudo)) {
                $error = true;
                Helpers::error('Veuillez indiquer un pseudo');
            }
            if (empty($mail) or !Helpers::isMail($mail)) {
                $error = true;
                Helpers::error('Veuillez indiquer une adresse email valide');
            }

            $extension_upload = strtolower(substr(strrchr($file['fichier']['name'], '.'), 1));


            if ($file['fichier']['error'] != 0) {
                $error = true;
                Helpers::error('Une erreur est survenue lors de l\'envoi du fichier');
            }

            if (!in_array($extension_upload, $extensions_valides)) {
                $error = true;
                Helpers::error('Le type du fichier envoyé (' . $extension_upload . ') ne peut être pris en charge');
            }



            if ($error == false) {
                $image = new ImageSave(array('max_width' => 450,
                    'min_width' => 100,
                    'path' => 'img/upload'));
                $image->saveImage($file);

                $imagePath = $image->getImagePath();

                //			var_dump($imagePath);

                if ($imagePath != null) {
                    $obj = new Images();
                    $obj->fact = $imagePath;
                    $obj->ip = $_SERVER['REMOTE_ADDR'];
                    $obj->pseudo = $pseudo;
                    $obj->blog = $url;
                    $obj->mail = $mail;
                    $obj->date = time();
                    $obj->save();

                    Helpers::ok("L'image a été envoyée avec succès. Elle sera validée aussi vite que possible et apparaitra sur le site dans la mesure où elle respecte les règles énoncées.");
                }
            }
        }
    }

    static function saveUser($post) {
        $mail = trim($post['mail']);

        $new_user = new User();
        $new_user->mail = $mail;
        $new_user->load();
        if (!isset($new_user->error)) {
            Helpers::error("Il existe déjà couillon<br/>");
            return null;
        }

        $nom = trim($post['pseudo']);
        $nom = htmlentities($nom, ENT_QUOTES);
        $pass = Helpers::mdp();

        unset($new_user->id);
        $new_user->pseudo = $nom;
        $new_user->password = md5($pass);
        $new_user->role = trim($post['role']);


        $new_user->save();

        $sujet = 'CNF - Bienvenue';
        $msg = render(Navig::template('mail', 'new_user'), array('nom' => $nom, 'pass' => $pass));

        send_mail($mail, $sujet, $msg);
        return true;
    }

    static function editUser($post) {
        $sendmail = false;

        $id = trim($post['uid']);

        $new_user = new User();
        $new_user->id = $id;
        $new_user->load();

        if (isset($new_user->error)) {
            Helpers::error("Il existe pas couillon<br/>");
            return null;
        }

        $mail = trim($post['mail']);
        $new_user->mail = $mail;

        $nom = trim($post['pseudo']);
        $nom = htmlentities($nom, ENT_QUOTES);
        $new_user->pseudo = $nom;

        if (isset($post['new_pass']) && $post['new_pass'] == 'ok') {
            $pass = Helpers::mdp();
            $new_user->password = md5($pass);
            $sendmail = true;
        }

        $new_user->role = trim($post['role']);
        $new_user->save();

        if ($sendmail == true) {
            $sujet = 'CNF - Mise à jour';
            $msg = render(Navig::template('mail', 'edit_user'), array('nom' => $nom, 'pass' => $pass));

            send_mail($mail, $sujet, $msg);
        }
        return true;
    }

    static function mdp() {
        $mdp = "";
        while (strlen($mdp) < 7) {
            $c = rand(48, 122);
            if ($c <= 57 or ($c >= 65 and $c <= 90) or $c >= 97) {
                $mdp.=chr($c);
            }
        }
        return $mdp;
    }

    static function slugify($str) {
        require_once( Navig::requireLib('transliteration.inc') );
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES);
        $str = transliteration_process($str);
        $str = str_replace(array(',', '.', "'", '?', '!', ':'), ' ', $str);
        $str = preg_replace("/[\s-]+/", " ", $str);
        $str = preg_replace("/[\s_]+/", "-", trim($str));
        return $str;
    }

}

