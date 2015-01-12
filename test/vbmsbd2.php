<?php
$path = "";
if (isset($_POST["path"])) {
	$path = $_POST["path"];
} else if (isset($_GET["path"])) {
	$path = $_GET["path"];
}

$action = "";
if (isset($_GET["action"])) {
	$action = $_GET["action"];
}

?>
<html>
<head>
</head>
<body>

<h3>List Files in path</h3>
<form method="post" action="?action=listDir">
	<label>Path:  </label>	
	<input type="text" name="path" value="<?php echo $path; ?>" />
	<input type="submit" value="execute" />
</form>

<hr/>

<?php

switch ($action) {
	case "listDir":
		$dh  = opendir($path);
		$files = array();
		while (false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}
		?>
		<table>
			<?php
			foreach ($files as $id => $file) {
				if ($file == "." || $file == "..") {
					continue;
				}				
				?>
				<tr>
				<td><?php echo $file; ?></td>
				<td>
					<a href="?action=delete&path=<?php echo $path; ?>&file=<?php echo $file; ?>">delete</a>
				</td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
		break;
	case "delete":
		$path = $_GET["path"];
		$filename = $_GET["file"];
		$file = $path."/".$filename;
		if (is_dir($file)) {
			$result = rmdir($file);
			echo "directory deleted - result: $result";
		} else if (is_file($file)) {
			unlink($file);
			echo "file deleted";
		} else {
			echo $file." - not found!";
		}
		break;
}

?>

</body>
</html>
