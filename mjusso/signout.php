<?php
if ($_SERVER["HTTP_HOST"] === "localhost") {
    $_SESSION["admin"] = NULL;
// remove all session variables
session_unset();
// destroy the session
session_destroy();
    die("<meta http-equiv='refresh' content='0; URL=../'>");
    // header("location:../admin/");
}


// แก้ไข Client ID ตามที่ได้รับจากการลงทะเบียนไว้
$clientId = '63845c675e46447d8c91cfdf7f1c81e8';
// นำเข้าชุดคำสั่งจากไฟล์ mjusso.php
include_once('mjusso.php');
// หากเข้าระบบสำเร็จข้อมูลจะถูกส่งไปที่ตัวแปร userInfo
// $userInfo;

$_SESSION["admin"] = NULL;
// remove all session variables
session_unset();
// destroy the session
session_destroy();

header("location:" . $url_signout . $clientId);

