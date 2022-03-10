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
$MJU_API = new MJU_API();

if (isset($_POST["fst"]) && $_POST["fst"] == "uploadAttachments" && isset($_POST["ref_table"]) && isset($_POST["ref_id"])) {
  // echo "uploading...";
  if (isset($_POST['ref_pid']) && $_POST['ref_pid'] != "") {
    $target_dir = "uploads/" . $_POST["ref_table"] . "/" . "Project-" . $_POST['ref_pid'] . "/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir);
    }
    $target_dir = "uploads/" . $_POST["ref_table"] . "/" . "Project-" . $_POST['ref_pid'] . "/" . "Activity-" . $_POST["ref_id"] . "/";
  } else {
    $target_dir = "uploads/" . $_POST["ref_table"] . "/" . $_POST["ref_table"] . "-" . $_POST["ref_id"] . "/";
  }
  if (!file_exists($target_dir)) {
    mkdir($target_dir);
  }
  if (isset($_FILES["file_attach"])) {
    // echo "<pre>" . print_r($_FILES["file_attach"]) . "</pre>";
    foreach ($_FILES['file_attach']['tmp_name'] as $key => $val) {

      $file_name = $_FILES['file_attach']['name'][$key];
      $file_type = $_FILES['file_attach']['type'][$key];
      $upload_filename = explode(".", $_FILES["file_attach"]["name"][$key])[0];
      $filename = explode(".", $_FILES["file_attach"]["name"][$key]);
      $extension = end($filename);
      unset($filename[count($filename) - 1]);
      $file_name = implode("", $filename);
      $file_name = str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $file_name))))));
      $file_name .= '.' . $extension;
      $target_file = $target_dir . $file_name;
      if (move_uploaded_file($_FILES["file_attach"]["tmp_name"][$key], $target_file)) {
        // echo "<br>The file " . htmlspecialchars(basename($_FILES["file_attach"]["name"][$key])) . " has been uploaded.";
        $sql = "INSERT INTO `attachment`(`att_ref_table`, `att_ref_id`, `att_filename`, `att_filetype`, `att_filepath`, `att_status`, `att_editor`) VALUES 
        ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "','" . $file_name . "','" . $file_type . "','" . $target_dir . "','enable','Admin')";
        // die($sql);
        $fnc->sql_execute($sql);
      } else {
        echo "E Sorry, there was an error uploading your file. Please contact admin.<br>" . $target_dir;
        echo '<meta http-equiv="refresh" content="5; URL=admin/' . $_POST["ref_table"] . '.php?p=' . $_POST["ref_table"] . '&act=coWorker&' . strtolower(substr($_POST["ref_table"], 0, 1)) . 'id=' . $_POST["ref_id"] . '&alert=warning&title=ผิดพลาด&msg=เพิ่มเอกสารแนบใน ' . $_POST["ref_table"] . ' ไม่สำเร็จ." />';
        die();
      }
      // rename($target_file, $target_dir . $target_newfilename);
    }


    // if (!empty($_FILES["upload_file"]["tmp_name"])) {
    //   $target_dir = "uploads/" . $_POST["ref_table"] . "/" . $_POST["ref_id"] . "/";
    //   $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
    //   $upload_filename = explode(".", $_FILES["upload_file"]["name"])[0];
    //   $extension = explode(".", $_FILES["upload_file"]["name"]);
    //   $extension = end($extension);
    //   $target_newfilename = $_POST["m_id"] . "-" . date("YMd-Hi") . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $upload_filename)))))) . "." . $extension;
    //   $uploadOk = 1;
    // }
    if ($sql) {
      switch ($_POST["ref_table"]) {
        case "proceeding":
          $fnc->sql_execute("UPDATE `proceeding` SET `pro_attach`='true',`pro_lastupdate`=CURRENT_TIMESTAMP() WHERE `pro_id` =" . $_POST["ref_id"]);
          $link_back = 'proceeding.php?p=proceeding&act=coWorker&' . strtolower(substr($_POST["ref_table"], 0, 1)) . 'id=' . $_POST["ref_id"];
          break;
        case "journal":
          $fnc->sql_execute("UPDATE `journal` SET `jour_attach`='true',`jour_lastupdate`=CURRENT_TIMESTAMP() WHERE `jour_id` =" . $_POST["ref_id"]);
          $link_back = 'journal.php?p=journal&act=coWorker&' . strtolower(substr($_POST["ref_table"], 0, 1)) . 'id=' . $_POST["ref_id"];
          break;
        case "research":
          $fnc->sql_execute("UPDATE `research` SET `res_attach`='true',`res_lastupdate`=CURRENT_TIMESTAMP() WHERE `res_id` =" . $_POST["ref_id"]);
          $link_back = 'research.php?p=research&act=coWorker&' . strtolower(substr($_POST["ref_table"], 0, 1)) . 'id=' . $_POST["ref_id"];
          break;
        case "project":
          $fnc->sql_execute("UPDATE `project` SET `proj_attach`='true',`proj_lastupdate`=CURRENT_TIMESTAMP() WHERE `proj_id` =" . $_POST["ref_id"]);
          $link_back = 'project.php?p=project&act=coWorker&' . strtolower(substr($_POST["ref_table"], 0, 1)) . 'id=' . $_POST["ref_id"];
          break;
        case "activity":
          $fnc->sql_execute("UPDATE `project_activity` SET `pa_attach`='true',`pa_lastupdate`=CURRENT_TIMESTAMP() WHERE `pa_id` =" . $_POST["ref_id"]);
          $link_back = 'project.php?p=activity&act=photomgt&pid=' . $_POST['ref_pid'] . '&paid=' . $_POST['ref_id'];
          break;
      }
      // echo "passed.";
      echo '<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=success&title=สำเร็จ&msg=เพิ่มเอกสารแนบใน ' . $_POST["ref_table"] . ' เรียบร้อย." />';
    } else {
      echo '<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=warning&title=ผิดพลาด&msg=เพิ่มเอกสารแนบใน ' . $_POST["ref_table"] . ' ไม่สำเร็จ." />';
    }
  } else {
    // echo "<br>no file upload.";
  }
  die();
}


