<?php

//$test = "testing";

class Tester {
    static function doTest () {
        global $test;
        echo $test;
    }
}

Tester::doTest();

?>