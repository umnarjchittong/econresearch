<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container my-5 p-5">
        <div class="col-6 mx-auto my-5 p-5 text-center">
            <img src="images/loading.gif" width="50px;">
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
</body>

</html>

<?php
include("core.php");
$fnc = new Web();

// * set so
if (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"]) && isset($_POST["fst"]) && $_POST["fst"] == "ondutyadd" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
    if (is_array($_POST["so_id"])) {
        $sql = "";
        foreach ($_POST["so_id"] as $so_id) {
            if (is_array($_POST["position"])) {
                $priority = explode(",", $_POST["position"][0])[0];
                $position = array();
                for ($i = 0; $i < count($_POST["position"]); $i++) {
                    array_push($position, explode(",", $_POST["position"][$i])[1]);
                }
                $sql .= "INSERT INTO `on-duty` (`match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $so_id . ", " . $priority . ", '" . implode(", ", $position) . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp()); ";
            } else {
                $position = explode(",", $_POST["position"]);
                $sql .= "INSERT INTO `on-duty` (`match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $so_id . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp()); ";
            }
        }
    } else {
        $sql = "INSERT INTO `on-duty` (`match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $_POST["so_id"] . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] . "', current_timestamp())";
    }
    // die($sql);
    $fnc->sql_execute_multi($sql);
    echo '<meta http-equiv="refresh" content="0.0; URL=admin/?p=duty&mid=' . $_GET["mid"] . '&alert=success&msg=บันทึกเรียบร้อย&listview=' . $_GET["listview"] . '" />';
    die();
}

// if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyadd" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
//     $position = explode(",",$_POST["position"]);
//     print_r($_POST["so_id"]);
//     echo "<br>";
//     $sql = "INSERT INTO `on-duty` (`match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES (" . $_POST["mid"] . ", " . $_POST["so_id"] . ", " . $position[0] . ", '" . $position["1"] . "', 'enable', '" . $_SESSION["member"]["so_firstname_en"] ."', current_timestamp())";
//      $fnc->sql_execute($sql);
// die($sql);
// echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=index.php?p=duty&mid=' . $_GET["mid"] . '&alert=success&msg=บันทึกเรียบร้อย" />';
// die();
// }

