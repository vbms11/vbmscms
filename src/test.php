<?php

function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

// $value = hexToStr("275cbf27");

$value = "";
$size = pow(2, 16);



for ($i=0; $i<$size; $i++) {
    $value .= $i;
}


$content = "<?php \$var = array('".addslashes($value)."'); ?>";

echo $size;
echo "<hr/>";
echo $value;
echo "<hr/>";
echo $content;

file_put_contents("test.out.php", $content);

?>