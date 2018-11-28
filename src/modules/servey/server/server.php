<?php

$config = array(
    $database => array(
        "default" => array(
            "host" => "",
            "user" => "",
            "password" => "",
            "name" => ""
        )
    )
);


$response_json = "json";
$response_xml = "xml";

$type_json = "json";
$type_sql = "sql";
$type_xml = "xml";

function getAlias ($name) {
    return $name;
}
function getParamValue ($name, $container) {
    return $container[getAlias($name)];
}
function getParam ($name) {
    $alias = getAlias("action");
    if (isset($_GET[$alias])) {
        return getParamValue($alias);
    }
    return null;
}

function connect ($database) {
    return (false !== mysql_connect($database["host"],$database["user"],$database["password"]) && true === mysql_select_db($database["name"]));
}
function close () {
    mysql_close();
}
function criteriaToSql ($criteria) {
    $condition = "";
    $feilds = array();
    foreach ($criteria as $feild => $value) {
        $feilds []= $feild." = '".mysql_real_escape_string($value)."' ";
    }
    return implode($feilds, "and");
}
function print_result ($result) {
    
    $rows = mysql_num_rows($result);
    $response = array();
    while ($row = mysql_fetch_array($result) != false) {
        $response []= $row;
    }
    switch (getParam("response")) {
        case response_json:
            echo json_encode(array(
                "status" => "success", 
                "rows" => $rows, 
                "data" => $response
            ));
            break;
        case response_xml:
            break;
    }
}
function print_affected ($num) {
    echo json_encode(array(
        "status" => "success", 
        "affected" => $num
    ));
}
function print_error () {
    echo "database error";
}

function print_email_error () {
    echo "mail error";
}
function sendEmail ($to,$subject,$content,$from,$html=true) {
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/".($html?"html":"plain")."; charset=iso-8859-1\r\n";
    $header .= "From: $from\r\n";
    $header .= "Reply-To: $from\r\n";
    $header .= "X-Mailer: PHP ". phpversion();
    mail($to,$subject,$content,$header) or print_email_error();
}

switch (getParam("action")) {
    
    case "ëmail":
        
        $to = getParam("to");
        $subject = getParam("subject");
        $content = getParam("content");
        $from = getParam("from");
        $html = getParam("html");
        
        sendTextEmail($to,$subject,$content,$from,$html);
        
        break;
        
    case "database":
        
        switch (getParam("type")) {
            
            case type_json:
                
                $object = json_decode(getParam("data"));
                
                switch ($object["command"]) {
                    case "create":
                        foreach ($object["objects"] as $key => $item) {
                            $feilds = array();
                            $values = array();
                            foreach ($item as $feild => $value) {
                                $feilds []= $feild;
                                $values []= "'".mysql_real_escape_string($value)."'";
                            }
                            $query = "insert into ".$object["table"]." (".implode($feilds, ",").") values(".implode($values, ",").");";
                            mysql_query($query);
                        }
                        break;
                    case "update":
                        foreach ($object["objects"] as $key => $item) {
                            $values = array();
                            foreach ($item as $feild => $value) {
                                $values[$feild] = "'".mysql_real_escape_string($value)."'";
                            }
                            $query = "update ".$object["table"]." set ".implode($values, ",")." where ".criteriaToSql($object["condition"]);
                            $result = mysql_query($query);
                            print_affected(mysql_affected_rows($result));
                        }
                        break;
                    case "delete":
                        $query = "delete from ".$object["table"]." where ".criteriaToSql($object["condition"]);
                        $result = mysql_query($query);
                        print_affected(mysql_affected_rows($result));
                        break;
                    case "select":
                        $result = mysql_query("select * from ".$object["table"]." where ".criteriaToSql($object["condition"]));
                        print_result($result);
                        break;
                }
                
                break;
            case type_sql:
                
                $query = getParam("query");
                $result = mysql_query($query) or print_error();
                print_result($result);
                break;
        }
        break;
}

?>