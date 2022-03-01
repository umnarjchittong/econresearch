<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web();
$MJU_API = new MJU_API();
// require('core_fnc.php');
// $core_fnc = new general_fnc();
require('core_fnc_activity.php');
$activity_fnc = new activity_fnc();

?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ECON-Academic and Services</title>
    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* css ส่วนสำหรับการแบ่งหน้าข้อมูลสำหรับการพิมพ์ */
        @media print {
            .page-break {
                /* display: block;
                height: 1px; */
                page-break-before: always;
            }

            .page-break-no {
                /* display: block;
                height: 1px; */
                page-break-after: avoid;
            }
        }
    </style>

</head>

<body style="background-color: #DFD9EA;">

    <div class="d-print-none">
        <?php include('main_menu.php'); ?>
    </div>
    <div class="page-break" style"page-break-before: always;">page break before</div>
    <div class="d-print-none" style="margin-top:2em; height: 1.5em;"></div>
    <?php
    if (isset($_GET['act']) && $_GET['act'] == 'report') {
        $activity_fnc->gen_report();
    }

    ?>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <?php include('../sweet_alert.php'); ?>

</body>

</html>