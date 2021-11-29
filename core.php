<?php
session_start();
$_SESSION['coding_indent'] = 0;

ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

class Constants
{
  // public $google_analytic_id = 'G-62GTDQF33N';
  public $system_name = "ECON Research";
  public $system_org = "ECON";
  // public $system_version = '3';
  public $system_path = '/dev/econ_research/';
  // public $system_debug = false;
  public $database_sample = false;
  // public $system_alert = false;
  public $system_meta_redirect = 1;
  // public $opt_sex = array("ไม่ระบุ", "ชาย", "หญิง");
  // public $opt_blood_type = array("A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-", "อื่นๆ");
  // public $opt_so_level = array("", "SO (ฝึกหัด)", "SO", "CSO", "SOI", "IPOC");
  // public $system_auth_lv = array("0" => "not idpa member", "1" => "idpa member", "3" => "so member", "5" => "match director", "6" => "stat officer", "7" => "admin team", "9" => "developer");
  // public $system_stage = 10; // 7 = 5 stages, 8 = 8 stages, 10 = 10 stages, 15 = 15 stages
  // public $current_match_id = 10;
}

class CommonFnc extends Constants
{
  public function debug_console($val1, $val2 = null)
  {
    if (!empty($_SESSION["member"]["setting"]) && $_SESSION["member"]["setting"]["setting_debug_show"] && $_SESSION["member"]["auth_lv"] >= 9) {
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
      if ($result->num_rows > 0) {;
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
      if ($result->num_rows > 0) {;
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
      if ($result->num_rows > 0) {
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
      if ($result->num_rows > 0) {
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
      if ($result->num_rows > 0) {
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
  public function gen_qrcode_page()
  {
    echo '<div class="my-3">&nbsp;</div>';

    echo '<div class="col-12 col-md-10 col-lg-8 mx-auto text-center mt-5">
                    <img src="../images/qr_match.png" class="rounded mx-auto d-block box_shadow" style="width: 20em;">
                    <p class="h5 fw-bold mt-3">ข้อมูลแมทซ์</p>
                    <p class="h5 mt-1"><a href="https://faed.mju.ac.th/soth/match/" target="_blank" class="link-primary">https://faed.mju.ac.th/soth/match/</a></p>
                    </div>
                    ';

    echo '<div class="my-3">&nbsp;</div>';

    echo '<div class="col-12 col-md-10 col-lg-8 mx-auto text-center mt-5">
                    <img src="../images/qr_match_shooters.png" class="rounded mx-auto d-block box_shadow" style="width: 20em;">
                    <p class="h5 fw-bold mt-3">ข้อมูลนักกีฬา</p>
                    <p class="h5 mt-1"><a href="https://faed.mju.ac.th/soth/match/shooters/" target="_blank" class="link-primary">https://faed.mju.ac.th/soth/match/shooters/</a></p>
                    </div>
                    ';

    echo '<div class="my-3">&nbsp;</div>';

    echo '<div class="col-12 col-md-10 col-lg-8 mx-auto text-center mt-5">
                    <img src="../images/qr_shooter.png" class="rounded mx-auto d-block box_shadow" style="width: 20em;">
                    <p class="h5 fw-bold mt-3">ตรวจผลคะแนน</p>
                    <p class="h5 mt-1"><a href="https://faed.mju.ac.th/soth/shooter/" target="_blank" class="link-primary">https://faed.mju.ac.th/soth/shooter/</a></p>
                    </div>
                    ';

    echo '<div class="my-3">&nbsp;</div>';
  }

  public function gen_categories_shorty($cate)
  {
    $cate = str_replace("Law Enforcement", "LE", $cate);
    $cate = str_replace("Junior", "Jr", $cate);
    $cate = str_replace("Senior", "SE", $cate);
    $cate = str_replace("Lady", "LD", $cate);
    $cate = str_replace("International", "Int", $cate);
    return $cate;
  }

  public function get_match_categories($mid)
  {
    $sql = "Select scsh.shooter_categories From score_shooter scsh Where scsh.shooter_categories <> '' And  scsh.shooter_categories NOT LIKE '%,%' And scsh.match_id = " . $mid . " Group By scsh.shooter_categories Order By scsh.shooter_categories";
    $categories1 = $this->get_db_array($sql);
    $sql = "Select scsh.shooter_categories From score_shooter scsh Where scsh.shooter_categories <> '' And  scsh.shooter_categories LIKE '%,%' And scsh.match_id = " . $mid . " Group By scsh.shooter_categories Order By scsh.shooter_categories";
    $categories2 = $this->get_db_array($sql);
    // echo "cate 1 = <br>";
    // echo '<pre>';
    // print_r($categories1);
    // echo '</pre>';
    // echo "cate 2 = <br>";
    // echo '<pre>';
    // print_r($categories2);
    // echo '</pre>';
    $categories = array();
    foreach ($categories1 as $cate) {
      array_push($categories, $cate["shooter_categories"]);
    }
    // echo "categories = <br>";
    // echo '<pre>';
    // print_r($categories);
    // echo '</pre>';
    if (!empty($categories2)) {
      foreach ($categories2 as $cate) {
        $cate_sub = explode(",", $cate["shooter_categories"]);
        // echo "cate_sub = <br>";
        // echo '<pre>';
        // print_r($cate_sub);
        // echo '</pre>';
        foreach ($cate_sub as $c_sub) {
          // echo 'find TOM' . $c_sub . ' in array = ' . array_search("TOM", $categories) . '<br>';
          if (!strlen(array_search($c_sub, $categories))) {
            array_push($categories, $c_sub);
          }
        }
      }
    }
    sort($categories);
    // echo "cate all = <br>";
    // echo '<pre>';
    // print_r($categories);
    // echo '</pre>';
    return $categories;
  }

  public function gen_download_list()
  {
    echo '<div class="col-10 col-md-6">
      <div class="list-group">';
    if ($_SESSION["member"]["auth_lv"] >= 1) {
      echo '<a href="https://www.idpa.com/wp-content/uploads/2018/09/IDPA-Rulebook-2017.pdf" target="_blank" class="list-group-item list-group-item-action list-group-item-light text-primary fw-bold">Rule Books ver 2017.3</a>';
    }
    if ($_SESSION["member"]["auth_lv"] >= 3) {
      echo '<a href="../docs/SOTH-Match-Report.docx" target="_blank" class="list-group-item list-group-item-action list-group-item-light text-primary fw-bold">แบบฟอร์มรายงานผลการปฏิบัติงานของ SO</a>';
    }
    echo '</div>
    </div>';
  }

  public function gen_member_card($soid)
  {
    $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $soid;
    // $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $_GET["soid"];
    $member = $this->get_db_array($sql)[0];
    if (empty($member)) {
      die("not found user data");
    } else {
?>
      <div class="card box_shadow">
        <div class="card-header text-primary h5 text-center">
          <strong>Safety Officer Thailand</strong>
        </div>
        <div class="card-body px-4">
          <div class="text-end"><strong><?= $member["so_idpa_id"] ?><?php if (!empty($member["so_level"])) {
                                                                      echo ' : ' . $member["so_level"];
                                                                    } ?></strong></div>
          <div class="row mt-2 mt-md-0">
            <div class="col-8 col-md-4 col-lg-3 mx-auto">
              <img src="<?= "../" . $member["so_avatar"] ?>" class="img-thumbnail rounded mx-auto" alt="">
              <div class="text-center mt-2 mb-4 mb-md-0"><strong><?= $member["so_nickname"] ?></strong></div>
            </div>
            <div class="col text-start ms-3" style="font-size: 1rem;">
              <div><span class="text-uppercase"><strong><?= $member["so_firstname_en"] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $member["so_lastname_en"] ?></strong></span></div>
              <div><span class="text-capitalize"><?= $member["so_firstname"] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $member["so_lastname"] ?></span></div>

              <div class="mt-4"><?= $member["so_subdistrict"] . ", " . $member["so_district"] . ", " . $member["so_province"] ?></div>
              <div><strong>Tel.</strong> <?= $member["so_phone"] ?><br><strong>Email.</strong> <?= $member["so_email"] ?></div>
            </div>
          </div>
          <!-- <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a> -->
          <p class="lead">

          </p>
        </div>
        <div class="card-footer text-muted">
          <div class="row">
            <div class="col text-start">
              <div><strong><?= $member["so_club"] ?></strong></div>
            </div>
            <div class="col text-end">
              <?php if (isset($member["so_idpa_expire"])) {
                echo '<strong>Exp.</strong> ' . date("M, Y", strtotime($member["so_idpa_expire"]));
              } ?>
            </div>

          </div>
        </div>
      </div>
    <?php
    }
  }

  public function gen_member_info($soid)
  {
    ?>
    <div class="card box_shadow">
      <div class="card-header text-end">* Admin view only</div>
      <div class="card-body p-4" style="font-size: 1em;">
        <?php
        $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $soid;
        $row = $this->get_db_row($sql);
        $this->debug_console("so info sql: ", $sql);
        $this->debug_console("so info: ", $row);
        ?>
        <div class="row mt-2 mb-3">
          <div class="col-12 col-md-6">
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                CITIZEN ID:
              </div>
              <div class="col"><?= $row["so_citizen_id"]; ?>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                Name:
              </div>
              <div class="col">
                <p class="my-0"><?= $row["so_firstname"] . " " . $row["so_lastname"] . " (" . $row["so_nickname"] . ")"; ?></p>
                <p class="my-0"><?= $row["so_firstname_en"] . " " . $row["so_lastname_en"]; ?></p>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                DOB:
              </div>
              <div class="col"><?= date("d M Y", strtotime($row["so_dob"])); ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                SEX:
              </div>
              <div class="col"><?= $row["so_sex"] . " / Blood: " . $row["so_blood_type"] . ""; ?>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 mt-md-0 mt-4">
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                IDPA ID:
              </div>
              <div class="col"><?= $row["so_idpa_id"]; ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                CLUB:
              </div>
              <div class="col"><?= $row["so_club"]; ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                IDPA PROFILE:
              </div>
              <div class="col">
                <?= '<a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '/" target="_blank">' . 'www.idpa.com' . '</a>' ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                IDPA EXP:
              </div>
              <div class="col">
                <?php if (isset($row["so_idpa_expire"])) {
                  echo date("M d, Y", strtotime($row["so_idpa_expire"]));
                } ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                SO EXP:
              </div>
              <div class="col">
                <?php if (isset($row["so_license_expire"])) {
                  echo date("M d, Y", strtotime($row["so_license_expire"]));
                } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-0">
          <hr class="mb-4">
        </div>

        <div class="row mt-2 mb-3">
          <div class="col-12 col-md-6 mt-md-0 mt-4">
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                PHONE:
              </div>
              <div class="col">
                <?= $row["so_phone"]; ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                EMAIL:
              </div>
              <div class="col">
                <?= $row["so_email"]; ?>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                LINE ID:
              </div>
              <div class="col">
                <?= $row["so_line_id"]; ?>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="row mb-2">
              <div class="col-4 col-md-4 info-label">
                ADDRESS:
              </div>
              <div class="col">
                <p class="my-0"><?= $row["so_address"]; ?></p>
                <p class="my-0"><?= $row["so_subdistrict"] . " " . $row["so_district"]; ?></p>
                <p class="my-0"><?= $row["so_province"] . " " . $row["so_zipcode"]; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-end text-mute" style="font-size: 0.75em;">
        <?= "Last Update: " . date("M d, Y H:i", strtotime($row["so_lastupdate"])) . " / By " . $row["so_editor"]; ?>
      </div>

    </div>

  <?php
  }

  // * so on duty table show position order by priority
  public function so_on_duty($so_id)
  {
  ?>
    <div class="mt-4 mb-3">
      <h4 class="text-primary text-uppercase mt-4"><strong>ประวัติการทำงานของท่าน</strong></h4>
      <!-- <div class="card"> -->
      <div class="card-body p-0">
        <table class="table table-striped table-bordered table-hover table-responsive">
          <?php
          $sql = "Select v_on_duty.match_id, v_on_duty.match_name, v_on_duty.match_level, v_on_duty.match_begin, v_on_duty.`on-duty_position` From v_on_duty Where v_on_duty.so_id = " . $so_id . " Order By v_on_duty.match_begin Desc";
          $this->debug_console("on duty table: ", $sql);
          $dataset = $this->get_db_array($sql);
          ?>
          <thead class="thead-inverse">
            <tr class="table-success">
              <th class="text-center">#</th>
              <th class="text-center">DATE</th>
              <th>MATCH TITLE</th>
              <th class="text-center">POSITION</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (is_array($dataset)) {
              $x = 1;
              foreach ($dataset as $row) {
                echo '<tr>
                                    <td scope="row" class="text-center">' . $x . '</td>
                                    <td class="text-center">' . date("M d, Y", strtotime($row["match_begin"])) . '</td>
                                    <td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_TOP">' . $row["match_name"] . ' (' . $row["match_level"] . ')' . '</a></td>
                                    <td class="text-center">' . $row["on-duty_position"] . '</td>';
                echo '</tr>';
                $x++;
              }
            } else {
              echo '<tr>
                                <td scope="row" colspan="4" class="text-center py-3">No Data</td>
                            </tr>';
            }
            ?>
          </tbody>
        </table>

      </div>
      <!-- </div> -->
    </div>
  <?php
  }

  public function match_list()
  {
    $sql_order = NULL;
    if (isset($_GET["year"]) && strlen($_GET["year"]) == 4) {
      $sql_year = " AND year(match_begin) = '" . $_GET["year"] . "'";
    } else {
      $sql_year = "";
    }
    if (isset($_GET["filter"]) && isset($_GET["key"])) {
      $sql_filter = " AND " . $_GET["filter"] . " Like '%" . $_GET["key"] . "%'";
    } else {
      $sql_filter = "";
    }
  ?>
    <div class="mt-4 mb-3">
      <div class="row">
        <div class="col">
          <h4 class="text-primary text-uppercase"><strong>รายการ Match ในระบบฐานข้อมูล <?= "(" . $this->get_db_col("SELECT count(`match_id`) as cnt_so FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter) . " รายการ)"; ?></strong></h4>
        </div>
        <div class="col-5 col-md-3 col-lg-2 align-self-end text-end">
          <form action="?p=match" method="get">
            <?php
            if (isset($_GET['order'])) {
              echo '<input type="hidden" name="order" value="' . $_GET['order'] . '">';
            }
            if (isset($_GET['sort'])) {
              echo '<input type="hidden" name="sort" value="' . $_GET['sort'] . '">';
            }
            echo '<input type="hidden" name="p" value="' . $_GET['p'] . '">';
            $sql = "Select Year(maid.match_begin) As yrs From `match-idpa` maid Group By Year(maid.match_begin) Order By yrs Desc";
            $match_year = $this->get_db_array($sql);
            echo '<select name="year" class="form-select form-select-sm" aria-label="Default select example" onchange="this.form.submit();">';
            echo '<option';
            if (!isset($_GET["year"]) || strlen($_GET["year"]) != 4) {
              echo ' selected';
            }
            echo ' value="">แสดงทั้งหมด</option>';
            foreach ($match_year as $yrs) {
              echo '<option value="' . $yrs["yrs"] . '"';
              if (isset($_GET["year"]) && $_GET["year"] == $yrs["yrs"]) {
                echo ' selected';
              }
              echo '>แสดงปี ' . $yrs["yrs"] . '</option>';
            }
            ?>
            </select>
          </form>
        </div>
      </div>
      <table class="table table-light table-striped table-hover">
        <thead>
          <tr class="table-primary">
            <th><?php $sql_order .= $this->table_header_sorting("DATE", "match_begin", $sql_order); ?></th>
            <th><?php $sql_order .= $this->table_header_sorting("TITLE", "match_name", $sql_order); ?></th>
            <th class="text-center d-none d-md-table-cell"><?php $sql_order .= $this->table_header_sorting("LEVEL", "match_level", $sql_order); ?></th>
            <th class="text-center d-none d-md-table-cell"><?php $sql_order .= $this->table_header_sorting("STAGES", "match_stages", $sql_order); ?></th>
            <th class="d-none d-lg-table-cell"><?php $sql_order .= $this->table_header_sorting("MD", "match_md", $sql_order); ?></th>
            <th class="d-none d-lg-table-cell"><?php $sql_order .= $this->table_header_sorting("CONTACT", "match_md_contact", $sql_order); ?></th>
            <!-- <th>IDPA Expr</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable'" . $sql_year . $sql_filter;
          if (!empty($sql_order)) {
            $sql .= $sql_order;
          } else {
            $sql .= ' Order by match_begin Desc';
          }
          $this->debug_console("table match list:", $sql);
          $dataset = $this->get_db_array($sql);
          if ($dataset) {
            foreach ($dataset as $row) {
              echo '<tr>
                                        <td scope="row" style="font-size:0.8em;">' . date("M d, Y", strtotime($row["match_begin"])) . '</td>';
              if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 3) {
                if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 5) {
                  echo '<td><a href="?p=matchinfo&mid=' . $row["match_id"] . '" target="_top">' . $row["match_name"] . '</a></td>';
                } else {
                  echo '<td><a href="../match/?mid=' . $row["match_id"] . '" target="_blank">' . $row["match_name"] . '</a></td>';
                }
              } else {
                echo '<td>' . $row["match_name"] . '</td>';
              }
              echo '<td class="text-center d-none d-md-table-cell">' . $row["match_level"] . '</td>
                                        <td class="text-center d-none d-md-table-cell">' . $row["match_stages"] . '</td>
                                        <td class="d-none d-lg-table-cell">' . $row["match_md"] . '</td>
                                        <td class="d-none d-lg-table-cell">' . $row["match_md_contact"] . '</td>
                                        </tr>';
            }
          } else {
            echo '<tr><td colspan="6" class="text-center py-3">NO DATA</td></tr>';
          }
          ?>
        </tbody>
      </table>

    </div>
  <?php
  }

  public function match_detail($m_id, $share_btn = false)
  {
  ?>
    <div class="col-12 mb-4">
      <div class="row">
        <div class="col-auto">
          <h4 class="text-primary text-uppercase mt-4"><strong>
              <?php if (!empty($_GET["p"]) && $_GET["p"] == "matchinfo" && $_SESSION["member"]["auth_lv"] >= 7) { ?>
                <a href="index.php?p=match" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>
              <?php } ?>
              Match Information</strong></h4>
        </div>
        <div class="col text-end align-self-end">
          <?php if ($share_btn) {
            //  echo '<strong class="h4" style="font-weight: bold;"><a href="../guest/matchinfo.php?mid=' . $_GET["mid"] . '" target="_blank"><i class="bi bi-share-fill text-info"></i></a></strong>';
            echo '<button type="button" class="btn btn-info text-white" onclick=window.open("../match/?mid=' . $m_id . '","_blank");><i class="bi bi-share-fill me-2"></i>Share</button>';
          } ?>
        </div>
      </div>

      <div class="">
        <?php
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $this->get_db_row($sql);
        $this->debug_console("match info sql: ", $sql);
        $this->debug_console("match info: ", $row);

        $this->match_info($m_id);
        ?>

        <?php
        $this->so_on_duty_table($m_id);
        ?>

      </div>

    </div>

  <?php
  }

  public function match_info($m_id)
  {
    $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
    $row = $this->get_db_row($sql);
    $this->debug_console("match info sql: ", $sql);
    $this->debug_console("match info: ", $row);
  ?>
    <div class="mt-4 mb-3">
      <div class="card">
        <div class="card-header text-center bg-primary">
          <h3 class="text-white my-2"><strong><?= $row["match_name"] ?></strong></h3>
        </div>
        <div class="card-body row p-4 mt-3 mb-2 gx-3">

          <div class="col-12 text-center col-md-auto">
            <img src="/soth/images/soth_logo.png" class="img-thumbnail" style="width: 9em;">
          </div>

          <div class="col mt-3">
            <div class="row px-3 mt-1 mb-3">
              <div class="col-12 col-lg-auto" style="font-size: 1.2em;">
                <p class="card-title h5"><?= '<span class="text-primary" style="font-weight: bold">RANGE: </span>' . $row["match_location"] ?></p>
              </div>
              <div class="col text-lg-end">
                <p class=""><?= '<span class="text-primary" style="font-weight: bold">DATE: </span>' . date("M d, Y", strtotime($row["match_begin"])) ?><?php if ($row["match_begin"] != $row["match_finish"]) {
                                                                                                                                                          echo ' - ' . date("M d, Y", strtotime($row["match_finish"]));
                                                                                                                                                        } ?></p>
              </div>
            </div>

            <div class="row px-3 mt-3 mb-2 gx-5 justify-content-center">
              <div class="col-auto mb-3">
                <?= '<span class="text-primary" style="font-weight: bold">LV: </span>' . $row["match_level"] ?>
              </div>
              <div class="col-auto mb-3">
                <?= '<span class="text-primary" style="font-weight: bold">STAGES: </span>' . $row["match_stages"] ?>
              </div>
              <div class="col-auto mb-3">
                <?= '<span class="text-primary" style="font-weight: bold">ROUNDS: </span>' . $row["match_rounds"] ?>
              </div>
              <!-- <div class="row mt-3"> -->
              <div class="col-auto">
                <?= '<span class="text-primary" style="font-weight: bold">Match Director: </span>' . $row["match_md"] ?>
              </div>
            </div>


          </div>

        </div>




        <?php if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 5 && !empty($row["match_detail"]) && $this->get_url_filename() == "index.php") { ?>
          <div class="card-body px-5 bg-gray-500" style="background-color: #EFEFEF;">
            <p class="card-text px-4"><?= nl2br($row["match_detail"]) ?></p>
          </div>

          <div class="card-footer text-muted px-5" style="font-size: 0.75em;">
            <div class="row">
              <div class="col">
                registered: <?= date("M d, Y", strtotime($row["match_regist_datetime"])) ?>
              </div>
              <div class="col text-center">
                <?php
                if (isset($_SESSION["member"]) && $row["match_upload_file"] && $this->get_url_filename() == "index.php") {
                  echo 'document: <a href="../' . htmlentities(($row["match_upload_file"])) . '" target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>' .  $row["match_upload_file"] . '</a>';
                }
                ?>
              </div>
              <div class="col text-end">
                lastupdate: <?= date("M d, Y", strtotime($row["match_lastupdate"])) ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php
    return $row;
  }

  public function match_info_2ok($m_id)
  {
    $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
    $row = $this->get_db_row($sql);
    $this->debug_console("match info sql: ", $sql);
    $this->debug_console("match info: ", $row);
  ?>
    <div class="mt-4 mb-3">
      <div class="card">
        <div class="card-header text-center bg-primary">
          <h5 class="text-white my-2"><strong><?= $row["match_name"] ?></strong></h5>
        </div>
        <div class="card-body row px-5 mt-3 mb-0">
          <div class="col-12 col-md-6">
            <p class="card-title"><?= '<span class="text-primary" style="font-weight: bold">RANGE: </span>' . $row["match_location"] ?></p>
          </div>
          <div class="col-12 col-md-6 text-md-end">
            <p class="card-text"><?= '<span class="text-primary" style="font-weight: bold">DATE: </span>' . date("M d, Y", strtotime($row["match_begin"])) ?><?php if ($row["match_begin"] != $row["match_finish"]) {
                                                                                                                                                                echo ' - ' . date("M d, Y", strtotime($row["match_finish"]));
                                                                                                                                                              } ?></p>
          </div>
        </div>

        <div class="card-body row px-5 mt-0">
          <div class="col-4 col-md-3 offset-md-1">
            <?= '<span class="text-primary" style="font-weight: bold">LV: </span>' . $row["match_level"] ?>
          </div>
          <div class="col-4 col-md-4 text-center">
            <?= '<span class="text-primary" style="font-weight: bold">STAGES: </span>' . $row["match_stages"] ?>
          </div>
          <div class="col-4 col-md-3 text-end">
            <?= '<span class="text-primary" style="font-weight: bold">ROUNDS: </span>' . $row["match_rounds"] ?>
          </div>
          <!-- <div class="row mt-3"> -->
          <div class="col-12 mt-3">
            <?= '<span class="text-primary" style="font-weight: bold">Match Director: </span>' . $row["match_md"] ?>
          </div>
          <!-- <div class="col-12 col-md-6 text-md-end"> -->
          <?php if (!empty($row["match_md_contact"])) {
            // echo '<span class="text-primary" style="font-weight: bold">Contacts: </span>' . $row["match_md_contact"];
          } ?>
          <!-- </div> -->
          <!-- </div> -->
        </div>

        <?php if (isset($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 5 && !empty($row["match_detail"]) && $this->get_url_filename() == "index.php") { ?>
          <div class="card-body px-5 bg-gray-500" style="background-color: #EFEFEF;">
            <p class="card-text px-4"><?= nl2br($row["match_detail"]) ?></p>
          </div>

          <div class="card-footer text-muted px-5" style="font-size: 0.75em;">
            <div class="row">
              <div class="col">
                registered: <?= date("M d, Y", strtotime($row["match_regist_datetime"])) ?>
              </div>
              <div class="col text-center">
                <?php
                if (isset($_SESSION["member"]) && $row["match_upload_file"] && $this->get_url_filename() == "index.php") {
                  echo 'document: <a href="../' . htmlentities(($row["match_upload_file"])) . '" target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>' .  $row["match_upload_file"] . '</a>';
                }
                ?>
              </div>
              <div class="col text-end">
                lastupdate: <?= date("M d, Y", strtotime($row["match_lastupdate"])) ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php
    return $row;
  }

  public function so_on_duty_table($m_id)
  {
    $sql_order = NULL;
  ?>
    <div class="mt-3 mb-3 col-12 mx-auto">
      <table class="table table-striped table-bordered table-hover table-responsive table-light">
        <thead class="thead-inverse">
          <tr class="table-primary">
            <th class="text-center">#</th>
            <th class="text-center d-none d-md-table-cell">IDPA ID</th>
            <th>OFFICER NAME</th>
            <?php
            if (isset($_GET["p"]) && $_GET["p"] == "duty") {
              echo '<th colspan="2" class="text-center">POSITION</th>';
            } else {
              echo '<th class="text-center">POSITION</th>';
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql_order = NULL;
          $sql = "Select v_on_duty.`on-duty_id`, v_on_duty.so_id, v_on_duty.so_idpa_id, v_on_duty.so_firstname, v_on_duty.so_lastname, v_on_duty.so_firstname_en, v_on_duty.so_lastname_en, v_on_duty.so_nickname, v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`on-duty_notes` From v_on_duty Where v_on_duty.`on-duty_status` = 'enable' And v_on_duty.match_id = " . $m_id . " order by v_on_duty.`on-duty_priority`, v_on_duty.`on-duty_position`, v_on_duty.`so_firstname_en`";
          $this->debug_console("on duty table: ", $sql);
          $dataset = $this->get_db_array($sql);
          if (is_array($dataset)) {
            $x = 1;
            foreach ($dataset as $row) {
              echo '<tr>
                                                <td scope="row" class="text-center">' . $x . '</td>';
              echo '
                                                <td class="text-center d-none d-md-table-cell">' . $row["so_idpa_id"] . '</td>';
              if (!empty($_SESSION["member"]) && $_SESSION["member"]["auth_lv"] >= 5 && $this->get_url_filename() == "index.php") {
                echo '<td>';
                if (!empty($row["so_idpa_id"])) {
                  echo '<span class="d-md-none">' . $row["so_idpa_id"] . '<br></span>';
                }
                echo '<a href="../admin/?p=soinfo&soid=' . $row["so_id"] . '" target="_blank">' . $row["so_firstname_en"] . ' ' . $row["so_lastname_en"] . '</a><span class="d-block mt-0">' . $row["so_firstname"] . ' ' . $row["so_lastname"] . ' (' . $row["so_nickname"] . ')</span>' . '</td>';
              } else {
                echo '<td style="white-space: nowrap;">' . $row["so_firstname_en"] . ' ' . $row["so_lastname_en"] . '<span class="d-block mt-0">' . $row["so_firstname"] . ' ' . $row["so_lastname"] . ' (' . $row["so_nickname"] . ')</span>' . '</td>';
              }
              echo '
                                                <td class="text-center">' . $row["on-duty_position"] . '</td>';
              if (isset($_GET["p"]) && $_GET["p"] == "duty") {
                echo '<td class="text-center d-none d-md-table-cell">' . '<a href="?p=duty&mid=' . $m_id . '&act=dutyedit&odid=' . $row["on-duty_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="../db_mgt.php?p=duty&mid=' . $m_id . '&act=dutydelete&odid=' . $row["on-duty_id"] . '" target="_top" class="link-danger ps-3">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
              }
              echo '</tr>';
              $x++;
            }
          } else {
            echo '<tr class="table-ligh">
                                            <td scope="row" colspan="4" class="text-center py-3">No Data</td>
                                        </tr>';
          }
          ?>
        </tbody>
      </table>

    </div>
  <?php
  }

  public function so_form_update($so_id)
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>SO Profile Update</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <?php
        $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
        $row = $this->get_db_row($sql);
        $this->debug_console("so info sql: ", $sql);
        $this->debug_console("so info: ", $row);
        ?>
        <form action="../db_mgt.php?p=so&act=soedit" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname" name="firstname" value="<?= $row["so_firstname"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname" name="lastname" value="<?= $row["so_lastname"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname_en" name="firstname_en" value="<?= $row["so_firstname_en"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname_en" name="lastname_en" value="<?= $row["so_lastname_en"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="nickname" name="nickname" value="<?= $row["so_nickname"] ?>" maxlength="20" required>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= $row["so_citizen_id"] ?>" maxlength="13" required>
              </div>
              <div class="mb-3">
                <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="dob" name="dob" value="<?= $row["so_dob"] ?>" required>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="sex" class="form-label">เพศ <span class="lbl_required">*</span></label>
                    <select id="sex" name="sex" class="form-select" required>
                      <?php
                      foreach ($this->opt_sex as $sex) {
                        echo '<option value="' . $sex . '"';
                        if ($row["so_sex"] == $sex) {
                          echo ' selected';
                        }
                        echo '>' . $sex . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="blood" class="form-label">หมู่เลือด <span class="lbl_required">*</span></label>
                    <select id="blood" name="blood" class="form-select" required>
                      <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                      <?php
                      foreach ($this->opt_blood_type as $blood) {
                        echo '<option value="' . $blood . '"';
                        if ($row["so_blood_type"] == $blood) {
                          echo ' selected';
                        }
                        echo '>' . $blood . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5 mb-md-0">
              <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทร <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["so_phone"] ?>" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
                <input type="email" class="form-control col" id="email" name="email" value="<?= $row["so_email"] ?>" maxlength="50" required>
              </div>
              <div class="mb-3">
                <label for="line_id" class="form-label">LINE ID</label>
                <input type="text" class="form-control col" id="line_id" name="line_id" value="<?= $row["so_line_id"] ?>" maxlength="30">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่ <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="address" name="address" value="<?= $row["so_address"] ?>" maxlength="50" required>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="subdistrict" class="form-label">แขวง/ตำบล <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="subdistrict" name="subdistrict" value="<?= $row["so_subdistrict"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <label for="district" class="form-label">เขต/อำเภอ <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="district" name="district" value="<?= $row["so_district"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="province" class="form-label">จังหวัด <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="province" name="province" value="<?= $row["so_province"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <label for="zip" class="form-label">รหัสไปรษณีย์ <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="zip" name="zip" value="<?= $row["so_zipcode"] ?>" maxlength="5" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <div class="row">
                <div class="col mb-3">
                  <label for="idpa_id" class="form-label">IDPA ID</label>
                  <input type="text" class="form-control" id="idpa_id" name="idpa_id" value="<?= $row["so_idpa_id"] ?>" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
                </div>
                <!-- <div class="col mb-3">
                                    <label for="so_level" class="form-label">SO LEVEL</label>
                                    <select id="so_level" name="so_level" class="form-select" disabled readonly>
                                        <?php
                                        // foreach ($fnc->opt_so_level as $opt) {
                                        //     echo '<option value="' . $opt . '"';
                                        //     if ($row["so_level"] == $opt) {
                                        //         echo ' selected';
                                        //     }
                                        //     echo '>' . $opt . '</option>';
                                        // }
                                        ?>
                                    </select>
                                </div> -->
              </div>
              <div class="mb-3">
                <label for="club" class="form-label">CLUB</label>
                <input type="text" class="form-control" id="club" name="club" value="<?= $row["so_club"] ?>" placeholder="(ถ้ามี)" maxlength="50">
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                  <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp" value="<?php if ($row["so_idpa_expire"]) {
                                                                                                      echo $row["so_idpa_expire"];
                                                                                                    } ?>">
                </div>
                <div class="col mb-3">
                  <label for="so_exp" class="form-label">SO EXPIRE</label>
                  <input type="date" class="form-control col" id="so_exp" name="so_exp" value="<?php if ($row["so_license_expire"]) {
                                                                                                  echo $row["so_license_expire"];
                                                                                                } ?>">
                </div>
              </div>
              <!-- <div class="mb-3">
                  <label for="idpa_profile" class="form-label">Change Password</label>
                  <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="*******" maxlength="24" minlength="4">
                </div> -->
              <div class="row">
                <div class="col-12 col-md-4 col-lg-4 mb-3">
                  <img class="img-thumbnail rounded mx-auto" src="../<?= $row["so_avatar"]; ?>">
                </div>
                <div class="col mb-3">
                  <label for="avatar" class="form-label">Change Profile Image</label>
                  <input type="file" name="avatar" id="avatar" accept="image/png, image/jpeg" class="form-control form-control-sm">
                  <label for="avatar" class="form-label text-end text-muted w-100">(ratio 1:1 recommended)</label>
                </div>
              </div>
              <div class="mb-3 text-end">
                <!-- <label for="idpa_profile" class="form-label">Change Password</label> -->
                <!-- <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="*******" maxlength="24" minlength="4"> -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#changePwdModal">
                  <i class="bi bi-key me-2"></i>Click for Change Your Password.
                </button>

              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 1em;">
                <div class="col-6">
                  <a href="../member/" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="status" value="<?= $row["so_status"] ?>">
                  <input type="hidden" name="fst" value="soupdate">
                  <input type="hidden" name="so_id" value="<?= $_SESSION["member"]["so_id"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                </div>
              </div>

            </div>
          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="changePwdModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form class="form" role="form" autocomplete="off" action="../db_mgt.php?p=so&act=changePassword" method="post">
            <div class="modal-header">
              <h5 class="modal-title">Change Password</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <?php if (!empty($row["so_pwd"])) { ?>
                <div class="form-group mb-3">
                  <label for="inputPasswordOld">Current Password</label>
                  <input type="password" name="passwordOld" class="form-control" id="inputPasswordOld" required="" maxlength="24" minlength="4">
                </div>
              <?php } ?>
              <div class="form-group">
                <label for="inputPasswordNew">New Password</label>
                <input type="password" name="passwordNew" class="form-control" id="inputPasswordNew" required="" maxlength="24" minlength="4">
                <span class="form-text small text-muted">
                  The password must be 4-24 characters, and must <em>not</em> contain spaces.
                </span>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="soid" value="<?= $row["so_id"]; ?>">
              <input type="hidden" name="fst" value="SOChangePassword">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <?php
  }

  public function setting_form_update()
  {
    $opt_db_name = array("soth", "soth_sample");
  ?>
    <div class="card p-3 mt-4">
      <?php
      $sql = "SELECT * FROM `settings` ORDER BY `setting_id` Desc Limit 1";
      $row = $this->get_db_row($sql);
      $this->debug_console("setting sql: ", $sql);
      $this->debug_console("setting info: ", $row);
      ?>
      <form action="../db_mgt.php?p=setting&act=settingupdate" method="post">

        <div class="row">
          <div class="col-12 col-md-6 mb-3">
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="setting_db_name" class="form-label">Database Name <span class="lbl_required">*</span></label>
                  <select id="setting_db_name" name="setting_db_name" class="form-select" required>
                    <?php
                    foreach ($opt_db_name as $opt) {
                      echo '<option value="' . $opt . '"';
                      if ($row["setting_db_name"] == $opt) {
                        echo ' selected';
                      }
                      echo '>' . $opt . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="setting_debug_show" class="form-label">Debug Console <span class="lbl_required">*</span></label>
                  <select id="setting_debug_show" name="setting_debug_show" class="form-select" required>
                    <?php
                    echo '<option value="true"';
                    if ($row["setting_debug_show"] == 'true') {
                      echo ' selected';
                    }
                    echo '>Enable</option>';
                    echo '<option value="false"';
                    if ($row["setting_debug_show"] != 'true') {
                      echo ' selected';
                    }
                    echo '>Disable</option>';
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="setting_alert" class="form-label">Alert <span class="lbl_required">*</span></label>
                  <select id="setting_alert" name="setting_alert" class="form-select" required>
                    <?php
                    echo '<option value="true"';
                    if ($row["setting_alert"] === 'true') {
                      echo ' selected';
                    }
                    echo '>Enable</option>';
                    echo '<option value="true"';
                    if ($row["setting_alert"] !== 'true') {
                      echo ' selected';
                    }
                    echo '>Disable</option>';
                    ?>
                  </select>
                </div>
                <div class="col">
                  <label for="setting_meta_redirect" class="form-label">Redirect Time (second) <span class="lbl_required">*</span></label>
                  <input type="number" class="form-control col" id="setting_meta_redirect" name="setting_meta_redirect" value="<?= $row["setting_meta_redirect"] ?>" min="0" max="9" required>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label for="setting_system_name" class="form-label">System Name <span class="lbl_required">*</span></label>
              <input type="text" class="form-control" id="setting_system_name" name="setting_system_name" value="<?= $row["setting_system_name"] ?>" maxlength="13" required>
            </div>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="setting_version" class="form-label">Version <span class="lbl_required">*</span></label>
                  <input type="text" class="form-control col" id="setting_version" name="setting_version" value="<?= $row["setting_version"] ?>" required>
                </div>
                <div class="col">
                  <label for="setting_max_stage" class="form-label">Stage Available <span class="lbl_required">*</span></label>
                  <select id="setting_max_stage" name="setting_max_stage" class="form-select" required>
                    <?php
                    for ($i = 1; $i <= 15; $i++) {
                      echo '<option value="' . $i . '"';
                      if ($row["setting_max_stage"] == $i) {
                        echo ' selected';
                      }
                      echo '>' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <?php
            $system_version = explode(".", $row["setting_version"],3);
            ?>
            <div class="mb-3">
              <div class="row gx-2">
                <div class="col">
                  <label for="setting_version_major" class="form-label">Version Major</label>
                  <input type="text" class="form-control col" id="setting_version_major" name="setting_version_major" value="<?php if (!empty($system_version[0])) { echo $system_version[0]; } ?>" readonly>
                </div>
                <div class="col">
                  <label for="setting_version_minor" class="form-label">Minor</label>
                  <input type="text" class="form-control col" id="setting_version_minor" name="setting_version_minor" value="<?php if (!empty($system_version[1])) { echo $system_version[1]; } ?>" readonly>
                </div>
                <div class="col">
                  <label for="setting_version_fix" class="form-label">Fix</label>
                  <input type="text" class="form-control col" id="setting_version_fix" name="setting_version_fix" value="<?php if (!empty($system_version[2])) { echo $system_version[2]; } ?>" readonly>
                </div>                
              </div>
            </div>
            <div class="mb-3">
              <label for="setting_version_notes" class="form-label">last update</label>
              <input type="text" class="form-control" id="setting_version_notes" name="setting_version_notes" value="<?= $row["setting_version_notes"] ?>" maxlength="120">
            </div>

          </div>
        </div>

        <hr class="w-50 mx-auto">

        <div class="row mt-4">
          <div class="col-12 col-md-6 mb-3">
            <div class="mb-3">
              <label for="setting_match_active" class="form-label">Match Activated <span class="lbl_required">*</span></label>
              <select id="setting_match_active" name="setting_match_active" class="form-select" required>
                <?php
                $sql = "SELECT `match_id`,`match_name`,`match_begin` FROM `match-idpa` WHERE `match_status` = 'enable' Order By `match_begin` Desc";
                $match = $this->get_db_array($sql);
                foreach ($match as $opt) {
                  echo '<option value="' . $opt["match_id"] . '"';
                  if ($row["setting_match_active"] == $opt["match_id"]) {
                    echo ' selected';
                  }
                  echo '>' . $opt["match_name"] . ' (' . date("M d, Y", strtotime($opt["match_begin"])) . ')' . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-6 mb-2">
            <div class="row align-items-end gx-5" style="padding-top: 1em;">
              <div class="col-6">
                <a href="../admin/" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
              </div>
              <div class="col-6">
                <input type="hidden" name="fst" value="settingupdate">
                <input type="hidden" name="setting_id" value="<?= $row["setting_id"] ?>">
                <input type="hidden" name="setting_view_result" value="<?= $row["setting_view_result"] ?>">
                <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
              </div>
            </div>
          </div>
        </div>

    </div>

    </div>
    <!-- </div> -->
    </form>

  <?php
  }

  public function table_header_sorting($label, $col_name, $sql_order = NULL)
  {
    // $sql_order = NULL;
    if (isset($_GET["mid"])) {
      $mid = '&mid=' . $_GET["mid"];
    } else {
      $mid = '';
    }
    if (isset($_GET["order"]) && $_GET["order"] == $label) {
      if (isset($_GET["sort"]) && $_GET["sort"] == "z") {
        $sql_order = " ORDER BY " . $col_name . " DESC";
        echo '<a href="?p=' . $_GET["p"] . $mid . '&order=' . $label . '&sort=a" target="_top">' . $label . ' <i class="bi bi-sort-down"></i>' . '</a>';
      } else {
        echo '<a href="?p=' . $_GET["p"] . $mid . '&order=' . $label . '&sort=z" target="_top">' . $label . ' <i class="bi bi-sort-down-alt"></i>' . '</a>';
        $sql_order = " ORDER BY " . $col_name . " ASC";
      }
      return $sql_order;
    } else {
      echo '<a href="?p=' . $_GET["p"] . $mid . '&order=' . $label . '&sort=a" target="_top">' . $label . '</a>';
    }
  }

  // * admin sections

  public function so_admin_menu()
  {
  ?>
    <div class="container bg-gradient pt-0 mt-0 text-end" style="background-color: #eeeeee;">
      <ul class="nav justify-content-end text-capitalize" style="font-size: 0.8rem; font-weight: bold;">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="?p=so&act=soadd"><i class="bi bi-journal-plus me-2"></i>New SO Register</a>
        </li>
        <?php if (isset($_GET["soid"]) && $_GET["soid"] != "") {
          echo '<li class="nav-item">
          <a class="nav-link link-info" aria-current="page" href="?p=so&act=soedit&soid=' . $_GET["soid"] . '" target="_top"><i class="bi bi-pencil-square me-2"></i>Update SO</a>
        </li>';
          echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="../db_mgt.php?p=so&&act=sodelete&soid=' . $_GET["soid"] . '" target="_top"><i class="bi bi-trash me-2"></i>delete SO</a>
        </li>';
        } else {
          if (isset($_GET["v"]) && $_GET["v"] == "delete") {
            echo '<li class="nav-item">
          <a class="nav-link link-success" aria-current="page" href="?p=so"><i class="bi bi-person me-2"></i>Activated SO</a>
          </li>';
          } else {
            echo '<li class="nav-item">
        <a class="nav-link link-danger" aria-current="page" href="?p=so&v=delete"><i class="bi bi-person-x me-2"></i>Deleted SO</a>
        </li>';
          }
        } ?>
      </ul>
    </div>
  <?php
  }

  public function match_admin_menu()
  {
  ?>
    <div class="container bg-gradient pt-0 mt-0 text-end" style="background-color: #eeeeee;">
      <ul class="nav justify-content-end text-capitalize" style="font-size: 0.8rem; font-weight: bold;">
        <li class="nav-item">
          <?php if (isset($_GET["mid"]) && $_GET["mid"] != "") {
            echo '<li class="nav-item">
          <a class="nav-link link-success" aria-current="page" href="../score/?p=home&mid=' . $_GET["mid"] . '" target="_blank"><i class="bi bi-person-badge me-2"></i>อัพโหลดผลการแข่งขัน</a>
        </li>';
            echo '<li class="nav-item">
          <a class="nav-link " aria-current="page" href="?p=duty&mid=' . $_GET["mid"] . '"><i class="bi bi-person-badge me-2"></i>บันทึกการทำงานของ SO</a>
        </li>';
            echo '<li class="nav-item">
          <a class="nav-link link-info" aria-current="page" href="?p=match&act=matchedit&mid=' . $_GET["mid"] . '" target="_top"><i class="bi bi-pencil-square me-2"></i>Update Match</a>
        </li>';
            echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="../db_mgt.php?p=match&act=matchdelete&mid=' . $_GET["mid"] . '" target="_top"><i class="bi bi-trash me-2"></i>delete Match</a>
        </li>';
          } else {
            echo '<li class="nav-item">
          <a class="nav-link " aria-current="page" href="?p=match&act=matchadd"><i class="bi bi-journal-text me-2"></i>ลงทะเบียน Match</a>
          </li>';
            if (isset($_GET["v"]) && $_GET["v"] == "delete") {
              echo '<li class="nav-item">
            <a class="nav-link link-success" aria-current="page" href="?p=match"><i class="bi bi-journal-check me-2"></i>Activated Match</a>
            </li>';
            } else {
              echo '<li class="nav-item">
          <a class="nav-link link-danger" aria-current="page" href="?p=match&v=delete"><i class="bi bi-journal-x me-2"></i>Deleted Match</a>
          </li>';
            }
          } ?>
        </li>
      </ul>
    </div>
  <?php
  }

  public function so_list()
  {
    $sql_order = NULL;
  ?>
    <div class="mb-5">
      <div class="row">
        <div class="col-12 col-md-8">
          <h4 class="text-primary text-uppercase mt-4"><strong>รายชื่อ SO ในระบบฐานข้อมูล (<label id="num_of_data">0</label> คน)</strong></h4>
        </div>
        <div class="col align-self-end text-end pt-4">
          <form action="?" method="get">
            <div class="input-group input-group-sm">
              <input type="hidden" name="p" value="so">
              <?php
              if (isset($_GET["v"]) && $_GET["v"] != "") {
                echo '<input type="hidden" name="v" value="' . $_GET["v"] . '">';
              }
              ?>
              <input type="text" class="form-control" name="keysearch" placeholder="ระบุ idpa id, ชื่อ หรืออีเมล" <?php {
                                                                                                                    if (isset($_GET["keysearch"]) && $_GET["keysearch"] != "") echo ' value="' . $_GET['keysearch'] . '"';
                                                                                                                  } ?> aria-describedby="button-addon2">
              <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search me-2"></i>ค้นหา</button>
            </div>
          </form>

        </div>
      </div>
      <div>
        <p class="text-mute my-0 py-0" style="font-size: 0.75em;">คลิกหมายเลข idpa เพื่อแสดงข้อมูลสมาชิก idpa.com / คลิกชื่อ เพื่อแสดงรายละเอียดและประวัติการทำงาน / คลิกหัวข้อตารางเพื่อเรียงลำดับ</p>
      </div>
      <table class="table table-light table-striped table-hover table-responsive mt-3">
        <thead>
          <tr class="table-primary">
            <th><?php $sql_order .= $this->table_header_sorting("IDPA ID", "so_idpa_id", $sql_order); ?></th>
            <th><?php $sql_order .= $this->table_header_sorting("FULL NAME", "so_firstname_en", $sql_order); ?></th>
            <th class="d-none d-md-table-cell">PHONE / EMAIL</th>
            <!-- <th><?php //$sql_order .= table_header_sorting("LINE ID", "so_line_id", $sql_order); 
                      ?></th> -->
            <!-- <th>IDPA Expr</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET["v"]) && $_GET["v"] == "delete") {
            $sql = "SELECT * FROM `so-member` WHERE `so_status` = 'delete'";
          } else {
            $sql = "SELECT * FROM `so-member` WHERE `so_status` = 'enable'";
          }
          if (isset($_GET["keysearch"]) && $_GET["keysearch"] != "") {
            $sql .= " AND (`so_idpa_id` LIKE '" . $_GET["keysearch"] . "' OR `so_firstname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_firstname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_lastname_en` LIKE '%" . $_GET["keysearch"] . "%' OR `so_nickname` LIKE '" . $_GET["keysearch"] . "' OR `so_email` LIKE '%" . $_GET["keysearch"] . "%')";
          }
          if (isset($sql_order)) {
            $sql .= $sql_order;
          }
          $this->debug_console("table so list:", $sql);
          $so_array = $this->get_db_array($sql);
          if (!empty($so_array)) {
            foreach ($so_array as $row) {
              echo '<tr>
                                <td scope="row"><a href="https://www.idpa.com/members/' . $row["so_idpa_id"] . '/" target="_blank">' . $row["so_idpa_id"] . '</a></td>
                                <td nowarp><a href="?p=soinfo&soid=' . $row["so_id"] . '" target="_top">' . $row["so_firstname_en"] . ' ' . $row["so_lastname_en"] . '</a><br>' . $row["so_firstname"] . ' ' . $row["so_lastname"] . ' (' . $row["so_nickname"] . ')</td>
                                <td class="d-none d-md-table-cell"><a href="tel:' . $row["so_phone"] . '"><i class="bi bi-telephone me-2"></i>' . $row["so_phone"] . '</a><br>' . $row["so_email"] . '</td>';
              // echo '<td class="text-center">' . '<a href="?p=so&act=soedit&soid=' . $row["so_id"] . '" target="_top" class="link-warning"><i class="bi bi-pencil-square"></i></a>' . '<a href="../db_mgt.php?p=so&&act=sodelete&soid=' . $row["so_id"] . '" target="_top" class="link-danger ps-2">' . '<i class="bi bi-trash-fill"></i>' . '</a></td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="8" class="text-center">SO not founded.</td></tr>';
          }
          ?>
        </tbody>
      </table>
      <script type="text/javascript">
        document.getElementById("num_of_data").innerHTML = <?= count($so_array); ?>;
      </script>

    </div>
  <?php
  }

  public function so_info($so_id)
  {
  ?>
    <div class="row col mb-1">
      <div class="col-auto">
        <h4 class="text-primary text-uppercase mt-4"><strong>
            <?php
            if ($_SESSION["member"]["auth_lv"] >= 7) {
              echo '<a href="../admin/?p=so" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>';
            }
            ?>
            SO Information</strong></h4>
      </div>
      <?php if ($_SESSION["member"]["auth_lv"] >= 7) { ?>
        <div class="col align-self-end text-end">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#so_detail"><i class="bi bi-box-arrow-down me-2"></i>Details</button>
        </div>
      <?php } ?>
    </div>
    <div class="">

      <?php
      $this->gen_member_card($_GET["soid"]);

      if ($_SESSION["member"]["auth_lv"] >= 7) {
        echo '<!-- Modal -->
        <div class="modal fade" id="so_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">';
        $this->gen_member_info($_GET["soid"]);
        echo '              
            </div>
          </div>
        </div>';
      }

      ?>

    </div>
  <?php
  }

  public function so_form_add()
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>NEW SO Register</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <form action="../db_mgt.php?p=so&act=soappend" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname" name="firstname" placholder="" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname" name="lastname" placholder="" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname_en" name="firstname_en" placholder="" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname_en" name="lastname_en" placholder="" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น</label>
                <input type="text" class="form-control col" id="nickname" name="nickname" placholder="" maxlength="20">
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="citizen_id" name="citizen_id" placholder="" maxlength="13" required>
              </div>
              <div class="mb-3">
                <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="dob" name="dob" placholder="" required>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="sex" class="form-label">เพศ</label>
                    <select id="sex" name="sex" class="form-select">
                      <?php
                      foreach ($this->opt_sex as $sex) {
                        echo '<option value="' . $sex . '">' . $sex . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="blood" class="form-label">หมู่เลือด</label>
                    <select id="blood" name="blood" class="form-select">
                      <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                      <?php
                      foreach ($this->opt_blood_type as $blood) {
                        echo '<option value="' . $blood . '">' . $blood . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5 mb-md-0">
              <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทร <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="phone" name="phone" placholder="" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
                <input type="email" class="form-control col" id="email" name="email" placholder="" maxlength="50" required>
              </div>
              <div class="mb-3">
                <label for="line_id" class="form-label">LINE ID</label>
                <input type="text" class="form-control col" id="line_id" name="line_id" placholder="" maxlength="30">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่</label>
                <input type="text" class="form-control col" id="address" name="address" placholder="" maxlength="50">
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                    <input type="text" class="form-control col" id="subdistrict" name="subdistrict" placholder="" maxlength="30">
                  </div>
                  <div class="col">
                    <label for="district" class="form-label">เขต/อำเภอ</label>
                    <input type="text" class="form-control col" id="district" name="district" placholder="" maxlength="30">
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="province" class="form-label">จังหวัด</label>
                    <input type="text" class="form-control col" id="province" name="province" placholder="" maxlength="30">
                  </div>
                  <div class="col">
                    <label for="zip" class="form-label">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control col" id="zip" name="zip" placholder="" maxlength="5">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <div class="mb-3">
                <label for="idpa_id" class="form-label">IDPA ID</label>
                <input type="text" class="form-control" id="idpa_id" name="idpa_id" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
              </div>
              <div class="mb-3">
                <label for="club" class="form-label">CLUB</label>
                <input type="text" class="form-control" id="club" name="club" placeholder="(ถ้ามี)" maxlength="50">
              </div>
              <!-- <div class="mb-3">
                  <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
                  <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" placeholder="(ถ้ามี)" maxlength="30">
                </div> -->
              <div class="row">
                <div class="col mb-3">
                  <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                  <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp">
                </div>
                <div class="col mb-3">
                  <label for="so_exp" class="form-label">SO EXPIRE</label>
                  <input type="date" class="form-control col" id="so_exp" name="so_exp">
                </div>
              </div>
              <div class="mb-3">
                <label for="idpa_profile" class="form-label">Enter Password <span class="lbl_required">*</span></label>
                <input type="password" class="form-control col" id="pwd" name="pwd" placeholder="อย่างน้อย 4 ตัวอักษร" maxlength="24" minlength="4" required>
              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 2em;">
                <div class="col-6">
                  <a href="../admin/?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="status" value="enable">
                  <input type="hidden" name="fst" value="soappend">
                  <input type="hidden" name="so_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="append">
                </div>
              </div>

            </div>
          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>
  <?php
  }

  public function so_form_add_guest()
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>SOTH Register...</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <form action="../db_mgt.php?p=soregist&act=soregist" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname" name="firstname" placholder="" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname" name="lastname" placholder="" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
                <div class="row gx-2">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname_en" name="firstname_en" placholder="" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname_en" name="lastname_en" placholder="" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น</label>
                <input type="text" class="form-control col" id="nickname" name="nickname" placholder="" maxlength="20">
              </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <div class="mb-3">
                <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="citizen_id" name="citizen_id" placholder="" maxlength="13" required>
              </div>
              <div class="mb-3">
                <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="dob" name="dob" placholder="" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
                <input type="email" class="form-control col" id="email" name="email" placholder="" maxlength="50" required>
              </div>
            </div>

            <div class="col-12 mb-3">
              <div class="row mt-5 align-items-end gx-5 text-end" style="padding-top: 0em;">
                <div class="col-6 offset-6 col-md-3 offset-md-9">
                  <input type="hidden" name="status" value="regist">
                  <input type="hidden" name="fst" value="soregist">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="Register">
                </div>
              </div>

            </div>
          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>
  <?php
  }

  public function so_form_update_admin($so_id)
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>SO Profile Update for Admin</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <?php
        $sql = "SELECT * FROM `so-member` WHERE `so_id` = " . $so_id;
        $row = $this->get_db_row($sql);
        $this->debug_console("so info sql: ", $sql);
        $this->debug_console("so info: ", $row);
        ?>
        <form action="../db_mgt.php?p=so&act=soedit" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อ - สกุล <span class="lbl_required">*</span></label>
                <div class="row gx-3">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname" name="firstname" value="<?= $row["so_firstname"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname" name="lastname" value="<?= $row["so_lastname"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="firstname_en" class="form-label">Full Name <span class="lbl_required">*</span></label>
                <div class="row gx-3">
                  <div class="col">
                    <input type="text" class="form-control col" id="firstname_en" name="firstname_en" value="<?= $row["so_firstname_en"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" id="lastname_en" name="lastname_en" value="<?= $row["so_lastname_en"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="nickname" class="form-label">ชื่อเรียก / ชื่อเล่น <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="nickname" name="nickname" value="<?= $row["so_nickname"] ?>" maxlength="20" required>
                  </div>
                  <?php if ($_SESSION["member"]["auth_lv"] >= 9) { ?>
                    <div class="col">
                      <label for="so_auth_lv" class="form-label">Auth LV</label>
                      <select id="so_auth_lv" name="so_auth_lv" class="form-select">
                        <?php
                        // foreach ($this->system_auth_lv as $opt) {
                        for ($i = 0; $i <= count($this->system_auth_lv); $i++) {
                          if (isset($this->system_auth_lv[$i])) {
                            echo '<option value="' . $i . '"';
                            if ($row["so_auth_lv"] == $i) {
                              echo ' selected';
                            }
                            echo '>' . ucwords($this->system_auth_lv[$i]) . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5">
              <div class="mb-3">
                <label for="citizen_id" class="form-label">หมายเลขบัตรประชาชน <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="citizen_id" name="citizen_id" value="<?= $row["so_citizen_id"] ?>" maxlength="13" required>
              </div>
              <div class="mb-3">
                <label for="dob" class="form-label">วัน/เดือน/ปี เกิด <span class="lbl_required">*</span></label>
                <input type="date" class="form-control col" id="dob" name="dob" value="<?= $row["so_dob"] ?>" required>
              </div>
              <div class="mb-3">
                <div class="row gx-3">
                  <div class="col">
                    <label for="sex" class="form-label">เพศ <span class="lbl_required">*</span></label>
                    <select id="sex" name="sex" class="form-select" required>
                      <?php
                      foreach ($this->opt_sex as $sex) {
                        echo '<option value="' . $sex . '"';
                        if ($row["so_sex"] == $sex) {
                          echo ' selected';
                        }
                        echo '>' . $sex . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="blood" class="form-label">หมู่เลือด <span class="lbl_required">*</span></label>
                    <select id="blood" name="blood" class="form-select" required>
                      <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                      <?php
                      foreach ($this->opt_blood_type as $blood) {
                        echo '<option value="' . $blood . '"';
                        if ($row["so_blood_type"] == $blood) {
                          echo ' selected';
                        }
                        echo '>' . $blood . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-5 mb-md-0">
              <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทร <span class="lbl_required">*</span></label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $row["so_phone"] ?>" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">อีเมล <span class="lbl_required">*</span></label>
                <input type="email" class="form-control col" id="email" name="email" value="<?= $row["so_email"] ?>" maxlength="50" required>
              </div>
              <div class="mb-3">
                <label for="line_id" class="form-label">LINE ID</label>
                <input type="text" class="form-control col" id="line_id" name="line_id" value="<?= $row["so_line_id"] ?>" maxlength="30">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่</label>
                <input type="text" class="form-control col" id="address" name="address" value="<?= $row["so_address"] ?>" maxlength="50" required>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="subdistrict" class="form-label">แขวง/ตำบล <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="subdistrict" name="subdistrict" value="<?= $row["so_subdistrict"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <label for="district" class="form-label">เขต/อำเภอ <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="district" name="district" value="<?= $row["so_district"] ?>" maxlength="30" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="province" class="form-label">จังหวัด <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="province" name="province" value="<?= $row["so_province"] ?>" maxlength="30" required>
                  </div>
                  <div class="col">
                    <label for="zip" class="form-label">รหัสไปรษณีย์ <span class="lbl_required">*</span></label>
                    <input type="text" class="form-control col" id="zip" name="zip" value="<?= $row["so_zipcode"] ?>" maxlength="5" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <div class="row">
                <div class="col mb-3">
                  <label for="idpa_id" class="form-label">IDPA ID</label>
                  <input type="text" class="form-control" id="idpa_id" name="idpa_id" value="<?= $row["so_idpa_id"] ?>" placeholder="TH0000001 (ถ้ามี)" maxlength="12">
                </div>
                <?php if ($_SESSION["member"]["auth_lv"] >= 7) { ?>
                  <div class="col mb-3">
                    <label for="so_level" class="form-label">SO LEVEL</label>
                    <select id="so_level" name="so_level" class="form-select">
                      <?php
                      foreach ($this->opt_so_level as $opt) {
                        echo '<option value="' . $opt . '"';
                        if ($row["so_level"] == $opt) {
                          echo ' selected';
                        }
                        echo '>' . $opt . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                <?php } ?>
              </div>
              <div class="mb-3">
                <label for="club" class="form-label">CLUB</label>
                <input type="text" class="form-control" id="club" name="club" value="<?= $row["so_club"] ?>" placeholder="(ถ้ามี)" maxlength="50">
              </div>
              <!-- <div class="mb-3">
                  <label for="idpa_profile" class="form-label">IDPA Profile URL</label>
                  <input type="url" class="form-control col" id="idpa_profile" name="idpa_profile" value="<?= $row["so_idpa_profile"] ?>" placeholder="(ถ้ามี)" maxlength="30">
                </div> -->
              <div class="row gx-3">
                <div class="col mb-3">
                  <label for="idpa_exp" class="form-label">IDPA EXPIRE</label>
                  <input type="date" class="form-control col" id="idpa_exp" name="idpa_exp" value="<?php if ($row["so_idpa_expire"]) {
                                                                                                      echo $row["so_idpa_expire"];
                                                                                                    } ?>">
                </div>
                <div class="col mb-3">
                  <label for="so_exp" class="form-label">SO EXPIRE</label>
                  <input type="date" class="form-control col" id="so_exp" name="so_exp" value="<?php if ($row["so_license_expire"]) {
                                                                                                  echo $row["so_license_expire"];
                                                                                                } ?>">
                </div>
              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 2em;">
                <div class="col-6">
                  <a href="../admin/?p=so" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="status" value="<?= $row["so_status"] ?>">
                  <input type="hidden" name="fst" value="soupdate">
                  <input type="hidden" name="so_id" value="<?= $_GET["soid"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                </div>
              </div>

            </div>
          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>
  <?php
  }

  public function match_form_edit($mid)
  {
    $sql = "SELECT * FROM `match-idpa` WHERE `match_id` = " . $mid;
    $match_info = $this->get_db_row($sql);
    $this->debug_console("match info: ", $match_info);
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>Match Update + File</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <form action="../db_mgt.php?p=match&act=matchupdate" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12 col-md-6 mb-5 mb-md-2">
              <div class="mb-3">
                <label for="match_name" class="form-label">Match Name <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_name" name="match_name" value="<?= $match_info["match_name"] ?>" placholder="" maxlength="120" required>
              </div>
              <div class="mb-3">
                <label for="match_location" class="form-label">Range / Location <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_location" name="match_location" value="<?= $match_info["match_location"] ?>" placholder="" maxlength="80" required>
              </div>
              <div class="mb-3">
                <label for="match_md" class="form-label">Match Director <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_md" name="match_md" value="<?= $match_info["match_md"] ?>" placholder="" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="match_md_contact" class="form-label">M.D. Contact</label>
                <input type="text" class="form-control col" id="match_md_contact" name="match_md_contact" value="<?= $match_info["match_md_contact"] ?>" placholder="" maxlength="60">
              </div>
              <div class="mb-3">
                <label for="match_detail" class="form-label">Match Details</label>
                <textarea class="form-control" id="match_detail" name="match_detail" rows="3"><?= $match_info["match_detail"] ?></textarea>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-2">
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="match_level" class="form-label">LEVEL <span class="lbl_required">*</span></label>
                    <select id="match_level" name="match_level" class="form-select" required>
                      <?php
                      for ($i = 1; $i <= 5; $i++) {
                        echo '<option value="TIER ' . $i . '"';
                        if ($match_info["match_level"] == "TIER " . $i) {
                          echo ' selected';
                        }
                        echo '>TIER ' . $i . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_stages" class="form-label">Stages <span class="lbl_required">*</span></label>
                    <select id="match_stages" name="match_stages" class="form-select" required>
                      <!-- <option value="ไม่ระบุ" selected>ไม่ระบุ</option> -->
                      <?php
                      for ($i = 1; $i <= 15; $i++) {
                        echo '<option value="' . $i . '"';
                        if ($match_info["match_stages"] == $i) {
                          echo ' selected';
                        }
                        echo '>' . $i . '&nbsp;&nbsp;Stage';
                        if ($i > 1) {
                          echo 's';
                        }
                        echo '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_rounds" class="form-label">Rounds <span class="lbl_required">*</span></label>
                    <input type="number" class="form-control col" id="match_rounds" name="match_rounds" value="<?= $match_info["match_rounds"] ?>" placholder="" maxlength="3" min="50" max="350" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="match_begin" class="form-label">Match Begin <span class="lbl_required">*</span></label>
                  <input type="date" class="form-control col" id="match_begin" name="match_begin" value="<?php if (!empty($match_info["match_begin"])) {
                                                                                                            echo $match_info["match_begin"];
                                                                                                          } ?>" required>
                </div>
                <div class="col mb-3">
                  <label for="match_finish" class="form-label">Match Finish</label>
                  <input type="date" class="form-control col" id="match_finish" name="match_finish" value="<?php if ($match_info["match_finish"]) {
                                                                                                              echo $match_info["match_finish"];
                                                                                                            } ?>">
                </div>
              </div>

              <div class="mb-3">
                <label for="match_coordinator" class="form-label">Co-Ordinator</label>
                <select id="match_coordinator" name="match_coordinator" class="form-select">
                  <?php
                  $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable' Order by `so_firstname`";
                  $so_dataset = $this->get_db_array($sql_so);
                  echo '<option value="">' . 'ไม่ระบุ' . '</option>';
                  if (!empty($so_dataset)) {
                    foreach ($so_dataset as $so) {
                      echo '<option value="' . $so["so_id"] . '"';
                      if ($so["so_id"] == $match_info["match_coordinator"]) {
                        echo ' selected';
                      }
                      echo '>' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                    }
                  }
                  ?>
                </select>
                <?php $this->debug_console("SO available list: ", $sql_so); ?>
              </div>
              <div class="mb-3">
                <label for="match_upload_file" class="form-label">Report Upload</label>
                <input type="file" name="match_upload_file" id="match_upload_file" accept=".pdf" class="form-control form-control-sm">
                <label for="match_upload_file" class="form-label text-end text-muted w-100">(รองรับเฉพาะไฟล์ .PDF)</label>
              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 7em;">
                <div class="col-6">
                  <a href="../admin/?p=matchinfo&mid=<?= $mid ?>" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="m_id" value="<?= $mid ?>">
                  <input type="hidden" name="fst" value="matchupdate">
                  <input type="hidden" name="match_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="update">
                </div>
              </div>
            </div>


          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>
  <?php
  }

  public function match_form_add()
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-uppercase mt-4"><strong>Match Register</strong></h4>
      <!-- <div class="container mt-4"> -->
      <div class="card p-3 mt-4">
        <form action="../db_mgt.php?p=match&act=matchappend" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-5 mb-md-2">
              <div class="mb-3">
                <label for="match_name" class="form-label">Match Name <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_name" name="match_name" placholder="" maxlength="120" required>
              </div>
              <div class="mb-3">
                <label for="match_location" class="form-label">Range / Location <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_location" name="match_location" placholder="" maxlength="80" required>
              </div>
              <div class="mb-3">
                <label for="match_md" class="form-label">Match Director <span class="lbl_required">*</span></label>
                <input type="text" class="form-control col" id="match_md" name="match_md" placholder="" maxlength="30" required>
              </div>
              <div class="mb-3">
                <label for="match_md_contact" class="form-label">M.D. Contact</label>
                <input type="text" class="form-control col" id="match_md_contact" name="match_md_contact" placholder="" maxlength="60">
              </div>
              <div class="mb-3">
                <label for="match_detail" class="form-label">Match Details</label>
                <textarea class="form-control" id="match_detail" name="match_detail" rows="3"></textarea>
              </div>
            </div>

            <div class="col-12 col-md-6 mb-2">
              <div class="mb-3">
                <div class="row gx-2">
                  <div class="col">
                    <label for="match_level" class="form-label">LEVEL <span class="lbl_required">*</span></label>
                    <select id="match_level" name="match_level" class="form-select" required>
                      <?php
                      for ($i = 1; $i <= 5; $i++) {
                        echo '<option value="TIER ' . $i . '">TIER ' . $i . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_stages" class="form-label">Stages <span class="lbl_required">*</span></label>
                    <select id="match_stages" name="match_stages" class="form-select" required>
                      <option value="ไม่ระบุ" selected>ไม่ระบุ</option>
                      <?php
                      for ($i = 1; $i <= 15; $i++) {
                        echo '<option value="' . $i . '">' . $i . '&nbsp;&nbsp;Stage';
                        if ($i > 1) {
                          echo 's';
                        }
                        echo '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col">
                    <label for="match_rounds" class="form-label">Rounds <span class="lbl_required">*</span></label>
                    <input type="number" class="form-control col" id="match_rounds" name="match_rounds" placholder="" maxlength="3" min="1" max="300" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="match_begin" class="form-label">Match Begin <span class="lbl_required">*</span></label>
                  <input type="date" class="form-control col" id="match_begin" name="match_begin" required>
                </div>
                <div class="col mb-3">
                  <label for="match_finish" class="form-label">Match Finish</label>
                  <input type="date" class="form-control col" id="match_finish" name="match_finish">
                </div>
              </div>

              <div class="mb-3">
                <label for="match_coordinator" class="form-label">Co-Ordinator</label>
                <select id="match_coordinator" name="match_coordinator" class="form-select">
                  <?php
                  $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable' Order by `so_firstname`";
                  $so_dataset = $this->get_db_array($sql_so);
                  $this->debug_console("SO available list: ", $sql_so);
                  echo '<option value="">' . 'ไม่ระบุ' . '</option>';
                  if (!empty($so_dataset)) {
                    foreach ($so_dataset as $so) {
                      echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="row mt-5 align-items-end gx-5" style="padding-top: 7em;">
                <div class="col-6">
                  <a href="../admin/?p=match" target="_top" class="btn btn-secondary w-100 text-uppercase py-3">close</a>
                </div>
                <div class="col-6">
                  <input type="hidden" name="fst" value="matchappend">
                  <input type="hidden" name="match_editor" value="<?= $_SESSION["member"]["so_firstname_en"] ?>">
                  <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase py-3" value="append">
                </div>
              </div>
            </div>


          </div>
      </div>
      <!-- </div> -->
      </form>
    </div>

    </div>
  <?php
  }

  public function duty_form_set($m_id)
  {
  ?>
    <div class="mt-4 mb-3">
      <div class="row">
        <div class="col-auto">
          <h4 class="text-primary text-uppercase"><strong><a href="index.php?p=matchinfo&mid=<?= $_GET["mid"] ?>" target="_top" class="link-secondary pe-3"><i class="bi bi-arrow-left-square-fill"></i></a>Match SO Setup</strong></h4>
        </div>
        <div class="col text-end align-self-center">
          SO LIST: <a href="?<?= 'p=duty&mid=' . $_GET["mid"] . ''; ?>&listview=so_idpa_id" class="text-primary">IDPA ID</a>
          <a href="?<?= 'p=duty&mid=' . $_GET["mid"] . '&listview=so_firstname_en'; ?>" class="text-primary ms-2">FirstName EN</a>
          <a href="?<?= 'p=duty&mid=' . $_GET["mid"] . '&listview=so_firstname'; ?>" class="text-primary ms-2">FirstName TH</a>
        </div>
      </div>
      <div class="mt-4">
        <?php
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $this->get_db_row($sql);
        $this->debug_console("match info sql: ", $sql);
        $this->debug_console("match info: ", $row);

        $this->match_info($m_id);

        if (isset($_GET["listview"])) {
          $listview = $_GET["listview"];          
        } else {
          $listview = "so_idpa_id";
        }
        ?>

        <div class="mt-4 mb-3">
          <div class="">
            <div class="text-start">
              <h4 class="text-secondary my-1 text-uppercase" style="font-weight:bold;">เลือก SO และหน้าที่ (เลือกได้มากกว่า 1)</h4>
            </div>

            <div class="card-body p-0">
              <form method="post" action="../db_mgt.php?p=duty&mid=<?= $m_id; ?>&listview=<?= $listview ?>">
                <div class="row gy-1">
                  <div class="col-12 col-md-7">
                    <select name="so_id[]" class="form-select" size="12" multiple aria-label="size 8 select example" required>
                      <?php
                      $sql_so_onduty = "Select `so_id` From v_on_duty Where `on-duty_status` = 'enable' AND `match_id` = " . $m_id;
                      $so_onduty = $this->get_db_array($sql_so_onduty);
                      if (!empty($so_onduty)) {
                        $so_except = "";
                        foreach ($so_onduty as $so_duty) {
                          $so_except .= " AND `so-member`.so_id <> " . $so_duty["so_id"];
                        }
                      }
                      $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`,`so_nickname`,`so_firstname_en`, `so_lastname_en` FROM `so-member` WHERE `so_status` = 'enable'" . $so_except;
                      $order = " Order by `so_idpa_id`";
                      if (isset($listview)) {
                        $order = " Order by `" . $listview . "`";
                      }
                      // $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`,`so_nickname`,`so_firstname_en`, `so_firstname_en` FROM `so-member` WHERE `so_status` = 'enable'" . $so_except . " Order by `so_firstname`";
                      $so_dataset = $this->get_db_array($sql_so . $order);
                      $this->debug_console("SO available list: ", $sql_so);
                      foreach ($so_dataset as $so) {
                        $so_list = '<option value="' . $so["so_id"] . '">' . $so["so_idpa_id"] . ' ' . $so["so_firstname_en"] . ' ' . $so["so_lastname_en"] . ' / ' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . '</option>';
                        if (isset($listview)) {
                          if ($listview == "so_firstname") {
                            $so_list = '<option value="' . $so["so_id"] . '">' .  $so["so_firstname"] . ' ' . $so["so_lastname"] . ' / ' . $so["so_firstname_en"] . ' ' . $so["so_lastname_en"] . ' (' . $so["so_nickname"] . ') ' . ' ' . $so["so_idpa_id"] . '</option>';
                          } elseif ($listview == "so_firstname_en") {
                            $so_list = '<option value="' . $so["so_id"] . '">' .  $so["so_firstname_en"] . ' ' . $so["so_lastname_en"] . ' / ' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . ' ' . $so["so_idpa_id"] . '</option>';
                          } else {
                            $so_list = '<option value="' . $so["so_id"] . '">' . $so["so_idpa_id"] . ' ' . $so["so_firstname_en"] . ' ' . $so["so_lastname_en"] . ' / ' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . '</option>';
                          }
                        }
                        echo $so_list;
                      }
                      ?>
                    </select>
                    <?php $this->debug_console("sq on duty sql:", $sql_so_onduty); ?>
                    <?php $this->debug_console("sq on duty:", $so_onduty); ?>
                  </div>
                  <div class="col-12 col-md-3 mt-2 mt-md-auto">
                    <select name="position[]" class="form-select col-3" size="12" multiple aria-label="size 8 select example" required>
                      <?php
                      // $position = array("MD", "CSO", "Chrono", "Stat", "SO");
                      // array_push($position, "PSO Stage 1", "PSO Stage 2", "PSO Stage 3", "PSO Stage 4", "PSO Stage 5", "PSO Stage 6", "PSO Stage 7", "PSO Stage 8", "PSO Stage 9", "PSO Stage 10", "PSO Stage 11", "PSO Stage 12", "PSO Stage 13", "PSO Stage 14", "PSO Stage 15", "PSO Stage 16", "PSO Stage 17", "PSO Stage 18", "PSO Stage 19", "PSO Stage 20");
                      // array_push($position, "SO Stage 1", "SO Stage 2", "SO Stage 3", "SO Stage 4", "SO Stage 5", "SO Stage 6", "SO Stage 7", "SO Stage 8", "SO Stage 9", "SO Stage 10", "SO Stage 11", "SO Stage 12", "SO Stage 13", "SO Stage 14", "SO Stage 15");
                      $sql_postition = "SELECT * FROM `on-duty-position` WHERE `post_status` = 'enable' AND post_priority <= " . $_SESSION["member"]["setting"]["setting_max_stage"] . " ORDER BY `post_priority`, `post_title`";
                      $position = $this->get_db_array($sql_postition);
                      $this->debug_console("position sql: " . $sql_postition);

                      foreach ($position as $po) {
                        echo '<option value="' . $po["post_priority"] . ',' . $po["post_title"] . '">' . $po["post_title"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 align-self-end text-end mt-2 mt-md-auto">
                    <input type="hidden" name="mid" value="<?= $m_id; ?>">
                    <input type="hidden" name="fst" value="ondutyadd">
                    <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase" value="SET">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php
        $this->so_on_duty_table($m_id);
        ?>

      </div>

    </div>
  <?php
  }

  public function duty_form_edit($m_id, $odid)
  {
  ?>
    <div class="container mb-4">
      <h4 class="text-primary text-decoration-underline mt-4">Match Information update SO</h4>
      <div class="container mt-4">
        <?php
        $sql = "Select vod.so_id, vod.`on-duty_position`, vod.so_firstname, vod.so_lastname, vod.so_firstname_en, vod.so_lastname_en, vod.so_nickname, vod.so_idpa_id From v_on_duty vod Where vod.`on-duty_id` = " . $odid;
        $edit_info = $this->get_db_array($sql)[0];
        $this->debug_console("edit info : ", $edit_info);
        $sql = "SELECT * FROM `match-idpa` WHERE `match_status` = 'enable' AND `match_id` = " . $m_id;
        $row = $this->get_db_row($sql);
        $this->debug_console("match info sql: ", $sql);
        $this->debug_console("match info: ", $row);

        $this->match_info($m_id);
        ?>

        <div class="mt-4 mb-3">
          <div class="card">
            <div class="card-header text-center">
              <h5 class="text-secondary my-1 text-uppercase" style="font-size:0.9em; font-weight:bold;">Form Edit on Duty</h5>
            </div>

            <div class="card-body p-0">
              <form method="post" action="../db_mgt.php?p=duty&mid=<?= $m_id; ?>">
                <div class="row gy-1">
                  <div class="col-12 col-md-7">
                    <select name="so_id" class="form-select" size="8" aria-label="size 8 select example" required>
                      <?php
                      $sql_so_onduty = "Select v_on_duty.so_id From v_on_duty Where `on-duty_status` = 'enable' AND v_on_duty.match_id = " . $m_id;
                      $so_onduty = $this->get_db_array($sql_so_onduty);
                      if (!empty($so_onduty)) {
                        $so_except = "";
                        foreach ($so_onduty as $so_duty) {
                          $so_except .= " AND `so-member`.so_id <> " . $so_duty["so_id"];
                        }
                      }
                      $sql_so = "SELECT `so_id`,`so_idpa_id`,`so_firstname`,`so_lastname`, `so_nickname` FROM `so-member` WHERE `so_status` = 'enable'" . $so_except . " Order by `so_firstname`";
                      $so_dataset = $this->get_db_array($sql_so);
                      $this->debug_console("SO available list: ", $sql_so);
                      if (isset($edit_info)) {
                        echo '<option value="' . $edit_info["so_id"] . '" selected>' . $edit_info["so_firstname"] . ' ' . $edit_info["so_lastname"] . ' (' . $edit_info["so_nickname"] . ') ' . $edit_info["so_idpa_id"] . '</option>';
                      }
                      foreach ($so_dataset as $so) {
                        echo '<option value="' . $so["so_id"] . '">' . $so["so_firstname"] . ' ' . $so["so_lastname"] . ' (' . $so["so_nickname"] . ') ' . $so["so_idpa_id"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-3 mt-2 mt-md-auto">
                    <select name="position" class="form-select col-3" size="8" aria-label="size 8 select example" required>
                      <?php
                      $sql_postition = "SELECT * FROM `on-duty-position` WHERE `post_status` = 'enable' AND post_priority <= " . $_SESSION["member"]["setting"]["setting_max_stage"] . " ORDER BY `post_priority`, post_title";
                      $position = $this->get_db_array($sql_postition);

                      foreach ($position as $po) {
                        echo '<option value="' . $po["post_priority"] . ',' . $po["post_title"] . '"';
                        if ($po["post_title"] == $edit_info["on-duty_position"]) {
                          echo ' selected';
                        }
                        echo '>' . $po["post_title"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 align-self-end text-end mt-2 mt-md-auto">
                    <input type="hidden" name="odid" value="<?= $odid; ?>">
                    <input type="hidden" name="mid" value="<?= $m_id; ?>">
                    <input type="hidden" name="fst" value="ondutyupdate">
                    <input type="submit" name="submit" class="btn btn-primary w-100 text-uppercase" value="update">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php
        $this->so_on_duty_table($m_id);
        ?>

      </div>

    </div>
<?php
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
