<?php
require_once('../core.php');
require_once('../plugins/nusoap.php');


// * Setup the initial config
$SignInSuccess_URL = "../admin/";
$SignInFailure_URL = "../";

// * Check for request parameter    
$logAs = $_GET["logAs"];
if ($logAs) {
    // * Using PID get the API information
    $MJU_API = new MJU_API();
    $API_URL = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
    switch ($logAs) {
        case "dev":
            $API_URL .= "3500700238956";
            $auth_lv = 9;
            $homepage = "index.php";
            break;
        case "admin":
            $API_URL .= "3500700050680"; // kanchana
            $auth_lv = 9;
            $homepage = "index.php";
            break;
        case "officer":
            $API_URL .= ""; // ?
            $auth_lv = 7;
            $homepage = "officer.php";
            break;
        case "dean":
            $API_URL .= "3570500079277"; // Dean's SomKiat
            $auth_lv = 5;
            $homepage = "board.php";
            break;
        case "Katesuda":
            $API_URL .= "3501400115841"; // member
            $auth_lv = 3;
            $homepage = "member.php";
            break;
        case "Prasert":
            $API_URL .= "3749900310991"; // member
            $auth_lv = 3;
            $homepage = "member.php";
            break;
        default:
            die("not right parameter.");
            break;
    }
    $api_array = $MJU_API->GetAPI_array($API_URL)[0];
    $fnc = new CommonFnc();
    $_SESSION["admin"] = array(
        "citizenId" => $api_array["citizenId"],
        "titlePosition" => $fnc->gen_titlePosition_short($api_array["titlePosition"]),
        "firstName" => $api_array["firstName"],
        "lastName" => $api_array["lastName"],
        "firstName_en" => $api_array["fistNameEn"],
        "lastName_en" => $api_array["lastNameEn"],
        "positionTypeId" => $api_array["positionTypeId"],
        "homepage" => $homepage,
        "auth_lv" => $auth_lv
    );

    if (isset($auth_lv) && $auth_lv > 0 && $_SESSION["admin"]) {
        // echo "you have authentication level data is: ";
        // print_r($_SESSION["admin"]);
        // header("location:index.html");
        // $fnc->debug_console("admin", $_SESSION["admin"]);
        // echo '<meta http-equiv="refresh" content="1;url=' . $SignInSuccess_URL . '">';
        // echo '<meta http-equiv="refresh" content="0;url=../admin/' . $_SESSION["admin"]["homepage"] . '?p=welcome">';
        echo '<meta http-equiv="refresh" content="0;url=../admin/?p=welcome">';
    } else {
        echo "you have no authorize";
        // echo '<meta http-equiv="refresh" content="0;url=https://faed.mju.ac.th/ddm/e401.php?err=ท่านไม่มีสิทธิ์ใช้ระบบนี้">';
    }
} else {
    echo "your info is not founded";
    // echo '<meta http-equiv="refresh" content="0;url=https://faed.mju.ac.th/ddm/e401.php?err=ระบบไม่พบข้อมูลของท่าน โปรดติดต่อฝ่ายไอที umnarj@mju.ac.th">';
}
