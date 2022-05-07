<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik123';
//$useragent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36 OPR/82.0.4227.50";
$useragent = "Mozilla/5.0(iPad; U; CPU OS 4_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F191 Safari/6533.18.5";
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

            $data_post_fb_1 = 'lsd=AVqPBn3ZyUw&jazoest=2986&ccp=2&reg_instance=nQV3YlKCtEeZGyj01pbSvcJS&submission_request=true&helper=&reg_impression_id=5827eca6-e38b-402b-af9c-bb7c0c06796c&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname='.$first_name.'+'.$last_name.'&reg_email__='.$email.'&sex=1&custom_gender=&did_use_age=false&birthday_day=7&birthday_month=5&birthday_year=2000&age_step_input=&reg_passwd__='.$default_password.'&submit=Sign+Up';
            $post_fb_1 = curl_attr('https://mbasic.facebook.com/reg/submit/?cid=103', $data_post_fb_1, $useragent, false, false);
            echo $post_fb_1;
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
        //'content-type: application/x-www-form-urlencoded',
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
