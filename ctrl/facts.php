<?php
// page des facts
addJs('vote');
addJs('raty/jquery.raty');
addJs('facts');

$page = (isset($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;

$arg = (count(arg()) > 1) ? arg(1) : null;

$type = 'txt';

if ($arg == 'image') {
    $type = 'img';
    $arg = (count(arg()) > 2) ? arg(2) : null;
    if (isset($_FILES)) {
        Helpers::saveImage($_POST, $_FILES);
    }
}

if (user_has_role('moderateur') && $type = 'txt') {
    addJs('modif');
}

$facts = new Facts($arg, $page, $type);

$titre = 'toutes les facts';

$vue = ($type == 'img') ? 'images' : null;

$content = render(Navig::maVue($vue), array('facts' => $facts->getFacts(), 'pagination' => $facts->getPagination(), 'root' => $root));

$output = array('content' => $content, 'titre' => $titre);
