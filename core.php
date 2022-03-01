<?php
session_start();
$_SESSION['coding_indent'] = 1;

// ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

class Constants
{
  // public $google_analytic_id = 'G-62GTDQF33N';
  public $system_name = "ECON Research";
  public $system_org = "ECON";
  // public $system_version = '3';
  public $system_path = '/dev/econ_research/';
  public $system_debug = true;
  public $database_sample = false;
  // public $system_alert = false;
  public $system_meta_redirect = 1;
  public $month_name = array(1 => "ม.ค.", 2 => "ก.พ.", 3 => "มี.ค.", 4 => "เม.ย.", 5 => "พ.ค.", 6 => "มิ.ย.", 7 => "ก.ค.", 8 => "ส.ค.", 9 => "ก.ย.", 10 => "ต.ค.", 11 => "พ.ย.", 12 => "ธ.ค.");
  public $month_fullname = array(1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม");
  public $api_url_personal = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
}

class CommonFnc extends Constants
{
  public function debug_console($val1, $val2 = null)
  {
    // if (!empty($_SESSION["member"]["setting"]) && $_SESSION["member"]["setting"]["setting_debug_show"] && $_SESSION["member"]["auth_lv"] >= 9) {
    if ($this->system_debug === true) {
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
  }

  public function get_client_info()
  {
    $data = array();
    foreach ($_SERVER as $key => $value) {
      // $data .= '$_SERVER["' . $key . '"] = ' . $value . '<br />';
      array_push($data, '$_SERVER["' . $key . '"] = ' . $value);
    }
    return $data;
  }

  public function get_page_info($parameter = null)
  {
    if (!$parameter) {
      $indicesServer = [
        'PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO',
      ];

      // $data = '<table cellpadding="10">';
      $val = "page info : \\n";
      foreach ($indicesServer as $arg) {
        if (isset($_SERVER[$arg])) {
          // $data .= '<tr><td>' .
          //     $arg .
          //     '</td><td>' .
          //     $_SERVER[$arg] .
          //     '</td></tr>';
          // $this->debug_console($arg . " = " . $_SERVER[$arg]);
          $val .= $arg . ' = ' . $_SERVER[$arg] . "\\n";
        } else {
          // $data .= '<tr><td>' . $arg . '</td><td>-</td></tr>';
          // $this->debug_console($arg . " = -");
          $val .= $arg . ' = -' . "\\n";
        }
      }
      // $data .= '</table>';            
      $this->debug_console($val);
      return $val;
    } else {
      switch ($parameter) {
        case 'thisfilename':
          if (strripos($_SERVER['PHP_SELF'], '/')) {
            $data = substr(
              $_SERVER['PHP_SELF'],
              strripos($_SERVER['PHP_SELF'], '/') + 1
            );
          } else {
            $data = substr(
              $_SERVER['PHP_SELF'],
              strripos($_SERVER['PHP_SELF'], '/')
            );
          }
          // $this->debug_console("this file name = " . $data);
          return $data;
          break;
        case 'parameter':
          if (strripos($_SERVER['REQUEST_URI'], '?')) {
            parse_str(
              substr(
                $_SERVER['REQUEST_URI'],
                strripos($_SERVER['REQUEST_URI'], '?') + 1
              ),
              $data
            );
          } else {
            parse_str(substr($_SERVER['REQUEST_URI'], 0), $data);
          }
          // print_r($data);
          return $data;
          break;
      }
    }
  }

  public function get_url_filename($val = true)
  {
    if ($val === true) {
      $val = $_SERVER['PHP_SELF'];
    }
    if (isset($val)) {
      if (strpos($val, '?')) {
        $val = substr($val, 0, strpos($val, '?'));
      }

      if (stristr($val, '/')) {
        $val = substr($val, strripos($val, '/') + 1);
      } else {
        $val = substr($val, strripos($val, '/'));
      }
      return $val;
    }
  }

  public function get_url_parameter($val = true, $data_array = false)
  {
    if ($val === true) {
      $val = $_SERVER['REQUEST_URI'];
    }
    if (isset($val) && stristr($val, '?')) {
      if (isset($data_array) && $data_array === true) {
        parse_str(substr($val, strpos($val, '?') + 1), $data);
        // print_r($data);
      } else {
        $data = substr($val, strpos($val, '?') + 1);
      }
      return $data;
    }
  }

  public function gen_google_analytics($id = null)
  {
    if (!isset($id) || $id != '') {
      $id = $this->google_analytic_id;
    }
    echo '<!-- Global site tag (gtag.js) - Google Analytics -->';
    echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' .
      $id .
      '"></script>';
    echo '<script>';
    echo '  window.dataLayer = window.dataLayer || [];';
    echo '  function gtag(){dataLayer.push(arguments);}';
    echo '  gtag("js", new Date());';
    echo '  gtag("config", "' . $id . '");';
    echo '</script>';
  }

  public function get_date_semi_th($current_date = NULL)
  {
    if (!isset($current_date)) {
      $current_date = date("Y-m-d");
    }
    $data = date("j", strtotime($current_date));
    $data .= " ";
    $data .= $this->month_name[(int) date("m", strtotime($current_date))];
    $data .= " ";
    $data .= substr((date("Y", strtotime($current_date)) + 543), 2);
    return $data;
  }

  public function gen_date_semi_th($current_date = NULL)
  {
    if (!isset($current_date)) {
      $current_date = date("Y-m-d");
    }
    echo date("j", strtotime($current_date));
    echo " ";
    echo $this->month_name[(int) date("m", strtotime($current_date))];
    echo " ";
    echo substr((date("Y", strtotime($current_date)) + 543), 2);
  }

  public function gen_date_range_semi_th($start_date, $end_date = "")
  {
    // echo date("M j, Y", strtotime($start_date));
    if (empty($end_date) || $end_date <= 0) {
      echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
    } else {
      if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
        if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
          if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
            echo date("j ", strtotime($start_date)) . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
          } else {
            echo date("j", strtotime($start_date)) . date("-j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
          }
        } else {
          echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . "-" . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
        }
      } else {
        echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543) . "-" . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($end_date))] . " " . (date("Y", strtotime($end_date)) + 543);
      }
    }
  }

  public function gen_date_semi_en($current_date = NULL)
  {
    if (!isset($current_date)) {
      $current_date = date("Y-m-d");
    }
    echo date("M j, Y", strtotime($current_date));
  }

  public function gen_date_range_semi_en($start_date, $end_date = "")
  {
    // echo date("M j, Y", strtotime($start_date));
    if (empty($end_date) || $end_date <= 0) {
      echo date("M j, Y", strtotime($start_date));
    } else {
      if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
        if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
          if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
            echo date("M j, Y", strtotime($start_date));
          } else {
            echo date("M j", strtotime($start_date)) . date("-j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
          }
        } else {
          echo date("M j", strtotime($start_date)) . date("-M j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
        }
      } else {
        echo date("M j, Y", strtotime($start_date)) . date("-M j, Y", strtotime($end_date));
      }
    }
  }

  public function get_date_full_thai($current_date = NULL)
  {
    if (!isset($current_date)) {
      $current_date = date("Y-m-d");
    }
    $data = date("j", strtotime($current_date));
    $data .= " ";
    $data .= $this->month_fullname[(int) date("m", strtotime($current_date))];
    $data .= " ";
    $data .= (date("Y", strtotime($current_date)) + 543);
    return $data;
  }

  public function gen_date_full_thai($current_date = NULL)
  {
    if (!isset($current_date)) {
      $current_date = date("Y-m-d");
    }
    echo date("j", strtotime($current_date));
    echo " ";
    echo $this->month_fullname[(int) date("m", strtotime($current_date))];
    echo " ";
    echo (date("Y", strtotime($current_date)) + 543);
  }

  public function get_fiscal_year($date = NULL)
  {
    if ($date == NULL) {
      $date = date('Y-m-d H:i:s');
    }
    // echo "date= " . $date;
    // echo ", month= " . $date_m = date("m", strtotime($date));
    // echo ", year= " . $date_y = (date("Y", strtotime($date))+543);
    if (date("m", strtotime($date)) >= 10) {
      return (date("Y", strtotime($date)) + 543) + 1;
    }
    return (date("Y", strtotime($date)) + 543);
  }

  public function gen_alert($alert_sms, $alert_title = 'Alert!!', $alert_style = 'danger')
  {
    // echo '<div class="app-wrapper">';
    echo '<div class="container col-12 mt-3">';
    // echo '<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">';
    echo '<div class="alert alert-' . $alert_style . ' alert-dismissible fade show" role="alert">';
    echo '<div class="inner">';
    echo '<div class="app-card-body p-3 p-lg-4">';
    echo '<h3 class="mb-3 text-' .
      $alert_style .
      '">' .
      $alert_title .
      '</h3>';
    echo '<div class="row gx-5 gy-3">';
    echo '<div class="col-12">';
    echo '<div class="text-center">' . $alert_sms . '</div>';
    echo '</div>';
    echo '</div>';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    // echo '</div>';
    $this->debug_console($alert_sms);
  }

  public function get_alert($method)
  {
    switch ($method) {
      case "replied":
        $this->gen_alert("ทำการส่งอีเมลตอบกลับเรียบร้อย.", "Email Sent", "info");
    }
  }

  public function date_diff($date1)
  {
    $date1 = date_create($date1);
    $date2 = date_create(date("Y") . "-" . date("m") . "-" . date("d"));
    $diff = date_diff($date2, $date1);
    //echo $diff->format("%R%a days");
    //        $this->debug_console($diff->format("%R%a"));
    if ($diff->format("%R%a") < 0) {
      //            $this->debug_console("false");
      // return false;
    } else {
      // $this->debug_console("true: " . $diff->format("%R%a"));
      //            $this->debug_console("true");
      // return $diff->format("%R%a");
      return true;
    }
  }

  public function get_time_ago($time)
  {
    $time_difference = time() - $time;

    if ($time_difference < 1) {
      return 'less than 1 second ago';
    }
    // $condition = array(
    //     12 * 30 * 24 * 60 * 60 =>  'year',
    //     30 * 24 * 60 * 60       =>  'month',
    //     24 * 60 * 60            =>  'day',
    //     60 * 60                 =>  'hour',
    //     60                      =>  'minute',
    //     1                       =>  'second'
    // );
    $condition = array(
      12 * 30 * 24 * 60 * 60 =>  'yr',
      30 * 24 * 60 * 60       =>  'month',
      24 * 60 * 60            =>  'day',
      60 * 60                 =>  'hr',
      60                      =>  'min',
      1                       =>  'sec'
    );

    foreach ($condition as $secs => $str) {
      $d = $time_difference / $secs;

      if ($d >= 1) {
        $t = round($d);
        // return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        return '' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
      }
    }
  }

  public function gen_password_complexity($chr_len = 8)
  {
    $complex_str = "";
    for ($i = 1; $i <= $chr_len; $i++) {
      $rnd_char_type = (rand(1, 4));
      switch ($rnd_char_type) {
        case "1":
          $complex_str .= chr(rand(65, 90)); // Uppercase characters of European languages (A through Z)
          break;
        case "2":
          $complex_str .= chr(rand(97, 112)); // Lowercase characters of European languages (a through z, sharp-s)
          break;
        case "3":
          $complex_str .= chr(rand(48, 57)); // Base 10 digits (0 through 9)
          break;
        case "4":
          $complex_str .= chr(rand(35, 38)); // Nonalphanumeric characters
          break;
      }
    }
    return $complex_str;;
  }

  public function gen_titlePosition_short($titlePosition)
  {
    $titlePosition = str_replace('รองศาสตราจารย์', 'รศ.', $titlePosition);
    $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์', 'ผศ.', $titlePosition);
    $titlePosition = str_replace('ศาสตราจารย์', 'ศ.', $titlePosition);
    $titlePosition = str_replace('อาจารย์', 'อ.', $titlePosition);
    return $titlePosition;
  }
}

