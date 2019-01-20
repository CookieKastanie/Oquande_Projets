<?php

$seconds_to_cache = 5;
$ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
header("Expires: $ts");
header("Pragma: cache");
header("Cache-Control: max-age=$seconds_to_cache");

 ?>

<link rel="stylesheet" href="wow.css">

<p>wow j'aime les salades ertyertyery</p>
