<?php
//N° version
$version = 2.0;

//racine de l'application sur le serveur
$root = "/";

//BDD
//mysql en local
$bddData = array(
'sgbd' => '',
'user' => '',
'pass' => '',
'host' => '',
'dbname' => '',
);

// objet à executer au démarage
// optionnel
// !! doit implémenter une méthode "start" en static !!
$startObject = 'CNF';


// script d'initialisation post_installation
$zeroScript = '';

// controleur de le home page
$home = 'home' ; 

// nom du site
$titre = 'chuckNorrisFacts';

//mail webmaster
$mail_webmaster = '';
$mail_no_reply = '';

// variables globals
$conf['types_facts'] = array('txt','img');
