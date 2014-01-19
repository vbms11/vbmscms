<?php

include_once 'config.php';

$error = null;
$result = null;

// set database
function connect () {
    if (false !== mysql_connect($GLOBALS['dbHost'],$GLOBALS['dbUser'],$GLOBALS['dbPass']) 
            && true === mysql_select_db($GLOBALS['dbName'])) {
        $connected = true;
    } else {
        $connected = false;
    }
    return $connected;
}

function query ($query) {
    global $error;
    $result = mysql_query($query) or $error = mysql_error();
    return $result;
}

function fetchArray ($result) {
    $ret = array();
    if ($result) {
        $rows = mysql_num_rows($result);
        if ($rows < 1) {
            return;
        }
        while ($obj = mysql_fetch_array($result)) {
            $ret[] = $obj;
        }
    }
    return $ret;
}

if (isset($_POST['query'])) {
    connect();
    $querys = stripslashes($_POST['query']);
    $querys = explode(";",$querys);
	
    foreach ($querys as $query) {
        $result = query($query);
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Sql Shell</title>        
    <style>
    </style>
</head>
<body>

<form action='' method='post'>
<textarea name='query' rows='5' cols='5' style='width:100%;'></textarea>
<button type='submit'>Execute</button>
</form>
<hr/>

<?php

if ($error !== null) {
    echo $error;
} else if ($result !== null) {
    if ($result === true) {
        echo "inserted";
    } else {
        $results = fetchArray($result);
        if (count($results) > 0) {
            $keys = array_keys(current($results));
            echo "<table cellspacing='0'><tr>";
            foreach ($keys as $key) {
                echo "<td><b>".htmlentities($key,ENT_QUOTES)."</b></td>";
            }
            echo "</tr>";
            foreach ($results as $arr) {
                echo "<tr>";
                foreach ($keys as $key) {
                    echo "<td>".htmlentities($arr[$key],ENT_QUOTES)."</td>";
                }
                echo "</tr>";
            }
            echo "</tr></table>";
        }
    }
}

?>

</body>
</html>