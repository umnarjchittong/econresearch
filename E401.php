<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dean's direct message</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Dean's direct message">
    <meta name="author" content="Umnarj Chittong">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="../js/all.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Prompt:wght@300&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link id="theme-style" rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            /* font-family: 'Kanit', sans-serif; */
            font-family: 'Prompt', sans-serif;
            background-color: black;
            color: blanchedalmond;
        }
    </style>

</head>

<body>

    <div class="container text-center">
        <h2 class="text-warning mt-5 mb-0" style="font-size: 3em;">ERROR</h2>
        <h1 class="text-warning mb-2" style="font-size: 15em;">401</h1>
        <h3 class="text-white-50 mb-5" style="font-size: 3em;">UNAUTHORIZED</h3>
        <?php
        if (isset($_GET["err"])) {
            echo '<div class="mb-2">' . $_GET["err"] . '</div>';
        } else {
            echo '<div class="mb-2">Please Sign-in</div>';
        }
        ?>

        <a href="https://faed.mju.ac.th/ddm" target="_top" class="text-primary">[ HOME PAGE ]</a>
        <span class="mx-3">|</span>
        <a href="https://faed.mju.ac.th/ddm/sign/index.php" target="_top" class="text-primary">[ SIGN-IN ]</a>
    </div>


</body>

</html>