class database extends CommonFnc
{
  protected $mysql_server = "10.1.3.5:3306";
  protected $mysql_user = "econ_research";
  protected $mysql_pass = "faedadmin";
  protected $mysql_name = "econ_research";
  // protected $mysql_name = "soth_sample";

  public function open_conn()
  {
    // $conn = mysqli_connect('10.1.3.5', 'faed_ddm', 'faedadmin', 'faed_ddm');        
    // $conn = new mysqli($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
    //$conn = new mysqli("10.1.3.5:3306","rims","faedamin","research_rims");
    if ($this->database_sample === true) {
      $mysql_name = "soth_sample";
    }
    $conn = mysqli_connect($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
    if (mysqli_connect_errno()) {
      // die("Failed to connect to MySQL: " . mysqli_connect_error());
      $this->debug_console("MySQL Error!" . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
  }

  public function get_result($sql)
  {
    $result = $this->open_conn()->query($sql);
    return $result;
  }

  public function sql_execute($sql)
  {
    //$this->open_conn()->query($sql);
    $conn = $this->open_conn();
    $conn->query($sql);
    return $conn->insert_id;
  }

  public function sql_execute_multi($sql)
  {
    $conn = $this->open_conn();
    $conn->multi_query($sql);
  }

  public function sql_execute_debug($st = "", $sql)
  {
    if ($st != "") {
      if ($st == "die") {
        $this->debug_console("SQL: " . $sql);
      } else {
        $this->debug_console("SQL: " . $sql);
      }
    } else {
      //$this->open_conn()->query($sql);
      $conn = $this->open_conn();
      $conn->query($sql);
      return $conn->insert_id;
    }
  }

  public function sql_secure_string($str)
  {
    return mysqli_real_escape_string($this->open_conn(), $str);
  }

  public function get_db_row($sql)
  {
    if (isset($sql)) {
      $result = $this->get_result($sql);
      if (!empty($result)) {;
        // if ($result->num_rows > 0) {;
        return $result->fetch_assoc();
      }
      return NULL;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_db_rows($sql)
  {
    if (isset($sql)) {
      $result = $this->get_result($sql);
      // if ($result->num_rows > 0) {;
      if (!empty($result)) {
        return $result->fetch_all(MYSQLI_ASSOC);
      }
      return NULL;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_db_col_name($sql)
  {
    if (isset($sql)) {
      // $column = array("name", "orgname", "table", "orgtable", "def", "db", "catalog", "max_length", "length", "charsetnr", "flags", "type", "decimals");
      $column = array();
      $result = $this->get_result($sql);
      while ($col = $result->fetch_field()) {
        array_push($column, $col->name);
      }
      return $column;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_db_array($sql, $type = 'key')
  {
    if (isset($sql)) {
      $result = $this->get_result($sql);
      // if ($result->num_rows > 0) {
      if (!empty($result)) {
        if ($type == 'key') {
          return $result->fetch_all(MYSQLI_ASSOC);
        } else {
          return $result->fetch_all(MYSQLI_NUM);
        }
      }
      return NULL;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_db_array_noKey($sql)
  {
    if (isset($sql)) {
      $result = $this->get_result($sql);
      // if ($result->num_rows > 0) {
      if (!empty($result)) {
        return $result->fetch_all(MYSQLI_NUM);
      }
      return NULL;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_dataset_array($sql, $method = "MYSQLI_NUM")
  {
    // * method = MYSQLI_NUM, MYSQLI_ASSOC, MYSQLI_BOTH
    return $this->open_conn()->query($sql)->fetch_all(MYSQLI_BOTH);
  }

  public function get_db_col($sql)
  {
    if (isset($sql)) {
      //echo $this->debug("", "fnc get_db_col sql: " . $sql);
      $result = $this->get_result($sql);
      // if ($result->num_rows > 0) {
      if (!empty($result)) {
        $row = $result->fetch_array();
        return $row[0];
      }
      return NULL;
    } else {
      die("fnc get_db_col no sql parameter.");
    }
  }

  public function get_last_id($tbl = "activity", $col = "act_id")
  {
    $sql = "select " . $col . " from " . $tbl;
    $sql .= " order by " . $col . " Desc Limit 1";
    return $this->get_db_col($sql);
  }
}

class Thailand_Province extends CommonFnc
{

  public function open_conn_thailand()
  {
    $mysql_server = "10.1.3.5:3306";
    $mysql_user = "alumni";
    $mysql_pass = "faedadmin";
    $mysql_db = "thailand";
    $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
    if (mysqli_connect_errno()) {
      // die("Failed to connect to MySQL: " . mysqli_connect_error());
      $this->debug_console("MySQL Error!" . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
  }

  public function get_province_subdistrict($SubDistrictID = NULL)
  {
    $sql = "Select 
        dis.zip_code As zipcode, 
        dis.name_th As subdistrict_name_th, dis.name_en As subdistrict_name_en, 
        amp.name_th As district_name_th, amp.name_en As district_name_en, 
        pro.name_th As province_name_th, pro.name_en As province_name_en, 
        geo.name As geocity_name_th
        From districts dis Left Join amphures amp On amp.id = dis.amphure_id Left Join provinces pro On pro.id = amp.province_id Left Join geographies geo On geo.id = pro.geography_id
        Where dis.id = " . $SubDistrictID;
    $query = mysqli_query($this->open_conn_thailand(), $sql);
    return $query->fetch_all(MYSQLI_ASSOC);
  }

  public function gen_province_dropdown_form()
  {
    $sql = "SELECT * FROM provinces ORDER BY name_th";
    $query = mysqli_query($this->open_conn_thailand(), $sql);
    echo '<form action="?provice=true" method="GET" class="col-10">';
    echo '<div class="form-row">
            <div class="form-group col-md-4 mb-2">
                <label for="province">จังหวัด</label>
                <select name="province_id" id="province" class="form-select">
                    <option value="">เลือกจังหวัด</option>';
    while ($result = mysqli_fetch_assoc($query)) :
      echo '
            <option value="' . $result['id'] . '">' . $result['name_th'] . '</option>';
    endwhile;
    echo '</select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="amphure">อำเภอ</label>
                <select name="amphure_id" id="amphure" class="form-select">
                    <option value="">เลือกอำเภอ</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="district">ตำบล</label>
                <select name="district_id" id="district" class="form-select">
                    <option value="">เลือกตำบล</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="zip">รหัสไปรษณีย์</label>
                <input type="text" name="zip" id="zip" class="form-control">                
            </div>
            <input type="hidden" id="subdistrict_code" name="subdistrict_code">
        </div>';
    echo '<button type="submit" id="submit_btn" name="submit_btn" class="btn btn-primary mt-3" disabled>Sending</button>';
    echo '</form>';
    echo '';
  }

  public function gen_provice_script_js()
  {
    echo "<script type=text/javascript>
        $(function(){
            var provinceObject = $('#province');
            var amphureObject = $('#amphure');
            var districtObject = $('#district');            
            
            // on change province
            provinceObject.on('change', function(){
                var provinceId = $(this).val();
                
                amphureObject.html('<option value=>เลือกอำเภอ</option>');
                districtObject.html('<option value=>เลือกตำบล</option>');
                
                $.get('get_thailand.php?province_id=' + provinceId, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        amphureObject.append(
                            $('<option></option>').val(item.id).html(item.name_th)
                        );
                    });
                });
            });
            
            // on change amphure
            amphureObject.on('change', function(){
                var amphureId = $(this).val();         
                districtObject.html('<option value=>เลือกตำบล</option>');
                
                $.get('get_thailand.php?amphure_id=' + amphureId, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        districtObject.append(
                            $('<option></option>').val(item.id).html(item.name_th)
                        );
                    });
                });
            });
            
            // on change sub-district
            districtObject.on('change', function(){
                var districtId = $(this).val();
                
                $.get('get_thailand.php?district_id=' + districtId, function(data){
                    var result = JSON.parse(data);
                    document.getElementById('zip').value = result[0].zip_code;            
                    document.getElementById('subdistrict_code').value = result[0].id;                           
                });
                
                document.getElementById('submit_btn').disabled = false;
            });
        });
        </script>";
  }
}

class Web extends database
{

  public function array_remove_data($search_citizenId, $array_data)
  {
    // $i = 0;
    // echo "find : " . $search_citizenId . "<br>";
    // foreach ($array_data as $econ_member) {
    // echo "<pre>";
    // print_r($array_data);
    // echo "</pre>";
    for ($i = 0; $i < count($array_data); $i++) {
      // echo "sample array data : " . $array_data[$i]["citizenId"] . " = " . $search_citizenId . "<br>";
      // echo "found: " . $array_data[$i]["citizenId"] . "<br>";
      if ($array_data[$i]["citizenId"] == $search_citizenId) {
        unset($array_data[$i]);
        // echo "remove id completed.<br>";
        return $array_data;
        die();
      }
    }
    return $array_data;
  }

  public function econ_member_remove_exists($page, $id, $econ_member, $show = "")
  {
    $fnc = new web;
    switch ($page) {
      case "proceeding":
        $sql_owner = "Select pro_owner_citizenid as citizen_id From " . $page . " Where pro_id = " . $id;
        $owner_data = $fnc->get_db_row($sql_owner);
        $sql_coworker = "Select cow_citizenid as citizen_id From co_worker Where cow_ref_table = '" . $page . "' And cow_ref_id = " . $id;
        $coworker_data = $fnc->get_db_array($sql_coworker);
        break;
      case "journal":
        $sql_owner = "Select jour_owner_citizenid as citizen_id From " . $page . " Where jour_id = " . $id;
        $owner_data = $fnc->get_db_row($sql_owner);
        $sql_coworker = "Select cow_citizenid as citizen_id From co_worker Where cow_ref_table = '" . $page . "' And cow_ref_id = " . $id;
        $coworker_data = $fnc->get_db_array($sql_coworker);
        break;
      case "research":
        $sql_owner = "Select res_owner_citizenid as citizen_id From " . $page . " Where res_id = " . $id;
        $owner_data = $fnc->get_db_row($sql_owner);
        $sql_coworker = "Select cow_citizenid as citizen_id From co_worker Where cow_ref_table = '" . $page . "' And cow_ref_id = " . $id;
        $coworker_data = $fnc->get_db_array($sql_coworker);
        break;
      case "project":
        $sql_owner = "Select proj_owner_citizenid as citizen_id From " . $page . " Where proj_id = " . $id;
        $owner_data = $fnc->get_db_row($sql_owner);
        $sql_coworker = "Select cow_citizenid as citizen_id From co_worker Where cow_ref_table = '" . $page . "' And cow_ref_id = " . $id;
        $coworker_data = $fnc->get_db_array($sql_coworker);
        break;
    }
    if (empty($show) || $show != "owner") {
      $econ_member = $this->array_remove_data($owner_data["citizen_id"], $econ_member);
    }
    if (!empty($coworker_data)) {
      foreach ($coworker_data as $cow) {
        if (!empty($cow["citizen_id"])) {
          $econ_member = $this->array_remove_data($cow["citizen_id"], $econ_member);
        }
      }
    }
    return $econ_member;
  }
}

class MJU_API extends CommonFnc
{
  private $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/20500";
  public function get_api_info($title = "", $api_url, $print_r = false)
  {
    $array_data = $this->GetAPI_array($api_url);
    echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
    echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($array_data) . "</br>";
    echo "#column: " . $this->get_col_count($array_data) . "</br>";
    echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
    $this->get_col_name($array_data, true);
    echo "</span></h4><hr>";
    if ($print_r) {
      print_r($array_data);
      echo "<hr>";
    }
  }

  public function get_row_count($array, $print_r = false)
  {
    return count($array);
  }

  public function get_col_count($array, $print_r = false)
  {
    return count($array[0]);
  }

  public function get_col_name($array, $print_r = false)
  {
    if ($print_r) {
      print_r(array_keys($array[0]));
    }
    return array_keys($array[0]);
  }

  public function gen_array_filter($array, $key, $value)
  {
    $result = array();
    foreach ($array as $k => $val) {
      if ($val[$key] == $value) {
        array_push($result, $array[$k]);
      }
    }
    return $result;
  }

  public function get_array_filters($array, $key1, $value1, $key2 = null, $value2 = null, $key3 = null, $value3 = null, $key4 = null, $value4 = null, $key5 = null, $value5 = null)
  {
    $result = $array;
    $this->debug_console("get_array_filter2 started");

    if ($key5 && $value5) {
      $result = $this->gen_array_filter($result, $key5, $value5);
      $this->debug_console("gen_array_filter condition #5 completed");
    }
    if ($key4 && $value4) {
      $result = $this->gen_array_filter($result, $key4, $value4);
      $this->debug_console("gen_array_filter condition #4 completed");
    }
    if ($key3 && $value3) {
      $result = $this->gen_array_filter($result, $key3, $value3);
      $this->debug_console("gen_array_filter condition #3 completed");
    }
    if ($key2 && $value2) {
      $result = $this->gen_array_filter($result, $key2, $value2);
      $this->debug_console("gen_array_filter condition #2 completed");
    }
    if ($key1 && $value1) {
      $result = $this->gen_array_filter($result, $key1, $value1);
      $this->debug_console("gen_array_filter condition #1 completed");
    }

    if (count($result)) {
      $this->debug_console("#row of result : " . count($result));
      return $result;
    } else {
      return null;
    }
  }

  public function get_row($array_data, $num_row = 1, $print_r = false)
  {
    if (isset($array_data) && isset($num_row)) {
      return $array_data[$num_row];
    } else {
      return null;
    }
  }

  public function get_col($array_data, $num_row, $col_name, $print_r = false)
  {
    if (isset($array_data) && isset($num_row) && isset($col_name)) {
      if ($print_r) {
        print_r($array_data[$num_row][$col_name]);
      }
      return $array_data[$num_row][$col_name];
    } else {
      return null;
    }
  }

  public function get_last_id($tbl = "activity", $col = "act_id")
  {
    $sql = "select " . $col . " from " . $tbl;
    $sql .= " order by " . $col . " Desc Limit 1";
    // return $this->get_db_col($sql);
    $database = new $this->database();
    return $database->get_db_col($sql);
  }

  function arraysearch_rownum($key, $value, $array)
  {
    foreach ($array as $k => $val) {
      if ($val[$key] == $value) {
        return $k;
      }
    }
    return null;
  }

  // not Supported for SSL
  /*
    Function GetAPI_array($API_URL) {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable            
        $array_data = json_decode($data, true);

        return $array_data;
    }
    */

  // update for SSL
  function GetAPI_array($API_URL)
  {
    $arrContextOptions = array(
      "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
      ),
    );
    $data = file_get_contents($API_URL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
    $array_data = json_decode($data, true);

    return $array_data;
  }

  function GetAPI_object($API_URL)
  {
    $data = file_get_contents($API_URL); // put the contents of the file into a variable    
    $obj_data = json_decode($data); // decode the JSON to obj        
    return $obj_data;
  }
}

class Mailer extends CommonFnc
{
  public function send_email($receiver_add, $reveiver_name, $subject = "", $content = "", $return_url = "")
  {
    $data = array(
      "receiver_address" => $receiver_add,
      "receiver_name" => $reveiver_name,
      "from_address" => "tom.umnarj.soth@gmail.com",
      "from_name" => "soth admin",
      "reply_address" => "tom.umnarj.soth@gmail.com",
      "reply_name" => "soth admin",
      "subject" => "Test 5th Sending Email",
      "content" => "ทดสอบการส่ง email ด้วย phpmailer",
      "attachment" => "",
      "next_url" => "../admin/setting.php?action=completed"
    );
    // * "next_url" => "test.php", "close" is close sending email page

    if (isset($subject) && $subject != "") {
      $data["subject"] = $subject;
    }
    if (isset($content) && $content != "") {
      $data["content"] = $content;
    }
    if (isset($return_url) && $return_url != "") {
      $data["next_url"] = $return_url;
    }
    // $data["content"] = '';
    // echo "data: <br>";
    // print_r($data);
    // echo "<br><br>";

    // $data = json_encode($data);
    // $data = implode(',', $data);

    // session_start();
    // $_SESSION["data"] = $data;
    $_SESSION["data_json"] = json_encode($data, JSON_UNESCAPED_UNICODE);

    // echo "json data: <br>";
    // echo $_SESSION["data_json"];

    // echo '<br><br><hr><br><a href="mail.php?type=session&next=true" target="_blank">Mailer and comeback - OK</a>';
    // echo '<br><br><hr><br><a href="mail.php?type=session&next=close" target="_blank">Mailer new tab and close - OK</a>';
    // echo '<br><br><hr><br><a href="mail.php?type=json&next=true" target="_blank">Mailer by json - OK</a>';
    // header("Location:../phpmailer/mail.php?type=json&next=true");
    echo '<meta http-equiv="refresh" content="0;url=../phpmailer/mail.php?type=json&next=true">';
  }

  public function gen_email($data)
  {
    $database = new Database;
    $data = array(
      "receiver_address" => $_POST["receiver_address"],
      "receiver_name" => $_POST["receiver_address"],
      "from_address" => $_SESSION["admin"]["e_mail"],
      // "from_name" => $_POST["m_replyuser"],
      "from_name" => "คณะสถาปัตยกรรมศาสตร์ฯ มหาวิทยาลัยแม่โจ้",
      "reply_address" => "archmaejo@gmail.com",
      "reply_name" => "คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้",
      "cc_address" => "",
      "cc_name" => "",
      "cc_address1" => "",
      "cc_name1" => "",
      "cc_address2" => "",
      "cc_name2" => "",
      "subject" => "การตอบกลับข้อความสายตรงคณบดีของท่าน",
      "content" => $_POST["m_reply"]
    );

    // $sql = "select * from message where message_id = " . $_POST["m_id"];
    // $row = $database->get_db_row($sql);
    // $m_created = $this->get_date_semi_th($row["message_created"]);

    $content = array(
      "title" => '<div class="mb-2"><strong class="mb-2">เรียน คุณ' . $data["receiver_name"] . '</strong></div>',
      "subject" => '<div class="mb-4"><strong class="mb-2">เรื่อง ยืนยันสิทธิ์ศิษย์เก่า</strong></div>',
      "content_intro" => '',
      "content_m_memo" => '',
      "content_then" => 'ในการนี้ กดลิงค์เถอะ',
      "reply_by" => "รองคณบดีฯ",
      "reply_by_fullname" => "ผศ.พันธุ์ศักดิ์ ชัยภักดี"
    );

    $data["content"] = $this->email_content_html($content);

    // die($data["content"]);

    $_SESSION["data"] = $data;
    $this->debug_console("email data: ", $data);
    // $_SESSION["data_json"] = json_encode($data, JSON_UNESCAPED_UNICODE);
    // echo "<br>" . $_SESSION["data"] . "<hr style:margin-bottom: 1em;>";

    // $sql = "UPDATE message SET message_status='completed',message_replied=CURRENT_TIMESTAMP,message_completed=CURRENT_TIMESTAMP,message_replytext='" . $_POST["m_reply"] . "',message_replyuser='" . $_SESSION["admin"]["board_fullname"] . "',message_replyuser_position='" . $_SESSION["admin"]["board"] . "' WHERE message_id = " . $_POST["m_id"];
    // $database->sql_execute($sql);

    // header("Location:../phpmailer/mail.php?type=session&next=true");

  }

  private function email_content_html($content)
  {
    // $content_html = '<!doctype html><html lang="en">';
    $content_html = '<meta charset="UTF-8">';
    // $content_html .= '<head>';
    // $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    // $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
    // $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
    // $content_html .= '<title>ระบบสายตรงคณบดี</title>';
    $content_html .= '<style>';
    $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
    $content_html .= '.footer-text { letter-spacing: 0.1em; }';
    $content_html .= '</style>';
    // $content_html .= '</head>';

    // $content_html .= '<body>';
    $content_html .= '<div class="container col-10 col-lg-8 p-2 align-self-center" style="padding: 4em;">';
    $content_html .= '<div id="title">';
    $content_html .= $content["title"] . $content["subject"];
    $content_html .= '</div>';
    $content_html .= '<div id="content" class="text-black">';
    $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
    $content_html .= $content["content_intro"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
    $content_html .= $content["content_m_memo"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
    $content_html .= $content["content_then"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
    // $content_html .= $_POST["m_reply"];
    $content_html .= '</p>';
    $content_html .= '</div>';

    $content_html .= '<br><br>';
    $content_html .= '<div id="footer" class="mt-3 text-black">';
    $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
    $content_html .= '  <div class="mt-2 col-auto offset-6">';
    $content_html .= '      <div>';
    $content_html .= $content["reply_by_fullname"];
    $content_html .= '      </div>';
    $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
    $content_html .= '      <div>';
    $content_html .= $content["reply_by"];
    $content_html .= '      </div>';
    $content_html .= '  </div>';
    $content_html .= '</div>';

    $content_html .= '<hr class="my-4">';
    $content_html .= '<div class="row mt-1 p-2" style="content: ""; display: table; clear: both;">';
    $content_html .= '<div class="col-auto" style="float: left; width: 100px; padding: 10px;"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
    $content_html .= '<div class="col text-black-50 pt-1" style="margit-top: 2em;>';
    $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
    $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
    $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"> <a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
    $content_html .= '</p>';
    $content_html .= '</div>';
    $content_html .= '</div>';
    $content_html .= '</div>';
    // $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
    // $content_html .= '</body>';
    // $content_html .= '</html>';
    return $content_html;
  }

  private function email_content_html2($content)
  {
    $content_html = '<!doctype html><html lang="en">';
    $content_html .= '<meta charset="UTF-8">';
    $content_html .= '<head>';
    $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
    $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
    $content_html .= '<title>ระบบสายตรงคณบดี</title>';
    $content_html .= '<style>';
    $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
    $content_html .= '.footer-text { letter-spacing: 0.1em; }';
    $content_html .= '</style>';
    $content_html .= '</head>
        
        <body>';
    $content_html .= '<div class="container col-10 col-lg-8 p-2">';
    $content_html .= '<div id="title">';
    $content_html .= $content["title"] . $content["subject"];
    $content_html .= '</div>';
    $content_html .= '<div id="content" class="text-black">';
    $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
    $content_html .= $content["content_intro"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
    $content_html .= $content["content_m_memo"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
    $content_html .= $content["content_then"];
    $content_html .= '</p>';
    $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
    $content_html .= $_POST["m_reply"];
    $content_html .= '</p>';
    $content_html .= '</div>

        <div id="footer" class="mt-3 text-black">';
    $content_html .= '<br><br>
        ';
    $content_html .= '<div class="mt-2 col-auto offset-6">';
    $content_html .= '<div>';
    $content_html .= $content["reply_by_fullname"];
    $content_html .= '</div>';
    $content_html .= '<div>';
    $content_html .= $content["reply_by"];
    $content_html .= '</div>';
    $content_html .= '</div>';
    $content_html .= '</div>

        <hr class="my-4">';
    $content_html .= '<div class="row mt-1 p-2" style="">';
    $content_html .= '<div class="col-auto"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
    $content_html .= '<div class="col text-black-50 pt-1">';
    $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
    $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
    $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"><a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
    $content_html .= '</p>';
    $content_html .= '</div>';
    $content_html .= '</div>';
    $content_html .= '</div>';
    $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
    $content_html .= '</body>';
    $content_html .= '</html>';
    return $content_html;
  }
}
