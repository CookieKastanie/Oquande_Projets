<?php

include_once "KImports.php";

$KImp = new KImports();

try {
  $KImp->add("js/A.js");
  $KImp->add("js/B.js");
} catch (Exception $e) {
  echo($e->getMessage());
  echo "<br>";
}

var_dump($KImp->getList());

?>
