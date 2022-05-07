<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik';
$useragent = "Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19";
//********************//


    $get_ip     = curl_attr('https://ipwhois.app/json/', false, false, false, false);
    if($get_ip !== false) {
        $res_ip = json_decode($get_ip, true);
        echo "\033[1;37mIP : " . $res_ip['ip'] . " | Country : " . $res_ip['country'] . "\033[1;37m\n";
        echo "\033[1;37m========================================\033[1;37m\n";
    } else {
        echo "\033[1;37mIP : null | Country : null\033[1;37m\n";
        echo "\033[1;37m========================================\033[1;37m\n";
    }


    $get_attr   = curl_attr('https://randomuser.me/api/?gender=female&nat=us', false, false, false, false);
    $get_email  = curl_attr('http://ese.kr/?pb=6549', false, false, false, false);

    if($get_attr !== false && $get_email !== false && strpos($get_email, 'name="mailbox"') !== false) {
        $res_attr   = json_decode($get_attr, true);
        $first_name = strtolower($res_attr['results']['0']['name']['first']);
        $last_name  = strtolower($res_attr['results']['0']['name']['last']);
        $email      = replace_string('<input type="search" name="mailbox" value="', '"', $get_email);

        echo "\033[1;37m◆ Full Name : " . $first_name . ' ' . $last_name . "\033[1;37m\n";
        echo "\033[1;37m◆ Email     : " . $email . "\033[1;37m\n";
        echo "\033[1;37m◆ Creating  : ";

        $get_fb_cred = curl_attr('https://mbasic.facebook.com/reg/submit/', false, $useragent, true, false);
        if($get_fb_cred !== false  && strpos($get_fb_cred, 'method="post" action="/cookie/consent/') !== false) {
            echo "\033[1;31mProxy Cookies Error\033[1;37m\n";
        } else {
            echo "\n" . $get_fb_cred;
        }
        
    } else {
        echo 'looping';
    }
}

function replace_string($start, $end, $data) {
    $rt = explode($start, $data)[1];
    $rt = explode($end, $rt)[0];
    return $rt;
}

function curl_attr($url, $body, $useragent, $createcookies, $readcookies) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'accept-language: en-US,en;q=0.9',
        'content-type: application/x-www-form-urlencoded',
        'user-agent: ' . $useragent
    ));
    if($body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    if($createcookies) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'tmp.txt');
    }
    if($readcookies) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'tmp.txt');
    }
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
