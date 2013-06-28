<?php

global $user;
addJs('vote');
addJs('raty/jquery.raty');
addJs('facts');

$search = (isset($_POST['s'])) ? trim($_POST['s']) : null;

$titre = 'vous recherchez des facts ';

$content = '';
if ($search != null) {
    if ($user != null && $user->role->id > 0) {
        addjs('modif');
    }

    $search2 = htmlentities($search, ENT_QUOTES);
    $search2 = strip_tags($search2);
    $titre .= 'avec "' . $search2. '"';


    $obj = new Search($search2);

    $facts = $obj->getFacts();
  
    if(count($facts) == 10)
    {
        Helpers::ok('La recherche remonte les 10 facts les mieux notés.');
    }
    
    $content = render(Navig::maVue('facts'), array('facts' => $facts, 'action' => 'head', 'nontri'=> true));
}

$output = array('content' => $content, 'titre' => $titre);
