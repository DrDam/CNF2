<?php
// page de moderation
if (user_access('webmaster')) {
    addJs('vote');
    addJs('raty/jquery.raty');
    addJs('modif');
    addJs('berk');

    $facts = Facts::getBerk('txt');

    $titre = 'C\'est moche !';

    $content = render(Navig::template('tpl', 'facts_txt'), array('facts' => $facts, 'action' => 'head'));

    $output = array('content' => $content, 'titre' => $titre);
}
