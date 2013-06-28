<?php

$datas = array();

// Ajout de facts
$args = (count(arg()) > 1) ? 'addfacts_' . arg(1) : null;

global $user;

if (isset($_POST['facts'])) {
    $fact_old = $_POST['facts'];

    if ($_SESSION['nb_alea'] == $_POST['cap']) {
        if (trim($_POST['facts']) == '') {
            Helpers::error('Hey, pense au moins à mettre quelque chose !');
        } else {
            // l'utilisateur n'a pas déclaré que sa facts n'est pas un doublon
            if (!isset($_POST['double'])) {
                $doublon = new Doublons();
                $doubl_id = $doublon->getDoublon($_POST['facts']);

                // on a trouvé un doublon
                if ($doubl_id != null) {
                    $fact_double = Facts::getObject();
                    $fact_double->id = $doubl_id;
                    $fact_double->load();
                    Helpers::error('Hey, il y en a une qui existe déjà : "' . $fact_double->fact . '" !');
                    $datas['double'] = true;
                    $datas['oldfact'] = $fact_old;
                }
            }

            // la fact n'est pas un doublon
            if (!isset($datas['double'])) {
                $fact_old = '';
                $object = Facts::getObject();

                $createDoublon = false;

                if ($user != null && $user->role->id > 0) {
                    $object->statut = 1;
                    $createDoublon = true;
                }

                $object->setFact($_POST);

                if ($createDoublon === true) {
                    $newDoublon = new Doublons();
                    $newDoublon->id = $object->id;
                    $newDoublon->cut = $object->fact;
                    $newDoublon->save();
                }
            }
        }
    } else {
        Helpers::error('Erreur lors de la confirmation anti-bot. Merci de réviser vos tables d\'addition.');
    }
}

$capchat = Helpers::capchat();
$datas['capchat'] = $capchat;
$titre = 'Qu\'est ce que Chuck Norris a encore fait ?';

$content = render(Navig::maVue(), $datas);

$output = array('content' => $content, 'titre' => $titre);
