<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web();
$MJU_API = new MJU_API();
// require('core_fnc.php');
// $core_fnc = new general_fnc();
require('core_fnc_research.php');
$research_fnc = new research_fnc();

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body style="background-color: #DFD9EA;">
    <div class="d-print-none">
        <?php include('main_menu.php'); ?>
    </div>

    <?php
    // * sub-menu
    if (isset($_GET['act']) && $_GET['act'] == "report") {
        $research_fnc->data_report_submenu();
    } else {
        echo '<div class="d-print-none" style="margin-top:3em;">&nbsp;</div>';
    }
    ?>

    <main class="mb-3">
        <div class="container mx-auto py-3">

            <?php
            if (isset($_GET['p']) && $_GET['p'] != '' && $_GET['act'] != 'report') {
                switch ($_GET['p']) {
                    case "research":
                        if (isset($_GET['act']) && $_GET['act'] == "append") {
                            $research_fnc->gen_append_form();
                        } elseif (isset($_GET['rid']) && $_GET['act'] == "update") {
                            $research_fnc->gen_update_form($_GET['rid']);
                        } elseif (isset($_GET['rid']) && $_GET['act'] == "viewinfo") {
                            $research_fnc->gen_data_info($_GET['rid']);
                        } elseif (isset($_GET['act']) && $_GET['act'] == "viewdeleted") {
                            $research_fnc->gen_data_table('delete');
                        } elseif (isset($_GET['rid']) && isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            $research_fnc->gen_data_coworker($_GET['rid']);
                        } elseif (isset($_GET['rid']) && isset($_GET['act']) && $_GET['act'] == "attachment") {
                            $research_fnc->gen_data_attachment($_GET['rid']);
                        } else {
                            $research_fnc->gen_data_table();
                        }
                        break;
                }
            } else {
                // echo "none parameters";
            }
            ?>

        </div>
    </main>

    <?php
    if (isset($_GET['act']) && $_GET['act'] == 'report') {
        if (isset($_GET['cat']) && $_GET['cat'] != '') {
            switch ($_GET['cat']) {
                case "personal":
                    $research_fnc->gen_report_personal();
                    break;
                    // case "personal-old":
                    //     $research_fnc->gen_report_personal2();
                    //     break;
                case "department":
                    $research_fnc->gen_report_department();
                    break;
                case "apasample":
                    $research_fnc->gen_report_apa();
                    break;
            }
        }
    }

    ?>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <?php include('../sweet_alert.php'); ?>

</body>

</html>