// * insert proceeding
if (isset($_POST["fst"]) && $_POST["fst"] == "proceeding_append") {
  $api_url = $fnc->api_url_personal . $_POST["pro_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  if (empty($_POST["pro_date_end"])) {
    $_POST["pro_date_end"] = $_POST["pro_date_begin"];
  }
  if (!isset($_POST["department_name"])) {
    $_POST["department_name"] = '';
  }
  if (!isset($_POST["pro_conf_owner"])) {
    $_POST["pro_conf_owner"] = '';
  }
  if (!isset($_POST["pro_volume_issue"])) {
    $_POST["pro_volume_issue"] = '';
  }
  if (!isset($_POST["pro_page"])) {
    $_POST["pro_page"] = '';
  }
  if (!isset($_POST["pro_link"])) {
    $_POST["pro_link"] = '';
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["pro_date_begin"]);
  $sql = "INSERT INTO proceeding (pro_owner_citizenid, pro_owner_prename, pro_owner_firstname, pro_owner_lastname, department_name, 
  pro_ratio, pro_study, pro_tier, pro_date_begin, pro_date_end, pro_fiscalyear, 
  pro_conf, pro_conf_owner, pro_volume_issue, pro_page, pro_link, pro_detail, pro_location, pro_status, pro_editor) VALUES 
  ('" . $_POST["pro_owner_citizenid"] . "', '" . $owner["titlePosition"] . "', '" . $owner["firstName"] . "', '" . $owner["lastName"] . "', '" . $_POST["department_name"] . "',
   '" . $_POST["pro_ratio"] . "', '" . addslashes($_POST["pro_study"]) . "', '" . $_POST["pro_tier"] . "', '" . $_POST["pro_date_begin"] . "', '" . $_POST["pro_date_end"] . "', '" . $fiscal_year . "', 
   '" . addslashes($_POST["pro_conf"]) . "', '" . addslashes($_POST["pro_conf_owner"]) . "', '" . addslashes($_POST["pro_volume_issue"]) . "', '" . addslashes($_POST["pro_page"]) . "', '" . addslashes($_POST["pro_link"]) . "', '" . addslashes($_POST["pro_detail"]) . "', '" . addslashes($_POST["pro_location"]) . "', 'enable', 'Admin')";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&alert=success&title=สำเร็จ&msg=บันทึกข้อมูล Proceeding เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "proceeding_update") {
  $api_url = $fnc->api_url_personal . $_POST["pro_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  if (empty($_POST["pro_date_end"])) {
    $_POST["pro_date_end"] = $_POST["pro_date_begin"];
  }
  if (isset($_POST["department_name"])) {
    $department_name = ",department_name='" . $_POST["department_name"] . "'";
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["pro_date_begin"]);
  $sql = "UPDATE proceeding SET pro_owner_citizenid='" . $_POST["pro_owner_citizenid"] . "',pro_owner_prename='" . $owner["titlePosition"] . "',pro_owner_firstname='" . $owner["firstName"] . "',pro_owner_lastname='" . $owner["lastName"] . "'" . $department_name . ", 
   pro_ratio='" . $_POST["pro_ratio"] . "',pro_study='" . addslashes($_POST["pro_study"]) . "',pro_tier='" . $_POST["pro_tier"] . "',pro_date_begin='" . $_POST["pro_date_begin"] . "',pro_date_end='" . $_POST["pro_date_end"] . "',pro_fiscalyear='" . $fiscal_year . "',
   pro_conf='" . addslashes($_POST["pro_conf"]) . "',pro_conf_owner='" . addslashes($_POST["pro_conf_owner"]) . "',pro_page='" . addslashes($_POST["pro_page"]) . "',pro_detail='" . addslashes($_POST["pro_detail"]) . "',pro_location='" . addslashes($_POST["pro_location"]) . "',pro_status='enable',pro_editor='Admin',pro_lastupdate=CURRENT_TIMESTAMP() WHERE pro_id = " . $_POST["pro_id"];
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=viewinfo&pid=' . $_POST["pro_id"] . '&alert=success&title=สำเร็จ&msg=ปรับปรุงข้อมูล Proceeding เรียบร้อย." />';
  die();
}

if (isset($_GET["p"]) && $_GET["p"] == "proceeding" && isset($_GET["act"]) && $_GET["act"] == "delete" && isset($_GET["pid"])) {
  // $sql = "UPDATE proceeding SET pro_status='delete',pro_editor='admin',pro_lastupdate=CURRENT_TIMESTAMP() WHERE pro_id = " . $_GET["pid"];
  // * delete proceeding
  $sql = "DELETE FROM `proceeding` WHERE `pro_id` = " . $_GET["pid"];
  // die($sql);
  $fnc->sql_execute($sql);
  // * delete co-worker
  $sql = "DELETE FROM `co_worker` WHERE `cow_ref_table` like 'proceeding' and `cow_ref_id` = " . $_GET["pid"];
  // die($sql);
  $fnc->sql_execute($sql);
  // * delete attachment file
  $sql = "SELECT * FROM `attachment` WHERE `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $_GET["pid"];
  $attachments = $fnc->get_db_array($sql);
  if (!empty($attachments)) {
    foreach ($attachments as $row) {
      if (!empty($row["att_filename"])) {
        unlink($row["att_filepath"] . $row["att_filename"]);
      }
    }
    $sql = "DELETE FROM `attachment` WHERE `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $_GET["pid"];
    // die($sql);
    $fnc->sql_execute($sql);
  }

  echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&alert=success&title=สำเร็จ&msg=ลบข้อมูล Proceeding เรียบร้อย." />';
  die();
}

