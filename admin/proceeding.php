<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');
$fnc = new web();
$MJU_API = new MJU_API();
require('core_fnc.php');
// $proceeding_fnc = new general_fnc();
$proceeding_fnc = new proceeding_fnc();

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

    <?php include('main_menu.php'); ?>

    <?php
    // * sub-menu
    if (isset($_GET['act']) && $_GET['act'] == "report") {
        $proceeding_fnc->proceeding_report_submenu();
    } else {
        echo '<div style="margin-top:3em;">&nbsp;</div>';
    }
    ?>

    <main class="mb-3">
        <div class="container mx-auto py-3">

            <?php
            if (isset($_GET['p']) && $_GET['p'] != '') {
                switch ($_GET['p']) {
                    case "proceeding":
                        if (isset($_GET['act']) && $_GET['act'] == "append") {
                            $proceeding_fnc->gen_append_form();
                        } elseif (isset($_GET['pid']) && $_GET['act'] == "update") {
                            $proceeding_fnc->gen_update_form($_GET['pid']);
                        } elseif (isset($_GET['pid']) && $_GET['act'] == "viewinfo") {
                            $proceeding_fnc->gen_proceeding_info($_GET['pid']);
                        } elseif (isset($_GET['act']) && $_GET['act'] == "viewdeleted") {
                            $proceeding_fnc->gen_proceeding_table('delete');
                        } elseif (isset($_GET['cat']) && $_GET['cat'] != '') {
                            switch ($_GET['cat']) {
                                case "personal":
                                    $proceeding_fnc->gen_report_personal();
                                    break;
                                case "department":
                                    $proceeding_fnc->gen_report_department();
                                    break;
                                case "apasample":
                                    $proceeding_fnc->gen_report_apa();
                                    break;
                            }
                        } elseif (isset($_GET['pid']) && isset($_GET['act']) && $_GET['act'] == "coWorker") {
                            $proceeding_fnc->gen_proceeding_coworker($_GET['pid']);
                        } elseif (isset($_GET['pid']) && isset($_GET['act']) && $_GET['act'] == "attachment") {
                            $proceeding_fnc->gen_proceeding_attachment($_GET['pid']);
                        } else {
                            $proceeding_fnc->gen_proceeding_table();
                        }
                        break;
                }
            } else {
                echo "none parameters";
            }
            ?>

        </div>
    </main>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <?php include('../sweet_alert.php'); ?>

</body>

</html>