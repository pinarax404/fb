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
    
    $data = 'jazoest=2998&lsd=AVrxld3BVSw&firstname=anna&lastname=zaza&reg_email__='.$mail.'&reg_email_confirmation__='.$mail.'&reg_passwd__=badaklepas123&birthday_day=6&birthday_month=5&birthday_year=2002&birthday_age=&did_use_age=false&sex=1&preferred_pronoun=&custom_gender=&referrer=&asked_to_login=0&use_custom_gender=&terms=on&ns=0&ri=b3226a2c-5845-408c-abf9-5b80bf2cf7aa&action_dialog_shown=&ignore=captcha&locale=en_GB&reg_instance=HI11Ypj22hrTxWLR734IvG6A&captcha_persist_data=AZly9U7w1IJH3TvBiB7ZwzGN0fn1am5atggZSoQiVvpxNmiSTZZ2J_Hn96-7uPbMTF-J7E7XmRTMJ67j3AZMY07XDX6zWAQLphnXT55-gIeHnv6zTm0Dp9q3CmjkWfp6LnKq3srlZnc0Ob1zED5ti7O0yG7MUmhmWoKPqMataO8kiy3VXZDIElAh10jD3LzDM6wtrx5kKRikZTgN8kpJZs5S3WXT1MaXHtX8WrpNnOQlFjpMXu89X7jBdI7xaAVx4T6tqK5AsveH_St4FUXSk6h1_opURN9xfmQUYzT2N7a5d-zLOlenh6vkJvnNXG3tBoKCpZsEuTTu-ZlGFV_SuOuqabj9hz3-VG9vVosO3vnaUs-xXbUaxLHc5exms0Fdv40&captcha_response=&__user=0&__a=1&__dyn=7xe6FomK36Q5E5ObwKBWo5O12wAxu13wqovzEdEc8uw9-3K4o1j8hwem0nCq1ewcG0KEswaq0yE5ufz81sbzo5-0me2218w5uwbO7E2swdq0Ho2ewnE3fw5rwSyE1582ZwrU&__csr=&__req=9&__hs=19118.BP%3ADEFAULT.2.0.0.0.&dpr=1&__ccg=EXCELLENT&__rev=1005467977&__s=gabrkb%3A2lvqx2%3Ahl4tsw&__hsi=7094739152151910489-0&__comet_req=0&__spin_r=1005467977&__spin_b=trunk&__spin_t=1651872683';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.facebook.com/ajax/register.php');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'content-type: application/x-www-form-urlencoded',
        'user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_8_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/18H107 [FBAN/FBIOS;FBDV/iPhone8,1;FBMD/iPhone;FBSN/iOS;FBSV/14.8.1;FBSS/2;FBID/phone;FBLC/da_DK;FBOP/5]'
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
    
    if(strpos($respons_data, 'href="/checkpoint/') !== false) {
        echo 'Checkpoint' . "\n";
    } else {
        echo $respons_data;
    }
}