if (isset($_GET["p"]) && $_GET["p"] == "duty" && isset($_GET["mid"]) && isset($_GET["act"]) && $_GET["act"] == "dutydelete" && isset($_GET["odid"])) {
    // $sql = "DELETE FROM `on-duty` WHERE `on-duty_id` = " . $_GET["odid"];
    $sql = "UPDATE `on-duty` SET `on-duty_status`='delete',`on-duty_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`on-duty_lastupdate`=current_timestamp() WHERE `on-duty_id` = " . $_GET["odid"];
    //  die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=duty&mid=' . $_GET["mid"] . '&alert=info&msg=ลบเรียบร้อย" />';
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "ondutyupdate" && isset($_POST["mid"]) && isset($_POST["so_id"]) && isset($_POST["odid"]) && isset($_POST["position"]) && isset($_POST["submit"])) {
    $position = explode(",", $_POST["position"]);
    $sql = "UPDATE `on-duty` SET `so_id`=" . $_POST["so_id"] . ", `on-duty_priority`=" . $position[0] . ", `on-duty_position`='" . $position[1] . "', `on-duty_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`on-duty_lastupdate`=current_timestamp() WHERE `on-duty_id` = " . $_POST["odid"];
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=duty&mid=' . $_POST["mid"] . '&alert=info&msg=อัพเดทเรียบร้อย" />';
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soregist" && isset($_GET["p"]) && $_GET["p"] == "soregist" && isset($_GET["act"]) && $_GET["act"] == "soregist" && isset($_POST["submit"])) {
    $sql = "SELECT `so_id` FROM `so-member` WHERE `so_citizen_id` LIKE '" . $_POST["citizen_id"] . "' OR `so_email` LIKE '" . $_POST["email"] . "'";
    if (!empty($fnc->get_db_col($sql))) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=guest/register.php?p=exists&alert=danger&msg=ขออภัย...มีการลงทะเบียนด้วยหมายเลขปัตรประชาชน หรืออีเมลนี้แล้ว" />';
        die();
    }

    $auth = 0;
    $sql = "INSERT INTO `so-member` (`so_firstname`, `so_lastname`, `so_firstname_en`, `so_lastname_en`, `so_nickname`, 
    `so_citizen_id`, `so_dob`, `so_email`, `so_auth_lv`, `so_status`, `so_regis_datetime`, `so_editor`) 
    VALUES ('" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["firstname_en"] . "', '" . $_POST["lastname_en"] . "', '" . $_POST["nickname"] .
        "', '" . $_POST["citizen_id"] . "', '" . $_POST["dob"] . "', '" . $_POST["email"] . "', " . $auth . ", 'register', current_timestamp(), '" . $_POST["firstname_en"] . "')";

    // die("so regist sql: <br><br>" . $sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=guest/register.php?p=registered&alert=info&msg=ลงทะเบียนข้อมูล SO เรียบร้อย. โปรด Login เพื่อเข้าสู่ระบบ" />';
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soappend" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soappend" && isset($_POST["so_editor"]) && isset($_POST["submit"])) {
    if ($_POST["idpa_id"] != "") {
        $auth = 3;
    } else {
        $auth = 1;
    }
    $sql = "INSERT INTO `so-member` (`so_idpa_id`, `so_club`, `so_firstname`, `so_lastname`, `so_firstname_en`, `so_lastname_en`, `so_nickname`, 
    `so_citizen_id`, `so_dob`, `so_blood_type`, `so_sex`, `so_address`, `so_subdistrict`, `so_district`, `so_province`, `so_zipcode`, 
    `so_phone`, `so_email`, `so_line_id`, `so_idpa_expire`, `so_license_expire`, `so_pwd`, `so_auth_lv`, `so_status`, `so_regis_datetime`, `so_editor`, `so_lastupdate`) 
    VALUES ('" . strtoupper($_POST["idpa_id"]) . "', '" . $_POST["club"] . "', '" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["firstname_en"] . "', '" . $_POST["lastname_en"] . "', '" . $_POST["nickname"] .
        "', '" . $_POST["citizen_id"] . "', '" . $_POST["dob"] . "', '" . $_POST["blood"] . "', '" . $_POST["sex"] . "', '" . $_POST["address"] . "', '" . $_POST["subdistrict"] . "', '" . $_POST["district"] . "', '" . $_POST["province"] . "', '" . $_POST["zip"] .
        "', '" . $_POST["phone"] . "', '" . $_POST["email"] . "', '" . $_POST["line_id"] . "', '" . $_POST["idpa_exp"] . "', '" . $_POST["so_exp"] . "', '" . $_POST["pwd"] . "', " . $auth . ", 'enable', current_timestamp(), '" . $_POST["so_editor"] . "', current_timestamp())";

    // die("so add sql: <br><br>" . $sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&alert=info&msg=เพิ่มข้อมูล SO เรียบร้อย" />';
    die();
}

