<?php
require_once('ajaxboot.php');

$fact = Facts::getObject(false, 'txt');

$fact->id = $_POST['fact'];
$fact->load();
$fact->fact = $_POST['fact_txt'];
$fact->save(true);

print render(Navig::template('tpl', 'factbody'), array('fact' => $fact));

