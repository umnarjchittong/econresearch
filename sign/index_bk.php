<?php
require_once('../core.php');
require_once('../plugins/nusoap.php');

if (isset($_GET["p"]) && $_GET["p"] = "signout") {
    $_SESSION["admin"] = NULL;
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header("location:https://econ.mju.ac.th/academicservice/home/");
}

// * Setup the initial config
$WebToken = "95db669a55c0406c881eca261eae50e9"; // dev mode
$AuthPath = "https://passport.mju.ac.th?W=" . $WebToken;
$SignInSuccess_URL = "../admin/";
$SignInFailure_URL = "https://econ.mju.ac.th/academicservice/home/";

// * Check for request parameter
if (empty($_REQUEST["T"])) {
    // * If no parameter to the sign in form
    die("<meta http-equiv='refresh' content='0; URL=$AuthPath'>");
} else {
    // * If I get a parameter, Set the parameter get the PID    
    $SoapClient = new nusoap_client('https://passport.mju.ac.th/login.asmx?wsdl', true);
    $response = $SoapClient->call('CitizenID', array('WebsiteToken' => $WebToken, 'LoginToken' => $_GET["T"]));
    if ($response["CitizenIDResult"]) {
        $pid = $response["CitizenIDResult"];
    } else {
        die("<meta http-equiv='refresh' content='0; URL=$AuthPath'>");
    }

    if ($pid) {
        // * Using PID get the API information
        // echo "pid: " . $pid;
        $MJU_API = new MJU_API();
        $API_URL = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/" . $pid;
        $api_array = $MJU_API->GetAPI_array($API_URL)[0];
        if ($api_array["citizenId"] == "3500700238956") { // developer
            $auth_lv = 9;
            $homepage = "index.php";
        } elseif ($api_array["citizenId"] == "3500700050680") { // admin Kanchana
            $auth_lv = 9;
            $homepage = "index.php";
        // } elseif ($api_array["citizenId"] == "3500700050680") { // officer // ?
        //     $auth_lv = 7;
        //     $homepage = "officer.php";
        } elseif ($api_array["citizenId"] == "3570500079277") { // dean SomKiat  // board
            $auth_lv = 5;
            $homepage = "board.php";
        } else { // econ general member
            $auth_lv = 3;
            $homepage = "member.php";
        }
        // if (($api_array["facultyId"] != '20500' || $api_array["positionTypeId"] != "ก") && $auth_lv < 9) {\
        if ($auth_lv < 9) {
            if (($api_array["facultyId"] != '20500')) {
                // $auth_lv = 1;
                // $homepage = "guest.php";
                echo "The authorize for ECON faculty employee only";
                die('<meta http-equiv="refresh" content="5;url=../e401.php?err=ขออภัยท่านไม่ได้รับสิทธิ์เข้าใช้ระบบ">');
            } else {
                // * view api data
                // print_r($api_array);
                // $auth_lv = 3;
                // $homepage = "member.php";
            }
        }
        $fnc = new CommonFnc();
        $_SESSION["admin"] = array(
            "citizenId" => $api_array["citizenId"],
            // "titlePosition" => $fnc->gen_titlePosition_short($api_array["titlePosition"]),
            "titlePosition" => $api_array["titlePosition"],
            "firstName" => $api_array["firstName"],
            "lastName" => $api_array["lastName"],
            "titleNameEn" => $api_array["titleNameEn"],
            "positionEn" => $api_array["positionEn"],
            "firstName_en" => $api_array["fistNameEn"],
            "lastName_en" => $api_array["lastNameEn"],
            "positionTypeId" => $api_array["positionTypeId"],
            "personnelPhoto" => str_replace("http://", "https://", $api_array["personnelPhoto"]),
            "homepage" => $homepage,
            "auth_lv" => $auth_lv
        );

        if (isset($auth_lv) && $auth_lv > 0 && $_SESSION["admin"]) {
            // echo "you have authentication level data is: ";
            // print_r($_SESSION["admin"]);
            // header("location:index.html");
            die('<meta http-equiv="refresh" content="0;url=../admin/">');
        } else {
            echo "you have no authorize";
            die('<meta http-equiv="refresh" content="3;url=../e401.php?err=ขออภัยท่านไม่ได้รับสิทธิ์เข้าใช้ระบบ">');
        }
    } else {
        echo "your info is not founded";
        die('<meta http-equiv="refresh" content="3;url=../e401.php?err=ระบบไม่พบข้อมูลของท่าน โปรดติดต่อผู้ดูแลระบบ Kanchana_c@mju.ac.th">');
    }
}