// so delete
if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "sodelete" && isset($_GET["soid"])) {
    $sql = "UPDATE `so-member` SET `so_status`='delete', `so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_GET["soid"];
    echo $sql;
    die("so delete " . $sql);
    // $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=so&alert=info&msg=ลบข้อมูล SO เรียบร้อย" />';
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "soupdate" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_POST["so_id"]) && isset($_POST["submit"])) {
    if (isset($_POST["pwd"]) && $_POST["pwd"] != "") {
        // $pwd = ",`so_pwd`='" . $_POST["pwd"] . "'";
        $pwd = "";
    } else {
        $pwd = "";
    }
    if (isset($_POST["so_level"]) && $_POST["so_level"] != "") {
        $so_level = ",`so_level`='" . $_POST["so_level"] . "'";
    } else {
        $so_level = "";
    }
    // if (isset($_POST["idpa_id"]) && $_POST["idpa_id"] != "") {
    //     $auth = ",`so_auth_lv`=3";
    // } else {
    //     $auth = ",`so_auth_lv`=1";
    // }
    if (isset($_POST["so_auth_lv"]) && $_POST["so_auth_lv"] != "") {
        $auth = ",`so_auth_lv`=" . $_POST["so_auth_lv"];
    }
    if (isset($_POST["status"]) && $_POST["status"] == "register") {
        $_POST["status"] = "enable";
    }
    if (isset($_POST["idpa_exp"]) && $_POST["idpa_exp"] != "") {
        $idpa_exp = ",`so_idpa_expire`='" . $_POST["idpa_exp"] . "'";
    } else {
        $idpa_exp = ",`so_idpa_expire`=NULL";
    }
    if (isset($_POST["so_exp"]) && $_POST["so_exp"] != "") {
        $so_exp = ",`so_license_expire`='" . $_POST["so_exp"] . "'";
    } else {
        $so_exp = ",`so_license_expire`=NULL";;
    }
    // ! $system_auth_lv = array("1" => "idpa member", "3" => "so member", "5" => "md", "7" => "admin", "9" => "developer");
    switch ($_POST["citizen_id"]) {
        case "3500700238956": // อำนาจ
            $auth = ",`so_auth_lv`=9";
            break;
        case "3120101111910": // ก้องเกียรติ admin
            $auth = ",`so_auth_lv`=7";
            break;
        case "3100601917557": // ทรงศักดิ์ admin
            $auth = ",`so_auth_lv`=7";
            break;
        case "3100400140393": // พี่โอ Stat
            $auth = ",`so_auth_lv`=6";
            break;
        case "1101200020151": // พี่น้อง stat
            $auth = ",`so_auth_lv`=6";
            break;
    }

    if (!empty($_FILES["avatar"]["tmp_name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $extension = explode(".", $_FILES["avatar"]["name"]);
        $extension = end($extension);
        $target_newfilename = $_POST["so_id"] . "-" . $_POST["firstname_en"] . "_" . $_POST["lastname_en"] . "." . $extension;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            // echo "File is not an image.<br>";
            $uploadOk = 0;
        }
        // check file size > 2mb
        if ($_FILES["avatar"]["size"] > (2 * (1000 * 1000))) {
            echo 'Sorry, your file is too large (> 2Mb).<a href="member/?p=profile" target="_TOP">Try again.</a><br>';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
        $target_newfilename = ", `so_avatar`='" . $target_dir . $target_newfilename . "'";
    } else {
        $target_newfilename = "";
    }

    $sql = "UPDATE `so-member` SET `so_idpa_id`='" . $_POST["idpa_id"] . "',`so_club`='" . $_POST["club"] . "',`so_firstname`='" . $_POST["firstname"] . "',`so_lastname`='" . $_POST["lastname"] . "',`so_firstname_en`='" . $_POST["firstname_en"] . "',`so_lastname_en`='" . $_POST["lastname_en"] . "',`so_nickname`='" . $_POST["nickname"] . "',
    `so_citizen_id`='" . $_POST["citizen_id"] . "',`so_dob`='" . $_POST["dob"] . "',`so_blood_type`='" . $_POST["blood"] . "',`so_sex`='" . $_POST["sex"] . "',`so_address`='" . $_POST["address"] . "',`so_subdistrict`='" . $_POST["subdistrict"] . "',`so_district`='" . $_POST["district"] . "',`so_province`='" . $_POST["province"] . "',`so_zipcode`='" . $_POST["zip"] . "',
    `so_phone`='" . $_POST["phone"] . "',`so_email`='" . $_POST["email"] . "',`so_line_id`='" . $_POST["line_id"] . "'" . $idpa_exp . $so_exp . $pwd . $auth . $target_newfilename . $so_level . ",`so_status`='" . $_POST["status"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_POST["so_id"];
    // die("<hr>" . $sql);
    $fnc->sql_execute($sql);
    if ($_SESSION["member"]["auth_lv"] >= 7) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/index.php?p=so&alert=success&msg=อัพเดทเรียบร้อย" />';
    } elseif (!empty($_SESSION["member"])) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?alert=success&msg=อัพเดทเรียบร้อย" />';
    }
    die();
}

