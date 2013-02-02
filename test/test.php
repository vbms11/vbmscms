<?php

$param = "id";

$valid = array("id","name","date");

$result = in_array($param,$valid);

"select * from users order by $param";

?>