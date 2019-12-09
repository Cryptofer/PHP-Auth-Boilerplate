<?php

require_once('assets/inc/global.functions.php');
require_once('assets/inc/session.class.php');
require_once('assets/inc/account.class.php');


$account = new Account();

if(isset($_GET['action']) && $_GET['action'] == "logout") {
    $account->destroySession();
}

$Session = new Session();
if($Session->isActive()) {
    Header("Location: index.php");
    exit;
}

$errorMessage = "";

if(isset($_GET['action']) && $_GET['action'] === "register") {

    $required = array('username', 'password', 'confirm_password');
    $error = false;
    foreach($required as $field) {
        if (!isset($_POST[$field]) ||empty($_POST[$field])) {
            $error = true;
        }
    }

    if(!$error) {
        $register = $account->Register($_POST['username'], $_POST['password'], $_POST['confirm_password']);
        if($register[0]) {
            Header("Location: index.php");
        } else {
            $errorMessage = $register[1];
        }
    } else {
        $errorMessage = "Please fill all fields!";
    }

    include "assets/inc/views/authentication/register.php";
}

if(isset($_POST['do_action']) && $_POST['do_action'] === "login") {
    $required = array('username', 'password');
    $error = false;
    foreach($required as $field) {
        if (!isset($_POST[$field]) ||empty($_POST[$field])) {
            $error = true;
        }
    }

    if(!$error) {
        if($account->Login($_POST['username'], $_POST['password'])) {
            Header("Location: index.php");
        } else {
            $errorMessage = "Invalid username or password!";
        }
    } else {
        $errorMessage = "Please fill all fields!";
    }
}

include "assets/inc/views/authentication/login.php";

?>