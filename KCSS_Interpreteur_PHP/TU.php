<?php

include_once "../module_tests_unitaires/UnitTest.php";
include_once "KCSSReader.php";

$kcss = new KCSSReader();

$lesTests = new UnitTest();

////////////////////////////////////////////////////////////////////////////////

$lesTests->addTest(array($kcss, "readKCSS"), array("body{color:red}"), "");
$lesTests->addTest(array($kcss, "writeCSS"), array(), "body{color:red;}");

$lesTests->addTest(array($kcss, "readKCSS"), array(""), "");
$lesTests->addTest(array($kcss, "writeCSS"), array(), "");

$lesTests->addTest(array($kcss, "readKCSS"), array("        body, a             {color:red}"), "");
$lesTests->addTest(array($kcss, "writeCSS"), array(), "body,a{color:red;}");

$lesTests->addTest(array($kcss, "readKCSS"), array("
?bg_color : lightblue
?width : 600px

body{
  a, p{
    color: red
    position: relatif
  }

  :hover{
    background-color : pink
  }
}

@media only screen and (max-width: ?width) {
  body {
    background-color: ?bg_color;
  }
}
"), "");
$lesTests->addTest(array($kcss, "writeCSS"), array(), "body a,body p{color:red;position:relatif;}body:hover{background-color:pink;}@media only screen and (max-width: 600px){body{background-color:lightblue;}}");

////////////////////////////////////////////////////////////////////////////////

$lesTests->start();

?>
