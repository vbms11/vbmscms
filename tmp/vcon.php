<?php

function printHtmlHeader () {
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TODO supply a title</title>
    </head>
    <body>
    <?php
}

function printHtmlFooter () {
    ?>
    </body>
    </html>
    <?php
}



function printDirectory ($path) {
    $path += "/";
    $dh  = opendir($path);
    if ($dh) {
        while (false !== ($filename = readdir($dh))) {
            if ($filename == ".." || $filename == ".") {
                continue;
            }
            $files[] = $filename;
        }
    }
    printHtmlHeader();
    echo "<table>";
    foreach ($files as $file) {
        $rights = fileperms($path.$file);
        if (is_dir($path.$file)) {
            echo "<tr><td><a href=''>$file</td><td>$rights</td></tr>";
        } else {
            echo "<tr><td>$file</td><td>$rights</td></tr>";
        }
    }
    echo "</table>";
    printHtmlFooter();
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
    
    case 'fs':
        if (isset($_GET['path'])) {
            printDirectory($_GET['path']);
        } else {
            printDirectory(dirname(__FILE__));
        }
        
        break;
    
    
    }
}


?>