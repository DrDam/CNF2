<?php
define("ROOT", realpath('..').'/');
require_once(ROOT .'lib/core/boot.php');

function ajax_access($access)
{
    if(!user_has_role($access)) header('HTTP/1.1 403 Forbidden') ; 
}
