<?php

echo "server";

print_r($_SERVER);

echo "<hr/>";

print_r($_REQUEST);

echo "<hr/>";

print_r($_ENV);

echo "<hr/>";

echo $_POST["test"];

echo "<hr/>";

echo htmlentities($_POST["test"]);

echo "<hr/>";
$var = "üöä";
echo $var;
echo "<hr/>";

echo htmlentities($var);

echo "<hr/>";

echo utf8_decode($var);
echo "<hr/>";

echo htmlentities(utf8_decode($var));

echo "<hr/>";

/*
$str = $_GET["str"];
$str = utf8_decode($str);
$htmlEntities = htmlentities($str);

echo $htmlEntities;
echo "<hr/>";

$htmlSpecialChars = htmlspecialchars($str,ENT_QUOTES);


echo $htmlSpecialChars;
echo "<hr/>";
*/
echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="robots" content="index, follow" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link type="text/css" href="resource/js/jquery/css/base/jquery.ui.all.css" media="all" rel="stylesheet"/>
    <script type="text/javascript" src="resource/js/jquery/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="resource/js/cookie/jquery.cookie.js"></script>
    <script type="text/javascript" src="resource/js/jquery/js/jquery-ui-1.10.3.custom.min.js"></script>
    <link type="text/css" href="resource/css/main.css" media="all" rel="stylesheet"/>
    <script type="text/javascript" src="resource/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="modules/admin/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="?service=menuStyles" />
    <link rel="stylesheet" type="text/css" href="modules/comments/css/comments.css" />
    <link rel="stylesheet" type="text/css" href="resource/css/captcha.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost/vbmscms/files/template/75ea9d252b5f131f3f0720542b5f5669//template.css" />
    <script type="text/javascript" src="modules/admin/js/menu.js" ></script>
    <script type="text/javascript" src="http://localhost/vbmscms/files/template/75ea9d252b5f131f3f0720542b5f5669//template.js" ></script>
    <!-- Piwik -->
</head>
<body>
    <form action="" method="post">
        <textarea name="test">öäü <?php echo utf8_decode("öäü"); ?> &uuml;</textarea>
        <button type="submit">test</button>
    </form>
</body>
</html>