if (isset($_GET["p"]) && $_GET["p"] == "proceeding" && isset($_GET["act"]) && $_GET["act"] == "restore" && isset($_GET["pid"])) {
  $sql = "UPDATE proceeding SET pro_status='enable',pro_editor='admin',pro_lastupdate=CURRENT_TIMESTAMP() WHERE pro_id = " . $_GET["pid"];
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="3; URL=admin/proceeding.php?p=proceeding&alert=success&title=สำเร็จ&msg=ลบข้อมูล Proceeding เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "proceedingCoWorkerIntAppend") {
  $api_url = $fnc->api_url_personal . $_POST["cow_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, 	department_name, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "','" . $_POST["cow_citizenid"] . "','" . $owner["titlePosition"] . "','" . $owner["firstName"] . "','" . $owner["lastName"] . "','" . addslashes($_POST["department_name"]) . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"] . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน Proceeding เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "proceedingCoWorkerExtAppend") {
  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "',NULL,'" . $_POST["cow_prename"] . "','" . $_POST["cow_firstname"] . "','" . $_POST["cow_lastname"] . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"] . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน Proceeding เรียบร้อย." />';
  die();
}

if (isset($_GET["p"]) && isset($_GET["act"]) && $_GET["act"] == "coWorkerRemove" && isset($_GET["id"]) && isset($_GET["cowid"])) {
  // $sql = "UPDATE `co_worker` SET `cow_status`='delete',`cow_editor`='Admin',`cow_lastupdate`=CURRENT_TIMESTAMP() WHERE `cow_id` = " . $_GET["cowid"];
  $sql = "DELETE FROM `co_worker` WHERE `cow_id` =" . $_GET["cowid"];
  // die($sql);
  $fnc->sql_execute($sql);
  // switch ($_GET["p"]) {
  //   case "proceeding":
  //     // $link_back = 'proceeding.php?p=proceeding&act=coWorker&pid=' . $_GET["id"];
  //     break;
  //   case "journal":
  //     // $link_back = 'journal.php?p=journal&act=coWorker&jid=' . $_GET["id"];
  //     break;
  // }
  $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"], 0, 1)) . 'id=' . $_GET["id"];
  echo '<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=success&title=สำเร็จ&msg=นำรายชื่อผู้ร่วมงานออกเรียบร้อยแล้ว." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "uploadAttachments" && isset($_POST["ref_table"]) && $_POST["ref_table"] == "proceeding" && isset($_POST["ref_id"])) {
  $target_dir = "uploads/" . $_POST["ref_table"] . "/" . $_POST["ref_id"] . "/";
  if (!file_exists($target_dir)) {
    mkdir($target_dir);
  }
  if (isset($_FILES["pro_attach"])) {
    // echo "<pre>" . print_r($_FILES["pro_attach"]) . "</pre>";
    foreach ($_FILES['pro_attach']['tmp_name'] as $key => $val) {

      $file_name = $_FILES['pro_attach']['name'][$key];
      // $file_size = $_FILES['pro_attach']['size'][$key];
      // $file_tmp = $_FILES['pro_attach']['tmp_name'][$key];
      $file_type = $_FILES['pro_attach']['type'][$key];
      // move_uploaded_file($file_tmp, "myfile/" . $file_name);
      $upload_filename = explode(".", $_FILES["pro_attach"]["name"][$key])[0];
      $filename = explode(".", $_FILES["pro_attach"]["name"][$key]);
      $extension = end($filename);
      unset($filename[count($filename) - 1]);
      $file_name = implode("", $filename);
      $file_name = str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $file_name))))));
      $file_name .= '.' . $extension;
      $target_file = $target_dir . $file_name;
      if (move_uploaded_file($_FILES["pro_attach"]["tmp_name"][$key], $target_file)) {
        // echo "<br>The file " . htmlspecialchars(basename($_FILES["pro_attach"]["name"][$key])) . " has been uploaded.";
        $sql = "INSERT INTO `attachment`(`att_ref_table`, `att_ref_id`, `att_filename`, `att_filetype`, `att_filepath`, `att_status`, `att_editor`) VALUES 
        ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "','" . $file_name . "','" . $file_type . "','" . $target_dir . "','enable','Admin')";
        // die($sql);
        $fnc->sql_execute($sql);
      } else {
        echo "Sorry, there was an error uploading your file. Please contact admin.<br>";
        echo '<meta http-equiv="refresh" content="3; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"] . '&alert=warning&title=ผิดพลาด&msg=เพิ่มเอกสารแนบใน Proceeding ไม่สำเร็จ." />';
        die();
      }
      // rename($target_file, $target_dir . $target_newfilename);
    }


    // if (!empty($_FILES["upload_file"]["tmp_name"])) {
    //   $target_dir = "uploads/" . $_POST["ref_table"] . "/" . $_POST["ref_id"] . "/";
    //   $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
    //   $upload_filename = explode(".", $_FILES["upload_file"]["name"])[0];
    //   $extension = explode(".", $_FILES["upload_file"]["name"]);
    //   $extension = end($extension);
    //   $target_newfilename = $_POST["m_id"] . "-" . date("YMd-Hi") . "-" . str_replace("#", "", str_replace("$", "", str_replace("%", "", str_replace("/", "", str_replace(".", "", str_replace(":", "", $upload_filename)))))) . "." . $extension;
    //   $uploadOk = 1;
    // }
    if ($sql) {
      $fnc->sql_execute("UPDATE `proceeding` SET `pro_attach`='true',`pro_lastupdate`=CURRENT_TIMESTAMP WHERE `pro_id` =" . $_POST["ref_id"]);
      echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"] . '&alert=success&title=สำเร็จ&msg=เพิ่มเอกสารแนบใน Proceeding เรียบร้อย." />';
    } else {
      echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"] . '&alert=warning&title=ผิดพลาด&msg=เพิ่มเอกสารแนบใน Proceeding ไม่สำเร็จ." />';
    }
  }
  die();
}

