<?php

include_once "KCSSReader.php";

$kcss = new KCSSReader();

try {
  $kcss->readKCSSFile("test.kcss"); // ou $kcss->readKCSS("KCSS brute");
} catch (Exception $e) {
  echo($e->getMessage()); // messages d'erreur d'interprétation du KCSS
}

$kcss->writeCSSFile("test.css"); // ou $kcss->writeCSS(); qui retourne une chaîne de caractères

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" href="test.css">
 </head>
 <body>
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
   <span>spanspanspanspan</span>
   <a href="#">un lien</a>
 </body>
</html>
