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
    
    $data = 'ccp=2&reg_instance=HI11Ypj22hrTxWLR734IvG6A&submission_request=true&helper=&reg_impression_id=15f3c347-dc6c-41a7-84ee-fae0a4719cf7&ns=1&zero_header_af_client=&app_id=&logger_id=3e9c7860-5d63-4c43-bb42-93cc948943bd&field_names%5B0%5D=firstname&firstname='.$name.'&field_names%5B1%5D=birthday_wrapper&birthday_day=6&birthday_month=5&birthday_year=1991&age_step_input=&did_use_age=false&field_names%5B2%5D=reg_email__&reg_email__='.$mail.'&field_names%5B3%5D=sex&sex=1&preferred_pronoun=&custom_gender=&field_names%5B4%5D=reg_passwd__&reg_passwd__=badaklepas123&name_suggest_elig=false&was_shown_name_suggestions=false&did_use_suggested_name=false&use_custom_gender=false&guid=&encpass=%23PWD_BROWSER%3A5%3A1651871787%3AAXRQANWK2zo17X%2B%2BayEY7ZSE7lcjWAgwRf3K%2F61k9lYBe20lDu5kgXs2HBanS0LwmmdoGMCB%2FLO5MX98a2jcOKsbennJ1m%2FccFLafYtysllRwz1Nsaw2hDJxaFatB%2F6zn5n%2BVj1i5piiYEgM9iHZUWI%3D&submit=Sign%20Up&fb_dtsg=AQE1uTS77svP4d4%3A0%3A0&jazoest=21387&lsd=AVrxld3BG9U&__dyn=1Z3paBwk8nxe14z-l0BBBg9odE4a2i5U4e0C86u7E39x64o7S0PEhwem0iy1gCwjE1xolwaS0UE-0nSUS0se229w4NwqU2YxW0D81x82ew4Kwww5NyE1582ZwrU&__csr=&__req=d&__a=AYntOs6wA3MhLefNlCM1w1v6VmGpDmGvMqTVDUAFTtKd06WfpuRw2oJFwHDQdtOup9lsMcWudCOiZcpGAyHKvL6315CNr3UlMnF82sJGl-6EVQ&__user=0';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/reg/submit/');
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
