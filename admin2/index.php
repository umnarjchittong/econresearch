<!doctype html>
<?php
require_once('../src/includes/app.php');
require_once('../core.php');
$fnc = new web;
$sql_display_limit = ' limit 5';

// if (empty($_SESSION["admin"]) || !isset($_SESSION["admin"]) || !$_SESSION["admin"]["email"]) {
//     die('<meta http-equiv="refresh" content="0;url=../mjusso/signout.php">');
// } else {
//     $fnc->debug_console("Admin: \\n", $_SESSION["admin"]);
// }

?>


<html lang="<?= $_SESSION["Language"] ?>">

<head>
    <title><?= APP_TITLE ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../src/assets/images/econ_logo.png" rel="icon">

    <!-- Style CSS -->
    <link rel="stylesheet" href="../src/css/styles.css">

</head>

<body>

    <div class="body-wrapper flex flex-col">
        <div id="main_menu" class="mb-3">
            <?php include_once('main_menu.php'); ?>
        </div>

        <main class="mb-auto bg-red-400">

            <div class="container mx-auto py-3">

                <div class="">
                    <div class="col-3 text-center">
                        <img src="<?= $_SESSION["admin"]["personnelPhoto"] ?>"
                            class="img-thumbnail rounded rounded-3 mx-auto member_avatar" alt="">
                    </div>
                    <div class="col-auto pt-3" style="font-size: 1rem;">
                        <h2 style="font-size: 1.75em">
                            <?= $_SESSION["admin"]["titlePosition"] . " " . $_SESSION["admin"]["firstName"] . "  " . $_SESSION["admin"]["lastName"] ?>
                        </h2>
                        <h3 style="font-size: 1.6em">
                            <?= $_SESSION["admin"]["titleNameEn"] . " " . $_SESSION["admin"]["firstName_en"] . "  " . $_SESSION["admin"]["lastName_en"] ?>
                        </h3>
                        <h3 style="font-size: 1.2em">
                            <?= "สิทธิ์การเข้าถึง : ระดับ" . $fnc->system_auth_lv[$_SESSION["admin"]["auth_lv"]] ?>
                        </h3>
                    </div>
                </div>

            </div>


        </main>

        <footer class="mt-6">footer</footer>
    </div>

    


    <?php include_once('../src/includes/sweet_alert.php'); ?>

</body>

</html>