<?php

//ini_set('display_errors', "0");
system('clear');

soot_start();

function soot_start() {


//********************//
$default_password = 'buyung_upik123';
//$useragent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36 OPR/82.0.4227.50";
//$useragent = "Mozilla/5.0(iPad; U; CPU OS 4_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F191 Safari/6533.18.5";
//********************//


    $get_ip     = curl_attr('https://ipwhois.app/json/');
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


    $get_attr   = curl_attr('https://randomuser.me/api/?gender=female&nat=us');
    $get_email  = curl_attr('http://ese.kr/?pb=6549');

    if($get_attr !== false && $get_email !== false && strpos($get_email, 'name="mailbox"') !== false) {
        $res_attr   = json_decode($get_attr, true);
        $first_name = strtolower($res_attr['results']['0']['name']['first']);
        $last_name  = strtolower($res_attr['results']['0']['name']['last']);
        $email      = replace_string('<input type="search" name="mailbox" value="', '"', $get_email);

        echo "\033[1;37m◆ Full Name      : " . $first_name . ' ' . $last_name . "\033[1;37m\n";
        echo "\033[1;37m◆ Email          : " . $email . "\033[1;37m\n";
        echo "\033[1;37m◆ Proxy Cookies  : ";

        $data_post_fb_1 = 'ccp=2&reg_instance=yw93YjkTXCbmRNdeFWItVUd9&submission_request=true&helper=&reg_impression_id=e1166f9a-6a81-4386-a202-e9fb652ed7c8&ns=1&zero_header_af_client=&app_id=103&logger_id=fdcfe35e-ca82-4bdd-8e49-92f4c2799e9d&field_names%5B0%5D=firstname&firstname='.$first_name.' '.$last_name.' '.$last_name.'&field_names%5B1%5D=birthday_wrapper&birthday_day=7&birthday_month=5&birthday_year=1998&age_step_input=&did_use_age=false&field_names%5B2%5D=reg_email__&reg_email__='.$email.'&field_names%5B3%5D=sex&sex=1&preferred_pronoun=&custom_gender=&field_names%5B4%5D=reg_passwd__&reg_passwd__=badaklepas123&name_suggest_elig=false&was_shown_name_suggestions=false&did_use_suggested_name=false&use_custom_gender=false&guid=&encpass=&submit=Sign%20Up&fb_dtsg=AQHLShKh4QXutQc%3A0%3A0&jazoest=21506&lsd=AVpGJPj5qhw&__dyn=1Z3paBwk8nxe14z-l0BBBg9odE4a2i5U4e0C86u7E39x64o7S0PEhwem0iy1gCwjE1xolwaS0UE-0nSUS0se229w4NwqU2YxW0D81x82ew4Kwww5NyE1582ZwrU&__csr=&__req=d&__a=AYl03ILgQxWAmqBcKH4Y9_iksmfRLv9DiZPcOnUkX6Ma5GlH9WLK__J6AYO2tuwJsKFS-B0epIhcUNh1YfTtWRGbHbhGU11MVQxZC_mr4PjQmw&__user=0';
        $post_fb_1 = curl_attr_fb('https://m.facebook.com/reg/submit/', $data_post_fb_1, true, false);
        if($post_fb_1) {
            $get_fb_2 = curl_attr_fb('https://m.facebook.com/login/save-device/', false, false, true);
            echo $get_fb_2;
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

function curl_attr($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
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

function curl_attr_fb($url, $body, $createcookies = false, $readcookies = false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded',
        'user-agent: Mozilla/5.0(iPad; U; CPU OS 4_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8F191 Safari/6533.18.5'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if($body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    if($createcookies) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'tmp.txt');
    }
    if($readcookies) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'tmp.txt');
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
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