/*if (isset($_GET["p"]) && $_GET["p"] == "proceeding" && isset($_GET["act"]) && $_GET["act"] == "deletefile" && isset($_GET["pid"]) && isset($_GET["fid"])) {
  $att_file = $fnc->get_db_row("SELECT * FROM `attachment` WHERE `att_id` = " . $_GET["fid"]);
  if (!empty($att_file)) {
    // echo "no empty";
    unlink($att_file["att_filepath"] . $att_file["att_filename"]);
    $sql = "DELETE FROM `attachment` WHERE `att_id` =" . $_GET["fid"];
    // die($sql);
    $fnc->sql_execute($sql);
    echo "SELECT count(att_id) as cnt FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $_GET["pid"];
    if (!$fnc->get_db_col("SELECT count(att_id) as cnt FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = 'proceeding' AND `att_ref_id` = " . $_GET["pid"])) {
      $fnc->sql_execute("UPDATE `proceeding` SET `pro_attach`=NULL,`pro_lastupdate`=CURRENT_TIMESTAMP WHERE `pro_id` =" . $_GET["pid"]);
    }
    echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_GET["pid"] . '&alert=success&title=สำเร็จ&msg=ลบไฟล์แนบของ Proceeding เรียบร้อย." />';
  } else {
    // echo "is empty :" . $sql;
    echo '<meta http-equiv="refresh" content="0; URL=admin/proceeding.php?p=proceeding&act=coWorker&pid=' . $_GET["pid"] . '&alert=success&title=สำเร็จ&msg=ลบไฟล์แนบของ Proceeding ไม่สำเร็จ." />';
  }
  die();
}*/

if (isset($_GET['p']) && $_GET['p'] == "setting" && isset($_GET['act']) && $_GET['act'] == "department_append" && isset($_POST['fst']) && $_POST['fst'] == "department_append" && isset($_POST['department_name'])) {
  $sql = "INSERT INTO `department`(`department_name`, `department_editor`, `department_lastupdate`) VALUES ('" . addslashes($_POST['department_name']) . "','Admin',CURRENT_TIMESTAMP)";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/setting.php?p=department&alert=success&title=สำเร็จ&msg=เพิ่มข้อมูลหลักสูตร/สาขาวิชาสำเร็จ." />';
  die();
}

if (isset($_GET['p']) && $_GET['p'] == "setting" && isset($_GET['act']) && $_GET['act'] == "department_update" && isset($_POST['fst']) && $_POST['fst'] == "department_update" && isset($_POST['department_name']) && isset($_POST['department_id'])) {
  $sql = "UPDATE `department` SET `department_name`='" . addslashes($_POST['department_name']) . "',`department_editor`='Admin',`department_lastupdate`=CURRENT_TIMESTAMP WHERE `department_id` = " . $_POST['department_id'];
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/setting.php?p=department&alert=success&title=สำเร็จ&msg=อัพเดทข้อมูลหลักสูตร/สาขาวิชาสำเร็จ." />';
  die();
}

if (isset($_GET['p']) && $_GET['p'] == "setting" && isset($_GET['act']) && $_GET['act'] == "department_remove" && isset($_GET['d_id'])) {
  $sql = "DELETE FROM `department` WHERE  `department_id` = " . $_GET['d_id'];
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/setting.php?p=department&alert=success&title=สำเร็จ&msg=ลบข้อมูลหลักสูตร/สาขาวิชาสำเร็จ." />';
  die();
}


// * Journals insert
if (isset($_POST["fst"]) && $_POST["fst"] == "journal_append") {
  $api_url = $fnc->api_url_personal . $_POST["jour_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";


  if (!isset($_POST["department_name"])) {
    $_POST["department_name"] = '';
  }
  if (!isset($_POST["jour_volume_issue"])) {
    $_POST["jour_volume_issue"] = '';
  }
  if (!isset($_POST["jour_page"])) {
    $_POST["jour_page"] = '';
  }
  if (!isset($_POST["jour_link"])) {
    $_POST["jour_link"] = '';
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["jour_date_avaliable"]);
  $sql = "INSERT INTO `journal` (`jour_owner_citizenid`, `jour_owner_prename`, `jour_owner_firstname`, `jour_owner_lastname`, `department_name`, 
  `jour_study`, `jour_ratio`, `jour_tier`, `jour_journal`, `jour_value`, `jour_volume_issue`, `jour_page`, `jour_link`, `jour_date_avaliable`, 
  `jour_fiscalyear`, `jour_detail`, `jour_create_datetime`, `jour_status`, `jour_editor`, `jour_lastupdate`) 
  VALUES ('" . $_POST["jour_owner_citizenid"] . "', '" . addslashes($owner["titlePosition"]) . "', '" . addslashes($owner["firstName"]) . "', '" . addslashes($owner["lastName"]) . "', '" . addslashes($_POST["department_name"]) . "', 
  '" . addslashes($_POST["jour_study"]) . "', '" . $_POST["jour_ratio"] . "', '" . $_POST["jour_tier"] . "', '" . $_POST["jour_journal"] . "', '" . $_POST["jour_value"] . "', '" . $_POST["jour_volume_issue"] . "', '" . $_POST["jour_page"] . "', '" . $_POST["jour_link"] . "', '" . $_POST["jour_date_avaliable"] . "', 
  '" . $fiscal_year . "', '" . addslashes($_POST["jour_detail"]) . "', current_timestamp(), 'enable', 'admin', current_timestamp())";

  // $sql = "INSERT INTO Journal (pro_owner_citizenid, pro_owner_prename, pro_owner_firstname, pro_owner_lastname, department_name, 
  // pro_ratio, pro_study, pro_tier, pro_date_begin, pro_date_end, pro_fiscalyear, 
  // pro_conf, pro_conf_owner, pro_volume_issue, pro_page, pro_link, pro_detail, pro_location, pro_status, pro_editor) VALUES 
  // ('" . $_POST["jour_owner_citizenid"] . "', '" . $owner["titlePosition"] . "', '" . $owner["firstName"] . "', '" . $owner["lastName"] . "', '" . $_POST["department_name"] . "',
  //  '" . $_POST["jour_ratio"] . "', '" . addslashes($_POST["jour_study"]) . "', '" . $_POST["jour_tier"] . "', '" . $_POST["jour_date_begin"] . "', '" . $_POST["jour_date_end"] . "', '" . $fiscal_year . "', 
  //  '" . addslashes($_POST["jour_conf"]) . "', '" . addslashes($_POST["jour_conf_owner"]) . "', '" . addslashes($_POST["jour_volume_issue"]) . "', '" . addslashes($_POST["jour_page"]) . "', '" . addslashes($_POST["jour_link"]) . "', '" . addslashes($_POST["jour_detail"]) . "', '" . addslashes($_POST["jour_location"]) . "', 'enable', 'Admin')";

  //  die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/journal.php?p=journal&alert=success&title=สำเร็จ&msg=บันทึกข้อมูล Journal เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "journal_update") {
  $api_url = $fnc->api_url_personal . $_POST["jour_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  if (isset($_POST["department_name"])) {
    $department_name = ",`department_name`='" . $_POST["department_name"] . "'";
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["jour_date_avaliable"]);
  $sql = "UPDATE `journal` SET `jour_owner_citizenid`='" . $_POST["jour_owner_citizenid"] . "',`jour_owner_prename`='" . addslashes($owner["titlePosition"]) . "',`jour_owner_firstname`='" . addslashes($owner["firstName"]) . "',`jour_owner_lastname`='" . addslashes($owner["lastName"]) . "'" . $department_name . ",
`jour_study`='" . addslashes($_POST["jour_study"]) . "',`jour_ratio`='" . $_POST["jour_ratio"] . "',`jour_tier`='" . $_POST["jour_tier"] . "',`jour_journal`='" . addslashes($_POST["jour_journal"]) . "',`jour_value`='" . addslashes($_POST["jour_value"]) . "',
`jour_volume_issue`='" . addslashes($_POST["jour_volume_issue"]) . "',`jour_page`='" . addslashes($_POST["jour_page"]) . "',`jour_link`='" . addslashes($_POST["jour_link"]) . "',`jour_date_avaliable`='" . addslashes($_POST["jour_date_avaliable"]) . "',`jour_fiscalyear`='" . $fiscal_year . "',
`jour_detail`='" . addslashes($_POST["jour_detail"]) . "',`jour_editor`='Admin',`jour_lastupdate`=CURRENT_TIMESTAMP() WHERE jour_id = " . $_POST["jour_id"];

  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/journal.php?p=journal&act=viewinfo&jid=' . $_POST["jour_id"] . '&alert=success&title=สำเร็จ&msg=ปรับปรุงข้อมูล Journal เรียบร้อย." />';
  die();
}

