<?php
define("ROOT", realpath('.') . '/');

require_once('lib/core/boot.php');

require_once Navig::routing();

if (isset($_SESSION['403']) && $_SESSION['403'] == true) {
    unset($_SESSION['403']);
    unset($output);
    require_once Navig::ctrl('inc/403');
}

if (!isset($no_render) || $no_render == false) {
    $page = render(Navig::template('inc', 'page'), $output);

    $output['page'] = $page;

    print render(Navig::template('inc', 'html'), $output);
}
