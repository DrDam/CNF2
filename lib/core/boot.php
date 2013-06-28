<?php

session_start();

date_default_timezone_set('UTC');

include(ROOT . 'lib/config.php');

SPDO::config($bddData);

$installed = Variables::get_var('installed');
if ($installed == null) {
    include(ROOT . 'lib/core/install.php');
}

define("FRONT", $home);

define("LIB", ROOT . 'lib/');

function __autoload($class_name) {
    // recherche des classes core
    if (file_exists(ROOT . 'lib/core/base/' . $class_name . '.class.php')) {
        require_once ROOT . 'lib/core/base/' . $class_name . '.class.php';
    }
    if (file_exists(ROOT . 'lib/core/outils/' . $class_name . '.class.php')) {
        require_once ROOT . 'lib/core/outils/' . $class_name . '.class.php';
    }

    // recherche des classes custom
    if (file_exists(ROOT . 'lib/model/' . $class_name . '.class.php')) {
        require_once ROOT . 'lib/model/' . $class_name . '.class.php';
    }
    if (file_exists(ROOT . 'lib/helpers/' . $class_name . '.class.php')) {
        require_once ROOT . 'lib/helpers/' . $class_name . '.class.php';
    }
}

$js = null;

require_once ROOT . 'lib/core/outils/helpers.php';

if (isset($startObject)) {
    $startObject::start();
}

if (isset($conf) && is_array($conf) && $conf != array()) {
    foreach ($conf as $var => $value) {
        $GLOBALS[$var] = $value;
    }
}
