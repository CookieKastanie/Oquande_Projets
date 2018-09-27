<?php

include_once "KJSImports.php";

$KJS = new KJSImports();

try {
  $KJS->add("js/A.js");
  $KJS->add("js/B.js");
} catch (Exception $e) {
  echo($e->getMessage());
  echo "<br>";
}

var_dump($KJS->getText());

?>