if (isset($_GET["p"]) && isset($_GET["act"]) && $_GET["act"] == "deletefile" && isset($_GET["id"]) && isset($_GET["fid"])) {
  $att_file = $fnc->get_db_row("SELECT * FROM `attachment` WHERE `att_id` = " . $_GET["fid"]);
  if (!empty($att_file)) {
    // echo "no empty";
    unlink($att_file["att_filepath"] . $att_file["att_filename"]);
    $sql = "DELETE FROM `attachment` WHERE `att_id` =" . $_GET["fid"];
    // die($sql);
    $fnc->sql_execute($sql);
    // echo "SELECT count(att_id) as cnt FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = '" . $_GET["p"] . "' AND `att_ref_id` = " . $_GET["id"];
    $cnt = $fnc->get_db_col("SELECT count(att_id) as cnt FROM `attachment` WHERE `att_status` = 'enable' AND `att_ref_table` = '" . $_GET["p"] . "' AND `att_ref_id` = " . $_GET["id"]);

    switch ($_GET["p"]) {
      case "proceeding":
        if (!$cnt) {
          $fnc->sql_execute("UPDATE `proceeding` SET `pro_attach`=NULL,`pro_lastupdate`=CURRENT_TIMESTAMP WHERE `pro_id` =" . $_GET["id"]);
        }
        // $link_back = 'proceeding.php?p=proceeding&act=coWorker&' . strtolower(substr($_GET["p"],0,1)) . 'id=' . $_GET["id"];
        break;
      case "journal":
        if (!$cnt) {
          $fnc->sql_execute("UPDATE `journal` SET `jour_attach`=NULL,`jour_lastupdate`=CURRENT_TIMESTAMP WHERE `jour_id` =" . $_GET["id"]);
        }
        // $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"],0,1)) . 'id=' . $_GET["id"];
        break;
      case "research":
        if (!$cnt) {
          $fnc->sql_execute("UPDATE `research` SET `res_attach`=NULL,`res_lastupdate`=CURRENT_TIMESTAMP WHERE `res_id` =" . $_GET["id"]);
        }
        // $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"],0,1)) . 'id=' . $_GET["id"];
        break;
      case "project":
        if (!$cnt) {
          $fnc->sql_execute("UPDATE `project` SET `proj_attach`=NULL,`proj_lastupdate`=CURRENT_TIMESTAMP WHERE `proj_id` =" . $_GET["id"]);
        }
        // $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"],0,1)) . 'id=' . $_GET["id"];
        break;
      case "activity":
        if (!$cnt) {
          $fnc->sql_execute("UPDATE `project_activity` SET `pa_attach`=NULL,`pa_lastupdate`=CURRENT_TIMESTAMP WHERE `pa_id` =" . $_GET["paid"]);
        }
        // $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"],0,1)) . 'id=' . $_GET["id"];
        // project.php?p=activity&act=photomgt&pid=12&paid=36
        $link_back = 'project.php?p=' . $_GET["p"] . '&act=photomgt&pid=' . $_GET["id"] . '&paid=' . $_GET["paid"];
        break;
    }
    if (empty($link_back)) {
      $link_back = $_GET["p"] . '.php?p=' . $_GET["p"] . '&act=coWorker&' . strtolower(substr($_GET["p"], 0, 1)) . 'id=' . $_GET["id"];
    }

    // echo "admin/" . $link_back . "&alert=success&title=สำเร็จ&msg=ลบไฟล์แนบของ " . $_GET['p'] . " เรียบร้อย.";
    // die($link_back);
    die('<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=success&title=สำเร็จ&msg=ลบไฟล์แนบของ ' . ucfirst($_GET['p']) . ' เรียบร้อย." />');
  } else {
    die("ERROR is empty :" . $sql);
    echo '<meta http-equiv="refresh" content="3; URL=admin/' . $link_back . '&alert=warning&title=ผิดพลาด&msg=ลบไฟล์แนบของ ' . ucfirst($_GET['p']) . ' ไม่สำเร็จ." />';
  }
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "journalCoWorkerIntAppend") {
  $api_url = $fnc->api_url_personal . $_POST["cow_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, 	department_name, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "','" . $_POST["cow_citizenid"] . "','" . $owner["titlePosition"] . "','" . $owner["firstName"] . "','" . $owner["lastName"] . "','" . addslashes($_POST["department_name"]) . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/journal.php?p=journal&act=coWorker&jid=' . $_POST["ref_id"] . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน Journal เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "journalCoWorkerExtAppend") {
  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "',NULL,'" . $_POST["cow_prename"] . "','" . $_POST["cow_firstname"] . "','" . $_POST["cow_lastname"] . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/journal.php?p=journal&act=coWorker&jid=' . $_POST["ref_id"] . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน Journal เรียบร้อย." />';
  die();
}

if (isset($_GET["p"]) && isset($_GET["act"]) && $_GET["act"] == "datadelete" && isset($_GET["id"])) {
  // $sql = "UPDATE proceeding SET pro_status='delete',pro_editor='admin',pro_lastupdate=CURRENT_TIMESTAMP() WHERE pro_id = " . $_GET["pid"];
  // * delete data
  switch ($_GET["p"]) {
    case "proceeding";
      $sql = "DELETE FROM `proceeding` WHERE `pro_id` = " . $_GET["id"];
      break;
    case "journal";
      $sql = "DELETE FROM `journal` WHERE `jour_id` = " . $_GET["id"];
      break;
    case "research";
      $sql = "DELETE FROM `research` WHERE `res_id` = " . $_GET["id"];
      break;
    case "project";
      $sql = "DELETE FROM `project` WHERE `proj_id` = " . $_GET["id"];
      break;
    case "activity";
      $sql = "DELETE FROM `project_activity` WHERE `proj_id` = " . $_GET["id"] . " AND `pa_id` = "  . $_GET["paid"];
      break;
      // case "activity_image";
      //   $sql = "DELETE FROM `project_activity` WHERE `pa_id` = " . $_GET["id"];
      //   break;
  }
  // die($sql);
  $fnc->sql_execute($sql);
  // * delete co-worker
  $sql = "DELETE FROM `co_worker` WHERE `cow_ref_table` like '" . $_GET["p"] . "' and `cow_ref_id` = " . $_GET["id"];
  // die($sql);
  $fnc->sql_execute($sql);
  // * delete attachment file
  $sql = "SELECT * FROM `attachment` WHERE `att_ref_table` = '" . $_GET["p"] . "' AND `att_ref_id` = " . $_GET["id"];
  $attachments = $fnc->get_db_array($sql);
  if (!empty($attachments)) {
    foreach ($attachments as $row) {
      if (!empty($row["att_filename"])) {
        unlink($row["att_filepath"] . $row["att_filename"]);
      }
    }
    $sql = "DELETE FROM `attachment` WHERE `att_ref_table` = '" . $_GET["p"] . "' AND `att_ref_id` = " . $_GET["id"];
    // die($sql);
    $fnc->sql_execute($sql);
  }
  // die();
  if ($_GET["p"] = "activity") {
    die('<meta http-equiv="refresh" content="0; URL=admin/project.php?p=' . $_GET["p"] . '&act=view&pid=' . $_GET["id"] . '&alert=success&title=สำเร็จ&msg=ลบข้อมูล ' . ucfirst($_GET["p"]) . ' เรียบร้อย." />');
  } else {
    die('<meta http-equiv="refresh" content="0; URL=admin/' . $_GET["p"] . '.php?p=' . $_GET["p"] . '&alert=success&title=สำเร็จ&msg=ลบข้อมูล ' . ucfirst($_GET["p"]) . ' เรียบร้อย." />');
  }
  // die();
}

// * Research insert
if (isset($_POST["fst"]) && $_POST["fst"] == "research_append") {
  $api_url = $fnc->api_url_personal . $_POST["res_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  if (!isset($_POST["department_name"])) {
    $_POST["department_name"] = '';
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["res_period_begin"]);
  $sql = "INSERT INTO `research` (`res_owner_citizenid`, `res_owner_prename`, `res_owner_firstname`, `res_owner_lastname`, `department_name`, 
`res_name`, `res_ratio`, `res_period_begin`, `res_period_finish`, `res_fiscalyear`, 
`res_budget_source`, `res_budget`, `res_budget_province`, `res_tier`, `res_detail`, `res_create_datetime`, `res_status`, `res_editor`, `res_lastupdate`) 
 VALUES ('" . $_POST["res_owner_citizenid"] . "', '" . addslashes($owner["titlePosition"]) . "', '" . addslashes($owner["firstName"]) . "', '" . addslashes($owner["lastName"]) . "', '" . addslashes($_POST["department_name"]) . "', 
 '" . addslashes($_POST["res_name"]) . "', '" . addslashes($_POST["res_ratio"]) . "', '" . $_POST["res_period_begin"] . "', '" . $_POST["res_period_finish"] . "', '" . $fiscal_year . "', 
 '" . addslashes($_POST["res_budget_source"]) . "', " . $_POST["res_budget"] . ", '" . addslashes($_POST["res_budget_province"]) . "', '" . addslashes($_POST["res_tier"]) . "', '" . addslashes($_POST["res_detail"]) . "', current_timestamp(), 'enable', 'Admin', current_timestamp())";

  //  die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/research.php?p=research&alert=success&title=สำเร็จ&msg=บันทึกข้อมูล Research เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "research_update") {
  $api_url = $fnc->api_url_personal . $_POST["res_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";
  if (empty($_POST["res_researchID"])) {
    $_POST["res_researchID"] = 'NULL';
  }
  if (empty($_POST["res_researchCode"])) {
    $_POST["res_researchCode"] = 'NULL';
  }
  if (isset($_POST["department_name"])) {
    $department_name = ",`department_name`='" . $_POST["department_name"] . "'";
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["res_period_begin"]);
  $sql = "UPDATE `research` SET `res_researchID`=" . $_POST["res_researchID"] . ",`res_researchCode`='" . $_POST["res_researchCode"] . "',`res_owner_citizenid`='" . $_POST["res_owner_citizenid"] . "',`res_owner_prename`='" . addslashes($owner["titlePosition"]) . "',`res_owner_firstname`='" . addslashes($owner["firstName"]) . "',`res_owner_lastname`='" . addslashes($owner["lastName"]) . "'" . $department_name . ",
`res_name`='" . addslashes($_POST["res_name"]) . "',`res_ratio`='" . $_POST["res_ratio"] . "',`res_period_begin`='" . $_POST["res_period_begin"] . "',`res_period_finish`='" . $_POST["res_period_finish"] . "',`res_fiscalyear`='" . $fiscal_year . "',
`res_budget_source`='" . addslashes($_POST["res_budget_source"]) . "',`res_budget`=" . $_POST["res_budget"] . ",`res_budget_province`='" . addslashes($_POST["res_budget_province"]) . "',`res_tier`='" . addslashes($_POST["res_tier"]) . "',
`res_detail`='" . addslashes($_POST["res_detail"]) . "',`res_editor`='Admin',`res_lastupdate`=CURRENT_TIMESTAMP() WHERE `res_id` = " . $_POST["res_id"];

  //   $sql = "UPDATE `research` SET `jour_owner_citizenid`='" . $_POST["jour_owner_citizenid"] . "',`jour_owner_prename`='" . addslashes($owner["titlePosition"]) . "',`jour_owner_firstname`='" . addslashes($owner["firstName"]) . "',`jour_owner_lastname`='" . addslashes($owner["lastName"]) . "'" . $department_name . ",
  // `jour_study`='" . addslashes($_POST["jour_study"]) . "',`jour_ratio`='" . $_POST["jour_ratio"] . "',`jour_tier`='" . $_POST["jour_tier"] . "',`jour_research`='" . addslashes($_POST["jour_research"]) . "',`jour_value`='" . addslashes($_POST["jour_value"]) . "',
  // `jour_volume_issue`='" . addslashes($_POST["jour_volume_issue"]) . "',`jour_page`='" . addslashes($_POST["jour_page"]) . "',`jour_link`='" . addslashes($_POST["jour_link"]) . "',`jour_date_avaliable`='" . addslashes($_POST["jour_date_avaliable"]) . "',`jour_fiscalyear`='" . $fiscal_year . "',
  // `jour_detail`='" . addslashes($_POST["jour_detail"]) . "',`jour_notes`='" . addslashes($_POST["jour_notes"]) . "',`jour_editor`='Admin',`jour_lastupdate`=CURRENT_TIMESTAMP() WHERE jour_id = " . $_POST["jour_id"];

  // die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/research.php?p=research&act=viewinfo&rid=' . $_POST["res_id"] . '&alert=success&title=สำเร็จ&msg=ปรับปรุงข้อมูล Research เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "CoWorkerIntAppend") {
  $api_url = $fnc->api_url_personal . $_POST["cow_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, 	department_name, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "','" . $_POST["cow_citizenid"] . "','" . $owner["titlePosition"] . "','" . $owner["firstName"] . "','" . $owner["lastName"] . "','" . addslashes($_POST["department_name"]) . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  switch ($_POST["ref_table"]) {
    case "proceeding":
      $link_back = 'proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"];
      break;
    case "journal":
      $link_back = 'journal.php?p=journal&act=coWorker&jid=' . $_POST["ref_id"];
      break;
    case "research":
      $link_back = 'research.php?p=research&act=coWorker&rid=' . $_POST["ref_id"];
      break;
    case "project":
      $link_back = 'project.php?p=project&act=coWorker&pid=' . $_POST["ref_id"];
      break;
  }
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน ' . ucfirst($_POST["ref_table"]) . ' เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "CoWorkerExtAppend") {
  $sql = "INSERT INTO co_worker(cow_ref_table, cow_ref_id, cow_citizenid, cow_prename, cow_firstname, cow_lastname, cow_ratio, cow_status, cow_editor) VALUES 
  ('" . $_POST["ref_table"] . "','" . $_POST["ref_id"] . "',NULL,'" . $_POST["cow_prename"] . "','" . $_POST["cow_firstname"] . "','" . $_POST["cow_lastname"] . "','" . $_POST["cow_ratio"] . "','enable','Admin')";
  // die($sql);
  switch ($_POST["ref_table"]) {
    case "proceeding":
      $link_back = 'proceeding.php?p=proceeding&act=coWorker&pid=' . $_POST["ref_id"];
      break;
    case "journal":
      $link_back = 'journal.php?p=journal&act=coWorker&jid=' . $_POST["ref_id"];
      break;
    case "research":
      $link_back = 'research.php?p=research&act=coWorker&rid=' . $_POST["ref_id"];
      break;
    case "project":
      $link_back = 'project.php?p=project&act=coWorker&pid=' . $_POST["ref_id"];
      break;
  }
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/' . $link_back . '&alert=success&title=สำเร็จ&msg=เพิ่มผู้ร่วมงานใน ' . ucfirst($_POST["ref_table"]) . ' เรียบร้อย." />';
  die();
}

// * Academic Service Project insert
if (isset($_POST["fst"]) && $_POST["fst"] == "project_append") {
  $api_url = $fnc->api_url_personal . $_POST["proj_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";

  if (!isset($_POST["department_name"])) {
    $_POST["department_name"] = '';
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["proj_period_begin"]);
  $sql = "INSERT INTO `project`(`proj_owner_citizenid`, `proj_owner_prename`, `proj_owner_firstname`, `proj_owner_lastname`, `department_name`, 
  `proj_name`, `proj_budget`, `proj_budget_source`, `proj_period_begin`, `proj_period_finish`, `proj_fiscalyear`, 
  `proj_target`, `proj_detail`, `proj_create_datetime`, `proj_status`, `proj_editor`, `proj_lastupdate`) 
  VALUES ('" . $_POST["proj_owner_citizenid"] . "', '" . addslashes($owner["titlePosition"]) . "', '" . addslashes($owner["firstName"]) . "', '" . addslashes($owner["lastName"]) . "', '" . addslashes($_POST["department_name"]) . "', 
  '" . addslashes($_POST["proj_name"]) . "', '" . addslashes($_POST["proj_budget"]) . "', '" . addslashes($_POST["proj_budget_source"]) . "', '" . $_POST["proj_period_begin"] . "', '" . $_POST["proj_period_finish"] . "', '" . $fiscal_year . "', 
  '" . addslashes($_POST["proj_target"]) . "', '" . addslashes($_POST["proj_detail"]) . "', current_timestamp(), 'enable', 'Admin', current_timestamp())";

  //  die($sql);
  $fnc->sql_execute($sql);
  echo '<meta http-equiv="refresh" content="0; URL=admin/project.php?p=project&alert=success&title=สำเร็จ&msg=บันทึกข้อมูล project เรียบร้อย." />';
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "project_update") {
  $api_url = $fnc->api_url_personal . $_POST["proj_owner_citizenid"];
  $owner = $MJU_API->GetAPI_array($api_url)[0];
  // echo "<pre>";
  // print_r($owner);
  // echo "</pre>";
  if (empty($_POST["proj_projectID"])) {
    $_POST["proj_projectID"] = NULL;
  }
  if (isset($_POST["department_name"])) {
    $department_name = ",`department_name`='" . $_POST["department_name"] . "'";
  }
  $fiscal_year = $fnc->get_fiscal_year($_POST["proj_period_begin"]);
  $sql = "UPDATE `project` SET `proj_owner_citizenid`='" . $_POST["proj_owner_citizenid"] . "',`proj_owner_prename`='" . addslashes($owner["titlePosition"]) . "',`proj_owner_firstname`='" . addslashes($owner["firstName"]) . "',`proj_owner_lastname`='" . addslashes($owner["lastName"]) . "'" . $department_name . ",
`proj_name`='" . addslashes($_POST["proj_name"]) . "',`proj_budget`=" . $_POST["proj_budget"] . ",`proj_budget_source`='" . addslashes($_POST["proj_budget_source"]) . "',`proj_period_begin`='" . $_POST["proj_period_begin"] . "',`proj_period_finish`='" . $_POST["proj_period_finish"] . "',`proj_fiscalyear`='" . $fiscal_year . "',
`proj_target`='" . addslashes($_POST["proj_target"]) . "',`proj_detail`='" . addslashes($_POST["proj_detail"]) . "',`proj_editor`='Admin',`proj_lastupdate`=CURRENT_TIMESTAMP() WHERE `proj_id` = " . $_POST["proj_id"];

  //   $sql = "UPDATE `project` SET `proj_projectID`=" . $_POST["proj_projectID"] . ",`proj_owner_citizenid`='" . $_POST["proj_owner_citizenid"] . "',`proj_owner_prename`='" . addslashes($owner["titlePosition"]) . "',`proj_owner_firstname`='" . addslashes($owner["firstName"]) . "',`proj_owner_lastname`='" . addslashes($owner["lastName"]) . "'" . $department_name . ",
  // `proj_name`='" . addslashes($_POST["proj_name"]) . "',`proj_budget`=" . $_POST["proj_budget"] . ",`proj_budget_source`='" . addslashes($_POST["proj_budget_source"]) . "',`proj_period_begin`='" . $_POST["proj_period_begin"] . "',`proj_period_finish`='" . $_POST["proj_period_finish"] . "',`proj_fiscalyear`='" . $fiscal_year . "',
  // `proj_budget_province`='" . addslashes($_POST["proj_budget_province"]) . "',`proj_tier`='" . addslashes($_POST["proj_tier"]) . "',
  // `proj_detail`='" . addslashes($_POST["proj_detail"]) . "',`proj_editor`='Admin',`proj_lastupdate`=CURRENT_TIMESTAMP() WHERE `proj_id` = " . $_POST["proj_id"];

  // die($sql);
  $fnc->sql_execute($sql);
  die('<meta http-equiv="refresh" content="0; URL=admin/project.php?p=project&act=viewinfo&rid=' . $_POST["proj_id"] . '&alert=success&title=สำเร็จ&msg=ปรับปรุงข้อมูล Academic Service Project เรียบร้อย." />');
  // die();
}

// * Activity insert
if (isset($_POST["fst"]) && $_POST["fst"] == "activity_append") {
  if (empty($_POST["pa_period_finish"])) {
    $_POST["pa_period_finish"] = $_POST["pa_period_begin"];
  }
  $sql = "INSERT INTO `project_activity`(`proj_id`, `pa_period_begin`, `pa_period_finish`, `pa_location`, `pa_participant`, `pa_participant_number`, `pa_detail`, `pa_create_datetime`, `pa_status`, `pa_editor`, `pa_lastupdate`) 
VALUES ('" . $_POST["pid"] . "','" . $_POST["pa_period_begin"] . "','" . $_POST["pa_period_finish"] . "','" . addslashes($_POST["pa_location"]) . "','" . addslashes($_POST["pa_participant"]) . "','" . $_POST["pa_participant_number"] . "','" . addslashes($_POST["pa_detail"]) . "',CURRENT_TIMESTAMP(),'enable','admin',CURRENT_TIMESTAMP())";

  //  die($sql);
  $fnc->sql_execute($sql);
  die('<meta http-equiv="refresh" content="0; URL=admin/project.php?p=activity&act=view&pid=' . $_POST["pid"] . '&alert=success&title=สำเร็จ&msg=บันทึกข้อมูล project เรียบร้อย." />');
  die();
}

if (isset($_POST["fst"]) && $_POST["fst"] == "activity_update") {
  $sql = "UPDATE `project_activity` SET `pa_period_begin`='" . $_POST["pa_period_begin"] . "',`pa_period_finish`='" . $_POST["pa_period_finish"] . "',
`pa_location`='" . addslashes($_POST["pa_location"]) . "',`pa_participant`='" . addslashes($_POST["pa_participant"]) . "',
`pa_participant_number`='" . $_POST["pa_participant_number"] . "',`pa_detail`='" . addslashes($_POST["pa_detail"]) . "',`pa_editor`='admin',
`pa_lastupdate`=CURRENT_TIMESTAMP WHERE `pa_id` = " . $_POST["paid"];

  // die($sql);
  $fnc->sql_execute($sql);
  die('<meta http-equiv="refresh" content="0; URL=admin/project.php?p=activity&act=info&pid=' . $_POST["pid"] . '&paid=' . $_POST["paid"] . '&alert=success&title=สำเร็จ&msg=ปรับปรุงข้อมูล Academic Service Project เรียบร้อย." />');
  die();
}

echo "condition fails / "; // . $_POST["fst"];
