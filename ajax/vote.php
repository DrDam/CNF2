<?php
require_once('ajaxboot.php');
// les retour :
// 0 => Ok pas de problème
// 1 => id inexistant
// 2 => mauvaise valeur de vote
// 3 => type faux
// 4 => déjà voté

$ip = $_SERVER['REMOTE_ADDR'];

$votes = new Votes();
$votes->ip = $ip;
$votes->load();

//controler $type !!
if (!Helpers::is_valid_type($_POST['type'])) {
    exit(json_encode(array('code' => 3)));
}

// test "deja vote" ??
$data = array();
if (isset($_COOKIE['votes'])) {

    $data = json_decode($_COOKIE['votes']);
    $votes->addCookie();
} else {
    $data = $votes->datas;
    $votes->addCookie();
}

if ($data != null && isset($data->$_POST['type']) && in_array($_POST['fact'], $data->$_POST['type'])) {
    exit(json_encode(array('code' => 4)));
}

$fact = Facts::getObject(false, $_POST['type']);

$fact->id = $_POST['fact'];

$fact->load();
if (isset($fact->error) && $fact->error == TRUE) {
    exit(json_encode(array('code' => 1)));
}

//controler $vote !!
$vote = $_POST['vote'];
if (!is_numeric($vote) || $vote < 0 || $vote > 5) {
    exit(json_encode(array('code' => 2)));
}

if ($vote == 0) {
    $fact->berk++;
} else {
    $fact->points += $_POST['vote'];
}

$fact->votes++;
$fact->moyenne = $fact->points / $fact->votes;
$fact->save();

$allVotes = $votes->datas->$_POST['type'];
$allVotes[] = $fact->id;
$votes->datas->$_POST['type'] = $allVotes;

$votes->save();
$votes->addCookie();

print json_encode(array('code' => 0,'moyenne' => round($fact->moyenne * 2, 2)));
