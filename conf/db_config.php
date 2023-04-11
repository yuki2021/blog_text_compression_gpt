<?php

// DB接続先
$local_ip = getHostByName(getHostName());
if($local_ip == '') {
    // 本番環境
    $dbConfig = [
        'host' => '',
        'name' => '',
        'username' => '',
        'password' => '',
    ];
} else {
    // テスト環境
    $dbConfig = [
        'host' => '',
        'name' => '',
        'username' => '',
        'password' => '',
    ];
}