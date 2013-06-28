<?php

// fonction de création SQL de création des tables
function make_creat_sql($table, $elems, $primary) {
    $sql = 'CREATE TABLE ' . $table . '( ';
    $fields = array();
    foreach ($elems as $field => $data) {
        $long = (isset($data['length'])) ? '(' . $data['length'] . ')' : '';
        $fields[] = $field . ' ' . $data['type'] . $long;
    }

    $sql.= implode(',', $fields);
    $sql.= ',PRIMARY KEY (';
    $sql.= (is_array($primary)) ? implode(',', $primary) : $primary;
    $sql .= '));';
   

    return $sql;
}

$install_db = $insert_data = '';
$no_id = array();

// préparation insertion données
include(ROOT . 'lib/zeroData.php');


//creation des tables
$dirs = array(ROOT . 'lib/model', ROOT . 'lib/core/outils');
foreach ($dirs as $dirname) {
    $dir = opendir($dirname);
    while ($file = readdir($dir)) {
        if ($file != '.' && $file != '..' && !is_dir($dirname . $file) && substr($file, -10, 10) == '.class.php') {
            $class = substr($file, 0, strlen($file) - 10);

            if (isset($class::$no_dataBase))
                continue;

            $structure = $class::get_structure($class);
            if ($structure == null)
                continue;

            $primary = (isset($class::$primary)) ? $class::$primary : array();

            $install_db .= make_creat_sql($class, $structure, $primary);

            if (isset($zeroData[$class])) {
                
                if(is_array($primary))
                {
                    foreach ($primary as $primaire) {
                        if ($structure[$primaire]['type'] == 'serial') {
                            $no_id[$class] = $primaire;
                        }
                    }
                }
                else {
                    if ($structure[$primary]['type'] == 'serial') {
                            $no_id[$class] = $primary;
                        }
                }
            }
        }
    }
    closedir($dir);
}

foreach ($zeroData as $table => $values) {
    $sql = $items = '';

    $fields = array_keys($values[0]);

    // si on a un serial en clef primaire, on fait sauter l'id
    if (isset($no_id[$table])) {
        foreach ($fields as $key => $field) {
            if ($field == $no_id[$table])
                unset($fields[$key]);
        }
    }

    $sql .= 'insert into ' . $table . ' (' . implode(',', $fields) . ')';

    foreach ($values as $value) {
        // si on a un serial en clef primaire, on fait sauter l'id
        if (isset($no_id[$table]))
            unset($value[$no_id[$table]]);

        $items[] = '( "' . implode('","', $value) . '" )';
    }

    $sql .= ' VALUES ' . implode(',', $items) . ';';

    $insert_data .= $sql;
}

//  Initialisation BDD
$bdd = new Base();
$bdd->beginTransaction();
$bdd->query($install_db);
$bdd->query($insert_data);
$bdd->commit();

// run script installation
require_once(ROOT . 'lib/setup.php');

Variables::set_var('installed', date('Y/m/j - G-i'));

