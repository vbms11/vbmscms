<?php

echo "hello world";



?>
<!DOCTYPE html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title>jCanvasGraph demo</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="jCanvasGraph.js"></script>
</head>
<body>


<a href=" https://vbmscms-vbms.c9.io/vbmscms/test/test1.php">test1</a>


<a href="test2.php">test2</a>

<a href="/test3.php">test3</a>


<script>
$(function(){
	$("a").each(function(index,object){
	   alert(object.attr("href")); 
	});
	alert("finnished");
});
</script>

</body>
</html>




