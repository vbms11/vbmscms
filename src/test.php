<?php
/*
echo "server";

print_r($_SERVER);

echo "<hr/>";

print_r($_REQUEST);

echo "<hr/>";

print_r($_ENV);
*/

$str = $_GET["str"];
$str = utf8_decode($str);
$htmlEntities = htmlentities($str);

echo $htmlEntities;
echo "<hr/>";

$htmlSpecialChars = htmlspecialchars($str,ENT_QUOTES);


echo $htmlSpecialChars;
echo "<hr/>";

?>