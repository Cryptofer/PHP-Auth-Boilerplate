<?php


require_once('assets/inc/global.functions.php');
require_once('assets/inc/session.class.php');
require_once('assets/inc/paginator.class.php');
require_once('assets/inc/registrations.class.php');
require_once('assets/inc/payment.class.php');

$Session = new Session();
if(!$Session->isActive()) {
    Header("Location: member.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <title>Auth Boilerplate</title>
</head>
<body>
    <div class="header">
        <div class="heading-top">
            <div class="wrapper">
                <img src="assets/images/logo.svg" alt="Logo" class="logo" />
                <div class="header-navigation">
                    <a href="member.php?action=logout">Sign Out</a>
                </div>
            </div>
        </div>
        <div class="navigation">
            <div class="wrapper">
                <ul>
                    <li><a href="#" class="active">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content wrapper">
        <div class="content-heading">
            <h1>Member Section</h1>
        </div>
        <div class="panel">
            Only members are able to view this page.
        </div>
    </div>
</body>
</html>