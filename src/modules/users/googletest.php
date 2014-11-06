<?php

session_start();

require("core/lib/Google/src/Google/Client.php");

$client = new Google_Client();
$client->setClientId("926459283772-vdf1bj7lq8j3373km7htkvqsme95eeo2.apps.googleusercontent.com");
$client->setClientSecret("In217TPSAmYZIJoPUSYy3ddb");
$client->setRedirectUri("http://online4dating.net/googletest.php");

$service = new Google_Service_Urlshortener($client);
$client->addScope(array("https://www.googleapis.com/auth/userinfo.email"));

$loggedIn = false;
$userInfo = null;

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  // header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  	$client->setAccessToken($_SESSION['access_token']);
	$userInfo = $client->verifyIdToken()->getAttributes();
	$loggedIn = true;
}

?>
<html>
<head>

</head>
<body>

<?php
if ($loggedIn) {
	print_r($userInfo);
} else {
	?>
	<a href="<?php echo $client->createAuthUrl(); ?>">Login</a>
	<?php
}
?>

</body>
</html>





