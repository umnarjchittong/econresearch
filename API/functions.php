<?php

function open_conn()
{
    $mysql_server = "10.1.245.45";
    $mysql_user = "econ_research";
    $mysql_pass = "faedadmin";
    $mysql_name = "econ_research";

    $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_name);
    if (mysqli_connect_errno()) {
        // die("Failed to connect to MySQL: " . mysqli_connect_error());
        //   $this->debug_console("MySQL Error!" . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

function get_result($sql)
{
    $result = open_conn()->query($sql);
    // return $result;
    if (!empty($result)) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return NULL;
}

function sql_execute($sql)
  {
    //$this->open_conn()->query($sql);
    $conn = open_conn();
    $conn->query($sql);
    return $conn->insert_id;
  }

  function sql_execute_multi($sql)
  {
    $conn = open_conn();
    $conn->multi_query($sql);
  }

function cors_fixed()
{
    // Allow from any origin
    if (isset($_SERVER["HTTP_ORIGIN"])) {
        // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    } else {
        //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
        header("Access-Control-Allow-Origin: *");
    }
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 600");    // cache for 10 minutes
    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
        if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
            header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS"); //Make sure you remove those you do not want to support

        if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        //Just exit with 200 OK with the above headers for OPTIONS method
        exit(0);
    }
}

function debug_console($val1, $val2 = null)
{
    // if (!empty($_SESSION["member"]["setting"]) && $_SESSION["member"]["setting"]["setting_debug_show"] && $_SESSION["member"]["auth_lv"] >= 9) {
    if (is_array($val1)) {
        // $val1 = implode(',', $val1);
        $val1 = str_replace(
            chr(34),
            '',
            json_encode($val1, JSON_UNESCAPED_UNICODE)
        );
        $val1 = str_replace(chr(58), chr(61), $val1);
        $val1 = str_replace(chr(44), ', ', $val1);
        $val1 = 'Array:' . $val1;
    }
    if (is_array($val2)) {
        // $val2 = implode(',', $val2);
        $val2 = str_replace(
            chr(34),
            '',
            json_encode($val2, JSON_UNESCAPED_UNICODE)
        );
        $val2 = str_replace(chr(58), chr(61), $val2);
        $val2 = str_replace(chr(44), ', ', $val2);
        $val2 = 'Array:' . $val2;
    }
    if (isset($val1) && isset($val2) && !is_null($val2)) {
        echo '<script>console.log("' .
            $val1 .
            '\\n' .
            $val2 .
            '");</script>';
    } else {
        echo '<script>console.log("' . $val1 . '");</script>';
    }
}
?>