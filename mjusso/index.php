<!DOCTYPE html>
<html lang="en">
<?php
// แก้ไข Client ID ตามที่ได้รับจากการลงทะเบียนไว้
$clientId = '63845c675e46447d8c91cfdf7f1c81e8';
// นำเข้าชุดคำสั่งจากไฟล์ mjusso.php
include_once('mjusso.php');
// หากเข้าระบบสำเร็จข้อมูลจะถูกส่งไปที่ตัวแปร userInfo
// $userInfo;

if ($ac && isset($userInfo) && $userInfo["e_mail"] !== "") {
    $auth_lv = 0;
    if (strtolower($userInfo["e_mail"]) === "umnarj@mju.ac.th" || $userInfo["e_mail"] == "umnarj@mju.ac.th") { // developer
        $auth_lv = 9;
        $homepage = "index.php";
    } elseif (strtolower($userInfo["e_mail"]) == "kanchana_c@mju.ac.th" || $userInfo["e_mail"] == "kanchana_c@mju.ac.th") { // admin Kanchana
        $auth_lv = 9;
        $homepage = "index.php";
        // } elseif ($userInfo["e_mail"] == "3500700050680") { // officer // ?
        //     $auth_lv = 7;
        //     $homepage = "officer.php";
    } elseif (strtolower($userInfo["e_mail"]) == "3570500079277" || $userInfo["e_mail"] == "3570500079277") { // dean SomKiat  // board
        $auth_lv = 5;
        $homepage = "board.php";
    } elseif (strtolower($userInfo["e_mail"]) == "3570500079277" || $userInfo["e_mail"] == "3570500079277") { // econ general member
        $auth_lv = 3;
        $homepage = "member.php";
    } else {
        die('<meta http-equiv="refresh" content="0;url=../src/e401.php?err=ขออภัยท่านไม่ได้รับสิทธิ์เข้าใช้ระบบ">');
    }

    echo strtolower($userInfo["e_mail"]);
    echo "<br/>" . $auth_lv;


    if ($auth_lv < 9) {
        if (($userInfo["facultyId"] != '20500')) {
            // $auth_lv = 1;
            // $homepage = "guest.php";
            echo "The authorize for ECON faculty employee only";
            // die('<meta http-equiv="refresh" content="5;url=../src/e401.php?err=ขออภัยท่านไม่ได้รับสิทธิ์เข้าใช้ระบบ">');
        } else {
            // * view api data
            // print_r($userInfo);
            // $auth_lv = 3;
            // $homepage = "member.php";
        }
    }

    echo "line 48";

    require_once('../core.php');
    // $fnc = new CommonFnc();
    $_SESSION["admin"] = array(
        "citizenId" => $userInfo["citizenID"],
        // "titlePosition" => $fnc->gen_titlePosition_short($userInfo["titlePosition"]),
        "titlePosition" => $userInfo["titleName"],
        "firstName" => $userInfo["firstName"],
        "lastName" => $userInfo["lastName"],
        "titleNameEn" => $userInfo["titleNameEn"],
        "positionEn" => $userInfo["position"],
        "firstName_en" => $userInfo["fistNameEn"],
        "lastName_en" => $userInfo["lastNameEn"],
        "positionTypeId" => null,
        // "personnelPhoto" => str_replace("http://", "https://", $userInfo["personnelPhoto"]),
        "personnelPhoto" => $userInfo["pictureUrl"],
        "email" => $userInfo["e_mail"],
        "homepage" => $homepage,
        "auth_lv" => $auth_lv
    );

    print_r($_SESSION["admin"]);
    echo "<br/><br/>";
    print_r($userInfo);

    if (isset($auth_lv) && $auth_lv > 1 && $_SESSION["admin"]) {
        // echo "you have authentication level data is: ";
        // print_r($_SESSION["admin"]);
        // die('<meta http-equiv="refresh" content="0;url=../admin/">');
        // header("location:../admin/index.php");
        die("<meta http-equiv='refresh' content='3; URL=../admin/index.php'>");
        // die("<meta http-equiv='refresh' content='0; URL=../home/'>");
    } else {
        echo "you have no authorize";
        // die('<meta http-equiv="refresh" content="3;url=../src/e401.php?err=ขออภัยท่านไม่ได้รับสิทธิ์เข้าใช้ระบบ">');
    }
}

// header("Location:" . $url_signout . $clientId);
die("<meta http-equiv='refresh' content='0; URL=".$url_signin . $clientId."'>");

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MJU SSO</title>
    <style>
        body {
            background-color: #2C3E4C;
            font-family: 'Prompt', sans-serif;
            color: antiquewhite;
        }

        .container {
            width: 500px;
            margin: 50px auto;
            padding: 16px;
            border-radius: 8px;
            border: 2px solid #FDAB9F;
            text-align: center;
        }

        a {
            color: #52B2BF;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        a::before {
            content: "[ ";
        }

        a::after {
            content: " ]";
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            color: burlywood;
            letter-spacing: 4px;
        }

        .result {
            word-break: break-all;
            text-wrap: word-break;
        }
    </style>
</head>

<body>
    <div class="container">
    </div>
</body>

</html>