<?php

// page de moderation
if (user_access('moderateur')) {
    addJs('vote');
    addJs('raty/jquery.raty');
    addJs('valider');
    addJs('modif');

    $type = 'txt';
    if (arg(1) == 'images') {
        $type = 'img';
    }

    $facts = Facts::aModerer($type, true);

    foreach ($facts as $key => $obj) {
        // on récupère les hésitants
        $facts[$key]->getNames();
        
        // pour chaque facts on recherche des doublons
        $doublon = new Doublons();
        $doubl_id = $doublon->getDoublon($obj->fact);
        if ($doubl_id != null) {
            
            $old = Base::autoLoad('Fact', array('id' => $doubl_id));
            $facts[$key]->doublon = $old->fact;
        }
    }


    $titre = 'C\'est votre dernier mot ?';

    $content = render(Navig::template('tpl', 'facts_' . $type), array('facts' => $facts, 'action' => 'head'));

    $content .= '<div class="clear"></div>';
    
    $output = array('content' => $content, 'titre' => $titre);
}
