<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,PATCH,PUT,DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
$ApiToken = 'a24712c674e118915e36e8b0727e4428e1533ff9995b8f520f8b576a00110e70ffd22cd65edcfb9c';

// if (isset($_SERVER['REQUEST_METHOD']) && isset($_SERVER['HTTP_AUTHORIZATION']) && $_SERVER['HTTP_AUTHORIZATION'] == $ApiAuthToken) {
require('../function.php');
$fnc = new Api_Function;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // $data = file_get_contents('php://input');
    // $data = json_decode($data, true);
    $data = $fnc->getApiData();
    // echo $data ? print_r($data) : "failed";

    if (!isset($data['code'])) {
        $sql = "SELECT * FROM activities WHERE act_category != 'test'";

        if (isset($data["owner"]) && $data["owner"] != "") {
            $sql .= " AND act_owner = '" . $data["owner"] . "'";
        }
        if (isset($data["status"]) && $data["status"] != "") {
            if (strpos($data["status"], ",")) {
                $categories = explode(",", $data["status"]);
                $sql_status = [];
                foreach ($categories as $cate) {
                    array_push($sql_status, "act_status LIKE '%" . $cate . "%'");
                }
                $sql_status = implode(" OR ", $sql_status);
                $sql .= " AND (" . $sql_status . " )";
            } else {
                $sql .= " AND act_status LIKE '%" . $data["status"] . "%'";
            }
            // $sql .= " AND act_status = '" . $data["status"] . "'";
        } else {
            $sql .= " AND act_status = 'enable'";
        }
        if (isset($data["category"]) && $data["category"] != "") {
            if (strpos($data["category"], ",")) {
                $categories = explode(",", $data["category"]);
                $sql_categories = [];
                foreach ($categories as $cate) {
                    array_push($sql_categories, "act_category LIKE '%" . $cate . "%'");
                }
                $sql_categories = implode(" OR ", $sql_categories);
                $sql .= " AND (" . $sql_categories . " )";
            } else {
                $sql .= " AND act_category LIKE '%" . $data["category"] . "%'";
            }
        }
        if (isset($data["tag"]) && $data["tag"] != "") {
            if (strpos($data["tag"], ",")) {
                $tags = explode(",", $data["tag"]);
                $sql_tags = [];
                foreach ($tags as $tag) {
                    array_push($sql_tags, "act_tag LIKE '%" . $tag . "%'");
                }
                $sql_tags = implode(" OR ", $sql_tags);
                $sql .= " AND (" . $sql_tags . " )";
            } else {
                $sql .= " AND act_tag LIKE '%" . $data["tag"] . "%'";
            }
        }
        $sql .= " ORDER BY act_date DESC";
        if (isset($data["limit"]) && $data["limit"] > 0) {
            $sql .= " LIMIT " . $data["limit"];
        }
    } else {
        $sql = "SELECT * FROM activities WHERE act_code = '" . $data['code'] . "'";
        if ($result = $fnc->getQuery($sql)) {
            $sql_image = "SELECT * FROM image_gallery WHERE act_id = " . $result[0]["act_id"];
            $result[0]["act_gallery"] = $fnc->getQuery($sql_image);

            http_response_code(200);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            // $fnc->success200OK($result);
        } else {
            echo $sql;
            $fnc->failed200NoContent();
        }
        die();
    }


    if ($result = $fnc->getQuery($sql)) {
        // if (count($result) == 1) {
        //     $result = $result[0];
        // }
        http_response_code(200);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        // $fnc->success200OK($result);
    } else {
        echo $sql;
        $fnc->failed200NoContent();
    }





    // if () {}
    // $data = $fnc->getApiData();

} else {
    echo "400";
    $fnc->failed400BadRequest();
}
// } else {
//     echo "401";
//     $fnc->failed401Unauthorized();
// }
