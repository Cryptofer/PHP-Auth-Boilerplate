<?php

require_once('config.php');

function escapeString($string) {

    $string = strip_tags($string);
    $string = htmlspecialchars($string);

    return $string;
}

function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function randomLetters($len = 5){
    $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $base = strlen($charset);
    $result = '';
  
    $now = explode(' ', microtime())[1];
    while ($now >= $base){
      $i = $now % $base;
      $result = $charset[$i] . $result;
      $now /= $base;
    }
    return substr($result, -$len);
}

?>