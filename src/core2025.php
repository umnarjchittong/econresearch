<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Status: 200');

// Start the session
session_start();

// Set datetime thai
date_default_timezone_set("Asia/Bangkok");

if ($_SERVER['HTTP_HOST'] == 'localhost') // or any other host
{
    // development
    if (file_exists('E:/xampp/htdocs/pr.mju/')){
        define('ROOT_PATH', 'E:/xampp/htdocs/pr.mju/'); // umnarj pc
    } else {
        define('ROOT_PATH', 'D:/xampp/htdocs/econ-research/'); // chittong nb
    }
    //  define('ROOT_PATH',  'E:/xampp/htdocs/pr.mju/'); // umnarj pc
    // define('ROOT_PATH', 'D:/xampp/htdocs/pr.mju/'); // chittong nb
    define('BASE_URL', '/econ-research/');
} else {
    // production
    define('ROOT_PATH', 'C:/inetpub/website/projects/econ-research/');
    define('BASE_URL', '/econ-research/');
}

define('SHOWCONSOLE', true);
define('APIS_URL', 'https://apis.mju.ac.th/');
define('API_URL', 'https://aed.mju.ac.th/econ-research/api/');
define('SHOWITEMPERPAGE', 20);

define('APP_TITLE', 'ECON-Academic and Services');
define('ORG_NAME', 'ECON');

if (!isset($_SESSION["Language"]) || $_SESSION["Language"] == '') {
    $_SESSION["Language"] = 'th';
}

class coreFunction
{
    public $tableTitle = 'รายงานการบันทึกเวลาปฏิบัติงาน ของบุคลากรสายสนับสนุน คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้';
    public $dayTh = ['', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'];
    public $monthTHShort = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    public $monthTH = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    public function debug_console($var1, $var2 = null)
    {
        if (!SHOWCONSOLE) {
            return;
        }

        $var1 = is_array($var1) ? json_encode($var1, JSON_UNESCAPED_UNICODE) : $var1;
        $var2 = is_array($var2) ? json_encode($var2, JSON_UNESCAPED_UNICODE) : $var2;

        echo '<script>';
        echo "console.log" . "('" . $var1 . "', '" . $var2 . "');";
        echo '</script>';
    }

    // public function jsonReader($filePath)
    // {
    //     $json = file_get_contents($filePath);
    //     $json_data = json_decode($json, true);
    //     return $json_data;
    // }

    public function dateThai($date)
    {
        $date = new DateTime($date);
        // return "".$date->format('d')." ".$this->monthTHShort[$date->format('m')]." ".$date->format('Y');
        return "" . $date->format('d') . " " . $this->monthTH[$date->format('n')] . " " . $date->format('Y') + 543;
    }

    public function dateThaiSemi($date)
    {
        $date = new DateTime($date);
        // return "".$date->format('d')." ".$this->monthTHShort[$date->format('m')]." ".$date->format('Y');
        return "" . $date->format('d') . " " . $this->monthTHShort[$date->format('n')] . " " . substr($date->format('Y') + 543, 2, 2);
    }
}


class Json extends coreFunction
{
    public function jsonReader($json_file)
    {
        $filePath = ROOT_PATH . "json/" . $json_file . ".json";
        // $filePath = 'C:/inetpub/website/projects/pr.mju_php/' . "json/" . $json_file . ".json";
        // $this->debug_console("json file path:" . $_SERVER['DOCUMENT_ROOT']);

        if (!file_exists($filePath)) {
            $this->debug_console("json file not found." . "\\n  method:" . $json_file . "\\n  path:" . $filePath);
            return false;
        }

        $json = file_get_contents($filePath);
        $json_data = json_decode($json, true);
        // $this->debug_console("json readed." . "\\n  method:" . $json_file . "\\n  path:" . $filePath . "\\n  data:", $json_data);
        return $json_data;
    }
}


}