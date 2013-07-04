<?php

require_once Navig::ctrl('facts');
unset($_SESSION['messages']);
$no_render = true;

switch ($arg) {
    case 'alea':
        $desc = '{nb} Chuck Norris Facts aléatoire';
        break;
    case 'flop':
        $desc = 'Le flop {nb} des Chuck Norris Facts';
        break;
    case 'top':
        $desc = 'Le top {nb} des Chuck Norris Facts';
        break;
    case 'last':
    default:
        $desc = 'Les {nb} derniers Chuck Norris Facts';
        break;
}
if ($type == 'img') {
    $nb = 10;
    $desc .= ' ( en Images )';
} else {
    $nb = 30;
}

$desc = str_replace('{nb}', $nb, $desc);

$desc .= ' !';

print '<?xml version="1.0" encoding="UTF-8" ?>';
print render(Navig::maVue('rss'), array('facts' => $facts->getFacts(), 'desc' => $desc, 'type' => $type, 'base_url' => $root));
