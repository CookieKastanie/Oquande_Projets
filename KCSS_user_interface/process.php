<?php

include_once "../KCSS_Interpreteur_PHP/KCSSReader.php";

$kcss = new KCSSReader();

$input = @file_get_contents('php://input');

try {
  $kcss->readKCSS($input);
} catch (Exception $e) {
  echo($e->getMessage());
  http_response_code(422);
}

echo($kcss->writeCSS());

?>
