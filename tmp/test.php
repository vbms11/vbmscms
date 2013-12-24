<?php

include_once 'config.php';

// set database
function connect () {
    if (false !== mysql_connect($GLOBALS['dbHost'],$GLOBALS['dbUser'],$GLOBALS['dbPass']) 
            && true === mysql_select_db($GLOBALS['dbName'])) {
        $this->connected = true;
    } else {
        $this->connected = false;
    }
    return $this->connected;
}

function query ($query) {
    $result = mysql_query($query) or $this->error = true;
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

$result = null;
if (isset($_POST['query'])) {
    $querys = explode(";",$_POST['query']);
    foreach ($querys as $query) {
        $result = query($query);
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>TODO supply a title</title>        
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

if ($result !== null) {
    $results = fetchArray($result);
    foreach ($results as $arr) {
        $keys = array_keys($arr);
        echo "<table cellspacing='0'><tr>";
        foreach ($keys as $key) {
            echo "<tr><b>".htmlentities($key,ENT_QUOTES)."</b></tr>";
        }
        echo "</tr><tr>";
        foreach ($keys as $key) {
            echo "<tr>".htmlentities($arr[$key],ENT_QUOTES)."</tr>";
        }
        echo "</tr></table>";
    }
}

?>

</body>
</html>