<?php

//ini_set('display_errors', "0");

echo 'Email :' . PHP_EOL;
$mailid = fopen('php://stdin', 'rb');
$mail = fgets($mailid);
if(trim($mail) !== null) {
    echo 'Name :' . PHP_EOL;
    $nameid = fopen('php://stdin', 'rb');
    $name = fgets($nameid);
    if(trim($name) !== null) {
        php_ajax(trim($mail), trim($name));
    } else {
        die();
    }
} else {
    die();
}

function php_ajax($mail, $name1) {
    
    $data = 'lsd=AVrzaUa2khY&jazoest=21016&ccp=2&reg_instance=Xi92YmDws84GGNBn4Lqqfmdb&submission_request=true&helper=&reg_impression_id=818c417c-2220-427e-91a5-1aad57f1b6c4&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname='.$name1.'+&lastname='.$name1.'&reg_email__='.$mail.'&sex=1&custom_gender=&did_use_age=false&birthday_month=5&birthday_day=7&birthday_year=2002&age_step_input=&reg_passwd__=badaklepas&submit=Sign+Upp';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/reg/submit/?cid=103');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded',
        'user-agent: Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesfb.txt');
    //curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookiesfb.txt');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if(strpos($respons_data, 'action="/checkpoint/') == true) {
        echo 'Checkpoint' . "\n";
    } else {
        echo $respons_data;
    }
}
