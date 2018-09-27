<?php

require_once "SSH.php";

$ssh = new SSH('letoutchaud.fr');
$ssh->login('jeremy', '_jeje07205_');

var_dump($ssh->listing());
var_dump($ssh->listing("WIPCE"));

$ssh->end();

?>
