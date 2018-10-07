<?php

require_once "SSH.php";
require_once "identifiants.php";

$ssh = new SSH($adresse);
$ssh->login($nom, $mdp);

var_dump($ssh->listing());
var_dump($ssh->listing("WIPCE"));
var_dump($ssh->readFile("WIPCE/index.html"));

var_dump($ssh->exec("cat ./WIPCE/index.html"));

$ssh->end();

?>