/*if (isset($_POST["fst"]) && $_POST["fst"] == "soupdate" && isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "soedit" && isset($_POST["so_id"]) && isset($_POST["submit"])) {
    if (isset($_POST["pwd"]) && $_POST["pwd"] != "") {
        $pwd = ",`so_pwd`='" . $_POST["pwd"] . "'";
    } else {
        $pwd = "";
    }
    if ($_POST["idpa_exp"] != "") {
        $auth = ",`so_auth_lv`=3";
    } else {
        $auth = ",`so_auth_lv`=1";
    }
    // ! $system_auth_lv = array("1" => "idpa member", "3" => "so member", "5" => "md", "7" => "admin", "9" => "developer");
    switch ($_POST["citizen_id"]) {
            // อำนาจ
        case "3500700238956":
            $auth = ",`so_auth_lv`=9";
            break;
            // ก้องเกียรติ admin
        case "3120101111910":
            $auth = ",`so_auth_lv`=7";
            break;
            // ทรงศักดิ์ admin
        case "3100601917557":
            $auth = ",`so_auth_lv`=7";
            break;
    }

    $sql = "UPDATE `so-member` SET `so_idpa_id`='" . $_POST["idpa_id"] . "',`so_club`='" . $_POST["club"] . "',`so_firstname`='" . $_POST["firstname"] . "',`so_lastname`='" . $_POST["lastname"] . "',`so_firstname_en`='" . $_POST["firstname_en"] . "',`so_lastname_en`='" . $_POST["lastname_en"] . "',`so_nickname`='" . $_POST["nickname"] . "',
    `so_citizen_id`='" . $_POST["citizen_id"] . "',`so_dob`='" . $_POST["dob"] . "',`so_blood_type`='" . $_POST["blood"] . "',`so_sex`='" . $_POST["sex"] . "',`so_address`='" . $_POST["address"] . "',`so_subdistrict`='" . $_POST["subdistrict"] . "',`so_district`='" . $_POST["district"] . "',`so_province`='" . $_POST["province"] . "',`so_zipcode`='" . $_POST["zip"] . "',
    `so_phone`='" . $_POST["phone"] . "',`so_email`='" . $_POST["email"] . "',`so_line_id`='" . $_POST["line_id"] . "',`so_idpa_expire`='" . $_POST["idpa_exp"] . "',`so_license_expire`='" . $_POST["so_exp"] . "',`so_idpa_profile`='" . $_POST["idpa_profile"] . "'" . $pwd . $auth . ",`so_status`='" . $_POST["status"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=current_timestamp() WHERE `so_id` = " . $_POST["so_id"];
    $fnc->sql_execute($sql);
    // die($sql);
    if (!empty($_SESSION["member"])) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/index.php?p=so&alert=success&msg=อัพเดทเรียบร้อย" />';
    } elseif (!empty($_SESSION["member"])) {
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/index.php?p=profile&alert=success&msg=อัพเดทเรียบร้อย" />';
    }
    die();
} */

