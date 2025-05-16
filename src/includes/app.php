<?php

session_start();

define('SHOWCONSOLE', true);
define('APIS_URL', 'https://apis.mju.ac.th/');
define('SHOWITEMPERPAGE', 5);

define('BASE_URL', '/econ-research/');
define('APP_TITLE', 'ECON-Academic and Services');


define('ORG_NAME', 'ECON');

if (!isset($_SESSION["Language"]) || $_SESSION["Language"] == '') {
    $_SESSION["Language"] = 'th';
}


?>