<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web();
$MJU_API = new MJU_API();
// require('core_fnc.php');
// $core_fnc = new general_fnc();
require('core_fnc_project.php');
$project_fnc = new project_fnc();

?>
<html lang="en">

<head>
    <title>ECON-Academic and Services</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <!-- <link href="../images/favicon.png" rel="icon"> -->

    <!-- Bootstrap CSS v5.0.2 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body style="background-color: #DFD9EA;">

    <div class="d-print-none">
        <?php include('main_menu.php'); ?>
    </div>

    <?php
    // * sub-menu
    if (isset($_GET['act']) && $_GET['act'] == "report") {
        $project_fnc->data_report_submenu();
    } else {
        echo '<div class="d-print-none" style="margin-top:2em; height: 1.5em;"></div>';
    }
    ?>

    <?php
    if (isset($_GET['p']) && $_GET['p'] == 'project' && $_GET['act'] != 'report') {
        echo '<main class="mb-3">
                <div class="container mx-auto py-3">';
        if (isset($_GET['act']) && $_GET['act'] == "append") {
            $project_fnc->gen_append_form();
        } elseif (isset($_GET['pid']) && $_GET['act'] == "update") {
            $project_fnc->gen_update_form($_GET['pid']);
        } elseif (isset($_GET['pid']) && $_GET['act'] == "viewinfo") {
            $project_fnc->gen_data_info($_GET['pid']);
        } elseif (isset($_GET['act']) && $_GET['act'] == "viewdeleted") {
            $project_fnc->gen_data_table('delete');
        } elseif (isset($_GET['pid']) && isset($_GET['act']) && $_GET['act'] == "coWorker") {
            $project_fnc->gen_data_coworker($_GET['pid']);
        } elseif (isset($_GET['pid']) && isset($_GET['act']) && $_GET['act'] == "attachment") {
            $project_fnc->gen_data_attachment($_GET['pid']);
        } else {
            $project_fnc->gen_data_table();
        }
        echo '</div>
                </main>';
    } else {
        // echo "none parameters";
    }

    if (isset($_GET['p']) && $_GET['p'] == 'activity' && isset($_GET['pid']) && $_GET['act'] != 'report') {
        echo '<main class="mb-3">
                <div class="container mx-auto py-3">';
        $project_fnc->gen_data_activity($_GET['pid']);
        echo '</div>
                </main>';
    }
    ?>

    <?php
    if (isset($_GET['act']) && $_GET['act'] == 'report') {
        if (isset($_GET['cat']) && $_GET['cat'] != '') {
            switch ($_GET['cat']) {
                case "personal":
                    $project_fnc->gen_report_personal();
                    break;
                case "department":
                    $project_fnc->gen_report_department();
                    break;
                case "apasample":
                    $project_fnc->gen_report_apa();
                    break;
            }
        }
    }

    ?>


    <!-- Bootstrap JavaScript Libraries -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <?php include('../sweet_alert.php'); ?>

</body>

</html>