if (isset($_POST["fst"]) && $_POST["fst"] == "matchappend" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchappend" && isset($_POST["match_editor"]) && isset($_POST["submit"])) {
    if (!is_numeric($_POST["match_coordinator"])) {
        $_POST["match_coordinator"] = 'NULL';
    }
    if (!is_numeric($_POST["match_finish"])) {
        $_POST["match_finish"] = $_POST["match_begin"];
    }
    $sql = "INSERT INTO `match-idpa` (`match_regist_datetime`, `match_name`, `match_location`, `match_detail`, `match_level`, `match_stages`, `match_rounds`, `match_begin`, `match_finish`, 
    `match_md`, `match_md_contact`, `match_coordinator`, `match_status`, `match_editor`, `match_lastupdate`) 
    VALUES (current_timestamp(), '" . $_POST["match_name"] . "', '" . $_POST["match_location"] . "', '" . $_POST["match_detail"] . "', '" . $_POST["match_level"] . "', " . $_POST["match_stages"] . ", " . $_POST["match_rounds"] . ", '" . $_POST["match_begin"] . "', '" . $_POST["match_finish"] . "', 
    '" . $_POST["match_md"] . "', '" . $_POST["match_md_contact"] . "', " . $_POST["match_coordinator"] . ", 'enable', '" . $_POST["match_editor"] . "', current_timestamp())";
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=match&alert=success&msg=ลงทะเบียนเรียบร้อย" />';
    die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "matchupdate" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchupdate" && isset($_POST["match_editor"]) && isset($_POST["submit"]) && isset($_POST["m_id"])) {
    if (!empty($_FILES["match_upload_file"]["tmp_name"])) {
        $target_dir = "uploads/pdf/";
        $target_file = $target_dir . basename($_FILES["match_upload_file"]["name"]);
        $extension = explode(".", $_FILES["match_upload_file"]["name"]);
        $extension = end($extension);
        $target_newfilename = $_POST["m_id"] . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $_POST["match_name"])))))) . "." . $extension;
        $uploadOk = 1;
        // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // $check = getimagesize($_FILES["match_upload_file"]["tmp_name"]);
        // if ($check !== false) {
        //     echo "File is an image - " . $check["mime"] . ".<br>";
        //     $uploadOk = 1;
        // } else {
        //     echo "File is not an image.<br>";
        //     $uploadOk = 0;
        // }
        // check file size > 1.5mb
        if ($_FILES["match_upload_file"]["size"] > (1.5 * (1000 * 1000))) {
            echo 'Sorry, your file is too large (> 2Mb).<a href="member/?p=profile" target="_TOP">Try again.</a><br>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["match_upload_file"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
        $target_newfilename = ", `match_upload_file`='" . $target_dir . $target_newfilename . "'";
    } else {
        $target_newfilename = "";
    }

    $sql = "UPDATE `match-idpa` SET `match_name`='" . $_POST["match_name"] . "',`match_location`='" . $_POST["match_location"] . "',`match_detail`='" . $_POST["match_detail"] . "',`match_level`='" . $_POST["match_level"] . "',`match_stages`=" . $_POST["match_stages"] . ",`match_rounds`=" . $_POST["match_rounds"] . ",`match_begin`='" . $_POST["match_begin"] . "',`match_finish`='" . $_POST["match_finish"] . "',`match_md`='" . $_POST["match_md"] . "'";
    if ($_POST["match_md_contact"]) {
        $sql .= ",`match_md_contact`='" . $_POST["match_md_contact"] . "'";
    }
    if ($_POST["match_coordinator"]) {
        $sql .= ",`match_coordinator`=" . $_POST["match_coordinator"];
    }
    $sql .= $target_newfilename . ",`match_editor`='" . $_POST["match_editor"] . "',`match_lastupdate`=current_timestamp() WHERE `match_id` = " . $_POST["m_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=matchinfo&mid=' . $_POST["m_id"] . '&alert=success&msg=อัพเดทเรียบร้อย" />';
    die();
}

/*if (isset($_POST["fst"]) && $_POST["fst"] == "matchupdate" && isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchupdate" && isset($_POST["match_editor"]) && isset($_POST["submit"]) && isset($_POST["m_id"])) {
    $sql = "UPDATE `match-idpa` SET `match_name`='" . $_POST["match_name"] . "',`match_location`='" . $_POST["match_location"] . "',`match_detail`='" . $_POST["match_detail"] . "',`match_level`='" . $_POST["match_level"] . "',`match_stages`=" . $_POST["match_stages"] . ",`match_rounds`=" . $_POST["match_rounds"] . ",`match_begin`='" . $_POST["match_begin"] . "',`match_finish`='" . $_POST["match_finish"] . "',`match_md`='" . $_POST["match_md"] . "'";
    if ($_POST["match_md_contact"]) {
        $sql .= ",`match_md_contact`='" . $_POST["match_md_contact"] . "'";
    }
    if ($_POST["match_coordinator"]) {
        $sql .= ",`match_coordinator`=" . $_POST["match_coordinator"];
    }
    $sql .= ",`match_editor`='" . $_POST["match_editor"] . "',`match_lastupdate`=current_timestamp() WHERE `match_id` = " . $_POST["m_id"];
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=matchinfo&mid=' . $_POST["m_id"] . '&alert=success&msg=อัพเดทเรียบร้อย" />';
    die();
}*/

