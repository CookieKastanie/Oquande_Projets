<?php
include_once "KCSSReader.php";

$kcss = new KCSSReader();

try {
  $kcss->readKCSS("test.kcss");

} catch (Exception $e) {
  echo($e->getMessage());
}

$css = $kcss->writeCSS();

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title></title>
   <style media="screen"><?php echo($css); ?></style>
 </head>
 <body>
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
   <span>spanspanspanspan</span>
   <a href="#">un lien</a>
 </body>
</html>
