<!doctype html>
<?php
require('../vendor/autoload.php');
require('../core.php');

$fnc = new web();

include_once("../fusioncharts/fusioncharts.php");

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Kanchana Chittong">
    <title>ECON RESEARCH</title>

    <!-- <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/blog/"> -->

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;300&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../home/style.css">

    <!-- FusionCharts Library -->
    <script type="text/javascript" src="../js/fusioncharts.js"></script>
    <script type="text/javascript" src="../js/themes/fusioncharts.theme.fusion.js"></script>
    <!--
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.fusion.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.fint.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.gammel.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.zune.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.candy.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.carbon.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.ocean.js"></script>
        <script type="text/javascript" src="../js/themes/fusioncharts.theme.umber.js"></script>
    -->

</head>

<body>

    <?PHP include("header.php"); ?>

    <?PHP
    include('../home/homepage_configure.php');
    
    ?>



    <main class="container">
        <h1 class="mt-5 mb-3">Dashboard</h1>

    </main><!-- /.container -->

    <footer class="blog-footer">
        <p class="mb-1">งานบริการวิชาการและวิจัย สำนักงานคณบดี <a href="https://econ.mju.ac.th/" class="fw-bold" style="text-decoration: none; color: #727272;">คณะเศรษฐศาสตร์ มหาวิทยาลัยแม่โจ้</a></p>
        <p class="mb-0">63 หมู่ 4 ถนนเชียงใหม่-พร้าว ต.หนองหาร อ.สันทราย จ.เชียงใหม่ 50290</p>
        <p class="m-0">โทรศัพท์. 053-875264 | โทรสาร. 053-875252 | อีเมล์ econ@mju.ac.th</p>
        <!-- <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p> -->
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>

    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>