if (isset($_GET["p"]) && $_GET["p"] == "match" && isset($_GET["act"]) && $_GET["act"] == "matchdelete" && isset($_GET["mid"])) {
    $sql = "UPDATE `match-idpa` SET `match_status`='delete',`match_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`match_lastupdate`=CURRENT_TIMESTAMP() WHERE `match_id` =" . $_GET["mid"];
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/?p=matchinfo&mid=' . $_POST["m_id"] . '&alert=success&msg=อัพเดทเรียบร้อย" />';
    die();
}
// echo "so change password";
if (isset($_GET["p"]) && $_GET["p"] == "so" && isset($_GET["act"]) && $_GET["act"] == "changePassword" && isset($_POST["fst"]) && $_POST["fst"] == "SOChangePassword" && isset($_POST["passwordNew"])) {
    if (isset($_POST["passwordOld"])) {
        $sql_chk = "Select `so-member`.so_id, `so-member`.so_citizen_id From `so-member` Where `so_id` = " . $_POST["soid"] . " And `so-member`.so_pwd Like '" . $_POST["passwordOld"] . "'";
        $data_row = $fnc->get_db_row($sql_chk);
        if (!empty($data_row)) {
            $sql = "UPDATE `so-member` SET `so_pwd`='" . $_POST["passwordNew"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=CURRENT_TIMESTAMP() WHERE `so_id` = " . $_POST["soid"] . " AND `so_citizen_id` LIKE '" . $data_row["so_citizen_id"] . "'";
        } else {
            echo "your password is incorrect";
            echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=profile&alert=danger&msg=ท่านระบุรหัสผ่านไม่ถูกต้อง." />';
            die();
        }
    } else {
        $sql = "UPDATE `so-member` SET `so_pwd`='" . $_POST["passwordNew"] . "',`so_editor`='" . $_SESSION["member"]["so_firstname_en"] . "',`so_lastupdate`=CURRENT_TIMESTAMP() WHERE `so_id` = " . $_POST["soid"];
    }

    if (!empty($sql)) {
        // die($sql);
        $fnc->sql_execute($sql);
        if ($_SESSION["member"]["so_status"] == "forcepwd") {
            $fnc->sql_execute("UPDATE `so-member` SET `so_status`='enable' WHERE `so_id` = " . $_POST["soid"]);
        }
        echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=member/?p=profile&alert=success&msg=รหัสผ่านถูกเปลี่ยนเรียบร้อย." />';
        die();
    }
}

if (isset($_GET["p"]) && $_GET["p"] == "setting" && isset($_GET["act"]) && $_GET["act"] == "settingupdate" && isset($_POST["fst"]) && $_POST["fst"] == "settingupdate" && isset($_POST["setting_id"])) {
    // $sql = "UPDATE `settings` SET `setting_max_stage`='" . $_POST["setting_max_stage"] . "',`setting_db_name`='" . $_POST["setting_db_name"] . "',`setting_debug_show`='" . $_POST["setting_debug_show"] . "',`setting_alert`='" . $_POST["setting_alert"] . "',`setting_meta_redirect`='" . $_POST["setting_meta_redirect"] . "',`setting_system_name`='" . $_POST["setting_system_name"] . "',`setting_version`='" . $_POST["setting_version"] . "',`setting_match_active`='" . $_POST["setting_match_active"] . "' WHERE `setting_id` = " . $_POST["setting_id"];
    $sql = "INSERT INTO `settings` (`setting_max_stage`, `setting_db_name`, `setting_debug_show`, `setting_alert`, `setting_meta_redirect`, 
    `setting_system_name`, `setting_version`, `setting_version_notes`, `setting_match_active`, `setting_view_result`, `setting_editor`) 
    VALUES ('" . $_POST["setting_max_stage"] . "', '" . $_POST["setting_db_name"] . "', '" . $_POST["setting_debug_show"] . "', '" . $_POST["setting_alert"] . "', '" . $_POST["setting_meta_redirect"] . "', 
    '" . $_POST["setting_system_name"] . "', '" . $_POST["setting_version"] . "', '" . $_POST["setting_version_notes"] . "', '" . $_POST["setting_match_active"] . "', '" . $_POST["setting_view_result"] . "', '" . $_SESSION["member"]["so_firstname_en"] . "')";
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=admin/setting.php?alert=success&msg=บันทึกข้อมูลการตั้งค่าเรียบร้อย." />';
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "result" && isset($_GET["act"]) && $_GET["act"] == "csvupload" && isset($_POST["m_id"]) && isset($_POST["fst"]) && $_POST["fst"] == "csvupload") {
    if (!empty($_FILES["upload_file"]["tmp_name"])) {
        $target_dir = "uploads/result/";
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        $upload_filename = explode(".", $_FILES["upload_file"]["name"])[0];
        $extension = explode(".", $_FILES["upload_file"]["name"]);
        $extension = end($extension);
        $target_newfilename = $_POST["m_id"] . "-" . date("YMd-Hi") . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $upload_filename)))))) . "." . $extension;
        $uploadOk = 1;
        // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
        // if ($check !== false) {
        //     echo "File is an image - " . $check["mime"] . ".<br>";
        //     $uploadOk = 1;
        // } else {
        //     echo "File is not an image.<br>";
        //     $uploadOk = 0;
        // }
        // check file size > 1.5mb
        if ($_FILES["upload_file"]["size"] > (1.5 * (1000 * 1000))) {
            echo 'Sorry, your file is too large (> 2Mb).<a href="member/?p=profile" target="_TOP">Try again.</a><br>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
            }
        }
        rename($target_file, $target_dir . $target_newfilename);
        // $target_newfilename = ", `upload_file`='" . $target_dir . $target_newfilename . "'";
        $sql = "UPDATE `match-idpa` SET `match_csv_file`='" . $target_dir . $target_newfilename . "' WHERE `match_id` = " . $_POST["m_id"];
    } else {
        die("no target new filename");
        // $target_newfilename = "";
    }
    // die($sql);
    $fnc->sql_execute($sql);
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=upload&v=readcsv&alert=success&msg=อัพโหลดไฟล์เรียบร้อย." />';
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "proceeding" && isset($_GET["act"]) && $_GET["act"] == "delete" && isset($_GET["act"])) {
    $sql = "UPDATE `proceeding` SET `pro_status`='delete',`pro_editor`='admin',`pro_lastupdate`=CURRENT_TIMESTAMP() WHERE `pro_id` = " . $_GET["act"];
    die($sql);
    $fnc->sql_execute($sql);
    
}

