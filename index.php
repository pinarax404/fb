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
    
    $data = 'lsd=AVrxld3BMYY&jazoest=2965&ccp=2&reg_instance=HI11Ypj22hrTxWLR734IvG6A&submission_request=true&helper=&reg_impression_id=839c9f18-db27-44b8-8244-b38e9098f0ae&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname='.$name.'&reg_email__='.$mail.'&sex=1&custom_gender=&did_use_age=false&birthday_day=6&birthday_month=5&birthday_year=1999&age_step_input=&reg_passwd__=badaklepas&submit=Sign+Up';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/reg/submit/?cid=103');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded',
        'user-agent: Mozilla/5.0 (Linux; Android 8.1.0; DRA-L01 Build/HUAWEIDRA-L01; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.127 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/364.0.0.24.132;]'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesfb.txt');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo $respons_data;
}
