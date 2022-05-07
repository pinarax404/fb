<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik123';
$useragent = "Mozilla/5.0 (iPhone; CPU iPhone OS 13_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 Instagram 123.1.0.26.115 (iPhone11,8; iOS 13_3; en_US; en-US; scale=2.00; 828x1792; 190542906)";
//$useragent = "Mozilla/5.0(iPad; U; CPU OS 4_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F191 Safari/6533.18.5";
//********************//


    $get_ip     = curl_attr('https://ipwhois.app/json/', false, false, false, false);
    if($get_ip !== false) {
        $res_ip = json_decode($get_ip, true);
        echo "\033[1;37m========================================\033[1;37m\n";
        echo "\033[1;37mIP : " . $res_ip['ip'] . " | Country : " . $res_ip['country'] . "\033[1;37m\n";
        echo "\033[1;37m========================================\033[1;37m\n";
    } else {
        echo "\033[1;37m========================================\033[1;37m\n";
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

        echo "\033[1;37m◆ Full Name      : " . $first_name . ' ' . $last_name . "\033[1;37m\n";
        echo "\033[1;37m◆ Email          : " . $email . "\033[1;37m\n";
        echo "\033[1;37m◆ Proxy Cookies  : ";

        $get_accept_cookies = curl_attr('https://mbasic.facebook.com/reg/', false, $useragent, true, false);
        if($get_accept_cookies !== false  && strpos($get_accept_cookies, 'method="post" action="https://mbasic.facebook.com/reg/submit/"') !== false) {
            echo "\033[1;32mTrue\033[1;37m\n";
            echo "\033[1;37m◆ Create Account : ";

            $reg_instance = replace_string('name="reg_instance" value="', '"', $get_accept_cookies);
            $reg_impression_id = replace_string('name="reg_impression_id" value="', '"', $get_accept_cookies);

            $data_post_fb_1 = 'ccp=2&reg_instance=q_Z2Yn6kTVrvM8ckWt26D3kF&submission_request=true&helper=&reg_impression_id=69a4862f-3b8c-4e5c-983a-db982fb1d630&ns=1&zero_header_af_client=&app_id=103&logger_id=c5395e48-ae2f-4ee0-bccd-92ac82523354&field_names%5B0%5D=firstname&firstname='.$first_name.'&lastname='.$last_name.'&field_names%5B1%5D=birthday_wrapper&birthday_day=7&birthday_month=5&birthday_year=2000&age_step_input=&did_use_age=false&field_names%5B2%5D=reg_email__&reg_email__='.$email.'&field_names%5B3%5D=sex&sex=1&preferred_pronoun=&custom_gender=&field_names%5B4%5D=reg_passwd__&reg_passwd__='.$default_password.'&name_suggest_elig=false&was_shown_name_suggestions=false&did_use_suggested_name=false&use_custom_gender=false&guid=&encpass=&fb_dtsg=AQENq-&jazoest=21372&lsd=AVq3f_vTR5c&__dyn=1Z3paBwk8nxe14z-l0BBBg9odE4a2i5U4e0C86u7E39x64o7S0PEhwem0iy1gCwjE1xolwaS0UE-0nSUS0se229w4NwqU2YxW0D81x82ew4Kwww5NyE1582ZwrU&__csr=&__req=h&__a=AYkbXkydaIHZS8_xP5a8YCP4M2Cvz5taaEQiqef7YWrYfBmzzdzoyuvLccJ4Gdj1opnE15rmLKsZt5F3z1RY6tdN-_2QIm4FuzcYS5X92u5Zmg&__user=0';
            $post_fb_1 = curl_attr('https://m.facebook.com/reg/submit/', $data_post_fb_1, $useragent, true, false);
            if($post_fb_1) {
                $get_fb_check = curl_attr('https://m.facebook.com/login/save-device', false, $useragent, false, true);
                echo $get_fb_check;
            } else {
                echo "\033[1;31mFailed...\033[1;37m\n";
                soot_start();
            }
        } else if($get_accept_cookies !== false && strpos($get_accept_cookies, 'method="post" action="/cookie/consent/') !== false) {
            echo "\033[1;31mProxy Cookies Error\033[1;37m\n";
            soot_start();
        } else {
            echo "\033[1;31mFailed...\033[1;37m\n";
            soot_start();
        }
    } else {
        soot_start();
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
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
