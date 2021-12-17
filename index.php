<?php

function rplc_mode_create($start, $end, $data) {
    $rt = explode($start, $data)[1];
    $rt = explode($end, $rt)[0];
    return $rt;
}


function pinarax_curl($url, $data, $httpheader, $cookies, $csrftoken, $showresult, $useragent) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($httpheader == 'default_ig') {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: */*',
            'accept-language: en-US,en;q=0.9',
            'content-type: application/x-www-form-urlencoded',
            'x-asbd-id: 198387',
            'x-csrftoken: ' . $csrftoken,
            'x-ig-app-id: 1217981644879628',
            'x-ig-www-claim: 0',
            'x-instagram-ajax: 4a7c22e38c59'
        ));
    }
    if($httpheader == 'default_ig_cookies') {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: */*',
            'accept-language: en-US,en;q=0.9',
            'content-type: application/x-www-form-urlencoded',
            'x-asbd-id: 198387',
            'x-mid: 72y6ve1v8ijga13eibrz9telb3133ynta16xh76xa0vz4e1q1yfmt',
            'x-ig-app-id: 1217981644879628',
            'x-ig-www-claim: 0',
            'x-instagram-ajax: 4a7c22e38c59'
        ));
    }
    if($showresult == 'respons_header') {
        curl_setopt($ch, CURLOPT_HEADER, true);
    } else {
        curl_setopt($ch, CURLOPT_HEADER, false);
    }
    if($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    if($cookies) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'tmp/cookiesig.txt');
    } else {
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'tmp/cookiesig.txt');
    }
    if($useragent) {
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 4.2.2; en-us; SAMSUNG DUOS Build/JDQ39) AppleWebKit/535.19 (KHTML, like Gecko) Version/1.0 Chrome/28.0.1025.308 Mobile Safari/535.19');
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($respons_http_code == 200) {
        if($showresult == 'respons_data') {
            return $respons_data;
        } else if($showresult == 'respons_header') {
            return $respons_header;
        }
    } else {
        return false;
    }
}