if (isset($_GET["p"]) && $_GET["p"] == "viewresult" && isset($_GET["act"]) && $_GET["act"] == "openview") {
    $sql = "UPDATE `settings` SET `setting_view_result`='true' WHERE `setting_id` = " . $_GET["set_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    $_SESSION["member"]["setting"]["setting_view_result"] = "true";
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&alert=success&msg=เปิดการแสดงผล Shooter Score เรียบร้อย." />';
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "viewresult" && isset($_GET["act"]) && $_GET["act"] == "closeview") {
    $sql = "UPDATE `settings` SET `setting_view_result`='false' WHERE `setting_id` = " . $_GET["set_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    $_SESSION["member"]["setting"]["setting_view_result"] = "false";
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&alert=success&msg=ปิดการแสดงผล Shooter Score เรียบร้อย." />';
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "matchresult" && isset($_GET["act"]) && $_GET["act"] == "openview") {
    $sql = "UPDATE `settings` SET `setting_match_result`='true' WHERE `setting_id` = " . $_GET["set_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    $_SESSION["member"]["setting"]["setting_match_result"] = "true";
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&alert=success&msg=เปิดการแสดงผล Match Result เรียบร้อย." />';
    die();
}

if (isset($_GET["p"]) && $_GET["p"] == "matchresult" && isset($_GET["act"]) && $_GET["act"] == "closeview") {
    $sql = "UPDATE `settings` SET `setting_match_result`='false' WHERE `setting_id` = " . $_GET["set_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    $_SESSION["member"]["setting"]["setting_match_result"] = "false";
    echo '<meta http-equiv="refresh" content="' . $_SESSION["member"]["setting"]["setting_meta_redirect"] . '; URL=score/?p=showscore&alert=success&msg=ปิดการแสดงผล Match Result เรียบร้อย." />';
    die();
}

echo "condition fails";
