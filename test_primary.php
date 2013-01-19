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

include "no_more_models/nmm.php";

print ("-- OBJECT WITH PRIMARY KEY --<br>");
$nmm_obj = NMM::create('test');
$nmm_obj->setPrimary("test_id", 1);
$nmm_obj->fill();
print_array($nmm_obj->get());

print ("-- SET & UPDATE --<br>");
$rnd = generateRandomString();
print (" name => primary_test_".$rnd."<br><br>");
$nmm_obj->set("name", "primary_test_".$rnd);
$nmm_obj->update();

print ("-- CHECK THE VALUE --<br>");
$nmm_obj2 = NMM::fetchRPK('test', 'test_id', 1);
print_array($nmm_obj2);

?>