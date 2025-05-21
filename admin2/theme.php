<!doctype html>
<?php
require_once('../src/includes/app.php');
require_once('../src/includes/components.php');
require_once('../core.php');
// $fnc = new web;
// $sql_display_limit = ' limit 5';

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

<body class="body-wrapper">

    <div id="nav-main" class="mb-3">
        <?= navMain() ?>
    </div>

    <main>

        <?= genMemberInfoCard() ?>


    </main>

    <footer class="mt-6">footer</footer>




    <?php include_once('../src/includes/sweet_alert.php'); ?>

</body>

</html>