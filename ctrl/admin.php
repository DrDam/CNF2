<?php

if (user_access('moderateur')) {
    global $user;

    $berk = Facts::nbBerk('txt');

    $nb_attente = Facts::enAttente('txt');
    $img_att = Facts::enAttente('img');

    $datas = array('attentes' => $nb_attente, 'berk' => $berk, 'img_att' => $img_att);

    $titre = "Y'a quoi au menu ?";
    $content = render(Navig::maVue('admin'), $datas);

    $output = array('content' => $content, 'titre' => $titre);
}
