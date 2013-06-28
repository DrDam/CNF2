<?php
require_once('ajaxboot.php');

$fact = Facts::getObject(false, 'txt');
$fact->id = $_POST['fact'];
$fact->load();

if (isset($fact->error) && $fact->error == TRUE) {
    exit(json_encode(array('code' => 1)));
}

// controle du vote
$vote = $_POST['choix'];
if (!is_numeric($vote) || !in_array($vote, array(1, 0))) {
    exit(json_encode(array('code' => 2)));
}

if ($vote == 1) {
    $fact->points++;
}

$fact->votes++;
$fact->moyenne = $fact->points / $fact->votes;
$fact->save();

print json_encode(array('code' => 0,'moyenne'=>round($fact->moyenne * 100,2),'votes'=>$fact->votes ));
