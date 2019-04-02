<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "DatePeriodParser8601.php";

$test[] = "2015-11-24";
$test[] = "2015-W48";
$test[] = "2015-W48-WE";
$test[] = "2015-11";
$test[] = "2015-11-XX";
$test[] = "2016";
$test[] = "201X";
$test[] = "20XX";
$test[] = "2XXX";
$test[] = "2018-XX-XX";
//$test[] = "2017-WI";
$test[] = "test";

foreach($test as $string){

    try {
        $obj = new DatePeriodParser8601($string);

        echo "<brString: " . $string;
        echo "<br>";
        echo "Start: " . $obj->getStart()->format("d.m.Y H:i:s");
        echo "<br>";
        echo "End : " . $obj->getEnd()->format("d.m.Y H:i:s");
        echo "<br>";
        echo "As DatePeriod: " . get_class($obj->asDatePeriod(new \DateInterval("P1D")));


        echo "<br><br><br>";
        $obj = null;

    }catch(\Exception $e){
        echo $e->getMessage();
    }
}