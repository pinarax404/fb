<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik';
$useragent = "Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19";
//********************//


    $get_ip     = curl_attr('https://ipwhois.app/json/', false, false);
    $get_attr   = curl_attr('https://randomuser.me/api/?gender=female&nat=us', false, false);
    $get_email  = curl_attr('http://ese.kr/?pb=6549', false, false);

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

        echo "\033[1;37m◆ Full Name : " . $first_name . ' ' . $last_name . "\033[1;37m\n";
        echo "\033[1;37m◆ Email     : " . $email . "\033[1;37m\n";
        echo "\033[1;37m◆ Creating  : ";

        $data_post_create_1 = 'lsd=AVrzaUa2khY&jazoest=21016&ccp=2&reg_instance=Xi92YmDws84GGNBn4Lqqfmdb&submission_request=true&helper=&reg_impression_id=818c417c-2220-427e-91a5-1aad57f1b6c4&ns=0&zero_header_af_client=&app_id=&logger_id=&field_names%5B%5D=firstname&field_names%5B%5D=reg_email__&field_names%5B%5D=sex&field_names%5B%5D=birthday_wrapper&field_names%5B%5D=reg_passwd__&firstname='.$first_name.'+&lastname='.$first_name.'&reg_email__='.$email.'&sex=1&custom_gender=&did_use_age=false&birthday_month=5&birthday_day=7&birthday_year=2002&age_step_input=&reg_passwd__='.$default_password.'&submit=Sign+Upp';
        $post_create_1 = curl_attr('https://mbasic.facebook.com/reg/submit/?cid=103', $data_post_create_1, $useragent);
        echo "\n" . $post_create_1;
        
        
    } else {
        echo 'looping';
    }
}

function replace_string($start, $end, $data) {
    $rt = explode($start, $data)[1];
    $rt = explode($end, $rt)[0];
    return $rt;
}

function curl_attr($url, $body, $useragent) {
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
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesfb.txt');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $respons_data = curl_exec($ch);
    $respons_header = substr($respons_data, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $respons_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $respons_data;

    //if($respons_http_code == 200) {
    //    return $respons_data;
    //} else {
    //    return false;
    //}
}
