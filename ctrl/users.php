<?php

if (user_access('superadmin')) {
    $obj = new User();

    $users = $obj->getAll();

    $titre = 'La DreamTeam ! ';

    $content = render(Navig::maVue('users'), array('users' => $users));

    $output = array('content' => $content, 'titre' => $titre);
}
