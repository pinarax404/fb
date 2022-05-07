<?php

//ini_set('display_errors', "0");
system('clear');

$getip = file_get_contents('https://ipwhois.app/json/');
if($getip && strpos($getip, 'ip') !== false && strpos($getip, 'country') !== false) {
    $res_ip = json_decode($getip, true);
    echo "\033[1;37mIP : " . $res_ip['ip'] . " | Country : " . $res_ip['country'] . "\033[1;37m\n";
} else {
    echo "\033[1;37mIP : null | Country : null\033[1;37m\n";
}
