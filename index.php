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

        $data_post_fb_1 = 'jazoest=21010&lsd=AVoW_mG8urc&firstname='.$first_name.'&lastname='.$last_name.'&reg_email__='.$email.'&reg_email_confirmation__='.$email.'&reg_passwd__='.$default_password.'&birthday_month=6&birthday_day=17&birthday_year=2000&birthday_age=&did_use_age=false&sex=1&preferred_pronoun=&custom_gender=&referrer=&asked_to_login=0&use_custom_gender=&terms=on&ns=0&ri=a59d0918-5686-4317-8693-a5e04d86fbb2&action_dialog_shown=&ignore=captcha&locale=en_US&reg_instance=FDZ4Yt2F5Ox40hlUyTPjr2hy&captcha_persist_data=AZnX6XWahCqfrjQVDoaEWbXu-a5vO6sh3EaHnm3r9zYrBbYvDdRaExNahkUKfkzCnInxgtuqliBDB_IEu60k3eTObDaZ8T4bEMlUs8VuwfitoAdyDRSIzyaSIoo-0QWwkE6HWgoZKwE-ZIDcGIiCWpIz8MBEI1K-m3iWurdxIG0JmaEbqZIGjiFUxPh_Sf8DSA85HnhDFXF1G99W_y4sdJ5IRiw6Y437E84s5jAkYHoLUVWHVcEc6EE6TcY7tbLWgDSXX3agAr1JkGBdhkN49ttQuLblX_rngfKuK3wRVvSdFnApi0uK0C6GlgQGfege8m5uAyMXnkjHXYlR6aavgySmaqB8TBgrqpECrX93DVTyWjfCft0oscR78oUPR0mlUAc&captcha_response=&__user=0&__a=1&__dyn=7xe6FomK36Q5E5ObwKBWo5O12wAxu13wqovzEdEc8uw9-3K4o1j8hwem0nCq1ewcG0KEswaq0yE5ufz81sbzo5-0me2218w5uwbO7E2swdq0Ho2ewnE3fw5rwSyE1582ZwrU&__csr=&__req=e&__hs=19120.BP%3ADEFAULT.2.0.0.0.&dpr=1&__ccg=EXCELLENT&__rev=1005474943&__s=zcwah1%3Asbumph%3Awvnqbj&__hsi=7095480681922732001-0&__comet_req=0&__spin_r=1005474943&__spin_b=trunk&__spin_t=1652045334';
        $post_fb_1 = curl_attr_fb('https://www.facebook.com/ajax/register.php', $data_post_fb_1, true, false);
        echo $post_fb_1;
        //if($post_fb_1) {
        //    $get_fb_2 = curl_attr_fb('https://m.facebook.com/login/save-device/', false, false, true);
        //    echo $get_fb_2;
        //}
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
        'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36'
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
