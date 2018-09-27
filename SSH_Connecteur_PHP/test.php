<?php

require_once "SSH.php";

$ssh = new SSH('letoutchaud.fr');
$ssh->login('///////', '////////////');

var_dump($ssh->listing());
var_dump($ssh->listing("WIPCE"));

$ssh->end();

?>
