<?php
require_once('ajaxboot.php');

user_access('moderateur');

$news = new News();
$news->id = $_POST['id'];
$news->notCached = $_POST['sens'];
$news->save();

print $_POST['sens'];
