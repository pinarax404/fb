<?php

//ini_set('display_errors', "0");
system('clear');

$getip = file_get_contents('https://ipwhois.app/json/');
$getattr = file_get_contents('https://randomuser.me/api/?gender=female&nat=us');



if($getip && strpos($getip, 'ip') !== false) {
    $res_ip = json_decode($getip, true);
    echo "\033[1;37mIP : " . $res_ip['ip'] . " | Country : " . $res_ip['country'] . "\033[1;37m\n";
} else {
    echo "\033[1;37mIP : null | Country : null\033[1;37m\n";
}


if($getattr && strpos($getattr, 'name') !== false) {
    $res_attr = json_decode($getattr, true);
    $first_name = strtolower($json_generate_user['results']['0']['name']['first']);
    $last_name = strtolower($json_generate_user['results']['0']['name']['last']);
    echo $first_name . ' ' . $last_name . "\n";
} else {
    echo "Failed\n";
}
