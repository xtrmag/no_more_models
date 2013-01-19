<?php
function print_array($array) {
	echo '<xmp>'.print_r($array, true).'</xmp>';
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function stopwatch($start) {
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	echo 'Elpased time: '.$total_time.' seconds.<br>';
}

//------------------------------
include "no_more_models/nmm.php";

//NMM::getInstance()->getADP()->connect();
//NMM::getInstance()->getADP()->query("SELECT * FROM test");
//NMM::getInstance()->getADP()->disconnect();
//die();


//Time watch
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

NMM::getInstance()->createObject('test');

print ("-- EMPTYOBJ --<br>");
$empty = NMM::getInstance()->getDB()->getEmptyObject('test');
print_array($empty);
stopwatch($start);


print ("-- FETCHROW --<br>");
$obj = NMM::getInstance()->fetchRow('test', "test_id = 2");
print_array($obj);
stopwatch($start);


print ("-- FILL --<br>");
$nmm_obj = NMM::getInstance()->createObject('test');
$nmm_obj->fill("test_id = 1");
print_array($nmm_obj->get());
stopwatch($start);


print ("-- SET --<br>");
$nmm_obj->set("name", generateRandomString());
print_array($nmm_obj->get());
stopwatch($start);


print ("-- Update --<br>");
$nmm_obj->update("test_id = 1");
$nmm_obj2 = NMM::getInstance()->createObject('test');
$nmm_obj2->fill("test_id = 1");
print_array($nmm_obj2->get());
stopwatch($start);


/* It's working!*/
print ("-- Insert --<br>");
$nmm_obj3 = NMM::getInstance()->createObject('test');
$tmp_name = generateRandomString();
$nmm_obj3->set("name", $tmp_name);
$nmm_obj3->set("params", generateRandomString());
print_array($nmm_obj3->get());
$nmm_obj3->insert();
stopwatch($start);


$nmm_obj4 = NMM::getInstance()->createObject('test');
$nmm_obj4->fill("name = '".$tmp_name."'");
print_array($nmm_obj4->get());
stopwatch($start);

/*
print ("-- Delete --<br>");
$nmm_obj5 = NMM::getInstance()->createObject('test');
$nmm_obj5->delete("test_id = 3");
stopwatch($start);
*/

//--------------------------------

//Time watch
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';

?>
