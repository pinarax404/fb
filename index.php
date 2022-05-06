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

function php_ajax($mail, $name) {
    
    $data = 'lsd=&jazoest=2910&ccp=2&reg_instance=&submission_request=true&helper=&reg_impression_id=&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname='.$name.'&reg_email__='.$mail.'&sex=1&custom_gender=&did_use_age=false&birthday_day=10&birthday_month=1&birthday_year=2002&age_step_input=&reg_passwd__=badaklepas111&submit=Sign+Up';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/reg/submit/?cid=103');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded',
        'user-agent: Mozilla/5.0 (Linux; U; Android 4.4.2; id; SM-G900 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.9.2.467 U3/0.8.0 Mobile Safari/534.30'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesfb.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookiesfb.txt');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if(strpos($respons_data, 'href="checkpoint') !== false) {
        echo 'Checkpoint' . "\n";
    } else {
        echo $respons_data;
    }
}
