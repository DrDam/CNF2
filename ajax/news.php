<?php
require_once('ajaxboot.php');
ajax_access('moderateur');

$news = new News();
$news->id = $_POST['id'];
$news->notCached = $_POST['sens'];
$news->save();

print $_POST['sens'];
