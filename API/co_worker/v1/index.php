<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ApiToken = 'a24712c674e118915e36e8b0727e4428e1533ff9995b8f520f8b576a00110e70ffd22cd65edcfb9c';

require_once('../../functions.php');
cors_fixed();

header("Content-Type: application/json");
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST,GET,PATCH,PUT,DELETE');
// header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

function verifyExist($body)
{
    $sql = "Select * From researcher Where citizenid = '" . $body["citizenid"] . "'";
    $res = get_result($sql);
    if (count($res) > 0) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = $_GET;
    if (isset($data["method"]) && $data["method"] != "") {
        switch (strtolower($data["method"])) {
            case "view":
                if (isset($data["option"]) && strtolower($data["option"]) === "all") {
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable'";
                } elseif (isset($data["status"]) && strtolower($data["status"]) === "delete") {
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = '" . $data["status"] . "'";
                } elseif (isset($data["option"]) && strlen($data["option"]) && isset($data["proj_id"]) && is_numeric($data["proj_id"])) {
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = '" . $data["option"] . "' AND `cow_ref_id` = " . $data["proj_id"];
                } elseif (isset($data["option"]) && strlen($data["option"])) {
                    $sql = "SELECT * FROM `co_worker` WHERE `cow_status` = 'enable' AND `cow_ref_table` = '" . $data["option"] . "'";
                }
                break;
        }

        $sql .= " Order By cow_id Desc";
        if (isset($data["limit"]) && is_numeric($data["limit"])) $sql .= " limit " . $data["limit"];
        $res = $sql ? get_result($sql) : null;

        if (empty($res) || !$res || !count($res) > 0) {
            http_response_code(203); // notfound
            die(false);
            // die($sql);
        }
        http_response_code(200); // OK
        die($res ? json_encode($res, JSON_UNESCAPED_UNICODE) : $sql);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // token check
    // if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] == $ApiToken) {
    // }
    // $data = $_GET;
    // $body = json_decode(file_get_contents('php://input'), true);
    // if (isset($data["method"]) && $data["method"] != "") {
    //     switch (strtolower($data["method"])) {
    //         case "insert":
    //             if (verifyExist($body)) {
    //                 http_response_code(203); // notfound
    //                 die("Duplicate data");
    //             }
    //             $sql = "INSERT INTO `researcher`(`citizenid`, `techName`, `firstName`, `lastName`, `cv_filename`) VALUES ('" . $body["citizenid"] . "','" . $body["techName"] . "','" . $body["firstName"] . "','" . $body["lastName"] . "','" . $body["cv_filename"] . "')";
    //             die($sql);
    //     }
    // }
} else if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    // token check
    // if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] == $ApiToken) {
    // }
    // $data = $_GET;
    // $body = json_decode(file_get_contents('php://input'), true);
    // if (isset($data["method"]) && $data["method"] != "") {
    //     switch (strtolower($data["method"])) {
    //         case "update":
    //             if (!verifyExist($body)) {
    //                 http_response_code(203); // notfound
    //                 die("Not Exist data");
    //             }
    //             $sql = "UPDATE `researcher` SET `citizenid`='" . $body["citizenid"] . "','techName`='" . $body["techName"] . "','firstName`='" . $body["firstName"] . "','lastName`='" . $body["lastName"] . "','cv_filename`='" . $body["cv_filename"] . "' WHERE `researcher`.`citizenid`='" . $body["citizenid"] . "'";
    //             die($sql);
    //     }
    // }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // token check
    // if (isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] == $ApiToken) {
    // }
    // $data = $_GET;
    // $body = json_decode(file_get_contents('php://input'), true);
    // if (isset($data["method"]) && $data["method"] != "") {
    //     switch (strtolower($data["method"])) {
    //         case "delete":
    //             if (!verifyExist($body)) {
    //                 http_response_code(203); // notfound
    //                 die("Not Exist data");
    //             }
    //             $sql = "DELETE FROM `researcher` WHERE `researcher`.`citizenid`='" . $body["citizenid"] . "'";
    //             die($sql);
    //     }
    // }
} else {
    http_response_code(200); // 405 Method Not Allowed
    die("Method Not Allowed.");
}
