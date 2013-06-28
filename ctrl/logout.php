<?php
global $user;
unset($user);

if (isset($_SESSION['pseudo'])) {
    unset($_SESSION['pseudo']);
}
if (isset($_COOKIE['cnf'])) {
    setcookie('cnf', '', time() - 3600);
}

Navig::redirect('home');

$output = array('content' => $content, 'titre' => $titre);
