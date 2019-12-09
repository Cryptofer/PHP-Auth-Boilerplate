<?php

/*
    General Server Configurations
*/

date_default_timezone_set('Europe/Helsinki');
header('Content-Type: text/html; charset=utf-8');

/*
    Database Configuration
*/
$config['database']['host'] = 'localhost';
$config['database']['name'] = 'savate_payments';
$config['database']['username'] = 'root';
$config['database']['password'] = '';

//ini_set('display_errors', 1);

$db = new mysqli($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['name']);
if ($db->connect_errno) {
    die($db->connect_errno);
}

?>