<?php
// page de moderation
addJs('vote');
addJs('raty/jquery.raty');
addJs('moderation');
global $user;

if (isset($user->role) && $user->role->id >= 1) {
    addJs('modif');
}

$facts = Facts::aModerer('txt');

$titre = 'Et vous en pensez quoi ?';

Helpers::ok("Cette page recense 10 facts aléatoire en attente. Aidez nous en nous indiquant si selon vous, ils sont dignes ou non de figurer sur le site. Merci pour votre aide mais n'oubliez pas que, quoiqu'il arrive, les admins auront toujours le dernier mot...");

$content = render(Navig::template('tpl', 'facts_txt'), array('facts' => $facts ));

$output = array('content' => $content, 'titre' => $titre);
