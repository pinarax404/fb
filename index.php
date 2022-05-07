<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik';
$useragent = "Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19";
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

        $get_accept_cookies = curl_attr('https://mbasic.facebook.com/reg/submit/', false, $useragent, true, false);
        if($get_accept_cookies !== false  && strpos($get_accept_cookies, 'method="post" action="https://mbasic.facebook.com/reg/submit/"') !== false) {
            echo "\033[1;32mTrue\033[1;37m\n";
            echo "\033[1;37m◆ Create Account : ";

            $reg_instance = replace_string('name="reg_instance" value="', '"', $get_accept_cookies);
            $reg_impression_id = replace_string('name="reg_impression_id" value="', '"', $get_accept_cookies);

            $data_post_fb_1 = 'lsd=AVqE8qtLi3M&jazoest=2927&ccp=2&reg_instance='.$reg_instance.'&submission_request=true&helper=&reg_impression_id='.$reg_impression_id.'&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names[]=firstname&field_names[]=reg_email__&field_names[]=sex&field_names[]=birthday_wrapper&field_names[]=reg_passwd__&firstname='.$first_name.'&lastname='.$last_name.'&reg_email__='.$email.'&sex=1&preferred_pronoun=1&custom_gender=&did_use_age=false&birthday_day=12&birthday_month=10&birthday_year=1999&age_step_input=&reg_passwd__='.$default_password.'&submit=Sign+Up';
            $post_fb_1 = curl_attr('https://mbasic.facebook.com/reg/submit/', $data_post_fb_1, $useragent, false, false);
            if($post_fb_1 !== false && strpos($post_fb_1, 'method="post" action="/checkpoint/') !== false) {
                echo "\033[1;31mCheckpoint\033[1;37m\n";
                soot_start();
            } else if($post_fb_1 !== false && strpos($post_fb_1, 'svsvsvsv') !== false) {
                
            } else {
                echo "\033[1;32mCreate Success\033[1;37m\n";
                echo $post_fb_1;
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
