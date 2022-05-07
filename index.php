<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {
    $get_ip     = curl_attr('https://ipwhois.app/json/', false);
    $get_attr   = curl_attr('https://randomuser.me/api/?gender=female&nat=us', false);
    $get_email  = curl_attr('http://ese.kr/?pb=6549', false);


    if($get_ip !== false) {
        $res_ip = json_decode($get_ip, true);
        echo "\033[1;37mIP : " . $res_ip['ip'] . " | Country : " . $res_ip['country'] . "\033[1;37m\n";
        echo "\033[1;37m========================================\033[1;37m\n";
    } else {
        echo "\033[1;37mIP : null | Country : null\033[1;37m\n";
        echo "\033[1;37m========================================\033[1;37m\n";
    }

    if($get_attr !== false && $get_email !== false && strpos($get_email, 'name="mailbox"') !== false) {
        $res_attr   = json_decode($get_attr, true);
        $first_name = strtolower($res_attr['results']['0']['name']['first']);
        $last_name  = strtolower($res_attr['results']['0']['name']['last']);
        $email      = replace_string('<input type="search" name="mailbox" value="', '"', $get_email);

        echo "\033[1;37mFull Name : " . $first_name . ' ' . $last_name . "\033[1;37m\n";
        echo "\033[1;37mEmail     : " . $email . "\033[1;37m\n";
        echo "\033[1;37mCreating Account...\033[1;37m\n";

    } else {
        echo 'looping';
    }
}

function replace_string($start, $end, $data) {
    $rt = explode($start, $data)[1];
    $rt = explode($end, $rt)[0];
    return $rt;
}

function curl_attr($url, $body) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($respons_http_code == 200) {
        return $respons_data;
    } else {
        return false;
    }
}
