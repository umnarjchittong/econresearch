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
            case "byear":
                $sql = "Select Year(proj_period_begin) As b_year From project Where proj_status = 'enable' Group By Year(proj_period_begin) Order by proj_period_begin Desc";
                $res = get_result($sql);

            case "view":
                if (isset($data["option"]) && strtolower($data["option"]) === "all") {
                    $sql = "Select * From researcher";
                    $sql .= " Order By researcher.firstName, researcher.lastName";
                    if (isset($data["limit"]) && is_numeric($data["limit"])) {
                        $sql .= " Limit " . $data["limit"];
                    }
                    // die($sql);
                    $res = get_result($sql);
                } elseif (isset($data["option"]) && strlen($data["option"])) {
                    $sql = "Select * From researcher Where researcher.firstName LIKE '%" . strtolower($data["option"]) . "%' OR researcher.lastName LIKE '%" . strtolower($data["option"]) . "%'";
                    $sql .= " Order By researcher.firstName, researcher.lastName";
                    if (isset($data["limit"]) && is_numeric($data["limit"])) {
                        $sql .= " Limit " . $data["limit"];
                    }
                    // die($sql);
                    $res = get_result($sql);
                } else {
                    isset($data["status"]) && $data["status"] != "" ? $data_status = $data["status"] : $data_status = "enable";
                    $sql = "Select proj.* From project proj Left Join co_worker cowo On cowo.cow_ref_id = proj.proj_id Where proj.proj_status Like '" . $data_status . "'";
                    if (isset($data["limit"]) && is_numeric($data["limit"])) {
                        $sql .= " Limit " . $data["limit"];
                    }
                    $sql_year = "";
                    if (isset($data["byear"]) && is_numeric($data["byear"])) {
                        $sql_year = " AND Year(proj.proj_period_begin) LIKE '" . $_GET["byear"] . "'";
                    }
                    // $sql_group = " Group By proj.proj_period_begin, proj.proj_id";
                    // $sql_order = " Order By proj.proj_period_begin Desc"; // order
                    $sql .= $sql_year;
                    // die($sql);
                    $res = get_result($sql);
                }

        }

        if (empty($res) || !$res || !count($res)) {
            http_response_code(204); // notfound
            die($sql);
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
